<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Repositories\Manager\StoreRepository;

class StoreController extends BaseController
{
    private $storeRepository;

    public function __construct(StoreRepository $storeRepository)
    {
        $this->storeRepository = $storeRepository;
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
            $listStore = $this->storeRepository->all($relations);
            return $this->responseSuccess($listStore);
        } catch (\Exception $e) {
            return $this->responseFalse($e->getMessage());
        }
    }
}
