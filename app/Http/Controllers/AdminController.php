<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function create()
    {
        $categories = Category::getCategories();
        $products = Product::getProducts();
        return view('admin.products.create', compact('categories', 'products'));
    }

    public function store(StoreProductRequest $request)
    {
        $product = new Product();
        $product->id_category = $request->id_category;
        $product->name = $request->name;
        $product->price = $request->price;
        $product->old_price = $request->old_price ?? 0;
        $product->storage = $request->storage;
        $product->color = $request->color;
        $product->description = $request->description;
        $product->quantity = $request->quantity;
        $product->created_by = Auth::id();
        $product->updated_by = Auth::id();
        $product->save();

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            // Lấy tên file gốc và lưu vào thư mục public/image
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('image'), $imageName);

            // Lưu tên file vào bảng product_images
            ProductImage::create([
                'id_product' => $product->id_product,
                'image' => $imageName,
            ]);
        }

        return redirect()->route('admin.products.create')->with('success', 'Sản phẩm đã được thêm thành công!');
    }

    public function addImage(Request $request)
    {
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('image'), $imageName);

            ProductImage::create([
                'id_product' => $request->product_id,
                'image' => $imageName,
            ]);
        }

        return redirect()->route('admin.products.create')->with('success', 'Hình ảnh đã được thêm thành công!');
    }
}
