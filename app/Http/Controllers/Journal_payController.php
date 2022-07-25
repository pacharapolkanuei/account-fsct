<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;
use App\Api\Datetime;
use App\Branch;
use App\Ledger;
use App\Api\Connectdb;
use Illuminate\Support\Facades\Input;
use Softon\SweetAlert\Facades\SWAL;

class Journal_payController extends Controller
{
    public function index()
    {
      $connect1 = Connectdb::Databaseall();
      $baseAc1 = $connect1['fsctaccount'];
      $baseHr1 = $connect1['hr_base'];

      $start = "2020-01-01";
      $end = "2020-12-31";
      // $db = Connectdb::Databaseall();
      //   $datas = DB::connection('mysql2')
      //       ->table("inform_po_mainhead")
      //       ->leftjoin("po_detail", DB::raw("FIND_IN_SET(po_detail.po_headid,inform_po_mainhead.po_id)"), ">", DB::raw("'0'"))
      //       ->join('good', 'good.id', '=', 'po_detail.materialid')
      //       ->join('accounttype', 'accounttype.id', '=', 'good.accounttype')
      //       ->leftjoin("supplier", DB::raw("FIND_IN_SET(supplier.id,inform_po_mainhead.po_id)"), ">", DB::raw("'0'"))
      //       ->leftjoin("initial", DB::raw("FIND_IN_SET(initial.per,supplier.pre)"), ">", DB::raw("'0'"))
      //       ->orderBy('payser_number', 'asc')
      //       ->where('po_detail.statususe', '=', '1')
      //       ->get();
      //   // dd($datas);
      //   // exit;
      //   $ap = 'default';
// --------------------------------------------
      // LEFT JOIN $baseAc1.supplier
      // ON $baseAc1.inform_po.id_po = $baseAc1.supplier.id
      //
      // LEFT JOIN $baseAc1.initial
      // ON $baseAc1.supplier.pre = $baseAc1.initial.per
      //
      // LEFT JOIN $baseAc1.po_head
      // ON $baseAc1.inform_po.id_po = $baseAc1.po_head.id
                                              // ,po_head.totolsumreal
                                              // ,initial.statusperson
//-----------------------------------------------
        $sql1 = "SELECT $baseAc1.inform_po.*
                                        ,inform_po.id as id_ref
                                        ,po_detail.list
                                        ,po_detail.note
                                        ,accounttype.accounttypeno
                                        ,accounttype.accounttypefull
                                        ,po_detail.total
                                        ,accounttype.id as id_accounttype
                                        ,po_head.totolsumreal
                                        ,initial.statusperson
                                        ,inform_po.type_newtable
                                        ,po_head.id_pv

                        FROM $baseAc1.inform_po

                        INNER JOIN $baseAc1.po_detail
                        ON $baseAc1.inform_po.id_po = $baseAc1.po_detail.po_headid

                        INNER JOIN $baseAc1.good
                        ON $baseAc1.po_detail.materialid = $baseAc1.good.id

                        INNER JOIN $baseAc1.accounttype
                        ON $baseAc1.good.accounttype = $baseAc1.accounttype.id

                        INNER JOIN $baseAc1.po_head
                        ON $baseAc1.inform_po.id_po = $baseAc1.po_head.id

                        INNER JOIN $baseAc1.supplier
                        ON $baseAc1.po_head.supplier_id = $baseAc1.supplier.id

                        INNER JOIN $baseAc1.initial
                        ON $baseAc1.supplier.pre = $baseAc1.initial.per

                        WHERE $baseAc1.inform_po.datebill BETWEEN '2020-01-01' AND '2020-12-31' AND $baseAc1.inform_po.status = 1 AND $baseAc1.po_detail.statususe = 1
                        ORDER BY $baseAc1.inform_po.datebill ASC
                        LIMIT 0";
        // exit;
        $datas = DB::select($sql1);
        $ap = 'default';
        $ap_forold = 'default';
        $type_data = 1;
        // $datas = DB::connection('mysql2')
        //     ->enableQueryLog()
        //     ->table("inform_po")
        //     ->select('inform_po.id as id_ref','po_detail.list','po_detail.note','accounttype.accounttypeno','accounttype.accounttypefull'
        //     ,'po_detail.total','initial.statusperson','accounttype.id as id_accounttype','inform_po.payser_number','inform_po.type'
        //     ,'inform_po.accept','inform_po.datebill','inform_po.branch_id','inform_po.vat_percent','inform_po.discount'
        //     ,'inform_po.wht_percent','inform_po.wht','inform_po.company_pay_wht','inform_po.type_pay','inform_po.payout','inform_po.account_bank'
        //     ,'inform_po.vat_price','inform_po.type_newtable','po_detail.po_headid')
        //     ->leftjoin("po_detail", DB::raw("FIND_IN_SET(po_detail.po_headid,inform_po.id_po)"), ">", DB::raw("'0'"))
        //     ->join('po_head', 'po_head.id', '=', 'inform_po.id_po')
        //     ->join('good', 'good.id', '=', 'po_detail.materialid')
        //     ->join('accounttype', 'accounttype.id', '=', 'good.accounttype')
        //     ->join('supplier', 'supplier.id', '=', 'po_head.supplier_id')
        //     ->join('initial', 'initial.per', '=', 'supplier.pre')
        //     // ->where('inform_po.type_newtable', '=', '1')
        //     ->where('po_detail.statususe', '=', '1')
        //     ->whereBetween('inform_po.datebill', [$start, $end])
        //     ->orderBy('inform_po.datebill', 'asc')
        //     ->limit(100)
        //     ->get();
        //
        // $queries = $datas;
        // echo $last_query = end($queries);
        // // dd($datas);
        // exit;


        // $sqlbillengine = 'SELECT '.$db['fsctaccount'].'.inform_po_mainhead.*
        //                                             ,inform_po_mainhead.id as id_ref
        //
        //   FROM '.$db['fsctaccount'].'.inform_po_mainhead
        //
        //   INNER JOIN  '.$db['fsctaccount'].'.po_detail
        //   ON '. $db['fsctaccount'].'.inform_po_mainhead.po_id = '. $db['fsctaccount'].'.po_detail.po_headid
        //
        //   INNER JOIN  '.$db['fsctaccount'].'.good
        //   ON '. $db['fsctaccount'].'.po_detail.materialid = '. $db['fsctaccount'].'.good.id
        //
        //   INNER JOIN  '.$db['fsctaccount'].'.accounttype
        //   ON '. $db['fsctaccount'].'.good.accounttype = '. $db['fsctaccount'].'.accounttype.id
        //
        //   INNER JOIN  '.$db['fsctaccount'].'.supplier
        //   ON '. $db['fsctaccount'].'.inform_po_mainhead.po_id = '. $db['fsctaccount'].'.supplier.id
        //
        //   INNER JOIN  '.$db['fsctaccount'].'.initial
        //   ON '. $db['fsctaccount'].'.supplier.pre = '. $db['fsctaccount'].'.initial.per
        //
        //   ORDER BY '.$db['fsctaccount'].'.inform_po_mainhead.payser_number ASC
        //   WHERE '.$db['fsctaccount'].'.inform_po_mainhead.statususe = 1
        //   LIMIT 15';
        // $datas = DB::connection('mysql')->select($sqlbillengine);
        // $ap = 'default';

        // $branchs = Branch::get();
        $branchs = DB::connection('mysql')
            ->table('branch')
            ->orderBy('code_branch', 'asc')
            ->where('status_main',1)
            ->get();
        // dd($datas);

        // $sql1 = "SELECT $baseHr1.branch.code_branch,
        //                    WAGE_HISTORY.WAGE_THIS_MONTH_BANK_CONFIRM_STATUS as status_fil
        //                   ,WAGE_HISTORY.WAGE_THIS_MONTH_BANK_CONFIRM_DATE as datepay
        //                   ,sum(WAGE_HISTORY.WAGE_NET_SALARY) as WAGE_NET_SALARY
        //
        //                 FROM $baseHr1.WAGE_HISTORY
        //
        //                 INNER JOIN $baseHr1.emp_data
        //                 ON $baseHr1.WAGE_HISTORY.WAGE_EMP_ID = $baseHr1.emp_data.idcard_no
        //
        //                 INNER JOIN $baseHr1.branch
        //                 ON $baseHr1.emp_data.branch_id = $baseHr1.branch.code_branch
        //
        //                 WHERE WAGE_THIS_MONTH_BANK_CONFIRM_DATE BETWEEN '2018-06-01' AND '2018-06-31'
        //                 GROUP BY branch.code_branch
        //                 LIMIT 5";
        //
        //   $journal_pays = DB::select($sql1);
        //   $salas = 'default';

          $journal_generals = DB::connection('mysql2')
              ->table('journal_5')
              ->select('journal_5.id as id_journal_5','journal_5.number_bill_journal','journalgeneral_detail.list','journalgeneral_detail.name_suplier'
              ,'journal_5.datebill' ,'journal_5.accept' ,'journal_5.totalsum' ,'journal_5.code_branch','journal_5.code_branch','journalgeneral_detail.debit','journalgeneral_detail.credit'
              ,'accounttype.accounttypeno','accounttype.accounttypefull')
              ->join('journalgeneral_detail', 'journal_5.id', '=', 'journalgeneral_detail.id_journalgeneral_head')
              ->join('accounttype', 'accounttype.id', '=', 'journalgeneral_detail.accounttype')
              ->orderBy('number_bill_journal', 'asc')
              ->where('journal_5.type_module',2)
              ->where('journalgeneral_detail.status',1)
              ->get();
          $ap_journal = 'default';

          $reserve_moneys = DB::connection('mysql2')
              ->table('reservemoney')
              ->select('reservemoney.id as id_reservemoney','reservemoney.accept','reservemoney.accept','reservemoney.vat','reservemoney.vat_money','reservemoney.total'
              ,'reservemoney.status','reservemoney.dateporef','reservemoney.bill_no','po_detail.list as po_detail_list','po_detail.note as po_detail_note','accounttype.accounttypeno'
              ,'accounttype.accounttypefull','po_detail.total','reservemoney.branch')
              ->join('po_head', 'reservemoney.po_ref', '=', 'po_head.id')
              ->join('po_detail', 'reservemoney.po_ref', '=', 'po_detail.po_headid')
              ->join('good', 'po_detail.materialid', '=', 'good.id')
              ->join('accounttype', 'good.accounttype', '=', 'accounttype.id')
              ->orderBy('reservemoney.bill_no', 'asc')
              ->where('reservemoney.status',1)
              ->limit(0)
              ->get();
          $ap_reserve = 'default';

          // SELECT branch.code_branch,
          //     sum(WAGE_HISTORY.WAGE_NET_SALARY) as WAGE_NET_SALARY
          // FROM `WAGE_HISTORY`
          //
          // INNER JOIN emp_data
          // ON WAGE_HISTORY.WAGE_EMP_ID = emp_data.idcard_no
          //
          // INNER  JOIN branch
          // ON emp_data.branch_id = branch.code_branch

          // WHERE `WAGE_THIS_MONTH_BANK_CONFIRM_DATE` BETWEEN '2019-12-01' AND '2019-12-31'
          // AND branch.code_branch = '1001'
          // GROUP BY branch.code_branch

        return view('journal.journal_pay', compact('journal_generals', 'ap_journal' ,'datas', 'ap', 'branchs' , 'ap_forold' , 'type_data' , 'reserve_moneys' , 'ap_reserve'));
    }



