<?php

namespace App\Http\Controllers\Api\manager;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Repositories\Manager\AttributeOptionRepository;
use App\Repositories\Manager\AttributeRepository;
use App\Repositories\Manager\CategoryRepository;
use Exception;
use Illuminate\Http\Request;

class CategoryController extends BaseController
{
    private $categoryRepository;
    private $attributeRepository;
    private $attributeOptionRepository;

    public function __construct(CategoryRepository $categoryRepository, AttributeRepository $attributeRepository, AttributeOptionRepository $attributeOptionRepository)
    {
        $this->categoryRepository = $categoryRepository;
        $this->attributeRepository = $attributeRepository;
        $this->attributeOptionRepository = $attributeOptionRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $pageSize = $request->pageSize ?? 10;
            $relations = [];
            $categories = $this->categoryRepository->getList($pageSize, $relations);
            return $this->responseSuccess($categories);
        } catch (\Exception $e) {
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
            $category = $this->categoryRepository->create(['name' => $request['name']]);
            $attributes = $request['attributes'];
            foreach($attributes as $dataAttribute) {
                $attribute = $this->attributeRepository->create([
                    'category_id' => $category->id,
                    'name' => $dataAttribute['name'],
                ]);
                $attributeOptions = $dataAttribute['attributeOptions'];
                foreach($attributeOptions as $dataAttributeOption) {
                    $attributeOption = $this->attributeOptionRepository->create([
                        'attribute_id' => $attribute->id,
                        'name' => $dataAttributeOption['name']
                    ]);
                }
            }
            return $this->responseSuccess();
        } catch (Exception $e) {
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
            $relations = ['attributes.attributeOptions'];
            $attribute = $this->categoryRepository->getById($id, $relations);
            return $this->responseSuccess($attribute);
        } catch (Exception $e) {
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
            $relations = ['attributes.attributeOptions'];
            $category = $this->categoryRepository->getById($id, $relations);
            $category->update([
                'name' => $data['name'],
            ]);

            $attributes = $category->attributes;
            foreach($attributes as $attribute) {
                $attribute->attributeOptions()->delete();
            }
            $category->attributes()->delete();

            $attributes = $request['attributes'];
            foreach($attributes as $dataAttribute) {
                $attribute = $this->attributeRepository->create([
                    'category_id' => $category->id,
                    'name' => $dataAttribute['name'],
                ]);
                $attributeOptions = $dataAttribute['attributeOptions'];
                foreach($attributeOptions as $dataAttributeOption) {
                    $attributeOption = $this->attributeOptionRepository->create([
                        'attribute_id' => $attribute->id,
                        'name' => $dataAttributeOption['name']
                    ]);
                }
            }

            return $this->responseSuccess();
        } catch (Exception $e) {
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
            $relations = ['attributes.attributeOptions'];
            $category = $this->categoryRepository->getById($id, $relations);

            $attributes = $category->attributes;
            foreach($attributes as $attribute) {
                $attribute->attributeOptions()->delete();
            }
            $category->attributes()->delete();

            $category->delete();

            return $this->responseSuccess();
        } catch (Exception $e) {
            return $this->responseFalse($e->getMessage());
        }
    }
}
