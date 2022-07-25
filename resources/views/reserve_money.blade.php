<?php

use  App\Api\Connectdb;
use  App\Api\Accountcenter;
use  App\Api\Maincenter;
use  App\Api\Vendorcenter;
use  App\Api\DateTime;

$level_id = Session::get('level_emp');

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

<script type="text/javascript" src='js/accountjs/reservemoney.js'></script>
<meta name="csrf-token" content="{{ csrf_token() }}" />

<div class="content-page">
  <!-- Start content -->
  <div class="content">
    <div class="container-fluid">

      <div class="row">
        <div class="col-xl-12">
          <div class="breadcrumb-holder" id="fontscontent">
            <h1 class="float-left">Account - FSCT</h1>
            <ol class="breadcrumb float-right">
              <li class="breadcrumb-item">จัดการข้อมูลซื้อ - ขาย</li>
              <li class="breadcrumb-item active">ตั้งเบิกเงินสำรองจ่าย</li>
            </ol>
            <div class="clearfix"></div>
          </div>
        </div>
      </div>
      <!-- end row -->

      <!-- <div class="box-body" style="overflow-x:auto;"> -->
      <!-- <form action="serachreportaccrued" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        </form> -->
      <!-- </div> -->

      <div style="padding: 25px 0px 0px 50px;" align="right">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
          <i class="fas fa-plus">
            <fonts id="fontscontent">ขอเงินสำรองจ่าย
          </i>
        </button>
      </div>

      <div class="row">
        <br>
      </div>

      <div class="row">
        <div class="col-md-12">
          <?php
          if (isset($query)) {
            // echo "<pre>";
            // print_r($data);
            // exit;
            ?>

            <!-- <form action="configreportcashdailynow" onSubmit="if(!confirm('ยืนยันการทำรายการ?')){return false;}" method="post" class="form-horizontal"> -->
            <!-- <input type="hidden" name="_token" value="{{ csrf_token() }}"> -->
            <form action="checkdetail" method="post" enctype="multipart/form-data">
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <!-- <table class="table table-striped"> -->
              <table id="example" class="table table-striped table-bordered fontslabel" style="width:100%">
                <thead>
                  <tr>
                    <th>ลำดับ</th>
                    <th>วันที่ขอ</th>
                    <th>รายการ</th>
                    <th>จำนวนเงิน</th>
                    <th>หมายเหตุ</th>
                    <th>สถานะการขอ</th>
                    <th>ผู้ขอ</th>
                    <th>อนุมัติ</th>
                    <th>ไม่อนุมัติ / ลบ </th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>

                  <?php

                  $sumtotalloss = 0;
                  $i = 1;
                  $date = date('Y-m-d');

                  foreach ($data as $key => $value) { ?>
                  <tr>
                    <td><?php echo $i; ?></td>
                    <!--ลำดับ-->
                    <td><?php echo ($value->datetime); ?></td>
                    <!--วันที่ขอ-->
                    <td><?php echo ($value->listname); ?></td>
                    <!--รายการ-->
                    <td><?php echo ($value->amount); ?></td>
                    <!--จำนวนเงิน-->
                    <td><?php echo ($value->note); ?></td>
                    <!--หมายเหตุ-->
                    <td>
                      <!--สถานะการขอ-->
                      <?php
                      if ($value->status == '1') {
                        echo '<span style="color: blue;" />ยังไม่ได้อนุมัติ</span>';
                        // echo "รออนุมัติ";
                      }else if ($value->status == '2') {
                        echo '<span style="color: green;" />อนุมัติแล้ว</span>';
                        // echo "อนุมัติแล้ว";
                      }else if ($value->status == '3') {
                        echo '<span style="color: green;" />จ่ายเงินสำรองแล้ว</span>';
                        // echo "อนุมัติแล้ว";
                      }else if ($value->status == '99') {
                        echo '<span style="color: red;" />ยกเลิก</span>';
                        // echo "อนุมัติแล้ว";
                      }
                      ?>
                    </td>
                    <td>
                      <!--ผู้ขอ-->
                      <?php
                      $modelemp = Maincenter::getdatacompemp($value->code_emp);
                      if ($modelemp) {
                        echo $value->code_emp;
                        echo " [";
                        echo ($modelemp[0]->nameth . " " . $modelemp[0]->surnameth);
                        echo "]";
                      }
                      ?>
                    </td>
                    <td>
                      <!--อนุมัติ-->
                      <!-- $level_id == '7' หัวหน้าหน่วยสาขา  if ($value->status == '1' && $level_id == '7' || $level_id == '15') -->
                      <?php if ($value->status == '1') { ?>
                        <input type="checkbox" name="check" id="check" value="<?php echo $value->id; ?>">
                      <?php } ?>

                    </td>
                    <td>
                      <!--ไม่อนุมัติ / ลบ-->
                      <?php if ($value->status == '1') { ?>
                        <a href="{{ route('reserve_money.updatereserve_withdraw',$value->id) }}">
                          <button type="button" class="btn btn-danger" onclick="if (!confirm('ยืนยันการลบข้อมูล?')) { return false }"><i class="fa fa-trash"></i> </button>
                        </a>
                        <input type="hidden" name="branch" id="branch" value="<?php echo $value->branch; ?>">
                      <?php } ?>
                    </td>
                    <td>
                      <!--Save-->
                      <?php //if($value->status_head == 1){
                      ?>
                      <?php if ($value->status == '1') { ?>
                        <input type="submit" name="transfer" class="btn btn-info" value="บันทึก" onclick="if (!confirm('ยืนยันการบันทึกข้อมูล?')) { return false }">
                      <?php } ?>
                    </td>
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


<!-- Strat Modal -->

<div class="modal fade" id="myModal" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">ตั้งเบิกเงินสำรองจ่าย</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <!-- <form id="configFormvendors" onsubmit="return getdatesubmit();" data-toggle="validator" method="post" class="form-horizontal"> -->
        <form action="savecash" method="post">
          <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">

          <div class="form-group row">
            <label for="list" class="col-sm-2"></label>
            <div class="col-sm-4">
              <!-- <input type="text" name="datepicker" id="datepicker" value="<?php //echo date('Y-m-d H:i:s');
                                                                                ?>" class="form-control datepicker" required readonly> -->
            </div>

            <label for="list" class="col-sm-2">สาขา</label>
            <div class="col-sm-4">
              <input type="text" name="brcode" id="brcode" value="<?php

              $branch_id = Session::get('brcode');
              $db = Connectdb::Databaseall();

              // $sqlbranch = 'SELECT * FROM '.$db['hr_base'].'.branch
              //         WHERE '.$db['hr_base'].'.branch.code_branch = '.$branch_id.' ';
              // $databranch = DB::connection('mysql')->select($sqlbranch);

              $modelbr = Maincenter::databranchbycode($branch_id);
              if ($modelbr) {
                echo ($modelbr[0]->name_branch);
              }

              ?>" class="form-control datepicker" required readonly>

            </div>
          </div>

          <div class="form-group row">
            <!-- <label for="list" class="col-sm-2">เลขที่เอกสาร</label>
              <div class="col-sm-4">
                <input class="form-control col-sm-10" type="text" name="billno" id="billno" value="" required>
              </div> -->

            <label for="list" class="col-sm-2">วันที่เบิกเงิน</label>
            <div class="col-sm-4">
              <input type="text" name="datepicker" id="datepicker" value="<?php echo date('Y-m-d H:i:s'); ?>" class="form-control datepicker" required readonly>
            </div>

            <label for="list" class="col-sm-2">วงเงินสดย่อย</label>
            <div class="col-sm-4">
              <?php

              $sqlcash = 'SELECT * FROM ' . $db['fsctaccount'] . '.cash
                                  WHERE ' . $db['fsctaccount'] . '.cash.branch_id = ' . $branch_id . '
                                  AND ' . $db['fsctaccount'] . '.cash.time LIKE "'.$date.'%"
                                  ';

              $datacash = DB::connection('mysql')->select($sqlcash);

              ?>
              <input type="text" name="totalcash" id="totalcash" value="<?php if ($datacash) {
                                                                          echo ($datacash[0]->grandtotal);
                                                                        } ?>" class="form-control datepicker" required readonly>

            </div>
          </div>

          <div class="form-group row">
            <label for="list" class="col-sm-2">รหัสพนักงาน</label>
            <div class="col-sm-4">
              <?php
              $empcode = Session::get('emp_code');
              echo $empcode;
              ?>
              <input type="hidden" name="empcode" id="empcode" value="<?php echo $empcode; ?>" class="form-control datepicker" required readonly>
            </div>

            <label for="list" class="col-sm-2">ชื่อ</label>
            <div class="col-sm-4">
              <?php
              $modelempcode = Maincenter::getdatacompemp($empcode);
              if ($modelempcode) {
                echo ($modelempcode[0]->nameth . " " . $modelempcode[0]->surnameth);
                echo " [";
                echo ($modelempcode[0]->position);
                echo " ]";
              }
              ?>
            </div>
          </div>

          <div class="form-group row">
            <label for="list" class="col-sm-2">รายการ</label>
            <div class="col-sm-10">
              <?php

              // $sqlcom = 'SELECT '.$db['fsctaccount'].'.listpaypre.*
              //            FROM '.$db['fsctaccount'].'.listpaypre
              //            AND '.$db['fsctaccount'].'.listpaypre.status = 1 ';
              // $data = DB::connection('mysql')->select($sqlcom);
              // print_r($data);
              ?>
              <select class="form-control col-sm-10" name="id_compay" id="id_compay" required>
                <option value="1"> บริษัท ฟ้าใสคอนสตรัคชั่นทูลส์ จำกัด </option>
                <option value="2"> บริษัท ฟ้าใส แมนูแฟคเจอริ่ง จำกัด </option>

              </select>
            </div>
          </div>

          <div class="form-group row">
            <label for="list" class="col-sm-2">รายการ</label>
            <div class="col-sm-10">
              <?php

              $db = Connectdb::Databaseall();
              // $sql = 'SELECT '.$db['fsctaccount'].'.listpaypre.*
              //         FROM '.$db['fsctaccount'].'.listpaypre
              //         AND '.$db['fsctaccount'].'.listpaypre.status = 1 ';
              $sql = 'SELECT * FROM ' . $db['fsctaccount'] . '.listpaypre
                            WHERE ' . $db['fsctaccount'] . '.listpaypre.status = 1
                           ';
              $data = DB::connection('mysql')->select($sql);
              // print_r($data);
              ?>
              <select class="form-control col-sm-10" name="list" id="list" required>
                <option value=""> เลือกรายการ </option>
                <?php foreach ($data as $key2 => $value2) { ?>
                  <option value="<?php echo $value2->id; ?>"> <?php echo $value2->listname; ?> </option>
                <?php } ?>
              </select>
            </div>
          </div>

          <div class="form-group row">
            <label for="amount" class="col-sm-2">จำนวนเงินที่ตั้งเบิก</label>
            <div class="col-sm-10">
              <input class="form-control col-sm-10" type="text" id="amount" name="amount" value="" required>
            </div>
          </div>

          <!-- <div class="form-group row">
              <label for="vat" class="col-sm-2">VAT (%)</label>
              <div class="col-sm-10">
                <input class="form-control col-sm-10" type="text" id="vat" name="vat" value="" required>
              </div>
            </div> -->

          <!-- <div class="form-group row">
              <label for="vat_money" class="col-sm-2">ยอด VAT (บาท)</label>
              <div class="col-sm-10">
                <input class="form-control col-sm-10" type="text" name="vat_money" id="vat_money" value="" required>
              </div>
            </div> -->

          <!-- <div class="form-group row">
              <label for="total" class="col-sm-2">ยอดสุทธิ</label>
              <div class="col-sm-10">
                <input class="form-control col-sm-10" type="text" name="total" id="total" value="" required>
              </div>
            </div> -->

          <div class="form-group row">
            <label for="total" class="col-sm-2">หมายเหตุ</label>
            <div class="col-sm-10">
              <input class="form-control col-sm-10" type="text" name="note" id="note" value="" required>
            </div>
          </div>
      </div>

      <input class="form-control col-sm-10" type="hidden" id="status" name="status" value="1">
      <input class="form-control col-sm-10" type="hidden" id="brid" name="brid" value="<?php echo $branch_id; ?>">
      <div class="row">
        <br>
      </div>

      <div class="modal-footer">
        <button type="submit" class="btn btn-success">ยืนยัน</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>
        </form>
      </div>
    </div>
  </div>

</div>

<!-- End Modal -->


@endsection
