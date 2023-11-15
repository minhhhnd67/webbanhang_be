<?php

namespace App\Http\Controllers\Api\Manager;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Repositories\Manager\ProductAttributeRepository;
use App\Repositories\Manager\ProductRepository;
use App\Repositories\Manager\SkuOptionRepository;
use App\Repositories\Manager\SkuRepository;
use Exception;
use Illuminate\Http\Request;

class ProductController extends BaseController
{
    private $productRepository;
    private $productAttributeRepository;
    private $skuRepository;
    private $skuOptionRepository;

    public function __construct(ProductRepository $productRepository, ProductAttributeRepository $productAttributeRepository, SkuRepository $skuRepository, SkuOptionRepository $skuOptionRepository)
    {
        $this->productRepository = $productRepository;
        $this->productAttributeRepository = $productAttributeRepository;
        $this->skuRepository = $skuRepository;
        $this->skuOptionRepository = $skuOptionRepository;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $storeId = $request->storeId;
            $pageSize = $request->pageSize ?? 10;
            $products = $this->productRepository->getProductByStore($storeId, $pageSize);

            return $this->responseSuccess($products);
        } catch(Exception $e) {
            return $this->responseFalse($e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $data = $request->all();
            $product = $this->productRepository->create([
                "category_id" => $data['category_id'],
                "store_id" => $data['store_id'],
                "code" => $data['code'],
                "name" => $data['name'],
                "title" => $data['title'],
                "description" => $data['description'],
                "price" => $data['price'],
                "image" => $data['image'],
            ]);
            $attributes = $data['attributes'] ?? [];
            foreach($attributes as $attribute) {
                $attribute['product_id'] = $product->id;
                $this->productAttributeRepository->create($attribute);
            }
            $skus = $data['skus'] ?? [];
            foreach($skus as $sku) {
                $sk = $this->skuRepository->create([
                    'product_id' => $product->id,
                    'name' => $sku['name']
                ]);
                $skuOptions = $sku['skuOptions'] ?? [];
                foreach($skuOptions as $skuOption) {
                    $this->skuOptionRepository->create([
                        'sku_id' => $sk->id,
                        'name' => $skuOption['name'],
                        'change_price' => $skuOption['change_price']
                    ]);
                }
            }

            return $this->responseSuccess();
        } catch(Exception $e) {
            return $this->responseFalse($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $relations = ['skus.skuOptions', 'attributes'];
            $product = $this->productRepository->getById($id, $relations);

            return $this->responseSuccess($product);
        } catch(Exception $e) {
            return $this->responseFalse($e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $data = $request->all();
            $relations = ['skus.skuOptions', 'attributes'];
            $product = $this->productRepository->getById($id, $relations);
            $product->update([
                "category_id" => $data['category_id'],
                "store_id" => $data['store_id'],
                "code" => $data['code'],
                "name" => $data['name'],
                "title" => $data['title'],
                "description" => $data['description'],
                "price" => $data['price'],
                "image" => $data['image'],
            ]);

            // Delete old attribute + old sku
            $product->attributes()->detach();
            $skus = $product->skus ?? [];
            foreach($skus as $sku) {
                $sku->skuOptions()->delete();
            }
            $product->skus()->delete();

            // Add new attribute + new sku
            $attributes = $data['attributes'] ?? [];
            foreach($attributes as $attribute) {
                $attribute['product_id'] = $product->id;
                $this->productAttributeRepository->create($attribute);
            }
            $skus = $data['skus'] ?? [];
            foreach($skus as $sku) {
                $sk = $this->skuRepository->create([
                    'product_id' => $product->id,
                    'name' => $sku['name']
                ]);
                $skuOptions = $sku['skuOptions'] ?? [];
                foreach($skuOptions as $skuOption) {
                    $this->skuOptionRepository->create([
                        'sku_id' => $sk->id,
                        'name' => $skuOption['name'],
                        'change_price' => $skuOption['change_price']
                    ]);
                }
            }

            return $this->responseSuccess();
        } catch(Exception $e) {
            return $this->responseFalse($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $relations = ['skus.skuOptions', 'attributes'];
            $product = $this->productRepository->getById($id, $relations);

            // Delete attribute + sku
            $product->attributes()->detach();
            $skus = $product->skus ?? [];
            foreach($skus as $sku) {
                $sku->skuOptions()->delete();
            }
            $product->skus()->delete();

            // Delete product
            $product->delete();

            return $this->responseSuccess();
        } catch(Exception $e) {
            return $this->responseFalse($e->getMessage());
        }
    }
}
