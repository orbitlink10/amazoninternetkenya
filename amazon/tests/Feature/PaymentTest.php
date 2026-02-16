<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PaymentTest extends TestCase
{
    use RefreshDatabase;

    public function test_payment_callback_marks_order_paid_once(): void
    {
        $product = Product::factory()->create(['stock_quantity' => 2, 'price' => 1000]);
        $this->post(route('cart.add', $product), ['quantity' => 1]);

        $orderResponse = $this->post(route('checkout.place'), [
            'name' => 'Jane',
            'phone' => '0700000000',
            'email' => 'jane@example.com',
            'county' => 'Nairobi',
            'town' => 'CBD',
            'street' => 'Kenyatta Ave',
            'payment_method' => 'cod',
        ]);
        $order = Order::first();

        $this->postJson(route('payments.callback'), [
            'order_number' => $order->order_number,
            'status' => 'success',
            'amount' => $order->total,
        ])->assertOk();

        $this->postJson(route('payments.callback'), [
            'order_number' => $order->order_number,
            'status' => 'success',
            'amount' => $order->total,
        ])->assertOk();

        $this->assertEquals('paid', $order->fresh()->payment_status);
        $this->assertEquals(1, \App\Models\Payment::count());
    }
}
