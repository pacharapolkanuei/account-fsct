<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Api\Connectdb;

use App\Pprdetail;
use DB;
use Illuminate\Support\Facades\Input;
use phpDocumentor\Reflection\Types\Null_;
use Session;
use App\Api\Datetime;
use Redirect;

class ReportvatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     // function index(){
     //
     // 	$branchs = new Debt;
     // 	$branchs->setConnection('hr_base');
     // 	$branchs = Debt::get();
     //
     //
     //  return view('debt.debt',compact('branchs'));
     // }

     public function reporttaxbuywaituse(){ //รายงานเจ้าหนี้การค้า (ค้างจ่าย)

            return view('reporttaxbuywaituse');
     }

     public function serachreporttaxbuywaituse(){
           $data = Input::all();
           $db = Connectdb::Databaseall();
           $branch_id = $data['branch_id'];
           // print_r($data);
           // exit;
           $data = $data;

           return view('reporttaxbuywaituse',['data'=>$data,'query'=>true,'branch_id'=>$branch_id]);
     }

     public function savebuyvatwaituse(){
           $data = Input::all();
           $db = Connectdb::Databaseall();

           print_r($data);
           exit;
     }


}
