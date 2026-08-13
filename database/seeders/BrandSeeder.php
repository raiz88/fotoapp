<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        Brand::updateOrCreate(
            ['code' => 'ceritaconvo'],
            [
                'name' => 'CeritaConvo',
                'legal_name' => 'CeritaConvo Photography',
                'domain' => 'ceritaconvo.com',
                'dev_domain' => 'ceritaconvo.localhost',
                'tagline' => 'Abadikan detik konvokesyen anda',
                'document_prefix' => 'CC',
                'booking_mode' => 'slotted',
                'primary_color' => '#a855f7',
                'secondary_color' => '#22d3ee',
                'mail_from_name' => 'CeritaConvo',
                'mail_from_address' => 'hello@ceritaconvo.com',
                'whatsapp_number' => '+60123456789',
                'instagram_handle' => 'ceritaconvo',
                'bank_name' => 'Maybank',
                'bank_account_no' => '1234 5678 9012',
                'bank_account_holder' => 'CeritaConvo Photography',
                'quotation_validity_days' => 7,
                'payment_hold_hours' => 48,
                'lead_days' => 3,
                'deposit_percent' => 30,
                'address' => 'Shah Alam, Selangor',
                'is_active' => true,
            ]
        );

        Brand::updateOrCreate(
            ['code' => 'corememory'],
            [
                'name' => 'CoreMemory',
                'legal_name' => 'CoreMemory Weddings',
                'domain' => 'corememory.com',
                'dev_domain' => 'corememory.localhost',
                'tagline' => 'Kenangan abadi hari bahagia anda',
                'document_prefix' => 'CM',
                'booking_mode' => 'full_day',
                'primary_color' => '#d4af37',
                'secondary_color' => '#b76e79',
                'mail_from_name' => 'CoreMemory',
                'mail_from_address' => 'hello@corememory.com',
                'whatsapp_number' => '+60123456780',
                'instagram_handle' => 'corememory.weddings',
                'bank_name' => 'CIMB Bank',
                'bank_account_no' => '8765 4321 0987',
                'bank_account_holder' => 'CoreMemory Weddings',
                'quotation_validity_days' => 7,
                'payment_hold_hours' => 48,
                'lead_days' => 3,
                'deposit_percent' => 30,
                'address' => 'Shah Alam, Selangor',
                'is_active' => true,
            ]
        );
    }
}
