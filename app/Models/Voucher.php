<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Voucher extends Model
{
    use SoftDeletes;

    protected $table = 'vouchers';
    protected $primaryKey = 'id_voucher';

    protected $fillable = [
        'code',
        'discount'
    ];

    public function orders()
    {
        return $this->hasMany(Order::class, 'id_voucher', 'id_voucher');
    }
} 