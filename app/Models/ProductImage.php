<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $table = 'product_images';
    protected $primaryKey = 'id_product_image';
    protected $keyType = 'int';
    protected $fillable = ['id_product', 'image'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'id_product', 'id_product');
    }

    public static function getImagesByProduct($productId)
    {
        return self::where('id_product', $productId)->get();
    }
}
