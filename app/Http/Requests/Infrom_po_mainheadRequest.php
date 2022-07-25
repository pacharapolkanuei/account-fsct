<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Infrom_po_mainheadRequest extends FormRequest
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
             'branch' => 'required',
             'type_po' => 'required',
             // 'bank' => 'required',
             'po' => 'required',
             'bill_no_withtax' => 'required',
             'date_picker_withtax' => 'required|date',
             'bill_no_withpaybill' => 'required',
             'date_picker_withpaybill' => 'required|date'
             // 'sum_discount' => 'required'
         ];
     }

     public function messages()
     {
         return [
             'branch.required' => '!!! กรุณาเลือกสาขา !!!',
             'type_po.required' => '!!! กรุณาเลือกประเภทการจ่ายเงิน !!!',
             // 'bank.required' => '!!! กรุณาเลือกธนาคาร !!!',
             'po.required' => '!!! กรุณาเลือกใบ PO !!!',
             'bill_no_withtax.required' => '!!! กรุณาระบุเลขที่ใบกำกับภาษี !!!',
             'date_picker_withtax.required' => '!!! กรุณาระบุวันที่ตามใบกำกับภาษี่ !!!',
             'bill_no_withpaybill.required' => '!!! กรุณาระบุเลขที่ใบเสร็จรับเงิน !!!',
             'date_picker_withpaybill.required' => '!!! กรุณาระบุวันที่ตามใบเสร็จรับเงิน !!!'
             // 'sum_discount.required' => '!!! กรุณากรอกส่วนลด !!!'
         ];
     }
}
