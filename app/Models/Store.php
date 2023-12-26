<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;

    protected $table = 'stores';

    protected $fillable = [
        'name',
        'hotline',
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

    public function products()
    {
        return $this->hasMany(Product::class, 'store_id');
    }
}
