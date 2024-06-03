<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AccountRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'is_parent' => 'required',
            'account_types_id' => 'required',
            'parent_account_number' => 'required_if:is_parent,0',
            'start_balance_status' => 'required',
            'start_balance' => 'required|min:0',
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
            'start_balance_status.required' => 'حالة رصيد الأولي مطلوب',
            'start_balance.required' => ' الرصيد الأولي مطلوب',
            'is_archived.required' => 'حالة التفعيل مطلوبة',

        ];
    }
}