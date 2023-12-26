<?php
namespace App\Repositories\Manager;

use App\Models\Sku;
use App\Repositories\BaseRepository;

class SkuRepository extends BaseRepository
{
    public function __construct(Sku $model) {
        parent::__construct($model);
    }
}
