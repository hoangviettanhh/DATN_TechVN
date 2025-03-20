<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function create()
    {
        return view('admin.products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'image' => 'required|image',
        ]);

        $imagePath = $request->file('image')->store('products', 'public');

        Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'old_price' => $request->old_price,
            'image' => $imagePath,
            'description' => $request->description,
            'quantity' => $request->quantity,
            'storage' => $request->storage,
            'color' => $request->color,
        ]);

        return redirect()->route('admin.products.create')->with('success', 'Thêm sản phẩm thành công!');
    }
}
