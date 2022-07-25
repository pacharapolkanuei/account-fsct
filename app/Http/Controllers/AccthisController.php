<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use DB;

class AccthisController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    /*function getData()
    {
      $data = DB::table('detail_acc')->get();

      return view('accbook/income_pay_book',['datashow'=>$data]);
      //
      // echo "<pre>";
      // print_r($data['data']);
      // exit;
    } */

    function index()
    {
     return view('accbook/income_pay_book');
    }

    function fetch_data(Request $request)
    {
     if($request->ajax())
     {
      if($request->from_date != '' && $request->to_date != '')
      {
       $data = DB::table('detail_acc')
         ->whereBetween('date', array($request->from_date, $request->to_date))
         ->get();
      }
      else
      {
       $data = DB::table('detail_acc')->orderBy('date', 'desc')->get();
      }
      echo json_encode($data);
     }
    }

}
