<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Branch;
use App\Api\Datetime;
use App\Api\Connectdb;
use DB;
use Session;

class Journal_saleController extends Controller
{
    public function index()
    {

        $branchs = Branch::where('status_main',1)->get();
        $dateNow = date('Y-m').'%';


		$database = Connectdb::Databaseall();

		$baseac = $database['fsctaccount'];
		$basemain = $database['fsctmain'];

        //$journals = DB::table($baseac.'.invoice_sell as db1',
        //                      $basemain.'.invoicerun as db3',
        //                      $basemain.'.inv_head as db2',
        //                      $baseac.'.accounttype as db4')
        //->join($basemain.'.invoicerun as db3', 'db1.invoice_id', '=', 'db3.id')
        //->join($basemain.'.inv_head as db2', 'db2.id', '=', 'db3.id_refhead')
        //->join($baseac.'.accounttype as db4', 'db4.id', '=', 'db1.account_id')
		//->where('datetime_out','like',$dateNow)
        //->get();


				  $sql ='SELECT '.$baseac.'.invoice_sell.*,
							 '.$basemain.'.invoicerun.*,
							 '.$basemain.'.inv_head.*,
							 '.$baseac.'.accounttype.*,
							 '.$baseac.'.invoice_sell.id as idinvsell

                       FROM '.$baseac.'.invoice_sell
						INNER JOIN '.$basemain.'.invoicerun
							ON '.$baseac.'.invoice_sell.invoice_id = '.$basemain.'.invoicerun.id
						INNER JOIN '.$basemain.'.inv_head
							ON '.$basemain.'.inv_head.id = '.$basemain.'.invoicerun.id_refhead
						INNER JOIN '.$baseac.'.accounttype
							ON '.$baseac.'.accounttype.id = '.$baseac.'.invoice_sell.account_id
						WHERE '.$baseac.'.invoice_sell.datetime_out LIKE "'.$dateNow.'"	';
            $journals = DB::connection('mysql')->select($sql);



              $sqljournal_general = 'SELECT '.$baseac.'.journal_5.*
                                  FROM '.$baseac.'.journal_5
                                   WHERE '.$baseac.'.journal_5.datebill  LIKE "'.$dateNow.'"
                                     AND '.$baseac.'.journal_5.type_module = 3
                                     AND '.$baseac.'.journal_5.status = 1';


           $datajournal_general = DB::connection('mysql')->select($sqljournal_general);


        // dd($journals);

        //
        // $journals_1 = DB::table('admin_accdemo.invoice_sell as db1')
        //     ->leftjoin('admin_maindemo.billengine_detail as db2', 'db1.bill_rent_id', '=', 'db2.bill_rent')
        //     ->join('admin_maindemo.billengine_rent as db3', 'db1.bill_rent_id', '=', 'db3.id')
        //     ->where('db1.type', 1)
        //     ->get();
        //
        // $ap_1 = 'default';
        // $ap_0 = 'default';
        //
        // $delivery_order_0 = DB::table('admin_accdemo.invoice_sell as db1')
        //     ->where('db1.type', '=', '0')
        //     ->leftjoin('admin_maindemo.bill_detail as db3', 'db1.bill_rent_id', '=', 'db3.bill_rent')
        //     ->leftjoin('admin_maindemo.bill_rent as db2', 'db1.bill_rent_id', '=', 'db2.id')
        //     ->where('db2.status', '>', '2')
        //     ->Leftjoin('admin_maindemo.material as db4', 'db4.id', '=', 'db3.material_id')
        //     ->get();
        // $do0 = 'default';
        //
        // $delivery_order_1 = DB::table('admin_accdemo.invoice_sell as db1')
        //     ->where('db1.type', '=', '1')
        //     ->leftjoin('admin_maindemo.billengine_detail as db3', 'db3.bill_rent', '=', 'db1.bill_rent_id')
        //     ->Leftjoin('admin_maindemo.billengine_rent as db2', 'db2.id', '=', 'db1.bill_rent_id')
        //     ->where('db2.status', '>', '2')
        //     ->Leftjoin('admin_maindemo.material as db4', 'db4.id', '=', 'db3.material_id')
        //     ->get();
        // $do1 = 'default';

        // dd($delivery_order_0);
        return view('journal.journal_sale', compact('branchs', 'journals','datajournal_general'));
    }

