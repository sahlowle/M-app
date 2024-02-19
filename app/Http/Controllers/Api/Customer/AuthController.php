<?php

namespace App\Http\Controllers\Api\Customer;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginUserRequest;
use App\Http\Requests\Api\RegisterUserRequest;
use App\Http\Requests\Api\ForgetPasswordRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;

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
            return $this->sendResponse(false,[],trans('auth.failed'),401);
        }

        $user = Auth::guard('customer')->user();

        $user['token'] = $user->createToken("API TOKEN")->plainTextToken;

        return $this->sendResponse(true,$user,'User Logged In Successfully',200);
    }

    public function forgetPassword(ForgetPasswordRequest $request) {
        $credentials = $request->validated();

        Password::sendResetLink($credentials);

        return $this->sendResponse(true,[],'Reset password link sent on your email id.',200);
    }

}
