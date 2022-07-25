<?php

namespace App\Http\Controllers;

use App\Ledger;
use Illuminate\Http\Request;
use App\Journal;
use App\Accounttype;
use App\Po_head;
use DB;
use Softon\SweetAlert\Facades\SWAL;

use App\Api\Connectdb;
use Session;
use App\Api\Datetime;
use Illuminate\Support\Facades\Input;
use phpDocumentor\Reflection\Types\Null_;
use Redirect;

class LedgerController extends Controller
{

    public function ledger_branch(){ //แยกประเภทบัญชี (รายสาขา)

        return view('ledger_branch');

    }

    public function ledger_allbranch(){ //แยกประเภทบัญชี (ทั้งหมด)

        return view('ledger_allbranch');

    }

    public function serachledger_branch(){ //แยกประเภทบัญชี (รายสาขา)

        $data = Input::all();
        $db = Connectdb::Databaseall();
        // echo "<pre>";
        // print_r($data);
        // exit;

        $datepicker = explode("-",trim(($data['reservation'])));

          // $start_date = $datepicker[0];
          $e1 = explode("/",trim(($datepicker[0])));
                  if(count($e1) > 0) {
                      $start_date = $e1[2] . '-' . $e1[0] . '-' . $e1[1]." 00:00:00"; //ปี - เดือน - วัน
                  }

          // $end_date = $datepicker[1];
          $e2 = explode("/",trim(($datepicker[1])));
                  if(count($e2) > 0) {
                      $end_date = $e2[2] . '-' . $e2[0] . '-' . $e2[1]." 23:59:59"; //ปี - เดือน - วัน
                  }

        $branch_id = $data['branch_id'];
        $acc_code = $data['acc_code'];

        //กรณี เพิ่มข้อมูลเล่มทั่วไป โดยไม่กดปิดบัญชี balance_forward_status = 0
        $sql = 'SELECT '.$db['fsctaccount'].'.ledger.*
                FROM '.$db['fsctaccount'].'.ledger

                WHERE '.$db['fsctaccount'].'.ledger.branch = '.$branch_id.'
                  AND '.$db['fsctaccount'].'.ledger.acc_code = '.$acc_code.'
                  AND '.$db['fsctaccount'].'.ledger.timestamp BETWEEN "'.$start_date.'" AND  "'.$end_date.'"
                  AND '.$db['fsctaccount'].'.ledger.balance_forward_status = 0
                  AND '.$db['fsctaccount'].'.ledger.status != 99
                  ';
        $datatresult = DB::connection('mysql')->select($sql);
        // echo "<pre>";
        // print_r($datatresult);
        // exit;

        return view('ledger_branch',[
          'data'=>$datatresult,
          'query'=>true,
          'datepicker'=>$data['reservation'],
          'branch_id'=>$branch_id,
          'accontcode'=>$acc_code,
        //   'datepicker2'=>$datetime
        ]);

    }


    public function serachledger_allbranch(){ //แยกประเภทบัญชี (ทั้งหมด)

        $data = Input::all();
        $db = Connectdb::Databaseall();
        // echo "<pre>";
        // print_r($data);
        // exit;

        $datepicker = explode("-",trim(($data['reservation'])));

          // $start_date = $datepicker[0];
          $e1 = explode("/",trim(($datepicker[0])));
                  if(count($e1) > 0) {
                      $start_date = $e1[2] . '-' . $e1[0] . '-' . $e1[1]." 00:00:00"; //ปี - เดือน - วัน
                  }

          // $end_date = $datepicker[1];
          $e2 = explode("/",trim(($datepicker[1])));
                  if(count($e2) > 0) {
                      $end_date = $e2[2] . '-' . $e2[0] . '-' . $e2[1]." 23:59:59"; //ปี - เดือน - วัน
                  }

        $acc_code = $data['acc_code'];

        //กรณี เพิ่มข้อมูลเล่มทั่วไป โดยไม่กดปิดบัญชี balance_forward_status = 0
        $sql = 'SELECT '.$db['fsctaccount'].'.ledger.*
                FROM '.$db['fsctaccount'].'.ledger

                WHERE '.$db['fsctaccount'].'.ledger.acc_code = '.$acc_code.'
                  AND '.$db['fsctaccount'].'.ledger.timestamp BETWEEN "'.$start_date.'" AND  "'.$end_date.'"
                  AND '.$db['fsctaccount'].'.ledger.balance_forward_status = 0
                  AND '.$db['fsctaccount'].'.ledger.status != 99
                  ';
        $datatresult = DB::connection('mysql')->select($sql);
        // echo "<pre>";
        // print_r($datatresult);
        // exit;

        return view('ledger_allbranch',[
          'data'=>$datatresult,
          'query'=>true,
          'datepicker'=>$data['reservation'],
          // 'branch_id'=>$branch_id,
          'accontcode'=>$acc_code,
        //   'datepicker2'=>$datetime
        ]);

    }


    public function reportledgercash(){ //แยกประเภท (เงินสด)

           return view('reportledgercash');
    }

