<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Account_UpdateRequest extends FormRequest
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
            'name' => 'required',
            'is_parent' => 'required',
            'account_types_id' => 'required',
            'parent_account_number' => 'required_if:is_parent,0',
            'is_archived' => 'required',

        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'اسم الحساب مطلوب',
            'is_parent.required' => '  هل أب مطلوب',
            'account_types_id.required' => 'نوع الحساب مطلوب',
            'parent_account_number.required_if' => 'الحساب الأب مطلوب',
            'is_archived.required' => 'حالة التفعيل مطلوبة',

        ];
    }
}