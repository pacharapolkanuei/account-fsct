<?php

namespace App\Http\Controllers;

use App\Branch;
use App\Debt;
use App\Ledger;
use App\Api\Connectdb;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Softon\SweetAlert\Facades\SWAL;
use DB;
use App\Api\Datetime;

class Journal_debtController extends Controller
{
    public function  index()
    {
        $debts = DB::connection('mysql2')
            ->table('in_debt')
            ->select('in_debt.id as id_indebt','in_debt.number_debt','in_debt.accept','in_debt.branch_id','in_debt.discount'
            ,'in_debt.vat','in_debt.vat_price','in_debt.id_typejournal','in_debt.datebill','po_detail.list','po_detail.note'
            ,'accounttype.accounttypeno','accounttype.accounttypefull','po_detail.total','accounttype.config_group_supp_id','good.name'
            ,'accounttype.id as id_accounttype','po_head.supplier_id')
            ->join('po_head', 'in_debt.id_po', '=', 'po_head.id')
            ->join('po_detail', 'in_debt.id_po', '=', 'po_detail.po_headid')
            ->join('good', 'good.id', '=', 'po_detail.materialid')
            ->join('accounttype', 'accounttype.id', '=', 'good.accounttype')
            // ->select(DB::raw("SUM(po_detail.total) as counttotal"))
            ->orderBy('number_debt', 'asc')
            ->where('po_detail.statususe',1)
            ->get();
        $ap = 'default';

        // echo "<pre>";
        // print_r($debts);
        // dd($debts);
        // exit;

        // $sumtotals = DB::connection('mysql2')
        //     ->table('in_debt')
        //     ->join('po_detail', 'in_debt.id_po', '=', 'po_detail.po_headid')
        //     ->where('po_detail.statususe',1)
        //     ->sum('po_detail.total');
        //
        // dd($sumtotals);
        // exit;
        $journal_generals = DB::connection('mysql2')
            ->table('journal_5')
            ->select('journal_5.id as id_journal_5','journal_5.number_bill_journal','journalgeneral_detail.list','journalgeneral_detail.name_suplier'
            ,'journal_5.datebill' ,'journal_5.accept','journal_5.totalsum','journal_5.code_branch','journal_5.code_branch','journalgeneral_detail.debit','journalgeneral_detail.credit'
            ,'accounttype.accounttypeno','accounttype.accounttypefull')
            ->join('journalgeneral_detail', 'journal_5.id', '=', 'journalgeneral_detail.id_journalgeneral_head')
            ->join('accounttype', 'accounttype.id', '=', 'journalgeneral_detail.accounttype')
            ->orderBy('number_bill_journal', 'asc')
            ->where('journal_5.type_module',1)
            ->where('journalgeneral_detail.status',1)
            ->get();
        $ap_journal = 'default';

        $branchs = new Branch;
        $branchs = Branch::where('status_main', '=', '1')->get();
        // dd($debts);

        return view('journal.journal_debt', compact('debts', 'ap', 'branchs' ,'journal_generals' , 'ap_journal'));
    }

    public function  journaldebt_filter(Request $request)
    {
        $branchs = new Branch;
        $branchs = Branch::get();

        $date = $request->get('daterange');
        $branch = $request->get('branch');

        $dateset = Datetime::convertStartToEnd($date);
        $start = $dateset['start'];
        $end = $dateset['end'];

        if ($branch != '0') {
            $debts = DB::connection('mysql2')
                ->table('in_debt')
                ->select('in_debt.id as id_indebt','in_debt.number_debt','in_debt.accept','in_debt.branch_id','in_debt.discount'
                ,'in_debt.vat','in_debt.vat_price','in_debt.id_typejournal','in_debt.datebill','po_detail.list','po_detail.note'
                ,'accounttype.accounttypeno','accounttype.accounttypefull','po_detail.total','accounttype.config_group_supp_id','good.name'
                ,'accounttype.id as id_accounttype')
                ->join('po_detail', 'in_debt.id_po', '=', 'po_detail.po_headid')
                ->join('good', 'good.id', '=', 'po_detail.materialid')
                ->join('accounttype', 'accounttype.id', '=', 'good.accounttype')
                ->orderBy('number_debt', 'asc')
                ->whereBetween('datebill', [$start, $end])
                ->where('branch_id', $branch)
                ->get();
            // dump('have');
        } else {
            $debts = DB::connection('mysql2')
                ->table('in_debt')
                ->select('in_debt.id as id_indebt','in_debt.number_debt','in_debt.accept','in_debt.branch_id','in_debt.discount'
                ,'in_debt.vat','in_debt.vat_price','in_debt.id_typejournal','in_debt.datebill','po_detail.list','po_detail.note'
                ,'accounttype.accounttypeno','accounttype.accounttypefull','po_detail.total','accounttype.config_group_supp_id','good.name'
                ,'accounttype.id as id_accounttype')
                ->join('po_detail', 'in_debt.id_po', '=', 'po_detail.po_headid')
                ->join('good', 'good.id', '=', 'po_detail.materialid')
                ->join('accounttype', 'accounttype.id', '=', 'good.accounttype')
                ->orderBy('number_debt', 'asc')
                ->whereBetween('datebill', [$start, $end])
                ->get();
            // dump('empty');
        }
        $ap = 'default';

        $journal_generals = DB::connection('mysql2')
            ->table('journal_5')
            ->select('journal_5.id as id_journal_5','journal_5.number_bill_journal','journalgeneral_detail.list','journalgeneral_detail.name_suplier'
            ,'journal_5.datebill' ,'journal_5.accept','journal_5.totalsum','journal_5.code_branch','journal_5.code_branch','journalgeneral_detail.debit','journalgeneral_detail.credit'
            ,'accounttype.accounttypeno','accounttype.accounttypefull')
            ->join('journalgeneral_detail', 'journal_5.id', '=', 'journalgeneral_detail.id_journalgeneral_head')
            ->join('accounttype', 'accounttype.id', '=', 'journalgeneral_detail.accounttype')
            ->orderBy('number_bill_journal', 'asc')
            ->where('journal_5.type_module',1)
            ->where('journalgeneral_detail.status',1)
            ->get();
        $ap_journal = 'default';
        // dd($debts);
        return view('journal.journal_debt', compact('debts', 'ap', 'branchs' ,'journal_generals' , 'ap_journal'));
    }

    public function debtcancel(Request $request, $getidindebt)
  	{
          $number_bill_rentenginez = [$getidindebt];
  				// $number_bill_rentenginez = $getidindebt;
          // print_r($number_bill_rentenginez);
          // exit;
  				DB::connection('mysql2')
  				->table('in_debt')->whereIn('id',$number_bill_rentenginez)
  				->update(['statususe' => 99]);

  				// SWAL::message('สำเร็จ', 'ได้บันทึกรายการว่าโอนแล้ว!', 'success', ['timer' => 6000]);
  				return redirect()->route('journal.debt');
  	}

