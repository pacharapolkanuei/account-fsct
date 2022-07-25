<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use App\Api\Connectdb;
use App\Api\Datetime;
use DB;
use App\Branch;
use Redirect;

// use App\Inform_po_head;
// use App\Inform_po_detail;
// use App\Good;
// use App\Config_group_supp;
use Illuminate\Support\Facades\Input;
use Softon\SweetAlert\Facades\SWAL;

class JournalController extends Controller
{
  use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

  function index(){

    $branchs = new Branch;
    $branchs->setConnection('hr_base');
    $branchs = Branch::get();

    
      $connect = Connectdb::Databaseall();
      $baseAc = $connect['fsctaccount'];
      $baseHr = $connect['hr_base'];
    
      $sql = "SELECT inform_po_head.*
                          ,inform_po_head.id as poheadid
                          ,inform_po_detail.*
                          ,good.*
                          ,config_group_supp.*
                          ,accounttype.*
                          ,type_pay.name_pay
                          ,type_pay.creaditpay
                          ,type_pay.acctype as acctypenum
                          ,withhold.acctype as acctypewhd
                          ,tax_config.acctype as acctype
                          ,inform_po_head.company_pay_wht as acccompanywht
                          ,branch.name_branch as name_branch
                          ,bank_detail.account_no
                          
                      FROM $baseAc.inform_po_head

                      LEFT JOIN $baseAc.bank_detail
                      ON $baseAc.inform_po_head.id_bankdetail = $baseAc.bank_detail.id

                      INNER JOIN $baseHr.branch
                      ON $baseAc.inform_po_head.branch_id = $baseHr.branch.code_branch

                      INNER JOIN $baseAc.inform_po_detail
                      ON $baseAc.inform_po_head.id = $baseAc.inform_po_detail.inform_po_head

                      INNER JOIN $baseAc.good
                      ON $baseAc.inform_po_detail.materialid = $baseAc.good.id

                      INNER JOIN $baseAc.config_group_supp
                      ON $baseAc.good.group_supplier = $baseAc.config_group_supp.id

                      INNER JOIN $baseAc.accounttype
                      ON $baseAc.good.accounttype = $baseAc.accounttype.id

                      INNER JOIN $baseAc.type_pay
                      ON $baseAc.type_pay.id = $baseAc.inform_po_head.type_pay

                      INNER JOIN $baseAc.withhold
                      ON $baseAc.withhold.withhold = $baseAc.inform_po_head.wht_percent

                      INNER JOIN $baseAc.tax_config
                      ON $baseAc.tax_config.tax = $baseAc.inform_po_head.vat_percent

                      WHERE inform_po_head.status IN (1)
                      ";
      $datas = DB::select($sql);
      // dd($datas);
    
    return view('journal.journal',['branchs'=>$branchs,'datas'=>$datas]);
  }

  public function store(Request $request)
  {
      $daterange = $request->post('daterange');
      $dateset = Datetime::convertStartToEnd($daterange);

      $start = $dateset['start'];
      $end = $dateset['end'];

      $branch_search = $request->post('branch_search');
      $column_search = $request->post('column_search');

      $branchs = new Branch;
      $branchs->setConnection('hr_base');
      $branchs = Branch::get();

      $connect = Connectdb::Databaseall();
      $baseAc = $connect['fsctaccount'];
      $baseHr = $connect['hr_base'];


      $comma_separated = implode(",", $branch_search);
      

      // echo $comma_separated;
      // exit;

      echo $sql = "SELECT inform_po_head.*
                                ,inform_po_head.id as poheadid
                                ,inform_po_detail.*
                                ,good.*
                                ,config_group_supp.*
                                ,accounttype.*
                                ,type_pay.name_pay
                                ,type_pay.creaditpay
                                ,type_pay.acctype as acctypenum
                                ,withhold.acctype as acctypewhd
                                ,tax_config.acctype as acctype
                                ,inform_po_head.company_pay_wht as acccompanywht
                                ,branch.name_branch as name_branch


                            FROM $baseAc.inform_po_head

                            INNER JOIN $baseHr.branch
                            ON $baseAc.inform_po_head.branch_id = $baseHr.branch.code_branch

                            INNER JOIN $baseAc.inform_po_detail
                            ON $baseAc.inform_po_head.id = $baseAc.inform_po_detail.inform_po_head

                            INNER JOIN $baseAc.good
                            ON $baseAc.inform_po_detail.materialid = $baseAc.good.id

                            INNER JOIN $baseAc.config_group_supp
                            ON $baseAc.good.group_supplier = $baseAc.config_group_supp.id

                            INNER JOIN $baseAc.accounttype
                            ON $baseAc.good.accounttype = $baseAc.accounttype.id

                            INNER JOIN $baseAc.type_pay
                            ON $baseAc.type_pay.id = $baseAc.inform_po_head.type_pay

                            INNER JOIN $baseAc.withhold
                            ON $baseAc.withhold.withhold = $baseAc.inform_po_head.wht_percent

                            INNER JOIN $baseAc.tax_config
                            ON $baseAc.tax_config.tax = $baseAc.inform_po_head.vat_percent



                            WHERE inform_po_head.status IN (1)
                            AND  $baseAc.inform_po_head.datetime BETWEEN '$start' AND '$end'
                            AND  $baseHr.branch.code_branch IN ($comma_separated)
                            ";

      $datas = DB::select($sql);
      
      

      $dataset= ['daterange'=>$daterange,
              'branch_search'=>$branch_search,
              'column_search'=>$column_search,
              'query'=>true,
              'branchs'=>$branchs,
              'datas'=>$datas];

      return  Redirect::back()->with('msg', $dataset);

  }
}

