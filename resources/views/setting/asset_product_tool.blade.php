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

                                $sql1 = "SELECT $baseMan.goods_to_material_head.*,
                                                $baseMan.material.name
                                        FROM $baseMan.goods_to_material_head
                                        INNER JOIN $baseMan.material
                                        ON $baseMan.material.id = $baseMan.goods_to_material_head.material_id
                                        WHERE $baseMan.goods_to_material_head.status = '1' ";
                                $gethead = DB::select($sql1);
                                //print_r($getdatas);
                                ?>
                                <div class="table-responsive">
                                  <table id="example" class="table table-striped table-bordered fontslabel" style="width:100%">
                                    <thead>
                                      <tr>
                                        <th>Material </th>
                                        <th>วัตถุดิบ</th>
                                      </tr>
                                    </thead>


                                    <tbody>
                                    <?php if(!empty($gethead)){?>
                                      <?php foreach ($gethead as $key => $value) {?>
                                        <tr>
                                          <th><?php echo $value->name;?> </th>
                                          <th>
                                            <table class="table table-bordered table-hover">
                                              <thead>
                                              <tr>
                                                <th style="width: 25%;">ชื่อวัตถุดิบ</th>
                                                <th>กี่เมตร</th>
                                                <th>ราคาต่อเมตร</th>
                                                <th>รวมต้นทุน/ชิ้น</th>
                                              </tr>
                                                <tbody>
                                                    <?php
                                                        $a = 0;
                                                        $b = 0 ;
                                                        $c = 0;
                                                        $sql1 = "SELECT $baseMan.goods_to_material_detail.*,
                                                                      $baseAc1.good.name
                                                              FROM $baseMan.goods_to_material_detail
                                                              INNER JOIN $baseAc1.good
                                                              ON $baseMan.goods_to_material_detail.goodsid = $baseAc1.good.id
                                                              WHERE $baseMan.goods_to_material_detail.goods_to_material_head_id = '$value->id' ";
                                                      $getheaddetail = DB::select($sql1);
                                                    ?>
                                                    <?php foreach ($getheaddetail as $k => $v):
                                                        $a = $a + $v->amountpermeet;
                                                        $b = $b + $v->pricepermeet;
                                                        $c = $c + $v->totalthis;
                                                      ?>
                                                    <tr>
                                                      <td style="width: 25%;"><?php echo $v->name;?></td>
                                                      <td><?php echo $v->amountpermeet;?></td>
                                                      <td><?php echo $v->pricepermeet;?></td>
                                                      <td><?php echo $v->totalthis;?></td>
                                                    </tr>
                                                    <?php endforeach; ?>
                                                    <tr>
                                                      <th style="width: 25%;">รวม</th>
                                                      <th><?php echo $a;?></th>
                                                      <th><?php echo $b;?></th>
                                                      <th><?php echo $c;?></th>
                                                    </tr>
                                                </tbody>
                                              </thead>
                                            </table>
                                          </th>
                                        </tr>
                                      <?php } ?>
                                    <?php } ?>
                                    </tbody>
                                  </table><br>
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
                                                  <th>ลบ</th>
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
                                                    <td><input type="text" class="form-control mb-2 mr-sm-2" name="produce[]" id="produce0"   readonly></td>
                                                    <td><input type="text" class="form-control mb-2 mr-sm-2" name="cost[]" id="cost0"   readonly></td>
                                                    <td><input type="text" class="form-control mb-2 mr-sm-2" name="total_cost[]" id="total_cost0"   readonly></td>
                                                    <td><input type="text" class="form-control mb-2 mr-sm-2" name="saraly[]" id="saraly0"   readonly></td>
                                                    <td><input type="text" class="form-control mb-2 mr-sm-2" name="total_cost_produce[]" id="total_cost_produce0"   readonly></td>
                                                    <td><input type="text" class="form-control mb-2 mr-sm-2" name="cost_produce_unit[]" id="cost_produce_unit0"   readonly></td>
                                                    <td></td>
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


  <!-- MODAL edit -->

  <div class="modal fade" id="modaledit">
      <div class="modal-dialog modal-lg">
          <div class="modal-content">

              <!-- Modal Header -->
              <div class="modal-header">
                <h4 class="modal-title" id="fontscontent2"><b>รายการทรัพย์สิน</b></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>

                <!-- Modal body -->
                <div class="modal-body">

                    {{ csrf_field() }}


              </div>
              <!-- Modal footer -->
              <div class="modal-footer">
                  <a href="{{route('asset_list')}}">
                      <input type="submit" class="btn btn-success" style="display: inline" id="button-submit-edit" value="บันทึก">
                      <button type="button" class="btn btn-warning" data-dismiss="modal">ยกเลิก</button>
                  </a>
              </div>


          </div>
      </div>
  </div>

  <!-- end iditmodal -->


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
