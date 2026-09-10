<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ItemRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'store_name' => 'nullable|string|max:255',
            'quantity' => 'required|integer|min:1|max:10',
            'user_id' => 'required|exists:users,id',
            'hurry_flag' => 'boolean',
            'complete_flag' => 'boolean',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '商品名は必須です',
            'name.string' => '商品名は文字列で入力してください',
            'name.max' => '商品名は255文字以内で入力してください',
            'store_name.string' => '買う場所の名前は文字列で入力してください',
            'store_name.max' => '買う場所の名前は255文字以内で入力してください',
            'quantity.required' => '個数を入力してください',
            'quantity.min' => '個数は1以上の数字を入力してください',
            'quantity.max' => '個数は10以下の数字を入力してください',
            'user_id.required' => '登録者情報がありません',
            'user_id.exists' => '存在しないユーザーです',
            'hurry_flag.in' => '0または1を入力してください',
            'complete_flag.in' => '0または1を入力してください',
        ];

    }
}
