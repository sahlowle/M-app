<?php

namespace App\Http\Requests\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class AdminUpdateMallRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }


    public function rules()
    {
        return [
            'name' => ['nullable','array'],
            'mall_name' => ['nullable','array'],
            'category_id' => ['nullable','exists:categories,id'],
            'image' => ['nullable','image'],
            'description' => ['nullable','array'],
            'lat' => ['nullable','max:120'],
            'lng' => ['nullable','max:120'],
            'website_url' => ['nullable','url'],
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
