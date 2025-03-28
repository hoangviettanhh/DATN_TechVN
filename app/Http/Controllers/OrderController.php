<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['orderDetails.product', 'orderStatus'])
            ->where('id_user', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with(['orderDetails.product', 'orderStatus'])
            ->where('id_user', Auth::id())
            ->where('id_order', $id)
            ->firstOrFail();

        return view('orders.show', compact('order'));
    }
} 