<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAttribute extends Model
{
    use HasFactory;

    public $table = 'product_attributes';

    public $fillable = [
        'product_id',
        'attribute_id',
        'attribute_option_id',
        'attribute_option_value',
    ];
}
