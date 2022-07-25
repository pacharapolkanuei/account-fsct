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

class Trial_balanceController extends Controller
{

    public function trial_balance(){ //งบทดลอง (รายสาขา)

        return view('trial_balance');

    }

    public function trial_balance_detail(){ //งบทดลอง (ทั้งหมด)->(รายละเอียด)
      $data = Input::all();
      $db = Connectdb::Databaseall();
      // print_r($data);
      // exit;

      return view('trial_balance_detail',[
                  'data'=>$data,
                  'query'=>true
                ]);
    }

    public function trial_allbalance(){ //งบทดลอง (ทั้งหมด)

        return view('trial_allbalance');

    }

    public function trial_balance_after(){ //งบทดลองหลังปิดบัญชี (รายสาขา)

        return view('trial_balance_after');

    }

    public function trial_balance_detail_after(){ //งบทดลองหลังปิดบัญชี (ทั้งหมด)->(รายละเอียด)
      $data = Input::all();
      $db = Connectdb::Databaseall();
      // print_r($data);
      // exit;

      return view('trial_balance_detail_after',[
                  'data'=>$data,
                  'query'=>true
                ]);
    }

    public function trial_allbalance_after(){ //งบทดลองหลังปิดบัญชี (ทั้งหมด)

        return view('trial_allbalance_after');

    }

    public function serachtrial_balance(){ //งบทดลอง (รายสาขา)

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

        return view('trial_balance',[
          'data'=>$datatresult,
          'query'=>true,
          'datepicker'=>$data['reservation'],
          'branch_id'=>$branch_id
          // 'accontcode'=>$acc_code,
        //   'datepicker2'=>$datetime
        ]);

    }


    public function serachtrial_allbalance(){ //งบทดลอง (ทั้งหมด)

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

        return view('trial_allbalance',[
          'data'=>$datatresult,
          'query'=>true,
          'datepicker'=>$data['reservation']
          // 'branch_id'=>$branch_id
          // 'accontcode'=>$acc_code,
        //   'datepicker2'=>$datetime
        ]);

    }

    public function serachtrial_balance_after(){ //งบทดลองหลังปิดบัญชี (รายสาขา)

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

        // $sql = 'SELECT '.$db['fsctaccount'].'.accounttype.*
        //         FROM '.$db['fsctaccount'].'.accounttype
        //
        //         WHERE '.$db['fsctaccount'].'.accounttype.status != 99
        //           ';
        // $datatresult = DB::connection('mysql')->select($sql);

        $sql = 'SELECT '.$db['fsctaccount'].'.ledger.*
                      FROM '.$db['fsctaccount'].'.ledger

                      WHERE '.$db['fsctaccount'].'.ledger.timestamp  BETWEEN "'.$start_date.'" AND  "'.$end_date.'"
                        AND '.$db['fsctaccount'].'.ledger.branch = "'.$branch_id.'"
                        AND '.$db['fsctaccount'].'.ledger.status != 99
                      GROUP BY '.$db['fsctaccount'].'.ledger.acc_code
                      ';

        $datatresult = DB::select($sql);
        // echo "<pre>";
        // print_r($datatresult);
        // exit;

        return view('trial_balance_after',[
          'data'=>$datatresult,
          'query'=>true,
          'datepicker'=>$data['reservation'],
          'branch_id'=>$branch_id
          // 'accontcode'=>$acc_code,
        //   'datepicker2'=>$datetime
        ]);

    }


    public function serachtrial_allbalance_after(){ //งบทดลองหลังปิดบัญชี (ทั้งหมด)

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

        // $sql = 'SELECT '.$db['fsctaccount'].'.accounttype.*
        //         FROM '.$db['fsctaccount'].'.accounttype
        //
        //         WHERE '.$db['fsctaccount'].'.accounttype.status != 99
        //           ';
        // $datatresult = DB::connection('mysql')->select($sql);

        $sql = 'SELECT '.$db['fsctaccount'].'.ledger.*
                      FROM '.$db['fsctaccount'].'.ledger

                      WHERE '.$db['fsctaccount'].'.ledger.timestamp  BETWEEN "'.$start_date.'" AND  "'.$end_date.'"
                        AND '.$db['fsctaccount'].'.ledger.status != 99
                      GROUP BY '.$db['fsctaccount'].'.ledger.acc_code
                      ';

        $datatresult = DB::select($sql);
        // echo "<pre>";
        // print_r($datatresult);
        // exit;

        return view('trial_allbalance_after',[
          'data'=>$datatresult,
          'query'=>true,
          'datepicker'=>$data['reservation']
          // 'branch_id'=>$branch_id
          // 'accontcode'=>$acc_code,
        //   'datepicker2'=>$datetime
        ]);

    }





}
