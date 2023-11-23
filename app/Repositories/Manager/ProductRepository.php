<?php
namespace App\Repositories\Manager;

use App\Repositories\BaseRepository;
use App\Models\Product;

class ProductRepository extends BaseRepository
{
    public function __construct(Product $model) {
        parent::__construct($model);
    }

    public function getProductByStore($storeId, $pageSize)
    {
        $products = $this->model->where([['store_id', $storeId]])->paginate($pageSize);
        return $products;
    }

    public function getAllByStore($storeId, $relations = [])
    {
        $products = $this->model->with($relations)->where([['store_id', $storeId]])->get();
        return $products;
    }
}
