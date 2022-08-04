<?php

namespace App\Http\Controllers;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use App\Http\Requests\Asset_listRequest;
use DB;
use App\Asset_list;
use App\Branch;
use App\Group_Property;
use App\Accounttype;
use App\Api\Connectdb;
use Illuminate\Support\Facades\Input;
use Softon\SweetAlert\Facades\SWAL;
use App\Api\Datetime;
use Session;

class SettingassettoolController extends Controller
{


    public function settingtool(){

      return view('setting.settingtool');
    }

    public function settingpotool(){

      return view('setting.settingpotool');
    }

    public function serchsettingpotool(){

      $data= Input::all();
      $connect1 = Connectdb::Databaseall();
      $baseAc1 = $connect1['fsctaccount'];
      $baseMan = $connect1['fsctmain'];

      $idserch = $data['id'];
      $sql1 = "SELECT $baseAc1.po_head.*,
                      $baseAc1.po_detail.*,
                      $baseAc1.supplier.pre,
                      $baseAc1.supplier.name_supplier,
                      $baseAc1.supplier.phone,
                      $baseAc1.supplier.mobile,
                      $baseAc1.accounttype.accounttypeno
              FROM $baseAc1.po_head
              INNER JOIN $baseAc1.po_detail
              ON $baseAc1.po_head.id = $baseAc1.po_detail.po_headid
              INNER JOIN $baseAc1.supplier
              ON $baseAc1.supplier.id = $baseAc1.po_head.supplier_id
              INNER JOIN $baseAc1.good
              ON $baseAc1.good.id = $baseAc1.po_detail.materialid
              INNER JOIN $baseAc1.accounttype
              ON $baseAc1.accounttype.id = $baseAc1.good.accounttype
              WHERE $baseAc1.po_head.status_head != '99'
              AND $baseAc1.po_head.po_number = '$idserch'";
        $getdatas = DB::select($sql1);
        return $getdatas;


    }

    public function savesettingpotool(){
        $data = Input::all();
        $connect1 = Connectdb::Databaseall();
        $pohead = $data['search'];
        $lotnumber = $data['lotnumber'];
        $baseAc1 = $connect1['fsctaccount'];
        $baseMan = $connect1['fsctmain'];

        $sql1 = "SELECT $baseAc1.po_to_asset.*
                FROM $baseAc1.po_to_asset
                WHERE $baseAc1.po_to_asset.status != '99'
                AND $baseAc1.po_to_asset.po_number = '$pohead'";
          $getdatas = DB::select($sql1);
        if(!empty($getdatas)){
              //echo "dont save";
        SWAL::message('ผิดพลาด', 'รายการซ้ำ!', 'danger', ['timer' => 6000]);
        return redirect()->back();

        }else{
              // echo "  save";
              $arrInert = [ 'id'=>'',
                      'po_number'=>$pohead,
                      'lotnumber'=>$lotnumber,
                      'status'=>'0'];

              DB::table($connect1['fsctaccount'].'.po_to_asset')->insert($arrInert);
          SWAL::message('สำเร็จ', 'บันทึกรายการ', 'success', ['timer' => 6000]);
          return redirect()->back();

        }
    }

