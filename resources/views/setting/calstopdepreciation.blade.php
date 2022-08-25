<?php
use App\Api\Connectdb;
use App\Api\Datetime;
?>
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
                                  <li class="breadcrumb-item active">หยุดคิดค่าเสืื่อมราคา</li>
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
                            <fonts id="fontsheader">หยุดคิดค่าเสืื่อมราคา</fonts>
                          </h3>
                        </div>
                        </div><!-- end card-->
                        <form action="searchtypecalstoppreciation" method="post" id="myForm" files='true' >
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="row">
                                  <div class="col-sm-3">
                                      <div class="input-group mb-6">
                                          <div class="input-group-prepend">
                                              <label id="fontslabel"><b>วันที่ : &nbsp;</b></label>
                                          </div>
                                          <input type="text" class="form-control" name="daterange" value="" autocomplete="off">
                                      </div>
                                  </div>
                                  <div class="col-sm-3">
                                      <div class="input-group mb-6">
                                          <label id="fontslabel"><b>เลือกชนิดใบขายสินค้า : &nbsp;</b></label>
                                          <select class="form-control" name="type" required>
                                              <option value="">เลือกชนิดใบขายสินค้า</option>
                                              <option value="1">ตัดหาย (RL) </option>
                                              <option value="2">ขายสินค้า (SS)</option>
                                          </select>
                                      </div>
                                  </div>
                                  <center><button type="submit" class="btn btn-primary btn-sm fontslabel">ค้นหา</button></center>&nbsp;
                        </form>
                              </div>
                                <br>
                                <?php

                                if(isset($type)){
                                  $connect1 = Connectdb::Databaseall();
                                  $dateset = Datetime::convertStartToEnd($daterange);
                                  $start = $dateset['start'];
                                  $end = $dateset['end'];

                                  $baseAc1 = $connect1['fsctaccount'];
                                  $baseMan = $connect1['fsctmain'];
                                    if($type==1){
                                       $sql1 = "SELECT $baseAc1.taxinvoice_loss_abb.*
                                              FROM $baseAc1.taxinvoice_loss_abb
                                              WHERE $baseAc1.taxinvoice_loss_abb.status != '99'
                                              AND $baseAc1.taxinvoice_loss_abb.time BETWEEN '$start' AND '$end' ";
                                    }else{
                                        $sql1 = "SELECT $baseMan.stock_sell_head.*
                                               FROM $baseMan.stock_sell_head
                                               WHERE $baseMan.stock_sell_head.status != '99'
                                               AND $baseMan.stock_sell_head.date_approved BETWEEN '$start' AND '$end'
                                               AND $baseMan.stock_sell_head.type = '3' ";
                                    }
                                      $getdatadetail = DB::select($sql1);


                                }

                                ?>
                                <div class="table-responsive">
                                  <table id="example" class="table table-striped table-bordered fontslabel" style="width:100%">
                                    <thead>
                                      <tr>
                                        <th>รหัสใบกำกับภาษี </th>
                                        <th>วันที่ออกใบ</th>
                                        <th>ยอดสุทธิ</th>
                                        <th>สถานะ</th>
                                        <th>อนุมัติ</th>
                                        <th>พิมพ์รายละเอียด</th>
                                      </tr>
                                    </thead>
                                    <<?php
                                    if(isset($type) && $type==1){
                                          foreach ($getdatadetail as $key => $value): ?>
                                      <tr>
                                        <td><?php echo $value->number_taxinvoice;?> </td>
                                        <td><?php echo $value->time;?></td>
                                        <td><?php echo $value->grandtotal;?></td>
                                        <td><?php
                                                $sqldetail = "SELECT $baseAc1.ref_sell_depreciationexpense.*
                                                     FROM $baseAc1.ref_sell_depreciationexpense
                                                     WHERE $baseAc1.ref_sell_depreciationexpense.status != '99'
                                                     AND $baseAc1.ref_sell_depreciationexpense.id_tax  = '$value->id'
                                                     AND  $baseAc1.ref_sell_depreciationexpense.type = '1' ";
                                              $getdatashow = DB::select($sqldetail);
                                                if(!empty($getdatashow)){    echo '<p style="color:blue">'.$getdatashow[0]->datestop.'</p>';  }else{    echo '<p style="color:red">ยังไม่มีข้อมูล</p>'; }
                                              ?>
                                        </td>
                                        <td><?php
                                                $sqldetail = "SELECT $baseAc1.ref_sell_depreciationexpense.*
                                                     FROM $baseAc1.ref_sell_depreciationexpense
                                                     WHERE $baseAc1.ref_sell_depreciationexpense.status != '99'
                                                     AND $baseAc1.ref_sell_depreciationexpense.id_tax  = '$value->id'
                                                     AND  $baseAc1.ref_sell_depreciationexpense.type = '1' ";
                                              $getdatashow = DB::select($sqldetail);
                                                if(!empty($getdatashow)){     }else{  ?>
                                                  <button type="button" class="btn btn-primary" data-toggle="modal" style="float: right;margin: 0px 12px 10px 10px;" data-target="#myModal" onclick="selecttax(<?php echo $value->id?>,1)">
                                                    <i class="fas fa-plus">
                                                      <fonts id="fontscontent">เพิ่มข้อมูล
                                                    </i>
                                                  </button>
                                                <?php } ?>
                                        </td>
                                        <td><a href="http://103.13.231.24/fsctmain/public/printtaxinvoicelossabb/<?php echo $value->id ?>" target="_blank"><img src="images/global/printall.png"></td>
                                      </tr>
                                    <?php endforeach; ?>
                                  <?php } else if(isset($type) && $type==2){ ?>
                                    <<?php foreach ($getdatadetail as $key => $value): ?>
                                      <tr>
                                        <td><?php echo $value->bill_no;?> </td>
                                        <td><?php echo $value->date_approved;?></td>
                                        <td><?php echo $value->grandtotal;?></td>
                                        <td><?php
                                                $sqldetail = "SELECT $baseAc1.ref_sell_depreciationexpense.*
                                                     FROM $baseAc1.ref_sell_depreciationexpense
                                                     WHERE $baseAc1.ref_sell_depreciationexpense.status != '99'
                                                     AND $baseAc1.ref_sell_depreciationexpense.id_tax  = '$value->id'
                                                     AND  $baseAc1.ref_sell_depreciationexpense.type = '2' ";
                                              $getdatashow = DB::select($sqldetail);
                                                if(!empty($getdatashow)){     echo '<p style="color:blue">'.$getdatashow[0]->datestop.'</p>';    }else{    echo '<p style="color:red">ยังไม่มีข้อมูล</p>'; } ?>
                                        </td>
                                        <td><?php
                                                $sqldetail = "SELECT $baseAc1.ref_sell_depreciationexpense.*
                                                     FROM $baseAc1.ref_sell_depreciationexpense
                                                     WHERE $baseAc1.ref_sell_depreciationexpense.status != '99'
                                                     AND $baseAc1.ref_sell_depreciationexpense.id_tax  = '$value->id'
                                                     AND  $baseAc1.ref_sell_depreciationexpense.type = '1' ";
                                              $getdatashow = DB::select($sqldetail);
                                                if(!empty($getdatashow)){      }else{  ?>
                                                  <button type="button" class="btn btn-primary" data-toggle="modal" style="float: right;margin: 0px 12px 10px 10px;" data-target="#myModal" onclick="selecttax(<?php echo $value->id?>,2)">
                                                    <i class="fas fa-plus">
                                                      <fonts id="fontscontent">เพิ่มข้อมูล
                                                    </i>
                                                  </button>
                                                <?php } ?>
                                         </td>
                                        <td><a href="http://103.13.231.24/fsctmain/public/printstocksell/<?php echo $value->id ?>" target="_blank"><img src="images/global/printall.png"></td>
                                      </tr>
                                    <?php endforeach; ?>
                                  <?php } ?>
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

                                          <form action="savedatestopdepreciation" method="post" id="myForm" files='true' >
                                          <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <input type="hidden" id="idref" name="idref" >
                                                <input type="hidden" id="typeref" name="typeref" >
                                                <div class="row" >
                                                  <!-- <div class="col-sm-6"> -->
                                                  <div class="col-sm-2">
                                                    <label class="mb-2 mr-sm-2" id="fontslabel" for=""><b>วันที่หยุดคิดค่าเสื่อม :</b></label>
                                                  </div>
                                                  <div class="col-sm-3">
                                                    <input type="date" class="form-control mb-2 mr-sm-2" name="datestop" id="datestop"  value="<?php echo date('Y-m-d');?>" >
                                                  </div>
                                                  <!-- </div> -->
                                                </div>
                                                <div class="row" >
                                                  {!! Form::submit('บันทึก', ['class' => 'btn btn-success', 'style' => 'dispaly: inline']) !!}
                                                    <button type="button" class="btn btn-warning" data-dismiss="modal">ยกเลิก</button>

                                                </div>
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
  <script type="text/javascript" src = 'js/accountjs/calstopdepreciation.js'></script>
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
