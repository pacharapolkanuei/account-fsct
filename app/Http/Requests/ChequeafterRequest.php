<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChequeafterRequest extends FormRequest
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
            'cheque_id' => 'required',
            'status' => 'required',
            'income_cheque' => 'required',
            'date_deposit' => 'required',
            'bank_recived' => 'required',
            'net' => 'required',
            'fee' => 'required',
            'date_check_pass' => 'required',
            'deposit_no' => 'required',
            'receipt_no' => 'required',
            
        ];
    }

    public function messages()
    {
        return [
            
            'cheque_id.required' => '',
            'status.required' => 'กรุณาระบุสถานะเช็ค',
            'income_cheque.required' => 'กรุณาระบุรายรับ',
            'date_deposit.required' => 'กรุณาระบุวันที่นำฝาก',
            'bank_recived.required' => 'กรุณาระบุธนาคาร',
            'net.required' => 'กรุณาระบุนอดเงินสุทธิ',
            'fee.required' => 'กรุณาระบุค่าธรรมเนียม',
            'date_check_pass.required' => 'กรุณาระบุวันที่เช็คผ่าน',
            'deposit_no.required' => 'กรุณาระบุหมายเลขที่นำฝาก',
            'receipt_no.required' => 'กรุณาระบุเลขที่ใบสำคัญรับ',
            
        ];
    }
}
