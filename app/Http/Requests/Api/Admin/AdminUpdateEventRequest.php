<?php

namespace App\Http\Requests\Api\Admin;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Http\Controllers\Controller;

class AdminUpdateEventRequest extends FormRequest
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
            'address' => ['nullable','array'],
            'lat' => ['nullable','max:120'],
            'lng' => ['nullable','max:120'],
            'event_time' => ['nullable','date_format:H:i:s'],
            'event_date' => ['nullable','date_format:Y-m-d'],
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
