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

<style media="screen">
.select2-container .select2-selection--single{
  height:40px !important;
}
.select2-container--default .select2-selection--single{
  border: 1px solid #ccc !important;
  border-radius: 0px !important;
}
</style>

  <div class="content-page">
    <!-- Start content -->
        <div class="content">
             <div class="container-fluid">

                  <div class="row">
                        <div class="col-xl-12">
                            <div class="breadcrumb-holder" id="fontscontent">
                                <h1 class="float-left">Account - FSCT</h1>
                                <ol class="breadcrumb float-right">
                                  <li class="breadcrumb-item">ทรัพย์สินและค่าเสื่อม</li>
                                  <li class="breadcrumb-item active">เพิ่มรายการต้นทุนแบบเหล็ก(ซื้อมาผลิต)</li>
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
                            <fonts id="fontsheader">เพิ่มรายการต้นทุนแบบเหล็ก(ซื้อมาผลิต)</fonts>
                          </h3>
                        </div>
                        </div><!-- end card-->

                                <!-- Button to Open the Modal -->
                                <div>
                                  <button type="button" class="btn btn-primary" data-toggle="modal" style="float: right;margin: 0px 12px 10px 10px;" data-target="#myModal">
                                    <i class="fas fa-plus">
                                      <fonts id="fontscontent">เพิ่มข้อมูล
                                    </i>
                                  </button>
                                </div>

                                <br>
                                <?php
                                $connect1 = Connectdb::Databaseall();

                                $baseAc1 = $connect1['fsctaccount'];
                                $baseMan = $connect1['fsctmain'];

                                $sql1 = "SELECT $baseAc1.receiptasset.*,
                                                $baseAc1.bill_of_lading_head.number_bill as  bill_of_lading_head,
                                                SUM($baseAc1.receiptasset_detail.total_cost_produce) as sum_total_cost_produce
                                        FROM $baseAc1.receiptasset
                                        INNER JOIN $baseAc1.bill_of_lading_head
                                        ON $baseAc1.bill_of_lading_head.id = $baseAc1.receiptasset.bill_of_lading_head_id
                                        INNER JOIN $baseAc1.receiptasset_detail
                                        ON $baseAc1.receiptasset_detail.receiptasset_id = $baseAc1.receiptasset.id
                                        WHERE $baseAc1.receiptasset.status != '99'
                                        AND  $baseAc1.receiptasset.type_pd = '1'";
                                $gethead = DB::select($sql1);

                                //print_r($getdatas);
                                ?>
                                <div class="table-responsive">
                                  <table id="example" class="table table-striped table-bordered fontslabel" style="width:100%">
                                    <thead>
                                      <tr>
                                        <th>รหัสใบผลิตสินค้า </th>
                                        <th>วันที่</th>
                                        <th>รวมต้นทุนผลิต</th>
                                        <th>สถานะ</th>
                                        <th>อนุมัติ</th>
                                        <th>พิมพ์รายละเอียด</th>
                                      </tr>
                                    </thead>
                                    <?php if(isset($gethead)){
                                        foreach ($gethead as $key => $value) {
                                    ?>
                                          <tbody>
                                            <tr>
                                              <td><?php echo $value->bill_of_lading_head;?></td>
                                              <td><?php echo $value->datein;?></th>
                                              <td><?php echo $value->sum_total_cost_produce;?></th>
                                              <td><?php
                                                      if($value->status==0){
                                                          echo '<p style="color:blue">รออนุมัติ</p>';
                                                      }elseif($value->status==1){
                                                          echo '<p style="color:green">อนุมัติเรียบร้อย</p>';
                                                      }
                                                  ?>
                                              </td>
                                              <td>
                                                <button type="button" class="btn btn-primary" data-toggle="modal" onclick="saveapprovedtool(<?php echo $value->id ?>)" data-target="#exampleModal">
                                                  <i class="fas fa-check">
                                                    <fonts id="fontscontent">เพิ่มข้อมูล
                                                  </i>
                                                </button>
                                              </td>
                                              <td> <a href="printasset_product_tool?id=<?php echo $value->id ?>" target="_blank"><img src="images/global/printall.png"> </a></td>
                                            </tr>
                                          </tbody>
                                      <?php }?>
                                  <?php }?>
                                  </table>
                                  <br>
                                </div>

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
                                  <div class="modal-dialog modal-xl" style="max-width: 80%;">
                                    <div class="modal-content">

                                      <!-- Modal Header -->
                                      <div class="modal-header">
                                        <h4 class="modal-title" id="fontscontent2"><b>การจัดการชิ้นส่วนสินค่าให้เช่า(ซื้อมาผลิต)</b></h4>
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

                                          <form action="saveproductgoodtoproduct" method="post" id="myForm" files='true' >
                                          <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                                <div class="row" >
                                                  <!-- <div class="col-sm-6"> -->
                                                  <div class="col-sm-2">
                                                    <label class="mb-2 mr-sm-2" id="fontslabel" for=""><b>ใบเบิกวัตถุดิบ :</b></label>
                                                  </div>
                                                  <div class="col-sm-3">
                                                    <input type="text" class="form-control mb-2 mr-sm-2" name="bill_of_lading_head" id="bill_of_lading_head" onblur="seachbillhead()" required="">
                                                  </div>
                                                  <!-- </div> -->
                                                </div>
                                                <br>
                                                <div class="row" >
                                                  <!-- <div class="col-sm-6"> -->
                                                  <div class="col-sm-2">
                                                    <label class="mb-2 mr-sm-2" id="fontslabel" for=""><b>วันที่ผลิตเสร็จ :</b></label>
                                                  </div>
                                                  <div class="col-sm-3">
                                                    <input type="text" class="form-control mb-2 mr-sm-2" name="datein" id="datein"  value="<?php echo date('Y-m-d');?>" readonly>
                                                  </div>
                                                  <!-- </div> -->
                                                </div>
                                                <br>
                                                <div class="row" >
                                                  <!-- <div class="col-sm-6"> -->
                                                  <div class="col-sm-2">
                                                    <label class="mb-2 mr-sm-2" id="fontslabel" for=""><b>Lot :</b></label>
                                                  </div>
                                                  <div class="col-sm-3">
                                                    <input type="text" class="form-control mb-2 mr-sm-2" name="LotShow" id="LotShow"   readonly>
                                                  </div>
                                                  <!-- </div> -->
                                                </div>
                                                <br>
                                                <br>
                                                <!-- Button to Open the Modal -->
                                                <div>
                                                  <button type="button" class="btn btn-primary" onclick="addrow()"   style="float: right;margin: 0px 12px 10px 10px;" >
                                                    <i class="fas fa-plus">
                                                      <fonts id="fontscontent">เพิ่มข้อมูลสินค้าผลิต
                                                    </i>
                                                  </button>
                                                </div>
                                                <table class="table table-bordered table-hover">
                                                  <thead>
                                                  <tr>
                                                  <th style="width: 25%;">รายการ</th>
                                                  <th>ผลิตได้</th>
                                                  <th>ราคาทุนต่อวัตถุดิบ</th>
                                                  <th>ต้นทุนวัตถุดิบที่ใช้</th>
                                                  <th>เงินเดือน/่ค่าแรงพนักงานผลิต</th>
                                                  <th>รวมต้นทุนผลิต</th>
                                                  <th>ต้นทุนผลิตต่อหน่วย</th>

                                                  </tr>
                                                  </thead>
                                                  <tbody id="addrowtb">
                                                    <tr>
                                                    <td style="width: 25%;">
                                                          <?php
                                                          $connect1 = Connectdb::Databaseall();
                                                          $baseAc1 = $connect1['fsctaccount'];
                                                          $baseMan = $connect1['fsctmain'];
                                                            $sql2 = "SELECT $baseMan.material.*
                                                                    FROM $baseMan.material
                                                                    WHERE $baseMan.material.status != '99' ";
                                                            $getdatas = DB::select($sql2);
                                                          ?>
                                                          <select  class="form-control select2" name="material_id[]" onchange="calmapping(0)" id="mproduct0"  required>
                                                            <option value="" selected >เลือกสินค้า</option>
                                                            <?php foreach ($getdatas as $key => $value) {  ?>
                                                                <option value="<?php echo $value->id?>"  ><?php echo  $value->name;?></option>
                                                            <?php } ?>

                                                          </select>
                                                    </td>
                                                    <td><input type="text" class="form-control mb-2 mr-sm-2 pd" name="produce[]" id="produce0"   readonly></td>
                                                    <td><input type="text" class="form-control mb-2 mr-sm-2 ct" name="cost[]" id="cost0"   readonly></td>
                                                    <td><input type="text" class="form-control mb-2 mr-sm-2 tc" name="total_cost[]" id="total_cost0"   readonly></td>
                                                    <td><input type="text" class="form-control mb-2 mr-sm-2" name="saraly[]" id="saraly0"   readonly></td>
                                                    <td><input type="text" class="form-control mb-2 mr-sm-2 tpc" name="total_cost_produce[]" id="total_cost_produce0"   readonly></td>
                                                    <td><input type="text" class="form-control mb-2 mr-sm-2 cpu" name="cost_produce_unit[]" id="cost_produce_unit0"   readonly></td>

                                                    </tr>

                                                  </tbody>
                                                  <tr>
                                                  <th style="width: 25%;">รวม</th>
                                                  <td><input type="text" class="form-control mb-2 mr-sm-2"  id="produceshow" value="0"   readonly></td>
                                                  <td><input type="text" class="form-control mb-2 mr-sm-2"  id="costshow"  value="0"  readonly></td>
                                                  <td><input type="text" class="form-control mb-2 mr-sm-2"  id="total_costshow"  value="0"   readonly></td>
                                                  <td><input type="text" class="form-control mb-2 mr-sm-2"  id="saralyshow"  value="0"   readonly></td>
                                                  <td><input type="text" class="form-control mb-2 mr-sm-2"  id="total_cost_produceshow"   value="0"  readonly></td>
                                                  <td><input type="text" class="form-control mb-2 mr-sm-2"  id="cost_produce_unitshow"   value="0"  readonly></td>
                                                  </tr>
                                                </table>

                                      </div>

                                      <!-- Modal footer -->

                                      <div class="modal-footer">
                                        <a href="{{route('paycredit')}}">
                                      {!! Form::submit('บันทึก', ['class' => 'btn btn-success', 'style' => 'dispaly: inline']) !!}
                                        <button type="button" class="btn btn-warning" data-dismiss="modal">ยกเลิก</button>
                                        </a>
                                      </div>


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
          <input type="hidden" id="idappoved" value="">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" onclick="saveapprovedrecstatus();">Save</button>
        </div>
      </div>
    </div>
  </div>


  <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script> -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  <script type="text/javascript" src = 'js/accountjs/asset_product_tool.js'></script>
  <script>
      $(document).ready(function() {
      $('#example').DataTable();
      } );
  </script>

  <script type="text/javascript">
  $('#search').on('keyup',function(){
  $value=$(this).val();
  $.ajax({
  type : 'get',
  url : '{{URL::to('search')}}',
  data:{'search':$value},
  success:function(data){
  $('tbody').html(data);
  }
  });
  })
  </script>

  <script type="text/javascript">
  $.ajaxSetup({ headers: { 'csrftoken' : '{{ csrf_token() }}' } });
  </script>



@endsection
