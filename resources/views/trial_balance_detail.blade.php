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

<script type="text/javascript" src = 'js/accountjs/report.js'></script>

<div class="content-page">
	<!-- Start content -->
  <div class="content">
       <div class="container-fluid">

					   <div class="row">
									<div class="col-xl-12">
											<div class="breadcrumb-holder" id="fontscontent">
													<h1 class="float-left">Account - FSCT</h1>
													<ol class="breadcrumb float-right">
													<li class="breadcrumb-item">หน้าแสดงรายละเอียด</li>
													<li class="breadcrumb-item active">หน้าแสดงรายละเอียดงบทดลอง (รายสาขา)</li>
													</ol>
													<div class="clearfix"></div>
											</div>
									</div>
						</div>
			<!-- end row -->

      <div class="row">
          <br>
      </div>

      <?php

      $db = Connectdb::Databaseall();
      // echo "<pre>";
      // print_r($data);
      // print_r($data['idacc']);
      // print_r($data['datepicker']);
      // exit;

      $datepicker2 = explode("-",trim($data['datepicker']));
      $acc_code = $data['idacc'];

      $e1 = explode("/",trim(($datepicker2[0])));
              if(count($e1) > 0) {
                  $start_date = $e1[2] . '-' . $e1[0] . '-' . $e1[1]." 00:00:00"; //ปี - เดือน - วัน
                  $start_year = $e1[2]-1; //ปีเก่า (ยอดยกมา)
              }

      // $end_date = $datepicker[1];
      $e2 = explode("/",trim(($datepicker2[1])));
              if(count($e2) > 0) {
                  $end_date = $e2[2] . '-' . $e2[0] . '-' . $e2[1]." 23:59:59"; //ปี - เดือน - วัน
              }

      $sql = 'SELECT '.$db['fsctaccount'].'.ledger.*,
                       SUM('.$db['fsctaccount'].'.ledger.dr) as sumdebit,
                       SUM('.$db['fsctaccount'].'.ledger.cr) as sumcredit

                    FROM '.$db['fsctaccount'].'.ledger

                    WHERE '.$db['fsctaccount'].'.ledger.acc_code = "'.$acc_code.'"
                      AND '.$db['fsctaccount'].'.ledger.timestamp  BETWEEN "'.$start_date.'" AND  "'.$end_date.'"
                      AND '.$db['fsctaccount'].'.ledger.balance_forward_status = 0
                      AND '.$db['fsctaccount'].'.ledger.status != 99
                    GROUP BY '.$db['fsctaccount'].'.ledger.branch
                    ';

      $dataquery = DB::select($sql);

      $sql_forward = 'SELECT '.$db['fsctaccount'].'.ledger.*,
                       SUM('.$db['fsctaccount'].'.ledger.dr) as sumdebit,
                       SUM('.$db['fsctaccount'].'.ledger.cr) as sumcredit

                    FROM '.$db['fsctaccount'].'.ledger

                    WHERE '.$db['fsctaccount'].'.ledger.acc_code = "'.$acc_code.'"
                      AND '.$db['fsctaccount'].'.ledger.timestamp LIKE "'.$start_year.'%"
                      AND '.$db['fsctaccount'].'.ledger.balance_forward_status = 1
                      AND '.$db['fsctaccount'].'.ledger.type_journal = 5
                      AND '.$db['fsctaccount'].'.ledger.status != 99
                    GROUP BY '.$db['fsctaccount'].'.ledger.acc_code
                    ';

      $dataquery_forward = DB::select($sql_forward);
      // echo "<pre>";
      // print_r($dataquery);
      // print_r($dataquery_forward);
      // exit;
      ?>


        <div class="col-md-6">
          <?php   //if(isset($query)){ //echo $branch_id; ?>

            <?php  //if(isset($group_branch_acc_select) && $group_branch_acc_select != ''){?>
                    <!-- <a href="printcovertaxabb?group_branch_acc_select=<?php //echo $group_branch_acc_select ;?>&&datepickerstart=<?php //echo $datepicker2['start_date'];?>&&datepickerend=<?php  //echo $datepicker2['end_date'];?>"><img src="images/global/printall.png"></a> -->
            <?php //}else { ?>
            <?php //$path = '&branch_id='.$branch_id?>
                    <!-- <a href="<?php //echo url("/excelreportaccruedall?$path");?>" target="_blank"><img src="images/global/printall.png"></a> -->
                    <!-- <a href="printtrial_balance?branch_id=<?php //echo $branch_id;?>&&reservation=<?php //echo $datepicker;?>" target="_blank" ><img src="images/global/printall.png"></a> -->
            <?php //} ?>

          <?php //} ?>
        </div>

        <div class="row">
            <br>
        </div>

        <div class="row">
        <div class="col-md-12">
          <?php
          if(isset($dataquery)){
              // echo "<pre>";
              // print_r($data);
              // print_r($datepicker);
              // print_r($branch_id);
              // exit;
            ?>

            <!-- <form action="configreportcashdailynow" onSubmit="if(!confirm('ยืนยันการทำรายการ?')){return false;}" method="post" class="form-horizontal"> -->
            <!-- <input type="hidden" name="_token" value="{{ csrf_token() }}"> -->
            <form action="saveapprovedpo" method="post" enctype="multipart/form-data" onSubmit="JavaScript:return fncSubmit();">
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <!-- <table class="table table-striped"> -->
            <table id="example" class="table table-striped table-bordered fontslabel" style="width:100%">
            <!-- <table id="example" class="table" width="100%"> -->
               <thead>
                 <tr>
                   <th><center>ลำดับ</center></th>
                   <th><center>สาขา</center></th>
                   <th><center>ยอด</center></th>
                 </tr>
               </thead>
               <tbody>

               <?php

               $i = 1;
               $sumgrandtotal = 0;
               $sumdebit = 0;
               $sumcredit = 0;

               foreach ($dataquery as $key => $value) { ?>

               <tr>
                  <td><?php echo $i;?></td><!--Name-->
                  <?php $modelbranch = Maincenter::databranchbycode($value->branch);?>
                  <td><?php if($modelbranch){ echo $modelbranch[0]->name_branch;}?></td><!--Branch-->

                  <?php
                  $valuereturn = $value->acc_code." ".$value->branch;
                  // echo $valuereturn; exit;
                  // $modelaccount_name = Maincenter::getdataaccount_name($valuereturn,$datepicker);
                  $modelbroughtforward = Maincenter::getdatabroughtforward_branch($valuereturn,$data['datepicker']);
                  // if($modelbroughtforward){
                  //       // echo "debit";
                  //       echo $modelbroughtforward[0]->sumdebit;
                  // }
                  ?>

                  <td align="right"><!--Debit-->
                    <?php
                    // if($modelbroughtforward){
                    //   if(($value->sumdebit + $modelbroughtforward[0]->sumdebit) > ($value->sumcredit + $modelbroughtforward[0]->sumcredit)){
                    //         echo number_format (($value->sumdebit + $modelbroughtforward[0]->sumdebit) - ($value->sumcredit + $modelbroughtforward[0]->sumcredit),2);
                    //         $sumdebit = $sumdebit + (($value->sumdebit + $modelbroughtforward[0]->sumdebit) - ($value->sumcredit + $modelbroughtforward[0]->sumcredit));
                    //   }else if(($value->sumdebit + $modelbroughtforward[0]->sumdebit) < ($value->sumcredit + $modelbroughtforward[0]->sumcredit)){
                    //         echo number_format (($value->sumcredit + $modelbroughtforward[0]->sumcredit) - ($value->sumdebit + $modelbroughtforward[0]->sumdebit),2);
                    //         $sumcredit = $sumcredit + (($value->sumcredit + $modelbroughtforward[0]->sumcredit) - ($value->sumdebit + $modelbroughtforward[0]->sumdebit));
                    //   }
                    //
                    // }else
                    if($value->sumdebit > $value->sumcredit){
                            echo number_format ($value->sumdebit - $value->sumcredit,2);
                            $sumdebit = $sumdebit + ($value->sumdebit - $value->sumcredit);
                    }else if($value->sumdebit < $value->sumcredit){
                            echo number_format ($value->sumcredit - $value->sumdebit,2);
                            $sumcredit = $sumcredit + ($value->sumcredit - $value->sumdebit);
                    }

                    // if(($value->sumdebit + $modelbroughtforward[0]->sumdebit) > ($value->sumcredit + $modelbroughtforward[0]->sumcredit)){
                    //     echo number_format (($value->sumdebit + $modelbroughtforward[0]->sumdebit) - ($value->sumcredit + $modelbroughtforward[0]->sumcredit),2);
                    //     $sumdebit = $sumdebit + (($value->sumdebit + $modelbroughtforward[0]->sumdebit) - ($value->sumcredit + $modelbroughtforward[0]->sumcredit));
                    // }

                    // else
                    // if($value->sumdebit > $value->sumcredit){
                    //     echo number_format ($value->sumdebit - $value->sumcredit,2);
                    //     $sumdebit = $sumdebit + ($value->sumdebit - $value->sumcredit);
                    // }else if($value->sumdebit < $value->sumcredit){
                    //     echo number_format ($value->sumcredit - $value->sumdebit,2);
                    //     $sumdebit = $sumdebit + ($value->sumcredit - $value->sumdebit);
                    // }

                    ?>
                  </td>
               </tr>

             <?php $i++; } ?>

                <tr>
                  <td></td>
                  <td><b>รวม</b></td>
                  <td align="right"><b><?php echo number_format($sumdebit + $sumcredit,2); ?></b></td>
                </tr>

              </tbody>
              </table>

             <?php  }  ?>

            </div>
         </div>

         <div class="row">
         <div class="col-md-12">

         <div class="row">
             <br><br>
         </div>


             <b>ยอดยกมา : <b><br><br>
        


           <?php
           if(isset($dataquery_forward)){
               // echo "<pre>";
               // print_r($data);
               // print_r($datepicker);
               // print_r($branch_id);
               // exit;
             ?>

             <!-- <form action="configreportcashdailynow" onSubmit="if(!confirm('ยืนยันการทำรายการ?')){return false;}" method="post" class="form-horizontal"> -->
             <!-- <input type="hidden" name="_token" value="{{ csrf_token() }}"> -->
             <form action="saveapprovedpo" method="post" enctype="multipart/form-data" onSubmit="JavaScript:return fncSubmit();">
               <input type="hidden" name="_token" value="{{ csrf_token() }}">
             <!-- <table class="table table-striped"> -->
             <table id="example" class="table table-striped table-bordered fontslabel" style="width:100%">
             <!-- <table id="example" class="table" width="100%"> -->
                <thead>
                  <tr>
                    <th><center>ลำดับ</center></th>
                    <th><center>สาขา</center></th>
                    <th><center>ยอด</center></th>
                  </tr>
                </thead>
                <tbody>

                <?php

                $i = 1;
                $sumgrandtotal = 0;
                $sumdebit = 0;
                $sumcredit = 0;

              foreach ($dataquery_forward as $key => $value2) { ?>

              <tr>
                 <td><?php echo $i;?></td><!--Name-->
                 <?php $modelbranch = Maincenter::databranchbycode($value2->branch);?>
                 <td><?php if($modelbranch){ echo $modelbranch[0]->name_branch;}?></td><!--Branch-->

                 <?php
                 // $value2return = $value2->acc_code." ".$value2->branch;
                 // // $modelaccount_name = Maincenter::getdataaccount_name($value2return,$datepicker);
                 // $modelbroughtforward = Maincenter::getdatabroughtforward_branch($value2return,$data['datepicker']);
                 // if($modelbroughtforward){
                 //       // echo "debit";
                 //       echo $modelbroughtforward[0]->sumdebit;
                 // }
                 ?>

                 <td align="right"><!--Debit-->
                   <?php
                   // if($modelbroughtforward){
                   //   if(($value2->sumdebit + $modelbroughtforward[0]->sumdebit) > ($value2->sumcredit + $modelbroughtforward[0]->sumcredit)){
                   //         echo number_format (($value2->sumdebit + $modelbroughtforward[0]->sumdebit) - ($value2->sumcredit + $modelbroughtforward[0]->sumcredit),2);
                   //         $sumdebit = $sumdebit + (($value2->sumdebit + $modelbroughtforward[0]->sumdebit) - ($value2->sumcredit + $modelbroughtforward[0]->sumcredit));
                   //   }else if(($value2->sumdebit + $modelbroughtforward[0]->sumdebit) < ($value2->sumcredit + $modelbroughtforward[0]->sumcredit)){
                   //         echo number_format (($value2->sumcredit + $modelbroughtforward[0]->sumcredit) - ($value2->sumdebit + $modelbroughtforward[0]->sumdebit),2);
                   //         $sumcredit = $sumcredit + (($value2->sumcredit + $modelbroughtforward[0]->sumcredit) - ($value2->sumdebit + $modelbroughtforward[0]->sumdebit));
                   //   }
                   //
                   // }else
                   if($value2->sumdebit > $value2->sumcredit){
                           echo number_format ($value2->sumdebit - $value2->sumcredit,2);
                           $sumdebit = $sumdebit + ($value2->sumdebit - $value2->sumcredit);
                   }else if($value2->sumdebit < $value2->sumcredit){
                           echo number_format ($value2->sumcredit - $value2->sumdebit,2);
                           $sumcredit = $sumcredit + ($value2->sumcredit - $value2->sumdebit);
                   }

                   // if(($value2->sumdebit + $modelbroughtforward[0]->sumdebit) > ($value2->sumcredit + $modelbroughtforward[0]->sumcredit)){
                   //     echo number_format (($value2->sumdebit + $modelbroughtforward[0]->sumdebit) - ($value2->sumcredit + $modelbroughtforward[0]->sumcredit),2);
                   //     $sumdebit = $sumdebit + (($value2->sumdebit + $modelbroughtforward[0]->sumdebit) - ($value2->sumcredit + $modelbroughtforward[0]->sumcredit));
                   // }

                   // else
                   // if($value2->sumdebit > $value2->sumcredit){
                   //     echo number_format ($value2->sumdebit - $value2->sumcredit,2);
                   //     $sumdebit = $sumdebit + ($value2->sumdebit - $value2->sumcredit);
                   // }else if($value2->sumdebit < $value2->sumcredit){
                   //     echo number_format ($value2->sumcredit - $value2->sumdebit,2);
                   //     $sumdebit = $sumdebit + ($value2->sumcredit - $value2->sumdebit);
                   // }

                   ?>
                 </td>
              </tr>

            <?php $i++; } ?>


                 <tr>
                   <td></td>
                   <td><b>รวม</b></td>
                   <td align="right"><b><?php echo number_format($sumdebit + $sumcredit,2); ?></b></td>
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
