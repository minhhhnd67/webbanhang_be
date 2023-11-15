<?php
namespace App\Repositories\Manager;

use App\Repositories\BaseRepository;
use App\Models\SkuOption;

class SkuOptionRepository extends BaseRepository
{
    public function __construct(SkuOption $model) {
        parent::__construct($model);
    }
}
