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
              <li class="breadcrumb-item active">รายงานเจ้าหนี้การค้า</li>
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
                <fonts id="fontsheader">รายงานเจ้าหนี้การค้า</fonts>
              </h3>
            </div>
          </div><!-- end card-->

          {!! Form::open(['route' => 'ap_list_filter', 'method' => 'post']) !!}
            <center>
              <div class="col-sm-3">
                  <div class="input-group mb-6">
                      <div class="input-group-prepend">
                          <label id="fontslabel"><b>วันที่ : &nbsp;</b></label>
                      </div>
                      <input type='text' class="form-control" name="daterange" value="" autocomplete="off" />
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
      <label id="fontslabel"><b>วันที่จาก <?php echo $start ?> ถึง <?php echo $end ?></b></label>
    <?php endif; ?>
  </center>
  <br>

            <?php if (isset($supplier_aps) && isset($supplier_informs)): ?>
              <table class="table table-bordered" cellspacing="0" id="fontsjournal">
                <thead>
                    <tr style="background-color:#aab6c2;color:white;">
                        <th scope="col">วันที่</th>
                        <th scope="col">เลขที่เอกสาร</th>
                        <th scope="col">เพิ่มขึ้น</th>
                        <th scope="col">ลดลง</th>
                        <th scope="col">ยอดคงเหลือ</th>
                    </tr>
                </thead>
                <tbody>
                  @foreach ($supplier_aps  as $key => $supplier_ap)
                    @if ($supplier_ap->name_suplier == $ap)
                    <!-- ถ้า ap เหมือนกันเขียนแค่ list -->
                      <tr>
                          <td>{{ $supplier_ap->date_po }}</td>
                          <td>{{ $supplier_ap->po_number_use }}</td>
                          <td>{{ $supplier_ap->date_po }}</td>
                          <td></td>
                          <td>{{ $supplier_ap->date_po }}</td>
                      </tr>

                      <tr>
                          <td>{{ $supplier_ap->date_inform_po }}</td>
                          <td>{{ $supplier_ap->date_inform_po }}</td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                      </tr>

                      @if ($key == count($databillengines)-1)
                      <!-- เขียนสำหรับรายการสุดท้าย -->
                          <tr>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td><b>
                                <?php if ($databillengine->vat == 1.00 && $databillengine->discount == 0.00 && $databillengine->withhold == 0.00) {
                                  $vatshow = $databillengine->cal_total/1.01;
                                    echo number_format($vatshow, 2, '.', ''); ?>
                                <?php }elseif ($databillengine->vat == 3.00 && $databillengine->discount == 0.00 && $databillengine->withhold == 0.00) {
                                    $vatshow = $databillengine->cal_total/1.03;
                                      echo number_format($vatshow, 2, '.', ''); ?>
                                <?php }elseif ($databillengine->vat == 5.00 && $databillengine->discount == 0.00 && $databillengine->withhold == 0.00) {
                                    $vatshow = $databillengine->cal_total/1.05;
                                      echo number_format($vatshow, 2, '.', ''); ?>
                                <?php }elseif ($databillengine->vat == 7.00 && $databillengine->discount == 0.00 && $databillengine->withhold == 0.00) {
                                    $vatshow = $databillengine->cal_total/1.07;
                                      echo number_format($vatshow, 2, '.', ''); ?>

                                <?php }elseif ($databillengine->vat == 0.00 && $databillengine->discount >= 1.00 && $databillengine->withhold == 0.00) {
                                    $discount_show = $databillengine->discount/100;
                                    $totalforsum = $databillengine->cal_total - $discount_show;
                                      echo number_format($totalforsum, 2, '.', ''); ?>

                                <?php }elseif ($databillengine->vat == 7.00 && $databillengine->discount >= 0.01 && $databillengine->withhold == 0.00) {
                                        $discount_show = $databillengine->discount/100;
                                        $discount_show1 = 1.00 - $discount_show;
                                        $valuetotal = $databillengine->cal_total;
                                        $vatsum = 100/107;
                                        $totalforsum = ($valuetotal*$vatsum)/$discount_show1;
                                      echo number_format($totalforsum, 2, '.', ''); ?>
                                <?php }elseif ($databillengine->vat == 7.00 && $databillengine->discount == 0.00 && $databillengine->withhold == 3.00) {
                                        $vatshow = $databillengine->cal_total;
                                        $vatshow1 = 100/104;
                                        $vatshow_final = $vatshow*$vatshow1;
                                      echo number_format($vatshow_final, 2, '.', ''); ?>
                                <?php }elseif ($databillengine->vat == 7.00 && $databillengine->discount == 0.00 && $databillengine->withhold == 5.00) {
                                        $vatshow = $databillengine->cal_total;
                                        $vatshow1 = 100/102;
                                        $vatshow_final = $vatshow*$vatshow1;
                                      echo number_format($vatshow_final, 2, '.', ''); ?>

                                <?php }elseif ($databillengine->vat == 7.00 && $databillengine->discount >= 0.01 && $databillengine->withhold == 3.00) {
                                        $discount_show = $databillengine->discount/100;
                                        $discount_show1 = 1.00 - $discount_show;
                                        $vatshow = $databillengine->cal_total;
                                        $vatshow1 = 100/104;
                                        $vatshow_final = ($vatshow*$vatshow1)/$discount_show1;
                                      echo number_format($vatshow_final, 2, '.', ''); ?>

                                <?php }elseif ($databillengine->vat == 7.00 && $databillengine->discount >= 0.01 && $databillengine->withhold == 5.00) {
                                        $discount_show = $databillengine->discount/100;
                                        $discount_show1 = 1.00 - $discount_show;
                                        $vatshow = $databillengine->cal_total;
                                        $vatshow1 = 100/102;
                                        $vatshow_final = ($vatshow*$vatshow1)/$discount_show1;
                                      echo number_format($vatshow_final, 2, '.', ''); ?>
                                <?php }else{
                                    $vatshow = $databillengine->cal_total;
                                      echo number_format($vatshow, 2, '.', ''); ?>
                                <?php } ?>
                              </b></td>
                              <td><b>
                                <?php if ($databillengine->vat == 1.00 && $databillengine->discount == 0.00 && $databillengine->withhold == 0.00) {
                                  $vatshow = $databillengine->cal_total/1.01;
                                    echo number_format($vatshow, 2, '.', ''); ?>
                                <?php }elseif ($databillengine->vat == 3.00 && $databillengine->discount == 0.00 && $databillengine->withhold == 0.00) {
                                    $vatshow = $databillengine->cal_total/1.03;
                                      echo number_format($vatshow, 2, '.', ''); ?>
                                <?php }elseif ($databillengine->vat == 5.00 && $databillengine->discount == 0.00 && $databillengine->withhold == 0.00) {
                                    $vatshow = $databillengine->cal_total/1.05;
                                      echo number_format($vatshow, 2, '.', ''); ?>
                                <?php }elseif ($databillengine->vat == 7.00 && $databillengine->discount == 0.00 && $databillengine->withhold == 0.00) {
                                    $vatshow = $databillengine->cal_total/1.07;
                                      echo number_format($vatshow, 2, '.', ''); ?>

                                <?php }elseif ($databillengine->vat == 0.00 && $databillengine->discount >= 1.00 && $databillengine->withhold == 0.00) {
                                    $discount_show = $databillengine->discount/100;
                                    $totalforsum = $databillengine->cal_total - $discount_show;
                                      echo number_format($totalforsum, 2, '.', ''); ?>

                                <?php }elseif ($databillengine->vat == 7.00 && $databillengine->discount >= 0.01 && $databillengine->withhold == 0.00) {
                                        $discount_show = $databillengine->discount/100;
                                        $discount_show1 = 1.00 - $discount_show;
                                        $valuetotal = $databillengine->cal_total;
                                        $vatsum = 100/107;
                                        $totalforsum = ($valuetotal*$vatsum)/$discount_show1;
                                      echo number_format($totalforsum, 2, '.', ''); ?>
                                <?php }elseif ($databillengine->vat == 7.00 && $databillengine->discount == 0.00 && $databillengine->withhold == 3.00) {
                                        $vatshow = $databillengine->cal_total;
                                        $vatshow1 = 100/104;
                                        $vatshow_final = $vatshow*$vatshow1;
                                      echo number_format($vatshow_final, 2, '.', ''); ?>
                                <?php }elseif ($databillengine->vat == 7.00 && $databillengine->discount == 0.00 && $databillengine->withhold == 5.00) {
                                        $vatshow = $databillengine->cal_total;
                                        $vatshow1 = 100/102;
                                        $vatshow_final = $vatshow*$vatshow1;
                                      echo number_format($vatshow_final, 2, '.', ''); ?>

                                <?php }elseif ($databillengine->vat == 7.00 && $databillengine->discount >= 0.01 && $databillengine->withhold == 3.00) {
                                        $discount_show = $databillengine->discount/100;
                                        $discount_show1 = 1.00 - $discount_show;
                                        $vatshow = $databillengine->cal_total;
                                        $vatshow1 = 100/104;
                                        $vatshow_final = ($vatshow*$vatshow1)/$discount_show1;
                                      echo number_format($vatshow_final, 2, '.', ''); ?>

                                <?php }elseif ($databillengine->vat == 7.00 && $databillengine->discount >= 0.01 && $databillengine->withhold == 5.00) {
                                        $discount_show = $databillengine->discount/100;
                                        $discount_show1 = 1.00 - $discount_show;
                                        $vatshow = $databillengine->cal_total;
                                        $vatshow1 = 100/102;
                                        $vatshow_final = ($vatshow*$vatshow1)/$discount_show1;
                                      echo number_format($vatshow_final, 2, '.', ''); ?>
                                <?php }else{
                                    $vatshow = $databillengine->cal_total;
                                      echo number_format($vatshow, 2, '.', ''); ?>
                                <?php } ?>
                              </b></td>
                          </tr>
                      @endif

                    @else
                    <!-- เปลี่ยนรายการ -->
                      @if ($key != 0)
                          <!-- ก่อนเปลี่ยนรายการเขียนปิดรายการก่อนหน้า -->
                          <tr>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td><b>
                                <?php if ($databillengines[$key-1]->vat == 1.00 && $databillengines[$key-1]->discount == 0.00 && $databillengines[$key-1]->withhold == 0.00) {
                                  $vatshow = $databillengines[$key-1]->cal_total/1.01;
                                    echo number_format($vatshow, 2, '.', ''); ?>
                                <?php }elseif ($databillengines[$key-1]->vat == 3.00 && $databillengines[$key-1]->discount == 0.00 && $databillengines[$key-1]->withhold == 0.00) {
                                    $vatshow = $databillengines[$key-1]->cal_total/1.03;
                                      echo number_format($vatshow, 2, '.', ''); ?>
                                <?php }elseif ($databillengines[$key-1]->vat == 5.00 && $databillengines[$key-1]->discount == 0.00 && $databillengines[$key-1]->withhold == 0.00) {
                                    $vatshow = $databillengines[$key-1]->cal_total/1.05;
                                      echo number_format($vatshow, 2, '.', ''); ?>
                                <?php }elseif ($databillengines[$key-1]->vat == 7.00 && $databillengines[$key-1]->discount == 0.00 && $databillengines[$key-1]->withhold == 0.00) {
                                    $vatshow = $databillengines[$key-1]->cal_total/1.07;
                                      echo number_format($vatshow, 2, '.', ''); ?>

                                <?php }elseif ($databillengines[$key-1]->vat == 0.00 && $databillengines[$key-1]->discount >= 1.00 && $databillengines[$key-1]->withhold == 0.00) {
                                    $discount_show = $databillengines[$key-1]->discount/100;
                                    $totalforsum = $databillengines[$key-1]->cal_total - $discount_show;
                                      echo number_format($totalforsum, 2, '.', ''); ?>

                                <?php }elseif ($databillengines[$key-1]->vat == 7.00 && $databillengines[$key-1]->discount >= 0.01 && $databillengines[$key-1]->withhold == 0.00) {
                                        $discount_show = $databillengines[$key-1]->discount/100;
                                        $discount_show1 = 1.00 - $discount_show;
                                        $valuetotal = $databillengines[$key-1]->cal_total;
                                        $vatsum = 100/107;
                                        $totalforsum = ($valuetotal*$vatsum)/$discount_show1;
                                      echo number_format($totalforsum, 2, '.', ''); ?>
                                <?php }elseif ($databillengines[$key-1]->vat == 7.00 && $databillengines[$key-1]->discount == 0.00 && $databillengines[$key-1]->withhold == 3.00) {
                                        $vatshow = $databillengines[$key-1]->cal_total;
                                        $vatshow1 = 100/104;
                                        $vatshow_final = $vatshow*$vatshow1;
                                      echo number_format($vatshow_final, 2, '.', ''); ?>
                                <?php }elseif ($databillengines[$key-1]->vat == 7.00 && $databillengines[$key-1]->discount == 0.00 && $databillengines[$key-1]->withhold == 5.00) {
                                        $vatshow = $databillengines[$key-1]->cal_total;
                                        $vatshow1 = 100/102;
                                        $vatshow_final = $vatshow*$vatshow1;
                                      echo number_format($vatshow_final, 2, '.', ''); ?>

                                <?php }elseif ($databillengines[$key-1]->vat == 7.00 && $databillengines[$key-1]->discount >= 0.01 && $databillengines[$key-1]->withhold == 3.00) {
                                        $discount_show = $databillengines[$key-1]->discount/100;
                                        $discount_show1 = 1.00 - $discount_show;
                                        $vatshow = $databillengines[$key-1]->cal_total;
                                        $vatshow1 = 100/104;
                                        $vatshow_final = ($vatshow*$vatshow1)/$discount_show1;
                                      echo number_format($vatshow_final, 2, '.', ''); ?>

                                <?php }elseif ($databillengines[$key-1]->vat == 7.00 && $databillengines[$key-1]->discount >= 0.01 && $databillengines[$key-1]->withhold == 5.00) {
                                        $discount_show = $databillengines[$key-1]->discount/100;
                                        $discount_show1 = 1.00 - $discount_show;
                                        $vatshow = $databillengines[$key-1]->cal_total;
                                        $vatshow1 = 100/102;
                                        $vatshow_final = ($vatshow*$vatshow1)/$discount_show1;
                                      echo number_format($vatshow_final, 2, '.', ''); ?>
                                <?php }else{
                                    $vatshow = $databillengines[$key-1]->cal_total;
                                      echo number_format($vatshow, 2, '.', ''); ?>
                                <?php } ?>
                              </b></td>
                              <td><b>
                                <?php if ($databillengines[$key-1]->vat == 1.00 && $databillengines[$key-1]->discount == 0.00 && $databillengines[$key-1]->withhold == 0.00) {
                                  $vatshow = $databillengines[$key-1]->cal_total/1.01;
                                    echo number_format($vatshow, 2, '.', ''); ?>
                                <?php }elseif ($databillengines[$key-1]->vat == 3.00 && $databillengines[$key-1]->discount == 0.00 && $databillengines[$key-1]->withhold == 0.00) {
                                    $vatshow = $databillengines[$key-1]->cal_total/1.03;
                                      echo number_format($vatshow, 2, '.', ''); ?>
                                <?php }elseif ($databillengines[$key-1]->vat == 5.00 && $databillengines[$key-1]->discount == 0.00 && $databillengines[$key-1]->withhold == 0.00) {
                                    $vatshow = $databillengines[$key-1]->cal_total/1.05;
                                      echo number_format($vatshow, 2, '.', ''); ?>
                                <?php }elseif ($databillengines[$key-1]->vat == 7.00 && $databillengines[$key-1]->discount == 0.00 && $databillengines[$key-1]->withhold == 0.00) {
                                    $vatshow = $databillengines[$key-1]->cal_total/1.07;
                                      echo number_format($vatshow, 2, '.', ''); ?>

                                <?php }elseif ($databillengines[$key-1]->vat == 0.00 && $databillengines[$key-1]->discount >= 1.00 && $databillengines[$key-1]->withhold == 0.00) {
                                    $discount_show = $databillengines[$key-1]->discount/100;
                                    $totalforsum = $databillengines[$key-1]->cal_total - $discount_show;
                                      echo number_format($totalforsum, 2, '.', ''); ?>

                                <?php }elseif ($databillengines[$key-1]->vat == 7.00 && $databillengines[$key-1]->discount >= 0.01 && $databillengines[$key-1]->withhold == 0.00) {
                                        $discount_show = $databillengines[$key-1]->discount/100;
                                        $discount_show1 = 1.00 - $discount_show;
                                        $valuetotal = $databillengines[$key-1]->cal_total;
                                        $vatsum = 100/107;
                                        $totalforsum = ($valuetotal*$vatsum)/$discount_show1;
                                      echo number_format($totalforsum, 2, '.', ''); ?>
                                <?php }elseif ($databillengines[$key-1]->vat == 7.00 && $databillengines[$key-1]->discount == 0.00 && $databillengines[$key-1]->withhold == 3.00) {
                                        $vatshow = $databillengines[$key-1]->cal_total;
                                        $vatshow1 = 100/104;
                                        $vatshow_final = $vatshow*$vatshow1;
                                      echo number_format($vatshow_final, 2, '.', ''); ?>
                                <?php }elseif ($databillengines[$key-1]->vat == 7.00 && $databillengines[$key-1]->discount == 0.00 && $databillengines[$key-1]->withhold == 5.00) {
                                        $vatshow = $databillengines[$key-1]->cal_total;
                                        $vatshow1 = 100/102;
                                        $vatshow_final = $vatshow*$vatshow1;
                                      echo number_format($vatshow_final, 2, '.', ''); ?>

                                <?php }elseif ($databillengines[$key-1]->vat == 7.00 && $databillengines[$key-1]->discount >= 0.01 && $databillengines[$key-1]->withhold == 3.00) {
                                        $discount_show = $databillengines[$key-1]->discount/100;
                                        $discount_show1 = 1.00 - $discount_show;
                                        $vatshow = $databillengines[$key-1]->cal_total;
                                        $vatshow1 = 100/104;
                                        $vatshow_final = ($vatshow*$vatshow1)/$discount_show1;
                                      echo number_format($vatshow_final, 2, '.', ''); ?>

                                <?php }elseif ($databillengines[$key-1]->vat == 7.00 && $databillengines[$key-1]->discount >= 0.01 && $databillengines[$key-1]->withhold == 5.00) {
                                        $discount_show = $databillengines[$key-1]->discount/100;
                                        $discount_show1 = 1.00 - $discount_show;
                                        $vatshow = $databillengines[$key-1]->cal_total;
                                        $vatshow1 = 100/102;
                                        $vatshow_final = ($vatshow*$vatshow1)/$discount_show1;
                                      echo number_format($vatshow_final, 2, '.', ''); ?>
                                <?php }else{
                                    $vatshow = $databillengines[$key-1]->cal_total;
                                      echo number_format($vatshow, 2, '.', ''); ?>
                                <?php } ?>
                              </b></td>
                          </tr>
                      @endif

                    <tr style="border-top-style:solid;">
                        <!-- เขียน row แรก แต่ละรายการ -->
                        <td>
                            @if($databillengine->accept == 0)
                            <label class="con">
                            <input type="checkbox" name="id_journal_5[]" value="{{$databillengine->id_engine}}">
                                <span class="checkmark"></span>
                            </label>
                            @else
                            <i class="fa fa-check" style="color:green;font-size:20px;"></i>
                            @endif
                        </td>
                        <td>{{$databillengine->date_req_rent}}</td>
                        <td>{{$databillengine->billengine_rent}}</td>
                        <td>เครื่องมือให้เช่า {{$databillengine->name_engine}}</td>
                        <td>ขึ้นเครื่องมือให้เช่าลูกค้า {{$databillengine->name}} {{$databillengine->lastname}}</td>
                        <td>151901</td>
                        <td style="text-align:left;">เครื่องมือให้เช่าลูกค้า {{$databillengine->name}} {{$databillengine->lastname}}</td>
                        <td>{{$databillengine->branch_id}}</td>
                        <td>{{$databillengine->last_total}}</td>
                        <td></td>
                    </tr>

                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>151900</td>
                        <td style="text-align:center;">เครื่องมือให้เช่า {{$databillengine->name_engine}}</td>
                        <td></td>
                        <td></td>
                        <td>{{$databillengine->last_total}}</td>
                    </tr>

                    @if ($key == count($databillengines)-1)
                    <!-- เขียนสำหรับรายการสุดท้าย -->
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><b>
                              <?php if ($databillengine->vat == 1.00 && $databillengine->discount == 0.00 && $databillengine->withhold == 0.00) {
                                $vatshow = $databillengine->cal_total/1.01;
                                  echo number_format($vatshow, 2, '.', ''); ?>
                              <?php }elseif ($databillengine->vat == 3.00 && $databillengine->discount == 0.00 && $databillengine->withhold == 0.00) {
                                  $vatshow = $databillengine->cal_total/1.03;
                                    echo number_format($vatshow, 2, '.', ''); ?>
                              <?php }elseif ($databillengine->vat == 5.00 && $databillengine->discount == 0.00 && $databillengine->withhold == 0.00) {
                                  $vatshow = $databillengine->cal_total/1.05;
                                    echo number_format($vatshow, 2, '.', ''); ?>
                              <?php }elseif ($databillengine->vat == 7.00 && $databillengine->discount == 0.00 && $databillengine->withhold == 0.00) {
                                  $vatshow = $databillengine->cal_total/1.07;
                                    echo number_format($vatshow, 2, '.', ''); ?>

                              <?php }elseif ($databillengine->vat == 0.00 && $databillengine->discount >= 1.00 && $databillengine->withhold == 0.00) {
                                  $discount_show = $databillengine->discount/100;
                                  $totalforsum = $databillengine->cal_total - $discount_show;
                                    echo number_format($totalforsum, 2, '.', ''); ?>

                              <?php }elseif ($databillengine->vat == 7.00 && $databillengine->discount >= 0.01 && $databillengine->withhold == 0.00) {
                                      $discount_show = $databillengine->discount/100;
                                      $discount_show1 = 1.00 - $discount_show;
                                      $valuetotal = $databillengine->cal_total;
                                      $vatsum = 100/107;
                                      $totalforsum = ($valuetotal*$vatsum)/$discount_show1;
                                    echo number_format($totalforsum, 2, '.', ''); ?>
                              <?php }elseif ($databillengine->vat == 7.00 && $databillengine->discount == 0.00 && $databillengine->withhold == 3.00) {
                                      $vatshow = $databillengine->cal_total;
                                      $vatshow1 = 100/104;
                                      $vatshow_final = $vatshow*$vatshow1;
                                    echo number_format($vatshow_final, 2, '.', ''); ?>
                              <?php }elseif ($databillengine->vat == 7.00 && $databillengine->discount == 0.00 && $databillengine->withhold == 5.00) {
                                      $vatshow = $databillengine->cal_total;
                                      $vatshow1 = 100/102;
                                      $vatshow_final = $vatshow*$vatshow1;
                                    echo number_format($vatshow_final, 2, '.', ''); ?>

                              <?php }elseif ($databillengine->vat == 7.00 && $databillengine->discount >= 0.01 && $databillengine->withhold == 3.00) {
                                      $discount_show = $databillengine->discount/100;
                                      $discount_show1 = 1.00 - $discount_show;
                                      $vatshow = $databillengine->cal_total;
                                      $vatshow1 = 100/104;
                                      $vatshow_final = ($vatshow*$vatshow1)/$discount_show1;
                                    echo number_format($vatshow_final, 2, '.', ''); ?>

                              <?php }elseif ($databillengine->vat == 7.00 && $databillengine->discount >= 0.01 && $databillengine->withhold == 5.00) {
                                      $discount_show = $databillengine->discount/100;
                                      $discount_show1 = 1.00 - $discount_show;
                                      $vatshow = $databillengine->cal_total;
                                      $vatshow1 = 100/102;
                                      $vatshow_final = ($vatshow*$vatshow1)/$discount_show1;
                                    echo number_format($vatshow_final, 2, '.', ''); ?>
                              <?php }else{
                                  $vatshow = $databillengine->cal_total;
                                    echo number_format($vatshow, 2, '.', ''); ?>
                              <?php } ?>
                            </b></td>
                            <td><b>
                              <?php if ($databillengine->vat == 1.00 && $databillengine->discount == 0.00 && $databillengine->withhold == 0.00) {
                                $vatshow = $databillengine->cal_total/1.01;
                                  echo number_format($vatshow, 2, '.', ''); ?>
                              <?php }elseif ($databillengine->vat == 3.00 && $databillengine->discount == 0.00 && $databillengine->withhold == 0.00) {
                                  $vatshow = $databillengine->cal_total/1.03;
                                    echo number_format($vatshow, 2, '.', ''); ?>
                              <?php }elseif ($databillengine->vat == 5.00 && $databillengine->discount == 0.00 && $databillengine->withhold == 0.00) {
                                  $vatshow = $databillengine->cal_total/1.05;
                                    echo number_format($vatshow, 2, '.', ''); ?>
                              <?php }elseif ($databillengine->vat == 7.00 && $databillengine->discount == 0.00 && $databillengine->withhold == 0.00) {
                                  $vatshow = $databillengine->cal_total/1.07;
                                    echo number_format($vatshow, 2, '.', ''); ?>

                              <?php }elseif ($databillengine->vat == 0.00 && $databillengine->discount >= 1.00 && $databillengine->withhold == 0.00) {
                                  $discount_show = $databillengine->discount/100;
                                  $totalforsum = $databillengine->cal_total - $discount_show;
                                    echo number_format($totalforsum, 2, '.', ''); ?>

                              <?php }elseif ($databillengine->vat == 7.00 && $databillengine->discount >= 0.01 && $databillengine->withhold == 0.00) {
                                      $discount_show = $databillengine->discount/100;
                                      $discount_show1 = 1.00 - $discount_show;
                                      $valuetotal = $databillengine->cal_total;
                                      $vatsum = 100/107;
                                      $totalforsum = ($valuetotal*$vatsum)/$discount_show1;
                                    echo number_format($totalforsum, 2, '.', ''); ?>
                              <?php }elseif ($databillengine->vat == 7.00 && $databillengine->discount == 0.00 && $databillengine->withhold == 3.00) {
                                      $vatshow = $databillengine->cal_total;
                                      $vatshow1 = 100/104;
                                      $vatshow_final = $vatshow*$vatshow1;
                                    echo number_format($vatshow_final, 2, '.', ''); ?>
                              <?php }elseif ($databillengine->vat == 7.00 && $databillengine->discount == 0.00 && $databillengine->withhold == 5.00) {
                                      $vatshow = $databillengine->cal_total;
                                      $vatshow1 = 100/102;
                                      $vatshow_final = $vatshow*$vatshow1;
                                    echo number_format($vatshow_final, 2, '.', ''); ?>

                              <?php }elseif ($databillengine->vat == 7.00 && $databillengine->discount >= 0.01 && $databillengine->withhold == 3.00) {
                                      $discount_show = $databillengine->discount/100;
                                      $discount_show1 = 1.00 - $discount_show;
                                      $vatshow = $databillengine->cal_total;
                                      $vatshow1 = 100/104;
                                      $vatshow_final = ($vatshow*$vatshow1)/$discount_show1;
                                    echo number_format($vatshow_final, 2, '.', ''); ?>

                              <?php }elseif ($databillengine->vat == 7.00 && $databillengine->discount >= 0.01 && $databillengine->withhold == 5.00) {
                                      $discount_show = $databillengine->discount/100;
                                      $discount_show1 = 1.00 - $discount_show;
                                      $vatshow = $databillengine->cal_total;
                                      $vatshow1 = 100/102;
                                      $vatshow_final = ($vatshow*$vatshow1)/$discount_show1;
                                    echo number_format($vatshow_final, 2, '.', ''); ?>
                              <?php }else{
                                  $vatshow = $databillengine->cal_total;
                                    echo number_format($vatshow, 2, '.', ''); ?>
                              <?php } ?>
                            </b></td>
                        </tr>
                    @endif

                    <?php $en = $databillengine->billengine_rent ?>
                    @endif
                  @endforeach
                </tbody>
              </table>

            <?php endif; ?>


              <!-- <div class="table-responsive">
                <table id="example1" class="table table-striped table-bordered fontslabel" style="width:100%">
                  <thead>
                    <tr>
                      <th>รหัส</th>
                      <th>ชื่อเจ้าหนี้</th>
                      <th>ยอดคงค้าง</th>
                    </tr>
                  </thead>
                  <tbody>

                    <tr>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>

                  </tbody>
                </table><br>
              </div> -->

              <!-- <div class="table-responsive">
                <table id="example2" class="table table-striped table-bordered fontslabel" style="width:100%">
                  <thead>
                    <tr>
                      <th>รหัส</th>
                      <th>ชื่อเจ้าหนี้</th>
                      <th>เครดิต(วัน)</th>
                      <th>ยอดคงค้าง</th>
                      <th>จะครบกำหนด</th>
                      <th>เกินกำหนด</th>
                      <th>รวมยอดหนี้</th>
                    </tr>
                  </thead>
                  <tbody>

                    <tr>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>

                  </tbody>
                </table><br>
              </div> -->

</div>
<!-- END content-page -->
<!-- END main -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script> -->
<script type="text/javascript" src = 'js/accountjs/buysteel.js'></script>
<!-- <script>
$(document).ready(function() {
  var table = $('#example').DataTable({
      "columnDefs": [
          { "visible": false, "targets": 1 }
      ],
      "order": [[ 1, 'asc' ]],
      "displayLength": 25,
      "drawCallback": function ( settings ) {
          var api = this.api();
          var rows = api.rows( {page:'current'} ).nodes();
          var last=null;

          api.column(1, {page:'current'} ).data().each( function ( group, i ) {
              if ( last !== group ) {
                  $(rows).eq( i ).before(
                      '<tr class="group"><td colspan="8">'+group+'</td></tr>'
                  );

                  last = group;
              }
          } );
      }
  } );

  // Order by the grouping
  $('#example tbody').on( 'click', 'tr.group', function () {
      var currentOrder = table.order()[0];
      if ( currentOrder[0] === 1 && currentOrder[1] === 'asc' ) {
          table.order( [ 1, 'desc' ] ).draw();
      }
      else {
          table.order( [ 1, 'asc' ] ).draw();
      }
  } );
} );
</script> -->

@endsection
