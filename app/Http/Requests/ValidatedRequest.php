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
        $can_input_title = config('const.title');
        $can_input_description = config('const.description');
        $min_price = config('const.min_price');
        $max_price = config('const.max_price');

        return [
            'title' => "required|string|max:$can_input_title",
            'image' => 'required|image',
            'description' => "required|string|max:$can_input_description",
            'price' => "required|integer|between:$min_price,$max_price"
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
