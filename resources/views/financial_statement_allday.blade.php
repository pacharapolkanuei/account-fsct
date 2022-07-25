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
													<li class="breadcrumb-item">งบแสดงฐานะการเงิน</li>
													<li class="breadcrumb-item active">งบแสดงฐานะการเงิน (ทั้งหมด)</li>
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
        <form action="serachfinancial_statement_allday" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
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
                    <a href="printfinancial_statement_allday?reservation=<?php echo $datepicker;?>" target="_blank" ><img src="images/global/printall.png"></a>
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

                 $common_stock = 2000000; //หุ้นสามัญ
                 $num_stock = 20000; //จำนวนหุ้น
                 $cost_stock = 100; //มูลค่าหุ้น
                 $debt_long = 0; //ส่วนของหนี้สินระยะยาวที่ถึงกำหนดชำระภายในหนึ่งปี
                 $asset_no = 0; //หนี้สินไม่หมุนเวียนอื่น

                 $sumcash_dr = 0; //เงินสดและรายการเทียบเท่าเงินสด
                 $sumcash_cr = 0; //เงินสดและรายการเทียบเท่าเงินสด

                 $sumdebtor_dr = 0; //ลูกหนี้การค้าและลูกหนี้อื่น
                 $sumdebtor_cr = 0; //ลูกหนี้การค้าและลูกหนี้อื่น

                 $sumestate_dr = 0; //ที่ดิน อาคารและอุปกรณ์
                 $sumestate_cr = 0; //ที่ดิน อาคารและอุปกรณ์

                 $sumdepreciation_dr = 0; //ค่าเสื่อม
                 $sumdepreciation_cr = 0; //ค่าเสื่อม

                 $sumasset_no_dr = 0; //สินทรัพย์ไม่หมุนเวียนอื่น
                 $sumasset_no_cr = 0; //สินทรัพย์ไม่หมุนเวียนอื่น

                 $sumcreditor_dr =0; //เจ้าหนี้การค้าและเจ้าหนี้อื่น
                 $sumcreditor_cr =0; //เจ้าหนี้การค้าและเจ้าหนี้อื่น

                 $sumloan_short_dr =0; //เงินกู้ยืมระยะสั้น
                 $sumloan_short_cr =0; //เงินกู้ยืมระยะสั้น

                 $sumasset_dr =0; //หนี้สินหมุนเวียนอื่นๆ
                 $sumasset_cr =0; //หนี้สินหมุนเวียนอื่นๆ

                 //เงินกู้ยืมระยะยาว
                 $sumloan_long_dr =0;
                 $sumloan_long_cr =0;

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

                 $sumprofit_dr =0;  //กำไรสะสม
                 $sumprofit_cr =0;  //กำไรสะสม

                 $sumprofit_loss_dr =0; //กำไร(ขาดทุน)สะสม
                 $sumprofit_loss_cr =0; //กำไร(ขาดทุน)สะสม

                 $sumassetall_dr =0; //รวมหนี้สิน
                 $sumassetall_cr =0; //รวมหนี้สิน



  //-----------------------------------ยอดยกมา-----------------------------------

                $sumcash_dr_old = 0; //เงินสดและรายการเทียบเท่าเงินสด
                $sumcash_cr_old = 0; //เงินสดและรายการเทียบเท่าเงินสด

                $sumdebtor_dr_old = 0; //ลูกหนี้การค้าและลูกหนี้อื่น
                $sumdebtor_cr_old = 0; //ลูกหนี้การค้าและลูกหนี้อื่น

                $sumestate_dr_old = 0; //ที่ดิน อาคารและอุปกรณ์
                $sumestate_cr_old = 0; //ที่ดิน อาคารและอุปกรณ์

                $sumdepreciation_dr_old = 0; //ค่าเสื่อม
                $sumdepreciation_cr_old = 0; //ค่าเสื่อม

                $sumasset_no_dr_old = 0; //สินทรัพย์ไม่หมุนเวียนอื่น
                $sumasset_no_cr_old = 0; //สินทรัพย์ไม่หมุนเวียนอื่น

                $sumcreditor_dr_old =0; //เจ้าหนี้การค้าและเจ้าหนี้อื่น
                $sumcreditor_cr_old =0; //เจ้าหนี้การค้าและเจ้าหนี้อื่น

                $sumloan_short_dr_old =0; //เงินกู้ยืมระยะสั้น
                $sumloan_short_cr_old =0; //เงินกู้ยืมระยะสั้น

                $sumasset_dr_old =0; //หนี้สินหมุนเวียนอื่นๆ
                $sumasset_cr_old =0; //หนี้สินหมุนเวียนอื่นๆ

                //เงินกู้ยืมระยะยาว
                $sumloan_long_dr_old =0;
                $sumloan_long_cr_old =0;

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

                $sumprofit_dr_old =0;  //กำไรสะสม
                $sumprofit_cr_old =0;  //กำไรสะสม

  //-----------------------------------รวม----------------------------------------
                $totalcash =0; //เงินสดและรายการเทียบเท่าเงินสด
                $totaldebtor =0; //ลูกหนี้การค้าและลูกหนี้อื่น
                $totalestate =0; //ที่ดิน อาคารและอุปกรณ์
                $totaldepreciation =0; //ค่าเสื่อม
                $totalasset_no =0; //สินทรัพย์ไม่หมุนเวียนอื่น
                $totalcreditor =0; //เจ้าหนี้การค้าและเจ้าหนี้อื่น
                $totalloan_short =0; //เงินกู้ยืมระยะสั้น
                $totalasset =0; //หนี้สินหมุนเวียนอื่นๆ
                $totalloan_long =0; //เงินกู้ยืมระยะยาว
                $totalasset_no_ot =0; //หนี้สินไม่หมุนเวียนอื่น

                $totalincome_sell =0;
                $totalincome_discount = 0;
                $totalincome_other = 0;
                $totalcost_of_sales =0;
                $totalcost_of_saleslost =0;
                $totalexpenses_sales =0;
                $totalexpenses_manage =0;
                $totalcosts_finance =0;

                $totalprofit  =0; //กำไรสะสม

                $sumassetall = 0;
                $sumprofit_loss  = 0;

                 foreach ($data as $key => $value) { ?>

                 <?php

                     $subcost = substr($value->acc_code,0);
                     $subexpenses_cash = $subcost[0]."".$subcost[1]."".$subcost[2];

                     //-------------------เงินสดและรายการเทียบเท่าเงินสด---------------
                     if($value->acc_code == 111200 || $value->acc_code == 111201 || $subexpenses_cash == 112){
                       $sumcash_dr = $sumcash_dr + $value->sumdebit;
                       $sumcash_cr = $sumcash_cr + $value->sumcredit;
                     }

                     //-------------------ลูกหนี้การค้าและลูกหนี้อื่น---------------------
                     if($value->acc_code == 119101 || $value->acc_code == 119200 || $value->acc_code == 119201
                     || $value->acc_code == 119401 || $value->acc_code == 119402 || $value->acc_code == 119501
                     || $value->acc_code == 119502 || $value->acc_code == 119503 || $value->acc_code == 119504
                     || $subexpenses_cash == 113 || $subexpenses_cash == 114){
                       $sumdebtor_dr = $sumdebtor_dr + $value->sumdebit;
                       $sumdebtor_cr = $sumdebtor_cr + $value->sumcredit;
                     }

                     //------------------ที่ดิน อาคารและอุปกรณ์-----------------------
                     if($subexpenses_cash == 150 || $subexpenses_cash==151){
                       $sumestate_dr = $sumestate_dr + $value->sumdebit;
                       $sumestate_cr = $sumestate_cr + $value->sumcredit;
                     }

                     //---------------------------ค่าเสื่อม--------------------------
                     if($subexpenses_cash == 161){
                       $sumdepreciation_dr = $sumdepreciation_dr + $value->sumdebit;
                       $sumdepreciation_cr = $sumdepreciation_cr + $value->sumcredit;
                     }

                     //----------------------สินทรัพย์ไม่หมุนเวียนอื่น-------------------
                     if($value->acc_code == 119300 || $value->acc_code == 171100 || $value->acc_code == 192102 || $value->acc_code == 119100 || $value->acc_code == 119103){
                       $sumasset_no_dr = $sumasset_no_dr + $value->sumdebit;
                       $sumasset_no_cr = $sumasset_no_cr + $value->sumcredit;
                     }

                     //----------------------เจ้าหนี้การค้าและเจ้าหนี้อื่น-----------------
                     if($value->acc_code == 212100 || $value->acc_code == 212101 || $value->acc_code == 212102 || $value->acc_code == 219100 || $value->acc_code == 219101
                     || $value->acc_code == 219102 || $value->acc_code == 219103 || $value->acc_code == 219200 || $value->acc_code == 219201 || $value->acc_code == 219401
                     || $value->acc_code == 222000 || $value->acc_code == 219402 || $value->acc_code == 222001 || $value->acc_code == 219403 || $value->acc_code == 222002
                     || $value->acc_code == 219501 || $value->acc_code == 219503 || $value->acc_code == 219502  ){
                       $sumcreditor_dr = $sumcreditor_dr + $value->sumdebit;
                       $sumcreditor_cr = $sumcreditor_cr + $value->sumcredit;
                     }

                     //----------------------เงินกู้ยืมระยะสั้น-------------------------
                     if($value->acc_code == 219700 || $value->acc_code == 221000){
                       $sumloan_short_dr = $sumloan_short_dr + $value->sumdebit;
                       $sumloan_short_cr = $sumloan_short_cr + $value->sumcredit;
                     }

                     //----------------------หนี้สินหมุนเวียนอื่นๆ----------------------
                     if($value->acc_code == 219600){
                       $sumasset_dr = $sumasset_dr + $value->sumdebit;
                       $sumasset_cr = $sumasset_cr + $value->sumcredit;
                     }

                     //----------------------เงินกู้ยืมระยะยาว-------------------------
                     if($value->acc_code == 221100 || $value->acc_code == 221101 || $value->acc_code == 221103 || $value->acc_code == 221102){
                       $sumloan_long_dr = $sumloan_long_dr + $value->sumdebit;
                       $sumloan_long_cr = $sumloan_long_cr + $value->sumcredit;
                     }
                 ?>


                 <?php //กำไร (ขาดทุน) สะสม
                   //รายได้
                   //รายได้จากการขายหรือการให้บริการ
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

                   //ค่าใช้จ่าย
                   //ต้นทุนขายหรือต้นทุนการให้บริการ
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

                   //ต้นทุนทางการเงิน
                   $subcost = substr($value->acc_code,0);
                   // echo $subcost[0]; echo $subcost[1]; exit;
                   $subfinance = $subcost[0]."".$subcost[1];
                   // echo $subexpenses; exit;
                   if($subexpenses == 69){
                           $sumcosts_finance_dr = $sumcosts_finance_dr + $value->sumdebit;
                           $sumcosts_finance_cr = $sumcosts_finance_cr + $value->sumcredit;
                   }


                   //กำไรสะสม
                   if($value->acc_code == 322100 || $value->acc_code == 322101){
                     $sumprofit_dr = $sumprofit_dr + $value->sumdebit;
                     $sumprofit_cr = $sumprofit_cr + $value->sumcredit;
                   }

                 ?>


                 <?php $i++; } ?>

                 <?php
                 foreach ($data_yearold as $key2 => $value2) { ?>

                 <?php

                     $subcost = substr($value2->acc_code,0);
                     $subexpenses_cash = $subcost[0]."".$subcost[1]."".$subcost[2];
                     // echo $subexpenses_cash;

                     //-------------------เงินสดและรายการเทียบเท่าเงินสด---------------
                     if($value2->acc_code == 111200 || $value2->acc_code == 111201 || $subexpenses_cash == 112){
                       $sumcash_dr_old = $sumcash_dr_old + $value2->sumdebit;
                       $sumcash_cr_old = $sumcash_cr_old + $value2->sumcredit;
                     }

                     //-------------------ลูกหนี้การค้าและลูกหนี้อื่น---------------------
                     if($value2->acc_code == 119101 || $value2->acc_code == 119200 || $value2->acc_code == 119201
                     || $value2->acc_code == 119401 || $value2->acc_code == 119402 || $value2->acc_code == 119501
                     || $value2->acc_code == 119502 || $value2->acc_code == 119503 || $value2->acc_code == 119504
                     || $subexpenses_cash == 113 || $subexpenses_cash == 114){
                       $sumdebtor_dr_old = $sumdebtor_dr_old + $value2->sumdebit;
                       $sumdebtor_cr_old = $sumdebtor_cr_old + $value2->sumcredit;
                     }

                     //------------------ที่ดิน อาคารและอุปกรณ์-----------------------
                     if($subexpenses_cash == 150 || $subexpenses_cash == 151){
                       $sumestate_dr_old = $sumestate_dr_old + $value2->sumdebit;
                       $sumestate_cr_old = $sumestate_cr_old + $value2->sumcredit;
                     }

                     //---------------------------ค่าเสื่อม--------------------------
                     if($subexpenses_cash == 161){
                       $sumdepreciation_dr_old = $sumdepreciation_dr_old + $value2->sumdebit;
                       $sumdepreciation_cr_old = $sumdepreciation_cr_old + $value2->sumcredit;
                     }

                     //----------------------สินทรัพย์ไม่หมุนเวียนอื่น-------------------
                     if($value2->acc_code == 119300 || $value2->acc_code == 171100 || $value2->acc_code == 192102 || $value2->acc_code == 119100 || $value2->acc_code == 119103){
                       $sumasset_no_dr_old = $sumasset_no_dr_old + $value2->sumdebit;
                       $sumasset_no_cr_old = $sumasset_no_cr_old + $value2->sumcredit;
                     }

                     //----------------------เจ้าหนี้การค้าและเจ้าหนี้อื่น-----------------
                     if($value2->acc_code == 212100 || $value2->acc_code == 212101 || $value2->acc_code == 212102 || $value2->acc_code == 219100 || $value2->acc_code == 219101
                     || $value2->acc_code == 219102 || $value2->acc_code == 219103 || $value2->acc_code == 219200 || $value2->acc_code == 219201 || $value2->acc_code == 219401
                     || $value2->acc_code == 222000 || $value2->acc_code == 219402 || $value2->acc_code == 222001 || $value2->acc_code == 219403 || $value2->acc_code == 222002
                     || $value2->acc_code == 219501 || $value2->acc_code == 219503 || $value2->acc_code == 219502  ){
                       $sumcreditor_dr_old = $sumcreditor_dr_old + $value2->sumdebit;
                       $sumcreditor_cr_old = $sumcreditor_cr_old + $value2->sumcredit;
                     }

                     //----------------------เงินกู้ยืมระยะสั้น-------------------------
                     if($value2->acc_code == 219700 || $value2->acc_code == 221000){
                       $sumloan_short_dr_old = $sumloan_short_dr_old + $value2->sumdebit;
                       $sumloan_short_cr_old = $sumloan_short_cr_old + $value2->sumcredit;
                     }

                     //----------------------หนี้สินหมุนเวียนอื่นๆ----------------------
                     if($value2->acc_code == 219600){
                       $sumasset_dr_old = $sumasset_dr_old + $value2->sumdebit;
                       $sumasset_cr_old = $sumasset_cr_old + $value2->sumcredit;
                     }

                     //----------------------เงินกู้ยืมระยะยาว-------------------------
                     if($value2->acc_code == 221100 || $value2->acc_code == 221101 || $value2->acc_code == 221103 || $value2->acc_code == 221102){
                       $sumloan_long_dr_old = $sumloan_long_dr_old + $value2->sumdebit;
                       $sumloan_long_cr_old = $sumloan_long_cr_old + $value2->sumcredit;
                     }
                 ?>


                 <?php //กำไร (ขาดทุน) สะสม
                   //รายได้
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

                   //ค่าใช้จ่าย
                   //ต้นทุนขายหรือต้นทุนการให้บริการ
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

                   //ต้นทุนทางการเงิน
                   $subcost = substr($value2->acc_code,0);
                   // echo $subcost[0]; echo $subcost[1]; exit;
                   $subfinance = $subcost[0]."".$subcost[1];
                   // echo $subexpenses; exit;
                   if($subexpenses == 69){
                           $sumcosts_finance_old_dr = $sumcosts_finance_old_dr + $value2->sumdebit;
                           $sumcosts_finance_old_cr = $sumcosts_finance_old_cr + $value2->sumcredit;
                   }

                   //กำไรสะสม
                   if($value2->acc_code == 322100){
                     $sumprofit_dr_old = $sumprofit_dr_old + $value2->sumdebit;
                     $sumprofit_cr_old = $sumprofit_cr_old + $value2->sumcredit;
                   }

                 ?>

                 <?php $i++; } ?>

                 <?php
                 //เงินสดและรายการเทียบเท่าเงินสด
                 if(($sumcash_dr + $sumcash_dr_old) > ($sumcash_cr + $sumcash_cr_old)){
                     $totalcash = ($sumcash_dr + $sumcash_dr_old) - ($sumcash_cr + $sumcash_cr_old);
                 }elseif (($sumcash_dr + $sumcash_dr_old) < ($sumcash_cr + $sumcash_cr_old)) {
                     $totalcash = ($sumcash_cr + $sumcash_cr_old) - ($sumcash_dr + $sumcash_dr_old);
                 }

                 //ลูกหนี้การค้าและลูกหนี้อื่น
                 if(($sumdebtor_dr + $sumdebtor_dr_old) > ($sumdebtor_cr + $sumdebtor_cr_old)){
                     $totaldebtor = ($sumdebtor_dr + $sumdebtor_dr_old) - ($sumdebtor_cr + $sumdebtor_cr_old);
                 }elseif (($sumdebtor_dr + $sumdebtor_dr_old) < ($sumdebtor_cr + $sumdebtor_cr_old)) {
                     $totaldebtor = ($sumdebtor_cr + $sumdebtor_cr_old) - ($sumdebtor_dr + $sumdebtor_dr_old);
                 }

                 //ที่ดิน อาคารและอุปกรณ์
                 if(($sumestate_dr + $sumestate_dr_old) > ($sumestate_cr + $sumestate_cr_old)){
                     $totalestate = ($sumestate_dr + $sumestate_dr_old) - ($sumestate_cr + $sumestate_cr_old);
                 }elseif (($sumestate_dr + $sumestate_dr_old) < ($sumestate_cr + $sumestate_cr_old)) {
                     $totalestate = ($sumestate_cr + $sumestate_cr_old) - ($sumestate_dr + $sumestate_dr_old);
                 }

                 //ค่าเสื่อม
                 if(($sumdepreciation_dr + $sumdepreciation_dr_old) > ($sumdepreciation_cr + $sumdepreciation_cr_old)){
                     $totaldepreciation = ($sumdepreciation_dr + $sumdepreciation_dr_old) - ($sumdepreciation_cr + $sumdepreciation_cr_old);
                 }elseif (($sumdepreciation_dr + $sumdepreciation_dr_old) < ($sumdepreciation_cr + $sumdepreciation_cr_old)) {
                     $totaldepreciation = ($sumdepreciation_cr + $sumdepreciation_cr_old) - ($sumdepreciation_dr + $sumdepreciation_dr_old);
                 }

                 //สินทรัพย์ไม่หมุนเวียนอื่น
                 if(($sumasset_no_dr + $sumasset_no_dr_old) > ($sumasset_no_cr + $sumasset_no_cr_old)){
                     $totalasset_no = ($sumasset_no_dr + $sumasset_no_dr_old) - ($sumasset_no_cr + $sumasset_no_cr_old);
                 }elseif (($sumasset_no_dr + $sumasset_no_dr_old) < ($sumasset_no_cr + $sumasset_no_cr_old)) {
                     $totalasset_no = ($sumasset_no_cr + $sumasset_no_cr_old) - ($sumasset_no_dr + $sumasset_no_dr_old);
                 }

                 //เจ้าหนี้การค้าและเจ้าหนี้อื่น
                 if(($sumcreditor_dr + $sumcreditor_dr_old) > ($sumcreditor_cr + $sumcreditor_cr_old)){
                     $totalcreditor = ($sumcreditor_dr + $sumcreditor_dr_old) - ($sumcreditor_cr + $sumcreditor_cr_old);
                 }elseif (($sumcreditor_dr + $sumcreditor_dr_old) < ($sumcreditor_cr + $sumcreditor_cr_old)) {
                     $totalcreditor = ($sumcreditor_cr + $sumcreditor_cr_old) - ($sumcreditor_dr + $sumcreditor_dr_old);
                 }

                 //เงินกู้ยืมระยะสั้น
                 if(($sumloan_short_dr + $sumloan_short_dr_old) > ($sumloan_short_cr + $sumloan_short_cr_old)){
                     $totalloan_short = ($sumloan_short_dr + $sumloan_short_dr_old) - ($sumloan_short_cr + $sumloan_short_cr_old);
                 }elseif (($sumloan_short_dr + $sumloan_short_dr_old) < ($sumloan_short_cr + $sumloan_short_cr_old)) {
                     $totalloan_short = ($sumloan_short_cr + $sumloan_short_cr_old) - ($sumloan_short_dr + $sumloan_short_dr_old);
                 }

                 //หนี้สินหมุนเวียนอื่นๆ
                 if(($sumasset_dr + $sumasset_dr_old) > ($sumasset_cr + $sumasset_cr_old)){
                     $totalasset = ($sumasset_dr + $sumasset_dr_old) - ($sumasset_cr + $sumasset_cr_old);
                 }elseif (($sumasset_dr + $sumasset_dr_old) < ($sumasset_cr + $sumasset_cr_old)) {
                     $totalasset = ($sumasset_cr + $sumasset_cr_old) - ($sumasset_dr + $sumasset_dr_old);
                 }

                 //เงินกู้ยืมระยะยาว
                 if(($sumloan_long_dr + $sumloan_long_dr_old) > ($sumloan_long_cr + $sumloan_long_cr_old)){
                     $totalloan_long = ($sumloan_long_dr + $sumloan_long_dr_old) - ($sumloan_long_cr + $sumloan_long_cr_old);
                 }elseif (($sumloan_long_dr + $sumloan_long_dr_old) < ($sumloan_long_cr + $sumloan_long_cr_old)) {
                     $totalloan_long = ($sumloan_long_cr + $sumloan_long_cr_old) - ($sumloan_long_dr + $sumloan_long_dr_old);
                 }
                 ?>

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

                 // //ต้นทุนทางการเงิน
                 // if(($sumprofit_dr + $sumcosts_finance_old_dr) > ($sumprofit_cr + $sumcosts_finance_old_cr)){
                 //     $totalprofit = ($sumprofit_dr + $sumcosts_finance_old_dr) - ($sumprofit_cr + $sumcosts_finance_old_cr);
                 // }elseif (($sumprofit_dr + $sumcosts_finance_old_dr) < ($sumprofit_cr + $sumcosts_finance_old_cr)) {
                 //     $totalprofit = ($sumprofit_cr + $sumcosts_finance_old_cr) - ($sumprofit_dr + $sumcosts_finance_old_dr);
                 // }

                 //กำไรสะสม
                 if(($sumprofit_dr + $sumprofit_dr_old) > ($sumprofit_cr + $sumprofit_cr_old)){
                     $totalprofit = ($sumprofit_dr + $sumprofit_dr_old) - ($sumprofit_cr + $sumprofit_cr_old);
                 }elseif (($sumprofit_dr + $sumprofit_dr_old) < ($sumprofit_cr + $sumprofit_cr_old)) {
                     $totalprofit = ($sumprofit_cr + $sumprofit_cr_old) - ($sumprofit_dr + $sumprofit_dr_old);
                 }
                 ?>

                 </form>

                 <tr><td colspan="3"><b><?php echo "งบแสดงฐานะการเงิน"?></b></td></tr>
                 <tr>
                   <td><b><?php echo "สินทรัพย์"?></b>
                    <?php echo "<br><b>";echo "&nbsp;&nbsp;สินทรัพย์หมุนเวียน</b>";
                              echo "<br>";echo "&nbsp;&nbsp;&nbsp;&nbsp;เงินสดและรายการเทียบเท่าเงินสด";
                              echo "<br>";echo "&nbsp;&nbsp;&nbsp;&nbsp;ลูกหนี้การค้าและลูกหนี้อื่น";
                              echo "<br><b>";echo "&nbsp;&nbsp;&nbsp;&nbsp;รวมสินทรัพย์หมุนเวียน</b>";

                          echo "<br><b>";echo "&nbsp;&nbsp;สินทรัพย์ไม่หมุนเวียน</b>";
                              echo "<br>";echo "&nbsp;&nbsp;&nbsp;&nbsp;ที่ดิน อาคารและอุปกรณ์";
                              echo "<br>";echo "&nbsp;&nbsp;&nbsp;&nbsp;สินทรัพย์ไม่หมุนเวียนอื่น";
                              echo "<br><b>";echo "&nbsp;&nbsp;&nbsp;&nbsp;รวมสินทรัพย์ไม่หมุนเวียน</b>";
                          echo "<br><b>";echo "&nbsp;&nbsp;รวมสินทรัพย์</b>";
                    ?>
                   </td>
                   <td></td>
                   <td align="right">
                   <?php echo "<br>";
                           echo "<br>"; echo number_format ($totalcash,2); //เงินสดและรายการเทียบเท่าเงินสด
                           echo "<br>"; echo number_format ($totaldebtor,2); //ลูกหนี้การค้าและลูกหนี้อื่น
                           echo "<br><b>"; echo number_format ($totalcash + $totaldebtor,2)."</b>"; //รวมสินทรัพย์หมุนเวียน

                         echo "<br>";
                           echo "<br>"; echo number_format ($totalestate - $totaldepreciation,2); //ที่ดิน อาคารและอุปกรณ์
                           echo "<br>"; echo number_format ($totalasset_no,2); //สินทรัพย์ไม่หมุนเวียนอื่น
                           echo "<br><b>"; echo number_format (($totalestate - $totaldepreciation)+ $totalasset_no,2); //รวมสินทรัพย์ไม่หมุนเวียน
                         echo "<br>"; echo number_format (($totalcash + $totaldebtor) + (($totalestate - $totaldepreciation)+ $totalasset_no),2)."</b>"; //รวมสินทรัพย์
                   ?>
                  </td>
                 </tr>

                 <tr>
                   <td><b><?php echo "หนี้สินและส่วนของผู้ถือหุ้น"?></b>
                    <?php echo "<br><b>";echo "&nbsp;&nbsp;หนี้สินหมุนเวียน</b>";
                              echo "<br>";echo "&nbsp;&nbsp;&nbsp;&nbsp;เจ้าหนี้การค้าและเจ้าหนี้อื่น";
                              echo "<br>";echo "&nbsp;&nbsp;&nbsp;&nbsp;ส่วนของหนี้สินระยะยาวที่ถึงกำหนดชำระภายในหนึ่งปี";
                              echo "<br>";echo "&nbsp;&nbsp;&nbsp;&nbsp;เงินกู้ยืมระยะสั้น";
                              echo "<br>";echo "&nbsp;&nbsp;&nbsp;&nbsp;หนี้สินหมุนเวียนอื่นๆ";
                              echo "<br><b>";echo "&nbsp;&nbsp;&nbsp;&nbsp;รวมหนี้สินหมุนเวียน</b>";

                              echo "<br><b>";echo "&nbsp;&nbsp;หนี้สินไม่หมุนเวียน</b>";
                              echo "<br>";echo "&nbsp;&nbsp;&nbsp;&nbsp;เงินกู้ยืมระยะยาว";
                              echo "<br>";echo "&nbsp;&nbsp;&nbsp;&nbsp;หนี้สินไม่หมุนเวียนอื่น";
                              echo "<br><b>";echo "&nbsp;&nbsp;&nbsp;&nbsp;รวมหนี้สินไม่หมุนเวียน</b>";
                          echo "<br><b>";echo "&nbsp;&nbsp;รวมหนี้สิน</b>";


                          echo "<br><b>";echo "&nbsp;&nbsp;ส่วนของผู้ถือหุ้น</b>";
                              echo "<br>";echo "&nbsp;&nbsp;&nbsp;&nbsp;ทุนเรือนหุ้น";
                              echo "<br>";echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ทุนจดทะเบียน";
                              echo "<br>";echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;หุ้นสามัญ";
                              echo "<br>";echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;จำนวนหุ้น";
                              echo "<br>";echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;มูลค่าหุ้น";

                              echo "<br>";echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ทุนที่ชำระแล้ว";
                              echo "<br>";echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;หุ้นสามัญ";

                              echo "<br>";echo "&nbsp;&nbsp;&nbsp;&nbsp;กำไร(ขาดทุน)สะสม";
                              echo "<br>";echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ยังไม่ได้จัดสรร";
                              echo "<br><b>";echo "&nbsp;&nbsp;&nbsp;&nbsp;รวมส่วนของผู้ถือหุ้น</b>";
                          echo "<br><b>";echo "&nbsp;&nbsp;รวมหนี้สินและส่วนของผู้ถือหุ้น</b>";
                    ?>
                   </td>
                   <td></td>
                   <td align="right">
                   <?php echo "<br>";
                           echo "<br>"; echo number_format ($totalcreditor,2); //เจ้าหนี้การค้าและเจ้าหนี้อื่น
                           echo "<br>"; echo number_format ($debt_long,2); //ส่วนของหนี้สินระยะยาวที่ถึงกำหนดชำระภายในหนึ่งปี
                           echo "<br>"; echo number_format ($totalloan_short,2); //เงินกู้ยืมระยะสั้น
                           echo "<br>"; echo number_format ($totalasset,2); //หนี้สินหมุนเวียนอื่นๆ
                         echo "<br><b>"; echo number_format ($totalcreditor + $debt_long + $totalloan_short + $totalasset,2)."</b>"; //รวมหนี้สินหมุนเวียน

                         echo "<br>";
                           echo "<br>"; echo number_format ($totalloan_long,2); //เงินกู้ยืมระยะยาว
                           echo "<br>"; echo number_format ($totalasset_no_ot,2); //หนี้สินไม่หมุนเวียนอื่น
                           echo "<br><b>"; echo number_format ($totalloan_long + $totalasset_no_ot,2); //รวมหนี้สินไม่หมุนเวียน
                         echo "<br>"; echo number_format (($totalcreditor + $debt_long + $totalloan_short + $totalasset) + ($totalloan_long + $totalasset_no_ot),2)."</b>"; //รวมหนี้สิน
                         $sumassetall = ($totalcreditor + $debt_long + $totalloan_short + $totalasset) + ($totalloan_long + $totalasset_no_ot);

                         echo "<br>"; echo "<br>"; echo "<br>";
                           echo "<br>"; echo number_format ($common_stock,2); //หุ้นสามัญ
                           echo "<br>"; echo number_format ($num_stock,2); //จำนวนหุ้น
                           echo "<br>"; echo number_format ($cost_stock,2); //มูลค่าหุ้น
                         echo "<br>";
                           echo "<br>"; echo number_format ($common_stock,2); //หุ้นสามัญ

                         // echo "<br>";
                         //   echo "<br>"; //ยังไม่ได้จัดสรร
                         //   if(($totalincome_sell + $totalincome_other) > (($totalcost_of_sales + $totalcost_of_saleslost) + $totalexpenses_sales + $totalexpenses_manage)){ //กรณี รวมรายได้ > รวมค่าใช้จ่าย
                         //     echo number_format (($totalincome_sell + $totalincome_other)-(($totalcost_of_sales + $totalcost_of_saleslost) + $totalexpenses_sales + $totalexpenses_manage) + $totalcosts_finance + $totalprofit,2);
                         //     $sumprofit_loss = ($totalincome_sell + $totalincome_other)-(($totalcost_of_sales + $totalcost_of_saleslost) + $totalexpenses_sales + $totalexpenses_manage) + $totalcosts_finance + $totalprofit;
                         //   }
                         //   else if(($totalincome_sell + $totalincome_other) < (($totalcost_of_sales + $totalcost_of_saleslost) + $totalexpenses_sales + $totalexpenses_manage)){ //กรณี รวมรายได้ < รวมค่าใช้จ่าย
                         //    echo number_format ((($totalcost_of_sales + $totalcost_of_saleslost) + $totalexpenses_sales + $totalexpenses_manage)-($totalincome_sell + $totalincome_other) + $totalcosts_finance + $totalprofit,2);
                         //    $sumprofit_loss = (($totalcost_of_sales + $totalcost_of_saleslost) + $totalexpenses_sales + $totalexpenses_manage)-($totalincome_sell + $totalincome_other) + $totalcosts_finance + $totalprofit;
                         //   }
                         // echo "<br><b>"; //รวมส่วนของผู้ถือหุ้น
                         // if($sumprofit_loss > $common_stock){ //กรณี กำไร(ขาดทุน)สะสม > หุ้นสามัญ
                         //   echo number_format ($sumprofit_loss - $common_stock,2);
                         // }elseif ($sumprofit_loss < $common_stock) { //กรณี กำไร(ขาดทุน)สะสม < หุ้นสามัญ
                         //   echo number_format ($common_stock - $sumprofit_loss,2);
                         // }
                         //
                         // echo "<br>"; //รวมหนี้สินและส่วนของผู้ถือหุ้น
                         // if($sumassetall > ($sumprofit_loss - $common_stock)){ //กรณี หนี้สิน > ส่วนของผู้ถือหุ้น
                         //   echo number_format ($sumassetall - ($sumprofit_loss - $common_stock),2)."</b>";
                         // }elseif ($sumassetall < ($sumprofit_loss - $common_stock)) { //กรณี หนี้สิน < ส่วนของผู้ถือหุ้น
                         //   echo number_format (($sumprofit_loss - $common_stock) - $sumassetall,2)."</b>";
                         // }

                         echo "<br>";
                           echo "<br>("; //ยังไม่ได้จัดสรร
                           if(($totalincome_sell + $totalincome_other) > (($totalcost_of_sales + $totalcost_of_saleslost) + $totalexpenses_sales + $totalexpenses_manage)){ //กรณี รวมรายได้ > รวมค่าใช้จ่าย
                             echo number_format (($totalincome_sell + $totalincome_other)-(($totalcost_of_sales + $totalcost_of_saleslost) + $totalexpenses_sales + $totalexpenses_manage) + $totalcosts_finance + $totalprofit,2);
                             $sumprofit_loss = ($totalincome_sell + $totalincome_other)-(($totalcost_of_sales + $totalcost_of_saleslost) + $totalexpenses_sales + $totalexpenses_manage) + $totalcosts_finance + $totalprofit;
                           }
                           else if(($totalincome_sell + $totalincome_other) < (($totalcost_of_sales + $totalcost_of_saleslost) + $totalexpenses_sales + $totalexpenses_manage)){ //กรณี รวมรายได้ < รวมค่าใช้จ่าย
                            echo number_format ((($totalcost_of_sales + $totalcost_of_saleslost) + $totalexpenses_sales + $totalexpenses_manage)-($totalincome_sell + $totalincome_other) + $totalcosts_finance + $totalprofit,2);
                            $sumprofit_loss = (($totalcost_of_sales + $totalcost_of_saleslost) + $totalexpenses_sales + $totalexpenses_manage)-($totalincome_sell + $totalincome_other) + $totalcosts_finance + $totalprofit;
                          }else {
                            echo number_format ($totalprofit_oldss,2);
                            $sumprofit_loss = $totalprofit_oldss;
                          }
                         echo ")<br><b>("; //รวมส่วนของผู้ถือหุ้น
                         if($sumprofit_loss > $common_stock){ //กรณี กำไร(ขาดทุน)สะสม > หุ้นสามัญ
                           echo number_format ($sumprofit_loss - $common_stock,2);
                         }elseif ($sumprofit_loss < $common_stock) { //กรณี กำไร(ขาดทุน)สะสม < หุ้นสามัญ
                           echo number_format ($common_stock - $sumprofit_loss,2);
                         }

                         echo ")<br>"; //รวมหนี้สินและส่วนของผู้ถือหุ้น
                         if($sumassetall > ($sumprofit_loss - $common_stock)){ //กรณี หนี้สิน > ส่วนของผู้ถือหุ้น
                           echo number_format ($sumassetall - ($sumprofit_loss - $common_stock),2)."</b>";
                         }elseif ($sumassetall < ($sumprofit_loss - $common_stock)) { //กรณี หนี้สิน < ส่วนของผู้ถือหุ้น
                           echo number_format (($sumprofit_loss - $common_stock) - $sumassetall,2)."</b>";
                         }
                   ?>
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
