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

class Financial_statementController extends Controller
{

//---------------------------งบแสดงฐานะการเงิน (รายสาขา)------------------------------
    public function financial_statement_day(){ //งบแสดงฐานะการเงิน (รายวัน/รายเดือน)

        return view('financial_statement_day');
    }

    public function financial_statement_year(){ //งบแสดงฐานะการเงิน (รายปี)

        return view('financial_statement_year');
    }

    public function serachfinancial_statement_day(){ //งบแสดงฐานะการเงิน (รายวัน)

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

                      //ปีเก่า
                      $s_yearold = $e1[2]-1;
                      $start_dateold = $s_yearold . '-' . $e1[0] . '-' . $e1[1]." 00:00:00"; //ปี - เดือน - วัน
                  }

          // $end_date = $datepicker[1];
          $e2 = explode("/",trim(($datepicker[1])));
                  if(count($e2) > 0) {
                      $end_date = $e2[2] . '-' . $e2[0] . '-' . $e2[1]." 23:59:59"; //ปี - เดือน - วัน

                      //ปีเก่า
                      $e_yearold = $e2[2]-1;
                      $end_dateold = $e_yearold . '-' . $e2[0] . '-' . $e2[1]." 23:59:59"; //ปี - เดือน - วัน
                  }

        $branch_id = $data['branch_id'];
        // $acc_code = $data['acc_code'];

        $sql = 'SELECT '.$db['fsctaccount'].'.ledger.*,
                         SUM('.$db['fsctaccount'].'.ledger.dr) as sumdebit,
                         SUM('.$db['fsctaccount'].'.ledger.cr) as sumcredit

                      FROM '.$db['fsctaccount'].'.ledger

                      WHERE '.$db['fsctaccount'].'.ledger.timestamp  BETWEEN "'.$start_date.'" AND  "'.$end_date.'"
                        AND '.$db['fsctaccount'].'.ledger.branch = "'.$branch_id.'"
                        AND '.$db['fsctaccount'].'.ledger.balance_forward_status = 0
                        AND '.$db['fsctaccount'].'.ledger.status != 99
                      GROUP BY '.$db['fsctaccount'].'.ledger.acc_code
                      ';

        $datatresult = DB::select($sql);

        $sqlyearold = 'SELECT '.$db['fsctaccount'].'.ledger.*,
                         SUM('.$db['fsctaccount'].'.ledger.dr) as sumdebit,
                         SUM('.$db['fsctaccount'].'.ledger.cr) as sumcredit

                      FROM '.$db['fsctaccount'].'.ledger

                      WHERE '.$db['fsctaccount'].'.ledger.timestamp  BETWEEN "'.$start_dateold.'" AND  "'.$end_dateold.'"
                        AND '.$db['fsctaccount'].'.ledger.branch = "'.$branch_id.'"
                        AND '.$db['fsctaccount'].'.ledger.balance_forward_status = 1
                        AND '.$db['fsctaccount'].'.ledger.type_journal = 5
                        AND '.$db['fsctaccount'].'.ledger.status != 99
                      GROUP BY '.$db['fsctaccount'].'.ledger.acc_code
                      ';

        $data_yearold = DB::select($sqlyearold);
        // echo "<pre>";
        // print_r($datatresult);
        // print_r($data_yearold);
        // exit;

