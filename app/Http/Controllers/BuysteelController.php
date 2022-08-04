<?php

namespace App\Http\Controllers;

use App\Bank;
use Illuminate\Http\Request;
use Softon\SweetAlert\Facades\SWAL;
use App\Branch;
use App\Po_head;
use App\Po_detail;
use App\Accounttype;
use App\Material_ref_good;
use App\Receiptasset;
use App\Api\Connectdb;
use App\Receiptasset_detail;
use App\Http\Requests\BankRequest;
use Carbon\Carbon;
use DB;

class BuysteelController extends Controller
{

    public function index()
    {
      // $propertys = DB::connection('mysql2')
      //     ->table('receiptasset_detail')
      //     ->select('group_property.id as id_group','group_property.number_property','group_property.descritption_thai','group_property.descritption_eng','accounttype.accounttypeno','accounttype.accounttypefull')
      //     ->join('accounttype', 'accounttype.id', '=', 'group_property.accounttype_no')
      //     ->orderBy('group_property.id', 'asc')
      //     ->where('group_property.statususe',1)
      //     ->get();
      $connect = Connectdb::Databaseall();
      $baseAc = $connect['fsctaccount'];
      $baseHr = $connect['hr_base'];
      $baseMain = $connect['fsctmain'];

      $sql = "SELECT $baseAc.receiptasset_detail.*
                                      ,material.name as material_name
                                      ,receiptasset.type_pd

                      FROM $baseAc.receiptasset_detail

                      INNER JOIN $baseMain.material
                      ON $baseAc.receiptasset_detail.material_id = $baseMain.material.id

                      INNER JOIN $baseAc.receiptasset
                      ON $baseAc.receiptasset_detail.receiptasset_id = $baseAc.receiptasset.id

                      WHERE $baseAc.receiptasset.type_pd = 0";

      $receiptasset_details = DB::select($sql);

      return view('assetlist.buysteel',['receiptasset_details'=>$receiptasset_details]);
    }

    public function approve_buysteel_index()
    {
      $connect = Connectdb::Databaseall();
      $baseAc = $connect['fsctaccount'];
      $baseHr = $connect['hr_base'];
      $baseMain = $connect['fsctmain'];

      $sql = "SELECT $baseAc.receiptasset.*
                                      ,po_head.po_number
                                      ,receiptasset_detail.totalall
                                      ,receiptasset_detail.lot


                      FROM $baseAc.receiptasset

                      INNER JOIN $baseAc.po_head
                      ON $baseAc.receiptasset.po_ref = $baseAc.po_head.id

                      LEFT JOIN $baseAc.receiptasset_detail
                      ON $baseAc.receiptasset_detail.receiptasset_id = $baseAc.receiptasset.id

                      WHERE $baseAc.receiptasset.type_pd = 0
                      GROUP BY $baseAc.receiptasset_detail.receiptasset_id
                      ORDER BY $baseAc.receiptasset.receiptnum ASC";

      $receiptassets = DB::select($sql);

      return view('assetlist.approve_buysteel',['receiptassets'=>$receiptassets]);
    }

    public function config_buysteel_index()
    {
      $connect = Connectdb::Databaseall();
  		$baseAc = $connect['fsctaccount'];
  		$sql = "SELECT * FROM $baseAc.po_head

                       WHERE $baseAc.po_head.branch_id = 1001";
  		$po_heads = DB::select($sql);

      return view('assetlist.config_po_good',['po_heads'=>$po_heads]);
    }
    function getpodetailbyidhead(Request $request)
    {
        $id = $request->post('data');
         $po_detail = new Po_detail;
         $po_detail->setConnection('mysql2');
         $po_detail = Po_detail::join('po_head', 'po_head.id', '=', 'po_detail.po_headid')
                       ->whereIn('po_detail.po_headid', $id)
                       ->where('statususe','=',1)
                       ->get();
         return $po_detail;
    }


