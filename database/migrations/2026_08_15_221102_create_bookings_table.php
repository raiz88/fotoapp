<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('brand_id')->constrained()->restrictOnDelete();
            $table->foreignId('package_id')->nullable()->constrained()->nullOnDelete();
            $table->string('customer_name', 120);
            $table->string('customer_phone', 30);
            $table->date('booking_date');
            $table->string('time_slot', 20); // morning | afternoon | evening
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique(['brand_id', 'booking_date', 'time_slot']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
