<?php

namespace App\Http\Controllers;

use PDF;
use DB;
use App\Cheque;
use App\Cheque_after;
use Illuminate\Http\Request;
use App\Branch;
use App\Bank;
use App\Accounttype;
use App\Http\Requests\ChequeRequest;
use App\Http\Requests\ChequeafterRequest;
use Softon\SweetAlert\Facades\SWAL;

class ChequeController extends Controller
{

    public function index()
    {

        // $cheques = Cheque::all();
        $cheques = DB::connection('mysql2')
            ->table('cheque')
            ->leftJoin('cheque_after', 'cheque.id', '=', 'cheque_after.id_cheque')
            ->select(
                'cheque.id',
                'cheque.got_cheque',
                'cheque.cheque_no',
                'cheque.name',
                'cheque.price',
                'cheque.status',
                'cheque.notation',
                'cheque.cheque_date',
                'cheque_after.fee',
                'cheque_after.net',
                'cheque_after.bank_recived',
                'cheque_after.date_deposit',
                'cheque_after.bank_recived',
                'cheque_after.date_check_pass',
                'cheque_after.deposit_no',
                'cheque_after.receipt_no'
            )
            ->get();

        $banks = Bank::get();

        $moneybanks = Accounttype::where('config_group_supp_id',1)
                                  ->where('accounttypefull', 'like' , '%' . "เงินฝากออมทรัพย์" . '%' )
                                  ->get();

        // dd($banks);

        return view('cheque.cheque', compact('cheques', 'banks' , 'moneybanks'));
    }

    public function show($id)
    {
        $cheque = Cheque::find($id);
        // dd($cheque);
        return view('cheque.cheque_detail', compact('cheque'));
    }

    public function edit(Request $request, $id)
    {

        $cheque = Cheque::find($id);
        $cheque->got_cheque = $request->got_cheque;
        $cheque->cheque_date = $request->cheque_date;
        $cheque->status = $request->status;
        $cheque->cheque_no = $request->cheque_no;
        $cheque->bank_cheque = $request->bank_cheque;
        $cheque->branch = $request->branch;
        $cheque->name = $request->name;
        $cheque->payer = $request->payer;
        $cheque->price = $request->price;
        $cheque->notation = $request->notation;

        $cheque->update();
        return redirect()->route('cheque');
    }

    public function store(ChequeRequest $request)
    {
        $cheque = new Cheque();
        $cheque->got_cheque = $request->got_cheque;
        $cheque->cheque_date = $request->cheque_date;
        $cheque->status = $request->status;
        $cheque->cheque_no = $request->cheque_no;
        $cheque->bank_cheque = $request->bank_cheque;
        $cheque->branch = $request->branch;
        $cheque->name = $request->name;
        $cheque->payer = $request->payer;
        $cheque->price = $request->price;
        $cheque->notation = $request->notation;

        // dd($cheque);
        if ($request->hasFile('pic')) {
            $image_filename = $request->file('pic')->getClientOriginalName();
            $image_name = date("Ymd-His-") . $image_filename;
            $public_path = 'images/cheque/';
            $destination = base_path() . "/public/" . $public_path;
            $request->file('pic')->move($destination, $image_name);
            $cheque->pic = $public_path . $image_name;
        }
        $cheque->save();
        SWAL::message('สำเร็จ','เพิ่มการรับเช็ค','success',['timer'=>6000]);

        return redirect()->route('cheque');
    }
    public function pdf()
    {
        $cheque = Cheque::all();
        $pdf = PDF::loadView('cheque.chequepdf', ['cheque' => $cheque]);
        return @$pdf->stream();
    }

    public function update_status(ChequeafterRequest $request)
    {
        $cheque_aftet = Cheque_after::where('id_cheque', $request->cheque_id)->first();
        // dd($cheque_aftet);
        if ($cheque_aftet == NULL) {
            // dd('empty');
            $cheque_aftet = new Cheque_after();
            $cheque_aftet->id_cheque = $request->cheque_id;
            $cheque_aftet->status = $request->status;
            $cheque_aftet->income_cheque = $request->income_cheque;
            $cheque_aftet->date_deposit = $request->date_deposit;
            $cheque_aftet->bank_recived = $request->bank_recived;
            $cheque_aftet->net = $request->net;
            $cheque_aftet->fee = $request->fee;
            $cheque_aftet->date_check_pass = $request->date_check_pass;
            $cheque_aftet->deposit_no = $request->deposit_no;
            $cheque_aftet->receipt_no = $request->receipt_no;
            $cheque_aftet->save();
        }else{
            // dd('no empty');
            $cheque_aftet->id_cheque = $request->cheque_id;
            $cheque_aftet->status = $request->status;
            $cheque_aftet->income_cheque = $request->income_cheque;
            $cheque_aftet->date_deposit = $request->date_deposit;
            $cheque_aftet->bank_recived = $request->bank_recived;
            $cheque_aftet->net = $request->net;
            $cheque_aftet->fee = $request->fee;
            $cheque_aftet->date_check_pass = $request->date_check_pass;
            $cheque_aftet->deposit_no = $request->deposit_no;
            $cheque_aftet->receipt_no = $request->receipt_no;
            $cheque_aftet->update();
        }

        $cheque = Cheque::find($request->cheque_id);
        $cheque->status = $request->status;
        $cheque->update();
        SWAL::message('สำเร็จ','อัพเดทสถานะเช็ค','success',['timer'=>6000]);

        return redirect()->route('cheque');
    }
}
