<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    public $table = 'carts';

    public $fillable = [
        'store_id',
        'user_id',
        'product_id',
        'code',
        'name',
        'image',
        'amount',
        'skus',
    ];
}
