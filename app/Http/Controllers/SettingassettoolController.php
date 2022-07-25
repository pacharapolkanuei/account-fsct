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
                      $baseAc1.supplier.name_supplier
              FROM $baseAc1.po_head
              INNER JOIN $baseAc1.po_detail
              ON $baseAc1.po_head.id = $baseAc1.po_detail.po_headid
              INNER JOIN $baseAc1.supplier
              ON $baseAc1.supplier.id = $baseAc1.po_head.supplier_id
              WHERE $baseAc1.po_head.status_head != '99'
              AND $baseAc1.po_head.po_number = '$idserch'";
        $getdatas = DB::select($sql1);
        return $getdatas;


    }

}
