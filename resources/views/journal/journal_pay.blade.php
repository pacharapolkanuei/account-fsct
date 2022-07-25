@extends('index')
@section('content')
<!-- js data table -->
<script type="text/javascript" src="https://unpkg.com/sweetalert2@7.0.6/dist/sweetalert2.all.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript" src={{ asset('js/accountjs/journal_debt.js') }}></script>
<link href="{{ asset('css/journal_debt/journal_debt.css') }}" rel="stylesheet" type="text/css" media="all">
<script language="JavaScript">
  function toggle(source) {
    checkboxes = document.getElementsByName('id_journal_pay[]');
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
                            <li class="breadcrumb-item active">สมุดรายวันจ่าย</li>
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
                                <fonts id="fontsheader">สมุดรายวันจ่าย</fonts>
                            </h3><br><br>
                            <!-- date range -->
                            {!! Form::open(['route' => 'journalpay_filter', 'method' => 'post']) !!}
                            <div class="row" class="fontslabel">
                                <div class="col-sm-3">
                                    <div class="input-group mb-6">
                                        <div class="input-group-prepend">
                                            <label id="fontslabel"><b>วันที่ : &nbsp;</b></label>
                                        </div>
                                        <input type='text' class="form-control" name="daterange" value="" autocomplete="off" required/>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="input-group mb-6">
                                        <label id="fontslabel"><b>สาขา : &nbsp;</b></label>
                                        <select class="form-control" name="branch" required>
                                            <option value="0">เลือกสาขา</option>
                                            @foreach ($branchs as $key => $branch)
                                            <option value="{{$branch->code_branch}}">{{$branch->name_branch}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="input-group mb-6">
                                        <label id="fontslabel"><b>แจ้งการจ่ายเงิน : &nbsp;</b></label>
                                        <select class="form-control" name="type_pay_request" required>
                                            <option value="1">แจ้งการจ่ายเงินแบบใหม่</option>
                                            <option value="0">แจ้งการจ่ายเงินแบบเก่า</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- <div class="col-sm-3">
                                    <div class="input-group mb-4">
                                        <label id="fontslabel"><b>ประเภทการจ่าย : &nbsp;</b></label>
                                        <select class="form-control" name="type_paid" required>
                                            <option selected disabled>เลือกประเภทการจ่าย</option>
                                            <option value="1">จ่ายเงินทั่วไป</option>
                                            <option value="2">เงินเดือน</option>
                                        </select>
                                    </div>
                                </div> -->
                                <center><button type="submit" class="btn btn-primary btn-sm fontslabel">ค้นหา</button></center>&nbsp;
                                <center><a class="btn btn-info btn-sm fontslabel" href="{{url('journal_pay')}}">ดูทั้งหมด</a></center>
                            </div>
                            {!! Form::close() !!}
                            <!-- date range -->
                        </div>


                        <!-- table cotent -->
                        <div id="fontsjournal">
                            <table class="table table-bordered" style="table-layout: fixed;">
                                <thead>
                                    <tr style="background-color:#aab6c2;color:white;">
                                        <th style="width:5%"><label class="con" style="margin: -25px -35px 0px 0px;">
                                            <input type="checkbox" onClick="toggle(this)">
                                            <span class="checkmark"></span>
                                          </label>
                                        </th>
                                        <th style="width:5%">วัน/เดือน/ปี</th>
                                        <th style="width:10%">เลขที่ใบสำคัญจ่าย</th>
                                        <th style="width:10%">รายการ</th>
                                        <th style="width:25%">รายละเอียด</th>
                                        <th style="width:10%">เลขที่บัญชี</th>
                                        <th style="width:10%">ชื่อเลขที่บัญชี</th>
                                        <th style="width:5%">สาขา</th>
                                        <th style="width:10%">เดบิต</th>
                                        <th style="width:10%">เครดิต</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ( $type_data == 1)
                                    @foreach ($datas as $key => $debt)
                                    <!-- เช็คว่ามาจากตารางเก่าใหม่ -->
                                      @if ($debt->payser_number == $ap)
                                      <!-- ถ้า ap เหมือนกันเขียนแค่ list -->
                                          @if ($debt->type == 1)
                                          <tr>
                                              <td></td>
                                              <td></td>
                                              <td></td>
                                              <td style="text-align:left;"><b>ค่า</b> {{$debt->list}} <b>ค้างจ่าย</b></td>
                                              <td><?php
                                                $text = $debt->note;
                                                $newtext = wordwrap($text, 30, "<br />\n");
                                                echo $newtext; ?>
                                              </td>
                                              <td>212100</td>
                                              <td>เจ้าหนี้การค้า</td>
                                              <td></td>
                                              <td>{{$debt->payout}}</td>
                                              <td></td>
                                          </tr>
                                          @endif

                                          @if ($debt->type == 2)
                                          <tr>
                                              <td></td>
                                              <td></td>
                                              <td></td>
                                              <td style="text-align:left;">{{$debt->list}}</td>
                                              <td><?php
                                                $text = $debt->note;
                                                $newtext = wordwrap($text, 30, "<br />\n");
                                                echo $newtext; ?>
                                              </td>
                                              <td>{{$debt->accounttypeno}}</td>
                                              <td>{{$debt->accounttypefull}}</td>
                                              <td></td>
                                              <td>{{$debt->total}}</td>
                                              <td></td>
                                          </tr>
                                          @endif

                                          @if ($debt->type == 3)
                                          <tr>
                                              <td></td>
                                              <td></td>
                                              <td></td>
                                              <td style="text-align:left;">{{$debt->list}}</td>
                                              <td><?php
                                                $text = $debt->note;
                                                $newtext = wordwrap($text, 30, "<br />\n");
                                                echo $newtext; ?>
                                              </td>
                                              <td>{{$debt->accounttypeno}}</td>
                                              <td>{{$debt->accounttypefull}}</td>
                                              <td></td>
                                              <td>{{$debt->total}}</td>
                                              <td></td>
                                          </tr>
                                          @endif

                                          @if ($debt->type == 4)
                                          <tr>
                                              <td></td>
                                              <td></td>
                                              <td></td>
                                              <td style="text-align:left;">{{$debt->list}}</td>
                                              <td><?php
                                                $text = $debt->note;
                                                $newtext = wordwrap($text, 30, "<br />\n");
                                                echo $newtext; ?>
                                              </td>
                                              <td>{{$debt->accounttypeno}}</td>
                                              <td>{{$debt->accounttypefull}}</td>
                                              <td></td>
                                              <td>{{$debt->total}}</td>
                                              <td></td>
                                          </tr>
                                          @endif

                                          @if ($debt->type == 5)
                                          <tr>
                                              <td></td>
                                              <td></td>
                                              <td></td>
                                              <td style="text-align:left;">{{$debt->list}}</td>
                                              <td><?php
                                                $text = $debt->note;
                                                $newtext = wordwrap($text, 30, "<br />\n");
                                                echo $newtext; ?>
                                              </td>
                                              <td>{{$debt->accounttypeno}}</td>
                                              <td>{{$debt->accounttypefull}}</td>
                                              <td></td>
                                              <td>{{$debt->total}}</td>
                                              <td></td>
                                          </tr>
                                          @endif

                                          @if ($debt->type == 6)
                                          <tr>
                                              <td></td>
                                              <td></td>
                                              <td></td>
                                              <td style="text-align:left;">{{$debt->list}}</td>
                                              <td><?php
                                                $text = $debt->note;
                                                $newtext = wordwrap($text, 30, "<br />\n");
                                                echo $newtext; ?>
                                              </td>
                                              <td>{{$debt->accounttypeno}}</td>
                                              <td>{{$debt->accounttypefull}}</td>
                                              <td></td>
                                              <td>{{$debt->total}}</td>
                                              <td></td>
                                          </tr>
                                          @endif

                                          <?php $ap = $debt->payser_number; ?>

                                          @if ($key == count($datas)-1)
                                          <!-- เขียนสำหรับรายการสุดท้าย -->
                                              @if ($debt->type > 1 )
                                                  @if ($debt->vat_percent != 0)
                                                  <tr>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td style="text-align:left;"><b>ภาษีมูลค่าเพิ่ม</td>
                                                      <td></td>
                                                      <td>119501</td>
                                                      <td>ภาษีซื้อ</td>
                                                      <td></td>
                                                      <td>{{ $debt->vat_price }}</td>
                                                      <td></td>
                                                  </tr>
                                                  @endif

                                                  @if ($debt->discount != 0)
                                                  <tr>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td style="text-align:left;"><b>ส่วนลด</td>
                                                      <td></td>
                                                      <td>412900</td>
                                                      <td>ส่วนลดรับ</td>
                                                      <td></td>
                                                      <td></td>
                                                      <td><?php echo number_format($debt->discount, 2, '.', ''); ?></td>
                                                  </tr>
                                                  @endif

                                                  @if ($debt->wht_percent != 0)
                                                  <tr>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      @if($debt->company_pay_wht == "255")
                                                      <td style="text-align:left;"><b>{{isCompanyWht($debt->company_pay_wht)}}</td>
                                                      @else
                                                      <td style="text-align:center;"><b>{{isCompanyWht($debt->company_pay_wht)}}</td>
                                                      @endif
                                                      <td></td>
                                                        @if($debt->company_pay_wht == 255)
                                                        <td>621708</td>
                                                        <td>ค่าใช้จ่ายในการบริหาร-ค่าภาษีหัก ณ ที่จ่ายออกแทน</td>
                                                        @elseif($debt->statusperson == 0)
                                                        <td>219402</td>
                                                        <td>ภาษีหัก ณ ที่จ่ายค้างจ่าย ภงด.3</td>
                                                        @elseif($debt->statusperson == 1)
                                                        <td>222002</td>
                                                        <td>ภาษีหัก ณ ที่จ่าย ภงด.53</td>
                                                        @else
                                                        <td>219401</td>
                                                        <td>ภาษีหัก ณ ที่จ่ายค้างจ่าย ภงด.1</td>
                                                        @endif
                                                      <td></td>
                                                      @if($debt->company_pay_wht == 255)
                                                      <td>{{$debt->wht}}</td>
                                                      <td></td>
                                                      @elseif($debt->statusperson == 0)
                                                      <td></td>
                                                      <td>{{$debt->wht}}</td>
                                                      @elseif($debt->statusperson == 1)
                                                      <td></td>
                                                      <td>{{$debt->wht}}</td>
                                                      @else
                                                      <td></td>
                                                      <td>{{$debt->wht}}</td>
                                                      @endif
                                                  </tr>
                                                  @endif


                                                  @if ($debt->company_pay_wht == 255)
                                                  <tr>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td style="text-align:center;"><b>ภาษีหัก ณ ที่จ่าย</td>
                                                      <td></td>
                                                      @if ($debt->statusperson == 0)
                                                      <td>222001</td>
                                                      <td>ภาษีหัก ณ ที่จ่าย ภงด.3</td>
                                                      @elseif ($debt->statusperson == 1)
                                                      <td>222002</td>
                                                      <td>ภาษีหัก ณ ที่จ่าย ภงด.53</td>
                                                      @else
                                                      <td>222000</td>
                                                      <td>ภาษีหัก ณ ที่จ่าย ภงด.1</td>
                                                      @endif
                                                      <td></td>
                                                      <td></td>
                                                      <td>{{$debt->wht}}</td>
                                                  </tr>
                                                  @endif
                                              @endif

                                                  @if ($debt->type == 1)
                                                  <tr>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td style="text-align:center;">
                                                          <b>{{ TypePay($debt->type_pay) }}</b>
                                                      </td>
                                                      <td></td>
                                                      <td>
                                                        <?php if($debt->type_pay == 1) {
                                                            echo "111200"; ?>
                                                        <?php }elseif($debt->type_pay == 2) {
                                                            $string = $debt->account_bank;
                                                            $token = strtok($string, "|");
                                                            echo $token;
                                                        ?>
                                                        <?php }else {
                                                        } ?>
                                                      </td>
                                                      <td>
                                                        <?php if($debt->type_pay == 1) {
                                                            echo "เงินสด"; ?>
                                                        <?php }elseif($debt->type_pay == 2) {
                                                          $keep = stristr($debt->account_bank,"|");
                                                          echo substr($keep,1)
                                                        ?>
                                                        <?php }else {
                                                        } ?>
                                                      </td>
                                                      <td></td>
                                                      <td></td>
                                                      <td>
                                                        <?php if($debt->wht_percent >= 1.00 && $debt->company_pay_wht == 0.00) {
                                                                $showmoney = $debt->vat_price-$debt->wht;
                                                                    echo number_format($showmoney, 2, '.', ''); ?>
                                                        <?php }else {
                                                                $showmoney1 = $debt->payout;
                                                                    echo number_format($showmoney1, 2, '.', '');
                                                        } ?>
                                                      </td>
                                                  </tr>
                                                  @endif

                                                  @if ($debt->type == 2)
                                                  <tr>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td style="text-align:center;">
                                                          <b>{{ TypePay($debt->type_pay) }}</b>
                                                      </td>
                                                      <td></td>
                                                      <td>
                                                        <?php if($debt->type_pay == 1) {
                                                            echo "111200"; ?>
                                                        <?php }elseif($debt->type_pay == 2 && $debt->type_newtable == 1) {
                                                            $string = $debt->account_bank;
                                                            $token = strtok($string, "|");
                                                            echo $token;
                                                        ?>
                                                        <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1001) {
                                                            echo "112027";
                                                        ?>
                                                        <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1004) {
                                                            echo "112027";
                                                        ?>
                                                        <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1005) {
                                                            echo "112038";
                                                        ?>
                                                        <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1006) {
                                                            echo "112046";
                                                        ?>
                                                        <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1007) {
                                                            echo "112046";
                                                        ?>
                                                        <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1008) {
                                                            echo "112043";
                                                        ?>
                                                        <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1009) {
                                                            echo "112048";
                                                        ?>
                                                        <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1010) {
                                                            echo "112047";
                                                        ?>
                                                        <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1011) {
                                                            echo "112028";
                                                        ?>
                                                        <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1012) {
                                                            echo "112054";
                                                        ?>
                                                        <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1013) {
                                                            echo "112053";
                                                        ?>
                                                        <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1014) {
                                                            echo "112053";
                                                        ?>
                                                        <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1015) {
                                                            echo "112041";
                                                        ?>
                                                        <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1016) {
                                                            echo "112033";
                                                        ?>
                                                        <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1017) {
                                                            echo "112033";
                                                        ?>
                                                        <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1018) {
                                                            echo "112052";
                                                        ?>
                                                        <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1019) {
                                                            echo "112042";
                                                        ?>
                                                        <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1020) {
                                                            echo "112055";
                                                        ?>
                                                        <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1021) {
                                                            echo "112055";
                                                        ?>
                                                        <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1022) {
                                                            echo "112045";
                                                        ?>
                                                        <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1023) {
                                                            echo "112049";
                                                        ?>
                                                        <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1024) {
                                                            echo "112050";
                                                        ?>
                                                        <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1025) {
                                                            echo "112051";
                                                        ?>
                                                        <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1026) {
                                                            echo "112032";
                                                        ?>
                                                        <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1027) {
                                                            echo "112044";
                                                        ?>
                                                        <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1028) {
                                                            echo "112029";
                                                        ?>
                                                        <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1029) {
                                                            echo "112034";
                                                        ?>
                                                        <?php }else {
                                                        } ?>
                                                      </td>
                                                      <td>
                                                        <?php if($debt->type_pay == 1) {
                                                            echo "เงินสด"; ?>
                                                        <?php }elseif($debt->type_pay == 2 && $debt->type_newtable == 1) {
                                                          $keep = stristr($debt->account_bank,"|");
                                                          echo substr($keep,1)
                                                        ?>
                                                        <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1001) {
                                                            echo "เงินฝากออมทรัพย์ KBANK 587-2-25765-0 (เชียงใหม่)";
                                                        ?>
                                                        <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1004) {
                                                            echo "เงินฝากออมทรัพย์ KBANK 587-2-25765-0 (เชียงใหม่)";
                                                        ?>
                                                        <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1005) {
                                                            echo "เงินฝากออมทรัพย์ KBANK 014-3-90676-0 (ลำพูน)";
                                                        ?>
                                                        <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1006) {
                                                            echo "เงินฝากออมทรัพย์ KBANK 011-8-74641-4 (เชียงราย)";
                                                        ?>
                                                        <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1007) {
                                                            echo "เงินฝากออมทรัพย์ KBANK 011-8-74641-4 (เชียงราย)";
                                                        ?>
                                                        <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1008) {
                                                            echo "เงินฝากออมทรัพย์ KBANK 011-8-68918-6 (พะเยา)";
                                                        ?>
                                                        <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1009) {
                                                            echo "เงินฝากออมทรัพย์ KBANK 011-3-75497-4 (ลำปาง)";
                                                        ?>
                                                        <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1010) {
                                                            echo "เงินฝากออมทรัพย์ KBANK 013-3-83066-9 (สกลนคร)";
                                                        ?>
                                                        <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1011) {
                                                            echo "เงินฝากออมทรัพย์ KBANK 580-2-00222-1 (บางปะอิน)";
                                                        ?>
                                                        <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1012) {
                                                            echo "เงินฝากออมทรัพย์ KBANK 012-1-28303-4 (ลพบุรี)";
                                                        ?>
                                                        <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1013) {
                                                            echo "เงินฝากออมทรัพย์ KBANK 013-3-94803-1 (อุดรธานี)";
                                                        ?>
                                                        <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1014) {
                                                            echo "เงินฝากออมทรัพย์ KBANK 013-3-94803-1 (อุดรธานี)";
                                                        ?>
                                                        <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1015) {
                                                            echo "เงินฝากออมทรัพย์ KBANK 013-3-74618-8 (บุรีรัมย์)";
                                                        ?>
                                                        <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1016) {
                                                            echo "เงินฝากออมทรัพย์ KBANK 013-3-80020-4 (ขอนแก่น)";
                                                        ?>
                                                        <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1017) {
                                                            echo "เงินฝากออมทรัพย์ KBANK 013-3-80020-4 (ขอนแก่น)";
                                                        ?>
                                                        <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1018) {
                                                            echo "เงินฝากออมทรัพย์ KBANK 013-3- 77322-3 (มหาสารคาม)";
                                                        ?>
                                                        <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1019) {
                                                            echo "เงินฝากออมทรัพย์ KBANK 013-3-53944-1 (ร้อยเอ็ด)";
                                                        ?>
                                                        <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1020) {
                                                            echo "เงินฝากออมทรัพย์ KBANK 013-361402-8 (อุบลราชธานี)";
                                                        ?>
                                                        <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1021) {
                                                            echo "เงินฝากออมทรัพย์ KBANK 013-361402-8 (อุบลราชธานี)";
                                                        ?>
                                                        <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1022) {
                                                            echo "เงินฝากออมทรัพย์ KBANK 013-3-71800-1 (สุรินทร์)";
                                                        ?>
                                                        <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1023) {
                                                            echo "เงินฝากออมทรัพย์ KBANK 433-2-17759-7 (นครราชสีมา)";
                                                        ?>
                                                        <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1024) {
                                                            echo "เงินฝากออมทรัพย์ KBANK 008-140-1160 (นครราชสีมา2)";
                                                        ?>
                                                        <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1025) {
                                                            echo "เงินฝากออมทรัพย์ KBANK 433-2-52400-9 (นครราชสีมา3)";
                                                        ?>
                                                        <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1026) {
                                                            echo "เงินฝากออมทรัพย์ KBANK 960-2-10113-1 (หาดใหญ่)";
                                                        ?>
                                                        <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1027) {
                                                            echo "เงินฝากออมทรัพย์ KBANK 032-8-50533-9 (นครพนม)";
                                                        ?>
                                                        <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1028) {
                                                            echo "เงินฝากออมทรัพย์ KBANK 014-8-77067-0 (สุราษฎร์ธานี)";
                                                        ?>
                                                        <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1029) {
                                                            echo "เงินฝากออมทรัพย์ KBANK 014-8-69809-0 (นครศรีธรรมราช)";
                                                        ?>
                                                        <?php }else {
                                                        } ?>
                                                      </td>
                                                      <td></td>
                                                      <td></td>
                                                      <td>
                                                        <?php if($debt->wht_percent >= 1.00 && $debt->company_pay_wht == 0.00) {
                                                                $showmoney = $debt->payout;
                                                                    echo number_format($showmoney, 2, '.', ''); ?>
                                                        <?php }else {
                                                                $showmoney1 = $debt->payout;
                                                                    echo number_format($showmoney1, 2, '.', '');
                                                        } ?>
                                                      </td>
                                                  </tr>
                                                  @endif


                                                  @if ($debt->type == 3)
                                                  <tr>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td style="text-align:center;"><b>เงินยืมกรรมการ</b></td>
                                                      <td></td>
                                                      <td>221100</td>
                                                      <td>เงินกู้ยืมจากกรรมการ</td>
                                                      <td></td>
                                                      <td></td>
                                                      <td>{{$debt->payout}}</td>
                                                  </tr>
                                                  @endif

                                                  @if ($debt->type == 4)
                                                  <tr>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td style="text-align:center;"><b>เงินสดย่อย</b></td>
                                                      <td></td>
                                                      <td>111201</td>
                                                      <td>เงินสดย่อย</td>
                                                      <td></td>
                                                      <td></td>
                                                      <td>{{$debt->payout}}</td>
                                                  </tr>
                                                  @endif

                                                  @if ($debt->type == 5)
                                                  <tr>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td style="text-align:center;"><b>คืนเงินสดย่อย</b></td>
                                                      <td></td>
                                                      <td>111201</td>
                                                      <td>เงินสดย่อย</td>
                                                      <td></td>
                                                      <td></td>
                                                      <td>{{$debt->payout}}</td>
                                                  </tr>
                                                  @endif

                                                  @if ($debt->type == 6)
                                                  <tr>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td style="text-align:center;"><b>ลดหนี้</b></td>
                                                      <td></td>
                                                      <td>{{$debt->accounttypeno}}</td>
                                                      <td>{{$debt->accounttypefull}}</td>
                                                      <td></td>
                                                      <td></td>
                                                      <td>{{$debt->payout}}</td>
                                                  </tr>
                                                  @endif


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
                                                        <?php if ($debt->type == 1) {
                                                          $showpayput = $debt->payout;
                                                                     echo number_format($showpayput, 2, '.', ''); ?>
                                                        <?php  }else{ ?>
                                                        <?php  if($debt->vat_percent == 0 && $debt->discount == 0.00 && $debt->wht_percent == 0.00 && $debt->company_pay_wht == 0) {
                                                            $showsumcredits = $debt->payout;
                                                                      echo number_format($showsumcredits, 2, '.', ''); ?>
                                                        <?php  }elseif ($debt->vat_percent == 0 && $debt->discount >= 0.01 && $debt->wht_percent == 0.00 && $debt->company_pay_wht == 0) {
                                                            $showsumcredits = $debt->payout+$debt->discount;
                                                                      echo number_format($showsumcredits, 2, '.', ''); ?>
                                                        <?php  }elseif ($debt->vat_percent >= 1 && $debt->discount == 0.00 && $debt->wht_percent == 0.00 && $debt->company_pay_wht == 0) {
                                                            $showsumcredits = $debt->payout;
                                                                      echo number_format($showsumcredits, 2, '.', ''); ?>
                                                        <?php  }elseif ($debt->vat_percent >= 1 && $debt->discount >= 0.01 && $debt->wht_percent == 0.00 && $debt->company_pay_wht == 0) {
                                                            $showsumcredits = $debt->payout+$debt->discount;
                                                                      echo number_format($showsumcredits, 2, '.', ''); ?>
                                                        <?php  }elseif ($debt->vat_percent == 0 && $debt->discount == 0.00 && $debt->wht_percent >= 1.00 && $debt->company_pay_wht == 0) {
                                                            $showsumcredits = $debt->payout;
                                                                      echo number_format($showsumcredits, 2, '.', ''); ?>
                                                        <?php  }elseif ($debt->vat_percent == 0 && $debt->discount == 0.00 && $debt->wht_percent >= 1.00 && $debt->company_pay_wht == 255) {
                                                            $showsumcredits = $debt->payout+$debt->wht;
                                                                      echo number_format($showsumcredits, 2, '.', ''); ?>
                                                        <?php  }elseif ($debt->vat_percent == 0 && $debt->discount >= 0.01 && $debt->wht_percent >= 1.00 && $debt->company_pay_wht == 0) {
                                                            $showsumcredits = $debt->payout+$debt->discount;
                                                                      echo number_format($showsumcredits, 2, '.', ''); ?>
                                                        <?php  }elseif ($debt->vat_percent == 0 && $debt->discount >= 0.01 && $debt->wht_percent >= 1.00 && $debt->company_pay_wht == 255) {
                                                            $showsumcredits = $debt->payout+$debt->discount+$debt->wht;
                                                                      echo number_format($showsumcredits, 2, '.', ''); ?>
                                                        <?php  }elseif ($debt->vat_percent >= 1 && $debt->discount == 0.00 && $debt->wht_percent >= 1.00 && $debt->company_pay_wht == 0) {
                                                            $showsumcredits = $debt->payout+$debt->wht;
                                                                      echo number_format($showsumcredits, 2, '.', ''); ?>
                                                        <?php  }elseif ($debt->vat_percent >= 1 && $debt->discount == 0.00 && $debt->wht_percent >= 1.00 && $debt->company_pay_wht == 255) {
                                                            $showsumcredits = $debt->payout+$debt->wht;
                                                                      echo number_format($showsumcredits, 2, '.', ''); ?>
                                                        <?php  }elseif ($debt->vat_percent >= 1 && $debt->discount >= 0.01 && $debt->wht_percent >= 1.00 && $debt->company_pay_wht == 0) {
                                                            $showsumcredits = $debt->payout+$debt->discount;
                                                                      echo number_format($showsumcredits, 2, '.', ''); ?>
                                                        <?php  }elseif ($debt->vat_percent >= 1 && $debt->discount >= 0.01 && $debt->wht_percent >= 1.00 && $debt->company_pay_wht == 255) {
                                                            $showsumcredits = $debt->payout+$debt->discount+$debt->wht;
                                                                      echo number_format($showsumcredits, 2, '.', ''); ?>
                                                        <?php }else {
                                                                      echo "Code Error";
                                                        }} ?>
                                                      </b></td>
                                                      <td><b>
                                                        <?php if ($debt->type == 1) {
                                                          $showpayput = $debt->payout;
                                                                     echo number_format($showpayput, 2, '.', ''); ?>
                                                        <?php  }else{ ?>
                                                        <?php  if($debt->vat_percent == 0 && $debt->discount == 0.00 && $debt->wht_percent == 0.00 && $debt->company_pay_wht == 0) {
                                                            $showsumcredits = $debt->payout;
                                                                      echo number_format($showsumcredits, 2, '.', ''); ?>
                                                        <?php  }elseif ($debt->vat_percent == 0 && $debt->discount >= 0.01 && $debt->wht_percent == 0.00 && $debt->company_pay_wht == 0) {
                                                            $showsumcredits = $debt->payout+$debt->discount;
                                                                      echo number_format($showsumcredits, 2, '.', ''); ?>
                                                        <?php  }elseif ($debt->vat_percent >= 1 && $debt->discount == 0.00 && $debt->wht_percent == 0.00 && $debt->company_pay_wht == 0) {
                                                            $showsumcredits = $debt->payout;
                                                                      echo number_format($showsumcredits, 2, '.', ''); ?>
                                                        <?php  }elseif ($debt->vat_percent >= 1 && $debt->discount >= 0.01 && $debt->wht_percent == 0.00 && $debt->company_pay_wht == 0) {
                                                            $showsumcredits = $debt->payout+$debt->discount;
                                                                      echo number_format($showsumcredits, 2, '.', ''); ?>
                                                        <?php  }elseif ($debt->vat_percent == 0 && $debt->discount == 0.00 && $debt->wht_percent >= 1.00 && $debt->company_pay_wht == 0) {
                                                            $showsumcredits = $debt->payout;
                                                                      echo number_format($showsumcredits, 2, '.', ''); ?>
                                                        <?php  }elseif ($debt->vat_percent == 0 && $debt->discount == 0.00 && $debt->wht_percent >= 1.00 && $debt->company_pay_wht == 255) {
                                                            $showsumcredits = $debt->payout+$debt->wht;
                                                                      echo number_format($showsumcredits, 2, '.', ''); ?>
                                                        <?php  }elseif ($debt->vat_percent == 0 && $debt->discount >= 0.01 && $debt->wht_percent >= 1.00 && $debt->company_pay_wht == 0) {
                                                            $showsumcredits = $debt->payout+$debt->discount;
                                                                      echo number_format($showsumcredits, 2, '.', ''); ?>
                                                        <?php  }elseif ($debt->vat_percent == 0 && $debt->discount >= 0.01 && $debt->wht_percent >= 1.00 && $debt->company_pay_wht == 255) {
                                                            $showsumcredits = $debt->payout+$debt->discount+$debt->wht;
                                                                      echo number_format($showsumcredits, 2, '.', ''); ?>
                                                        <?php  }elseif ($debt->vat_percent >= 1 && $debt->discount == 0.00 && $debt->wht_percent >= 1.00 && $debt->company_pay_wht == 0) {
                                                            $showsumcredits = $debt->payout+$debt->wht;
                                                                      echo number_format($showsumcredits, 2, '.', ''); ?>
                                                        <?php  }elseif ($debt->vat_percent >= 1 && $debt->discount == 0.00 && $debt->wht_percent >= 1.00 && $debt->company_pay_wht == 255) {
                                                            $showsumcredits = $debt->payout+$debt->wht;
                                                                      echo number_format($showsumcredits, 2, '.', ''); ?>
                                                        <?php  }elseif ($debt->vat_percent >= 1 && $debt->discount >= 0.01 && $debt->wht_percent >= 1.00 && $debt->company_pay_wht == 0) {
                                                            $showsumcredits = $debt->payout+$debt->discount;
                                                                      echo number_format($showsumcredits, 2, '.', ''); ?>
                                                        <?php  }elseif ($debt->vat_percent >= 1 && $debt->discount >= 0.01 && $debt->wht_percent >= 1.00 && $debt->company_pay_wht == 255) {
                                                            $showsumcredits = $debt->payout+$debt->discount+$debt->wht;
                                                                      echo number_format($showsumcredits, 2, '.', ''); ?>
                                                        <?php }else {
                                                                      echo "Code Error";
                                                        }} ?>
                                                      </b></td>
                                                  </tr>
                                          @endif
                                          <?php $ap = $debt->payser_number; ?>

                                      @else

                                          <!-- เปลี่ยนรายการ -->
                                          @if ($key != 0)
                                              <!-- ก่อนเปลี่ยนรายการเขียนปิดรายการก่อนหน้า -->
                                            @if($datas[$key-1]->type > 1)
                                              @if ($datas[$key-1]->vat_percent != 0)
                                              <tr>
                                                  <td></td>
                                                  <td></td>
                                                  <td></td>
                                                  <td style="text-align:left;"><b>ภาษีมูลค่าเพิ่ม</td>
                                                  <td></td>
                                                  <td>119501</td>
                                                  <td>ภาษีซื้อ</td>
                                                  <td></td>
                                                  <td>{{ $datas[$key-1]->vat_price }}</td>
                                                  <td></td>
                                              </tr>
                                              @endif

                                              @if ($datas[$key-1]->discount != 0)
                                              <tr>
                                                  <td></td>
                                                  <td></td>
                                                  <td></td>
                                                  <td style="text-align:left;"><b>ส่วนลด</td>
                                                  <td></td>
                                                  <td>412900</td>
                                                  <td>ส่วนลดรับ</td>
                                                  <td></td>
                                                  <td></td>
                                                  <td><?php echo number_format($datas[$key-1]->discount, 2, '.', ''); ?></td>
                                              </tr>
                                              @endif

                                              @if ($datas[$key-1]->wht_percent != 0)
                                              <tr>
                                                  <td></td>
                                                  <td></td>
                                                  <td></td>
                                                  @if($datas[$key-1]->company_pay_wht == "255")
                                                  <td style="text-align:left;"><b>{{isCompanyWht($datas[$key-1]->company_pay_wht)}}</td>
                                                  @else
                                                  <td style="text-align:center;"><b>{{isCompanyWht($datas[$key-1]->company_pay_wht)}}</td>
                                                  @endif
                                                  <td></td>

                                                  @if($datas[$key-1]->company_pay_wht == 255)
                                                  <td>621708</td>
                                                  <td>ค่าใช้จ่ายในการบริหาร-ค่าภาษีหัก ณ ที่จ่ายออกแทน</td>
                                                  @elseif($datas[$key-1]->statusperson == 0)
                                                  <td>219402</td>
                                                  <td>ภาษีหัก ณ ที่จ่ายค้างจ่าย ภงด.3</td>
                                                  @elseif($datas[$key-1]->statusperson == 1)
                                                  <td>222002</td>
                                                  <td>ภาษีหัก ณ ที่จ่าย ภงด.53</td>
                                                  @else
                                                  <td>219401</td>
                                                  <td>ภาษีหัก ณ ที่จ่ายค้างจ่าย ภงด.1</td>
                                                  @endif
                                                  <td></td>
                                                  @if($datas[$key-1]->company_pay_wht == 255)
                                                  <td>{{$datas[$key-1]->wht}}</td>
                                                  <td></td>
                                                  @elseif($datas[$key-1]->statusperson == 0)
                                                  <td></td>
                                                  <td>{{$datas[$key-1]->wht}}</td>
                                                  @elseif($datas[$key-1]->statusperson == 1)
                                                  <td></td>
                                                  <td>{{$datas[$key-1]->wht}}</td>
                                                  @else
                                                  <td></td>
                                                  <td>{{$datas[$key-1]->wht}}</td>
                                                  @endif
                                              </tr>
                                              @endif

                                              @if ($datas[$key-1]->company_pay_wht == 255)
                                              <tr>
                                                  <td></td>
                                                  <td></td>
                                                  <td></td>
                                                  <td style="text-align:center;"><b>ภาษีหัก ณ ที่จ่าย</td>
                                                  <td></td>
                                                  @if ($datas[$key-1]->statusperson == 0)
                                                  <td>222001</td>
                                                  <td>ภาษีหัก ณ ที่จ่าย ภงด.3</td>
                                                  @elseif ($datas[$key-1]->statusperson == 1)
                                                  <td>222002</td>
                                                  <td>ภาษีหัก ณ ที่จ่าย ภงด.53</td>
                                                  @else
                                                  <td>222000</td>
                                                  <td>ภาษีหัก ณ ที่จ่าย ภงด.1</td>
                                                  @endif
                                                  <td></td>
                                                  <td></td>
                                                  <td>{{$datas[$key-1]->wht}}</td>
                                              </tr>
                                              @endif
                                            @endif

                                              @if ($datas[$key-1]->type == 1)
                                              <tr>
                                                  <td></td>
                                                  <td></td>
                                                  <td></td>
                                                  <td style="text-align:center;">
                                                      <b>{{ TypePay($datas[$key-1]->type_pay) }}
                                                  </td>
                                                  <td></td>
                                                  <td>
                                                    <?php if($datas[$key-1]->type_pay == 1) {
                                                        echo "111200"; ?>
                                                    <?php }elseif($datas[$key-1]->type_pay == 2) {
                                                        $string = $datas[$key-1]->account_bank;
                                                        $token = strtok($string, "|");
                                                        echo $token;
                                                    ?>
                                                    <?php }else {
                                                    } ?>
                                                  </td>
                                                  <td>
                                                    <?php if($datas[$key-1]->type_pay == 1) {
                                                        echo "เงินสด"; ?>
                                                    <?php }elseif($datas[$key-1]->type_pay == 2) {
                                                      $keep = stristr($datas[$key-1]->account_bank,"|");
                                                      echo substr($keep,1)
                                                    ?>
                                                    <?php }else {
                                                    } ?>
                                                  </td>
                                                  <td></td>
                                                  <td></td>
                                                  <td>
                                                    <?php if($datas[$key-1]->wht_percent >= 1.00 && $datas[$key-1]->company_pay_wht == 0.00) {
                                                            $showmoney = $datas[$key-1]->vat_price-$datas[$key-1]->wht;
                                                                echo number_format($showmoney, 2, '.', ''); ?>
                                                    <?php }else {
                                                            $showmoney1 = $datas[$key-1]->payout;
                                                                echo number_format($showmoney1, 2, '.', '');
                                                    } ?>
                                                  </td>
                                              </tr>
                                              @endif

                                              @if ($datas[$key-1]->type == 2)
                                              <tr>
                                                  <td></td>
                                                  <td></td>
                                                  <td></td>
                                                  <td style="text-align:center;">
                                                      <b>{{ TypePay($datas[$key-1]->type_pay) }}
                                                  </td>
                                                  <td></td>
                                                  <td>
                                                    <?php if($datas[$key-1]->type_pay == 1) {
                                                        echo "111200"; ?>
                                                    <?php }elseif($datas[$key-1]->type_pay == 2 && $datas[$key-1]->type_newtable == 1) {
                                                        $string = $datas[$key-1]->account_bank;
                                                        $token = strtok($string, "|");
                                                        echo $token;
                                                    ?>
                                                    <?php }elseif($datas[$key-1]->type_pay == 2 && $datas[$key-1]->branch_id == 1001) {
                                                        echo "112027";
                                                    ?>
                                                    <?php }elseif($datas[$key-1]->type_pay == 2 && $datas[$key-1]->branch_id == 1004) {
                                                        echo "112027";
                                                    ?>
                                                    <?php }elseif($datas[$key-1]->type_pay == 2 && $datas[$key-1]->branch_id == 1005) {
                                                        echo "112038";
                                                    ?>
                                                    <?php }elseif($datas[$key-1]->type_pay == 2 && $datas[$key-1]->branch_id == 1006) {
                                                        echo "112046";
                                                    ?>
                                                    <?php }elseif($datas[$key-1]->type_pay == 2 && $datas[$key-1]->branch_id == 1007) {
                                                        echo "112046";
                                                    ?>
                                                    <?php }elseif($datas[$key-1]->type_pay == 2 && $datas[$key-1]->branch_id == 1008) {
                                                        echo "112043";
                                                    ?>
                                                    <?php }elseif($datas[$key-1]->type_pay == 2 && $datas[$key-1]->branch_id == 1009) {
                                                        echo "112048";
                                                    ?>
                                                    <?php }elseif($datas[$key-1]->type_pay == 2 && $datas[$key-1]->branch_id == 1010) {
                                                        echo "112047";
                                                    ?>
                                                    <?php }elseif($datas[$key-1]->type_pay == 2 && $datas[$key-1]->branch_id == 1011) {
                                                        echo "112028";
                                                    ?>
                                                    <?php }elseif($datas[$key-1]->type_pay == 2 && $datas[$key-1]->branch_id == 1012) {
                                                        echo "112054";
                                                    ?>
                                                    <?php }elseif($datas[$key-1]->type_pay == 2 && $datas[$key-1]->branch_id == 1013) {
                                                        echo "112053";
                                                    ?>
                                                    <?php }elseif($datas[$key-1]->type_pay == 2 && $datas[$key-1]->branch_id == 1014) {
                                                        echo "112053";
                                                    ?>
                                                    <?php }elseif($datas[$key-1]->type_pay == 2 && $datas[$key-1]->branch_id == 1015) {
                                                        echo "112041";
                                                    ?>
                                                    <?php }elseif($datas[$key-1]->type_pay == 2 && $datas[$key-1]->branch_id == 1016) {
                                                        echo "112033";
                                                    ?>
                                                    <?php }elseif($datas[$key-1]->type_pay == 2 && $datas[$key-1]->branch_id == 1017) {
                                                        echo "112033";
                                                    ?>
                                                    <?php }elseif($datas[$key-1]->type_pay == 2 && $datas[$key-1]->branch_id == 1018) {
                                                        echo "112052";
                                                    ?>
                                                    <?php }elseif($datas[$key-1]->type_pay == 2 && $datas[$key-1]->branch_id == 1019) {
                                                        echo "112042";
                                                    ?>
                                                    <?php }elseif($datas[$key-1]->type_pay == 2 && $datas[$key-1]->branch_id == 1020) {
                                                        echo "112055";
                                                    ?>
                                                    <?php }elseif($datas[$key-1]->type_pay == 2 && $datas[$key-1]->branch_id == 1021) {
                                                        echo "112055";
                                                    ?>
                                                    <?php }elseif($datas[$key-1]->type_pay == 2 && $datas[$key-1]->branch_id == 1022) {
                                                        echo "112045";
                                                    ?>
                                                    <?php }elseif($datas[$key-1]->type_pay == 2 && $datas[$key-1]->branch_id == 1023) {
                                                        echo "112049";
                                                    ?>
                                                    <?php }elseif($datas[$key-1]->type_pay == 2 && $datas[$key-1]->branch_id == 1024) {
                                                        echo "112050";
                                                    ?>
                                                    <?php }elseif($datas[$key-1]->type_pay == 2 && $datas[$key-1]->branch_id == 1025) {
                                                        echo "112051";
                                                    ?>
                                                    <?php }elseif($datas[$key-1]->type_pay == 2 && $datas[$key-1]->branch_id == 1026) {
                                                        echo "112032";
                                                    ?>
                                                    <?php }elseif($datas[$key-1]->type_pay == 2 && $datas[$key-1]->branch_id == 1027) {
                                                        echo "112044";
                                                    ?>
                                                    <?php }elseif($datas[$key-1]->type_pay == 2 && $datas[$key-1]->branch_id == 1028) {
                                                        echo "112029";
                                                    ?>
                                                    <?php }elseif($datas[$key-1]->type_pay == 2 && $datas[$key-1]->branch_id == 1029) {
                                                        echo "112034";
                                                    ?>
                                                    <?php }else {
                                                    } ?>
                                                  </td>
                                                  <td>
                                                    <?php if($datas[$key-1]->type_pay == 1) {
                                                        echo "เงินสด"; ?>
                                                    <?php }elseif($datas[$key-1]->type_pay == 2 && $datas[$key-1]->type_newtable == 1) {
                                                      $keep = stristr($datas[$key-1]->account_bank,"|");
                                                      echo substr($keep,1)
                                                    ?>
                                                    <?php }elseif($datas[$key-1]->type_pay == 2 && $datas[$key-1]->branch_id == 1001) {
                                                        echo "เงินฝากออมทรัพย์ KBANK 587-2-25765-0 (เชียงใหม่)";
                                                    ?>
                                                    <?php }elseif($datas[$key-1]->type_pay == 2 && $datas[$key-1]->branch_id == 1004) {
                                                        echo "เงินฝากออมทรัพย์ KBANK 587-2-25765-0 (เชียงใหม่)";
                                                    ?>
                                                    <?php }elseif($datas[$key-1]->type_pay == 2 && $datas[$key-1]->branch_id == 1005) {
                                                        echo "เงินฝากออมทรัพย์ KBANK 014-3-90676-0 (ลำพูน)";
                                                    ?>
                                                    <?php }elseif($datas[$key-1]->type_pay == 2 && $datas[$key-1]->branch_id == 1006) {
                                                        echo "เงินฝากออมทรัพย์ KBANK 011-8-74641-4 (เชียงราย)";
                                                    ?>
                                                    <?php }elseif($datas[$key-1]->type_pay == 2 && $datas[$key-1]->branch_id == 1007) {
                                                        echo "เงินฝากออมทรัพย์ KBANK 011-8-74641-4 (เชียงราย)";
                                                    ?>
                                                    <?php }elseif($datas[$key-1]->type_pay == 2 && $datas[$key-1]->branch_id == 1008) {
                                                        echo "เงินฝากออมทรัพย์ KBANK 011-8-68918-6 (พะเยา)";
                                                    ?>
                                                    <?php }elseif($datas[$key-1]->type_pay == 2 && $datas[$key-1]->branch_id == 1009) {
                                                        echo "เงินฝากออมทรัพย์ KBANK 011-3-75497-4 (ลำปาง)";
                                                    ?>
                                                    <?php }elseif($datas[$key-1]->type_pay == 2 && $datas[$key-1]->branch_id == 1010) {
                                                        echo "เงินฝากออมทรัพย์ KBANK 013-3-83066-9 (สกลนคร)";
                                                    ?>
                                                    <?php }elseif($datas[$key-1]->type_pay == 2 && $datas[$key-1]->branch_id == 1011) {
                                                        echo "เงินฝากออมทรัพย์ KBANK 580-2-00222-1 (บางปะอิน)";
                                                    ?>
                                                    <?php }elseif($datas[$key-1]->type_pay == 2 && $datas[$key-1]->branch_id == 1012) {
                                                        echo "เงินฝากออมทรัพย์ KBANK 012-1-28303-4 (ลพบุรี)";
                                                    ?>
                                                    <?php }elseif($datas[$key-1]->type_pay == 2 && $datas[$key-1]->branch_id == 1013) {
                                                        echo "เงินฝากออมทรัพย์ KBANK 013-3-94803-1 (อุดรธานี)";
                                                    ?>
                                                    <?php }elseif($datas[$key-1]->type_pay == 2 && $datas[$key-1]->branch_id == 1014) {
                                                        echo "เงินฝากออมทรัพย์ KBANK 013-3-94803-1 (อุดรธานี)";
                                                    ?>
                                                    <?php }elseif($datas[$key-1]->type_pay == 2 && $datas[$key-1]->branch_id == 1015) {
                                                        echo "เงินฝากออมทรัพย์ KBANK 013-3-74618-8 (บุรีรัมย์)";
                                                    ?>
                                                    <?php }elseif($datas[$key-1]->type_pay == 2 && $datas[$key-1]->branch_id == 1016) {
                                                        echo "เงินฝากออมทรัพย์ KBANK 013-3-80020-4 (ขอนแก่น)";
                                                    ?>
                                                    <?php }elseif($datas[$key-1]->type_pay == 2 && $datas[$key-1]->branch_id == 1017) {
                                                        echo "เงินฝากออมทรัพย์ KBANK 013-3-80020-4 (ขอนแก่น)";
                                                    ?>
                                                    <?php }elseif($datas[$key-1]->type_pay == 2 && $datas[$key-1]->branch_id == 1018) {
                                                        echo "เงินฝากออมทรัพย์ KBANK 013-3- 77322-3 (มหาสารคาม)";
                                                    ?>
                                                    <?php }elseif($datas[$key-1]->type_pay == 2 && $datas[$key-1]->branch_id == 1019) {
                                                        echo "เงินฝากออมทรัพย์ KBANK 013-3-53944-1 (ร้อยเอ็ด)";
                                                    ?>
                                                    <?php }elseif($datas[$key-1]->type_pay == 2 && $datas[$key-1]->branch_id == 1020) {
                                                        echo "เงินฝากออมทรัพย์ KBANK 013-361402-8 (อุบลราชธานี)";
                                                    ?>
                                                    <?php }elseif($datas[$key-1]->type_pay == 2 && $datas[$key-1]->branch_id == 1021) {
                                                        echo "เงินฝากออมทรัพย์ KBANK 013-361402-8 (อุบลราชธานี)";
                                                    ?>
                                                    <?php }elseif($datas[$key-1]->type_pay == 2 && $datas[$key-1]->branch_id == 1022) {
                                                        echo "เงินฝากออมทรัพย์ KBANK 013-3-71800-1 (สุรินทร์)";
                                                    ?>
                                                    <?php }elseif($datas[$key-1]->type_pay == 2 && $datas[$key-1]->branch_id == 1023) {
                                                        echo "เงินฝากออมทรัพย์ KBANK 433-2-17759-7 (นครราชสีมา)";
                                                    ?>
                                                    <?php }elseif($datas[$key-1]->type_pay == 2 && $datas[$key-1]->branch_id == 1024) {
                                                        echo "เงินฝากออมทรัพย์ KBANK 008-140-1160 (นครราชสีมา2)";
                                                    ?>
                                                    <?php }elseif($datas[$key-1]->type_pay == 2 && $datas[$key-1]->branch_id == 1025) {
                                                        echo "เงินฝากออมทรัพย์ KBANK 433-2-52400-9 (นครราชสีมา3)";
                                                    ?>
                                                    <?php }elseif($datas[$key-1]->type_pay == 2 && $datas[$key-1]->branch_id == 1026) {
                                                        echo "เงินฝากออมทรัพย์ KBANK 960-2-10113-1 (หาดใหญ่)";
                                                    ?>
                                                    <?php }elseif($datas[$key-1]->type_pay == 2 && $datas[$key-1]->branch_id == 1027) {
                                                        echo "เงินฝากออมทรัพย์ KBANK 032-8-50533-9 (นครพนม)";
                                                    ?>
                                                    <?php }elseif($datas[$key-1]->type_pay == 2 && $datas[$key-1]->branch_id == 1028) {
                                                        echo "เงินฝากออมทรัพย์ KBANK 014-8-77067-0 (สุราษฎร์ธานี)";
                                                    ?>
                                                    <?php }elseif($datas[$key-1]->type_pay == 2 && $datas[$key-1]->branch_id == 1029) {
                                                        echo "เงินฝากออมทรัพย์ KBANK 014-8-69809-0 (นครศรีธรรมราช)";
                                                    ?>
                                                    <?php }else {
                                                    } ?>
                                                  </td>
                                                  <td></td>
                                                  <td></td>
                                                  <td>
                                                    <?php if($datas[$key-1]->wht_percent >= 1.00 && $datas[$key-1]->company_pay_wht == 0.00) {
                                                            $showmoney = $datas[$key-1]->payout;
                                                                echo number_format($showmoney, 2, '.', ''); ?>
                                                    <?php }else {
                                                            $showmoney1 = $datas[$key-1]->payout;
                                                                echo number_format($showmoney1, 2, '.', '');
                                                    } ?>
                                                  </td>
                                              </tr>
                                              @endif

                                              @if ($datas[$key-1]->type == 3)
                                              <tr>
                                                  <td></td>
                                                  <td></td>
                                                  <td></td>
                                                  <td style="text-align:center;"><b>เงินยืมกรรมการ</b></td>
                                                  <td></td>
                                                  <td>221100</td>
                                                  <td>เงินกู้ยืมจากกรรมการ</td>
                                                  <td></td>
                                                  <td></td>
                                                  <td>{{$datas[$key-1]->payout}}</td>
                                              </tr>
                                              @endif

                                              @if ($datas[$key-1]->type == 4)
                                              <tr>
                                                  <td></td>
                                                  <td></td>
                                                  <td></td>
                                                  <td style="text-align:center;"><b>เงินสดย่อย</b></td>
                                                  <td></td>
                                                  <td>111201</td>
                                                  <td>เงินสดย่อย</td>
                                                  <td></td>
                                                  <td></td>
                                                  <td>{{$datas[$key-1]->payout}}</td>
                                              </tr>
                                              @endif

                                              @if ($datas[$key-1]->type == 5)
                                              <tr>
                                                  <td></td>
                                                  <td></td>
                                                  <td></td>
                                                  <td style="text-align:center;"><b>คืนเงินสดย่อย</b></td>
                                                  <td></td>
                                                  <td>111201</td>
                                                  <td>เงินสดย่อย</td>
                                                  <td></td>
                                                  <td></td>
                                                  <td>{{$datas[$key-1]->payout}}</td>
                                              </tr>
                                              @endif

                                              @if ($datas[$key-1]->type == 6)
                                              <tr>
                                                  <td></td>
                                                  <td></td>
                                                  <td></td>
                                                  <td style="text-align:center;"><b>ลดหนี้</b></td>
                                                  <td></td>
                                                  <td></td>
                                                  <td></td>
                                                  <td></td>
                                                  <td></td>
                                                  <td>{{$datas[$key-1]->payout}}</td>
                                              </tr>
                                              @endif

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
                                                    <?php if ($datas[$key-1]->type == 1) {
                                                      $showpayput = $datas[$key-1]->payout;
                                                                 echo number_format($showpayput, 2, '.', ''); ?>
                                                    <?php  }else{ ?>
                                                    <?php  if($datas[$key-1]->vat_percent == 0 && $datas[$key-1]->discount == 0.00 && $datas[$key-1]->wht_percent == 0.00 && $datas[$key-1]->company_pay_wht == 0) {
                                                        $showsumcredits = $datas[$key-1]->payout;
                                                                  echo number_format($showsumcredits, 2, '.', ''); ?>
                                                    <?php  }elseif ($datas[$key-1]->vat_percent == 0 && $datas[$key-1]->discount >= 0.01 && $datas[$key-1]->wht_percent == 0.00 && $datas[$key-1]->company_pay_wht == 0) {
                                                        $showsumcredits = $datas[$key-1]->payout+$datas[$key-1]->discount;
                                                                  echo number_format($showsumcredits, 2, '.', ''); ?>
                                                    <?php  }elseif ($datas[$key-1]->vat_percent >= 1 && $datas[$key-1]->discount == 0.00 && $datas[$key-1]->wht_percent == 0.00 && $datas[$key-1]->company_pay_wht == 0) {
                                                        $showsumcredits = $datas[$key-1]->payout;
                                                                  echo number_format($showsumcredits, 2, '.', ''); ?>
                                                    <?php  }elseif ($datas[$key-1]->vat_percent >= 1 && $datas[$key-1]->discount >= 0.01 && $datas[$key-1]->wht_percent == 0.00 && $datas[$key-1]->company_pay_wht == 0) {
                                                        $showsumcredits = $datas[$key-1]->payout+$datas[$key-1]->discount;
                                                                  echo number_format($showsumcredits, 2, '.', ''); ?>
                                                    <?php  }elseif ($datas[$key-1]->vat_percent == 0 && $datas[$key-1]->discount == 0.00 && $datas[$key-1]->wht_percent >= 1.00 && $datas[$key-1]->company_pay_wht == 0) {
                                                        $showsumcredits = $datas[$key-1]->payout;
                                                                  echo number_format($showsumcredits, 2, '.', ''); ?>
                                                    <?php  }elseif ($datas[$key-1]->vat_percent == 0 && $datas[$key-1]->discount == 0.00 && $datas[$key-1]->wht_percent >= 1.00 && $datas[$key-1]->company_pay_wht == 255) {
                                                        $showsumcredits = $datas[$key-1]->payout+$datas[$key-1]->wht;
                                                                  echo number_format($showsumcredits, 2, '.', ''); ?>
                                                    <?php  }elseif ($datas[$key-1]->vat_percent == 0 && $datas[$key-1]->discount >= 0.01 && $datas[$key-1]->wht_percent >= 1.00 && $datas[$key-1]->company_pay_wht == 0) {
                                                        $showsumcredits = $datas[$key-1]->payout+$datas[$key-1]->discount;
                                                                  echo number_format($showsumcredits, 2, '.', ''); ?>
                                                    <?php  }elseif ($datas[$key-1]->vat_percent == 0 && $datas[$key-1]->discount >= 0.01 && $datas[$key-1]->wht_percent >= 1.00 && $datas[$key-1]->company_pay_wht == 255) {
                                                        $showsumcredits = $datas[$key-1]->payout+$datas[$key-1]->discount+$datas[$key-1]->wht;
                                                                  echo number_format($showsumcredits, 2, '.', ''); ?>
                                                    <?php  }elseif ($datas[$key-1]->vat_percent >= 1 && $datas[$key-1]->discount == 0.00 && $datas[$key-1]->wht_percent >= 1.00 && $datas[$key-1]->company_pay_wht == 0) {
                                                        $showsumcredits = $datas[$key-1]->payout+$datas[$key-1]->wht;
                                                                  echo number_format($showsumcredits, 2, '.', ''); ?>
                                                    <?php  }elseif ($datas[$key-1]->vat_percent >= 1 && $datas[$key-1]->discount == 0.00 && $datas[$key-1]->wht_percent >= 1.00 && $datas[$key-1]->company_pay_wht == 255) {
                                                        $showsumcredits = $datas[$key-1]->payout+$datas[$key-1]->wht;
                                                                  echo number_format($showsumcredits, 2, '.', ''); ?>
                                                    <?php  }elseif ($datas[$key-1]->vat_percent >= 1 && $datas[$key-1]->discount >= 0.01 && $datas[$key-1]->wht_percent >= 1.00 && $datas[$key-1]->company_pay_wht == 0) {
                                                        $showsumcredits = $datas[$key-1]->payout+$datas[$key-1]->discount;
                                                                  echo number_format($showsumcredits, 2, '.', ''); ?>
                                                    <?php  }elseif ($datas[$key-1]->vat_percent >= 1 && $datas[$key-1]->discount >= 0.01 && $datas[$key-1]->wht_percent >= 1.00 && $datas[$key-1]->company_pay_wht == 255) {
                                                        $showsumcredits = $datas[$key-1]->payout+$datas[$key-1]->discount+$datas[$key-1]->wht;
                                                                  echo number_format($showsumcredits, 2, '.', ''); ?>
                                                    <?php }else {
                                                                  echo "Code Error";
                                                    }} ?>
                                                  </b></td>
                                                  <td><b>
                                                    <?php if ($datas[$key-1]->type == 1) {
                                                      $showpayput = $datas[$key-1]->payout;
                                                                 echo number_format($showpayput, 2, '.', ''); ?>
                                                    <?php  }else{ ?>
                                                    <?php  if($datas[$key-1]->vat_percent == 0 && $datas[$key-1]->discount == 0.00 && $datas[$key-1]->wht_percent == 0.00 && $datas[$key-1]->company_pay_wht == 0) {
                                                        $showsumcredits = $datas[$key-1]->payout;
                                                                  echo number_format($showsumcredits, 2, '.', ''); ?>
                                                    <?php  }elseif ($datas[$key-1]->vat_percent == 0 && $datas[$key-1]->discount >= 0.01 && $datas[$key-1]->wht_percent == 0.00 && $datas[$key-1]->company_pay_wht == 0) {
                                                        $showsumcredits = $datas[$key-1]->payout+$datas[$key-1]->discount;
                                                                  echo number_format($showsumcredits, 2, '.', ''); ?>
                                                    <?php  }elseif ($datas[$key-1]->vat_percent >= 1 && $datas[$key-1]->discount == 0.00 && $datas[$key-1]->wht_percent == 0.00 && $datas[$key-1]->company_pay_wht == 0) {
                                                        $showsumcredits = $datas[$key-1]->payout;
                                                                  echo number_format($showsumcredits, 2, '.', ''); ?>
                                                    <?php  }elseif ($datas[$key-1]->vat_percent >= 1 && $datas[$key-1]->discount >= 0.01 && $datas[$key-1]->wht_percent == 0.00 && $datas[$key-1]->company_pay_wht == 0) {
                                                        $showsumcredits = $datas[$key-1]->payout+$datas[$key-1]->discount;
                                                                  echo number_format($showsumcredits, 2, '.', ''); ?>
                                                    <?php  }elseif ($datas[$key-1]->vat_percent == 0 && $datas[$key-1]->discount == 0.00 && $datas[$key-1]->wht_percent >= 1.00 && $datas[$key-1]->company_pay_wht == 0) {
                                                        $showsumcredits = $datas[$key-1]->payout;
                                                                  echo number_format($showsumcredits, 2, '.', ''); ?>
                                                    <?php  }elseif ($datas[$key-1]->vat_percent == 0 && $datas[$key-1]->discount == 0.00 && $datas[$key-1]->wht_percent >= 1.00 && $datas[$key-1]->company_pay_wht == 255) {
                                                        $showsumcredits = $datas[$key-1]->payout+$datas[$key-1]->wht;
                                                                  echo number_format($showsumcredits, 2, '.', ''); ?>
                                                    <?php  }elseif ($datas[$key-1]->vat_percent == 0 && $datas[$key-1]->discount >= 0.01 && $datas[$key-1]->wht_percent >= 1.00 && $datas[$key-1]->company_pay_wht == 0) {
                                                        $showsumcredits = $datas[$key-1]->payout+$datas[$key-1]->discount;
                                                                  echo number_format($showsumcredits, 2, '.', ''); ?>
                                                    <?php  }elseif ($datas[$key-1]->vat_percent == 0 && $datas[$key-1]->discount >= 0.01 && $datas[$key-1]->wht_percent >= 1.00 && $datas[$key-1]->company_pay_wht == 255) {
                                                        $showsumcredits = $datas[$key-1]->payout+$datas[$key-1]->discount+$datas[$key-1]->wht;
                                                                  echo number_format($showsumcredits, 2, '.', ''); ?>
                                                    <?php  }elseif ($datas[$key-1]->vat_percent >= 1 && $datas[$key-1]->discount == 0.00 && $datas[$key-1]->wht_percent >= 1.00 && $datas[$key-1]->company_pay_wht == 0) {
                                                        $showsumcredits = $datas[$key-1]->payout+$datas[$key-1]->wht;
                                                                  echo number_format($showsumcredits, 2, '.', ''); ?>
                                                    <?php  }elseif ($datas[$key-1]->vat_percent >= 1 && $datas[$key-1]->discount == 0.00 && $datas[$key-1]->wht_percent >= 1.00 && $datas[$key-1]->company_pay_wht == 255) {
                                                        $showsumcredits = $datas[$key-1]->payout+$datas[$key-1]->wht;
                                                                  echo number_format($showsumcredits, 2, '.', ''); ?>
                                                    <?php  }elseif ($datas[$key-1]->vat_percent >= 1 && $datas[$key-1]->discount >= 0.01 && $datas[$key-1]->wht_percent >= 1.00 && $datas[$key-1]->company_pay_wht == 0) {
                                                        $showsumcredits = $datas[$key-1]->payout+$datas[$key-1]->discount;
                                                                  echo number_format($showsumcredits, 2, '.', ''); ?>
                                                    <?php  }elseif ($datas[$key-1]->vat_percent >= 1 && $datas[$key-1]->discount >= 0.01 && $datas[$key-1]->wht_percent >= 1.00 && $datas[$key-1]->company_pay_wht == 255) {
                                                        $showsumcredits = $datas[$key-1]->payout+$datas[$key-1]->discount+$datas[$key-1]->wht;
                                                                  echo number_format($showsumcredits, 2, '.', ''); ?>
                                                    <?php }else {
                                                                  echo "Code Error";
                                                    }} ?>
                                                  </b></td>
                                              </tr>
                                          @endif

                                          <!-- เขียน row แรก แต่ละรายการ -->
                                          {!! Form::open(['route' => 'confirm_journal_pay', 'method' => 'post']) !!}
                                          <input type="hidden" name="type_newtable_ins" value="1">
                                          @if ($debt->type == 1)
                                              <!-- ถ้าเป็นการตั้งหนี้ -->
                                              <tr style="border-top-style:solid;">
                                                    <td>
                                                        @if($debt->accept == 0)
                                                        <label class="con">
                                                        <input type="checkbox" name="id_journal_pay[]" value="{{ $debt->id_ref }}">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                        @else
                                                        <i class="fa fa-check" style="color:green;font-size:20px;"></i>
                                                        @endif
                                                    </td>
                                                    <td>{{$debt->datebill}}</td>
                                                    <td>{{$debt->payser_number}}</td>
                                                    <td style="text-align:left;"><b>ค่า</b> {{$debt->list}} <b>ค้างจ่าย</b></td>
                                                    <td><?php
                                                      $text = $debt->note;
                                                      $newtext = wordwrap($text, 30, "<br />\n");
                                                      echo $newtext; ?>
                                                    </td>
                                                    <td>212100</td>
                                                    <td>เจ้าหนี้การค้า</td>
                                                    <td>{{$debt->branch_id}}</td>
                                                    <td>{{$debt->payout}}</td>
                                                    <td></td>
                                              </tr>
                                          @elseif ($debt->type == 2)
                                              <tr style="border-top-style:solid;">
                                              <!-- ถ้าเป็นการจ่ายเงินสด -->
                                                  <td>
                                                    @if($debt->accept == 0)
                                                    <label class="con">
                                                    <input type="checkbox" name="id_journal_pay[]" value="{{ $debt->id_ref }}">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                    @else
                                                    <i class="fa fa-check" style="color:green;font-size:20px;"></i>
                                                    @endif
                                                  </td>
                                                  <td>{{$debt->datebill }}</td>
                                                  <td>{{$debt->payser_number}}</td>
                                                  <td style="text-align:left;">{{$debt->list}}</td>
                                                  <td><?php
                                                    $text = $debt->note;
                                                    $newtext = wordwrap($text, 30, "<br />\n");
                                                    echo $newtext; ?>
                                                  </td>
                                                  <td>{{$debt->accounttypeno}}</td>
                                                  <td>{{$debt->accounttypefull}}</td>
                                                  <td>{{$debt->branch_id }}</td>
                                                  <td>{{$debt->total }}</td>
                                                  <td></td>
                                              </tr>

                                          @elseif ($debt->type == 3)
                                              <tr style="border-top-style:solid;">
                                              <!-- ถ้าเป็นการจ่ายแบบโอนตรงจากบัญชีส่วนตัวไปลูกค้า-->
                                                  <td>
                                                    @if($debt->accept == 0)
                                                    <label class="con">
                                                    <input type="checkbox" name="id_journal_pay[]" value="{{ $debt->id_ref }}">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                    @else
                                                    <i class="fa fa-check" style="color:green;font-size:20px;"></i>
                                                    @endif
                                                  </td>
                                                  <td>{{$debt->datebill }}</td>
                                                  <td>{{$debt->payser_number}}</td>
                                                  <td style="text-align:left;">{{$debt->list}}</td>
                                                  <td><?php
                                                    $text = $debt->note;
                                                    $newtext = wordwrap($text, 30, "<br />\n");
                                                    echo $newtext; ?>
                                                  </td>
                                                  <td>{{$debt->accounttypeno}}</td>
                                                  <td>{{$debt->accounttypefull}}</td>
                                                  <td>{{$debt->branch_id }}</td>
                                                  <td>{{$debt->total }}</td>
                                                  <td></td>
                                              </tr>

                                          @elseif ($debt->type == 4)
                                              <tr style="border-top-style:solid;">
                                              <!-- ถ้าเป็นการจ่ายแบบโอนตรงจากบัญชีส่วนตัวไปลูกค้า-->
                                                  <td>
                                                    @if($debt->accept == 0)
                                                    <label class="con">
                                                    <input type="checkbox" name="id_journal_pay[]" value="{{ $debt->id_ref }}">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                    @else
                                                    <i class="fa fa-check" style="color:green;font-size:20px;"></i>
                                                    @endif
                                                  </td>
                                                  <td>{{$debt->datebill }}</td>
                                                  <td>{{$debt->payser_number}}</td>
                                                  <td style="text-align:left;">{{$debt->list}}</td>
                                                  <td><?php
                                                    $text = $debt->note;
                                                    $newtext = wordwrap($text, 30, "<br />\n");
                                                    echo $newtext; ?>
                                                  </td>
                                                  <td>{{$debt->accounttypeno}}</td>
                                                  <td>{{$debt->accounttypefull}}</td>
                                                  <td>{{$debt->branch_id }}</td>
                                                  <td>{{$debt->total }}</td>
                                                  <td></td>
                                              </tr>
                                              <?php $sum_tot_Price1 = $debt->total; ?>

                                          @elseif ($debt->type == 5)
                                              <tr style="border-top-style:solid;">
                                              <!-- ถ้าเป็นการจ่ายแบบโอนตรงจากบัญชีส่วนตัวไปลูกค้า-->
                                                  <td>
                                                    @if($debt->accept == 0)
                                                    <label class="con">
                                                    <input type="checkbox" name="id_journal_pay[]" value="{{ $debt->id_ref }}">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                    @else
                                                    <i class="fa fa-check" style="color:green;font-size:20px;"></i>
                                                    @endif
                                                  </td>
                                                  <td>{{$debt->datebill }}</td>
                                                  <td>{{$debt->payser_number}}</td>
                                                  <td style="text-align:left;">{{$debt->list}}</td>
                                                  <td><?php
                                                    $text = $debt->note;
                                                    $newtext = wordwrap($text, 30, "<br />\n");
                                                    echo $newtext; ?>
                                                  </td>
                                                  <td>{{$debt->accounttypeno}}</td>
                                                  <td>{{$debt->accounttypefull}}</td>
                                                  <td>{{$debt->branch_id }}</td>
                                                  <td>{{$debt->total }}</td>
                                                  <td></td>
                                              </tr>

                                          @elseif ($debt->type == 6)
                                              <tr style="border-top-style:solid;">
                                              <!-- ถ้าเป็นการจ่ายแบบโอนตรงจากบัญชีส่วนตัวไปลูกค้า-->
                                                  <td>
                                                    @if($debt->accept == 0)
                                                    <label class="con">
                                                    <input type="checkbox" name="id_journal_pay[]" value="{{ $debt->id_ref }}">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                    @else
                                                    <i class="fa fa-check" style="color:green;font-size:20px;"></i>
                                                    @endif
                                                  </td>
                                                  <td>{{$debt->datebill }}</td>
                                                  <td>{{$debt->payser_number}}</td>
                                                  <td style="text-align:left;">{{$debt->list}}</td>
                                                  <td><?php
                                                    $text = $debt->note;
                                                    $newtext = wordwrap($text, 30, "<br />\n");
                                                    echo $newtext; ?>
                                                  </td>
                                                  <td>{{$debt->accounttypeno}}</td>
                                                  <td>{{$debt->accounttypefull}}</td>
                                                  <td>{{$debt->branch_id }}</td>
                                                  <td>{{$debt->total }}</td>
                                                  <td></td>
                                              </tr>

                                          @endif

                                          @if ($key == count($datas)-1)
                                              <!-- เขียนสำหรับรายการสุดท้าย ในกรณีที่มีแค่ list เดียว-->
                                            @if($debt->type >1)
                                              @if ($debt->vat_percent != 0)
                                              <tr>
                                                  <td></td>
                                                  <td></td>
                                                  <td></td>
                                                  <td style="text-align:left;"><b>ภาษีมูลค่าเพิ่ม</td>
                                                  <td></td>
                                                  <td>119501</td>
                                                  <td>ภาษีซื้อ</td>
                                                  <td></td>
                                                  <td>{{ $debt->vat_price }}</td>
                                                  <td></td>
                                              </tr>
                                              @endif

                                              @if ($debt->discount != 0)
                                              <tr>
                                                  <td></td>
                                                  <td></td>
                                                  <td></td>
                                                  <td style="text-align:left;"><b>ส่วนลด</td>
                                                  <td></td>
                                                  <td>412900</td>
                                                  <td>ส่วนลดรับ</td>
                                                  <td></td>
                                                  <td></td>
                                                  <td><?php echo number_format($debt->discount, 2, '.', ''); ?></td>
                                              </tr>
                                              @endif

                                              @if ($debt->wht_percent != 0)
                                              <tr>
                                                  <td></td>
                                                  <td></td>
                                                  <td></td>
                                                  @if($debt->company_pay_wht == "255")
                                                  <td style="text-align:left;"><b>{{isCompanyWht($debt->company_pay_wht)}}</td>
                                                  @else
                                                  <td style="text-align:center;"><b>{{isCompanyWht($debt->company_pay_wht)}}</td>
                                                  @endif
                                                  <td></td>

                                                  @if($debt->company_pay_wht == 255)
                                                  <td>621708</td>
                                                  <td>ค่าใช้จ่ายในการบริหาร-ค่าภาษีหัก ณ ที่จ่ายออกแทน</td>
                                                  @elseif($debt->statusperson == 0)
                                                  <td>219402</td>
                                                  <td>ภาษีหัก ณ ที่จ่ายค้างจ่าย ภงด.3</td>
                                                  @elseif($debt->statusperson == 1)
                                                  <td>222002</td>
                                                  <td>ภาษีหัก ณ ที่จ่าย ภงด.53</td>
                                                  @else
                                                  <td>219401</td>
                                                  <td>ภาษีหัก ณ ที่จ่ายค้างจ่าย ภงด.1</td>
                                                  @endif
                                                  <td></td>
                                                  @if($debt->company_pay_wht == 255)
                                                  <td>{{$debt->wht}}</td>
                                                  <td></td>
                                                  @elseif($debt->statusperson == 0)
                                                  <td></td>
                                                  <td>{{$debt->wht}}</td>
                                                  @elseif($debt->statusperson == 1)
                                                  <td></td>
                                                  <td>{{$debt->wht}}</td>
                                                  @else
                                                  <td></td>
                                                  <td>{{$debt->wht}}</td>
                                                  @endif
                                              </tr>
                                              @endif

                                              @if ($debt->company_pay_wht == 255)
                                              <tr>
                                                  <td></td>
                                                  <td></td>
                                                  <td></td>
                                                  <td style="text-align:center;"><b>ภาษีหัก ณ ที่จ่าย</td>
                                                  <td></td>
                                                  @if ($debt->statusperson == 0)
                                                  <td>222001</td>
                                                  <td>ภาษีหัก ณ ที่จ่าย ภงด.3</td>
                                                  @elseif ($debt->statusperson == 1)
                                                  <td>222002</td>
                                                  <td>ภาษีหัก ณ ที่จ่าย ภงด.53</td>
                                                  @else
                                                  <td>222000</td>
                                                  <td>ภาษีหัก ณ ที่จ่าย ภงด.1</td>
                                                  @endif
                                                  <td></td>
                                                  <td></td>
                                                  <td>{{$debt->wht}}</td>
                                              </tr>
                                              @endif
                                          @endif

                                              @if ($debt->type == 1)
                                              <tr>
                                                  <td></td>
                                                  <td></td>
                                                  <td></td>
                                                  <td style="text-align:center;">
                                                      <b>{{ TypePay($debt->type_pay) }}</b>
                                                  </td>
                                                  <td></td>
                                                  <td>
                                                    <?php if($debt->type_pay == 1) {
                                                        echo "111200"; ?>
                                                    <?php }elseif($debt->type_pay == 2) {
                                                        $string = $debt->account_bank;
                                                        $token = strtok($string, "|");
                                                        echo $token;
                                                    ?>
                                                    <?php }else {
                                                    } ?>
                                                  </td>
                                                  <td>
                                                    <?php if($debt->type_pay == 1) {
                                                        echo "เงินสด"; ?>
                                                    <?php }elseif($debt->type_pay == 2) {
                                                      $keep = stristr($debt->account_bank,"|");
                                                      echo substr($keep,1)
                                                    ?>
                                                    <?php }else {
                                                    } ?>
                                                  </td>
                                                  <td></td>
                                                  <td></td>
                                                  <td>
                                                    <?php if($debt->wht_percent >= 1.00 && $debt->company_pay_wht == 0.00) {
                                                            $showmoney = $debt->vat_price-$debt->wht;
                                                                echo number_format($showmoney, 2, '.', ''); ?>
                                                    <?php }else {
                                                            $showmoney1 = $debt->payout;
                                                                echo number_format($showmoney1, 2, '.', '');
                                                    } ?>
                                                  </td>
                                              </tr>
                                              @endif

                                              @if ($debt->type == 2)
                                              <tr>
                                                  <td></td>
                                                  <td></td>
                                                  <td></td>
                                                  <td style="text-align:center;">
                                                      <b>{{ TypePay($debt->type_pay) }}</b>
                                                  </td>
                                                  <td></td>
                                                  <td>
                                                    <?php if($debt->type_pay == 1) {
                                                        echo "111200"; ?>
                                                    <?php }elseif($debt->type_pay == 2 && $debt->type_newtable == 1) {
                                                        $string = $debt->account_bank;
                                                        $token = strtok($string, "|");
                                                        echo $token;
                                                    ?>
                                                    <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1001) {
                                                        echo "112027";
                                                    ?>
                                                    <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1004) {
                                                        echo "112027";
                                                    ?>
                                                    <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1005) {
                                                        echo "112038";
                                                    ?>
                                                    <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1006) {
                                                        echo "112046";
                                                    ?>
                                                    <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1007) {
                                                        echo "112046";
                                                    ?>
                                                    <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1008) {
                                                        echo "112043";
                                                    ?>
                                                    <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1009) {
                                                        echo "112048";
                                                    ?>
                                                    <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1010) {
                                                        echo "112047";
                                                    ?>
                                                    <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1011) {
                                                        echo "112028";
                                                    ?>
                                                    <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1012) {
                                                        echo "112054";
                                                    ?>
                                                    <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1013) {
                                                        echo "112053";
                                                    ?>
                                                    <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1014) {
                                                        echo "112053";
                                                    ?>
                                                    <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1015) {
                                                        echo "112041";
                                                    ?>
                                                    <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1016) {
                                                        echo "112033";
                                                    ?>
                                                    <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1017) {
                                                        echo "112033";
                                                    ?>
                                                    <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1018) {
                                                        echo "112052";
                                                    ?>
                                                    <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1019) {
                                                        echo "112042";
                                                    ?>
                                                    <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1020) {
                                                        echo "112055";
                                                    ?>
                                                    <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1021) {
                                                        echo "112055";
                                                    ?>
                                                    <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1022) {
                                                        echo "112045";
                                                    ?>
                                                    <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1023) {
                                                        echo "112049";
                                                    ?>
                                                    <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1024) {
                                                        echo "112050";
                                                    ?>
                                                    <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1025) {
                                                        echo "112051";
                                                    ?>
                                                    <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1026) {
                                                        echo "112032";
                                                    ?>
                                                    <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1027) {
                                                        echo "112044";
                                                    ?>
                                                    <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1028) {
                                                        echo "112029";
                                                    ?>
                                                    <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1029) {
                                                        echo "112034";
                                                    ?>
                                                    <?php }else {
                                                    } ?>
                                                  </td>
                                                  <td>
                                                    <?php if($debt->type_pay == 1) {
                                                        echo "เงินสด"; ?>
                                                    <?php }elseif($debt->type_pay == 2 && $debt->type_newtable == 1) {
                                                      $keep = stristr($debt->account_bank,"|");
                                                      echo substr($keep,1)
                                                    ?>
                                                    <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1001) {
                                                        echo "เงินฝากออมทรัพย์ KBANK 587-2-25765-0 (เชียงใหม่)";
                                                    ?>
                                                    <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1004) {
                                                        echo "เงินฝากออมทรัพย์ KBANK 587-2-25765-0 (เชียงใหม่)";
                                                    ?>
                                                    <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1005) {
                                                        echo "เงินฝากออมทรัพย์ KBANK 014-3-90676-0 (ลำพูน)";
                                                    ?>
                                                    <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1006) {
                                                        echo "เงินฝากออมทรัพย์ KBANK 011-8-74641-4 (เชียงราย)";
                                                    ?>
                                                    <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1007) {
                                                        echo "เงินฝากออมทรัพย์ KBANK 011-8-74641-4 (เชียงราย)";
                                                    ?>
                                                    <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1008) {
                                                        echo "เงินฝากออมทรัพย์ KBANK 011-8-68918-6 (พะเยา)";
                                                    ?>
                                                    <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1009) {
                                                        echo "เงินฝากออมทรัพย์ KBANK 011-3-75497-4 (ลำปาง)";
                                                    ?>
                                                    <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1010) {
                                                        echo "เงินฝากออมทรัพย์ KBANK 013-3-83066-9 (สกลนคร)";
                                                    ?>
                                                    <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1011) {
                                                        echo "เงินฝากออมทรัพย์ KBANK 580-2-00222-1 (บางปะอิน)";
                                                    ?>
                                                    <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1012) {
                                                        echo "เงินฝากออมทรัพย์ KBANK 012-1-28303-4 (ลพบุรี)";
                                                    ?>
                                                    <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1013) {
                                                        echo "เงินฝากออมทรัพย์ KBANK 013-3-94803-1 (อุดรธานี)";
                                                    ?>
                                                    <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1014) {
                                                        echo "เงินฝากออมทรัพย์ KBANK 013-3-94803-1 (อุดรธานี)";
                                                    ?>
                                                    <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1015) {
                                                        echo "เงินฝากออมทรัพย์ KBANK 013-3-74618-8 (บุรีรัมย์)";
                                                    ?>
                                                    <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1016) {
                                                        echo "เงินฝากออมทรัพย์ KBANK 013-3-80020-4 (ขอนแก่น)";
                                                    ?>
                                                    <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1017) {
                                                        echo "เงินฝากออมทรัพย์ KBANK 013-3-80020-4 (ขอนแก่น)";
                                                    ?>
                                                    <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1018) {
                                                        echo "เงินฝากออมทรัพย์ KBANK 013-3- 77322-3 (มหาสารคาม)";
                                                    ?>
                                                    <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1019) {
                                                        echo "เงินฝากออมทรัพย์ KBANK 013-3-53944-1 (ร้อยเอ็ด)";
                                                    ?>
                                                    <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1020) {
                                                        echo "เงินฝากออมทรัพย์ KBANK 013-361402-8 (อุบลราชธานี)";
                                                    ?>
                                                    <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1021) {
                                                        echo "เงินฝากออมทรัพย์ KBANK 013-361402-8 (อุบลราชธานี)";
                                                    ?>
                                                    <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1022) {
                                                        echo "เงินฝากออมทรัพย์ KBANK 013-3-71800-1 (สุรินทร์)";
                                                    ?>
                                                    <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1023) {
                                                        echo "เงินฝากออมทรัพย์ KBANK 433-2-17759-7 (นครราชสีมา)";
                                                    ?>
                                                    <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1024) {
                                                        echo "เงินฝากออมทรัพย์ KBANK 008-140-1160 (นครราชสีมา2)";
                                                    ?>
                                                    <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1025) {
                                                        echo "เงินฝากออมทรัพย์ KBANK 433-2-52400-9 (นครราชสีมา3)";
                                                    ?>
                                                    <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1026) {
                                                        echo "เงินฝากออมทรัพย์ KBANK 960-2-10113-1 (หาดใหญ่)";
                                                    ?>
                                                    <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1027) {
                                                        echo "เงินฝากออมทรัพย์ KBANK 032-8-50533-9 (นครพนม)";
                                                    ?>
                                                    <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1028) {
                                                        echo "เงินฝากออมทรัพย์ KBANK 014-8-77067-0 (สุราษฎร์ธานี)";
                                                    ?>
                                                    <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1029) {
                                                        echo "เงินฝากออมทรัพย์ KBANK 014-8-69809-0 (นครศรีธรรมราช)";
                                                    ?>
                                                    <?php }else {
                                                    } ?>
                                                  </td>
                                                  <td></td>
                                                  <td></td>
                                                  <td>
                                                    <?php if($debt->wht_percent >= 1.00 && $debt->company_pay_wht == 0.00) {
                                                            $showmoney = $debt->payout;
                                                                echo number_format($showmoney, 2, '.', ''); ?>
                                                    <?php }else {
                                                            $showmoney1 = $debt->payout;
                                                                echo number_format($showmoney1, 2, '.', '');
                                                    } ?>
                                                  </td>
                                              </tr>
                                              @endif

                                              @if ($debt->type == 3)
                                              <tr>
                                                  <td></td>
                                                  <td></td>
                                                  <td></td>
                                                  <td style="text-align:center;"><b>เงินยืมกรรมการ</b></td>
                                                  <td></td>
                                                  <td>221100</td>
                                                  <td>เงินกู้ยืมจากกรรมการ</td>
                                                  <td></td>
                                                  <td></td>
                                                  <td>{{$debt->payout}}</td>
                                              </tr>
                                              @endif

                                              @if ($debt->type == 4)
                                              <tr>
                                                  <td></td>
                                                  <td></td>
                                                  <td></td>
                                                  <td style="text-align:center;"><b>เงินสดย่อย</b></td>
                                                  <td></td>
                                                  <td>111201</td>
                                                  <td>เงินสดย่อย</td>
                                                  <td></td>
                                                  <td></td>
                                                  <td>{{$debt->payout}}</td>
                                              </tr>
                                              @endif

                                              @if ($debt->type == 5)
                                              <tr>
                                                  <td></td>
                                                  <td></td>
                                                  <td></td>
                                                  <td style="text-align:center;"><b>เงินสดย่อย</b></td>
                                                  <td></td>
                                                  <td>111201</td>
                                                  <td>เงินสดย่อย</td>
                                                  <td></td>
                                                  <td></td>
                                                  <td>{{$debt->payout}}</td>
                                              </tr>
                                              @endif

                                              @if ($debt->type == 6)
                                              <tr>
                                                  <td></td>
                                                  <td></td>
                                                  <td></td>
                                                  <td style="text-align:center;"><b>ลดหนี้</b></td>
                                                  <td></td>
                                                  <td></td>
                                                  <td></td>
                                                  <td></td>
                                                  <td></td>
                                                  <td>{{$debt->payout}}</td>
                                              </tr>
                                              @endif

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
                                                    <?php if ($debt->type == 1) {
                                                      $showpayput = $debt->payout;
                                                                 echo number_format($showpayput, 2, '.', ''); ?>
                                                    <?php  }else{ ?>
                                                    <?php  if($debt->vat_percent == 0 && $debt->discount == 0.00 && $debt->wht_percent == 0.00 && $debt->company_pay_wht == 0) {
                                                        $showsumcredits = $debt->payout;
                                                                  echo number_format($showsumcredits, 2, '.', ''); ?>
                                                    <?php  }elseif ($debt->vat_percent == 0 && $debt->discount >= 0.01 && $debt->wht_percent == 0.00 && $debt->company_pay_wht == 0) {
                                                        $showsumcredits = $debt->payout+$debt->discount;
                                                                  echo number_format($showsumcredits, 2, '.', ''); ?>
                                                    <?php  }elseif ($debt->vat_percent >= 1 && $debt->discount == 0.00 && $debt->wht_percent == 0.00 && $debt->company_pay_wht == 0) {
                                                        $showsumcredits = $debt->payout;
                                                                  echo number_format($showsumcredits, 2, '.', ''); ?>
                                                    <?php  }elseif ($debt->vat_percent >= 1 && $debt->discount >= 0.01 && $debt->wht_percent == 0.00 && $debt->company_pay_wht == 0) {
                                                        $showsumcredits = $debt->payout+$debt->discount;
                                                                  echo number_format($showsumcredits, 2, '.', ''); ?>
                                                    <?php  }elseif ($debt->vat_percent == 0 && $debt->discount == 0.00 && $debt->wht_percent >= 1.00 && $debt->company_pay_wht == 0) {
                                                        $showsumcredits = $debt->payout;
                                                                  echo number_format($showsumcredits, 2, '.', ''); ?>
                                                    <?php  }elseif ($debt->vat_percent == 0 && $debt->discount == 0.00 && $debt->wht_percent >= 1.00 && $debt->company_pay_wht == 255) {
                                                        $showsumcredits = $debt->payout+$debt->wht;
                                                                  echo number_format($showsumcredits, 2, '.', ''); ?>
                                                    <?php  }elseif ($debt->vat_percent == 0 && $debt->discount >= 0.01 && $debt->wht_percent >= 1.00 && $debt->company_pay_wht == 0) {
                                                        $showsumcredits = $debt->payout+$debt->discount;
                                                                  echo number_format($showsumcredits, 2, '.', ''); ?>
                                                    <?php  }elseif ($debt->vat_percent == 0 && $debt->discount >= 0.01 && $debt->wht_percent >= 1.00 && $debt->company_pay_wht == 255) {
                                                        $showsumcredits = $debt->payout+$debt->discount+$debt->wht;
                                                                  echo number_format($showsumcredits, 2, '.', ''); ?>
                                                    <?php  }elseif ($debt->vat_percent >= 1 && $debt->discount == 0.00 && $debt->wht_percent >= 1.00 && $debt->company_pay_wht == 0) {
                                                        $showsumcredits = $debt->payout+$debt->wht;
                                                                  echo number_format($showsumcredits, 2, '.', ''); ?>
                                                    <?php  }elseif ($debt->vat_percent >= 1 && $debt->discount == 0.00 && $debt->wht_percent >= 1.00 && $debt->company_pay_wht == 255) {
                                                        $showsumcredits = $debt->payout+$debt->wht;
                                                                  echo number_format($showsumcredits, 2, '.', ''); ?>
                                                    <?php  }elseif ($debt->vat_percent >= 1 && $debt->discount >= 0.01 && $debt->wht_percent >= 1.00 && $debt->company_pay_wht == 0) {
                                                        $showsumcredits = $debt->payout+$debt->discount;
                                                                  echo number_format($showsumcredits, 2, '.', ''); ?>
                                                    <?php  }elseif ($debt->vat_percent >= 1 && $debt->discount >= 0.01 && $debt->wht_percent >= 1.00 && $debt->company_pay_wht == 255) {
                                                        $showsumcredits = $debt->payout+$debt->discount+$debt->wht;
                                                                  echo number_format($showsumcredits, 2, '.', ''); ?>
                                                    <?php }else {
                                                                  echo "Code Error";
                                                    }} ?>
                                                  </b></td>
                                                  <td><b>
                                                    <?php if ($debt->type == 1) {
                                                      $showpayput = $debt->payout;
                                                                 echo number_format($showpayput, 2, '.', ''); ?>
                                                    <?php  }else{ ?>
                                                    <?php  if($debt->vat_percent == 0 && $debt->discount == 0.00 && $debt->wht_percent == 0.00 && $debt->company_pay_wht == 0) {
                                                        $showsumcredits = $debt->payout;
                                                                  echo number_format($showsumcredits, 2, '.', ''); ?>
                                                    <?php  }elseif ($debt->vat_percent == 0 && $debt->discount >= 0.01 && $debt->wht_percent == 0.00 && $debt->company_pay_wht == 0) {
                                                        $showsumcredits = $debt->payout+$debt->discount;
                                                                  echo number_format($showsumcredits, 2, '.', ''); ?>
                                                    <?php  }elseif ($debt->vat_percent >= 1 && $debt->discount == 0.00 && $debt->wht_percent == 0.00 && $debt->company_pay_wht == 0) {
                                                        $showsumcredits = $debt->payout;
                                                                  echo number_format($showsumcredits, 2, '.', ''); ?>
                                                    <?php  }elseif ($debt->vat_percent >= 1 && $debt->discount >= 0.01 && $debt->wht_percent == 0.00 && $debt->company_pay_wht == 0) {
                                                        $showsumcredits = $debt->payout+$debt->discount;
                                                                  echo number_format($showsumcredits, 2, '.', ''); ?>
                                                    <?php  }elseif ($debt->vat_percent == 0 && $debt->discount == 0.00 && $debt->wht_percent >= 1.00 && $debt->company_pay_wht == 0) {
                                                        $showsumcredits = $debt->payout;
                                                                  echo number_format($showsumcredits, 2, '.', ''); ?>
                                                    <?php  }elseif ($debt->vat_percent == 0 && $debt->discount == 0.00 && $debt->wht_percent >= 1.00 && $debt->company_pay_wht == 255) {
                                                        $showsumcredits = $debt->payout+$debt->wht;
                                                                  echo number_format($showsumcredits, 2, '.', ''); ?>
                                                    <?php  }elseif ($debt->vat_percent == 0 && $debt->discount >= 0.01 && $debt->wht_percent >= 1.00 && $debt->company_pay_wht == 0) {
                                                        $showsumcredits = $debt->payout+$debt->discount;
                                                                  echo number_format($showsumcredits, 2, '.', ''); ?>
                                                    <?php  }elseif ($debt->vat_percent == 0 && $debt->discount >= 0.01 && $debt->wht_percent >= 1.00 && $debt->company_pay_wht == 255) {
                                                        $showsumcredits = $debt->payout+$debt->discount+$debt->wht;
                                                                  echo number_format($showsumcredits, 2, '.', ''); ?>
                                                    <?php  }elseif ($debt->vat_percent >= 1 && $debt->discount == 0.00 && $debt->wht_percent >= 1.00 && $debt->company_pay_wht == 0) {
                                                        $showsumcredits = $debt->payout+$debt->wht;
                                                                  echo number_format($showsumcredits, 2, '.', ''); ?>
                                                    <?php  }elseif ($debt->vat_percent >= 1 && $debt->discount == 0.00 && $debt->wht_percent >= 1.00 && $debt->company_pay_wht == 255) {
                                                        $showsumcredits = $debt->payout+$debt->wht;
                                                                  echo number_format($showsumcredits, 2, '.', ''); ?>
                                                    <?php  }elseif ($debt->vat_percent >= 1 && $debt->discount >= 0.01 && $debt->wht_percent >= 1.00 && $debt->company_pay_wht == 0) {
                                                        $showsumcredits = $debt->payout+$debt->discount;
                                                                  echo number_format($showsumcredits, 2, '.', ''); ?>
                                                    <?php  }elseif ($debt->vat_percent >= 1 && $debt->discount >= 0.01 && $debt->wht_percent >= 1.00 && $debt->company_pay_wht == 255) {
                                                        $showsumcredits = $debt->payout+$debt->discount+$debt->wht;
                                                                  echo number_format($showsumcredits, 2, '.', ''); ?>
                                                    <?php }else {
                                                                  echo "Code Error";
                                                    }} ?>
                                                  </b></td>
                                              </tr>
                                          @endif

                                          <?php $ap = $debt->payser_number; ?>

                                      @endif
                                      <?php $ap_forold = $debt->bill_no; ?>
                                  @endforeach
                                  @endif


                                  @if ($type_data == 0)
                                  <input type="hidden" name="type_newtable_ins" value="0">
                                  @foreach ($datas as $key => $debt)

                                      @if ($debt->bill_no == $ap_forold)
                                      <!-- ถ้า ap เหมือนกันเขียนแค่ list -->
                                          @if ($debt->type == 2)
                                          <tr>
                                              <td></td>
                                              <td></td>
                                              <td></td>
                                              <td style="text-align:left;">{{$debt->list}}</td>
                                              <td><?php
                                                $text = $debt->note;
                                                $newtext = wordwrap($text, 30, "<br />\n");
                                                echo $newtext; ?>
                                              </td>
                                              <td>{{$debt->accounttypeno}}</td>
                                              <td>{{$debt->accounttypefull}}</td>
                                              <td></td>
                                              <td>{{$debt->total}}</td>
                                              <td></td>
                                          </tr>
                                          @endif

                                          @if ($key == count($datas)-1)
                                          <!-- เขียนสำหรับรายการสุดท้าย -->
                                              @if ($debt->type > 1 )
                                                  @if ($debt->vat_percent != 0)
                                                  <tr>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td style="text-align:left;"><b>ภาษีมูลค่าเพิ่ม</td>
                                                      <td></td>
                                                      <td>119501</td>
                                                      <td>ภาษีซื้อ</td>
                                                      <td></td>
                                                      <td><?php echo number_format($debt->vat_price, 2, '.', ''); ?></td>
                                                      <td></td>
                                                  </tr>
                                                  @endif

                                                  @if ($debt->discount != 0)
                                                  <tr>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td style="text-align:left;"><b>ส่วนลด</td>
                                                      <td></td>
                                                      <td>412900</td>
                                                      <td>ส่วนลดรับ</td>
                                                      <td></td>
                                                      <td></td>
                                                      <td><?php echo number_format($debt->discount, 2, '.', ''); ?></td>
                                                  </tr>
                                                  @endif

                                                  @if ($debt->wht_percent != 0)
                                                  <tr>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      @if($debt->company_pay_wht == "255")
                                                      <td style="text-align:left;"><b>{{isCompanyWht($debt->company_pay_wht)}}</td>
                                                      @else
                                                      <td style="text-align:center;"><b>{{isCompanyWht($debt->company_pay_wht)}}</td>
                                                      @endif
                                                      <td></td>
                                                        @if($debt->company_pay_wht == 255)
                                                        <td>621708</td>
                                                        <td>ค่าใช้จ่ายในการบริหาร-ค่าภาษีหัก ณ ที่จ่ายออกแทน</td>
                                                        @elseif($debt->statusperson == 0)
                                                        <td>219402</td>
                                                        <td>ภาษีหัก ณ ที่จ่ายค้างจ่าย ภงด.3</td>
                                                        @elseif($debt->statusperson == 1)
                                                        <td>222002</td>
                                                        <td>ภาษีหัก ณ ที่จ่าย ภงด.53</td>
                                                        @else
                                                        <td>219401</td>
                                                        <td>ภาษีหัก ณ ที่จ่ายค้างจ่าย ภงด.1</td>
                                                        @endif
                                                      <td></td>
                                                      @if($debt->company_pay_wht == 255)
                                                      <td>{{$debt->wht}}</td>
                                                      <td></td>
                                                      @elseif($debt->statusperson == 0)
                                                      <td></td>
                                                      <td>{{$debt->wht}}</td>
                                                      @elseif($debt->statusperson == 1)
                                                      <td></td>
                                                      <td>{{$debt->wht}}</td>
                                                      @else
                                                      <td></td>
                                                      <td>{{$debt->wht}}</td>
                                                      @endif
                                                  </tr>
                                                  @endif


                                                  @if ($debt->company_pay_wht == 255)
                                                  <tr>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td style="text-align:center;"><b>ภาษีหัก ณ ที่จ่าย</td>
                                                      <td></td>
                                                      @if ($debt->statusperson == 0)
                                                      <td>222001</td>
                                                      <td>ภาษีหัก ณ ที่จ่าย ภงด.3</td>
                                                      @elseif ($debt->statusperson == 1)
                                                      <td>222002</td>
                                                      <td>ภาษีหัก ณ ที่จ่าย ภงด.53</td>
                                                      @else
                                                      <td>222000</td>
                                                      <td>ภาษีหัก ณ ที่จ่าย ภงด.1</td>
                                                      @endif
                                                      <td></td>
                                                      <td></td>
                                                      <td>{{$debt->wht}}</td>
                                                  </tr>
                                                  @endif
                                              @endif

                                                  @if ($debt->type == 2)
                                                  <tr>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td style="text-align:center;">
                                                          <b>@if($debt->type_pay == 1)
                                                              เงินสด
                                                             @elseif ($debt->type_pay == 2)
                                                              เงินโอน
                                                             @endif
                                                          </b>
                                                      </td>
                                                      <td></td>
                                                      <td>
                                                        <?php if($debt->type_pay == 1) {
                                                            echo "111200"; ?>
                                                        <?php }elseif($debt->type_pay == 2 && $debt->type_newtable == 1) {
                                                            $string = $debt->account_bank;
                                                            $token = strtok($string, "|");
                                                            echo $token;
                                                        ?>
                                                        <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1001) {
                                                            echo "112027";
                                                        ?>
                                                        <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1004) {
                                                            echo "112027";
                                                        ?>
                                                        <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1005) {
                                                            echo "112038";
                                                        ?>
                                                        <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1006) {
                                                            echo "112046";
                                                        ?>
                                                        <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1007) {
                                                            echo "112046";
                                                        ?>
                                                        <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1008) {
                                                            echo "112043";
                                                        ?>
                                                        <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1009) {
                                                            echo "112048";
                                                        ?>
                                                        <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1010) {
                                                            echo "112047";
                                                        ?>
                                                        <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1011) {
                                                            echo "112028";
                                                        ?>
                                                        <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1012) {
                                                            echo "112054";
                                                        ?>
                                                        <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1013) {
                                                            echo "112053";
                                                        ?>
                                                        <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1014) {
                                                            echo "112053";
                                                        ?>
                                                        <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1015) {
                                                            echo "112041";
                                                        ?>
                                                        <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1016) {
                                                            echo "112033";
                                                        ?>
                                                        <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1017) {
                                                            echo "112033";
                                                        ?>
                                                        <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1018) {
                                                            echo "112052";
                                                        ?>
                                                        <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1019) {
                                                            echo "112042";
                                                        ?>
                                                        <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1020) {
                                                            echo "112055";
                                                        ?>
                                                        <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1021) {
                                                            echo "112055";
                                                        ?>
                                                        <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1022) {
                                                            echo "112045";
                                                        ?>
                                                        <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1023) {
                                                            echo "112049";
                                                        ?>
                                                        <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1024) {
                                                            echo "112050";
                                                        ?>
                                                        <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1025) {
                                                            echo "112051";
                                                        ?>
                                                        <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1026) {
                                                            echo "112032";
                                                        ?>
                                                        <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1027) {
                                                            echo "112044";
                                                        ?>
                                                        <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1028) {
                                                            echo "112029";
                                                        ?>
                                                        <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1029) {
                                                            echo "112034";
                                                        ?>
                                                        <?php }else {
                                                        } ?>
                                                      </td>
                                                      <td>
                                                        <?php if($debt->type_pay == 1) {
                                                            echo "เงินสด"; ?>
                                                        <?php }elseif($debt->type_pay == 2 && $debt->type_newtable == 1) {
                                                          $keep = stristr($debt->account_bank,"|");
                                                          echo substr($keep,1)
                                                        ?>
                                                        <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1001) {
                                                            echo "เงินฝากออมทรัพย์ KBANK 587-2-25765-0 (เชียงใหม่)";
                                                        ?>
                                                        <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1004) {
                                                            echo "เงินฝากออมทรัพย์ KBANK 587-2-25765-0 (เชียงใหม่)";
                                                        ?>
                                                        <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1005) {
                                                            echo "เงินฝากออมทรัพย์ KBANK 014-3-90676-0 (ลำพูน)";
                                                        ?>
                                                        <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1006) {
                                                            echo "เงินฝากออมทรัพย์ KBANK 011-8-74641-4 (เชียงราย)";
                                                        ?>
                                                        <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1007) {
                                                            echo "เงินฝากออมทรัพย์ KBANK 011-8-74641-4 (เชียงราย)";
                                                        ?>
                                                        <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1008) {
                                                            echo "เงินฝากออมทรัพย์ KBANK 011-8-68918-6 (พะเยา)";
                                                        ?>
                                                        <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1009) {
                                                            echo "เงินฝากออมทรัพย์ KBANK 011-3-75497-4 (ลำปาง)";
                                                        ?>
                                                        <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1010) {
                                                            echo "เงินฝากออมทรัพย์ KBANK 013-3-83066-9 (สกลนคร)";
                                                        ?>
                                                        <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1011) {
                                                            echo "เงินฝากออมทรัพย์ KBANK 580-2-00222-1 (บางปะอิน)";
                                                        ?>
                                                        <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1012) {
                                                            echo "เงินฝากออมทรัพย์ KBANK 012-1-28303-4 (ลพบุรี)";
                                                        ?>
                                                        <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1013) {
                                                            echo "เงินฝากออมทรัพย์ KBANK 013-3-94803-1 (อุดรธานี)";
                                                        ?>
                                                        <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1014) {
                                                            echo "เงินฝากออมทรัพย์ KBANK 013-3-94803-1 (อุดรธานี)";
                                                        ?>
                                                        <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1015) {
                                                            echo "เงินฝากออมทรัพย์ KBANK 013-3-74618-8 (บุรีรัมย์)";
                                                        ?>
                                                        <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1016) {
                                                            echo "เงินฝากออมทรัพย์ KBANK 013-3-80020-4 (ขอนแก่น)";
                                                        ?>
                                                        <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1017) {
                                                            echo "เงินฝากออมทรัพย์ KBANK 013-3-80020-4 (ขอนแก่น)";
                                                        ?>
                                                        <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1018) {
                                                            echo "เงินฝากออมทรัพย์ KBANK 013-3- 77322-3 (มหาสารคาม)";
                                                        ?>
                                                        <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1019) {
                                                            echo "เงินฝากออมทรัพย์ KBANK 013-3-53944-1 (ร้อยเอ็ด)";
                                                        ?>
                                                        <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1020) {
                                                            echo "เงินฝากออมทรัพย์ KBANK 013-361402-8 (อุบลราชธานี)";
                                                        ?>
                                                        <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1021) {
                                                            echo "เงินฝากออมทรัพย์ KBANK 013-361402-8 (อุบลราชธานี)";
                                                        ?>
                                                        <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1022) {
                                                            echo "เงินฝากออมทรัพย์ KBANK 013-3-71800-1 (สุรินทร์)";
                                                        ?>
                                                        <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1023) {
                                                            echo "เงินฝากออมทรัพย์ KBANK 433-2-17759-7 (นครราชสีมา)";
                                                        ?>
                                                        <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1024) {
                                                            echo "เงินฝากออมทรัพย์ KBANK 008-140-1160 (นครราชสีมา2)";
                                                        ?>
                                                        <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1025) {
                                                            echo "เงินฝากออมทรัพย์ KBANK 433-2-52400-9 (นครราชสีมา3)";
                                                        ?>
                                                        <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1026) {
                                                            echo "เงินฝากออมทรัพย์ KBANK 960-2-10113-1 (หาดใหญ่)";
                                                        ?>
                                                        <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1027) {
                                                            echo "เงินฝากออมทรัพย์ KBANK 032-8-50533-9 (นครพนม)";
                                                        ?>
                                                        <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1028) {
                                                            echo "เงินฝากออมทรัพย์ KBANK 014-8-77067-0 (สุราษฎร์ธานี)";
                                                        ?>
                                                        <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1029) {
                                                            echo "เงินฝากออมทรัพย์ KBANK 014-8-69809-0 (นครศรีธรรมราช)";
                                                        ?>
                                                        <?php }else {
                                                        } ?>
                                                      </td>
                                                      <td></td>
                                                      <td></td>
                                                      <td>{{ $debt->payout }}</td>
                                                  </tr>
                                                  @endif

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
                                                        <?php  if($debt->vat_percent == 0 && $debt->discount == 0.00 && $debt->wht_percent == 0.00) {
                                                            $showsumcredits = $debt->payout;
                                                                      echo number_format($showsumcredits, 2, '.', ''); ?>
                                                        <?php  }elseif ($debt->vat_percent >= 1 && $debt->discount == 0.00 && $debt->wht_percent == 0.00) {
                                                            $showsumcredits = $debt->payout;
                                                                      echo number_format($showsumcredits, 2, '.', ''); ?>
                                                        <?php  }elseif ($debt->vat_percent == 0 && $debt->discount == 0.00 && $debt->wht_percent >= 1.00) {
                                                            $showsumcredits = $debt->payout+$debt->wht;
                                                                      echo number_format($showsumcredits, 2, '.', ''); ?>
                                                        <?php  }elseif ($debt->vat_percent >= 1 && $debt->discount == 0.00 && $debt->wht_percent >= 1.00) {
                                                            $showsumcredits = $debt->payout+$debt->wht;
                                                                      echo number_format($showsumcredits, 2, '.', ''); ?>
                                                        <?php }else {
                                                                      echo "Code Error";
                                                        } ?>
                                                      </b></td>
                                                      <td><b>
                                                        <?php  if($debt->vat_percent == 0 && $debt->discount == 0.00 && $debt->wht_percent == 0.00) {
                                                            $showsumcredits = $debt->payout;
                                                                      echo number_format($showsumcredits, 2, '.', ''); ?>
                                                        <?php  }elseif ($debt->vat_percent >= 1 && $debt->discount == 0.00 && $debt->wht_percent == 0.00) {
                                                            $showsumcredits = $debt->payout;
                                                                      echo number_format($showsumcredits, 2, '.', ''); ?>
                                                        <?php  }elseif ($debt->vat_percent == 0 && $debt->discount == 0.00 && $debt->wht_percent >= 1.00) {
                                                            $showsumcredits = $debt->payout+$debt->wht;
                                                                      echo number_format($showsumcredits, 2, '.', ''); ?>
                                                        <?php  }elseif ($debt->vat_percent >= 1 && $debt->discount == 0.00 && $debt->wht_percent >= 1.00) {
                                                            $showsumcredits = $debt->payout+$debt->wht;
                                                                      echo number_format($showsumcredits, 2, '.', ''); ?>
                                                        <?php }else {
                                                                      echo "Code Error";
                                                        } ?>
                                                      </b></td>
                                                  </tr>
                                          @endif
                                          <?php $ap_forold = $debt->bill_no; ?>

                                      @else

                                          <!-- เปลี่ยนรายการ -->
                                          @if ($key != 0)
                                              <!-- ก่อนเปลี่ยนรายการเขียนปิดรายการก่อนหน้า -->
                                            @if($datas[$key-1]->type > 1)
                                              @if ($datas[$key-1]->vat_percent != 0)
                                              <tr>
                                                  <td></td>
                                                  <td></td>
                                                  <td></td>
                                                  <td style="text-align:left;"><b>ภาษีมูลค่าเพิ่ม</td>
                                                  <td></td>
                                                  <td>119501</td>
                                                  <td>ภาษีซื้อ</td>
                                                  <td></td>
                                                  <td><?php echo number_format($datas[$key-1]->vat_price, 2, '.', ''); ?></td>
                                                  <td></td>
                                              </tr>
                                              @endif

                                              @if ($datas[$key-1]->discount != 0)
                                              <tr>
                                                  <td></td>
                                                  <td></td>
                                                  <td></td>
                                                  <td style="text-align:left;"><b>ส่วนลด</td>
                                                  <td></td>
                                                  <td>412900</td>
                                                  <td>ส่วนลดรับ</td>
                                                  <td></td>
                                                  <td></td>
                                                  <td><?php echo number_format($datas[$key-1]->discount, 2, '.', ''); ?></td>
                                              </tr>
                                              @endif

                                              @if ($datas[$key-1]->wht_percent != 0)
                                              <tr>
                                                  <td></td>
                                                  <td></td>
                                                  <td></td>
                                                  @if($datas[$key-1]->company_pay_wht == "255")
                                                  <td style="text-align:left;"><b>{{isCompanyWht($datas[$key-1]->company_pay_wht)}}</td>
                                                  @else
                                                  <td style="text-align:center;"><b>{{isCompanyWht($datas[$key-1]->company_pay_wht)}}</td>
                                                  @endif
                                                  <td></td>

                                                  @if($datas[$key-1]->company_pay_wht == 255)
                                                  <td>621708</td>
                                                  <td>ค่าใช้จ่ายในการบริหาร-ค่าภาษีหัก ณ ที่จ่ายออกแทน</td>
                                                  @elseif($datas[$key-1]->statusperson == 0)
                                                  <td>219402</td>
                                                  <td>ภาษีหัก ณ ที่จ่ายค้างจ่าย ภงด.3</td>
                                                  @elseif($datas[$key-1]->statusperson == 1)
                                                  <td>222002</td>
                                                  <td>ภาษีหัก ณ ที่จ่าย ภงด.53</td>
                                                  @else
                                                  <td>219401</td>
                                                  <td>ภาษีหัก ณ ที่จ่ายค้างจ่าย ภงด.1</td>
                                                  @endif
                                                  <td></td>
                                                  @if($datas[$key-1]->company_pay_wht == 255)
                                                  <td>{{$datas[$key-1]->wht}}</td>
                                                  <td></td>
                                                  @elseif($datas[$key-1]->statusperson == 0)
                                                  <td></td>
                                                  <td>{{$datas[$key-1]->wht}}</td>
                                                  @elseif($datas[$key-1]->statusperson == 1)
                                                  <td></td>
                                                  <td>{{$datas[$key-1]->wht}}</td>
                                                  @else
                                                  <td></td>
                                                  <td>{{$datas[$key-1]->wht}}</td>
                                                  @endif
                                              </tr>
                                              @endif

                                              @if ($datas[$key-1]->company_pay_wht == 255)
                                              <tr>
                                                  <td></td>
                                                  <td></td>
                                                  <td></td>
                                                  <td style="text-align:center;"><b>ภาษีหัก ณ ที่จ่าย</td>
                                                  <td></td>
                                                  @if ($datas[$key-1]->statusperson == 0)
                                                  <td>222001</td>
                                                  <td>ภาษีหัก ณ ที่จ่าย ภงด.3</td>
                                                  @elseif ($datas[$key-1]->statusperson == 1)
                                                  <td>222002</td>
                                                  <td>ภาษีหัก ณ ที่จ่าย ภงด.53</td>
                                                  @else
                                                  <td>222000</td>
                                                  <td>ภาษีหัก ณ ที่จ่าย ภงด.1</td>
                                                  @endif
                                                  <td></td>
                                                  <td></td>
                                                  <td>{{$datas[$key-1]->wht}}</td>
                                              </tr>
                                              @endif
                                            @endif

                                              @if ($datas[$key-1]->type == 2)
                                              <tr>
                                                  <td></td>
                                                  <td></td>
                                                  <td></td>
                                                  <td style="text-align:center;">
                                                      <b>{{ TypePay($datas[$key-1]->type_pay) }}
                                                  </td>
                                                  <td></td>
                                                  <td>
                                                    <?php if($datas[$key-1]->type_pay == 1) {
                                                        echo "111200"; ?>
                                                    <?php }elseif($datas[$key-1]->type_pay == 2 && $datas[$key-1]->type_newtable == 1) {
                                                        $string = $datas[$key-1]->account_bank;
                                                        $token = strtok($string, "|");
                                                        echo $token;
                                                    ?>
                                                    <?php }elseif($datas[$key-1]->type_pay == 2 && $datas[$key-1]->branch_id == 1001) {
                                                        echo "112027";
                                                    ?>
                                                    <?php }elseif($datas[$key-1]->type_pay == 2 && $datas[$key-1]->branch_id == 1004) {
                                                        echo "112027";
                                                    ?>
                                                    <?php }elseif($datas[$key-1]->type_pay == 2 && $datas[$key-1]->branch_id == 1005) {
                                                        echo "112038";
                                                    ?>
                                                    <?php }elseif($datas[$key-1]->type_pay == 2 && $datas[$key-1]->branch_id == 1006) {
                                                        echo "112046";
                                                    ?>
                                                    <?php }elseif($datas[$key-1]->type_pay == 2 && $datas[$key-1]->branch_id == 1007) {
                                                        echo "112046";
                                                    ?>
                                                    <?php }elseif($datas[$key-1]->type_pay == 2 && $datas[$key-1]->branch_id == 1008) {
                                                        echo "112043";
                                                    ?>
                                                    <?php }elseif($datas[$key-1]->type_pay == 2 && $datas[$key-1]->branch_id == 1009) {
                                                        echo "112048";
                                                    ?>
                                                    <?php }elseif($datas[$key-1]->type_pay == 2 && $datas[$key-1]->branch_id == 1010) {
                                                        echo "112047";
                                                    ?>
                                                    <?php }elseif($datas[$key-1]->type_pay == 2 && $datas[$key-1]->branch_id == 1011) {
                                                        echo "112028";
                                                    ?>
                                                    <?php }elseif($datas[$key-1]->type_pay == 2 && $datas[$key-1]->branch_id == 1012) {
                                                        echo "112054";
                                                    ?>
                                                    <?php }elseif($datas[$key-1]->type_pay == 2 && $datas[$key-1]->branch_id == 1013) {
                                                        echo "112053";
                                                    ?>
                                                    <?php }elseif($datas[$key-1]->type_pay == 2 && $datas[$key-1]->branch_id == 1014) {
                                                        echo "112053";
                                                    ?>
                                                    <?php }elseif($datas[$key-1]->type_pay == 2 && $datas[$key-1]->branch_id == 1015) {
                                                        echo "112041";
                                                    ?>
                                                    <?php }elseif($datas[$key-1]->type_pay == 2 && $datas[$key-1]->branch_id == 1016) {
                                                        echo "112033";
                                                    ?>
                                                    <?php }elseif($datas[$key-1]->type_pay == 2 && $datas[$key-1]->branch_id == 1017) {
                                                        echo "112033";
                                                    ?>
                                                    <?php }elseif($datas[$key-1]->type_pay == 2 && $datas[$key-1]->branch_id == 1018) {
                                                        echo "112052";
                                                    ?>
                                                    <?php }elseif($datas[$key-1]->type_pay == 2 && $datas[$key-1]->branch_id == 1019) {
                                                        echo "112042";
                                                    ?>
                                                    <?php }elseif($datas[$key-1]->type_pay == 2 && $datas[$key-1]->branch_id == 1020) {
                                                        echo "112055";
                                                    ?>
                                                    <?php }elseif($datas[$key-1]->type_pay == 2 && $datas[$key-1]->branch_id == 1021) {
                                                        echo "112055";
                                                    ?>
                                                    <?php }elseif($datas[$key-1]->type_pay == 2 && $datas[$key-1]->branch_id == 1022) {
                                                        echo "112045";
                                                    ?>
                                                    <?php }elseif($datas[$key-1]->type_pay == 2 && $datas[$key-1]->branch_id == 1023) {
                                                        echo "112049";
                                                    ?>
                                                    <?php }elseif($datas[$key-1]->type_pay == 2 && $datas[$key-1]->branch_id == 1024) {
                                                        echo "112050";
                                                    ?>
                                                    <?php }elseif($datas[$key-1]->type_pay == 2 && $datas[$key-1]->branch_id == 1025) {
                                                        echo "112051";
                                                    ?>
                                                    <?php }elseif($datas[$key-1]->type_pay == 2 && $datas[$key-1]->branch_id == 1026) {
                                                        echo "112032";
                                                    ?>
                                                    <?php }elseif($datas[$key-1]->type_pay == 2 && $datas[$key-1]->branch_id == 1027) {
                                                        echo "112044";
                                                    ?>
                                                    <?php }elseif($datas[$key-1]->type_pay == 2 && $datas[$key-1]->branch_id == 1028) {
                                                        echo "112029";
                                                    ?>
                                                    <?php }elseif($datas[$key-1]->type_pay == 2 && $datas[$key-1]->branch_id == 1029) {
                                                        echo "112034";
                                                    ?>
                                                    <?php }else {
                                                    } ?>
                                                  </td>
                                                  <td>
                                                    <?php if($datas[$key-1]->type_pay == 1) {
                                                        echo "เงินสด"; ?>
                                                    <?php }elseif($datas[$key-1]->type_pay == 2 && $datas[$key-1]->type_newtable == 1) {
                                                      $keep = stristr($datas[$key-1]->account_bank,"|");
                                                      echo substr($keep,1)
                                                    ?>
                                                    <?php }elseif($datas[$key-1]->type_pay == 2 && $datas[$key-1]->branch_id == 1001) {
                                                        echo "เงินฝากออมทรัพย์ KBANK 587-2-25765-0 (เชียงใหม่)";
                                                    ?>
                                                    <?php }elseif($datas[$key-1]->type_pay == 2 && $datas[$key-1]->branch_id == 1004) {
                                                        echo "เงินฝากออมทรัพย์ KBANK 587-2-25765-0 (เชียงใหม่)";
                                                    ?>
                                                    <?php }elseif($datas[$key-1]->type_pay == 2 && $datas[$key-1]->branch_id == 1005) {
                                                        echo "เงินฝากออมทรัพย์ KBANK 014-3-90676-0 (ลำพูน)";
                                                    ?>
                                                    <?php }elseif($datas[$key-1]->type_pay == 2 && $datas[$key-1]->branch_id == 1006) {
                                                        echo "เงินฝากออมทรัพย์ KBANK 011-8-74641-4 (เชียงราย)";
                                                    ?>
                                                    <?php }elseif($datas[$key-1]->type_pay == 2 && $datas[$key-1]->branch_id == 1007) {
                                                        echo "เงินฝากออมทรัพย์ KBANK 011-8-74641-4 (เชียงราย)";
                                                    ?>
                                                    <?php }elseif($datas[$key-1]->type_pay == 2 && $datas[$key-1]->branch_id == 1008) {
                                                        echo "เงินฝากออมทรัพย์ KBANK 011-8-68918-6 (พะเยา)";
                                                    ?>
                                                    <?php }elseif($datas[$key-1]->type_pay == 2 && $datas[$key-1]->branch_id == 1009) {
                                                        echo "เงินฝากออมทรัพย์ KBANK 011-3-75497-4 (ลำปาง)";
                                                    ?>
                                                    <?php }elseif($datas[$key-1]->type_pay == 2 && $datas[$key-1]->branch_id == 1010) {
                                                        echo "เงินฝากออมทรัพย์ KBANK 013-3-83066-9 (สกลนคร)";
                                                    ?>
                                                    <?php }elseif($datas[$key-1]->type_pay == 2 && $datas[$key-1]->branch_id == 1011) {
                                                        echo "เงินฝากออมทรัพย์ KBANK 580-2-00222-1 (บางปะอิน)";
                                                    ?>
                                                    <?php }elseif($datas[$key-1]->type_pay == 2 && $datas[$key-1]->branch_id == 1012) {
                                                        echo "เงินฝากออมทรัพย์ KBANK 012-1-28303-4 (ลพบุรี)";
                                                    ?>
                                                    <?php }elseif($datas[$key-1]->type_pay == 2 && $datas[$key-1]->branch_id == 1013) {
                                                        echo "เงินฝากออมทรัพย์ KBANK 013-3-94803-1 (อุดรธานี)";
                                                    ?>
                                                    <?php }elseif($datas[$key-1]->type_pay == 2 && $datas[$key-1]->branch_id == 1014) {
                                                        echo "เงินฝากออมทรัพย์ KBANK 013-3-94803-1 (อุดรธานี)";
                                                    ?>
                                                    <?php }elseif($datas[$key-1]->type_pay == 2 && $datas[$key-1]->branch_id == 1015) {
                                                        echo "เงินฝากออมทรัพย์ KBANK 013-3-74618-8 (บุรีรัมย์)";
                                                    ?>
                                                    <?php }elseif($datas[$key-1]->type_pay == 2 && $datas[$key-1]->branch_id == 1016) {
                                                        echo "เงินฝากออมทรัพย์ KBANK 013-3-80020-4 (ขอนแก่น)";
                                                    ?>
                                                    <?php }elseif($datas[$key-1]->type_pay == 2 && $datas[$key-1]->branch_id == 1017) {
                                                        echo "เงินฝากออมทรัพย์ KBANK 013-3-80020-4 (ขอนแก่น)";
                                                    ?>
                                                    <?php }elseif($datas[$key-1]->type_pay == 2 && $datas[$key-1]->branch_id == 1018) {
                                                        echo "เงินฝากออมทรัพย์ KBANK 013-3- 77322-3 (มหาสารคาม)";
                                                    ?>
                                                    <?php }elseif($datas[$key-1]->type_pay == 2 && $datas[$key-1]->branch_id == 1019) {
                                                        echo "เงินฝากออมทรัพย์ KBANK 013-3-53944-1 (ร้อยเอ็ด)";
                                                    ?>
                                                    <?php }elseif($datas[$key-1]->type_pay == 2 && $datas[$key-1]->branch_id == 1020) {
                                                        echo "เงินฝากออมทรัพย์ KBANK 013-361402-8 (อุบลราชธานี)";
                                                    ?>
                                                    <?php }elseif($datas[$key-1]->type_pay == 2 && $datas[$key-1]->branch_id == 1021) {
                                                        echo "เงินฝากออมทรัพย์ KBANK 013-361402-8 (อุบลราชธานี)";
                                                    ?>
                                                    <?php }elseif($datas[$key-1]->type_pay == 2 && $datas[$key-1]->branch_id == 1022) {
                                                        echo "เงินฝากออมทรัพย์ KBANK 013-3-71800-1 (สุรินทร์)";
                                                    ?>
                                                    <?php }elseif($datas[$key-1]->type_pay == 2 && $datas[$key-1]->branch_id == 1023) {
                                                        echo "เงินฝากออมทรัพย์ KBANK 433-2-17759-7 (นครราชสีมา)";
                                                    ?>
                                                    <?php }elseif($datas[$key-1]->type_pay == 2 && $datas[$key-1]->branch_id == 1024) {
                                                        echo "เงินฝากออมทรัพย์ KBANK 008-140-1160 (นครราชสีมา2)";
                                                    ?>
                                                    <?php }elseif($datas[$key-1]->type_pay == 2 && $datas[$key-1]->branch_id == 1025) {
                                                        echo "เงินฝากออมทรัพย์ KBANK 433-2-52400-9 (นครราชสีมา3)";
                                                    ?>
                                                    <?php }elseif($datas[$key-1]->type_pay == 2 && $datas[$key-1]->branch_id == 1026) {
                                                        echo "เงินฝากออมทรัพย์ KBANK 960-2-10113-1 (หาดใหญ่)";
                                                    ?>
                                                    <?php }elseif($datas[$key-1]->type_pay == 2 && $datas[$key-1]->branch_id == 1027) {
                                                        echo "เงินฝากออมทรัพย์ KBANK 032-8-50533-9 (นครพนม)";
                                                    ?>
                                                    <?php }elseif($datas[$key-1]->type_pay == 2 && $datas[$key-1]->branch_id == 1028) {
                                                        echo "เงินฝากออมทรัพย์ KBANK 014-8-77067-0 (สุราษฎร์ธานี)";
                                                    ?>
                                                    <?php }elseif($datas[$key-1]->type_pay == 2 && $datas[$key-1]->branch_id == 1029) {
                                                        echo "เงินฝากออมทรัพย์ KBANK 014-8-69809-0 (นครศรีธรรมราช)";
                                                    ?>
                                                    <?php }else {
                                                    } ?>
                                                  </td>
                                                  <td></td>
                                                  <td></td>
                                                  <td>{{ $datas[$key-1]->payout }}</td>
                                              </tr>
                                              @endif

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
                                                    <?php  if($datas[$key-1]->vat_percent == 0 && $datas[$key-1]->discount == 0.00 && $datas[$key-1]->wht_percent == 0.00) {
                                                        $showsumcredits = $datas[$key-1]->payout;
                                                                  echo number_format($showsumcredits, 2, '.', ''); ?>
                                                    <?php  }elseif ($datas[$key-1]->vat_percent >= 1 && $datas[$key-1]->discount == 0.00 && $datas[$key-1]->wht_percent == 0.00) {
                                                        $showsumcredits = $datas[$key-1]->payout;
                                                                  echo number_format($showsumcredits, 2, '.', ''); ?>
                                                    <?php  }elseif ($datas[$key-1]->vat_percent == 0 && $datas[$key-1]->discount == 0.00 && $datas[$key-1]->wht_percent >= 1.00) {
                                                        $showsumcredits = $datas[$key-1]->payout+$datas[$key-1]->wht;
                                                                  echo number_format($showsumcredits, 2, '.', ''); ?>
                                                    <?php  }elseif ($datas[$key-1]->vat_percent >= 1 && $datas[$key-1]->discount == 0.00 && $datas[$key-1]->wht_percent >= 1.00) {
                                                        $showsumcredits = $datas[$key-1]->payout+$datas[$key-1]->wht;
                                                                  echo number_format($showsumcredits, 2, '.', ''); ?>
                                                    <?php }else {
                                                                  echo "Code Error";
                                                    } ?>
                                                  </b></td>
                                                  <td><b>
                                                    <?php  if($datas[$key-1]->vat_percent == 0 && $datas[$key-1]->discount == 0.00 && $datas[$key-1]->wht_percent == 0.00) {
                                                        $showsumcredits = $datas[$key-1]->payout;
                                                                  echo number_format($showsumcredits, 2, '.', ''); ?>
                                                    <?php  }elseif ($datas[$key-1]->vat_percent >= 1 && $datas[$key-1]->discount == 0.00 && $datas[$key-1]->wht_percent == 0.00) {
                                                        $showsumcredits = $datas[$key-1]->payout;
                                                                  echo number_format($showsumcredits, 2, '.', ''); ?>
                                                    <?php  }elseif ($datas[$key-1]->vat_percent == 0 && $datas[$key-1]->discount == 0.00 && $datas[$key-1]->wht_percent >= 1.00) {
                                                        $showsumcredits = $datas[$key-1]->payout+$datas[$key-1]->wht;
                                                                  echo number_format($showsumcredits, 2, '.', ''); ?>
                                                    <?php  }elseif ($datas[$key-1]->vat_percent >= 1 && $datas[$key-1]->discount == 0.00 && $datas[$key-1]->wht_percent >= 1.00) {
                                                        $showsumcredits = $datas[$key-1]->payout+$datas[$key-1]->wht;
                                                                  echo number_format($showsumcredits, 2, '.', ''); ?>
                                                    <?php }else {
                                                                  echo "Code Error";
                                                    } ?>
                                                  </b></td>
                                              </tr>
                                          @endif

                                          <!-- เขียน row แรก แต่ละรายการ -->
                                          {!! Form::open(['route' => 'confirm_journal_pay', 'method' => 'post']) !!}

                                          @if ($debt->type == 2)
                                            <tr style="border-top-style:solid;">
                                            <!-- ถ้าเป็นการจ่ายเงินสด -->
                                                <td>
                                                  @if($debt->accept == 0)
                                                  <label class="con">
                                                  <input type="checkbox" name="id_journal_pay[]" value="{{ $debt->id_ref }}">
                                                      <span class="checkmark"></span>
                                                  </label>
                                                  @else
                                                  <i class="fa fa-check" style="color:green;font-size:20px;"></i>
                                                  @endif
                                                </td>
                                                <td>{{$debt->datebill }}</td>
                                                <td>{{$debt->id_pv}}</td>
                                                <td style="text-align:left;">{{$debt->list}}</td>
                                                <td><?php
                                                  $text = $debt->note;
                                                  $newtext = wordwrap($text, 30, "<br />\n");
                                                  echo $newtext; ?>
                                                </td>
                                                <td>{{$debt->accounttypeno}}</td>
                                                <td>{{$debt->accounttypefull}}</td>
                                                <td>{{$debt->branch_id }}</td>
                                                <td>{{$debt->total }}</td>
                                                <td></td>
                                            </tr>
                                          @endif

                                          @if ($key == count($datas)-1)
                                              <!-- เขียนสำหรับรายการสุดท้าย ในกรณีที่มีแค่ list เดียว-->
                                            @if($debt->type >1)
                                              @if ($debt->vat_percent != 0)
                                              <tr>
                                                  <td></td>
                                                  <td></td>
                                                  <td></td>
                                                  <td style="text-align:left;"><b>ภาษีมูลค่าเพิ่ม</td>
                                                  <td></td>
                                                  <td>119501</td>
                                                  <td>ภาษีซื้อ</td>
                                                  <td></td>
                                                  <td><?php echo number_format($debt->vat_price, 2, '.', ''); ?></td>
                                                  <td></td>
                                              </tr>
                                              @endif

                                              @if ($debt->discount != 0)
                                              <tr>
                                                  <td></td>
                                                  <td></td>
                                                  <td></td>
                                                  <td style="text-align:left;"><b>ส่วนลด</td>
                                                  <td></td>
                                                  <td>412900</td>
                                                  <td>ส่วนลดรับ</td>
                                                  <td></td>
                                                  <td></td>
                                                  <td><?php echo number_format($debt->discount, 2, '.', ''); ?></td>
                                              </tr>
                                              @endif

                                              @if ($debt->wht_percent != 0)
                                              <tr>
                                                  <td></td>
                                                  <td></td>
                                                  <td></td>
                                                  @if($debt->company_pay_wht == "255")
                                                  <td style="text-align:left;"><b>{{isCompanyWht($debt->company_pay_wht)}}</td>
                                                  @else
                                                  <td style="text-align:center;"><b>{{isCompanyWht($debt->company_pay_wht)}}</td>
                                                  @endif
                                                  <td></td>

                                                  @if($debt->company_pay_wht == 255)
                                                  <td>621708</td>
                                                  <td>ค่าใช้จ่ายในการบริหาร-ค่าภาษีหัก ณ ที่จ่ายออกแทน</td>
                                                  @elseif($debt->statusperson == 0)
                                                  <td>219402</td>
                                                  <td>ภาษีหัก ณ ที่จ่ายค้างจ่าย ภงด.3</td>
                                                  @elseif($debt->statusperson == 1)
                                                  <td>222002</td>
                                                  <td>ภาษีหัก ณ ที่จ่าย ภงด.53</td>
                                                  @else
                                                  <td>219401</td>
                                                  <td>ภาษีหัก ณ ที่จ่ายค้างจ่าย ภงด.1</td>
                                                  @endif
                                                  <td></td>
                                                  @if($debt->company_pay_wht == 255)
                                                  <td>{{$debt->wht}}</td>
                                                  <td></td>
                                                  @elseif($debt->statusperson == 0)
                                                  <td></td>
                                                  <td>{{$debt->wht}}</td>
                                                  @elseif($debt->statusperson == 1)
                                                  <td></td>
                                                  <td>{{$debt->wht}}</td>
                                                  @else
                                                  <td></td>
                                                  <td>{{$debt->wht}}</td>
                                                  @endif
                                              </tr>
                                              @endif

                                              @if ($debt->company_pay_wht == 255)
                                              <tr>
                                                  <td></td>
                                                  <td></td>
                                                  <td></td>
                                                  <td style="text-align:center;"><b>ภาษีหัก ณ ที่จ่าย</td>
                                                  <td></td>
                                                  @if ($debt->statusperson == 0)
                                                  <td>222001</td>
                                                  <td>ภาษีหัก ณ ที่จ่าย ภงด.3</td>
                                                  @elseif ($debt->statusperson == 1)
                                                  <td>222002</td>
                                                  <td>ภาษีหัก ณ ที่จ่าย ภงด.53</td>
                                                  @else
                                                  <td>222000</td>
                                                  <td>ภาษีหัก ณ ที่จ่าย ภงด.1</td>
                                                  @endif
                                                  <td></td>
                                                  <td></td>
                                                  <td>{{$debt->wht}}</td>
                                              </tr>
                                              @endif
                                            @endif

                                              @if ($debt->type == 2)
                                              <tr>
                                                  <td></td>
                                                  <td></td>
                                                  <td></td>
                                                  <td style="text-align:center;">
                                                      <b>{{ TypePay($debt->type_pay) }}</b>
                                                  </td>
                                                  <td></td>
                                                  <td>
                                                    <?php if($debt->type_pay == 1) {
                                                        echo "111200"; ?>
                                                    <?php }elseif($debt->type_pay == 2 && $debt->type_newtable == 1) {
                                                        $string = $debt->account_bank;
                                                        $token = strtok($string, "|");
                                                        echo $token;
                                                    ?>
                                                    <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1001) {
                                                        echo "112027";
                                                    ?>
                                                    <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1004) {
                                                        echo "112027";
                                                    ?>
                                                    <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1005) {
                                                        echo "112038";
                                                    ?>
                                                    <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1006) {
                                                        echo "112046";
                                                    ?>
                                                    <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1007) {
                                                        echo "112046";
                                                    ?>
                                                    <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1008) {
                                                        echo "112043";
                                                    ?>
                                                    <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1009) {
                                                        echo "112048";
                                                    ?>
                                                    <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1010) {
                                                        echo "112047";
                                                    ?>
                                                    <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1011) {
                                                        echo "112028";
                                                    ?>
                                                    <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1012) {
                                                        echo "112054";
                                                    ?>
                                                    <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1013) {
                                                        echo "112053";
                                                    ?>
                                                    <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1014) {
                                                        echo "112053";
                                                    ?>
                                                    <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1015) {
                                                        echo "112041";
                                                    ?>
                                                    <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1016) {
                                                        echo "112033";
                                                    ?>
                                                    <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1017) {
                                                        echo "112033";
                                                    ?>
                                                    <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1018) {
                                                        echo "112052";
                                                    ?>
                                                    <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1019) {
                                                        echo "112042";
                                                    ?>
                                                    <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1020) {
                                                        echo "112055";
                                                    ?>
                                                    <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1021) {
                                                        echo "112055";
                                                    ?>
                                                    <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1022) {
                                                        echo "112045";
                                                    ?>
                                                    <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1023) {
                                                        echo "112049";
                                                    ?>
                                                    <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1024) {
                                                        echo "112050";
                                                    ?>
                                                    <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1025) {
                                                        echo "112051";
                                                    ?>
                                                    <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1026) {
                                                        echo "112032";
                                                    ?>
                                                    <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1027) {
                                                        echo "112044";
                                                    ?>
                                                    <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1028) {
                                                        echo "112029";
                                                    ?>
                                                    <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1029) {
                                                        echo "112034";
                                                    ?>
                                                    <?php }else {
                                                    } ?>
                                                  </td>
                                                  <td>
                                                    <?php if($debt->type_pay == 1) {
                                                        echo "เงินสด"; ?>
                                                    <?php }elseif($debt->type_pay == 2 && $debt->type_newtable == 1) {
                                                      $keep = stristr($debt->account_bank,"|");
                                                      echo substr($keep,1)
                                                    ?>
                                                    <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1001) {
                                                        echo "เงินฝากออมทรัพย์ KBANK 587-2-25765-0 (เชียงใหม่)";
                                                    ?>
                                                    <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1004) {
                                                        echo "เงินฝากออมทรัพย์ KBANK 587-2-25765-0 (เชียงใหม่)";
                                                    ?>
                                                    <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1005) {
                                                        echo "เงินฝากออมทรัพย์ KBANK 014-3-90676-0 (ลำพูน)";
                                                    ?>
                                                    <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1006) {
                                                        echo "เงินฝากออมทรัพย์ KBANK 011-8-74641-4 (เชียงราย)";
                                                    ?>
                                                    <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1007) {
                                                        echo "เงินฝากออมทรัพย์ KBANK 011-8-74641-4 (เชียงราย)";
                                                    ?>
                                                    <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1008) {
                                                        echo "เงินฝากออมทรัพย์ KBANK 011-8-68918-6 (พะเยา)";
                                                    ?>
                                                    <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1009) {
                                                        echo "เงินฝากออมทรัพย์ KBANK 011-3-75497-4 (ลำปาง)";
                                                    ?>
                                                    <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1010) {
                                                        echo "เงินฝากออมทรัพย์ KBANK 013-3-83066-9 (สกลนคร)";
                                                    ?>
                                                    <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1011) {
                                                        echo "เงินฝากออมทรัพย์ KBANK 580-2-00222-1 (บางปะอิน)";
                                                    ?>
                                                    <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1012) {
                                                        echo "เงินฝากออมทรัพย์ KBANK 012-1-28303-4 (ลพบุรี)";
                                                    ?>
                                                    <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1013) {
                                                        echo "เงินฝากออมทรัพย์ KBANK 013-3-94803-1 (อุดรธานี)";
                                                    ?>
                                                    <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1014) {
                                                        echo "เงินฝากออมทรัพย์ KBANK 013-3-94803-1 (อุดรธานี)";
                                                    ?>
                                                    <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1015) {
                                                        echo "เงินฝากออมทรัพย์ KBANK 013-3-74618-8 (บุรีรัมย์)";
                                                    ?>
                                                    <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1016) {
                                                        echo "เงินฝากออมทรัพย์ KBANK 013-3-80020-4 (ขอนแก่น)";
                                                    ?>
                                                    <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1017) {
                                                        echo "เงินฝากออมทรัพย์ KBANK 013-3-80020-4 (ขอนแก่น)";
                                                    ?>
                                                    <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1018) {
                                                        echo "เงินฝากออมทรัพย์ KBANK 013-3- 77322-3 (มหาสารคาม)";
                                                    ?>
                                                    <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1019) {
                                                        echo "เงินฝากออมทรัพย์ KBANK 013-3-53944-1 (ร้อยเอ็ด)";
                                                    ?>
                                                    <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1020) {
                                                        echo "เงินฝากออมทรัพย์ KBANK 013-361402-8 (อุบลราชธานี)";
                                                    ?>
                                                    <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1021) {
                                                        echo "เงินฝากออมทรัพย์ KBANK 013-361402-8 (อุบลราชธานี)";
                                                    ?>
                                                    <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1022) {
                                                        echo "เงินฝากออมทรัพย์ KBANK 013-3-71800-1 (สุรินทร์)";
                                                    ?>
                                                    <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1023) {
                                                        echo "เงินฝากออมทรัพย์ KBANK 433-2-17759-7 (นครราชสีมา)";
                                                    ?>
                                                    <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1024) {
                                                        echo "เงินฝากออมทรัพย์ KBANK 008-140-1160 (นครราชสีมา2)";
                                                    ?>
                                                    <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1025) {
                                                        echo "เงินฝากออมทรัพย์ KBANK 433-2-52400-9 (นครราชสีมา3)";
                                                    ?>
                                                    <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1026) {
                                                        echo "เงินฝากออมทรัพย์ KBANK 960-2-10113-1 (หาดใหญ่)";
                                                    ?>
                                                    <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1027) {
                                                        echo "เงินฝากออมทรัพย์ KBANK 032-8-50533-9 (นครพนม)";
                                                    ?>
                                                    <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1028) {
                                                        echo "เงินฝากออมทรัพย์ KBANK 014-8-77067-0 (สุราษฎร์ธานี)";
                                                    ?>
                                                    <?php }elseif($debt->type_pay == 2 && $debt->branch_id == 1029) {
                                                        echo "เงินฝากออมทรัพย์ KBANK 014-8-69809-0 (นครศรีธรรมราช)";
                                                    ?>
                                                    <?php }else {
                                                    } ?>
                                                  </td>
                                                  <td></td>
                                                  <td></td>
                                                  <td>{{ $debt->payout }}</td>
                                              </tr>
                                              @endif

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
                                                    <?php  if($debt->vat_percent == 0 && $debt->discount == 0.00 && $debt->wht_percent == 0.00) {
                                                        $showsumcredits = $debt->payout;
                                                                  echo number_format($showsumcredits, 2, '.', ''); ?>
                                                    <?php  }elseif ($debt->vat_percent >= 1 && $debt->discount == 0.00 && $debt->wht_percent == 0.00) {
                                                        $showsumcredits = $debt->payout;
                                                                  echo number_format($showsumcredits, 2, '.', ''); ?>
                                                    <?php  }elseif ($debt->vat_percent == 0 && $debt->discount == 0.00 && $debt->wht_percent >= 1.00) {
                                                        $showsumcredits = $debt->payout+$debt->wht;
                                                                  echo number_format($showsumcredits, 2, '.', ''); ?>
                                                    <?php  }elseif ($debt->vat_percent >= 1 && $debt->discount == 0.00 && $debt->wht_percent >= 1.00) {
                                                        $showsumcredits = $debt->payout+$debt->wht;
                                                                  echo number_format($showsumcredits, 2, '.', ''); ?>
                                                    <?php }else {
                                                                  echo "Code Error";
                                                    } ?>
                                                  </b></td>
                                                  <td><b>
                                                    <?php  if($debt->vat_percent == 0 && $debt->discount == 0.00 && $debt->wht_percent == 0.00) {
                                                        $showsumcredits = $debt->payout;
                                                                  echo number_format($showsumcredits, 2, '.', ''); ?>
                                                    <?php  }elseif ($debt->vat_percent >= 1 && $debt->discount == 0.00 && $debt->wht_percent == 0.00) {
                                                        $showsumcredits = $debt->payout;
                                                                  echo number_format($showsumcredits, 2, '.', ''); ?>
                                                    <?php  }elseif ($debt->vat_percent == 0 && $debt->discount == 0.00 && $debt->wht_percent >= 1.00) {
                                                        $showsumcredits = $debt->payout+$debt->wht;
                                                                  echo number_format($showsumcredits, 2, '.', ''); ?>
                                                    <?php  }elseif ($debt->vat_percent >= 1 && $debt->discount == 0.00 && $debt->wht_percent >= 1.00) {
                                                        $showsumcredits = $debt->payout+$debt->wht;
                                                                  echo number_format($showsumcredits, 2, '.', ''); ?>
                                                    <?php }else {
                                                                  echo "Code Error";
                                                    } ?>
                                                  </b></td>
                                              </tr>
                                          @endif

                                          <?php $ap_forold = $debt->bill_no; ?>
                                      @endif

                                    @endforeach
                                    @endif






                                    <!-- รายการสำรองจ่าย -->
                                    @foreach ($reserve_moneys as $key => $reserve_money)
                                    @if ($reserve_money->bill_no == $ap_reserve)
                                    <!-- ถ้า ap เหมือนกันเขียนแค่ list -->
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td style="text-align:left;">{{$reserve_money->po_detail_list}}</td>
                                        <td>{{$reserve_money->po_detail_note}}</td>
                                        <td>{{$reserve_money->accounttypeno}}</td>
                                        <td>{{$reserve_money->accounttypefull}}</td>
                                        <td></td>
                                        <td>{{$reserve_money->total}}</td>
                                        <td></td>
                                    </tr>

                                    @if ($key == count($reserve_moneys)-1)
                                    <!-- เขียนสำหรับรายการสุดท้าย -->
                                      @if ($reserve_money->vat != 0)
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td style="text-align:left;"><b>ภาษีมูลค่าเพิ่ม</b></td>
                                            <td></td>
                                            <td>119501</td>
                                            <td>ภาษีซื้อ</td>
                                            <td></td>
                                            <td>{{ $reserve_money->vat_money }}</td>
                                            <td></td>
                                        </tr>
                                      @endif

                                      <!-- เงินสด/เงินโอน -->
                                      <tr>
                                          <td></td>
                                          <td></td>
                                          <td></td>
                                          <td style="text-align:center;"><b>เงินสด</b></td>
                                          <td></td>
                                          <td>111200</td>
                                          <td>เงินสด</td>
                                          <td></td>
                                          <td></td>
                                          <td>
                                            <?php  if($reserve_money->vat == 0) {
                                                $showsumcredits = $reserve_money->total;
                                                          echo number_format($showsumcredits, 2, '.', ''); ?>
                                            <?php  }elseif ($reserve_money->vat >= 1) {
                                                $showsumcredits = $reserve_money->total + $reserve_money->vat_money;
                                                          echo number_format($showsumcredits, 2, '.', ''); ?>
                                            <?php }else {
                                                          echo "Code Error";
                                            } ?>
                                          </td>
                                      </tr>
                                      <!-- ปิดเงินสด/เงินโอน -->

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
                                              <?php  if($reserve_money->vat == 0) {
                                                  $showsumcredits = $reserve_money->total;
                                                            echo number_format($showsumcredits, 2, '.', ''); ?>
                                              <?php  }elseif ($reserve_money->vat >= 1) {
                                                  $showsumcredits = $reserve_money->total + $reserve_money->vat_money;
                                                            echo number_format($showsumcredits, 2, '.', ''); ?>
                                              <?php }else {
                                                            echo "Code Error";
                                              } ?>
                                            </b></td>
                                            <td><b>
                                              <?php  if($reserve_money->vat == 0) {
                                                  $showsumcredits = $reserve_money->total;
                                                            echo number_format($showsumcredits, 2, '.', ''); ?>
                                              <?php  }elseif ($reserve_money->vat >= 1) {
                                                  $showsumcredits = $reserve_money->total + $reserve_money->vat_money;
                                                            echo number_format($showsumcredits, 2, '.', ''); ?>
                                              <?php }else {
                                                            echo "Code Error";
                                              } ?>
                                            </b></td>
                                        </tr>
                                    @endif
                                    <?php $ap_reserve = $reserve_money->bill_no; ?>


                                    @else
                                    <!-- เปลี่ยนรายการ -->
                                    @if ($key != 0)
                                    <!-- ก่อนเปลี่ยนรายการเขียนปิดรายการก่อนหน้า -->
                                      @if ($reserve_moneys[$key-1]->vat != 0)
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td style="text-align:left;"><b>ภาษีมูลค่าเพิ่ม</b></td>
                                            <td></td>
                                            <td>119501</td>
                                            <td>ภาษีซื้อ</td>
                                            <td></td>
                                            <td>{{ $reserve_moneys[$key-1]->vat_money }}</td>
                                            <td></td>
                                        </tr>
                                      @endif

                                      <!-- เงินสด/เงินโอน -->
                                      <tr>
                                          <td></td>
                                          <td></td>
                                          <td></td>
                                          <td style="text-align:center;"><b>เงินสด</b></td>
                                          <td></td>
                                          <td>111200</td>
                                          <td>เงินสด</td>
                                          <td></td>
                                          <td></td>
                                          <td>
                                            <?php  if($reserve_moneys[$key-1]->vat == 0) {
                                                $showsumcredits = $reserve_moneys[$key-1]->total;
                                                          echo number_format($showsumcredits, 2, '.', ''); ?>
                                            <?php  }elseif ($reserve_moneys[$key-1]->vat >= 1) {
                                                $showsumcredits = $reserve_moneys[$key-1]->total + $reserve_moneys[$key-1]->vat_money;
                                                          echo number_format($showsumcredits, 2, '.', ''); ?>
                                            <?php }else {
                                                          echo "Code Error";
                                            } ?>
                                          </td>
                                      </tr>
                                      <!-- ปิดเงินสด/เงินโอน -->

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
                                              <?php  if($reserve_moneys[$key-1]->vat == 0) {
                                                  $showsumcredits = $reserve_moneys[$key-1]->total;
                                                            echo number_format($showsumcredits, 2, '.', ''); ?>
                                              <?php  }elseif ($reserve_moneys[$key-1]->vat >= 1) {
                                                  $showsumcredits = $reserve_moneys[$key-1]->total + $reserve_moneys[$key-1]->vat_money;
                                                            echo number_format($showsumcredits, 2, '.', ''); ?>
                                              <?php }else {
                                                            echo "Code Error";
                                              } ?>
                                            </b></td>
                                            <td><b>
                                              <?php  if($reserve_moneys[$key-1]->vat == 0) {
                                                  $showsumcredits = $reserve_moneys[$key-1]->total;
                                                            echo number_format($showsumcredits, 2, '.', ''); ?>
                                              <?php  }elseif ($reserve_moneys[$key-1]->vat >= 1) {
                                                  $showsumcredits = $reserve_moneys[$key-1]->total + $reserve_moneys[$key-1]->vat_money;
                                                            echo number_format($showsumcredits, 2, '.', ''); ?>
                                              <?php }else {
                                                            echo "Code Error";
                                              } ?>
                                            </b></td>
                                        </tr>
                                    @endif

                                    <tr style="border-top-style:solid;">
                                        <!-- เขียน row แรก แต่ละรายการ -->
                                        <td>
                                            @if($reserve_money->accept == 0)
                                            <label class="con">
                                            <input type="checkbox" name="id_reservemoneys[]" value="{{$reserve_money->id_reservemoney}}">
                                                <span class="checkmark"></span>
                                            </label>
                                            @else
                                            <i class="fa fa-check" style="color:green;font-size:20px;"></i>
                                            @endif
                                        </td>
                                        <td>{{$reserve_money->dateporef}}</td>
                                        <td>{{$reserve_money->bill_no}}</td>
                                        <td style="text-align:left;">{{$reserve_money->po_detail_list}}</td>
                                        <td>{{$reserve_money->po_detail_note}}</td>
                                        <td>{{$reserve_money->accounttypeno}}</td>
                                        <td>{{$reserve_money->accounttypefull}}</td>
                                        <td>{{$reserve_money->branch}}</td>
                                        <td>{{$reserve_money->total}}</td>
                                        <td></td>

                                    </tr>
                                      @if ($key == count($reserve_moneys)-1)
                                      <!-- เขียนสำหรับรายการสุดท้าย -->
                                        @if ($reserve_money->vat != 0)
                                          <tr>
                                              <td></td>
                                              <td></td>
                                              <td></td>
                                              <td style="text-align:left;"><b>ภาษีมูลค่าเพิ่ม</b></td>
                                              <td></td>
                                              <td>119501</td>
                                              <td>ภาษีซื้อ</td>
                                              <td></td>
                                              <td>{{ $reserve_money->vat_money }}</td>
                                              <td></td>
                                          </tr>
                                        @endif

                                        <!-- เงินสด/เงินโอน -->
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td style="text-align:center;"><b>เงินสด</b></td>
                                            <td></td>
                                            <td>111200</td>
                                            <td>เงินสด</td>
                                            <td></td>
                                            <td></td>
                                            <td>
                                              <?php  if($reserve_money->vat == 0) {
                                                  $showsumcredits = $reserve_money->total;
                                                            echo number_format($showsumcredits, 2, '.', ''); ?>
                                              <?php  }elseif ($reserve_money->vat >= 1) {
                                                  $showsumcredits = $reserve_money->total + $reserve_money->vat_money;
                                                            echo number_format($showsumcredits, 2, '.', ''); ?>
                                              <?php }else {
                                                            echo "Code Error";
                                              } ?>
                                            </td>
                                        </tr>
                                        <!-- ปิดเงินสด/เงินโอน -->

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
                                                <?php  if($reserve_money->vat == 0) {
                                                    $showsumcredits = $reserve_money->total;
                                                              echo number_format($showsumcredits, 2, '.', ''); ?>
                                                <?php  }elseif ($reserve_money->vat >= 1) {
                                                    $showsumcredits = $reserve_money->total + $reserve_money->vat_money;
                                                              echo number_format($showsumcredits, 2, '.', ''); ?>
                                                <?php }else {
                                                              echo "Code Error";
                                                } ?>
                                              </b></td>
                                              <td><b>
                                                <?php  if($reserve_money->vat == 0) {
                                                    $showsumcredits = $reserve_money->total;
                                                              echo number_format($showsumcredits, 2, '.', ''); ?>
                                                <?php  }elseif ($reserve_money->vat >= 1) {
                                                    $showsumcredits = $reserve_money->total + $reserve_money->vat_money;
                                                              echo number_format($showsumcredits, 2, '.', ''); ?>
                                                <?php }else {
                                                              echo "Code Error";
                                                } ?>
                                              </b></td>
                                          </tr>
                                      @endif

                                    <?php $ap_reserve = $reserve_money->bill_no; ?>
                                    @endif
                                    @endforeach
                                    <!-- ปิดรายการสำรองจ่าย -->







                                    <!-- จากสมุดรายวันทั่วไป -->
                                    @foreach ($journal_generals as $key => $journal_general)
                                    @if ($journal_general->number_bill_journal == $ap_journal)
                                      <!-- ถ้า ap เหมือนกันเขียนแค่ list -->
                                      <tr>
                                          <td>
                                          </td>
                                          <td></td>
                                          <td></td>
                                          <td style="text-align:center;">{{$journal_general->name_suplier}}</td>
                                          <td></td>
                                          <td>{{$journal_general->accounttypeno}}</td>
                                          <td>{{$journal_general->accounttypefull}}</td>
                                          <td></td>
                                          <td>{{$journal_general->debit}}</td>
                                          <td>{{$journal_general->credit}}</td>
                                      </tr>
                                      @if ($key == count($journal_generals)-1)
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
                                              <td><b>{{$journal_general->totalsum}}</b></td>
                                              <td><b>{{$journal_general->totalsum}}</b></td>
                                          </tr>
                                      @endif
                                      <?php $ap_journal = $journal_general->number_bill_journal ?>
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
                                              <td><b>{{$journal_generals[$key-1]->totalsum}}</b></td>
                                              <td><b>{{$journal_generals[$key-1]->totalsum}}</b></td>
                                          </tr>
                                      @endif
                                      <tr style="border-top-style:solid;">
                                          <!-- เขียน row แรก แต่ละรายการ -->
                                          <td>
                                            @if($journal_general->accept == 0)
                                            <label class="con">
                                            <input type="checkbox" name="id_journal_general[]" value="{{ $journal_general->id_journal_5 }}">
                                                <span class="checkmark"></span>
                                            </label>
                                            @else
                                            <i class="fa fa-check" style="color:green;font-size:20px;"></i>
                                            @endif
                                          </td>
                                          <td>{{$journal_general->datebill}}</td>
                                          <td>{{$journal_general->number_bill_journal}}</td>
                                          <td style="text-align:left;">{{$journal_general->name_suplier}}</td>
                                          <td>{{$journal_general->list}}</td>
                                          <td>{{$journal_general->accounttypeno}}</td>
                                          <td>{{$journal_general->accounttypefull}}</td>
                                          <td>{{$journal_general->code_branch}}</td>
                                          <td>{{$journal_general->debit}}</td>
                                          <td>{{$journal_general->credit}}</td>
                                      </tr>

                                      @if ($key == count($journal_generals)-1)
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
                                              <td><b>{{$journal_general->totalsum}}</b></td>
                                              <td><b>{{$journal_general->totalsum}}</b></td>
                                          </tr>
                                      @endif
                                    <?php $ap_journal = $journal_general->number_bill_journal ?>
                                    @endif
                                    @endforeach
                                    <!-- ปิดสมุดรายวันทั่วไป -->


                                </tbody>
                            </table>
                        </div>
                        <div style="padding-bottom:50px;">
                            <center><button type="submit" class="btn btn-success">Okay ยืนยันการตรวจ</button></center>
                        </div>
                        <!--END table cotent -->
                        {!! Form::close() !!}
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
