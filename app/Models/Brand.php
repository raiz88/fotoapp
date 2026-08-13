<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = [
        'code', 'name', 'legal_name', 'domain', 'dev_domain', 'tagline',
        'document_prefix', 'booking_mode', 'primary_color', 'secondary_color',
        'logo_path', 'logo_dark_path', 'favicon_path', 'og_image_path',
        'mail_from_name', 'mail_from_address', 'reply_to_address',
        'whatsapp_number', 'instagram_handle',
        'bank_name', 'bank_account_no', 'bank_account_holder', 'duitnow_qr_path',
        'quotation_validity_days', 'payment_hold_hours', 'lead_days', 'deposit_percent',
        'default_terms', 'address', 'business_reg_no', 'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function packages(): HasMany
    {
        return $this->hasMany(Package::class);
    }

    public function addons(): HasMany
    {
        return $this->hasMany(Addon::class);
    }

    /**
     * The host to use when generating public-facing URLs for this brand
     * (mail links, PDFs). Falls back to dev_domain outside production so
     * queued jobs never leak a link pointing at the wrong brand.
     */
    public function publicUrl(): string
    {
        $host = app()->environment('production') ? $this->domain : ($this->dev_domain ?? $this->domain);
        $scheme = app()->environment('production') ? 'https' : 'http';
        $port = app()->environment('local') ? ':'.request()->getPort() : '';

        return "{$scheme}://{$host}{$port}";
    }

    public function whatsappUrl(string $message): string
    {
        $number = preg_replace('/\D/', '', (string) $this->whatsapp_number);

        return 'https://wa.me/'.$number.'?text='.rawurlencode($message);
    }
}