    function approvedpotoolassetstatus(){
        $data = Input::all();
        $connect1 = Connectdb::Databaseall();
        $baseAc1 = $connect1['fsctaccount'];
        // print_r($data);
        $id = $data['id'];
        $sqlUpdate = ' UPDATE '.$baseAc1.'.po_to_asset
                  SET status = "1"
                  WHERE '.$baseAc1.'.po_to_asset.id = "'.$id.'" ';
        $lgUpdateResulte = DB::connection('mysql')->select($sqlUpdate);
        $datenow = date('Y-m-d H:m:s');
        /// insert general5

        $sql1 = "SELECT $baseAc1.po_to_asset.*,
                        $baseAc1.po_head.branch_id,
                        $baseAc1.po_head.totolsumall as total,
                        $baseAc1.po_detail.*
                FROM $baseAc1.po_to_asset
                INNER JOIN $baseAc1.po_head
                ON $baseAc1.po_head.po_number = $baseAc1.po_to_asset.po_number
                INNER JOIN $baseAc1.po_detail
                ON $baseAc1.po_head.id = $baseAc1.po_detail.po_headid
                WHERE $baseAc1.po_to_asset.status != '99'
                AND $baseAc1.po_to_asset.id = '$id'";

        $getdatas = DB::select($sql1);

        $arrInert = [ 'id'=>'',
                      'type_module'=>'5',
                      'number_bill_journal'=>'POTOOL'.$getdatas[0]->po_number,
                      'code_branch'=>$getdatas[0]->branch_id,
                      'datebill'=>date('Y-m-d'),
                      'balance_forward_status'=>0,
                      'accept'=>1,
                      'status'=>1,
                      'totalsum'=>$getdatas[0]->total
                     ];

        $lastid = DB::table($connect1['fsctaccount'].'.journal_5')->insertGetId($arrInert);

        //print_r($getdatas);
      $totalnovat = 0;
        foreach ($getdatas as $key => $value) {
           $totalnovat = $totalnovat + $value->total;
        }

        //// 512100  ซื้อสินค้า 159
        $accbuy = '159';
        $arrInert = [ 'id'=>'',
                      'id_journalgeneral_head'=>$lastid,
                      'accounttype'=>$accbuy,
                      'list'=>'ซื้อวัตถุดิบผลิต',
                      'name_suplier'=>'',
                      'status'=>1,
                      'debit'=>$totalnovat,
                      'credit'=>0];
        DB::table($connect1['fsctaccount'].'.journalgeneral_detail')->insert($arrInert);

        // insert lg
        $arrInert = [ 'id'=>'',
                'dr'=>$totalnovat,
                'cr'=>0.00,
                'acc_code'=>'512100',
                'branch'=>$getdatas[0]->branch_id,
                'status'=> 1,
                'number_bill'=>'POTOOL'.$getdatas[0]->po_number,
                'customer_vendor'=>'',
                'timestamp'=>$datenow,
                //'code_emp'=>$emp_outs,
                'subtotal'=> 0,
                'discount'=> 0,
                'vat'=> 0,
                'vatmoney'=> 0,
                // 'wht'=> $withholds,
                'whtmoney'=> 0,
                'grandtotal'=> $totalnovat,
                'type_journal' => 5,
                'id_type_ref_journal'=>$lastid,
                'timereal'=>$datenow,
                'list'=> 'ซื้อวัตถุดิบผลิต ของ '.'POTOOL'.$getdatas[0]->po_number];

        DB::table($connect1['fsctaccount'].'.ledger')->insert($arrInert);


        //// 119503  ภาษีซื้อรอใบกำกับ 113
        $accvatwait = '113';
        $vattotalvat = $totalnovat*0.07;
        $arrInert = [ 'id'=>'',
                      'id_journalgeneral_head'=>$lastid,
                      'accounttype'=>$accvatwait,
                      'list'=>'ภาษีซื้อรอใบกำกับ',
                      'name_suplier'=>'',
                      'status'=>1,
                      'debit'=>$vattotalvat,
                      'credit'=>0];
        DB::table($connect1['fsctaccount'].'.journalgeneral_detail')->insert($arrInert);
        // insert lg
        $arrInert = [ 'id'=>'',
                'dr'=>$vattotalvat,
                'cr'=>0.00,
                'acc_code'=>'119503',
                'branch'=>$getdatas[0]->branch_id,
                'status'=> 1,
                'number_bill'=>'POTOOL'.$getdatas[0]->po_number,
                'customer_vendor'=>'',
                'timestamp'=>$datenow,
                //'code_emp'=>$emp_outs,
                'subtotal'=> 0,
                'discount'=> 0,
                'vat'=> 0,
                'vatmoney'=> 0,
                // 'wht'=> $withholds,
                'whtmoney'=> 0,
                'grandtotal'=> $totalnovat,
                'type_journal' => 5,
                'id_type_ref_journal'=>$lastid,
                'timereal'=>$datenow,
                'list'=> 'ภาษีซื้อรอใบกำกับ ของ '.'POTOOL'.$getdatas[0]->po_number];
        DB::table($connect1['fsctaccount'].'.ledger')->insert($arrInert);


        //// 212100  เจ้าหนี้การค้า 130
        $acccreditor = '130';
        $lasttotal = $totalnovat*1.07;
        $arrInert = [ 'id'=>'',
                      'id_journalgeneral_head'=>$lastid,
                      'accounttype'=>$acccreditor,
                      'list'=>'ภาษีซื้อรอใบกำกับ',
                      'name_suplier'=>'',
                      'status'=>1,
                      'debit'=>0,
                      'credit'=>$lasttotal];
          DB::table($connect1['fsctaccount'].'.journalgeneral_detail')->insert($arrInert);

          $arrInert = [ 'id'=>'',
                  'dr'=>0.00,
                  'cr'=>$lasttotal,
                  'acc_code'=>'212100',
                  'branch'=>$getdatas[0]->branch_id,
                  'status'=> 1,
                  'number_bill'=>'POTOOL'.$getdatas[0]->po_number,
                  'customer_vendor'=>'',
                  'timestamp'=>$datenow,
                  //'code_emp'=>$emp_outs,
                  'subtotal'=> 0,
                  'discount'=> 0,
                  'vat'=> 0,
                  'vatmoney'=> 0,
                  // 'wht'=> $withholds,
                  'whtmoney'=> 0,
                  'grandtotal'=> $totalnovat,
                  'type_journal' => 5,
                  'id_type_ref_journal'=>$lastid,
                  'timereal'=>$datenow,
                  'list'=> 'เจ้าหนี้การค้า ของ '.'POTOOL'.$getdatas[0]->po_number];
          DB::table($connect1['fsctaccount'].'.ledger')->insert($arrInert);



        SWAL::message('สำเร็จ', 'บันทึกรายการ', 'success', ['timer' => 6000]);
        return 1;

    }


    public function settingdmtool(){
          return view('setting.settingdmtool');
    }

    public function getdatedmtool(){
            $data = Input::all();
            $connect1 = Connectdb::Databaseall();
            $baseAc1 = $connect1['fsctaccount'];
            // print_r($data);
            $id = $data['id'];
            $sql1 = "SELECT $baseAc1.po_to_asset.*,
                            $baseAc1.po_head.branch_id,
                            $baseAc1.po_head.totolsumall as total,
                            $baseAc1.po_detail.*,
                            $baseAc1.po_detail.materialid
                    FROM $baseAc1.po_to_asset
                    INNER JOIN $baseAc1.po_head
                    ON $baseAc1.po_head.po_number = $baseAc1.po_to_asset.po_number
                    INNER JOIN $baseAc1.po_detail
                    ON $baseAc1.po_head.id = $baseAc1.po_detail.po_headid
                    WHERE $baseAc1.po_to_asset.status != '99'
                    AND $baseAc1.po_to_asset.id = '$id'";
          $getdatas = DB::select($sql1);

          return $getdatas;

    }

    public function savesettingdmtool(){
        $data = Input::all();
        $connect1 = Connectdb::Databaseall();
        $baseAc1 = $connect1['fsctaccount'];
        $id = $data['id_poasset'];
        $emp_code = Session::get('emp_code');
        $sql1 = "SELECT $baseAc1.po_to_asset.*,
                        $baseAc1.po_head.branch_id,
                        $baseAc1.po_head.totolsumall as total,
                        $baseAc1.po_detail.*
                FROM $baseAc1.po_to_asset
                INNER JOIN $baseAc1.po_head
                ON $baseAc1.po_head.po_number = $baseAc1.po_to_asset.po_number
                INNER JOIN $baseAc1.po_detail
                ON $baseAc1.po_head.id = $baseAc1.po_detail.po_headid
                WHERE $baseAc1.po_to_asset.status != '99'
                AND $baseAc1.po_to_asset.id = '$id'";
      $getdatas = DB::select($sql1);

      $arrInert = [ 'id'=>'',
                    'number_bill'=>'BOL'.$getdatas[0]->po_number,
                    'emp_code'=>$emp_code,
                    'status'=>'2',
                    'lot'=>$getdatas[0]->lotnumber,
                    'po_to_asset_id'=>$id];

      $lastid = DB::table($connect1['fsctaccount'].'.bill_of_lading_head')->insertGetId($arrInert);


      foreach ($data['materialid'] as $key => $value) {
        $ckstatushead = $data['income'][$key]-$data['payout'][$key];
          if($ckstatushead>0){
            $sqlUpdate = ' UPDATE '.$baseAc1.'.bill_of_lading_head
                      SET status = "3"
                      WHERE '.$baseAc1.'.bill_of_lading_head.id = "'.$lastid.'" ';
            $lgUpdateResulte = DB::connection('mysql')->select($sqlUpdate);
          }
            $arrInert = [ 'id'=>'',
                          'materialid'=>$value,
                          'bill_of_lading_head'=>$lastid,
                          'income'=>$data['income'][$key],
                          'payout'=>$data['payout'][$key]
                        ];
          DB::table($connect1['fsctaccount'].'.bill_of_lading_detail')->insert($arrInert);
      }

      SWAL::message('สำเร็จ', 'บันทึกรายการ', 'success', ['timer' => 6000]);
      return redirect()->back();

    }

