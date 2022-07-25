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

<script type="text/javascript" src = 'js/accountjs/reservemoney.js'></script>
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
													<li class="breadcrumb-item active">จ่ายเงินสำรอง</li>
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
              <fonts id="fontscontent">จ่ายเงินสำรอง
            </i>
          </button>
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

            <div >
            <div class="table-responsive">
            <form action="checkdetail" method="post" enctype="multipart/form-data">
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <table id="example" class="table table-striped table-bordered fontslabel" style="width:100%">
            <!-- <table class="table table-striped"> -->
               <thead>
                 <tr>
                   <th>ลำดับ</th>
                   <th>วันที่ขอ</th>
                   <th>เลขที่บิล</th>
                   <th>รายการ</th>
                   <th>จำนวนเงินตั้งเบิก</th>
                   <th>จำนวน</th>
                   <th>ราคาต่อหน่วย</th>
                   <th>จำนวนเงินที่จ่าย</th>
                   <th>เงินทอน</th>
                   <th>สถานะการขอ</th>
                   <th>อนุมัติ</th>
                   <th>ไม่อนุมัติ / ลบ</th>
                   <!-- <th>ขอ PR</th> -->
                   <th>แนบ PO</th>
                 </tr>
               </thead>
               <tbody>

               <?php

               $sumtotalloss = 0;
               $i = 1;
               $date = date('Y-m-d');

               foreach ($data as $key => $value) { ?>
               <tr>
                  <td><?php echo $i;?></td><!--ลำดับ-->
                  <td><?php echo ($value->datetime);?></td><!--วันที่ขอ-->
                  <td><?php echo ($value->number_rsm);?></td><!--เลขที่บิล-->
                  <td><?php echo ($value->listname);?></td><!--รายการ-->
                  <td><?php echo ($value->amount);?></td><!--จำนวนเงินตั้งเบิก-->
                  <td><?php echo ($value->num);?></td><!--จำนวน-->
                  <td><?php echo ($value->num_price);?></td><!--ราคาต่อหน่วย-->
                  <td><?php echo ($value->total);?></td><!--จำนวนเงินที่จ่าย-->
                  <td><font color="red"><!--เงินทอน-->
                    <?php
                    echo number_format ($value->amount-$value->total,2);
                    ?>
                  </td></font>
                  <td><!--สถานะการขอ-->
                    <?php
                    if($value->status == '1'){
                      echo '<span style="color: blue;" />ยังไม่ได้อนุมัติ</span>';
                      // echo "รออนุมัติ";
                    }else if($value->status == '2'){
                      echo '<span style="color: green;" />อนุมัติแล้ว</span>';
                      // echo "อนุมัติแล้ว";
                    }else if($value->status == '99'){
                      echo '<span style="color: red;" />ยกเลิก</span>';
                      // echo "อนุมัติแล้ว";
                    }
                    ?>
                  </td>
                  <td><!--อนุมัติ-->
                    <?php if($value->status == '1'){ ?>
                    <!-- <input type="checkbox" name="check" id="check" value="<?php //echo $value->id;?>"> -->
                    <a href="{{ route('reserve_moneyto.recordreservemoney',$value->id) }}">
                      <button type="button" class="btn btn-info" onclick="if (!confirm('ยืนยันการบันทึกข้อมูล?')) { return false }"><i class="fa fa-check"></i> </button>
                    </a>
                    <?php } ?>
                  </td>
                  <td><!--ไม่อนุมัติ / ลบ-->
                    <?php if($value->status == '1'){ ?>
                    <a href="{{ route('reserve_moneyto.updatereservemoney',$value->id) }}">
                      <button type="button" class="btn btn-danger" onclick="if (!confirm('ยืนยันการลบข้อมูล?')) { return false }"><i class="fa fa-trash"></i> </button>
                    </a>
                    <!-- <button type="button" class="btn btn-danger"  onclick="deleteMe(<?php echo $value->id;?>);" ><i class="fa fa-trash"></i> </button> -->
                    <input type="hidden" name="branch" id="branch" value="<?php echo $value->branch;?>">
                    <?php } ?>
                  </td>
                  <!-- <td> -->
                    <!--ขอ PR-->
                    <?php //if($value->status == '2' && $value->po_ref == '0'){ ?>
                      <!--Test-->
                      <!-- <button type="button" value="" class="btn btn-warning" onClick="document.location.href='http://localhost/fsctaccount/public/vendoraddbill'" /><i class="fa fa-book"></i></button> -->

                      <!--ขึ้นระบบ-->
                      <!-- <button type="button" value="" class="btn btn-warning" onClick="document.location.href='http://103.13.231.24/.com/fsctaccounting/public/vendoraddbill'" /><i class="fa fa-book"></i></button> -->
                    <?php //} ?>
                  <!-- </td> -->
                  <td><!--แนบ PO-->
                    <?php if($value->status == '2' && $value->po_ref == '0'){ ?>
                    <a href="#"  data-toggle="modal" data-target="#myPoref" onclick="saveporef(<?php echo $value->id; ?>)" >
                      <img src="images/global/edit-icon.png">
                    </a>
                  <?php }else if($value->po_ref != '0'){
                         echo '<span style="color: blue;" /><u>';
                         echo ($value->po_num);
                         echo '</span></u>';
                        } ?>
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
          <h5 class="modal-title">จ่ายเงินสำรอง</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
        <!-- <form id="configFormvendors" onsubmit="return getdatesubmit();" data-toggle="validator" method="post" class="form-horizontal"> -->
        <form action="savereservemoney" method="post" >
        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">

            <div class="form-group row">
              <label for="list" class="col-sm-2">สาขา</label>
              <div class="col-sm-4" >
                <input type="text" name="brcode" id="brcode" value="<?php

                $branch_id = Session::get('brcode');
                $db = Connectdb::Databaseall();

                // $sqlbranch = 'SELECT * FROM '.$db['hr_base'].'.branch
                //         WHERE '.$db['hr_base'].'.branch.code_branch = '.$branch_id.' ';
                // $databranch = DB::connection('mysql')->select($sqlbranch);

                $modelbr = Maincenter::databranchbycode($branch_id);
                if($modelbr){
                  echo ($modelbr[0]->name_branch);
                }

                ?>" class="form-control datepicker" required readonly>
              </div>

                <!-- <select class="form-control col-sm-10" name="list" id="list" required> -->
                    <!-- <option value=""> เลือกสาขา </option> -->
                  <?php //foreach ($databranch as $key => $value) { ?>
                    <!-- <option value="<?php //echo $value->id; ?>"> <?php //echo $value->name_branch; ?> </option> -->
                  <?php //} ?>
                <!-- </select> -->

                <label for="list" class="col-sm-2"></label>  <!--เลขที่เอกสาร-->
                <div class="col-sm-4" >
                  <input class="form-control col-sm-12" type="hidden" name="billno" id="billno" value="" readonly/>
                </div>

            </div>

            <div class="form-group row">
              <!-- <label for="list" class="col-sm-2">เลขที่เอกสาร</label>
              <div class="col-sm-4">
                <input class="form-control col-sm-10" type="text" name="billno" id="billno" value="" required>
              </div> -->

              <label for="list" class="col-sm-2">วันที่เบิกเงิน</label>
              <div class="col-sm-4">
                <input type="text" name="datepicker" id="datepicker" value="<?php echo date('Y-m-d H:i:s');?>" class="form-control datepicker" required readonly>
              </div>

              <label for="list" class="col-sm-2">วงเงินสดย่อย</label>
              <div class="col-sm-4">
                <?php

                    $sqlcash = 'SELECT * FROM '.$db['fsctaccount'].'.cash
                                WHERE '.$db['fsctaccount'].'.cash.branch_id = '.$branch_id.'
                                AND ' . $db['fsctaccount'] . '.cash.time LIKE "'.$date.'%"
                                ';
                    $datacash = DB::connection('mysql')->select($sqlcash);

                ?>
                <input type="text" name="totalcash" id="totalcash" value="<?php if($datacash){ echo ($datacash[0]->grandtotal); }?>" class="form-control datepicker" required readonly>

              </div>
            </div>

            <div class="form-group row">
              <label for="list" class="col-sm-2">รหัสพนักงาน</label>
              <div class="col-sm-4">
                <?php
                $empcode = Session::get('emp_code');
                echo $empcode;
                ?>
                <input type="hidden" name="empcode" id="empcode" value="<?php echo $empcode;?>" class="form-control datepicker" required readonly>
              </div>

              <label for="list" class="col-sm-2">ชื่อ</label>
              <div class="col-sm-4">
                <?php
                $modelempcode = Maincenter::getdatacompemp($empcode);
                if($modelempcode){
                  echo ($modelempcode[0]->nameth." ".$modelempcode[0]->surnameth);
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
                  <select class="form-control col-sm-12" name="id_compay" id="id_compay" required>
                      <option value="1"> บริษัท ฟ้าใสคอนสตรัคชั่นทูลส์ จำกัด </option>
                      <option value="2"> บริษัท ฟ้าใส แมนูแฟคเจอริ่ง จำกัด </option>

                  </select>
                </div>
            </div>

            <div class="form-group row">
              <label for="list" class="col-sm-2">วันที่บิล</label>
              <div class="col-sm-10">
                <input class="form-control col-sm-12" type="date" name="date_bill_no" id="date_bill_no" value="" required>
              </div>
            </div>

            <div class="form-group row">
              <label for="list" class="col-sm-2">รายการ</label>
              <div class="col-sm-4">
                <input class="form-control col-sm-10" type="hidden" id="status" name="status" value="1" >
                <input class="form-control col-sm-10" type="hidden" id="brid" name="brid" value="<?php echo $branch_id;?>" >
                <?php

                    $db = Connectdb::Databaseall();
                    // $sql = 'SELECT '.$db['fsctaccount'].'.listpaypre.*
                    //         FROM '.$db['fsctaccount'].'.listpaypre
                    //         AND '.$db['fsctaccount'].'.listpaypre.status = 1 ';
                    $sql = 'SELECT '.$db['fsctaccount'].'.reserve_withdraw.*,
                                   '.$db['fsctaccount'].'.listpaypre.listname
                           FROM '.$db['fsctaccount'].'.reserve_withdraw

                           INNER JOIN  '.$db['fsctaccount'].'.listpaypre
                              ON '.$db['fsctaccount'].'.reserve_withdraw.list = '.$db['fsctaccount'].'.listpaypre.id

                           WHERE '.$db['fsctaccount'].'.reserve_withdraw.branch = '.$branch_id.'
                           AND '.$db['fsctaccount'].'.reserve_withdraw.status IN (2)
                             ';
                    $data = DB::connection('mysql')->select($sql);
                    // echo "<pre>";
                    // print_r($data);
                    // exit;
                ?>
                <select class="form-control" id="list" name="list" onchange="selecttypeprice(this)"  required>
                <!-- <select class="form-control col-sm-12" name="list" id="list" required> -->
                    <option value=""> เลือกรายการ </option>
                  <?php foreach ($data as $key2 => $value2) {?>
                    <option value="<?php echo $value2->id; ?>"> <?php echo $value2->listname; ?> </option>
                      <?php  } ?>
                </select>
              </div>

              <label for="list" class="col-sm-2">จำนวนเงินตั้งเบิก</label>
              <div class="col-sm-4">
              <!-- <div class="row showdetail" style="display: none" class="col-sm-4"> -->
                  <!-- <input class="form-control col-sm-6" type="text" name="amount[]" id="amount0" disabled > -->
                  <input class="form-control col-sm-12" type="text" id="amount" name="amount[]" value="" required readonly>
                  <input class="form-control col-sm-12" type="hidden" id="list0" name="list0[]" value="" required readonly>
                  <input class="form-control col-sm-12" type="hidden" id="id_list" name="id_list[]" value="" required readonly>
              </div>

            </div>

            <div class="form-group row">
              <label for="list" class="col-sm-2">จำนวน</label>
              <div class="col-sm-4">
                <input class="form-control col-sm-12" type="text" name="amount_num" id="amount_num" value="" required>
              </div>

              <label for="list" class="col-sm-2">ราคาต่อหน่วย</label>
              <div class="col-sm-4">
                <input class="form-control col-sm-12" type="text" name="price" id="price" value="" required>
              </div>
            </div>

            <div class="form-group row">
              <label for="list" class="col-sm-2">จำนวนเงินที่จ่ายจริง</label>
              <div class="col-sm-4">
                <input class="form-control col-sm-12" type="text" name="totalreal" id="totalreal" value="" required>
              </div>

              <label for="total" class="col-sm-2">หมายเหตุ</label>
              <div class="col-sm-4">
                <input class="form-control col-sm-12" type="text" name="note" id="note" value="" required>
              </div>

            </div>
          </div>

          <div class="row">
              <br>
          </div>

        <div class="modal-footer">
          <button type="submit"  class="btn btn-success">ยืนยัน</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>
        </form>
        </div>
      </div>
      </div>

    </div>

<!-- End Modal -->

<div class="modal fade" id="myPoref"  role="dialog" aria-labelledby="Login" aria-hidden="true">
    <div class="modal-dialog" style="width:60%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title">PO. ref</h5>
            </div>

            <div class="modal-body">

                <!-- <form id="configPo" onsubmit="return getponumbersubmit();" data-toggle="validator" method="post" class="form-horizontal">
                    <input value="{{ null }}" type="hidden" id="reservemoneyid" name="reservemoneyid" /> -->
                    <form action="insertporef" method="post" >
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">

                    <!-- <input class="form-control col-sm-10" type="hidden" id="id" name="id" value="" required>  -->
                    <input value="{{ null }}" type="hidden" id="reservemoneyid" name="reservemoneyid" />

                    <div class="container-fluid">
                      <div class="form-group row">
                        <label for="amount" class="col-sm-2">PO.</label>
                        <div class="col-sm-10">
                          <input class="form-control col-sm-10" type="text" id="ponumber" name="ponumber" value="" required>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                        <br>
                    </div>
                    <!-- <div class="container-fluid">
                      <div class="form-group row">
                        <label for="amount" class="col-sm-2">วันที่บิล/ใบกำกับภาษี.</label>
                        <div class="col-sm-10">
                          <input class="form-control col-sm-10" type="text" id="bill_no" name="bill_no" value="" required>
                        </div>
                      </div>
                    </div> -->
                    <div class="row">
                        <br>
                    </div>
                    <div class="container-fluid">
                      <div class="form-group row">
                        <label for="amount" class="col-sm-2">บิลใบกำกับภาษี/ใบเสร็จ.</label>
                        <div class="col-sm-10">
                          <input class="form-control col-sm-10" type="text" id="bill_no" name="bill_no" value="" required>
                        </div>
                      </div>
                    </div>

                    <!-- <div class="row">
                        <br>
                    </div>
                    <div class="container-fluid">
                      <div class="form-group row">
                        <label for="amount" class="col-sm-2">หลักฐาน</label>
                        <div class="col-sm-10">
                          <input class="form-control col-sm-10" type="file" id="fileref" name="fileref"  required>
                        </div>
                      </div>
                    </div> -->
                    <div class="row">
                        <br>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="col-xs-5 col-xs-offset-3">
                                    <button type="submit" id="Btn_save" class="btn btn-primary">Save</button>
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>


                </form>
            </div>
        </div>
    </div>
</div>



@endsection
