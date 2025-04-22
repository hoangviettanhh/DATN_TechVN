<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';
    protected $primaryKey = 'id_category';
    protected $keyType = 'int';
    protected $fillable = ['name', 'status'];
    protected $attributes = [
        'status' => 1 // 1: active, 0: inactive
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'id_category', 'id_category');
    }

    public static function getCategories($ignoreStatus = false)
    {
        $query = self::query();
        
        if (!$ignoreStatus) {
            $query->where('status', 1);
        }
        
        return $query->get();
    }

    public static function getCategory($id)
    {
        return self::findOrFail($id);
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
