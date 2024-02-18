<?php

namespace App\Http\Controllers\Api\Customer;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginUserRequest;
use App\Http\Requests\Api\RegisterUserRequest;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
   /*
   |--------------------------------------------------------------------------
   | Register new customer
   |--------------------------------------------------------------------------
   */
    public function register(RegisterUserRequest $request)
    {
        $data = $request->validated();

        $user = Customer::create($data);

        $user['token'] = $user->createToken("API TOKEN")->plainTextToken;

        return $this->sendResponse(true,$user,'User Created Successfully',200);
    }

   /*
   |--------------------------------------------------------------------------
   | login customer
   |--------------------------------------------------------------------------
   */
    public function login(LoginUserRequest $request)
    {
        $data = $request->only(['email', 'password']);

        if (!Auth::guard('customer')->attempt($data)) {
            return $this->sendResponse(false,[],'Email & Password does not match with our record.',401);
        }

        $user = Auth::guard('customer')->user();

        $user['token'] = $user->createToken("API TOKEN")->plainTextToken;

        return $this->sendResponse(true,$user,'User Logged In Successfully',200);
    }

}
