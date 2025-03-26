<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::getFeaturedProducts(5);
        $products = Product::getProductsMappingCategory();
        return view('home', compact('featuredProducts', 'products'));
    }
}
