<?php

namespace Database\Factories;

use App\Models\Addon;
use App\Models\Brand;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Addon>
 */
class AddonFactory extends Factory
{
    public function definition(): array
    {
        $name = $this->faker->words(2, true);

        return [
            'brand_id' => Brand::factory(),
            'code' => Str::slug($name),
            'name' => ucfirst($name),
            'price_cents' => $this->faker->numberBetween(5000, 50000),
            'is_active' => true,
        ];
    }
}
