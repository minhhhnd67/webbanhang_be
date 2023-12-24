<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    use HasFactory;

    public $table = 'attributes';

    public $fillable = [
        'category_id',
        'name',
        'suggest_point',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function attributeOptions() {
        return $this->hasMany(AttributeOption::class, 'attribute_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_attributes', 'attribute_id', 'product_id')->withPivot('attribute_option_id', 'attribute_option_value');
    }
}
