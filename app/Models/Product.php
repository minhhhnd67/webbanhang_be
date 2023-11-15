<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public $table = 'products';

    public $fillable = [
        'category_id',
        'store_id',
        'code',
        'name',
        'title',
        'description',
        'price',
        'image',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id');
    }

    public function skus()
    {
        return $this->hasMany(Sku::class, 'product_id');
    }

    public function attributes()
    {
        return $this->belongsToMany(Attribute::class, 'product_attributes', 'product_id', 'attribute_id')->withPivot('attribute_option_id', 'attribute_option_value');
    }
}
