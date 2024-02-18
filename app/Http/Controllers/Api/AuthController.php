<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginUserRequest;
use App\Http\Requests\Api\RegisterUserRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

 ///////////////// All Users ////////////////////////////////////////////////

   function users() {
    return User::all();
   }

///////////////////////////////////////////////////////////////////////////////

////////////////// User Register ///////////////////////////////////////////////

    public function registerUser(RegisterUserRequest $request)
    {
        try {
            $data = $request->validated();

            $user = User::create($data);

            $user['token'] = $user->createToken("API TOKEN")->plainTextToken;

            return $this->sendResponse(true,$user,'User Created Successfully',200);

        } catch (\Throwable $th) {
            return $this->sendResponse(false,[],$th->getMessage(),500);
        }
    }

    ////////////////////////////////////////////////////////////////////////////
 
    ////////////////////// User Login //////////////////////////////////////////
    
    public function loginUser(LoginUserRequest $request)
    {
       
        try {
            if(!Auth::attempt($request->only(['email', 'password']))){
                
                return $this->sendResponse(false,[],'Email & Password does not match with our record.',401);

            }

            $user = User::where('email', $request->email)->first();

            $user['token'] = $user->createToken("API TOKEN")->plainTextToken;

            return $this->sendResponse(true,$user,'User Logged In Successfully',200);


        } catch (\Throwable $th) {

            return $this->sendResponse(false,[],$th->getMessage(),500);
      
        }
    }
     ////////////////////////////////////////////////////////////////////////////

}
