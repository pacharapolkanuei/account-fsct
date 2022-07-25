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

class Profitloss_statementController extends Controller
{

//---------------------------งบกำไรขาดทุน (รายสาขา)------------------------------
    public function profitloss_statement_day(){ //งบกำไรขาดทุน (รายวัน/รายเดือน)

        return view('profitloss_statement_day');
    }

    public function profitloss_statement_year(){ //งบกำไรขาดทุน (รายปี)

        return view('profitloss_statement_year');
    }

    public function serachprofitloss_statement_day(){ //งบกำไรขาดทุน (รายวัน)

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
                      $start_dateold = $e1[2]-1; //ปี - เดือน - วัน (ปีเก่า)
                  }

          // $end_date = $datepicker[1];
          $e2 = explode("/",trim(($datepicker[1])));
                  if(count($e2) > 0) {
                      $end_date = $e2[2] . '-' . $e2[0] . '-' . $e2[1]." 23:59:59"; //ปี - เดือน - วัน
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

        $sqlold = 'SELECT '.$db['fsctaccount'].'.ledger.*,
                         SUM('.$db['fsctaccount'].'.ledger.dr) as sumdebit,
                         SUM('.$db['fsctaccount'].'.ledger.cr) as sumcredit

                      FROM '.$db['fsctaccount'].'.ledger

                      WHERE '.$db['fsctaccount'].'.ledger.timestamp LIKE "'.$start_dateold.'%"
                        AND '.$db['fsctaccount'].'.ledger.branch = "'.$branch_id.'"
                        AND '.$db['fsctaccount'].'.ledger.balance_forward_status = 1
                        AND '.$db['fsctaccount'].'.ledger.type_journal = 5
                        AND '.$db['fsctaccount'].'.ledger.status != 99
                      GROUP BY '.$db['fsctaccount'].'.ledger.acc_code
                      ';

        $datatold = DB::select($sqlold);
        // echo "<pre>";
        // print_r($datatresult);
        // print_r($datatold);
        // exit;

        return view('profitloss_statement_day',[
          'data'=>$datatresult,
          'datatold'=>$datatold,
          'query'=>true,
          'datepicker'=>$data['reservation'],
          'branch_id'=>$branch_id
          // 'accontcode'=>$acc_code,
        //   'datepicker2'=>$datetime
        ]);

    }

    public function serachprofitloss_statement_year(){ //งบกำไรขาดทุน (รายปี)

        $data = Input::all();
        $db = Connectdb::Databaseall();
        // echo "<pre>";
        // print_r($data);
        // exit;

        // $datepicker = explode("-",trim(($data['reservation'])));
        //
        //   // $start_date = $datepicker[0];
        //   $e1 = explode("/",trim(($datepicker[0])));
        //           if(count($e1) > 0) {
        //               $start_date = $e1[2] . '-' . $e1[0] . '-' . $e1[1]." 00:00:00"; //ปี - เดือน - วัน
        //           }
        //
        //   // $end_date = $datepicker[1];
        //   $e2 = explode("/",trim(($datepicker[1])));
        //           if(count($e2) > 0) {
        //               $end_date = $e2[2] . '-' . $e2[0] . '-' . $e2[1]." 23:59:59"; //ปี - เดือน - วัน
        //           }

        $year = $data['reservation'];
        $yearold = $data['reservation']-1;
        $yearoldss = $data['reservation']-2;
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
        // echo "<pre>";
        // print_r($datatresult);
        // print_r($dataold);
        // exit;

        return view('profitloss_statement_year',[
          'data'=>$datatresult,
          'dataold'=>$dataold,
          'datayear'=>$datayear,
          'dataoldss'=>$dataoldss,
          'query'=>true,
          'datepicker'=>$data['reservation'],
          'branch_id'=>$branch_id
          // 'accontcode'=>$acc_code,
        //   'datepicker2'=>$datetime
        ]);

    }


//---------------------------งบกำไรขาดทุน (ทั้งหมด)-------------------------------
    public function profitloss_statement_allday(){ //งบกำไรขาดทุน (รายวัน/รายเดือน)

        return view('profitloss_statement_allday');
    }

