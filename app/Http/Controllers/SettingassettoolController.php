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

}
