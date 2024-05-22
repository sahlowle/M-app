<?php

namespace App\Http\Controllers\Api\Customer;

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

class AuthController extends Controller
{

   /*
   |--------------------------------------------------------------------------
   | Register new customer
   |--------------------------------------------------------------------------
   */
    public function register(RegisterCustomerRequest $request)
    {
        $data = $request->validated();

        $customer = Customer::create($data);

        $email = $customer->email;

        $otp = OTP::generate($email,4,10);

        Mail::to($email)->send(new SendOtp($otp));

        // $customer['token'] = $customer->createToken("login-token")->plainTextToken;

        return $this->sendResponse(true,$customer,'User Created Successfully',200);
    }

    /*
    |--------------------------------------------------------------------------
    |customer login verify otp
    |--------------------------------------------------------------------------
    */
    public function verifyLoginOtp(VerifyLoginOtpRequest $request)
    {
        $email = $request->email;

        $otp = $request->otp;

        $otpValidate = OTP::validate($email,$otp);

        if ($otpValidate->success) {
            $customer  = Customer::where('email',$email)->first();
            $token = $customer->createToken("login-token")->plainTextToken;

            $customer->update([
                'is_verified' => true
            ]);

            return $this->sendResponse(true,["token"=> $token],'Otp successful verified',200);
        }

        return $this->sendResponse(false,[],'Otp code is not valid',401);
    }

    /*
    |--------------------------------------------------------------------------
    | resend Otp
    |--------------------------------------------------------------------------
    */
    public function resendOtp(ForgetPasswordRequest $request) 
    {
        $email = $request->email;

        $otp = OTP::generate($email,4,10);

        Mail::to($email)->send(new SendOtp($otp));

        return $this->sendResponse(true,[],'Otp code sent on your email.',200);
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

        $customer = Auth::guard('customer')->user();

        if ($customer->isNotVerified()) {
            $email = $customer->email;
            $otp = OTP::generate($email,4,10);
            Mail::to($email)->send(new SendOtp($otp));
            return $this->sendResponse(false,[],'please verify your account',403);
        }

        $customer['token'] = $customer->createToken("login-token")->plainTextToken;

        return $this->sendResponse(true,$customer,'User Logged In Successfully',200);
    }


    /*
    |--------------------------------------------------------------------------
    | customer forget password
    |--------------------------------------------------------------------------
    */
    public function forgetPassword(ForgetPasswordRequest $request) 
    {
        $email = $request->email;

        $otp = OTP::generate($email,4,10);

        Mail::to($email)->send(new SendOtp($otp));

        return $this->sendResponse(true,[],'Otp code sent on your email.',200);
    }

    /*
    |--------------------------------------------------------------------------
    |reset password verify otp
    |--------------------------------------------------------------------------
    */
    public function verifyResetPasswordOtp(VerifyResetPasswordOtpRequest $request)
    {
        $email = $request->email;

        $otp = $request->otp;

        $otpValidate = OTP::validate($email,$otp);

        if ($otpValidate->success) {
            $customer  = Customer::where('email',$email)->first();
            $token = $customer->createToken('reset-password-auth', ['reset-password'])->plainTextToken;
            return $this->sendResponse(true,["token"=> $token],'Otp successful verified',200);
        }

        return $this->sendResponse(false,[],'Otp code is not valid',401);
    }

    /*
    |--------------------------------------------------------------------------
    | customer reset password
    |--------------------------------------------------------------------------
    */
    public function resetPassword(ResetPasswordRequest $request) 
    {
        $data = $request->only('password');

        $customer = $request->user();

        $customer->update($data);

        $customer->currentAccessToken()->delete(); // remove token to ensure no one else can use it after rest password. 

        return $this->sendResponse(true,[],'Password successful updated',200);
    }

    /*
    |--------------------------------------------------------------------------
    | handel login by google
    |--------------------------------------------------------------------------
    */
    public function handleGoogleCallback(GoogleLoginRequest $request) 
    {
        $accessToken = $request->access_token;

        $googleUser = Socialite::driver('google')->userFromToken($accessToken);

        $customer = Customer::where('email', $googleUser->getEmail())->first();

        if ($customer)
        {
            $customer->update([
                'is_verified' => true
            ]);
        }
        else
        {
            $customer = Customer::create([
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'is_verified' => true
            ]);
        }

        $customer['token'] = $customer->createToken("login-token")->plainTextToken;

        return $this->sendResponse(true,$customer,'User Logged In Successfully',200);
    }




}