    public function approveddmtoolassetstatus(){
          $data = Input::all();

          $id = $data['id'];
          $connect1 = Connectdb::Databaseall();
          $baseAc1 = $connect1['fsctaccount'];

          $sqlUpdate = ' UPDATE '.$baseAc1.'.bill_of_lading_head
                    SET status = "1"
                    WHERE '.$baseAc1.'.bill_of_lading_head.id = "'.$id.'" ';
          $lgUpdateResulte = DB::connection('mysql')->select($sqlUpdate);


          $sql2 = "SELECT $baseAc1.bill_of_lading_head.*,
                          $baseAc1.bill_of_lading_detail.*,
                          $baseAc1.po_to_asset.po_number,
                          $baseAc1.po_head.id as idpo
                  FROM $baseAc1.bill_of_lading_head
                  INNER JOIN $baseAc1.bill_of_lading_detail
                  ON $baseAc1.bill_of_lading_head.id = $baseAc1.bill_of_lading_detail.bill_of_lading_head
                  INNER JOIN $baseAc1.po_to_asset
                  ON $baseAc1.po_to_asset.id = $baseAc1.bill_of_lading_head.po_to_asset_id
                  INNER JOIN $baseAc1.po_head
                  ON $baseAc1.po_head.po_number = $baseAc1.po_to_asset.po_number
                  WHERE $baseAc1.bill_of_lading_head.status != '99'
                  AND $baseAc1.bill_of_lading_head.id = '$id'";
          $datamain = DB::connection('mysql')->select($sql2);

          // print_r($datamain);
          // exit;
          $idpo = $datamain[0]->idpo;
          $sql1 = "SELECT $baseAc1.po_to_asset.*,
                          $baseAc1.po_head.branch_id,
                          $baseAc1.po_head.totolsumall as total,
                          $baseAc1.po_detail.*
                  FROM $baseAc1.po_to_asset
                  INNER JOIN $baseAc1.po_head
                  ON $baseAc1.po_head.po_number = $baseAc1.po_to_asset.po_number
                  INNER JOIN $baseAc1.po_detail
                  ON $baseAc1.po_head.id = $baseAc1.po_detail.po_headid
                  WHERE $baseAc1.po_to_asset.status != '99'
                  AND $baseAc1.po_head.id = '$idpo'";
          $getdatas = DB::select($sql1);

            //print_r($getdatas);
          $totalcr = 0;
          foreach ($getdatas as $key => $value) {
                $totalcr = $totalcr + $value->price * $value->amount ;//   ราคา
          }
            ///////////////////    บันทึก GL
          $arrInert = [ 'id'=>'',
                        'type_module'=>'5',
                        'number_bill_journal'=>$datamain[0]->number_bill,
                        'code_branch'=>$getdatas[0]->branch_id,
                        'datebill'=>date('Y-m-d'),
                        'balance_forward_status'=>0,
                        'accept'=>1,
                        'status'=>1,
                        'totalsum'=>$totalcr];

          $lastid = DB::table($connect1['fsctaccount'].'.journal_5')->insertGetId($arrInert);
              // cr บันทึกบัญชี  ซื้อสินค้า 159  512100//


          $accbuy = '159';
          $arrInert = [ 'id'=>'',
                        'id_journalgeneral_head'=>$lastid,
                        'accounttype'=>$accbuy,
                        'list'=>'ซื้อวัตถุดิบผลิต',
                        'name_suplier'=>'',
                        'status'=>1,
                        'debit'=>0,
                        'credit'=>$totalcr];
          DB::table($connect1['fsctaccount'].'.journalgeneral_detail')->insert($arrInert);


          $arrInert = [ 'id'=>'',
                  'dr'=>0.00,
                  'cr'=>$totalcr,
                  'acc_code'=>'512100',
                  'branch'=>$getdatas[0]->branch_id,
                  'status'=> 1,
                  'number_bill'=>$datamain[0]->number_bill,
                  'customer_vendor'=>'',
                  'timestamp'=>date('Y-m-d'),
                  //'code_emp'=>$emp_outs,
                  'subtotal'=> 0,
                  'discount'=> 0,
                  'vat'=> 0,
                  'vatmoney'=> 0,
                  // 'wht'=> $withholds,
                  'whtmoney'=> 0,
                  'grandtotal'=> $totalcr,
                  'type_journal' => 5,
                  'id_type_ref_journal'=>$lastid,
                  'timereal'=>date('Y-m-d'),
                  'list'=> 'ซื้อวัตถุดิบผลิต ใบเบิกของเลขที่'.$datamain[0]->number_bill];
          DB::table($connect1['fsctaccount'].'.ledger')->insert($arrInert);



          // dr บันทึกบัญชี  งานระหว่างทำ-นั่งร้าน 266  115301//
        $totaldr = 0;;

          foreach ($getdatas as $key => $value) {
              foreach ($datamain as $k => $v) {
                  if($v->materialid==$value->materialid){
                      $totaldr = $totaldr + $value->price * $v->payout ;//   ราคา
                  }
              }

          }




          $accmake = '266';
          $arrInert = [ 'id'=>'',
                        'id_journalgeneral_head'=>$lastid,
                        'accounttype'=>$accmake,
                        'list'=>'งานระหว่างทำ-นั่งร้าน',
                        'name_suplier'=>'',
                        'status'=>1,
                        'debit'=>$totaldr,
                        'credit'=>0];
          DB::table($connect1['fsctaccount'].'.journalgeneral_detail')->insert($arrInert);

          $arrInert = [ 'id'=>'',
                  'dr'=>$totaldr,
                  'cr'=>0.00,
                  'acc_code'=>'115301',
                  'branch'=>$getdatas[0]->branch_id,
                  'status'=> 1,
                  'number_bill'=>$datamain[0]->number_bill,
                  'customer_vendor'=>'',
                  'timestamp'=>date('Y-m-d'),
                  //'code_emp'=>$emp_outs,
                  'subtotal'=> 0,
                  'discount'=> 0,
                  'vat'=> 0,
                  'vatmoney'=> 0,
                  // 'wht'=> $withholds,
                  'whtmoney'=> 0,
                  'grandtotal'=> $totalcr,
                  'type_journal' => 5,
                  'id_type_ref_journal'=>$lastid,
                  'timereal'=>date('Y-m-d'),
                  'list'=> 'งานระหว่างทำ-นั่งร้าน ใบเบิกของเลขที่'.$datamain[0]->number_bill];
          DB::table($connect1['fsctaccount'].'.ledger')->insert($arrInert);


          SWAL::message('สำเร็จ', 'บันทึกรายการ', 'success', ['timer' => 6000]);
          return 1;

    }

