<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Services\CartService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartTest extends TestCase
{
    use RefreshDatabase;

    public function test_add_update_remove_cart_items(): void
    {
        $product = Product::factory()->create(['stock_quantity' => 5, 'price' => 1000]);

        // add
        $this->post(route('cart.add', $product), ['quantity' => 2])->assertRedirect(route('cart.index'));
        $this->assertDatabaseHas('cart_items', ['product_id' => $product->id, 'quantity' => 2]);

        // update
        $this->post(route('cart.update', $product), ['quantity' => 3])->assertSessionHasNoErrors();
        $this->assertDatabaseHas('cart_items', ['product_id' => $product->id, 'quantity' => 3]);

        // remove
        $this->post(route('cart.update', $product), ['quantity' => 0])->assertSessionHasNoErrors();
        $this->assertDatabaseMissing('cart_items', ['product_id' => $product->id]);
    }
}
