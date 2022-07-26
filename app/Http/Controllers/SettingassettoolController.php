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

}