    public function journalpay_filter(Request $request)
    {
        $connect1 = Connectdb::Databaseall();
        $baseAc1 = $connect1['fsctaccount'];
        $baseHr1 = $connect1['hr_base'];

        $branchs = new Branch;
        $branchs = Branch::get();
        $type_paids = $request->get('type_pay_request');
        $date = $request->get('daterange');
        // dd($date);
        // exit;
        $branch = $request->get('branch');

        $dateset = Datetime::convertStartToEnd($date);
        $start = $dateset['start'];
        $end = $dateset['end'];
        // echo $start;
        // echo $end;
        // exit;

          if ($branch != '0' && $start != null && $end != null && $type_paids == 0) {
              $datas = DB::connection('mysql2')
                  ->table("inform_po")
                  ->select('inform_po.id as id_ref','po_detail.list','po_detail.note','accounttype.accounttypeno','accounttype.accounttypefull'
                  ,'po_detail.total','initial.statusperson','accounttype.id as id_accounttype','inform_po.payser_number','inform_po.type'
                  ,'inform_po.accept','inform_po.datebill','inform_po.branch_id','inform_po.vat_percent','inform_po.discount'
                  ,'inform_po.wht_percent','inform_po.company_pay_wht','inform_po.type_pay','inform_po.payout','inform_po.account_bank'
                  ,'inform_po.vat_price','inform_po.type_newtable','inform_po.bill_no','inform_po.wht','po_head.id_pv')
                  // ->leftjoin("po_detail", DB::raw("FIND_IN_SET(po_detail.po_headid,inform_po.id_po)"), ">", DB::raw("'0'"))
                  ->join('po_detail', 'po_detail.po_headid', '=', 'inform_po.id_po')
                  ->join('po_head', 'po_head.id', '=', 'inform_po.id_po')
                  ->join('good', 'good.id', '=', 'po_detail.materialid')
                  ->join('accounttype', 'accounttype.id', '=', 'good.accounttype')
                  ->join('supplier', 'supplier.id', '=', 'po_head.supplier_id')
                  ->join('initial', 'initial.per', '=', 'supplier.pre')
                  ->orderBy('inform_po.datebill', 'asc')
                  ->where('po_detail.statususe', '=', '1')
                  ->where('inform_po.status', '=', '1')
                  ->where('inform_po.type_newtable', '=', '0')
                  ->whereBetween('inform_po.datetime', [$start.'%', $end.'%'])
                  ->where('inform_po.branch_id', $branch)
                  ->get();

              $reserve_moneys = DB::connection('mysql2')
                  ->table('reservemoney')
                  ->select('reservemoney.id as id_reservemoney','reservemoney.accept','reservemoney.accept','reservemoney.vat','reservemoney.vat_money','reservemoney.total'
                  ,'reservemoney.status','reservemoney.dateporef','reservemoney.bill_no','po_detail.list as po_detail_list','po_detail.note as po_detail_note','accounttype.accounttypeno'
                  ,'accounttype.accounttypefull','po_detail.total','reservemoney.branch')
                  ->join('po_head', 'reservemoney.po_ref', '=', 'po_head.id')
                  ->join('po_detail', 'reservemoney.po_ref', '=', 'po_detail.po_headid')
                  ->join('good', 'po_detail.materialid', '=', 'good.id')
                  ->join('accounttype', 'good.accounttype', '=', 'accounttype.id')
                  ->orderBy('reservemoney.bill_no', 'asc')
                  ->whereBetween('reservemoney.dateporef', [$start, $end])
                  ->where('reservemoney.branch', $branch)
                  ->where('reservemoney.status',1)
                  ->get();

              $type_data = 0;

          }elseif ($branch != '0' && $start != null && $end != null && $type_paids == 1) {
              $datas = DB::connection('mysql2')
                  ->table("inform_po")
                  ->select('inform_po.id as id_ref','po_detail.list','po_detail.note','accounttype.accounttypeno','accounttype.accounttypefull'
                  ,'po_detail.total','initial.statusperson','accounttype.id as id_accounttype','inform_po.payser_number','inform_po.type'
                  ,'inform_po.accept','inform_po.datebill','inform_po.branch_id','inform_po.vat_percent','inform_po.discount'
                  ,'inform_po.wht_percent','inform_po.company_pay_wht','inform_po.type_pay','inform_po.payout','inform_po.account_bank'
                  ,'inform_po.vat_price','inform_po.type_newtable','inform_po.bill_no','inform_po.wht')
                  // ->leftjoin("po_detail", DB::raw("FIND_IN_SET(po_detail.po_headid,inform_po.id_po)"), ">", DB::raw("'0'"))
                  ->join('po_detail', 'po_detail.po_headid', '=', 'inform_po.id_po')
                  ->join('po_head', 'po_head.id', '=', 'inform_po.id_po')
                  ->join('good', 'good.id', '=', 'po_detail.materialid')
                  ->join('accounttype', 'accounttype.id', '=', 'good.accounttype')
                  ->join('supplier', 'supplier.id', '=', 'po_head.supplier_id')
                  ->join('initial', 'initial.per', '=', 'supplier.pre')
                  ->orderBy('inform_po.datebill', 'asc')
                  ->where('po_detail.statususe', '=', '1')
                  ->where('inform_po.status', '=', '1')
                  ->where('inform_po.type_newtable', '=', '1')
                  ->whereBetween('inform_po.datetime', [$start.'%', $end.'%'])
                  ->where('inform_po.branch_id', $branch)
                  ->get();

              $reserve_moneys = DB::connection('mysql2')
                  ->table('reservemoney')
                  ->select('reservemoney.id as id_reservemoney','reservemoney.accept','reservemoney.accept','reservemoney.vat','reservemoney.vat_money','reservemoney.total'
                  ,'reservemoney.status','reservemoney.dateporef','reservemoney.bill_no','po_detail.list as po_detail_list','po_detail.note as po_detail_note','accounttype.accounttypeno'
                  ,'accounttype.accounttypefull','po_detail.total','reservemoney.branch')
                  ->join('po_head', 'reservemoney.po_ref', '=', 'po_head.id')
                  ->join('po_detail', 'reservemoney.po_ref', '=', 'po_detail.po_headid')
                  ->join('good', 'po_detail.materialid', '=', 'good.id')
                  ->join('accounttype', 'good.accounttype', '=', 'accounttype.id')
                  ->orderBy('reservemoney.bill_no', 'asc')
                  ->whereBetween('reservemoney.dateporef', [$start, $end])
                  ->where('reservemoney.branch', $branch)
                  ->where('reservemoney.status',1)
                  ->get();

              $type_data = 1;
          }elseif ($start != null && $end != null && $type_paids == 0) {
              $datas = DB::connection('mysql2')
                  ->table("inform_po")
                  ->select('inform_po.id as id_ref','po_detail.list','po_detail.note','accounttype.accounttypeno','accounttype.accounttypefull'
                  ,'po_detail.total','initial.statusperson','accounttype.id as id_accounttype','inform_po.payser_number','inform_po.type'
                  ,'inform_po.accept','inform_po.datebill','inform_po.branch_id','inform_po.vat_percent','inform_po.discount'
                  ,'inform_po.wht_percent','inform_po.company_pay_wht','inform_po.type_pay','inform_po.payout','inform_po.account_bank'
                  ,'inform_po.vat_price','inform_po.type_newtable','inform_po.bill_no','inform_po.wht','po_head.id_pv')
                  // ->leftjoin("po_detail", DB::raw("FIND_IN_SET(po_detail.po_headid,inform_po.id_po)"), ">", DB::raw("'0'"))
                  ->join('po_detail', 'po_detail.po_headid', '=', 'inform_po.id_po')
                  ->join('po_head', 'po_head.id', '=', 'inform_po.id_po')
                  ->join('good', 'good.id', '=', 'po_detail.materialid')
                  ->join('accounttype', 'accounttype.id', '=', 'good.accounttype')
                  ->join('supplier', 'supplier.id', '=', 'po_head.supplier_id')
                  ->join('initial', 'initial.per', '=', 'supplier.pre')
                  ->orderBy('inform_po.datebill', 'asc')
                  ->where('po_detail.statususe', '=', '1')
                  ->where('inform_po.status', '=', '1')
                  ->where('inform_po.type_newtable', '=', '0')
                  ->whereBetween('inform_po.datetime', [$start.'%', $end.'%'])
                  ->get();

              $reserve_moneys = DB::connection('mysql2')
                  ->table('reservemoney')
                  ->select('reservemoney.id as id_reservemoney','reservemoney.accept','reservemoney.accept','reservemoney.vat','reservemoney.vat_money','reservemoney.total'
                  ,'reservemoney.status','reservemoney.dateporef','reservemoney.bill_no','po_detail.list as po_detail_list','po_detail.note as po_detail_note','accounttype.accounttypeno'
                  ,'accounttype.accounttypefull','po_detail.total','reservemoney.branch')
                  ->join('po_head', 'reservemoney.po_ref', '=', 'po_head.id')
                  ->join('po_detail', 'reservemoney.po_ref', '=', 'po_detail.po_headid')
                  ->join('good', 'po_detail.materialid', '=', 'good.id')
                  ->join('accounttype', 'good.accounttype', '=', 'accounttype.id')
                  ->orderBy('reservemoney.bill_no', 'asc')
                  ->whereBetween('reservemoney.dateporef', [$start, $end])
                  ->where('reservemoney.status',1)
                  ->get();
              $type_data = 0;
          }elseif ($start != null && $end != null && $type_paids == 1) {
              $datas = DB::connection('mysql2')
                  ->table("inform_po")
                  ->select('inform_po.id as id_ref','po_detail.list','po_detail.note','accounttype.accounttypeno','accounttype.accounttypefull'
                  ,'po_detail.total','initial.statusperson','accounttype.id as id_accounttype','inform_po.payser_number','inform_po.type'
                  ,'inform_po.accept','inform_po.datebill','inform_po.branch_id','inform_po.vat_percent','inform_po.discount'
                  ,'inform_po.wht_percent','inform_po.company_pay_wht','inform_po.type_pay','inform_po.payout','inform_po.account_bank'
                  ,'inform_po.vat_price','inform_po.type_newtable','inform_po.bill_no','inform_po.wht')
                  // ->leftjoin("po_detail", DB::raw("FIND_IN_SET(po_detail.po_headid,inform_po.id_po)"), ">", DB::raw("'0'"))
                  ->join('po_detail', 'po_detail.po_headid', '=', 'inform_po.id_po')
                  ->join('good', 'good.id', '=', 'po_detail.materialid')
                  ->join('po_head', 'po_head.id', '=', 'inform_po.id_po')
                  ->join('accounttype', 'accounttype.id', '=', 'good.accounttype')
                  ->join('supplier', 'supplier.id', '=', 'po_head.supplier_id')
                  ->join('initial', 'initial.per', '=', 'supplier.pre')
                  ->orderBy('inform_po.datebill', 'asc')
                  ->where('po_detail.statususe', '=', '1')
                  ->where('inform_po.status', '=', '1')
                  ->where('inform_po.type_newtable', '=', '1')
                  ->whereBetween('inform_po.datetime', [$start.'%', $end.'%'])
                  ->get();
              $type_data = 1;

              $reserve_moneys = DB::connection('mysql2')
                  ->table('reservemoney')
                  ->select('reservemoney.id as id_reservemoney','reservemoney.accept','reservemoney.accept','reservemoney.vat','reservemoney.vat_money','reservemoney.total'
                  ,'reservemoney.status','reservemoney.dateporef','reservemoney.bill_no','po_detail.list as po_detail_list','po_detail.note as po_detail_note','accounttype.accounttypeno'
                  ,'accounttype.accounttypefull','po_detail.total','reservemoney.branch')
                  ->join('po_head', 'reservemoney.po_ref', '=', 'po_head.id')
                  ->join('po_detail', 'reservemoney.po_ref', '=', 'po_detail.po_headid')
                  ->join('good', 'po_detail.materialid', '=', 'good.id')
                  ->join('accounttype', 'good.accounttype', '=', 'accounttype.id')
                  ->orderBy('reservemoney.bill_no', 'asc')
                  ->whereBetween('reservemoney.dateporef', [$start, $end])
                  ->where('reservemoney.branch', $branch)
                  ->where('reservemoney.status',1)
                  ->get();

          }
          $ap = 'default';
          $ap_forold = 'default';
          $ap_journal = 'default';
          $ap_reserve = 'default';


          $journal_generals = DB::connection('mysql2')
              ->table('journal_5')
              ->select('journal_5.id as id_journal_5','journal_5.number_bill_journal','journalgeneral_detail.list','journalgeneral_detail.name_suplier'
              ,'journal_5.datebill' ,'journal_5.accept' ,'journal_5.totalsum' ,'journal_5.code_branch','journal_5.code_branch','journalgeneral_detail.debit','journalgeneral_detail.credit'
              ,'accounttype.accounttypeno','accounttype.accounttypefull')
              ->join('journalgeneral_detail', 'journal_5.id', '=', 'journalgeneral_detail.id_journalgeneral_head')
              ->join('accounttype', 'accounttype.id', '=', 'journalgeneral_detail.accounttype')
              ->orderBy('number_bill_journal', 'asc')
              ->where('journal_5.type_module',2)
              ->where('journalgeneral_detail.status',1)
              ->get();
        // if ($type_paids == 1) {
        //   return view('journal.journal_pay', compact('datas', 'ap', 'branchs'));
        // }
        // else {
        //   return view('journal.journal_pay', compact('journal_pays', 'salas', 'branchs'));
        // }
        return view('journal.journal_pay', compact('datas', 'ap', 'branchs', 'journal_generals', 'ap_journal', 'ap_forold', 'type_data' , 'reserve_moneys' , 'ap_reserve'));
        // return view('journal.journal_pay', compact('datas', 'ap', 'branchs'));
    }


