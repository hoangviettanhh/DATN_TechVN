<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderStatus;
use App\Models\Voucher;
use App\Services\VNPayService;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    protected $vnpayService;

    public function __construct(VNPayService $vnpayService)
    {
        $this->vnpayService = $vnpayService;
    }

    public function index()
    {
        $user = Auth::user();
        $cartItems = Cart::with('product')->where('id_user', $user->id_user)->get();
        
        // Tính tổng tiền
        $subtotal = $cartItems->sum(function($item) {
            return $item->product->price * $item->quantity;
        });
        
        // Lấy danh sách voucher có thể sử dụng
        $vouchers = Voucher::where('deleted_at', null)->get();
        
        return view('checkout.index', compact('user', 'cartItems', 'subtotal', 'vouchers'));
    }

    public function placeOrder(Request $request)
    {
        $request->validate([
            'address' => 'required|string',
            'voucher_code' => 'nullable|exists:vouchers,code',
            'payment_method' => 'required|in:cod,vnpay'
        ]);

        $user = Auth::user();
        
        // Lưu user_id vào session
        session(['user_id' => $user->id_user]);
        session()->save();

        Log::info('Place Order Session:', [
            'user_id' => $user->id_user,
            'session_id' => session()->getId()
        ]);

        $cartItems = Cart::with('product')->where('id_user', $user->id_user)->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.view')->with('error', 'Giỏ hàng trống!');
        }

        // Tính tổng tiền
        $subtotal = $cartItems->sum(function($item) {
            return $item->product->price * $item->quantity;
        });

        // Xử lý voucher nếu có
        $discount = 0;
        if ($request->voucher_code) {
            $voucher = Voucher::where('code', $request->voucher_code)->first();
            $discount = $subtotal * ($voucher->discount / 100);
        }

        $totalAmount = $subtotal - $discount;

        // Tạo đơn hàng mới
        $order = Order::create([
            'id_user' => $user->id_user,
            'id_voucher' => $request->voucher_code ? Voucher::where('code', $request->voucher_code)->first()->id_voucher : null,
            'id_order_status' => $request->payment_method === 'cod' ? 
                OrderStatus::where('name', 'Success')->first()->id_order_status :
                OrderStatus::where('name', 'Pending')->first()->id_order_status,
            'total_amount' => $totalAmount,
            'address' => $request->address,
            'payment_method' => $request->payment_method
        ]);

        // Tạo chi tiết đơn hàng
        foreach ($cartItems as $item) {
            OrderDetail::create([
                'id_order' => $order->id_order,
                'id_product' => $item->id_product,
                'quantity' => $item->quantity,
                'price' => $item->product->price
            ]);
        }

        // Xóa giỏ hàng
        Cart::where('id_user', $user->id_user)->delete();

        // Xử lý thanh toán VNPay nếu được chọn
        if ($request->payment_method === 'vnpay') {
            $orderInfo = "Thanh toan don hang #" . $order->id_order;
            $paymentUrl = $this->vnpayService->createPaymentUrl($order->id_order, $totalAmount, $orderInfo);
            
            Log::info('VNPay Payment URL:', [
                'order_id' => $order->id_order,
                'user_id' => $user->id_user,
                'url' => $paymentUrl
            ]);

            return redirect($paymentUrl);
        }

        return redirect()->route('order.success', $order->id_order)
            ->with('success', 'Đặt hàng thành công!');
    }

    public function vnpayReturn(Request $request)
    {
        try {
            Log::info('VNPay Return Data:', $request->all());

            $vnp_ResponseCode = $request->input('vnp_ResponseCode');
            $vnp_TxnRef = $request->input('vnp_TxnRef');
            $vnp_Amount = $request->input('vnp_Amount');
            $vnp_OrderInfo = $request->input('vnp_OrderInfo');
            $vnp_BankCode = $request->input('vnp_BankCode');
            $vnp_PayDate = $request->input('vnp_PayDate');
            $vnp_TransactionNo = $request->input('vnp_TransactionNo');
            $user_id = $request->query('user_id'); // Lấy user_id từ query string

            // Đăng nhập lại user nếu có user_id
            if (!Auth::check() && $user_id) {
                Auth::loginUsingId($user_id, true);
                Log::info('Re-authenticated user:', ['user_id' => $user_id]);
            }

            // Kiểm tra mã giao dịch
            if ($vnp_ResponseCode == "00") {
                // Thanh toán thành công
                $order = Order::with(['orderDetails.product', 'orderStatus'])
                    ->where('id_order', $vnp_TxnRef)
                    ->where('id_user', $user_id) // Thêm điều kiện kiểm tra user_id
                    ->first();

                if ($order) {
                    $order->id_order_status = OrderStatus::where('name', 'Success')->first()->id_order_status;
                    $order->payment_method = 'vnpay';
                    $order->payment_details = json_encode([
                        'bank_code' => $vnp_BankCode,
                        'pay_date' => $vnp_PayDate,
                        'response_code' => $vnp_ResponseCode,
                        'transaction_no' => $vnp_TransactionNo,
                        'amount' => $vnp_Amount,
                        'order_info' => $vnp_OrderInfo
                    ]);
                    $order->save();

                    Log::info('Payment Success:', [
                        'order_id' => $order->id_order,
                        'user_id' => $user_id,
                        'amount' => $vnp_Amount,
                        'transaction_no' => $vnp_TransactionNo
                    ]);

                    // Lưu session trước khi redirect
                    session()->save();

                    return redirect()->route('order.success', ['id' => $order->id_order])
                        ->with('success', 'Thanh toán thành công!');
                }

                Log::error('Order not found:', [
                    'order_id' => $vnp_TxnRef,
                    'user_id' => $user_id
                ]);
                return redirect()->route('home')
                    ->with('error', 'Không tìm thấy đơn hàng.');
            }

            // Thanh toán thất bại
            Log::warning('Payment Failed:', [
                'response_code' => $vnp_ResponseCode,
                'order_id' => $vnp_TxnRef,
                'user_id' => $user_id,
                'amount' => $vnp_Amount
            ]);

            $errorMessage = match($vnp_ResponseCode) {
                "01" => "Giao dịch chưa hoàn tất",
                "02" => "Giao dịch bị lỗi",
                "04" => "Giao dịch đã hoàn tất",
                "05" => "Tài khoản không đủ số dư",
                "06" => "Giao dịch bị hủy",
                "07" => "Thẻ/Tài khoản bị khóa",
                "09" => "Thẻ/Tài khoản chưa đăng ký dịch vụ",
                "10" => "Đã hết hạn chờ thanh toán",
                "11" => "Giao dịch không thành công",
                "12" => "Giao dịch không hợp lệ",
                "13" => "OTP không đúng",
                "24" => "Giao dịch không được phép",
                "51" => "Tài khoản không đủ số dư",
                "65" => "Tài khoản vượt quá hạn mức",
                "75" => "Ngân hàng đang bảo trì",
                "79" => "Thẻ/Tài khoản chưa đăng ký dịch vụ",
                "99" => "Lỗi khác",
                default => "Giao dịch thất bại"
            };

            return redirect()->route('home')
                ->with('error', 'Thanh toán thất bại: ' . $errorMessage);

        } catch (\Exception $e) {
            Log::error('VNPay Exception:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'user_id' => $user_id ?? null
            ]);

            return redirect()->route('home')
                ->with('error', 'Có lỗi xảy ra trong quá trình xử lý thanh toán');
        }
    }

    public function orderSuccess($id)
    {
        try {
            Log::info('Order Success Request:', [
                'order_id' => $id,
                'session_id' => session()->getId(),
                'user_id' => session('user_id'),
                'auth_check' => Auth::check(),
                'session_data' => session()->all()
            ]);

            // Tìm order trước
            $order = Order::with(['orderDetails.product', 'orderStatus'])
                ->where('id_order', $id)
                ->first();

            if (!$order) {
                Log::error('Order not found:', [
                    'order_id' => $id
                ]);
                return redirect()->route('home')
                    ->with('error', 'Không tìm thấy đơn hàng.');
            }

            // Nếu chưa đăng nhập và có user_id trong session
            if (!Auth::check() && session()->has('user_id')) {
                $userId = session('user_id');
                // Kiểm tra xem order có thuộc về user này không
                if ($order->id_user == $userId) {
                    Auth::loginUsingId($userId, true);
                    Log::info('Auto logged in user:', ['user_id' => $userId]);
                }
            }

            // Nếu đã đăng nhập, kiểm tra quyền truy cập
            if (Auth::check() && $order->id_user != Auth::id()) {
                Log::warning('Unauthorized access to order:', [
                    'order_id' => $id,
                    'user_id' => Auth::id(),
                    'order_user_id' => $order->id_user
                ]);
                return redirect()->route('home')
                    ->with('error', 'Bạn không có quyền xem đơn hàng này.');
            }

            // Cho phép xem trang success ngay cả khi chưa đăng nhập
            return view('checkout.success', compact('order'));

        } catch (\Exception $e) {
            Log::error('Exception in orderSuccess:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'session' => session()->all()
            ]);

            return redirect()->route('home')
                ->with('error', 'Có lỗi xảy ra. Vui lòng thử lại.');
        }
    }
} 