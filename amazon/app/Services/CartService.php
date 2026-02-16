<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class CartService
{
    public function current(): Cart
    {
        $sessionId = session()->get('cart_session_id');
        $cart = Cart::with('items.product')->when(Auth::check(), function ($query) {
            $query->where('user_id', Auth::id());
        }, function ($query) use ($sessionId) {
            $query->where('session_id', $sessionId);
        })->first();

        if (!$cart) {
            $cart = Cart::create([
                'user_id' => Auth::id(),
                'session_id' => $sessionId ?? Str::uuid()->toString(),
                'currency' => 'KES',
            ]);
            session()->put('cart_session_id', $cart->session_id);
            $cart->load('items.product');
        }

        return $cart;
    }

    public function mergeAfterLogin(): void
    {
        if (!Auth::check()) {
            return;
        }
        $sessionId = session()->get('cart_session_id');
        if (!$sessionId) {
            return;
        }
        $sessionCart = Cart::where('session_id', $sessionId)->first();
        $userCart = Cart::firstOrCreate(['user_id' => Auth::id()], [
            'session_id' => Str::uuid()->toString(),
            'currency' => 'KES',
        ]);

        if ($sessionCart) {
            foreach ($sessionCart->items as $item) {
                $this->addItem($userCart, $item->product, $item->quantity);
            }
            $sessionCart->delete();
        }
        session()->put('cart_session_id', $userCart->session_id);
    }

    public function addItem(Cart $cart, Product $product, int $quantity): Cart
    {
        $quantity = max(1, $quantity);
        if ($product->stock_quantity < $quantity) {
            throw new \RuntimeException('Insufficient stock for '.$product->name);
        }

        $item = $cart->items()->where('product_id', $product->id)->first();
        $price = $product->sale_price ?? $product->price;

        if ($item) {
            $newQty = $item->quantity + $quantity;
            if ($product->stock_quantity < $newQty) {
                throw new \RuntimeException('Insufficient stock for '.$product->name);
            }
            $item->update([
                'quantity' => $newQty,
                'unit_price' => $price,
                'subtotal' => $price * $newQty,
            ]);
        } else {
            $cart->items()->create([
                'product_id' => $product->id,
                'quantity' => $quantity,
                'unit_price' => $price,
                'subtotal' => $price * $quantity,
            ]);
        }

        return $cart->refresh()->load('items.product');
    }

    public function updateQuantity(Cart $cart, Product $product, int $quantity): Cart
    {
        $quantity = max(0, $quantity);
        $item = $cart->items()->where('product_id', $product->id)->first();
        if (!$item) {
            return $cart;
        }
        if ($quantity === 0) {
            $item->delete();
        } else {
            if ($product->stock_quantity < $quantity) {
                throw new \RuntimeException('Insufficient stock for '.$product->name);
            }
            $price = $product->sale_price ?? $product->price;
            $item->update([
                'quantity' => $quantity,
                'unit_price' => $price,
                'subtotal' => $price * $quantity,
            ]);
        }
        return $cart->refresh()->load('items.product');
    }

    public function clear(Cart $cart): void
    {
        $cart->items()->delete();
    }
}
