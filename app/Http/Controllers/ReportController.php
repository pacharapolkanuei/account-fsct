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

class ReportController extends Controller
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

     public function reportaccrued(){ //รายงานเจ้าหนี้การค้า (ค้างจ่าย)

            return view('reportaccrued');
     }

     public function reportaccruedall(){ //รายงานเจ้าหนี้การค้า (ทั้งหมด)

            return view('reportaccruedall');
     }

     public function reportaccruedtransfer(){ //รายงานเจ้าหนี้การค้า (โอนแล้ว)

            return view('reportaccruedtransfer');
     }

     public function reporttaxbuy(){ //รายงานภาษีซื้อ

            return view('reporttaxbuy');
     }

     public function reportpaycash(){ //รายงานชำระค่าสินค้าและบริการ (เงินสด/เงินโอน)

            return view('reportpaycash');
     }

     public function reportpaycredit(){ //รายงานชำระค่าสินค้าและบริการ (เงินเชื่อ)

            return view('reportpaycredit');
     }


     public function serachreportaccrued(){ //รายงานเจ้าหนี้การค้า (ค้างจ่าย)

         $data = Input::all();
         $db = Connectdb::Databaseall();
         // echo "<pre>";
         // print_r($data);
         // exit;

         // $datepicker = explode("/",trim(($data['datepicker'])));
         // if(count($datepicker) > 0) {
         //     $datetime = $datepicker[2] . '-' . $datepicker[1] . '-' . $datepicker[0]; //วัน - เดือน - ปี
         // }
         //
         $branch_id = $data['branch_id'];

         $sql = 'SELECT '.$db['fsctaccount'].'.po_head.*,
                        '.$db['fsctaccount'].'.in_debt.created_at,
                        '.$db['fsctaccount'].'.in_debt.vat_price
                 FROM '.$db['fsctaccount'].'.po_head

                 INNER JOIN  '.$db['fsctaccount'].'.in_debt
                     ON '.$db['fsctaccount'].'.po_head.id = '.$db['fsctaccount'].'.in_debt.id_po

                 WHERE '.$db['fsctaccount'].'.po_head.branch_id = '.$branch_id.'
                   AND '.$db['fsctaccount'].'.po_head.type_po IN (1)
                   AND '.$db['fsctaccount'].'.po_head.status_head IN (0 , 1)
                   ';
         $datatresult = DB::connection('mysql')->select($sql);
         // echo "<pre>";
         // print_r($datatresult);
         // exit;

         return view('reportaccrued',[
           'data'=>$datatresult,
           'query'=>true,
         //   'datepicker'=>$data['datepicker'],
           'branch_id'=>$branch_id,
         //   'datepicker2'=>$datetime
         ]);

     }


     public function saveapprovedpo(){ //รายงานเจ้าหนี้การค้า (ค้างจ่าย)(อนุมัติ/แนบไฟล์)

        $data = Input::all();
        // echo "<pre>";
        // print_r($data);
        // exit;

        $emp_code = Session::get('emp_code');

        $db = Connectdb::Databaseall();
        DB::beginTransaction();

        try {

        // if(!empty($data['tranfermoneyidpo'])){
        $tranfermoneyidpo = $data['tranfermoneyidpo'];
        // foreach ($tranfermoneyidpo as $key => $value) {

        $time = date('Y-m-d H:i:s');

        //------Start image------

        // if(Input::hasFile('image'[0])){

        if($data['image'] != ''){

          // echo $_FILES["image"]['name']."<br>";
          // echo $_FILES["image"]['tmp_name']."<br>";
          // echo "1";
          // exit;

          $model = DB::connection('mysql')->table($db['fsctaccount'].'.'.'po_head')->where('id',$tranfermoneyidpo)->update(['status_head'=>2,'image'=>$_FILES["image"]['name']]);

          // for($i=0;$i<count($_FILES['image']['name']);$i++){
          // if($_FILES['image']['name'][0] != ''){
          // move_uploaded_file($_FILES['image']['tmp_name'],"po_head/".$_FILES['image']['name'][0]);

            $uploaddir = 'D:/xampp/htdocs/account/public/Receiptpo/';
            $uploadfile = $uploaddir . basename($_FILES['image']['name']);

            if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadfile)) {
                 // echo "File uploaded successful";
                 // exit;
            }else{
                echo "File upload failed";
                exit;
            }
            // }
          // }

        }
        //------End image-----

            // echo "0";
            // exit;
        //   }
        // }


        DB::commit();

          return redirect('reportaccrued');

        }
          catch (\Exception $e) {
                  DB::rollback();

      			  return $e;

        			// print_r($e);
        			// return 0;
              // something went wrong
        }

      }


      public function serachreportaccruedall(){ //รายงานเจ้าหนี้การค้า (ทั้งหมด)

          $data = Input::all();
          $db = Connectdb::Databaseall();
          // echo "<pre>";
          // print_r($data);
          // exit;

          $branch_id = $data['branch_id'];

          $sql = 'SELECT '.$db['fsctaccount'].'.po_head.*,
                         '.$db['fsctaccount'].'.in_debt.created_at,
                         '.$db['fsctaccount'].'.in_debt.vat_price
                  FROM '.$db['fsctaccount'].'.po_head

                  INNER JOIN  '.$db['fsctaccount'].'.in_debt
                      ON '.$db['fsctaccount'].'.po_head.id = '.$db['fsctaccount'].'.in_debt.id_po

                  WHERE '.$db['fsctaccount'].'.po_head.branch_id = '.$branch_id.'
                    AND '.$db['fsctaccount'].'.po_head.type_po IN (1)
                    AND '.$db['fsctaccount'].'.po_head.status_head NOT IN (99)
                    ';
          $datatresult = DB::connection('mysql')->select($sql);
          // echo "<pre>";
          // print_r($datatresult);
          // exit;

          return view('reportaccruedall',[
            'data'=>$datatresult,
            'query'=>true,
          //   'datepicker'=>$data['datepicker'],
            'branch_id'=>$branch_id,
          //   'datepicker2'=>$datetime
          ]);

      }


      public function serachreportaccruedtransfer(){ //รายงานเจ้าหนี้การค้า (โอนแล้ว)

          $data = Input::all();
          $db = Connectdb::Databaseall();
          // echo "<pre>";
          // print_r($data);
          // exit;

          $branch_id = $data['branch_id'];

          $sql = 'SELECT '.$db['fsctaccount'].'.po_head.*,
                         '.$db['fsctaccount'].'.in_debt.created_at,
                         '.$db['fsctaccount'].'.in_debt.vat_price
                  FROM '.$db['fsctaccount'].'.po_head

                  INNER JOIN  '.$db['fsctaccount'].'.in_debt
                      ON '.$db['fsctaccount'].'.po_head.id = '.$db['fsctaccount'].'.in_debt.id_po

                  WHERE '.$db['fsctaccount'].'.po_head.branch_id = '.$branch_id.'
                    AND '.$db['fsctaccount'].'.po_head.type_po IN (1)
                    AND '.$db['fsctaccount'].'.po_head.status_head NOT IN (0 , 1, 99)
                    ';
          $datatresult = DB::connection('mysql')->select($sql);
          // echo "<pre>";
          // print_r($datatresult);
          // exit;

          return view('reportaccruedtransfer',[
            'data'=>$datatresult,
            'query'=>true,
          //   'datepicker'=>$data['datepicker'],
            'branch_id'=>$branch_id,
          //   'datepicker2'=>$datetime
          ]);

      }

      public function serachreporttaxbuy(){ //รายงานภาษีซื้อ

          $data = Input::all();
          $db = Connectdb::Databaseall();
          // echo "<pre>";
          // print_r($data);
          // exit;

          $datepicker = explode("-",trim(($data['reservation'])));

          // $start_date = $datepicker[0];
          $e1 = explode("/",trim(($datepicker[0])));
                  if(count($e1) > 0) {
                      $start_date = $e1[2] . '-' . $e1[0] . '-' . $e1[1]; //ปี - เดือน - วัน
                  }

          // $end_date = $datepicker[1];
          $e2 = explode("/",trim(($datepicker[1])));
                  if(count($e2) > 0) {
                      $end_date = $e2[2] . '-' . $e2[0] . '-' . $e2[1]; //ปี - เดือน - วัน
                  }

          // $branch_id = $data['branch_id'];
          $branch_id = $data['branch_id'];

          // echo "<pre>";
          // print_r($start_date);
          // print_r($end_date);
          // exit;

          // $sql = 'SELECT '.$db['fsctaccount'].'.inform_po_mainhead.*
          //
          //         FROM '.$db['fsctaccount'].'.inform_po_mainhead
          //
          //         WHERE '.$db['fsctaccount'].'.inform_po_mainhead.branch_id = '.$branch_id.'
          //           AND '.$db['fsctaccount'].'.inform_po_mainhead.datebill  BETWEEN "'.$start_date.'" AND  "'.$end_date.'"
          //           AND '.$db['fsctaccount'].'.inform_po_mainhead.status NOT IN (99)
          //           AND '.$db['fsctaccount'].'.inform_po_mainhead.vat_percent IN (7)
          //        ';
          //
          // $datatresult = DB::connection('mysql')->select($sql);
          // echo "<pre>";
          // print_r($datatresult);
          // exit;
          return view('reporttaxbuy',[
            'query'=>true,
            'datepicker'=>$data['reservation'],
            'branch_id'=>$branch_id,
            'data'=>$data,
          //   'datepicker2'=>$datetime
          ]);

      }


      public function serachreportpaycash(){ //รายงานชำระค่าสินค้าและบริการ (เงินสด/เงินโอน)

        $data = Input::all();
        $db = Connectdb::Databaseall();
        // echo "<pre>";
        // print_r($data);
        // exit;

        $datepicker = explode("-",trim(($data['reservation'])));

        // $start_date = $datepicker[0];
        $e1 = explode("/",trim(($datepicker[0])));
                if(count($e1) > 0) {
                    $start_date = $e1[2] . '-' . $e1[0] . '-' . $e1[1]; //ปี - เดือน - วัน
                }

        // $end_date = $datepicker[1];
        $e2 = explode("/",trim(($datepicker[1])));
                if(count($e2) > 0) {
                    $end_date = $e2[2] . '-' . $e2[0] . '-' . $e2[1]; //ปี - เดือน - วัน
                }

        // $branch_id = $data['branch_id'];
        $branch_id = $data['branch_id'];

        // echo "<pre>";
        // print_r($start_date);
        // print_r($end_date);
        // exit;

        $sql = 'SELECT '.$db['fsctaccount'].'.inform_po_mainhead.*

                FROM '.$db['fsctaccount'].'.inform_po_mainhead

                WHERE '.$db['fsctaccount'].'.inform_po_mainhead.branch_id = '.$branch_id.'
                  AND '.$db['fsctaccount'].'.inform_po_mainhead.datebill  BETWEEN "'.$start_date.'" AND  "'.$end_date.'"
                  AND '.$db['fsctaccount'].'.inform_po_mainhead.status NOT IN (99)
                  AND '.$db['fsctaccount'].'.inform_po_mainhead.type IN (1)
               ';

        $datatresult = DB::connection('mysql')->select($sql);
        // echo "<pre>";
        // print_r($datatresult);
        // exit;

        return view('reportpaycash',[
          'data'=>$datatresult,
          'query'=>true,
          'datepicker'=>$data['reservation'],
          'branch_id'=>$branch_id,
        //   'datepicker2'=>$datetime
        ]);

      }


      public function serachreportpaycredit(){ //รายงานชำระค่าสินค้าและบริการ (เงินเชื่อ)

        $data = Input::all();
        $db = Connectdb::Databaseall();
        // echo "<pre>";
        // print_r($data);
        // exit;

        $datepicker = explode("-",trim(($data['reservation'])));

        // $start_date = $datepicker[0];
        $e1 = explode("/",trim(($datepicker[0])));
                if(count($e1) > 0) {
                    $start_date = $e1[2] . '-' . $e1[0] . '-' . $e1[1]; //ปี - เดือน - วัน
                }

        // $end_date = $datepicker[1];
        $e2 = explode("/",trim(($datepicker[1])));
                if(count($e2) > 0) {
                    $end_date = $e2[2] . '-' . $e2[0] . '-' . $e2[1]; //ปี - เดือน - วัน
                }

        // $branch_id = $data['branch_id'];
        $branch_id = $data['branch_id'];

        // echo "<pre>";
        // print_r($start_date);
        // print_r($end_date);
        // exit;

        $sql = 'SELECT '.$db['fsctaccount'].'.inform_po_mainhead.*

                FROM '.$db['fsctaccount'].'.inform_po_mainhead

                WHERE '.$db['fsctaccount'].'.inform_po_mainhead.branch_id = '.$branch_id.'
                  AND '.$db['fsctaccount'].'.inform_po_mainhead.datebill  BETWEEN "'.$start_date.'" AND  "'.$end_date.'"
                  AND '.$db['fsctaccount'].'.inform_po_mainhead.status NOT IN (99)
                  AND '.$db['fsctaccount'].'.inform_po_mainhead.type IN (2)
               ';

        $datatresult = DB::connection('mysql')->select($sql);
        // echo "<pre>";
        // print_r($datatresult);
        // exit;

        return view('reportpaycredit',[
          'data'=>$datatresult,
          'query'=>true,
          'datepicker'=>$data['reservation'],
          'branch_id'=>$branch_id,
        //   'datepicker2'=>$datetime
        ]);

      }































}
