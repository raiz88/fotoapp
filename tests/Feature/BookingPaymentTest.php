<?php

namespace Tests\Feature;

use App\Mail\AdminBookingNotificationMail;
use App\Mail\BookingReceiptMail;
use App\Models\Booking;
use App\Models\Brand;
use App\Models\Invoice;
use App\Models\Package;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Tests\TestCase;

class BookingPaymentTest extends TestCase
{
    use RefreshDatabase;

    private function bookingPayload(Package $package): array
    {
        return [
            'package_id' => $package->id,
            'customer_name' => 'Aiman Malik',
            'customer_email' => 'aiman@example.test',
            'customer_phone' => '0123456789',
            'booking_date' => now()->addDays(3)->toDateString(),
            'time_slot' => 'morning',
        ];
    }

    public function test_store_creates_pending_booking_and_redirects_to_gateway(): void
    {
        Http::fake([
            '*/index.php/api/createBill' => Http::response([['BillCode' => 'abc123']]),
        ]);

        $brand = Brand::factory()->create(['dev_domain' => 'ceritaconvo.localhost']);
        $package = Package::factory()->create(['brand_id' => $brand->id, 'price_cents' => 100000]);

        $response = $this->post("http://{$brand->dev_domain}/booking", $this->bookingPayload($package));

        $response->assertRedirect('https://dev.toyyibpay.com/abc123');

        $booking = Booking::first();
        $this->assertSame(Booking::STATUS_PENDING_PAYMENT, $booking->status);
        $this->assertSame('abc123', $booking->gateway_bill_code);
        $this->assertSame($package->depositAmountCents(), $booking->deposit_amount_cents->cents);
    }

    public function test_store_rejects_an_already_taken_slot(): void
    {
        $brand = Brand::factory()->create(['dev_domain' => 'ceritaconvo.localhost']);
        $package = Package::factory()->create(['brand_id' => $brand->id]);
        $payload = $this->bookingPayload($package);

        Booking::create([
            ...$payload,
            'brand_id' => $brand->id,
            'status' => Booking::STATUS_PENDING_PAYMENT,
            'deposit_amount_cents' => 30000,
            'access_token' => Str::random(32),
        ]);

        $response = $this->post("http://{$brand->dev_domain}/booking", $payload);

        $response->assertSessionHasErrors('time_slot');
        $this->assertSame(1, Booking::count());
    }

    public function test_webhook_marks_booking_paid_generates_invoice_and_sends_emails(): void
    {
        Storage::fake('local');
        Mail::fake();

        $brand = Brand::factory()->create(['dev_domain' => 'ceritaconvo.localhost']);
        $package = Package::factory()->create(['brand_id' => $brand->id, 'price_cents' => 100000]);
        $owner = User::factory()->create(['role' => User::ROLE_OWNER, 'is_active' => true]);

        $booking = Booking::create([
            ...$this->bookingPayload($package),
            'brand_id' => $brand->id,
            'status' => Booking::STATUS_PENDING_PAYMENT,
            'deposit_amount_cents' => $package->depositAmountCents(),
            'access_token' => Str::random(32),
            'gateway_bill_code' => 'abc123',
        ]);

        $response = $this->post("http://{$brand->dev_domain}/booking/webhook", [
            'billcode' => 'abc123',
            'status' => '1',
        ]);

        $response->assertOk();

        $booking->refresh();
        $this->assertTrue($booking->isPaid());
        $this->assertNotNull($booking->invoice);
        $this->assertTrue(Storage::disk('local')->exists($booking->invoice->pdf_path));
        $this->assertSame("{$brand->document_prefix}-INV-000001", $booking->invoice->invoice_number);

        Mail::assertSent(BookingReceiptMail::class, fn ($mail) => $mail->hasTo($booking->customer_email));
        Mail::assertSent(AdminBookingNotificationMail::class, fn ($mail) => $mail->hasTo($owner->email));
    }

    public function test_webhook_is_idempotent_and_does_not_duplicate_the_invoice(): void
    {
        Storage::fake('local');
        Mail::fake();

        $brand = Brand::factory()->create(['dev_domain' => 'ceritaconvo.localhost']);
        $package = Package::factory()->create(['brand_id' => $brand->id]);

        $booking = Booking::create([
            ...$this->bookingPayload($package),
            'brand_id' => $brand->id,
            'status' => Booking::STATUS_PENDING_PAYMENT,
            'deposit_amount_cents' => $package->depositAmountCents(),
            'access_token' => Str::random(32),
            'gateway_bill_code' => 'abc123',
        ]);

        $webhook = fn () => $this->post("http://{$brand->dev_domain}/booking/webhook", [
            'billcode' => 'abc123',
            'status' => '1',
        ]);

        $webhook();
        $webhook();

        $this->assertSame(1, Invoice::count());
        Mail::assertSent(BookingReceiptMail::class, 1);
    }

    public function test_expire_stale_bookings_command_frees_the_slot(): void
    {
        $brand = Brand::factory()->create(['dev_domain' => 'ceritaconvo.localhost', 'payment_hold_hours' => 1]);
        $package = Package::factory()->create(['brand_id' => $brand->id]);
        $payload = $this->bookingPayload($package);

        $stale = Booking::create([
            ...$payload,
            'brand_id' => $brand->id,
            'status' => Booking::STATUS_PENDING_PAYMENT,
            'deposit_amount_cents' => 30000,
            'access_token' => Str::random(32),
        ]);
        $stale->forceFill(['created_at' => now()->subHours(2)])->save();

        $this->artisan('bookings:expire-stale')->assertSuccessful();

        $this->assertSame(Booking::STATUS_EXPIRED, $stale->fresh()->status);

        // Same slot should now be bookable again.
        Http::fake(['*/index.php/api/createBill' => Http::response([['BillCode' => 'xyz789']])]);
        $response = $this->post("http://{$brand->dev_domain}/booking", $payload);
        $response->assertRedirect('https://dev.toyyibpay.com/xyz789');
    }
}
