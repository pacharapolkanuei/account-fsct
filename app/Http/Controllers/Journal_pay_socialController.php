<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Api\Datetime;
use App\Branch;
use App\Ledger;
use App\Api\Connectdb;
use Illuminate\Support\Facades\Input;

class Journal_pay_socialController extends Controller
{
    public function index()
    {
      // $connect1 = Connectdb::Databaseall();
      // $baseAc1 = $connect1['fsctaccount'];
      // $baseHr1 = $connect1['hr_base'];
      //
      // $sql1 = "SELECT $baseHr1.ADD_DEDUCT_HISTORY.*
      //
      //
      //           FROM $baseHr1.ADD_DEDUCT_HISTORY
      //
      //           LEFT JOIN $baseHr1.emp_data
      //           ON $baseHr1.ADD_DEDUCT_HISTORY.ADD_DEDUCT_THIS_MONTH_EMP_ID = $baseHr1.emp_data.idcard_no
      //
      //           WHERE $baseHr1.ADD_DEDUCT_HISTORY.ADD_DEDUCT_THIS_MONTH_TMP_ID = 38
      //           ORDER BY ADD_DEDUCT_THIS_MONTH_PAY_DATE ASC";
      //
      // $datas = DB::select($sql1);
      // $ap = 'default';
      //
      $branchs = Branch::where('status_main',1)->get();
      // // dd($datas);

        return view('journal.journal_pay_social', compact('branchs'));
    }



