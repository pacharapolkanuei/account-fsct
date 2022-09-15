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
use App\Supplier;
use App\Po;
use App\Po_detail;
use App\Debt;
use App\Listindebt;
use Softon\SweetAlert\Facades\SWAL;
use Illuminate\Support\Facades\Input;
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
		$connect1 = Connectdb::Databaseall();
		$baseAc1 = $connect1['fsctaccount'];

		$sql = "SELECT supplier.id as id_supplier_ref
														,supplier.pre as pre1
														,supplier.name_supplier as name1
														,supplier.type_pay

										FROM $baseAc1.supplier

										ORDER BY $baseAc1.supplier.pre ASC ";

		$datas = DB::select($sql);

		return view('AccountsPayable.ap_list_summary', compact( 'datas' ));
	}


	function index_ap_list_showdateexpire()
	{
		$connect1 = Connectdb::Databaseall();
		$baseAc1 = $connect1['fsctaccount'];

		$sql = "SELECT supplier.id as id_supplier_ref
														,supplier.pre as pre1
														,supplier.name_supplier as name1
														,supplier.type_pay

										FROM $baseAc1.supplier

										ORDER BY $baseAc1.supplier.pre ASC ";

		$datas = DB::select($sql);

		return view('AccountsPayable.ap_list_showdateexpire', compact( 'datas' ));
	}

	function index_supplier_pay_type()
	{
		$connect1 = Connectdb::Databaseall();
		$baseAc1 = $connect1['fsctaccount'];
		$basemain1 = $connect1['fsctmain'];
		$baseHr1 = $connect1['hr_base'];

		$sql = "SELECT supplier.id as id_supplier_ref
														,supplier.pre
														,supplier.name_supplier
														,supplier.address
														,supplier.district
														,supplier.amphur
														,supplier.province
														,supplier.zipcode
														,supplier.type_pay

										FROM $baseAc1.supplier

										WHERE $baseAc1.supplier.status = 1
										ORDER BY $baseAc1.supplier.pre ASC ";

		$datas = DB::select($sql);

		$sql1 = "SELECT supplier.id as id_supplier_ref
														,supplier.pre
														,supplier.name_supplier
														,supplier.address
														,supplier.district
														,supplier.amphur
														,supplier.province
														,supplier.zipcode
														,supplier.type_pay

										FROM $baseAc1.supplier

										WHERE $baseAc1.supplier.status = 2
										ORDER BY $baseAc1.supplier.pre ASC ";

		$datas1 = DB::select($sql1);

		return view('supplier_pay_type', compact('datas','datas1'));
	}




  public function  ap_list_filters(Request $request)
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

			$sql = "SELECT	po_head.totolsumreal as totalsum
											,supplier.pre
											,supplier.name_supplier
											,supplier.codecreditor
											-- ,supplier_terms.day
											,po_head.date as date_po
											,inform_po.datebill as date_inform_po
											,po_head.po_number as po_number_use
											,inform_po.payser_number as payser_number_use
											,inform_po.payout

											FROM $baseAc1.supplier

											-- INNER JOIN $baseAc1.supplier_terms
											-- ON $baseAc1.supplier.terms_id = $baseAc1.supplier_terms.id

											INNER JOIN $baseAc1.po_head
											ON $baseAc1.supplier.id = $baseAc1.po_head.supplier_id

											LEFT JOIN $baseAc1.inform_po
											ON $baseAc1.po_head.id = $baseAc1.inform_po.id_po

											WHERE $baseAc1.po_head.date BETWEEN '$start' AND '$end'
											AND $baseAc1.po_head.status_head IN ('2','3','4','5')
											-- AND $baseAc1.supplier_terms.day >= 1
											-- ORDER BY $baseAc1.supplier.name_supplier ASC";

				$supplier_aps = DB::select($sql);
				 // echo '<pre>';
				 // var_dump($supplier_aps);
				 // echo '</pre>';
				// exit;
				$ap = 'default';

      // $supplier_aps = DB::connection('mysql2')
      //     ->table('supplier')
      //     ->select('supplier.pre','supplier.name_supplier','po_head.date as date_po','po_head.status_head','inform_po.datebill as date_inform_po','inform_po.status','po_head.po_number as po_number_use')
      //     ->join('supplier_terms', 'supplier_terms.id', '=', 'supplier.terms_id')
      //     ->join('po_head', 'po_head.supplier_id', '=', 'supplier.id')
      //     ->join('inform_po', 'inform_po.id_po', '=', 'po_head.id')
      //     // ->orderBy('inform_po.id', 'asc')
      //     ->whereBetween('po_head.date', [$start.'%', $end.'%'])
      //     // ->where('inform_po.type',2)
      //     ->where('po_head.status_head',2)
      //     // ->where('inform_po.type_newtable',1)
      //     ->get();
			//
      // $ap = 'default';
			//
      // $supplier_informs = DB::connection('mysql2')
      //     ->table('supplier')
      //     ->select('supplier.pre','supplier.name_supplier','po_head.date as date_po','inform_po.datebill as date_inform_po','inform_po.status')
      //     ->join('supplier_terms', 'supplier_terms.id', '=', 'supplier.terms_id')
      //     ->join('po_head', 'po_head.supplier_id', '=', 'supplier.id')
      //     ->join('inform_po', 'inform_po.id_po', '=', 'po_head.id')
      //     // ->orderBy('inform_po.id', 'asc')
      //     ->whereBetween('inform_po.datebill', [$start.'%', $end.'%'])
      //     // ->where('inform_po.type',2)
      //     ->where('inform_po.status',1)
      //     // ->where('inform_po.type_newtable',1)
      //     ->get();

      return view('AccountsPayable.ap_list', compact('supplier_aps', 'supplier_informs', 'start' , 'end','ap'));
  }


	public function  ap_list_summary_filters(Request $request)
	{
			$data = Input::all();

			$connect1 = Connectdb::Databaseall();
			$baseAc1 = $connect1['fsctaccount'];
			$baseHr1 = $connect1['hr_base'];

			$dateend = $request->get('dateend');
			$start1 = "2022-01-01";

			if (isset($data['ap_list'])) {
			$select_ap1 = $data['ap_list'];
			$comma_separated = implode(',', $select_ap1);

			$sql = "SELECT	SUM(po_head.totolsumreal) as totalsumreal2
											,supplier.pre
											,supplier.name_supplier
											,supplier.codecreditor

											FROM $baseAc1.supplier

											INNER JOIN $baseAc1.supplier_terms
											ON $baseAc1.supplier.terms_id = $baseAc1.supplier_terms.id

											INNER JOIN $baseAc1.po_head
											ON $baseAc1.supplier.id = $baseAc1.po_head.supplier_id

											WHERE $baseAc1.po_head.date BETWEEN '$start1' AND '$dateend'
											AND $baseAc1.po_head.status_head = 2
											AND $baseAc1.supplier.id IN ($comma_separated)
											GROUP BY $baseAc1.supplier.name_supplier
											ORDER BY $baseAc1.supplier.pre ASC";

				$supplier_aps = DB::select($sql);
			}else {
				$sql = "SELECT	SUM(po_head.totolsumreal) as totalsumreal2
												,supplier.pre
												,supplier.name_supplier
												,supplier.codecreditor

												FROM $baseAc1.supplier

												INNER JOIN $baseAc1.supplier_terms
												ON $baseAc1.supplier.terms_id = $baseAc1.supplier_terms.id

												INNER JOIN $baseAc1.po_head
												ON $baseAc1.supplier.id = $baseAc1.po_head.supplier_id

												WHERE $baseAc1.po_head.date BETWEEN '$start1' AND '$dateend'
												AND $baseAc1.po_head.status_head = 2
												GROUP BY $baseAc1.supplier.name_supplier
												ORDER BY $baseAc1.supplier.pre ASC";

					$supplier_aps = DB::select($sql);
			}

			return view('AccountsPayable.ap_list_summary', compact('supplier_aps', 'start' , 'dateend' , 'date'));
	}

	public function  ap_list_showdateexpire_filters(Request $request)
	{
			$connect1 = Connectdb::Databaseall();
			$baseAc1 = $connect1['fsctaccount'];
			$baseHr1 = $connect1['hr_base'];

			$start = "2022-01-01";
			$dateend = $request->get('dateend');

			if (isset($data['ap_list'])) {
			$select_ap1 = $data['ap_list'];
			$comma_separated = implode(',', $select_ap1);
			$sql = "SELECT	po_head.totolsumreal as totalsum
											,supplier.pre
											,supplier.name_supplier
											,supplier.codecreditor
											,po_head.date as date_to_cal
											,supplier_terms.day as day_tocal
											,supplier.id as supplier_id
											FROM $baseAc1.supplier

											INNER JOIN $baseAc1.supplier_terms
											ON $baseAc1.supplier.terms_id = $baseAc1.supplier_terms.id

											INNER JOIN $baseAc1.po_head
											ON $baseAc1.supplier.id = $baseAc1.po_head.supplier_id

											WHERE $baseAc1.po_head.date BETWEEN '$start' AND '$dateend'
											AND $baseAc1.supplier.id IN ($comma_separated)
											AND $baseAc1.po_head.status_head = 2
											-- AND $baseAc1.supplier_terms.day >= 1

											ORDER BY $baseAc1.supplier_terms.day DESC";

				$supplier_aps = DB::select($sql);
				$ap = 'default';
				// echo "<pre>";
				$arrNewData = [];
				foreach ($supplier_aps as $key => $value) {
						$arrNewData[$value->supplier_id]['supplier_id']=$value->supplier_id;
						$arrNewData[$value->supplier_id]['totalsum'][$key]=$value->totalsum;
						$arrNewData[$value->supplier_id]['pre']=$value->pre;
						$arrNewData[$value->supplier_id]['name_supplier']=$value->name_supplier;
						$arrNewData[$value->supplier_id]['codecreditor']=$value->codecreditor;
						// $arrNewData[$value->supplier_id]['date_to_cal'][$key]=$value->date_to_cal;
						// $arrNewData[$value->supplier_id]['day_tocal'][$key]=$value->day_tocal;


						//////////////////////////////////////////////////////////////////////////
						$dateset = strtotime($value->date_to_cal);
						$termsdays = $value->day_tocal;
						$datedue = strtotime("+$termsdays day", $dateset);
						$datedue = date('Y-m-d', $datedue);
						$value->supplier_id.'===>';
						$date1 = date_create($dateend);
						$date2 = date_create($datedue);
						$diff = date_diff($date1,$date2);

						if($diff->format("%R%a days")>60){
									// echo "มากกว่า 60=>".$diff->format("%R%a days");
									$arrNewData[$value->supplier_id]['daterang1'][$key]=$value->totalsum;
						}else if( $diff->format("%R%a days") > 30 && $diff->format("%R%a days") <= 60 ){
									// echo "ช่วง 30-60=>".$diff->format("%R%a days");
									$arrNewData[$value->supplier_id]['daterang2'][$key]=$value->totalsum;
						}else if( $diff->format("%R%a days") > 15 && $diff->format("%R%a days") <= 30 ){
									// echo "ช่วง 15-30=>".$diff->format("%R%a days");
									$arrNewData[$value->supplier_id]['daterang3'][$key]=$value->totalsum;
						}else if( $diff->format("%R%a days") >= 0 && $diff->format("%R%a days") <= 15 ){
									// echo "ช่วง 0-15=>".$diff->format("%R%a days");
									$arrNewData[$value->supplier_id]['daterang4'][$key]=$value->totalsum;
						}else if( $diff->format("%R%a days") >= -7 && $diff->format("%R%a days") < 0 ){
									// echo "เกิน 0-7=>".$diff->format("%R%a days");
									$arrNewData[$value->supplier_id]['daterang5'][$key]=$value->totalsum;
						}else if( $diff->format("%R%a days") >= -15 && $diff->format("%R%a days") <= -8 ){
									// echo "เกิน 8-15=>".$diff->format("%R%a days");
									$arrNewData[$value->supplier_id]['daterang6'][$key]=$value->totalsum;
						}else if( $diff->format("%R%a days") >= -30 && $diff->format("%R%a days") <= -16 ){
									// echo "เกิน 16-30=>".$diff->format("%R%a days");
									$arrNewData[$value->supplier_id]['daterang7'][$key]=$value->totalsum;
						}else{
									// echo "เกิน 30=>".$diff->format("%R%a days");
									$arrNewData[$value->supplier_id]['daterang8'][$key]=$value->totalsum;
						}

					//////////////////////////////////////////////////////////////////////////

				}


				$arrShow = [];
						foreach ($arrNewData as $k => $v) {
											$arrShow[$k]['codecreditor']=$v['codecreditor'];
											$arrShow[$k]['supplier_id']=$v['supplier_id'];
											$arrShow[$k]['pre']=$v['pre'];
											$arrShow[$k]['name_supplier']=$v['name_supplier'];
											$totalsum = 0;
											foreach ($v['totalsum'] as $a => $b) {
												$totalsum = $totalsum + $b;
											}
											$arrShow[$k]['totalsum'] = $totalsum;

											////////////////////////////////
											$totalrage1 = 0;
											if(!empty($v['daterang1'])){
													foreach ($v['daterang1'] as $c => $d) {
													 	 $totalrage1 = $totalrage1 + $d;
													}
											}else{
													$totalrage1 = 0;
											}
											$arrShow[$k]['daterang1']=$totalrage1;
											////////////////////////////////

											////////////////////////////////
											$totalrage2 = 0;
											if(!empty($v['daterang2'])){
													foreach ($v['daterang2'] as $e => $f) {
														 $totalrage2 = $totalrage2 + $f;
													}
											}else{
													$totalrage2 = 0;
											}
											$arrShow[$k]['daterang2']=$totalrage2;
											////////////////////////////////

											////////////////////////////////
											$totalrage3 = 0;
											if(!empty($v['daterang3'])){
													foreach ($v['daterang3'] as $g => $h) {
														 $totalrage3 = $totalrage3 + $h;
													}
											}else{
													$totalrage3 = 0;
											}
											$arrShow[$k]['daterang3']=$totalrage3;
											////////////////////////////////

											////////////////////////////////
											$totalrage4 = 0;
											if(!empty($v['daterang4'])){
													foreach ($v['daterang4'] as $i => $j) {
														 $totalrage4 = $totalrage4 + $j;
													}
											}else{
													$totalrage4 = 0;
											}
											$arrShow[$k]['daterang4']=$totalrage4;
											////////////////////////////////

											////////////////////////////////
											$totalrage5 = 0;
											if(!empty($v['daterang5'])){
													foreach ($v['daterang5'] as $k => $l) {
														 $totalrage5 = $totalrage5 + $l;
													}
											}else{
													$totalrage5 = 0;
											}
											$arrShow[$k]['daterang5']=$totalrage5;
											////////////////////////////////

											////////////////////////////////
											$totalrage6 = 0;
											if(!empty($v['daterang6'])){
													foreach ($v['daterang6'] as $m => $n) {
														 $totalrage6 = $totalrage6 + $n;
													}
											}else{
													$totalrage6 = 0;
											}
											$arrShow[$k]['daterang6']=$totalrage6;
											////////////////////////////////

											////////////////////////////////
											$totalrage7 = 0;
											if(!empty($v['daterang7'])){
													foreach ($v['daterang7'] as $o => $p) {
														 $totalrage7 = $totalrage7 + $p;
													}
											}else{
													$totalrage7 = 0;
											}
											$arrShow[$k]['daterang7']=$totalrage7;
											////////////////////////////////

											////////////////////////////////
											$daterang8 = 0;
											if(!empty($v['daterang8'])){
													foreach ($v['daterang8'] as $q => $r) {
														 $daterang8 = $daterang8 + $r;
													}
											}else{
													$daterang8 = 0;
											}
											$arrShow[$k]['daterang8']=$daterang8;
						}
					}else {
						$sql = "SELECT	po_head.totolsumreal as totalsum
														,supplier.pre
														,supplier.name_supplier
														,supplier.codecreditor
														,po_head.date as date_to_cal
														,supplier_terms.day as day_tocal
														,supplier.id as supplier_id
														FROM $baseAc1.supplier

														INNER JOIN $baseAc1.supplier_terms
														ON $baseAc1.supplier.terms_id = $baseAc1.supplier_terms.id

														INNER JOIN $baseAc1.po_head
														ON $baseAc1.supplier.id = $baseAc1.po_head.supplier_id

														WHERE $baseAc1.po_head.date BETWEEN '$start' AND '$dateend'
														AND $baseAc1.po_head.status_head = 2
														-- AND $baseAc1.supplier_terms.day >= 1

														ORDER BY $baseAc1.supplier_terms.day DESC";

							$supplier_aps = DB::select($sql);
							$ap = 'default';
							// echo "<pre>";
							$arrNewData = [];
							foreach ($supplier_aps as $key => $value) {
									$arrNewData[$value->supplier_id]['supplier_id']=$value->supplier_id;
									$arrNewData[$value->supplier_id]['totalsum'][$key]=$value->totalsum;
									$arrNewData[$value->supplier_id]['pre']=$value->pre;
									$arrNewData[$value->supplier_id]['name_supplier']=$value->name_supplier;
									$arrNewData[$value->supplier_id]['codecreditor']=$value->codecreditor;
									// $arrNewData[$value->supplier_id]['date_to_cal'][$key]=$value->date_to_cal;
									// $arrNewData[$value->supplier_id]['day_tocal'][$key]=$value->day_tocal;


									//////////////////////////////////////////////////////////////////////////
									$dateset = strtotime($value->date_to_cal);
									$termsdays = $value->day_tocal;
									$datedue = strtotime("+$termsdays day", $dateset);
									$datedue = date('Y-m-d', $datedue);
									$value->supplier_id.'===>';
									$date1 = date_create($dateend);
									$date2 = date_create($datedue);
									$diff = date_diff($date1,$date2);

									if($diff->format("%R%a days")>60){
												// echo "มากกว่า 60=>".$diff->format("%R%a days");
												$arrNewData[$value->supplier_id]['daterang1'][$key]=$value->totalsum;
									}else if( $diff->format("%R%a days") > 30 && $diff->format("%R%a days") <= 60 ){
												// echo "ช่วง 30-60=>".$diff->format("%R%a days");
												$arrNewData[$value->supplier_id]['daterang2'][$key]=$value->totalsum;
									}else if( $diff->format("%R%a days") > 15 && $diff->format("%R%a days") <= 30 ){
												// echo "ช่วง 15-30=>".$diff->format("%R%a days");
												$arrNewData[$value->supplier_id]['daterang3'][$key]=$value->totalsum;
									}else if( $diff->format("%R%a days") >= 0 && $diff->format("%R%a days") <= 15 ){
												// echo "ช่วง 0-15=>".$diff->format("%R%a days");
												$arrNewData[$value->supplier_id]['daterang4'][$key]=$value->totalsum;
									}else if( $diff->format("%R%a days") >= -7 && $diff->format("%R%a days") < 0 ){
												// echo "เกิน 0-7=>".$diff->format("%R%a days");
												$arrNewData[$value->supplier_id]['daterang5'][$key]=$value->totalsum;
									}else if( $diff->format("%R%a days") >= -15 && $diff->format("%R%a days") <= -8 ){
												// echo "เกิน 8-15=>".$diff->format("%R%a days");
												$arrNewData[$value->supplier_id]['daterang6'][$key]=$value->totalsum;
									}else if( $diff->format("%R%a days") >= -30 && $diff->format("%R%a days") <= -16 ){
												// echo "เกิน 16-30=>".$diff->format("%R%a days");
												$arrNewData[$value->supplier_id]['daterang7'][$key]=$value->totalsum;
									}else{
												// echo "เกิน 30=>".$diff->format("%R%a days");
												$arrNewData[$value->supplier_id]['daterang8'][$key]=$value->totalsum;
									}

								//////////////////////////////////////////////////////////////////////////

							}


							$arrShow = [];
									foreach ($arrNewData as $k => $v) {
														$arrShow[$k]['codecreditor']=$v['codecreditor'];
														$arrShow[$k]['supplier_id']=$v['supplier_id'];
														$arrShow[$k]['pre']=$v['pre'];
														$arrShow[$k]['name_supplier']=$v['name_supplier'];
														$totalsum = 0;
														foreach ($v['totalsum'] as $a => $b) {
															$totalsum = $totalsum + $b;
														}
														$arrShow[$k]['totalsum'] = $totalsum;

														////////////////////////////////
														$totalrage1 = 0;
														if(!empty($v['daterang1'])){
																foreach ($v['daterang1'] as $c => $d) {
																 	 $totalrage1 = $totalrage1 + $d;
																}
														}else{
																$totalrage1 = 0;
														}
														$arrShow[$k]['daterang1']=$totalrage1;
														////////////////////////////////

														////////////////////////////////
														$totalrage2 = 0;
														if(!empty($v['daterang2'])){
																foreach ($v['daterang2'] as $e => $f) {
																	 $totalrage2 = $totalrage2 + $f;
																}
														}else{
																$totalrage2 = 0;
														}
														$arrShow[$k]['daterang2']=$totalrage2;
														////////////////////////////////

														////////////////////////////////
														$totalrage3 = 0;
														if(!empty($v['daterang3'])){
																foreach ($v['daterang3'] as $g => $h) {
																	 $totalrage3 = $totalrage3 + $h;
																}
														}else{
																$totalrage3 = 0;
														}
														$arrShow[$k]['daterang3']=$totalrage3;
														////////////////////////////////

														////////////////////////////////
														$totalrage4 = 0;
														if(!empty($v['daterang4'])){
																foreach ($v['daterang4'] as $i => $j) {
																	 $totalrage4 = $totalrage4 + $j;
																}
														}else{
																$totalrage4 = 0;
														}
														$arrShow[$k]['daterang4']=$totalrage4;
														////////////////////////////////

														////////////////////////////////
														$totalrage5 = 0;
														if(!empty($v['daterang5'])){
																foreach ($v['daterang5'] as $k => $l) {
																	 $totalrage5 = $totalrage5 + $l;
																}
														}else{
																$totalrage5 = 0;
														}
														$arrShow[$k]['daterang5']=$totalrage5;
														////////////////////////////////

														////////////////////////////////
														$totalrage6 = 0;
														if(!empty($v['daterang6'])){
																foreach ($v['daterang6'] as $m => $n) {
																	 $totalrage6 = $totalrage6 + $n;
																}
														}else{
																$totalrage6 = 0;
														}
														$arrShow[$k]['daterang6']=$totalrage6;
														////////////////////////////////

														////////////////////////////////
														$totalrage7 = 0;
														if(!empty($v['daterang7'])){
																foreach ($v['daterang7'] as $o => $p) {
																	 $totalrage7 = $totalrage7 + $p;
																}
														}else{
																$totalrage7 = 0;
														}
														$arrShow[$k]['daterang7']=$totalrage7;
														////////////////////////////////

														////////////////////////////////
														$daterang8 = 0;
														if(!empty($v['daterang8'])){
																foreach ($v['daterang8'] as $q => $r) {
																	 $daterang8 = $daterang8 + $r;
																}
														}else{
																$daterang8 = 0;
														}
														$arrShow[$k]['daterang8']=$daterang8;
									}
					}
					dd($arrShow);
					exit;
				// // print_r($arrNewData);
				// // echo "<br>";
				// print_r($arrShow);
				//
				//
				// // dd($supplier_aps);
				// exit;
				// // $ap = 'default';
			return view('AccountsPayable.ap_list_showdateexpire', compact( 'dateend' , 'date' , 'ap' ,'arrShow'));
	}

	public function getdata_supplier_pay_type($id)
  {
    $connect1 = Connectdb::Databaseall();
    $baseAc1 = $connect1['fsctaccount'];
    $baseHr1 = $connect1['hr_base'];
    $basemain1 = $connect1['fsctmain'];

    $sql1 = "SELECT $baseAc1.supplier.*
                                    ,supplier.id

                    FROM $baseAc1.supplier

                    WHERE $baseAc1.supplier.id = $id";

      $getdatas = DB::select($sql1);
      return $getdatas;
  }

  public function supplier_pay_type_update(Request $request)
  {
    $get_id = $request->get('get_id');
    // dd($get_id);
    // exit;
    $property = Supplier::find($get_id);
    $property->type_pay = $request->get('type_pay');

    $property->update();
    SWAL::message('สำเร็จ', 'แก้ไขเรียบร้อย!', 'success', ['timer' => 6000]);
    return redirect()->route('supplier_pay_type');

  }


}
