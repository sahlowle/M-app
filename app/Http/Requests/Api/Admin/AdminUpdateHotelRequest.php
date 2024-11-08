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
            'name' => ['array:en,ar,fr,ur,tr,sw','required_array_keys:en,ar,fr,ur,tr,sw'],
            'description' => ['array:en,ar,fr,ur,tr,sw','required_array_keys:en,ar,fr,ur,tr,sw'],
            'image' => ['image'],
            'price' => ['numeric'],
            'sort' => ['numeric'],
            'lat' => ['string','max:120'],
            'lng' => ['string','max:120'],
            'map_url' => ['string','max:1024'],
            'booking_url' => ['url'],
            'stars_count' => ['numeric','min:1','max:5'],
            'rate_stars_count' => ['numeric'],
            'users_ratings_count' => ['numeric'],
            'logo' => ['image'],
            'booking_rate' => ['numeric'],
            'tripadvisor_rate' => ['numeric'],
            'agoda_rate' => ['numeric'],
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
