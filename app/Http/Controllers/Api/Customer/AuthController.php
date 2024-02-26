<?php

namespace App\Http\Controllers\Api\Customer;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginUserRequest;
use App\Http\Requests\Api\RegisterUserRequest;
use App\Http\Requests\Api\ForgetPasswordRequest;
use App\Http\Requests\Api\GoogleLoginRequest;
use App\Http\Requests\Api\ResetPasswordRequest;
use App\Http\Requests\Api\VerifyOtpRequest;
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
    public function register(RegisterUserRequest $request)
    {
        $data = $request->validated();

        $customer = Customer::create($data);

        $customer['token'] = $customer->createToken("login-token")->plainTextToken;

        return $this->sendResponse(true,$customer,'User Created Successfully',200);
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

        return $this->sendResponse(true,[],'Reset password link sent on your email.',200);
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
     /*
    |--------------------------------------------------------------------------
    |customer verify otp
    |--------------------------------------------------------------------------
    */
    public function verifyOtp(VerifyOtpRequest $request)
    {
        $Customer  = Customer::where([['email','=',$request->email],['otp','=',$request->otp]])->first();
        if($Customer){
            auth()->login($Customer, true);
            
            Customer::where('email','=',$request->email)->update(['otp' => null]);

            $customer = Auth::guard('customer')->user();

            $customer['token'] = $customer->createToken("authToken")->accessToken;

            return $this->sendResponse(true,[],'Password successful updated',200);
           
        }
       
    }


}