    public function settingsalaryemptool(){
        return view('setting.settingsalaryemptool');
    }

    public function getempwageselectmonthproduct(){
            $data = Input::all();
            $connect1 = Connectdb::Databaseall();
            //print_r($data);
            $remonth = explode("-",$data['monthselect']);

            $newsetmonth = $remonth[1].'-'.$remonth[0];
            $baseHr = $connect1['hr_base'];
            $sql = "SELECT $baseHr.WAGE_HISTORY.*,
                            $baseHr.emp_data.code_emp_old,
                            $baseHr.emp_data.prefixth,
                            $baseHr.emp_data.nameth,
                            $baseHr.emp_data.surnameth
                    FROM $baseHr.WAGE_HISTORY
                    INNER JOIN $baseHr.emp_data
                    ON $baseHr.emp_data.idcard_no = $baseHr.WAGE_HISTORY.WAGE_EMP_ID
                    WHERE $baseHr.WAGE_HISTORY.WAGE_PAY_DATE = '$newsetmonth' ";
            $getdatahead = DB::select($sql);

            $sql1 = "SELECT $baseHr.WAGE_HISTORY.*,
                            $baseHr.ADD_DEDUCT_HISTORY.*,
                            $baseHr.emp_data.code_emp_old,
                            $baseHr.emp_data.prefixth,
                            $baseHr.emp_data.nameth,
                              $baseHr.emp_data.surnameth
                    FROM $baseHr.WAGE_HISTORY
                    INNER JOIN $baseHr.ADD_DEDUCT_HISTORY
                    ON $baseHr.WAGE_HISTORY.WAGE_EMP_ID = $baseHr.ADD_DEDUCT_HISTORY.ADD_DEDUCT_THIS_MONTH_EMP_ID
                    INNER JOIN $baseHr.emp_data
                    ON $baseHr.emp_data.idcard_no = $baseHr.WAGE_HISTORY.WAGE_EMP_ID
                    WHERE $baseHr.WAGE_HISTORY.WAGE_PAY_DATE = '$newsetmonth'
                    AND $baseHr.ADD_DEDUCT_HISTORY.ADD_DEDUCT_THIS_MONTH_PAY_DATE = '$newsetmonth' ";
            $getdatadetail = DB::select($sql1);

            return ['getdatahead'=>$getdatahead,'getdatadetail'=>$getdatadetail];

    }

