<?php
use  App\Api\Connectdb;
use  App\Api\Accountcenter;
use  App\Api\Maincenter;
use  App\Api\Vendorcenter;

use App\Api\Datetime;
use App\working_company;
use Illuminate\Support\Facades\Input;

?>

<link>
{{--<script type="text/javascript" src = 'js/jquery-ui-1.12.1/jquery-ui.js'></script>--}}
{{--<script type="text/javascript" src = 'js/jquery-ui-1.12.1/jquery-ui.min.js'></script>--}}
<script type="text/javascript" src = 'js/bootbox.min.js'></script>
<script type="text/javascript" src = 'js/validator.min.js'></script>

<script type="text/javascript" src = 'js/jquery.dataTables.min.js'></script>
<script type="text/javascript" src = 'js/dataTables.bootstrap.min.js'></script>
<link rel="stylesheet" type="text/css" href="css/table/dataTables.bootstrap.min.css">

<script type="text/javascript" src = 'js/accountjs/reservemoney.js'></script>

<meta name="csrf-token" content="{{ csrf_token() }}" />
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        @font-face {
            font-family: 'THSarabunNew';
            font-style: normal;
            font-weight: normal;
            src: url("{{ public_path('fonts/THSarabunNew.ttf') }}") format('truetype');
        }
        @font-face {
            font-family: 'THSarabunNew';
            font-style: normal;
            font-weight: bold;
            src: url("{{ public_path('fonts/THSarabunNew Bold.ttf') }}") format('truetype');
        }
        @font-face {
            font-family: 'THSarabunNew';
            font-style: italic;
            font-weight: normal;
            src: url("{{ public_path('fonts/THSarabunNew Italic.ttf') }}") format('truetype');
        }
        @font-face {
            font-family: 'THSarabunNew';
            font-style: italic;
            font-weight: bold;
            src: url("{{ public_path('fonts/THSarabunNew BoldItalic.ttf') }}") format('truetype');
        }

        body {
            font-family: "THSarabunNew";
            font-size: 12px;
        }
        h4 {
            font-family: "THSarabunNew";
        }
        table {
            font-family: "THSarabunNew";
        }
        td,th {
            font-family: "THSarabunNew";
        }

    </style>

<style>
    .modal-ku {
        width: 90%;
        margin: auto;
    }