    public function confirm_journal_pay(Request $request)
    {
      $connect1 = Connectdb::Databaseall();
      $baseAc1 = $connect1['fsctaccount'];

      $data = Input::all();
      $db = Connectdb::Databaseall();
      // print_r($data);
      if (isset($data['id_journal_pay'])) {
        if ($request->get('type_newtable_ins') == 1) {
          $datack = $data['id_journal_pay'];
          $comma_separated1 = implode(',', $datack);

          // dd($comma_separated1);
          // exit;
          // foreach ($datack as $key => $value) {
          //          $id = $value;
                   // dd($comma_separated1);
                   // exit;

                    $sqlUpdate = ' UPDATE '.$db['fsctaccount'].'.inform_po
                              SET accept = "1"
                              WHERE '.$db['fsctaccount'].'.inform_po.id IN ('.$comma_separated1.') ';
                    $lgUpdateResulte = DB::connection('mysql')->select($sqlUpdate);

                    $sql1 = "SELECT $baseAc1.inform_po.*
                                                    ,inform_po.id as id_ref
                                                    ,po_detail.list
                                                    ,po_detail.note
                                                    ,accounttype.accounttypeno
                                                    ,accounttype.accounttypefull
                                                    ,po_detail.total
                                                    ,initial.statusperson
                                                    ,supplier.id as id_supplier
                                                    ,accounttype.id as id_accounttype

                                    FROM $baseAc1.inform_po

                                    LEFT JOIN $baseAc1.po_detail
                                    ON $baseAc1.inform_po.id_po = $baseAc1.po_detail.po_headid

                                    INNER JOIN $baseAc1.good
                                    ON $baseAc1.po_detail.materialid = $baseAc1.good.id

                                    INNER JOIN $baseAc1.accounttype
                                    ON $baseAc1.good.accounttype = $baseAc1.accounttype.id

                                    INNER JOIN $baseAc1.po_head
                                    ON $baseAc1.inform_po.id_po = $baseAc1.po_head.id

                                    INNER JOIN $baseAc1.supplier
                                    ON $baseAc1.po_head.supplier_id = $baseAc1.supplier.id

                                    INNER JOIN $baseAc1.initial
                                    ON $baseAc1.supplier.pre = $baseAc1.initial.per

                                    WHERE $baseAc1.inform_po.status IN ('1') AND po_detail.statususe = 1 AND inform_po.id IN ($comma_separated1)";

                    $datas = DB::select($sql1);
                    // dd($datas);
                    // exit;

                      for ($i=0; $i < count($datas) ; $i++) {
                        $branch_s = $datas[$i]->branch_id;
                        $numbe_debt1_s = $datas[$i]->payser_number;
                        $customer_ids = $datas[$i]->id_supplier;
                        // $accounttypenos_s = $datas[$i]->accounttypeno;
                        if ($datas[$i]->type == 1) {
                          $debits_s = $datas[$i]->payout;
                        }else {
                          $debits_s = $datas[$i]->total;
                        }
                        // $credits_s = $datas[$i]->last_total;
                        // $list_s = $datas[$i]->list;
                        $id_typejournal_s = 3;
                        $id_type_ref_journal = $datas[$i]->id_ref;
                        $datebills_start = $datas[$i]->datebill;
                        $datetime_copy = $datas[$i]->datetime;
                        // $emp_outs = $datas[$i]->emp_out;
                        $vats = $datas[$i]->vat_percent;
                        $discounts = $datas[$i]->discount;
                        // $withholds = $datas[$i]->withhold;
                        $accode = $datas[$i]->accounttypeno;
                        $list = $datas[$i]->list;

                          $arrInert = [ 'id'=>'',
                                  'dr'=>$debits_s,
                                  'cr'=>0.00,
                                  'acc_code'=>$accode,
                                  'branch'=>$branch_s,
                                  'status'=> 1,
                                  'number_bill'=> $numbe_debt1_s,
                                  'customer_vendor'=> $customer_ids,
                                  'timestamp'=>$datetime_copy,
                                  // 'code_emp'=>$emp_outs,
                                  'subtotal'=> 0,
                                  'discount'=> $discounts,
                                  'vat'=> $vats,
                                  'vatmoney'=> 0,
                                  // 'wht'=> $withholds,
                                  'whtmoney'=> 0,
                                  'grandtotal'=> $debits_s,
                                  'type_journal' => 3,
                                  'id_type_ref_journal'=>$id_type_ref_journal,
                                  'timereal'=>$datetime_copy,
                                  'list'=> $list];

                          DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);
                      }


                      $sqlpay2 = 'SELECT '.$db['fsctaccount'].'.inform_po.*
                                                                     ,inform_po.id as id_jourpay
                                                                     ,initial.statusperson
                                                                     ,supplier.id as id_supplier
                      FROM '.$db['fsctaccount'].'.inform_po

                      INNER JOIN '.$db['fsctaccount'].'.po_head
                      ON '.$db['fsctaccount'].'.inform_po.id_po = '.$db['fsctaccount'].'.po_head.id

                      INNER JOIN '.$db['fsctaccount'].'.supplier
                      ON '.$db['fsctaccount'].'.po_head.supplier_id = '.$db['fsctaccount'].'.supplier.id

                      INNER JOIN '.$db['fsctaccount'].'.initial
                      ON '.$db['fsctaccount'].'.supplier.pre = '.$db['fsctaccount'].'.initial.per

                      WHERE '.$db['fsctaccount'].'.inform_po.id IN ('.$comma_separated1.')';
                      $datacredit = DB::select($sqlpay2);
                      // dd($datacredit);
                      // exit;

                      for ($i=0; $i < count($datacredit) ; $i++) {
                        if ($datacredit[$i]->type_pay == 1) {
                          $branch_s = $datacredit[$i]->branch_id;
                          $numbe_debt1_s = $datacredit[$i]->payser_number;
                          $customer_ids = $datacredit[$i]->id_supplier;
                          // $accounttypenos_s = $datacredit[$i]->accounttypeno;
                          // $debits_s = $datacredit[$i]->total;
                          if($datacredit[$i]->wht_percent >= 1.00 && $datacredit[$i]->company_pay_wht == 0) {
                            $showmoney = $datacredit[$i]->payout-$datacredit[$i]->wht;
                          }
                          else {
                            $showmoney = $datacredit[$i]->payout;
                          }
                          $credits_s = $showmoney;
                          // $list_s = $datacredit[$i]->list;
                          $id_typejournal_s = 3;
                          $id_type_ref_journal = $datacredit[$i]->id_jourpay;
                          $datebills_start = $datacredit[$i]->datebill;
                          // $emp_outs = $datacredit[$i]->emp_out;
                          $vats = $datacredit[$i]->vat_percent;
                          $discounts = $datacredit[$i]->discount;
                          // $withholds = $datacredit[$i]->withhold;
                          $accode = '111200';
                          // $list = "".$datacredit[$i]->name."".'ค้างจ่าย';
                          $list = 'เงินสด';

                            $arrInert = [ 'id'=>'',
                                    'dr'=>0.00,
                                    'cr'=>$credits_s,
                                    'acc_code'=>$accode,
                                    'branch'=>$branch_s,
                                    'status'=> 1,
                                    'number_bill'=> $numbe_debt1_s,
                                    'customer_vendor'=> $customer_ids,
                                    'timestamp'=>$datetime_copy,
                                    // 'code_emp'=>$emp_outs,
                                    'subtotal'=> 0,
                                    'discount'=> $discounts,
                                    'vat'=> $vats,
                                    'vatmoney'=> 0,
                                    // 'wht'=> $withholds,
                                    'whtmoney'=> 0,
                                    'grandtotal'=> $credits_s,
                                    'type_journal' => 2,
                                    'id_type_ref_journal'=>$id_type_ref_journal,
                                    'timereal'=>$datetime_copy,
                                    'list'=> $list];

                            DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);
                        }
                      }

                      for ($i=0; $i < count($datacredit) ; $i++) {
                        if ($datacredit[$i]->type_pay == 2) {
                            $branch_s = $datacredit[$i]->branch_id;
                            $numbe_debt1_s = $datacredit[$i]->payser_number;
                            $customer_ids = $datacredit[$i]->id_supplier;
                            // $accounttypenos_s = $datacredit[$i]->accounttypeno;
                            // $debits_s = $datacredit[$i]->total;
                            if($datacredit[$i]->wht_percent >= 1.00 && $datacredit[$i]->company_pay_wht == 0) {
                              $showmoney = $datacredit[$i]->payout-$datacredit[$i]->wht;
                            }
                            else {
                              $showmoney = $datacredit[$i]->payout;
                            }
                            $credits_s = $showmoney;
                            // $list_s = $datacredit[$i]->list;
                            $id_typejournal_s = 3;
                            $id_type_ref_journal = $datacredit[$i]->id_jourpay;
                            $datebills_start = $datacredit[$i]->datebill;
                            // $emp_outs = $datacredit[$i]->emp_out;
                            $vats = $datacredit[$i]->vat_percent;
                            $discounts = $datacredit[$i]->discount;
                            // $withholds = $datacredit[$i]->withhold;
                            // $accode = '111200';
                            $accode = $datacredit[$i]->account_bank;
                            $accode_cut = substr($accode,0,6);
                            // $list = "".$datacredit[$i]->name."".'ค้างจ่าย';
                            $list = 'เงินโอน';

                              $arrInert = [ 'id'=>'',
                                      'dr'=>0.00,
                                      'cr'=>$credits_s,
                                      'acc_code'=>$accode_cut,
                                      'branch'=>$branch_s,
                                      'status'=> 1,
                                      'number_bill'=> $numbe_debt1_s,
                                      'customer_vendor'=> $customer_ids,
                                      'timestamp'=>$datetime_copy,
                                      // 'code_emp'=>$emp_outs,
                                      'subtotal'=> 0,
                                      'discount'=> $discounts,
                                      'vat'=> $vats,
                                      'vatmoney'=> 0,
                                      // 'wht'=> $withholds,
                                      'whtmoney'=> 0,
                                      'grandtotal'=> $credits_s,
                                      'type_journal' => 3,
                                      'id_type_ref_journal'=>$id_type_ref_journal,
                                      'timereal'=>$datetime_copy,
                                      'list'=> $list];

                              DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);
                          }
                      }

