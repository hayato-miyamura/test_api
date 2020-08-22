<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ValidatedRequest extends FormRequest
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
            'title' => 'required|string|max:100',
            'image' => 'required|image',
            'description' => 'required|string|max:500',
            'price' => 'required|integer'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response = response()->json([
            'status' => '400',
            'error' => $validator->errors(),
        ], 400);

        throw new HttpResponseException($response);
    }
}
