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
        return auth()->check();
    }

    public function rules()
    {
        return [
            'name' => ['required','array','required_array_keys:en,ar,fr,ur,tr,sw'],

            'image' => ['required','image'],

            'description' => ['required','array','required_array_keys:en,ar,fr,ur,tr,sw'],
            'price' => ['required','numeric'],
            'lat' => ['required','max:120'],
            'lng' => ['required','max:120'],
            'booking_url' => ['required','url'],
            'stars_count' => ['required','numeric'],
            'rate_stars_count' => ['required','numeric'],
            'users_ratings_count' => ['required','numeric'],
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
