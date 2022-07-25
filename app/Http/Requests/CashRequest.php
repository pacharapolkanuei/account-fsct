<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CashRequest extends FormRequest
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
            'grandtotal' => 'required',
            'branch_id' => 'required',
            'time' => 'required',
            'timeold' => 'required',
            'note' => 'required',
            'account' => 'required',
        ];
    }
    public function messages()
    {
        return [
            
            'grandtotal.required' => 'กรุณาระบุวงเงิน',
            'branch_id.required' => 'กรุณาระบุสาขา',
            'time.required' => 'กรุณาระบุวันที่',
            'timeold.required' => 'กรุณาระบุวันที่นำเงินฝาก',
            'note.required' => 'กรุณาระบุหมายเหตุ',
            'account.required' => 'กรุณาระบุรหัสบัญชี',
            
        ];
    }
}
