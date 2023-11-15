<?php
namespace App\Repositories\Manager;

use App\Repositories\BaseRepository;
use App\Models\ProductAttribute;

class ProductAttributeRepository extends BaseRepository
{
    public function __construct(ProductAttribute $model) {
        parent::__construct($model);
    }
}
