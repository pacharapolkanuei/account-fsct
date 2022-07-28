<?php use App\Api\Connectdb;?>
@extends('index')
@section('content')
<script type="text/javascript" src="https://unpkg.com/sweetalert2@7.0.6/dist/sweetalert2.all.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
@if (Session::has('sweetalert.json'))
<script>
swal({!!Session::pull('sweetalert.json')!!});
</script>
@endif



  <div class="content-page">
    <!-- Start content -->
        <div class="content">
             <div class="container-fluid">

                  <div class="row">
                        <div class="col-xl-12">
                            <div class="breadcrumb-holder" id="fontscontent">
                                <h1 class="float-left">Account - FSCT</h1>
                                <ol class="breadcrumb float-right">
                                  <li class="breadcrumb-item">ค่าแรงพนักงานผลิต (ซื้อมาผลิต)</li>
                                  <li class="breadcrumb-item active">ค่าแรงพนักงานผลิต (ซื้อมาผลิต)</li>
                                </ol>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                  </div>

                  <div class="row">
                    <div class="col-sm-12">
                      <div class="card mb-3">
                        <div class="card-header">
                          <h3><i class="fas fa-edit"></i>
                            <fonts id="fontsheader">ค่าแรงพนักงานผลิต (ซื้อมาผลิต)</fonts>
                          </h3>
                        </div>
                        </div><!-- end card-->

                        <!-- Button to Open the Modal -->
                        <!-- แสดงตาราง -->
                        <?php
                        $connect1 = Connectdb::Databaseall();

                        $baseAc1 = $connect1['fsctaccount'];
                        $baseMan = $connect1['fsctmain'];

                        $sql2 = "SELECT $baseAc1.bill_of_lading_head.*
                                FROM $baseAc1.bill_of_lading_head
                                WHERE $baseAc1.bill_of_lading_head.status != '99' ";

                        $getdatas = DB::select($sql2);
                        //print_r($getdatas);
                        ?>
                        <div class="table-responsive">
                          <table id="example" class="table table-striped table-bordered fontslabel" style="width:100%">
                            <thead>
                              <tr>
                                <th>ลำดับ</th>
                                <th>รหัส ใบเบิก</th>
                                <th>วันที่ เบิก</th>
                                <th>lot</th>
                                <th>สถานะใบเบิก</th>
                                <th>เพิ่มพนักงานผลิต</th>
                                <th>รายละเอียด</th>
                              </tr>
                            </thead>

                            <tbody>
                              <?php
                              if(!empty($getdatas)){
                                 $i=1;foreach ($getdatas as $key => $value) {    ?>
                                  <tr>
                                    <th><?php echo $i;?></th>
                                    <th><?php echo $value->number_bill;?><input type="hidden" id="poshowappoved<?php echo $value->id?>" value="<?php echo $value->id;?>"></th>
                                    <th><?php echo $value->datetime;?></th>
                                    <th><?php echo $value->lot;?><input type="hidden" id="lot<?php echo $value->id?>" value="<?php echo $value->lot?>"></th>
                                    <th>
                                        <?php
                                              if($value->status==2){
                                                  echo '<p style="color:blue">เบิกของครบแล้วรออนุมัติ</p>';
                                              }elseif($value->status==3){
                                                  echo '<p style="color:orange">ยังมีของค้างในคลัง</p>';
                                              }elseif($value->status==1){
                                                  echo '<p style="color:green">อนุมัติเรียบร้อย</p>';
                                              }else{
                                                  echo '<p style="color:blue">ยังไม่ได้เบิก</p>';
                                              }
                                        ?>
                                    </th>
                                    <th>
                                      <button type="button" class="btn btn-primary" data-toggle="modal" onclick="getdataemptodm(<?php echo $value->id; ?>)" data-target="#myModal">
                                        <i class="fas fa-plus">
                                          <fonts id="fontscontent">เพิ่มพนักงานผลิต
                                        </i>
                                      </button>
                                    </th>
                                    <th><!--รายละเอียด--></th>
                                  </tr>
                                <?php $i++;}
                              }?>
                            </tbody>
                          </table><br>
                        </div>




                        <br>

                                <!-- แสดง error กรอกข้อมูลไม่ครบ -->
                                @if ($errors->any())
                                <script>
                                  swal({
                                    title: 'กรุณาระบุข้อมูลให้ครบถ้วน',
                                    html: '{!! implode(' <br> ',$errors->all()) !!}',
                                    type: 'error'
                                  })
                                </script>
                                @endif
                                <!-- แสดง error -->

                                <br>


                                <!-- The Modal -->
                                <div class="modal fade" id="myModal">
                                  <div class="modal-dialog modal-xl" style="max-width: 80%;" role="document">
                                    <div class="modal-content">

                                      <!-- Modal Header -->
                                      <div class="modal-header">
                                        <h4 class="modal-title" id="fontscontent2"><b>ค่าแรงพนักงานผลิต (ซื้อมาผลิต)</b></h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                      </div>

                                      <!-- Modal body -->
                                      <!-- ทำการ validate ช่องข้อมูล แสดง error -->
                                      <div class="modal-body">
                                        @if ($errors->any())
                                        <div class="alert alert-danger">
                                          <ul>
                                            @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                            @endforeach
                                          </ul>
                                        </div>
                                        @endif
                                        <!-- //สิ้นสุด ทำการ validate ช่องข้อมูล แสดง error -->
                                      <form action="saveempdateproductthislot" method="post" id="myForm" files='true' >
                                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                      <input type="hidden" name="id_poasset" id="id_poasset" value="0">
                                                <div class="was-validated form-inline" style="margin: 10px 50px 0px 50px;">
                                                  <!-- <div class="col-sm-6"> -->
                                                  <div class="row">
                                                    &nbsp;&nbsp;<label class="mb-2 mr-sm-2" id="fontslabel" for=""><b>Lot :   <b id="lotthis1"></b></b></label>
                                                    <br>
                                                  </div>
                                                  <!-- </div> -->
                                                </div>
                                                <br>
                                                <div class="row">
                                                  &nbsp;&nbsp;
                                                  <label class="mb-2 mr-sm-2" for="modal-input-priceservice" id="fontslabel"><b>วันที่ <?php echo date('Y-m-d H:m:s');?></b>

                                                  </label>
                                                  <br>
                                                </div>

                                                <br>
                                                <div class="row">

                                                      <div class="input-group-prepend">
                                                            &nbsp;&nbsp;<label id="fontslabel"><b>เลือกเดือน : &nbsp;</b></label>
                                                      </div>
                                                      <div class="input-group-prepend">
                                                            &nbsp;&nbsp <input type="month" class="form-control "  id="month" name="month" required onchange="changemonth()"></input>
                                                      </div>



                                                </div>

                                                <br>

                                                <div class="row">
                                                  &nbsp;&nbsp;
                                                  <label id="fontslabel"><b>เลือกพนักงานผลิต :</b></label>
                                                  <div class="col-sm">
                                                    <select  class="form-control select2" name="empproduct" id="empproduct"  required>
                                                      <option value="" selected>เลือกพนักงานผลิต</option>

                                                    </select>



                                                  </div>
                                                  <button type="button" class="btn btn-primary"  onclick="addrowempdate()" >
                                                    <i class="fas fa-plus">
                                                      <fonts id="fontscontent">เพิ่มพนักงาน
                                                    </i>
                                                  </button>
                                                </div>
                                                <br>



                                                <table class="table table-bordered table-hover">
                                                  <thead>
                                                  <tr>

                                                    <th rowspan="2">ชื่อพนักงาน</th>
                                                    <th rowspan="2">ตำแหน่ง</th>
                                                    <th colspan="4" ><b align="center">รายได้</b></th>
                                                    <th colspan="4" ><b align="center">รายจ่าย</b></th>
                                                    <th rowspan="2">จ่ายสุทธิ</th>
                                                    <th rowspan="2">เงินเดือน/ค่าแรงในการผลิตนี้</th>
                                                  </tr>
                                                  <tr>
                                                    <th>เงินเดือน</th>
                                                    <th>OT</th>
                                                    <th>รายรับอื่นๆ</th>
                                                    <th>รวมรายรับ</th>
                                                    <th>ประกันสังคม</th>
                                                    <th>ขาด/ลา</th>
                                                    <th>หักอื่นๆ</th>
                                                    <th>รวมรายหัก</th>
                                                    <th>ลบ</th>
                                                  </tr>
                                                  </thead>
                                                  <tbody id="datatable">
                                                  </tbody>
                                                </tr>
                                                <!-- <tr id="callast" style="dispaly:none;">
                                                  <th colspan="2">รวม</th>
                                                  <th><b id="grandsalary" class="del"></b></th>
                                                  <th><b id="grandot" class="del"></b></th>
                                                  <th><b id="grandincomeetc" class="del"></b></th>
                                                  <th><b id="grandtotalincome" class="del"></b></th>
                                                  <th><b id="grandsocial" class="del"></b></th>
                                                  <th><b id="grandleave" class="del"></b></th>
                                                  <th><b id="grandpayetc" class="del"></b></th>
                                                  <th><b id="grandtotalpay" class="del"></b></th>
                                                  <th><b id="grandnet" class="del"></b></th>
                                                  <th><b id="grandproductpay" class="del"></b></th>
                                                  <th></th>
                                                </tr> -->
                                                </table>

                                      </div>


                                      <div class="modal-footer">

                                      {!! Form::submit('บันทึก', ['class' => 'btn btn-success', 'style' => 'dispaly: inline']) !!}
                                        <button type="button" class="btn btn-warning" data-dismiss="modal">ยกเลิก</button>

                                      </div>
                                    </form>

                                    </div>
                                  </div>
                                </div>



                    </div>
      			<!-- END container-fluid -->
      		    </div>
      		<!-- END content -->
        </div>
      </div><!-- end card-->
  </div>

  <!-- Modal confrime-->
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          ยืนยันการอนุมัติ <b id="poappove"></b>
          <input type="hidden" id="idpoappoved" value="">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" onclick="saveapprovedpostatus();">Save</button>
        </div>
      </div>
    </div>
  </div>

  <!-- MODAL edit -->



  <!-- end iditmodal -->


  <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script> -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  <script type="text/javascript" src = 'js/accountjs/settingsalaryemptool.js'></script>
  <script>
      $(document).ready(function() {
      $('#example').DataTable();
      } );
  </script>



  <script type="text/javascript">
  $.ajaxSetup({ headers: { 'csrftoken' : '{{ csrf_token() }}' } });
  </script>



@endsection
