<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChequeRequest extends FormRequest
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
            'got_cheque' => 'required',
            'cheque_date' => 'required',
            'status' => 'required',
            'cheque_no' => 'required',
            'bank_cheque' => 'required',
            'branch' => 'required',
            'name' => 'required',
            'payer' => 'required',
            'price' => 'required',
            'notation' => 'required',
            
        ];
    }

    public function messages()
    {
        return [
            
            'got_cheque.required' => 'กรุณาระบุวันที่รับเช็ค',
            'cheque_date.required' => 'กรุณาระบุวันที่เช็ค',
            'status.required' => 'กรุณาระบุสถานะเช็ค',
            'cheque_no.required' => 'กรุณาระบุหมายเลขเช็ค',
            'bank_cheque.required' => 'กรุณาระบุธนาคาร',
            'branch.required' => 'กรุณาระบุสาขา',
            'name.required' => 'กรุณาระบุชื่อบัญชี',
            'payer.required' => 'กรุณาระบุผู้สั่งจ่าย',
            'price.required' => 'กรุณาระบุจำนวนเงิน',
            'notation.required' => 'กรุณาระบุหมายเหตุ',
            
        ];
    }
}
