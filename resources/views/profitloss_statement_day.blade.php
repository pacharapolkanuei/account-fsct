<?php

use  App\Api\Connectdb;
use  App\Api\Accountcenter;
use  App\Api\Maincenter;
use  App\Api\Vendorcenter;
use  App\Api\DateTime;

?>
@extends('index')
@section('content')
<!-- End Sidebar -->

<!-- css data table -->
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css" />
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" />
<!-- SWAL -->
<script type="text/javascript" src="https://unpkg.com/sweetalert2@7.0.6/dist/sweetalert2.all.js"></script>
<!-- jquery account debt -->
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<script src="bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>

<link rel="stylesheet" href="bower_components/bootstrap-daterangepicker/daterangepicker.css">

<script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>

<script type="text/javascript" src = 'js/accountjs/reservemoney.js'></script>

<div class="content-page">
	<!-- Start content -->
  <div class="content">
       <div class="container-fluid">

					   <div class="row">
									<div class="col-xl-12">
											<div class="breadcrumb-holder" id="fontscontent">
													<h1 class="float-left">Account - FSCT</h1>
													<ol class="breadcrumb float-right">
													<li class="breadcrumb-item">งบกำไรขาดทุน</li>
													<li class="breadcrumb-item active">งบกำไรขาดทุน (รายสาขา)</li>
													</ol>
													<div class="clearfix"></div>
											</div>
									</div>
						</div>
			<!-- end row -->

      <div class="row">
          <br>
      </div>

      <!-- <div class="box-body" style="overflow-x:auto;"> -->
        <form action="serachprofitloss_statement_day" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <div class="row">
              <div class="col-md-2">

              </div>

              <div class="col-md-3">
                  <p class="text-right">
                    ค้นหาสาขา
                  </p>
              </div>
              <div class="col-md-2">
                <?php
                  $db = Connectdb::Databaseall();
                  $sql = 'SELECT '.$db['hr_base'].'.branch.*
                          FROM '.$db['hr_base'].'.branch
                          WHERE '.$db['hr_base'].'.branch.status = "1"';

                  $brcode = DB::connection('mysql')->select($sql);
                ?>
                  <select name="branch_id" id="branch_id" class="form-control" required>
                    <option value="">เลือกสาขา</option>
                    <?php foreach ($brcode as $key => $value) { ?>
                        <option value="<?php echo $value->code_branch?>" <?php if(isset($query)){ if($branch_id==$value->code_branch){ echo "selected";} }?>><?php echo $value->name_branch?></option>
                    <?php } ?>
                  </select>
              </div>
          </div>

          <div class="row">
              <br>
          </div>
          <div class="row">
              <div class="col-md-2">

              </div>
              <div class="col-md-3">
                  <p class="text-right">
                    วันที่
                  </p>
              </div>
              <div class="col-md-2">
                  <input type="text" name="reservation" id="reservation" value="<?php if(isset($query)){ print_r($datepicker); }else{ echo date('d/m/Y');}?>" class="form-control" required readonly>
              </div>

              <div class="col-md-2">

              </div>
              <div class="col-md-3">

              </div>

          </div>

          <div class="row">
              <br>
          </div>

          <div class="row">
            <div class="col-md-5">

            </div>
            <div class="col-md-3">
              <input type="submit" class="btn btn-primary" value="ค้นหา">
              <input type="reset" class="btn btn-danger">
            </div>
          </div>

          <div class="row">
              <br>
          </div>

          </form>
        <!-- </div> -->

        <div class="col-md-6">
          <?php   if(isset($query)){ //echo $branch_id; ?>

            <?php  //if(isset($group_branch_acc_select) && $group_branch_acc_select != ''){?>
                    <!-- <a href="printcovertaxabb?group_branch_acc_select=<?php //echo $group_branch_acc_select ;?>&&datepickerstart=<?php //echo $datepicker2['start_date'];?>&&datepickerend=<?php  //echo $datepicker2['end_date'];?>"><img src="images/global/printall.png"></a> -->
            <?php //}else { ?>
            <?php //$path = '&branch_id='.$branch_id?>
                    <!-- <a href="<?php //echo url("/excelreportaccruedall?$path");?>" target="_blank"><img src="images/global/printall.png"></a> -->
                    <a href="printprofitloss_statement_day?branch_id=<?php echo $branch_id;?>&&reservation=<?php echo $datepicker;?>" target="_blank" ><img src="images/global/printall.png"></a>
            <?php //} ?>

          <?php } ?>
        </div>

        <div class="row">
            <br>
        </div>

        <div class="row">
        <div class="col-md-12">
          <?php
          if(isset($query)){
              // echo "<pre>";
              // print_r($data);
              // print_r($datatold);
              // print_r($datepicker);
              // print_r($branch_id);
              // exit;

              $datepicker_sub = explode("-",trim($datepicker));

              $datepickerstart = explode("/",trim(($datepicker_sub[0])));
              if(count($datepickerstart) > 0) {
                  $datetime = $datepickerstart[1] . '-' . $datepickerstart[0]; //วัน - เดือน
              }

              $datepickerend = explode("/",trim(($datepicker_sub[1])));
              if(count($datepickerend) > 0) {
                  $datetime2 = $datepickerend[1] . '-' . $datepickerend[0]; //วัน - เดือน
              }

              if($datepickerstart[0] == "01"){$monthTH = "มกราคม";
                }else if($datepickerstart[0] == "02"){$monthTH = "กุมภาพันธ์";
                }else if($datepickerstart[0] == "03"){$monthTH = "มีนาคม";
                }else if($datepickerstart[0] == "04"){$monthTH = "เมษายน";
                }else if($datepickerstart[0] == "05"){$monthTH = "พฤษภาคม";
                }else if($datepickerstart[0] == "06"){$monthTH = "มิถุนายน";
                }else if($datepickerstart[0] == "07"){$monthTH = "กรกฎาคม";
                }else if($datepickerstart[0] == "08"){$monthTH = "สิงหาคม";
                }else if($datepickerstart[0] == "09"){$monthTH = "กันยายน";
                }else if($datepickerstart[0] == "10"){$monthTH = "ตุลาคม";
                }else if($datepickerstart[0] == "11"){$monthTH = "พฤศจิกายน";
                }else if($datepickerstart[0] == "12"){$monthTH = "ธันวาคม";
                }

              if($datepickerend[0] == "01"){$monthTH2 = "มกราคม";
                }else if($datepickerend[0] == "02"){$monthTH2 = "กุมภาพันธ์";
                }else if($datepickerend[0] == "03"){$monthTH2 = "มีนาคม";
                }else if($datepickerend[0] == "04"){$monthTH2 = "เมษายน";
                }else if($datepickerend[0] == "05"){$monthTH2 = "พฤษภาคม";
                }else if($datepickerend[0] == "06"){$monthTH2 = "มิถุนายน";
                }else if($datepickerend[0] == "07"){$monthTH2 = "กรกฎาคม";
                }else if($datepickerend[0] == "08"){$monthTH2 = "สิงหาคม";
                }else if($datepickerend[0] == "09"){$monthTH2 = "กันยายน";
                }else if($datepickerend[0] == "10"){$monthTH2 = "ตุลาคม";
                }else if($datepickerend[0] == "11"){$monthTH2 = "พฤศจิกายน";
                }else if($datepickerend[0] == "12"){$monthTH2 = "ธันวาคม";
                }

            ?>

            <!-- <form action="configreportcashdailynow" onSubmit="if(!confirm('ยืนยันการทำรายการ?')){return false;}" method="post" class="form-horizontal"> -->
            <!-- <input type="hidden" name="_token" value="{{ csrf_token() }}"> -->
            <form action="saveapprovedpo" method="post" enctype="multipart/form-data" onSubmit="JavaScript:return fncSubmit();">
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <!-- <table class="table table-striped"> -->
            <table id="example" class="table table-striped table-bordered fontslabel" style="width:100%">
               <thead>
                 <tr>
                   <th rowspan="2"></th>
                   <td colspan="2" align="right"><b>หน่วย: แสดงตามจริง (Actuals),บาท</b></td>
                 </tr>

                 <tr>
                     <th><center>หมายเหตุ</center></th>
                     <th><center><?php echo $datepickerstart[1]." ".$monthTH." ".$datepickerstart[2];?> - <?php echo $datepickerend[1]." ".$monthTH2." ".$datepickerend[2];?></center></th>
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


//-----------------------------------ยอดยกมา-----------------------------------
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

//-----------------------------------รวม----------------------------------------
               $totalincome_sell =0;
               $totalincome_discount = 0;
               $totalincome_other = 0;
               $totalcost_of_sales =0;
               $totalcost_of_saleslost =0;
               $totalexpenses_sales =0;
               $totalexpenses_manage =0;
               $totalcosts_finance =0;

               foreach ($data as $key => $value) { ?>

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
               //ยอดยกมา
               foreach ($datatold as $key2 => $value2) { ?>

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

               </form>

               <tr><td colspan="3"><b><?php echo "งบกำไรขาดทุน"?></b></td></tr>
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
               </tr>

               <tr>
                 <td><b><?php echo "ค่าใช้จ่าย"?></b>
                  <?php echo "<br>";
                              echo "&nbsp;&nbsp;ต้นทุนขายหรือต้นทุนการให้บริการ";
                        echo "<br>";
                              echo "&nbsp;&nbsp;ค่าใช้จ่ายในการขาย";
                        echo "<br>";
                              echo "&nbsp;&nbsp;ค่าใช้จ่ายในการบริหาร";
                        echo "<b>";
                        echo "<br>";
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
               </tr>

               <tr>
                 <td><b><?php echo "กำไร(ขาดทุน) ก่อนต้นทุนทางการเงินและค่าใช้จ่ายภาษีเงินได้"?></b></td>
                 <td></td>
                 <td align="right"><b>
                  <?php
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
               </tr>

               <tr>
                 <td><b><?php echo "ต้นทุนทางการเงิน"?></b></td>
                 <td></td>
                 <td align="right"><b>(<?php echo number_format ($totalcosts_finance,2);?>)</b></td>
               </tr>

               <tr>
                 <td><b><?php echo "กำไร(ขาดทุน) ก่อนค่าใช้จ่ายภาษีเงินได้"?></b></td>
                 <td></td>
                 <td align="right"><b>
                   <?php
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
               </tr>

               <tr>
                 <td><b><?php echo "กำไร(ขาดทุน) สุทธิ"?></b></td>
                 <td></td>
                 <td align="right"><b>
                   <?php
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
               </tr>


              </tbody>
             </table>


             <?php  }  ?>

            </div>
         </div>

		  </div>
		<!-- END content -->
  </div>
	<!-- END content-page -->
</div>
<!-- END main -->
@endsection
