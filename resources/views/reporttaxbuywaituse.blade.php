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
													<li class="breadcrumb-item">รายงาน</li>
													<li class="breadcrumb-item active">รายงานภาษีซื้อ</li>
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
        <form action="serachreporttaxbuywaituse" method="post">
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
                        <option value="<?php echo $value->code_branch?>" ><?php echo $value->name_branch;?></option>
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
                  <input type="text" name="reservation" id="reservation" value="" class="form-control" required readonly>
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
                    <!--  -->
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

              $datepicker = explode("-",trim(($data['reservation'])));

              // $start_date = $datepicker[0];
              $e1 = explode("/",trim(($datepicker[0])));
                      if(count($e1) > 0) {
                          $start_date = $e1[2] . '-' . $e1[0] . '-' . $e1[1]." 00:00:00"; //ปี - เดือน - วัน
                          $start_date2 = $start_date." 00:00:00";
                      }

              // $end_date = $datepicker[1];
              $e2 = explode("/",trim(($datepicker[1])));
                      if(count($e2) > 0) {
                          $end_date = $e2[2] . '-' . $e2[0] . '-' . $e2[1]." 23:59:59"; //ปี - เดือน - วัน
                          $end_date2 = $end_date." 23:59:59";
                      }

              $branch_id = $data['branch_id'];

              // echo "<pre>";
              // print_r($start_date);
              // print_r($end_date);
              // exit;

              $sql = 'SELECT '.$db['fsctaccount'].'.inform_po.*,
                             '.$db['fsctaccount'].'.po_head.branch_id

                     FROM '.$db['fsctaccount'].'.inform_po
                     INNER JOIN  '.$db['fsctaccount'].'.po_head
                        ON '.$db['fsctaccount'].'.po_head.id = '.$db['fsctaccount'].'.inform_po.id_po

                      WHERE '.$db['fsctaccount'].'.po_head.branch_id = "'.$branch_id.'"
                        AND '.$db['fsctaccount'].'.inform_po.datetime  BETWEEN "'.$start_date.'" AND  "'.$end_date.'"
                        AND '.$db['fsctaccount'].'.inform_po.status NOT IN (99)
                        AND '.$db['fsctaccount'].'.inform_po.vat_percent IN (7)
                        ORDER BY '.$db['fsctaccount'].'.inform_po.datebillreceipt
                     ';

              $datatresult = DB::connection('mysql')->select($sql);


              $sqlreserve = 'SELECT '.$db['fsctaccount'].'.reservemoney.*
                             FROM '.$db['fsctaccount'].'.reservemoney

                             WHERE '.$db['fsctaccount'].'.reservemoney.branch = "'.$branch_id.'"
                              AND '.$db['fsctaccount'].'.reservemoney.dateporef  BETWEEN "'.$start_date2.'" AND  "'.$end_date2.'"
                              AND '.$db['fsctaccount'].'.reservemoney.status IN (0 , 1 , 2)
                              AND '.$db['fsctaccount'].'.reservemoney.vat >= 1
                              AND '.$db['fsctaccount'].'.reservemoney.po_ref != 0
                              ORDER BY '.$db['fsctaccount'].'.reservemoney.date_bill_no
                             ';

              $datatresultreserve = DB::connection('mysql')->select($sqlreserve);

              // echo "<pre>";
              // print_r($datatresult);
              // echo "<br>";
              // print_r($datatresultreserve);
              // exit;

            ?>

            <!-- <form action="configreportcashdailynow" onSubmit="if(!confirm('ยืนยันการทำรายการ?')){return false;}" method="post" class="form-horizontal"> -->
            <!-- <input type="hidden" name="_token" value="{{ csrf_token() }}"> -->
            <form action="savebuyvatwaituse" method="post" enctype="multipart/form-data" onSubmit="JavaScript:return fncSubmit();">
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <!-- <table class="table table-striped"> -->
            <table  class="table table-striped table-bordered fontslabel" style="width:100%">
               <thead>
                 <tr>
                   <th>ลำดับ</th>
                   <th>ปี/เดือน/วัน</th>
                   <th>เลขที่</th>
                   <th>ชื่อผู้ซื้อสินค้า/ผู้รับบริการ</th>
                   <th>เลขประจำตัวผู้เสียภาษี</th>
                   <th>สถานประกอบการ</th>
                   <th>มูลค่าสินค้าหรือบริการ</th>
                   <th>จำนวนเงินภาษีมูลค่าเพิ่ม</th>
                   <th>จำนวนเงินรวมทั้งหมด</th>
                   <th>อนุมัติ</th>
                 </tr>
               </thead>
               <tbody>
                 <?php

                   $sumtotalloss = 0;
                   $vat = 0;
                   $i = 1;
                   $sumsubtotal = 0;
                   $sumvat = 0;
                   $sumgrandtotal = 0;

                   $j = 1;

                   // $sumtotalloss2 = 0;
                   // $sumsubtotal2 = 0;
                   // $sumgrandtotal2 = 0;

                   foreach ($datatresult as $key => $value) { ?>
                     <tr>
                        <td><?php echo $i;?></td><!--ลำดับ-->
                        <td><?php echo ($value->datebill);?></td><!--ปี/เดือน/วัน-->
                        <td><?php echo ($value->bill_no);?></td><!--เลขที่-->
                        <td>
                          <?php
                          $modelsupplier = Maincenter::getdatasupplierpo($value->id_po);
                                if($modelsupplier){
                                  echo ($modelsupplier[0]->pre);
                                  echo ($modelsupplier[0]->name_supplier);

                          ?>
                        </td>
                        <td><?php echo ($modelsupplier[0]->tax_id);?></td>
                        <td><?php echo ($modelsupplier[0]->type_branch); }?></td>

                        <?php  $vat = $value->vat_price; ?>
                        <?php  //$vat = ((($value->payout + $value->wht) * 7 )/ 100); ?>

                        <td>
                          <?php
                            echo number_format($value->payout - $vat + $value->wht , 2);
                            $sumsubtotal = $sumsubtotal + ($value->payout - $vat + $value->wht);
                          ?>
                        </td>

                        <td>

                          <?php
                            echo number_format ($vat,2);
                            $sumvat = $sumvat + $vat;
                          ?>
                        </td>

                        <td>
                          <?php
                            echo number_format ($value->payout + $value->wht,2);
                            $sumgrandtotal = $sumgrandtotal + $value->payout + $value->wht;
                          ?>
                        </td>
                        <td>
                            <input type="checkbox" name="id_checkinform[]" value="<?php echo $value->id; ?>">
                        </td>
                     </tr>

                   <?php $i++; } ?>

                   <?
                   foreach ($datatresultreserve as $key2 => $value2) { ?>

                   <tr>
                      <td><?php echo $i;?></td><!--ลำดับ-->
                      <td><?php echo ($value2->date_bill_no);?></td><!--ปี/เดือน/วัน-->
                      <td><?php echo ($value2->bill_no);?></td><!--เลขที่-->
                      <td>
                        <?php
                        $modelsuppliername = Maincenter::getdatasupplierpo($value2->po_ref);
                              if($modelsuppliername){
                                echo ($modelsuppliername[0]->pre);
                                echo ($modelsuppliername[0]->name_supplier);

                        ?>
                      </td>
                      <td><?php echo ($modelsuppliername[0]->tax_id);?></td>
                      <td><?php echo ($modelsuppliername[0]->type_branch); }?></td>

                      <?php  //$vat = (($value2->vat_money * 7 )/ 107); ?>

                      <td>
                        <?php
                          echo number_format($value2->amount, 2);
                          $sumsubtotal = $sumsubtotal + $value2->amount;
                        ?>
                      </td>

                      <td>
                        <?php
                          echo number_format ($value2->vat_money,2);
                          $sumvat = $sumvat + $value2->vat_money;
                        ?>
                      </td>

                      <td>
                        <?php
                          echo number_format ($value2->total,2);
                          $sumgrandtotal = $sumgrandtotal + $value2->total;
                        ?>
                      </td>
                      <td>
                        <input type="checkbox" name="id_checkrev[]" value="<?php echo $value2->id; ?>">
                      </td>
                   </tr>

                   <?php $i++; } ?>

              </tbody>
             </table>
            <br>
               <input type="submit" class="btn btn-success" style="float: right;margin: 0px 12px 10px 10px;" value="บันทึก">

          </form>

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
