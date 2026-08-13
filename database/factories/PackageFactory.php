<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Package;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Package>
 */
class PackageFactory extends Factory
{
    public function definition(): array
    {
        $name = 'Pakej '.$this->faker->words(2, true);

        return [
            'brand_id' => Brand::factory(),
            'slug' => Str::slug($name).'-'.$this->faker->unique()->numberBetween(1, 9999),
            'name' => $name,
            'price_cents' => $this->faker->numberBetween(30000, 500000),
            'is_active' => true,
            'published_at' => now(),
            'sort_order' => $this->faker->numberBetween(0, 10),
        ];
    }
}
