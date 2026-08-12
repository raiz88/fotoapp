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
            $table->string('client_name');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('package')->nullable();          // e.g. Wedding, Portrait, Event
            $table->date('booking_date');
            $table->time('booking_time')->nullable();
            $table->string('location')->nullable();
            $table->decimal('price', 10, 2)->default(0);
            $table->string('status')->default('pending');   // pending | confirmed | completed | cancelled
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