    public function saveempdateproductthislot(){
          $data = Input::all();
          $connect1 = Connectdb::Databaseall();
          $baseHr = $connect1['hr_base'];
          $emp_code = Session::get('emp_code');
          $br = Session::get('brcode');

          $remonth = explode("-",$data['month']);

          $newsetmonth = $remonth[1].'-'.$remonth[0];
          $totallg = 0;
            foreach ($data['idwage'] as $key => $value) {
                  $sql = "SELECT $baseHr.WAGE_HISTORY.*,
                                    $baseHr.emp_data.code_emp_old,
                                    $baseHr.emp_data.prefixth,
                                    $baseHr.emp_data.nameth,
                                    $baseHr.emp_data.surnameth,
                                    $baseHr.emp_data.branch_id
                            FROM $baseHr.WAGE_HISTORY
                            INNER JOIN $baseHr.emp_data
                            ON $baseHr.emp_data.idcard_no = $baseHr.WAGE_HISTORY.WAGE_EMP_ID
                            WHERE $baseHr.WAGE_HISTORY.WAGE_ID = '$value'
                            AND $baseHr.WAGE_HISTORY.WAGE_PAY_DATE = '$newsetmonth'";
                    $getdatahead = DB::select($sql);

                    ///////// OT
                    $sql1 = "SELECT $baseHr.ADD_DEDUCT_HISTORY.ADD_DEDUCT_THIS_MONTH_AMOUNT
                            FROM $baseHr.WAGE_HISTORY
                            INNER JOIN $baseHr.ADD_DEDUCT_HISTORY
                            ON $baseHr.WAGE_HISTORY.WAGE_EMP_ID = $baseHr.ADD_DEDUCT_HISTORY.ADD_DEDUCT_THIS_MONTH_EMP_ID
                            INNER JOIN $baseHr.emp_data
                            ON $baseHr.emp_data.idcard_no = $baseHr.WAGE_HISTORY.WAGE_EMP_ID
                            WHERE $baseHr.WAGE_HISTORY.WAGE_ID = '$value'
                            AND $baseHr.ADD_DEDUCT_HISTORY.ADD_DEDUCT_THIS_MONTH_TMP_ID = '8'
                            AND $baseHr.ADD_DEDUCT_HISTORY.ADD_DEDUCT_THIS_MONTH_PAY_DATE = '$newsetmonth'";
                    $getdatadetailot = DB::select($sql1);
                    $otthis = 0 ;
                    if(!empty($getdatadetailot)){
                        $otthis = $getdatadetailot[0]->ADD_DEDUCT_THIS_MONTH_AMOUNT;
                    }

                    /////////////// income Etc

                    $sql1 = "SELECT SUM($baseHr.ADD_DEDUCT_HISTORY.ADD_DEDUCT_THIS_MONTH_AMOUNT) as ADD_DEDUCT_THIS_MONTH_AMOUNT
                            FROM $baseHr.WAGE_HISTORY
                            INNER JOIN $baseHr.ADD_DEDUCT_HISTORY
                            ON $baseHr.WAGE_HISTORY.WAGE_EMP_ID = $baseHr.ADD_DEDUCT_HISTORY.ADD_DEDUCT_THIS_MONTH_EMP_ID
                            INNER JOIN $baseHr.emp_data
                            ON $baseHr.emp_data.idcard_no = $baseHr.WAGE_HISTORY.WAGE_EMP_ID
                            WHERE $baseHr.WAGE_HISTORY.WAGE_ID = '$value'
                            AND $baseHr.ADD_DEDUCT_HISTORY.ADD_DEDUCT_THIS_MONTH_TMP_ID != '8'
                            AND $baseHr.ADD_DEDUCT_HISTORY.ADD_DEDUCT_THIS_MONTH_TYPE  = '1'
                            AND $baseHr.ADD_DEDUCT_HISTORY.ADD_DEDUCT_THIS_MONTH_PAY_DATE = '$newsetmonth' ";
                    $getdatadetailincometc = DB::select($sql1);
                    $incomeetcthis = 0 ;
                    if(!empty($getdatadetailincometc)){
                        $incomeetcthis = $getdatadetailincometc[0]->ADD_DEDUCT_THIS_MONTH_AMOUNT;
                    }

                    /////////////// socail

                    $sql1 = "SELECT SUM($baseHr.ADD_DEDUCT_HISTORY.ADD_DEDUCT_THIS_MONTH_AMOUNT) as ADD_DEDUCT_THIS_MONTH_AMOUNT
                            FROM $baseHr.WAGE_HISTORY
                            INNER JOIN $baseHr.ADD_DEDUCT_HISTORY
                            ON $baseHr.WAGE_HISTORY.WAGE_EMP_ID = $baseHr.ADD_DEDUCT_HISTORY.ADD_DEDUCT_THIS_MONTH_EMP_ID
                            INNER JOIN $baseHr.emp_data
                            ON $baseHr.emp_data.idcard_no = $baseHr.WAGE_HISTORY.WAGE_EMP_ID
                            WHERE $baseHr.WAGE_HISTORY.WAGE_ID = '$value'
                            AND $baseHr.ADD_DEDUCT_HISTORY.ADD_DEDUCT_THIS_MONTH_TMP_ID = '38'
                            AND $baseHr.ADD_DEDUCT_HISTORY.ADD_DEDUCT_THIS_MONTH_PAY_DATE = '$newsetmonth'";
                    $getdatadetailso= DB::select($sql1);
                    $sothis = 0 ;
                    if(!empty($getdatadetailso)){
                        $sothis = $getdatadetailso[0]->ADD_DEDUCT_THIS_MONTH_AMOUNT;
                    }

                    /////////////// leave

                    $sql1 = "SELECT SUM($baseHr.ADD_DEDUCT_HISTORY.ADD_DEDUCT_THIS_MONTH_AMOUNT) as ADD_DEDUCT_THIS_MONTH_AMOUNT
                            FROM $baseHr.WAGE_HISTORY
                            INNER JOIN $baseHr.ADD_DEDUCT_HISTORY
                            ON $baseHr.WAGE_HISTORY.WAGE_EMP_ID = $baseHr.ADD_DEDUCT_HISTORY.ADD_DEDUCT_THIS_MONTH_EMP_ID
                            INNER JOIN $baseHr.emp_data
                            ON $baseHr.emp_data.idcard_no = $baseHr.WAGE_HISTORY.WAGE_EMP_ID
                            WHERE $baseHr.WAGE_HISTORY.WAGE_ID = '$value'
                            AND $baseHr.ADD_DEDUCT_HISTORY.ADD_DEDUCT_THIS_MONTH_TMP_ID = '21'
                            AND $baseHr.ADD_DEDUCT_HISTORY.ADD_DEDUCT_THIS_MONTH_PAY_DATE = '$newsetmonth'";
                    $getdatadetailleave= DB::select($sql1);
                    $leavethis = 0 ;
                    if(!empty($getdatadetailleave)){
                        $leavethis = $getdatadetailleave[0]->ADD_DEDUCT_THIS_MONTH_AMOUNT;
                    }

                    /////////////// leave

                    $sql1 = "SELECT SUM($baseHr.ADD_DEDUCT_HISTORY.ADD_DEDUCT_THIS_MONTH_AMOUNT) as ADD_DEDUCT_THIS_MONTH_AMOUNT
                            FROM $baseHr.WAGE_HISTORY
                            INNER JOIN $baseHr.ADD_DEDUCT_HISTORY
                            ON $baseHr.WAGE_HISTORY.WAGE_EMP_ID = $baseHr.ADD_DEDUCT_HISTORY.ADD_DEDUCT_THIS_MONTH_EMP_ID
                            INNER JOIN $baseHr.emp_data
                            ON $baseHr.emp_data.idcard_no = $baseHr.WAGE_HISTORY.WAGE_EMP_ID
                            WHERE $baseHr.WAGE_HISTORY.WAGE_ID = '$value'
                            AND $baseHr.ADD_DEDUCT_HISTORY.ADD_DEDUCT_THIS_MONTH_TMP_ID != '21'
                            AND $baseHr.ADD_DEDUCT_HISTORY.ADD_DEDUCT_THIS_MONTH_TMP_ID != '38'
                            AND $baseHr.ADD_DEDUCT_HISTORY.ADD_DEDUCT_THIS_MONTH_TYPE  = '2'
                            AND $baseHr.ADD_DEDUCT_HISTORY.ADD_DEDUCT_THIS_MONTH_PAY_DATE = '$newsetmonth'";
                    $getdatadetailpayetc= DB::select($sql1);
                    $payetc = 0 ;
                    if(!empty($getdatadetailpayetc)){
                        $payetc = $getdatadetailpayetc[0]->ADD_DEDUCT_THIS_MONTH_AMOUNT;
                    }
                    $incomeetcthis = $incomeetcthis+ $otthis + $getdatahead[0]->WAGE_SALARY ;
                    $arrInert = [ 'id'=>'',
                                  'bill_of_lading_head_id'=>$data['idbillhead'],
                                  'idcard'=>$getdatahead[0]->WAGE_EMP_ID,
                                  'empdata'=>$emp_code,
                                  'salary'=>$getdatahead[0]->WAGE_SALARY,
                                  'ot'=>$otthis,
                                  'incomeetc'=>$incomeetcthis,
                                  'socialpay'=>$sothis,
                                  'leavepay'=>$leavethis,
                                  'payetc'=>$payetc,
                                  'payreal'=>$getdatahead[0]->WAGE_NET_SALARY,
                                  'paythisproduct'=>$incomeetcthis,
                                  'status'=>'1',
                                  'wage_his_pk'=>$value,
                                  'date'=>date('Y-m-d H:m:s')
                                ];

                    // print_r($arrInert);
                   DB::table($connect1['fsctaccount'].'.emp_data_producttion')->insert($arrInert);

                    $totallg = $totallg + $incomeetcthis + $otthis + $getdatahead[0]->WAGE_SALARY ;




                  }
                  //////////////////// นอก loop



                 ///////////////////    บันทึก GL
               $arrInert = [ 'id'=>'',
                             'type_module'=>'5',
                             'number_bill_journal'=>'IDrefBillOfHead'.$data['idbillhead'],
                             'code_branch'=>$br,
                             'datebill'=>date('Y-m-d'),
                             'balance_forward_status'=>0,
                             'accept'=>1,
                             'status'=>1,
                             'totalsum'=>$totallg];

               $lastid = DB::table($connect1['fsctaccount'].'.journal_5')->insertGetId($arrInert);



                 // dr บันทึกบัญชี  งานระหว่างทำ-นั่งร้าน 266  115301//
               $totaldr = $totallg;

                 $accmake = '266';
                 $arrInert = [ 'id'=>'',
                               'id_journalgeneral_head'=>$lastid,
                               'accounttype'=>$accmake,
                               'list'=>'งานระหว่างทำ-นั่งร้าน',
                               'name_suplier'=>'',
                               'status'=>1,
                               'debit'=>$totaldr,
                               'credit'=>0];
                 DB::table($connect1['fsctaccount'].'.journalgeneral_detail')->insert($arrInert);

                 $arrInert = [ 'id'=>'',
                         'dr'=>$totaldr,
                         'cr'=>0.00,
                         'acc_code'=>'115301',
                         'branch'=>$br,
                         'status'=> 1,
                         'number_bill'=>'IDrefBillOfHead'.$data['idbillhead'],
                         'customer_vendor'=>$data['idbillhead'],
                         'timestamp'=>date('Y-m-d'),
                         //'code_emp'=>$emp_outs,
                         'subtotal'=> 0,
                         'discount'=> 0,
                         'vat'=> 0,
                         'vatmoney'=> 0,
                         // 'wht'=> $withholds,
                         'whtmoney'=> 0,
                         'grandtotal'=> $totaldr,
                         'type_journal' => 5,
                         'id_type_ref_journal'=>$lastid,
                         'timereal'=>date('Y-m-d'),
                         'list'=> 'ค่าแรง งานระหว่างทำ-นั่งร้าน :'.'IDrefBillOfHead'.$data['idbillhead']];
                 DB::table($connect1['fsctaccount'].'.ledger')->insert($arrInert);

                 // cr บันทึกบัญชี  ค่าใช้จ่ายในการบริหาร-เงินเดือนพนักงาน 168  621101//
               $totalcr = $totallg;

                 $accsl = '168';
                 $arrInert = [ 'id'=>'',
                               'id_journalgeneral_head'=>$lastid,
                               'accounttype'=>$accsl,
                               'list'=>'ค่าใช้จ่ายในการบริหาร-เงินเดือนพนักงาน',
                               'name_suplier'=>'',
                               'status'=>1,
                               'debit'=>0,
                               'credit'=>$totalcr];
                 DB::table($connect1['fsctaccount'].'.journalgeneral_detail')->insert($arrInert);

                 $arrInert = [ 'id'=>'',
                         'dr'=>0.00,
                         'cr'=>$totalcr,
                         'acc_code'=>'621101',
                         'branch'=>$br,
                         'status'=> 1,
                         'number_bill'=>'IDrefBillOfHead'.$data['idbillhead'],
                         'customer_vendor'=>$data['idbillhead'],
                         'timestamp'=>date('Y-m-d'),
                         //'code_emp'=>$emp_outs,
                         'subtotal'=> 0,
                         'discount'=> 0,
                         'vat'=> 0,
                         'vatmoney'=> 0,
                         // 'wht'=> $withholds,
                         'whtmoney'=> 0,
                         'grandtotal'=> $totaldr,
                         'type_journal' => 5,
                         'id_type_ref_journal'=>$lastid,
                         'timereal'=>date('Y-m-d'),
                         'list'=> 'ค่าใช้จ่ายในการบริหาร-เงินเดือนพนักงาน ของ :'.'IDrefBillOfHead'.$data['idbillhead']];
                 DB::table($connect1['fsctaccount'].'.ledger')->insert($arrInert);

          SWAL::message('สำเร็จ', 'บันทึกรายการ', 'success', ['timer' => 6000]);
          return redirect()->back();
    }