        return view('financial_statement_day',[
          'data'=>$datatresult,
          'data_yearold'=>$data_yearold,
          'query'=>true,
          'datepicker'=>$data['reservation'],
          'branch_id'=>$branch_id
          // 'accontcode'=>$acc_code,
        //   'datepicker2'=>$datetime
        ]);

    }

    public function serachfinancial_statement_year(){ //งบแสดงฐานะการเงิน (รายปี)

        $data = Input::all();
        $db = Connectdb::Databaseall();
        // echo "<pre>";
        // print_r($data);
        // exit;

        $year = $data['reservation'];
        $yearold = $data['reservation']-1;
        $yearoldss = $data['reservation']-2;
        $yearoldsss = $data['reservation']-2;
        $branch_id = $data['branch_id'];
        // $acc_code = $data['acc_code'];

        //ปีปัจจุบัน
        $sql = 'SELECT '.$db['fsctaccount'].'.ledger.*,
                         SUM('.$db['fsctaccount'].'.ledger.dr) as sumdebit,
                         SUM('.$db['fsctaccount'].'.ledger.cr) as sumcredit

                      FROM '.$db['fsctaccount'].'.ledger

                      WHERE '.$db['fsctaccount'].'.ledger.timestamp LIKE "'.$year.'%"
                        AND '.$db['fsctaccount'].'.ledger.branch = "'.$branch_id.'"
                        AND '.$db['fsctaccount'].'.ledger.balance_forward_status = 0
                        AND '.$db['fsctaccount'].'.ledger.status != 99
                      GROUP BY '.$db['fsctaccount'].'.ledger.acc_code
                      ';

        $datatresult = DB::select($sql);

        //ยอดยกมาของปีปัจจุบัน
        $sqlold = 'SELECT '.$db['fsctaccount'].'.ledger.*,
                         SUM('.$db['fsctaccount'].'.ledger.dr) as sumdebit,
                         SUM('.$db['fsctaccount'].'.ledger.cr) as sumcredit

                      FROM '.$db['fsctaccount'].'.ledger

                      WHERE '.$db['fsctaccount'].'.ledger.timestamp LIKE "'.$yearold.'%"
                        AND '.$db['fsctaccount'].'.ledger.branch = "'.$branch_id.'"
                        AND '.$db['fsctaccount'].'.ledger.balance_forward_status = 1
                        AND '.$db['fsctaccount'].'.ledger.type_journal = 5
                        AND '.$db['fsctaccount'].'.ledger.status != 99
                      GROUP BY '.$db['fsctaccount'].'.ledger.acc_code
                      ';

        $dataold = DB::select($sqlold);

        //ปีเก่า
        $sqlyear = 'SELECT '.$db['fsctaccount'].'.ledger.*,
                         SUM('.$db['fsctaccount'].'.ledger.dr) as sumdebit,
                         SUM('.$db['fsctaccount'].'.ledger.cr) as sumcredit

                      FROM '.$db['fsctaccount'].'.ledger

                      WHERE '.$db['fsctaccount'].'.ledger.timestamp LIKE "'.$yearold.'%"
                        AND '.$db['fsctaccount'].'.ledger.branch = "'.$branch_id.'"
                        AND '.$db['fsctaccount'].'.ledger.balance_forward_status = 0
                        AND '.$db['fsctaccount'].'.ledger.status != 99
                      GROUP BY '.$db['fsctaccount'].'.ledger.acc_code
                      ';

        $datayear = DB::select($sqlyear);

        //ยอดยกมาของปีเก่า
        $sqloldss = 'SELECT '.$db['fsctaccount'].'.ledger.*,
                         SUM('.$db['fsctaccount'].'.ledger.dr) as sumdebit,
                         SUM('.$db['fsctaccount'].'.ledger.cr) as sumcredit

                      FROM '.$db['fsctaccount'].'.ledger

                      WHERE '.$db['fsctaccount'].'.ledger.timestamp LIKE "'.$yearoldss.'%"
                        AND '.$db['fsctaccount'].'.ledger.branch = "'.$branch_id.'"
                        AND '.$db['fsctaccount'].'.ledger.balance_forward_status = 1
                        AND '.$db['fsctaccount'].'.ledger.type_journal = 5
                        AND '.$db['fsctaccount'].'.ledger.status != 99
                      GROUP BY '.$db['fsctaccount'].'.ledger.acc_code
                      ';

        $dataoldss = DB::select($sqloldss);

        //ข้อมูลปีเก่า
        $sqloldsss = 'SELECT '.$db['fsctaccount'].'.ledger.*,
                         SUM('.$db['fsctaccount'].'.ledger.dr) as sumdebit,
                         SUM('.$db['fsctaccount'].'.ledger.cr) as sumcredit

                      FROM '.$db['fsctaccount'].'.ledger

                      WHERE '.$db['fsctaccount'].'.ledger.timestamp LIKE "'.$yearoldsss.'%"
                        AND '.$db['fsctaccount'].'.ledger.branch = "'.$branch_id.'"
                        AND '.$db['fsctaccount'].'.ledger.balance_forward_status = 0
                        AND '.$db['fsctaccount'].'.ledger.status != 99
                      GROUP BY '.$db['fsctaccount'].'.ledger.acc_code
                      ';

        $dataoldsss = DB::select($sqloldsss);
        // echo "<pre>";
        // print_r($datatresult);
        // print_r($dataold);
        // exit;

        return view('financial_statement_year',[
          'data'=>$datatresult,
          'dataold'=>$dataold,
          'datayear'=>$datayear,
          'dataoldss'=>$dataoldss,
          'dataoldsss'=>$dataoldsss,
          'query'=>true,
          'datepicker'=>$data['reservation'],
          'branch_id'=>$branch_id
          // 'accontcode'=>$acc_code,
        //   'datepicker2'=>$datetime
        ]);

    }


