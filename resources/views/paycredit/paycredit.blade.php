@extends('index')
@section('content')
<script type="text/javascript" src="https://unpkg.com/sweetalert2@7.0.6/dist/sweetalert2.all.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
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
                                  <li class="breadcrumb-item">จัดการข้อมูลซื้อ - ขาย</li>
                                  <li class="breadcrumb-item active">แจ้งการจ่ายเงินเชื่อ</li>
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
                            <fonts id="fontsheader">แจ้งการจ่ายเงินเชื่อ</fonts>
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
                                  <div class="modal-dialog modal-xl">
                                    <div class="modal-content">

                                      <!-- Modal Header -->
                                      <div class="modal-header">
                                        <h4 class="modal-title" id="fontscontent2"><b>แจ้งการจ่ายเงินเชื่อ</b></h4>
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

                                              {!! Form::open(['route' => 'paycredit.store', 'method' => 'post', 'files' => true ]) !!}
                                                {{ csrf_field() }}
                                            <div class="form-inline">
                                              <label id="fontslabel"><b>สาขา :</b></label>
                                              <div class="col-sm">
                                              <select style="width: 100%;max-width: 500px;" class="form-control" name="branch" onchange="selectbranch3(this)">
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

                                              <div class="container1">

                                              </div>

                                              <br>

                                              <div class="form-inline">
                                                <label id="fontslabel"><b>เลือก Seller :</b></label>
                                                <div class="col-sm">
                                                <select style="width: 100%;max-width: 1200px;" class="form-control" id="modal-input-po" name="po">
                                                </select>
                                                </div>
                                              </div>

                                              <br>
                                              <br>
                                              <div style="padding: 0px 30px 0px 30px;" id="fontstable">
                                                <div class="table-responsive">
                                                  <table class="table">
                                                    <thead class="thead-light">
                                                      <tr>
                                                        <th>ลำดับ</th>
                                                        <th>ใบเลขที่ AP</th>
                                                        <th>ใบเลขที่ PO</th>
                                                        <th>จำนวนเงิน</th>
                                                        <th>หมายเหตุ</th>
                                                      </tr>
                                                    </thead>
                                                    <tbody id="apdata">

                                                    </tbody>
                                                  </table>
                                                </div>
                                              </div>

                                              <div class="form-inline">
                                              <label id="fontslabel"><b>จำนวนเงินที่ขอ :</b></label>
                                              <div class="col-sm">
                                              <input style="width: 100%;max-width: 1200px;" type="text" name="money_request" class="form-control" id="getmoney" readonly>
                                              </div>
                                              </div>
                                              <br>
                                              <div class="form-inline">
                                                  <label id="fontslabel"><b>วันที่ตามใบเสร็จรับเงิน :</b></label>
                                                  <div class="col-sm">
                                                  <input style="width: 100%;max-width: 1200px;" type="date" autocomplete="off" class="form-control" name="date_picker_withpaybill">
                                                  </div>
                                                  <label id="fontslabel"><b>เลขที่ใบเสร็จรับเงิน :</b></label>
                                                  <div class="col-sm">
                                                  <input style="width: 100%;max-width: 1200px;" type="text" name="bill_no_withpaybill" class="form-control">
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
                                              <div style="padding: 10px 50px 0px 50px;">
                                                <div class="table-responsive">
                                                  <table class="table">
                                                    <thead class="thead-light">
                                                      <tr id="fontstable">
                                                        <th>ลำดับ</th>
                                                        <th>เลขที่ใบแจ้งหนี้</th>
                                                        <th>หัก ณ ที่จ่าย(%)</th>
                                                        <th>ยอดหัก ณ ที่จ่าย</th>
                                                        <th>จำนวนเงิน</th>
                                                      </tr>
                                                    </thead>
                                                    <tbody id="po_content">

                                                    </tbody>

                                                    <tfoot class="thead-light">
                                                      <tr>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th id="fontstable" style="text-align: right;">จำนวนเงินที่ขอ :</th>
                                                        <td><input type="text" name="" value="" id="totalallcol"  class="form-control" readonly></td>
                                                      </tr>

                                                      <tr class="container10">
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th id="fontstable" style="text-align: right;">ยอดหัก ณ ที่จ่าย :</th>
                                                        <td><input type="text" name="" id="sumallwhdcol"  class="form-control" readonly></td>
                                                      </tr>

                                                      <tr class="container10">
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th id="fontstable" style="text-align: right;">บริษัทออกแทน :</th>
                                                        <td id="fontstable"><input type="checkbox" name="company_pay" value="255"/></td>
                                                      </tr>

                                                      <tr>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th id="fontstable" style="text-align: right;">ยอดเงินทั้งหมด :</th>
                                                        <td><input type="text" value="" id="aftermoney"  name="aftermoney1" class="form-control" readonly></td>
                                                      </tr>

                                                    </tfoot>

                                                  </table>
                                                </div>
                                              </div>

                                            </div>

                                      <!-- Modal footer -->

                                      <div class="modal-footer">
                                        <a href="{{route('paycredit')}}">
                                      {!! Form::submit('บันทึก', ['class' => 'btn btn-success', 'style' => 'dispaly: inline']) !!}
                                        <button type="button" class="btn btn-warning" data-dismiss="modal">ยกเลิก</button>
                                        </a>
                                      </div>
                                      {!! Form::close() !!}

                                    </div>
                                  </div>
                                </div>

                                <div >
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
                                          @foreach ($infrom_po_mainheads as $key => $infrom_po_mainhead)
                                        <tr>
                                          <td>{{ $key+1 }}</td>
                                          <td>{{$infrom_po_mainhead->datebill}}</td>
                                          <td></td>
                                          <td>{{$infrom_po_mainhead->payser_number }}</td>
                                          <td>{{$infrom_po_mainhead->datebill }}</td>
                                          <td>{{$infrom_po_mainhead->datebill }}</td>
                                          <td>{{$infrom_po_mainhead->bill_no}}</td>
                                          <td>{{$infrom_po_mainhead->payout}}</td>
                                          <td>{{$infrom_po_mainhead->vat_percent}}</td>
                                          <td><a href="{{ route('paycreditpdf',$infrom_po_mainhead->id) }}">
                                              <button class="btn btn-primary">ดาวน์โหลดรายงาน</button>
                                              </a>
                                              <button type="button" class="btn btn-warning" onclick="getdataedit({{ $infrom_po_mainhead->id }})" data-toggle="modal" data-target="#modaledit"><b>แก้ไข</b></button>
                                              <a href="{{ route ('paycredit.delete', ['id' => $infrom_po_mainhead->id]) }}" class="btn btn-danger btn-md delete-confirm">ลบ</a>
                                              <!-- <button type="button" class="btn btn-danger btn-md" data-toggle="modal" onclick="confirmdelete({{ $infrom_po_mainhead->id }})">ลบ</button> -->
                                          </td>
                                        </tr>
                                          @endforeach
                                      </tbody>
                                    </table>
                                    <br>
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
  @foreach ($infrom_po_mainheads as $key => $infrom_po_mainhead)
  <div class="modal fade" id="modaledit">
      <div class="modal-dialog modal-xl">
          <div class="modal-content">

              <!-- Modal Header -->
              <div class="modal-header">
                <h4 class="modal-title" id="fontscontent2"><b>แจ้งการจ่ายเงินเชื่อ</b></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>

                <!-- Modal body -->
                <div class="modal-body">
                  {!! Form::open(['route' => 'paycredit.update']) !!}
                    {{ csrf_field() }}
                            <input type="hidden" class="form-control" name="get_id" id="get_id_edit">

                            <div class="form-inline">
                              <label id="fontslabel"><b>สาขา :</b></label>
                              <div class="col-sm">
                              <select style="width: 100%;max-width: 500px;" class="form-control" name="code_branch" id="getbranch">
                                  @foreach ($branchs as $key => $branch)
                                  <option value="{{$branch->code_branch}}">{{$branch->name_branch}}</option>
                                  @endforeach
                              </select>
                              </div>

                              <label id="fontslabel"><b>ประเภทการจ่ายเงิน :</b></label>
                              <div class="col-sm">
                              <select style="width: 100%;max-width: 500px;" class="form-control" name="type_pay" id="get_type_po">
                                @foreach ($type_pays as $key => $type_pay)
                                <option value="{{$type_pay->id}}">{{$type_pay->name_pay}}</option>
                                @endforeach
                              </select>
                              </div>
                            </div>

                            <!-- <div class="form-inline">
                              <label id="fontslabel"><b>สาขา :</b></label>
                              <div class="col">
                                <input style="width: 100%;max-width: 500px;" type="text" name="branch_update" class="form-control" id="getbranch">
                              </div>
                              <label id="fontslabel"><b>ประเภทการจ่ายเงิน :</b></label>
                              <div class="col">
                              <input style="width: 100%;max-width: 500px;" type="text" name="type_po_update" class="form-control" id="get_type_po">
                              </div>
                            </div> -->

                            <br>
                            <input type="hidden" id="get_type_po_no">
                            <div class="container2">

                            </div>

                            <br>
                            <div style="padding: 0px 100px 0px 100px;" id="fontstable">
                              <div class="table-responsive">
                                <table class="table">
                                  <thead class="thead-light">
                                    <tr>
                                      <th>ลำดับ</th>
                                      <th>ใบเลขที่ AP</th>
                                      <th>ใบเลขที่ PO</th>
                                      <th>จำนวนเงิน</th>
                                      <th>หมายเหตุ</th>
                                    </tr>
                                  </thead>
                                  <tbody id="poedit">

                                  </tbody>
                                </table>
                              </div>
                            </div>

                            <div class="form-inline">
                              <label id="fontslabel"><b>จำนวนเงินที่ขอ :</b></label>
                              <div class="col">
                                <input style="width: 100%;max-width: 1200px;" type="text" name="money_request" class="form-control" id="vat_price" readonly>
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
                                  <input style="width: 100%;max-width: 500px;" type="text" name="bill_no_withpaybills" class="form-control" id="bill_no">
                                </div>
                            </div>

                            <br>
                            <div style="padding: 10px 50px 0px 50px;">
                              <div class="table-responsive">
                                <table class="table">
                                  <thead class="thead-light">
                                    <tr id="fontstable">
                                      <th>ลำดับ</th>
                                      <th>เลขที่ใบแจ้งหนี้</th>
                                      <th>หัก ณ ที่จ่าย(%)</th>
                                      <th>ยอดหัก ณ ที่จ่าย</th>
                                      <th>จำนวนเงิน</th>
                                    </tr>
                                  </thead>
                                  <tbody id="po_content2">

                                  </tbody>
                                  <tfoot class="thead-light">

                                    <tr>
                                      <th></th>
                                      <th></th>
                                      <th></th>
                                      <th id="fontstable" style="text-align: right;">จำนวนเงินที่ขอ :</th>
                                      <td><input type="text" name="" value="" id="vat_price_calcol2"  class="form-control" readonly></td>
                                    </tr>

                                    <tr>
                                      <th></th>
                                      <th></th>
                                      <th></th>
                                      <th id="fontstable" style="text-align: right;">ยอดหัก ณ ที่จ่าย :</th>
                                      <td><input type="text" name="" id="sum_whd2"  class="form-control" readonly></td>
                                    </tr>

                                    <tr>
                                      <th></th>
                                      <th></th>
                                      <th></th>
                                      <th id="fontstable" style="text-align: right;">บริษัทออกแทน : </th>
                                      <td>
                                        @if ($infrom_po_mainhead->company_pay_wht == 255)
                                          <input type="text" class="form-control" value="บริษัทออกหัก ณ ที่จ่าย" readonly>
                                        @else
                                          <input type="text" class="form-control" value="ไม่ได้ออกหัก ณ ที่จ่าย" readonly>
                                        @endif
                                      </td>
                                    </tr>

                                    <tr>
                                      <th></th>
                                      <th></th>
                                      <th></th>
                                      <th id="fontstable" style="text-align: right;">ยอดเงินทั้งหมด :</th>
                                      <td><input type="text" value="" id="aftermoney2" class="form-control" readonly></td>
                                    </tr>

                                  </tfoot>
                                </table>
                              </div>
                            </div>

                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <a href="{{route('paycredit')}}">
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




  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <script type="text/javascript" src = 'js/accountjs/paycredit.js'></script>
  <script>
      $(document).ready(function() {
      $('#example').DataTable();
      } );
  </script>
@endsection
