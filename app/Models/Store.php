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
    ];

    protected $appends = ['address'];

    public function getAddressAttribute()
    {
        return "{$this->province_name} - {$this->district_name} - {$this->ward_name}";
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'store_id');
    }
}
