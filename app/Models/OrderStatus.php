<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderStatus extends Model
{
    use SoftDeletes;

    protected $table = 'order_status';
    protected $primaryKey = 'id_order_status';

    protected $fillable = [
        'name'
    ];

    public function orders()
    {
        return $this->hasMany(Order::class, 'id_order_status', 'id_order_status');
    }
} 