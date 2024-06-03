<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Admin_Panel_Setting_Request extends FormRequest
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
            'system_name' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'active' => 'required',
            'com_code' => 'required',
            'customer_parent_account_number' => 'required',
            'supplier_parent_account_number' => 'required',

        ];
    }

    public function messages()
    {
        return [
            'system_name.required' => 'اسم الشركة مطلوب',
            'address.required' => 'عنوان الشركة مطلوب',
            'active.required' => 'حالة تفعيل الشركة مطلوبة',
            'com_code.required' => 'كود الشركة مطلوب',
            'phone.required' => 'هاتف الشركة مطلوب',
            'customer_parent_account_number.required' => '  رقم الحساب المالي للعملاء الأب مطلوب',
            'supplier_parent_account_number.required' => '  رقم الحساب المالي للموردين الأب مطلوب',

        ];
    }
}