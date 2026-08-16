<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->string('customer_email', 160)->after('customer_phone');
            $table->string('status', 20)->default('pending_payment')->after('notes');
            $table->unsignedInteger('deposit_amount_cents')->default(0)->after('status');
            $table->string('access_token', 40)->unique()->after('deposit_amount_cents');
            $table->string('gateway_bill_code', 40)->nullable()->after('access_token');
            $table->timestamp('paid_at')->nullable()->after('gateway_bill_code');
        });

        // Replace the plain unique constraint with a partial one that
        // excludes expired bookings, so an abandoned pending_payment
        // booking that later expires frees the slot for someone else.
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropUnique(['brand_id', 'booking_date', 'time_slot']);
        });

        DB::statement(
            'create unique index bookings_brand_date_slot_active_unique '.
            "on bookings (brand_id, booking_date, time_slot) where status <> 'expired'"
        );
    }

    public function down(): void
    {
        DB::statement('drop index if exists bookings_brand_date_slot_active_unique');

        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn([
                'customer_email', 'status', 'deposit_amount_cents',
                'access_token', 'gateway_bill_code', 'paid_at',
            ]);
            $table->unique(['brand_id', 'booking_date', 'time_slot']);
        });
    }
};
