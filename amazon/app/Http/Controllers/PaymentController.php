<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function callback(Request $request)
    {
        $data = $request->validate([
            'order_number' => 'required',
            'status' => 'required|in:success,failed',
            'amount' => 'required|numeric',
        ]);

        $order = Order::where('order_number', $data['order_number'])->firstOrFail();

        $payment = Payment::firstOrCreate(
            ['order_id' => $order->id, 'provider' => 'cod'],
            ['amount' => $data['amount'], 'status' => 'pending']
        );

        if ($payment->status === 'success') {
            return response()->json(['message' => 'Already processed']);
        }

        if ((float) $data['amount'] !== (float) $order->total) {
            return response()->json(['message' => 'Amount mismatch'], 422);
        }

        $payment->update([
            'status' => $data['status'],
            'raw_payload' => $request->all(),
        ]);

        if ($data['status'] === 'success') {
            $order->update(['payment_status' => 'paid', 'status' => 'processing']);
        }

        return response()->json(['message' => 'ok']);
    }
}
