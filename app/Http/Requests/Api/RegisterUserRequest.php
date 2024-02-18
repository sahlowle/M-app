<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegisterUserRequest extends FormRequest
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

 
     ////////////////////// Register Rules /////////////
    public function rules()
    {
        return [
            
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required'
            
        ];
        
    }
   ////////////////////// Register And Login User Message/////////////
/*
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => false,
            'message' => "The given data was invalid.",
            'data' => $validator->errors(),
            'code' => 422,
        ], 
        422));
    }
     */
}