    public function profitloss_statement_allyear(){ //งบกำไรขาดทุน (รายปี)

        return view('profitloss_statement_allyear');
    }

    public function serachprofitloss_statement_allday(){ //งบกำไรขาดทุน (รายวัน)

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
                      $start_dateold = $e1[2]-1; //ปี - เดือน - วัน (ปีเก่า)
                  }

          // $end_date = $datepicker[1];
          $e2 = explode("/",trim(($datepicker[1])));
                  if(count($e2) > 0) {
                      $end_date = $e2[2] . '-' . $e2[0] . '-' . $e2[1]." 23:59:59"; //ปี - เดือน - วัน
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

        $sqlold = 'SELECT '.$db['fsctaccount'].'.ledger.*,
                         SUM('.$db['fsctaccount'].'.ledger.dr) as sumdebit,
                         SUM('.$db['fsctaccount'].'.ledger.cr) as sumcredit

                      FROM '.$db['fsctaccount'].'.ledger

                      WHERE '.$db['fsctaccount'].'.ledger.timestamp LIKE "'.$start_dateold.'%"
                        AND '.$db['fsctaccount'].'.ledger.balance_forward_status = 1
                        AND '.$db['fsctaccount'].'.ledger.type_journal = 5
                        AND '.$db['fsctaccount'].'.ledger.status != 99
                      GROUP BY '.$db['fsctaccount'].'.ledger.acc_code
                      ';

        $datatold = DB::select($sqlold);

        return view('profitloss_statement_allday',[
          'data'=>$datatresult,
          'datatold'=>$datatold,
          'query'=>true,
          'datepicker'=>$data['reservation']
          // 'branch_id'=>$branch_id
          // 'accontcode'=>$acc_code,
        //   'datepicker2'=>$datetime
        ]);

    }

    public function serachprofitloss_statement_allyear(){ //งบกำไรขาดทุน (รายปี)

        $data = Input::all();
        $db = Connectdb::Databaseall();
        // echo "<pre>";
        // print_r($data);
        // exit;

        $year = $data['reservation'];
        $yearold = $data['reservation']-1;
        $yearoldss = $data['reservation']-2;
        // $branch_id = $data['branch_id'];
        // $acc_code = $data['acc_code'];

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
        // echo "<pre>";
        // print_r($datatresult);
        // exit;

        return view('profitloss_statement_allyear',[
          'data'=>$datatresult,
          'dataold'=>$dataold,
          'datayear'=>$datayear,
          'dataoldss'=>$dataoldss,
          'query'=>true,
          'datepicker'=>$data['reservation']
          // 'accontcode'=>$acc_code,
        //   'datepicker2'=>$datetime
        ]);

    }

