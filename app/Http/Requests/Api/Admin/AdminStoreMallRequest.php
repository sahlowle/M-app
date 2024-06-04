<?php

namespace App\Http\Requests\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class AdminStoreMallRequest extends FormRequest
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
            'name' => ['required','array:en,ar,fr,ur,tr,sw'],

            'name.en' => ['required','string','max:190'],
            'name.ar' => ['required','string','max:190'],
            'name.fr' => ['required','string','max:190'],
            'name.ur' => ['required','string','max:190'],
            'name.tr' => ['required','string','max:190'],
            'name.sw' => ['required','string','max:190'],

            'mall_name' => ['required','array:en,ar,fr,ur,tr,sw'],

            'mall_name.en' => ['required','string','max:190'],
            'mall_name.ar' => ['required','string','max:190'],
            'mall_name.fr' => ['required','string','max:190'],
            'mall_name.ur' => ['required','string','max:190'],
            'mall_name.tr' => ['required','string','max:190'],
            'mall_name.sw' => ['required','string','max:190'],

            'category_id' => ['required','exists:categories,id'],
            'image' => ['required','image'],
            'description' => ['required','array:en,ar,fr,ur,tr,sw'],
            
            'description.en' => ['required','string','max:1000'],
            'description.ar' => ['required','string','max:1000'],
            'description.fr' => ['required','string','max:1000'],
            'description.ur' => ['required','string','max:1000'],
            'description.tr' => ['required','string','max:1000'],
            'description.sw' => ['required','string','max:1000'],

            'lat' => ['required','max:120'],
            'lng' => ['required','max:120'],
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
