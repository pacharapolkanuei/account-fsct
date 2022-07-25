<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use DB;
use App\Branch;
use App\Ledger;
use App\Type_journal;
use App\Accounttype;
use App\Api\Connectdb;
use Illuminate\Support\Facades\Input;
use Softon\SweetAlert\Facades\SWAL;
use App\Api\Datetime;

class JournalGeneral2Controller extends Controller
{
  use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index()
    {
        $accounttypes = new Accounttype;
        $accounttypes->setConnection('mysql2');
        $accounttypes = Accounttype::where('status','=',1)
                      ->get();

        $branchs = new Branch;
        $branchs = Branch::where('status_main',1)->get();

        $data = Input::all();
        $db = Connectdb::Databaseall();

        $startdate = "2020-01-01 00:00:01";
        $enddate = "2020-12-31 23:59:59";

          $sqlbill = 'SELECT '.$db['fsctmain'].'.bill_return_head.*
                                              ,customers.name
                                              ,customers.lastname
                                              ,bill_detail.total as last_total
                                              ,material.name as names
                                              ,bill_return_head.id as id_billreturn
                                              ,bill_rent.total as cal_total
                                              ,bill_rent.discount
                                              ,bill_rent.vat
                                              ,bill_rent.withhold
                                              ,bill_rent.note

          FROM '.$db['fsctmain'].'.bill_return_head

          INNER JOIN  '.$db['fsctmain'].'.bill_rent
          ON '. $db['fsctmain'].'.bill_return_head.bill_rent = '. $db['fsctmain'].'.bill_rent.id

          INNER JOIN  '.$db['fsctmain'].'.bill_return_detail
          ON '. $db['fsctmain'].'.bill_return_head.id = '. $db['fsctmain'].'.bill_return_detail.return_head

          INNER JOIN  '.$db['fsctmain'].'.bill_detail
          ON '. $db['fsctmain'].'.bill_return_detail.bill_detail = '. $db['fsctmain'].'.bill_detail.id

          INNER JOIN  '.$db['fsctmain'].'.customers
          ON '. $db['fsctmain'].'.bill_rent.customer_id = '. $db['fsctmain'].'.customers.customerid

          INNER JOIN  '.$db['fsctmain'].'.material
          ON '. $db['fsctmain'].'.bill_detail.material_id = '. $db['fsctmain'].'.material.id

          WHERE '.$db['fsctmain'].'.bill_detail.status = 2 AND '.$db['fsctmain'].'.bill_return_head.time BETWEEN "2020-01-01 00:00:01" AND "2020-12-31 23:59:59"
          LIMIT 100';

        $databills = DB::connection('mysql')->select($sqlbill);
        // dd($databills);
        // exit;
        $ap = 'default';

        // $sqlsumtotal = 'SELECT '.$db['fsctmain'].'.bill_return_head.*
        //                                     ,bill_detail.total as totalvalue
        //
        // FROM '.$db['fsctmain'].'.bill_return_head
        //
        // INNER JOIN  '.$db['fsctmain'].'.bill_return_detail
        // ON '. $db['fsctmain'].'.bill_return_head.id = '. $db['fsctmain'].'.bill_return_detail.return_head
        //
        // INNER JOIN  '.$db['fsctmain'].'.bill_detail
        // ON '. $db['fsctmain'].'.bill_return_detail.bill_detail = '. $db['fsctmain'].'.bill_detail.id
        //
        // WHERE '.$db['fsctmain'].'.bill_detail.status = 2 AND '.$db['fsctmain'].'.bill_return_head.time BETWEEN "2020-01-01 00:00:01" AND "2020-12-31 23:59:59"
        // GROUP BY '.$db['fsctmain'].'.bill_return_detail.return_head
        // LIMIT 100';
        //
        // $sumtotals = DB::connection('mysql')->select($sqlsumtotal);


        return view('journal.journal_general2', compact( 'branchs' , 'accounttypes', 'databills' ,'ap'));
    }

