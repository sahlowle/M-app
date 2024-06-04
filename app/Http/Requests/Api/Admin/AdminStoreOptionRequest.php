<?php

namespace App\Http\Requests\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class AdminStoreOptionRequest extends FormRequest
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
            'hotel_id' => ['required','exists:hotels,id'],
            'name' => ['required','array:en,ar,fr,ur,tr,sw'],
            
            'name.en' => ['required','string','max:190'],
            'name.ar' => ['required','string','max:190'],
            'name.fr' => ['required','string','max:190'],
            'name.ur' => ['required','string','max:190'],
            'name.tr' => ['required','string','max:190'],
            'name.sw' => ['required','string','max:190'],

            'image' => ['required','image'],
            'total_count' => ['required','numeric'],
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
