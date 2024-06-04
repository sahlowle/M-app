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
            'name' => ['array:en,ar,fr,ur,tr,sw'],
             
            'name.en' => ['string','max:190'],
            'name.ar' => ['string','max:190'],
            'name.fr' => ['string','max:190'],
            'name.ur' => ['string','max:190'],
            'name.tr' => ['string','max:190'],
            'name.sw' => ['string','max:190'],

            'image' => ['image'],

            'description' => ['array:en,ar,fr,ur,tr,sw'],
                                        
            'description.en' => ['string','max:1000'],
            'description.ar' => ['string','max:1000'],
            'description.fr' => ['string','max:1000'],
            'description.ur' => ['string','max:1000'],
            'description.tr' => ['string','max:1000'],
            'description.sw' => ['string','max:1000'],

            'price' => ['numeric'],
            'lat' => ['max:120'],
            'lng' => ['max:120'],
            'booking_url' => ['url'],
            'stars_count' => ['numeric','min:1','max:5'],
            'rate_stars_count' => ['numeric'],
            'users_ratings_count' => ['numeric'],
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
