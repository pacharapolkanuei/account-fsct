<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use App\Http\Requests\Journal_generalRequest;
use DB;
use App\Branch;
use App\Type_journal;
use App\Journal_5;
use App\Journalgeneraldetail;
use App\Ledger;
use App\Accounttype;
use App\Api\Connectdb;
use Illuminate\Support\Facades\Input;
use Softon\SweetAlert\Facades\SWAL;
use App\Api\Datetime;
use App\Imports\GeneralImports;
use Maatwebsite\Excel\Facades\Excel;

class JournalGeneralController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

      public function index()
      {
          $type_journals = new Type_journal;
          $type_journals->setConnection('mysql2');
          $type_journals = Type_journal::where('statususe','=',1)
                        ->get();

          $accounttypes = new Accounttype;
          $accounttypes->setConnection('mysql2');
          $accounttypes = Accounttype::where('status','=',1)
                        ->get();

          // $general = DB::connection('mysql2')
          //     ->table('in_debt')
          //     ->join('po_detail', 'in_debt.id_po', '=', 'po_detail.po_headid')
          //     ->join('good', 'good.id', '=', 'po_detail.materialid')
          //     ->join('accounttype', 'accounttype.id', '=', 'good.accounttype')
          //     ->orderBy('number_debt', 'asc')
          //     ->get();

          $branchs = new Branch;
          $branchs = Branch::where('status_main',1)->get();

          $connect1 = Connectdb::Databaseall();
          $baseAc1 = $connect1['fsctaccount'];
          $baseHr1 = $connect1['hr_base'];

          $sql1 = "SELECT $baseAc1.journal_5.*
                                          ,journal_5.id as id_journal_5
                                          ,branch.code_branch
                                          ,branch.name_branch
                                          ,accounttype.accounttypeno
                                          ,accounttype.accounttypefull
                                          ,accounttype.status
                                          ,journalgeneral_detail.debit
                                          ,journalgeneral_detail.credit
                                          ,journalgeneral_detail.list
                                          ,journalgeneral_detail.name_suplier

                          FROM $baseAc1.journal_5

                          INNER JOIN $baseAc1.journalgeneral_detail
                          ON $baseAc1.journal_5.id = $baseAc1.journalgeneral_detail.id_journalgeneral_head

                          INNER JOIN $baseHr1.branch
                          ON $baseAc1.journal_5.code_branch = $baseHr1.branch.code_branch

                          INNER JOIN $baseAc1.accounttype
                          ON $baseAc1.journalgeneral_detail.accounttype = $baseAc1.accounttype.id

                          WHERE $baseAc1.journalgeneral_detail.status IN ('1') AND journal_5.type_module = 5 AND journal_5.accept = 0
                          ORDER BY number_bill_journal ASC";
            // exit;
            $inform_get_edits = DB::select($sql1);
            $ap = 'default';

          return view('journal.journal_general', compact( 'inform_get_edits' , 'ap', 'branchs' , 'accounttypes' , 'type_journals'));
      }

      public function getaccountname(){
          $connect1 = Connectdb::Databaseall();
          $baseAc1 = $connect1['fsctaccount'];

          $sql1 = "SELECT * FROM $baseAc1.accounttype
                   WHERE $baseAc1.accounttype.status = 1";

          $getdatas = DB::select($sql1);
          return $getdatas;
      }

      public function getbranch($id){
          $connect1 = Connectdb::Databaseall();
          $baseAc1 = $connect1['fsctaccount'];

          $sql1 = "SELECT $baseAc1.accounttype FROM $baseAc1.accounttype
                   WHERE $baseAc1.accounttype.status = 1";

          $getdatas = DB::select($sql1);
          return $getdatas;

      }

      public function store(Journal_generalRequest $request)
      {
       // $code_branch = $request->get('branch');
       //
       // $count = DB::connection('mysql2')
       //              ->table('journal_5')
       //              ->where('code_branch', '=', $code_branch)
       //              ->groupBy('number_run_lastbill')
       //              ->get();
       // $count_journal_general = count($count)+1;
       //
       //  $datebill = $request->get('datenow');
       //  $gettype_module = $request->get('type_module');
       //  $debit = $request->get('debit');
       //  $credit = $request->get('credit');
       //  $list = $request->get('memo');
       //  $name_supplier = $request->get('name');
       //  $accounttypeno = $request->get('account');
       //
       //  for ($i=0; $i < count($accounttypeno); $i++) {
       //      $journal_generals = new Journal_5;
       //      $journal_generals->setConnection('mysql2');
       //      $journal_generals->code_branch = $code_branch;
       //      $journal_generals->type_module = $gettype_module;
       //      for ($j=1001; $j <= 1050 ; $j++) {
       //        if ($code_branch == $j) {
       //          $journal_generals->number_bill_journal = "JG" . $j . date("ym") . sprintf('%04d', $count_journal_general);
       //        }
       //      }
       //      $journal_generals->datebill = $datebill;
       //      $journal_generals->accounttypeno = $accounttypeno[$i];
       //      $journal_generals->debit = $debit[$i];
       //      $journal_generals->credit = $credit[$i];
       //      $journal_generals->list = $list[$i];
       //      $journal_generals->name_supplier = $name_supplier[$i];
       //      $journal_generals->number_run_lastbill = $count_journal_general;
       //      $journal_generals->save();
            $code_branch = $request->get('branch');

            $count = DB::connection('mysql2')
                         ->table('journal_5')
                         ->where('code_branch', '=', $code_branch)
                         ->get();
            $count_journal_general = count($count);

            $datebill = $request->get('datenow');
            $gettype_module = $request->get('type_module');
            $debit = $request->get('debit');
            $totaldebit = $request->get('totaldebit');
            $credit = $request->get('credit');
            $list = $request->get('memo');
            $name_supplier = $request->get('name');
            $accounttypeno = $request->get('account');


            if ($request->get('check_bankclose')) {
              $check_bankclose = $request->get('check_bankclose');
            }
            else {
              $check_bankclose = 0;
            }


            $journal_generals = new Journal_5;
            $journal_generals->setConnection('mysql2');
            $journal_generals->code_branch = $code_branch;
            $journal_generals->type_module = $gettype_module;
            $journal_generals->datebill = $datebill;
            $journal_generals->totalsum = $totaldebit;
            $journal_generals->balance_forward_status = $check_bankclose;

            for ($j=1001; $j <= 1050 ; $j++) {
              if ($code_branch == $j) {
                $journal_generals->number_bill_journal = "JG" . $j . date("ym") . sprintf('%04d', $count_journal_general);
              }
            }
            $journal_generals->save();

            $count_id = Journal_5::max('id');

            if ($request->get('fileexcel')) {
              Excel::import(new GeneralImports,request()->file('fileexcel'));
            }
            else {
              for ($i=0; $i < count($accounttypeno); $i++) {
                $journal_generals_detail = new Journalgeneraldetail;
                $journal_generals_detail->setConnection('mysql2');
                $journal_generals_detail->id_journalgeneral_head = $count_id;
                $journal_generals_detail->accounttype = $accounttypeno[$i];
                $journal_generals_detail->debit = $debit[$i];
                $journal_generals_detail->credit = $credit[$i];
                $journal_generals_detail->list = $list[$i];
                $journal_generals_detail->name_suplier = $name_supplier[$i];
                $journal_generals_detail->save();
              }
            }

        //}
        SWAL::message('สำเร็จ', 'บันทึกสมุดรายวันทั่วไปแล้ว!', 'success', ['timer' => 6000]);
        return redirect()->route('journal.general');
      }




      public function import()
    {
        Excel::import(new BulkImport,request()->file('file'));

        return back();
    }





      public function journalgeneral_filter(Request $request)
      {
          // $connect1 = Connectdb::Databaseall();
          // $baseAc1 = $connect1['fsctaccount'];
          // $baseHr1 = $connect1['hr_base'];
          $type_journals = new Type_journal;
          $type_journals->setConnection('mysql2');
          $type_journals = Type_journal::where('statususe','=',1)
                        ->get();

          $accounttypes = new Accounttype;
          $accounttypes->setConnection('mysql2');
          $accounttypes = Accounttype::where('status','=',1)
                        ->get();

          $branchs = new Branch;
          $branchs = Branch::get();

          $date = $request->get('daterange');
          $branch = $request->get('branch_search');

          $dateset = Datetime::convertStartToEnd($date);
          $start = $dateset['start'];
          $end = $dateset['end'];

          if (!empty($branch)) {
            $inform_get_edits = DB::connection('mysql2')
                    ->table('journal_5')
                    ->select('accounttype.accounttypeno','journal_5.number_bill_journal','journal_5.accept','journal_5.id as id_journal_5'
                    ,'journal_5.datebill','journalgeneral_detail.debit','journalgeneral_detail.credit','journalgeneral_detail.name_suplier','journalgeneral_detail.list'
                    ,'accounttype.accounttypefull','journal_5.code_branch','journal_5.totalsum')
                    ->join('journalgeneral_detail', 'journalgeneral_detail.id_journalgeneral_head', '=', 'journal_5.id')
                    ->join('accounttype', 'accounttype.id', '=', 'journalgeneral_detail.accounttype')
                    ->orderBy('journal_5.number_bill_journal', 'asc')
                    ->whereBetween('journal_5.datebill', [$start, $end])
                    ->where('journal_5.code_branch', $branch)
                    ->get();
          }
          else {
            $inform_get_edits = DB::connection('mysql2')
                    ->table('journal_5')
                    ->select('accounttype.accounttypeno','journal_5.number_bill_journal','journal_5.accept','journal_5.id as id_journal_5'
                    ,'journal_5.datebill','journalgeneral_detail.debit','journalgeneral_detail.credit','journalgeneral_detail.name_suplier','journalgeneral_detail.list'
                    ,'accounttype.accounttypefull','journal_5.code_branch','journal_5.totalsum')
                    ->join('journalgeneral_detail', 'journalgeneral_detail.id_journalgeneral_head', '=', 'journal_5.id')
                    ->join('accounttype', 'accounttype.id', '=', 'journalgeneral_detail.accounttype')
                    ->orderBy('journal_5.number_bill_journal', 'asc')
                    ->whereBetween('journal_5.datebill', [$start, $end])
                    ->get();
          }

          $ap = 'default';

          // if ($branch != '0') {
          //   $sql1 = "SELECT $baseAc1.journal_5.*
          //                                   ,branch.code_branch
          //                                   ,branch.name_branch
          //                                   ,accounttype.accounttypeno
          //                                   ,accounttype.accounttypefull
          //                                   ,accounttype.status
          //
          //                   FROM $baseAc1.journal_5
          //
          //                   INNER JOIN $baseHr1.branch
          //                   ON $baseAc1.journal_5.code_branch = $baseHr1.branch.code_branch
          //
          //                   INNER JOIN $baseAc1.accounttype
          //                   ON $baseAc1.journal_5.accounttypeno = $baseAc1.accounttype.id
          //
          //                   WHERE $baseAc1.journal_5.datebill BETWEEN $start AND  $end
          //                   AND $baseAc1.journal_5.status IN ('1') ORDER BY id ASC";
          //
          //   $inform_get_edits = DB::select($sql1);
          // }
          // else {
          //   $sql1 = "SELECT $baseAc1.journal_5.*
          //                                   ,branch.code_branch
          //                                   ,branch.name_branch
          //                                   ,accounttype.accounttypeno
          //                                   ,accounttype.accounttypefull
          //                                   ,accounttype.status
          //
          //                   FROM $baseAc1.journal_5
          //
          //                   INNER JOIN $baseHr1.branch
          //                   ON $baseAc1.journal_5.code_branch = $baseHr1.branch.code_branch
          //
          //                   INNER JOIN $baseAc1.accounttype
          //                   ON $baseAc1.journal_5.accounttypeno = $baseAc1.accounttype.id
          //
          //                   WHERE $baseAc1.journal_5.datebill BETWEEN $start AND  $end
          //                   AND $baseAc1.journal_5.status IN ('1') ORDER BY id ASC";
          //
          //   $inform_get_edits = DB::select($sql1);
          // }
          // $ap = 'default';
          //
          // return view('journal.journal_general', compact('inform_get_edits', 'ap', 'branchs'));


          // if ($branch != '0') {
          //     $inform_get_edits = DB::connection('mysql2')
          //         ->table('journal_5')
          //         ->join('accounttype', 'accounttype.id', '=', 'journal_5.accounttypeno')
          //         ->orderBy('number_bill_journal', 'asc')
          //         ->whereBetween('datebill', [$start, $end])
          //         ->where('code_branch', $branch)
          //         ->get();
          //     // dump('have');
          // } else {
          //     $inform_get_edits = DB::connection('mysql2')
          //         ->table('journal_5')
          //         ->join('accounttype', 'accounttype.id', '=', 'journal_5.accounttypeno')
          //         ->orderBy('number_bill_journal', 'asc')
          //         ->whereBetween('datebill', [$start, $end])
          //         ->get();
          //     // dump('empty');
          // }
          // $ap = 'default';

          return view('journal.journal_general', compact('inform_get_edits', 'ap', 'branchs' , 'accounttypes' ,'type_journals'));
      }


      public function confirm_journal_debt(Request $request)
      {
          $list_ap = $request->get('check_list');
          $debts = Debt::whereIn('number_debt', $list_ap)
              ->get();
          foreach ($debts as $key => $debt) {
              $debt->accept = 1;
              $debt->update();
          }
          return redirect()->route('journal.debt');
      }

      public function getjournalgeneraledit($id)
      {
        $connect1 = Connectdb::Databaseall();
        $baseAc1 = $connect1['fsctaccount'];
        $baseHr1 = $connect1['hr_base'];

        $sql1 = "SELECT $baseAc1.journal_5.*
                                        ,branch.code_branch
                                        ,branch.name_branch

                        FROM $baseAc1.journal_5

                        INNER JOIN $baseHr1.branch
                        ON $baseAc1.journal_5.code_branch = $baseHr1.branch.code_branch

                        WHERE $baseAc1.journal_5.id = $id ";

          $getdatas = DB::select($sql1);
          return $getdatas;
      }

      public function update(Request $request)
      {
        $id_journal = $request->get_id;
        $journal_generals = Journal_5::find($id_journal);
        $journal_generals->code_branch = $request->branchs;
        $journal_generals->datebill = $request->datenow;
        $journal_generals->accounttypeno = $request->accounts;
        $journal_generals->debit = $request->debits;
        $journal_generals->credit = $request->credits;
        $journal_generals->list = $request->memos;
        $journal_generals->name_supplier = $request->names;

        $journal_generals->save();
        SWAL::message('สำเร็จ', 'แก้ไขเรียบร้อย!', 'success', ['timer' => 6000]);
        return redirect()->route('journal.general');
      }

        /**
         * Remove the specified resource from storage.
         *
         * @param  \App\Journal_5  $cash
         * @return \Illuminate\Http\Response
         */

      public function deleteUpdate($id)
      {
          $journal_generals = Journal_5::find($id);
          $idjournal = $journal_generals->id;

          if ($journal_generals != null)
          {
              $journal_generals->status = '99';
              $journal_generals->update();

              return redirect()->route('journal_general');
          }
      }

      public function confirm_journal_general(Request $request)
      {
          $connect1 = Connectdb::Databaseall();
          $baseAc1 = $connect1['fsctaccount'];

          $data = Input::all();
          $db = Connectdb::Databaseall();
          // print_r($data);

          $datack = $data['id_gen'];
          $comma_separated1 = implode(',', $datack);
          // dd($datack);
          // exit;
          // foreach ($datack as $key => $value) {
          //          $id = $value;
                   // dd($comma_separated1);
                   // exit;

                   $sqlUpdate = ' UPDATE '.$db['fsctaccount'].'.journal_5
                 					  SET accept = "1"
                 					  WHERE '.$db['fsctaccount'].'.journal_5.id IN ('.$comma_separated1.')';
             			 $lgUpdateResulte = DB::connection('mysql')->select($sqlUpdate);


                   $sqlwage = "SELECT * FROM $db[fsctaccount].journal_5

                              INNER JOIN $db[fsctaccount].journalgeneral_detail
                              ON $db[fsctaccount].journal_5.id = $db[fsctaccount].journalgeneral_detail.id_journalgeneral_head

                              INNER JOIN $db[fsctaccount].accounttype
                              ON $db[fsctaccount].journalgeneral_detail.accounttype = $db[fsctaccount].accounttype.id

                              WHERE $db[fsctaccount].journal_5.id IN ($comma_separated1)";
                        $datawage = DB::select($sqlwage);
                        // dd($datawage);
                        // exit;
                    for ($i=0; $i < count($datawage) ; $i++) {
                      $branch_s = $datawage[$i]->code_branch;
                      $numbe_debt1_s = $datawage[$i]->number_bill_journal;
                      $accounttypenos_s = $datawage[$i]->accounttypeno;
                      $debits_s = $datawage[$i]->debit;

                      if ($datawage[$i]->balance_forward_status == 1) {
                        $balance_close = $datawage[$i]->balance_forward_status;
                      }else {
                        $balance_close = 0;
                      }

                      $credits_s = $datawage[$i]->credit;
                      $list_s = $datawage[$i]->list;
                      $id_typejournal_s = 5;
                      $id_type_ref_journal = $datawage[$i]->id;
                      $datebills_s = $datawage[$i]->datebill;

                      if ($debits_s > 0.00) {
                        $arrInert = [ 'id'=>'',
                                'dr'=>$debits_s,
                                'cr'=>0.00,
                                'acc_code'=>$accounttypenos_s,
                                'branch'=>$branch_s,
                                'status'=> 1,
                                'number_bill'=> $numbe_debt1_s,
                                'customer_vendor'=> 0,
                                'timestamp'=>$datebills_s,
                                'balance_forward_status'=>$balance_close,
                                'code_emp'=> '',
                                'subtotal'=> 0,
                                'discount'=> 0,
                                'vat'=> 0,
                                'vatmoney'=> 0,
                                'wht'=> 0,
                                'whtmoney'=> 0,
                                'grandtotal'=> $debits_s,
                                'type_journal' => 5,
                                'id_type_ref_journal'=>$id_type_ref_journal,
                                'timereal'=>date('Y-m-d H:i:s'),
                                'list'=> $list_s];

                        DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);
                      }

                      if ($credits_s > 0.00)  {
                        $arrInert = [ 'id'=>'',
                                'dr'=>0.00,
                                'cr'=>$credits_s,
                                'acc_code'=>$accounttypenos_s,
                                'branch'=>$branch_s,
                                'status'=> 1,
                                'number_bill'=> $numbe_debt1_s,
                                'customer_vendor'=> 0,
                                'timestamp'=>$datebills_s,
                                'balance_forward_status'=>$balance_close,
                                'code_emp'=> '',
                                'subtotal'=> 0,
                                'discount'=> 0,
                                'vat'=> 0,
                                'vatmoney'=> 0,
                                'wht'=> 0,
                                'whtmoney'=> 0,
                                'grandtotal'=> $credits_s,
                                'type_journal' => 5,
                                'id_type_ref_journal'=>$id_type_ref_journal,
                                'timereal'=>date('Y-m-d H:i:s'),
                                'list'=> $list_s];

                        DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);
                      }

                    }

          // }







          // $ids = $request->get('id_journal_5');
          // $comma_separated1 = implode(',', $ids);
          // // dd($ids);
          // // exit;
          //
          // $sql1 = "SELECT * FROM $baseAc1.journal_5
          //
          //                 LEFT JOIN $baseAc1.journalgeneral_detail
          //                 ON $baseAc1.journal_5.id = $baseAc1.journalgeneral_detail.id_journalgeneral_head
          //
          //                 LEFT JOIN $baseAc1.accounttype
          //                 ON $baseAc1.journalgeneral_detail.accounttype = $baseAc1.accounttype.id
          //
          //                 WHERE $baseAc1.journal_5.id IN ($comma_separated1) AND journalgeneral_detail.status = 1";
          // // exit;
          // $datas = DB::select($sql1);
          //
          // foreach($datas as $data){
          //   // dd($data);
          //   // exit;
          //   Ledger::create([
          //    'branch' => $datas[0]->code_branch,
          //    'number_bill' => $datas[0]->number_bill_journal,
          //    'acc_code' => $datas[0]->accounttypeno,
          //    'dr' => $datas[0]->debit,
          //    'cr' =>  $datas[0]->credit,
          //    'list' => $datas[0]->list,
          //    'type_journal' => 5,
          //    'id_type_ref_journal' => $datas[0]->id,
          //    'timereal' => $datas[0]->datebill
          //   ]);
          // }






          // dd($datas);
          // exit;
          // $branch_s = $datas[0]->code_branch;
          // $numbe_debt1_s = $datas[0]->number_bill_journal;
          // $accounttypenos_s = $datas[0]->accounttypeno;
          // $debits_s = $datas[0]->debit;
          // $credits_s = $datas[0]->credit;
          // $list_s = $datas[0]->list;
          // $id_typejournal_s = 5;
          // $id_type_ref_journal = $datas[0]->id;
          // $datebills_s = $datas[0]->datebill;

          // foreach ($datas as $key => $value) {
          //   $ins_ledger = new Ledger;
          //   $ins_ledger->setConnection('mysql2');
          //
          //   $ins_ledger->branch = $datas[0]->code_branch;
          //   $ins_ledger->number_bill = $datas[0]->number_bill_journal;
          //   $ins_ledger->acc_code = $datas[0]->accounttypeno;
          //   $ins_ledger->dr = $datas[0]->debit;
          //   $ins_ledger->cr =  $datas[0]->credit;
          //   $ins_ledger->list = $datas[0]->list;
          //   $ins_ledger->type_journal = 5;
          //   $ins_ledger->id_type_ref_journal = $datas[0]->id;
          //   $ins_ledger->timereal = $datas[0]->datebill;
          //
          //   $ins_ledger->save();
          // }

          // foreach ($datas as $key => $value) {
          //   dd($datas);
          //   exit;
          //   $ins_ledger = new Ledger;
          //   $ins_ledger->setConnection('mysql2');
          //
          //   for ($i=0; $i < 2 ; $i++) {
          //     $ins_ledger->branch = $datas[$i]->code_branch;
          //     $ins_ledger->number_bill = $datas[$i]->number_bill_journal;
          //     $ins_ledger->acc_code = $datas[$i]->accounttypeno;
          //     $ins_ledger->dr = $datas[$i]->debit;
          //     $ins_ledger->cr =  $datas[$i]->credit;
          //     $ins_ledger->list = $datas[$i]->list;
          //     $ins_ledger->type_journal = 5;
          //     $ins_ledger->id_type_ref_journal = $datas[$i]->id;
          //     $ins_ledger->timereal = $datas[$i]->datebill;
          //
          //     $ins_ledger->save();
          //   }

          // }


            // DB::connection('mysql2')
            // ->table('journal_5')->whereIn('id',$ids)
            // ->update(['accept' => 1]);
            // // print_r($update);
            // // exit;
            // $branch_s = $request->get('code_branchs');
            // $numbe_debt1_s = $request->get('number_bill_journals');
            // // $discounts_s = $request->get('discounts');
            // // $vat_percents_s = $request->get('vat_percents');
            // // $vat_prices_s = $request->get('vat_prices');
            // $accounttypenos_s = $request->get('accounttypenos');
            // // $accounttypefulls_s = $request->get('accounttypefulls');
            // $debits_s = $request->get('debits');
            // $credits_s = $request->get('credits');
            // $id_typejournal_s = $request->get('id_typejournals');
            // // $id_journal_pay_s = $request->get('id_journal_pay');
            // $datebills_s = $request->get('datebills');
            // // echo $request->get('id_journal_pay');
            // $ref  =  $request->get('id_journal_generals');
            // // dd($ref);
            // // exit;
            //
            // // if (is_array($ref) || is_object($ref)) {
            //   foreach ($ref as $key => $value) {
            //     $ins_ledger = new Ledger;
            //     $ins_ledger->setConnection('mysql2');
            //
            //     $ins_ledger->branch = $branch_s[$key];
            //     $ins_ledger->number_bill = $numbe_debt1_s[$key];
            //     $ins_ledger->acc_code = $accounttypenos_s[$key];
            //     // $ins_ledger->vat = $accounttypefulls_s[$key];
            //     $ins_ledger->dr = $debits_s[$key];
            //     $ins_ledger->cr = $credits_s[$key];
            //     $ins_ledger->type_journal = $id_typejournal_s[$key];
            //     $ins_ledger->id_type_ref_journal = $value;
            //     $ins_ledger->timereal = $datebills_s[$key];
            //
            //     $ins_ledger->save();
            //   }
          SWAL::message('สำเร็จ', 'ได้ทำการผ่านรายการแล้ว!', 'success', ['timer' => 6000]);

          return redirect()->route('journal.general');
      }

}
