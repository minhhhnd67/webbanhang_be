<?php

namespace App\Http\Controllers\Api\Manager;

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
            // $pageSize = $request->page_size ?? 20;
            $listStore = $this->storeRepository->all($relations);
            return $this->responseSuccess($listStore);
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
            $store = $this->storeRepository->create($data);
            return $this->responseSuccess($store);
        } catch (\Exception $e) {
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
            $store = $this->storeRepository->getById($id);
            return $this->responseSuccess($store);
        } catch (\Exception $e) {
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
            $this->storeRepository->update($data, $id);
            return $this->responseSuccess();
        } catch (\Exception $e) {
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
            $this->storeRepository->destroy([$id]);
            return $this->responseSuccess();
        } catch (\Exception $e) {
            return $this->responseFalse($e->getMessage());
        }
    }
}