    public function journalpay_filter_social()
    {
        // echo "<pre>";
        $data = Input::all();
        $db = Connectdb::Databaseall();



         $branch = $data['branch'];
         $dateset = Datetime::convertStartToEnd($data['daterange']);
         $start = $dateset['start'];
         $end = $dateset['end'];

        if($branch=='all'){
              $sqlwage = "SELECT  $db[hr_base].WAGE_HISTORY.*,
                                       $db[hr_base].emp_data.nameth,
                                       $db[hr_base].emp_data.surnameth,
                                       $db[hr_base].emp_data.branch_id,
                                       $db[hr_base].emp_data.statussalaryboss
                          FROM $db[hr_base].WAGE_HISTORY
                          INNER JOIN $db[hr_base].emp_data
                          ON $db[hr_base].WAGE_HISTORY.WAGE_EMP_ID = $db[hr_base].emp_data.idcard_no
                          WHERE $db[hr_base].WAGE_HISTORY.WAGE_THIS_MONTH_BANK_CONFIRM_DATE BETWEEN '$start'  AND '$end' ";
        }else{
               $sqlwage = "SELECT  $db[hr_base].WAGE_HISTORY.*,
                                   $db[hr_base].emp_data.nameth,
                                   $db[hr_base].emp_data.surnameth,
                                   $db[hr_base].emp_data.branch_id,
                                   $db[hr_base].emp_data.statussalaryboss
                          FROM $db[hr_base].WAGE_HISTORY
                          INNER JOIN $db[hr_base].emp_data
                          ON $db[hr_base].WAGE_HISTORY.WAGE_EMP_ID = $db[hr_base].emp_data.idcard_no
                          WHERE $db[hr_base].WAGE_HISTORY.WAGE_THIS_MONTH_BANK_CONFIRM_DATE BETWEEN '$start'  AND '$end'
                          AND $db[hr_base].emp_data.branch_id =  '$branch' ";
        }
        $datasaraly = DB::select($sqlwage);
        $branchs = Branch::get();
        return view('journal.journal_pay_social', compact('branchs','datasaraly'));

        // $connect1 = Connectdb::Databaseall();
        // $baseAc1 = $connect1['fsctaccount'];
        // $baseHr1 = $connect1['hr_base'];
        //
        // $branchs = new Branch;
        // $branchs = Branch::get();
        // $type_paids = $request->get('type_paid');
        // $date = $request->get('daterange');
        // $branch = $request->get('branch');
        //

        //
        //
        //   if ($branch != '0') {
        //       $datas = DB::connection('mysql2')
        //           ->table("inform_po_mainhead")
        //           ->leftjoin("po_detail", DB::raw("FIND_IN_SET(po_detail.po_headid,inform_po_mainhead.po_id)"), ">", DB::raw("'0'"))
        //           ->join('good', 'good.id', '=', 'po_detail.materialid')
        //           ->join('accounttype', 'accounttype.id', '=', 'good.accounttype')
        //           ->orderBy('payser_number', 'asc')
        //           ->where('po_detail.statususe', '=', '1')
        //           ->whereBetween('datebill', [$start, $end])
        //           ->where('branch_id', $branch)
        //           ->get();
        //   } else {
        //       $datas = DB::connection('mysql2')
        //           ->table("inform_po_mainhead")
        //           ->leftjoin("po_detail", DB::raw("FIND_IN_SET(po_detail.po_headid,inform_po_mainhead.po_id)"), ">", DB::raw("'0'"))
        //           ->join('good', 'good.id', '=', 'po_detail.materialid')
        //           ->join('accounttype', 'accounttype.id', '=', 'good.accounttype')
        //           ->orderBy('payser_number', 'asc')
        //           ->where('po_detail.statususe', '=', '1')
        //           ->whereBetween('datebill', [$start, $end])
        //           ->get();
        //   }
        //   $ap = 'default';
        //
        //
        //   if ($branch != '0') {
        //       $journal_pays = DB::connection('mysql')
        //           ->table("WAGE_HISTORY")
        //           // ->select(DB::raw("SUM(WAGE_HISTORY.WAGE_NET_SALARY) as WAGE_NET_SALARY"))
        //           // ->select('WAGE_HISTORY', 'WAGE_THIS_MONTH_BANK_CONFIRM_STATUS as status_fil')
        //           // ->select('WAGE_HISTORY', 'WAGE_THIS_MONTH_BANK_CONFIRM_DATE as datepay_fil')
        //           ->join('emp_data', 'emp_data.idcard_no', '=', 'WAGE_HISTORY.WAGE_EMP_ID')
        //           ->join('branch', 'branch.code_branch', '=', 'emp_data.branch_id')
        //           ->whereBetween('WAGE_THIS_MONTH_BANK_CONFIRM_DATE', [$start, $end])
        //           ->where('code_branch', $branch)
        //           ->get();
        //   } else {
        //     $journal_pays = DB::connection('mysql')
        //         ->table("WAGE_HISTORY")
        //         // ->select(DB::raw("SUM(WAGE_HISTORY.WAGE_NET_SALARY) as WAGE_NET_SALARY"))
        //         // ->select('WAGE_HISTORY', 'WAGE_THIS_MONTH_BANK_CONFIRM_STATUS as status_fil')
        //         // ->select('WAGE_HISTORY', 'WAGE_THIS_MONTH_BANK_CONFIRM_DATE as datepay_fil')
        //         ->join('emp_data', 'emp_data.idcard_no', '=', 'WAGE_HISTORY.WAGE_EMP_ID')
        //         ->join('branch', 'branch.code_branch', '=', 'emp_data.branch_id')
        //         ->whereBetween('WAGE_THIS_MONTH_BANK_CONFIRM_DATE', [$start, $end])
        //         ->get();
        //   }
        //   $salas = 'default';
        //
        // // if ($type_paids == 1) {
        // //   return view('journal.journal_pay', compact('datas', 'ap', 'branchs'));
        // // }
        // // else {
        // //   return view('journal.journal_pay', compact('journal_pays', 'salas', 'branchs'));
        // // }
        // return view('journal.journal_pay', compact('datas', 'ap', 'branchs', 'journal_pays' , 'salas'));
        // return view('journal.journal_pay', compact('datas', 'ap', 'branchs'));
    }


