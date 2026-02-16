<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminAuditLog;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::query();
        if ($status = $request->get('status')) {
            $query->where('status', $status);
        }
        if ($payment = $request->get('payment_status')) {
            $query->where('payment_status', $payment);
        }
        if ($request->filled('from')) {
            $query->whereDate('created_at', '>=', $request->get('from'));
        }
        if ($request->filled('to')) {
            $query->whereDate('created_at', '<=', $request->get('to'));
        }
        $orders = $query->latest()->paginate(20);
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load('items');
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $data = $request->validate([
            'status' => 'required|in:pending,paid,processing,dispatched,delivered,cancelled,refunded',
        ]);

        $order->update(['status' => $data['status']]);
        AdminAuditLog::create(['admin_id' => auth()->id(), 'action' => 'order.status', 'details' => $order->order_number.':'.$data['status']]);

        return back()->with('success', 'Order status updated.');
    }
}