    public function journal_generalfilter3(Request $request)
    {
        $data = Input::all();
        $db = Connectdb::Databaseall();

        $branchs = new Branch;
        $branchs = Branch::get();

        $date = $request->get('daterange');
        $branch = $request->get('branch_search');
        // echo $date;
        // echo "<br />";
        // echo $branch;
        // exit;
        $dateset = Datetime::convertStartToEnd($date);
        $start = $dateset['start'];
        $end = $dateset['end'];
        // echo $start;
        // echo "<br />";
        // echo $end;
        // exit;
        if ($branch != '0') {
            $databills = DB::connection('mysql3')
                ->table('bill_return_head')
                ->select('customers.name','customers.lastname','bill_detail.total as last_total','material.name as names','bill_return_head.id as id_billreturn','bill_rent.total as totalledger'
                ,'bill_rent.discount','bill_rent.vat','bill_rent.withhold','bill_return_head.time','bill_rent.note','bill_return_head.numberrun','bill_return_head.accept','bill_return_head.branch_id'
                )
                ->join('bill_rent', 'bill_rent.id', '=', 'bill_return_head.bill_rent')
                ->join('bill_return_detail', 'bill_return_detail.return_head', '=', 'bill_return_head.id')
                ->join('bill_detail', 'bill_detail.id', '=', 'bill_return_detail.bill_detail')
                ->join('customers', 'customers.customerid', '=', 'bill_rent.customer_id')
                ->join('material', 'material.id', '=', 'bill_detail.material_id')
                ->orderBy('bill_return_head.numberrun', 'asc')
                ->whereBetween('bill_return_head.time', [$start, $end])
                ->where('bill_return_head.branch_id', $branch)
                ->get();
        } else {
            $databills = DB::connection('mysql3')
                ->table('bill_return_head')
                ->select('customers.name','customers.lastname','bill_detail.total as last_total','material.name as names','bill_return_head.id as id_billreturn','bill_rent.total as totalledger'
                ,'bill_rent.discount','bill_rent.vat','bill_rent.withhold','bill_return_head.time','bill_rent.note','bill_return_head.numberrun','bill_return_head.accept','bill_return_head.branch_id'
                )
                ->join('bill_rent', 'bill_rent.id', '=', 'bill_return_head.bill_rent')
                ->join('bill_return_detail', 'bill_return_detail.return_head', '=', 'bill_return_head.id')
                ->join('bill_detail', 'bill_detail.id', '=', 'bill_return_detail.bill_detail')
                ->join('customers', 'customers.customerid', '=', 'bill_rent.customer_id')
                ->join('material', 'material.id', '=', 'bill_detail.material_id')
                ->orderBy('bill_return_head.numberrun', 'asc')
                ->whereBetween('bill_return_head.time', [$start, $end])
                ->get();
        }
        $ap = 'default';

        return view('journal.journal_general2', compact('databills', 'ap', 'branchs'));
    }

