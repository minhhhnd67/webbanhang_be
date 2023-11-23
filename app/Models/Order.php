<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public $table = 'orders';

    public $fillable = [
        'store_id',
        'code',
        'user_id',
        'status',
        'total_money',
        'type',
        'name',
        'phone',
        'province_id',
        'province_name',
        'district_id',
        'district_name',
        'ward_id',
        'ward_name',
        'address_detail',
    ];

    protected $appends = ['address'];

    public function getAddressAttribute()
    {
        return "{$this->address_detail} - {$this->ward_name} - {$this->district_name} - {$this->province_name}";
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'order_id');
    }
}
