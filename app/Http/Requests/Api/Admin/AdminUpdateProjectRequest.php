<?php

namespace App\Http\Requests\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class AdminUpdateProjectRequest extends FormRequest
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
            'name' => ['array:en,ar,fr,ur,tr,sw','required_array_keys:en,ar,fr,ur,tr,sw'],

            'description' => ['array:en,ar,fr,ur,tr,sw','required_array_keys:en,ar,fr,ur,tr,sw'],
            
            'image' => ['image'],

            'type' => ['string','max:50'],

            'status' => ['string','max:50'],
            'city' => ['string','max:50'],
            'building_area' => ['numeric',],
            'land_area' => ['numeric',],
            'units_count' => ['numeric',],
            'floors' => ['numeric',],
            'pdf_file' => ['mimes:pdf','max:100000'],
            'lat' => ['string','max:120'],
            'lng' => ['string','max:120'],
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