    public function confirm_journal_debt(Request $request)
    {
      $connect1 = Connectdb::Databaseall();
      $baseAc1 = $connect1['fsctaccount'];

      $data = Input::all();
      $db = Connectdb::Databaseall();
      // print_r($data);
      if (isset($data['id_indebts'])) {
      $datack = $data['id_indebts'];
      $comma_separated1 = implode(',', $datack);
      // dd($comma_separated1);
      // exit;
      // foreach ($datack as $key => $value) {
      //          $id = $value;
               // dd($comma_separated1);
               // exit;
                $sqlUpdate = ' UPDATE '.$db['fsctaccount'].'.in_debt
                          SET accept = "1"
                          WHERE '.$db['fsctaccount'].'.in_debt.id IN ('.$comma_separated1.') ';
                $lgUpdateResulte = DB::connection('mysql')->select($sqlUpdate);

                $sqlbillengine = 'SELECT '.$db['fsctaccount'].'.in_debt.*
                                                               ,in_debt.id as id_indebt
                                                               ,po_detail.total
                                                               ,po_detail.list
                                                               ,accounttype.accounttypeno
                                                               ,good.name


                 FROM '.$db['fsctaccount'].'.in_debt

                 INNER JOIN  '.$db['fsctaccount'].'.po_detail
                 ON '. $db['fsctaccount'].'.in_debt.id_po = '. $db['fsctaccount'].'.po_detail.po_headid

                 INNER JOIN  '.$db['fsctaccount'].'.good
                 ON '. $db['fsctaccount'].'.po_detail.materialid = '. $db['fsctaccount'].'.good.id

                 INNER JOIN  '.$db['fsctaccount'].'.accounttype
                 ON '. $db['fsctaccount'].'.good.accounttype = '. $db['fsctaccount'].'.accounttype.id



                 WHERE '.$db['fsctaccount'].'.in_debt.id IN ('.$comma_separated1.') AND '.$db['fsctaccount'].'.po_detail.statususe =1';

                $datawage = DB::select($sqlbillengine);
                // dd($datawage);
                // exit;

                // INNER JOIN  '.$db['fsctaccount'].'.supplier
                // ON '. $db['fsctaccount'].'.in_debt.id_po = '. $db['fsctaccount'].'.supplier.id

                  for ($i=0; $i < count($datawage) ; $i++) {
                    $branch_s = $datawage[$i]->branch_id;
                    $numbe_debt1_s = $datawage[$i]->number_debt;
                    $customer_ids = $datawage[$i]->supplier_id;
                    // $accounttypenos_s = $datawage[$i]->accounttypeno;
                    $debits_s = $datawage[$i]->total;
                    // $credits_s = $datawage[$i]->last_total;
                    // $list_s = $datawage[$i]->list;
                    $id_typejournal_s = 1;
                    $id_type_ref_journal = $datawage[$i]->id_indebt;
                    $datebills_start = $datawage[$i]->datebill;
                    // $emp_outs = $datawage[$i]->emp_out;
                    $vats = $datawage[$i]->vat;
                    $discounts = $datawage[$i]->discount;
                    // $withholds = $datawage[$i]->withhold;
                    $accode = $datawage[$i]->accounttypeno;
                    $list = $datawage[$i]->list;

                      $arrInert = [ 'id'=>'',
                              'dr'=>$debits_s,
                              'cr'=>0.00,
                              'acc_code'=>$accode,
                              'branch'=>$branch_s,
                              'status'=> 1,
                              'number_bill'=> $numbe_debt1_s,
                              'customer_vendor'=> $customer_ids,
                              'timestamp'=>$datebills_start,
                              // 'code_emp'=>$emp_outs,
                              'subtotal'=> 0,
                              'discount'=> $discounts,
                              'vat'=> $vats,
                              'vatmoney'=> 0,
                              // 'wht'=> $withholds,
                              'whtmoney'=> 0,
                              'grandtotal'=> $debits_s,
                              'type_journal' => 1,
                              'id_type_ref_journal'=>$id_type_ref_journal,
                              'timereal'=>date('Y-m-d H:i:s'),
                              'list'=> $list];

                      DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);
                  }


                    $sqlbillengine1 = 'SELECT '.$db['fsctaccount'].'.in_debt.*
                                                                   ,in_debt.id as id_indebt
                     FROM '.$db['fsctaccount'].'.in_debt

                     WHERE '.$db['fsctaccount'].'.in_debt.id IN ('.$comma_separated1.')';
                     $datawagecredit = DB::select($sqlbillengine1);
                     // dd($datawagecredit);
                     // exit;

                  for ($i=0; $i < count($datawagecredit) ; $i++) {
                        $branch_s = $datawagecredit[$i]->branch_id;
                        $numbe_debt1_s = $datawagecredit[$i]->number_debt;
                        // $customer_ids = $datawagecredit[$i]->supplier_id;
                        // $accounttypenos_s = $datawagecredit[$i]->accounttypeno;
                        // $debits_s = $datawagecredit[$i]->total;
                        $credits_s = $datawagecredit[$i]->vat_price;
                        // $list_s = $datawagecredit[$i]->list;
                        $id_typejournal_s = 1;
                        $id_type_ref_journal = $datawagecredit[$i]->id_indebt;
                        $datebills_start = $datawagecredit[$i]->datebill;
                        // $emp_outs = $datawagecredit[$i]->emp_out;
                        $vats = $datawagecredit[$i]->vat;
                        $discounts = $datawagecredit[$i]->discount;
                        // $withholds = $datawagecredit[$i]->withhold;
                        $accode = '212100';
                        // $list = "".$datawagecredit[$i]->name."".'ค้างจ่าย';
                        $list = 'รายการค้างจ่าย';

                          $arrInert = [ 'id'=>'',
                                  'dr'=>0.00,
                                  'cr'=>$credits_s,
                                  'acc_code'=>$accode,
                                  'branch'=>$branch_s,
                                  'status'=> 1,
                                  'number_bill'=> $numbe_debt1_s,
                                  'customer_vendor'=> $customer_ids,
                                  'timestamp'=>$datebills_start,
                                  // 'code_emp'=>$emp_outs,
                                  'subtotal'=> 0,
                                  'discount'=> $discounts,
                                  'vat'=> $vats,
                                  'vatmoney'=> 0,
                                  // 'wht'=> $withholds,
                                  'whtmoney'=> 0,
                                  'grandtotal'=> $credits_s,
                                  'type_journal' => 1,
                                  'id_type_ref_journal'=>$id_type_ref_journal,
                                  'timereal'=>date('Y-m-d H:i:s'),
                                  'list'=> $list];

                          DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);
                  }