    public function confirm_journal_sale(Request $request)
    {
		$id = $request->get('check_list');

    $idgl = $request->get('check_list_gl');
    // echo "<pre>";
		// print_r($id);
    // print_r($idgl);
		$database = Connectdb::Databaseall();
    $emp_code = Session::get('emp_code');
		$baseac = $database['fsctaccount'];
		$basemain = $database['fsctmain'];
		$branchs = Branch::all();
    $dateNow = date('Y-m').'%';

		if(!empty($id)){
			foreach($id as $k =>$v ){
									//echo $v;
									//echo "<br>";
									// ค้นหาก่อน insert
                  $sqljournal_general = 'SELECT '.$baseac.'.invoice_sell.*
                                      FROM '.$baseac.'.invoice_sell
                                       WHERE '.$baseac.'.invoice_sell.invoice_id = "'.$v.'"
                                       AND accept = 0';


                  $datajournal_general = DB::connection('mysql')->select($sqljournal_general);


                  // print_r($datajournal_general);

									if(!empty($datajournal_general)){

                    $sqlUpdate = ' UPDATE '.$baseac.'.invoice_sell
                              SET accept = "1"
                              WHERE '.$baseac.'.invoice_sell.invoice_id = "'.$v.'" ';

                    $lgUpdateResulte = DB::connection('mysql')->select($sqlUpdate);

										//echo "insert";

										  $sql ='SELECT '.$baseac.'.invoice_sell.*,
													 '.$basemain.'.invoicerun.*,
													 '.$basemain.'.inv_head.*,
													 '.$baseac.'.accounttype.*,
													 '.$baseac.'.invoice_sell.id as idinvsell

											   FROM '.$baseac.'.invoice_sell
												INNER JOIN '.$basemain.'.invoicerun
													ON '.$baseac.'.invoice_sell.invoice_id = '.$basemain.'.invoicerun.id
												INNER JOIN '.$basemain.'.inv_head
													ON '.$basemain.'.inv_head.id = '.$basemain.'.invoicerun.id_refhead
												INNER JOIN '.$baseac.'.accounttype
													ON '.$baseac.'.accounttype.id = '.$baseac.'.invoice_sell.account_id
												WHERE '.$baseac.'.invoice_sell.invoice_id = "'.$v.'"	';
										 $journals = DB::connection('mysql')->select($sql);
                     // echo "<pre>";
                     // print_r($journals);
                     // exit;
                     foreach ($journals as $key => $value) {

                       if($value->type ==1){


                         $arrInert = [ 'id'=>'',
                                 'dr'=> '0.00',
                                 'cr'=> $value->grandtotal,
                                 'acc_code'=> $value->accounttypeno,
                                 'branch'=>$value->branch_id,
                                 'status'=> 1,
                                 'number_bill'=> $value->id_run,
                                 'customer_vendor'=> $value->customer_id,
                                 'timestamp'=>date('Y-m-d H:i:s'),
                                 'code_emp'=> $value->codeemp,
                                 'subtotal'=> '',
                                 'discount'=> '',
                                 'vat'=> '',
                                 'vatmoney'=> '',
                                 'wht'=> '',
                                 'whtmoney'=> '',
                                 'grandtotal'=> '',
                                 'type_income'=>$value->type ,
                                 'type_journal'=>2 ,
                                 'id_type_ref_journal'=> $value->idinvsell,
                                 'timereal'=> $value->datetime_out,
                                 'list'=> ''
                               ];
                         DB::table($baseac.'.ledger')->insert($arrInert);
                       }else if($value->type ==2){
                           $arrInert = [ 'id'=>'',
                                   'dr'=> '0.00',
                                   'cr'=> $value->grandtotal,
                                   'acc_code'=> $value->accounttypeno,
                                   'branch'=> $value->branch_id,
                                   'status'=> 1,
                                   'number_bill'=> $value->id_run,
                                   'customer_vendor'=> $journals[0]->customer_id,
                                   'timestamp'=>date('Y-m-d H:i:s'),
                                   'code_emp'=> $value->codeemp,
                                   'subtotal'=> '',
                                   'discount'=> '',
                                   'vat'=> '',
                                   'vatmoney'=> '',
                                   'wht'=> '',
                                   'whtmoney'=> '',
                                   'grandtotal'=> '',
                                   'type_income'=>$value->type ,
                                   'type_journal'=>2 ,
                                   'id_type_ref_journal'=> $value->idinvsell,
                                   'timereal'=> $value->datetime_out,
                                   'list'=> ''
                                 ];
                           DB::table($baseac.'.ledger')->insert($arrInert);
                       }else {
                         $arrInert = [ 'id'=>'',
                                 'dr'=> $value->grandtotal,
                                 'cr'=> '0.00',
                                 'acc_code'=> $value->accounttypeno,
                                 'branch'=>$value->branch_id,
                                 'status'=> 1,
                                 'number_bill'=> $value->id_run,
                                 'customer_vendor'=> $value->customer_id,
                                 'timestamp'=>date('Y-m-d H:i:s'),
                                 'code_emp'=> $value->codeemp,
                                 'subtotal'=> '',
                                 'discount'=> '',
                                 'vat'=> '',
                                 'vatmoney'=> '',
                                 'wht'=> '',
                                 'whtmoney'=> '',
                                 'grandtotal'=> '',
                                 'type_income'=>$value->type ,
                                 'type_journal'=>2 ,
                                 'id_type_ref_journal'=> $value->idinvsell,
                                 'timereal'=> $value->datetime_out,
                                 'list'=> ''
                               ];
                         DB::table($baseac.'.ledger')->insert($arrInert);
                       }

                     }

									}

					}

		}


    if(!empty($idgl)){
          	foreach($idgl as $m =>$n ){
              $sqlj5 = 'SELECT '.$baseac.'.journal_5.*
                                  FROM '.$baseac.'.journal_5
                                   WHERE '.$baseac.'.journal_5.id  = "'.$n.'"';

              $dataj5 = DB::connection('mysql')->select($sqlj5);

              $sqlUpdate = ' UPDATE '.$baseac.'.journal_5
                        SET accept = "1"
                        WHERE '.$baseac.'.journal_5.id = "'.$n.'" ';
              $lgUpdateResulte = DB::connection('mysql')->select($sqlUpdate);
            // echo "<pre>";

                foreach ($dataj5 as $i => $j) {
                      $sqlgldetail = 'SELECT '.$baseac.'.journalgeneral_detail.*
                                          FROM '.$baseac.'.journalgeneral_detail
                                           WHERE '.$baseac.'.journalgeneral_detail.id_journalgeneral_head  = "'.$n.'"';

                       $datadetail = DB::connection('mysql')->select($sqlgldetail);

                         // print_r($datadetail);
                         // exit;
                      $dr = 0;
                      $cr = 0;
                      foreach ($datadetail as $a => $b) {

                        $ac_id = $b->accounttype;
                        $sqlaccounttype = 'SELECT '.$baseac.'.accounttype.*
                                             FROM '.$baseac.'.accounttype
                                              WHERE '.$baseac.'.accounttype.id = "'.$ac_id.'" ';

                         $dataaccounttype = DB::connection('mysql')->select($sqlaccounttype);

                          if(!is_null($b->debit)){
                              $dr = $b->debit;
                          }

                          if(!is_null($b->credit)){
                              $cr = $b->credit;
                          }


                               $arrInert = [ 'id'=>'',
                                       'dr'=> $dr,
                                       'cr'=> $cr,
                                       'acc_code'=> $dataaccounttype[0]->accounttypeno,
                                       'branch'=>$dataj5[0]->code_branch,
                                       'status'=> 1,
                                       'number_bill'=> $dataj5[0]->number_bill_journal,
                                       'customer_vendor'=> '',
                                       'timestamp'=>date('Y-m-d H:i:s'),
                                       'code_emp'=> $emp_code,
                                       'subtotal'=> '',
                                       'discount'=> '',
                                       'vat'=> '',
                                       'vatmoney'=> '',
                                       'wht'=> '',
                                       'whtmoney'=> '',
                                       'grandtotal'=> '',
                                       'type_income'=>0 ,
                                       'type_journal'=>2 ,
                                       'id_type_ref_journal'=>  $b->id,
                                       'timereal'=> $dataj5[0]->datebill,
                                       'list'=> $dataaccounttype[0]->accounttypefull
                                     ];
                               DB::table($baseac.'.ledger')->insert($arrInert);
                      }

                }

            }
    }

       // echo "string";
       // exit;
				 $sql ='SELECT '.$baseac.'.invoice_sell.*,
							 '.$basemain.'.invoicerun.*,
							 '.$basemain.'.inv_head.*,
							 '.$baseac.'.accounttype.*,
							 '.$baseac.'.invoice_sell.id as idinvsell

                       FROM '.$baseac.'.invoice_sell
						INNER JOIN '.$basemain.'.invoicerun
							ON '.$baseac.'.invoice_sell.invoice_id = '.$basemain.'.invoicerun.id
						INNER JOIN '.$basemain.'.inv_head
							ON '.$basemain.'.inv_head.id = '.$basemain.'.invoicerun.id_refhead
						INNER JOIN '.$baseac.'.accounttype
							ON '.$baseac.'.accounttype.id = '.$baseac.'.invoice_sell.account_id
						WHERE '.$baseac.'.invoice_sell.datetime_out LIKE "'.$dateNow.'"	';
            $journals = DB::connection('mysql')->select($sql);


          $sqljournal_general = 'SELECT '.$baseac.'.journal_5.*
                              FROM '.$baseac.'.journal_5
                               WHERE '.$baseac.'.journal_5.datebill  LIKE "'.$dateNow.'"
                                 AND '.$baseac.'.journal_5.type_module = 3
                                 AND '.$baseac.'.journal_5.status = 1';


       $datajournal_general = DB::connection('mysql')->select($sqljournal_general);


		 return view('journal.journal_sale', compact('branchs', 'journals','datajournal_general'));
        // dd($check_list4  );
    }

