<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
// use Sanctum\Http\Controllers\AuthController as SanctumAuthController;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->all();

        $this->validate($request, [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
        ]);

        $user = new User();
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = Hash::make($data['password']);
        $user->save();

        return response()->json([
            'message' => 'Đăng ký thành công!',
            'user' => $user,
        ]);
    }

    public function login(Request $request)
    {
        // $validator = Validator::make($request->all(), [
        //     'email'    => 'required|string',
        //     'password' => 'required|string',
        // ]);

        // if ($validator->fails()) {
        //     return response()->json(['error' => $validator->errors()], 400);
        // }

        if(!Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            return response()->json(['message' => 'Invalid login details'], 401);
        }

        $user  = User::where('email', $request['email'])->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
           'access_token' => $token,
           'token_type'   => 'Bearer',
        ]);
    }

    public function me(Request $request)
    {
        return $request->user();
    }
}