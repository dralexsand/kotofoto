<?php

namespace App\Http\Requests\Price;

use App\Rules\CheckSetPriceArrayRule;
use App\Rules\CheckSetPriceSizeRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class SetPriceRequest extends FormRequest
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
            "key" => ['required', 'string'],
            'data' => [
                'required',
                'nullable',
                'array',
                new CheckSetPriceSizeRule,
                new CheckSetPriceArrayRule,
            ],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors()->messages()['data'][7];

        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'errors' => $errors,
            ], 422)
        );
    }
}
