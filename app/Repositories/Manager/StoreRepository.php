<?php
namespace App\Repositories\Manager;

use App\Repositories\BaseRepository;
use App\Models\Store;

class StoreRepository extends BaseRepository
{
    public function __construct(Store $model) {
        parent::__construct($model);
    }
}
