@extends('index')
@section('content')

<?php
  $level_id = Session::get('level_id');
  // echo $level_id;
?>

<link rel="stylesheet" href="{{asset('css/debt/debt.css')}}"> //! include css
<!-- css data table -->
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css" />
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" />
<!-- SWAL -->
<script type="text/javascript" src="https://unpkg.com/sweetalert2@7.0.6/dist/sweetalert2.all.js"></script>
<!-- jquery account debt -->
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript" src={{ asset('js/accountjs/debt.js') }}></script>

<!-- jquery -->
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<!-- -----แสดง SWAL เมื่อบันทึกการตั้งหนี้สำเร็จ--------- -->
@if (Session::has('sweetalert.json'))
<script>
  swal({!!Session::pull('sweetalert.json') !!});
</script>
@endif
<!-- -----แสดง SWAL เมื่อบันทึกการตั้งหนี้สำเร็จ--------- -->


<div class="content-page">
  <!-- Start content -->
  <div class="content">
    <div class="container-fluid">

      <div class="row">
        <div class="col-xl-12">
          <div class="breadcrumb-holder" id="fontscontent">
            <h1 class="float-left">Account - FSCT</h1>
            <ol class="breadcrumb float-right">
              <li class="breadcrumb-item">จัดการข้อมูล</li>
              <li class="breadcrumb-item active">รายการตั้งหนี้</li>
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
                <fonts id="fontsheader">รายการตั้งหนี้</fonts>
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

          <!-- แสดง error -->
          @if($errors->any())
          <script>
            swal({
              title: 'กรุณาระบุข้อมูลให้ครบถ้วน',
              html: '{!! implode(' < br > ',$errors->all()) !!}',
              type: 'error'
            })
          </script>
          @endif
          <!-- แสดง error -->

          <!-- The Modal -->
          <div class="modal fade" id="myModal">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                  <h4 class="modal-title" id="fontscontent2"><b>แบบฟอร์มรายการตั้งหนี้</b></h4>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <!-- ทำการ validate ช่องข้อมูล แสดง error -->
                <div class="modal-body">

                  @if ($errors->any())

                  <div class="alert alert-danger" id="fontscontent2">
                    <ul>
                      @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                      @endforeach
                    </ul>
                  </div>

                  @endif
                  <!-- //สิ้นสุด ทำการ validate ช่องข้อมูล แสดง error -->

                  {!! Form::open(['route' => 'debt.store', 'method' => 'post', 'files' => true]) !!}
                  <div class="form-inline">
                  <label id="fontslabel"><b>สาขา :</b></label>
                  <div class="col-sm">
                  <select style="width: 100%;max-width: 500px;" class="form-control" id="modal-input-province" name="branch_id" onchange="selectbranch(this)">
                    <option value="">เลือกจังหวัด</option>
                    @foreach ($branchs as $key => $branch)
                    <option value="{{$branch->code_branch}}">{{$branch->name_branch}}</option>
                    @endforeach
                  </select>
                  </div>
                  <label id="fontslabel"><b>เลขที่ PO :</b></label>
                  <div class="col-sm">
                  <select style="width: 100%;max-width: 500px;" class="form-control" id="modal-input-po" name="po_no" onchange="terms(this)">
                    <option value="">Select PO</option>
                  </select>
                  </div>
                  </div>
                  <br>
                  <div class="form-inline">
                    <label id="fontslabel"><b>จำนวนเงิน :</b></label>
                    <div class="col-sm">
                      <input style="width: 100%; max-width: 1200px;" type="text" name="modal-input-calculate" class="form-control" id="sumshow" readonly>
                      <!-- <input style="width: 100%;max-width: 1200px;" type="text" name="modal-input-calculate" class="form-control" id="totalsumall" readonly> -->
                    </div>
                  </div>
                  <br>

                  <input type="hidden" class="form-control" id="suppliers" readonly>

                  <div class="form-inline">
                    <label class="col-form-label" for="modal-input-priceservice" id="fontslabel"><b>วันที่ :</b></label>
                    <div class="col-sm">
                    <input style="width: 100%;max-width: 500px;" type="date" autocomplete="off" class="form-control" name="datebill">
                    </div>
                    <label id="fontslabel"><b>เลขที่บิล :</b></label>
                    <div class="col-sm">
                    <input style="width: 100%;max-width: 500px;" type="text" name="bill_no" class="form-control" id="modal-input-calculate">
                    </div>
                  </div>
                  <div style="padding: 10px 50px 0px 50px;" id="table-po">
                    <div class="table-responsive">
                      <table class="table">
                        <thead class="thead-light">
                          <tr>
                            <th>ลำดับ</th>
                            <th>รายการ</th>
                            <th>จำนวน</th>
                            <th>ราคาต่อหน่วย</th>
                            <th>ส่วนลด(%)</th>
                            <th>จำนวนเงิน</th>
                            <th>หมายเหตุ</th>
                          </tr>
                        </thead>
                        <tbody id="po_content">

                        </tbody id="">
                        <tfoot class="thead-light" id="footer">
                          <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th style="text-align: right;">จำนวนเงิน :</th>
                            <td id="show_realtotal">-</td>
                          </tr>
                          <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th style="text-align: right;">ส่วนลด :</th>
                            <td id="discount">...</td>
                          </tr>
                          <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th style="text-align: right;">ยอดหลังหักส่วนลด :</th>
                            <td id="after_discount">...</td>
                          </tr>
                          <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th style="text-align: right;">ภาษีมูลค่าเพิ่ม(%) :</th>
                            <td id="vat">...</td>
                          </tr>
                          <!-- <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th style="text-align: right;">ยอดภาษี :</th>
                            <td id="cal_vat">...</td>
                          </tr> -->
                          <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th style="text-align: right;">จำนวนเงินรวมทั้งสิ้น :</th>
                            <td id="sum-all">...</td>

                          </tr>
                        </tfoot>
                      </table>
                    </div>
                  </div>

                  <br>
                  <div class="form-inline">
                    <label id="fontslabel"><b>เครดิตครบกำหนด :</b></label>
                    <div class="col-sm">
                    <input style="width: 100%;max-width: 1200px;" type="text" name="credit" class="form-control" id="modal-input-credit" value="">
                    </div>
                  </div>
                  <br>
                  <div class="form-inline">
                    <label id="fontslabel"><b>แนบหลักฐาน :</b></label>
                    <div class="col-sm">
                    <input style="width: 100%;max-width: 1200px;" type="file" name="inform_po_picture" class="form-control" id="modal-input-bookinc">
                    </div>
                  </div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                  <a href="{{route('debt')}}">
                    {!! Form::submit('บันทึก', ['class' => 'btn btn-success', 'style' => 'dispaly: inline']) !!}
                    <button type="button" class="btn btn-warning" data-dismiss="modal">ยกเลิก</button>
                  </a>
                </div>
                {!! Form::close() !!}

              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- end row -->
    </div>
    <!-- END container-fluid -->
  </div>
  <!-- END content -->

  <!-- Tabs -->
  <section id="tabs">
    <div class="container">
      <h6 class="section-title h1"></h6>
      <div class="row">
        <div class="col-12 " style="widht:100%;">
          <nav>
            <div class="nav nav-tabs nav-fill fontslabel" id="nav-tab" role="tablist">

              <!-- <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">รายการที่ยังไม่ได้โอน</a> -->
              <a class="nav-item nav-link" id="nav-supplier-tab" data-toggle="tab" href="#nav-supplier" role="tab" aria-controls="nav-supplier" aria-selected="false">รายการเจ้าหนี้การค้ารอโอน</a>

              <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">รายการรอแจ้งการจ่ายเงิน</a>
              <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">รายการทั้งหมด</a>
              <!-- <a class="nav-item nav-link" id="nav-supplier-tab" data-toggle="tab" href="#nav-supplier" role="tab" aria-controls="nav-supplier" aria-selected="false">รายการเจ้าหนี้การค้ารอโอน</a> -->
            </div>
          </nav>

          <div class="tab-content py-3 px-3 px-sm-0" id="nav-tabContent">


            <!-- ดูรายการเจ้าหนี้ทั้งหมด -->
            <div class="tab-pane fade" id="nav-supplier" role="tabpanel" aria-labelledby="nav-supplier-tab">
              <!-- table ทั้งหมด-->
              <div class="table-responsive">
                <table id="example3" class="table table-striped table-bordered fontslabel" style="width:100%">
                  <thead>
                    <tr>
                      <th>ลำดับ</th>
                      <th>เลขที่ใบตั้งหนี้</th>
                      <th>ชื่อเจ้าหนี้</th>
                      <th>สาขา</th>
                      <th>วันที่เริ่มบิล</th>
                      <th>วันที่ครบรอบบิล</th>
                      <th>จำนวนเงิน</th>
                      <th>สถานะ</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($list_suppliers as $key => $list_supplier)
                    <tr>
                      <td>{{++$key}}</td>
                      <td>{{$list_supplier->number_debt}}</td>
                      <td>{{$list_supplier->name_supplier}}</td>
                      <td>{{$list_supplier->bill_no}}</td>
                      <td>
                          <?php
                          $cutstrdate = substr($list_supplier->datebill,5);
                          $month = strtok($cutstrdate,'-');
                          // echo $month;
                          if ($month == 1) {
                              echo "2020-01-01";
                          }elseif ($month == 2) {
                              echo "2020-02-01";
                          }elseif ($month == 3) {
                              echo "2020-03-01";
                          }elseif ($month == 4) {
                              echo "2020-04-01";
                          }elseif ($month == 5) {
                              echo "2020-05-01";
                          }elseif ($month == 6) {
                              echo "2020-06-01";
                          }elseif ($month == 7) {
                              echo "2020-07-01";
                          }elseif ($month == 8) {
                              echo "2020-08-01";
                          }elseif ($month == 9) {
                              echo "2020-09-01";
                          }elseif ($month == 10) {
                              echo "2020-10-01";
                          }elseif ($month == 11) {
                              echo "2020-11-01";
                          }else{
                              echo "2020-12-01";
                          }
                          ?>
                      </td>
                      <td>
                          <?php
                          $cutstrdate = substr($list_supplier->datebill,5);
                          $month = strtok($cutstrdate,'-');
                          // echo $month;
                          if ($month == 1) {
                              echo "2020-01-31";
                          }elseif ($month == 2) {
                              echo "2020-02-28";
                          }elseif ($month == 3) {
                              echo "2020-03-31";
                          }elseif ($month == 4) {
                              echo "2020-04-30";
                          }elseif ($month == 5) {
                              echo "2020-05-31";
                          }elseif ($month == 6) {
                              echo "2020-06-30";
                          }elseif ($month == 7) {
                              echo "2020-07-31";
                          }elseif ($month == 8) {
                              echo "2020-08-31";
                          }elseif ($month == 9) {
                              echo "2020-09-30";
                          }elseif ($month == 10) {
                              echo "2020-10-01";
                          }elseif ($month == 11) {
                              echo "2020-11-30";
                          }else{
                              echo "2020-12-31";
                          }
                          ?>
                      </td>
                      <td>{{$list_supplier->total_col}}</td>
                      <td>
                        <a href="{{ route('debtpdfsupplier',$list_supplier->supplier_id) }}">
                        <button class="btn btn-primary">ดาวนืโหลดรายงาน</button>
                        </a>

                        @if($list_supplier->status_tranfer == 0)
                        {!! Form::open(['route' => 'debtconfirm', 'method' => 'post']) !!}
                          <input type="hidden" name="supplier_ids[]" value="{{$list_supplier->supplier_id}}">
                          <button type="submit" class="btn btn-warning">รอโอน</buttosn>
                        {!! Form::close() !!}
                        @else
                          <button class="btn btn-success" id="transfering">โอนแล้ว</button>
                        @endif
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table><br>
              </div>
              <!-- table -->
            </div>
            <!-- ปิดรายการเจ้าหนี้ -->
            <!-- <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab"> -->
              <!-- table ยังไม่ได้จ่าย-->
              <!-- <div class="table-responsive">
                <table id="example" class="table table-striped table-bordered fontslabel" style="width:100%">
                  <thead>
                    <tr>
                      <th>ลำดับ</th>
                      <th>เลขที่ใบตั้งหนี้</th>
                      <th>ชื่อเจ้าหนี้</th>
                      <th>สาขา</th>
                      <th>วันที่บิล</th>
                      <th>เลขที่บิล</th>
                      <th>จำนวนเงิน</th>
                      <th>สถานะ</th>
                    </tr>
                  </thead>
                  <tbody>

                    @foreach ($lists as $key => $list)
                    @if($list->status_pay == 0)
                    <tr>
                      <td>{{++$key}}</td>
                      <td>{{$list->number_debt}}</td>
                      <td>{{$list->supplier_id}}</td>
                      <td>{{$list->bill_no}}</td>
                      <td>{{$list->datebill}}</td>
                      <td>{{$list->branch_id}}</td>
                      <td>
                        <a href="{{ route('debtpdf',$list->id) }}">
                          <button class="btn btn-primary">ดาวนืโหลดรายงาน</button>
                        </a>
                      </td>
                      <td>
                        @if($list->status_tranfer == 0)
                        {!! Form::open(['route' => 'debtconfirm', 'method' => 'post']) !!}
                          <input type="hidden" name="indebt_number[]" value="{{$list->number_debt}}">
                          <button type="submit" class="btn btn-warning">รอโอน</buttosn>
                        {!! Form::close() !!}
                        @else
                          <button class="btn btn-success" id="transfering">โอนแล้ว</button>
                        @endif
                      </td>
                    </tr>
                    @endif
                    @endforeach
                  </tbody>
                </table><br>
              </div> -->
              <!-- table -->
            <!-- </div> -->


            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
              <!-- table จ่ายแล้ว-->
              <div class="table-responsive">
                <table id="example1" class="table table-striped table-bordered fontslabel" style="width:100%">
                  <thead>
                    <tr>
                      <th>ลำดับ</th>
                      <th>เลขที่ใบตั้งหนี้</th>
                      <th>ชื่อเจ้าหนี้</th>
                      <th>สาขา</th>
                      <th>วันที่บิล</th>
                      <th>เลขที่บิล</th>
                      <th>จำนวนเงิน</th>
                      <th>สถานะ</th>
                    </tr>
                  </thead>
                  <tbody>

                    @foreach ($lists as $key => $list)
                    @if($list->status_tranfer == 1)
                    <tr>
                      <td>{{++$key}}</td>
                      <td>{{$list->number_debt}}</td>
                      <td>{{$list->supplier_id}}</td>
                      <td>{{$list->bill_no}}</td>
                      <td>{{$list->datebill}}</td>
                      <td>{{$list->branch_id}}</td>
                      <td>
                        <a href="{{ route('debtpdf',$list->id) }}">
                          <button class="btn btn-primary">ดาวนืโหลดรายงาน</button>
                        </a>
                      </td>
                      <td>
                        @if($list->status_pay == 0)
                        <a href="{{ route('paycredit') }}">
                          <button class="btn btn-warning">แจ้งการจ่ายเงิน</button>
                        </a>
                        @else
                          <button class="btn btn-success" id="transfering">แจ้งการจ่ายเงินแล้ว</button>
                        @endif
                      </td>
                    </tr>
                    @endif
                    @endforeach
                  </tbody>
                </table><br>
              </div>
              <!-- table -->
            </div>

            <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
              <!-- table ทั้งหมด-->
              <div class="table-responsive">
                <table id="example2" class="table table-striped table-bordered fontslabel" style="width:100%">
                  <thead>
                    <tr>
                      <th>ลำดับ</th>
                      <th>เลขที่ใบตั้งหนี้</th>
                      <th>ชื่อเจ้าหนี้</th>
                      <th>สาขา</th>
                      <th>วันที่บิล</th>
                      <th>เลขที่บิล</th>
                      <th>จำนวนเงิน</th>
                      <th>สถานะ</th>
                    </tr>
                  </thead>
                  <tbody>

                    @foreach ($lists as $key => $list)
                    <tr>
                      <td>{{++$key}}</td>
                      <td>{{$list->number_debt}}</td>
                      <td>{{$list->supplier_id}}</td>
                      <td>{{$list->bill_no}}</td>
                      <td>{{$list->datebill}}</td>
                      <td>{{$list->branch_id}}</td>
                      <td>
                        <a href="{{ route('debtpdf',$list->id) }}">
                          <button class="btn btn-primary">ดาวนืโหลดรายงาน</button>
                        </a>
                      </td>
                      <td>

                        @if($list->status_pay == 0 && $list->status_tranfer == 0)
                          <div class="alert alert-warning" role="alert">
                            รอโอน แต่ ยังไม่ได้แจ้งการจ่ายเงิน
                          </div>
                        @elseif($list->status_pay == 1 && $list->status_tranfer == 0)
                          <div class="alert alert-warning" role="alert">
                            รอโอน และ แจ้งการจ่ายเงินแล้ว
                          </div>
                        @elseif($list->status_pay == 0 && $list->status_tranfer == 1)
                          <div class="alert alert-warning" role="alert">
                            โอนแล้ว แต่ ยังไม่ได้แจ้งการจ่ายเงิน
                          </div>
                        @else
                          <div class="alert alert-success" role="alert">
                            โอนแล้ว และ แจ้งการจ่ายเงินแล้ว
                          </div>
                        @endif
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table><br>
              </div>
              <!-- table -->
            </div>

            <!-- ดูรายการเจ้าหนี้ทั้งหมด -->
            <!-- <div class="tab-pane fade" id="nav-supplier" role="tabpanel" aria-labelledby="nav-supplier-tab"> -->
              <!-- table ทั้งหมด-->
              <!-- <div class="table-responsive">
                <table id="example3" class="table table-striped table-bordered fontslabel" style="width:100%">
                  <thead>
                    <tr>
                      <th>ลำดับ</th>
                      <th>เลขที่ใบตั้งหนี้</th>
                      <th>ชื่อเจ้าหนี้</th>
                      <th>สาขา</th>
                      <th>วันที่บิล</th>
                      <th>เลขที่บิล</th>
                      <th>จำนวนเงิน</th>
                      <th>สถานะ</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($list_suppliers as $key => $list_supplier)
                    <tr>
                      <td>{{++$key}}</td>
                      <td>{{$list_supplier->number_debt}}</td>
                      <td>{{$list_supplier->supplier_id}}</td>
                      <td>{{$list_supplier->bill_no}}</td>
                      <td>{{$list_supplier->datebill}}</td>
                      <td>{{$list_supplier->branch_id}}</td>
                      <td>
                        <a href="{{ route('debtpdfsupplier',$list_supplier->supplier_id) }}">
                          <button class="btn btn-primary">ดาวนืโหลดรายงาน</button>
                        </a>
                      </td>
                      <td></td>
                    </tr>
                    @endforeach
                  </tbody>
                </table><br>
              </div> -->
              <!-- table -->
            <!-- </div> -->
            <!-- ปิดรายการเจ้าหนี้ -->

          </div>

        </div>
      </div>
    </div>
  </section>
  <!-- ./Tabs -->
</div>
<!-- END content-page -->
</div>
<!-- END main -->
@endsection
