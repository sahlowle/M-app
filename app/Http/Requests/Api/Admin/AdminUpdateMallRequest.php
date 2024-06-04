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
            'name' => ['array','required_array_keys:en,ar,fr,ur,tr,sw'],
            'mall_name' => ['array','required_array_keys:en,ar,fr,ur,tr,sw'],
            'description' => ['array','required_array_keys:en,ar,fr,ur,tr,sw'],
            'category_id' => ['exists:categories,id'],
            'image' => ['image'],    
            'lat' => ['max:120'],
            'lng' => ['max:120'],
            'address' => ['string','max:190'],
            'phone_one' => ['numeric','digits_between:9,20'],
            'phone_two' => ['numeric','digits_between:9,20'],
            'phone_three' => ['numeric','digits_between:9,20'],
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
