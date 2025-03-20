<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';
    protected $primaryKey = 'id_category';
    protected $keyType = 'int';
    protected $fillable = ['name'];

    public function products()
    {
        return $this->hasMany(Product::class, 'id_category', 'id_category');
    }

    public static function getCategories()
    {
        return self::all();
    }

    public static function getCategory($id)
    {
        return self::findOrFail($id);
    }
}
