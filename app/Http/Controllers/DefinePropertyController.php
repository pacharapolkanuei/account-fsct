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
use App\Group_Property;
use App\Ledger;
use App\Type_journal;
use App\Accounttype;
use App\Api\Connectdb;
use Illuminate\Support\Facades\Input;
use Softon\SweetAlert\Facades\SWAL;
use App\Api\Datetime;


class DefinePropertyController extends Controller
{
  use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

  public function index()
  {
    $accounttypes = new Accounttype;
    $accounttypes->setConnection('mysql2');
    $accounttypes = Accounttype::where('status','=',1)
                  ->get();

    $propertys = DB::connection('mysql2')
        ->table('group_property')
        // ->select('in_debt.id as id_indebt','in_debt.number_debt','in_debt.accept','in_debt.branch_id','in_debt.discount'
        // ,'in_debt.vat','in_debt.vat_price','in_debt.id_typejournal','in_debt.datebill','po_detail.list','po_detail.note'
        // ,'accounttype.accounttypeno','accounttype.accounttypefull','po_detail.total','accounttype.config_group_supp_id','good.name'
        // ,'accounttype.id as id_accounttype','po_head.supplier_id')
        ->select('group_property.id as id_group','group_property.number_property','group_property.descritption_thai','group_property.descritption_eng','accounttype.accounttypeno','accounttype.accounttypefull')
        ->join('accounttype', 'accounttype.id', '=', 'group_property.accounttype_no')
        ->orderBy('group_property.id', 'asc')
        ->where('group_property.statususe',1)
        ->get();
    return view('assetlist.define_property' , compact( 'accounttypes' , 'propertys' ));
  }

  public function store(Group_PropertyRequest $request)
	{

		// ทำการ insert การตั้งหนี้(debt)ลงใน table in_debt
		$property = new Group_Property;
		$property->setConnection('mysql2');
		$property->number_property = $request->get('no_group');
		$property->descritption_thai = $request->get('des_thai');
		$property->descritption_eng = $request->get('des_eng');
		$property->accounttype_no = $request->get('acc_code');
		$property->debit = $request->get('debit');
		$property->credit = $request->get('credit');

		$property->save();

		SWAL::message('สำเร็จ', 'บันทึกกลุ่มบัญชีทรัพย์สิน!', 'success', ['timer' => 6000]);
		return redirect()->route('define_property');
	}

  public function getdefineproperty($id)
  {
    $connect1 = Connectdb::Databaseall();
    $baseAc1 = $connect1['fsctaccount'];
    $baseHr1 = $connect1['hr_base'];

    $sql1 = "SELECT $baseAc1.group_property.*
                                    ,accounttype.id

                    FROM $baseAc1.group_property

                    INNER JOIN $baseAc1.accounttype
                    ON $baseAc1.group_property.accounttype_no = $baseAc1.accounttype.id

                    WHERE $baseAc1.group_property.id = $id";

      $getdatas = DB::select($sql1);
      return $getdatas;
  }

  public function update(Request $request)
  {
    $get_id = $request->get('get_id');
    // dd($get_id);
    // exit;
    $property = Group_Property::find($get_id);
    $property->number_property = $request->get('no_group');
    $property->descritption_thai = $request->get('des_thai');
    $property->descritption_eng = $request->get('des_eng');
    $property->accounttype_no = $request->get('acc_code');
    $property->debit = $request->get('debit');
    $property->credit = $request->get('credit');

    $property->update();
    SWAL::message('สำเร็จ', 'แก้ไขเรียบร้อย!', 'success', ['timer' => 6000]);
    return redirect()->route('define_property');

  }


  public function delete($id)
  {
      $property = Group_Property::find($id);
      // dd($property);
      // exit;
      if ($property != null) {
          $property->statususe = '99';
          $property->update();
          return redirect()->route('define_property');
      }
  }

  // public function debtconfirm(Request $request)
  // {
  //       $number_bill_rentenginez = $request->get('indebt_number');
  //
  //       DB::connection('mysql2')
  //       ->table('in_debt')->whereIn('number_debt',$number_bill_rentenginez)
  //       ->update(['status_tranfer' => 1]);
  //
  //       SWAL::message('สำเร็จ', 'ได้บันทึกรายการว่าโอนแล้ว!', 'success', ['timer' => 6000]);
  //       return redirect()->route('debt');
  //
  // }

}
