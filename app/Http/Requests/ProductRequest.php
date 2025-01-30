<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            // 配列にルールを指定するか、ルールを|で区切るかは公式を見る限り多分自由
            "name" => ['required', 'string', 'min:2', 'max:15'],
            "code" => ['required', 'string', 'min:4', 'max:4'],
            "price" => ['required', 'integer', 'min:100', 'max:100000'],
            "tax" => ['required', 'integer']
        ];
    }
}