    public function getgoodformaterial(){
          $connect1 = Connectdb::Databaseall();
          $baseAc1 = $connect1['fsctaccount'];
          $sql2 = "SELECT $baseAc1.good.*
                  FROM $baseAc1.good
                  WHERE $baseAc1.good.status != '99'
                  AND $baseAc1.good.status_toolasset = '1' ";
          $getdatas = DB::select($sql2);

          return $getdatas;
    }

    public function saveconfiggoodtomaterial(){
        $data = Input::all();
        $connect1 = Connectdb::Databaseall();
        $emp_code = Session::get('emp_code');


        $arrInert = [ 'id'=>'',
                'material_id'=>$data['mproduct'],
                'status'=>'1',
                'emp_add'=>$emp_code,
                'datetime'=>date('Y-m-d H:m:s'),
                'amountmain'=>$data['amountmain']
                ];
      $lastid = DB::table($connect1['fsctmain'].'.goods_to_material_head')->insertGetId($arrInert);

      foreach ($data['idgood'] as $key => $value) {
              $arrInert = [ 'id'=>'',
                      'goods_to_material_head_id'=>$lastid,
                      'goodsid'=>$value,
                      'amountpermeet'=>$data['amountpermeet'][$key],
                      'pricepermeet'=>$data['pricepermeet'][$key],
                      'totalthis'=>$data['totalthis'][$key]
                      ];
            DB::table($connect1['fsctmain'].'.goods_to_material_detail')->insert($arrInert);
      }

        SWAL::message('สำเร็จ', 'บันทึกรายการ', 'success', ['timer' => 6000]);
        return redirect()->back();
    }

    public function asset_product_tool(){
            return view('setting.asset_product_tool');

    }

