<?php

namespace App\Http\Controllers;

use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::getFeaturedProducts(5);
        $products = Product::getProducts();
        return view('home', compact('featuredProducts', 'products'));
    }
}
