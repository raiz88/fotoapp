<?php

namespace App\Services;

use App\Models\Booking;
use Illuminate\Support\Facades\Http;
use RuntimeException;

/**
 * Thin wrapper around ToyyibPay's REST API (createBill / getBillTransactions).
 * Points at the sandbox (dev.toyyibpay.com) until a live merchant account
 * replaces TOYYIBPAY_BASE_URL in .env.
 */
class ToyyibPayGateway
{
    private readonly string $secretKey;

    private readonly string $categoryCode;

    private readonly string $baseUrl;

    public function __construct(?string $secretKey = null, ?string $categoryCode = null, ?string $baseUrl = null)
    {
        $this->secretKey = $secretKey ?? (string) config('services.toyyibpay.secret_key');
        $this->categoryCode = $categoryCode ?? (string) config('services.toyyibpay.category_code');
        $this->baseUrl = rtrim($baseUrl ?? (string) config('services.toyyibpay.base_url'), '/');
    }

    /**
     * Creates a hosted payment bill for a booking's deposit and returns the
     * URL to redirect the customer to.
     */
    public function createBill(Booking $booking): string
    {
        // Built from the booking's own brand (not the current request's host)
        // so this stays correct even if generated outside a brand-domain
        // request context — same reasoning as Brand::publicUrl()'s docblock.
        $brandUrl = $booking->brand->publicUrl();

        $response = Http::asForm()->post("{$this->baseUrl}/index.php/api/createBill", [
            'userSecretKey' => $this->secretKey,
            'categoryCode' => $this->categoryCode,
            'billName' => "Deposit - {$booking->package->name}",
            'billDescription' => "Booking deposit for {$booking->booking_date->toFormattedDateString()} ({$booking->slotLabel()})",
            'billPriceSetting' => 1,
            'billPayorInfo' => 1,
            'billAmount' => $booking->deposit_amount_cents->cents,
            'billReturnUrl' => $brandUrl.route('booking.return', $booking->access_token, absolute: false),
            'billCallbackUrl' => $brandUrl.route('booking.webhook', absolute: false),
            'billExternalReferenceNo' => (string) $booking->id,
            'billTo' => $booking->customer_name,
            'billEmail' => $booking->customer_email,
            'billPhone' => $booking->customer_phone,
            'billSplitPayment' => 0,
            'billPaymentChannel' => 2,
            'billContentEmail' => 'Thank you for your booking deposit.',
            'billChargeToCustomer' => 1,
        ])->throw()->json();

        $billCode = $response[0]['BillCode'] ?? null;

        if (! $billCode) {
            throw new RuntimeException('ToyyibPay createBill did not return a BillCode: '.json_encode($response));
        }

        $booking->update(['gateway_bill_code' => $billCode]);

        return "{$this->baseUrl}/{$billCode}";
    }

    /**
     * Authoritative check against ToyyibPay itself — used both on the
     * customer's return redirect and can be reused if the webhook is ever
     * delayed or missed.
     */
    public function verifyBill(string $billCode): bool
    {
        $response = Http::asForm()->post("{$this->baseUrl}/index.php/api/getBillTransactions", [
            'billCode' => $billCode,
        ])->throw()->json();

        return collect($response)->contains(fn ($transaction) => ($transaction['billpaymentStatus'] ?? null) === '1');
    }
}
