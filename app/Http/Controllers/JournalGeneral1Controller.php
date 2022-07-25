<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use DB;
use App\Branch;
use App\Type_journal;
use App\Ledger;
use App\Journal_5;
use App\Accounttype;
use App\Api\Connectdb;
use Illuminate\Support\Facades\Input;
use Softon\SweetAlert\Facades\SWAL;
use App\Api\Datetime;

class JournalGeneral1Controller extends Controller
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

        $basemain = $db['fsctmain'];

        $sqlbill = 'SELECT '.$db['fsctmain'].'.bill_rent.*
                                              ,material.name as names
                                              ,customers.name
                                              ,customers.lastname
                                              ,bill_detail.bill_rent as bill_forsum
                                              ,bill_rent.bill_rent as bill_rent_number
                                              ,bill_detail.total as last_total
                                              ,bill_rent.bill_rent as bill_rent_no
                                              ,bill_rent.id as id_ref
                                              ,bill_rent.total as cal_total
                                              ,bill_rent.accept


          FROM '.$db['fsctmain'].'.bill_rent

          INNER JOIN  '.$db['fsctmain'].'.bill_detail
          ON '. $db['fsctmain'].'.bill_rent.id = '. $db['fsctmain'].'.bill_detail.bill_rent

          INNER JOIN  '.$db['fsctmain'].'.material
          ON '. $db['fsctmain'].'.bill_detail.material_id = '. $db['fsctmain'].'.material.id

          INNER JOIN  '.$db['fsctmain'].'.customers
          ON '. $db['fsctmain'].'.bill_rent.customer_id = '. $db['fsctmain'].'.customers.customerid

          WHERE '.$db['fsctmain'].'.bill_rent.status IN (3,4) AND '.$db['fsctmain'].'.bill_rent.date_req_rent BETWEEN "2020-01-01 00:00:01" AND "2020-12-31 23:59:59"
          ORDER BY '. $db['fsctmain'].'.bill_detail.bill_rent ASC
          LIMIT 200';

          // $sqlbill = 'SELECT '.$db['fsctmain'].'.bill_rent.*
          //                                       ,material.name as names
          //                                       ,customers.name
          //                                       ,customers.lastname
          //                                       ,bill_detail.bill_rent
          //                                       ,bill_rent.bill_rent as bill_rent_number
          //                                       ,bill_rent.bill_rent as bill_rent_no
          //                                       ,SUM(bill_detail.total) as last_total
          //
          //
          //   FROM '.$db['fsctmain'].'.bill_rent
          //
          //   INNER JOIN  '.$db['fsctmain'].'.bill_detail
          //   ON '. $db['fsctmain'].'.bill_rent.id = '. $db['fsctmain'].'.bill_detail.bill_rent
          //
          //   INNER JOIN  '.$db['fsctmain'].'.material
          //   ON '. $db['fsctmain'].'.bill_detail.material_id = '. $db['fsctmain'].'.material.id
          //
          //   INNER JOIN  '.$db['fsctmain'].'.customers
          //   ON '. $db['fsctmain'].'.bill_rent.customer_id = '. $db['fsctmain'].'.customers.customerid
          //
          //   WHERE '.$db['fsctmain'].'.bill_rent.status IN (3,4)
          //   GROUP BY '.$db['fsctmain'].'.bill_detail.bill_rent
          //   ORDER BY '. $db['fsctmain'].'.bill_detail.bill_rent ASC';
          // WHERE '.$db['fsctmain'].'.bill_rent.branch_id = "'.$branch_id.'"
          // AND '.$db['fsctmain'].'.bill_rent.startdate  BETWEEN "'.$start_date2.'" AND  "'.$end_date2.'"
        $databills = DB::connection('mysql3')->select($sqlbill);
        $ap = 'default';

        return view('journal.journal_general1', compact( 'branchs' , 'accounttypes', 'databills' ,'ap'));
    }

    public function journal_generalfilter1(Request $request)
    {
        $data = Input::all();
        $db = Connectdb::Databaseall();

        $branchs = new Branch;
        $branchs = Branch::get();

        $date = $request->get('daterange');
        $branch = $request->get('branch_search');

        $dateset = Datetime::convertStartToEnd($date);
        $start = $dateset['start'];
        $end = $dateset['end'];

        if ($branch != '0') {
            $databills = DB::connection('mysql3')
                ->table('bill_rent')
                ->select('material.name as names','customers.name','customers.lastname','bill_detail.bill_rent as bill_forsum','bill_rent.bill_rent as bill_rent_number'
                ,'bill_detail.total as last_total','bill_rent.bill_rent as bill_rent_no','bill_rent.id as id_ref','bill_rent.accept','bill_rent.bill_rent','bill_rent.branch_id'
                ,'bill_rent.discount','bill_rent.vat','bill_rent.total','bill_rent.date_req_rent','bill_rent.withhold','bill_rent.total as cal_total')
                ->join('bill_detail', 'bill_detail.bill_rent', '=', 'bill_rent.id')
                ->join('material', 'material.id', '=', 'bill_detail.material_id')
                ->join('customers', 'customers.customerid', '=', 'bill_rent.customer_id')
                ->orderBy('bill_detail.bill_rent', 'asc')
                ->whereBetween('date_req_rent', [$start, $end])
                ->where('branch_id', $branch)
                ->get();
        } else {
            $databills = DB::connection('mysql3')
                ->table('bill_rent')
                ->select('material.name as names','customers.name','customers.lastname','bill_detail.bill_rent as bill_forsum','bill_rent.bill_rent as bill_rent_number'
                ,'bill_detail.total as last_total','bill_rent.bill_rent as bill_rent_no','bill_rent.id as id_ref','bill_rent.accept','bill_rent.bill_rent','bill_rent.branch_id'
                ,'bill_rent.discount','bill_rent.vat','bill_rent.total','bill_rent.date_req_rent','bill_rent.withhold','bill_rent.total as cal_total')
                ->join('bill_detail', 'bill_detail.bill_rent', '=', 'bill_rent.id')
                ->join('material', 'material.id', '=', 'bill_detail.material_id')
                ->join('customers', 'customers.customerid', '=', 'bill_rent.customer_id')
                ->orderBy('bill_detail.bill_rent', 'asc')
                ->whereBetween('date_req_rent', [$start, $end])
                ->get();
        }
        $ap = 'default';
        // dd($debts);
        return view('journal.journal_general1', compact('databills', 'ap', 'branchs'));
    }

    public function confirm_journal_general1(Request $request)
    {
      $connect1 = Connectdb::Databaseall();
      $baseAc1 = $connect1['fsctmain'];

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
               $sqlUpdate = ' UPDATE '.$db['fsctmain'].'.bill_rent
                        SET accept = "1"
                        WHERE '.$db['fsctmain'].'.bill_rent.id IN ('.$comma_separated1.') ';
               $lgUpdateResulte = DB::connection('mysql')->select($sqlUpdate);

               $sql1 = "SELECT $baseAc1.bill_rent.*
                                                 ,bill_detail.total as last_total
                                                 ,bill_rent.bill_rent as billrent_num
                                                 ,material.name as names
                                                 ,customers.name
                                                 ,customers.lastname
                                                 ,bill_rent.id as id_ref
                                                 ,bill_rent.accept

                               FROM $baseAc1.bill_rent

                               INNER JOIN $baseAc1.bill_detail
                               ON $baseAc1.bill_rent.id = $baseAc1.bill_detail.bill_rent

                               INNER JOIN $baseAc1.material
                               ON $baseAc1.bill_detail.material_id = $baseAc1.material.id

                               INNER JOIN $baseAc1.customers
                               ON $baseAc1.bill_rent.customer_id = $baseAc1.customers.customerid

                               WHERE $baseAc1.bill_rent.id IN ($comma_separated1) AND bill_rent.status IN (3,4)";

                    $datawage = DB::select($sql1);
                    // dd($datawage);
                    // exit;
                for ($i=0; $i < count($datawage) ; $i++) {
                  $branch_s = $datawage[$i]->branch_id;
                  $numbe_debt1_s = $datawage[$i]->billrent_num;
                  $customer_ids = $datawage[$i]->customer_id;
                  // $accounttypenos_s = $datawage[$i]->accounttypeno;
                  $debits_s = $datawage[$i]->last_total;
                  $credits_s = $datawage[$i]->last_total;
                  // $list_s = $datawage[$i]->list;
                  $id_typejournal_s = 5;
                  $id_type_ref_journal = $datawage[$i]->id_ref;
                  $datebills_start = $datawage[$i]->date_req_rent;
                  $emp_outs = $datawage[$i]->emp_out;
                  $vats = $datawage[$i]->vat;
                  $discounts = $datawage[$i]->discount;
                  $withholds = $datawage[$i]->withhold;

                    $accode = '151901';
                    $list = 'ขึ้นเครื่องมือให้เช่าลูกค้า'."".$datawage[$i]->name."".$datawage[$i]->lastname;
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
                  $numbe_debt1_s = $datawage[$i]->billrent_num;
                  $customer_ids = $datawage[$i]->customer_id;
                  // $accounttypenos_s = $datawage[$i]->accounttypeno;
                  $debits_s = $datawage[$i]->last_total;
                  $credits_s = $datawage[$i]->last_total;
                  // $list_s = $datawage[$i]->list;
                  $id_typejournal_s = 5;
                  $id_type_ref_journal = $datawage[$i]->id_ref;
                  $datebills_start = $datawage[$i]->date_req_rent;
                  $emp_outs = $datawage[$i]->emp_out;
                  $vats = $datawage[$i]->vat;
                  $discounts = $datawage[$i]->discount;
                  $withholds = $datawage[$i]->withhold;

                    $accode = '151900';
                    $list = 'เครื่องมือให้เช่า'."".$datawage[$i]->names."";
                    $arrInert = [ 'id'=>'',
                            'dr'=>0.00,
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
                            'grandtotal'=> $credits_s,
                            'type_journal' => 5,
                            'id_type_ref_journal'=>$id_type_ref_journal,
                            'timereal'=>date('Y-m-d H:i:s'),
                            'list'=> $list];

                    DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);

                }

      // }









      // $check_list = $request->get('check_list');
      // dd($check_list);
      // exit;
      // $ids = $request->get('numbe_debt1');
      // $journal_pay = DB::connection('mysql3')
      //     ->table('bill_rent')
      //     ->whereIn('bill_rent', $ids)
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


        // $number_bill_rentzz = $request->get('number_bill_rents');
        // // dd($number_bill_rentzz);
        // // exit;
        // DB::connection('mysql3')
        //   ->table('bill_rent')->whereIn('bill_rent',$number_bill_rentzz)
        //   ->update(['accept' => 1]);
        //
        //   $ref  =  $request->get('id_journal_pay');
        //
        //
        // $branch = $request->get('branch_ids');
        // $number_bill = $request->get('numbe_debt1');
        // $discount = $request->get('discounts');
        // $vat = $request->get('vat_percents');
        // $vatmoney = $request->get('vat_prices');
        // $type_journal = $request->get('id_typejournals');
        // $id_type_ref_journal = $request->get('id_bill_rents');
        // $timereal = $request->get('datebills');
        // // $debit = $request->get('debits');
        // // $credit = $request->get('credits');
        // $no_debts = $request->get('number_bill_rents');
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
        //   $ins_ledger->vatmoney = $vatmoney[$key];
        //   $ins_ledger->type_journal = $type_journal[$key];
        //   $ins_ledger->id_type_ref_journal = $id_type_ref_journal[$key];
        //   $ins_ledger->timereal = $timereal[$key];
        //
        //   // dd($ins_ledger);
        //   // exit;
        //   $ins_ledger->save();
        SWAL::message('สำเร็จ', 'ได้ทำการผ่านรายการแล้ว!', 'success', ['timer' => 6000]);

        return redirect()->route('journal.general1');
    }
}
