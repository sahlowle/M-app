<?php

namespace App\Http\Requests\Api;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Facades\Auth;

class StoreContactRequest extends FormRequest
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
            'name' => ['required','max:150'],
            'title' => ['required','max:150'],
            'email' => ['email','max:100'],
            'phone' =>  ['numeric','digits_between:9,20'],
            'message' => ['required','string'],
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
