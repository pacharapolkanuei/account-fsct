<?php

use  App\Api\Connectdb;
use  App\Api\Accountcenter;
use  App\Api\Maincenter;
use  App\Api\Vendorcenter;
use  App\Api\DateTime;

?>

@extends('index')
@section('content')

<?php
  $level_id = Session::get('level_id');
  // echo $level_id;
?>

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

<style media="screen">
  tr.group,
  tr.group:hover {
    background-color: #ddd !important;
  }
</style>
<script type="text/javascript">
  $(function() {
      $('input[name="daterange"]').daterangepicker();
  });
</script>


<div class="content-page">
  <!-- Start content -->
  <div class="content">
    <div class="container-fluid">

      <div class="row">
        <div class="col-xl-12">
          <div class="breadcrumb-holder" id="fontscontent">
            <h1 class="float-left">Account - FSCT</h1>
            <ol class="breadcrumb float-right">
              <li class="breadcrumb-item">เจ้าหนี้การค้า</li>
              <li class="breadcrumb-item active">รายงานวิเคราะห์อายุหนี้ แยกตามลูกหนี้</li>
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
                <fonts id="fontsheader">รายงานวิเคราะห์อายุหนี้ แยกตามลูกหนี้</fonts>
              </h3>
            </div>
          </div><!-- end card-->

          {!! Form::open(['route' => 'ap_list_showdateexpire_filter', 'method' => 'post']) !!}
            <center>
              <div class="col-sm-4">
                  <div class="input-group mb-6">
                      <div class="input-group-prepend">
                          <label id="fontslabel"><b>ณ วันที่ : &nbsp;</b></label>
                      </div>
                      <input type='date' class="form-control" name="dateend" value="" autocomplete="off" />
                  </div>
              </div>
              <br>

              <?php if (isset($datas)): ?>
              <div class="col-sm-4">
                  <div class="input-group mb-6">
                      <div class="input-group-prepend">
                          <label id="fontslabel"><b>รหัสเจ้าหนี้ : &nbsp;</b></label>
                      </div>
                      <select class="form-control select2" id="example3" name="ap_list[]" multiple="multiple">
                        <optgroup label="เจ้าหนี้การค้า">
                          @foreach ($datas as $key => $data)
                            @if ($data->type_pay === 1)
                              <option value="{{$data->id_supplier_ref}}">{{$data->pre1}} {{$data->name1}}</option>
                            @endif
                          @endforeach
      									<optgroup>
      									<optgroup label="เจ้าหนี้การค้าอื่นๆ">
                          @foreach ($datas as $key => $data)
                            @if ($data->type_pay === 2)
                              <option value="{{$data->id_supplier_ref}}">{{$data->pre1}} {{$data->name1}}</option>
                            @endif
                          @endforeach
      									<optgroup>
      								</select>
                  </div>
              </div>
              <?php endif; ?>




              <button type="submit" class="btn btn-primary btn-sm fontslabel">ค้นหา</button>
              <a href="{{url('ap_list_showdateexpire')}}" class="btn btn-danger btn-md delete-confirm">RESET</a>
            </center>
          {!! Form::close() !!}

          <br>
          <br>
          <center>
            <?php if (isset($dateend)): ?>
              <label id="fontslabel"><b>วันที่ดึงรายงาน</b> <?php echo $dateend ?></label>
            <?php endif; ?>
          </center>
          <br>

          <?php if (isset($arrShow)): ?>
            <table class="table table-bordered" cellspacing="0" id="fontslabel" style="margin-left: auto;margin-right: auto;">
              <thead>
                <tr style="background-color:#aab6c2;color:white;">
                  <th rowspan="2" style="vertical-align : middle;text-align:center;">รหัส</th>
                  <th rowspan="2" style="vertical-align : middle;text-align:center;">ชื่อลูกหนี้</th>
                  <th rowspan="2" style="vertical-align : middle;text-align:center;">เครดิต (วัน)</th>
                  <th rowspan="2" style="vertical-align : middle;text-align:center;">ยอดคงค้าง</th>
                  <th colspan="4" style="vertical-align : middle;text-align:center;">จะครบกำหนด</th>
                  <th colspan="4" style="vertical-align : middle;text-align:center;">เกินกำหนด</th>
                  <th rowspan="2" style="vertical-align : middle;text-align:center;">รวมยอดหนี้</th>
                </tr>
                <tr>
                  <th scope="col" style="vertical-align : middle;text-align:center;">ภายใน 15 วัน</th>
                  <th scope="col" style="vertical-align : middle;text-align:center;">ภายใน 30 วัน</th>
                  <th scope="col" style="vertical-align : middle;text-align:center;">ภายใน 60 วัน</th>
                  <th scope="col" style="vertical-align : middle;text-align:center;">เกิน 60 วัน</th>
                  <th scope="col" style="vertical-align : middle;text-align:center;">1-7 วัน</th>
                  <th scope="col" style="vertical-align : middle;text-align:center;">8-15 วัน</th>
                  <th scope="col" style="vertical-align : middle;text-align:center;">16-30 วัน</th>
                  <th scope="col" style="vertical-align : middle;text-align:center;">เกิน 30 วัน</th>
                </tr>
              </thead>
              <tbody style="vertical-align : middle;text-align:center;">
                @foreach ($arrShow as $key => $show_data)
                  <tr>
                    <td>{{ $show_data->codecreditor }}</td>
                    <td>{{ $show_data->pre }} {{ $show_data->name_supplier }}</td>
                    <td>{{ $show_data->day_tocal }}</td>
                    <td>
                      <?php $keep_totalsum = number_format($show_data->totalsum,2,".",",");
                            echo $keep_totalsum;
                      ?>
                    </td>
                    <td>{{ $show_data->daterang1 }}</td>
                    <td>{{ $show_data->daterang2 }}</td>
                    <td>{{ $show_data->daterang3 }}</td>
                    <td>{{ $show_data->daterang4 }}</td>
                    <td>{{ $show_data->daterang5 }}</td>
                    <td>{{ $show_data->daterang6 }}</td>
                    <td>{{ $show_data->daterang7 }}</td>
                    <td>{{ $show_data->daterang8 }}</td>
                    <td>
                      <?php $keep_totalsum = number_format($show_data->totalsum,2,".",",");
                            echo $keep_totalsum;
                      ?>
                  </tr>
                @endforeach
              </tbody>
            </table>

          <?php endif; ?>




        </div>
      </div>
      <!-- end row -->
    </div>
    <!-- END container-fluid -->
  </div>
  <!-- END content -->
</div>
<!-- END content-page -->
<!-- END main -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script>
$(document).ready(function() {
    $('.select2').select2();
});
</script>
<script type="text/javascript" src = 'js/accountjs/buysteel.js'></script>
@endsection
