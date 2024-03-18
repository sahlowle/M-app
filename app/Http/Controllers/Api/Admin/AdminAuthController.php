<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginUserRequest;
use App\Http\Requests\Api\RegisterCustomerRequest;
use App\Http\Requests\Api\ForgetPasswordRequest;
use App\Http\Requests\Api\GoogleLoginRequest;
use App\Http\Requests\Api\ResetPasswordRequest;
use App\Http\Requests\Api\VerifyLoginOtpRequest;
use App\Http\Requests\Api\VerifyResetPasswordOtpRequest;
use App\Mail\SendOtp;
use App\Services\OTP;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Laravel\Socialite\Facades\Socialite;

class AdminAuthController extends Controller
{
    /*
   |--------------------------------------------------------------------------
   | login admin
   |--------------------------------------------------------------------------
   */
  public function login(LoginUserRequest $request)
  {
      $data = $request->only(['email', 'password']);

      if (!Auth::attempt($data)) {
          return $this->sendResponse(false,[],trans('auth.failed'),401);
      }

      $user = Auth::user();

      $user['token'] =  $user->createToken('admin-login', ['admin-login'])->plainTextToken;

      return $this->sendResponse(true,$user,'User Logged In Successfully',200);
  }

   /*
   |--------------------------------------------------------------------------
   | Register new customer
   |--------------------------------------------------------------------------
   */
    // public function register(RegisterCustomerRequest $request)
    // {
    //     $data = $request->validated();

    //     $customer = Customer::create($data);

    //     $customer['token'] = $customer->createToken("login-token")->plainTextToken;

    //     return $this->sendResponse(true,$customer,'User Created Successfully',200);
    // }
}