    public function seachbillofladinghead(){
        $data = Input::all();
        $connect1 = Connectdb::Databaseall();

        $bill = $data['bill'];

        /////// bill_of_lading_head
        $baseAc1 = $connect1['fsctaccount'];
        $sql2 = "SELECT $baseAc1.bill_of_lading_head.*
                FROM $baseAc1.bill_of_lading_head
                WHERE $baseAc1.bill_of_lading_head.status  = '1'
                AND $baseAc1.bill_of_lading_head.number_bill = '$bill' ";
        $getdatas = DB::select($sql2);

        if(!empty($getdatas)){
          ////// sum sw  emp_data_producttion
          $idheadbill = $getdatas[0]->id;
          $sql2 = "SELECT sum($baseAc1.emp_data_producttion.paythisproduct) as sumpaythisproduct
                  FROM $baseAc1.emp_data_producttion
                  WHERE $baseAc1.emp_data_producttion.status  = '1'
                  AND $baseAc1.emp_data_producttion.bill_of_lading_head_id = '$idheadbill' ";
          $sumpaythisproduct = DB::select($sql2);
              return ['billhead'=>$getdatas,'sumpaythisproduct'=>$sumpaythisproduct];
        }else{
              return 0;
        }





    }

    public function getmaterialall(){
            $data = Input::all();
            $connect1 = Connectdb::Databaseall();
            $baseMan = $connect1['fsctmain'];
              $sql2 = "SELECT $baseMan.material.*
                      FROM $baseMan.material
                      WHERE $baseMan.material.status != '99' ";
              $getdatas = DB::select($sql2);
          return $getdatas;
    }

    public function selectmmapping(){
          $data = Input::all();
          $connect1 = Connectdb::Databaseall();

          $baseMan = $connect1['fsctmain'];
          $bill = $data['bill'];
          $mId =  $data['mId'];
          //  หาว่าได้ตั้ง ใบเบิกใช้วัสตุตัวไหน
          $baseAc1 = $connect1['fsctaccount'];
          $sql2 = "SELECT $baseAc1.bill_of_lading_head.*,
                          $baseAc1.bill_of_lading_detail.*
                  FROM $baseAc1.bill_of_lading_head
                  INNER JOIN $baseAc1.bill_of_lading_detail
                  ON $baseAc1.bill_of_lading_head.id = $baseAc1.bill_of_lading_detail.bill_of_lading_head
                  WHERE $baseAc1.bill_of_lading_head.status  = '1'
                  AND $baseAc1.bill_of_lading_head.number_bill = '$bill' ";
          $getdatas = DB::select($sql2);

          $arrInGoods  = [];
            foreach ($getdatas as $a => $b) {
                $arrInGoods[] = $b->materialid;
            }
          $goodIn =  implode(",",$arrInGoods);

          //  ได้วัสดุแล้วมา mapping ว่ามีก่อ goods_to_material_head_id ต้องมี 100%
             $sql2 = "SELECT $baseMan.goods_to_material_head.*,
                            $baseMan.goods_to_material_detail.*
                    FROM $baseMan.goods_to_material_head
                    INNER JOIN $baseMan.goods_to_material_detail
                    ON $baseMan.goods_to_material_head.id = $baseMan.goods_to_material_detail.goods_to_material_head_id
                    WHERE $baseMan.goods_to_material_head.status  = '1'
                    AND $baseMan.goods_to_material_detail.goodsid IN ($goodIn)
                    AND $baseMan.goods_to_material_head.material_id = '$mId' ";
            $getdatamain = DB::select($sql2);
          if(!empty($getdatamain)){
            $idSet = $getdatamain[0]->goods_to_material_head_id;
            $sql2 = "SELECT count($baseMan.goods_to_material_detail.id) as countgoods_to_material_detail
                    FROM $baseMan.goods_to_material_head
                    INNER JOIN $baseMan.goods_to_material_detail
                    ON $baseMan.goods_to_material_head.id = $baseMan.goods_to_material_detail.goods_to_material_head_id
                    WHERE $baseMan.goods_to_material_head.status  = '1'
                    AND $baseMan.goods_to_material_detail.goods_to_material_head_id = '$idSet' ";
            $getdatacksize = DB::select($sql2);

              // print_r($getdatacksize);
              $sizeSetgood = sizeof($arrInGoods);
                    if($sizeSetgood==$getdatacksize[0]->countgoods_to_material_detail){
                          $sql2 = "SELECT $baseMan.goods_to_material_head.amountmain,
                                        SUM($baseMan.goods_to_material_detail.totalthis) as sumtotalthis
                                 FROM $baseMan.goods_to_material_head
                                 INNER JOIN $baseMan.goods_to_material_detail
                                 ON $baseMan.goods_to_material_head.id = $baseMan.goods_to_material_detail.goods_to_material_head_id
                                 WHERE $baseMan.goods_to_material_head.status  = '1'
                                 AND $baseMan.goods_to_material_detail.goodsid IN ($goodIn)
                                 AND $baseMan.goods_to_material_head.material_id = '$mId' ";
                         $getdatause = DB::select($sql2);
                        return $getdatause;
                    }else{
                        return 0;
                    }
          }else{
              return 0;
          }


            //
    }

    public function saveproductgoodtoproduct(){
          $data = Input::all();
          $connect1 = Connectdb::Databaseall();


          $emp_code = Session::get('emp_code');
          $baseMan = $connect1['fsctmain'];


          //  หาว่าได้ตั้ง ใบเบิกใช้วัสตุตัวไหน
          $baseAc1 = $connect1['fsctaccount'];
          $sql2 = "SELECT Max($baseAc1.receiptasset.id)+1 as idgen
                  FROM $baseAc1.receiptasset ";
          $idgen = DB::select($sql2);
          $Y = (date('Y')+543);
          $m = date('m');
          $d = date('d');
          $bill = $data['bill_of_lading_head'];

          $sql2 = "SELECT $baseAc1.bill_of_lading_head.*,
                          $baseAc1.bill_of_lading_detail.*
                  FROM $baseAc1.bill_of_lading_head
                  INNER JOIN $baseAc1.bill_of_lading_detail
                  ON $baseAc1.bill_of_lading_head.id = $baseAc1.bill_of_lading_detail.bill_of_lading_head
                  WHERE $baseAc1.bill_of_lading_head.status  = '1'
                  AND $baseAc1.bill_of_lading_head.number_bill = '$bill' ";
          $getdatabillhead = DB::select($sql2);


          $arrInert = [ 'id'=>'',
                  'po_ref'=>0,
                  'receiptnum'=>'RCT'.$Y.$m.$d.str_pad($idgen[0]->idgen, 5, '0', STR_PAD_LEFT),
                  'datein'=>date('Y-m-d H:m:s'),
                  'dateuse'=>date('Y-m-d H:m:s'),
                  'status'=>'0',
                  'emp_code'=>$emp_code,
                  'type_pd'=>'1',
                  'bill_of_lading_head_id'=>$getdatabillhead[0]->bill_of_lading_head,
                  ];

          // print_r($data);
           $lastid = DB::table($connect1['fsctaccount'].'.receiptasset')->insertGetId($arrInert);

          foreach ($data['material_id'] as $key => $value) {
                $arrInert = [ 'id'=>'',
                        'receiptasset_id'=>$lastid,
                        'material_id'=>$value,
                        'lot'=>$data['LotShow'],
                        'produce'=>$data['produce'][$key],
                        'cost'=>$data['cost'][$key],
                        'total_cost'=>$data['total_cost'][$key],
                        'saraly'=>$data['saraly'][$key],
                        'total_cost_produce'=>$data['total_cost_produce'][$key],
                        'cost_produce_unit'=>$data['cost_produce_unit'][$key],
                        'beginningbalance'=>0,
                        'depreciation_first'=>0,
                        ];
              DB::table($connect1['fsctaccount'].'.receiptasset_detail')->insert($arrInert);
          }


          SWAL::message('สำเร็จ', 'บันทึกรายการ', 'success', ['timer' => 6000]);
          return redirect()->back();

    }


