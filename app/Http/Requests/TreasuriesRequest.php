<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TreasuriesRequest extends FormRequest
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
            'is_master' => 'required',
            'com_code' => 'required',
            'last_isal_exchange' => 'required',
            'last_isal_collect' => 'required',
            'active' => 'required',

        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'اسم الخزانة مطلوب',
            'is_master.required' => ' نوع الخزانة مطلوب',
            'com_code.required' => 'كود الشركة مطلوب',
            'last_isal_exchange.required' => 'اخر ايصال الصرف مطلوب',
            'last_isal_collect.required' => 'اخر ايصال التحصيل مطلوب',
            'active.required' => 'حالة الخزانة مطلوبة',

        ];
    }
}
