<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sku extends Model
{
    use HasFactory;

    public $table = 'skus';

    public $fillable = [
        'product_id',
        'name',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function skuOptions()
    {
        return $this->hasMany(SkuOption::class, 'sku_id');
    }
}