    public function approveasset_product_tool(){
            $data = Input::all();
            $connect1 = Connectdb::Databaseall();
            $emp_code = Session::get('emp_code');
            ////////////  save app ac
            // print_r($data);
            $baseAc1 = $connect1['fsctaccount'];
            // print_r($data);
            $id = $data['id'];
            $sqlUpdate = ' UPDATE '.$baseAc1.'.receiptasset
                      SET status = "1"
                      WHERE '.$baseAc1.'.receiptasset.id = "'.$id.'" ';
            $lgUpdateResulte = DB::connection('mysql')->select($sqlUpdate);

            $sql2 = "SELECT $baseAc1.receiptasset.*,
                            sum($baseAc1.receiptasset_detail.total_cost_produce) as sumtotal_cost_produce
                   FROM $baseAc1.receiptasset
                   INNER JOIN $baseAc1.receiptasset_detail
                   ON $baseAc1.receiptasset.id = $baseAc1.receiptasset_detail.receiptasset_id
                   WHERE $baseAc1.receiptasset.status  = '1'
                   AND $baseAc1.receiptasset.id =  '$id' ";

            $getdatadetail = DB::select($sql2);


          $receiptnum = $getdatadetail[0]->receiptnum;
          $sumtotal_cost_produce = $getdatadetail[0]->sumtotal_cost_produce;
          $brcode = Session::get('brcode');
          ///////////////////    บันทึก GL
          $arrInert = [ 'id'=>'',
                      'type_module'=>'5',
                      'number_bill_journal'=>$receiptnum,
                      'code_branch'=>$brcode,
                      'datebill'=>date('Y-m-d'),
                      'balance_forward_status'=>0,
                      'accept'=>1,
                      'status'=>1,
                      'totalsum'=>$sumtotal_cost_produce];

        $lastid = DB::table($connect1['fsctaccount'].'.journal_5')->insertGetId($arrInert);


            // dr บันทึกบัญชี   เครื่องมือให้เช่า 121  151900//
          $totaldr = $sumtotal_cost_produce;

            $accmake = '121';
            $arrInert = [ 'id'=>'',
                          'id_journalgeneral_head'=>$lastid,
                          'accounttype'=>$accmake,
                          'list'=>'เครื่องมือให้เช่า',
                          'name_suplier'=>'',
                          'status'=>1,
                          'debit'=>$totaldr,
                          'credit'=>0];
            DB::table($connect1['fsctaccount'].'.journalgeneral_detail')->insert($arrInert);

            $arrInert = [ 'id'=>'',
                    'dr'=>$sumtotal_cost_produce,
                    'cr'=>0.00,
                    'acc_code'=>'151900',
                    'branch'=>$brcode,
                    'status'=> 1,
                    'number_bill'=>$receiptnum,
                    'customer_vendor'=>'',
                    'timestamp'=>date('Y-m-d'),
                    //'code_emp'=>$emp_outs,
                    'subtotal'=> 0,
                    'discount'=> 0,
                    'vat'=> 0,
                    'vatmoney'=> 0,
                    // 'wht'=> $withholds,
                    'whtmoney'=> 0,
                    'grandtotal'=> $totaldr,
                    'type_journal' => 5,
                    'id_type_ref_journal'=>$lastid,
                    'timereal'=>date('Y-m-d'),
                    'list'=> ' นั่งร้าน :'.'bill'.$receiptnum];
            DB::table($connect1['fsctaccount'].'.ledger')->insert($arrInert);


            // cr บันทึกบัญชี   งานระหว่างทำ-นั่งร้าน 266  115301//
          $totalcr = $sumtotal_cost_produce;

            $acccr = '266';
            $arrInert = [ 'id'=>'',
                          'id_journalgeneral_head'=>$lastid,
                          'accounttype'=>$acccr,
                          'list'=>'งานระหว่างทำ-นั่งร้าน',
                          'name_suplier'=>'',
                          'status'=>1,
                          'debit'=>0,
                          'credit'=>$sumtotal_cost_produce];
            DB::table($connect1['fsctaccount'].'.journalgeneral_detail')->insert($arrInert);

            $arrInert = [ 'id'=>'',
                    'dr'=>0.00,
                    'cr'=>$sumtotal_cost_produce,
                    'acc_code'=>'115301',
                    'branch'=>$brcode,
                    'status'=> 1,
                    'number_bill'=>$receiptnum,
                    'customer_vendor'=>'',
                    'timestamp'=>date('Y-m-d'),
                    //'code_emp'=>$emp_outs,
                    'subtotal'=> 0,
                    'discount'=> 0,
                    'vat'=> 0,
                    'vatmoney'=> 0,
                    // 'wht'=> $withholds,
                    'whtmoney'=> 0,
                    'grandtotal'=> $totalcr,
                    'type_journal' => 5,
                    'id_type_ref_journal'=>$lastid,
                    'timereal'=>date('Y-m-d'),
                    'list'=> 'งานระหว่างทำ-นั่งร้าน :'.'bill'.$receiptnum];
            DB::table($connect1['fsctaccount'].'.ledger')->insert($arrInert);

            SWAL::message('สำเร็จ', 'บันทึกรายการ', 'success', ['timer' => 6000]);
            return 1;


    }



}
