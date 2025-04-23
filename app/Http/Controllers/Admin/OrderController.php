<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function index()
    {
        try {
            $orders = Order::with(['user', 'orderStatus', 'orderDetails.product.productImages'])
                          ->orderBy('created_at', 'desc')
                          ->get();
            return view('admin.orders.list', compact('orders'));
        } catch (\Exception $e) {
            Log::error('Lỗi hiển thị danh sách đơn hàng: ' . $e->getMessage());
            return back()->with('error', 'Có lỗi xảy ra khi tải danh sách đơn hàng');
        }
    }

    public function show($id_order)
    {
        try {
            $order = Order::with(['user', 'orderStatus', 'orderDetails.product.productImages'])
                         ->findOrFail($id_order);
            return view('admin.orders.show', compact('order'));
        } catch (\Exception $e) {
            Log::error('Lỗi hiển thị chi tiết đơn hàng: ' . $e->getMessage());
            return back()->with('error', 'Có lỗi xảy ra khi tải thông tin đơn hàng');
        }
    }

    public function edit($id_order)
    {
        try {
            $order = Order::with(['user', 'orderStatus', 'orderDetails.product.productImages'])
                         ->findOrFail($id_order);
            return view('admin.orders.edit', compact('order'));
        } catch (\Exception $e) {
            Log::error('Lỗi hiển thị form sửa đơn hàng: ' . $e->getMessage());
            return back()->with('error', 'Có lỗi xảy ra khi tải thông tin đơn hàng');
        }
    }

    public function update(Request $request, $id_order)
    {
        try {
            $request->validate([
                'address' => 'required|string|max:255'
            ], [
                'address.required' => 'Vui lòng nhập địa chỉ giao hàng',
                'address.max' => 'Địa chỉ giao hàng không được vượt quá 255 ký tự'
            ]);

            $order = Order::findOrFail($id_order);
            $order->address = $request->address;
            $order->save();

            return redirect()->route('admin.orders.show', $id_order)
                           ->with('success', 'Cập nhật đơn hàng thành công');
        } catch (\Exception $e) {
            Log::error('Lỗi cập nhật đơn hàng: ' . $e->getMessage());
            return back()->with('error', 'Có lỗi xảy ra khi cập nhật đơn hàng')
                        ->withInput();
        }
    }

    public function confirm($id_order)
    {
        try {
            $order = Order::findOrFail($id_order);
            
            if ($order->orderStatus->name !== 'Success') {
                return back()->with('error', 'Chỉ có thể xác nhận đơn hàng đã thanh toán');
            }

            $order->id_order_status = 2; // Giả sử 3 là trạng thái "Đã xác nhận"
            $order->save();

            return back()->with('success', 'Xác nhận đơn hàng thành công');
        } catch (\Exception $e) {
            Log::error('Lỗi xác nhận đơn hàng: ' . $e->getMessage());
            return back()->with('error', 'Có lỗi xảy ra khi xác nhận đơn hàng');
        }
    }

    public function cancel($id_order)
    {
        try {
            $order = Order::findOrFail($id_order);
            
            if (!in_array($order->orderStatus->name, ['Pending'])) {
                return back()->with('error', 'Không thể hủy đơn hàng ở trạng thái này');
            }

            $order->id_order_status = 6;
            $order->save();

            return back()->with('success', 'Hủy đơn hàng thành công');
        } catch (\Exception $e) {
            Log::error('Lỗi hủy đơn hàng: ' . $e->getMessage());
            return back()->with('error', 'Có lỗi xảy ra khi hủy đơn hàng');
        }
    }
} 