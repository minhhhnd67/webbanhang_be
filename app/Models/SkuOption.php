<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SkuOption extends Model
{
    use HasFactory;

    public $table = 'sku_options';

    public $fillable = [
        'sku_id',
        'name',
        'change_price',
    ];
}
