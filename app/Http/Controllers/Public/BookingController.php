<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Mail\AdminBookingNotificationMail;
use App\Mail\BookingReceiptMail;
use App\Models\Booking;
use App\Models\Brand;
use App\Models\Package;
use App\Models\User;
use App\Services\InvoiceService;
use App\Services\ToyyibPayGateway;
use Illuminate\Contracts\View\View;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\StreamedResponse;

class BookingController extends Controller
{
    public function checkAvailability(Request $request): JsonResponse
    {
        /** @var Brand $brand */
        $brand = app(Brand::class);

        $validated = $request->validate([
            'booking_date' => ['required', 'date', 'after_or_equal:today'],
            'time_slot' => ['required', Rule::in(array_keys(Booking::SLOTS))],
        ]);

        return response()->json([
            'available' => ! $this->slotTaken($brand, $validated['booking_date'], $validated['time_slot']),
        ]);
    }

    public function store(Request $request, ToyyibPayGateway $gateway): RedirectResponse
    {
        /** @var Brand $brand */
        $brand = app(Brand::class);

        $validated = $request->validate([
            'customer_name' => ['required', 'string', 'max:120'],
            'customer_email' => ['required', 'email', 'max:160'],
            'customer_phone' => ['required', 'string', 'max:30'],
            'booking_date' => ['required', 'date', 'after_or_equal:today'],
            'time_slot' => ['required', Rule::in(array_keys(Booking::SLOTS))],
            'package_id' => ['required', 'exists:packages,id'],
            'notes' => ['nullable', 'string', 'max:500'],
        ]);

        if ($this->slotTaken($brand, $validated['booking_date'], $validated['time_slot'])) {
            return back()->withInput()->withErrors([
                'time_slot' => 'That date and time slot is already booked. Please choose another date or slot.',
            ]);
        }

        $package = Package::findOrFail($validated['package_id']);

        try {
            $paymentUrl = DB::transaction(function () use ($validated, $brand, $package, $gateway) {
                $booking = Booking::create([
                    ...$validated,
                    'brand_id' => $brand->id,
                    'status' => Booking::STATUS_PENDING_PAYMENT,
                    'deposit_amount_cents' => $package->depositAmountCents(),
                    'access_token' => Str::random(32),
                ]);

                return $gateway->createBill($booking);
            });
        } catch (QueryException) {
            // Unique constraint race: someone booked the same slot a moment ago.
            return back()->withInput()->withErrors([
                'time_slot' => 'That date and time slot was just booked by someone else. Please choose another.',
            ]);
        } catch (\Throwable $e) {
            report($e);

            return back()->withInput()->withErrors([
                'package_id' => 'We could not start the payment process. Please try again shortly.',
            ]);
        }

        return redirect()->away($paymentUrl);
    }

    public function returnFromGateway(string $token, ToyyibPayGateway $gateway, InvoiceService $invoices): RedirectResponse
    {
        $booking = Booking::where('access_token', $token)->firstOrFail();

        if ($booking->status === Booking::STATUS_PENDING_PAYMENT && $booking->gateway_bill_code
            && $gateway->verifyBill($booking->gateway_bill_code)) {
            $this->markPaid($booking, $invoices);
        }

        return redirect()->route('booking.show', $token);
    }

    public function webhook(Request $request, InvoiceService $invoices): JsonResponse
    {
        $billCode = $request->input('billcode');
        $status = $request->input('status');

        $booking = Booking::where('gateway_bill_code', $billCode)->first();

        if ($booking && $status === '1' && $booking->status === Booking::STATUS_PENDING_PAYMENT) {
            $this->markPaid($booking, $invoices);
        }

        return response()->json(['ok' => true]);
    }

    public function show(string $token): View
    {
        $booking = Booking::where('access_token', $token)
            ->with(['brand', 'package', 'invoice'])
            ->firstOrFail();

        return view('public.booking-status', ['booking' => $booking]);
    }

    public function downloadInvoice(string $token): StreamedResponse
    {
        $booking = Booking::where('access_token', $token)->with('invoice')->firstOrFail();

        abort_unless($booking->isPaid() && $booking->invoice, 404);

        return Storage::disk('local')->download($booking->invoice->pdf_path, "{$booking->invoice->invoice_number}.pdf");
    }

    private function slotTaken(Brand $brand, string $date, string $slot): bool
    {
        return Booking::where('brand_id', $brand->id)
            ->where('booking_date', $date)
            ->where('time_slot', $slot)
            ->where('status', '!=', Booking::STATUS_EXPIRED)
            ->exists();
    }

    private function markPaid(Booking $booking, InvoiceService $invoices): void
    {
        $booking->update(['status' => Booking::STATUS_PAID, 'paid_at' => now()]);
        $invoices->generate($booking->fresh());
        $booking->refresh();

        Mail::to($booking->customer_email)->send(new BookingReceiptMail($booking));

        $adminEmails = User::whereIn('role', [User::ROLE_OWNER, User::ROLE_ADMIN])
            ->where('is_active', true)
            ->pluck('email');

        if ($adminEmails->isNotEmpty()) {
            Mail::to($adminEmails)->send(new AdminBookingNotificationMail($booking));
        }
    }
}