</style>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->

    <!-- Main content -->


    <section class="content">
        <div class="box box-success">
            <div class="box-body">

            <?php

              $data = Input::all();
              $db = Connectdb::Databaseall();
              // echo "<pre>";
              // print_r($data);
              // exit;

              $datepicker = $data['reservation'];
            ?>

          <div class="row">
              <div class="col-md-12">
                  <div class="box box-primary">
                      <div class="breadcrumbs" id="breadcrumbs">
                          <ul class="breadcrumb">
                              <div align="center">
                              <table width="100%">
                                <tr>
                                  <td align="center" ><b>บริษัท ฟ้าใสคอนสตรัคชั่นทูลส์ จำกัด </b></td>
                                </tr>

                                <tr>
                                  <td align="center" ><b>งบกำไรขาดทุน</b></td>
                                </tr>

                                <tr>
                                  <td align="center" ><b>สำหรับปีสิ้นสุดวันที่ 31 ธันวาคม {{$datepicker}}</b></td>
                                </tr>
                              </table>
              </div>
              </div>
              </ul><!-- /.breadcrumb -->
              <!-- /section:basics/content.searchbox -->
              </div>

							<div align="center">
							<?php

              $data = Input::all();
              $db = Connectdb::Databaseall();

              $year = $data['reservation'];
              $yearold = $data['reservation']-1;
              $yearoldss = $data['reservation']-2;

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

              ?>

              <div align="center" >
              <table class="table table-bordered" width="100%" border="0" cellspacing="0" bordercolor="white">
                  <thead class="thead-inverse" >
                    <tr>
                      <th rowspan="2"></th>
                      <td colspan="3" align="right"><b>หน่วย: แสดงตามจริง (Actuals),บาท</b></td>
                    </tr>

                    <tr>
                        <th><center>หมายเหตุ</center></th>
                        <th><center><?php echo $datepicker;?></center></th>
                        <th><center><?php echo $datepicker-1;?></center></th>
                    </tr>
                    </thead>
                    <tbody>

                <?php
                $i = 1;

                //รายได้
                $sumincome_sell_dr = 0; //รายได้
                $sumincome_sell_cr = 0; //รายได้

                $sumincome_discount_dr = 0; //ส่วนลดจ่าย
                $sumincome_discount_cr = 0; //ส่วนลดจ่าย

                $sumincome_other_dr = 0; //รายได้อื่น
                 $sumincome_other_cr = 0; //รายได้อื่น

                //ค่าใช้จ่าย
                $sumcost_of_sales_dr =0;
                $sumcost_of_saleslost_dr =0;
                $sumexpenses_sales_dr =0;
                $sumexpenses_manage_dr =0;

                $sumcost_of_sales_cr =0;
                $sumcost_of_saleslost_cr =0;
                $sumexpenses_sales_cr =0;
                $sumexpenses_manage_cr =0;

                //ต้นทุนทางการเงิน
                $sumcosts_finance_dr =0;
                $sumcosts_finance_cr =0;


 //-----------------------------ยอดยกมาปีปัจจุบัน-----------------------------------
                //รายได้
                $sumincome_sell_old_dr = 0; //รายได้
                $sumincome_sell_old_cr = 0; //รายได้

                $sumincome_discount_old_dr = 0; //ส่วนลดจ่าย
                $sumincome_discount_old_cr = 0; //ส่วนลดจ่าย

                $sumincome_other_old_dr = 0; //รายได้อื่น
                 $sumincome_other_old_cr = 0; //รายได้อื่น

                //ค่าใช้จ่าย
                $sumcost_of_sales_old_dr =0;
                $sumcost_of_saleslost_old_dr =0;
                $sumexpenses_sales_old_dr =0;
                $sumexpenses_manage_old_dr =0;

                $sumcost_of_sales_old_cr =0;
                $sumcost_of_saleslost_old_cr =0;
                $sumexpenses_sales_old_cr =0;
                $sumexpenses_manage_old_cr =0;

                //ต้นทุนทางการเงิน
                $sumcosts_finance_old_dr =0;
                $sumcosts_finance_old_cr =0;

 //-------------------------------ยอดยกมาปีเก่า------------------------------------
               //รายได้
               $sumincome_sell_oldss_dr = 0; //รายได้
               $sumincome_sell_oldss_cr = 0; //รายได้

               $sumincome_discount_oldss_dr = 0; //ส่วนลดจ่าย
               $sumincome_discount_oldss_cr = 0; //ส่วนลดจ่าย

               $sumincome_other_oldss_dr = 0; //รายได้อื่น
                $sumincome_other_oldss_cr = 0; //รายได้อื่น

               //ค่าใช้จ่าย
               $sumcost_of_sales_oldss_dr =0;
               $sumcost_of_saleslost_oldss_dr =0;
               $sumexpenses_sales_oldss_dr =0;
               $sumexpenses_manage_oldss_dr =0;

               $sumcost_of_sales_oldss_cr =0;
               $sumcost_of_saleslost_oldss_cr =0;
               $sumexpenses_sales_oldss_cr =0;
               $sumexpenses_manage_oldss_cr =0;

               //ต้นทุนทางการเงิน
               $sumcosts_finance_oldss_dr =0;
               $sumcosts_finance_oldss_cr =0;

 //---------------------------------ปีเก่า-----------------------------------------
               //รายได้
               $sumincome_sell_year_dr = 0; //รายได้
               $sumincome_sell_year_cr = 0; //รายได้

               $sumincome_discount_year_dr = 0; //ส่วนลดจ่าย
               $sumincome_discount_year_cr = 0; //ส่วนลดจ่าย

               $sumincome_other_year_dr = 0; //รายได้อื่น
                $sumincome_other_year_cr = 0; //รายได้อื่น

               //ค่าใช้จ่าย
               $sumcost_of_sales_year_dr =0;
               $sumcost_of_saleslost_year_dr =0;
               $sumexpenses_sales_year_dr =0;
               $sumexpenses_manage_year_dr =0;

               $sumcost_of_sales_year_cr =0;
               $sumcost_of_saleslost_year_cr =0;
               $sumexpenses_sales_year_cr =0;
               $sumexpenses_manage_year_cr =0;

               //ต้นทุนทางการเงิน
               $sumcosts_finance_year_dr =0;
               $sumcosts_finance_year_cr =0;


 //--------------------------------รวมปีปัจจุบัน-------------------------------------
                $totalincome_sell =0;
                $totalincome_discount = 0;
                $totalincome_other = 0;
                $totalcost_of_sales =0;
                $totalcost_of_saleslost =0;
                $totalexpenses_sales =0;
                $totalexpenses_manage =0;
                $totalcosts_finance =0;

 //--------------------------------รวมปีเก่า----------------------------------------
                $totalincome_selloldss =0;
                $totalincome_discountoldss = 0;
                $totalincome_otheroldss = 0;
                $totalcost_of_salesoldss =0;
                $totalcost_of_saleslostoldss =0;
                $totalexpenses_salesoldss =0;
                $totalexpenses_manageoldss =0;
                $totalcosts_financeoldss =0;

                foreach ($datatresult as $key => $value) { ?>

                <!-- รายได้ -->
                <?php //รายได้จากการขายหรือการให้บริการ
                  if($value->acc_code == 411100 || $value->acc_code == 421100 || $value->acc_code == 711300){ //รายได้
                          $sumincome_sell_dr = $sumincome_sell_dr + $value->sumdebit;
                          $sumincome_sell_cr = $sumincome_sell_cr + $value->sumcredit;
                  }

                  if($value->acc_code == 512200){ //ส่วนลดจ่าย
                          $sumincome_discount_dr = $sumincome_discount_dr + $value->sumdebit;
                          $sumincome_discount_cr = $sumincome_discount_cr + $value->sumcredit;
                  }

                //รายได้อื่น
                  if($value->acc_code == 421101){
                          $sumincome_other_dr = $sumincome_other_dr + $value->sumdebit;
                          $sumincome_other_cr = $sumincome_other_cr + $value->sumcredit;
                  }
                ?>
                <!-- รายได้ -->

                <!-- ค่าใช้จ่าย -->
                <?php //ต้นทุนขายหรือต้นทุนการให้บริการ
                  if($value->acc_code == 512100 || $value->acc_code == 512800 || $value->acc_code == 412900){ //สินค้า - ส่วนลดรับ
                          $sumcost_of_sales_dr = $value->sumdebit - $sumcost_of_sales_dr;
                          $sumcost_of_sales_cr = $value->sumcredit - $sumcost_of_sales_cr;
                  }

                  if($value->acc_code == 512900 || $value->acc_code == 513000){ //สินค้าสูญหาย,ค่าซ่อมแซม
                          $sumcost_of_saleslost_dr = $sumcost_of_saleslost_dr + $value->sumdebit;
                          $sumcost_of_saleslost_cr = $sumcost_of_saleslost_cr + $value->sumcredit;
                  }

                //ค่าใช้จ่ายในการขาย
                  $subcost = substr($value->acc_code,0);
                  // echo $subcost[0]; echo $subcost[1]; exit;
                  $subexpenses = $subcost[0]."".$subcost[1];
                  // echo $subexpenses; exit;
                  if($subexpenses == 61){
                          $sumexpenses_sales_dr = $sumexpenses_sales_dr + $value->sumdebit;
                          $sumexpenses_sales_cr = $sumexpenses_sales_cr + $value->sumcredit;
                  }

                //ค่าใช้จ่ายในการบริหาร
                  $subcost = substr($value->acc_code,0);
                  // echo $subcost[0]; echo $subcost[1]; exit;
                  $submanage = $subcost[0]."".$subcost[1];
                  // echo $subexpenses; exit;
                  if($subexpenses == 62){
                          $sumexpenses_manage_dr = $sumexpenses_manage_dr + $value->sumdebit;
                          $sumexpenses_manage_cr = $sumexpenses_manage_cr + $value->sumcredit;
                  }
                ?>
                <!-- ค่าใช้จ่าย -->


                <!-- ต้นทุนทางการเงิน -->
                <?php //ต้นทุนทางการเงิน
                  $subcost = substr($value->acc_code,0);
                  // echo $subcost[0]; echo $subcost[1]; exit;
                  $subfinance = $subcost[0]."".$subcost[1];
                  // echo $subexpenses; exit;
                  if($subexpenses == 69){
                          $sumcosts_finance_dr = $sumcosts_finance_dr + $value->sumdebit;
                          $sumcosts_finance_cr = $sumcosts_finance_cr + $value->sumcredit;
                  }
                ?>
                <!-- ต้นทุนทางการเงิน -->

                <?php  } ?>

                <?php
                //ยอดยกมาของปีปัจจุบัน
                foreach ($dataold as $key2 => $value2) { ?>

                <!-- รายได้ -->
                <?php //รายได้จากการขายหรือการให้บริการ
                  if($value2->acc_code == 411100 || $value2->acc_code == 421100 || $value2->acc_code == 711300){ //รายได้
                          $sumincome_sell_old_dr = $sumincome_sell_old_dr + $value2->sumdebit;
                          $sumincome_sell_old_cr = $sumincome_sell_old_cr + $value2->sumcredit;
                  }

                  if($value2->acc_code == 512200){ //ส่วนลดจ่าย
                          $sumincome_discount_old_dr = $sumincome_discount_old_dr + $value2->sumdebit;
                          $sumincome_discount_old_cr = $sumincome_discount_old_cr + $value2->sumcredit;
                  }

                //รายได้อื่น
                  if($value2->acc_code == 421101){
                          $sumincome_other_old_dr = $sumincome_other_old_dr + $value2->sumdebit;
                          $sumincome_other_old_cr = $sumincome_other_old_cr + $value2->sumcredit;
                  }
                ?>
                <!-- รายได้ -->

                <!-- ค่าใช้จ่าย -->
                <?php //ต้นทุนขายหรือต้นทุนการให้บริการ
                  if($value2->acc_code == 512100 || $value2->acc_code == 512800 || $value2->acc_code == 412900){ //สินค้า - ส่วนลดรับ
                          $sumcost_of_sales_old_dr = $value2->sumdebit - $sumcost_of_sales_old_dr;
                          $sumcost_of_sales_old_cr = $value2->sumcredit - $sumcost_of_sales_old_cr;
                  }

                  if($value2->acc_code == 512900 || $value2->acc_code == 513000){ //สินค้าสูญหาย,ค่าซ่อมแซม
                          $sumcost_of_saleslost_old_dr = $sumcost_of_saleslost_old_dr + $value2->sumdebit;
                          $sumcost_of_saleslost_old_cr = $sumcost_of_saleslost_old_cr + $value2->sumcredit;
                  }

                //ค่าใช้จ่ายในการขาย
                  $subcost = substr($value2->acc_code,0);
                  // echo $subcost[0]; echo $subcost[1]; exit;
                  $subexpenses = $subcost[0]."".$subcost[1];
                  // echo $subexpenses; exit;
                  if($subexpenses == 61){
                          $sumexpenses_sales_old_dr = $sumexpenses_sales_old_dr + $value2->sumdebit;
                          $sumexpenses_sales_old_cr = $sumexpenses_sales_old_cr + $value2->sumcredit;
                  }

                //ค่าใช้จ่ายในการบริหาร
                  $subcost = substr($value2->acc_code,0);
                  // echo $subcost[0]; echo $subcost[1]; exit;
                  $submanage = $subcost[0]."".$subcost[1];
                  // echo $subexpenses; exit;
                  if($subexpenses == 62){
                          $sumexpenses_manage_old_dr = $sumexpenses_manage_old_dr + $value2->sumdebit;
                          $sumexpenses_manage_old_cr = $sumexpenses_manage_old_cr + $value2->sumcredit;
                  }
                ?>
                <!-- ค่าใช้จ่าย -->


                <!-- ต้นทุนทางการเงิน -->
                <?php //ต้นทุนทางการเงิน
                  $subcost = substr($value2->acc_code,0);
                  // echo $subcost[0]; echo $subcost[1]; exit;
                  $subfinance = $subcost[0]."".$subcost[1];
                  // echo $subexpenses; exit;
                  if($subexpenses == 69){
                          $sumcosts_finance_old_dr = $sumcosts_finance_old_dr + $value2->sumdebit;
                          $sumcosts_finance_old_cr = $sumcosts_finance_old_cr + $value2->sumcredit;
                  }
                ?>
                <!-- ต้นทุนทางการเงิน -->

                <?php $i++; } ?>

                <?php
                //ยอดยกมาของปีเก่า
                foreach ($dataoldss as $key3 => $value3) { ?>

                <!-- รายได้ -->
                <?php //รายได้จากการขายหรือการให้บริการ
                  if($value3->acc_code == 411100 || $value3->acc_code == 421100 || $value3->acc_code == 711300){ //รายได้
                          $sumincome_sell_oldss_dr = $sumincome_sell_oldss_dr + $value3->sumdebit;
                          $sumincome_sell_oldss_cr = $sumincome_sell_oldss_cr + $value3->sumcredit;
                  }

                  if($value3->acc_code == 512200){ //ส่วนลดจ่าย
                          $sumincome_discount_oldss_dr = $sumincome_discount_oldss_dr + $value3->sumdebit;
                          $sumincome_discount_oldss_cr = $sumincome_discount_oldss_cr + $value3->sumcredit;
                  }

                //รายได้อื่น
                  if($value3->acc_code == 421101){
                          $sumincome_other_oldss_dr = $sumincome_other_oldss_dr + $value3->sumdebit;
                          $sumincome_other_oldss_cr = $sumincome_other_oldss_cr + $value3->sumcredit;
                  }
                ?>
                <!-- รายได้ -->

                <!-- ค่าใช้จ่าย -->
                <?php //ต้นทุนขายหรือต้นทุนการให้บริการ
                  if($value3->acc_code == 512100 || $value3->acc_code == 512800 || $value3->acc_code == 412900){ //สินค้า - ส่วนลดรับ
                          $sumcost_of_sales_oldss_dr = $value3->sumdebit - $sumcost_of_sales_oldss_dr;
                          $sumcost_of_sales_oldss_cr = $value3->sumcredit - $sumcost_of_sales_oldss_cr;
                  }

                  if($value3->acc_code == 512900 || $value3->acc_code == 513000){ //สินค้าสูญหาย,ค่าซ่อมแซม
                          $sumcost_of_saleslost_oldss_dr = $sumcost_of_saleslost_oldss_dr + $value3->sumdebit;
                          $sumcost_of_saleslost_oldss_cr = $sumcost_of_saleslost_oldss_cr + $value3->sumcredit;
                  }

                //ค่าใช้จ่ายในการขาย
                  $subcost = substr($value3->acc_code,0);
                  // echo $subcost[0]; echo $subcost[1]; exit;
                  $subexpenses = $subcost[0]."".$subcost[1];
                  // echo $subexpenses; exit;
                  if($subexpenses == 61){
                          $sumexpenses_sales_oldss_dr = $sumexpenses_sales_oldss_dr + $value3->sumdebit;
                          $sumexpenses_sales_oldss_cr = $sumexpenses_sales_oldss_cr + $value3->sumcredit;
                  }

                //ค่าใช้จ่ายในการบริหาร
                  $subcost = substr($value3->acc_code,0);
                  // echo $subcost[0]; echo $subcost[1]; exit;
                  $submanage = $subcost[0]."".$subcost[1];
                  // echo $subexpenses; exit;
                  if($subexpenses == 62){
                          $sumexpenses_manage_oldss_dr = $sumexpenses_manage_oldss_dr + $value3->sumdebit;
                          $sumexpenses_manage_oldss_cr = $sumexpenses_manage_oldss_cr + $value3->sumcredit;
                  }
                ?>
                <!-- ค่าใช้จ่าย -->


                <!-- ต้นทุนทางการเงิน -->
                <?php //ต้นทุนทางการเงิน
                  $subcost = substr($value3->acc_code,0);
                  // echo $subcost[0]; echo $subcost[1]; exit;
                  $subfinance = $subcost[0]."".$subcost[1];
                  // echo $subexpenses; exit;
                  if($subexpenses == 69){
                          $sumcosts_finance_oldss_dr = $sumcosts_finance_oldss_dr + $value3->sumdebit;
                          $sumcosts_finance_oldss_cr = $sumcosts_finance_oldss_cr + $value3->sumcredit;
                  }
                ?>
                <!-- ต้นทุนทางการเงิน -->

                <?php $i++; } ?>

                <?php
                //ปีเก่า
                foreach ($datayear as $key4 => $value4) { ?>

                <!-- รายได้ -->
                <?php //รายได้จากการขายหรือการให้บริการ
                  if($value4->acc_code == 411100 || $value4->acc_code == 421100 || $value4->acc_code == 711300){ //รายได้
                          $sumincome_sell_year_dr = $sumincome_sell_year_dr + $value4->sumdebit;
                          $sumincome_sell_year_cr = $sumincome_sell_year_cr + $value4->sumcredit;
                  }

                  if($value4->acc_code == 512200){ //ส่วนลดจ่าย
                          $sumincome_discount_year_dr = $sumincome_discount_year_dr + $value4->sumdebit;
                          $sumincome_discount_year_cr = $sumincome_discount_year_cr + $value4->sumcredit;
                  }

                //รายได้อื่น
                  if($value4->acc_code == 421101){
                          $sumincome_other_year_dr = $sumincome_other_year_dr + $value4->sumdebit;
                          $sumincome_other_year_cr = $sumincome_other_year_cr + $value4->sumcredit;
                  }
                ?>
                <!-- รายได้ -->

                <!-- ค่าใช้จ่าย -->
                <?php //ต้นทุนขายหรือต้นทุนการให้บริการ
                  if($value4->acc_code == 512100 || $value4->acc_code == 512800 || $value4->acc_code == 412900){ //สินค้า - ส่วนลดรับ
                          $sumcost_of_sales_year_dr = $value4->sumdebit - $sumcost_of_sales_year_dr;
                          $sumcost_of_sales_year_cr = $value4->sumcredit - $sumcost_of_sales_year_cr;
                  }

                  if($value4->acc_code == 512900 || $value4->acc_code == 513000){ //สินค้าสูญหาย,ค่าซ่อมแซม
                          $sumcost_of_saleslost_year_dr = $sumcost_of_saleslost_year_dr + $value4->sumdebit;
                          $sumcost_of_saleslost_year_cr = $sumcost_of_saleslost_year_cr + $value4->sumcredit;
                  }

                //ค่าใช้จ่ายในการขาย
                  $subcost = substr($value4->acc_code,0);
                  // echo $subcost[0]; echo $subcost[1]; exit;
                  $subexpenses = $subcost[0]."".$subcost[1];
                  // echo $subexpenses; exit;
                  if($subexpenses == 61){
                          $sumexpenses_sales_year_dr = $sumexpenses_sales_year_dr + $value4->sumdebit;
                          $sumexpenses_sales_year_cr = $sumexpenses_sales_year_cr + $value4->sumcredit;
                  }

                //ค่าใช้จ่ายในการบริหาร
                  $subcost = substr($value4->acc_code,0);
                  // echo $subcost[0]; echo $subcost[1]; exit;
                  $submanage = $subcost[0]."".$subcost[1];
                  // echo $subexpenses; exit;
                  if($subexpenses == 62){
                          $sumexpenses_manage_year_dr = $sumexpenses_manage_year_dr + $value4->sumdebit;
                          $sumexpenses_manage_year_cr = $sumexpenses_manage_year_cr + $value4->sumcredit;
                  }
                ?>
                <!-- ค่าใช้จ่าย -->


                <!-- ต้นทุนทางการเงิน -->
                <?php //ต้นทุนทางการเงิน
                  $subcost = substr($value4->acc_code,0);
                  // echo $subcost[0]; echo $subcost[1]; exit;
                  $subfinance = $subcost[0]."".$subcost[1];
                  // echo $subexpenses; exit;
                  if($subexpenses == 69){
                          $sumcosts_finance_year_dr = $sumcosts_finance_year_dr + $value4->sumdebit;
                          $sumcosts_finance_year_cr = $sumcosts_finance_year_cr + $value4->sumcredit;
                  }
                ?>
                <!-- ต้นทุนทางการเงิน -->

                <?php $i++; } ?>

 <!------------------------------- ข้อมูลปีปัจจุบัน --------------------------------->
                <?php
                //รายได้จากการขายหรือการให้บริการ
                if(($sumincome_sell_dr + $sumincome_sell_old_dr) > ($sumincome_sell_cr + $sumincome_sell_old_cr)){
                    $totalincome_sell = ($sumincome_sell_dr + $sumincome_sell_old_dr) - ($sumincome_sell_cr + $sumincome_sell_old_cr);
                }elseif (($sumincome_sell_dr + $sumincome_sell_old_dr) < ($sumincome_sell_cr + $sumincome_sell_old_cr)) {
                    $totalincome_sell = ($sumincome_sell_cr + $sumincome_sell_old_cr) - ($sumincome_sell_dr + $sumincome_sell_old_dr);
                }

                if(($sumincome_discount_dr + $sumincome_discount_old_dr) > ($sumincome_discount_cr + $sumincome_discount_old_cr)){
                    $totalincome_discount = ($sumincome_discount_dr + $sumincome_discount_old_dr) - ($sumincome_discount_cr + $sumincome_discount_old_cr);
                }elseif (($sumincome_discount_dr + $sumincome_discount_old_dr) < ($sumincome_discount_cr + $sumincome_discount_old_cr)) {
                    $totalincome_discount = ($sumincome_discount_cr + $sumincome_discount_old_cr) - ($sumincome_discount_dr + $sumincome_discount_old_dr);
                }

                //รายได้อื่น
                if(($sumincome_other_dr + $sumincome_other_old_dr) > ($sumincome_other_cr + $sumincome_other_old_cr)){
                    $totalincome_other = ($sumincome_other_dr + $sumincome_other_old_dr) - ($sumincome_other_cr + $sumincome_other_old_cr);
                }elseif (($sumincome_other_dr + $sumincome_other_old_dr) < ($sumincome_other_cr + $sumincome_other_old_cr)) {
                    $totalincome_other = ($sumincome_other_cr + $sumincome_other_old_cr) - ($sumincome_other_dr + $sumincome_other_old_dr);
                }

                //ต้นทุนขายหรือต้นทุนการให้บริการ
                if(($sumcost_of_sales_dr + $sumcost_of_sales_old_dr) > ($sumcost_of_sales_cr + $sumcost_of_sales_old_cr)){
                    $totalcost_of_sales = ($sumcost_of_sales_dr + $sumcost_of_sales_old_dr) - ($sumcost_of_sales_cr + $sumcost_of_sales_old_cr);
                }elseif (($sumcost_of_sales_dr + $sumcost_of_sales_old_dr) < ($sumcost_of_sales_cr + $sumcost_of_sales_old_cr)) {
                    $totalcost_of_sales = ($sumcost_of_sales_cr + $sumcost_of_sales_old_cr) - ($sumcost_of_sales_dr + $sumcost_of_sales_old_dr);
                }

                if(($sumcost_of_saleslost_dr + $sumcost_of_saleslost_old_dr) > ($sumcost_of_saleslost_cr + $sumcost_of_saleslost_old_cr)){
                    $totalcost_of_saleslost = ($sumcost_of_saleslost_dr + $sumcost_of_saleslost_old_dr) - ($sumcost_of_saleslost_cr + $sumcost_of_saleslost_old_cr);
                }elseif (($sumcost_of_saleslost_dr + $sumcost_of_saleslost_old_dr) < ($sumcost_of_saleslost_cr + $sumcost_of_saleslost_old_cr)) {
                    $totalcost_of_saleslost = ($sumcost_of_saleslost_cr + $sumcost_of_saleslost_old_cr) - ($sumcost_of_saleslost_dr + $sumcost_of_saleslost_old_dr);
                }

                //ค่าใช้จ่ายในการขาย
                if(($sumexpenses_sales_dr + $sumexpenses_sales_old_dr) > ($sumexpenses_sales_cr + $sumexpenses_sales_old_cr)){
                    $totalexpenses_sales = ($sumexpenses_sales_dr + $sumexpenses_sales_old_dr) - ($sumexpenses_sales_cr + $sumexpenses_sales_old_cr);
                }elseif (($sumexpenses_sales_dr + $sumexpenses_sales_old_dr) < ($sumexpenses_sales_cr + $sumexpenses_sales_old_cr)) {
                    $totalexpenses_sales = ($sumexpenses_sales_cr + $sumexpenses_sales_old_cr) - ($sumexpenses_sales_dr + $sumexpenses_sales_old_dr);
                }

                //ค่าใช้จ่ายในการบริหาร
                if(($sumexpenses_manage_dr + $sumexpenses_manage_old_dr) > ($sumexpenses_manage_cr + $sumexpenses_manage_old_cr)){
                    $totalexpenses_manage = ($sumexpenses_manage_dr + $sumexpenses_manage_old_dr) - ($sumexpenses_manage_cr + $sumexpenses_manage_old_cr);
                }elseif (($sumexpenses_manage_dr + $sumexpenses_manage_old_dr) < ($sumexpenses_manage_cr + $sumexpenses_manage_old_cr)) {
                    $totalexpenses_manage = ($sumexpenses_manage_cr + $sumexpenses_manage_old_cr) - ($sumexpenses_manage_dr + $sumexpenses_manage_old_dr);
                }

                //ต้นทุนทางการเงิน
                if(($sumcosts_finance_dr + $sumcosts_finance_old_dr) > ($sumcosts_finance_cr + $sumcosts_finance_old_cr)){
                    $totalcosts_finance = ($sumcosts_finance_dr + $sumcosts_finance_old_dr) - ($sumcosts_finance_cr + $sumcosts_finance_old_cr);
                }elseif (($sumcosts_finance_dr + $sumcosts_finance_old_dr) < ($sumcosts_finance_cr + $sumcosts_finance_old_cr)) {
                    $totalcosts_finance = ($sumcosts_finance_cr + $sumcosts_finance_old_cr) - ($sumcosts_finance_dr + $sumcosts_finance_old_dr);
                }
                ?>
 <!------------------------------- ข้อมูลปีปัจจุบัน --------------------------------->


 <!------------------------------- ข้อมูลปีเก่า ------------------------------------>
                <?php
                //รายได้จากการขายหรือการให้บริการ
                if(($sumincome_sell_oldss_dr + $sumincome_sell_year_dr) > ($sumincome_sell_oldss_cr + $sumincome_sell_year_cr)){
                    $totalincome_selloldss = ($sumincome_sell_oldss_dr + $sumincome_sell_year_dr) - ($sumincome_sell_oldss_cr + $sumincome_sell_year_cr);
                }elseif (($sumincome_sell_oldss_dr + $sumincome_sell_year_dr) < ($sumincome_sell_oldss_cr + $sumincome_sell_year_cr)) {
                    $totalincome_selloldss = ($sumincome_sell_oldss_cr + $sumincome_sell_year_cr) - ($sumincome_sell_oldss_dr + $sumincome_sell_year_dr);
                }

                if(($sumincome_discount_oldss_dr + $sumincome_discount_year_dr) > ($sumincome_discount_oldss_cr + $sumincome_discount_year_cr)){
                    $totalincome_discountoldss = ($sumincome_discount_oldss_dr + $sumincome_discount_year_dr) - ($sumincome_discount_oldss_cr + $sumincome_discount_year_cr);
                }elseif (($sumincome_discount_oldss_dr + $sumincome_discount_year_dr) < ($sumincome_discount_oldss_cr + $sumincome_discount_year_cr)) {
                    $totalincome_discountoldss = ($sumincome_discount_oldss_cr + $sumincome_discount_year_cr) - ($sumincome_discount_oldss_dr + $sumincome_discount_year_dr);
                }

                //รายได้อื่น
                if(($sumincome_other_oldss_dr + $sumincome_other_year_dr) > ($sumincome_other_oldss_cr + $sumincome_other_year_cr)){
                    $totalincome_otheroldss = ($sumincome_other_oldss_dr + $sumincome_other_year_dr) - ($sumincome_other_oldss_cr + $sumincome_other_year_cr);
                }elseif (($sumincome_other_oldss_dr + $sumincome_other_year_dr) < ($sumincome_other_oldss_cr + $sumincome_other_year_cr)) {
                    $totalincome_otheroldss = ($sumincome_other_oldss_cr + $sumincome_other_year_cr) - ($sumincome_other_oldss_dr + $sumincome_other_year_dr);
                }

                //ต้นทุนขายหรือต้นทุนการให้บริการ
                // if(($sumcost_of_sales_oldss_dr + $sumcost_of_sales_year_dr) > ($sumcost_of_sales_oldss_cr + $sumcost_of_sales_year_cr)){
                //     $totalcost_of_salesoldss = ($sumcost_of_sales_oldss_dr + $sumcost_of_sales_year_dr) - ($sumcost_of_sales_oldss_cr + $sumcost_of_sales_year_cr);
                // }elseif (($sumcost_of_sales_oldss_dr + $sumcost_of_sales_year_dr) < ($sumcost_of_sales_oldss_cr + $sumcost_of_sales_year_cr)) {
                //     $totalcost_of_salesoldss = ($sumcost_of_sales_oldss_cr + $sumcost_of_sales_year_cr) - ($sumcost_of_sales_oldss_dr + $sumcost_of_sales_year_dr);
                // }
                //
                // if(($sumcost_of_saleslost_oldss_dr + $sumcost_of_saleslost_year_dr) > ($sumcost_of_saleslost_oldss_cr + $sumcost_of_saleslost_year_cr)){
                //     $totalcost_of_saleslostoldss = ($sumcost_of_saleslost_oldss_dr + $sumcost_of_saleslost_year_dr) - ($sumcost_of_saleslost_oldss_cr + $sumcost_of_saleslost_year_cr);
                // }elseif (($sumcost_of_saleslost_oldss_dr + $sumcost_of_saleslost_year_dr) < ($sumcost_of_saleslost_oldss_cr + $sumcost_of_saleslost_year_cr)) {
                //     $totalcost_of_saleslostoldss = ($sumcost_of_saleslost_oldss_cr + $sumcost_of_saleslost_year_cr) - ($sumcost_of_saleslost_oldss_dr + $sumcost_of_saleslost_year_dr);
                // }
                if(($sumcost_of_sales_oldss_dr + $sumcost_of_sales_year_dr) > ($sumcost_of_sales_oldss_cr + $sumcost_of_sales_year_cr)){
                    $totalcost_of_salesoldss = ($sumcost_of_sales_oldss_dr + $sumcost_of_sales_year_dr) - ($sumcost_of_sales_oldss_cr + $sumcost_of_sales_year_cr);
                }elseif (($sumcost_of_sales_oldss_dr + $sumcost_of_sales_year_dr) < ($sumcost_of_sales_oldss_cr + $sumcost_of_sales_year_cr)) {
                    $totalcost_of_salesoldss = ($sumcost_of_sales_oldss_cr + $sumcost_of_sales_year_cr) - ($sumcost_of_sales_oldss_dr + $sumcost_of_sales_year_dr);
                }

                if(($sumcost_of_saleslost_oldss_dr + $sumcost_of_saleslost_year_dr) > ($sumcost_of_saleslost_oldss_cr + $sumcost_of_saleslost_year_cr)){
                    $totalcost_of_saleslostoldss = ($sumcost_of_saleslost_oldss_dr + $sumcost_of_saleslost_year_dr) - ($sumcost_of_saleslost_oldss_cr + $sumcost_of_saleslost_year_cr);
                }elseif (($sumcost_of_saleslost_oldss_dr + $sumcost_of_saleslost_year_dr) < ($sumcost_of_saleslost_oldss_cr + $sumcost_of_saleslost_year_cr)) {
                    $totalcost_of_saleslostoldss = ($sumcost_of_saleslost_oldss_cr + $sumcost_of_saleslost_year_cr) - ($sumcost_of_saleslost_oldss_dr + $sumcost_of_saleslost_year_dr);
                }

                //ค่าใช้จ่ายในการขาย
                if(($sumexpenses_sales_oldss_dr + $sumexpenses_sales_year_dr) > ($sumexpenses_sales_oldss_cr + $sumexpenses_sales_year_cr)){
                    $totalexpenses_salesoldss = ($sumexpenses_sales_oldss_dr + $sumexpenses_sales_year_dr) - ($sumexpenses_sales_oldss_cr + $sumexpenses_sales_year_cr);
                }elseif (($sumexpenses_sales_oldss_dr + $sumexpenses_sales_year_dr) < ($sumexpenses_sales_oldss_cr + $sumexpenses_sales_year_cr)) {
                    $totalexpenses_salesoldss = ($sumexpenses_sales_oldss_cr + $sumexpenses_sales_year_cr) - ($sumexpenses_sales_oldss_dr + $sumexpenses_sales_year_dr);
                }

                //ค่าใช้จ่ายในการบริหาร
                if(($sumexpenses_manage_oldss_dr + $sumexpenses_manage_year_dr) > ($sumexpenses_manage_oldss_cr + $sumexpenses_manage_year_cr)){
                    $totalexpenses_manageoldss = ($sumexpenses_manage_oldss_dr + $sumexpenses_manage_year_dr) - ($sumexpenses_manage_oldss_cr + $sumexpenses_manage_year_cr);
                }elseif (($sumexpenses_manage_oldss_dr + $sumexpenses_manage_year_dr) < ($sumexpenses_manage_oldss_cr + $sumexpenses_manage_year_cr)) {
                    $totalexpenses_manageoldss = ($sumexpenses_manage_oldss_cr + $sumexpenses_manage_year_cr) - ($sumexpenses_manage_oldss_dr + $sumexpenses_manage_year_dr);
                }

                //ต้นทุนทางการเงิน
                if(($sumcosts_finance_oldss_dr + $sumcosts_finance_year_dr) > ($sumcosts_finance_oldss_cr + $sumcosts_finance_year_cr)){
                    $totalcosts_financeoldss = ($sumcosts_finance_oldss_dr + $sumcosts_finance_year_dr) - ($sumcosts_finance_oldss_cr + $sumcosts_finance_year_cr);
                }elseif (($sumcosts_finance_oldss_dr + $sumcosts_finance_year_dr) < ($sumcosts_finance_oldss_cr + $sumcosts_finance_year_cr)) {
                    $totalcosts_financeoldss = ($sumcosts_finance_oldss_cr + $sumcosts_finance_year_cr) - ($sumcosts_finance_oldss_dr + $sumcosts_finance_year_dr);
                }
                ?>
 <!------------------------------- ข้อมูลปีเก่า ------------------------------------>

                </form>

                <tr><td colspan="4"><b><?php echo "งบกำไรขาดทุน"?></b></td></tr>
                <tr>
                  <td><b><?php echo "รายได้"?></b>
                   <?php echo "<br>";
                               echo "&nbsp;&nbsp;รายได้จากการขายหรือการให้บริการ";
                         echo "<br>";
                               echo "&nbsp;&nbsp;รายได้อื่น";
                         echo "<b>";
                         echo "<br>";
                               echo "&nbsp;&nbsp;รวมรายได้";
                   ?>
                  </td>
                  <td></td>
                  <td align="right">
                    <?php echo "<br>";
                                echo number_format ($totalincome_sell - $totalincome_discount,2);
                          echo "<br>";
                                echo number_format ($totalincome_other,2);
                          echo "<b>";
                          echo "<br>";
                                echo number_format (($totalincome_sell - $totalincome_discount) + $totalincome_other,2);
                    ?>
                 </td>
                 <td align="right">
                   <?php echo "<br>";
                               echo number_format ($totalincome_selloldss - $totalincome_discountoldss,2);
                         echo "<br>";
                               echo number_format ($totalincome_otheroldss,2);
                         echo "<b>";
                         echo "<br>";
                               echo number_format (($totalincome_selloldss - $totalincome_discountoldss) + $totalincome_otheroldss,2);
                   ?>
                </td>
                </tr>

                <tr>
                  <td><b><?php echo "ค่าใช้จ่าย"?></b>
                   <?php echo "<br>";
                               echo "&nbsp;&nbsp;ต้นทุนขายหรือต้นทุนการให้บริการ";
                         echo "<br>";
                               echo "&nbsp;&nbsp;ค่าใช้จ่ายในการขาย";
                         echo "<br>";
                               echo "&nbsp;&nbsp;ค่าใช้จ่ายในการบริหาร";
                         echo "<b><br>";
                               echo "&nbsp;&nbsp;รวมค่าใช้จ่าย";
                   ?>
                  </td>
                  <td></td>
                  <td align="right">
                    <?php echo "<br>";
                                echo number_format ($totalcost_of_sales + $totalcost_of_saleslost,2);
                          echo "<br>";
                                echo number_format ($totalexpenses_sales,2);
                          echo "<br>";
                                echo number_format ($totalexpenses_manage,2);
                          echo "<b>";
                          echo "<br>";
                                echo number_format (($totalcost_of_sales + $totalcost_of_saleslost) + $totalexpenses_sales + $totalexpenses_manage,2);
                    ?>
                  </td>
                  <td align="right">
                    <?php echo "<br>";
                                echo number_format ($totalcost_of_salesoldss + $totalcost_of_saleslostoldss,2);
                          echo "<br>";
                                echo number_format ($totalexpenses_salesoldss,2);
                          echo "<br>";
                                echo number_format ($totalexpenses_manageoldss,2);
                          echo "<b>";
                          echo "<br>";
                                echo number_format (($totalcost_of_salesoldss + $totalcost_of_saleslostoldss) + $totalexpenses_salesoldss + $totalexpenses_manageoldss,2);
                    ?>
                  </td>
                </tr>

                <tr>
                  <td><b><?php echo "กำไร(ขาดทุน) ก่อนต้นทุนทางการเงินและค่าใช้จ่ายภาษีเงินได้"?></b></td>
                  <td></td>
                  <td align="right"><b>
                    <?php
                    // if(($totalincome_sell + $totalincome_other) > (($totalcost_of_sales + $totalcost_of_sales) + $totalexpenses_sales + $totalexpenses_manage)){ //กรณี รวมรายได้ > รวมค่าใช้จ่าย
                    //   echo number_format (($totalincome_sell + $totalincome_other)-(($totalcost_of_sales + $totalcost_of_sales) + $totalexpenses_sales + $totalexpenses_manage),2);
                    // }
                    // else if(($totalincome_sell + $totalincome_other) < (($totalcost_of_sales + $totalcost_of_sales) + $totalexpenses_sales + $totalexpenses_manage)){ //กรณี รวมรายได้ < รวมค่าใช้จ่าย
                    //  echo number_format ((($totalcost_of_sales + $totalcost_of_sales) + $totalexpenses_sales + $totalexpenses_manage)-($totalincome_sell + $totalincome_other),2);
                    // }

                    // if(($totalincome_sell + $totalincome_other) > (($totalcost_of_sales + $totalcost_of_saleslost) + $totalexpenses_sales + $totalexpenses_manage)){ //กรณี รวมรายได้ > รวมค่าใช้จ่าย
                    //   echo number_format (($totalincome_sell + $totalincome_other)-(($totalcost_of_sales + $totalcost_of_saleslost) + $totalexpenses_sales + $totalexpenses_manage),2);
                    // }
                    // else if(($totalincome_sell + $totalincome_other) < (($totalcost_of_sales + $totalcost_of_saleslost) + $totalexpenses_sales + $totalexpenses_manage)){ //กรณี รวมรายได้ < รวมค่าใช้จ่าย
                    //  echo number_format ((($totalcost_of_sales + $totalcost_of_saleslost) + $totalexpenses_sales + $totalexpenses_manage)-($totalincome_sell + $totalincome_other),2);
                    // }

                    //กรณี รวมรายได้ > รวมค่าใช้จ่าย
                    if((($totalincome_sell - $totalincome_discount) + $totalincome_other) > (($totalcost_of_sales + $totalcost_of_saleslost) + $totalexpenses_sales + $totalexpenses_manage)){
                        if(($totalincome_sell + $totalincome_other) > (($totalcost_of_sales + $totalcost_of_saleslost) + $totalexpenses_sales + $totalexpenses_manage)){ //กรณี รวมรายได้ > รวมค่าใช้จ่าย
                          echo number_format (($totalincome_sell + $totalincome_other)-(($totalcost_of_sales + $totalcost_of_saleslost) + $totalexpenses_sales + $totalexpenses_manage),2);
                        }
                        else if(($totalincome_sell + $totalincome_other) < (($totalcost_of_sales + $totalcost_of_saleslost) + $totalexpenses_sales + $totalexpenses_manage)){ //กรณี รวมรายได้ < รวมค่าใช้จ่าย
                         echo number_format ((($totalcost_of_sales + $totalcost_of_saleslost) + $totalexpenses_sales + $totalexpenses_manage)-($totalincome_sell + $totalincome_other),2);
                        }
                    }
                    //กรณี รวมรายได้ < รวมค่าใช้จ่าย ใส่ ( )
                    elseif ((($totalincome_sell - $totalincome_discount) + $totalincome_other) < (($totalcost_of_sales + $totalcost_of_saleslost) + $totalexpenses_sales + $totalexpenses_manage)) {
                        if(($totalincome_sell + $totalincome_other) > (($totalcost_of_sales + $totalcost_of_saleslost) + $totalexpenses_sales + $totalexpenses_manage)){ //กรณี รวมรายได้ > รวมค่าใช้จ่าย
                          echo "(";
                          echo number_format (($totalincome_sell + $totalincome_other)-(($totalcost_of_sales + $totalcost_of_saleslost) + $totalexpenses_sales + $totalexpenses_manage),2);
                          echo ")";
                        }
                        else if(($totalincome_sell + $totalincome_other) < (($totalcost_of_sales + $totalcost_of_saleslost) + $totalexpenses_sales + $totalexpenses_manage)){ //กรณี รวมรายได้ < รวมค่าใช้จ่าย
                          echo "(";
                         echo number_format ((($totalcost_of_sales + $totalcost_of_saleslost) + $totalexpenses_sales + $totalexpenses_manage)-($totalincome_sell + $totalincome_other),2);
                          echo ")";
                        }
                    }
                    ?></b>
                  </td>
                  <td align="right"><b>
                    <?php
                    // if(($totalincome_selloldss + $totalincome_otheroldss) > (($totalcost_of_salesoldss + $totalcost_of_salesoldss) + $totalexpenses_salesoldss + $totalexpenses_manageoldss)){ //กรณี รวมรายได้ > รวมค่าใช้จ่าย
                    //   echo number_format (($totalincome_selloldss + $totalincome_otheroldss)-(($totalcost_of_salesoldss + $totalcost_of_salesoldss) + $totalexpenses_salesoldss + $totalexpenses_manageoldss),2);
                    // }
                    // else if(($totalincome_selloldss + $totalincome_otheroldss) < (($totalcost_of_salesoldss + $totalcost_of_salesoldss) + $totalexpenses_salesoldss + $totalexpenses_manageoldss)){ //กรณี รวมรายได้ < รวมค่าใช้จ่าย
                    //  echo number_format ((($totalcost_of_salesoldss + $totalcost_of_salesoldss) + $totalexpenses_salesoldss + $totalexpenses_manageoldss)-($totalincome_selloldss + $totalincome_otheroldss),2);
                    // }

                    // if(($totalincome_selloldss + $totalincome_otheroldss) > (($totalcost_of_salesoldss + $totalcost_of_saleslostoldss) + $totalexpenses_salesoldss + $totalexpenses_manageoldss)){ //กรณี รวมรายได้ > รวมค่าใช้จ่าย
                    //   echo number_format (($totalincome_selloldss + $totalincome_otheroldss)-(($totalcost_of_salesoldss + $totalcost_of_saleslostoldss) + $totalexpenses_salesoldss + $totalexpenses_manageoldss),2);
                    // }
                    // else if(($totalincome_selloldss + $totalincome_otheroldss) < (($totalcost_of_salesoldss + $totalcost_of_saleslostoldss) + $totalexpenses_salesoldss + $totalexpenses_manageoldss)){ //กรณี รวมรายได้ < รวมค่าใช้จ่าย
                    //  echo number_format ((($totalcost_of_salesoldss + $totalcost_of_saleslostoldss) + $totalexpenses_salesoldss + $totalexpenses_manageoldss)-($totalincome_selloldss + $totalincome_otheroldss),2);
                    // }

                    //กรณี รวมรายได้ > รวมค่าใช้จ่าย
                    if((($totalincome_selloldss - $totalincome_discountoldss) + $totalincome_otheroldss) > (($totalcost_of_salesoldss + $totalcost_of_saleslostoldss) + $totalexpenses_salesoldss + $totalexpenses_manageoldss)){
                        if(($totalincome_selloldss + $totalincome_otheroldss) > (($totalcost_of_salesoldss + $totalcost_of_saleslostoldss) + $totalexpenses_salesoldss + $totalexpenses_manageoldss)){ //กรณี รวมรายได้ > รวมค่าใช้จ่าย
                          echo number_format (($totalincome_selloldss + $totalincome_otheroldss)-(($totalcost_of_salesoldss + $totalcost_of_saleslostoldss) + $totalexpenses_salesoldss + $totalexpenses_manageoldss),2);
                        }
                        else if(($totalincome_selloldss + $totalincome_otheroldss) < (($totalcost_of_salesoldss + $totalcost_of_saleslostoldss) + $totalexpenses_salesoldss + $totalexpenses_manageoldss)){ //กรณี รวมรายได้ < รวมค่าใช้จ่าย
                         echo number_format ((($totalcost_of_salesoldss + $totalcost_of_saleslostoldss) + $totalexpenses_salesoldss + $totalexpenses_manageoldss)-($totalincome_selloldss + $totalincome_otheroldss),2);
                        }
                    }
                    //กรณี รวมรายได้ < รวมค่าใช้จ่าย ใส่ ( )
                    elseif ((($totalincome_selloldss - $totalincome_discountoldss) + $totalincome_otheroldss) < (($totalcost_of_salesoldss + $totalcost_of_saleslostoldss) + $totalexpenses_salesoldss + $totalexpenses_manageoldss)) {
                        if(($totalincome_selloldss + $totalincome_otheroldss) > (($totalcost_of_salesoldss + $totalcost_of_saleslostoldss) + $totalexpenses_salesoldss + $totalexpenses_manageoldss)){ //กรณี รวมรายได้ > รวมค่าใช้จ่าย
                          echo "(";
                          echo number_format (($totalincome_selloldss + $totalincome_otheroldss)-(($totalcost_of_salesoldss + $totalcost_of_saleslostoldss) + $totalexpenses_salesoldss + $totalexpenses_manageoldss),2);
                          echo ")";
                        }
                        else if(($totalincome_selloldss + $totalincome_otheroldss) < (($totalcost_of_salesoldss + $totalcost_of_saleslostoldss) + $totalexpenses_salesoldss + $totalexpenses_manageoldss)){ //กรณี รวมรายได้ < รวมค่าใช้จ่าย
                          echo "(";
                          echo number_format ((($totalcost_of_salesoldss + $totalcost_of_saleslostoldss) + $totalexpenses_salesoldss + $totalexpenses_manageoldss)-($totalincome_selloldss + $totalincome_otheroldss),2);
                          echo ")";
                        }
                    }

                    ?></b>
                  </td>
                </tr>

                <tr>
                  <td><b><?php echo "ต้นทุนทางการเงิน"?></b></td>
                  <td></td>
                  <td align="right"><b>(<?php echo number_format ($totalcosts_finance,2);?>)</b></td>
                  <td align="right"><b>(<?php echo number_format ($totalcosts_financeoldss,2);?>)</b></td>
                </tr>

                <tr>
                  <td><b><?php echo "กำไร(ขาดทุน) ก่อนค่าใช้จ่ายภาษีเงินได้"?></b></td>
                  <td></td>
                  <td align="right"><b>
                    <?php
                    // if(($totalincome_sell + $totalincome_other) > (($totalcost_of_sales + $totalcost_of_sales) + $totalexpenses_sales + $totalexpenses_manage)){ //กรณี รวมรายได้ > รวมค่าใช้จ่าย
                    //   echo number_format (($totalincome_sell + $totalincome_other)-(($totalcost_of_sales + $totalcost_of_sales) + $totalexpenses_sales + $totalexpenses_manage) + $totalcosts_finance,2);
                    // }
                    // else if(($totalincome_sell + $totalincome_other) < (($totalcost_of_sales + $totalcost_of_sales) + $totalexpenses_sales + $totalexpenses_manage)){ //กรณี รวมรายได้ < รวมค่าใช้จ่าย
                    //  echo number_format ((($totalcost_of_sales + $totalcost_of_sales) + $totalexpenses_sales + $totalexpenses_manage)-($totalincome_sell + $totalincome_other) + $totalcosts_finance,2);
                    // }

                    // if(($totalincome_sell + $totalincome_other) > (($totalcost_of_sales + $totalcost_of_saleslost) + $totalexpenses_sales + $totalexpenses_manage)){ //กรณี รวมรายได้ > รวมค่าใช้จ่าย
                    //   echo number_format (($totalincome_sell + $totalincome_other)-(($totalcost_of_sales + $totalcost_of_saleslost) + $totalexpenses_sales + $totalexpenses_manage) + $totalcosts_finance,2);
                    // }
                    // else if(($totalincome_sell + $totalincome_other) < (($totalcost_of_sales + $totalcost_of_saleslost) + $totalexpenses_sales + $totalexpenses_manage)){ //กรณี รวมรายได้ < รวมค่าใช้จ่าย
                    //  echo number_format ((($totalcost_of_sales + $totalcost_of_saleslost) + $totalexpenses_sales + $totalexpenses_manage)-($totalincome_sell + $totalincome_other) + $totalcosts_finance,2);
                    // }

                    //กรณี รวมรายได้ > รวมค่าใช้จ่าย (จะต้อง - ต้นทุนทางการเงิน)
                    if((($totalincome_sell - $totalincome_discount) + $totalincome_other) > (($totalcost_of_sales + $totalcost_of_saleslost) + $totalexpenses_sales + $totalexpenses_manage)){
                        if(($totalincome_sell + $totalincome_other) > (($totalcost_of_sales + $totalcost_of_saleslost) + $totalexpenses_sales + $totalexpenses_manage)){ //กรณี รวมรายได้ > รวมค่าใช้จ่าย
                          echo number_format (($totalincome_sell + $totalincome_other)-(($totalcost_of_sales + $totalcost_of_saleslost) + $totalexpenses_sales + $totalexpenses_manage) - $totalcosts_finance,2);
                        }
                        else if(($totalincome_sell + $totalincome_other) < (($totalcost_of_sales + $totalcost_of_saleslost) + $totalexpenses_sales + $totalexpenses_manage)){ //กรณี รวมรายได้ < รวมค่าใช้จ่าย
                         echo number_format ((($totalcost_of_sales + $totalcost_of_saleslost) + $totalexpenses_sales + $totalexpenses_manage)-($totalincome_sell + $totalincome_other) - $totalcosts_finance,2);
                        }
                    }
                    //กรณี รวมรายได้ < รวมค่าใช้จ่าย (จะต้อง + ต้นทุนทางการเงิน)
                    elseif((($totalincome_sell - $totalincome_discount) + $totalincome_other) < (($totalcost_of_sales + $totalcost_of_saleslost) + $totalexpenses_sales + $totalexpenses_manage)){
                        if(($totalincome_sell + $totalincome_other) > (($totalcost_of_sales + $totalcost_of_saleslost) + $totalexpenses_sales + $totalexpenses_manage)){ //กรณี รวมรายได้ > รวมค่าใช้จ่าย
                          echo "(";
                          echo number_format (($totalincome_sell + $totalincome_other)-(($totalcost_of_sales + $totalcost_of_saleslost) + $totalexpenses_sales + $totalexpenses_manage) + $totalcosts_finance,2);
                          echo ")";
                        }
                        else if(($totalincome_sell + $totalincome_other) < (($totalcost_of_sales + $totalcost_of_saleslost) + $totalexpenses_sales + $totalexpenses_manage)){ //กรณี รวมรายได้ < รวมค่าใช้จ่าย
                          echo "(";
                          echo number_format ((($totalcost_of_sales + $totalcost_of_saleslost) + $totalexpenses_sales + $totalexpenses_manage)-($totalincome_sell + $totalincome_other) + $totalcosts_finance,2);
                          echo ")";
                        }
                  }
                    ?></b>
                  </td>
                  <td align="right"><b>
                    <?php
                    // if(($totalincome_selloldss + $totalincome_otheroldss) > (($totalcost_of_salesoldss + $totalcost_of_saleslostoldss) + $totalexpenses_salesoldss + $totalexpenses_manageoldss)){ //กรณี รวมรายได้ > รวมค่าใช้จ่าย
                    //   echo number_format (($totalincome_selloldss + $totalincome_otheroldss)-(($totalcost_of_salesoldss + $totalcost_of_saleslostoldss) + $totalexpenses_salesoldss + $totalexpenses_manageoldss),2);
                    // }
                    // else if(($totalincome_selloldss + $totalincome_otheroldss) < (($totalcost_of_salesoldss + $totalcost_of_saleslostoldss) + $totalexpenses_salesoldss + $totalexpenses_manageoldss)){ //กรณี รวมรายได้ < รวมค่าใช้จ่าย
                    //  echo number_format ((($totalcost_of_salesoldss + $totalcost_of_saleslostoldss) + $totalexpenses_salesoldss + $totalexpenses_manageoldss)-($totalincome_selloldss + $totalincome_otheroldss),2);
                    // }

                    // if(($totalincome_selloldss + $totalincome_otheroldss) > (($totalcost_of_salesoldss + $totalcost_of_saleslostoldss) + $totalexpenses_salesoldss + $totalexpenses_manageoldss)){ //กรณี รวมรายได้ > รวมค่าใช้จ่าย
                    //   echo number_format (($totalincome_selloldss + $totalincome_otheroldss)-(($totalcost_of_salesoldss + $totalcost_of_saleslostoldss) + $totalexpenses_salesoldss + $totalexpenses_manageoldss) + $totalcosts_financeoldss,2);
                    // }
                    // else if(($totalincome_selloldss + $totalincome_otheroldss) < (($totalcost_of_salesoldss + $totalcost_of_saleslostoldss) + $totalexpenses_salesoldss + $totalexpenses_manageoldss)){ //กรณี รวมรายได้ < รวมค่าใช้จ่าย
                    //  echo number_format ((($totalcost_of_salesoldss + $totalcost_of_saleslostoldss) + $totalexpenses_salesoldss + $totalexpenses_manageoldss)-($totalincome_selloldss + $totalincome_otheroldss) + $totalcosts_financeoldss,2);
                    // }

                    //กรณี รวมรายได้ > รวมค่าใช้จ่าย (จะต้อง - ต้นทุนทางการเงิน)
                    if((($totalincome_selloldss - $totalincome_discountoldss) + $totalincome_otheroldss) > (($totalcost_of_salesoldss + $totalcost_of_saleslostoldss) + $totalexpenses_salesoldss + $totalexpenses_manageoldss)){
                        if(($totalincome_selloldss + $totalincome_otheroldss) > (($totalcost_of_salesoldss + $totalcost_of_saleslostoldss) + $totalexpenses_salesoldss + $totalexpenses_manageoldss)){ //กรณี รวมรายได้ > รวมค่าใช้จ่าย
                          echo number_format (($totalincome_selloldss + $totalincome_otheroldss)-(($totalcost_of_salesoldss + $totalcost_of_saleslostoldss) + $totalexpenses_salesoldss + $totalexpenses_manageoldss) - $totalcosts_financeoldss,2);
                        }
                        else if(($totalincome_selloldss + $totalincome_otheroldss) < (($totalcost_of_salesoldss + $totalcost_of_saleslostoldss) + $totalexpenses_salesoldss + $totalexpenses_manageoldss)){ //กรณี รวมรายได้ < รวมค่าใช้จ่าย
                         echo number_format ((($totalcost_of_salesoldss + $totalcost_of_saleslostoldss) + $totalexpenses_salesoldss + $totalexpenses_manageoldss)-($totalincome_selloldss + $totalincome_otheroldss) - $totalcosts_financeoldss,2);
                        }
                    }
                    //กรณี รวมรายได้ < รวมค่าใช้จ่าย (จะต้อง + ต้นทุนทางการเงิน)
                    elseif ((($totalincome_selloldss - $totalincome_discountoldss) + $totalincome_otheroldss) < (($totalcost_of_salesoldss + $totalcost_of_saleslostoldss) + $totalexpenses_salesoldss + $totalexpenses_manageoldss)) {
                        if(($totalincome_selloldss + $totalincome_otheroldss) > (($totalcost_of_salesoldss + $totalcost_of_saleslostoldss) + $totalexpenses_salesoldss + $totalexpenses_manageoldss)){ //กรณี รวมรายได้ > รวมค่าใช้จ่าย
                          echo "(";
                          echo number_format (($totalincome_selloldss + $totalincome_otheroldss)-(($totalcost_of_salesoldss + $totalcost_of_saleslostoldss) + $totalexpenses_salesoldss + $totalexpenses_manageoldss) + $totalcosts_financeoldss,2);
                          echo ")";
                        }
                        else if(($totalincome_selloldss + $totalincome_otheroldss) < (($totalcost_of_salesoldss + $totalcost_of_saleslostoldss) + $totalexpenses_salesoldss + $totalexpenses_manageoldss)){ //กรณี รวมรายได้ < รวมค่าใช้จ่าย
                          echo "(";
                          echo number_format ((($totalcost_of_salesoldss + $totalcost_of_saleslostoldss) + $totalexpenses_salesoldss + $totalexpenses_manageoldss)-($totalincome_selloldss + $totalincome_otheroldss) + $totalcosts_financeoldss,2);
                          echo ")";
                        }
                    }
                    ?></b>
                  </td>
                </tr>

                <tr>
                  <td><b><?php echo "กำไร(ขาดทุน) สุทธิ"?></b></td>
                  <td></td>
                  <td align="right"><b>
                    <?php
                    // if(($totalincome_sell + $totalincome_other) > (($totalcost_of_sales + $totalcost_of_sales) + $totalexpenses_sales + $totalexpenses_manage)){ //กรณี รวมรายได้ > รวมค่าใช้จ่าย
                    //   echo number_format (($totalincome_sell + $totalincome_other)-(($totalcost_of_sales + $totalcost_of_sales) + $totalexpenses_sales + $totalexpenses_manage) + $totalcosts_finance,2);
                    // }
                    // else if(($totalincome_sell + $totalincome_other) < (($totalcost_of_sales + $totalcost_of_sales) + $totalexpenses_sales + $totalexpenses_manage)){ //กรณี รวมรายได้ < รวมค่าใช้จ่าย
                    //  echo number_format ((($totalcost_of_sales + $totalcost_of_sales) + $totalexpenses_sales + $totalexpenses_manage)-($totalincome_sell + $totalincome_other) + $totalcosts_finance,2);
                    // }

                    // if(($totalincome_sell + $totalincome_other) > (($totalcost_of_sales + $totalcost_of_saleslost) + $totalexpenses_sales + $totalexpenses_manage)){ //กรณี รวมรายได้ > รวมค่าใช้จ่าย
                    //   echo number_format (($totalincome_sell + $totalincome_other)-(($totalcost_of_sales + $totalcost_of_saleslost) + $totalexpenses_sales + $totalexpenses_manage) + $totalcosts_finance,2);
                    // }
                    // else if(($totalincome_sell + $totalincome_other) < (($totalcost_of_sales + $totalcost_of_saleslost) + $totalexpenses_sales + $totalexpenses_manage)){ //กรณี รวมรายได้ < รวมค่าใช้จ่าย
                    //  echo number_format ((($totalcost_of_sales + $totalcost_of_saleslost) + $totalexpenses_sales + $totalexpenses_manage)-($totalincome_sell + $totalincome_other) + $totalcosts_finance,2);
                    // }

                    //กรณี รวมรายได้ > รวมค่าใช้จ่าย (จะต้อง - ต้นทุนทางการเงิน)
                    if((($totalincome_sell - $totalincome_discount) + $totalincome_other) > (($totalcost_of_sales + $totalcost_of_saleslost) + $totalexpenses_sales + $totalexpenses_manage)){
                        if(($totalincome_sell + $totalincome_other) > (($totalcost_of_sales + $totalcost_of_saleslost) + $totalexpenses_sales + $totalexpenses_manage)){ //กรณี รวมรายได้ > รวมค่าใช้จ่าย
                          echo number_format (($totalincome_sell + $totalincome_other)-(($totalcost_of_sales + $totalcost_of_saleslost) + $totalexpenses_sales + $totalexpenses_manage) - $totalcosts_finance,2);
                        }
                        else if(($totalincome_sell + $totalincome_other) < (($totalcost_of_sales + $totalcost_of_saleslost) + $totalexpenses_sales + $totalexpenses_manage)){ //กรณี รวมรายได้ < รวมค่าใช้จ่าย
                         echo number_format ((($totalcost_of_sales + $totalcost_of_saleslost) + $totalexpenses_sales + $totalexpenses_manage)-($totalincome_sell + $totalincome_other) - $totalcosts_finance,2);
                        }
                    }
                    //กรณี รวมรายได้ < รวมค่าใช้จ่าย (จะต้อง + ต้นทุนทางการเงิน)
                    elseif((($totalincome_sell - $totalincome_discount) + $totalincome_other) < (($totalcost_of_sales + $totalcost_of_saleslost) + $totalexpenses_sales + $totalexpenses_manage)){
                        if(($totalincome_sell + $totalincome_other) > (($totalcost_of_sales + $totalcost_of_saleslost) + $totalexpenses_sales + $totalexpenses_manage)){ //กรณี รวมรายได้ > รวมค่าใช้จ่าย
                          echo "(";
                          echo number_format (($totalincome_sell + $totalincome_other)-(($totalcost_of_sales + $totalcost_of_saleslost) + $totalexpenses_sales + $totalexpenses_manage) + $totalcosts_finance,2);
                          echo ")";
                        }
                        else if(($totalincome_sell + $totalincome_other) < (($totalcost_of_sales + $totalcost_of_saleslost) + $totalexpenses_sales + $totalexpenses_manage)){ //กรณี รวมรายได้ < รวมค่าใช้จ่าย
                          echo "(";
                          echo number_format ((($totalcost_of_sales + $totalcost_of_saleslost) + $totalexpenses_sales + $totalexpenses_manage)-($totalincome_sell + $totalincome_other) + $totalcosts_finance,2);
                          echo ")";
                        }
                    }
                    ?></b>
                  </td>
                  <td align="right"><b>
                    <?php
                    // if(($totalincome_selloldss + $totalincome_otheroldss) > (($totalcost_of_salesoldss + $totalcost_of_salesoldss) + $totalexpenses_salesoldss + $totalexpenses_manageoldss)){ //กรณี รวมรายได้ > รวมค่าใช้จ่าย
                    //   echo number_format (($totalincome_selloldss + $totalincome_otheroldss)-(($totalcost_of_salesoldss + $totalcost_of_salesoldss) + $totalexpenses_salesoldss + $totalexpenses_manageoldss) + $totalcosts_financeoldss,2);
                    // }
                    // else if(($totalincome_selloldss + $totalincome_otheroldss) < (($totalcost_of_salesoldss + $totalcost_of_salesoldss) + $totalexpenses_salesoldss + $totalexpenses_manageoldss)){ //กรณี รวมรายได้ < รวมค่าใช้จ่าย
                    //  echo number_format ((($totalcost_of_salesoldss + $totalcost_of_salesoldss) + $totalexpenses_salesoldss + $totalexpenses_manageoldss)-($totalincome_selloldss + $totalincome_otheroldss) + $totalcosts_financeoldss,2);
                    // }

                    // if(($totalincome_selloldss + $totalincome_otheroldss) > (($totalcost_of_salesoldss + $totalcost_of_saleslostoldss) + $totalexpenses_salesoldss + $totalexpenses_manageoldss)){ //กรณี รวมรายได้ > รวมค่าใช้จ่าย
                    //   echo number_format (($totalincome_selloldss + $totalincome_otheroldss)-(($totalcost_of_salesoldss + $totalcost_of_saleslostoldss) + $totalexpenses_salesoldss + $totalexpenses_manageoldss) + $totalcosts_financeoldss,2);
                    // }
                    // else if(($totalincome_selloldss + $totalincome_otheroldss) < (($totalcost_of_salesoldss + $totalcost_of_saleslostoldss) + $totalexpenses_salesoldss + $totalexpenses_manageoldss)){ //กรณี รวมรายได้ < รวมค่าใช้จ่าย
                    //  echo number_format ((($totalcost_of_salesoldss + $totalcost_of_saleslostoldss) + $totalexpenses_salesoldss + $totalexpenses_manageoldss)-($totalincome_selloldss + $totalincome_otheroldss) + $totalcosts_financeoldss,2);
                    // }

                    //กรณี รวมรายได้ > รวมค่าใช้จ่าย (จะต้อง - ต้นทุนทางการเงิน)
                    if((($totalincome_selloldss - $totalincome_discountoldss) + $totalincome_otheroldss) > (($totalcost_of_salesoldss + $totalcost_of_saleslostoldss) + $totalexpenses_salesoldss + $totalexpenses_manageoldss)){
                        if(($totalincome_selloldss + $totalincome_otheroldss) > (($totalcost_of_salesoldss + $totalcost_of_saleslostoldss) + $totalexpenses_salesoldss + $totalexpenses_manageoldss)){ //กรณี รวมรายได้ > รวมค่าใช้จ่าย
                          echo number_format (($totalincome_selloldss + $totalincome_otheroldss)-(($totalcost_of_salesoldss + $totalcost_of_saleslostoldss) + $totalexpenses_salesoldss + $totalexpenses_manageoldss) - $totalcosts_financeoldss,2);
                        }
                        else if(($totalincome_selloldss + $totalincome_otheroldss) < (($totalcost_of_salesoldss + $totalcost_of_saleslostoldss) + $totalexpenses_salesoldss + $totalexpenses_manageoldss)){ //กรณี รวมรายได้ < รวมค่าใช้จ่าย
                         echo number_format ((($totalcost_of_salesoldss + $totalcost_of_saleslostoldss) + $totalexpenses_salesoldss + $totalexpenses_manageoldss)-($totalincome_selloldss + $totalincome_otheroldss) - $totalcosts_financeoldss,2);
                        }
                    }
                    //กรณี รวมรายได้ < รวมค่าใช้จ่าย (จะต้อง + ต้นทุนทางการเงิน)
                    elseif ((($totalincome_selloldss - $totalincome_discountoldss) + $totalincome_otheroldss) < (($totalcost_of_salesoldss + $totalcost_of_saleslostoldss) + $totalexpenses_salesoldss + $totalexpenses_manageoldss)) {
                        if(($totalincome_selloldss + $totalincome_otheroldss) > (($totalcost_of_salesoldss + $totalcost_of_saleslostoldss) + $totalexpenses_salesoldss + $totalexpenses_manageoldss)){ //กรณี รวมรายได้ > รวมค่าใช้จ่าย
                          echo "(";
                          echo number_format (($totalincome_selloldss + $totalincome_otheroldss)-(($totalcost_of_salesoldss + $totalcost_of_saleslostoldss) + $totalexpenses_salesoldss + $totalexpenses_manageoldss) + $totalcosts_financeoldss,2);
                          echo ")";
                        }
                        else if(($totalincome_selloldss + $totalincome_otheroldss) < (($totalcost_of_salesoldss + $totalcost_of_saleslostoldss) + $totalexpenses_salesoldss + $totalexpenses_manageoldss)){ //กรณี รวมรายได้ < รวมค่าใช้จ่าย
                          echo "(";
                          echo number_format ((($totalcost_of_salesoldss + $totalcost_of_saleslostoldss) + $totalexpenses_salesoldss + $totalexpenses_manageoldss)-($totalincome_selloldss + $totalincome_otheroldss) + $totalcosts_financeoldss,2);
                          echo ")";
                        }
                    }
                    ?></b>
                  </td>
                </tr>

                      </tbody>
                   </table>
                   <!-- </font> -->

                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </section>
  <!-- /.content -->
</div>
