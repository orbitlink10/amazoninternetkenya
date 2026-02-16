<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CheckoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_checkout_creates_order_and_items(): void
    {
        $product = Product::factory()->create(['stock_quantity' => 5, 'price' => 500]);

        $this->post(route('cart.add', $product), ['quantity' => 2]);

        $payload = [
            'name' => 'John Doe',
            'phone' => '0712345678',
            'email' => 'john@example.com',
            'county' => 'Nairobi',
            'town' => 'Kilimani',
            'street' => 'Argwings',
            'notes' => 'Leave at gate',
            'payment_method' => 'cod',
        ];

        $response = $this->post(route('checkout.place'), $payload);

        $this->assertDatabaseCount('orders', 1);
        $order = \App\Models\Order::first();
        $this->assertEquals('KES', $order->currency);
        $this->assertDatabaseHas('order_items', [
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => 2,
        ]);

        $this->assertEquals('paid', $order->payment_status);
        $this->assertEquals('processing', $order->status);

        $response->assertRedirect(route('checkout.thankyou', $order));
    }
}
