<?php

namespace App\Http\Requests\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class AdminUpdateHotelRequest extends FormRequest
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
            'image' => ['nullable','image'],
            'description' => ['nullable','array'],
            'price' => ['nullable','numeric'],
            'lat' => ['nullable','max:120'],
            'lng' => ['nullable','max:120'],
            'booking_url' => ['nullable','url'],
            'stars_count' => ['nullable','numeric'],
            'rate_stars_count' => ['nullable','numeric'],
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
