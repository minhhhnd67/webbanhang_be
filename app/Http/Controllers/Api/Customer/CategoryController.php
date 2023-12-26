<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
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
            $relations = [];
            $categories = $this->categoryRepository->all($relations);
            return $this->responseSuccess($categories);
        } catch (\Exception $e) {
            return $this->responseFalse($e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $relations = ['attributes.attributeOptions'];
            $category = $this->categoryRepository->getById($id, $relations);
            foreach($category->attributes as &$attribute) {
                $attribute->attributeOptions = $attribute->attributeOptions;
            }

            return $this->responseSuccess($category);
        } catch (Exception $e) {
            return $this->responseFalse($e->getMessage());
        }
    }
}
