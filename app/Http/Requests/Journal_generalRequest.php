<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Journal_generalRequest extends FormRequest
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
             // 'ingredient[0].branch' => 'required',
             // 'ingredient[0].datenow' => 'required|date',
             // 'ingredient[0].account' => 'required',
             // 'ingredient[0].debit' => 'required',
             // 'ingredient[0].credit' => 'required',
             // 'ingredient[0].memo' => 'required',
             // 'ingredient[0].name' => 'required',
         ];
     }

     public function messages()
     {
         return [
             // 'ingredient[0].branch.required' => '!!! กรุณาเลือกสาขา !!!',
             // 'ingredient[0].datenow.required' => '!!! กรุณาระบุวันที่ !!!',
             // 'ingredient[0].account.required' => '!!! กรุณาระบุเลขรหัสบัญชี !!!',
             // 'ingredient[0].debit.required' => '!!! กรุณาระบุเดบิต !!!',
             // 'ingredient[0].credit.required' => '!!! กรุณาระบุเครดิต !!!',
             // 'ingredient[0].memo.required' => '!!! กรุณาระบุคำอธิบายรายการย่อย !!!',
             // 'ingredient[0].name.required' => '!!! กรุณาระบุชื่อลูกค้า !!!',
         ];
     }
}
