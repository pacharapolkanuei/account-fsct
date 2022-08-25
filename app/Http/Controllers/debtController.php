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
use App\Branch;
use App\Po;
use App\Po_detail;
use App\Debt;
use App\Listindebt;
use Softon\SweetAlert\Facades\SWAL;
use PDF;

class debtController extends Controller
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

		return view('debt.debt', compact('branchs', 'lists' , 'list_suppliers'));
	}

	public function pdf($id_indebt)
	{
		$report_debts = DB::connection('mysql2')
			->table('in_debt')
			->join('po_detail', 'in_debt.id_po', '=', 'po_detail.po_headid')
			->join('supplier', 'in_debt.supplier_id', '=', 'supplier.id')
			->where('in_debt.id', $id_indebt)
			->get();
		// dd($report_debts);
		$pdf = PDF::loadView('debt.debtpdf', ['report_debts' => $report_debts]);
		return @$pdf->stream();
	}

	public function pdfsupplier($id_indebtsupplier)
	{
		$report_debtsuppliers = DB::connection('mysql2')
			->table('in_debt')
			->join('supplier', 'in_debt.supplier_id', '=', 'supplier.id')
			->join('po_detail', 'in_debt.id_po', '=', 'po_detail.po_headid')
			->where('in_debt.supplier_id', $id_indebtsupplier)
			->get();
		// dd($report_debts);
		// exit;
		$pdf = PDF::loadView('debt.debtpdfsupplier', ['report_debtsuppliers' => $report_debtsuppliers]);
		return @$pdf->stream();
	}

	public function debtconfirm(Request $request)
	{
				$number_bill_rentenginez = $request->get('indebt_number');

				DB::connection('mysql2')
				->table('in_debt')->whereIn('number_debt',$number_bill_rentenginez)
				->update(['status_tranfer' => 1]);

				SWAL::message('สำเร็จ', 'ได้บันทึกรายการว่าโอนแล้ว!', 'success', ['timer' => 6000]);
				return redirect()->route('debt');

	}

	function getbranch($branchcode)
	{
		$connect = Connectdb::Databaseall();
		$baseAc1 = $connect['fsctaccount'];

		$start = "2020-01-01";
	  $end = "2022-12-31";

		$get_po_num = new Po;
		$get_po_num->setConnection('mysql2');
		$get_po_num = Po::where('branch_id', $branchcode)
						->where('type_po', 1)
						->where('status_head','=',1)
						->where('date', '>=', $start)
						->where('date', '<=', $end)
						->get();
		return $get_po_num;

		// $sql = "SELECT * FROM $baseAc.po_head
		//
		//                 WHERE $baseAc.po_head.type_po = 1 AND $baseAc.po_head.status_head = 1 AND $baseAc.po_head.branch_id = $branchcode";
		//
		// $get_po_num = DB::select($sql);
		// return $get_po_num;
	}

	function getterm($po_id)
	{

		$po = Po::find($po_id);

		return $po;
	}

	function getpodetail($po_id)
	{
		$po_detail = new Po_detail;
		$po_detail->setConnection('mysql2');
		$po_detail = Po_detail::where('po_headid', $po_id)
			->where('statususe', 1)
			->get();

		return $po_detail;
	}


	public function store(DebtRequest $request)
	{
		$get_branch = $request->get('branch_id');
		$count = DB::connection('mysql2')
			->table('in_debt')
			->where('branch_id','=',$get_branch)
			->get();
		$count_debt = count($count) + 1;

		// ทำการ insert การตั้งหนี้(debt)ลงใน table in_debt
		$debt = new Debt;
		$debt->setConnection('mysql2');
		$debt->bill_no = $request->get('bill_no');
		$debt->vat_price = $request->get('net_amount');
		$debt->id_po = $request->get('po_no');
		$debt->datebill = $request->get('datebill');
		$debt->branch_id = $request->get('branch_id');
		$debt->vat = $request->get('vat');
		$debt->discount = $request->get('discount');

		for ($i=1001; $i <= 1050 ; $i++) {
			if ($request->get('branch_id') == $i) {
				$debt->number_debt = "AP" . $i . date("ym") . sprintf('%04d', $count_debt);
			}
		}

		$debt->supplier_id = $request->get('supplie_id');

		if ($request->hasFile('inform_po_picture')) {
			$image_filename = $request->file('inform_po_picture')->getClientOriginalName();
			$image_name = date("Ymd-His-") . $image_filename;
			$public_path = 'images/inform_po_picture/';
			$destination = base_path() . "/public/" . $public_path;
			$request->file('inform_po_picture')->move($destination, $image_name);
			$debt->inform_po_picture = $public_path . $image_name;
		}
		// dd($debt);
		// exit;
		$debt->save();

		//แก้ไข เครดิตครบกำหนด จากหน้าการตั้งหนี้ debt.blade
		$credit = $request->get('credit');
		$vat = $request->get('vat');
		$id_po = $request->get('id_po');

		$po = Po::find($id_po);
		$po->terms = $credit;
		$po->vat = $vat;

		$po->update();


		$count_list = $request->get('count_list'); //จำนวนรายการ
		for ($i = 1; $i <=  $count_list; $i++) {

			$id = $request->get('id' . $i . '');
			$amount = $request->get('amount' . $i . '');
			$price = $request->get('price' . $i . '');

			$po_detail = Po_detail::find($id);
			$po_detail->amount = $amount;
			$po_detail->price = $price;
			$po_detail->total = $price * $amount;

			$po_detail->update();

			$save_po_number = $request->get('po_no');

			$connect1 = Connectdb::Databaseall();
	    $baseAc1 = $connect1['fsctaccount'];
	    $baseHr1 = $connect1['hr_base'];

	    $sql1 = "UPDATE $baseAc1.po_head
	             SET $baseAc1.po_head.status_head = '3'
	             WHERE $baseAc1.po_head.id IN($save_po_number)";
	    $sql_finish1 = DB::select($sql1);
		}


		$id = $request->get('id');
		// dd($count_list);

		SWAL::message('สำเร็จ', 'บันทึกการตั้งหนี้เรียบร้อย!', 'success', ['timer' => 6000]);

		return redirect()->route('debt');
	}
}
