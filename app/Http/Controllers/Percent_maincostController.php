<?php

namespace App\Http\Controllers;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use App\Http\Requests\Group_PropertyRequest;
use DB;
use App\Branch;
use App\Percent_maincost;
use App\Ledger;
use App\Type_journal;
use App\Accounttype;
use App\Api\Connectdb;
use Illuminate\Support\Facades\Input;
use Softon\SweetAlert\Facades\SWAL;
use App\Api\Datetime;


class Percent_maincostController extends Controller
{
  use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

  public function index()
  {
    // $accounttypes = new Accounttype;
    // $accounttypes->setConnection('mysql2');
    // $accounttypes = Accounttype::where('status','=',1)
    //               ->get();

    $connect1 = Connectdb::Databaseall();
    $baseAc1 = $connect1['fsctaccount'];
    $basemain1 = $connect1['fsctmain'];
    $baseHr1 = $connect1['hr_base'];

    $sql1 = "SELECT $basemain1.percent_main_cost.*
                                    ,percent_main_cost.id as id_percent_ref
                                    ,percent_main_cost.percent
                                    ,branch.name_branch

                    FROM $basemain1.percent_main_cost

                    INNER JOIN $baseHr1.branch
                    ON $basemain1.percent_main_cost.branch_id = $baseHr1.branch.code_branch

                    WHERE $basemain1.percent_main_cost.status = 1
                    ORDER BY $basemain1.percent_main_cost.id ASC ";

    $datas = DB::select($sql1);
    return view('percent_main_cost' , compact( 'datas' ));
  }

  public function getdata_percent($id)
  {
    $connect1 = Connectdb::Databaseall();
    $baseAc1 = $connect1['fsctaccount'];
    $baseHr1 = $connect1['hr_base'];
    $basemain1 = $connect1['fsctmain'];

    $sql1 = "SELECT $basemain1.percent_main_cost.*
                                    ,percent_main_cost.id

                    FROM $basemain1.percent_main_cost

                    WHERE $basemain1.percent_main_cost.id = $id";

      $getdatas = DB::select($sql1);
      return $getdatas;
  }

  public function update(Request $request)
  {
    $get_id = $request->get('get_id');
    // dd($get_id);
    // exit;
    $property = Percent_maincost::find($get_id);
    $property->percent = $request->get('percent_num');

    $property->update();
    SWAL::message('สำเร็จ', 'แก้ไขเรียบร้อย!', 'success', ['timer' => 6000]);
    return redirect()->route('percent_main_cost');

  }


  // public function delete($id)
  // {
  //     $property = Group_Property::find($id);
  //     // dd($property);
  //     // exit;
  //     if ($property != null) {
  //         $property->statususe = '99';
  //         $property->update();
  //         return redirect()->route('define_property');
  //     }
  // }

}
