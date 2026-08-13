<?php

namespace Database\Factories;

use App\Models\Brand;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Brand>
 */
class BrandFactory extends Factory
{
    public function definition(): array
    {
        $code = $this->faker->unique()->word();

        return [
            'code' => $code,
            'name' => ucfirst($code),
            'domain' => "{$code}.test",
            'dev_domain' => "{$code}.localhost",
            'document_prefix' => strtoupper($this->faker->unique()->lexify('??')),
            'booking_mode' => 'slotted',
            'primary_color' => $this->faker->hexColor(),
            'mail_from_name' => ucfirst($code),
            'mail_from_address' => "hello@{$code}.test",
            'whatsapp_number' => '+60123456789',
            'is_active' => true,
        ];
    }
}
