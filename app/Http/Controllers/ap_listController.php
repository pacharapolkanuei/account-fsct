<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Http\Requests\DebtRequest;
use Illuminate\Http\Request;
use App\Api\Connectdb;
use DB;
use App\Api\Datetime;
use App\Branch;
use App\Po;
use App\Po_detail;
use App\Debt;
use App\Listindebt;
use Softon\SweetAlert\Facades\SWAL;
use PDF;

class ap_listController extends Controller
{

	use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

	function index()
	{

		$branchs = new Branch;
		$branchs->setConnection('hr_base');
		$branchs = Branch::get();

		// $s = DB::connection('mysql2')
		// 	->table('in_debt')
		// 	->join('po_detail', 'in_debt.id_po', '=', 'po_detail.po_headid')
		// 	->select('in_debt.bill_no', 'in_debt.datebill', 'po_detail.list', 'po_detail.amount', 'po_detail.price', 'po_detail.total')
		// 	->where('in_debt.status_pay',0)
		// 	->get();

		$lists = Debt::all();

		$connect = Connectdb::Databaseall();
		$baseAc = $connect['fsctaccount'];
		$sql = "SELECT $baseAc.in_debt.*
		                                ,supplier.pre
																		,supplier.name_supplier
																		,sum(in_debt.vat_price) as total_col

		                FROM $baseAc.in_debt

										INNER JOIN $baseAc.supplier
		                ON $baseAc.supplier.id = $baseAc.in_debt.supplier_id

										WHERE $baseAc.in_debt.status_pay = 0
		                GROUP BY $baseAc.in_debt.supplier_id";

		$list_suppliers = DB::select($sql);

		return view('AccountsPayable.ap_list');
    // compact('branchs', 'lists' , 'list_suppliers')
	}



  public function  ap_list_filters(Request $request)
  {
      $date = $request->get('daterange');
      // $branch = $request->get('branch');
      // echo $date;
      // exit;

      $dateset = Datetime::convertStartToEnd($date);
      $start = $dateset['start'];
      $end = $dateset['end'];
      // echo $start;
      // echo $end;
      // exit;
      $supplier_aps = DB::connection('mysql2')
          ->table('supplier')
          ->select('supplier.pre','supplier.name_supplier','po_head.date as date_po','po_head.status_head','inform_po.datebill as date_inform_po','inform_po.status',,'po_head.po_number as po_number_use')
          ->join('supplier_terms', 'supplier_terms.id', '=', 'supplier.terms_id')
          ->join('po_head', 'po_head.supplier_id', '=', 'supplier.id')
          ->join('inform_po', 'inform_po.id_po', '=', 'po_head.id')
          // ->orderBy('inform_po.id', 'asc')
          ->whereBetween('po_head.date', [$start.'%', $end.'%'])
          // ->where('inform_po.type',2)
          ->where('po_head.status_head',2)
          // ->where('inform_po.type_newtable',1)
          ->get();

      $ap = 'default';

      $supplier_informs = DB::connection('mysql2')
          ->table('supplier')
          ->select('supplier.pre','supplier.name_supplier','po_head.date as date_po','inform_po.datebill as date_inform_po','inform_po.status')
          ->join('supplier_terms', 'supplier_terms.id', '=', 'supplier.terms_id')
          ->join('po_head', 'po_head.supplier_id', '=', 'supplier.id')
          ->join('inform_po', 'inform_po.id_po', '=', 'po_head.id')
          // ->orderBy('inform_po.id', 'asc')
          ->whereBetween('inform_po.datebill', [$start.'%', $end.'%'])
          // ->where('inform_po.type',2)
          ->where('inform_po.status',1)
          // ->where('inform_po.type_newtable',1)
          ->get();

      return view('AccountsPayable.ap_list', compact('supplier_aps', 'supplier_informs', 'start' , 'end','ap'));
  }

}
