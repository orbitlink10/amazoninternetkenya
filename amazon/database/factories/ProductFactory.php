<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->words(3, true);
        return [
            'name' => ucfirst($name),
            'slug' => \Str::slug($name) . '-' . \Str::random(4),
            'sku' => strtoupper(\Str::random(8)),
            'description' => $this->faker->paragraph,
            'price' => 1000,
            'sale_price' => null,
            'currency' => 'KES',
            'category_id' => Category::factory(),
            'brand' => $this->faker->company,
            'stock_quantity' => 10,
            'is_featured' => false,
            'is_active' => true,
        ];
    }
}
