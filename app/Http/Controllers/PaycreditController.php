<?php

namespace App\Http\Controllers;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use DB;
use App\Api\Connectdb;
use App\Api\Datetime;
use App\Http\Requests\Inform_po_paycreditRequest;
use App\Http\Requests\Infrom_po_mainheadRequest;
use App\Inform_po_paycredit;
use App\Infrom_po_mainhead;
use App\Branch;
use App\Bank;
use App\Po;
use App\Debt;
use App\Po_head;
use App\Type_pay;
use Illuminate\Support\Facades\Input;
use Softon\SweetAlert\Facades\SWAL;
use PDF;

class PaycreditController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    function index(){
    	$branchs = new Branch;
    	$branchs->setConnection('hr_base');
		  $branchs = Branch::get();

      $type_pays = new Type_pay;
      $type_pays->setConnection('mysql2');
      $type_pays = Type_pay::where('status','=',1)
                      ->get();

      $inform_po_paycredits = new Inform_po_paycredit;
      $inform_po_paycredits->setConnection('mysql2');
      $inform_po_paycredits = Inform_po_paycredit::where('status','=',1)
                      ->get();

      $infrom_po_mainheads = new Infrom_po_mainhead;
      $infrom_po_mainheads->setConnection('mysql2');
      $infrom_po_mainheads = Infrom_po_mainhead::where('type','=',1)
                      ->where('status','=',1)
                      ->get();
      // $inform_po_paycredits = new Debt;
      // $inform_po_paycredits->setConnection('mysql2');
      // $inform_po_paycredits = Debt::where('status','=',1)
      //                 ->get();
      // $connect1 = Connectdb::Databaseall();
      // $baseAc1 = $connect1['fsctaccount'];
      // $baseHr1 = $connect1['hr_base'];
      // $sql1 = "SELECT $baseAc1.inform_po_paycredit.*
      //                                 ,po_head.po_number
      //                                 ,po_head.branch_id
      //                                 ,po_head.id
      //                                 ,in_debt.branch_id
      //                                 ,in_debt.id_po
      //
      //                 FROM $baseAc1.inform_po_paycredit
      //
      //                 INNER JOIN $baseAc1.po_head
      //                 ON $baseAc1.inform_po_paycredit.id = $baseAc1.po_head.id
      //
      //                 INNER JOIN $baseHr1.branch
      //                 ON $baseAc1.inform_po_paycredit.branch_id = $baseHr1.branch.code_branch
      //
      //                 INNER JOIN $baseAc1.in_debt
      //                 ON $baseAc1.inform_po_paycredit.in_debt_id = $baseAc1.in_debt.id
      //
      //                 WHERE inform_po_paycredit.branch_id = in_debt.branch_id AND in_debt.id_po = po_head.id
      //                 ";
      //                 // exit;
      //   $getdatas = DB::select($sql1);
        // return $datas;
      // $connect = Connectdb::Databaseall();
      // $baseAc = $connect['fsctaccount'];
      // $baseHr = $connect['hr_base'];
      // $sql = "SELECT $baseAc.inform_po_paycredit.*
      //                                 ,type_pay.id
      //                                 ,type_pay.name_pay
      //                                 ,branch.code_branch
      //                                 ,branch.name_branch
      //
      //                 FROM $baseAc.inform_po_paycredit
      //
      //                 INNER JOIN $baseAc.type_pay
      //                 ON $baseAc.inform_po_paycredit.type_pay = $baseAc.type_pay.id
      //
      //                 INNER JOIN $baseHr.branch
      //                 ON $baseAc.inform_po_paycredit.branch_id = $baseHr.branch.code_branch
      //
      //                 WHERE $baseAc.inform_po_paycredit.status = 1";
      //
      //   $inform_po_paycredits = DB::select($sql);
     return view('paycredit.paycredit',['branchs'=>$branchs,
                                    'type_pays'=>$type_pays,
                                    'inform_po_paycredits'=>$inform_po_paycredits,
                                    'infrom_po_mainheads'=>$infrom_po_mainheads]);
    }

    public function pdf($id)
      {
  		$report_paycredits = DB::connection('mysql2')
  			->table('inform_po')
        ->join('po_head', 'inform_po.id_po', '=', 'po_head.id')
  			->join('po_detail', 'inform_po.id_po', '=', 'po_detail.po_headid')
        ->join('in_debt', 'inform_po.payser_number', '=', 'in_debt.number_debt')
        ->join('supplier', 'in_debt.supplier_id', '=', 'supplier.id')
        ->join('type_pay', 'inform_po.type_pay', '=', 'type_pay.id')
        ->where('po_detail.statususe','=',1)
        ->where('inform_po.id',$id)
        ->get();

  			// dd($report_debts);
          $pdf = PDF::loadView('paycredit.paycreditpdf', ['report_paycredits' => $report_paycredits]);
          return @$pdf->stream();
      }


    public function getpoindebt($getpo)
    {
      $connect = Connectdb::Databaseall();
      $baseAc = $connect['fsctaccount'];
      $baseHr = $connect['hr_base'];

      $sql = "SELECT $baseAc.in_debt.*
                                      ,po_head.po_number
                                      ,po_head.branch_id
                                      ,branch.code_branch
                                      ,branch.name_branch

                      FROM $baseAc.in_debt

                      INNER JOIN $baseAc.po_head
                      ON $baseAc.in_debt.id_po = $baseAc.po_head.id

                      INNER JOIN $baseHr.branch
                      ON $baseAc.in_debt.branch_id = $baseHr.branch.code_branch

                      WHERE in_debt.branch_id = ($getpo) AND in_debt.status_tranfer = 1 AND in_debt.status_pay = 0 ";
      // exit;
      $datas = DB::select($sql);
      return $datas;
    }

    // function getbankdetailz($getidbank)
    // {
    //   $connect = Connectdb::Databaseall();
    //   $baseAc = $connect['fsctaccount'];
    //   $sql = "SELECT $baseAc.bank_detail.*  FROM $baseAc.bank_detail
    //           WHERE bank_detail.status_use !=  99 ";
    //
    //   $datas = DB::select($sql);
    //   return $datas;
    // }

    function getbankfromaccounttype($getbank)
    {
      $connect1 = Connectdb::Databaseall();
      $baseAc1 = $connect1['fsctaccount'];
      $baseHr1 = $connect1['hr_base'];

      $sql1 = "SELECT * FROM $baseAc1.accounttype WHERE $baseAc1.accounttype.accounttypefull LIKE '%เงินฝากออมทรัพย์%'";

      $get_bank = DB::select($sql1);
      return $get_bank;
    }

    function postcalculatevatdebt(Request $request)
    {
         $id = $request->post('data');
         $arrIn = implode(",",$id);
         // echo $arrIn;
         // $po = Po::find($id);
         // $po = new Debt;
         // $po->setConnection('mysql2');
         // $po = Debt::whereIn('id',$id)->sum('vat_price');
         //   //
         //   // ->get();
         //   // exit;
       	 // return $po;
         // print_r($id);
         // echo "<pre>";
         // exit;
         $connect1 = Connectdb::Databaseall();
         $baseAc1 = $connect1['fsctaccount'];

           $sql1 = "SELECT SUM(vat_price)
                         FROM $baseAc1.in_debt
                         WHERE $baseAc1.in_debt.id IN ($arrIn)";

           $getdatas = DB::select($sql1);
         return $getdatas;
    }

    function postcalculatepo2(Request $request)
    {
         $id = $request->post('data');
         // $arrIn = implode(",",$id);
         // $po = Po::find($id);
         $po = new Po;
         $po->setConnection('mysql2');
         $po = Po::whereIn('id',$id)->sum('totolsumall');
           //
           // ->get();
       	 return $po;
    }

    function postinfofromindebt(Request $request)
    {

        $id = $request->post('data');
        $arrIn = implode(",",$id);

        $connect1 = Connectdb::Databaseall();
        $baseAc1 = $connect1['fsctaccount'];

           $sql1 = "SELECT $baseAc1.in_debt.*
                                    ,po_head.whd

                        FROM $baseAc1.in_debt

                        INNER JOIN $baseAc1.po_head
                        ON $baseAc1.in_debt.id_po = $baseAc1.po_head.id

                        WHERE $baseAc1.in_debt.id_po IN ($arrIn)";

          $getdatas = DB::select($sql1);
        return $getdatas;
    }

    public function getpodetailbydebt1(Request $request)
    {
      $id = $request->post('data');

      // $arrIn = implode(",",$id);

      $connect = Connectdb::Databaseall();
      $baseAc = $connect['fsctaccount'];
      $sql1 = "SELECT $baseAc.in_debt.*
                                  ,po_head.whd
               FROM $baseAc.in_debt

               INNER JOIN $baseAc.po_head
               ON $baseAc.in_debt.id_po = $baseAc.po_head.id

               WHERE in_debt.id IN ($id)";

      $in_debt = DB::select($sql1);

      return $in_debt;
    }

  function getwht($getwithhold){
        $whts = new Withhold;
        $whts->setConnection('mysql2');
        $whts = Withhold::where('id',$getwithhold)
                      ->where('status','=',1)
                      ->get();
       // $po = Po::find($id);
        return view('precredit.precredit',['whts'=>$whts]);
  }


  public function getdatadebtedit($getidedit)
  {
    $connect1 = Connectdb::Databaseall();
    $baseAc1 = $connect1['fsctaccount'];
    $baseHr1 = $connect1['hr_base'];

    $sql1 = "SELECT $baseAc1.inform_po.*
                                    ,po_head.po_number
                                    ,po_head.branch_id
                                    ,po_head.id
                                    ,in_debt.branch_id
                                    ,in_debt.number_debt
                                    ,type_pay.id
                                    ,type_pay.name_pay
                                    ,branch.code_branch
                                    ,branch.name_branch

                    FROM $baseAc1.inform_po

                    INNER JOIN $baseAc1.po_head
                    ON $baseAc1.inform_po.id_po = $baseAc1.po_head.id

                    INNER JOIN $baseHr1.branch
                    ON $baseAc1.inform_po.branch_id = $baseHr1.branch.code_branch

                    INNER JOIN $baseAc1.in_debt
                    ON $baseAc1.inform_po.payser_number = $baseAc1.in_debt.number_debt

                    INNER JOIN $baseAc1.type_pay
                    ON $baseAc1.inform_po.type_pay = $baseAc1.type_pay.id

                    WHERE $baseAc1.inform_po.id = $getidedit";

      $getdatas = DB::select($sql1);
      return $getdatas;
  }


  public function getbankdetailpaycredit($getpos)
  {
    $connect1 = Connectdb::Databaseall();
    $baseAc1 = $connect1['fsctaccount'];

    $sql1 = "SELECT $baseAc1.inform_po.*
                                    ,bank_detail.id
                                    ,bank_detail.account_name
                                    ,bank_detail.account_no

                    FROM $baseAc1.inform_po

                    INNER JOIN $baseAc1.bank_detail
                    ON $baseAc1.inform_po.id_bankdetail = $baseAc1.bank_detail.id

                    WHERE $baseAc1.inform_po.id = '$getpos'";

      $getdatas = DB::select($sql1);
      return $getdatas;
  }


  public function getinfofromidpo(Request $request)
  {
    $id = $request->post('data');

    $connect1 = Connectdb::Databaseall();
    $baseAc1 = $connect1['fsctaccount'];

       $sql1 = "SELECT $baseAc1.po_head.*
                                 ,inform_po.id_po
                                 ,inform_po.vat_price
                                 ,inform_po.payser_number
                                 ,po_detail.list
                                 ,po_detail.price

                    FROM $baseAc1.po_head

                    INNER JOIN $baseAc1.inform_po
                    ON $baseAc1.po_head.id = $baseAc1.inform_po.id_po

                    INNER JOIN $baseAc1.po_detail
                    ON $baseAc1.po_head.id = $baseAc1.po_detail.po_headid

                    WHERE $baseAc1.po_head.id IN ($id) AND $baseAc1.po_detail.statususe = 1";

      $getdatas = DB::select($sql1);

    return $getdatas;
  }

  public function printdetail(Request $request)
  {
    $id = $request->post('data');

    $connect1 = Connectdb::Databaseall();
    $baseAc1 = $connect1['fsctaccount'];

       $sql1 = "SELECT $baseAc1.inform_po.*

                    FROM $baseAc1.inform_po
                    WHERE $baseAc1.inform_po.id IN ($id)";

      $getdatas = DB::select($sql1);

    return $getdatas;
  }


  public function getindebtpo(Request $request)
  {
    $id = $request->post('data');
    // $arrIn = implode(",",$id);

    $connect1 = Connectdb::Databaseall();
    $baseAc1 = $connect1['fsctaccount'];

       $sql1 = "SELECT $baseAc1.in_debt.*
                                 ,po_head.po_number
                                 ,po_head.totolsumall
                                 ,po_detail.po_headid
                                 ,po_detail.list
                                 ,po_detail.total
                                 ,po_detail.price

                    FROM $baseAc1.in_debt

                    INNER JOIN $baseAc1.po_head
                    ON $baseAc1.in_debt.id_po = $baseAc1.po_head.id

                    INNER JOIN $baseAc1.po_detail
                    ON $baseAc1.in_debt.id_po = $baseAc1.po_detail.po_headid

                    WHERE $baseAc1.in_debt.id IN ($id) AND in_debt.statususe = 1 AND po_detail.statususe = 1";

      $getdatas = DB::select($sql1);

    return $getdatas;
  }


  public function store(Inform_po_paycreditRequest $request)
  {
        $payser = new Infrom_po_mainhead;
        $payser->setConnection('mysql2');
        $payser->payser_number = $request->get('ap_no');
        $payser->id_po = $request->get('po_id');
        $payser->type = "1";
        $payser->bill_no = $request->get('bill_no_withpaybill');
        $payser->branch_id = $request->get('branch');
        $payser->wht = $request->get('wht_name');
        // $payser->discount = $request->get('discount');
        $payser->wht_percent = $request->get('wht');
        $payser->vat_percent = $request->get('vat');

        $payser->vat_price = $request->get('vat_price');
        $payser->type_pay = $request->get('type_po');
        $payser->payout = $request->get('aftermoney1');
        $payser->datebillreceipt = $request->get('date_picker_withpaybill');

        $payser->type_newtable = "1";

        if ($request->get('company_pay')) {
          $payser->company_pay_wht = $request->get('company_pay');
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
      $payser->inform_po_picture = $public_path . $image_name;
    }

    $id_po_indebt =  $request->get('id_in_debt');
    $update_status_pay = Debt::find($id_po_indebt);
    $update_status_pay->status_pay = "1";
    $update_status_pay->update();
    // dd($payser);
    $payser->save();

    SWAL::message('สำเร็จ', 'บันทึกการแจ้งการจ่ายเงิน!', 'success', ['timer' => 6000]);
    return redirect()->route('paycredit');
  }

  public function delete($id)
  {
      $inform_po_paycredit = Infrom_po_mainhead::find($id);
      if ($inform_po_paycredit != null) {

          $inform_po_paycredit->status = '99';
          $inform_po_paycredit->update();
          return redirect()->route('paycredit');
      }
  }


  public function update(Request $request)
  {
    $get_id = $request->get('get_id');

    $paycredit = Infrom_po_mainhead::find($get_id);
    $paycredit->branch_id = $request->get('code_branch');
    $paycredit->type_pay = $request->get('type_pay');
    $paycredit->datebillreceipt = $request->get('date_picker_withpaybills');
    $paycredit->bill_no = $request->get('bill_no_withpaybills');
    $paycredit->update();
    //
    // $paycredit->datebill = $request->get('no_asset');
    // $paycredit->accounttypeno = $request->get('no_asset');
    // $paycredit->debit = $request->get('no_asset');
    // $paycredit->credit = $request->credits;
    // $paycredit->list = $request->memos;
    // $paycredit->name_supplier = $request->names;

    $paycredit->save();
    SWAL::message('สำเร็จ', 'แก้ไขเรียบร้อย!', 'success', ['timer' => 6000]);
    return redirect()->route('paycredit');
  }

   public function printpaycredit(Request $request,$id)
   {
       // echo "<pre>";
       // echo $request;
       // echo $id;
       $Inform_po_paycredit = Inform_po_paycredit::find($id)
                              ->get();

       return $Inform_po_paycredit;
   }


   public function getdataprint($getprint)
   {
     $connect1 = Connectdb::Databaseall();
     $baseAc1 = $connect1['fsctaccount'];
     $baseHr1 = $connect1['hr_base'];

     $sql1 = "SELECT $baseAc1.inform_po_paycredit.*
                                     ,po_head.po_number
                                     ,po_head.branch_id
                                     ,po_head.id
                                     ,in_debt.branch_id
                                     ,in_debt.id_po
                                     ,type_pay.id
                                     ,type_pay.name_pay
                                     ,branch.code_branch
                                     ,branch.name_branch

                     FROM $baseAc1.inform_po_paycredit

                     INNER JOIN $baseAc1.po_head
                     ON $baseAc1.inform_po_paycredit.id = $baseAc1.po_head.id

                     INNER JOIN $baseHr1.branch
                     ON $baseAc1.inform_po_paycredit.branch_id = $baseHr1.branch.code_branch

                     INNER JOIN $baseAc1.in_debt
                     ON $baseAc1.inform_po_paycredit.in_debt_id = $baseAc1.in_debt.id

                     INNER JOIN $baseAc1.type_pay
                     ON $baseAc1.inform_po_paycredit.type_pay = $baseAc1.type_pay.id

                     WHERE $baseAc1.inform_po_paycredit.id = '$getprint'";

       $getdatas = DB::select($sql1);
       return $getdatas;
   }

}
