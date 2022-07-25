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
													<li class="breadcrumb-item">ประเภทบัญชี</li>
													<li class="breadcrumb-item active">แยกประเภทบัญชี (ทั้งหมด)</li>
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
        <form action="serachledger_allbranch" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
         <div class="row">
              <div class="col-md-2">

              </div>

              <div class="col-md-3">
                  <p class="text-right">
                    เลขบัญชี
                  </p>
              </div>
              <div class="col-md-2">
                <?php
                  $db = Connectdb::Databaseall();
                  $sql = 'SELECT '.$db['admin_accdemo'].'.accounttype.*
                          FROM '.$db['admin_accdemo'].'.accounttype
                          WHERE '.$db['admin_accdemo'].'.accounttype.status = "1"';

                  $acc_code = DB::connection('mysql')->select($sql);
                ?>
                  <select name="acc_code" id="acc_code" class="form-control" required>
                    <option value="">เลือกเลขบัญชี</option>
                    <?php foreach ($acc_code as $key => $value) { ?>
                        <option value="<?php echo $value->accounttypeno?>" <?php if(isset($query)){ if($acc_code==$value->accounttypeno){ echo "selected";} }?>><?php echo $value->accounttypefull?></option>
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
                    <a href="printledger_allbranch?reservation=<?php echo $datepicker;?>&&acc_code=<?php echo $accontcode;?>" target="_blank" ><img src="images/global/printall.png"></a>
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
              // exit;
            ?>

            <!-- <form action="configreportcashdailynow" onSubmit="if(!confirm('ยืนยันการทำรายการ?')){return false;}" method="post" class="form-horizontal"> -->
            <!-- <input type="hidden" name="_token" value="{{ csrf_token() }}"> -->
            <form action="saveapprovedpo" method="post" enctype="multipart/form-data" onSubmit="JavaScript:return fncSubmit();">
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <!-- <table class="table table-striped"> -->
            <table id="example" class="table table-striped table-bordered fontslabel" style="width:100%">
               <thead>
                 <tr>
                   <!-- <th><center>No.</center></th> -->
                   <th><center>Type</center></th>
                   <th><center>Date</center></th>
                   <th><center>Num</center></th>
                   <th><center>Adj.</center></th>
                   <th><center>Memo</center></th>
                   <th><center>Split</center></th>
                   <th><center>Debit</center></th>
                   <th><center>Credit</center></th>
                   <th><center>Balance</center></th>
                 </tr>
               </thead>
               <tbody>

               <?php
               $sumgrandtotal_debit = 0;
               $sumgrandtotal_credit = 0;
               $sumdebit_brought = 0;
               $sumcredit_brought = 0;

               $i = 1;
               $sumgrandtotal = 0;
               $sumdebit = 0;
               $sumcredit = 0;

               $dateold = explode("-",trim(($datepicker)));
               // echo "<pre>";
               // print_r($dateold);
               // exit;
                 // $start_date = $datepicker[0];
                 $dateolds = explode("/",trim(($dateold[0])));
                         if(count($dateolds) > 0) {
                             $olds =$dateolds[2]; //ปี
                             $old = "01/01/" .$olds;

                         }
                         // "<pre>";
                         // print_r($old);
                         // exit;
               ?>

               <tr>
                 <td></td>
                 <td><?php echo $old;?></td>
                 <td></td>
                 <td></td>
                 <td><b>ยอดยกมา</b></td>
                 <td></td>
                 <td align="right"><b> <!--Debit-->
                   <?php
                     $modelbroughtforward = Maincenter::getdatabroughtforward($accontcode,$datepicker);
                           if($modelbroughtforward){
                             echo number_format($modelbroughtforward[0]->sumdebit,2);
                             $sumdebit_brought = $modelbroughtforward[0]->sumdebit;
                           }else {
                             echo "0.00";
                           }
                   ?>
                 </b></td>
                 <td align="right"><b> <!--Credit-->
                   <?php
                         if($modelbroughtforward){
                           echo number_format($modelbroughtforward[0]->sumcredit,2);
                           $sumcredit_brought = $modelbroughtforward[0]->sumcredit;
                         }else {
                           echo "0.00";
                         }
                   ?>
                 </b></td>
                 <td align="right"> <!--Balance-->
                   <?php
                   // if($modelbroughtforward){
                   //   if($modelbroughtforward[0]->sumdebit != 0){
                   //     echo number_format ($modelbroughtforward[0]->sumdebit,2);
                   //     $sumgrandtotal_debit = $sumgrandtotal_debit + $modelbroughtforward[0]->sumdebit;
                   //
                   //   }elseif ($modelbroughtforward[0]->sumdebit == 0) {
                   //     echo number_format ($modelbroughtforward[0]->sumcredit,2);
                   //     $sumgrandtotal_credit = $sumgrandtotal_credit + $modelbroughtforward[0]->sumcredit;
                   //   }
                   // }else {
                   //   // echo "0.00";
                   // }
                   ?>
                 </td>
               </tr>

               <?php
               foreach ($data as $key => $value) { ?>
               <tr>

                <td><center><!--Type-->
                  <?php
                  if($value->type_journal == 1) {
                      echo "ซื้อ";
                  }elseif ($value->type_journal == 2) {
                      echo "ขาย";
                  }elseif ($value->type_journal == 3) {
                      echo "จ่าย";
                  }elseif ($value->type_journal == 4) {
                      echo "รับ";
                  }elseif ($value->type_journal == 5) {
                      echo "ทั่วไป";
                  }else {
                      echo "-";
                  }
                  ?>
                </td></center>
                <td><!--วันที่-->
                  <?php
                    $timestamp = explode(" ",trim($value->timestamp));
                    $time = explode("-",trim($timestamp[0])); //วัน-เดือน-ปี
                    $timeall = $time[2] . '-' . $time[1] . '-' . $time[0]; //วัน - เดือน - ปี
                    echo $timeall;
                  ?>
                </td>
                <td><?php echo ($value->number_bill);?></td><!--เลขที่เอกสาร-->
                <td><center><!--Adj.-->
                  <?php
                        if($value->type_journal == 5){
                  ?>    <i class="fa fa-check" style="color:green;font-size:20px;"></i>
                  <?php }else {
                          echo "-";
                        };
                  ?>
                </td></center>
                <td><?php echo ($value->list);?></td><!--คำอธิบาย-->
                <td><?php echo ($value->acc_code);?></td><!--Split-->

                <td align="right"><!--Debit-->
                  <?php
                  echo number_format($value->dr,2);
                  $sumdebit = $sumdebit + $value->dr;
                  ?>
                </td>

                <td align="right"><!--Credit-->
                  <?php
                  echo number_format($value->cr,2);
                  $sumcredit = $sumcredit + $value->cr;
                  ?>
                </td>

                <td align="right"><!--Balance-->
                  <?php

                    // if($modelbroughtforward){
                    //   if($sumgrandtotal_debit != 0){ //กรณีมี Debit
                    //     if($value->dr != 0){
                    //       echo "test1";
                    //       echo number_format ((($value->dr + $value->cr) + $sumgrandtotal) + $sumgrandtotal_debit,2);
                    //       $sumgrandtotal = (($value->dr + $value->cr) + $sumgrandtotal)+ $sumgrandtotal_debit;
                    //
                    //     }elseif ($value->dr == 0) {
                    //       echo "test2";
                    //       echo number_format (($sumgrandtotal -($value->dr + $value->cr)) - $sumgrandtotal_credit,2);
                    //       $sumgrandtotal = ($sumgrandtotal -($value->dr + $value->cr))- $sumgrandtotal_credit;
                    //     }
                    //
                    //   }elseif ($sumgrandtotal_credit != 0) { //กรณีมี Credit
                    //     if($value->dr != 0){
                    //       echo "test3";
                    //       echo number_format ((($value->dr + $value->cr) + $sumgrandtotal) - $sumgrandtotal_credit,2);
                    //       $sumgrandtotal = (($value->dr + $value->cr) + $sumgrandtotal) - $sumgrandtotal_credit;
                    //
                    //     }elseif ($value->dr == 0) {
                    //       echo "test4";
                    //       echo number_format (($sumgrandtotal -($value->dr + $value->cr)) - $sumgrandtotal_credit,2);
                    //       $sumgrandtotal = ($sumgrandtotal -($value->dr + $value->cr)) - $sumgrandtotal_credit;
                    //     }
                    //   }
                    // }else {
                      if($value->dr != 0){
                        echo number_format ((($value->dr + $value->cr) + $sumgrandtotal),2);
                        $sumgrandtotal = (($value->dr + $value->cr) + $sumgrandtotal);

                      }elseif ($value->dr == 0) {
                        echo number_format (($sumgrandtotal -($value->dr + $value->cr)),2);
                        $sumgrandtotal = ($sumgrandtotal -($value->dr + $value->cr));
                      }
                    // }
                  ?>
                </td>
             </tr>

             <?php $i++; } ?>

                   <tr>
                     <td colspan="5" align="right"></td>
                     <td><b>รวม</b></td>
                     <td align="right"><b><?php echo number_format($sumdebit + $sumdebit_brought,2); ?></b></td>
                     <td align="right"><b><?php echo number_format($sumcredit + $sumcredit_brought,2); ?></b></td>
                     <td align="right"><b>
                       <?php
                       if(($sumdebit + $sumdebit_brought) > ($sumcredit + $sumcredit_brought)){
                         echo number_format(($sumdebit + $sumdebit_brought) - ($sumcredit + $sumcredit_brought),2);
                       }elseif(($sumdebit + $sumdebit_brought) < ($sumcredit + $sumcredit_brought)) {
                         echo number_format(($sumcredit + $sumcredit_brought) - ($sumdebit + $sumdebit_brought),2);
                       }
                       // echo number_format($sumgrandtotal,2);
                       ?>
                     </b></td>
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
