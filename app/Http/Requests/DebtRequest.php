<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DebtRequest extends FormRequest
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
            'bill_no' => 'required',
            'datebill' => 'required',
        ];
    }

    public function messages()
    {
        return [
            
            'bill_no.required' => 'กรุณาระบุเลขที่บิล',
            'datebill.required' => 'กรุณาระบุวันที่',
            
        ];
    }
}
