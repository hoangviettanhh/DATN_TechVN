<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    protected $table = 'products';
    protected $primaryKey = 'id_product';
    protected $keyType = 'int';
    protected $fillable =
        [
            'id_category',
            'name',
            'price',
            'old_price',
            'storage',
            'color',
            'description',
            'quantity',
            'created_by',
            'updated_by',
            'status'
        ];
    protected $attributes = [
        'status' => 1 // 1: active, 0: inactive
    ];

    // Hàm query chung
    public static function queryData($table, $where = [], $select = ['*'], $limit = null)
    {
        $query = DB::table($table)->select($select);

        if (!empty($where)) {
            foreach ($where as $key => $value) {
                if (is_array($value)) {
                    // Nếu value là mảng, giả sử dạng ['operator', 'value'], ví dụ: ['=', 1]
                    $query->where($key, $value[0], $value[1]);
                } else {
                    // Nếu value không phải mảng, mặc định dùng =
                    $query->where($key, '=', $value);
                }
            }
        }

        if ($limit) {
            $query->take($limit);
        }

        return $query->get();
    }

    // Lấy tất cả sản phẩm
    public static function getProducts($limit = null, $categoryId = null, $ignoreStatus = false)
    {
        $query = DB::table('products')
            ->select('products.*', 'categories.name as category_name')
            ->leftJoin('categories', 'products.id_category', '=', 'categories.id_category')
            ->orderBy('products.created_at', 'desc');

        if (!$ignoreStatus) {
            $query->where('products.status', 1);
        }

        if ($categoryId) {
            $query->where('products.id_category', '=', $categoryId);
        }

        if ($limit) {
            $query->take($limit);
        }

        $products = $query->get();

        // Lấy hình ảnh cho từng sản phẩm dưới dạng array
        foreach ($products as $product) {
            $images = DB::table('product_images')
                ->where('id_product', '=', $product->id_product)
                ->pluck('image')
                ->toArray();

            $product->images = $images;
            $product->image = !empty($images) ? $images[0] : '/image/default.jpg';
        }

        return $products;
    }
    public static function getProductsMappingCategory($limit = null, $categoryId = null)
    {
        $query = DB::table('products')
            ->select('products.*', 'categories.name as category_name')
            ->leftJoin('categories', 'products.id_category', '=', 'categories.id_category');

        if ($categoryId) {
            $query->where('products.id_category', '=', $categoryId);
        }

        if ($limit) {
            $query->take($limit);
        }

        $products = $query->get();

        $groupedProducts = [];

        foreach ($products as $product) {
            $product->images = DB::table('product_images')
                ->where('id_product', '=', $product->id_product)
                ->get();
            $product->image = $product->images->first()->image ?? '/image/default.jpg';

            $categoryName = $product->category_name ?? 'Uncategorized';
            if (!isset($groupedProducts[$categoryName])) {
                $groupedProducts[$categoryName] = [];
            }
            $groupedProducts[$categoryName][] = $product;
        }

        return $groupedProducts;
    }
    // Lấy sản phẩm theo ID
    public static function getProduct($id)
    {
        $product = DB::table('products')
            ->select('products.*', 'categories.name as category_name')
            ->leftJoin('categories', 'products.id_category', '=', 'categories.id_category')
            ->where('products.id_product', '=', $id)
            ->first();

        if (!$product) {
            throw new \Exception("Product not found");
        }

        // Lấy hình ảnh
        $product->images = DB::table('product_images')
            ->where('id_product', '=', $product->id_product)
            ->get();
        $product->image = $product->images->first()->image ?? '/image/default.jpg';

        return $product;
    }

    // Lấy sản phẩm nổi bật
    public static function getFeaturedProducts($limit = 5)
    {
        $query = DB::table('products')
            ->select('products.*')
            ->orderBy('quantity', 'desc')
            ->take($limit);

        $products = $query->get();

        // Lấy hình ảnh
        foreach ($products as $product) {
            $product->images = DB::table('product_images')
                ->where('id_product', '=', $product->id_product)
                ->get();
            $product->image = $product->images->first()->image ?? '/image/default.jpg';
        }

        return $products;
    }

    public static function getProductsByCategory($categoryId, $limit = null)
    {
        $query = DB::table('products')
            ->select('products.*')
            ->where('id_category', '=', $categoryId);

        if ($limit) {
            $query->take($limit);
        }

        $products = $query->get();

        // Lấy hình ảnh
        foreach ($products as $product) {
            $product->images = DB::table('product_images')
                ->where('id_product', '=', $product->id_product)
                ->get();
            $product->image = $product->images->first()->image ?? '/image/default.jpg';
        }

        return $products;
    }
    public function productImages()
    {
        return $this->hasMany(ProductImage::class, 'id_product');
    }

    public function deactivate()
    {
        $this->status = 0;
        return $this->save();
    }

    public function activate()
    {
        $this->status = 1;
        return $this->save();
    }
}
