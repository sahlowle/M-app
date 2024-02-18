<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Facades\Auth;

class LoginUserRequest extends FormRequest
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

    ///////////// Login Rules /////////////////////////
    public function rules()
    {
        return [
            'email' => 'required|email',
            'password' => 'required'
        ];
    }
    ////////////////////////////////////////////////////

}
