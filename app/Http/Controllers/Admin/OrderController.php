<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderEvent;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');

        $q = Order::with('items')->latest();

        if ($status && $status !== 'all') {
            $q->where('status', $status);
        }

        // Limite de 100 por tela (ajuste se quiser paginação)
        $orders = $q->limit(100)->get();

        return response()->json(['orders' => $orders]);
    }

    public function updateStatus(Request $request, Order $order)
    {
        $data = $request->validate([
            'status' => ['required', Rule::in(['pending', 'confirmed', 'preparing', 'ready', 'completed', 'cancelled'])],
        ]);

        $old = $order->status;
        $order->status = $data['status'];
        $order->save();

        OrderEvent::create([
            'order_id'   => $order->id,
            'old_status' => $old,
            'new_status' => $order->status,
            'note'       => 'Status updated from dashboard',
        ]);

        return response()->json(['ok' => true, 'order' => $order]);
    }
}
