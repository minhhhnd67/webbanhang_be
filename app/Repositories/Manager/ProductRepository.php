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
        if ($storeId == 6688) {
            $products = $this->model->orderBy('id', 'desc')->paginate($pageSize);
        } else {
            $products = $this->model->where([['store_id', $storeId]])->orderBy('id', 'desc')->paginate($pageSize);
        }

        return $products;
    }

    public function getNewProductByStore($storeId, $limit)
    {
        $products = $this->model->where([['store_id', $storeId]])->orderBy('id', 'desc')->limit($limit)->get();
        return $products;
    }

    public function searchProduct($storeId, $parameters, $pageSize) {
        $products = $this->model->with('attributes')->where('store_id', $storeId);
        if (isset($parameters['search']) && $parameters['search']) {
            $products = $products->where('name', 'like', "%".$parameters['search']."%");
        }
        if (isset($parameters['category_id']) && $parameters['category_id']) {
            $products = $products->where('category_id', $parameters['category_id']);
        }
        if (isset($parameters['attributes']) && $parameters['attributes']) {
            $attributes = $parameters['attributes'];
            foreach($attributes as $attribute) {
                if (isset($attribute['attribute_option_id']) && $attribute['attribute_option_id']) {
                    $products = $products->whereHas('attributes', function ($query) use($attribute) {
                        $query->where('product_attributes.attribute_id', $attribute['attribute_id'])->where('product_attributes.attribute_option_id', $attribute['attribute_option_id']);
                    });
                }
            }
        }
        $products = $products->orderBy('id', 'desc')->paginate($pageSize);
        return $products;
    }

    public function getAllByStore($storeId, $relations = [])
    {
        $products = $this->model->with($relations)->where([['store_id', $storeId]])->get();
        return $products;
    }
}
