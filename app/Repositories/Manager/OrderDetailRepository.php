<?php
namespace App\Repositories\Manager;

use App\Models\OrderDetail;
use App\Repositories\BaseRepository;

class OrderDetailRepository extends BaseRepository
{
    public function __construct(OrderDetail $model) {
        parent::__construct($model);
    }
}
