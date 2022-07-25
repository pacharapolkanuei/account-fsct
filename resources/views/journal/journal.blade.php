<?php

use App\Api\Accountcenter;
?>
@extends('layout.default')
@section('content')
<?php
$arrcol = [
  1 => 'ข้อมูลของโมดูล',
  2 => 'สาขา',
  3 => 'วัน/เดือน/ปี',
  4 => 'รายการ',
  5 => 'Reference No.',
  6 => 'ชื่อของเลขที่บัญชี',
  7 => 'เลขที่บัญชี'
];
?>
<div class="content-page">

  <!-- Start content -->
  <div class="content">
    <div class="container-fluid">
      @if (\Session::has('msg'))
      <?php
      $arr = Session::get('msg');
      // echo "<pre>";
      // print_r($arr);
      $col = $arr['column_search'];

      // print_r($col);
      ?>
      @endif

      <div class="row">
        <div class="col-xl-12">
          <div class="breadcrumb-holder" id="fontscontent">
            <h1 class="float-left">Account - FSCT</h1>
            <ol class="breadcrumb float-right">
              <li class="breadcrumb-item">สมุดรายวันทั่วไป</li>
              <li class="breadcrumb-item active">สมุดรายวันทั่วไป</li>
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
                <fonts id="fontsheader">สมุดรายวันทั่วไป </fonts>
              </h3>
            </div>

            <div class="col-md-12">
              <br />

              {!! Form::open(['route' => 'journal.store', 'method' => 'post']) !!}
              <div class="row">
                <div class="col-sm-4">
                  <div class="input-group mb-6">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><b>เลือกวันที่</b></span>
                    </div>
                    <input type='text' class="form-control" name="daterange" value="" autocomplete="off" />
                  </div>
                </div>

                <div class="col-sm-4">
                  <div class="input-group mb-6">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><b>เลือกสาขา</b></span>
                    </div>
                    <select class="form-control selectpicker" multiple data-live-search="true" name="branch_search[]">
                      @foreach ($branchs as $key => $branch)
                      <option value="{{$branch->code_branch}}">{{$branch->name_branch}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>



                <div class="col-sm-4">
                  <div class="input-group mb-6">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><b>โชว์คอลัมน์</b></span>
                    </div>
                    <select class="form-control selectpicker" multiple data-live-search="true" name="column_search[]">
                      <?php foreach ($arrcol as $k => $v) : ?>
                        <option value="<?php echo $k; ?>"><?php echo $v; ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                </div>

              </div>
              <br>
              <center><button type="submit" class="btn btn-primary">ค้นหา</button></center>
              {!! Form::close() !!}

              <br />

              <div id="fontslabel">
                <div class="table-responsive-xl">
                  <table class="table table-bordered">
                    <thead class="thead-light">
                      <tr>
                        <?php foreach ($arrcol as $e => $p) {
                          if (\Session::has('msg')) {
                            if (in_array($e, $col)) { ?>
                              <th style="text-align: center;"><?php echo $p; ?></th>
                            <?php } ?>
                          <?php } else {  ?>
                            <th style="text-align: center;"><?php echo $p; ?></th>
                          <?php } ?>
                        <?php } ?>
                        <th style="text-align: center;">เดบิต</th>
                        <th style="text-align: center;">เครดิต</th>
                      </tr>
                    </thead>
                    <?php $loop = count($datas);  ?>
                    <!-- นับจำนวน array  -->
                    <tbody>
                      <?php
                      if (!empty($datas)) {  ?>
                        <div class="container"></div>

                        <?php
                        foreach ($datas as $key => $tddefault) { ?>
                          <!-- ---------------------------------------------------------------------------- -->
                          {!! Form::open(['route' => 'ledger.store', 'method' => 'post', 'files' => true]) !!}
                          <input type="hidden" name="loop" value="{{$loop}}">
                          <?php if (\Session::has('msg')) { ?>
                            <tr>
                              <?php foreach ($arrcol as $e => $p) {
                                if (\Session::has('msg')) {
                                  if (in_array($e, $col)) { ?>
                                    <?php if ($e == 1) { ?>
                                      <td style="text-align: center;">
                                        @if($tddefault->accept==0)
                                        <input type="checkbox" name="check_list[]" value="{{$tddefault->po_head}}"><label></label>
                                        <?php echo 'PU'; ?>{{$key}}
                                        @else
                                        <i class="fa fa-check" style="color:green;font-size:20px;"></i>
                                        <?php echo 'PU'; ?>{{$key}}
                                        @endif
                                      </td>
                                    <?php } else if ($e == 2) { ?>
                                      <td style="text-align: center;"><?php echo $tddefault->name_branch; ?> </td>
                                    <?php } else if ($e == 3) { ?>
                                      <td style="text-align: center;"><?php echo $tddefault->datebill; ?> </td>
                                      <input type="hidden" name="name_branch{{$key}}" value="{{ $tddefault->name_branch }}">
                                      <input type="hidden" name="datebill{{$key}}" value="{{ $tddefault->datebill }}">
                                      <input type="hidden" name="module{{$key}}" value="PU">
                                    <?php } else if ($e == 4) { ?>

                                      <td style="text-align: ;"><?php echo $tddefault->list; ?> </td>
                                      <input type="hidden" name="list{{$key}}1" value="{{ $tddefault->list }}">

                                    <?php } else if ($e == 5) { ?>
                                      <td style="text-align: center;"><?php echo $tddefault->po_head; ?> </td>
                                      <input type="hidden" name="po_head{{$key}}" value="{{ $tddefault->po_head }}">
                                    <?php } else if ($e == 6) { ?>
                                      <td style="text-align: center;"><?php echo $tddefault->accounttypefull; ?> </td>
                                      <input type="hidden" name="accounttypefull_list{{$key}}" value="{{ $tddefault->accounttypefull }}">
                                    <?php } else if ($e == 7) { ?>
                                      <td style="text-align: center;"><?php echo $tddefault->accounttypeno; ?> </td>
                                      <input type="hidden" name="accounttypeno{{$key}}1" value="{{ $tddefault->accounttypeno }}">
                                    <?php } ?>
                                  <?php } ?>
                                <?php } ?>
                              <?php } ?>

                              <?php if ($tddefault->config_group_supp_id == 1) : ?>
                                <td style="text-align: ;"><?php $num = $tddefault->total;
                                                          $formattedNum = number_format($num, 2);
                                                          echo $formattedNum;; ?></td>
                                <input type="hidden" name="total{{$key}}1" value="{{ $tddefault->total }}">
                                <input type="hidden" name="DorC{{$key}}1" value="0">
                                <td style="text-align: center;"></td>

                              <?php elseif ($tddefault->config_group_supp_id == 2) : ?>
                                <td style="text-align: ;"><?php $num = $tddefault->total;
                                                          $formattedNum = number_format($num, 2);
                                                          echo $formattedNum;; ?></td>
                                <input type="hidden" name="total{{$key}}1" value="{{ $tddefault->total }}">
                                <input type="hidden" name="DorC{{$key}}1" value="0">
                                <td style="text-align: center;"></td>

                              <?php elseif ($tddefault->config_group_supp_id == 3) : ?>
                                <td style="text-align: ;"><?php $num = $tddefault->total;
                                                          $formattedNum = number_format($num, 2);
                                                          echo $formattedNum;; ?></td>
                                <input type="hidden" name="total{{$key}}1" value="{{ $tddefault->total }}">
                                <input type="hidden" name="DorC{{$key}}1" value="0">
                                <td style="text-align: center;"></td>

                              <?php elseif ($tddefault->config_group_supp_id == 4) : ?>
                                <td style="text-align: ;"><?php $num = $tddefault->total;
                                                          $formattedNum = number_format($num, 2);
                                                          echo $formattedNum;; ?></td>
                                <input type="hidden" name="total{{$key}}1" value="{{ $tddefault->total }}">
                                <input type="hidden" name="DorC{{$key}}1" value="0">
                                <td style="text-align: center;"></td>

                              <?php elseif ($tddefault->config_group_supp_id == 5) : ?>
                                <td style="text-align: ;"><?php $num = $tddefault->total;
                                                          $formattedNum = number_format($num, 2);
                                                          echo $formattedNum;; ?></td>
                                <input type="hidden" name="total{{$key}}1" value="{{ $tddefault->total }}">
                                <input type="hidden" name="DorC{{$key}}1" value="0">
                                <td style="text-align: center;"></td>
                              <?php endif; ?>
                            </tr>


                            <?php if ($tddefault->vat_percent >= 1) : ?>
                              <tr>
                                <?php foreach ($arrcol as $e => $p) {
                                  if (\Session::has('msg')) {
                                    if (in_array($e, $col)) { ?>
                                      <?php if ($e == 1) { ?>
                                        <td style="text-align: center;"></td>
                                      <?php } else if ($e == 2) { ?>
                                        <td style="text-align: center;"></td>
                                      <?php } else if ($e == 3) { ?>
                                        <td style="text-align: center;"></td>
                                      <?php } else if ($e == 4) { ?>
                                        <td style="text-align: ;">ภาษีมูลค่าเพิ่ม <?php echo $tddefault->vat_percent; ?> %</td>
                                        <input type="hidden" name="list{{$key}}2" value="ภาษีมูลค่าเพิ่ม{{ $tddefault->vat_percent }}">
                                      <?php } else if ($e == 5) { ?>
                                        <td style="text-align: center;"></td>
                                      <?php } else if ($e == 6) { ?>
                                        <td style="text-align: center;"></td>
                                      <?php } else if ($e == 7) { ?>
                                        <td style="text-align: center;">
                                          <?php $codeaccvat = Accountcenter::datacodeaccount($tddefault->acctype);

                                          echo $codeaccvat[0]->accounttypeno;
                                          ?></td><input type="hidden" name="accounttypeno{{$key}}2" value="{{ $codeaccvat[0]->accounttypeno }}">
                                      <?php } ?>
                                    <?php } ?>
                                  <?php } ?>
                                <?php } ?>
                                <td style="text-align: right;"><?php echo number_format($tddefault->vat_price, 2, ".", ",") . "\n"; ?></td>
                                <input type="hidden" name="DorC{{$key}}2" value="0">
                                <td style="text-align: center;"></td><input type="hidden" name="total{{$key}}2" value="{{ $tddefault->vat_price }}">
                              </tr>
                            <?php endif; ?>


                            <?php if ($tddefault->company_pay_wht == 255) : ?>
                              <tr>
                                <?php foreach ($arrcol as $e => $p) {
                                  if (\Session::has('msg')) {
                                    if (in_array($e, $col)) { ?>
                                      <?php if ($e == 1) { ?>
                                        <td style="text-align: center;"></td>
                                      <?php } else if ($e == 2) { ?>
                                        <td style="text-align: center;"></td>
                                      <?php } else if ($e == 3) { ?>
                                        <td style="text-align: center;"></td>
                                      <?php } else if ($e == 4) { ?>
                                        <td style="text-align: ;">ภาษีหัก ณ ที่จ่ายออกแทน</td>
                                      <?php } else if ($e == 5) { ?>
                                        <td style="text-align: center;"></td>
                                      <?php } else if ($e == 6) { ?>
                                        <td style="text-align: center;"></td>
                                      <?php } else if ($e == 7) { ?>
                                        <td style="text-align: center;">
                                          <?php $companywht = Accountcenter::datacodeaccount($tddefault->acccompanywht);

                                          echo $companywht[0]->accounttypeno;
                                          ?>
                                          <input type="hidden" name="list{{$key}}3" value="ภาษีหัก ณ ที่จ่ายออกแทน">
                                          <input type="hidden" name="accounttypeno{{$key}}3" value="{{$companywht[0]->accounttypeno}}">
                                        </td>
                                      <?php } ?>
                                    <?php } ?>
                                  <?php } ?>
                                <?php } ?>
                                <td style="text-align: right;"><?php echo $tddefault->wht; ?></td>
                                <input type="hidden" name="total{{$key}}3" value="{{ $tddefault->wht }}">
                                <input type="hidden" name="DorC{{$key}}3" value="0">
                                <td style="text-align: center;"></td>
                              </tr>
                            <?php endif; ?>


                            <?php if ($tddefault->wht_percent >= 1) : ?>
                              <tr>
                                <?php foreach ($arrcol as $e => $p) {
                                  if (\Session::has('msg')) {
                                    if (in_array($e, $col)) { ?>
                                      <?php if ($e == 1) { ?>
                                        <td style="text-align: center;"></td>
                                      <?php } else if ($e == 2) { ?>
                                        <td style="text-align: center;"></td>
                                      <?php } else if ($e == 3) { ?>
                                        <td style="text-align: center;"></td>
                                      <?php } else if ($e == 4) { ?>
                                        <td style="text-align: center;">ภาษีมูล หัก ณ ที่จ่าย <?php echo $tddefault->wht_percent; ?> %</td>
                                        <input type="hidden" name="wht_percent" value="{{ $tddefault->wht_percent }}">
                                      <?php } else if ($e == 5) { ?>
                                        <td style="text-align: center;"></td>
                                      <?php } else if ($e == 6) { ?>
                                        <td style="text-align: center;"></td>
                                      <?php } else if ($e == 7) { ?>
                                        <td style="text-align: center;">
                                          <?php $codeaccwhd = Accountcenter::datacodeaccount($tddefault->acctypewhd);

                                          echo $codeaccwhd[0]->accounttypeno;
                                          ?><input type="hidden" name="accounttypeno{{$key}}4" value="{{ $codeaccwhd[0]->accounttypeno }}">
                                        </td>
                                      <?php } ?>
                                    <?php } ?>
                                  <?php } ?>
                                <?php } ?>
                                <td style="text-align: center;"></td>
                                <td style="text-align: right;"><?php echo $tddefault->wht; ?></td>
                                <input type="hidden" name="total{{$key}}4" value="{{ $tddefault->wht }}">
                                <input type="hidden" name="DorC{{$key}}4" value="1">
                              </tr>
                            <?php endif; ?>


                            <?php if ($tddefault->creaditpay == 0) : ?>
                              <tr>
                                <?php foreach ($arrcol as $e => $p) {
                                  if (\Session::has('msg')) {
                                    if (in_array($e, $col)) { ?>
                                      <?php if ($e == 1) { ?>
                                        <td style="text-align: center;"></td>
                                      <?php } else if ($e == 2) { ?>
                                        <td style="text-align: center;"></td>
                                      <?php } else if ($e == 3) { ?>
                                        <td style="text-align: center;"></td>
                                      <?php } else if ($e == 4) { ?>
                                        <td style="text-align: center;"><?php echo $tddefault->name_pay; ?>
                                          <b>{{isHasBank($tddefault->account_no)}}</b>
                                        </td>
                                        <input type="hidden" name="list{{$key}}5" value="{{ $tddefault->name_pay }}">
                                      <?php } else if ($e == 5) { ?>
                                        <td style="text-align: center;"></td>
                                      <?php } else if ($e == 6) { ?>
                                        <td style="text-align: center;"></td>
                                      <?php } else if ($e == 7) { ?>
                                        <td style="text-align: center;">
                                          <?php $codeaccnum = Accountcenter::datacodeaccount($tddefault->acctypenum);

                                          echo $codeaccnum[0]->accounttypeno;
                                          ?>
                                          <input type="hidden" name="accounttypeno{{$key}}5" value="{{ $codeaccnum[0]->accounttypeno }}">
                                        </td>
                                      <?php } ?>
                                    <?php } ?>
                                  <?php } ?>
                                <?php } ?>
                                <td style="text-align: center;"></td>
                                <td style="text-align: right;"><?php $num = ($tddefault->total + $tddefault->vat_price + $tddefault->wht);
                                                                $formattedNum = number_format($num, 2);
                                                                echo $formattedNum;; ?></td>
                                <input type="hidden" name="total{{$key}}5" value="{{ $num}}">
                                <input type="hidden" name="DorC{{$key}}5" value="1">
                              </tr>
                            <?php endif; ?>

                            <tr style="border-bottom-style:solid;">
                              <?php foreach ($arrcol as $e => $p) {
                                if (\Session::has('msg')) {
                                  if (in_array($e, $col)) { ?>
                                    <?php if ($e == 1) { ?>
                                      <td style="text-align: center;"></td>
                                    <?php } else if ($e == 2) { ?>
                                      <td style="text-align: center;"></td>
                                    <?php } else if ($e == 3) { ?>
                                      <td style="text-align: center;"></td>
                                    <?php } else if ($e == 4) { ?>
                                      <td style="text-align: center;">จ่ายชำระ
                                        <?php $datadetail = Accountcenter::getdatainformdetail($tddefault->poheadid);
                                        $arrImportdata = [];
                                        foreach ($datadetail as $a => $v) {
                                          $arrImportdata[] = $v->name;
                                        }
                                        echo implode(' และ ', $arrImportdata);
                                        ?><input type="hidden" name="poheadid" value="{{ $tddefault->poheadid }}">
                                        เป็น
                                        <?php echo $tddefault->name_pay; ?>
                                        <input type="hidden" name="name_pay" value="{{ $tddefault->name_pay }}">
                                      </td>
                                    <?php } else if ($e == 5) { ?>
                                      <td style="text-align: center;"></td>
                                    <?php } else if ($e == 6) { ?>
                                      <td style="text-align: center;"></td>
                                    <?php } else if ($e == 7) { ?>
                                      <td style="text-align: center;"></td>
                                    <?php } ?>
                                  <?php } ?>
                                <?php } ?>
                              <?php } ?>
                              <td style="text-align: right;"></td>
                              <td style="text-align: center;"><?php $num = $tddefault->total;
                                                              $formattedNum = number_format($num, 2);
                                                              ?></td>
                              <input type="hidden" name="total" value="{{ $tddefault->total }}">
                            </tr>

                            <!-- ------------------------------------------------------------------------------------------------------------ -->
                          <?php } else { ?>

                            <input type="hidden" name="loop" value="{{$loop}}">

                            <tr>
                              <td style="text-align: center;">
                                @if($tddefault->accept==0)
                                <input type="checkbox" name="check_list[]" value="{{$tddefault->po_head}}"><label></label>
                                <?php echo 'PU'; ?>{{$key}}
                                @else
                                <i class="fa fa-check" style="color:green;font-size:20px;"></i>
                                <?php echo 'PU'; ?>{{$key}}
                                @endif
                              </td>
                              <td style="text-align: center;"><?php echo $tddefault->name_branch; ?></td>
                              <td style="text-align: center;"><?php echo $tddefault->datebill; ?></td>
                              <input type="hidden" name="name_branch{{$key}}" value="{{ $tddefault->name_branch }}">
                              <input type="hidden" name="datebill{{$key}}" value="{{ $tddefault->datebill }}">
                              <input type="hidden" name="module{{$key}}" value="PU">


                              <?php if ($tddefault->config_group_supp_id == 1) : ?>
                                <td style="text-align: left;"><?php echo $tddefault->list; ?></td>
                                <input type="hidden" name="list{{$key}}1" value="{{ $tddefault->list }}">
                                <td style="text-align: center;">
                                  <?php echo $tddefault->po_head; ?>
                                  <input type="hidden" name="po_head{{$key}}" value="{{ $tddefault->po_head }}">
                                </td>
                                <td style="text-align: center;"><?php echo $tddefault->accounttypefull; ?></td>
                                <input type="hidden" name="accounttypefull_list{{$key}}" value="{{ $tddefault->accounttypefull }}">
                                <td style="text-align: center;"><?php echo $tddefault->accounttypeno; ?></td>
                                <input type="hidden" name="accounttypeno{{$key}}1" value="{{ $tddefault->accounttypeno }}">
                                <td style="text-align: right;"><?php $num = $tddefault->total;
                                                                $formattedNum = number_format($num, 2);
                                                                echo $formattedNum;; ?></td>
                                <input type="hidden" name="total{{$key}}1" value="{{ $tddefault->total }}">
                                <input type="hidden" name="DorC{{$key}}1" value="0">
                                <td style="text-align: center;"></td>

                              <?php elseif ($tddefault->config_group_supp_id == 2) : ?>
                                <td style="text-align: ;"><?php echo $tddefault->list; ?></td>
                                <input type="hidden" name="list{{$key}}1" value="{{ $tddefault->list }}">
                                <td style="text-align: center;">
                                  <?php echo $tddefault->po_head; ?>
                                  <input type="hidden" name="po_head{{$key}}" value="{{ $tddefault->po_head }}">
                                </td>
                                <td style="text-align: center;"><?php echo $tddefault->accounttypefull; ?></td>
                                <input type="hidden" name="accounttypefull_list{{$key}}" value="{{ $tddefault->accounttypefull }}">
                                <td style="text-align: center;"><?php echo $tddefault->accounttypeno; ?></td>
                                <input type="hidden" name="accounttypeno{{$key}}1" value="{{ $tddefault->accounttypeno }}">
                                <td style="text-align: right;"><?php $num = $tddefault->total;
                                                                $formattedNum = number_format($num, 2);
                                                                echo $formattedNum;; ?></td>
                                <input type="hidden" name="total{{$key}}1" value="{{ $tddefault->total }}">
                                <input type="hidden" name="DorC{{$key}}1" value="0">
                                <td style="text-align: center;"></td>

                              <?php elseif ($tddefault->config_group_supp_id == 3) : ?>
                                <td style="text-align: ;"><?php echo $tddefault->list; ?></td>
                                <input type="hidden" name="list{{$key}}1" value="{{ $tddefault->list }}">
                                <td style="text-align: center;">
                                  <?php echo $tddefault->po_head; ?>
                                  <input type="hidden" name="po_head{{$key}}" value="{{ $tddefault->po_head }}">
                                </td>
                                <td style="text-align: center;"><?php echo $tddefault->accounttypefull; ?></td>
                                <input type="hidden" name="accounttypefull_list{{$key}}" value="{{ $tddefault->accounttypefull }}">
                                <td style="text-align: center;"><?php echo $tddefault->accounttypeno; ?></td>
                                <input type="hidden" name="accounttypeno{{$key}}1" value="{{ $tddefault->accounttypeno }}">
                                <td style="text-align: right;"><?php $num = $tddefault->total;
                                                                $formattedNum = number_format($num, 2);
                                                                echo $formattedNum;; ?></td>
                                <input type="hidden" name="total{{$key}}1" value="{{ $tddefault->total }}">
                                <input type="hidden" name="DorC{{$key}}1" value="0">
                                <td style="text-align: center;"></td>

                              <?php elseif ($tddefault->config_group_supp_id == 4) : ?>
                                <td style="text-align: ;"><?php echo $tddefault->list; ?></td>
                                <input type="hidden" name="list{{$key}}1" value="{{ $tddefault->list }}">
                                <td style="text-align: center;">
                                  <?php echo $tddefault->po_head; ?>
                                  <input type="hidden" name="po_head{{$key}}" value="{{ $tddefault->po_head }}">
                                </td>
                                <td style="text-align: center;"><?php echo $tddefault->accounttypefull; ?></td>
                                <input type="hidden" name="accounttypefull_list{{$key}}" value="{{ $tddefault->accounttypefull }}">
                                <td style="text-align: center;"><?php echo $tddefault->accounttypeno; ?></td>
                                <input type="hidden" name="accounttypeno{{$key}}1" value="{{ $tddefault->accounttypeno }}">
                                <td style="text-align: right;"><?php $num = $tddefault->total;
                                                                $formattedNum = number_format($num, 2);
                                                                echo $formattedNum;; ?></td>
                                <input type="hidden" name="total{{$key}}1" value="{{ $tddefault->total }}">
                                <input type="hidden" name="DorC{{$key}}1" value="0">
                                <td style="text-align: center;"></td>

                              <?php elseif ($tddefault->config_group_supp_id == 5) : ?>
                                <td style="text-align: ;"><?php echo $tddefault->list; ?></td>
                                <input type="hidden" name="list{{$key}}1" value="{{ $tddefault->list }}">
                                <td style="text-align: center;">
                                  <?php echo $tddefault->po_head; ?>
                                  <input type="hidden" name="po_head{{$key}}" value="{{ $tddefault->po_head }}">
                                </td>
                                <td style="text-align: center;"><?php echo $tddefault->accounttypefull; ?></td>
                                <input type="hidden" name="accounttypefull_list{{$key}}" value="{{ $tddefault->accounttypefull }}">
                                <td style="text-align: center;"><?php echo $tddefault->accounttypeno; ?></td>
                                <input type="hidden" name="accounttypeno{{$key}}1" value="{{ $tddefault->accounttypeno }}">
                                <td style="text-align: right;"><?php $num = $tddefault->total;
                                                                $formattedNum = number_format($num, 2);
                                                                echo $formattedNum;; ?></td>
                                <input type="hidden" name="total{{$key}}1" value="{{ $tddefault->total }}">
                                <input type="hidden" name="DorC{{$key}}1" value="0">
                                <td style="text-align: center;"></td>
                              <?php endif; ?>
                            </tr>


                            <?php if ($tddefault->vat_percent >= 1) : ?>
                              <tr>
                                <td style="text-align: center;"></td>
                                <td style="text-align: center;"></td>
                                <td style="text-align: center;"></td>
                                @if($tddefault->config_group_supp_id == 1 && $tddefault->config_group_supp_id == 5)
                                <td>ภาษีมูลค่าเพิ่ม <?php echo $tddefault->vat_percent; ?> %</td>
                                <input type="hidden" name="list{{$key}}2" value="ภาษีมูลค่าเพิ่ม{{ $tddefault->vat_percent }}">
                                @else
                                <td style="text-align: ;">ภาษีมูลค่าเพิ่ม <?php echo $tddefault->vat_percent; ?> %</td>
                                <input type="hidden" name="list{{$key}}2" value="ภาษีมูลค่าเพิ่ม{{ $tddefault->vat_percent }}">
                                @endif
                                <td style="text-align: center;"></td>
                                <td style="text-align: center;"></td>
                                <td style="text-align: center;">
                                  <?php $codeaccvat = Accountcenter::datacodeaccount($tddefault->acctype);

                                  echo $codeaccvat[0]->accounttypeno;
                                  ?></td><input type="hidden" name="accounttypeno{{$key}}2" value="{{ $codeaccvat[0]->accounttypeno }}">
                                <td style="text-align: right;"><?php echo number_format($tddefault->vat_price, 2, ".", ",") . "\n"; ?></td>
                                <input type="hidden" name="DorC{{$key}}2" value="0">
                                <td style="text-align: center;"></td><input type="hidden" name="total{{$key}}2" value="{{ $tddefault->vat_price }}">

                              </tr>
                            <?php endif; ?>



                            <?php if ($tddefault->company_pay_wht == 255) : ?>
                              <tr>
                                <td style="text-align: center;"></td>
                                <td style="text-align: center;"></td>
                                <td style="text-align: center;"></td>
                                <td style="text-align: ;">ภาษีหัก ณ ที่จ่ายออกแทน</td>
                                <td style="text-align: center;"></td>
                                <td style="text-align: center;"></td>
                                <td style="text-align: center;">
                                  <?php $companywht = Accountcenter::datacodeaccount($tddefault->acccompanywht);

                                  echo $companywht[0]->accounttypeno;
                                  ?>
                                  <input type="hidden" name="list{{$key}}3" value="ภาษีหัก ณ ที่จ่ายออกแทน">
                                  <input type="hidden" name="accounttypeno{{$key}}3" value="{{$companywht[0]->accounttypeno}}">
                                </td>
                                <td style="text-align: right;"><?php echo $tddefault->wht; ?></td>
                                <input type="hidden" name="total{{$key}}3" value="{{ $tddefault->wht }}">
                                <input type="hidden" name="DorC{{$key}}3" value="0">
                                <td style="text-align: center;"></td>
                              </tr>
                            <?php endif; ?>



                            <?php if ($tddefault->wht_percent >= 1) : ?>
                              <tr>
                                <td style="text-align: center;"></td>
                                <td style="text-align: center;"></td>
                                <td style="text-align: center;"></td>
                                <td style="text-align: center;">ภาษีมูล หัก ณ ที่จ่าย <?php echo $tddefault->wht_percent; ?> %</td>
                                <input type="hidden" name="list{{$key}}4" value="ภาษีมูล หัก ณ ที่จ่าย{{$tddefault->wht_percent}}">
                                <td style="text-align: center;"></td>
                                <td style="text-align: center;"></td>
                                <td style="text-align: center;">
                                  <?php $codeaccwhd = Accountcenter::datacodeaccount($tddefault->acctypewhd);

                                  echo $codeaccwhd[0]->accounttypeno;
                                  ?><input type="hidden" name="accounttypeno{{$key}}4" value="{{ $codeaccwhd[0]->accounttypeno }}">
                                </td>
                                <td style="text-align: center;"></td>
                                <td style="text-align: right;"><?php echo $tddefault->wht; ?></td>
                                <input type="hidden" name="total{{$key}}4" value="{{ $tddefault->wht }}">
                                <input type="hidden" name="DorC{{$key}}4" value="0">
                              </tr>
                            <?php endif; ?>


                            <?php if ($tddefault->creaditpay == 0) : ?>
                              <tr>
                                <td style="text-align: center;"></td>
                                <td style="text-align: center;"></td>
                                <td style="text-align: center;"></td>
                                <td style="text-align: center;"><?php echo $tddefault->name_pay; ?>
                                  <b>{{isHasBank($tddefault->account_no)}}</b>
                                </td>
                                <input type="hidden" name="list{{$key}}5" value="{{ $tddefault->name_pay }}">
                                <td style="text-align: center;"></td>
                                <td style="text-align: center;"></td>
                                <td style="text-align: center;">
                                  <?php $codeaccnum = Accountcenter::datacodeaccount($tddefault->acctypenum);

                                  echo $codeaccnum[0]->accounttypeno;
                                  ?>
                                  <input type="hidden" name="accounttypeno{{$key}}5" value="{{ $codeaccnum[0]->accounttypeno }}">
                                </td>
                                <td style="text-align: center;"></td>
                                <td style="text-align: right;"><?php $num = ($tddefault->total + $tddefault->vat_price - $tddefault->wht);
                                                                $formattedNum = number_format($num, 2);
                                                                echo $formattedNum; ?></td>
                                <input type="hidden" name="total{{$key}}5" value="{{ $num}}">
                                <input type="hidden" name="DorC{{$key}}5" value="1">

                              </tr>
                            <?php endif; ?>


                            <tr style="border-bottom-style:solid;">
                              <td style="text-align: center;"></td>
                              <td style="text-align: center;"></td>
                              <td style="text-align: center;"></td>
                              <td>จ่ายชำระ
                                <?php $datadetail = Accountcenter::getdatainformdetail($tddefault->poheadid);
                                $arrImportdata = [];
                                foreach ($datadetail as $a => $v) {
                                  $arrImportdata[] = $v->name;
                                }
                                echo implode(' และ ', $arrImportdata);
                                ?>
                                เป็น
                                <?php echo $tddefault->name_pay; ?> </td>
                              <input type="hidden" name="name_pay{{$key}}" value="{{ $tddefault->name_pay }}">
                              <td style="text-align: center;"></td>
                              <td style="text-align: center;"></td>
                              <td style="text-align: center;"></td>
                              <td style="text-align: center;"></td>
                              <td style="text-align: center;"></td>
                            </tr>

                            <!-- 222 -->
                          <?php } ?>
                        <?php } ?>
                  </div>
                  <!-- <div class="container">ss</div> -->
                <?php }  ?>
                </tbody>
                </table>

              </div>
            </div>
            <center>
              {!! Form::submit('บันทึกรายการที่เลือก', ['class' => 'btn btn-success btn-lg', 'style' => 'dispaly: inline','id'=>'fontslabel']) !!}<br>
            </center>
            {!! Form::close() !!}
            <br>
          </div>

        </div><!-- end card-->
      </div>
    </div>
    <!-- end row -->

  </div>
  <!-- END container-fluid -->
</div>
<!-- END content -->
</div>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.js"></script> -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>

<script type="text/javascript" src='js/accountjs/journal.js'></script>


@endsection