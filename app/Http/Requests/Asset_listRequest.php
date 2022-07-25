<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Asset_listRequest extends FormRequest
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
             // 'no_asset' => 'required',
             // 'name_thai' => 'required',
             // 'name_eng' => 'required',
             // 'groups' => 'required',
             // 'groups_acc' => 'required',
             // 'no_register' => 'required',
             // 'department' => 'required',
             // 'date_buy' => 'required',
             // 'date_startuse' => 'required',
             // 'price_buy' => 'required',
             // 'life_for_use' => 'required',
             // 'end_price_sell' => 'required'

             // 'date_sell' => 'required',
             // 'depreciation_sell' => 'required',
             // 'cal_date' => 'required'
             // 'profit_loss' => 'required',
             // 'primary_depreciation' => 'required'

         ];
     }

     public function messages()
     {
         return [
             // 'no_asset.required' => '!!! กรุณากรอกรหัสรหัสรายการทรัพย์สิน !!!',
             // 'name_thai.required' => '!!! กรุณากรอกชื่อรายการทรัพย์สิน (ภาษาไทย) !!!',
             // 'name_eng.required' => '!!! กรุณากรอกชื่อรายการทรัพย์สิน (ภาษาอังกฤษ) !!!',
             // 'groups.required' => '!!! กรุณาเลือกหมวด !!!',
             // 'groups_acc.required' => '!!! กรุณาเลือกกลุ่มบัญชี !!!',
             // 'no_register.required' => '!!! กรุณากรอกเลขทะเบียน !!!',
             // 'department.required' => '!!! กรุณากรอกแผนก !!!',
             // 'date_buy.required' => '!!! กรุณาเลือกวันที่ซื้อ !!!',
             // 'date_startuse.required' => '!!! กรุณาเลือกวันที่เริ่มใช้งาน !!!',
             // 'price_buy.required' => '!!! กรุณากรอกราคาทุน !!!',
             // 'life_for_use.required' => '!!! กรุณากรอกอายุการใช้งาน !!!',
             // 'end_price_sell.required' => '!!! กรุณากรอกราคาซาก !!!'

             // 'date_sell.required' => '!!! กรุณาเลือกวันที่ขาย !!!',
             // 'depreciation_sell.required' => '!!! กรุณากรอกราคาขาย !!!',
             // 'cal_date.required' => '!!! กรุณาเลือกคำนวณเองถึงวันที่ !!!'
             // 'profit_loss.required' => '!!! กรุณาเลือกเดบิต !!!',
             // 'primary_depreciation.required' => '!!! กรุณาเลือกเลขที่บัญชี - ชื่อบัญชี !!!'
         ];
     }
}
