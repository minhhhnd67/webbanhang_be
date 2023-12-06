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

    public function getNewProductByStore($storeId, $limit)
    {
        $products = $this->model->where([['store_id', $storeId]])->orderBy('id', 'desc')->limit($limit)->get();
        return $products;
    }

    public function searchProduct($storeId, $search) {
        $products = $this->model->where([['store_id', $storeId], ['name', 'like', "%$search%"]])->orderBy('id', 'desc')->get();
        return $products;
    }

    public function getAllByStore($storeId, $relations = [])
    {
        $products = $this->model->with($relations)->where([['store_id', $storeId]])->get();
        return $products;
    }
}
