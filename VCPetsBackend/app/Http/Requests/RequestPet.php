<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;
use App\Enums\StatusesPets;
use Illuminate\Validation\Rules\Enum;

class RequestPet extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
           'name' => 'required|max:32',
           'photoUrls' => 'required',
           'status' => [new Enum(StatusesPets::class)]
        ];
    }

    public function messages(){
        return [
            'name.required' => 'The Field Name Is Required',
            'photoUrls.required' => 'The Field Photo Urls Is Required'
        ];
    }

    protected function failedValidation(Validator $validator){
        $errors = (new ValidationException($validator))->errors();
        throw new HttpResponseException(
            response()->json( 
                ['message' => 'Validation exception',
                'errors' => $errors ], 405
            )
        );
    }
}