    public function journalsale_filter(Request $request)
    {

        $date = $request->get('daterange');
        $branch = $request->get('branch');

        // echo "<pre>";
        // print_r($branch);
        // exit;

        $dateset = Datetime::convertStartToEnd($date);
        $start = $dateset['start'];
        $end = $dateset['end'];
        $database = Connectdb::Databaseall();

    		$baseac = $database['fsctaccount'];
    		$basemain = $database['fsctmain'];
		    $branchs = Branch::all();
        $branch = $branch[0];

        if ($branch != '0') {

			   $sql ='SELECT '.$baseac.'.invoice_sell.*,
							 '.$basemain.'.invoicerun.*,
							 '.$basemain.'.inv_head.*,
							 '.$baseac.'.accounttype.*,
							 '.$baseac.'.invoice_sell.id as idinvsell

                       FROM '.$baseac.'.invoice_sell
						INNER JOIN '.$basemain.'.invoicerun
							ON '.$baseac.'.invoice_sell.invoice_id = '.$basemain.'.invoicerun.id
						INNER JOIN '.$basemain.'.inv_head
							ON '.$basemain.'.inv_head.id = '.$basemain.'.invoicerun.id_refhead
						INNER JOIN '.$baseac.'.accounttype
							ON '.$baseac.'.accounttype.id = '.$baseac.'.invoice_sell.account_id
						WHERE '.$baseac.'.invoice_sell.datetime_out BETWEEN "'.$start.'" AND "'.$end.'"
						AND '.$basemain.'.inv_head.branch_id = "'.$branch.'" ';
            $journals = DB::connection('mysql')->select($sql);



           $sqljournal_general = 'SELECT '.$baseac.'.journal_5.*
                               FROM '.$baseac.'.journal_5
                                WHERE '.$baseac.'.journal_5.datebill BETWEEN "'.$start.'" AND  "'.$end.'"
                                  AND '.$baseac.'.journal_5.type_module = 3
                                  AND '.$baseac.'.journal_5.status = 1
                                  AND '.$baseac.'.journal_5.code_branch = "'.$branch.'"   ';


            $datajournal_general = DB::connection('mysql')->select($sqljournal_general);



		 return view('journal.journal_sale', compact('branchs', 'journals','datajournal_general'));

        } else {

            $sql ='SELECT '.$baseac.'.invoice_sell.*,
							 '.$basemain.'.invoicerun.*,
							 '.$basemain.'.inv_head.*,
							 '.$baseac.'.accounttype.*,
							 '.$baseac.'.invoice_sell.id as idinvsell

                       FROM '.$baseac.'.invoice_sell
						INNER JOIN '.$basemain.'.invoicerun
							ON '.$baseac.'.invoice_sell.invoice_id = '.$basemain.'.invoicerun.id
						INNER JOIN '.$basemain.'.inv_head
							ON '.$basemain.'.inv_head.id = '.$basemain.'.invoicerun.id_refhead
						INNER JOIN '.$baseac.'.accounttype
							ON '.$baseac.'.accounttype.id = '.$baseac.'.invoice_sell.account_id
						WHERE '.$baseac.'.invoice_sell.datetime_out BETWEEN "'.$start.'" AND "'.$end.'"	';
            $journals = DB::connection('mysql')->select($sql);


            $sqljournal_general = 'SELECT '.$baseac.'.journal_5.*
                                FROM '.$baseac.'.journal_5
                                 WHERE '.$baseac.'.journal_5.datebill BETWEEN "'.$start.'" AND  "'.$end.'"
                                   AND '.$baseac.'.journal_5.type_module = 3
                                   AND '.$baseac.'.journal_5.status = 1';

             $datajournal_general = DB::connection('mysql')->select($sqljournal_general);

		 return view('journal.journal_sale', compact('branchs', 'journals','datajournal_general'));

        }
    }
}
