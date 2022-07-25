<?php

namespace App\Http\Controllers;

use App\Cash;
use Illuminate\Http\Request;
use App\Branch;
use App\Accounttype;
use App\Http\Requests\CashRequest;
use Softon\SweetAlert\Facades\SWAL;

class PettycashController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cashs = Cash::paginate(100);
        $branchs = Branch::all();
        $accounttypes = Accounttype::all();
        // echo "<pre>";
        // print_r($accounttypes);
        // exit;

        foreach ($cashs as $key => $cash) {
            $branch_name = Branch::where('code_branch', $cash->branch_id)->first();
            if (empty($branch_name)) {
                // dump('hi this is null');
            }

            // $cash->branch_name = $branch_name->name_branch;
        }
        $date = "ทั้งหมด";

        return view('pettycash.pettycash_table', compact('cashs', 'date','branchs','accounttypes'));
    }

    public function show_somelist($date)
    {
        $cashs = Cash::where('time', 'like', '%' . $date . '%')->get();
        $branchs = Branch::all();
        $accounttypes = Accounttype::all();

        foreach ($cashs as $key => $cash) {
            $branch_name = Branch::where('code_branch', $cash->branch_id)->first();
            $cash->branch_name = $branch_name->name_branch;
        }

        return view('pettycash.pettycash_table', compact('cashs', 'date','branchs','accounttypes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CashRequest $request)
    {
        $cash = new Cash();
        $cash->grandtotal = $request->grandtotal;
        $cash->branch_id = $request->branch_id;
        $cash->time = $request->time;
        $cash->timeold = $request->timeold;
        $cash->note = "ยอดที่นำฝาก = ".$request->note;
        $cash->status = 99;
        $cash->codeemp = 30266;
        $arr = explode(',', $request->account);
        if( count($arr) == 2 ) {
            $cash->account_code = $arr[0];
            $cash->account_name = $arr[1];
        }

        $cash->save();
        SWAL::message('สำเร็จ','เพิ่มรายการเรียบร้อย','success',['timer'=>6000]);

        return redirect()->route('pettycash');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Cash  $cash
     * @return \Illuminate\Http\Response
     */
    public function show(Cash $cash)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Cash  $cash
     * @return \Illuminate\Http\Response
     */
    public function edit(Cash $cash)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cash  $cash
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $cash = Cash::find($id);
        $cash->grandtotal = $request->grandtotal;

        $cash->save();
        SWAL::message('สำเร็จ', 'แก้ไขเรียบร้อย!', 'success', ['timer' => 6000]);
        return redirect()->route('pettycash');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cash  $cash
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cash $cash)
    {
        //
    }
}
