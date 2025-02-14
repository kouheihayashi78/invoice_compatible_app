<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderRequest extends FormRequest
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
            'customer_id' =>  ['required', 'integer', 'exists:customers,customer_id'],
            'product_id1' =>  ['required', 'integer', 'exists:products,product_id'],
            'num1' =>  ['required', 'integer', 'max:20', 'min:1'],
            'product_id2' =>  ['nullable', 'integer', 'exists:products,product_id'],
            'num2' =>  ['nullable', 'required_with:product_id2', 'integer', 'max:20', 'min:1'],
            'product_id3' =>  ['nullable', 'integer', 'exists:products,product_id'],
            'num3' =>  ['nullable', 'required_with:product_id3', 'integer', 'max:20', 'min:1'],
        ];
    }
}