    public function approve_confirm(Request $request)
  	{
  				$receiptasset_id = $request->get('receiptasset_id');

  				DB::connection('mysql2')
  				->table('receiptasset')->whereIn('id',$receiptasset_id)
  				->update(['status' => 1]);

          $connect1 = Connectdb::Databaseall();
          $baseAc1 = $connect1['fsctaccount'];
          $baseHr1 = $connect1['hr_base'];

          $sql1 = "SELECT $baseAc1.receiptasset.*
                                          ,
                                          ,

                          FROM $baseAc1.receiptasset

                          INNER JOIN $baseAc1.receiptasset_detail
                          ON $baseAc1.receiptasset_detail.receiptasset_id = $baseAc1.receiptasset.id

                          INNER JOIN $baseAc1.material
                          ON $baseAc1.receiptasset_detail.material_id = $baseAc1.material.id

                          WHERE $baseAc1.receiptasset.id = $receiptasset_id ";
          $getdata = DB::select($sql1);



  				SWAL::message('สำเร็จ', 'ได้ผ่านการอนุมัติแล้ว!', 'success', ['timer' => 6000]);
  				return redirect()->route('approve_buysteel');


  	}



    public function search(Request $request)
    {
      if($request->ajax())
      {
      $output="";

      $products = DB::connection('mysql2')
  			->table('po_head')
  			->where('po_number','LIKE',$request->search)
  			->get();

          if(!empty($products))
          {
            foreach ($products as $key => $product) {
            $output.= '&nbsp'.'&nbsp'.'&nbsp'.'&nbsp'.'ยอดเงิน'.'&nbsp'.$product->totolsumall;
            // foreach ($products as $key => $product) {
            // $output.='<tr>'.
            // '<td>'.$product->po_number.'</td>'.
            // '<td>'.$product->totolsumall.'</td>'.
            // '</tr>';
            }
          return Response($output);
          }
          else {
            $output.= '&nbsp'.'&nbsp'.'&nbsp'.'&nbsp'.'ไม่มีข้อมูล';
          }
      }
    }

    public function config_ins(Request $request)
    {
        if ($request->get('get_emp') != null) {

          $emp_code = $request->get('get_emp');
          $name_materials = $request->get('name_material');
          $name_goods = $request->get('name_good');

          for ($i=0; $i < count($name_materials); $i++) {
            $ins_mat_ref_good = new Material_ref_good;
            $ins_mat_ref_good->setConnection('mysql2');
            $ins_mat_ref_good->id_material = $name_materials[$i];
            $ins_mat_ref_good->id_good = $name_goods[$i];
            $ins_mat_ref_good->emp_code = $emp_code;
            $ins_mat_ref_good->save();
          }

      SWAL::message('สำเร็จ', 'บันทึกการตั้งค่าแบบเหล็ก(ซื้อสำเร็จรูป)แล้ว!', 'success', ['timer' => 6000]);
      return redirect()->route('buysteel');
    }else {
      SWAL::message('บันทึกล้มเหลว', 'session หมดอายุให้กลับไป Log In !', 'warning', ['timer' => 6000]);
      return redirect()->route('fsctonline.com/fscthr/auth/default/index');
    }
    }


