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
<!-- jquery -->
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<script type="text/javascript" src = 'js/accountjs/reportaccruedall.js'></script>

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
													<li class="breadcrumb-item active">รายงานเจ้าหนี้การค้า (ทั้งหมด)</li>
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
        <form action="serachreportaccruedall" method="post">
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
                    <a href="excelreportaccruedall?branch_id=<?php echo $branch_id ;?>" target="_blank" ><img src="images/global/printall.png"></a>
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
                   <th>ลำดับ</th>
                   <th>วันที่ใบแจ้งหนี้</th>
                   <th>เจ้าหนี้การค้า</th>
                   <th>รายการ</th>
                   <th>ยอดต้องชำระ</th>
                   <th>วันที่ครบกำหนด credit</th>
                   <!-- <th>สถานะ</th>
                   <th>แนบหลักฐานการจ่ายเงิน</th>
                   <th></th> -->
                 </tr>
               </thead>
               <tbody>

               <?php

               $sumtotalloss = 0;
               $i = 1;

               foreach ($data as $key => $value) { ?>

               <tr>
                  <td><?php echo $i;?></td><!--ลำดับ-->
                  <td><?php echo ($value->created_at);?></td><!--วันที่ใบแจ้งหนี้-->
                  <td><!--เจ้าหนี้การค้า-->
                    <?php
                    $modelsupplier = Maincenter::getdatasupplier($value->supplier_id);
                          if($modelsupplier){
                            echo ($modelsupplier[0]->pre);
                            echo ($modelsupplier[0]->name_supplier);
                          }
                    ?>
                  </td>
                  <td><!--รายการ-->
                    <?php
                    $modelpodetail = Maincenter::getdatapodetail($value->id);
                        if($modelpodetail){
                          echo ($modelpodetail[0]->list);
                        }
                    ?>
                  </td>
                  <td><?php echo ($value->vat_price);?></td><!--ยอดต้องชำระ-->
                  <td><!--วันที่ครบกำหนด credit-->
                    <?php
                    if($modelsupplier){
                      $terms_id = $modelsupplier[0]->terms_id;

                      $modelsupplierterms = Maincenter::getdatasupplierterms($terms_id);
                      if($modelsupplierterms){
                        // echo ($modelsupplierterms[0]->day);

                        $day = $modelsupplierterms[0]->day;
                        $newDate = date('d-m-Y', strtotime($value->created_at ." +$day day"));
                        echo $newDate;

                      }

                    }
                    ?>
                  </td>
                  <!--<td> สถานะ-->
                    <?php
                    // if($value->status_head == 0){
                    //   echo "รออนุมัติ";
                    // }else if($value->status_head == 1){
                    //   echo '<span style="color: blue;" />อนุมัติ / ยังไม่ได้โอน</span>';
                    // }else if($value->status_head == 2){
                    //   echo '<span style="color: green;" />รับของเรียบร้อย / โอนเรียบร้อย</span>';
                    // }
                    ?>
                  <!-- </td> -->
                  <!--<td> แนบหลักฐานการจ่ายเงิน-->
                      <?php
                         //if($value->status_head==1){ ?>
                         <!-- <input type="hidden" name="tranfermoneyidpo[]" id="tranfermoneyidpo" value="<?php //echo $value->id;?>">
                         <input type="file"  name="image" id="image" value=""> -->
                         <!-- <br>
                         <br> -->
                         <!-- <input type="file"  class="form-control-file showdetail" style="display:none;" name="inform_po_picture" id="inform_po_picture"> -->
                    <?php //} ?>
                  <!-- </td> -->
                  <!--<td> Save-->
                    <?php //if($value->status_head == 1){ ?>
                          <!-- <input type="submit" name="transfer" class="btn btn-info" value="Save"> -->
                    <?php //} ?>
                  <!-- </td> -->
               </tr>
               </form>

             <?php $i++; } ?>
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
