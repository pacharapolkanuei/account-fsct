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

class BuyController extends Controller
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

     // public function reportaccrued(){ //รายงานเจ้าหนี้การค้า (ค้างจ่าย)
     //
     //        return view('reportaccrued');
     // }

     public function testcash(){

            return view('testcash');
     }


     public function reserve_money(){ //จ่ายเงินสำรอง

       $data = Input::all();
       // echo "<pre>";
       // print_r($data);
       // exit;
       $db = Connectdb::Databaseall();
       $date = date('Y-m-d');

       $branch_id = Session::get('brcode');
       $emp_code = Session::get('emp_code');

       $sql = 'SELECT '.$db['fsctaccount'].'.reserve_withdraw.*,
                      '.$db['fsctaccount'].'.listpaypre.listname
               FROM '.$db['fsctaccount'].'.reserve_withdraw

               INNER JOIN  '.$db['fsctaccount'].'.listpaypre
                  ON '.$db['fsctaccount'].'.reserve_withdraw.list = '.$db['fsctaccount'].'.listpaypre.id

               WHERE '.$db['fsctaccount'].'.reserve_withdraw.branch = '.$branch_id.'
                 ';
       $datatresult = DB::connection('mysql')->select($sql);
       // echo "<pre>";
       // print_r($datatresult);
       // exit;

       return view('reserve_money',[
         'data'=>$datatresult,
         'query'=>true,
       //   'datepicker'=>$data['datepicker'],
         'emp_code'=>$emp_code,
         'date'=>date('Y-m-d'),
         'branch_id'=>$branch_id,
       ]);
     }


     // public function serachreportaccrued(){ //รายงานเจ้าหนี้การค้า (ค้างจ่าย)
     //
     //     $data = Input::all();
     //     $db = Connectdb::Databaseall();
     //     // echo "<pre>";
     //     // print_r($data);
     //     // exit;
     //
     //     // $datepicker = explode("/",trim(($data['datepicker'])));
     //     // if(count($datepicker) > 0) {
     //     //     $datetime = $datepicker[2] . '-' . $datepicker[1] . '-' . $datepicker[0]; //วัน - เดือน - ปี
     //     // }
     //     //
     //     $branch_id = $data['branch_id'];
     //
     //     $sql = 'SELECT '.$db['fsctaccount'].'.po_head.*,
     //                    '.$db['fsctaccount'].'.in_debt.created_at,
     //                    '.$db['fsctaccount'].'.in_debt.vat_price
     //             FROM '.$db['fsctaccount'].'.po_head
     //
     //             INNER JOIN  '.$db['fsctaccount'].'.in_debt
     //                 ON '.$db['fsctaccount'].'.po_head.id = '.$db['fsctaccount'].'.in_debt.id_po
     //
     //             WHERE '.$db['fsctaccount'].'.po_head.branch_id = '.$branch_id.'
     //               AND '.$db['fsctaccount'].'.po_head.type_po IN (1)
     //               AND '.$db['fsctaccount'].'.po_head.status_head NOT IN (99)
     //               ';
     //     $datatresult = DB::connection('mysql')->select($sql);
     //     // echo "<pre>";
     //     // print_r($datatresult);
     //     // exit;
     //
     //     return view('reportaccrued',[
     //       'data'=>$datatresult,
     //       'query'=>true,
     //     //   'datepicker'=>$data['datepicker'],
     //       'branch_id'=>$branch_id,
     //     //   'datepicker2'=>$datetime
     //     ]);
     //
     // }


     // public function saveapprovedpo(){ //รายงานเจ้าหนี้การค้า (ค้างจ่าย)(อนุมัติ/แนบไฟล์)
     //
     //    $data = Input::all();
     //    // echo "<pre>";
     //    // print_r($data);
     //    // exit;
     //
     //    $emp_code = Session::get('emp_code');
     //
     //    $db = Connectdb::Databaseall();
     //    DB::beginTransaction();
     //
     //    try {
     //
     //    // if(!empty($data['tranfermoneyidpo'])){
     //    $tranfermoneyidpo = $data['tranfermoneyidpo'];
     //    // foreach ($tranfermoneyidpo as $key => $value) {
     //
     //    $time = date('Y-m-d H:i:s');
     //
     //    //------Start image------
     //
     //    // if(Input::hasFile('image'[0])){
     //
     //    if($data['image'] != ''){
     //
     //      // echo $_FILES["image"]['name']."<br>";
     //      // echo $_FILES["image"]['tmp_name']."<br>";
     //      // echo "1";
     //      // exit;
     //
     //      $model = DB::connection('mysql')->table($db['fsctaccount'].'.'.'po_head')->where('id',$tranfermoneyidpo)->update(['status_head'=>2,'image'=>$_FILES["image"]['name']]);
     //
     //      // for($i=0;$i<count($_FILES['image']['name']);$i++){
     //      // if($_FILES['image']['name'][0] != ''){
     //      // move_uploaded_file($_FILES['image']['tmp_name'],"po_head/".$_FILES['image']['name'][0]);
     //
     //        $uploaddir = 'D:/xampp/htdocs/account/public/Receiptpo/';
     //        $uploadfile = $uploaddir . basename($_FILES['image']['name']);
     //
     //        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadfile)) {
     //             // echo "File uploaded successful";
     //             // exit;
     //        }else{
     //            echo "File upload failed";
     //            exit;
     //        }
     //        // }
     //      // }
     //
     //    }
     //    //------End image-----
     //
     //        // echo "0";
     //        // exit;
     //    //   }
     //    // }
     //
     //
     //    DB::commit();
     //
     //      return redirect('reportaccrued');
     //
     //    }
     //      catch (\Exception $e) {
     //              DB::rollback();
     //
     //  			  return $e;
     //
     //    			// print_r($e);
     //    			// return 0;
     //          // something went wrong
     //    }
     //
     //  }


      public function savecash(){ //ตั้งเบิกเงินสำรองจ่าย

          $data= Input::all();
          // echo "<pre>";
          // print_r($data);
          // exit;
          $db = Connectdb::Databaseall();

          $branch_id = Session::get('brcode');
          $emp_code = Session::get('emp_code');

          $list = $data['list'];
          $amount = $data['amount'];
          // $vat = $data['vat'];
          // $vat_money = $data['vat_money'];
          // $total = $data['total'];
          $id_compay = $data['id_compay'];
          $branch = $data['brid'];
          $code_emp = $data['empcode'];
          $note = $data['note'];
          $datepicker = $data['datepicker'];

          $arrInsert = ['id'=>'',
                        'datetime'=>$datepicker,
                        'list'=>$list,
                        'amount'=>$amount,
                        // 'vat'=>$vat,
                        // 'vat_money'=>$vat_money,
                        // 'total'=>$total,
                        'status'=>1,
                        'po_ref'=>0,
                        'id_compay'=>$id_compay,
                        'branch'=>$branch,
                        'code_emp'=>$code_emp,
                        'note'=>$note
                        ];
         // echo "<pre>";
         // print_r($arrInsert);
         // exit;

         $tranfermodel = DB::connection('mysql')->table($db['fsctaccount'].'.reserve_withdraw')->insertGetId($arrInsert);
         // echo "<pre>";
         // print_r($tranfermodel);
         // exit;

         $sql = 'SELECT '.$db['fsctaccount'].'.reserve_withdraw.*,
                        '.$db['fsctaccount'].'.listpaypre.listname
                FROM '.$db['fsctaccount'].'.reserve_withdraw

                INNER JOIN  '.$db['fsctaccount'].'.listpaypre
                   ON '.$db['fsctaccount'].'.reserve_withdraw.list = '.$db['fsctaccount'].'.listpaypre.id

                WHERE '.$db['fsctaccount'].'.reserve_withdraw.branch = '.$branch_id.'
                  ';
         $datatresult = DB::connection('mysql')->select($sql);
         // echo "<pre>";
         // print_r($datatresult);
         // exit;

         return view('reserve_money',[
                     'data'=>$datatresult,
                     'query'=>true,
                //   'datepicker'=>$data['datepicker'],
                     'emp_code'=>$emp_code,
                     'branch_id'=>$branch_id,
         ]);
      }


      public function checkdetail(){ //ตั้งเบิกเงินสำรองจ่าย

          $data = Input::all();
          // echo "<pre>";
          // print_r($data);
          // exit;

          $db = Connectdb::Databaseall();
          $emp_code = Session::get('emp_code');
          $id = $data['check'];
          $branch = $data['branch'];

          $model = DB::connection('mysql')->table($db['fsctaccount'].'.'.'reserve_withdraw')->where('id',$id)->update(['status'=>2]);

          $sql = 'SELECT '.$db['fsctaccount'].'.reserve_withdraw.*,
                         '.$db['fsctaccount'].'.listpaypre.listname
                 FROM '.$db['fsctaccount'].'.reserve_withdraw

                 INNER JOIN  '.$db['fsctaccount'].'.listpaypre
                    ON '.$db['fsctaccount'].'.reserve_withdraw.list = '.$db['fsctaccount'].'.listpaypre.id

                 WHERE '.$db['fsctaccount'].'.reserve_withdraw.branch = '.$branch.'
                   ';
          $datatresult = DB::connection('mysql')->select($sql);
          // echo "<pre>";
          // print_r($datatresult);
          // exit;

          return view('reserve_money',[
                      'data'=>$datatresult,
                      'query'=>true,
                 //   'datepicker'=>$data['datepicker'],
                      'emp_code'=>$emp_code,
                      'branch_id'=>$branch,
          ]);
       }


       public function reserve_moneyto(){ //จ่ายเงินสำรอง

         $data = Input::all();
         // echo "<pre>";
         // print_r($data);
         // exit;
         $db = Connectdb::Databaseall();

         $branch_id = Session::get('brcode');
         $emp_code = Session::get('emp_code');

         $sql = 'SELECT '.$db['fsctaccount'].'.reservemoney.*,
                        '.$db['fsctaccount'].'.listpaypre.listname
                 FROM '.$db['fsctaccount'].'.reservemoney

                 INNER JOIN  '.$db['fsctaccount'].'.listpaypre
                    ON '.$db['fsctaccount'].'.reservemoney.list = '.$db['fsctaccount'].'.listpaypre.id

                 WHERE '.$db['fsctaccount'].'.reservemoney.branch = '.$branch_id.'

                   ';
                 // AND '.$db['fsctaccount'].'.reserve_money.status IN (2)
         $datatresult = DB::connection('mysql')->select($sql);
         // echo "<pre>";
         // print_r($datatresult);
         // exit;

         return view('reserve_moneyto',[
           'data'=>$datatresult,
           'query'=>true,
         //   'datepicker'=>$data['datepicker'],
           'emp_code'=>$emp_code,
           'branch_id'=>$branch_id,
         ]);
       }


      public function getmainmaterialbyquotation(){ //จ่ายเงินสำรอง

         $data= Input::all();
         // echo "<pre>";
         // print_r($data);
         // exit;
         $db = Connectdb::Databaseall();

         $sql = 'SELECT '.$db['fsctaccount'].'.reserve_withdraw.amount,
                        '.$db['fsctaccount'].'.reserve_withdraw.list,
                        '.$db['fsctaccount'].'.reserve_withdraw.id
                FROM '.$db['fsctaccount'].'.reserve_withdraw

                INNER JOIN  '.$db['fsctaccount'].'.listpaypre
                   ON '.$db['fsctaccount'].'.reserve_withdraw.list = '.$db['fsctaccount'].'.listpaypre.id

                WHERE '.$db['fsctaccount'].'.reserve_withdraw.branch = "'.$data['branch_id'].'"
                AND '.$db['fsctaccount'].'.reserve_withdraw.id = "'.$data['idtype'].'"
                AND '.$db['fsctaccount'].'.reserve_withdraw.status IN (2)
                  ';
         $model = DB::connection('mysql')->select($sql);

         return $model;
       }


       public function savereservemoney(){ //จ่ายเงินสำรอง

          $data= Input::all();
          // echo "<pre>";
          // print_r($data);
          // exit;
          $db = Connectdb::Databaseall();

          $branch_id = Session::get('brcode');
          $emp_code = Session::get('emp_code');

          $count = DB::connection('mysql2')
      			->table('reservemoney')
      			->get();
          $count_debt = count($count) + 1;
          $number_rsm = "RSM" . date("ym") . sprintf('%04d', $count_debt);

          $datepicker = $data['datepicker'];
          $billno = $data['billno'];
          $list = $data['list0'][0];
          $amount = $data['amount'][0];
          $total = $data['totalreal'];
          $id_compay = $data['id_compay'];
          $branch = $data['brid'];
          $code_emp = $data['empcode'];
          $num = $data['amount_num'];
          $numprice = $data['price'];
          $note = $data['note'];
          $date_bill_no = $data['date_bill_no'];
          $id_list = $data['id_list'][0];

          // echo "<pre>";
          // print_r($number_rsm);
          // exit;

          //update table reserve_withdraw -> status = 3 (เมื่อทำการจ่ายเงินสำรองเรียบร้อย และรอการอนุมัติ)
          $modelupdate = DB::connection('mysql')->table($db['fsctaccount'].'.reserve_withdraw')->where('id',$id_list)->update(['status'=>3]);

          //insert table reservemoney
          $arrInsert = ['id'=>'',
                        'datetime'=>$datepicker,
                        'number_rsm'=>$number_rsm,
                        'bill_no'=>$billno,
                        'list'=>$list,
                        'num'=>$num,
                        'num_price'=>$numprice,
                        'amount'=>$amount,
                        // 'vat'=>$vat,
                        // 'vat_money'=>$vat_money,
                        'total'=>$total,
                        'status'=>1,
                        'po_ref'=>0,
                        'id_compay'=>$id_compay,
                        'branch'=>$branch,
                        'code_emp'=>$code_emp,
                        'date_bill_no'=>$date_bill_no,
                        'note'=>$note
                        ];

         $tranfermodel = DB::connection('mysql')->table($db['fsctaccount'].'.reservemoney')->insertGetId($arrInsert);

         //insert table insertcashrent -> ลงตารางเงินสดย่อยรายวัน และรอการอนุมัติ
         $array = ['id'=>'',
                   'datetimeinsert'=>$datepicker,
                   'money'=>$total,
                   'typedoc'=>14,
                   'emp_code'=>$code_emp,
                   'branch'=>$branch,
                   'status'=>0,
                   'typetranfer'=>1,
                   'log'=>$note,
                   'ref'=>$tranfermodel,
                   'typereftax'=>$tranfermodel
                  ];
         // echo "<pre>";
         // print_r($array);
         // exit;

         $insertmodel = DB::connection('mysql')->table($db['fsctaccount'].'.'.'insertcashrent')->insert($array);
         // echo "<pre>";
         // print_r($insertmodel);
         // exit;


         $sql = 'SELECT '.$db['fsctaccount'].'.reservemoney.*,
                        '.$db['fsctaccount'].'.listpaypre.listname
                 FROM '.$db['fsctaccount'].'.reservemoney

                 INNER JOIN  '.$db['fsctaccount'].'.listpaypre
                    ON '.$db['fsctaccount'].'.reservemoney.list = '.$db['fsctaccount'].'.listpaypre.id

                 WHERE '.$db['fsctaccount'].'.reservemoney.branch = '.$branch_id.'

                   ';
                 // AND '.$db['fsctaccount'].'.reserve_money.status IN (2)
         $datatresult = DB::connection('mysql')->select($sql);
         // echo "<pre>";
         // print_r($datatresult);
         // exit;

         return view('reserve_moneyto',[
           'data'=>$datatresult,
           'query'=>true,
           // 'datepicker'=>$data['datepicker'],
           'emp_code'=>$emp_code,
           'branch_id'=>$branch_id,
         ]);
       }


       public function updatereserve_withdraw($id){ //ยกเลิก / ไม่อนุมัติตั้งเบิกเงินสำรองจ่าย

             $reserve = DB::connection('mysql2')
                     ->table('reserve_withdraw')
                     ->where('id',$id)
                     ->update(['status' => 99]);

             return redirect('/reserve_money');
       }


       public function updatereservemoney($id){ //ยกเลิก / ไม่อนุมัติเงินสำรองจ่าย

             $reserve = DB::connection('mysql2')
                     ->table('reservemoney')
                     ->where('id',$id)
                     ->update(['status' => 99]);

             $reservecash = DB::connection('mysql2')
                     ->table('insertcashrent')
                     ->where('ref',$id)
                     ->update(['status' => 99]);

             return redirect('/reserve_moneyto');
       }


       public function recordreservemoney($id){ //อนุมัติเงินสำรองจ่าย

             $reserve = DB::connection('mysql2')
                     ->table('reservemoney')
                     ->where('id',$id)
                     ->update(['status' => 2]);

             $reservecash = DB::connection('mysql2')
                     ->table('insertcashrent')
                     ->where('ref',$id)
                     ->update(['status' => 1]);

             return redirect('/reserve_moneyto');
       }


       public function insertporef(){ //แนบ PO

          $data = Input::all();
          $db = Connectdb::Databaseall();

          $brcode = Session::get('brcode');
          $emp_code = Session::get('emp_code');
          $idreservemoney = $data['reservemoneyid'];
          $id = $data['ponumber'];
          $bill_no = $data['bill_no'];
          $datepicker = date('Y-m-d H:i:s');
          $date = date('Y-m-d');
          // echo "<pre>";
          // print_r($data);
          // exit;

          $sql = 'SELECT '.$db['fsctaccount'].'.reservemoney.*
                  FROM '.$db['fsctaccount'].'.reservemoney
                  WHERE '.$db['fsctaccount'].'.reservemoney.id = '.$idreservemoney.'
                   ';
          $datasearch = DB::connection('mysql')->select($sql);

          $sqlpo = 'SELECT '.$db['fsctaccount'].'.po_head.*
                  FROM '.$db['fsctaccount'].'.po_head
                  WHERE '.$db['fsctaccount'].'.po_head.po_number = "'.$id.'"
                   ';

          $datapo = DB::connection('mysql')->select($sqlpo);
          // echo "<pre>";
          // print_r($datapo);
          // exit;

          $total = $datasearch[0]->total;
          $note = $datasearch[0]->note;
          $idpo = $datapo[0]->id;

          $sqlupdate = 'UPDATE '.$db['fsctaccount'].'.reservemoney
                        SET po_ref="'.$idpo.'",
                            po_num="'.$id.'",
                      			bill_no="'.$bill_no.'",
                            dateporef="'.$date.'"
                      	WHERE id="'.$idreservemoney.'"
                        ';
          $dataupdate = DB::select($sqlupdate);
          // echo "<pre>";
          // print_r($dataupdate);
          // exit;

          $array = ['id'=>'',
                    'datetimeinsert'=>$datepicker,
                    'money'=>$total,
                    'typedoc'=>16,
                    'emp_code'=>$emp_code,
                    'branch'=>$brcode,
                    'status'=>1,
                    'typetranfer'=>1,
                    'log'=>$note,
                    'ref'=>$idpo,
                    'typereftax'=>$idreservemoney
                    ];

          $insertmodel = DB::connection('mysql')->table($db['fsctaccount'].'.'.'insertcashrent')->insert($array);

          // echo "<pre>";
          // print_r($dataupdate);
          // exit;

          // return view('reserve_moneyto',[
          //   'data'=>$dataupdate,
          //   'query'=>true,
          //   'datepicker'=>$data['reservation'],
          //   'branch_id'=>$branch_id
          //   // 'accontcode'=>$acc_code,
          // //   'datepicker2'=>$datetime
          // ]);

          // $reservecash = DB::connection('mysql2')
          //         ->table('reservemoney')
          //         ->where('id',$idreservemoney)
          //         ->update(['po_ref' =>$id]);

          return redirect('/reserve_moneyto');
    }


    public function getidbill(){

        $data= Input::all();
       // print_r($data);
       // exit;
         $yearnow = date('Y');


        $brcode = Session::get('brcode');
        $db = Connectdb::Databaseall();
        $sql = "SELECT COUNT(id) as idgen FROM $db[fsctaccount].reservemoney WHERE branch_id = '$brcode' AND id_company = '$data[id]' AND year = '$yearnow'";
        $bbr_no_branch = DB::connection('mysql')->select($sql);
        $numberrun = 0;

        $onset =  $bbr_no_branch[0]->idgen;

        if($onset == 0){
            $numberrun = 1;
        }else{
            $numberrun = (int)($onset)+1;
        }

        $yearth = $yearnow + 543;
        $yearth =  substr($yearth,2,2);
        $idgen = 'RSM'.$brcode.$yearth.date('m').str_pad($numberrun, 3, "0", STR_PAD_LEFT);
        $datagen =[ 'idgen'=>$idgen,
            'idnumber'=>$numberrun
        ] ;


        return json_encode($datagen);
    }

































}
