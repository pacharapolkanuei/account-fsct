<?php

namespace App\Http\Controllers;

use App\Bank;
use Illuminate\Http\Request;
use Softon\SweetAlert\Facades\SWAL;
use App\Branch;
use App\Accounttype;
use App\Http\Requests\BankRequest;


class BankController extends Controller
{
    
    public function index()
    {   
        $banks = Bank::get();
        $branchs = Branch::all();
        $accounttypes = Accounttype::all();
        

        return view('bank.bank_detail',compact('banks','branchs','accounttypes'));
    }

    
    public function store(BankRequest $request)
    {
        $bank = new Bank;
        $bank->account_no = $request->no;
        $bank->account_name = $request->name;
        $bank->notation = $request->notation;
        $bank->initials = $request->initials;
        $bank->accounttype_no = $request->accounttype_no;
        $bank->branch_id = $request->branch_id;
        $bank->status = $request->status;
        
        $bank->save();
        SWAL::message('สำเร็จ','เพิ่มรายการเรียบร้อย','success',['timer'=>6000]);
        
        return redirect()->route('bank.detail');
    }   

    public function update(BankRequest $request,$id)
    {
        $bank = Bank::find($id);        
        $bank->account_no = $request->no;        
        $bank->account_name = $request->name;
        $bank->notation = $request->notation;
        $bank->initials = $request->initials;
        $bank->accounttype_no = $request->accounttype_no;
        $bank->branch_id = $request->branch_id;
        $bank->status = $request->status;

        

        $bank->update();
        SWAL::message('สำเร็จ', 'แก้ไขเรียบร้อย!', 'success', ['timer' => 6000]);
        return redirect()->route('bank.detail'); 
       
    }

    
    public function delete($id)
    {   
        $bank = Bank::find($id);
        
        if ($bank != null) {
            $bank->status_use = 99;
            $bank->update();
            return redirect()->route('bank.detail');
        
        }
        
    }
}
