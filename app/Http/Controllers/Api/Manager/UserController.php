<?php

namespace App\Http\Controllers\Api\Manager;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\Manager\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends BaseController
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
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
            $pageSize = $request->pageSize ?? 5;
            $listUser = $this->userRepository->getList($pageSize, $relations);
            return $this->responseSuccess($listUser);
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

            $this->validate($request, [
                'name' => 'required|string',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:4',
            ]);

            $user = User::create([
                'email' => $data['email'],
                'name' => $data['name'],
                'password' => Hash::make($data['password']),
                'role' => $data['role'],
                'store_id' => $data['store_id'],
                'phone' => $data['phone'],
                'province_id' => $data['province_id'],
                'province_name' => $data['province_name'],
                'district_id' => $data['district_id'],
                'district_name' => $data['district_name'],
                'ward_id' => $data['ward_id'],
                'ward_name' => $data['ward_name'],
                'address_detail' => $data['address_detail'],
                'status' => $data['status'],
            ]);

            return $this->responseSuccess();
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
            $user = $this->userRepository->getById($id);
            return $this->responseSuccess($user);
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
            $this->userRepository->update($data, $id);
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
            $this->userRepository->destroy([$id]);
            return $this->responseSuccess();
        } catch (\Exception $e) {
            return $this->responseFalse($e->getMessage());
        }
    }
}
