<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Cart extends Model
{
    use SoftDeletes;

    protected $table = 'carts';
    protected $primaryKey = 'id_cart';

    protected $fillable = [
        'id_user',
        'id_product',
        'quantity'
    ];

    // Relationship với User
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    // Relationship với Product
    public function product()
    {
        return $this->belongsTo(Product::class, 'id_product', 'id_product');
    }

    // Helper method để lấy tổng số lượng sản phẩm trong giỏ hàng
    public static function getCartCount()
    {
        if (Auth::check()) {
            return self::where('id_user', Auth::id())->sum('quantity');
        }
        
        $cart = Session::get('cart', []);
        return array_sum(array_column($cart, 'quantity'));
    }
} 