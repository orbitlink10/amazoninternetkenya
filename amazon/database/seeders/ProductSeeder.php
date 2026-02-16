<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $internet = Category::firstOrCreate(['slug' => 'internet'], ['name' => 'Internet']);
        $hardware = Category::firstOrCreate(['slug' => 'hardware'], ['name' => 'Hardware']);

        $products = [
            [
                'name' => 'Home Broadband 20 Mbps',
                'sku' => 'BB-20',
                'price' => 2999,
                'sale_price' => 2499,
                'category_id' => $internet->id,
                'stock_quantity' => 50,
                'is_featured' => true,
                'description' => 'Reliable 20 Mbps connection for households.',
                'images' => ['https://upload.wikimedia.org/wikipedia/commons/6/67/Feedbin-Icon-wifi.svg'],
            ],
            [
                'name' => '4G Router Kit',
                'sku' => 'ROUT-4G',
                'price' => 7500,
                'category_id' => $hardware->id,
                'stock_quantity' => 25,
                'is_featured' => true,
                'description' => 'Plug-and-play 4G router kit with SIM slot.',
                'images' => ['https://upload.wikimedia.org/wikipedia/commons/8/8b/Modem.svg'],
            ],
        ];

        foreach ($products as $data) {
            $product = Product::updateOrCreate(
                ['sku' => $data['sku']],
                [
                    'name' => $data['name'],
                    'slug' => Str::slug($data['name']),
                    'price' => $data['price'],
                    'sale_price' => $data['sale_price'] ?? null,
                    'currency' => 'KES',
                    'category_id' => $data['category_id'],
                    'stock_quantity' => $data['stock_quantity'],
                    'is_featured' => $data['is_featured'] ?? false,
                    'is_active' => true,
                    'description' => $data['description'] ?? null,
                ]
            );

            $product->images()->delete();
            foreach ($data['images'] as $idx => $url) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'url' => $url,
                    'sort_order' => $idx,
                ]);
            }
        }
    }
}
