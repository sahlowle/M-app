<?php

namespace App\Http\Requests\Api;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegisterCustomerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

 
    public function rules()
    {
        return [
            'name' => ['required'],
            'email' => ['required','email','unique:customers,email'],
            'mobile' => ['nullable'],
            'gender' => ['required','in:male,female'],
            'password' =>[ 'required','string','min:6','max:20'],
            'fcm_token' => ['required','string','min:10','max:250'],
            'device_type' => ['required','string','in:android,ios'],
        ];
        
    }

   /*
    |--------------------------------------------------------------------------
    | handel json form of validation error
    |--------------------------------------------------------------------------
    */
    public function failedValidation(Validator $validator)
    {
        $controller = new Controller;
        
        throw new HttpResponseException($controller->sendResponse(false,$validator->errors(),'The given data was invalid.',422));
    }
     
}
