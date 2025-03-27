<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    protected $table = 'orders';
    protected $primaryKey = 'id_order';

    protected $fillable = [
        'id_user',
        'id_voucher',
        'id_order_status',
        'total_amount',
        'deleted_at',
        'address'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function voucher()
    {
        return $this->belongsTo(Voucher::class, 'id_voucher', 'id_voucher');
    }

    public function orderStatus()
    {
        return $this->belongsTo(OrderStatus::class, 'id_order_status', 'id_order_status');
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'id_order', 'id_order');
    }
} 