    public function income_sell_detail(){ //งบกำไรขาดทุน (รายวัน/รายเดือน)->(รายได้จากการขายหรือการให้บริการ)
      $data = Input::all();
      $db = Connectdb::Databaseall();
      // print_r($data);
      // exit;

      $datepicker = explode("-",trim(($data['datepicker'])));

        // $start_date = $datepicker[0];
        $e1 = explode("/",trim(($datepicker[0])));
                if(count($e1) > 0) {
                    $start_date = $e1[2] . '-' . $e1[0] . '-' . $e1[1]." 00:00:00"; //ปี - เดือน - วัน
                    $start_dateold = $e1[2]-1; //ปี - เดือน - วัน (ปีเก่า)
                }

        // $end_date = $datepicker[1];
        $e2 = explode("/",trim(($datepicker[1])));
                if(count($e2) > 0) {
                    $end_date = $e2[2] . '-' . $e2[0] . '-' . $e2[1]." 23:59:59"; //ปี - เดือน - วัน
                }

      // $branch_id = $data['branch_id'];
      // $acc_code = $data['acc_code'];

      // $sql = 'SELECT '.$db['fsctaccount'].'.ledger.*,
      //                  SUM('.$db['fsctaccount'].'.ledger.dr) as sumdebit,
      //                  SUM('.$db['fsctaccount'].'.ledger.cr) as sumcredit
      //
      //               FROM '.$db['fsctaccount'].'.ledger
      //
      //               WHERE '.$db['fsctaccount'].'.ledger.timestamp  BETWEEN "'.$start_date.'" AND  "'.$end_date.'"
      //                 AND '.$db['fsctaccount'].'.ledger.balance_forward_status = 0
      //                 AND '.$db['fsctaccount'].'.ledger.status != 99
      //               GROUP BY '.$db['fsctaccount'].'.ledger.acc_code
      //               ';

      $sql = 'SELECT DISTINCT '.$db['fsctaccount'].'.ledger.branch

                    FROM '.$db['fsctaccount'].'.ledger

                    WHERE '.$db['fsctaccount'].'.ledger.timestamp  BETWEEN "'.$start_date.'" AND  "'.$end_date.'"
                      AND '.$db['fsctaccount'].'.ledger.balance_forward_status = 0
                      AND '.$db['fsctaccount'].'.ledger.status != 99
                    GROUP BY '.$db['fsctaccount'].'.ledger.acc_code
                    ';

      $datatresult = DB::select($sql);
      //
      // $sqlold = 'SELECT '.$db['fsctaccount'].'.ledger.*,
      //                  SUM('.$db['fsctaccount'].'.ledger.dr) as sumdebit,
      //                  SUM('.$db['fsctaccount'].'.ledger.cr) as sumcredit
      //
      //               FROM '.$db['fsctaccount'].'.ledger
      //
      //               WHERE '.$db['fsctaccount'].'.ledger.timestamp LIKE "'.$start_dateold.'%"
      //                 AND '.$db['fsctaccount'].'.ledger.balance_forward_status = 1
      //                 AND '.$db['fsctaccount'].'.ledger.type_journal = 5
      //                 AND '.$db['fsctaccount'].'.ledger.status != 99
      //               GROUP BY '.$db['fsctaccount'].'.ledger.acc_code
      //               ';

      $sqlold = 'SELECT '.$db['fsctaccount'].'.ledger.*,
                       SUM('.$db['fsctaccount'].'.ledger.dr) as sumdebit,
                       SUM('.$db['fsctaccount'].'.ledger.cr) as sumcredit

                    FROM '.$db['fsctaccount'].'.ledger

                    WHERE '.$db['fsctaccount'].'.ledger.timestamp LIKE "'.$start_dateold.'%"
                      AND '.$db['fsctaccount'].'.ledger.balance_forward_status = 1
                      AND '.$db['fsctaccount'].'.ledger.type_journal = 5
                      AND '.$db['fsctaccount'].'.ledger.status != 99
                    GROUP BY '.$db['fsctaccount'].'.ledger.acc_code
                    ';

      $datatold = DB::select($sqlold);

      return view('income_sell_detail',[
                  'data'=>$datatresult,
                  'datatold'=>$datatold,
                  'datepicker'=>$data['datepicker'],
                  'query'=>true
                ]);
    }


