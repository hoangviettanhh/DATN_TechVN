<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ProductController extends Controller
{
    public function show($id)
    {
        $product = Product::getProduct($id);
        $similarProducts = Product::getProductsByCategory($product->id_category, 5)
            ->where('id_product', '!=', $id);
        return view('product.detail', compact('product', 'similarProducts'));
    }
}
