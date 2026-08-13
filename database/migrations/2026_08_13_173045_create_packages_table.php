<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('brand_id')->constrained()->restrictOnDelete();
            $table->string('slug', 120);
            $table->string('name', 120);
            $table->string('tier', 20)->nullable(); // basic | silver | gold | custom
            $table->string('tagline', 200)->nullable();
            $table->text('description')->nullable();
            $table->unsignedBigInteger('price_cents');
            $table->unsignedBigInteger('was_price_cents')->nullable();
            $table->string('price_note', 120)->nullable();
            $table->unsignedTinyInteger('deposit_percent')->nullable();
            $table->unsignedBigInteger('deposit_fixed_cents')->nullable();
            $table->unsignedSmallInteger('duration_minutes')->nullable();
            $table->unsignedTinyInteger('session_slots_required')->default(1);
            $table->unsignedSmallInteger('max_pax')->nullable();
            $table->unsignedSmallInteger('edited_photos_count')->nullable();
            $table->boolean('raw_photos_included')->default(false);
            $table->unsignedSmallInteger('delivery_days')->nullable();
            $table->unsignedSmallInteger('travel_included_km')->nullable();
            $table->string('cover_image_path')->nullable();
            $table->json('gallery')->nullable();
            $table->text('terms_override')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['brand_id', 'slug']);
            $table->index(['brand_id', 'is_active', 'published_at']);
            $table->index(['brand_id', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};
