<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Suppliers_with_ordeRequest extends FormRequest
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
            'supplier_code' => 'required',
            'bill_type' => 'required',
            'order_date' => 'required',
            'is_provide' => 'required',
            'store_id' => 'required',

        ];
    }

    public function messages()
    {
        return [
            'supplier_code.required' => 'اسم المورد مطلوب',
            'bill_type.required' => 'نوع الفاتورة مطلوب',
            'order_date.required' => 'تاريخ الفاتورة مطلوب',
            'is_provide.required' => 'حالة الإعتماد مطلوبة',
            'store_id.required' => 'اسم المخزن  مطلوب',

        ];
    }
}