                      for ($i=0; $i < count($datacredit) ; $i++) {
                        if ($datacredit[$i]->type == 2 && $datacredit[$i]->vat_percent >= 1) {
                            $branch_s = $datacredit[$i]->branch_id;
                            $numbe_debt1_s = $datacredit[$i]->payser_number;
                            $customer_ids = $datacredit[$i]->id_supplier;
                            // $accounttypenos_s = $datacredit[$i]->accounttypeno;
                            // $debits_s = $datacredit[$i]->total;
                            $showvat = $datacredit[$i]->vat_percent;
                            $showvat_cal = $datacredit[$i]->payout;
                            $total_vat = $datacredit[$i]->vat_price;
                            // if ($showvat == 7) {
                            //   $debits_s = $showvat_cal/1.07;
                            //   $calvat = $debits_s*0.07;
                            // }
                            // elseif ($showvat == 3) {
                            //   $debits_s = $showvat_cal/1.03;
                            //   $calvat = $debits_s*0.03;
                            // }
                            // elseif ($showvat == 5) {
                            //   $debits_s = $showvat_cal/1.05;
                            //   $calvat = $debits_s*0.05;
                            // }
                            // elseif ($showvat == 1) {
                            //   $debits_s = $showvat_cal/1.01;
                            //   $calvat = $debits_s*0.01;
                            // }
                            // $showvat_ins = number_format($calvat, 2, '.', '');

                            // $credits_s = $showvat_ins;
                            // $list_s = $datacredit[$i]->list;
                            $id_typejournal_s = 3;
                            $id_type_ref_journal = $datacredit[$i]->id_jourpay;
                            $datebills_start = $datacredit[$i]->datebill;
                            // $emp_outs = $datacredit[$i]->emp_out;
                            $vats = $datacredit[$i]->vat_percent;
                            $discounts = $datacredit[$i]->discount;
                            // $withholds = $datacredit[$i]->withhold;
                            $accode = '119501';
                            // $list = "".$datacredit[$i]->name."".'ค้างจ่าย';
                            $list = 'ภาษีมูลค่าเพิ่ม';

                              $arrInert = [ 'id'=>'',
                                      'dr'=>$total_vat,
                                      'cr'=>0.00,
                                      'acc_code'=>$accode,
                                      'branch'=>$branch_s,
                                      'status'=> 1,
                                      'number_bill'=> $numbe_debt1_s,
                                      'customer_vendor'=> $customer_ids,
                                      'timestamp'=>$datetime_copy,
                                      // 'code_emp'=>$emp_outs,
                                      'subtotal'=> 0,
                                      'discount'=> $discounts,
                                      'vat'=> $vats,
                                      'vatmoney'=> 0,
                                      // 'wht'=> $withholds,
                                      'whtmoney'=> 0,
                                      'grandtotal'=> $credits_s,
                                      'type_journal' => 3,
                                      'id_type_ref_journal'=>$id_type_ref_journal,
                                      'timereal'=>$datetime_copy,
                                      'list'=> $list];

                              DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);
                          }
                      }

                      for ($i=0; $i < count($datacredit) ; $i++) {
                        if ($datacredit[$i]->discount >= 0.01) {
                            $branch_s = $datacredit[$i]->branch_id;
                            $numbe_debt1_s = $datacredit[$i]->payser_number;
                            $customer_ids = $datacredit[$i]->id_supplier;
                            // $accounttypenos_s = $datacredit[$i]->accounttypeno;
                            // $debits_s = $datacredit[$i]->total;
                            $credits_s = $datacredit[$i]->discount;
                            // $list_s = $datacredit[$i]->list;
                            $id_typejournal_s = 3;
                            $id_type_ref_journal = $datacredit[$i]->id_jourpay;
                            $datebills_start = $datacredit[$i]->datebill;
                            // $emp_outs = $datacredit[$i]->emp_out;
                            $vats = $datacredit[$i]->vat_percent;
                            $discounts = $datacredit[$i]->discount;
                            // $withholds = $datacredit[$i]->withhold;
                            // $accode = '111200';
                            $accode = '412900';
                            // $list = "".$datacredit[$i]->name."".'ค้างจ่าย';
                            $list = 'ส่วนลด';

                              $arrInert = [ 'id'=>'',
                                      'dr'=>0.00,
                                      'cr'=>$credits_s,
                                      'acc_code'=>$accode,
                                      'branch'=>$branch_s,
                                      'status'=> 1,
                                      'number_bill'=> $numbe_debt1_s,
                                      'customer_vendor'=> $customer_ids,
                                      'timestamp'=>$datetime_copy,
                                      // 'code_emp'=>$emp_outs,
                                      'subtotal'=> 0,
                                      'discount'=> $discounts,
                                      'vat'=> $vats,
                                      'vatmoney'=> 0,
                                      // 'wht'=> $withholds,
                                      'whtmoney'=> 0,
                                      'grandtotal'=> $credits_s,
                                      'type_journal' => 3,
                                      'id_type_ref_journal'=>$id_type_ref_journal,
                                      'timereal'=>$datetime_copy,
                                      'list'=> $list];

                              DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);
                          }
                      }

                      for ($i=0; $i < count($datacredit) ; $i++) {
                        if ($datacredit[$i]->wht_percent >= 0.01) {
                            $branch_s = $datacredit[$i]->branch_id;
                            $numbe_debt1_s = $datacredit[$i]->payser_number;
                            $customer_ids = $datacredit[$i]->id_supplier;
                            // $accounttypenos_s = $datacredit[$i]->accounttypeno;
                            $wht_s = $datacredit[$i]->wht;
                            $credits_s = $wht_s;
                            // $list_s = $datacredit[$i]->list;
                            $id_typejournal_s = 3;
                            $id_type_ref_journal = $datacredit[$i]->id_jourpay;
                            $datebills_start = $datacredit[$i]->datebill;
                            // $emp_outs = $datacredit[$i]->emp_out;
                            $vats = $datacredit[$i]->vat_percent;
                            $discounts = $datacredit[$i]->discount;
                            $withholds = $datacredit[$i]->wht_percent;
                            // $accode = '111200';
                            // $list = "".$datacredit[$i]->name."".'ค้างจ่าย';
                            if ($datacredit[$i]->statusperson == 0) {
                              $list = 'ภาษีหัก ณ ที่จ่ายค้างจ่าย ภงด.3';
                              $accode = '219402';
                            }
                            elseif ($datacredit[$i]->statusperson == 1) {
                              $list = 'ภาษีหัก ณ ที่จ่าย ภงด.53';
                              $accode = '222002';
                            }
                            else {
                              $list = 'ภาษีหัก ณ ที่จ่ายค้างจ่าย ภงด.1';
                              $accode = '219401';
                            }


                              $arrInert = [ 'id'=>'',
                                      'dr'=>0.00,
                                      'cr'=>$credits_s,
                                      'acc_code'=>$accode,
                                      'branch'=>$branch_s,
                                      'status'=> 1,
                                      'number_bill'=> $numbe_debt1_s,
                                      'customer_vendor'=> $customer_ids,
                                      'timestamp'=>$datetime_copy,
                                      // 'code_emp'=>$emp_outs,
                                      'subtotal'=> 0,
                                      'discount'=> $discounts,
                                      'vat'=> $vats,
                                      'vatmoney'=> 0,
                                      'wht'=> $withholds,
                                      'whtmoney'=>$wht_s,
                                      'grandtotal'=> $credits_s,
                                      'type_journal' => 2,
                                      'id_type_ref_journal'=>$id_type_ref_journal,
                                      'timereal'=>$datetime_copy,
                                      'list'=> $list];

                              DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);
                          }
                      }

                      for ($i=0; $i < count($datacredit) ; $i++) {
                        if ($datacredit[$i]->company_pay_wht == 255) {
                            $branch_s = $datacredit[$i]->branch_id;
                            $numbe_debt1_s = $datacredit[$i]->payser_number;
                            $customer_ids = $datacredit[$i]->id_supplier;
                            // $accounttypenos_s = $datacredit[$i]->accounttypeno;
                            $wht_s = $datacredit[$i]->wht;
                            $debit_s = $wht_s;
                            // $list_s = $datacredit[$i]->list;
                            $id_typejournal_s = 3;
                            $id_type_ref_journal = $datacredit[$i]->id_jourpay;
                            $datebills_start = $datacredit[$i]->datebill;
                            // $emp_outs = $datacredit[$i]->emp_out;
                            $vats = $datacredit[$i]->vat_percent;
                            $discounts = $datacredit[$i]->discount;
                            $withholds = $datacredit[$i]->wht_percent;
                            // $accode = '111200';
                            $accode = '621708';
                            // $list = "".$datacredit[$i]->name."".'ค้างจ่าย';
                            $list = 'ภาษีหัก ณ ที่จ่ายบริษัทออกแทน';

                              $arrInert = [ 'id'=>'',
                                      'dr'=>$debit_s,
                                      'cr'=>0.00,
                                      'acc_code'=>$accode,
                                      'branch'=>$branch_s,
                                      'status'=> 1,
                                      'number_bill'=> $numbe_debt1_s,
                                      'customer_vendor'=> $customer_ids,
                                      'timestamp'=>$datetime_copy,
                                      // 'code_emp'=>$emp_outs,
                                      'subtotal'=> 0,
                                      'discount'=> $discounts,
                                      'vat'=> $vats,
                                      'vatmoney'=> 0,
                                      'wht'=> $withholds,
                                      'whtmoney'=>$wht_s,
                                      'grandtotal'=> $credits_s,
                                      'type_journal' => 2,
                                      'id_type_ref_journal'=>$id_type_ref_journal,
                                      'timereal'=>$datetime_copy,
                                      'list'=> $list];

                              DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);
                          }
                      }
        }else {
          $datack = $data['id_journal_pay'];
          $comma_separated1 = implode(',', $datack);
          // dd($comma_separated1);
          // exit;
                    $sqlUpdate = ' UPDATE '.$db['fsctaccount'].'.inform_po
                              SET accept = "1"
                              WHERE '.$db['fsctaccount'].'.inform_po.id IN ('.$comma_separated1.') ';
                    $lgUpdateResulte = DB::connection('mysql')->select($sqlUpdate);

                    $sql1 = "SELECT $baseAc1.inform_po.*
                                                    ,inform_po.id as id_ref
                                                    ,po_detail.list
                                                    ,po_detail.note
                                                    ,accounttype.accounttypeno
                                                    ,accounttype.accounttypefull
                                                    ,po_detail.total
                                                    ,accounttype.id as id_accounttype

                                    FROM $baseAc1.inform_po

                                    LEFT JOIN $baseAc1.po_detail
                                    ON $baseAc1.inform_po.id_po = $baseAc1.po_detail.po_headid

                                    INNER JOIN $baseAc1.good
                                    ON $baseAc1.po_detail.materialid = $baseAc1.good.id

                                    INNER JOIN $baseAc1.accounttype
                                    ON $baseAc1.good.accounttype = $baseAc1.accounttype.id

                                    -- LEFT JOIN $baseAc1.supplier
                                    -- ON $baseAc1.inform_po.id_po = $baseAc1.supplier.id

                                    -- LEFT JOIN $baseAc1.initial
                                    -- ON $baseAc1.supplier.pre = $baseAc1.initial.per

                                    WHERE $baseAc1.inform_po.status IN ('1') AND po_detail.statususe = 1 AND inform_po.id IN ($comma_separated1)";

                    $datas = DB::select($sql1);
                    // dd($datas);
                    // exit;

                      for ($i=0; $i < count($datas) ; $i++) {
                        $branch_s = $datas[$i]->branch_id;
                        $numbe_debt1_s = $datas[$i]->receipt_no;
                        // $customer_ids = $datas[$i]->supplier_id;
                        // $accounttypenos_s = $datas[$i]->accounttypeno;
                        $debits_s = $datas[$i]->total;
                        // $credits_s = $datas[$i]->last_total;
                        // $list_s = $datas[$i]->list;
                        $id_typejournal_s = 3;
                        $id_type_ref_journal = $datas[$i]->id_ref;
                        $datebills_start = $datas[$i]->datebill;
                        // $emp_outs = $datas[$i]->emp_out;
                        $vats = $datas[$i]->vat_percent;
                        $discounts = $datas[$i]->discount;
                        // $withholds = $datas[$i]->withhold;
                        $accode = $datas[$i]->accounttypeno;
                        $list = $datas[$i]->list;

                          $arrInert = [ 'id'=>'',
                                  'dr'=>$debits_s,
                                  'cr'=>0.00,
                                  'acc_code'=>$accode,
                                  'branch'=>$branch_s,
                                  'status'=> 1,
                                  'number_bill'=> $numbe_debt1_s,
                                  // 'customer_vendor'=> $customer_ids,
                                  'timestamp'=>$datetime_copy,
                                  // 'code_emp'=>$emp_outs,
                                  'subtotal'=> 0,
                                  'discount'=> $discounts,
                                  'vat'=> $vats,
                                  'vatmoney'=> 0,
                                  // 'wht'=> $withholds,
                                  'whtmoney'=> 0,
                                  'grandtotal'=> $debits_s,
                                  'type_journal' => 3,
                                  'id_type_ref_journal'=>$id_type_ref_journal,
                                  'timereal'=>$datetime_copy,
                                  'list'=> $list];

                          DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);
                      }


                      $sqlpay2 = 'SELECT '.$db['fsctaccount'].'.inform_po.*
                                                                     ,inform_po.id as id_jourpay
                      FROM '.$db['fsctaccount'].'.inform_po

                      WHERE '.$db['fsctaccount'].'.inform_po.id IN ('.$comma_separated1.')';
                      $datacredit = DB::select($sqlpay2);
                      // dd($datawagecredit);
                      // exit;

                      for ($i=0; $i < count($datacredit) ; $i++) {
                        if ($datacredit[$i]->type_pay == 1) {
                          $branch_s = $datacredit[$i]->branch_id;
                          $numbe_debt1_s = $datacredit[$i]->receipt_no;
                          // $customer_ids = $datacredit[$i]->supplier_id;
                          // $accounttypenos_s = $datacredit[$i]->accounttypeno;
                          // $debits_s = $datacredit[$i]->total;
                          $showmoney = $datacredit[$i]->payout;
                          $credits_s = $showmoney;
                          // $list_s = $datacredit[$i]->list;
                          $id_typejournal_s = 3;
                          $id_type_ref_journal = $datacredit[$i]->id_jourpay;
                          $datebills_start = $datacredit[$i]->datebill;
                          // $emp_outs = $datacredit[$i]->emp_out;
                          $vats = $datacredit[$i]->vat_percent;
                          $discounts = $datacredit[$i]->discount;
                          // $withholds = $datacredit[$i]->withhold;
                          $accode = '111200';
                          // $list = "".$datacredit[$i]->name."".'ค้างจ่าย';
                          $list = 'เงินสด';

                            $arrInert = [ 'id'=>'',
                                    'dr'=>0.00,
                                    'cr'=>$credits_s,
                                    'acc_code'=>$accode,
                                    'branch'=>$branch_s,
                                    'status'=> 1,
                                    'number_bill'=> $numbe_debt1_s,
                                    // 'customer_vendor'=> $customer_ids,
                                    'timestamp'=>$datetime_copy,
                                    // 'code_emp'=>$emp_outs,
                                    'subtotal'=> 0,
                                    'discount'=> $discounts,
                                    'vat'=> $vats,
                                    'vatmoney'=> 0,
                                    // 'wht'=> $withholds,
                                    'whtmoney'=> 0,
                                    'grandtotal'=> $credits_s,
                                    'type_journal' => 3,
                                    'id_type_ref_journal'=>$id_type_ref_journal,
                                    'timereal'=>$datetime_copy,
                                    'list'=> $list];

                            DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);
                        }
                      }

                      for ($i=0; $i < count($datacredit) ; $i++) {
                        if ($datacredit[$i]->type_pay == 2) {
                            $branch_s = $datacredit[$i]->branch_id;
                            $numbe_debt1_s = $datacredit[$i]->receipt_no;
                            // $customer_ids = $datacredit[$i]->supplier_id;
                            // $accounttypenos_s = $datacredit[$i]->accounttypeno;
                            // $debits_s = $datacredit[$i]->total;
                            // if($datacredit[$i]->wht_percent >= 1.00 && $datacredit[$i]->company_pay_wht == 0) {
                            //   $showmoney = $datacredit[$i]->vat_price-$datacredit[$i]->wht;
                            // }
                            // else {
                            $showmoney = $datacredit[$i]->payout;
                            // }
                            $credits_s = $showmoney;
                            // $list_s = $datacredit[$i]->list;
                            $id_typejournal_s = 3;
                            $id_type_ref_journal = $datacredit[$i]->id_jourpay;
                            $datebills_start = $datacredit[$i]->datebill;
                            // $emp_outs = $datacredit[$i]->emp_out;
                            $vats = $datacredit[$i]->vat_percent;
                            $discounts = $datacredit[$i]->discount;
                            // $withholds = $datacredit[$i]->withhold;
                            // $accode = '111200';
                            if($datacredit[$i]->branch_id == 1001) {
                                $accCode = "112027";
                            }elseif($datacredit[$i]->branch_id == 1004) {
                                $accCode = "112027";
                            }elseif($datacredit[$i]->branch_id == 1005) {
                                $accCode = "112038";
                            }elseif($datacredit[$i]->branch_id == 1006) {
                                $accCode = "112046";
                            }elseif($datacredit[$i]->branch_id == 1007) {
                                $accCode = "112046";
                            }elseif($datacredit[$i]->branch_id == 1008) {
                                $accCode = "112043";
                            }elseif($datacredit[$i]->branch_id == 1009) {
                                $accCode = "112048";
                            }elseif($datacredit[$i]->branch_id == 1010) {
                                $accCode = "112047";
                            }elseif($datacredit[$i]->branch_id == 1011) {
                                $accCode = "112028";
                            }elseif($datacredit[$i]->branch_id == 1012) {
                                $accCode = "112054";
                            }elseif($datacredit[$i]->branch_id == 1013) {
                                $accCode = "112053";
                            }elseif($datacredit[$i]->branch_id == 1014) {
                                $accCode = "112053";
                            }elseif($datacredit[$i]->branch_id == 1015) {
                                $accCode = "112041";
                            }elseif($datacredit[$i]->branch_id == 1016) {
                                $accCode = "112033";
                            }elseif($datacredit[$i]->branch_id == 1017) {
                                $accCode = "112033";
                            }elseif($datacredit[$i]->branch_id == 1018) {
                                $accCode = "112052";
                            }elseif($datacredit[$i]->branch_id == 1019) {
                                $accCode = "112042";
                            }elseif($datacredit[$i]->branch_id == 1020) {
                                $accCode = "112055";
                            }elseif($datacredit[$i]->branch_id == 1021) {
                                $accCode = "112055";
                            }elseif($datacredit[$i]->branch_id == 1022) {
                                $accCode = "112045";
                            }elseif($datacredit[$i]->branch_id == 1023) {
                                $accCode = "112049";
                            }elseif($datacredit[$i]->branch_id == 1024) {
                                $accCode = "112050";
                            }elseif($datacredit[$i]->branch_id == 1025) {
                                $accCode = "112051";
                            }elseif($datacredit[$i]->branch_id == 1026) {
                                $accCode = "112032";
                            }elseif($datacredit[$i]->branch_id == 1027) {
                                $accCode = "112044";
                            }elseif($datacredit[$i]->branch_id == 1028) {
                                $accCode = "112029";
                            }elseif($datacredit[$i]->branch_id == 1029) {
                                $accCode = "112034";
                            }
                            // $accode = $datacredit[$i]->account_bank;
                            // $accode_cut = substr($accode,0,6);

                            // $list = "".$datacredit[$i]->name."".'ค้างจ่าย';
                            $list = 'เงินโอน';

                              $arrInert = [ 'id'=>'',
                                      'dr'=>0.00,
                                      'cr'=>$credits_s,
                                      'acc_code'=>$accCode,
                                      'branch'=>$branch_s,
                                      'status'=> 1,
                                      'number_bill'=> $numbe_debt1_s,
                                      // 'customer_vendor'=> $customer_ids,
                                      'timestamp'=>$datetime_copy,
                                      // 'code_emp'=>$emp_outs,
                                      'subtotal'=> 0,
                                      'discount'=> $discounts,
                                      'vat'=> $vats,
                                      'vatmoney'=> 0,
                                      // 'wht'=> $withholds,
                                      'whtmoney'=> 0,
                                      'grandtotal'=> $credits_s,
                                      'type_journal' => 3,
                                      'id_type_ref_journal'=>$id_type_ref_journal,
                                      'timereal'=>$datetime_copy,
                                      'list'=> $list];

                              DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);
                          }
                      }

                      for ($i=0; $i < count($datacredit) ; $i++) {
                        if ($datacredit[$i]->type == 2 && $datacredit[$i]->vat_percent >= 1) {
                            $branch_s = $datacredit[$i]->branch_id;
                            $numbe_debt1_s = $datacredit[$i]->receipt_no;
                            // $customer_ids = $datacredit[$i]->supplier_id;
                            // $accounttypenos_s = $datacredit[$i]->accounttypeno;
                            // $debits_s = $datacredit[$i]->total;
                            $showvat = $datacredit[$i]->vat_percent;
                            $showvat_cal = $datacredit[$i]->vat_price;
                            //
                            // if ($showvat == 7) {
                            //   $debits_s = $showvat_cal/1.07;
                            //   $calvat = $debits_s*0.07;
                            // }
                            // elseif ($showvat == 3) {
                            //   $debits_s = $showvat_cal/1.03;
                            //   $calvat = $debits_s*0.03;
                            // }
                            // elseif ($showvat == 5) {
                            //   $debits_s = $showvat_cal/1.05;
                            //   $calvat = $debits_s*0.05;
                            // }
                            // elseif ($showvat == 1) {
                            //   $debits_s = $showvat_cal/1.01;
                            //   $calvat = $debits_s*0.01;
                            // }
                            // $showvat_ins = number_format($calvat, 2, '.', '');

                            $credits_s = $showvat_cal;
                            // $list_s = $datacredit[$i]->list;
                            $id_typejournal_s = 3;
                            $id_type_ref_journal = $datacredit[$i]->id_jourpay;
                            $datebills_start = $datacredit[$i]->datebill;
                            // $emp_outs = $datacredit[$i]->emp_out;
                            $vats = $datacredit[$i]->vat_percent;
                            $discounts = $datacredit[$i]->discount;
                            // $withholds = $datacredit[$i]->withhold;
                            $accode = '119501';
                            // $list = "".$datacredit[$i]->name."".'ค้างจ่าย';
                            $list = 'ภาษีมูลค่าเพิ่ม';

                              $arrInert = [ 'id'=>'',
                                      'dr'=>$credits_s,
                                      'cr'=>0.00,
                                      'acc_code'=>$accode,
                                      'branch'=>$branch_s,
                                      'status'=> 1,
                                      'number_bill'=> $numbe_debt1_s,
                                      // 'customer_vendor'=> $customer_ids,
                                      'timestamp'=>$datetime_copy,
                                      // 'code_emp'=>$emp_outs,
                                      'subtotal'=> 0,
                                      'discount'=> $discounts,
                                      'vat'=> $vats,
                                      'vatmoney'=> 0,
                                      // 'wht'=> $withholds,
                                      'whtmoney'=> 0,
                                      'grandtotal'=> $credits_s,
                                      'type_journal' => 3,
                                      'id_type_ref_journal'=>$id_type_ref_journal,
                                      'timereal'=>$datetime_copy,
                                      'list'=> $list];

                              DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);
                          }
                      }

                      for ($i=0; $i < count($datacredit) ; $i++) {
                        if ($datacredit[$i]->wht_percent >= 0.01) {
                            $branch_s = $datacredit[$i]->branch_id;
                            $numbe_debt1_s = $datacredit[$i]->receipt_no;
                            // $customer_ids = $datacredit[$i]->supplier_id;
                            // $accounttypenos_s = $datacredit[$i]->accounttypeno;
                            $wht_s = $datacredit[$i]->wht;
                            $credits_s = $wht_s;
                            // $list_s = $datacredit[$i]->list;
                            $id_typejournal_s = 3;
                            $id_type_ref_journal = $datacredit[$i]->id_jourpay;
                            $datebills_start = $datacredit[$i]->datebill;
                            // $emp_outs = $datacredit[$i]->emp_out;
                            $vats = $datacredit[$i]->vat_percent;
                            $discounts = $datacredit[$i]->discount;
                            $withholds = $datacredit[$i]->wht_percent;
                            // $accode = '111200';
                            $accode = '222002';
                            // $list = "".$datacredit[$i]->name."".'ค้างจ่าย';
                            $list = 'ภาษีหัก ณ ที่จ่าย';

                              $arrInert = [ 'id'=>'',
                                      'dr'=>0.00,
                                      'cr'=>$credits_s,
                                      'acc_code'=>$accode,
                                      'branch'=>$branch_s,
                                      'status'=> 1,
                                      'number_bill'=> $numbe_debt1_s,
                                      // 'customer_vendor'=> $customer_ids,
                                      'timestamp'=>$datetime_copy,
                                      // 'code_emp'=>$emp_outs,
                                      'subtotal'=> 0,
                                      'discount'=> $discounts,
                                      'vat'=> $vats,
                                      'vatmoney'=> 0,
                                      'wht'=> $withholds,
                                      'whtmoney'=>$wht_s,
                                      'grandtotal'=> $credits_s,
                                      'type_journal' => 3,
                                      'id_type_ref_journal'=>$id_type_ref_journal,
                                      'timereal'=>$datetime_copy,
                                      'list'=> $list];

                              DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);
                          }
                      }

        }
      }


                        // $reserve_moneys = DB::connection('mysql2')
                        //     ->table('reservemoney')
                        //     ->select('reservemoney.id as id_reservemoney','reservemoney.accept','reservemoney.accept','reservemoney.vat','reservemoney.vat_money','reservemoney.total'
                        //     ,'reservemoney.status','reservemoney.dateporef','reservemoney.bill_no','po_detail.list as po_detail_list','po_detail.note as po_detail_note','accounttype.accounttypeno'
                        //     ,'accounttype.accounttypefull','po_detail.total','reservemoney.branch')
                        //     ->join('po_head', 'reservemoney.po_ref', '=', 'po_head.id')
                        //     ->join('po_detail', 'reservemoney.po_ref', '=', 'po_detail.po_headid')
                        //     ->join('good', 'po_detail.materialid', '=', 'good.id')
                        //     ->join('accounttype', 'good.accounttype', '=', 'accounttype.id')
                        //     ->orderBy('reservemoney.bill_no', 'asc')
                        //     ->whereBetween('reservemoney.dateporef', [$start, $end])
                        //     ->where('reservemoney.status',1)
                        //     ->get();
      //ผ่านรายการสำรองจ่าย
      if (isset($data['id_reservemoneys'])) {
        $datack_reserv = $data['id_reservemoneys'];
        $comma_separated3 = implode(',', $datack_reserv);

        $sqlUpdate2 = ' UPDATE '.$db['fsctaccount'].'.reservemoney
                 SET accept = "1"
                 WHERE '.$db['fsctaccount'].'.reservemoney.id IN ('.$comma_separated3.')';
        $lgUpdateResulte2 = DB::connection('mysql')->select($sqlUpdate2);

        $sql13 = "SELECT $baseAc1.reservemoney.*
                                        ,journal_5.id as id_ref
                                        ,journalgeneral_detail.credit
                                        ,journalgeneral_detail.debit
                                        ,accounttype.accounttypeno
                                        ,journalgeneral_detail.list

                        FROM $baseAc1.reservemoney

                        INNER JOIN $baseAc1.journalgeneral_detail
                        ON $baseAc1.journal_5.id = $baseAc1.journalgeneral_detail.id_journalgeneral_head

                        INNER JOIN $baseAc1.accounttype
                        ON $baseAc1.journalgeneral_detail.accounttype = $baseAc1.accounttype.id

                        WHERE journal_5.id IN ($comma_separated2)";

        $data_reservm = DB::select($sql13);
         // dd($data_general);
         // exit;

         for ($i=0; $i < count($data_reservm) ; $i++) {
           $branch_s = $data_reservm[$i]->code_branch;
           $numbe_debt1_s = $data_reservm[$i]->number_bill_journal;
           $accounttypenos_s = $data_reservm[$i]->accounttypeno;
           $debits_s = $data_reservm[$i]->debit;
           $credits_s = $data_reservm[$i]->credit;
           $list_s = $data_reservm[$i]->list;
           $id_typejournal_s = 3;
           $id_type_ref_journal = $data_reservm[$i]->id_ref;
           $datebills_s = $data_reservm[$i]->datebill;

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
                     'type_journal' => 2,
                     'id_type_ref_journal'=>$id_type_ref_journal,
                     'timereal'=>$datetime_copy,
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
                     'type_journal' => 2,
                     'id_type_ref_journal'=>$id_type_ref_journal,
                     'timereal'=>$datetime_copy,
                     'list'=> $list_s];

             DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);
           }

         }
      }
      //--------ปิดผ่านรายการสำรอง








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
                        -- ON $baseAc1.inform_po.id_po = $baseAc1.supplier.id

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
           $id_typejournal_s = 3;
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
                     'type_journal' => 2,
                     'id_type_ref_journal'=>$id_type_ref_journal,
                     'timereal'=>$datetime_copy,
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
                     'type_journal' => 2,
                     'id_type_ref_journal'=>$id_type_ref_journal,
                     'timereal'=>$datetime_copy,
                     'list'=> $list_s];

             DB::table($db['fsctaccount'].'.ledger')->insert($arrInert);
           }

         }
      }

























        // $check_list = $request->get('check_list');
        // dd($check_list);
        // exit;
        // $ids = $request->get('numbe_debt1');
        // $journal_pay = DB::connection('mysql2')
        //     ->table('inform_po')
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
        // $ref  =  $request->get('id_journal_pay');
        //
        // $branch = $request->get('branch_ids');
        // $number_bill = $request->get('numbe_debt1');
        // $discount = $request->get('discounts');
        // $vat = $request->get('vat_percents');
        // $vatmoney = $request->get('vat_prices');
        // $type_journal = $request->get('id_typejournals');
        // $id_type_ref_journal = $request->get('id_bill_rents');
        // $timereal = $request->get('datebills');
        // $debitcredit = $request->get('decredit');
        //
        // $no_debts = $request->get('check_list');
        // // dd($no_debts);
        // // exit;
        //
        // foreach ($no_debts as $key => $value) {
        //   $ins_ledger = new Ledger;
        //   $ins_ledger->setConnection('mysql2');
        //
        //   $ins_ledger->dr = $debitcredit[$key];
        //   $ins_ledger->cr = $debitcredit[$key];
        //   $ins_ledger->branch = $branch[$key];
        //   $ins_ledger->number_bill = $value;
        //   $ins_ledger->discount = $discount[$key];
        //   $ins_ledger->vat = $vat[$key];
        //   $ins_ledger->vatmoney = $vatmoney[$key];
        //   $ins_ledger->type_journal = $type_journal[$key];
        //   $ins_ledger->id_type_ref_journal = $id_type_ref_journal[$key];
        //   $ins_ledger->timereal = $timereal[$key];
        //   // dd($ins_ledger);
        //   // exit;
        //   $ins_ledger->save();
        // }
        SWAL::message('สำเร็จ', 'ได้ทำการผ่านรายการแล้ว!', 'success', ['timer' => 6000]);
        return redirect()->route('journal.pay');
    }
}
