<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Api\Connectdb;
use App\Api\Accountcenter;
use App\Api\Maincenter;
use App\Api\Vendorcenter;
use App\Api\Datetime;

class ExcelController extends Controller
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

     public function excelreportaccruedall() { //รายงานเจ้าหนี้การค้า (ทั้งหมด)

				$data = Input::all();
				$db = Connectdb::Databaseall();
        // echo "<pre>";
        // print_r($data);
        // exit;

        $type = 'xls';

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

				$dataall = DB::connection('mysql')->select($sql);
				// echo "<pre>";
				// print_r($dataall);
				// exit;
				// echo "======";
				$arrNewdata = [];
				$sumrenttotal = 0;
				$i =1;
				$j=0;

				foreach ($dataall as $key => $value) {

						$arrNewdata[$j]['วันที่ใบแจ้งหนี้'] = $value->created_at;



            $modelsupplier = Maincenter::getdatasupplier($value->supplier_id);
            if($modelsupplier){
              $arrNewdata[$j]['เจ้าหนี้การค้า'] = $modelsupplier[0]->pre;
              // echo ($modelsupplier[0]->pre);
              // echo ($modelsupplier[0]->name_supplier);
            }

            $modelpodetail = Maincenter::getdatapodetail($value->id);
            if($modelpodetail){
              $arrNewdata[$j]['รายการ'] = $modelpodetail[0]->list;
              // echo ($modelpodetail[0]->list);
            }

						$arrNewdata[$j]['ยอดต้องชำระ'] = $value->vat_price;

            if($modelsupplier){
              $terms_id = $modelsupplier[0]->terms_id;

              $modelsupplierterms = Maincenter::getdatasupplierterms($terms_id);
              if($modelsupplierterms){
                // echo ($modelsupplierterms[0]->day);

                $day = $modelsupplierterms[0]->day;
                $newDate = date('d-m-Y', strtotime($value->created_at ." +$day day"));
                $arrNewdata[$j]['วันที่ครบกำหนด credit'] = $newDate;
                // echo $newDate;

              }

            }

							$i++;
							$j++;
				}

			// echo "<pre>";
			// print_r($arrNewdata);
			// exit;
			// echo "======";
			// $arr = [
			// 					['data2', 'data2'],
			// 					['data2', 'data2']
			// 			 ];
		  // print_r($arr);
			// exit;
			return Excel::create('รายงานเจ้าหนี้การค้า (ทั้งหมด)', function($excel) use ($arrNewdata) {

						$excel->sheet('Sheetname', function($sheet) use ($arrNewdata) {

							// $arr = [ ['data2', 'data2'],
							// 				 ['data2', 'data2']
							// 			 ];

						$sheet->fromArray($arrNewdata);

				});

  		})

      ->download($type);
  	  }


      public function excelreportaccrued() { //รายงานเจ้าหนี้การค้า (ค้างจ่าย)

 				$data = Input::all();
 				$db = Connectdb::Databaseall();
         // echo "<pre>";
         // print_r($data);
         // exit;

         $type = 'xls';

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

 				$dataall = DB::connection('mysql')->select($sql);
 				// echo "<pre>";
 				// print_r($dataall);
 				// exit;
 				// echo "======";
 				$arrNewdata = [];
 				$sumrenttotal = 0;
 				$i =1;
 				$j=0;

 				foreach ($dataall as $key => $value) {

 						$arrNewdata[$j]['วันที่ใบแจ้งหนี้'] = $value->created_at;



             $modelsupplier = Maincenter::getdatasupplier($value->supplier_id);
             if($modelsupplier){
               $arrNewdata[$j]['เจ้าหนี้การค้า'] = $modelsupplier[0]->pre;
               // echo ($modelsupplier[0]->pre);
               // echo ($modelsupplier[0]->name_supplier);
             }

             $modelpodetail = Maincenter::getdatapodetail($value->id);
             if($modelpodetail){
               $arrNewdata[$j]['รายการ'] = $modelpodetail[0]->list;
               // echo ($modelpodetail[0]->list);
             }

 						$arrNewdata[$j]['ยอดต้องชำระ'] = $value->vat_price;

             if($modelsupplier){
               $terms_id = $modelsupplier[0]->terms_id;

               $modelsupplierterms = Maincenter::getdatasupplierterms($terms_id);
               if($modelsupplierterms){
                 // echo ($modelsupplierterms[0]->day);

                 $day = $modelsupplierterms[0]->day;
                 $newDate = date('d-m-Y', strtotime($value->created_at ." +$day day"));
                 $arrNewdata[$j]['วันที่ครบกำหนด credit'] = $newDate;
                 // echo $newDate;

               }

             }

 							$i++;
 							$j++;
 				}

 			// echo "<pre>";
 			// print_r($arrNewdata);
 			// exit;
 			// echo "======";
 			// $arr = [
 			// 					['data2', 'data2'],
 			// 					['data2', 'data2']
 			// 			 ];
 		  // print_r($arr);
 			// exit;
 			return Excel::create('รายงานเจ้าหนี้การค้า (ค้างจ่าย)', function($excel) use ($arrNewdata) {

 						$excel->sheet('Sheetname', function($sheet) use ($arrNewdata) {

 							// $arr = [ ['data2', 'data2'],
 							// 				 ['data2', 'data2']
 							// 			 ];

 						$sheet->fromArray($arrNewdata);

 				});

   		})

       ->download($type);
   	  }


      public function excelreportaccruedtransfer() { //รายงานเจ้าหนี้การค้า (โอนแล้ว)

 				$data = Input::all();
 				$db = Connectdb::Databaseall();
         // echo "<pre>";
         // print_r($data);
         // exit;

         $type = 'xls';

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

 				$dataall = DB::connection('mysql')->select($sql);
 				// echo "<pre>";
 				// print_r($dataall);
 				// exit;
 				// echo "======";
 				$arrNewdata = [];
 				$sumrenttotal = 0;
 				$i =1;
 				$j=0;

 				foreach ($dataall as $key => $value) {

 						$arrNewdata[$j]['วันที่ใบแจ้งหนี้'] = $value->created_at;



             $modelsupplier = Maincenter::getdatasupplier($value->supplier_id);
             if($modelsupplier){
               $arrNewdata[$j]['เจ้าหนี้การค้า'] = $modelsupplier[0]->pre;
               // echo ($modelsupplier[0]->pre);
               // echo ($modelsupplier[0]->name_supplier);
             }

             $modelpodetail = Maincenter::getdatapodetail($value->id);
             if($modelpodetail){
               $arrNewdata[$j]['รายการ'] = $modelpodetail[0]->list;
               // echo ($modelpodetail[0]->list);
             }

 						$arrNewdata[$j]['ยอดต้องชำระ'] = $value->vat_price;

             if($modelsupplier){
               $terms_id = $modelsupplier[0]->terms_id;

               $modelsupplierterms = Maincenter::getdatasupplierterms($terms_id);
               if($modelsupplierterms){
                 // echo ($modelsupplierterms[0]->day);

                 $day = $modelsupplierterms[0]->day;
                 $newDate = date('d-m-Y', strtotime($value->created_at ." +$day day"));
                 $arrNewdata[$j]['วันที่ครบกำหนด credit'] = $newDate;
                 // echo $newDate;

               }

             }

 							$i++;
 							$j++;
 				}

 			// echo "<pre>";
 			// print_r($arrNewdata);
 			// exit;
 			// echo "======";
 			// $arr = [
 			// 					['data2', 'data2'],
 			// 					['data2', 'data2']
 			// 			 ];
 		  // print_r($arr);
 			// exit;
 			return Excel::create('รายงานเจ้าหนี้การค้า (โอนแล้ว)', function($excel) use ($arrNewdata) {

 						$excel->sheet('Sheetname', function($sheet) use ($arrNewdata) {

 							// $arr = [ ['data2', 'data2'],
 							// 				 ['data2', 'data2']
 							// 			 ];

 						$sheet->fromArray($arrNewdata);

 				});

   		})

       ->download($type);
   	  }


      public function excelreporttaxbuy() { //รายงานภาษีซื้อ

         $data = Input::all();
         $db = Connectdb::Databaseall();
         // echo "<pre>";
         // print_r($data);
         // exit;

         $type = 'xls';

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
                   AND '.$db['fsctaccount'].'.inform_po_mainhead.vat_percent IN (7)
                ';

         $dataall = DB::connection('mysql')->select($sql);
         // echo "<pre>";
         // print_r($dataall);
         // exit;
         // echo "======";

         $arrNewdata = [];
         $sumrenttotal = 0;
         $name = 0;
         $i =1;

         //----- รวม ------
         $sumsubtotal = 0;
         $sumvat = 0;
         $sumgrandtotal = 0;
         $arrNewall = [];
         //----- รวม ------


          //------ รายละเอียดข้างบน --------
          $arrNewdatadetail = [];
  				$t = 0;

  				$modelname = Maincenter::databranchbycode($branch_id);
          $arrNewdatadetail[$t][' '] = ' ';
  				$arrNewdatadetail[$t]['  '] = ' ';
  				$arrNewdatadetail[$t]['   '] = ' ';
  				$arrNewdatadetail[$t]['    '] = ' ';
  				$arrNewdatadetail[$t]['     '] = 'รายงานภาษีซื้อ';
  				$arrNewdatadetail[$t]['      '] = ' ';
  				$arrNewdatadetail[$t]['       '] = ' ';
  				$arrNewdatadetail[$t]['        '] = ' ';
  				$arrNewdatadetail[$t]['         '] = ' ';
  				$arrNewdatadetail[$t]['          '] = ' ';


  				$a =$t + 1;
  				// $datetime = $data[0]->time;
  				$time = (explode("-",$start_date));
  				$dateyear = $time[0];
  				$datemount = $time[1];

          $modelamount = Datetime::mappingMonth($time[1]);
          // echo "<pre>";
          // print_r($modelamount);
          // exit;
          $arrNewdatadetail[$a][' '] = ' ';
  				$arrNewdatadetail[$a]['  '] = ' ';
  				$arrNewdatadetail[$a]['   '] = ' ';
  				$arrNewdatadetail[$a]['    '] = ' ';
  				$arrNewdatadetail[$a]['     '] = 'เดือนภาษี'." ".$modelamount." ".'ปี'." ".$dateyear;
  				$arrNewdatadetail[$a]['      '] = ' ';
  				$arrNewdatadetail[$a]['       '] = ' ';
  				$arrNewdatadetail[$a]['        '] = ' ';
  				$arrNewdatadetail[$a]['         '] = ' ';
  				$arrNewdatadetail[$a]['          '] = ' ';

  				$b = $a +1;
  				// $modelname = Maincenter::databranchbycode($data[0]->branch_id);
  				$arrNewdatadetail[$b][' '] = 'ชื่อผู้ประกอบการ';
          $arrNewdatadetail[$b][' '] = ' ';
  				$arrNewdatadetail[$b]['  '] = ' ';
  				$arrNewdatadetail[$b]['   '] = ' ';
  				$arrNewdatadetail[$b]['    '] = ' ';
  				$arrNewdatadetail[$b]['     '] = 'ชื่อผู้ประกอบการ : '." "."บริษัท ฟ้าใสคอนสตรัคชั่นทูลส์ จำกัด "."(".($modelname[0]->name_branch).")";
  				$arrNewdatadetail[$b]['      '] = ' ';
  				$arrNewdatadetail[$b]['       '] = ' ';
  				$arrNewdatadetail[$b]['        '] = ' ';
  				$arrNewdatadetail[$b]['         '] = ' ';
  				$arrNewdatadetail[$b]['          '] = ' ';

          $c =$b +1;
          $arrNewdatadetail[$c][' '] = ' ';

  				$f =$c +1;
  				$arrNewdatadetail[$f]['ลำดับ'] = 'ลำดับ';
  				$arrNewdatadetail[$f]['ปี/เดือน/วัน'] = 'ปี/เดือน/วัน';
  				$arrNewdatadetail[$f]['เลขที่'] = 'เลขที';
  				$arrNewdatadetail[$f]['ชื่อผู้ซื้อสินค้า/ผู้รับบริการ'] = 'ชื่อผู้ซื้อสินค้า/ผู้รับบริการ';
  				$arrNewdatadetail[$f]['เลขประจำตัวผู้เสียภาษี'] = 'เลขประจำตัวผู้เสียภาษี';
  				$arrNewdatadetail[$f]['สถานประกอบการ'] = 'สถานประกอบการ';
  				$arrNewdatadetail[$f]['มูลค่าสินค้าหรือบริการ'] = 'มูลค่าสินค้าหรือบริการ';
  				$arrNewdatadetail[$f]['จำนวนเงินภาษีมูลค่าเพิ่ม'] = 'จำนวนเงินภาษีมูลค่าเพิ่ม';
  				$arrNewdatadetail[$f]['จำนวนเงินรวมทั้งหมด'] = 'จำนวนเงินรวมทั้งหมด';
  				$arrNewdatadetail[$f]['หมายเหตุ'] = 'หมายเหตุ';

          //------ รายละเอียดข้างบน --------


          // $j=0;
          // $key =$a +1;
          $s=0;

         foreach ($dataall as $key => $value) {

             $arrNewdata[$key]['ลำดับ'] = $i;
             $arrNewdata[$key]['ปี/เดือน/วัน'] = $value->datebill;
             $arrNewdata[$key]['เลขที่'] = $value->bill_no;

             $modelsupplier = Maincenter::getdatasupplierpo($value->po_id);
                 if($modelsupplier){
                   // echo ($modelsupplier[0]->pre);
                   // echo ($modelsupplier[0]->name_supplier);
                   if($modelsupplier[0]->pre){
                   $name = $modelsupplier[0]->pre." ".$modelsupplier[0]->name_supplier;

                   $arrNewdata[$key]['ชื่อผู้ซื้อสินค้า/ผู้รับบริการ'] = $name;
                   }else {
                     $arrNewdata[$key]['ชื่อผู้ซื้อสินค้า/ผู้รับบริการ'] = $modelsupplier[0]->name_supplier;
                   }

                   $arrNewdata[$key]['เลขประจำตัวผู้เสียภาษี'] = $modelsupplier[0]->tax_id;
                   $arrNewdata[$key]['สถานประกอบการ'] = $modelsupplier[0]->type_branch;
             }

             $vat = (($value->vat_price * 7 )/ 107);

             $arrNewdata[$key]['มูลค่าสินค้าหรือบริการ'] = $value->vat_price - $vat;
             $sumsubtotal = $sumsubtotal + ($value->vat_price - $vat);

             $arrNewdata[$key]['จำนวนเงินภาษีมูลค่าเพิ่ม'] = $vat;
             $sumvat = $sumvat + $vat;

             $arrNewdata[$key]['จำนวนเงินรวมทั้งหมด'] = $value->vat_price;
             $sumgrandtotal = $sumgrandtotal + $value->vat_price;

             $arrNewdata[$key]['หมายเหตุ'] = "-";

               $i++;
               $key++;
         }

         // $s = $key + 1;

         $arrNewall[$s]['ลำดับ'] = " ";
         $arrNewall[$s]['ปี/เดือน/วัน'] = " ";
         $arrNewall[$s]['เลขที่'] = " ";
         $arrNewall[$s]['ชื่อผู้ซื้อสินค้า/ผู้รับบริการ'] = " ";
         $arrNewall[$s]['เลขประจำตัวผู้เสียภาษี'] = " ";
         $arrNewall[$s]['สถานประกอบการ'] = "รวม";
         $arrNewall[$s]['มูลค่าสินค้าหรือบริการ'] = $sumsubtotal;
         $arrNewall[$s]['จำนวนเงินภาษีมูลค่าเพิ่ม'] = $sumvat;
         $arrNewall[$s]['จำนวนเงินรวมทั้งหมด'] = $sumgrandtotal;
         $arrNewall[$s]['หมายเหตุ'] = " ";

       // echo "<pre>";
       // print_r($arrNewall);
       // exit;
       // echo "======";

       // $arr = [
       // 					['data2', 'data2'],
       // 					['data2', 'data2']
       // 			 ];
       // print_r($arr);
       // exit;

       if($arrNewdatadetail || $arrNewdata || $arrNewall){
    	 $result = array_merge($arrNewdatadetail,$arrNewdata,$arrNewall);
       }

       return Excel::create('รายงานภาษีซื้อ', function($excel) use ($result) {

             $excel->sheet('Sheetname', function($sheet) use ($result) {

               // $arr = [ ['data2', 'data2'],
               // 				 ['data2', 'data2']
               // 			 ];

             $sheet->fromArray($result);

         });

     })

     ->download($type);
     }


     public function excelledger_branch() { //แยกประเภทบัญชี (รายสาขา)

        $data = Input::all();
        $db = Connectdb::Databaseall();
        // echo "<pre>";
        // print_r($data);
        // exit;

        $type = 'xls';

        $datepicker = explode("-",trim(($data['reservation'])));

        // $start_date = $datepicker[0];
        $e1 = explode("/",trim(($datepicker[0])));
                if(count($e1) > 0) {
                    $start_date = $e1[2] . '-' . $e1[0] . '-' . $e1[1]." 00:00:00"; //ปี - เดือน - วัน
                    $start_date1 = $e1[2] . '-' . $e1[0] . '-' . $e1[1]; //ปี - เดือน - วัน
                }

        // $end_date = $datepicker[1];
        $e2 = explode("/",trim(($datepicker[1])));
                if(count($e2) > 0) {
                    $end_date = $e2[2] . '-' . $e2[0] . '-' . $e2[1]." 23:59:59"; //ปี - เดือน - วัน
                    $end_date2 = $e2[2] . '-' . $e2[0] . '-' . $e2[1]; //ปี - เดือน - วัน
                }

        $branch_id = $data['branch_id'];
        $acc_code = $data['acc_code'];

        $sql = 'SELECT '.$db['fsctaccount'].'.ledger.*
                FROM '.$db['fsctaccount'].'.ledger

                WHERE '.$db['fsctaccount'].'.ledger.branch = '.$branch_id.'
                  AND '.$db['fsctaccount'].'.ledger.acc_code = '.$acc_code.'
                  AND '.$db['fsctaccount'].'.ledger.timestamp BETWEEN "'.$start_date.'" AND  "'.$end_date.'"
                  AND '.$db['fsctaccount'].'.ledger.status != 99
                  ';
        $datatresult = DB::connection('mysql')->select($sql);
        // echo "<pre>";
        // print_r($dataall);
        // exit;
        // echo "======";

        $arrNewdata = [];
        $sumrenttotal = 0;
        $name = 0;
        $i =1;

        //----- รวม ------
        $sumsubtotal = 0;
        $sumvat = 0;
        $sumgrandtotal = 0;
        $arrNewall = [];
        //----- รวม ------


         //------ รายละเอียดข้างบน --------
         $arrNewdatadetail = [];
         $t = 0;

         $modelname = Maincenter::databranchbycode($branch_id);
         $arrNewdatadetail[$t][' '] = ' ';
         $arrNewdatadetail[$t]['  '] = ' ';
         $arrNewdatadetail[$t]['   '] = ' ';
         $arrNewdatadetail[$t]['    '] = ' ';
         $arrNewdatadetail[$t]['     '] = 'บจก.ฟ้าใสคอนสตรัคชั่นทูลส์ จำกัด';
         $arrNewdatadetail[$t]['      '] = ' ';
         $arrNewdatadetail[$t]['       '] = ' ';
         $arrNewdatadetail[$t]['        '] = ' ';
         $arrNewdatadetail[$t]['         '] = ' ';
         $arrNewdatadetail[$t]['          '] = ' ';


         $a =$t + 1;
         // $datetime = $data[0]->time;
         // $time = (explode("-",$start_date));
         // $dateyear = $time[0];
         // $datemount = $time[1];
         //
         // $modelamount = Datetime::mappingMonth($time[1]);
         // echo "<pre>";
         // print_r($modelamount);
         // exit;
         $arrNewdatadetail[$a][' '] = ' ';
         $arrNewdatadetail[$a]['  '] = ' ';
         $arrNewdatadetail[$a]['   '] = ' ';
         $arrNewdatadetail[$a]['    '] = ' ';
         $arrNewdatadetail[$a]['     '] = 'ตั้งแต่วันที่'." ".$start_date1." ".'จนถึงวันที่'." ".$end_date2;
         $arrNewdatadetail[$a]['      '] = ' ';
         $arrNewdatadetail[$a]['       '] = ' ';
         $arrNewdatadetail[$a]['        '] = ' ';
         $arrNewdatadetail[$a]['         '] = ' ';
         $arrNewdatadetail[$a]['          '] = ' ';

         $b = $a +1;
         // $modelname = Maincenter::databranchbycode($data[0]->branch_id);
         $arrNewdatadetail[$b][' '] = 'ชื่อผู้ประกอบการ';
         $arrNewdatadetail[$b][' '] = ' ';
         $arrNewdatadetail[$b]['  '] = ' ';
         $arrNewdatadetail[$b]['   '] = ' ';
         $arrNewdatadetail[$b]['    '] = ' ';
         $arrNewdatadetail[$b]['     '] = 'ชื่อผู้ประกอบการ : '." "."บริษัท ฟ้าใสคอนสตรัคชั่นทูลส์ จำกัด "."(".($modelname[0]->name_branch).")";
         $arrNewdatadetail[$b]['      '] = ' ';
         $arrNewdatadetail[$b]['       '] = ' ';
         $arrNewdatadetail[$b]['        '] = ' ';
         $arrNewdatadetail[$b]['         '] = ' ';
         $arrNewdatadetail[$b]['          '] = ' ';

         $c =$b +1;
         $arrNewdatadetail[$c][' '] = ' ';

         $f =$c +1;
         $arrNewdatadetail[$f]['No.'] = 'No.';
         $arrNewdatadetail[$f]['Type'] = 'Type';
         $arrNewdatadetail[$f]['Date'] = 'Date';
         $arrNewdatadetail[$f]['Num'] = 'Num';
         $arrNewdatadetail[$f]['Adj.'] = 'Adj.';
         $arrNewdatadetail[$f]['Memo'] = 'Memo';
         $arrNewdatadetail[$f]['Split'] = 'Split';
         $arrNewdatadetail[$f]['Debit'] = 'Debit';
         $arrNewdatadetail[$f]['Credit'] = 'Credit';
         $arrNewdatadetail[$f]['Balance'] = 'Balance';

         //------ รายละเอียดข้างบน --------


         // $j=0;
         // $key =$a +1;
         $s=0;

        foreach ($datatresult as $key => $value) {

            $arrNewdata[$key]['ลำดับ'] = $i;
            $arrNewdata[$key]['ปี/เดือน/วัน'] = $value->datebill;
            $arrNewdata[$key]['เลขที่'] = $value->bill_no;

            $modelsupplier = Maincenter::getdatasupplierpo($value->po_id);
                if($modelsupplier){
                  // echo ($modelsupplier[0]->pre);
                  // echo ($modelsupplier[0]->name_supplier);
                  if($modelsupplier[0]->pre){
                  $name = $modelsupplier[0]->pre." ".$modelsupplier[0]->name_supplier;

                  $arrNewdata[$key]['ชื่อผู้ซื้อสินค้า/ผู้รับบริการ'] = $name;
                  }else {
                    $arrNewdata[$key]['ชื่อผู้ซื้อสินค้า/ผู้รับบริการ'] = $modelsupplier[0]->name_supplier;
                  }

                  $arrNewdata[$key]['เลขประจำตัวผู้เสียภาษี'] = $modelsupplier[0]->tax_id;
                  $arrNewdata[$key]['สถานประกอบการ'] = $modelsupplier[0]->type_branch;
            }

            $vat = (($value->vat_price * 7 )/ 107);

            $arrNewdata[$key]['มูลค่าสินค้าหรือบริการ'] = $value->vat_price - $vat;
            $sumsubtotal = $sumsubtotal + ($value->vat_price - $vat);

            $arrNewdata[$key]['จำนวนเงินภาษีมูลค่าเพิ่ม'] = $vat;
            $sumvat = $sumvat + $vat;

            $arrNewdata[$key]['จำนวนเงินรวมทั้งหมด'] = $value->vat_price;
            $sumgrandtotal = $sumgrandtotal + $value->vat_price;

            $arrNewdata[$key]['หมายเหตุ'] = "-";

              $i++;
              $key++;
        }

        // $s = $key + 1;

        $arrNewall[$s]['ลำดับ'] = " ";
        $arrNewall[$s]['ปี/เดือน/วัน'] = " ";
        $arrNewall[$s]['เลขที่'] = " ";
        $arrNewall[$s]['ชื่อผู้ซื้อสินค้า/ผู้รับบริการ'] = " ";
        $arrNewall[$s]['เลขประจำตัวผู้เสียภาษี'] = " ";
        $arrNewall[$s]['สถานประกอบการ'] = "รวม";
        $arrNewall[$s]['มูลค่าสินค้าหรือบริการ'] = $sumsubtotal;
        $arrNewall[$s]['จำนวนเงินภาษีมูลค่าเพิ่ม'] = $sumvat;
        $arrNewall[$s]['จำนวนเงินรวมทั้งหมด'] = $sumgrandtotal;
        $arrNewall[$s]['หมายเหตุ'] = " ";

      // echo "<pre>";
      // print_r($arrNewall);
      // exit;
      // echo "======";

      // $arr = [
      // 					['data2', 'data2'],
      // 					['data2', 'data2']
      // 			 ];
      // print_r($arr);
      // exit;

      if($arrNewdatadetail || $arrNewdata || $arrNewall){
      $result = array_merge($arrNewdatadetail,$arrNewdata,$arrNewall);
      }

      return Excel::create('แยกประเภทบัญชี', function($excel) use ($result) {

            $excel->sheet('Sheetname', function($sheet) use ($result) {

              // $arr = [ ['data2', 'data2'],
              // 				 ['data2', 'data2']
              // 			 ];

            $sheet->fromArray($result);

        });

     })

     ->download($type);
     }




































}
