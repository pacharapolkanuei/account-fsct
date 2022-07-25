<?php

namespace App\Http\Controllers;

use App\Ledger;
use Illuminate\Http\Request;
use App\Journal;
use App\Accounttype;
use App\Po_head;
use DB;
use Softon\SweetAlert\Facades\SWAL;

use App\Api\Connectdb;
use Session;
use App\Api\Datetime;
use Illuminate\Support\Facades\Input;
use phpDocumentor\Reflection\Types\Null_;
use Redirect;

class Working_papersController extends Controller
{

    public function working_papers(){ //กระดาษทำการ 10 ช่อง (รายสาขา)

        return view('working_papers');

    }

    public function working_allpapers(){ //กระดาษทำการ 10 ช่อง (ทั้งหมด)

        return view('working_allpapers');

    }

    public function serachworking_papers(){ //กระดาษทำการ 10 ช่อง (รายสาขา)

        $data = Input::all();
        $db = Connectdb::Databaseall();
        // echo "<pre>";
        // print_r($data);
        // exit;

        $datepicker = explode("-",trim(($data['reservation'])));

          // $start_date = $datepicker[0];
          $e1 = explode("/",trim(($datepicker[0])));
                  if(count($e1) > 0) {
                      $start_date = $e1[2] . '-' . $e1[0] . '-' . $e1[1]." 00:00:00"; //ปี - เดือน - วัน
                  }

          // $end_date = $datepicker[1];
          $e2 = explode("/",trim(($datepicker[1])));
                  if(count($e2) > 0) {
                      $end_date = $e2[2] . '-' . $e2[0] . '-' . $e2[1]." 23:59:59"; //ปี - เดือน - วัน
                  }

        $branch_id = $data['branch_id'];
        // $acc_code = $data['acc_code'];

        $sql = 'SELECT '.$db['fsctaccount'].'.accounttype.*
                FROM '.$db['fsctaccount'].'.accounttype

                WHERE '.$db['fsctaccount'].'.accounttype.status != 99
                  ';
        $datatresult = DB::connection('mysql')->select($sql);
        // echo "<pre>";
        // print_r($datatresult);
        // exit;

        return view('working_papers',[
          'data'=>$datatresult,
          'query'=>true,
          'datepicker'=>$data['reservation'],
          'branch_id'=>$branch_id
          // 'accontcode'=>$acc_code,
        //   'datepicker2'=>$datetime
        ]);

    }


    public function serachworking_allpapers(){ //กระดาษทำการ 10 ช่อง (ทั้งหมด)

        $data = Input::all();
        $db = Connectdb::Databaseall();
        // echo "<pre>";
        // print_r($data);
        // exit;

        $datepicker = explode("-",trim(($data['reservation'])));

          // $start_date = $datepicker[0];
          $e1 = explode("/",trim(($datepicker[0])));
                  if(count($e1) > 0) {
                      $start_date = $e1[2] . '-' . $e1[0] . '-' . $e1[1]." 00:00:00"; //ปี - เดือน - วัน
                  }

          // $end_date = $datepicker[1];
          $e2 = explode("/",trim(($datepicker[1])));
                  if(count($e2) > 0) {
                      $end_date = $e2[2] . '-' . $e2[0] . '-' . $e2[1]." 23:59:59"; //ปี - เดือน - วัน
                  }

        // $branch_id = $data['branch_id'];
        // $acc_code = $data['acc_code'];

        $sql = 'SELECT '.$db['fsctaccount'].'.accounttype.*
                FROM '.$db['fsctaccount'].'.accounttype

                WHERE '.$db['fsctaccount'].'.accounttype.status != 99
                  ';
        $datatresult = DB::connection('mysql')->select($sql);
        // echo "<pre>";
        // print_r($datatresult);
        // exit;

        return view('working_allpapers',[
          'data'=>$datatresult,
          'query'=>true,
          'datepicker'=>$data['reservation']
          // 'branch_id'=>$branch_id
          // 'accontcode'=>$acc_code,
        //   'datepicker2'=>$datetime
        ]);

    }





}
