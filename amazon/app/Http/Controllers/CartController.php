<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct(private CartService $cartService)
    {
    }

    public function index()
    {
        $cart = $this->cartService->current();
        return view('store.cart.index', compact('cart'));
    }

    public function add(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);
        $request->validate(['quantity' => 'required|integer|min:1']);

        try {
            $this->cartService->addItem($this->cartService->current(), $product, (int) $request->quantity);
        } catch (\RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }

        return redirect()->route('cart.index')->with('success', 'Added to cart.');
    }

    public function update(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);
        $request->validate(['quantity' => 'required|integer|min:0']);

        try {
            $this->cartService->updateQuantity($this->cartService->current(), $product, (int) $request->quantity);
        } catch (\RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }

        return back()->with('success', 'Cart updated.');
    }

    public function clear()
    {
        $cart = $this->cartService->current();
        $this->cartService->clear($cart);
        return redirect()->route('cart.index')->with('success', 'Cart cleared.');
    }
}
