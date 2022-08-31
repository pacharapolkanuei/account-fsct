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
		return view('AccountsPayable.ap_list');
	}

	function index_ap_list_summary()
	{
		return view('AccountsPayable.ap_list_summary');
	}


	function index_ap_list_showdateexpire()
	{
		return view('AccountsPayable.ap_list_showdateexpire');
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
          ->select('supplier.pre','supplier.name_supplier','po_head.date as date_po','po_head.status_head','inform_po.datebill as date_inform_po','inform_po.status','po_head.po_number as po_number_use')
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


	public function  ap_list_summary_filters(Request $request)
	{
			$connect1 = Connectdb::Databaseall();
			$baseAc1 = $connect1['fsctaccount'];
			$baseHr1 = $connect1['hr_base'];

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

			$sql = "SELECT	SUM(po_head.totolsumreal) as totalsumreal2
											,supplier.pre
											,supplier.name_supplier
											,supplier.codecreditor

											FROM $baseAc1.supplier

											INNER JOIN $baseAc1.supplier_terms
											ON $baseAc1.supplier.terms_id = $baseAc1.supplier_terms.id

											INNER JOIN $baseAc1.po_head
											ON $baseAc1.supplier.id = $baseAc1.po_head.supplier_id

											-- INNER JOIN $baseAc1.inform_po
											-- ON $baseAc1.po_head.id = $baseAc1.inform_po.id_po

											WHERE $baseAc1.po_head.date BETWEEN '2020-01-01 00:00:01' AND '2020-12-31 23:59:59'
											AND $baseAc1.po_head.status_head = 2
											GROUP BY $baseAc1.supplier.name_supplier";

				$supplier_aps = DB::select($sql);

				// dd($supplier_aps);
				// exit;
				// $ap = 'default';


			// $supplier_aps = DB::connection('mysql2')
			// 		->table('supplier')
			// 		->select('supplier.pre','supplier.name_supplier','po_head.date as date_po','po_head.status_head','inform_po.datebill as date_inform_po','inform_po.status','po_head.po_number as po_number_use')
			// 		->join('supplier_terms', 'supplier_terms.id', '=', 'supplier.terms_id')
			// 		->join('po_head', 'po_head.supplier_id', '=', 'supplier.id')
			// 		->join('inform_po', 'inform_po.id_po', '=', 'po_head.id')
			// 		// ->orderBy('inform_po.id', 'asc')
			// 		->whereBetween('po_head.date', [$start.'%', $end.'%'])
			// 		// ->where('inform_po.type',2)
			// 		->where('po_head.status_head',2)
			// 		// ->where('inform_po.type_newtable',1)
			// 		->get();
			//
			// $ap = 'default';
			//
			// $supplier_informs = DB::connection('mysql2')
			// 		->table('supplier')
			// 		->select('supplier.pre','supplier.name_supplier','po_head.date as date_po','inform_po.datebill as date_inform_po','inform_po.status')
			// 		->join('supplier_terms', 'supplier_terms.id', '=', 'supplier.terms_id')
			// 		->join('po_head', 'po_head.supplier_id', '=', 'supplier.id')
			// 		->join('inform_po', 'inform_po.id_po', '=', 'po_head.id')
			// 		// ->orderBy('inform_po.id', 'asc')
			// 		->whereBetween('inform_po.datebill', [$start.'%', $end.'%'])
			// 		// ->where('inform_po.type',2)
			// 		->where('inform_po.status',1)
			// 		// ->where('inform_po.type_newtable',1)
			// 		->get();

			return view('AccountsPayable.ap_list_summary', compact('supplier_aps', 'start' , 'end'));
	}




}