//---------------------------งบแสดงฐานะการเงิน (ทั้งหมด)-------------------------------
    public function financial_statement_allday(){ //งบแสดงฐานะการเงิน (รายวัน/รายเดือน)

        return view('financial_statement_allday');
    }

    public function financial_statement_allyear(){ //งบแสดงฐานะการเงิน (รายปี)

        return view('financial_statement_allyear');
    }

    public function serachfinancial_statement_allday(){ //งบแสดงฐานะการเงิน (รายวัน)

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

                    //ปีเก่า
                    $s_yearold = $e1[2]-1;
                    $start_dateold = $s_yearold . '-' . $e1[0] . '-' . $e1[1]." 00:00:00"; //ปี - เดือน - วัน
                }

        // $end_date = $datepicker[1];
        $e2 = explode("/",trim(($datepicker[1])));
                if(count($e2) > 0) {
                    $end_date = $e2[2] . '-' . $e2[0] . '-' . $e2[1]." 23:59:59"; //ปี - เดือน - วัน

                    //ปีเก่า
                    $e_yearold = $e2[2]-1;
                    $end_dateold = $e_yearold . '-' . $e2[0] . '-' . $e2[1]." 23:59:59"; //ปี - เดือน - วัน
                }


        // $branch_id = $data['branch_id'];
        // $acc_code = $data['acc_code'];

        $sql = 'SELECT '.$db['fsctaccount'].'.ledger.*,
                         SUM('.$db['fsctaccount'].'.ledger.dr) as sumdebit,
                         SUM('.$db['fsctaccount'].'.ledger.cr) as sumcredit

                      FROM '.$db['fsctaccount'].'.ledger

                      WHERE '.$db['fsctaccount'].'.ledger.timestamp  BETWEEN "'.$start_date.'" AND  "'.$end_date.'"
                        AND '.$db['fsctaccount'].'.ledger.balance_forward_status = 0
                        AND '.$db['fsctaccount'].'.ledger.status != 99
                      GROUP BY '.$db['fsctaccount'].'.ledger.acc_code
                      ';

        $datatresult = DB::select($sql);

        $sqlyearold = 'SELECT '.$db['fsctaccount'].'.ledger.*,
                         SUM('.$db['fsctaccount'].'.ledger.dr) as sumdebit,
                         SUM('.$db['fsctaccount'].'.ledger.cr) as sumcredit

                      FROM '.$db['fsctaccount'].'.ledger

                      WHERE '.$db['fsctaccount'].'.ledger.timestamp  BETWEEN "'.$start_dateold.'" AND  "'.$end_dateold.'"
                        AND '.$db['fsctaccount'].'.ledger.balance_forward_status = 1
                        AND '.$db['fsctaccount'].'.ledger.type_journal = 5
                        AND '.$db['fsctaccount'].'.ledger.status != 99
                      GROUP BY '.$db['fsctaccount'].'.ledger.acc_code
                      ';

        $data_yearold = DB::select($sqlyearold);
        // echo "<pre>";
        // print_r($datatresult);
        // exit;

        return view('financial_statement_allday',[
          'data'=>$datatresult,
          'data_yearold'=>$data_yearold,
          'query'=>true,
          'datepicker'=>$data['reservation']
          // 'branch_id'=>$branch_id
          // 'accontcode'=>$acc_code,
        //   'datepicker2'=>$datetime
        ]);

    }


    public function serachfinancial_statement_allyear(){ //งบแสดงฐานะการเงิน (รายปี)

        $data = Input::all();
        $db = Connectdb::Databaseall();
        // echo "<pre>";
        // print_r($data);
        // exit;

        $year = $data['reservation'];
        $yearold = $data['reservation']-1;
        $yearoldss = $data['reservation']-2;
        $yearoldsss = $data['reservation']-2;
        // $branch_id = $data['branch_id'];

        //ปีปัจจุบัน
        $sql = 'SELECT '.$db['fsctaccount'].'.ledger.*,
                         SUM('.$db['fsctaccount'].'.ledger.dr) as sumdebit,
                         SUM('.$db['fsctaccount'].'.ledger.cr) as sumcredit

                      FROM '.$db['fsctaccount'].'.ledger

                      WHERE '.$db['fsctaccount'].'.ledger.timestamp LIKE "'.$year.'%"
                        AND '.$db['fsctaccount'].'.ledger.balance_forward_status = 0
                        AND '.$db['fsctaccount'].'.ledger.status != 99
                      GROUP BY '.$db['fsctaccount'].'.ledger.acc_code
                      ';

        $datatresult = DB::select($sql);

        //ยอดยกมาของปีปัจจุบัน
        $sqlold = 'SELECT '.$db['fsctaccount'].'.ledger.*,
                         SUM('.$db['fsctaccount'].'.ledger.dr) as sumdebit,
                         SUM('.$db['fsctaccount'].'.ledger.cr) as sumcredit

                      FROM '.$db['fsctaccount'].'.ledger

                      WHERE '.$db['fsctaccount'].'.ledger.timestamp LIKE "'.$yearold.'%"
                        AND '.$db['fsctaccount'].'.ledger.balance_forward_status = 1
                        AND '.$db['fsctaccount'].'.ledger.type_journal = 5
                        AND '.$db['fsctaccount'].'.ledger.status != 99
                      GROUP BY '.$db['fsctaccount'].'.ledger.acc_code
                      ';

        $dataold = DB::select($sqlold);

        //ปีเก่า
        $sqlyear = 'SELECT '.$db['fsctaccount'].'.ledger.*,
                         SUM('.$db['fsctaccount'].'.ledger.dr) as sumdebit,
                         SUM('.$db['fsctaccount'].'.ledger.cr) as sumcredit

                      FROM '.$db['fsctaccount'].'.ledger

                      WHERE '.$db['fsctaccount'].'.ledger.timestamp LIKE "'.$yearold.'%"
                        AND '.$db['fsctaccount'].'.ledger.balance_forward_status = 0
                        AND '.$db['fsctaccount'].'.ledger.status != 99
                      GROUP BY '.$db['fsctaccount'].'.ledger.acc_code
                      ';

        $datayear = DB::select($sqlyear);

        //ยอดยกมาของปีเก่า
        $sqloldss = 'SELECT '.$db['fsctaccount'].'.ledger.*,
                         SUM('.$db['fsctaccount'].'.ledger.dr) as sumdebit,
                         SUM('.$db['fsctaccount'].'.ledger.cr) as sumcredit

                      FROM '.$db['fsctaccount'].'.ledger

                      WHERE '.$db['fsctaccount'].'.ledger.timestamp LIKE "'.$yearoldss.'%"
                        AND '.$db['fsctaccount'].'.ledger.balance_forward_status = 1
                        AND '.$db['fsctaccount'].'.ledger.type_journal = 5
                        AND '.$db['fsctaccount'].'.ledger.status != 99
                      GROUP BY '.$db['fsctaccount'].'.ledger.acc_code
                      ';

        $dataoldss = DB::select($sqloldss);

        //ข้อมูลปีเก่า
        $sqloldsss = 'SELECT '.$db['fsctaccount'].'.ledger.*,
                         SUM('.$db['fsctaccount'].'.ledger.dr) as sumdebit,
                         SUM('.$db['fsctaccount'].'.ledger.cr) as sumcredit

                      FROM '.$db['fsctaccount'].'.ledger

                      WHERE '.$db['fsctaccount'].'.ledger.timestamp LIKE "'.$yearoldsss.'%"
                        AND '.$db['fsctaccount'].'.ledger.balance_forward_status = 0
                        AND '.$db['fsctaccount'].'.ledger.status != 99
                      GROUP BY '.$db['fsctaccount'].'.ledger.acc_code
                      ';

        $dataoldsss = DB::select($sqloldsss);
        // echo "<pre>";
        // print_r($dataoldsss);
        // exit;

        return view('financial_statement_allyear',[
          'data'=>$datatresult,
          'dataold'=>$dataold,
          'datayear'=>$datayear,
          'dataoldss'=>$dataoldss,
          'dataoldsss'=>$dataoldsss,
          'query'=>true,
          'datepicker'=>$data['reservation']
          // 'accontcode'=>$acc_code,
        //   'datepicker2'=>$datetime
        ]);

    }


























}
