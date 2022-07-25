
@extends('index')
@section('content')
<!-- <link rel="stylesheet" href="{{asset('css/debt/debt.css')}}"> //! include css -->
<!-- js data table -->
<script type="text/javascript" src="https://unpkg.com/sweetalert2@7.0.6/dist/sweetalert2.all.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript" src={{ asset('js/accountjs/journal_general1.js') }}></script>
<link href="{{ asset('css/journal_debt/journal_general1.css') }}" rel="stylesheet" type="text/css" media="all">
<style media="screen">
  .project-tab {
    padding: 10% 2% 10% 2%;
    margin-top: -8%;
  }
  .project-tab #tabs{
    background: #007b5e;
    color: #eee;
  }
  .project-tab #tabs h6.section-title{
    color: #eee;
  }
  .project-tab #tabs .nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active {
    color: #0062cc;
    background-color: transparent;
    border-color: transparent transparent #f3f3f3;
    border-bottom: 3px solid !important;
    font-size: 16px;
    font-weight: bold;
  }
  .project-tab .nav-link {
    border: 1px solid transparent;
    border-top-left-radius: .25rem;
    border-top-right-radius: .25rem;
    color: #0062cc;
    font-size: 16px;
    font-weight: 600;
  }
  .project-tab .nav-link:hover {
    border: none;
  }
  .project-tab thead{
    background: #f3f3f3;
    color: #333;
  }
  .project-tab a{
    text-decoration: none;
    color: #333;
    font-weight: 600;
  }
</style>

<script language="JavaScript">
  function toggle1(source) {
    checkboxes = document.getElementsByName('id_journal_5[]');
    for(var i=0, n=checkboxes.length;i<1000;i++) {
      checkboxes[i].checked = source.checked;
    }
  }
</script>

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
                            <li class="breadcrumb-item">สมุดรายวัน</li>
                            <li class="breadcrumb-item active">สมุดรายวันทั่วไป (กรณีขึ้นของเช่าเครื่องยนต์)</li>
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
                                <fonts id="fontsheader">สมุดรายวันทั่วไป (กรณีขึ้นของเช่าเครื่องยนต์)</fonts>
                            </h3><br><br>

                            <!-- date range -->
                            {!! Form::open(['route' => 'journal_generalfilter2', 'method' => 'post']) !!}
                            <div class="row" class="fontslabel">
                                <div class="col-sm-3">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <label id="fontslabel"><b>วันที่ : &nbsp;</b></label>
                                        </div>
                                        <input type='text' class="form-control" name="daterange" value="" autocomplete="off" />
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="input-group">
                                        <label id="fontslabel"><b>สาขา :</b></label>&nbsp;&nbsp;
                                        <select class="form-control" name="branch_search">
                                            <option value="0">เลือกสาขา</option>
                                            @foreach ($branchs as $key => $branch)
                                            <option value="{{$branch->code_branch}}">{{$branch->name_branch}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                <button type="submit" class="btn btn-primary btn-sm fontslabel">ค้นหา</button>
                                <a class="btn btn-info btn-sm fontslabel" href="{{url('journal_general1_rentengine')}}">ดูทั้งหมด</a>
                                </div>
                            </div>
                            {!! Form::close() !!}
                            <!-- date range -->
                        </div>

                              <br>

                              {!! Form::open(['route' => 'confirm_journal_general2', 'method' => 'post']) !!}
                              <table class="table table-bordered" cellspacing="0" id="fontsjournal">
                                <thead>
                                    <tr style="background-color:#aab6c2;color:white;">
                                        <th scope="col">
                                          <label class="con" style="margin: -25px -35px 0px 0px;">
                                            <input type="checkbox" onClick="toggle1(this)">
                                            <span class="checkmark"></span>
                                          </label>
                                        </th>
                                        <th scope="col">วัน/เดือน/ปี</th>
                                        <th scope="col">เลขที่เอกสาร</th>
                                        <th scope="col">รายการ</th>
                                        <th scope="col">คำอธิบายรายการย่อย</th>
                                        <th scope="col">เลขที่บัญชี</th>
                                        <th scope="col">ชื่อเลขที่บัญชี</th>
                                        <th scope="col">สาขา</th>
                                        <th scope="col">เดบิต</th>
                                        <th scope="col">เครดิต</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  @foreach ($databillengines  as $key => $databillengine)
                                    @if ($databillengine->billengine_rent == $en)
                                    <!-- ถ้า ap เหมือนกันเขียนแค่ list -->
                                      <tr>
                                          <td></td>
                                          <td></td>
                                          <td></td>
                                          <td>เครื่องมือให้เช่า {{$databillengine->name_engine}}</td>
                                          <td>ขึ้นเครื่องมือให้เช่าลูกค้า {{$databillengine->name}} {{$databillengine->lastname}}</td>
                                          <td>151901</td>
                                          <td style="text-align:left;">เครื่องมือให้เช่าลูกค้า {{$databillengine->name}} {{$databillengine->lastname}}</td>
                                          <td></td>
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

                              <div style="padding-bottom:50px;">
                                  <center><button type="submit" class="btn btn-success">Okay ยืนยันการตรวจ</button></center>
                              </div>
                              {!! Form::close() !!}





                        <!--END table cotent -->
                    </div><!-- end card-->
                </div>
            </div>
            <!-- end row -->
        </div>
        <!-- END container-fluid -->
    </div>
    <!-- END content -->

</div>
<!-- END content-page -->
@endsection
