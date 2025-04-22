<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::getCategories(true);
        return view('admin.categories.list', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name'
        ]);

        Category::create([
            'name' => $request->name
        ]);

        return redirect()->route('admin.categories.list')
            ->with('success', 'Thêm danh mục thành công');
    }

    public function edit($id)
    {
        $category = Category::getCategory($id);
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,'.$id.',id_category'
        ]);

        $category = Category::getCategory($id);
        $category->update([
            'name' => $request->name
        ]);

        return redirect()->route('admin.categories.list')
            ->with('success', 'Cập nhật danh mục thành công');
    }

    public function deactivate($id)
    {
        try {
            $category = Category::findOrFail($id);
            $category->deactivate();
            
            return response()->json([
                'success' => true,
                'message' => 'Đã vô hiệu hóa danh mục thành công'
            ]);
        } catch (\Exception $e) {
            Log::error('Lỗi khi vô hiệu hóa danh mục: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi vô hiệu hóa danh mục'
            ], 500);
        }
    }

    public function activate($id)
    {
        try {
            $category = Category::findOrFail($id);
            $category->activate();
            
            return response()->json([
                'success' => true,
                'message' => 'Đã kích hoạt danh mục thành công'
            ]);
        } catch (\Exception $e) {
            Log::error('Lỗi khi kích hoạt danh mục: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi kích hoạt danh mục'
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            // Lấy danh mục
            $category = Category::findOrFail($id);
            
            // Lấy tất cả sản phẩm thuộc danh mục này
            $products = Product::where('id_category', $id)->get();
            
            // Kiểm tra xem có sản phẩm nào đang trong đơn hàng chờ thanh toán không
            foreach ($products as $product) {
                $orderDetails = DB::table('orders')
                    ->join('order_details', 'orders.id_order', '=', 'order_details.id_order')
                    ->where('order_details.id_product', $product->id_product)
                    ->where('orders.id_order_status', 1) // pending = 1
                    ->exists();
                    
                if ($orderDetails) {
                    return redirect()->route('admin.categories.list')
                        ->with('error', 'Không thể xóa danh mục vì có sản phẩm đang trong đơn hàng chờ thanh toán');
                }
            }
            
            // Lấy tất cả ảnh của các sản phẩm
            $productIds = $products->pluck('id_product')->toArray();
            $images = ProductImage::whereIn('id_product', $productIds)->get();
            
            // Xóa tất cả ảnh
            foreach ($images as $image) {
                // Xóa record ảnh từ database
                $image->delete();
            }
            
            // Xóa tất cả sản phẩm
            Product::where('id_category', $id)->delete();
            
            // Xóa danh mục
            $category->delete();
            
            return redirect()->route('admin.categories.list')
                ->with('success', 'Xóa danh mục và các sản phẩm liên quan thành công');
        } catch (\Exception $e) {
            Log::error('Lỗi khi xóa danh mục: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return redirect()->back()
                ->with('error', 'Có lỗi xảy ra khi xóa danh mục: ' . $e->getMessage())
                ->withInput();
        }
    }
} 