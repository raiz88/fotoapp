<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('brands', function (Blueprint $table) {
            $table->id();
            $table->string('code', 32)->unique();
            $table->string('name', 80);
            $table->string('legal_name', 160)->nullable();
            $table->string('domain', 120)->unique();
            $table->string('dev_domain', 120)->nullable();
            $table->string('tagline', 200)->nullable();
            $table->string('document_prefix', 8)->unique();
            $table->string('booking_mode', 16)->default('slotted'); // slotted | full_day
            $table->string('primary_color', 9)->default('#405189');
            $table->string('secondary_color', 9)->nullable();
            $table->string('logo_path')->nullable();
            $table->string('logo_dark_path')->nullable();
            $table->string('favicon_path')->nullable();
            $table->string('og_image_path')->nullable();
            $table->string('mail_from_name', 80)->nullable();
            $table->string('mail_from_address', 160)->nullable();
            $table->string('reply_to_address', 160)->nullable();
            $table->string('whatsapp_number', 20)->nullable();
            $table->string('instagram_handle', 60)->nullable();
            $table->string('bank_name', 80)->nullable();
            $table->string('bank_account_no', 40)->nullable();
            $table->string('bank_account_holder', 120)->nullable();
            $table->string('duitnow_qr_path')->nullable();
            $table->unsignedSmallInteger('quotation_validity_days')->default(7);
            $table->unsignedSmallInteger('payment_hold_hours')->default(48);
            $table->unsignedSmallInteger('lead_days')->default(3);
            $table->unsignedTinyInteger('deposit_percent')->default(30);
            $table->text('default_terms')->nullable();
            $table->text('address')->nullable();
            $table->string('business_reg_no', 40)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('is_active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('brands');
    }
};