    public function income_other_detail(){ //งบกำไรขาดทุน (รายวัน/รายเดือน)->(รายได้อื่น)
      $data = Input::all();
      $db = Connectdb::Databaseall();
      // print_r($data);
      // exit;

      $datepicker = explode("-",trim(($data['datepicker'])));

        // $start_date = $datepicker[0];
        $e1 = explode("/",trim(($datepicker[0])));
                if(count($e1) > 0) {
                    $start_date = $e1[2] . '-' . $e1[0] . '-' . $e1[1]." 00:00:00"; //ปี - เดือน - วัน
                    $start_dateold = $e1[2]-1; //ปี - เดือน - วัน (ปีเก่า)
                }

        // $end_date = $datepicker[1];
        $e2 = explode("/",trim(($datepicker[1])));
                if(count($e2) > 0) {
                    $end_date = $e2[2] . '-' . $e2[0] . '-' . $e2[1]." 23:59:59"; //ปี - เดือน - วัน
                }

      // $branch_id = $data['branch_id'];
      // $acc_code = $data['acc_code'];

      //  $sql = 'SELECT '.$db['fsctaccount'].'.ledger.*,
      //                  SUM('.$db['fsctaccount'].'.ledger.dr) as sumdebit,
      //                  SUM('.$db['fsctaccount'].'.ledger.cr) as sumcredit
      //
      //               FROM '.$db['fsctaccount'].'.ledger
      //
      //               WHERE '.$db['fsctaccount'].'.ledger.timestamp  BETWEEN "'.$start_date.'" AND  "'.$end_date.'"
      //                 AND '.$db['fsctaccount'].'.ledger.balance_forward_status = 0
      //                 AND '.$db['fsctaccount'].'.ledger.status != 99
      //               GROUP BY '.$db['fsctaccount'].'.ledger.acc_code
      //               ';
      //
      //
      // $datatresult = DB::select($sql);
      //
      // $sqlold = 'SELECT '.$db['fsctaccount'].'.ledger.*,
      //                  SUM('.$db['fsctaccount'].'.ledger.dr) as sumdebit,
      //                  SUM('.$db['fsctaccount'].'.ledger.cr) as sumcredit
      //
      //               FROM '.$db['fsctaccount'].'.ledger
      //
      //               WHERE '.$db['fsctaccount'].'.ledger.timestamp LIKE "'.$start_dateold.'%"
      //                 AND '.$db['fsctaccount'].'.ledger.balance_forward_status = 1
      //                 AND '.$db['fsctaccount'].'.ledger.type_journal = 5
      //                 AND '.$db['fsctaccount'].'.ledger.status != 99
      //               GROUP BY '.$db['fsctaccount'].'.ledger.acc_code
      //               ';
      //
      // $datatold = DB::select($sqlold);

      $sql = 'SELECT DISTINCT '.$db['fsctaccount'].'.ledger.branch

                    FROM '.$db['fsctaccount'].'.ledger

                    WHERE '.$db['fsctaccount'].'.ledger.timestamp  BETWEEN "'.$start_date.'" AND  "'.$end_date.'"
                      AND '.$db['fsctaccount'].'.ledger.balance_forward_status = 0
                      AND '.$db['fsctaccount'].'.ledger.status != 99
                    GROUP BY '.$db['fsctaccount'].'.ledger.acc_code
                    ';

      $datatresult = DB::select($sql);


      $sqlold = 'SELECT '.$db['fsctaccount'].'.ledger.*,
                       SUM('.$db['fsctaccount'].'.ledger.dr) as sumdebit,
                       SUM('.$db['fsctaccount'].'.ledger.cr) as sumcredit

                    FROM '.$db['fsctaccount'].'.ledger

                    WHERE '.$db['fsctaccount'].'.ledger.timestamp LIKE "'.$start_dateold.'%"
                      AND '.$db['fsctaccount'].'.ledger.balance_forward_status = 1
                      AND '.$db['fsctaccount'].'.ledger.type_journal = 5
                      AND '.$db['fsctaccount'].'.ledger.status != 99
                    GROUP BY '.$db['fsctaccount'].'.ledger.acc_code
                    ';

      $datatold = DB::select($sqlold);

      return view('income_other_detail',[
                  'data'=>$datatresult,
                  'datatold'=>$datatold,
                  'datepicker'=>$data['datepicker'],
                  'query'=>true
                ]);
    }


