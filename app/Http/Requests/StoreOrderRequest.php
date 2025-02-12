<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
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
            'customer_id' =>  ['required'],
            'product_id1' =>  ['required'],
            'product_id2' =>  [''],
            'product_id3' =>  [''],
            'num1' =>  ['required', 'integer'],
            'num2' =>  [''],
            'num3' =>  [''],
        ];
    }
}
