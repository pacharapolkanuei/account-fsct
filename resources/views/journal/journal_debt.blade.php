@extends('index')
@section('content')
<!-- js data table -->
<script type="text/javascript" src="https://unpkg.com/sweetalert2@7.0.6/dist/sweetalert2.all.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript" src={{ asset('js/accountjs/journal_debt.js') }}></script>
<link href="{{ asset('css/journal_debt/journal_debt.css') }}" rel="stylesheet" type="text/css" media="all">

<script language="JavaScript">
  function toggle(source) {
    checkboxes = document.getElementsByName('id_indebts[]');
    for(var i=0, n=checkboxes.length;i<10;i++) {
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
                            <li class="breadcrumb-item active">สมุดรายวันซื้อ</li>
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
                                <fonts id="fontsheader">สมุดรายวันซื้อ</fonts>
                            </h3><br><br>
                            <!-- date range -->
                            {!! Form::open(['route' => 'journaldebt_filter', 'method' => 'post']) !!}
                            <div class="row" class="fontslabel">
                                <div class="col-sm-3">
                                    <div class="input-group mb-6">
                                        <div class="input-group-prepend">
                                            <label id="fontslabel"><b>วันที่ : &nbsp;</b></label>
                                        </div>
                                        <input type='text' class="form-control" name="daterange" value="" autocomplete="off" />
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="input-group mb-6">
                                        <label id="fontslabel"><b>สาขา : &nbsp;</b></label>
                                        <select class="form-control" name="branch">
                                            <option value="0">เลือกสาขา</option>
                                            @foreach ($branchs as $key => $branch)
                                            <option value="{{$branch->code_branch}}">{{$branch->name_branch}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <center><button type="submit" class="btn btn-primary btn-sm fontslabel">ค้นหา</button></center>&nbsp;
                                <center><a class="btn btn-info btn-sm fontslabel" href="{{url('journal_debt')}}">ดูทั้งหมด</a></center>
                            </div>
                            {!! Form::close() !!}
                            <!-- date range -->
                        </div>

                        <?php
                              // $sum_tot_Price = 0;
                              // $temp = [];
                        ?>

                        {!! Form::open(['route' => 'confirm_journal_debt', 'method' => 'post']) !!}
                        <!-- table cotent -->
                        <div class="col" id="fontsjournal">
                            <table class="table table-bordered">
                                <thead>
                                    <tr style="background-color:#aab6c2;color:white;">
                                        <th scope="col"><label class="con" style="margin: -25px -35px 0px 0px;">
                                            <input type="checkbox" onClick="toggle(this)">
                                            <span class="checkmark"></span>
                                          </label>
                                        </th>
                                        <th scope="col">วัน/เดือน/ปี</th>
                                        <th scope="col">เลขที่ใบสำคัญรับ</th>
                                        <th scope="col">รายการ</th>
                                        <th scope="col">รายละเอียด</th>
                                        <th scope="col">เลขที่บัญชี</th>
                                        <th scope="col">ชื่อเลขที่บัญชี</th>
                                        <th scope="col">สาขา</th>
                                        <th scope="col">เดบิต</th>
                                        <th scope="col">เครดิต</th>
                                        <!-- <th scope="col">ยกเลิก</th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($debts as $key => $debt)
                                    @if ($debt->number_debt == $ap)
                                    <!-- ถ้า ap เหมือนกันเขียนแค่ list -->
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td style="text-align:left;">{{$debt->list}}</td>
                                        <td>{{$debt->note}}</td>
                                        <td>{{$debt->accounttypeno}}</td>
                                        <td>{{$debt->accounttypefull}}</td>
                                        <td></td>
                                        <td>{{$debt->total}}</td>
                                        <td></td>
                                    </tr>

                                    @if ($key == count($debts)-1)
                                    <!-- เขียนสำหรับรายการสุดท้าย -->
                                      @if ($debt->discount != 0)
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td style="text-align: left ;"><b>ส่วนลด</b></td>
                                            <td></td>
                                            <td>412900</td>
                                            <td>ส่วนลดรับ</td>
                                            <td></td>
                                            <td></td>
                                            <td><?php echo number_format($debt->discount, 2, '.', ''); ?></td>
                                        </tr>
                                      @endif

                                      @if ($debt->vat != 0)
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td style="text-align:left;"><b>ภาษีมูลค่าเพิ่ม</b></td>
                                            <td></td>
                                            <td>119501</td>
                                            <td>ภาษีซื้อ</td>
                                            <td></td>
                                            <td>
                                              <?php if ($debt->vat == 1) {
                                                  $vatshow = $debt->vat_price/1.01;
                                                  $vatshow1 = $vatshow*0.01;
                                                  echo number_format($vatshow1, 2, '.', ''); ?>
                                              <?php }elseif ($debt->vat == 3) {
                                                  $vatshow = $debt->vat_price/1.03;
                                                  $vatshow1 = $vatshow*0.03;
                                                    echo number_format($vatshow1, 2, '.', ''); ?>
                                              <?php }elseif ($debt->vat == 5) {
                                                  $vatshow = $debt->vat_price/1.05;
                                                  $vatshow1 = $vatshow*0.05;
                                                    echo number_format($vatshow1, 2, '.', ''); ?>
                                              <?php }else {
                                                  $vatshow = $debt->vat_price/1.07;
                                                  $vatshow1 = $vatshow*0.07;
                                                    echo number_format($vatshow1, 2, '.', ''); ?>
                                              <?php } ?>
                                            </td>
                                            <td></td>
                                        </tr>
                                      @endif

                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            @if ($debt->config_group_supp_id == 1)
                                            <td style="text-align:center;"><b>เจ้าหนี้การค้า</b></td>
                                            @else
                                            <td style="text-align:center;"><b>{{$debt->name}} ค้างจ่าย</b></td>
                                            @endif
                                            <td></td>
                                            <td>212100</td>
                                            <td>เจ้าหนี้การค้า</td>
                                            <td></td>
                                            <td></td>
                                            <td>{{$debt->vat_price}}</td>
                                        </tr>

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
                                              <?php if ($vatshow1 >= 0) {
                                                // code...
                                              } ?>
                                            </b></td>
                                            <td><b>
                                              <?php if ($debt->discount == 0) {
                                                $showsumdebit =  $debt->vat_price;
                                                           echo number_format($showsumdebit, 2, '.', ''); ?>
                                              <?php }else {
                                                $showsumdebit =   $debt->vat_price+$debt->discount;
                                                           echo number_format($showsumdebit, 2, '.', '');
                                              } ?>
                                            </b></td>
                                        </tr>
                                    @endif
                                    <?php $ap = $debt->number_debt ?>


                                    @else
                                    <!-- เปลี่ยนรายการ -->
                                    @if ($key != 0)
                                    <!-- ก่อนเปลี่ยนรายการเขียนปิดรายการก่อนหน้า -->
                                      @if ($debts[$key-1]->discount != 0)
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td style="text-align:left;"><b>ส่วนลด</b></td>
                                            <td></td>
                                            <td>412900</td>
                                            <td>ส่วนลดรับ</td>
                                            <td></td>
                                            <td></td>
                                            <td><?php echo number_format($debts[$key-1]->discount, 2, '.', ''); ?></td>
                                        </tr>
                                      @endif

                                      @if ($debts[$key-1]->vat != 0)
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td style="text-align:left;"><b>ภาษีมูลค่าเพิ่ม</b></td>
                                            <td></td>
                                            <td>119501</td>
                                            <td>ภาษีซื้อ</td>
                                            <td></td>
                                            <td>
                                              <?php if ($debts[$key-1]->vat == 1) {
                                                $vatshow = $debts[$key-1]->vat_price/1.01;
                                                $vatshow1 = $vatshow*0.01;
                                                  echo number_format($vatshow1, 2, '.', ''); ?>
                                              <?php }elseif ($debts[$key-1]->vat == 3) {
                                                  $vatshow = $debts[$key-1]->vat_price/1.03;
                                                  $vatshow1 = $vatshow*0.03;
                                                    echo number_format($vatshow1, 2, '.', ''); ?>
                                              <?php }elseif ($debts[$key-1]->vat == 5) {
                                                  $vatshow = $debts[$key-1]->vat_price/1.05;
                                                  $vatshow1 = $vatshow*0.05;
                                                    echo number_format($vatshow1, 2, '.', ''); ?>
                                              <?php }else {
                                                  $vatshow = $debts[$key-1]->vat_price/1.07;
                                                  $vatshow1 = $vatshow*0.07;
                                                    echo number_format($vatshow1, 2, '.', ''); ?>
                                              <?php } ?>
                                            </td>
                                            <td></td>
                                        </tr>
                                      @endif

                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            @if ($debts[$key-1]->config_group_supp_id == 1)
                                            <td style="text-align:center;"><b>เจ้าหนี้การค้า</b></td>
                                            @else
                                            <td style="text-align:center;"><b>{{$debts[$key-1]->name}} ค้างจ่าย</b></td>
                                            @endif
                                            <td></td>
                                            <td>212100</td>
                                            <td>เจ้าหนี้การค้า</td>
                                            <td></td>
                                            <td></td>
                                            <td>{{$debts[$key-1]->vat_price}}</td>
                                        </tr>

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
                                              <?php //echo number_format($showsumdebit, 2, '.', ''); ?>
                                              <?php if ($debts[$key-1]->discount == 0) {
                                                $showsumdebits =  $debts[$key-1]->vat_price;
                                                           echo number_format($showsumdebits, 2, '.', ''); ?>
                                              <?php }else {
                                                $showsumdebits =   $debts[$key-1]->vat_price + $debts[$key-1]->discount;
                                                           echo number_format($showsumdebits, 2, '.', '');
                                              } ?>
                                            </b></td>
                                            <td><b>
                                              <?php if ($debts[$key-1]->discount == 0) {
                                                $showsumdebit =  $debts[$key-1]->vat_price;
                                                           echo number_format($showsumdebit, 2, '.', ''); ?>
                                              <?php }else {
                                                $showsumdebit =   $debts[$key-1]->vat_price+$debts[$key-1]->discount;
                                                           echo number_format($showsumdebit, 2, '.', '');
                                              } ?>
                                            </b></td>
                                        </tr>
                                    @endif
                                    <!-- onchange="get_data_check(this)" id="check_number_debt" -->
                                    <?php $sum_tot_Price1 = 0; ?>
                                    <tr style="border-top-style:solid;">
                                        <!-- เขียน row แรก แต่ละรายการ -->
                                        <td>
                                            @if($debt->accept == 0)
                                            <label class="con">
                                            <input type="checkbox" name="id_indebts[]" value="{{$debt->id_indebt}}">
                                                <span class="checkmark"></span>
                                            </label>
                                            @else
                                            <i class="fa fa-check" style="color:green;font-size:20px;"></i>
                                            @endif
                                        </td>
                                        <td>{{$debt->datebill}}</td>
                                        <td>{{$debt->number_debt}}</td>
                                        <td style="text-align:left;">{{$debt->list}}</td>
                                        <td>{{$debt->note}}</td>
                                        <td>{{$debt->accounttypeno}}</td>
                                        <td>{{$debt->accounttypefull}}</td>
                                        <td>{{$debt->branch_id}}</td>
                                        <td>{{$debt->total}}</td>
                                        <td></td>
                                        <!-- <td>
                                          <a class="fas fa-times" href="{{ URL::route('debtcancel', $getidindebt = $debt->id_indebt) }}"></a>
                                        </td> -->

                                    </tr>
                                    <?php $sum_tot_Price1 += $debt->total; ?>

                                      @if ($key == count($debts)-1)
                                      <!-- เขียนสำหรับรายการสุดท้าย -->
                                        @if ($debt->discount != 0)
                                          <tr>
                                              <td></td>
                                              <td></td>
                                              <td></td>
                                              <td style="text-align: left ;"><b>ส่วนลด</b></td>
                                              <td></td>
                                              <td>412900</td>
                                              <td>ส่วนลดรับ</td>
                                              <td></td>
                                              <td></td>
                                              <td><?php echo number_format($debt->discount, 2, '.', ''); ?></td>
                                          </tr>
                                        @endif

                                        @if ($debt->vat != 0)
                                          <tr>
                                              <td></td>
                                              <td></td>
                                              <td></td>
                                              <td style="text-align:left;"><b>ภาษีมูลค่าเพิ่ม</b></td>
                                              <td></td>
                                              <td>119501</td>
                                              <td>ภาษีซื้อ</td>
                                              <td></td>
                                              <td>
                                                <?php if ($debt->vat == 1) {
                                                    $vatshow = $debt->vat_price/1.01;
                                                    $vatshow1 = $vatshow*0.01;
                                                    echo number_format($vatshow1, 2, '.', ''); ?>
                                                <?php }elseif ($debt->vat == 3) {
                                                    $vatshow = $debt->vat_price/1.03;
                                                    $vatshow1 = $vatshow*0.03;
                                                      echo number_format($vatshow1, 2, '.', ''); ?>
                                                <?php }elseif ($debt->vat == 5) {
                                                    $vatshow = $debt->vat_price/1.05;
                                                    $vatshow1 = $vatshow*0.05;
                                                      echo number_format($vatshow1, 2, '.', ''); ?>
                                                <?php }else {
                                                    $vatshow = $debt->vat_price/1.07;
                                                    $vatshow1 = $vatshow*0.07;
                                                      echo number_format($vatshow1, 2, '.', ''); ?>
                                                <?php } ?>
                                              </td>
                                              <td></td>
                                          </tr>
                                        @endif

                                          <tr>
                                              <td></td>
                                              <td></td>
                                              <td></td>
                                              @if ($debt->config_group_supp_id == 1)
                                              <td style="text-align:center;"><b>เจ้าหนี้การค้า</b></td>
                                              @else
                                              <td style="text-align:center;"><b>{{$debt->name}} ค้างจ่าย</b></td>
                                              @endif
                                              <td></td>
                                              <td>212100</td>
                                              <td>เจ้าหนี้การค้า</td>
                                              <td></td>
                                              <td></td>
                                              <td>{{$debt->vat_price}}</td>
                                          </tr>

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
                                                <?php if ($debt->discount == 0) {
                                                  $showsumdebits =  $debt->vat_price;
                                                             echo number_format($showsumdebits, 2, '.', ''); ?>
                                                <?php }else {
                                                  $showsumdebits =   $debt->vat_price+$debt->discount;
                                                             echo number_format($showsumdebits, 2, '.', '');
                                                } ?>
                                              </b></td>
                                              <td><b>
                                                <?php if ($debt->discount == 0) {
                                                  $showsumdebit =  $debt->vat_price;
                                                             echo number_format($showsumdebit, 2, '.', ''); ?>
                                                <?php }else {
                                                  $showsumdebit =   $debt->vat_price+$debt->discount;
                                                             echo number_format($showsumdebit, 2, '.', '');
                                                } ?>
                                              </td>
                                          </tr>
                                      @endif

                                    <?php $ap = $debt->number_debt ?>
                                    @endif
                                    @endforeach


                                    <?php
                                      $sum_debit = 0;
                                      $sum_credit = 0;
                                     ?>
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
