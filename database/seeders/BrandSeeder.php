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
                'tagline' => 'Capture your convocation moments',
                'document_prefix' => 'CC',
                'booking_mode' => 'slotted',
                'primary_color' => '#FBBC04',
                'secondary_color' => '#f59e0b',
                'mail_from_name' => 'CeritaConvo',
                'mail_from_address' => 'hello@ceritaconvo.com',
                'whatsapp_number' => '+60123456789',
                'instagram_handle' => 'ceritaconvo',
                'tiktok_handle' => 'ceritaconvo',
                'bank_name' => 'Maybank',
                'bank_account_no' => '1234 5678 9012',
                'bank_account_holder' => 'CeritaConvo Photography',
                'quotation_validity_days' => 7,
                'payment_hold_hours' => 48,
                'lead_days' => 3,
                'deposit_percent' => 30,
                'default_terms' => implode("\n", [
                    'Grouping and Personal packages do not include transportation charges.',
                    'Date/time changes can be made up to 1 week before the photoshoot day, subject to the photographer\'s availability.',
                    'All edits follow the editor\'s style.',
                    'Edited photos are ready within 7-21 days after the photoshoot.',
                    'All edited photos are delivered via Google Photos.',
                    'A RM50 deposit (non-refundable) will be deducted from the full payment.',
                    'The balance payment must be settled 1 day before the photoshoot session.',
                    'RAW files are not provided to clients.',
                    'Not responsible for rain or emergencies on the day — the available options are to change the date or location.',
                ]),
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

        // CeritaConvo is no longer a public website; keep any legacy record
        // inactive so existing databases cannot expose it.
        Brand::where('code', 'ceritaconvo')->update(['is_active' => false]);
    }
}
