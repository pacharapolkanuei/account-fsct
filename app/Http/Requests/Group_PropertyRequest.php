<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Group_PropertyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
     public function rules()
     {
         return [
             'no_group' => 'required',
             'des_thai' => 'required',
             'des_eng' => 'required',
             'acc_code' => 'required',
             'debit' => 'required',
             'credit' => 'required'
         ];
     }

     public function messages()
     {
         return [
             'no_group.required' => '!!! กรุณากรอกรหัสกลุ่มบัญชีทรัพย์สิน !!!',
             'des_thai.required' => '!!! กรุณากรอกำอธิบาย (ภาษาไทย) !!!',
             'des_eng.required' => '!!! กรุณาคำอธิบาย (ภาษาอังกฤษ) !!!',
             'acc_code.required' => '!!! กรุณาเลือกเลขที่บัญชี - ชื่อบัญชี !!!',
             'debit.required' => '!!! กรุณาเลือกเดบิต !!!',
             'credit.required' => '!!! กรุณาเลือกเครดิต !!!'
         ];
     }
}