    public function cost_of_sales_detail(){ //งบกำไรขาดทุน (รายวัน/รายเดือน)->(ต้นทุนขายหรือต้นทุนการให้บริการ)
      $data = Input::all();
      $db = Connectdb::Databaseall();
      // print_r($data);
      // exit;

      $datepicker = explode("-",trim(($data['datepicker'])));

        // $start_date = $datepicker[0];
        $e1 = explode("/",trim(($datepicker[0])));
                if(count($e1) > 0) {
                    $start_date = $e1[2] . '-' . $e1[0] . '-' . $e1[1]." 00:00:00"; //ปี - เดือน - วัน
                    $start_dateold = $e1[2]-1; //ปี - เดือน - วัน (ปีเก่า)
                }

        // $end_date = $datepicker[1];
        $e2 = explode("/",trim(($datepicker[1])));
                if(count($e2) > 0) {
                    $end_date = $e2[2] . '-' . $e2[0] . '-' . $e2[1]." 23:59:59"; //ปี - เดือน - วัน
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

      $sqlold = 'SELECT '.$db['fsctaccount'].'.ledger.*,
                       SUM('.$db['fsctaccount'].'.ledger.dr) as sumdebit,
                       SUM('.$db['fsctaccount'].'.ledger.cr) as sumcredit

                    FROM '.$db['fsctaccount'].'.ledger

                    WHERE '.$db['fsctaccount'].'.ledger.timestamp LIKE "'.$start_dateold.'%"
                      AND '.$db['fsctaccount'].'.ledger.balance_forward_status = 1
                      AND '.$db['fsctaccount'].'.ledger.type_journal = 5
                      AND '.$db['fsctaccount'].'.ledger.status != 99
                    GROUP BY '.$db['fsctaccount'].'.ledger.acc_code
                    ';

      $datatold = DB::select($sqlold);

      return view('cost_of_sales_detail',[
                  'data'=>$datatresult,
                  'datatold'=>$datatold,
                  'datepicker'=>$data['datepicker'],
                  'query'=>true
                ]);
    }


    public function expenses_sales_detail(){ //งบกำไรขาดทุน (รายวัน/รายเดือน)->(ค่าใช้จ่ายในการขาย)
      $data = Input::all();
      $db = Connectdb::Databaseall();
      // print_r($data);
      // exit;

      $datepicker = explode("-",trim(($data['datepicker'])));

        // $start_date = $datepicker[0];
        $e1 = explode("/",trim(($datepicker[0])));
                if(count($e1) > 0) {
                    $start_date = $e1[2] . '-' . $e1[0] . '-' . $e1[1]." 00:00:00"; //ปี - เดือน - วัน
                    $start_dateold = $e1[2]-1; //ปี - เดือน - วัน (ปีเก่า)
                }

        // $end_date = $datepicker[1];
        $e2 = explode("/",trim(($datepicker[1])));
                if(count($e2) > 0) {
                    $end_date = $e2[2] . '-' . $e2[0] . '-' . $e2[1]." 23:59:59"; //ปี - เดือน - วัน
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
                      AND '.$db['fsctaccount'].'.ledger.acc_code LIKE "61%"
                    GROUP BY '.$db['fsctaccount'].'.ledger.acc_code
                    ';

      $datatresult = DB::select($sql);

      $sqlold = 'SELECT '.$db['fsctaccount'].'.ledger.*,
                       SUM('.$db['fsctaccount'].'.ledger.dr) as sumdebit,
                       SUM('.$db['fsctaccount'].'.ledger.cr) as sumcredit

                    FROM '.$db['fsctaccount'].'.ledger

                    WHERE '.$db['fsctaccount'].'.ledger.timestamp LIKE "'.$start_dateold.'%"
                      AND '.$db['fsctaccount'].'.ledger.balance_forward_status = 1
                      AND '.$db['fsctaccount'].'.ledger.type_journal = 5
                      AND '.$db['fsctaccount'].'.ledger.status != 99
                      AND '.$db['fsctaccount'].'.ledger.acc_code LIKE "61%"
                    GROUP BY '.$db['fsctaccount'].'.ledger.acc_code
                    ';

      $datatold = DB::select($sqlold);

      return view('expenses_sales_detail',[
                  'data'=>$datatresult,
                  'datatold'=>$datatold,
                  'datepicker'=>$data['datepicker'],
                  'query'=>true
                ]);
    }


























}
