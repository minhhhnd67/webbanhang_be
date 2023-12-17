<?php
namespace App\Repositories\Manager;

use App\Models\Order;
use App\Repositories\BaseRepository;

class OrderRepository extends BaseRepository
{
    public function __construct(Order $model) {
        parent::__construct($model);
    }

    public function getOrderByStore($storeId, $relations = [], $pageSize = 10)
    {
        $orders = $this->model->with($relations)->where('store_id', $storeId)->orderBy('created_at', 'DESC')->paginate($pageSize);
        return $orders;
    }

    public function getOrderByUser($userId, $relations = [], $pageSize = 10)
    {
        $orders = $this->model->with($relations)->where('user_id', $userId)->orderBy('created_at', 'DESC')->paginate($pageSize);
        return $orders;
    }
}
