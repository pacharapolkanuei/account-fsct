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
													<li class="breadcrumb-item active">ต้นทุนขายหรือต้นทุนการให้บริการ</li>
													</ol>
													<div class="clearfix"></div>
											</div>
									</div>
						</div>
			<!-- end row -->

      <div class="row">
          <br>
      </div>


        <div class="col-md-6">
          <?php   if(isset($query)){ //echo $branch_id; ?>

            <?php  //if(isset($group_branch_acc_select) && $group_branch_acc_select != ''){?>
                    <!-- <a href="printcovertaxabb?group_branch_acc_select=<?php //echo $group_branch_acc_select ;?>&&datepickerstart=<?php //echo $datepicker2['start_date'];?>&&datepickerend=<?php  //echo $datepicker2['end_date'];?>"><img src="images/global/printall.png"></a> -->
            <?php //}else { ?>
            <?php //$path = '&branch_id='.$branch_id?>
                    <!-- <a href="<?php //echo url("/excelreportaccruedall?$path");?>" target="_blank"><img src="images/global/printall.png"></a> -->
                    <!-- <a href="printprofitloss_statement_day?branch_id=<?php //echo $branch_id;?>&&reservation=<?php //echo $datepicker;?>" target="_blank" ><img src="images/global/printall.png"></a> -->
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
              echo "<pre>";
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

               //ค่าใช้จ่าย
               $sumcost_of_sales_dr = 0; //ซื้อสินค้า
               $sumcost_of_sales_cr = 0; //ซื้อสินค้า

               $sumcost_of_salesre_dr = 0; //สินค้าส่งคืน
               $sumcost_of_salesre_cr = 0; //สินค้าส่งคืน

               $sumcost_of_salesdis_dr = 0; //ส่วนลดรับ
               $sumcost_of_salesdis_cr = 0; //ส่วนลดรับ

               $sumcost_of_saleslost_dr = 0; //สินค้าสูญหาย
               $sumcost_of_saleslost_cr = 0; //สินค้าสูญหาย

               $sumcost_of_saleslostmain_dr = 0; //ค่าซ่อมแซมบำรุงอุปกรณ์ให้เช่า
               $sumcost_of_saleslostmain_cr = 0; //ค่าซ่อมแซมบำรุงอุปกรณ์ให้เช่า

//-----------------------------------ยอดยกมา-----------------------------------
               //ค่าใช้จ่าย
               $sumcost_of_sales_old_dr = 0; //ซื้อสินค้า
               $sumcost_of_sales_old_cr = 0; //ซื้อสินค้า

               $sumcost_of_salesre_old_dr = 0; //สินค้าส่งคืน
               $sumcost_of_salesre_old_cr = 0; //สินค้าส่งคืน

               $sumcost_of_salesdis_old_dr = 0; //ส่วนลดรับ
               $sumcost_of_salesdis_old_cr = 0; //ส่วนลดรับ

               $sumcost_of_saleslost_old_dr = 0; //สินค้าสูญหาย
               $sumcost_of_saleslost_old_cr = 0; //สินค้าสูญหาย

               $sumcost_of_saleslostmain_old_dr = 0; //ค่าซ่อมแซมบำรุงอุปกรณ์ให้เช่า
               $sumcost_of_saleslostmain_old_cr = 0; //ค่าซ่อมแซมบำรุงอุปกรณ์ให้เช่า

//-----------------------------------รวม----------------------------------------
               $totalcost_of_sales =0;
               $totalcost_of_salesre =0;
               $totalcost_of_salesdis =0;
               $totalcost_of_saleslost = 0;
               $totalcost_of_saleslostmain = 0;

               foreach ($data as $key => $value) { ?>

               <!-- ค่าใช้จ่าย -->
               <?php //ต้นทุนขายหรือต้นทุนการให้บริการ
               if($value->acc_code == 512100){ //ซื้อสินค้า
                       $sumcost_of_sales_dr = $value->sumdebit - $sumcost_of_sales_dr;
                       $sumcost_of_sales_cr = $value->sumcredit - $sumcost_of_sales_cr;
               }

               if($value->acc_code == 512800){ //สินค้าส่งคืน
                       $sumcost_of_salesre_dr = $value->sumdebit - $sumcost_of_salesre_dr;
                       $sumcost_of_salesre_cr = $value->sumcredit - $sumcost_of_salesre_cr;
               }

               if($value->acc_code == 412900){ //ส่วนลดรับ
                       $sumcost_of_salesdis_dr = $value->sumdebit - $sumcost_of_salesdis_dr;
                       $sumcost_of_salesdis_cr = $value->sumcredit - $sumcost_of_salesdis_cr;
               }

               if($value->acc_code == 512900){ //สินค้าสูญหาย
                       $sumcost_of_saleslost_dr = $sumcost_of_saleslost_dr + $value->sumdebit;
                       $sumcost_of_saleslost_cr = $sumcost_of_saleslost_cr + $value->sumcredit;
               }

               if($value->acc_code == 513000){ //ค่าซ่อมแซมบำรุงอุปกรณ์ให้เช่า
                       $sumcost_of_saleslostmain_dr = $sumcost_of_saleslostmain_dr + $value->sumdebit;
                       $sumcost_of_saleslostmain_cr = $sumcost_of_saleslostmain_cr + $value->sumcredit;
               }
               ?>
               <!-- ค่าใช้จ่าย -->
               <?php $i++; } ?>

               <?php
               //ยอดยกมา
               foreach ($datatold as $key2 => $value2) { ?>

               <!-- ค่าใช้จ่าย -->
               <?php //ต้นทุนขายหรือต้นทุนการให้บริการ
                 if($value2->acc_code == 512100){ //ซื้อสินค้า
                         $sumcost_of_sales_old_dr = $value2->sumdebit - $sumcost_of_sales_old_dr;
                         $sumcost_of_sales_old_cr = $value2->sumcredit - $sumcost_of_sales_old_cr;
                 }

                 if($value2->acc_code == 512800){ //สินค้าส่งคืน
                         $sumcost_of_salesre_old_dr = $value2->sumdebit - $sumcost_of_salesre_old_dr;
                         $sumcost_of_salesre_old_cr = $value2->sumcredit - $sumcost_of_salesre_old_cr;
                 }

                 if($value2->acc_code == 412900){ //ส่วนลดรับ
                         $sumcost_of_salesdis_old_dr = $value2->sumdebit - $sumcost_of_salesdis_old_dr;
                         $sumcost_of_salesdis_old_cr = $value2->sumcredit - $sumcost_of_salesdis_old_cr;
                 }

                 if($value2->acc_code == 512900){ //สินค้าสูญหาย
                         $sumcost_of_saleslost_old_dr = $sumcost_of_saleslost_old_dr + $value2->sumdebit;
                         $sumcost_of_saleslost_old_cr = $sumcost_of_saleslost_old_cr + $value2->sumcredit;
                 }

                 if($value2->acc_code == 513000){ //ค่าซ่อมแซมบำรุงอุปกรณ์ให้เช่า
                         $sumcost_of_saleslostmain_old_dr = $sumcost_of_saleslostmain_old_dr + $value2->sumdebit;
                         $sumcost_of_saleslostmain_old_cr = $sumcost_of_saleslostmain_old_cr + $value2->sumcredit;
                 }
               ?>

               <?php $i++; } ?>

               <?php
               //ต้นทุนขายหรือต้นทุนการให้บริการ
               //ซื้อสินค้า
               if(($sumcost_of_sales_dr + $sumcost_of_sales_old_dr) > ($sumcost_of_sales_cr + $sumcost_of_sales_old_cr)){
                   $totalcost_of_sales = ($sumcost_of_sales_dr + $sumcost_of_sales_old_dr) - ($sumcost_of_sales_cr + $sumcost_of_sales_old_cr);
               }elseif (($sumcost_of_sales_dr + $sumcost_of_sales_old_dr) < ($sumcost_of_sales_cr + $sumcost_of_sales_old_cr)) {
                   $totalcost_of_sales = ($sumcost_of_sales_cr + $sumcost_of_sales_old_cr) - ($sumcost_of_sales_dr + $sumcost_of_sales_old_dr);
               }

               //สินค้าส่งคืน
               if(($sumcost_of_salesre_dr + $sumcost_of_salesre_old_dr) > ($sumcost_of_salesre_cr + $sumcost_of_salesre_old_cr)){
                   $totalcost_of_salesre = ($sumcost_of_salesre_dr + $sumcost_of_salesre_old_dr) - ($sumcost_of_salesre_cr + $sumcost_of_salesre_old_cr);
               }elseif (($sumcost_of_salesre_dr + $sumcost_of_salesre_old_dr) < ($sumcost_of_salesre_cr + $sumcost_of_salesre_old_cr)) {
                   $totalcost_of_salesre = ($sumcost_of_salesre_cr + $sumcost_of_salesre_old_cr) - ($sumcost_of_salesre_dr + $sumcost_of_salesre_old_dr);
               }

               //ส่วนลดรับ
               if(($sumcost_of_salesdis_dr + $sumcost_of_salesdis_old_dr) > ($sumcost_of_salesdis_cr + $sumcost_of_salesdis_old_cr)){
                   $totalcost_of_salesdis = ($sumcost_of_salesdis_dr + $sumcost_of_salesdis_old_dr) - ($sumcost_of_salesdis_cr + $sumcost_of_salesdis_old_cr);
               }elseif (($sumcost_of_salesdis_dr + $sumcost_of_salesdis_old_dr) < ($sumcost_of_salesdis_cr + $sumcost_of_salesdis_old_cr)) {
                   $totalcost_of_salesdis = ($sumcost_of_salesdis_cr + $sumcost_of_salesdis_old_cr) - ($sumcost_of_salesdis_dr + $sumcost_of_salesdis_old_dr);
               }

               //สินค้าสูญหาย
               if(($sumcost_of_saleslost_dr + $sumcost_of_saleslost_old_dr) > ($sumcost_of_saleslost_cr + $sumcost_of_saleslost_old_cr)){
                   $totalcost_of_saleslost = ($sumcost_of_saleslost_dr + $sumcost_of_saleslost_old_dr) - ($sumcost_of_saleslost_cr + $sumcost_of_saleslost_old_cr);
               }elseif (($sumcost_of_saleslost_dr + $sumcost_of_saleslost_old_dr) < ($sumcost_of_saleslost_cr + $sumcost_of_saleslost_old_cr)) {
                   $totalcost_of_saleslost = ($sumcost_of_saleslost_cr + $sumcost_of_saleslost_old_cr) - ($sumcost_of_saleslost_dr + $sumcost_of_saleslost_old_dr);
               }

               //ค่าซ่อมแซมบำรุงอุปกรณ์ให้เช่า
               if(($sumcost_of_saleslostmain_dr + $sumcost_of_saleslostmain_old_dr) > ($sumcost_of_saleslostmain_cr + $sumcost_of_saleslostmain_old_cr)){
                   $totalcost_of_saleslostmain = ($sumcost_of_saleslostmain_dr + $sumcost_of_saleslostmain_old_dr) - ($sumcost_of_saleslostmain_cr + $sumcost_of_saleslostmain_old_cr);
               }elseif (($sumcost_of_saleslostmain_dr + $sumcost_of_saleslostmain_old_dr) < ($sumcost_of_saleslostmain_cr + $sumcost_of_saleslostmain_old_cr)) {
                   $totalcost_of_saleslostmain = ($sumcost_of_saleslostmain_cr + $sumcost_of_saleslostmain_old_cr) - ($sumcost_of_saleslostmain_dr + $sumcost_of_saleslostmain_old_dr);
               }
               ?>

               </form>

               <tr><td colspan="3"><b><?php echo "ค่าใช้จ่าย"?></b></td></tr>
               <tr>
                 <td><b><?php echo "ต้นทุนขายหรือต้นทุนการให้บริการ"?></b>
                  <?php echo "<br>";
                              echo "&nbsp;&nbsp;ซื้อสินค้า";
                        echo "<br>";
                              echo "&nbsp;&nbsp;หัก สินค้าส่งคืน";
                        echo "<br>";
                              echo "&nbsp;&nbsp;หัก ส่วนลดรับ";
                        echo "<br>";
                              echo "&nbsp;&nbsp;สินค้าสูญหาย";
                        echo "<br>";
                              echo "&nbsp;&nbsp;ค่าซ่อมแซมบำรุงอุปกรณ์ให้เช่า";

                  ?>
                 </td>
                 <td></td>
                 <td align="right">
                 <?php echo "<br>";
                             echo number_format ($totalcost_of_sales,2);
                       echo "<br>";
                             echo number_format ($totalcost_of_salesre,2);
                       echo "<br>";
                             echo number_format ($totalcost_of_salesdis,2);
                       echo "<br>";
                             echo number_format ($totalcost_of_saleslost,2);
                       echo "<br>";
                             echo number_format ($totalcost_of_saleslostmain,2);
                       echo "<br>";
                             echo ("");
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
