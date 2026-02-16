<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function __construct(private CartService $cartService)
    {
    }

    public function show()
    {
        $cart = $this->cartService->current();
        if ($cart->items->isEmpty()) {
            return redirect()->route('products.index')->with('error', 'Your cart is empty.');
        }
        [$shippingFee, $total] = $this->shippingTotals($cart->total());
        return view('store.checkout.show', compact('cart', 'shippingFee', 'total'));
    }

    public function place(Request $request)
    {
        $cart = $this->cartService->current();
        if ($cart->items->isEmpty()) {
            return redirect()->route('products.index')->with('error', 'Your cart is empty.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:120',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:120',
            'county' => 'required|string|max:120',
            'town' => 'required|string|max:120',
            'street' => 'required|string|max:180',
            'notes' => 'nullable|string|max:500',
            'payment_method' => 'required|in:cod',
        ]);

        [$shippingFee, $total] = $this->shippingTotals($cart->total());

        $order = DB::transaction(function () use ($cart, $validated, $shippingFee, $total) {
            foreach ($cart->items as $item) {
                $product = Product::lockForUpdate()->find($item->product_id);
                if (!$product || $product->stock_quantity < $item->quantity) {
                    throw new \RuntimeException('Insufficient stock for '.$item->product?->name);
                }
            }

            $order = Order::create([
                'order_number' => Str::upper(Str::random(10)),
                'user_id' => auth()->id(),
                'status' => 'pending',
                'payment_status' => 'unpaid',
                'payment_method' => $validated['payment_method'],
                'subtotal' => $cart->total(),
                'shipping_fee' => $shippingFee,
                'total' => $total,
                'currency' => 'KES',
                'customer_name' => $validated['name'],
                'customer_phone' => $validated['phone'],
                'customer_email' => $validated['email'],
                'county' => $validated['county'],
                'town' => $validated['town'],
                'street' => $validated['street'],
                'notes' => $validated['notes'] ?? null,
            ]);

            foreach ($cart->items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'name' => $item->product->name,
                    'sku' => $item->product->sku,
                    'quantity' => $item->quantity,
                    'unit_price' => $item->unit_price,
                    'line_total' => $item->subtotal,
                ]);
            }

            if ($validated['payment_method'] === 'cod') {
                foreach ($cart->items as $item) {
                    $product = Product::lockForUpdate()->find($item->product_id);
                    $product->decrement('stock_quantity', $item->quantity);
                }
                $order->update([
                    'status' => 'processing',
                    'payment_status' => 'paid',
                ]);
                $order->payments()->create([
                    'provider' => 'cod',
                    'amount' => $order->total,
                    'status' => 'success',
                ]);
            }

            return $order;
        });

        $this->cartService->clear($cart);

        // TODO: send email confirmation
        logger()->info('Order placed', ['order' => $order->order_number]);

        return redirect()->route('checkout.thankyou', $order);
    }

    public function thankyou(Order $order)
    {
        return view('store.checkout.thankyou', compact('order'));
    }

    private function shippingTotals(float $subtotal): array
    {
        $shipping = (float) config('shop.shipping_fee', 0);
        $threshold = (float) config('shop.free_shipping_threshold', 0);
        if ($threshold > 0 && $subtotal >= $threshold) {
            $shipping = 0;
        }
        return [$shipping, $subtotal + $shipping];
    }
}