    public function store(Request $request)
    {
        if ($request->get('get_emp') != null) {
          // $code_branch = $request->get('branch');
          $count = DB::connection('mysql2')
                       ->table('receiptasset')
                       ->get();
          $count_num = count($count);

          $lot = $request->get('lotnumber');
          $datenowuse = $request->get('datenow');
          $emp_code = $request->get('get_emp');
          $po_number = $request->get('search');

          $search_po = DB::connection('mysql2')
      			->table('po_head')
            ->seLect('id as id_po')
      			->where('po_number','LIKE',$po_number)
      			->get();
          foreach ($search_po as $key => $search_pos) {
            $get_id_po = $search_pos->id_po;
          }

          $produce_unitforuse = $request->get('produce_unit');
          $total_produceforuse = $request->get('total_produce');
          $salaryforuse = $request->get('salary');
          $total_costforuse = $request->get('total_cost');
          $material_costforuse = $request->get('material_cost');
          $produceforuse = $request->get('produce');
          $name_materialforuse = $request->get('name_material');
          $total_produce_sums = $request->get('total_produce_sum');
          $cut_comma_total = str_replace(',', '', $total_produce_sums);


          $now = Carbon::now();
          $yearforuse = $now->year + 543;
          $monthforuse = $now->month;
          $dayforuse =$now->day;

          $ins_receiptasset = new Receiptasset;
          $ins_receiptasset->setConnection('mysql2');
          $ins_receiptasset->datein = $datenowuse;
          $ins_receiptasset->dateuse = $datenowuse;
          $ins_receiptasset->status = 0;
          $ins_receiptasset->emp_code = $emp_code;
          $ins_receiptasset->po_ref = $get_id_po;

          $ins_receiptasset->receiptnum = "RCT" . $yearforuse . $monthforuse . $dayforuse . sprintf('%05d', $count_num+1);
          $ins_receiptasset->save();

          $count_id = Receiptasset::max('id');
          for ($i=0; $i < count($name_materialforuse); $i++) {
            $ins_receiptasset_detail = new Receiptasset_detail;
            $ins_receiptasset_detail->setConnection('mysql2');
            $ins_receiptasset_detail->receiptasset_id = $count_id;
            $ins_receiptasset_detail->material_id = $name_materialforuse[$i];
            $ins_receiptasset_detail->lot = $lot;
            $ins_receiptasset_detail->produce = $produceforuse[$i];
            $ins_receiptasset_detail->cost = $material_costforuse[$i];
            $ins_receiptasset_detail->total_cost = $total_costforuse[$i];
            $ins_receiptasset_detail->saraly = 0;
            $ins_receiptasset_detail->total_cost_produce = $total_produceforuse[$i];
            $ins_receiptasset_detail->cost_produce_unit = $produce_unitforuse[$i];
            $ins_receiptasset_detail->totalall = $cut_comma_total;
            $ins_receiptasset_detail->save();
          }

      SWAL::message('สำเร็จ', 'บันทึกต้นทุนแบบเหล็ก(ซื้อสำเร็จรูป)แล้ว!', 'success', ['timer' => 6000]);
      return redirect()->route('buysteel');
    }else {
      SWAL::message('บันทึกล้มเหลว', 'session หมดอายุให้กลับไป Log In !', 'warning', ['timer' => 6000]);
      return redirect()->route('fsctonline.com/fscthr/auth/default/index');
    }
    }




    public function getmaterial()
    {
      $materials = DB::connection('mysql3')
          ->table('material')
          // ->select('in_debt.id as id_indebt','in_debt.number_debt','in_debt.accept','in_debt.branch_id','in_debt.discount'
          // ,'in_debt.vat','in_debt.vat_price','in_debt.id_typejournal','in_debt.datebill','po_detail.list','po_detail.note'
          // ,'accounttype.accounttypeno','accounttype.accounttypefull','po_detail.total','accounttype.config_group_supp_id','good.name'
          // ,'accounttype.id as id_accounttype','po_head.supplier_id')
          // ->select('group_property.id as id_group','group_property.number_property','group_property.descritption_thai','group_property.descritption_eng','accounttype.accounttypeno','accounttype.accounttypefull')
          ->seLect('id','name')
          // ->join('accounttype', 'accounttype.id', '=', 'group_property.accounttype_no')
          ->orderBy('name', 'asc')
          ->where('status',1)
          ->get();

      return $materials;
    }

    public function config_getmaterial()
    {
      $materials = DB::connection('mysql3')
          ->table('material')
          ->seLect('id','name')
          ->orderBy('name', 'asc')
          ->where('status',1)
          ->get();

      return $materials;
    }
    public function config_getgood()
    {
      $goods = DB::connection('mysql2')
          ->table('good')
          ->seLect('id','name')
          ->orderBy('name', 'asc')
          ->where('status',1)
          ->get();

      return $goods;
    }

}