    public function confirm_journal_pay_social()
    {

      $data = Input::all();
      $db = Connectdb::Databaseall();

      // print_r($data);

      $datack = $data['check_list'];

      foreach ($datack as $key => $value) {
               $id = $value;

               $sqlUpdate = ' UPDATE '.$db['hr_base'].'.WAGE_HISTORY
             					  SET status_ap = "1"
             					  WHERE '.$db['hr_base'].'.WAGE_HISTORY.WAGE_ID = "'.$id.'" ';
         			 $lgUpdateResulte = DB::connection('mysql')->select($sqlUpdate);

               $sqlwage = "SELECT  $db[hr_base].WAGE_HISTORY.*,
                                       $db[hr_base].emp_data.nameth,
                                       $db[hr_base].emp_data.surnameth,
                                       $db[hr_base].emp_data.branch_id,
                                       $db[hr_base].emp_data.statussalaryboss
                          FROM $db[hr_base].WAGE_HISTORY
                          INNER JOIN $db[hr_base].emp_data
                          ON $db[hr_base].WAGE_HISTORY.WAGE_EMP_ID = $db[hr_base].emp_data.idcard_no
                          WHERE $db[hr_base].WAGE_HISTORY.WAGE_ID = '$id'  ";
                    $datawage = DB::select($sqlwage);



                //  เงินเดือน  //
                $datelastmonth = substr($datawage[0]->WAGE_THIS_MONTH_BANK_CONFIRM_DATE,0,7);
                $timestamp = date("Y-m-t", strtotime($datelastmonth));
                $number_bill = $datelastmonth.'/'.$datawage[0]->WAGE_THIS_MONTH_ROW_NUM;

                $exportmounth = explode("-",$datelastmonth);
                $monthshow = Datetime::mappingMonth($exportmounth[1]);
                $yearthis = $exportmounth[0]+543;
                $accwage = '';
                if($datawage[0]->statussalaryboss==1){
                    $accwage =  "621106";
                }else{
                    $accwage =  "621101";
                }

                $list = 'เงินเดือน '.$monthshow.'  '.$yearthis.' ของ '.$datawage[0]->nameth.'  '.$datawage[0]->surnameth ;
                $arrInert = [ 'id'=>'',
                        'dr'=>$datawage[0]->WAGE_SALARY,
                        'cr'=>0.00,
                        'acc_code'=>$accwage,
                        'branch'=>$datawage[0]->branch_id,
                        'status'=> 1,
                        'number_bill'=> $number_bill,
                        'customer_vendor'=>$datawage[0]->WAGE_EMP_ID,
                        'timestamp'=>$timestamp,
                        'code_emp'=> '1002',
                        'subtotal'=> 0,
                        'discount'=> 0,
                        'vat'=> 0,
                        'vatmoney'=> 0,
                        'wht'=> 0,
                        'whtmoney'=> 0,
                        'grandtotal'=> $datawage[0]->WAGE_SALARY,
                        'type_income'=>'1' ,
                        'type_journal'=>3 ,
                        'id_type_ref_journal'=>$id,
                        'timereal'=>date('Y-m-d H:i:s'),
                        'list'=> $list,
                        'type_buy'=>0];

                DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);

                // SSO
                $idcard = $datawage[0]->WAGE_EMP_ID;
                $exportmounth = explode("-",$datelastmonth);
                $dateset = $exportmounth[1].'-'.$exportmounth[0];
                $sqlsso = "SELECT  $db[hr_base].ADD_DEDUCT_HISTORY.*
                            FROM $db[hr_base].ADD_DEDUCT_HISTORY
                            WHERE $db[hr_base].ADD_DEDUCT_HISTORY.ADD_DEDUCT_THIS_MONTH_EMP_ID = '$idcard'
                            AND $db[hr_base].ADD_DEDUCT_HISTORY.ADD_DEDUCT_THIS_MONTH_PAY_DATE = '$dateset'
                            AND $db[hr_base].ADD_DEDUCT_HISTORY.ADD_DEDUCT_THIS_MONTH_TMP_NAME = 'ประกันสังคม'  ";
                $datasso = DB::select($sqlsso);
                $idthis = $datasso[0]->ADD_DEDUCT_THIS_MONTH_ID;
                if(!empty($datasso[0]->ADD_DEDUCT_THIS_MONTH_AMOUNT!='0.00')){
                    $list = 'ค่าใช้จ่ายในการบริหาร-เงินสมทบกองทุนประกันสังคม เดือน '.$monthshow.'  '.$yearthis.' ของ '.$datawage[0]->nameth.'  '.$datawage[0]->surnameth ;
                    $arrInert = [ 'id'=>'',
                            'dr'=>$datasso[0]->ADD_DEDUCT_THIS_MONTH_AMOUNT,
                            'cr'=>0.00,
                            'acc_code'=>'621151',
                            'branch'=>$datawage[0]->branch_id,
                            'status'=> 1,
                            'number_bill'=> $number_bill,
                            'customer_vendor'=>$datawage[0]->WAGE_EMP_ID,
                            'timestamp'=>$timestamp,
                            'code_emp'=> '1002',
                            'subtotal'=> 0,
                            'discount'=> 0,
                            'vat'=> 0,
                            'vatmoney'=> 0,
                            'wht'=> 0,
                            'whtmoney'=> 0,
                            'grandtotal'=> $datasso[0]->ADD_DEDUCT_THIS_MONTH_AMOUNT,
                            'type_income'=>'1' ,
                            'type_journal'=>3 ,
                            'id_type_ref_journal'=>$idthis,
                            'timereal'=>date('Y-m-d H:i:s'),
                            'list'=> $list,
                            'type_buy'=>0];

                    DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);
                }

