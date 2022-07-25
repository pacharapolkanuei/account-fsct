@extends('index')
@section('content')
<script type="text/javascript" src="https://unpkg.com/sweetalert2@7.0.6/dist/sweetalert2.all.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
@if (Session::has('sweetalert.json'))
<script>
swal({!!Session::pull('sweetalert.json')!!});
</script>
@endif

<?php
  $get_branchsession = Session::get('brcode');
  // echo $level_id;
?>

  <div class="content-page">
    <!-- Start content -->
        <div class="content">
             <div class="container-fluid">

                  <div class="row">
                        <div class="col-xl-12">
                            <div class="breadcrumb-holder" id="fontscontent">
                                <h1 class="float-left">Account - FSCT</h1>
                                <ol class="breadcrumb float-right">
                                  <li class="breadcrumb-item">จัดการข้อมูลซื้อ - ขาย</li>
                                  <li class="breadcrumb-item active">แจ้งการจ่ายเงิน (สด/โอน)</li>
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
                                     <fonts id="fontsheader">แจ้งการจ่ายเงิน (สด/โอน)</fonts>
                                   </h3>
                                 </div>
                                </div><!-- end card-->


                                {!! Form::open(['route' => 'payser_filter', 'method' => 'post']) !!}
                                <div class="row" class="fontslabel">
                                    <div class="col-sm-3">
                                        <div class="input-group mb-6">
                                            <div class="input-group-prepend">
                                                <label id="fontslabel"><b>วันที่ : &nbsp;</b></label>
                                            </div>
                                            <input type='text' class="form-control" name="daterange" value="" autocomplete="off" />
                                        </div>
                                    </div>


                                    <!-- <div class="col-sm-3">
                                        <div class="input-group mb-6">
                                            <label id="fontslabel"><b>สาขา : &nbsp;</b></label>
                                            <select class="form-control" name="branch">
                                                <option value="0">เลือกสาขา</option>
                                                @foreach ($branchs as $key => $branch)
                                                <option value="{{$branch->code_branch}}">{{$branch->name_branch}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div> -->
                                    <center><button type="submit" class="btn btn-primary btn-sm fontslabel">ค้นหา</button></center>&nbsp;
                                    <center><a class="btn btn-info btn-sm fontslabel" href="{{url('payser')}}">ดูของวันนี้</a></center>

                                {!! Form::close() !!}
                                <!-- Button to Open the Modal -->
                                <div>
                                  <button type="button" class="btn btn-primary" data-toggle="modal" style="float: right;margin: 0px 12px 10px 10px;" data-target="#myModal">
                                    <i class="fas fa-plus">
                                      <fonts id="fontscontent">เพิ่มข้อมูล
                                    </i>
                                  </button>
                                </div>
                                <br>
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
                                </div>




                                <br>
                                <!-- The Modal -->
                                <div class="modal fade" id="myModal">
                                  <div class="modal-dialog modal-xl">
                                    <div class="modal-content">

                                      <!-- Modal Header -->
                                      <div class="modal-header">
                                        <h4 class="modal-title" id="fontscontent2"><b>แจ้งการจ่ายเงิน (สด/โอน)</b></h4>
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

                                              {!! Form::open(['route' => 'payser.store', 'method' => 'post', 'id' => 'myForm' , 'files' => true ]) !!}
                                                {{ csrf_field() }}
                                          <!-- <div class="row">
                                            <div class="col-sm"> -->
                                            <div class="form-inline">
                                              <label id="fontslabel"><b>สาขา :</b></label>
                                              <div class="col-sm">
                                              <select style="width: 100%;max-width: 500px;" class="form-control" id="modal-input-branch" name="branch" onchange="selectbranch2(this)">
                                                <option disabled selected>เลือกสาขา</option>
                                                @foreach ($branchs as $key => $branch)
                                                <option value="{{$branch->code_branch}}">{{$branch->name_branch}}</option>
                                                @endforeach
                                              </select>
                                              </div>

                                              <label id="fontslabel"><b>ประเภทการจ่ายเงิน :</b></label>
                                              <div class="col-sm">
                                              <select style="width: 100%;max-width: 500px;" class="form-control" name="type_po" onchange="selecttypepay(this)">
                                                <option disabled selected>เลือกประเภทการจ่ายเงิน</option>
                                                @foreach ($type_pays as $key => $type_pay)
                                                <option value="{{$type_pay->id}}">{{$type_pay->name_pay}}</option>
                                                @endforeach
                                              </select>
                                              </div>
                                            </div>

                                              <?php
                                                $level_id = Session::get('emp_code');
                                                // echo $level_id;
                                              ?>
                                              <input type="hidden" name="get_emp" value="{{ $level_id }}">


                                              <div class="container1">
                                              </div>

                                              <br>
                                              <div class="form-inline">
                                              <label id="fontslabel"><b>ใบเลขที่ PO :</b></label>
                                              <div class="col-sm">
                                              <select style="width: 100%;max-width: 1200px;" class="form-control select2" id="modal-input-po" name="po[]" multiple="multiple">
                                              </select>
                                              </div>
                                              </div>

                                              <div class="container2">
                                              </div>

                                              <div class="container3">
                                              </div>

                                              <br>
                                              <div class="form-inline">
                                              <label id="fontslabel"><b>จำนวนเงินที่ขอ :</b></label>
                                              <div class="col-sm">
                                              <input type="text" style="width: 100%;max-width: 1200px;" name="money_request" class="form-control" id="showmoney" readonly>
                                              </div>
                                              </div>

                                              <br>
                                              <div class="form-inline">
                                                <label id="fontslabel"><b>วันที่ตามใบกำกับภาษี :</b></label>
                                                <div class="col-sm">
                                                <input style="width: 100%;max-width: 500px;" type="date" autocomplete="off" class="form-control" name="date_picker_withtax">
                                                </div>

                                                <label id="fontslabel"><b>เลขที่ใบกำกับภาษี :</b></label>
                                                <div class="col-sm">
                                                <input style="width: 100%;max-width: 500px;" type="text" name="bill_no_withtax" class="form-control">
                                                </div>
                                              </div>

                                              <br>
                                              <div class="form-inline">
                                                <label id="fontslabel"><b>วันที่ตามใบเสร็จรับเงิน :</b></label>
                                                <div class="col-sm">
                                                <input style="width: 100%;max-width: 500px;" type="date" autocomplete="off" class="form-control" name="date_picker_withpaybill">
                                                </div>

                                                <label id="fontslabel"><b>เลขที่ใบเสร็จรับเงิน :</b></label>
                                                <div class="col-sm">
                                                <input style="width: 100%;max-width: 500px;" type="text" name="bill_no_withpaybill" class="form-control">
                                                </div>
                                              </div>

                                              <br>
                                              <div class="form-inline">
                                              <label id="fontslabel"><b>แนบหลักฐาน :</b></label>
                                              <div class="col-sm">
                                              <input style="width: 100%;max-width: 1200px;" type="file" name="inform_po_picture" class="form-control">
                                              </div>
                                              </div>

                                              <br>
                                              <div style="padding: 10px 50px 0px 50px;" id="table-po">
                                                <div class="table-responsive">
                                                  <table class="table">
                                                    <thead class="thead-light">
                                                      <tr>
                                                        <th width="5%" id="fontstable">ลำดับ</th>
                                                        <th width="35%" id="fontstable">รายการ</th>
                                                        <th width="8%" id="fontstable">จำนวน</th>
                                                        <th width="12%" id="fontstable">ราคาต่อหน่วย</th>
                                                        <!-- <th width="15%" id="fontstable">หัก ณ ที่จ่าย (บาท)</th> -->
                                                        <th width="20%" id="fontstable">จำนวนเงิน</th>
                                                        <th width="15%" id="fontstable">หมายเหตุ</th>
                                                      </tr>
                                                    </thead>
                                                    <tbody id="po_content">

                                                    </tbody>

                                                    <tfoot class="thead-light">

                                                      <tr>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th style="text-align: right;" id="fontstable">รวม</th>
                                                        <td><input type="text" name="sum_col" id="sum_col" class="form-control"></td>
                                                      </tr>

                                                      <tr>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th style="text-align: right;" id="fontstable">ส่วนลด(%)</th>
                                                        <td><input type="text" onchange="change_discount()" id="discountfinal" class="form-control" required><input type="text" class="form-control" name="sum_discount" id="sum_discountfinal" readonly>
                                                        </td>
                                                      </tr>

                                                      <tr>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th style="text-align: right;" id="fontstable">ยอดรวมหลังส่วนลด</th>
                                                        <td><input type="text" value="" id="sum"  class="form-control" readonly></td>
                                                      </tr>

                                                      <tr class="container11">
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th style="text-align: right;" id="fontstable">ภาษีมูลค่าเพิ่ม <select class="input-small" name="vat" id="vat" onchange="calculatelast()">
                                                                                                      @foreach ($vats as $key => $vat)
                                                                                                        <?php if ($vat->tax == 0) { ?>
                                                                                                          <option value="{{$vat->tax}}" selected>{{$vat->tax}} %</option>
                                                                                                        <?php } else { ?>
                                                                                                          <option value="{{$vat->tax}}" selected>{{$vat->tax}} %</option>
                                                                                                        <?php } ?>
                                                                                                      @endforeach
                                                                                                    </select>

                                                        </th>
                                                        <td><input type="text" name="vat_cal_true" id="sumcalvat"  class="form-control" readonly></td>
                                                      </tr>

                                                      <tr class="container11">
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th style="text-align: right;" id="fontstable">จำนวนเงินรวม</th>
                                                        <td><input type="text" name="sum_vat" value="" id="sumplusvat"  class="form-control" readonly></td>
                                                      </tr>

                                                        <tr class="container10">
                                                          <th></th>
                                                          <th></th>
                                                          <th></th>
                                                          <th></th>
                                                          <th style="text-align: right;" id="fontstable">วันที่เสียภาษีหัก ณ ที่จ่าย</th>
                                                          <td><input type="date" autocomplete="off" class="form-control" name="date_picker_wht"></td>
                                                        </tr>

                                                        <tr class="container10">
                                                          <th></th>
                                                          <th></th>
                                                          <th></th>
                                                          <th></th>
                                                          <th style="text-align: right;" id="fontstable">ภาษีหัก ณ ที่จ่าย <div id="showpercentwhd"></div> %</th>
                                                          <td><input type="text" name="sum_wht" value="" id="after_wht"  class="form-control" readonly></td>
                                                        </tr>

                                                        <tr class="container10">
                                                          <th></th>
                                                          <th></th>
                                                          <th></th>
                                                          <th></th>
                                                          <th style="text-align: right;" id="fontstable">บริษัทออกแทน</th>
                                                          <td id="fontstable"><input type="checkbox" name="company_pay" value="255"/></td>
                                                        </tr>
                                                      <!-- </div> -->


                                                        <tr>
                                                          <th></th>
                                                          <th></th>
                                                          <th></th>
                                                          <th></th>
                                                          <th style="text-align: right;" id="fontstable">รวมเป็นเงินสุทธิ</th>
                                                          <td><input type="text" id="after_vat_wht"  name="grand_total" class="form-control" readonly></td>
                                                        </tr>

                                                      <!-- <tr>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th style="text-align: right;" id="fontstable">เงินทอน</th>
                                                        <td><input type="text" class="form-control" readonly></td>
                                                      </tr> -->

                                                      <!-- <tr>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th style="text-align: right;">ยอดเงินที่ต้องจ่าย :</th>
                                                        <td><input type="text" name="money_request" class="form-control" required></td>
                                                      </tr> -->

                                                    </tfoot>
                                                  </table>
                                                </div>
                                              </div>

                                            </div>

                                      <!-- Modal footer -->

                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-primary" onclick="cleardata()">รีเซ็ตข้อมูล (กรณีข้อมูลค้าง)</button>
                                        <a href="{{route('payser')}}">
                                      {!! Form::submit('บันทึก', ['class' => 'btn btn-success', 'style' => 'dispaly: inline']) !!}
                                        <button type="button" class="btn btn-warning" data-dismiss="modal">ยกเลิก</button>
                                        </a>
                                      </div>
                                      {!! Form::close() !!}

                                    </div>
                                  </div>
                                </div>


                                  <div>
                                    <div class="table-responsive">
                                      <table id="example" class="table table-striped table-bordered fontslabel" style="width:100%">
                                          <thead>
                                            <tr>
                                              <th>ลำดับ</th>
                                              <th>วันที่จ่าย</th>
                                              <th>เลขที่เช็ค</th>
                                              <th>เลขที่ใบสำคัญจ่าย</th>
                                              <th>เลขที่ตามใบเสร็จ</th>
                                              <th>วันที่ตามใบกำกับภาษี</th>
                                              <th>รหัสเจ้าหนี้</th>
                                              <th>จ่ายให้</th>
                                              <th>จำนวนเงิน</th>
                                              <th>Action</th>
                                            </tr>
                                          </thead>

                                          <tbody>
                                            @foreach ($inform_po_mainheads as $key => $inform_po_mainhead)
                                            @if ($inform_po_mainhead->branch_id == $get_branchsession)
                                            <tr>
                                              <td>{{ $key+1 }}</td>
                                              <td>{{$inform_po_mainhead->datebill }}</td>
                                              <td></td>
                                              <td>{{$inform_po_mainhead->payser_number }}</td>
                                              <td>{{$inform_po_mainhead->bill_no }}</td>
                                              <td>{{$inform_po_mainhead->datebill }}</td>
                                              <td>{{$inform_po_mainhead->tax_id}}</td>
                                              <td>{{$inform_po_mainhead->name_supplier}}</td>
                                              <td>{{$inform_po_mainhead->payout}}</td>
                                              <td><a href="{{ route ('payserpdf', ['id' => $inform_po_mainhead->id_inform_po]) }}" class="btn btn-primary">ดาวน์โหลดรายงาน
                                                  <!-- <button class="btn btn-primary">ดาวน์โหลดรายงาน</button> -->
                                                  </a>
                                                  <!-- onclick="getpicview({{ $inform_po_mainhead->id_inform_po }})" -->
                                                  <button type="button" class="btn btn-primary btn-md" data-toggle="modal" data-target="#picview{{$inform_po_mainhead->id_inform_po}}"><b>ดูรูปหลักฐานที่แนบ</b></button>
                                                  <a href="{{ route ('edit_payser', ['id' => $inform_po_mainhead->id_inform_po]) }}" class="btn btn-warning">แก้ไข</a>
                                                  <!-- <button type="button" class="btn btn-warning btn-md" id="value" onclick="getdataedit({{ $inform_po_mainhead->id_inform_po }})" data-toggle="modal" data-target="#modaledit"><b>แก้ไข</b></button> -->
                                                  <a href="{{ route ('payser.delete', ['id' => $inform_po_mainhead->id_inform_po]) }}" class="btn btn-danger btn-md delete-confirm">ลบ</a>
                                                  <!-- <button type="button" class="btn btn-danger btn-md" data-toggle="modal" onclick="confirmdelete({{ $inform_po_mainhead->id_inform_po }})">ลบ</button> -->
                                              </td>
                                            </tr>
                                            @endif
                                            @endforeach
                                          </tbody>
                                        </table>
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
  @foreach ($inform_po_mainheads as $key => $inform_po_mainhead)
  <div class="modal fade" id="modaledit">
      <div class="modal-dialog modal-xl">
          <div class="modal-content">

              <!-- Modal Header -->
              <div class="modal-header">
                <h4 class="modal-title" id="fontscontent2"><b>แจ้งการจ่ายเงิน (สด/โอน)</b></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
                <!-- Modal body -->
                <div class="modal-body">

                            {!! Form::open(['route' => ['payser.update'], 'method' => 'patch', 'files' => true]) !!}
                            <div class="form-inline">
                                  <label class="col-form-label" id="fontslabel"><b>สาขา :</b></label>
                                <div class="col">
                                  <input style="width: 100%;max-width: 500px;" type="text" class="form-control" id="getbranch" readonly>
                                </div>
                                  <label class="col-form-label" id="fontslabel"><b>ประเภทการจ่ายเงิน :</b></label>
                                <div class="col">
                                  <input style="width: 100%;max-width: 500px;" type="text" class="form-control" id="get_type_po" readonly>
                                </div>
                            </div>

                            <input type="hidden" id="get_id_payser" name="get_id">

                            <input type="hidden" id="get_type_po_no">
                            <div class="container1">

                            </div>

                            <br>
                            <div style="padding: 0px 100px 0px 100px;" id="fontstable">
                              <div class="table-responsive">
                                <table class="table">
                                  <thead class="thead-light">
                                    <tr>
                                      <th>ลำดับ</th>
                                      <th>ใบเลขที่ PS</th>
                                      <th>ใบเลขที่ PO</th>
                                      <th>จำนวนเงิน</th>
                                      <th>หมายเหตุ</th>
                                    </tr>
                                  </thead>
                                  <tbody id="cccccc">

                                  </tbody>
                                </table>
                              </div>
                            </div>

                            <div class="form-inline">
                              <label class="col-form-label" id="fontslabel"><b>จำนวนเงินที่ขอ :</b></label>
                              <div class="col">
                              <input style="width: 100%;max-width: 1200px;" type="text" name="money_request" class="form-control" value="" id="totalsumreal2" readonly>
                              </div>
                            </div>
                            <br>

                            <div class="form-inline">
                                <label id="fontslabel"><b>วันที่ตามใบกำกับภาษี :</b></label>
                                <div class="col">
                                <input style="width: 100%;max-width: 500px;" type="date" autocomplete="off" class="form-control" name="date_picker_withtaxs" id="datebill_from_vat">
                                </div>

                                <label id="fontslabel"><b>เลขที่ใบกำกับภาษี :</b></label>
                                <div class="col">
                                <input style="width: 100%;max-width: 500px;" type="text" name="bill_no_withtaxs" class="form-control" id="bill_no_from_vat">
                                </div>
                            </div>
                            <br>
                            <div class="form-inline">
                                <label id="fontslabel"><b>วันที่ตามใบเสร็จรับเงิน :</b></label>
                                <div class="col">
                                <input style="width: 100%;max-width: 500px;" type="date" autocomplete="off" class="form-control" name="date_picker_withpaybills" id="datebill">
                                </div>

                                <label id="fontslabel"><b>เลขที่ใบเสร็จรับเงิน :</b></label>
                                <div class="col">
                                <input style="width: 100%;max-width: 500px;" type="text" name="bill_no_withpaybills"s class="form-control" id="bill_no">
                                </div>
                            </div>

                            <br>
                            <div style="padding: 10px 50px 0px 50px;">
                              <div class="table-responsive">
                                <table class="table" id="fontstable">
                                  <thead class="thead-light">
                                    <tr>
                                      <th>ลำดับ</th>
                                      <th>รายการ</th>
                                      <th>จำนวน</th>
                                      <th>ราคาต่อหน่วย</th>
                                      <th>หัก ณ ที่จ่าย (บาท)</th>
                                      <th>จำนวนเงิน</th>
                                      <th>หมายเหตุ</th>
                                    </tr>
                                  </thead>
                                  <tbody id="po_content2">

                                  </tbody>
                                  <tfoot class="thead-light">

                                    <tr>
                                      <th></th>
                                      <th></th>
                                      <th></th>
                                      <th></th>
                                      <th></th>
                                      <th style="text-align: right;">ส่วนลด :</th>
                                      <td><input type="text" name="sum_discount" id="discountshow"  class="form-control" readonly></td>
                                    </tr>

                                    <tr>
                                      <th></th>
                                      <th></th>
                                      <th></th>
                                      <th></th>
                                      <th></th>
                                      <th style="text-align: right;">จำนวนเงินรวม :</th>
                                      <td><input type="text" name="sum_vat" value="" id="sum1"  class="form-control" readonly></td>
                                    </tr>

                                    <tr class="container15">
                                      <th></th>
                                      <th></th>
                                      <th></th>
                                      <th></th>
                                      <th></th>
                                      <th style="text-align: right;">วันที่เสียภาษีหัก ณ ที่จ่าย :</th>
                                      <td><input type="date" autocomplete="off" class="form-control" name="date_pay_whts"></td>
                                    </tr>

                                    <tr>
                                      <th></th>
                                      <th></th>
                                      <th></th>
                                      <th></th>
                                      <th></th>
                                      <th style="text-align: right;">ยอดหัก ณ ที่จ่าย : </th>
                                      <td><input type="text" id="whtshow" class="form-control" readonly></td>
                                    </tr>

                                    <tr>
                                      <th></th>
                                      <th></th>
                                      <th></th>
                                      <th></th>
                                      <th></th>
                                      <th style="text-align: right;">บริษัทออกแทน : </th>
                                      <td>
                                          <input type="text" class="form-control" id="company_pay_wht_show" readonly>
                                      </td>
                                    </tr>

                                    <!-- <tr>
                                      <th></th>
                                      <th></th>
                                      <th></th>
                                      <th></th>
                                      <th></th>
                                      <th style="text-align: right;">VAT  % : </th>
                                      <td>
                                         <input type="text" class="form-control" id="" readonly>
                                      </td>
                                    </tr> -->

                                    <tr>
                                      <th></th>
                                      <th></th>
                                      <th></th>
                                      <th></th>
                                      <th></th>
                                      <th style="text-align: right;">ยอดเงินทั้งหมด :</th>
                                      <td><input type="text" class="form-control" value="{{ $inform_po_mainhead->payout }}" readonly></td>
                                    </tr>


                                  </tfoot>
                                </table>
                              </div>
                            </div>



                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <a href="{{route('payser')}}">
                        <input type="submit" class="btn btn-success" style="display: inline" id="button-submit-edit" value="บันทึก">
                        <button type="button" class="btn btn-warning" data-dismiss="modal">ยกเลิก</button>
                    </a>
                </div>
                {!! Form::close() !!}

          </div>
      </div>
  </div>
  @endforeach
  <!-- end iditmodal -->







  <!-- view pic -->
  @foreach ($inform_po_mainheads as $key => $inform_po_mainhead)
  <div class="modal fade" id="picview{{$inform_po_mainhead->id_inform_po}}">
      <div class="modal-dialog modal-xl">
          <div class="modal-content">

              <!-- Modal Header -->
              <div class="modal-header">
                <h4 class="modal-title" id="fontscontent2"><b>แจ้งการจ่ายเงิน (สด/โอน)</b></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
                <!-- Modal body -->
                <div class="modal-body">
                <!-- {!! Form::open(['route' => ['payser.update'], 'method' => 'patch', 'files' => true]) !!} -->

                  <div class="row">
                    <img style="display: block; margin-left: auto; margin-right: auto; width: 100%;" class="img-fluid" src="{{ asset($inform_po_mainhead->new_inform_po_picture) }}">
                  </div>

                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <a href="{{route('payser')}}">
                        <!-- <input type="submit" class="btn btn-success" style="display: inline" id="button-submit-edit" value="บันทึก"> -->
                        <button type="button" class="btn btn-warning" data-dismiss="modal">ยกเลิก</button>
                    </a>
                </div>

          </div>
      </div>
  </div>
  @endforeach
    <!-- view pic -->



  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <script type="text/javascript" src = 'js/accountjs/payser.js'></script>
  <!-- <script>

  </script> -->
  <script>
      $(document).ready(function() {
      $('#example').DataTable();
      } );
  </script>
@endsection
