<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

// use Sanctum\Http\Controllers\AuthController as SanctumAuthController;

class AuthController extends BaseController
{
    public function register(Request $request)
    {
        try {
            $data = $request->all();

            $this->validate($request, [
                'name' => 'required|string',
                'email' => 'required|email|unique:users',
                'phone' => 'required|min:4',
                'province_id' => 'required',
                'province_name' => 'required',
                'district_id' => 'required',
                'district_name' => 'required',
                'ward_id' => 'required',
                'ward_name' => 'required',
                'address_detail' => 'required',
            ]);

            $user = new User();
            $user->name = $data['name'];
            $user->email = $data['email'];
            $user->password = Hash::make($data['password']);
            $user->phone = $data['phone'];
            $user->province_id = $data['province_id'];
            $user->province_name = $data['province_name'];
            $user->district_id = $data['district_id'];
            $user->district_name = $data['district_name'];
            $user->ward_id = $data['ward_id'];
            $user->ward_name = $data['ward_name'];
            $user->address_detail = $data['address_detail'];
            $user->save();
            $token = $user->createToken('auth_token')->plainTextToken;

            return $this->responseSuccess(['token' => $token]);
        } catch (\Exception $e) {
            return $this->responseFalse($e->getMessage());
        }
    }

    public function login(Request $request)
    {
        try {
            $validator = Validator ::make($request->all(), [
                'email'    => 'required|string',
                'password' => 'required|string',
            ]);
            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            if(!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                throw new Exception('Invalid token');
            }

            $user  = User::where('email', $request['email'])->firstOrFail();
            $token = $user->createToken('auth_token')->plainTextToken;

            return $this->responseSuccess(['token' => $token]);
        } catch (\Exception $e) {
            return $this->responseFalse($e->getMessage());
        }
    }

    public function me(Request $request)
    {
        try {
            return $this->responseSuccess($request->user());
        } catch (\Exception $e) {
            return $this->responseFalse($e->getMessage());
        }
    }

    public function logout(Request $request)
    {
        try {
            $request->user()->currentAccessToken()->delete();
            return $this->responseSuccess();
        } catch (\Exception $e) {
            return $this->responseFalse($e->getMessage());
        }

    }
}
