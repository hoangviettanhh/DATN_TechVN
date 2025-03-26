<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function add(Request $request)
    {
        try {
            $productId = $request->input('product_id');
            $quantity = $request->input('quantity', 1);

            // Lấy thông tin sản phẩm
            $product = Product::find($productId);

            if (!$product) {
                return response()->json([
                    'success' => false,
                    'message' => 'Sản phẩm không tồn tại'
                ], 404);
            }

            // Nếu user đã đăng nhập
            if (Auth::check()) {
                $userId = Auth::id();
                
                // Kiểm tra sản phẩm đã có trong giỏ hàng chưa
                $existingCart = Cart::where('id_user', $userId)
                    ->where('id_product', $productId)
                    ->first();

                if ($existingCart) {
                    // Cập nhật số lượng
                    $existingCart->quantity += $quantity;
                    $existingCart->save();
                } else {
                    // Thêm mới vào giỏ hàng
                    Cart::create([
                        'id_user' => $userId,
                        'id_product' => $productId,
                        'quantity' => $quantity
                    ]);
                }

                // Lấy tổng số lượng trong giỏ hàng
                $cartCount = Cart::where('id_user', $userId)->sum('quantity');

                return response()->json([
                    'success' => true,
                    'message' => 'Đã thêm sản phẩm vào giỏ hàng',
                    'cart_count' => $cartCount
                ]);
            }
            
            // Nếu chưa đăng nhập, lưu vào session
            $cart = Session::get('cart', []);
            
            if (isset($cart[$productId])) {
                $cart[$productId]['quantity'] += $quantity;
            } else {
                $cart[$productId] = [
                    'product_id' => $productId,
                    'quantity' => $quantity
                ];
            }
            
            Session::put('cart', $cart);

            return response()->json([
                'success' => true,
                'message' => 'Đã thêm sản phẩm vào giỏ hàng',
                'cart_count' => array_sum(array_column($cart, 'quantity'))
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }

    public function view()
    {
        try {
            $cartItems = [];
            $total = 0;

            // Nếu user đã đăng nhập
            if (Auth::check()) {
                $userId = Auth::id();
                
                // Lấy thông tin giỏ hàng với eager loading product
                $dbCart = Cart::with('product')
                    ->where('id_user', $userId)
                    ->get();

                foreach ($dbCart as $item) {
                    if ($item->product) {
                        $cartItems[] = [
                            'id_product' => $item->id_product,
                            'name' => $item->product->name,
                            'price' => $item->product->price,
                            'image' => $item->product->image,
                            'quantity' => $item->quantity,
                            'description' => $item->product->description
                        ];
                        $total += $item->product->price * $item->quantity;
                    }
                }
            } else {
                // Nếu chưa đăng nhập, lấy từ session
                $sessionCart = Session::get('cart', []);
                
                foreach ($sessionCart as $productId => $item) {
                    $product = Product::find($productId);
                    if ($product) {
                        $cartItems[] = [
                            'id_product' => $productId,
                            'name' => $product->name,
                            'price' => $product->price,
                            'image' => $product->image,
                            'quantity' => $item['quantity'],
                            'description' => $product->description
                        ];
                        $total += $product->price * $item['quantity'];
                    }
                }
            }
            return view('cart.index', [
                'cartItems' => $cartItems,
                'total' => $total,
                'cartCount' => array_sum(array_column($cartItems, 'quantity'))
            ]);

        } catch (\Exception $e) {
            return back()->with('error', 'Có lỗi xảy ra khi hiển thị giỏ hàng');
        }
    }

    public function update($productId, Request $request)
    {
        try {
            $quantity = $request->input('quantity', 1);

            if (Auth::check()) {
                $userId = Auth::id();
                
                // Cập nhật số lượng trong database
                $cartItem = Cart::where('id_user', $userId)
                    ->where('id_product', $productId)
                    ->first();

                if ($cartItem) {
                    $cartItem->quantity = $quantity;
                    $cartItem->save();

                    // Lấy tổng số lượng mới
                    $cartCount = Cart::where('id_user', $userId)->sum('quantity');

                    return response()->json([
                        'success' => true,
                        'message' => 'Đã cập nhật số lượng sản phẩm',
                        'cartCount' => $cartCount
                    ]);
                }
            }

            // Nếu chưa đăng nhập, cập nhật trong session
            $cart = Session::get('cart', []);
            if (isset($cart[$productId])) {
                $cart[$productId]['quantity'] = $quantity;
                Session::put('cart', $cart);
            }

            return response()->json([
                'success' => true,
                'message' => 'Đã cập nhật số lượng sản phẩm',
                'cartCount' => array_sum(array_column($cart, 'quantity'))
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }

    public function remove($productId)
    {
        try {
            if (Auth::check()) {
                $userId = Auth::id();
                
                // Lấy thông tin item trong giỏ hàng
                $cartItem = Cart::where('id_user', $userId)
                    ->where('id_product', $productId)
                    ->first();

                if ($cartItem) {
                    if ($cartItem->quantity > 1) {
                        // Nếu số lượng > 1, giảm số lượng đi 1
                        $cartItem->quantity -= 1;
                        $cartItem->save();
                    } else {
                        // Nếu số lượng = 1, xóa luôn item
                        $cartItem->delete();
                    }

                    // Lấy tổng số lượng mới
                    $cartCount = Cart::where('id_user', $userId)->sum('quantity');

                    return response()->json([
                        'success' => true,
                        'message' => 'Đã xóa sản phẩm khỏi giỏ hàng',
                        'cartCount' => $cartCount
                    ]);
                }
            }

            // Nếu chưa đăng nhập, xử lý session
            $cart = Session::get('cart', []);
            if (isset($cart[$productId])) {
                if ($cart[$productId]['quantity'] > 1) {
                    // Nếu số lượng > 1, giảm số lượng đi 1
                    $cart[$productId]['quantity'] -= 1;
                } else {
                    // Nếu số lượng = 1, xóa luôn item
                    unset($cart[$productId]);
                }
                Session::put('cart', $cart);
            }

            return response()->json([
                'success' => true,
                'message' => 'Đã xóa sản phẩm khỏi giỏ hàng',
                'cartCount' => array_sum(array_column($cart, 'quantity'))
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }

    public function clear()
    {
        try {
            if (Auth::check()) {
                $userId = Auth::id();
                
                // Xóa toàn bộ giỏ hàng trong database (force delete)
                Cart::where('id_user', $userId)->forceDelete();

                return response()->json([
                    'success' => true,
                    'message' => 'Đã xóa toàn bộ giỏ hàng',
                    'cartCount' => 0
                ]);
            }

            // Nếu chưa đăng nhập, xóa toàn bộ session cart
            Session::forget('cart');

            return response()->json([
                'success' => true,
                'message' => 'Đã xóa toàn bộ giỏ hàng',
                'cartCount' => 0
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }
}