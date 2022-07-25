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

class Asset_listController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index()
    {
      $accounttypes = new Accounttype;
      $accounttypes->setConnection('mysql2');
      $accounttypes = Accounttype::where('status','=',1)
                    ->get();

      $group_propertys = new Group_Property;
      $group_propertys->setConnection('mysql2');
      $group_propertys = Group_Property::where('statususe','=',1)
                    ->get();

      // $branchs = new Branch;
      // $group_propertys->setConnection('mysql2');
      // $group_propertys = Group_Property::where('statususe','=',1)
      //               ->get();

      $branchs = new Branch;
    	$branchs->setConnection('hr_base');
		  $branchs = Branch::get();

      $asset_lists = DB::connection('mysql2')
          ->table('asset_list')
          ->select('group_property.id as id_group_property' , 'accounttype.id as id_accounttype'
          , 'asset_list.id as id_assetlist', 'asset_list.no_asset', 'asset_list.name_thai', 'asset_list.date_buy'
          , 'asset_list.price_buy', 'asset_list.life_for_use', 'asset_list.end_price_sellpercent', 'asset_list.date_sell'
          , 'asset_list.depreciation_sell', 'asset_list.profit_loss' , 'asset_list.asset_different')
          ->join('group_property', 'group_property.id', '=', 'asset_list.group_acc_id')
          ->join('accounttype', 'accounttype.id', '=', 'asset_list.group_property_id')
          ->orderBy('asset_list.id', 'asc')
          ->where('asset_list.statususe',1)
          ->limit(0)
          ->get();
      return view('assetlist.asset_list' , compact('accounttypes' , 'group_propertys' , 'asset_lists' , 'branchs' ));
    }

    public function  asset_list_filter(Request $request)
    {
        $branchs = new Branch;
        $branchs = Branch::get();

        $date = $request->get('daterange');
        $branch = $request->get('branch');
        // dd($date);
        // exit;
        $accounttypes = new Accounttype;
        $accounttypes->setConnection('mysql2');
        $accounttypes = Accounttype::where('status','=',1)
                      ->get();

        $group_propertys = new Group_Property;
        $group_propertys->setConnection('mysql2');
        $group_propertys = Group_Property::where('statususe','=',1)
                      ->get();

        $dateset = Datetime::convertStartToEnd($date);
        $start = $dateset['start'];
        $end = $dateset['end'];

        if ($branch != '0') {
            $asset_lists = DB::connection('mysql2')
                ->table('asset_list')
                ->select('asset_list.id as id_assetlist' , 'asset_list.no_asset' , 'asset_list.name_thai', 'asset_list.date_buy' ,
                'asset_list.price_buy' , 'asset_list.life_for_use' , 'asset_list.end_price_sellpercent' , 'asset_list.depreciation_sell',
                'asset_list.profit_loss' , 'asset_list.date_sell' , 'asset_list.asset_different' , 'asset_list.depreciation_buy')
                ->orderBy('id', 'asc')
                // ->whereBetween('date_buy', [$start, $end])
                ->where('branch_id', $branch)
                ->get();
            // dump('have');
        } else {
            $asset_lists = DB::connection('mysql2')
                ->table('asset_list')
                ->select('asset_list.id as id_assetlist' , 'asset_list.no_asset' , 'asset_list.name_thai', 'asset_list.date_buy' ,
                'asset_list.price_buy' , 'asset_list.life_for_use' , 'asset_list.end_price_sellpercent' , 'asset_list.depreciation_sell',
                'asset_list.profit_loss' , 'asset_list.date_sell' , 'asset_list.asset_different' , 'asset_list.depreciation_buy')
                ->orderBy('id', 'asc')
                // ->whereBetween('date_buy', [$start, $end])
                ->get();
            // dump('empty');
        }
        $ap = 'default';
        // dd($debts);
        return view('assetlist.asset_list', compact('asset_lists', 'ap', 'branchs' , 'accounttypes' , 'group_propertys' , 'date'));
    }


    public function pdf($daterangez,$branchz)
    {

        $get_date = $daterangez;
        $get_branch = $branchz;

        $dateset = Datetime::convertStartToEnd($get_date);
        $start = $dateset['start'];
        $end = $dateset['end'];

        if ($get_branch != '0') {
            $asset_lists = DB::connection('mysql2')
                ->table('asset_list')
                ->join('po_head', 'inform_po_mainhead.po_id', '=', 'po_head.id')
                ->where('po_detail.statususe','=',1)

                ->orderBy('id', 'asc')
                ->whereBetween('date_buy', [$start, $end])
                ->where('branch_id', $get_branch)
                ->get();
            // dump('have');
        } else {
            $asset_lists = DB::connection('mysql2')
                ->table('asset_list')
                ->join('po_head', 'inform_po_mainhead.po_id', '=', 'po_head.id')
                ->where('po_detail.statususe','=',1)

                ->orderBy('id', 'asc')
                ->whereBetween('date_buy', [$start, $end])
                ->get();
            // dump('empty');
        }

        $report_asset_list = DB::connection('mysql2')
          ->table('asset_list')
          ->join('po_head', 'inform_po_mainhead.po_id', '=', 'po_head.id')
          ->join('po_detail', 'inform_po_mainhead.po_id', '=', 'po_detail.po_headid')
          ->join('supplier', 'po_head.supplier_id', '=', 'supplier.id')
          ->join('type_pay', 'inform_po_mainhead.type_pay', '=', 'type_pay.id')
          ->where('po_detail.statususe','=',1)
          ->get();

          $pdf = PDF::loadView('asset_list.asset_listpdf', ['report_asset_list' => $report_asset_list]);
          return @$pdf->stream();
    }


    public function store(Asset_listRequest $request)
    {
      $date_start = strtotime($request->get('date_cal_starts'));
      $date_end = strtotime($request->get('date_cal_ends'));
      $datediff = $date_end - $date_start;
      $number_two_date = round($datediff / (60 * 60 * 24));

      $date_buy_loop = substr($request->get('date_buy'),0,4);
      $date_end_loop = substr($request->get('date_cal_ends'),0,4);
      // $life_use = 4;
      $price_buy = $request->get('price_buy');
      $end_price_sell = $request->get('end_price_sell');

      for ($i = $date_buy_loop; $i < $date_end_loop ; $i++) {
          // $numberday1 = date("z", strtotime("01-01-$i")) + 1;
          // $cal1 = ($price_buy - $end_price_sell)*($numberday1/$number_two_date);
          dd($i);
          exit;
      }

      // do {
      //   $numberday1 = date("z", strtotime("01-01-$date_buy_loop")) + 1;
      //   $cal1 = ($price_buy - $end_price_sell)*($numberday1/$number_two_date);
      //   echo $cal1;
      //   $date_buy_loop++;
      // } while ($date_buy_loop < $date_end_loop);






      $asset_list = new Asset_list;
      $asset_list->setConnection('mysql2');
      $asset_list->no_asset = $request->get('no_asset');
      $asset_list->name_thai = $request->get('name_thai');
      $asset_list->name_eng = $request->get('name_eng');
      $asset_list->asset_different = $request->get('assetlist_different');
      $asset_list->group_property_id = $request->get('groups');
      $asset_list->group_acc_id = $request->get('groups_acc');
      $asset_list->no_register = $request->get('no_register');
      $asset_list->department = $request->get('department');

      $asset_list->branch_id = $request->get('ins_branch');

      $asset_list->date_buy = $request->get('date_buy');
      $asset_list->date_startuse = $request->get('date_startuse');
      $asset_list->price_buy = $request->get('price_buy');
      $asset_list->life_for_use = $request->get('life_for_use');
      $asset_list->end_price_sell = $request->get('end_price_sell');
      $asset_list->end_price_sellpercent = $request->get('end_price_sellpercent');

      if ($request->get('cal_depreciation_buy') != null) {
        $asset_list->depreciation_buy = $request->get('cal_depreciation_buy');
      }

      $asset_list->date_sell = $request->get('date_sell');

      $asset_list->year_depreciation = $request->get('year_depreciation');
      $asset_list->month_depreciation = $request->get('month_depreciation');

      $asset_list->day_depreciation_buy = $request->get('day_depreciation');
      $asset_list->depreciation_sell = $request->get('depreciation_sell');
      $asset_list->cal_date = $request->get('cal_date');
      $asset_list->profit_loss = $request->get('profit_loss');
      $asset_list->primary_depreciation = $request->get('primary_depreciation');
      // dd($asset_list);
      // exit;
      $asset_list->save();

      SWAL::message('สำเร็จ', 'บันทึกรายการทรัพย์สิน!', 'success', ['timer' => 6000]);
      return redirect()->route('asset_list');
    }

    public function getassetlist($id)
    {
      $connect1 = Connectdb::Databaseall();
      $baseAc1 = $connect1['fsctaccount'];
      $baseHr1 = $connect1['hr_base'];

      $sql1 = "SELECT $baseAc1.asset_list.*
                                      ,accounttype.id as id_accounttype
                                      ,accounttype.accounttypeno
                                      ,accounttype.accounttypefull
                                      ,group_property.id as id_group_property
                                      ,group_property.number_property
                                      ,group_property.descritption_thai

                      FROM $baseAc1.asset_list

                      INNER JOIN $baseAc1.accounttype
                      ON $baseAc1.asset_list.group_property_id = $baseAc1.accounttype.id

                      INNER JOIN $baseAc1.group_property
                      ON $baseAc1.asset_list.group_acc_id = $baseAc1.group_property.id

                      WHERE $baseAc1.asset_list.id = $id";

        $getdatas = DB::select($sql1);
        return $getdatas;
    }

    public function update(Request $request)
    {
      $get_id = $request->get('get_id');
      // dd($get_id);
      // exit;
      $asset_list = Asset_list::find($get_id);
      $asset_list->no_asset = $request->get('no_asset');
      $asset_list->name_thai = $request->get('name_thai');
      $asset_list->name_eng = $request->get('name_eng');
      $asset_list->asset_different = $request->get('assetlist_differents');
      $asset_list->group_property_id = $request->get('groups');
      $asset_list->group_acc_id = $request->get('groups_acc');
      $asset_list->no_register = $request->get('no_register');
      $asset_list->department = $request->get('department');
      $asset_list->date_buy = $request->get('date_buy');
      $asset_list->date_startuse = $request->get('date_startuse');
      $asset_list->price_buy = $request->get('price_buy');
      $asset_list->life_for_use = $request->get('life_for_use');
      $asset_list->end_price_sell = $request->get('end_price_sell');
      $asset_list->end_price_sellpercent = $request->get('end_price_sellpercent');
      $asset_list->depreciation_buy = $request->get('depreciation_buy');
      $asset_list->date_sell = $request->get('date_sell');
      $asset_list->day_depreciation_buy = $request->get('day_depreciation');
      $asset_list->depreciation_sell = $request->get('depreciation_sell');
      $asset_list->cal_date = $request->get('cal_date');
      $asset_list->profit_loss = $request->get('profit_loss');
      $asset_list->primary_depreciation = $request->get('primary_depreciation');

      $asset_list->update();
      SWAL::message('สำเร็จ', 'แก้ไขเรียบร้อย!', 'success', ['timer' => 6000]);
      return redirect()->route('asset_list');

    }

    public function delete($id)
    {
        $asset_list = Asset_list::find($id);
        // dd($property);
        // exit;
        if ($asset_list != null) {
            $asset_list->statususe = '99';
            $asset_list->update();
            return redirect()->route('asset_list');
        }
    }

}
