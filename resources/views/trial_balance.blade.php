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
													<li class="breadcrumb-item">งบทดลอง</li>
													<li class="breadcrumb-item active">งบทดลอง (รายสาขา)</li>
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
        <form action="serachtrial_balance" method="post">
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
                          WHERE '.$db['hr_base'].'.branch.status_main = "1"';

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
                    <a href="printtrial_balance?branch_id=<?php echo $branch_id;?>&&reservation=<?php echo $datepicker;?>" target="_blank" ><img src="images/global/printall.png"></a>
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
            ?>

            <!-- <form action="configreportcashdailynow" onSubmit="if(!confirm('ยืนยันการทำรายการ?')){return false;}" method="post" class="form-horizontal"> -->
            <!-- <input type="hidden" name="_token" value="{{ csrf_token() }}"> -->
            <form action="saveapprovedpo" method="post" enctype="multipart/form-data" onSubmit="JavaScript:return fncSubmit();">
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <!-- <table class="table table-striped"> -->
            <table id="example" class="table table-striped table-bordered fontslabel" style="width:100%">
               <thead>
                 <tr>
                   <th><center>Name</center></th>
                   <th><center>Account code</center></th>
                   <th><center>Debit</center></th>
                   <th><center>Credit</center></th>
                 </tr>
               </thead>
               <tbody>

               <?php

               $i = 1;
               $sumgrandtotal = 0;
               $sumdebit = 0;
               $sumcredit = 0;

               foreach ($data as $key => $value) { ?>

               <?php
                   $valuereturn = $value->accounttypeno." ".$branch_id;
                   $modelaccount_name = Maincenter::getdataaccount_name($valuereturn,$datepicker);
                   $modelbroughtforward = Maincenter::getdatabroughtforward_branch($valuereturn,$datepicker);

               if($modelaccount_name || $modelbroughtforward){
               ?>
               <tr>
                  <td><?php echo ($value->accounttypefull);?></td><!--Name-->
                  <td><?php echo ($value->accounttypeno);?></td><!--Account code-->

                  <?php
                  // $valuereturn = $value->accounttypeno." ".$branch_id;
                  // $modelaccount_name = Maincenter::getdataaccount_name($valuereturn,$datepicker);
                  // $modelbroughtforward = Maincenter::getdatabroughtforward_branch($valuereturn,$datepicker);

                  // if($modelaccount_name){
                  //       echo "debit";
                  //       // echo $modelaccount_name[0]->accounttypeno;
                  // }
                  ?>

                  <td align="right"><!--Debit-->
                    <?php
                    if($modelbroughtforward){
                      if($modelaccount_name){
                        if(($modelaccount_name[0]->sumdebit + $modelbroughtforward[0]->sumdebit) > ($modelaccount_name[0]->sumcredit + $modelbroughtforward[0]->sumcredit)){
                              echo number_format (($modelaccount_name[0]->sumdebit + $modelbroughtforward[0]->sumdebit) - ($modelaccount_name[0]->sumcredit + $modelbroughtforward[0]->sumcredit),2);
                              $sumdebit = $sumdebit + (($modelaccount_name[0]->sumdebit + $modelbroughtforward[0]->sumdebit) - ($modelaccount_name[0]->sumcredit + $modelbroughtforward[0]->sumcredit));
                        }
                      }else {
                        if(($modelbroughtforward[0]->sumdebit) > ($modelbroughtforward[0]->sumcredit)){
                              echo number_format (($modelbroughtforward[0]->sumdebit) - ($modelbroughtforward[0]->sumcredit),2);
                              $sumdebit = $sumdebit + (($modelbroughtforward[0]->sumdebit) - ($modelbroughtforward[0]->sumcredit));
                        }
                      }
                    }
                    else if($modelaccount_name){
                        if($modelaccount_name[0]->sumdebit > $modelaccount_name[0]->sumcredit){
                              echo number_format ($modelaccount_name[0]->sumdebit - $modelaccount_name[0]->sumcredit,2);
                              $sumdebit = $sumdebit + ($modelaccount_name[0]->sumdebit - $modelaccount_name[0]->sumcredit);
                        }
                    }
                    ?>
                  </td>

                  <td align="right"><!--Credit-->
                    <?php
                    if($modelbroughtforward){
                      if($modelaccount_name){
                        if(($modelaccount_name[0]->sumdebit + $modelbroughtforward[0]->sumdebit) < ($modelaccount_name[0]->sumcredit + $modelbroughtforward[0]->sumcredit)){
                              echo number_format (($modelaccount_name[0]->sumcredit + $modelbroughtforward[0]->sumcredit) - ($modelaccount_name[0]->sumdebit + $modelbroughtforward[0]->sumdebit),2);
                              $sumcredit = $sumcredit + (($modelaccount_name[0]->sumcredit + $modelbroughtforward[0]->sumcredit) - ($modelaccount_name[0]->sumdebit + $modelbroughtforward[0]->sumdebit));
                        }
                      }else {
                        if(($modelbroughtforward[0]->sumdebit) < ($modelbroughtforward[0]->sumcredit)){
                              echo number_format (($modelbroughtforward[0]->sumcredit) - ($modelbroughtforward[0]->sumdebit),2);
                              $sumcredit = $sumcredit + (($modelbroughtforward[0]->sumcredit) - ($modelbroughtforward[0]->sumdebit));
                        }
                      }
                    }else if($modelaccount_name){
                      if($modelaccount_name[0]->sumdebit < $modelaccount_name[0]->sumcredit){
                            echo number_format ($modelaccount_name[0]->sumcredit - $modelaccount_name[0]->sumdebit,2);
                            $sumcredit = $sumcredit + ($modelaccount_name[0]->sumcredit - $modelaccount_name[0]->sumdebit);
                      }
                    }
                    ?>
                  </td>
               </tr>
               </form>

             <?php $i++; } }?>

                <tr>
                  <td></td>
                  <td><b>รวม</b></td>
                  <td align="right"><b><?php echo number_format($sumdebit,2); ?></b></td>
                  <td align="right"><b><?php echo number_format($sumcredit,2); ?></b></td>
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
