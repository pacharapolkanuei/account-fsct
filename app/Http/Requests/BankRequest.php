<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BankRequest extends FormRequest
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
            'no' => 'required',
            'name' => 'required',
            'initials' => 'required',
            'accounttype_no' => 'required',
            'branch_id' => 'required',
            
        ];
    }

    public function messages()
    {
        return [
            
            'no.required' => 'กรุณาระบุเลขบัญชี',
            'name.required' => 'กรุณาระบุชื่อบัญชี',
            'initials.required' => 'กรุณาระบุชื่อย่อ',
            'accounttype_no.required' => 'กรุณาระบุรหัสบัญชี',
            'branch_id.required' => 'กรุณาระบุสาขา',
            
        ];
    }
}