    public function store(Request $request)
    {
        $count_list = $request->loop;
        $count_sublist = 5;
        $check_list = $request->check_list;
        // $test = $request->all();
        // dd($count_list);
        for ($i = 0; $i < $count_list; $i++) { //ลูป i วนตามจำนวนรายการ check box
            for ($j = 1; $j <= $count_sublist; $j++) { //ลูป J วนตามรายการย่อยในรายการใหญ่
                $journal = new Journal;
                $journal->module = $request->get('module' . $i);
                $journal->name_branch = $request->get('name_branch' . $i);
                $journal->datebill = $request->get('datebill' . $i);
                $journal->po_head = $request->get('po_head' . $i);

                $journal->list = $request->get('list' . $i . $j);
                $journal->accounttypeno = $request->get('accounttypeno' . $i . $j);
                $journal->total = $request->get('total' . $i . $j);
                $journal->DorC = $request->get('DorC' . $i . $j);

                if ($journal->list != NUll && in_array($journal->po_head, $check_list)) {  //แต่ละรายการมีจำนวนรายการไม่เท่ากัน อาจทำให้เป็น NULL จึงไม่บันทึกลง database
                    // dd($journal);
                    $journal->save();
                } else {
                    // dump('no');
                }
            }
            if (in_array($request->get('po_head' . $i), $check_list)) {
                $update_accept = DB::connection('mysql2')
                    ->table('inform_po_detail')
                    ->where('po_head', $request->get('po_head' . $i))
                    ->update(['accept' => 1]);
            }
        }



        return redirect('journal');
    }


    public function index()
    {
        $account_types = Accounttype::all();

        return view('ledger.ledger', compact('account_types'));
    }

    public function detail($id)
    {
        // echo "<pre>";
        // print_r($id);
        // exit;





        // $account_type = Accounttype::where('accounttypeno', $id)->first();
        //
        // $journal_1 = Journal::where('accounttypeno', $id)->get();
        // $po_head = [];
        // foreach ($journal_1 as $key => $journal) {
        //     $po_head[$key] = $journal->po_head;
        //     $DorC = $journal->DorC;
        // }
        // if (count($journal_1) > 0) {
        //     $journals = Journal::whereIn('po_head', $po_head)
        //         ->where('DorC', '!=', $DorC)
        //         ->get();
        //     $count = count($journals);
        // }else{
        //
        //     SWAL::message('!Oops','บัญชีนี้ยังไม่มีข้อมูล','warning');
        //     return redirect()->route('ledger');
        // }
        //
        //
        // for ($i = 0; $i < count($journals); $i++) {
        //     $dis = Journal::where('po_head', $journals[$i]->po_head)->get();
        //     foreach ($dis as $key => $dis) {
        //         if ($id != $dis->accounttypeno && $journals[$i]->accounttypeno != $dis->accounttypeno && $journals[$i]->DorC == 1) {
        //             // ผลรวมลบค่าที่เหลือยกเว้นตัวเอง เช่น เมื่อเรียกบัญชีเงินสด บัญชีเงินฝากเป็นต้น
        //             if ($dis->DorC != $journals[$i]->DorC) {
        //                 $journals[$i]->total = $journals[$i]->total - $dis->total;
        //             } else {
        //                 $journals[$i]->total = $journals[$i]->total + $dis->total;
        //             }
        //         }
        //     }
        //     // foreach ($dis as $key => $dis) {
        //     //     if ($id != $dis->accounttypeno && $journals[$i]->accounttypeno != $dis->accounttypeno && $journals[$i]->DorC == 1) {
        //     //         // ผลรวมลบค่าที่เหลือยกเว้นตัวเอง เช่น เมื่อเรียกบัญชีเงินสด บัญชีเงินฝากเป็นต้น
        //     //         $journals[$i]->total = $journals[$i]->total - $dis->total;
        //     //     }
        //     // }
        // }

        // dd($account_type);

        return view('reportledgercash',[
          'id'=>$id
          // 'datepicker'=>$data['reservation'],
          // 'branch_id'=>$branch_id
        ]);

        // return view('ledger.ledger_detail', compact('journals', 'account_type'));
    }


    public function serachreportledgercash(){ //แยกประเภท (เงินสด)

        $data = Input::all();
        $db = Connectdb::Databaseall();
        echo "<pre>";
        print_r($data);
        exit;

        $branch_id = $data['branch_id'];

        // $sql = 'SELECT '.$db['fsctaccount'].'.ledger.*
        //         FROM '.$db['fsctaccount'].'.ledger

        //         WHERE '.$db['fsctaccount'].'.ledger.branch_id = '.$branch_id.'
        //           AND '.$db['fsctaccount'].'.ledger.acc_code =  IN (1)
        //           AND '.$db['fsctaccount'].'.ledger.status_head NOT IN (99)
        //           ';
        // $datatresult = DB::connection('mysql')->select($sql);
        // echo "<pre>";
        // print_r($datatresult);
        // exit;

        return view('reportaccruedall',[
          'data'=>$datatresult,
          'query'=>true,
        //   'datepicker'=>$data['datepicker'],
          'branch_id'=>$branch_id,
        //   'datepicker2'=>$datetime
        ]);

    }















































}
