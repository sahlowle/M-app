<?php

namespace App\Http\Requests\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class AdminStoreHotelRequest extends FormRequest
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
            // 'category_id' => ['required'],
            // 'name' => ['required','array'],
            // 'image' => ['required','image'],
            // 'description' => ['required','array'],
            // 'price' => ['required','numeric'],
            // 'lat' => ['required','max:120'],
            // 'lng' => ['required','max:120'],
            // 'booking_url' => ['required','url'],
            // 'stars_count' => ['required','numeric'],
            // 'rate_stars_count' => ['required','numeric'],
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