                // เงินเพิ่ม //
                $sqladddeduc = "SELECT  sum(ADD_DEDUCT_THIS_MONTH_AMOUNT) as ADD_DEDUCT_THIS_MONTH_AMOUNT,
                                        $db[hr_base].ADD_DEDUCT_TEMPLATE.accounting_code_pk
                            FROM $db[hr_base].ADD_DEDUCT_HISTORY
                            INNER JOIN $db[hr_base].ADD_DEDUCT_TEMPLATE
                            ON  $db[hr_base].ADD_DEDUCT_HISTORY.ADD_DEDUCT_THIS_MONTH_TMP_ID = $db[hr_base].ADD_DEDUCT_TEMPLATE.ADD_DEDUCT_TEMPLATE_ID
                            WHERE $db[hr_base].ADD_DEDUCT_HISTORY.ADD_DEDUCT_THIS_MONTH_EMP_ID = '$idcard'
                            AND $db[hr_base].ADD_DEDUCT_HISTORY.ADD_DEDUCT_THIS_MONTH_PAY_DATE = '$dateset'
                            AND $db[hr_base].ADD_DEDUCT_HISTORY.ADD_DEDUCT_THIS_MONTH_TYPE = '1'
                            GROUP BY  $db[hr_base].ADD_DEDUCT_TEMPLATE.accounting_code_pk ";

