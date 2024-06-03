<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Supplier_UpdateRequest extends FormRequest
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
            'active' => 'required',
            'suppliers_categories_id' => 'required',

        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'اسم المورد مطلوب',
            'active.required' => 'حالة التفعيل مطلوبة',
            'suppliers_categories_id.required' => ' فئــــة الموردين  مطلوبة',

        ];
    }
}