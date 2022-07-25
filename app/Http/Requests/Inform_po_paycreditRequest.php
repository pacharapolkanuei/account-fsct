<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Inform_po_paycreditRequest extends FormRequest
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
             'po' => 'required',
             'bill_no_withpaybill' => 'required',
             'date_picker_withpaybill' => 'required|date'
         ];
     }

     public function messages()
     {
         return [
             'branch.required' => '!!! กรุณาเลือกสาขา !!!',
             'type_po.required' => '!!! กรุณาเลือกประเภทการจ่ายเงิน !!!',
             'po.required' => '!!! กรุณาเลือกใบ PO !!!',
             'bill_no_withpaybill.required' => '!!! กรุณาระบุเลขที่ใบเสร็จรับเงิน !!!',
             'date_picker_withpaybill.required' => '!!! กรุณาระบุวันที่ตามใบเสร็จรับเงิน !!!'
         ];
     }
}
