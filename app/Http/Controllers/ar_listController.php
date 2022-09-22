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

class ar_listController extends Controller
{

	use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

	function index()
	{
		return view('Accar.ar_list');
	}



	function arlist_serch(){
		 		$data = Input::all();

				// print_r($data);
				$daterange = $data['daterange'];
				$customerid = $data['customerid'];
				$query = true;
		 return view('Accar.ar_list',  compact('daterange' , 'customerid' ,  'query'));

	}

	function ar_list_summary(){

			return view('Accar.ar_list_summary');
	}

	function arlistsummary_serch()
	{
		$data = Input::all();

		// print_r($data);
		$dateend = $data['dateend'];
		$customerid = $data['customerid'];
		$query = true;
 		return view('Accar.ar_list_summary',  compact('dateend' , 'customerid' ,  'query'));

	}

	function ar_list_showdateexpire()
	{
		return view('Accar.ar_list_showdateexpire');
	}

	function ar_list_showdateexpire_serch()
	{
		$data = Input::all();

		// print_r($data);
		$dateend = $data['dateend'];
		$customerid = $data['customerid'];
		$query = true;
		return view('Accar.ar_list_showdateexpire',  compact('dateend' , 'customerid' ,  'query'));

	}

}