                  for ($i=0; $i < count($datawagecredit) ; $i++) {
                    if ($datawagecredit[$i]->vat > 0 && $datawagecredit[$i]->vat_price >= 0.01) {
                      $showvat = $datawagecredit[$i]->vat;
                      $showvat_cal = $datawagecredit[$i]->vat_price;

                      $branch_s = $datawagecredit[$i]->branch_id;
                      $numbe_debt1_s = $datawagecredit[$i]->number_debt;
                      // $customer_ids = $datawagecredit[$i]->supplier_id;
                      // $accounttypenos_s = $datawagecredit[$i]->accounttypeno;
                      if ($showvat = 7) {
                        $debits_s = $showvat_cal/1.07;
                        $calvat = $debits_s*0.07;
                      }
                      elseif ($showvat = 3) {
                        $debits_s = $showvat_cal/1.03;
                        $calvat = $debits_s*0.03;
                      }
                      elseif ($showvat = 5) {
                        $debits_s = $showvat_cal/1.05;
                        $calvat = $debits_s*0.05;
                      }
                      elseif ($showvat = 1) {
                        $debits_s = $showvat_cal/1.01;
                        $calvat = $debits_s*0.01;
                      }
                      $showvat_ins = number_format($calvat, 2, '.', '');
                      // $credits_s = $datawagecredit[$i]->last_total;
                      // $list_s = $datawagecredit[$i]->list;
                      $id_typejournal_s = 1;
                      $id_type_ref_journal = $datawagecredit[$i]->id_indebt;
                      $datebills_start = $datawagecredit[$i]->datebill;
                      // $emp_outs = $datawagecredit[$i]->emp_out;
                      $vats = $showvat;
                      $discounts = $datawagecredit[$i]->discount;
                      // $withholds = $datawagecredit[$i]->withhold;
                      $accode = '119501';
                      $list = 'ภาษีมูลค่าเพิ่ม';

                        $arrInert = [ 'id'=>'',
                                'dr'=>$showvat_ins,
                                'cr'=>0.00,
                                'acc_code'=>$accode,
                                'branch'=>$branch_s,
                                'status'=> 1,
                                'number_bill'=> $numbe_debt1_s,
                                'customer_vendor'=> $customer_ids,
                                'timestamp'=>$datebills_start,
                                // 'code_emp'=>$emp_outs,
                                'subtotal'=> 0,
                                'discount'=> $discounts,
                                'vat'=> $vats,
                                'vatmoney'=> 0,
                                // 'wht'=> $withholds,
                                'whtmoney'=> 0,
                                'grandtotal'=> $debits_s,
                                'type_journal' => 1,
                                'id_type_ref_journal'=>$id_type_ref_journal,
                                'timereal'=>date('Y-m-d H:i:s'),
                                'list'=> $list];

                        DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);
                    }
                  }

                  for ($i=0; $i < count($datawagecredit) ; $i++) {
                    if ($datawagecredit[$i]->discount >= 0.01) {
                        $discount_check = $datawagecredit[$i]->discount;

                        // for ($i=0; $i < count($datawagecredit) ; $i++) {
                        $branch_s = $datawagecredit[$i]->branch_id;
                        $numbe_debt1_s = $datawagecredit[$i]->number_debt;
                        // $customer_ids = $datawagecredit[$i]->supplier_id;
                        // $accounttypenos_s = $datawagecredit[0]->accounttypeno;
                        // $debits_s = $datawagecredit[0]->total;
                        $credits_s = $discount_check;
                        // $list_s = $datawagecredit[$i]->list;
                        $id_typejournal_s = 1;
                        $id_type_ref_journal = $datawagecredit[$i]->id_indebt;
                        $datebills_start = $datawagecredit[$i]->datebill;
                        // $emp_outs = $datawagecredit[$i]->emp_out;
                        $vats = $datawagecredit[$i]->vat;
                        $discounts = $discount_check;
                        // $withholds = $datawagecredit[$i]->withhold;
                        $accode = '412900';
                        $list = 'ส่วนลด';

                        $arrInert = [ 'id'=>'',
                                'dr'=>0.00,
                                'cr'=>$credits_s,
                                'acc_code'=>$accode,
                                'branch'=>$branch_s,
                                'status'=> 1,
                                'number_bill'=> $numbe_debt1_s,
                                'customer_vendor'=> $customer_ids,
                                'timestamp'=>$datebills_start,
                                // 'code_emp'=>$emp_outs,
                                'subtotal'=> 0,
                                'discount'=> $discounts,
                                'vat'=> $vats,
                                'vatmoney'=> 0,
                                // 'wht'=> $withholds,
                                'whtmoney'=> 0,
                                'grandtotal'=> $credits_s,
                                'type_journal' => 1,
                                'id_type_ref_journal'=>$id_type_ref_journal,
                                'timereal'=>date('Y-m-d H:i:s'),
                                'list'=> $list];

                        DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);
                    }
                  }
      }

      if (isset($data['id_journal_general'])) {
        $datack_general = $data['id_journal_general'];
        $comma_separated2 = implode(',', $datack_general);

        $sqlUpdate1 = ' UPDATE '.$db['fsctaccount'].'.journal_5
                 SET accept = "1"
                 WHERE '.$db['fsctaccount'].'.journal_5.id IN ('.$comma_separated2.')';
        $lgUpdateResulte1 = DB::connection('mysql')->select($sqlUpdate1);

        $sql11 = "SELECT $baseAc1.journal_5.*
                                        ,journal_5.id as id_ref
                                        ,journalgeneral_detail.credit
                                        ,journalgeneral_detail.debit
                                        ,accounttype.accounttypeno
                                        ,journalgeneral_detail.list

                        FROM $baseAc1.journal_5

                        INNER JOIN $baseAc1.journalgeneral_detail
                        ON $baseAc1.journal_5.id = $baseAc1.journalgeneral_detail.id_journalgeneral_head

                        INNER JOIN $baseAc1.accounttype
                        ON $baseAc1.journalgeneral_detail.accounttype = $baseAc1.accounttype.id

                        -- LEFT JOIN $baseAc1.supplier
                        -- ON $baseAc1.inform_po_test.id_po = $baseAc1.supplier.id

                        -- LEFT JOIN $baseAc1.initial
                        -- ON $baseAc1.supplier.pre = $baseAc1.initial.per

                        WHERE journal_5.id IN ($comma_separated2)";

        $data_general = DB::select($sql11);
         // dd($data_general);
         // exit;

         for ($i=0; $i < count($data_general) ; $i++) {
           $branch_s = $data_general[$i]->code_branch;
           $numbe_debt1_s = $data_general[$i]->number_bill_journal;
           $accounttypenos_s = $data_general[$i]->accounttypeno;
           $debits_s = $data_general[$i]->debit;
           $credits_s = $data_general[$i]->credit;
           $list_s = $data_general[$i]->list;
           $id_typejournal_s = 1;
           $id_type_ref_journal = $data_general[$i]->id_ref;
           $datebills_s = $data_general[$i]->datebill;

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
                     'code_emp'=> '',
                     'subtotal'=> 0,
                     'discount'=> 0,
                     'vat'=> 0,
                     'vatmoney'=> 0,
                     'wht'=> 0,
                     'whtmoney'=> 0,
                     'grandtotal'=> $debits_s,
                     'type_journal' => 1,
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
                     'code_emp'=> '',
                     'subtotal'=> 0,
                     'discount'=> 0,
                     'vat'=> 0,
                     'vatmoney'=> 0,
                     'wht'=> 0,
                     'whtmoney'=> 0,
                     'grandtotal'=> $credits_s,
                     'type_journal' => 1,
                     'id_type_ref_journal'=>$id_type_ref_journal,
                     'timereal'=>date('Y-m-d H:i:s'),
                     'list'=> $list_s];

             DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);
           }

         }
      }

                    // else {
                    //   $showvat = 0;
                    // }
                    //
                    // if ($datawage[0]->vat_price >= 0.01) {
                    //   $showvat_cal = $datawage[0]->vat_price;
                    // }
                    // else {
                    //   $showvat_cal = 0.00;
                    // }
                    //
                    // if ($showvat > 0) {
                    //   // for ($i=0; $i < count($datawage) ; $i++) {
                    //     $branch_s = $datawage[0]->branch_id;
                    //     $numbe_debt1_s = $datawage[0]->number_debt;
                    //     $customer_ids = $datawage[0]->supplier_id;
                    //     // $accounttypenos_s = $datawage[$i]->accounttypeno;
                    //     if ($showvat = 1) {
                    //       $debits_s = $showvat_cal/1.01;
                    //       $calvat = $debits_s*0.01;
                    //     }
                    //     elseif ($showvat = 3) {
                    //       $debits_s = $showvat_cal/1.03;
                    //       $calvat = $debits_s*0.03;
                    //     }
                    //     elseif ($showvat = 5) {
                    //       $debits_s = $showvat_cal/1.05;
                    //       $calvat = $debits_s*0.05;
                    //     }
                    //     elseif ($showvat = 7) {
                    //       $debits_s = $showvat_cal/1.07;
                    //       $calvat = $debits_s*0.07;
                    //     }
                    //     $showvat_ins = number_format($calvat, 2, '.', '');
                    //     // $credits_s = $datawage[$i]->last_total;
                    //     // $list_s = $datawage[$i]->list;
                    //     $id_typejournal_s = 1;
                    //     $id_type_ref_journal = $datawage[0]->id_indebt;
                    //     $datebills_start = $datawage[0]->datebill;
                    //     // $emp_outs = $datawage[0]->emp_out;
                    //     $vats = $showvat;
                    //     $discounts = $datawage[0]->discount;
                    //     // $withholds = $datawage[$i]->withhold;
                    //     $accode = '119501';
                    //     $list = 'ภาษีมูลค่าเพิ่ม';
                    //
                    //       $arrInert = [ 'id'=>'',
                    //               'dr'=>$showvat_ins,
                    //               'cr'=>0.00,
                    //               'acc_code'=>$accode,
                    //               'branch'=>$branch_s,
                    //               'status'=> 1,
                    //               'number_bill'=> $numbe_debt1_s,
                    //               'customer_vendor'=> $customer_ids,
                    //               'timestamp'=>$datebills_start,
                    //               // 'code_emp'=>$emp_outs,
                    //               'subtotal'=> 0,
                    //               'discount'=> $discounts,
                    //               'vat'=> $vats,
                    //               'vatmoney'=> 0,
                    //               // 'wht'=> $withholds,
                    //               'whtmoney'=> 0,
                    //               'grandtotal'=> $debits_s,
                    //               'type_journal' => 1,
                    //               'id_type_ref_journal'=>$id_type_ref_journal,
                    //               'timereal'=>date('Y-m-d H:i:s'),
                    //               'list'=> $list];
                    //
                    //       DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);
                    //   // }
                    // }


                    // if ($datawage[0]->discount >= 0.01) {
                    //   $discount_check = $datawage[0]->discount;
                    // }
                    // else {
                    //   $discount_check = 0.00;
                    // }
                    // if ($discount_check > 0.00) {
                    //   // for ($i=0; $i < count($datawage) ; $i++) {
                    //     $branch_s = $datawage[0]->branch_id;
                    //     $numbe_debt1_s = $datawage[0]->number_debt;
                    //     $customer_ids = $datawage[0]->supplier_id;
                    //     // $accounttypenos_s = $datawage[0]->accounttypeno;
                    //     // $debits_s = $datawage[0]->total;
                    //     $credits_s = $discount_check;
                    //     // $list_s = $datawage[$i]->list;
                    //     $id_typejournal_s = 1;
                    //     $id_type_ref_journal = $datawage[0]->id_indebt;
                    //     $datebills_start = $datawage[0]->datebill;
                    //     // $emp_outs = $datawage[0]->emp_out;
                    //     $vats = $datawage[0]->vat;
                    //     $discounts = $discount_check;
                    //     // $withholds = $datawage[$i]->withhold;
                    //     $accode = '412900';
                    //     $list = 'ส่วนลด';
                    //
                    //     $arrInert = [ 'id'=>'',
                    //             'dr'=>0.00,
                    //             'cr'=>$credits_s,
                    //             'acc_code'=>$accode,
                    //             'branch'=>$branch_s,
                    //             'status'=> 1,
                    //             'number_bill'=> $numbe_debt1_s,
                    //             'customer_vendor'=> $customer_ids,
                    //             'timestamp'=>$datebills_start,
                    //             // 'code_emp'=>$emp_outs,
                    //             'subtotal'=> 0,
                    //             'discount'=> $discounts,
                    //             'vat'=> $vats,
                    //             'vatmoney'=> 0,
                    //             // 'wht'=> $withholds,
                    //             'whtmoney'=> 0,
                    //             'grandtotal'=> $credits_s,
                    //             'type_journal' => 1,
                    //             'id_type_ref_journal'=>$id_type_ref_journal,
                    //             'timereal'=>date('Y-m-d H:i:s'),
                    //             'list'=> $list];
                    //
                    //     DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);
                    //   }
                    // }

                  // for ($j=0; $j < count($datawage) ; $j++) {
                  //   if ($datawage[$j]->vat > 0) {
                  //     $showvat = $datawage[$j]->vat;
                  //   }
                  //
                  //   if ($datawage[$j]->vat_price >= 0.01) {
                  //     $showvat_cal = $datawage[$j]->vat_price;
                  //   }
                  // }


                  // for ($k=0; $k < count($datawage) ; $k++) {
                  //   if ($datawage[$k]->discount >= 0.01) {
                  //     $discount_check = $datawage[$k]->discount;
                  //   }
                  // }

                  // foreach ($datawage as $key => $datawagez) {
                  //   if ($datawagez->vat > 0) {
                  //     $showvat = $datawagez->vat;
                  //   }
                  //
                  //   if ($datawagez->vat_price >= 0.01) {
                  //     $showvat_cal = $datawagez->vat_price;
                  //   }
                  // }




                // if ($datawage[0]->vat = 1) {
                //   for ($i=0; $i < count($datawage) ; $i++) {
                //     $branch_s = $datawage[0]->branch_id;
                //     $numbe_debt1_s = $datawage[0]->number_debt;
                //     $customer_ids = $datawage[0]->supplier_id;
                //     // $accounttypenos_s = $datawage[$i]->accounttypeno;
                //     $debits_s = $datawage[0]->vat_price/1.01;
                //     $calvat = $debits_s*0.01;
                //     // $credits_s = $datawage[$i]->last_total;
                //     // $list_s = $datawage[$i]->list;
                //     $id_typejournal_s = 1;
                //     $id_type_ref_journal = $datawage[0]->id_indebt;
                //     $datebills_start = $datawage[0]->datebill;
                //     // $emp_outs = $datawage[0]->emp_out;
                //     $vats = 1.00;
                //     $discounts = $datawage[0]->discount;
                //     // $withholds = $datawage[$i]->withhold;
                //     $accode = '119501';
                //     $list = 'ภาษีมูลค่าเพิ่ม';
                //
                //       $arrInert = [ 'id'=>'',
                //               'dr'=>$calvat,
                //               'cr'=>0.00,
                //               'acc_code'=>$accode,
                //               'branch'=>$branch_s,
                //               'status'=> 1,
                //               'number_bill'=> $numbe_debt1_s,
                //               'customer_vendor'=> $customer_ids,
                //               'timestamp'=>$datebills_start,
                //               // 'code_emp'=>$emp_outs,
                //               'subtotal'=> 0,
                //               'discount'=> $discounts,
                //               'vat'=> $vats,
                //               'vatmoney'=> 0,
                //               // 'wht'=> $withholds,
                //               'whtmoney'=> 0,
                //               'grandtotal'=> $debits_s,
                //               'type_journal' => 1,
                //               'id_type_ref_journal'=>$id_type_ref_journal,
                //               'timereal'=>date('Y-m-d H:i:s'),
                //               'list'=> $list];
                //
                //       DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);
                //   }
                // }
                // elseif ($datawage[0]->vat = 3) {
                //   for ($i=0; $i < count($datawage) ; $i++) {
                //     $branch_s = $datawage[0]->branch_id;
                //     $numbe_debt1_s = $datawage[0]->number_debt;
                //     $customer_ids = $datawage[0]->supplier_id;
                //     // $accounttypenos_s = $datawage[$i]->accounttypeno;
                //     $debits_s = $datawage[0]->vat_price/1.03;
                //     $calvat = $debits_s*0.03;
                //     // $credits_s = $datawage[$i]->last_total;
                //     // $list_s = $datawage[$i]->list;
                //     $id_typejournal_s = 1;
                //     $id_type_ref_journal = $datawage[0]->id_indebt;
                //     $datebills_start = $datawage[0]->datebill;
                //     // $emp_outs = $datawage[0]->emp_out;
                //     $vats = 3.00;
                //     $discounts = $datawage[0]->discount;
                //     // $withholds = $datawage[$i]->withhold;
                //     $accode = '119501';
                //     $list = 'ภาษีมูลค่าเพิ่ม';
                //
                //       $arrInert = [ 'id'=>'',
                //               'dr'=>$calvat,
                //               'cr'=>0.00,
                //               'acc_code'=>$accode,
                //               'branch'=>$branch_s,
                //               'status'=> 1,
                //               'number_bill'=> $numbe_debt1_s,
                //               'customer_vendor'=> $customer_ids,
                //               'timestamp'=>$datebills_start,
                //               // 'code_emp'=>$emp_outs,
                //               'subtotal'=> 0,
                //               'discount'=> $discounts,
                //               'vat'=> $vats,
                //               'vatmoney'=> 0,
                //               // 'wht'=> $withholds,
                //               'whtmoney'=> 0,
                //               'grandtotal'=> $debits_s,
                //               'type_journal' => 1,
                //               'id_type_ref_journal'=>$id_type_ref_journal,
                //               'timereal'=>date('Y-m-d H:i:s'),
                //               'list'=> $list];
                //
                //       DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);
                //   }
                // }
                // elseif ($datawage[0]->vat = 5) {
                //   for ($i=0; $i < count($datawage) ; $i++) {
                //     $branch_s = $datawage[0]->branch_id;
                //     $numbe_debt1_s = $datawage[0]->number_debt;
                //     $customer_ids = $datawage[0]->supplier_id;
                //     // $accounttypenos_s = $datawage[$i]->accounttypeno;
                //     $debits_s = $datawage[0]->vat_price/1.05;
                //     $calvat = $debits_s*0.05;
                //     // $credits_s = $datawage[$i]->last_total;
                //     // $list_s = $datawage[$i]->list;
                //     $id_typejournal_s = 1;
                //     $id_type_ref_journal = $datawage[0]->id_indebt;
                //     $datebills_start = $datawage[0]->datebill;
                //     // $emp_outs = $datawage[0]->emp_out;
                //     $vats = 5.00;
                //     $discounts = $datawage[0]->discount;
                //     // $withholds = $datawage[$i]->withhold;
                //     $accode = '119501';
                //     $list = 'ภาษีมูลค่าเพิ่ม';
                //
                //       $arrInert = [ 'id'=>'',
                //               'dr'=>$calvat,
                //               'cr'=>0.00,
                //               'acc_code'=>$accode,
                //               'branch'=>$branch_s,
                //               'status'=> 1,
                //               'number_bill'=> $numbe_debt1_s,
                //               'customer_vendor'=> $customer_ids,
                //               'timestamp'=>$datebills_start,
                //               // 'code_emp'=>$emp_outs,
                //               'subtotal'=> 0,
                //               'discount'=> $discounts,
                //               'vat'=> $vats,
                //               'vatmoney'=> 0,
                //               // 'wht'=> $withholds,
                //               'whtmoney'=> 0,
                //               'grandtotal'=> $debits_s,
                //               'type_journal' => 1,
                //               'id_type_ref_journal'=>$id_type_ref_journal,
                //               'timereal'=>date('Y-m-d H:i:s'),
                //               'list'=> $list];
                //
                //       DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);
                //   }
                // }
                // elseif ($datawage[0]->vat = 7){
                //   for ($i=0; $i < count($datawage) ; $i++) {
                //     $branch_s = $datawage[0]->branch_id;
                //     $numbe_debt1_s = $datawage[0]->number_debt;
                //     $customer_ids = $datawage[0]->supplier_id;
                //     // $accounttypenos_s = $datawage[$i]->accounttypeno;
                //     $debits_s = $datawage[0]->vat_price/1.07;
                //     $calvat = $debits_s*0.07;
                //     // $list_s = $datawage[$i]->list;
                //     $id_typejournal_s = 1;
                //     $id_type_ref_journal = $datawage[0]->id_indebt;
                //     $datebills_start = $datawage[0]->datebill;
                //     // $emp_outs = $datawage[0]->emp_out;
                //     $vats = 7.00;
                //     $discounts = $datawage[0]->discount;
                //     // $withholds = $datawage[$i]->withhold;
                //     $accode = '119501';
                //     $list = 'ภาษีมูลค่าเพิ่ม';
                //
                //       $arrInert = [ 'id'=>'',
                //               'dr'=>$calvat,
                //               'cr'=>0.00,
                //               'acc_code'=>$accode,
                //               'branch'=>$branch_s,
                //               'status'=> 1,
                //               'number_bill'=> $numbe_debt1_s,
                //               'customer_vendor'=> $customer_ids,
                //               'timestamp'=>$datebills_start,
                //               // 'code_emp'=>$emp_outs,
                //               'subtotal'=> 0,
                //               'discount'=> $discounts,
                //               'vat'=> $vats,
                //               'vatmoney'=> 0,
                //               // 'wht'=> $withholds,
                //               'whtmoney'=> 0,
                //               'grandtotal'=> $debits_s,
                //               'type_journal' => 1,
                //               'id_type_ref_journal'=>$id_type_ref_journal,
                //               'timereal'=>date('Y-m-d H:i:s'),
                //               'list'=> $list];
                //
                //       DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);
                //   }
                // }


        // }




        // $connect1 = Connectdb::Databaseall();
        // $baseAc1 = $connect1['fsctaccount'];
        // // $branch_s = $request->get('branch_ids');
        // // $numbe_debt1_s = $request->get('numbe_debt1');
        // // $discounts_s = $request->get('discounts');
        // // $vat_percents_s = $request->get('vat_percents');
        // // $vat_prices_s = $request->get('vat_prices');
        // // $id_typejournal_s = $request->get('id_typejournals');
        // // $datebills_s = $request->get('datebills');
        // // $lists = $request->get('listtoled');
        // // $notes = $request->get('notetoled');
        // // $acctype = $request->get('account_no');
        // // $ins_debits = $request->get('ins_debit');
        // // $ins_credits = $request->get('ins_credit');
        // //
        // // $no_debts = $request->get('number_debts');
        // //
        // // dd($vat_percents_s);
        // // exit;
        //
        // // $number_bill = $request->get('number_debts');
        // // dd($number_bill);
        // // exit;
        // $ids = $request->get('id_indebt');
        // $comma_separated1 = implode(',', $ids);
        //
        // $sql1 = "SELECT * FROM $baseAc1.in_debt
        //
        //                 LEFT JOIN $baseAc1.po_detail
        //                 ON $baseAc1.in_debt.id_po = $baseAc1.po_detail.po_headid
        //
        //                 LEFT JOIN $baseAc1.good
        //                 ON $baseAc1.po_detail.materialid = $baseAc1.good.id
        //
        //                 LEFT JOIN $baseAc1.accounttype
        //                 ON $baseAc1.good.accounttype = $baseAc1.accounttype.id
        //
        //                 LEFT JOIN $baseAc1.supplier
        //                 ON $baseAc1.in_debt.id_po = $baseAc1.supplier.id
        //
        //                 WHERE $baseAc1.in_debt.id IN ($comma_separated1) AND po_detail.statususe = 1";
        // // exit;
        // $datas = DB::select($sql1);
        // dd($datas);
        // exit;
        //
        //
        // $arrInert = [
        //         'id'=>'',
        //         'dr'=>$grandtotal,
        //         'cr'=>'0',
        //         'acc_code'=>$acc_code,
        //         'branch'=>$branch_id,
        //         'status'=> 1,
        //         'number_bill'=> $number_bill,
        //         'customer_vendor'=>$customerid,
        //         'timestamp'=> $datebill,
        //         'code_emp'=> $emp_code,
        //         'subtotal'=> $subtotal,
        //         'discount'=> $discount,
        //         'vat'=> $vat,
        //         'vatmoney'=> $vatmoney,
        //         'wht'=> $wht,
        //         'whtmoney'=> $whtmoney,
        //         'grandtotal'=> $grandtotal,
        //         'type_journal'=> 1 ,
        //         'id_type_ref_journal'=> $id,
        //         'timereal'=>date('Y-m-d H:i:s'),
        //         'list'=> $list
        //       ];
        // DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);
        //
        // if($vat == 1) {
        //   $list = 'ภาษีมูลค่าเพิ่ม';
        //   $acc_code_vat = '119501';
        //     $arrInert = [
        //           'id'=>'',
        //           'dr'=> $vat_price,
        //           'cr'=> '0',
        //           'acc_code'=> $acc_code_vat,
        //           'branch'=> $branch_id,
        //           'status'=> 1,
        //           'number_bill'=> $number_bill,
        //           'customer_vendor'=> $customerid,
        //           'timestamp'=> $datebill,
        //           'code_emp'=> $emp_code,
        //           'subtotal'=> $subtotal,
        //           'discount'=> $discount,
        //           'vat'=> $vat,
        //           'vatmoney'=> $vatmoney,
        //           'wht'=> $wht,
        //           'whtmoney'=> $whtmoney,
        //           'grandtotal'=> $grandtotal,
        //           'type_journal'=> 1 ,
        //           'id_type_ref_journal'=> $id,
        //           'timereal'=>date('Y-m-d H:i:s'),
        //           'list'=> $list
        //         ];
        //   DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);
        // }
        //
        // if($vat == 3) {
        //   $list = 'ภาษีมูลค่าเพิ่ม';
        //   $acc_code_vat = '119501';
        //     $arrInert = [
        //           'id'=>'',
        //           'dr'=> $vat_price,
        //           'cr'=> '0',
        //           'acc_code'=> $acc_code_vat,
        //           'branch'=> $branch_id,
        //           'status'=> 1,
        //           'number_bill'=> $number_bill,
        //           'customer_vendor'=> $customerid,
        //           'timestamp'=> $datebill,
        //           'code_emp'=> $emp_code,
        //           'subtotal'=> $subtotal,
        //           'discount'=> $discount,
        //           'vat'=> $vat,
        //           'vatmoney'=> $vatmoney,
        //           'wht'=> $wht,
        //           'whtmoney'=> $whtmoney,
        //           'grandtotal'=> $grandtotal,
        //           'type_journal'=> 1 ,
        //           'id_type_ref_journal'=> $id,
        //           'timereal'=>date('Y-m-d H:i:s'),
        //           'list'=> $list
        //         ];
        //   DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);
        // }
        //
        // if($vat == 5) {
        //   $list = 'ภาษีมูลค่าเพิ่ม';
        //   $acc_code_vat = '119501';
        //     $arrInert = [
        //           'id'=>'',
        //           'dr'=> $vat_price,
        //           'cr'=> '0',
        //           'acc_code'=> $acc_code_vat,
        //           'branch'=> $branch_id,
        //           'status'=> 1,
        //           'number_bill'=> $number_bill,
        //           'customer_vendor'=> $customerid,
        //           'timestamp'=> $datebill,
        //           'code_emp'=> $emp_code,
        //           'subtotal'=> $subtotal,
        //           'discount'=> $discount,
        //           'vat'=> $vat,
        //           'vatmoney'=> $vatmoney,
        //           'wht'=> $wht,
        //           'whtmoney'=> $whtmoney,
        //           'grandtotal'=> $grandtotal,
        //           'type_journal'=> 1 ,
        //           'id_type_ref_journal'=> $id,
        //           'timereal'=>date('Y-m-d H:i:s'),
        //           'list'=> $list
        //         ];
        //   DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);
        // }
        //
        // if($vat == 7) {
        //   $list = 'ภาษีมูลค่าเพิ่ม';
        //   $acc_code_vat = '119501';
        //     $arrInert = [
        //           'id'=>'',
        //           'dr'=> $vat_price,
        //           'cr'=> '0',
        //           'acc_code'=> $acc_code_vat,
        //           'branch'=> $branch_id,
        //           'status'=> 1,
        //           'number_bill'=> $number_bill,
        //           'customer_vendor'=> $customerid,
        //           'timestamp'=> $datebill,
        //           'code_emp'=> $emp_code,
        //           'subtotal'=> $subtotal,
        //           'discount'=> $discount,
        //           'vat'=> $vat,
        //           'vatmoney'=> $vatmoney,
        //           'wht'=> $wht,
        //           'whtmoney'=> $whtmoney,
        //           'grandtotal'=> $grandtotal,
        //           'type_journal'=> 1 ,
        //           'id_type_ref_journal'=> $id,
        //           'timereal'=>date('Y-m-d H:i:s'),
        //           'list'=> $list
        //         ];
        //   DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);
        // }
        //
        // if($vat == 10) {
        //   $list = 'ภาษีมูลค่าเพิ่ม';
        //   $acc_code_vat = '119501';
        //     $arrInert = [
        //           'id'=>'',
        //           'dr'=> $vat_price,
        //           'cr'=> '0',
        //           'acc_code'=> $acc_code_vat,
        //           'branch'=> $branch_id,
        //           'status'=> 1,
        //           'number_bill'=> $number_bill,
        //           'customer_vendor'=> $customerid,
        //           'timestamp'=> $datebill,
        //           'code_emp'=> $emp_code,
        //           'subtotal'=> $subtotal,
        //           'discount'=> $discount,
        //           'vat'=> $vat,
        //           'vatmoney'=> $vatmoney,
        //           'wht'=> $wht,
        //           'whtmoney'=> $whtmoney,
        //           'grandtotal'=> $grandtotal,
        //           'type_journal'=> 1 ,
        //           'id_type_ref_journal'=> $id,
        //           'timereal'=>date('Y-m-d H:i:s'),
        //           'list'=> $list
        //         ];
        //   DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);
        // }
        //
        // if($discount != 0.00) {
        //   $list = 'ส่วนลด';
        //   $acc_code_discount = '412900';
        //     $arrInert = [
        //           'id'=>'',
        //           'dr'=> '0',
        //           'cr'=> $discount,
        //           'acc_code'=> $acc_code_discount,
        //           'branch'=> $branch_id,
        //           'status'=> 1,
        //           'number_bill'=> $number_bill,
        //           'customer_vendor'=> $customerid,
        //           'timestamp'=> $datebill,
        //           'code_emp'=> $emp_code,
        //           'subtotal'=> $subtotal,
        //           'discount'=> $discount,
        //           'vat'=> $vat,
        //           'vatmoney'=> $vatmoney,
        //           'wht'=> $wht,
        //           'whtmoney'=> $whtmoney,
        //           'grandtotal'=> $grandtotal,
        //           'type_journal'=> 1 ,
        //           'id_type_ref_journal'=> $id,
        //           'timereal'=>date('Y-m-d H:i:s'),
        //           'list'=> $list
        //         ];
        //   DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);
        // }
        // // DB::connection('mysql2')
        // //   ->table('in_debt')->whereIn('number_debt', $ids)
        // //   ->update(['accept' => 1]);
        // $querydata = DB::connection('mysql2')
        //     ->table('in_debt')
        //     ->select('in_debt.id as id_indebt','in_debt.number_debt','in_debt.accept','in_debt.branch_id','in_debt.discount'
        //     ,'in_debt.vat','in_debt.vat_price','in_debt.id_typejournal','in_debt.datebill','po_detail.list','po_detail.note'
        //     ,'accounttype.accounttypeno','accounttype.accounttypefull','po_detail.total','accounttype.config_group_supp_id','good.name'
        //     ,'accounttype.id as id_accounttype','po_head.supplier_id')
        //     ->join('po_head', 'in_debt.id_po', '=', 'po_head.id')
        //     ->join('po_detail', 'in_debt.id_po', '=', 'po_detail.po_headid')
        //     ->join('good', 'good.id', '=', 'po_detail.materialid')
        //     ->join('accounttype', 'accounttype.id', '=', 'good.accounttype')
        //     ->where('po_detail.statususe',1)
        //     ->whereIn('number_debt', $ids)
        //     ->get();
        // // dd($querydata);
        // // exit;
        // foreach ($querydata as $key => $querydata1) {
        //   dd($querydata);
        //   exit;
        //   for ($i=0; $i < $key; $i++) {
        //     $debit = $querydata[$i]->total;
        //     $credit = "0";
        //     $branch = $querydata[$i]->branch_id;
        //     $list = $querydata[$i]->list;
        //     $note = $querydata[$i]->note;
        //     $acc_code = $querydata[$i]->accounttypeno;
        //     $number_bill = $querydata[$i]->number_debt;
        //     $discount = $querydata[$i]->discount;
        //     $vat = $querydata[$i]->vat;
        //     $type_journal = "1";
        //     $id_type_ref_journal = $querydata[$i]->accounttypeno;
        //     $timereal = $querydata[$i]->datebill;
        //     echo $debit;
        //     exit;
        //   }
        // }
        //
        // // echo "<pre>";
        // // print_r($querydata);
        // // exit;
        // // $get_acccode = $querydata[0]->accounttypeno;
        // // $first_names = array_column($querydata, 'accounttypeno');
        // // dd($first_names);
        // // exit;
        // // for ($i = 0; $i < count($querydata->accounttypeno); $i++) {
        //
        // // foreach ($querydata as $key => $value ) {
        // //   if ($key = 1) {
        // //     $debit = $querydata[0]->total;
        // //     $credit = "0";
        // //     $branch = $querydata[0]->branch_id;
        // //     $list = $querydata[0]->list;
        // //     $note = $querydata[0]->note;
        // //     $acc_code = $querydata[0]->accounttypeno;
        // //     $number_bill = $querydata[0]->number_debt;
        // //     $discount = $querydata[0]->discount;
        // //     $vat = $querydata[0]->vat;
        // //     $type_journal = "1";
        // //     $id_type_ref_journal = $querydata[0]->accounttypeno;
        // //     $timereal = $querydata[0]->datebill;
        // //     echo $vat;
        // //     exit;
        // //   }
        // // }
        //
        // // elseif (condition) {
        // //   // code...
        // // }
        // // $debit = $querydata[1]->total;
        // // $credit = "0";
        // // $branch = $querydata[1]->branch_id;
        // // $list = $querydata[1]->list;
        // // $note = $querydata[1]->note;
        // // $acc_code = $querydata[1]->accounttypeno;
        // // $number_bill = $querydata[1]->number_debt;
        // // $discount = $querydata[1]->discount;
        // // $vat = $querydata[1]->vat;
        // // $type_journal = "1";
        // // $id_type_ref_journal = $querydata[1]->accounttypeno;
        // // $timereal = $querydata[1]->datebill;
        // // echo $debit;
        // // exit;
        //
        //
        //
        // // $accounttypeno = $querydata[0]->accounttypeno;
        // // $acccash = $accCode['acccash'];
        // // $number_bill = $datataxra[0]->number_taxinvoice;
        // // $customerid = $datataxra[0]->customerid;
        // // $subtotal = $datataxra[0]->subtotal;
        // // $discount = $datataxra[0]->discount;
        // // $discountmoney = $subtotal*($discount/100);
        // // $vat = $datataxra[0]->vat;
        // // $vatmoney = $datataxra[0]->vatmoney;
        // // $wht = $datataxra[0]->withhold;
        // // $whtmoney = $datataxra[0]->withholdmoney;
        // // $grandtotal = $datataxra[0]->grandtotal;
        //
        //   //     $answers[] = [
        //   //         // 'dr' => Sentinel::getUser()->id,
        //   //         'dr' =>
        //   //         'cr' =>
        //   //         'branch' =>
        //   //         'list' =>
        //   //         'note' =>
        //   //         'acc_code' =>
        //   //         'number_bill' =>
        //   //         'discount' =>
        //   //         'vat' =>
        //   //         // 'vatmoney' => $request->vat_prices[$i],
        //   //         'type_journal' =>
        //   //         'id_type_ref_journal' =>
        //   //         'timereal' =>
        //   //     ];
        //   // dd($answers);
        //
        //
        //
        // // if ($querydata->vat > 0) {
        // //   for ($i = 0; $i < count($request->id_journal_pay); $i++) {
        // //
        // //       $answers[] = [
        // //           // 'dr' => Sentinel::getUser()->id,
        // //           'dr' => $request->ins_debit[$i],
        // //           'cr' => $request->ins_credit[$i],
        // //           'branch' => $request->branch_ids[$i],
        // //           'list' => $request->listtoled[$i],
        // //           'note' => $request->notetoled[$i],
        // //           'acc_code' => $request->account_no[$i],
        // //           'number_bill' => $request->numbe_debt1[$i],
        // //           'discount' => $request->discounts[$i],
        // //           'vat' => $request->vat_percents[$i],
        // //           // 'vatmoney' => $request->vat_prices[$i],
        // //           'type_journal' => $request->id_typejournals[$i],
        // //           'id_type_ref_journal' => $request->id_journal_pay[$i],
        // //           'timereal' => $request->datebills[$i],
        // //       ];
        // //   }
        // // }
        //
        // // for ($i = 0; $i < count($request->id_journal_pay); $i++) {
        // //
        // //     $answers[] = [
        // //         // 'dr' => Sentinel::getUser()->id,
        // //         'dr' => $request->ins_debit[$i],
        // //         'cr' => $request->ins_credit[$i],
        // //         'branch' => $request->branch_ids[$i],
        // //         'list' => $request->listtoled[$i],
        // //         'note' => $request->notetoled[$i],
        // //         'acc_code' => $request->account_no[$i],
        // //         'number_bill' => $request->numbe_debt1[$i],
        // //         'discount' => $request->discounts[$i],
        // //         'vat' => $request->vat_percents[$i],
        // //         // 'vatmoney' => $request->vat_prices[$i],
        // //         'type_journal' => $request->id_typejournals[$i],
        // //         'id_type_ref_journal' => $request->id_journal_pay[$i],
        // //         'timereal' => $request->datebills[$i],
        // //     ];
        // // }
        //
        //
        //   // for ($i = 0; $i < count($request->id_journal_pay); $i++) {
        //   //     $answers[] = [
        //   //         // 'dr' => Sentinel::getUser()->id,
        //   //         'dr' => $request->ins_debit[$i],
        //   //         'cr' => $request->ins_credit[$i],
        //   //         'branch' => $request->branch_ids[$i],
        //   //         'list' => $request->listtoled[$i],
        //   //         'note' => $request->notetoled[$i],
        //   //         'acc_code' => $request->account_no[$i],
        //   //         'number_bill' => $request->numbe_debt1[$i],
        //   //         'discount' => $request->discounts[$i],
        //   //         'vat' => $request->vat_percents[$i],
        //   //         // 'vatmoney' => $request->vat_prices[$i],
        //   //         'type_journal' => $request->id_typejournals[$i],
        //   //         'id_type_ref_journal' => $request->id_journal_pay[$i],
        //   //         'timereal' => $request->datebills[$i],
        //   //     ];
        //   // }
        //
        //   // dd($answers);
        //   // exit;
        //   Ledger::insert($answers);










          // $branch_s = $request->get('branch_ids');
          // $numbe_debt1_s = $request->get('numbe_debt1');
          // $discounts_s = $request->get('discounts');
          // $vat_percents_s = $request->get('vat_percents');
          // $vat_prices_s = $request->get('vat_prices');
          // $id_typejournal_s = $request->get('id_typejournals');
          // $datebills_s = $request->get('datebills');
          // $lists = $request->get('listtoled');
          // $notes = $request->get('notetoled');
          // $acctype = $request->get('account_no');
          // $ins_debits = $request->get('ins_debit');
          // $ins_credits = $request->get('ins_credit');
          //
          // $no_debts = $request->get('number_debts');
          //
          // $ref  =  $request->get('id_journal_pay');

          // dd($ref);
          // exit;
            // foreach ($ref as $key => $value) {
            //   $ins_ledger = new Ledger;
            //   $ins_ledger->setConnection('mysql2');
            //
            //   $ins_ledger->dr = $request->get('ins_debit');
            //   $ins_ledger->cr = $request->get('ins_credit');
            //   $ins_ledger->branch = $branch_s[$key];
            //   $ins_ledger->list = $lists[$key];
            //   $ins_ledger->note = $notes[$key];
            //   $ins_ledger->acc_code = $acctype[$key];
            //   $ins_ledger->number_bill = $numbe_debt1_s[$key];
            //   $ins_ledger->discount = $request->get('discounts');
            //   $ins_ledger->vat = $request->get('vat_percents');
            //   $ins_ledger->vatmoney = $request->get('vat_prices');
            //   $ins_ledger->type_journal = $id_typejournal_s[$key];
            //   $ins_ledger->id_type_ref_journal = $value;
            //   $ins_ledger->timereal = $datebills_s[$key];

              // $ins_ledger->dr = $request->get('ins_debit');
              // $ins_ledger->cr = $request->get('ins_credit');
              // $ins_ledger->branch = $request->get('branch_ids');
              // $ins_ledger->list = $request->get('listtoled');
              // $ins_ledger->note = $request->get('notetoled');
              // $ins_ledger->acc_code = $request->get('account_no');
              // $ins_ledger->number_bill = $request->get('numbe_debt1');
              // $ins_ledger->discount = $request->get('discounts');
              // $ins_ledger->vat = $request->get('vat_percents');
              // $ins_ledger->vatmoney = $request->get('vat_prices');
              // $ins_ledger->type_journal = $request->get('id_typejournals');
              // $ins_ledger->id_type_ref_journal = $request->get('id_journal_pay');
              // $ins_ledger->timereal = $request->get('datebills');
              // dd($ins_ledger);
              // exit;
            //   $ins_ledger->save();
            // }

            // $answer = new Answers;
            // $data = $request->all();
            //  foreach ( $request->get('answer') as $answer) {
            //     $answers[] = [
            //         'username' => Auth::user()->name,
            //         'category' => $request->category,
            //         'year' => $request->year,
            //         'correct_answer' => $answer,
            //         'question_id' => $request->question_id,
            //     ];
            //   }
            // dd($answers);


            // $order_details = [];
            // for($i= 0; $i < count($product); $i++){
            //     $order_details[] = [
            //         'dr' => $product['product_id'][$i],
            //         'cr' => $product['product_id'][$i],
            //         'branch' => $product['quantity'][$i],
            //         'list' => $product['price'][$i],
            //         'note' => $product['amount'][$i],
            //         'acc_code' => $product['price'][$i],
            //         'number_bill' => $product['amount'][$i],
            //         'discount' => $product['price'][$i],
            //         'vat' => $product['amount'][$i],
            //         'vatmoney' => $product['price'][$i],
            //         'type_journal' => $product['amount'][$i],
            //         'id_type_ref_journal' => $product['price'][$i],
            //         'timereal' => $product['amount'][$i],
            //     ];
            // }
            // \DB::table('order_details')->insert($order_details);

          // $ins_ledger = new Ledger;
          // $ins_ledger->setConnection('mysql2');
          // $ins_ledger->branch = $request->get('branch_ids');
          // $ins_ledger->number_bill = $request->get('numbe_debt1');
          // $ins_ledger->discount = $request->get('discounts');
          // $ins_ledger->vat = $request->get('vat_percents');
          // $ins_ledger->vatmoney = $request->get('vat_prices');
          // $ins_ledger->type_journal = $request->get('id_typejournals');
          // $ins_ledger->id_type_ref_journal = $request->get('id_journal_pay');
          // $ins_ledger->timereal = $request->get('datebills');
          // // echo $request->get('id_journal_pay');
          // // exit;
          // $ins_ledger->save();

        // $id_debt = $request->get('id_journal_pay');
        // $comma_separated1 = implode(",", $id_debt);
        // if ($request->get('number_debts')) {
        //   $list_ap = $request->get('number_debts');
        //   // $arr = [];
        //   // foreach ($list_ap as $key => $value) {
        //   //   $arr[] = "'".$value."'";
        //   // }
        //   // print_r($arr);
        //   // exit;
        //   $comma_separated2 = implode(',' , "'.$arr.'");
        // }
        // $subjects = implode(',', $_POST['subject']);
        //
        // $sql1 = "UPDATE $baseAc1.in_debt
        //          SET $baseAc1.in_debt.accept = '1'
        //          WHERE $baseAc1.in_debt.number_debt IN($comma_separated2)";
        // // echo $sql1;
        // // exit;
        // $sql_finish1 = DB::select($sql1);

        // $UpdateDetails = User::where('email', $userEmail)->first();
        //
        // if (is_null($UpdateDetails)) {
        //     return false;
        // }
        // $debts = Debt::whereIn('number_debt' , '=' , $comma_separated)->get();
        // foreach ($debts as $key => $debt) {
        //     $debt->accept = 1;
        //     $debt->update();
        // }
        SWAL::message('สำเร็จ', 'ได้ทำการผ่านรายการแล้ว!', 'success', ['timer' => 6000]);
        return redirect()->route('journal.debt');
    }
}
