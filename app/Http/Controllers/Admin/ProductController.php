<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::getProducts(null, null, true);
        return view('admin.products.list', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.add', compact('categories'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'price' => 'required|numeric|min:0',
                'old_price' => 'nullable|numeric|min:0',
                'storage' => 'required|string|max:255',
                'color' => 'required|string|max:255',
                'description' => 'required|string',
                'quantity' => 'required|integer|min:0',
                'id_category' => 'required|exists:categories,id_category',
                'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);

            $product = Product::create([
                'name' => $request->name,
                'price' => $request->price,
                'old_price' => $request->old_price,
                'storage' => $request->storage,
                'color' => $request->color,
                'description' => $request->description,
                'quantity' => $request->quantity,
                'id_category' => $request->id_category,
                'created_by' => 1,
                'updated_by' => 1
            ]);

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('image'), $imageName);

                ProductImage::create([
                    'id_product' => $product->id_product,
                    'image' => $imageName,
                ]);
            }

            return redirect()->route('admin.products.list')
                ->with('success', 'Thêm sản phẩm thành công');
        } catch (\Exception $e) {
            Log::error('Lỗi khi thêm sản phẩm: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return redirect()->back()
                ->with('error', 'Có lỗi xảy ra khi thêm sản phẩm: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit($id)
    {
        $product = Product::getProduct($id);
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'price' => 'required|numeric|min:0',
                'old_price' => 'nullable|numeric|min:0',
                'storage' => 'required|string|max:255',
                'color' => 'required|string|max:255',
                'description' => 'required|string',
                'quantity' => 'required|integer|min:0',
                'id_category' => 'required|exists:categories,id_category',
                'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);

            $product = Product::findOrFail($id);
            
            $product->update([
                'name' => $request->name,
                'price' => $request->price,
                'old_price' => $request->old_price,
                'storage' => $request->storage,
                'color' => $request->color,
                'description' => $request->description,
                'quantity' => $request->quantity,
                'id_category' => $request->id_category,
                'updated_by' => 1
            ]);

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('image'), $imageName);

                ProductImage::create([
                    'id_product' => $product->id_product,
                    'image' => $imageName,
                ]);
            }

            return redirect()->route('admin.products.list')
                ->with('success', 'Cập nhật sản phẩm thành công');
        } catch (\Exception $e) {
            Log::error('Lỗi khi cập nhật sản phẩm: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return redirect()->back()
                ->with('error', 'Có lỗi xảy ra khi cập nhật sản phẩm: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function deactivate($id)
    {
        try {
            $product = Product::findOrFail($id);
            $product->deactivate();
            
            return response()->json([
                'success' => true,
                'message' => 'Đã vô hiệu hóa sản phẩm thành công'
            ]);
        } catch (\Exception $e) {
            Log::error('Lỗi khi vô hiệu hóa sản phẩm: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi vô hiệu hóa sản phẩm'
            ], 500);
        }
    }

    public function activate($id)
    {
        try {
            $product = Product::findOrFail($id);
            $product->activate();
            
            return response()->json([
                'success' => true,
                'message' => 'Đã kích hoạt sản phẩm thành công'
            ]);
        } catch (\Exception $e) {
            Log::error('Lỗi khi kích hoạt sản phẩm: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi kích hoạt sản phẩm'
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $product = Product::findOrFail($id);
            
            // Kiểm tra xem sản phẩm có trong đơn hàng đang chờ thanh toán (status = 1) không
            $orderDetails = DB::table('orders')
                ->join('order_details', 'orders.id_order', '=', 'order_details.id_order')
                ->where('order_details.id_product', $id)
                ->where('orders.id_order_status', 1) // pending = 1
                ->exists();
                
            if ($orderDetails) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không thể xóa sản phẩm vì đang có trong đơn hàng chờ thanh toán'
                ], 400);
            }
            
            // Xóa ảnh của sản phẩm
            $images = ProductImage::where('id_product', $id)->get();
            foreach ($images as $image) {
                $image->delete();
            }
            
            // Xóa sản phẩm
            $product->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Xóa sản phẩm thành công'
            ]);
        } catch (\Exception $e) {
            Log::error('Lỗi khi xóa sản phẩm: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi xóa sản phẩm: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroyImage($id)
    {
        try {
            $image = ProductImage::findOrFail($id);
            $image->delete();
            
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error('Lỗi khi xóa ảnh: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
} 