<?php

namespace App\Http\Requests\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class AdminStoreProjectRequest extends FormRequest
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

            'description' => ['required','array:en,ar,fr,ur,tr,sw','required_array_keys:en,ar,fr,ur,tr,sw'],

            'image' => ['required','image'],

            'status' => ['required','string','max:50'],
            'city' => ['required','string','max:50'],
            'type' => ['required','string','max:50'],
            'building_area' => ['numeric'],
            'investable_area' => ['numeric'],
            'number_of_podium_floors' => ['numeric'],
            'land_area' => ['numeric'],
            'units_count' => ['numeric'],
            'floors' => ['numeric'],
            'pdf_file' => ['required','mimes:pdf','max:100000'],
            'lat' => ['required','string','max:120'],
            'lng' => ['required','string','max:120'],
        ];
    }


    public function messages()
    {
        return [
            'image.image' => 'the image must be an image',
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
