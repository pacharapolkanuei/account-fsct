<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Inform_po_headRequest extends FormRequest
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
             'bill_no' => 'required',
             'date_picker' => 'required|date',
         ];
     }

     public function messages()
     {
         return [
             'branch.required' => '!!! กรุณาเลือกสาขา !!!',
             'type_po.required' => '!!! กรุณาเลือกประเภทการจ่ายเงิน !!!',
             'po.required' => '!!! กรุณาเลือกใบ PO !!!',
             'bill_no.required' => '!!! กรุณาระบุเลขที่บิล !!!',
             'date_picker.required' => '!!! กรุณาระบุวันที่ !!!',
         ];
     }
}