                $datadddeduc = DB::select($sqladddeduc);
                foreach ($datadddeduc as $q => $r) {
                    $accthis = $r->accounting_code_pk;
                    $list = '';
                    $sqlacc = "SELECT $db[fsctaccount].accounttype.*
                                 FROM $db[fsctaccount].accounttype
                                 WHERE $db[fsctaccount].accounttype.accounttypeno = '$accthis'";
                    $dataaccname = DB::connection('mysql')->select($sqlacc);
                    if(!empty($dataaccname)){
                          $list =  $dataaccname[0]->accounttypefull;
                    }

                    $arrInert = [ 'id'=>'',
                            'dr'=>$r->ADD_DEDUCT_THIS_MONTH_AMOUNT,
                            'cr'=>0.00,
                            'acc_code'=>$accthis,
                            'branch'=>$datawage[0]->branch_id,
                            'status'=> 1,
                            'number_bill'=> $number_bill,
                            'customer_vendor'=>$datawage[0]->WAGE_EMP_ID,
                            'timestamp'=>$timestamp,
                            'code_emp'=> '1002',
                            'subtotal'=> 0,
                            'discount'=> 0,
                            'vat'=> 0,
                            'vatmoney'=> 0,
                            'wht'=> 0,
                            'whtmoney'=> 0,
                            'grandtotal'=> $r->ADD_DEDUCT_THIS_MONTH_AMOUNT,
                            'type_income'=>'1' ,
                            'type_journal'=>3 ,
                            'id_type_ref_journal'=>$id,
                            'timereal'=>date('Y-m-d H:i:s'),
                            'list'=> $list,
                            'type_buy'=>0];

                    DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);
                }


                // SSO ค้่างจ่าย  ///
                $sqlsso = "SELECT  $db[hr_base].ADD_DEDUCT_HISTORY.*
                            FROM $db[hr_base].ADD_DEDUCT_HISTORY
                            WHERE $db[hr_base].ADD_DEDUCT_HISTORY.ADD_DEDUCT_THIS_MONTH_EMP_ID = '$idcard'
                            AND $db[hr_base].ADD_DEDUCT_HISTORY.ADD_DEDUCT_THIS_MONTH_PAY_DATE = '$dateset'
                            AND $db[hr_base].ADD_DEDUCT_HISTORY.ADD_DEDUCT_THIS_MONTH_TMP_NAME = 'ประกันสังคม'  ";
                $datasso = DB::select($sqlsso);
                if(!empty($datasso[0]->ADD_DEDUCT_THIS_MONTH_AMOUNT!='0.00')){
                    $list = 'เงินสมทบประกันสังคมค้างจ่าย เดือน '.$monthshow.'  '.$yearthis.' ของ '.$datawage[0]->nameth.'  '.$datawage[0]->surnameth ;
                    $arrInert = [ 'id'=>'',
                            'dr'=>0,
                            'cr'=>$datasso[0]->ADD_DEDUCT_THIS_MONTH_AMOUNT*2,
                            'acc_code'=>'219102',
                            'branch'=>$datawage[0]->branch_id,
                            'status'=> 1,
                            'number_bill'=> $number_bill,
                            'customer_vendor'=>$datawage[0]->WAGE_EMP_ID,
                            'timestamp'=>$timestamp,
                            'code_emp'=> '1002',
                            'subtotal'=> 0,
                            'discount'=> 0,
                            'vat'=> 0,
                            'vatmoney'=> 0,
                            'wht'=> 0,
                            'whtmoney'=> 0,
                            'grandtotal'=> $datasso[0]->ADD_DEDUCT_THIS_MONTH_AMOUNT*2,
                            'type_income'=>'1' ,
                            'type_journal'=>3 ,
                            'id_type_ref_journal'=>$id,
                            'timereal'=>date('Y-m-d H:i:s'),
                            'list'=> $list,
                            'type_buy'=>0];

                    DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);
                }


                $sqllost = "SELECT  sum(ADD_DEDUCT_THIS_MONTH_AMOUNT) as ADD_DEDUCT_THIS_MONTH_AMOUNT
                            FROM $db[hr_base].ADD_DEDUCT_HISTORY
                            WHERE $db[hr_base].ADD_DEDUCT_HISTORY.ADD_DEDUCT_THIS_MONTH_EMP_ID = '$idcard'
                            AND $db[hr_base].ADD_DEDUCT_HISTORY.ADD_DEDUCT_THIS_MONTH_PAY_DATE = '$dateset'
                            AND  $db[hr_base].ADD_DEDUCT_HISTORY.ADD_DEDUCT_THIS_MONTH_TMP_ID  IN(21,20)  ";
                $datalost = DB::select($sqllost);
                if(!empty($datalost[0]->ADD_DEDUCT_THIS_MONTH_AMOUNT) AND $datalost[0]->ADD_DEDUCT_THIS_MONTH_AMOUNT !='0.00'){
                    $list = 'มาสาย หักขาด ลากิจ เดือน '.$monthshow.'  '.$yearthis.' ของ '.$datawage[0]->nameth.'  '.$datawage[0]->surnameth ;
                    $arrInert = [ 'id'=>'',
                            'dr'=>0.00,
                            'cr'=>$datalost[0]->ADD_DEDUCT_THIS_MONTH_AMOUNT,
                            'acc_code'=>$accwage,
                            'branch'=>$datawage[0]->branch_id,
                            'status'=> 1,
                            'number_bill'=> $number_bill,
                            'customer_vendor'=>$datawage[0]->WAGE_EMP_ID,
                            'timestamp'=>$timestamp,
                            'code_emp'=> '1002',
                            'subtotal'=> 0,
                            'discount'=> 0,
                            'vat'=> 0,
                            'vatmoney'=> 0,
                            'wht'=> 0,
                            'whtmoney'=> 0,
                            'grandtotal'=> $datalost[0]->ADD_DEDUCT_THIS_MONTH_AMOUNT,
                            'type_income'=>'1' ,
                            'type_journal'=>3 ,
                            'id_type_ref_journal'=>$id,
                            'timereal'=>date('Y-m-d H:i:s'),
                            'list'=> $list,
                            'type_buy'=>0];

                    DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);

                }


                $sqladddeduc = "SELECT  sum(ADD_DEDUCT_THIS_MONTH_AMOUNT) as ADD_DEDUCT_THIS_MONTH_AMOUNT,
                                        $db[hr_base].ADD_DEDUCT_TEMPLATE.accounting_code_pk
                            FROM $db[hr_base].ADD_DEDUCT_HISTORY
                            INNER JOIN $db[hr_base].ADD_DEDUCT_TEMPLATE
                            ON  $db[hr_base].ADD_DEDUCT_HISTORY.ADD_DEDUCT_THIS_MONTH_TMP_ID = $db[hr_base].ADD_DEDUCT_TEMPLATE.ADD_DEDUCT_TEMPLATE_ID
                            WHERE $db[hr_base].ADD_DEDUCT_HISTORY.ADD_DEDUCT_THIS_MONTH_EMP_ID = '$idcard'
                            AND $db[hr_base].ADD_DEDUCT_HISTORY.ADD_DEDUCT_THIS_MONTH_PAY_DATE = '$dateset'
                            AND $db[hr_base].ADD_DEDUCT_HISTORY.ADD_DEDUCT_THIS_MONTH_TYPE = '2'
                            AND  $db[hr_base].ADD_DEDUCT_HISTORY.ADD_DEDUCT_THIS_MONTH_TMP_NAME NOT LIKE '%ประกันสังคม%'
                            AND  $db[hr_base].ADD_DEDUCT_HISTORY.ADD_DEDUCT_THIS_MONTH_TMP_ID NOT IN(21,38,20)
                            GROUP BY  $db[hr_base].ADD_DEDUCT_TEMPLATE.accounting_code_pk  ";
                $datadddeduc = DB::select($sqladddeduc);

                foreach ($datadddeduc as $b => $a) {
                   if($a->ADD_DEDUCT_THIS_MONTH_AMOUNT!='0.00'){

                       $accthis = $a->accounting_code_pk;
                       $list = '';
                       $sqlacc = "SELECT $db[fsctaccount].accounttype.*
                                    FROM $db[fsctaccount].accounttype
                                    WHERE $db[fsctaccount].accounttype.accounttypeno = '$accthis'";
                       $dataaccname = DB::connection('mysql')->select($sqlacc);
                       if(!empty($dataaccname)){
                             $list =  $dataaccname[0]->accounttypefull;
                       }

                       $arrInert = [ 'id'=>'',
                               'dr'=>0.00,
                               'cr'=>$a->ADD_DEDUCT_THIS_MONTH_AMOUNT,
                               'acc_code'=>$accthis,
                               'branch'=>$datawage[0]->branch_id,
                               'status'=> 1,
                               'number_bill'=> $number_bill,
                               'customer_vendor'=>$datawage[0]->WAGE_EMP_ID,
                               'timestamp'=>$timestamp,
                               'code_emp'=> '1002',
                               'subtotal'=> 0,
                               'discount'=> 0,
                               'vat'=> 0,
                               'vatmoney'=> 0,
                               'wht'=> 0,
                               'whtmoney'=> 0,
                               'grandtotal'=> $a->ADD_DEDUCT_THIS_MONTH_AMOUNT,
                               'type_income'=>'1' ,
                               'type_journal'=>3 ,
                               'id_type_ref_journal'=>$id,
                               'timereal'=>date('Y-m-d H:i:s'),
                               'list'=> $list,
                               'type_buy'=>0];

                       DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);

                   }
                }


              

              $list = 'เงินฝากออมทรัพย์ KBANK 587-2-25765-0 (เชียงใหม่)	';
              $arrInert = [ 'id'=>'',
                      'dr'=>0.00,
                      'cr'=>$datawage[0]->WAGE_NET_SALARY,
                      'acc_code'=>'112027',
                      'branch'=>$datawage[0]->branch_id,
                      'status'=> 1,
                      'number_bill'=> $number_bill,
                      'customer_vendor'=>$datawage[0]->WAGE_EMP_ID,
                      'timestamp'=>$timestamp,
                      'code_emp'=> '1002',
                      'subtotal'=> 0,
                      'discount'=> 0,
                      'vat'=> 0,
                      'vatmoney'=> 0,
                      'wht'=> 0,
                      'whtmoney'=> 0,
                      'grandtotal'=> $datawage[0]->WAGE_NET_SALARY,
                      'type_income'=>'1' ,
                      'type_journal'=>3 ,
                      'id_type_ref_journal'=>$id,
                      'timereal'=>date('Y-m-d H:i:s'),
                      'list'=> $list,
                      'type_buy'=>0];

              DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);



      }
      $datamsg = true;
      $branchs = Branch::get();
      return view('journal.journal_pay_social', compact('branchs','datamsg'));

        // $check_list = $request->get('check_list');
        // dd($check_list);
        // exit;
        // $ids = $request->get('numbe_debt1');
        // $journal_pay = DB::connection('mysql2')
        //     ->table('inform_po_mainhead')
        //     ->whereIn('payser_number', $ids)
        //     ->update(['accept' => 1]);
        //
        // // $ids = $request->get('numbe_debt1');
        // // dd($ids);
        // // exit;
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
        //           'wht' => $request->wht_percent[$i],
        //           // 'vatmoney' => $request->vat_prices[$i],
        //           'type_journal' => $request->id_typejournals[$i],
        //           'id_type_ref_journal' => $request->id_journal_pay[$i],
        //           'timereal' => $request->datebills[$i],
        //       ];
        //   }
        //   // dd($answers);
        //   // exit;
        //   Ledger::insert($answers);
        // // $ref  =  $request->get('id_journal_pay');
        // //
        // // $branch = $request->get('branch_ids');
        // // $number_bill = $request->get('numbe_debt1');
        // // $discount = $request->get('discounts');
        // // $vat = $request->get('vat_percents');
        // // $vatmoney = $request->get('vat_prices');
        // // $type_journal = $request->get('id_typejournals');
        // // $id_type_ref_journal = $request->get('id_bill_rents');
        // // $timereal = $request->get('datebills');
        // // $debitcredit = $request->get('decredit');
        // //
        // // $no_debts = $request->get('check_list');
        // // // dd($no_debts);
        // // // exit;
        // //
        // // foreach ($no_debts as $key => $value) {
        // //   $ins_ledger = new Ledger;
        // //   $ins_ledger->setConnection('mysql2');
        // //
        // //   $ins_ledger->dr = $debitcredit[$key];
        // //   $ins_ledger->cr = $debitcredit[$key];
        // //   $ins_ledger->branch = $branch[$key];
        // //   $ins_ledger->number_bill = $value;
        // //   $ins_ledger->discount = $discount[$key];
        // //   $ins_ledger->vat = $vat[$key];
        // //   $ins_ledger->vatmoney = $vatmoney[$key];
        // //   $ins_ledger->type_journal = $type_journal[$key];
        // //   $ins_ledger->id_type_ref_journal = $id_type_ref_journal[$key];
        // //   $ins_ledger->timereal = $timereal[$key];
        // //   // dd($ins_ledger);
        // //   // exit;
        // //   $ins_ledger->save();
        // // }
        //
        // return redirect()->route('journal.pay');
    }
}
