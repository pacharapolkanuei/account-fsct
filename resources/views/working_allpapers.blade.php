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
													<li class="breadcrumb-item">กระดาษทำการ 10 ช่อง</li>
													<li class="breadcrumb-item active">กระดาษทำการ 10 ช่อง (ทั้งหมด)</li>
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
        <form action="serachworking_allpapers" method="post">
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
                    <a href="printworking_allpapers?reservation=<?php echo $datepicker;?>" target="_blank" ><img src="images/global/printall.png"></a>
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
                   <th rowspan="2"><center>ชื่อบัญชี</center></td>
                   <th rowspan="2"><center>เลขที่บัญชี</center></td>
                   <th colspan="2"><center>งบทดลองก่อนปรับปรุง</center></th>
                   <th colspan="2"><center>รายการปรับปรุง</center></th>
                   <th colspan="2"><center>งบทดลองหลังปรับปรุง</center></th>
                   <th colspan="2"><center>งบกำไรขาดทุน</center></th>
                   <th colspan="2"><center>งบแสดงฐานะการเงิน</center></th>

                 </tr>

                 <tr>
                     <th><center>เดบิต</center></th>
                     <th><center>เครดิต</center></th>
                     <th><center>เดบิต</center></th>
                     <th><center>เครดิต</center></th>
                     <th><center>เดบิต</center></th>
                     <th><center>เครดิต</center></th>
                     <th><center>เดบิต</center></th>
                     <th><center>เครดิต</center></th>
                     <th><center>เดบิต</center></th>
                     <th><center>เครดิต</center></th>
                 </tr>
               </thead>
               <tbody>

               <?php

               $i = 1;

               //รายการปรับปรุง
               $sumdebit = 0;
               $sumcredit = 0;

               //งบทดลองก่อนปรับปรุง
               $sumdebitbefore = 0;
               $sumcreditbefore = 0;

               //งบทดลองหลังปรับปรุง
               $sumdebitafter = 0;
               $sumcreditafter = 0;

               //งบกำไรขาดทุน
               $sumdebitincome = 0;
               $sumcreditincome = 0;

               //งบแสดงฐานะการเงิน
               $sumdebitfinancial = 0;
               $sumcreditfinancial = 0;

               foreach ($data as $key => $value) { ?>

               <?php
                   // $valuereturn = $value->accounttypeno." ".$branch_id;
                   //งบทดลองก่อนปรับปรุง , ยอดยกมา งบทดลองก่อนปรับปรุง
                   $modeltatrial_budget_before = Maincenter::getdatatrial_budget_allbefore($value->accounttypeno,$datepicker);
                   $modeltatrial_budget_before_forward = Maincenter::getdatatrial_budget_allbefore_forward($value->accounttypeno,$datepicker);

                   //รายการปรับปรุง , ยอดยกมา รายการปรับปรุง
                   $modeltatrial_budget_after = Maincenter::getdatatrial_budget_allafter($value->accounttypeno,$datepicker);
                   $modeltatrial_budget_after_forward = Maincenter::getdatatrial_budget_allafter_forward($value->accounttypeno,$datepicker);

                   //งบทดลองหลังปรับปรุง , ยอดยกมา งบทดลองหลังปรับปรุง
                   $modelaccount_name = Maincenter::getdataaccount_name_all_after($value->accounttypeno,$datepicker);
                   $modelbroughtforward = Maincenter::getdatabroughtforward($value->accounttypeno,$datepicker);

                   //งบกำไรขาดทุน , ยอดยกมา งบกำไรขาดทุน
                   $modelaincome = Maincenter::getdataincome_all($value->accounttypeno,$datepicker);
                   $modelaincome_forward = Maincenter::getdataincome_all_forward($value->accounttypeno,$datepicker);

                   //งบแสดงฐานะการเงิน , ยอดยกมา งบแสดงฐานะการเงิน
                   $modelafinancial = Maincenter::getdatafinancial_all($value->accounttypeno,$datepicker);
                   $modelafinancial_forward = Maincenter::getdatafinancial_all_forward($value->accounttypeno,$datepicker);

               if($modeltatrial_budget_before || $modeltatrial_budget_after || $modelaccount_name || $modelaincome || $modelafinancial){
               ?>
               <tr>
                  <td><?php echo ($value->accounttypefull);?></td><!--ชื่อบัญชี-->
                  <td align="center"><?php echo ($value->accounttypeno);?></td><!--เลขที่บัญชี-->

                  <!--งบทดลองก่อนปรับปรุง-->
                  <td align="right"><!--Debit-->
                    <?php
                    // $modeltatrial_budget_before = Maincenter::getdatatrial_budget_allbefore($value->accounttypeno,$datepicker);
                    // if($modeltatrial_budget_before){
                    //   if($modeltatrial_budget_before[0]->sumdebit > $modeltatrial_budget_before[0]->sumcredit){
                    //         echo number_format ($modeltatrial_budget_before[0]->sumdebit - $modeltatrial_budget_before[0]->sumcredit,2);
                    //         $sumdebitbefore = $sumdebitbefore + ($modeltatrial_budget_before[0]->sumdebit - $modeltatrial_budget_before[0]->sumcredit);
                    //   }
                    // }
                    if($modeltatrial_budget_before_forward){
                      if($modeltatrial_budget_before){
                        if(($modeltatrial_budget_before[0]->sumdebit + $modeltatrial_budget_before_forward[0]->sumdebit) > ($modeltatrial_budget_before[0]->sumcredit + $modeltatrial_budget_before_forward[0]->sumcredit)){
                              echo number_format (($modeltatrial_budget_before[0]->sumdebit + $modeltatrial_budget_before_forward[0]->sumdebit) - ($modeltatrial_budget_before[0]->sumcredit + $modeltatrial_budget_before_forward[0]->sumcredit),2);
                              $sumdebitbefore = $sumdebitbefore + (($modeltatrial_budget_before[0]->sumdebit + $modeltatrial_budget_before_forward[0]->sumdebit) - ($modeltatrial_budget_before[0]->sumcredit + $modeltatrial_budget_before_forward[0]->sumcredit));
                        }
                      }
                    }
                    else if($modeltatrial_budget_before){
                      if($modeltatrial_budget_before[0]->sumdebit > $modeltatrial_budget_before[0]->sumcredit){
                            echo number_format ($modeltatrial_budget_before[0]->sumdebit - $modeltatrial_budget_before[0]->sumcredit,2);
                            $sumdebitbefore = $sumdebitbefore + ($modeltatrial_budget_before[0]->sumdebit - $modeltatrial_budget_before[0]->sumcredit);
                      }
                    }
                    ?>
                  </td>
                  <td align="right"><!--Credit-->
                    <?php
                    // if($modeltatrial_budget_before){
                    //   if($modeltatrial_budget_before[0]->sumdebit < $modeltatrial_budget_before[0]->sumcredit){
                    //         echo number_format ($modeltatrial_budget_before[0]->sumcredit - $modeltatrial_budget_before[0]->sumdebit,2);
                    //         $sumcreditbefore = $sumcreditbefore + ($modeltatrial_budget_before[0]->sumcredit - $modeltatrial_budget_before[0]->sumdebit);
                    //   }
                    // }
                    if($modeltatrial_budget_before_forward){
                      if($modeltatrial_budget_before){
                        if(($modeltatrial_budget_before[0]->sumdebit + $modeltatrial_budget_before_forward[0]->sumdebit) < ($modeltatrial_budget_before[0]->sumcredit + $modeltatrial_budget_before_forward[0]->sumcredit)){
                              echo number_format (($modeltatrial_budget_before[0]->sumcredit + $modeltatrial_budget_before_forward[0]->sumcredit) - ($modeltatrial_budget_before[0]->sumdebit + $modeltatrial_budget_before_forward[0]->sumdebit),2);
                              $sumcreditbefore = $sumcreditbefore + (($modeltatrial_budget_before[0]->sumcredit + $modeltatrial_budget_before_forward[0]->sumcredit) - ($modeltatrial_budget_before[0]->sumdebit + $modeltatrial_budget_before_forward[0]->sumdebit));
                        }
                      }
                    }else if($modeltatrial_budget_before){
                      if($modeltatrial_budget_before[0]->sumdebit < $modeltatrial_budget_before[0]->sumcredit){
                            echo number_format ($modeltatrial_budget_before[0]->sumcredit - $modeltatrial_budget_before[0]->sumdebit,2);
                            $sumcreditbefore = $sumcreditbefore + ($modeltatrial_budget_before[0]->sumcredit - $modeltatrial_budget_before[0]->sumdebit);
                      }
                    }
                    ?>
                  </td>


                  <!--รายการปรับปรุง-->
                  <td align="right"><!--Debit-->
                    <?php
                    // $modeltatrial_budget_after = Maincenter::getdatatrial_budget_allafter($value->accounttypeno,$datepicker);
                    // if($modeltatrial_budget_after){
                    //   if($modeltatrial_budget_after[0]->sumdebit > $modeltatrial_budget_after[0]->sumcredit){
                    //         echo number_format ($modeltatrial_budget_after[0]->sumdebit - $modeltatrial_budget_after[0]->sumcredit,2);
                    //         $sumdebit = $sumdebit + ($modeltatrial_budget_after[0]->sumdebit - $modeltatrial_budget_after[0]->sumcredit);
                    //   }
                    // }
                    if($modeltatrial_budget_after_forward){
                      if($modeltatrial_budget_after){
                        if(($modeltatrial_budget_after[0]->sumdebit + $modeltatrial_budget_after_forward[0]->sumdebit) > ($modeltatrial_budget_after[0]->sumcredit + $modeltatrial_budget_after_forward[0]->sumcredit)){
                              echo number_format (($modeltatrial_budget_after[0]->sumdebit + $modeltatrial_budget_after_forward[0]->sumdebit) - ($modeltatrial_budget_after[0]->sumcredit + $modeltatrial_budget_after_forward[0]->sumcredit),2);
                              $sumdebit = $sumdebit + (($modeltatrial_budget_after[0]->sumdebit + $modeltatrial_budget_after_forward[0]->sumdebit) - ($modeltatrial_budget_after[0]->sumcredit + $modeltatrial_budget_after_forward[0]->sumcredit));
                        }
                      }
                    }
                    else if($modeltatrial_budget_after){
                      if($modeltatrial_budget_after[0]->sumdebit > $modeltatrial_budget_after[0]->sumcredit){
                            echo number_format ($modeltatrial_budget_after[0]->sumdebit - $modeltatrial_budget_after[0]->sumcredit,2);
                            $sumdebit = $sumdebit + ($modeltatrial_budget_after[0]->sumdebit - $modeltatrial_budget_after[0]->sumcredit);
                      }
                    }
                    ?>
                  </td>
                  <td align="right"><!--Credit-->
                    <?php
                    // if($modeltatrial_budget_after){
                    //   if($modeltatrial_budget_after[0]->sumdebit < $modeltatrial_budget_after[0]->sumcredit){
                    //         echo number_format ($modeltatrial_budget_after[0]->sumcredit - $modeltatrial_budget_after[0]->sumdebit,2);
                    //         $sumcredit = $sumcredit + ($modeltatrial_budget_after[0]->sumcredit - $modeltatrial_budget_after[0]->sumdebit);
                    //   }
                    // }
                    if($modeltatrial_budget_after_forward){
                      if($modeltatrial_budget_after){
                        if(($modeltatrial_budget_after[0]->sumdebit + $modeltatrial_budget_after_forward[0]->sumdebit) > ($modeltatrial_budget_after[0]->sumcredit + $modeltatrial_budget_after_forward[0]->sumcredit)){
                              echo number_format (($modeltatrial_budget_after[0]->sumdebit + $modeltatrial_budget_after_forward[0]->sumdebit) - ($modeltatrial_budget_after[0]->sumcredit + $modeltatrial_budget_after_forward[0]->sumcredit),2);
                              $sumcredit = $sumcredit + (($modeltatrial_budget_after[0]->sumdebit + $modeltatrial_budget_after_forward[0]->sumdebit) - ($modeltatrial_budget_after[0]->sumcredit + $modeltatrial_budget_after_forward[0]->sumcredit));
                        }
                      }
                    }
                    else if($modeltatrial_budget_after){
                      if($modeltatrial_budget_after[0]->sumdebit < $modeltatrial_budget_after[0]->sumcredit){
                            echo number_format ($modeltatrial_budget_after[0]->sumcredit - $modeltatrial_budget_after[0]->sumdebit,2);
                            $sumcredit = $sumcredit + ($modeltatrial_budget_after[0]->sumcredit - $modeltatrial_budget_after[0]->sumdebit);
                      }
                    }
                    ?>
                  </td>


                  <!--งบทดลองหลังปรับปรุง-->
                  <td align="right"><!--Debit-->
                    <?php
                    // $modelaccount_name = Maincenter::getdataaccount_name_all($value->accounttypeno,$datepicker);
                    // if($modelaccount_name){
                    //   if($modelaccount_name[0]->sumdebit > $modelaccount_name[0]->sumcredit){
                    //         echo number_format ($modelaccount_name[0]->sumdebit - $modelaccount_name[0]->sumcredit,2);
                    //         $sumdebitafter = $sumdebitafter + ($modelaccount_name[0]->sumdebit - $modelaccount_name[0]->sumcredit);
                    //   }
                    // }
                    if($modelbroughtforward){
                      if($modelaccount_name){
                        if(($modelaccount_name[0]->sumdebit + $modelbroughtforward[0]->sumdebit) > ($modelaccount_name[0]->sumcredit + $modelbroughtforward[0]->sumcredit)){
                              echo number_format (($modelaccount_name[0]->sumdebit + $modelbroughtforward[0]->sumdebit) - ($modelaccount_name[0]->sumcredit + $modelbroughtforward[0]->sumcredit),2);
                              $sumdebitafter = $sumdebitafter + (($modelaccount_name[0]->sumdebit + $modelbroughtforward[0]->sumdebit) - ($modelaccount_name[0]->sumcredit + $modelbroughtforward[0]->sumcredit));
                        }
                      }
                    }
                    else if($modelaccount_name){
                        if($modelaccount_name[0]->sumdebit > $modelaccount_name[0]->sumcredit){
                              echo number_format ($modelaccount_name[0]->sumdebit - $modelaccount_name[0]->sumcredit,2);
                              $sumdebitafter = $sumdebitafter + ($modelaccount_name[0]->sumdebit - $modelaccount_name[0]->sumcredit);
                        }
                    }
                    ?>
                  </td>
                  <td align="right"><!--Credit-->
                    <?php
                    // if($modelaccount_name){
                    //   if($modelaccount_name[0]->sumdebit < $modelaccount_name[0]->sumcredit){
                    //         echo number_format ($modelaccount_name[0]->sumcredit - $modelaccount_name[0]->sumdebit,2);
                    //         $sumcreditafter = $sumcreditafter + ($modelaccount_name[0]->sumcredit - $modelaccount_name[0]->sumdebit);
                    //   }
                    // }
                    if($modelbroughtforward){
                      if($modelaccount_name){
                        if(($modelaccount_name[0]->sumdebit + $modelbroughtforward[0]->sumdebit) < ($modelaccount_name[0]->sumcredit + $modelbroughtforward[0]->sumcredit)){
                              echo number_format (($modelaccount_name[0]->sumcredit + $modelbroughtforward[0]->sumcredit) - ($modelaccount_name[0]->sumdebit + $modelbroughtforward[0]->sumdebit),2);
                              $sumcreditafter = $sumcreditafter + (($modelaccount_name[0]->sumcredit + $modelbroughtforward[0]->sumcredit) - ($modelaccount_name[0]->sumdebit + $modelbroughtforward[0]->sumdebit));
                        }
                      }
                    }else if($modelaccount_name){
                      if($modelaccount_name[0]->sumdebit < $modelaccount_name[0]->sumcredit){
                            echo number_format ($modelaccount_name[0]->sumcredit - $modelaccount_name[0]->sumdebit,2);
                            $sumcreditafter = $sumcreditafter + ($modelaccount_name[0]->sumcredit - $modelaccount_name[0]->sumdebit);
                      }
                    }
                    ?>
                  </td>


                  <!--งบกำไรขาดทุน-->
                  <td align="right"><!--Debit-->
                    <?php
                    // $modelaincome = Maincenter::getdataincome_all($value->accounttypeno,$datepicker);
                    // if($modelaincome){
                    //   if($modelaincome[0]->sumdebit > $modelaincome[0]->sumcredit){
                    //         echo number_format ($modelaincome[0]->sumdebit - $modelaincome[0]->sumcredit,2);
                    //         $sumdebitincome = $sumdebitincome + ($modelaincome[0]->sumdebit - $modelaincome[0]->sumcredit);
                    //   }
                    // }
                    if($modelaincome_forward){
                      if($modelaincome){
                        if(($modelaincome[0]->sumdebit + $modelaincome_forward[0]->sumdebit) > ($modelaincome[0]->sumcredit + $modelaincome_forward[0]->sumcredit)){
                              echo number_format (($modelaincome[0]->sumdebit + $modelaincome_forward[0]->sumdebit) - ($modelaincome[0]->sumcredit + $modelaincome_forward[0]->sumcredit),2);
                              $sumdebitincome = $sumdebitincome + (($modelaincome[0]->sumdebit + $modelaincome_forward[0]->sumdebit) - ($modelaincome[0]->sumcredit + $modelaincome_forward[0]->sumcredit));
                        }
                      }
                    }
                    else if($modelaincome){
                      if($modelaincome[0]->sumdebit > $modelaincome[0]->sumcredit){
                            echo number_format ($modelaincome[0]->sumdebit - $modelaincome[0]->sumcredit,2);
                            $sumdebitincome = $sumdebitincome + ($modelaincome[0]->sumdebit - $modelaincome[0]->sumcredit);
                      }
                    }
                    ?>
                  </td>
                  <td align="right"><!--Credit-->
                    <?php
                    // if($modelaincome){
                    //   if($modelaincome[0]->sumdebit < $modelaincome[0]->sumcredit){
                    //         echo number_format ($modelaincome[0]->sumcredit - $modelaincome[0]->sumdebit,2);
                    //         $sumcreditincome = $sumcreditincome + ($modelaincome[0]->sumcredit - $modelaincome[0]->sumdebit);
                    //   }
                    // }
                    if($modelaincome_forward){
                      if($modelaincome){
                        if(($modelaincome[0]->sumdebit + $modelaincome_forward[0]->sumdebit) > ($modelaincome[0]->sumcredit + $modelaincome_forward[0]->sumcredit)){
                              echo number_format (($modelaincome[0]->sumdebit + $modelaincome_forward[0]->sumdebit) - ($modelaincome[0]->sumcredit + $modelaincome_forward[0]->sumcredit),2);
                              $sumcreditincome = $sumcreditincome + (($modelaincome[0]->sumdebit + $modelaincome_forward[0]->sumdebit) - ($modelaincome[0]->sumcredit + $modelaincome_forward[0]->sumcredit));
                        }
                      }
                    }
                    else if($modelaincome){
                      if($modelaincome[0]->sumdebit < $modelaincome[0]->sumcredit){
                            echo number_format ($modelaincome[0]->sumcredit - $modelaincome[0]->sumdebit,2);
                            $sumcreditincome = $sumcreditincome + ($modelaincome[0]->sumcredit - $modelaincome[0]->sumdebit);
                      }
                    }
                    ?>
                  </td>


                  <!--งบแสดงฐานะการเงิน-->
                  <td align="right"><!--Debit-->
                    <?php
                    // $modelafinancial = Maincenter::getdatafinancial_all($value->accounttypeno,$datepicker);
                    // if($modelafinancial){
                    //   if($modelafinancial[0]->sumdebit > $modelafinancial[0]->sumcredit){
                    //         echo number_format ($modelafinancial[0]->sumdebit - $modelafinancial[0]->sumcredit,2);
                    //         $sumdebitfinancial = $sumdebitfinancial + ($modelafinancial[0]->sumdebit - $modelafinancial[0]->sumcredit);
                    //   }
                    // }
                    if($modelafinancial_forward){
                      if($modelafinancial){
                        if(($modelafinancial[0]->sumdebit + $modelafinancial_forward[0]->sumdebit) > ($modelafinancial[0]->sumcredit + $modelafinancial_forward[0]->sumcredit)){
                              echo number_format (($modelafinancial[0]->sumdebit + $modelafinancial_forward[0]->sumdebit) - ($modelafinancial[0]->sumcredit + $modelafinancial_forward[0]->sumcredit),2);
                              $sumdebitfinancial = $sumdebitfinancial + (($modelafinancial[0]->sumdebit + $modelafinancial_forward[0]->sumdebit) - ($modelafinancial[0]->sumcredit + $modelafinancial_forward[0]->sumcredit));
                        }
                      }
                    }
                    else if($modelafinancial){
                      if($modelafinancial[0]->sumdebit > $modelafinancial[0]->sumcredit){
                            echo number_format ($modelafinancial[0]->sumdebit - $modelafinancial[0]->sumcredit,2);
                            $sumdebitfinancial = $sumdebitfinancial + ($modelafinancial[0]->sumdebit - $modelafinancial[0]->sumcredit);
                      }
                    }
                    ?>
                  </td>
                  <td align="right"><!--Credit-->
                    <?php
                    // if($modelafinancial){
                    //   if($modelafinancial[0]->sumdebit < $modelafinancial[0]->sumcredit){
                    //         echo number_format ($modelafinancial[0]->sumcredit - $modelafinancial[0]->sumdebit,2);
                    //         $sumcreditfinancial = $sumcreditfinancial + ($modelafinancial[0]->sumcredit - $modelafinancial[0]->sumdebit);
                    //   }
                    // }
                    if($modelafinancial_forward){
                      if($modelafinancial){
                        if(($modelafinancial[0]->sumdebit + $modelafinancial_forward[0]->sumdebit) > ($modelafinancial[0]->sumcredit + $modelafinancial_forward[0]->sumcredit)){
                              echo number_format (($modelafinancial[0]->sumdebit + $modelafinancial_forward[0]->sumdebit) - ($modelafinancial[0]->sumcredit + $modelafinancial_forward[0]->sumcredit),2);
                              $sumcreditfinancial = $sumcreditfinancial + (($modelafinancial[0]->sumdebit + $modelafinancial_forward[0]->sumdebit) - ($modelafinancial[0]->sumcredit + $modelafinancial_forward[0]->sumcredit));
                        }
                      }
                    }
                    else if($modelafinancial){
                      if($modelafinancial[0]->sumdebit < $modelafinancial[0]->sumcredit){
                            echo number_format ($modelafinancial[0]->sumcredit - $modelafinancial[0]->sumdebit,2);
                            $sumcreditfinancial = $sumcreditfinancial + ($modelafinancial[0]->sumcredit - $modelafinancial[0]->sumdebit);
                      }
                    }
                    ?>
                  </td>


               </tr>
               </form>

             <?php $i++; } }?>

               <tr>
                 <td></td>
                 <td><center><b>รวม</b></center></td>
                 <td align="right"><b><?php echo number_format($sumdebitbefore,2); ?></b></td>
                 <td align="right"><b><?php echo number_format($sumcreditbefore,2); ?></b></td>

                 <td align="right"><b><?php echo number_format($sumdebit,2); ?></b></td>
                 <td align="right"><b><?php echo number_format($sumcredit,2); ?></b></td>

                 <td align="right"><b><?php echo number_format($sumdebitafter,2); ?></b></td>
                 <td align="right"><b><?php echo number_format($sumcreditafter,2); ?></b></td>

                 <td align="right"><b><?php echo number_format($sumdebitincome,2); ?></b></td>
                 <td align="right"><b><?php echo number_format($sumcreditincome,2); ?></b></td>

                 <td align="right"><b><?php echo number_format($sumdebitfinancial,2); ?></b></td>
                 <td align="right"><b><?php echo number_format($sumcreditfinancial,2); ?></b></td>
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
