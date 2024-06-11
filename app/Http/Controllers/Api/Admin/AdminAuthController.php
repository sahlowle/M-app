<?php

namespace App\Http\Controllers\Api\Admin;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\LoginAdminRequest;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    /*
   |--------------------------------------------------------------------------
   | login admin
   |--------------------------------------------------------------------------
   */
  public function login(LoginAdminRequest $request)
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
