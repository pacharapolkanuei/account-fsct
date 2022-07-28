<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use DB;
// use App\Http\Requests\Inform_po_headRequest;
use App\Http\Requests\Infrom_po_mainheadRequest;
use App\Branch;
use App\Po;
use App\Bank;
use App\Po_detail;
use App\Api\Connectdb;
use App\Po_head;
use App\Withhold;
use App\Api\Datetime;
use App\Tax_config;
use App\Inform_po_head;
use App\Inform_po_detail;
use App\Inform_po_relation;
use App\Infrom_po_mainhead;
use App\Type_pay;
use App\Insertcashrent;
use Illuminate\Support\Facades\Input;
use Softon\SweetAlert\Facades\SWAL;
use PDF;

class payserController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    function index(){

      $connect1 = Connectdb::Databaseall();
      $baseAc1 = $connect1['fsctaccount'];
      $baseHr1 = $connect1['hr_base'];

    	$branchs = new Branch;
    	$branchs->setConnection('hr_base');
		  $branchs = Branch::get();

      $type_pays = new Type_pay;
      $type_pays->setConnection('mysql2');
      $type_pays = Type_pay::where('status','=',1)
                      ->get();

      $whts = new Withhold;
      $whts->setConnection('mysql2');
      $whts = Withhold::where('status','=',1)
                    ->get();

      $vats = new Tax_config;
      $vats->setConnection('mysql2');
      $vats = Tax_config::where('status','=',1)
                    ->get();

      $banks = new Bank;
      $banks->setConnection('mysql2');
      $banks = Bank::where('status','=',1)
                    ->get();

      // $suppliers = DB::connection('mysql2')
      //             ->table('supplier')
      //             ->where('supplier.status','=',1)
      //             ->get();

      // $inform_po_mainheads = DB::connection('mysql2')
      //                             ->table('inform_po_mainhead')
      //                             ->join('po_head', 'inform_po_mainhead.po_id', '=', 'po_head.id')
      //                             // ->join('supplier', 'po_head.supplier_id', '=', 'supplier.id')
      //                             ->where('inform_po_mainhead.type','=',2)
      //                             ->where('inform_po_mainhead.status','=',1)
      //                             // ->orderByRaw('payser_number ASC')
      //                             ->get();
       $datenow = date("Y-m-d");
       $sql1 = "SELECT $baseAc1.inform_po.*
                                      ,supplier.name_supplier
                                      ,supplier.tax_id
                                      ,inform_po.id as id_inform_po

                      FROM $baseAc1.inform_po

                      INNER JOIN $baseAc1.po_head
                      ON $baseAc1.inform_po.id_po = $baseAc1.po_head.id

                      INNER JOIN $baseAc1.supplier
                      ON $baseAc1.po_head.supplier_id = $baseAc1.supplier.id

                      WHERE $baseAc1.inform_po.type = 2 AND  $baseAc1.inform_po.status = 1 AND $baseAc1.inform_po.type_newtable = 1
                      AND $baseAc1.inform_po.datetime LIKE '%$datenow%'
                      ORDER BY $baseAc1.inform_po.payser_number ASC";

        $inform_po_mainheads = DB::select($sql1);

