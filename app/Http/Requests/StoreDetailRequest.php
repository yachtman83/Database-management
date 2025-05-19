<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreDetailRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'weight' => ['required', 'numeric'],
            'material' => ['required', 'string'],
            'product_type_id' => ['required', 'exists:product_types,id']
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Название обязательно',
            'weight.numeric' => 'Вес должен быть числом',
            'product_type_id.exists' => 'Указанный тип продукта не существует',
        ];
    }

    /**
     * Формируем JSON-ответ, если валидация не прошла.
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => false,
            'errors' => $validator->errors()
        ], 422));
    }

}
