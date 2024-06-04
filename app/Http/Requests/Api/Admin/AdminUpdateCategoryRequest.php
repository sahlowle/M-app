<?php

namespace App\Http\Requests\Api\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class AdminUpdateCategoryRequest extends FormRequest
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
            'name' => ['array','required_array_keys:en,ar,fr,ur,tr,sw'],
            
            // 'name.en' => ['required_with:name','string','max:190'],
            // 'name.ar' => ['string','max:190'],
            // 'name.fr' => ['string','max:190'],
            // 'name.ur' => ['string','max:190'],
            // 'name.tr' => ['string','max:190'],
            // 'name.sw' => ['string','max:190'],

            // 'image' => ['image'],
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