     return view('payser.payser',['branchs'=>$branchs,
                                  'whts'=>$whts,
                                  'vats'=>$vats,
                                  'type_pays'=>$type_pays,
                                  'inform_po_mainheads'=>$inform_po_mainheads,
                                  'banks'=>$banks]);
    }

    public function  payser_filters(Request $request)
    {
        $date = $request->get('daterange');
        // $branch = $request->get('branch');

        $dateset = Datetime::convertStartToEnd($date);
        $start = $dateset['start'];
        $end = $dateset['end'];
        // echo $start;
        // echo $end;
        // exit;

        $branchs = new Branch;
      	$branchs->setConnection('hr_base');
  		  $branchs = Branch::get();

        $type_pays = new Type_pay;
        $type_pays->setConnection('mysql2');
        $type_pays = Type_pay::where('status','=',1)
                        ->get();

        $vats = new Tax_config;
        $vats->setConnection('mysql2');
        $vats = Tax_config::where('status','=',1)
                      ->get();

        $inform_po_mainheads = DB::connection('mysql2')
            ->table('inform_po')
            ->select('inform_po.id as id_inform_po','inform_po.datebill','inform_po.payser_number','inform_po.bill_no','inform_po.datebill'
            , 'inform_po.branch_id' , 'inform_po.new_inform_po_picture' ,'inform_po.payout','supplier.name_supplier','supplier.tax_id')
            ->join('po_head', 'po_head.id', '=', 'inform_po.id_po')
            ->join('supplier', 'supplier.id', '=', 'po_head.supplier_id')
            ->orderBy('inform_po.id', 'asc')
            ->whereBetween('inform_po.datetime', [$start.'%', $end.'%'])
            ->where('inform_po.type',2)
            ->where('inform_po.status',1)
            ->where('inform_po.type_newtable',1)
            ->get();
            // dump('have');
        // } else {
        //     $payser = DB::connection('mysql2')
        //         ->table('inform_po')
        //         ->select('inform_po.id','inform_po.datebill','inform_po.payser_number','inform_po.bill_no','inform_po.datebill','inform_po.tax_id'
        //         ,'inform_po.name_supplier','inform_po.payout','supplier.name_supplier','supplier.tax_id')
        //         ->join('po_head', 'po_head.id', '=', 'inform_po.id_po')
        //         ->join('supplier', 'supplier.id', '=', 'po_head.supplier_id')
        //         ->orderBy('id', 'asc')
        //         ->whereBetween('date_buy', [$start, $end])
        //         ->get();
            // dump('empty');
        // }
        // dd($inform_po_mainheads);
        // exit;
        return view('payser.payser', compact('inform_po_mainheads', 'date' , 'branchs' , 'type_pays' , 'vats'));
    }


    public function pdf($id)
      {
      if (isset($id)) {
        $keep_id = $id;
      }

      $report_paysers = DB::connection('mysql2')
        ->table('inform_po')
        ->join('po_head', 'inform_po.id_po', '=', 'po_head.id')
        ->join('po_detail', 'inform_po.id_po', '=', 'po_detail.po_headid')
        ->join('supplier', 'po_head.supplier_id', '=', 'supplier.id')
        ->join('type_pay', 'inform_po.type_pay', '=', 'type_pay.id')
        ->where('po_detail.statususe','=',1)
        ->where('inform_po.id',$keep_id)
        ->get();

        $pdf = PDF::loadView('payser.payserpdf', ['report_paysers' => $report_paysers]);
        return @$pdf->stream();
      }

    function getbranchtoconpay($branchcode){
      $start = "2020-01-01";
  	  $end = "2030-12-31";

    	$get_po_num = new Po;
    	$get_po_num->setConnection('mysql2');
		  $get_po_num = Po::where('branch_id',$branchcode)
        ->where('date', '>=', $start)
        ->where('date', '<=', $end)
				->where('type_po',0)
        ->where('status_head','=',2)
        ->orderBy('po_number', 'asc')
				->get();
    	// dd($get_po_num);
      return $get_po_num;
    }

    function getbankdetail($getidbank){
    	$bank = new Bank;
    	$bank->setConnection('mysql2');
		  $bank = Bank::where('status_use','!=',99)
				          ->get();
    	// dd($po);
      return $bank;
    }

    function getbankfromacctype($getbank)
    {
      $connect1 = Connectdb::Databaseall();
      $baseAc1 = $connect1['fsctaccount'];
      $baseHr1 = $connect1['hr_base'];

      $sql1 = "SELECT * FROM $baseAc1.accounttype WHERE $baseAc1.accounttype.accounttypefull LIKE '%เงินฝากออมทรัพย์%' OR $baseAc1.accounttype.accounttypefull LIKE '%เงินกู้ยืมจาก%'";

      $get_bank = DB::select($sql1);
      return $get_bank;
    }

    function postcalculatepo(Request $request){
         $id = $request->post('data');
         // $po = Po::find($id);

         $po = new Po_detail;
         $po->setConnection('mysql2');
         $po = Po_detail::whereIn('po_headid',$id)
                        ->where('statususe','=',1)
                        ->sum('total');
           //
           // ->get();

       	 return $po;
    }

  function getpohead($po_id){
    	$po = Po::find($po_id);
    	return $po;
	}

  public function check(Request $request){
  $test = $request->get('type_po');
      return ;
  }

  function getpodetailbyhead(Request $request)
  {
        $id = $request->post('data');

       $po_detail = new Po_detail;
       $po_detail->setConnection('mysql2');
       $po_detail = Po_detail::join('po_head', 'po_head.id', '=', 'po_detail.po_headid')
                     ->whereIn('po_detail.po_headid', $id)
                     ->where('statususe','=',1)
                     ->get();
       // $po = Po::find($id);
       return $po_detail;

  }

  function getwht($getwithhold){
        $whts = new Withhold;
        $whts->setConnection('mysql2');
        $whts = Withhold::where('id',$getwithhold)
                      ->where('status','=',1)
                      ->get();
       // $po = Po::find($id);
        return view('payser.payser',['whts'=>$whts]);
  }


  public function edit_data_payser($id)
  {
    $array = array($id);
    $comma_separated = implode(',', $array);
    // dd($comma_separated);
    // exit;
    $connect1 = Connectdb::Databaseall();
    $baseAc1 = $connect1['fsctaccount'];
    $baseHr1 = $connect1['hr_base'];

    $sql1 = "SELECT $baseAc1.inform_po.*
                                    ,po_head.id
                                    ,po_head.po_number
                                    ,branch.code_branch
                                    ,branch.name_branch
                                    ,po_detail.list
                                    ,po_detail.amount
                                    ,po_detail.price
                                    ,po_detail.total
                                    ,po_detail.note
                                    ,po_detail.id as id_po_detail
                                    ,inform_po.id as id_inform_poz
                                    -- ,type_pay.id
                                    -- ,type_pay.name_pay

                    FROM $baseAc1.inform_po

                    -- INNER JOIN $baseAc1.type_pay
                    -- ON $baseAc1.inform_po.type_pay = $baseAc1.type_pay.id
                    INNER JOIN $baseAc1.po_head
                    ON $baseAc1.inform_po.id_po = $baseAc1.po_head.id

                    INNER JOIN $baseAc1.po_detail
                    ON $baseAc1.inform_po.id_po = $baseAc1.po_detail.po_headid

                    INNER JOIN $baseHr1.branch
                    ON $baseAc1.inform_po.branch_id = $baseHr1.branch.code_branch

                    WHERE $baseAc1.inform_po.id = $comma_separated ";
      $inform_po_mainheads = DB::select($sql1);

      $sql2 = "SELECT $baseAc1.inform_po.*
                                      ,po_head.id
                                      ,po_head.po_number
                                      ,branch.code_branch
                                      ,branch.name_branch
                                      ,inform_po.id as id_inform_poz

                      FROM $baseAc1.inform_po

                      INNER JOIN $baseAc1.po_head
                      ON $baseAc1.inform_po.id_po = $baseAc1.po_head.id

                      INNER JOIN $baseHr1.branch
                      ON $baseAc1.inform_po.branch_id = $baseHr1.branch.code_branch

                      WHERE $baseAc1.inform_po.id = $comma_separated ";
        $inform_pos = DB::select($sql2);
      // dd($inform_po_mainheads);
      // exit;
      return view('payser.edit_payser', compact('inform_po_mainheads','inform_pos'));
  }

  public function update_data_payser(Request $request)
  {
    $connect1 = Connectdb::Databaseall();
    $baseAc1 = $connect1['fsctaccount'];
    $baseHr1 = $connect1['hr_base'];

    $get_id_po = $request->get('get_id');
    $array = array($get_id_po);
    $comma_separated = implode(',', $array);
    // dd($comma_separated);
    // exit;
    $datebills = $request->get('date_picker_withtaxs');
    $bill_nos = $request->get('bill_no_withtaxs');
    $datebillreceipts = $request->get('date_picker_withpaybills');
    $receipt_nos = $request->get('bill_no_withpaybills');
    // $insert_cashrent = $request->get('get_emp');
    // $insert_cashrent = $request->get('branch');
    if ($request->get('sum_discount')) {
      $discounts = $request->get('sum_discount');
    }else {
      $discounts = 0.00;
    }

    if ($request->get('vat_price')) {
      $vat_prices = $request->get('vat_price');
    }else {
      $vat_prices = 0.00;
    }

    if ($request->get('date_pay_wht')) {
      $date_pay_whts = $request->get('date_pay_wht');
    }else {
      $date_pay_whts = 0000-00-00;
    }

    if ($request->get('wth_price')) {
      $wth_prices = $request->get('wth_price');
    }else {
      $wth_prices = 0.00;
    }

    if ($request->get('payouts')) {
      $payoutss = $request->get('payouts');
    }else {
      $payoutss = 0.00;
    }

    $update_inform = Infrom_po_mainhead::find($comma_separated);
    $update_inform->setConnection('mysql2');
    $update_inform->datebill = $datebills;
    $update_inform->bill_no = $bill_nos;
    $update_inform->datebillreceipt = $datebillreceipts;
    $update_inform->receipt_no = $receipt_nos;
    $update_inform->discount = $discounts;
    $update_inform->vat_price = $vat_prices;
    $update_inform->date_pay_wht = $date_pay_whts;
    $update_inform->wht = $wth_prices;
    $update_inform->payout = $payoutss ;
    $update_inform->save();

    // $id_po_detailz = $request->get('id_po_details');
    // // dd($comma_separated2);
    // // exit;
    // $comma_separated2 = implode(',', $id_po_detailz);
    // dd($comma_separated2);
    // exit;
    // // VendorDetail::whereIn('vendor_id', [$request->id])->update($values);
    // // VendorDetail::where('vendor_id',$request->id)->update($values);
    // $amontss = $request->get('amonts');
    // $pricess = $request->get('prices');
    //
    // Po_detail::whereIn('id', $comma_separated2)
    //          ->update([
    //             'amount' => $amontss,
    //             'price' => $pricess,
    // ]);

    $sql2 = "SELECT $baseAc1.inform_po.*
                                    ,po_head.id
                                    ,po_head.po_number
                                    ,branch.code_branch
                                    ,branch.name_branch
                                    ,inform_po.id as id_inform_poz

                    FROM $baseAc1.inform_po

                    INNER JOIN $baseAc1.po_head
                    ON $baseAc1.inform_po.id_po = $baseAc1.po_head.id

                    INNER JOIN $baseHr1.branch
                    ON $baseAc1.inform_po.branch_id = $baseHr1.branch.code_branch

                    WHERE $baseAc1.inform_po.id = $comma_separated ";
      $inform_pos = DB::select($sql2);
    return view('payser.edit_payser', compact('inform_po_mainheads','inform_pos'));
  }

  public function getpayseredit($infrompoid)
  {
    $connect1 = Connectdb::Databaseall();
    $baseAc1 = $connect1['fsctaccount'];
    $baseHr1 = $connect1['hr_base'];

    $sql1 = "SELECT $baseAc1.inform_po.*
                                    ,po_head.id
                                    ,po_head.po_number
                                    ,branch.code_branch
                                    ,branch.name_branch
                                    ,type_pay.id
                                    ,type_pay.name_pay

                    FROM $baseAc1.inform_po

                    INNER JOIN $baseAc1.type_pay
                    ON $baseAc1.inform_po.type_pay = $baseAc1.type_pay.id

                    INNER JOIN $baseAc1.po_head
                    ON $baseAc1.inform_po.id_po = $baseAc1.po_head.id

                    INNER JOIN $baseHr1.branch
                    ON $baseAc1.inform_po.branch_id = $baseHr1.branch.code_branch

                    WHERE $baseAc1.inform_po.id = $infrompoid ";

      $getdatas = DB::select($sql1);
      return $getdatas;
  }

  public function getdataviewpicture($id)
  {
    $connect1 = Connectdb::Databaseall();
    $baseAc1 = $connect1['fsctaccount'];

    $sql1 = "SELECT * FROM $baseAc1.inform_po

                    WHERE $baseAc1.inform_po.id = '$id'";

      $getdatas = DB::select($sql1);
      return $getdatas;
  }

  public function getbankdetail1($getpos)
  {
    $connect1 = Connectdb::Databaseall();
    $baseAc1 = $connect1['fsctaccount'];

    $sql1 = "SELECT $baseAc1.inform_po.*
                                    ,bank_detail.id
                                    ,bank_detail.account_no
                                    ,bank_detail.account_name

                    FROM $baseAc1.inform_po

                    INNER JOIN $baseAc1.bank_detail
                    ON $baseAc1.inform_po.id_bankdetail = $baseAc1.bank_detail.id

                    WHERE $baseAc1.inform_po.id = '$getpos'";

      $getdatas = DB::select($sql1);
      return $getdatas;
  }

  public function getinfofromidpo1(Request $request)
  {
    $id = $request->post('data');
    $arrIn = implode(",",$id);
    $connect1 = Connectdb::Databaseall();
    $baseAc1 = $connect1['fsctaccount'];

       $sql1 = "SELECT $baseAc1.po_head.*
                            ,inform_po.payser_number
                            ,po_detail.price
                            ,po_detail.list

                    FROM $baseAc1.po_head

                    INNER JOIN $baseAc1.inform_po
                    ON $baseAc1.po_head.id = $baseAc1.inform_po.id_po

                    INNER JOIN $baseAc1.po_detail
                    ON $baseAc1.po_head.id = $baseAc1.po_detail.po_headid

                    WHERE $baseAc1.po_head.id IN ($arrIn) AND inform_po.status = 1 AND po_detail.statususe = 1";

      $getdatas = DB::select($sql1);
    return $getdatas;
  }


  public function store(Infrom_po_mainheadRequest $request)
  {
    if ($request->get('get_emp') != null) {
      $connect1 = Connectdb::Databaseall();
      $baseAc1 = $connect1['fsctaccount'];

      $get_branch = $request->get('branch');
      $count = DB::connection('mysql2')
        ->table('inform_po')
        ->where('branch_id','=',$get_branch)
        ->get();
      $count_payser = count($count)+1;

          $payser = new Infrom_po_mainhead;
          $payser->setConnection('mysql2');

          $payser_poid = $request->get('po_headid');
          $result = array_unique($payser_poid);
          $commaSeparated = implode(',' , $result);
          $payser->id_po = $commaSeparated;

          for ($i=1001; $i <= 1050 ; $i++) {
            if ($request->get('branch') == $i) {
              $payser->payser_number = "PS" . $i . date("ym") . sprintf('%04d', $count_payser);
            }
          }

          if ($request->get('ins_statusbank') ==  3) {
            $payser->type = "3";
          }
          elseif ($request->get('ins_pettycash') == 1) {
            $payser->type = "4";
          }
          elseif ($request->get('sum_vat') < 0) {
            $payser->type = "6";
          }
          // elseif ($request->get('sum_vat') < 0) {
          //   $payser->type = "5";
          // }
          else {
            $payser->type = "2";
          }

          // $po_ref = $request->get('po_number_ins');
          // echo $po_ref;
          // exit;
          $payser->bill_no = $request->get('bill_no_withtax');
          $payser->receipt_no = $request->get('bill_no_withpaybill');
          $payser->po_ref = $request->get('po_number_ins');
          $payser->inform_po_picture = $request->get('po_number_ins');
          $payser->bill_from_vat = $request->get('bill_no_withtax');
          $payser->branch_id = $request->get('branch');
          $payser->discount = $request->get('sum_discount');
          $payser->wht_percent = $request->get('wht_percent');
          $payser->vat_percent = $request->get('vat');

          $payser->vat_price = $request->get('vat_cal_true');

          if ($request->get('type_po') == 3) {
            $payser->type_pay = "1";
          }else {
            $payser->type_pay = $request->get('type_po');
          }

          $payser->payout = $request->get('grand_total');

          $payser->datebill = $request->get('date_picker_withtax');
          $payser->datebillreceipt = $request->get('date_picker_withpaybill');

          $payser->type_newtable = "1";

          if ($request->get('company_pay')) {
            $payser->company_pay_wht = $request->get('company_pay');
          }
          if ($request->get('date_picker_wht')) {
            $payser->date_pay_wht = $request->get('date_picker_wht');
          }
          if ($request->get('sum_wht')) {
            $payser->wht = $request->get('sum_wht');
          }
          if ($request->get('bank')) {
            $payser->account_bank = $request->get('bank');
          }


      if ($request->hasFile('inform_po_picture')) {
        $image_filename = $request->file('inform_po_picture')->getClientOriginalName();
        $image_name = date("Ymd-His-") . $image_filename;
        $public_path = 'images/inform_po_picture/';
        $destination = base_path() . "/public/" . $public_path;
        $request->file('inform_po_picture')->move($destination, $image_name);
        $payser->new_inform_po_picture = $public_path . $image_name;
      }
      $payser->save();

      $ref  =  $request->get('po_headid');
      // $get_po_num = $request->get('po_number_ins');
      $log  =  $request->get('po_number_ins');
      $money  =  $request->get('grand_total');
      $typereftax  =  $request->get('po_headid');

      $arruse = implode(",",$ref);
      $token = strtok($arruse, ",");
      // $sql1 = "SELECT * FROM $baseAc1.inform_po WHERE $baseAc1.inform_po.id_po = $arruse";
      // $getdatas = DB::select($sql1);
      // $get_id_informpo = $getdatas[0]->id;
      //
      // foreach ($ref as $key => $value) {
      if ($request->get('check_ins_reserv') != 1) {
        $insert_cashrent = new Insertcashrent;
        $insert_cashrent->setConnection('mysql2');
        $insert_cashrent->emp_code = $request->get('get_emp');
        $insert_cashrent->branch = $request->get('branch');

        if ($request->get('type_po') == 3) {
          $insert_cashrent->typetranfer = 1;
        }
        else {
          $insert_cashrent->typetranfer = 2;
        }

        $insert_cashrent->status = '1';

        $typedoc = $request->get('po');
        $typedoc = '10';

        $insert_cashrent->typedoc = $typedoc;
        $insert_cashrent->log = 'จ่ายเงินให้กับใบ  '.$log;
        $insert_cashrent->money = $money;
        $insert_cashrent->ref = $token;
        $insert_cashrent->typereftax = $token;

        $insert_cashrent->save();
      }

      // }

      $lastidpohead = $payser->id;

      // $count_list = $request->get('count_list'); //จำนวนรายการ
      $config_group_supp_id =  $request->get('config_group_supp_id');
      $materialid  =  $request->get('materialid');
      $list  =  $request->get('list');
      $amount  =  $request->get('amount');
      $type_amount  =  $request->get('type_amount');
      $price  =  $request->get('price');
      $discount  =  $request->get('discount');
      $withhold  =  $request->get('withhold');
      $total  =  $request->get('sum');
      $quantity_get  =  $request->get('quantity_get');
      $quantity_loss  =  $request->get('quantity_loss');
      $status  =  $request->get('status');
      $po_headid  =  $request->get('po_headid');

      $arraynew = array_unique($materialid);
      // $arraynew = [];

      $arraynewkey = [];
      $arrayresult = 0;
      // Unique values
      $unique = array_unique($materialid);

      // Duplicates
      $duplicates = array_diff_assoc($materialid, $unique);

      // Unique values
      $result = array_diff($unique, $duplicates);

      // Get the unique keys
      $unique_keys = array_keys($result);

      // Get duplicate keys
      $duplicate_keys = array_keys(array_intersect($materialid, $duplicates));

      $arrrnew= [];

      if($duplicate_keys){
            $sumprice = 0;
            $sumdiscount = 0;
            $sumwithhold = 0;
            $sumtotal = 0;

            // $a
            foreach ($materialid as $key => $value) {
                $setid = $materialid[$key];

                    if (in_array($key, $duplicate_keys))
                      {
                        $sumprice = $sumprice + $price[$key];
                        $sumdiscount = $sumdiscount + $discount[$key];
                        $sumwithhold =  $sumwithhold + $withhold[$key];
                        $sumtotal = $sumtotal + $total[$key];

                        $arrrnew[$setid]['config_group_supp_id'] = $config_group_supp_id[$key];
                        $arrrnew[$setid]['materialid'] = $setid;
                        $arrrnew[$setid]['list'] =  $list[$key];
                        $arrrnew[$setid]['amount'] =  $amount[$key];
                        $arrrnew[$setid]['type_amount'] =  $type_amount[$key];
                        $arrrnew[$setid]['price'] = $sumprice ; // $price[$key];
                        $arrrnew[$setid]['discount'] =  $sumdiscount; //$discount[$key];
                        $arrrnew[$setid]['withhold'] = $sumwithhold;// $withhold[$key];
                        $arrrnew[$setid]['po_head'] =  $po_headid[$key];
                        $arrrnew[$setid]['total'] = $sumtotal ;// $total[$key];
                        $arrrnew[$setid]['status'] =  1;
                        $arrrnew[$setid]['inform_po_head'] =  $lastidpohead;

                      }else{
                        $arrrnew[$setid]['config_group_supp_id'] = $config_group_supp_id[$key];
                        $arrrnew[$setid]['materialid'] = $setid;
                        $arrrnew[$setid]['list'] =  $list[$key];
                        $arrrnew[$setid]['amount'] =  $amount[$key];
                        $arrrnew[$setid]['type_amount'] =  $type_amount[$key];
                        $arrrnew[$setid]['price'] =  $price[$key];
                        $arrrnew[$setid]['discount'] =  $discount[$key];
                        $arrrnew[$setid]['withhold'] =  $withhold[$key];
                        $arrrnew[$setid]['po_head'] =  $po_headid[$key];
                        $arrrnew[$setid]['total'] =  $total[$key];
                        $arrrnew[$setid]['status'] = 1;
                        $arrrnew[$setid]['inform_po_head'] =  $lastidpohead;

                      }

            }
                  foreach ($arrrnew as $key => $value) {
                          $inform_po_detail = new Inform_po_detail;
                          $inform_po_detail->config_group_supp_id = $value['config_group_supp_id'];
                          $inform_po_detail->materialid =  $value['materialid'];
                          $inform_po_detail->list =  $value['list'];
                          $inform_po_detail->amount =  $value['amount'];
                          $inform_po_detail->type_amount =  $value['type_amount'];
                          $inform_po_detail->price= $value['price'];
                          $inform_po_detail->discount=  $value['discount'];
                          $inform_po_detail->withhold =   $value['withhold'];
                          $inform_po_detail->status = 1;
                          $inform_po_detail->inform_po_head = $value['inform_po_head'];
                          $inform_po_detail->po_head = $value['po_head'];

                          $inform_po_detail->save();
                          $lastid = $inform_po_detail->id;

                  }

      }else{
        ///  case not duplicate
              foreach ($config_group_supp_id as $key => $value) {
                    // $list = $list[$key];
                      $inform_po_detail = new Inform_po_detail;
                      $inform_po_detail->config_group_supp_id = $value;
                      $inform_po_detail->materialid =  $materialid[$key];
                      $inform_po_detail->list =  $list[$key];
                      $inform_po_detail->amount =  $amount[$key];
                      $inform_po_detail->type_amount =  $type_amount[$key];
                      $inform_po_detail->price=  $price[$key];
                      $inform_po_detail->discount=  $discount[$key];
                      $inform_po_detail->withhold =  $withhold[$key];
                      $inform_po_detail->total = $total[$key];
                      $inform_po_detail->quantity_get = $quantity_get[$key];
                      $inform_po_detail->quantity_loss = $quantity_loss[$key];
                      $inform_po_detail->status = $status[$key];
                      $inform_po_detail->po_head = $po_headid[$key];
                      $inform_po_detail->inform_po_head = $lastidpohead;

                      $inform_po_detail->save();

                      $lastid = $inform_po_detail->id;
              }
      }

      $connect1 = Connectdb::Databaseall();
      $baseAc1 = $connect1['fsctaccount'];
      $baseHr1 = $connect1['hr_base'];

      $sql1 = "UPDATE $baseAc1.po_head
               SET $baseAc1.po_head.status_head = '3'
               WHERE $baseAc1.po_head.id IN($commaSeparated)";
      $sql_finish1 = DB::select($sql1);

      SWAL::message('สำเร็จ', 'บันทึกการแจ้งการจ่ายเงิน!', 'success', ['timer' => 6000]);

      return redirect()->route('payser');
    }else {
      SWAL::message('บันทึกล้มเหลว', 'session หมดอายุให้กลับไป Log In !', 'warning', ['timer' => 6000]);
      return redirect()->route('fsctonline.com/fscthr/auth/default/index');
    }

  }

    public function update(Request $request)
    {
      $get_id = $request->get('get_id');

      $payser = Infrom_po_mainhead::find($get_id);
      $payser->branch_id = $request->get('code_branch');
      $payser->type_pay = $request->get('type_pay');
      $payser->datebillreceipt = $request->get('date_picker_withpaybills');
      $payser->bill_no = $request->get('bill_no_withpaybills');
      $payser->update();

        SWAL::message('สำเร็จ', 'แก้ไขเรียบร้อย!', 'success', ['timer' => 6000]);
        return redirect()->route('payser');
    }

      /**
       * Remove the specified resource from storage.
       *
       * @param  \App\Inform_po_head  $cash
       * @return \Illuminate\Http\Response
       */


    public function deleteUpdate($id)
    {
        $infrom_po_mainhead = Infrom_po_mainhead::find($id);
        // $idhead = $infrom_po_mainhead->id;

        if ($infrom_po_mainhead != null)
        {
            $infrom_po_mainhead->status = '99';
            $infrom_po_mainhead->update();

            return redirect()->route('payser');
        }
    }
}