    public function confirm_journal_general3(Request $request)
    {
      $connect1 = Connectdb::Databaseall();
      $baseAc1 = $connect1['admin_maindemo'];

      $data = Input::all();
      $db = Connectdb::Databaseall();
      // print_r($data);

      $datack = $data['id_journal_5'];
      $comma_separated1 = implode(',', $datack);
      // dd($comma_separated1);
      // exit;
      // foreach ($datack as $key => $value) {
      //          $id = $value;
               // dd($comma_separated1);
               // exit;
               $sqlUpdate = ' UPDATE '.$db['fsctmain'].'.bill_return_head
                        SET accept = "1"
                        WHERE '.$db['fsctmain'].'.bill_return_head.id IN ('.$comma_separated1.') ';
               $lgUpdateResulte = DB::connection('mysql')->select($sqlUpdate);

               $sqlbill = 'SELECT '.$db['fsctmain'].'.bill_return_head.*
                                                   ,customers.name
                                                   ,customers.lastname
                                                   ,bill_detail.total as last_total
                                                   ,material.name as names
                                                   ,bill_return_head.id as id_billreturn
                                                   ,bill_rent.total as totalledger
                                                   ,bill_rent.discount
                                                   ,bill_rent.vat
                                                   ,bill_rent.withhold
                                                   ,bill_rent.note
                                                   ,bill_rent.customer_id
                                                   ,bill_rent.emp_store

               FROM '.$db['fsctmain'].'.bill_return_head

               INNER JOIN  '.$db['fsctmain'].'.bill_rent
               ON '. $db['fsctmain'].'.bill_return_head.bill_rent = '. $db['fsctmain'].'.bill_rent.id

               INNER JOIN  '.$db['fsctmain'].'.bill_return_detail
               ON '. $db['fsctmain'].'.bill_return_head.id = '. $db['fsctmain'].'.bill_return_detail.return_head

               INNER JOIN  '.$db['fsctmain'].'.bill_detail
               ON '. $db['fsctmain'].'.bill_return_detail.bill_detail = '. $db['fsctmain'].'.bill_detail.id

               INNER JOIN  '.$db['fsctmain'].'.customers
               ON '. $db['fsctmain'].'.bill_rent.customer_id = '. $db['fsctmain'].'.customers.customerid

               INNER JOIN  '.$db['fsctmain'].'.material
               ON '. $db['fsctmain'].'.bill_detail.material_id = '. $db['fsctmain'].'.material.id

               WHERE '.$db['fsctmain'].'.bill_return_head.id IN ('.$comma_separated1.') AND '.$db['fsctmain'].'.bill_detail.status = 2';

               $datawage = DB::select($sqlbill);
                    // dd($datawage);
                    // exit;

                for ($i=0; $i < count($datawage) ; $i++) {
                  $branch_s = $datawage[$i]->branch_id;
                  $numbe_debt1_s = $datawage[$i]->numberrun;
                  $customer_ids = $datawage[$i]->customer_id;
                  // $accounttypenos_s = $datawage[$i]->accounttypeno;
                  $debits_s = $datawage[$i]->last_total;
                  $credits_s = $datawage[$i]->last_total;
                  // $list_s = $datawage[$i]->list;
                  $id_typejournal_s = 5;
                  $id_type_ref_journal = $datawage[$i]->id_billreturn;
                  $datebills_start = $datawage[$i]->time;
                  $emp_outs = $datawage[$i]->emp_store;
                  $vats = $datawage[$i]->vat;
                  $discounts = $datawage[$i]->discount;
                  $withholds = $datawage[$i]->withhold;

                    $accode = '151900';
                    $list = 'เครื่องมือให้เช่า'."".$datawage[$i]->names."";
                    $arrInert = [ 'id'=>'',
                            'dr'=>$debits_s,
                            'cr'=>0.00,
                            'acc_code'=>$accode,
                            'branch'=>$branch_s,
                            'status'=> 1,
                            'number_bill'=> $numbe_debt1_s,
                            'customer_vendor'=> $customer_ids,
                            'timestamp'=>$datebills_start,
                            'code_emp'=>$emp_outs,
                            'subtotal'=> 0,
                            'discount'=> $discounts,
                            'vat'=> $vats,
                            'vatmoney'=> 0,
                            'wht'=> $withholds,
                            'whtmoney'=> 0,
                            'grandtotal'=> $debits_s,
                            'type_journal' => 5,
                            'id_type_ref_journal'=>$id_type_ref_journal,
                            'timereal'=>date('Y-m-d H:i:s'),
                            'list'=> $list];

                    DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);

                  }
                  for ($i=0; $i < count($datawage) ; $i++) {
                    $branch_s = $datawage[$i]->branch_id;
                    $numbe_debt1_s = $datawage[$i]->numberrun;
                    $customer_ids = $datawage[$i]->customer_id;
                    // $accounttypenos_s = $datawage[$i]->accounttypeno;
                    $debits_s = $datawage[$i]->last_total;
                    $credits_s = $datawage[$i]->last_total;
                    // $list_s = $datawage[$i]->list;
                    $id_typejournal_s = 5;
                    $id_type_ref_journal = $datawage[$i]->id_billreturn;
                    $datebills_start = $datawage[$i]->time;
                    $emp_outs = $datawage[$i]->emp_store;
                    $vats = $datawage[$i]->vat;
                    $discounts = $datawage[$i]->discount;
                    $withholds = $datawage[$i]->withhold;

                      $accode = '151901';
                      $list = 'เครื่องมือให้เช่าลูกค้า'."".$datawage[$i]->name."".$datawage[$i]->lastname;
                      $arrInert = [ 'id'=>'',
                              'dr'=>0.0,
                              'cr'=>$credits_s,
                              'acc_code'=>$accode,
                              'branch'=>$branch_s,
                              'status'=> 1,
                              'number_bill'=> $numbe_debt1_s,
                              'customer_vendor'=> $customer_ids,
                              'timestamp'=>$datebills_start,
                              'code_emp'=>$emp_outs,
                              'subtotal'=> 0,
                              'discount'=> $discounts,
                              'vat'=> $vats,
                              'vatmoney'=> 0,
                              'wht'=> $withholds,
                              'whtmoney'=> 0,
                              'grandtotal'=> $debits_s,
                              'type_journal' => 5,
                              'id_type_ref_journal'=>$id_type_ref_journal,
                              'timereal'=>date('Y-m-d H:i:s'),
                              'list'=> $list];

                      DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);
                    }
      // }










      // // $check_list = $request->get('check_list');
      // // dd($check_list);
      // // exit;
      // $ids = $request->get('numbe_debt1');
      // $journal_pay = DB::connection('mysql3')
      //     ->table('bill_return_head')
      //     ->whereIn('numberrun', $ids)
      //     ->update(['accept' => 1]);
      //
      // // $ids = $request->get('numbe_debt1');
      // // dd($ids);
      // // exit;
      //
      //   for ($i = 0; $i < count($request->id_journal_pay); $i++) {
      //       $answers[] = [
      //           // 'dr' => Sentinel::getUser()->id,
      //           'dr' => $request->ins_debit[$i],
      //           'cr' => $request->ins_credit[$i],
      //           'branch' => $request->branch_ids[$i],
      //           'list' => $request->listtoled[$i],
      //           'note' => $request->notetoled[$i],
      //           'acc_code' => $request->account_no[$i],
      //           'number_bill' => $request->numbe_debt1[$i],
      //           'discount' => $request->discounts[$i],
      //           'vat' => $request->vat_percents[$i],
      //           'wht' => $request->with_holds[$i],
      //           // 'vatmoney' => $request->vat_prices[$i],
      //           'type_journal' => $request->id_typejournals[$i],
      //           'id_type_ref_journal' => $request->id_journal_pay[$i],
      //           'timereal' => $request->datebills[$i],
      //       ];
      //   }
      //   // dd($answers);
      //   // exit;
      //   Ledger::insert($answers);


        // $number_bill_rentz = $request->get('number_bill_enginerents');
        //
        // DB::connection('mysql3')
        //   ->table('bill_return_head')->whereIn('numberrun',$number_bill_rentz)
        //   ->update(['accept' => 1]);
        //
        // $ref  =  $request->get('id_journal_pay');
        //
        // $branch = $request->get('branch_ids');
        // $number_bill = $request->get('numbe_debt1');
        // $discount = $request->get('discounts');
        // $vat = $request->get('vat_percents');
        // $whd = $request->get('withholds');
        // $vatmoney = $request->get('vat_prices');
        // $type_journal = $request->get('id_typejournals');
        // $id_type_ref_journal = $request->get('id_bill_rents');
        // $timereal = $request->get('datebills');
        // // $debit = $request->get('debits');
        // // $credit = $request->get('credits');
        // $no_debts = $request->get('number_bill_enginerents');
        // // dd($no_debts);
        // // exit;
        //
        // foreach ($no_debts as $key => $value) {
        //   $ins_ledger = new Ledger;
        //   $ins_ledger->setConnection('mysql2');
        //
        //   $ins_ledger->branch = $branch[$key];
        //   $ins_ledger->number_bill = $value;
        //   $ins_ledger->discount = $discount[$key];
        //   $ins_ledger->vat = $vat[$key];
        //   $ins_ledger->wht = $whd[$key];
        //   $ins_ledger->vatmoney = $vatmoney[$key];
        //   $ins_ledger->type_journal = $type_journal[$key];
        //   $ins_ledger->id_type_ref_journal = $id_type_ref_journal[$key];
        //   $ins_ledger->timereal = $timereal[$key];
        //
        //   $ins_ledger->save();
        // }
        SWAL::message('สำเร็จ', 'ได้ทำการผ่านรายการแล้ว!', 'success', ['timer' => 6000]);
        return redirect()->route('journal.general2');
    }
}
