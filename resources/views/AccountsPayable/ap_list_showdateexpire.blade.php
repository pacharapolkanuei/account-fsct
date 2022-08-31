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
              <div class="col-sm-3">
                  <div class="input-group mb-6">
                      <div class="input-group-prepend">
                          <label id="fontslabel"><b>วันที่ : &nbsp;</b></label>
                      </div>
                      <input type='date' class="form-control" name="daterange" value="" autocomplete="off" />
                  </div>
              </div>
              <button type="submit" class="btn btn-primary btn-sm fontslabel">ค้นหา</button>
            </center>
          {!! Form::close() !!}

        </div>
      </div>
      <!-- end row -->
    </div>
    <!-- END container-fluid -->
  </div>
  <!-- END content -->
  <br>
  <br>
  <center>
    <?php if (isset($start) && isset($end)): ?>
      <label id="fontslabel"><b>วันที่ <?php echo $start ?></b></label>
    <?php endif; ?>
  </center>
  <br>


</div>
<!-- END content-page -->
<!-- END main -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
@endsection
