<?php

namespace App\Http\Requests\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class AdminStoreRestaurantRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['required','array:en,ar,fr,ur,tr,sw','required_array_keys:en,ar,fr,ur,tr,sw'],
            'mall_name' => ['required','array:en,ar,fr,ur,tr,sw'],
            'description' => ['required','array:en,ar,fr,ur,tr,sw','required_array_keys:en,ar,fr,ur,tr,sw'],

            'category_id' => ['required','exists:categories,id'],
            'image' => ['required','image'],

            'lat' => ['string','max:120'],
            'lng' => ['string','max:120'],
            'map_url' => ['string','max:1024'],
            'address' => ['required','string','max:190'],
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
