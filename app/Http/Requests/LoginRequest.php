<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'user_name' => 'required',
            'email' => 'required',
            'password' => 'required',

        ];

    }

    public function messages()
    {
        return [
            'user_name.required' => 'اسم المستخدم مطلوب',
            'email.required' => ' إيميل المستخدم مطلوب',
            'password.required' =>'كلمة المرور مطلوبة',

        ];
    }
}