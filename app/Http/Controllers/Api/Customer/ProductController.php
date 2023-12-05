<?php

namespace App\Http\Controllers\Api\Customer;

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

    public function getNewProductByStore($store_id, Request $request)
    {
        try {
            $limit = $request->limit ?? 12;
            $products = $this->productRepository->getNewProductByStore($store_id, $limit);

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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
