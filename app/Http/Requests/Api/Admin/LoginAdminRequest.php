<?php

namespace App\Http\Requests\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class LoginAdminRequest extends FormRequest
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
            'email' => ['required','email'],
            'password' => ['required','string','min:6','max:20']
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
