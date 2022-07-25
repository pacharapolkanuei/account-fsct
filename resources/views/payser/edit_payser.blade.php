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

                                  @foreach ($inform_pos as $key => $inform_po)
                                  <div class="container">

                                    {!! Form::open(['route' => ['update_payser'], 'method' => 'post']) !!}
                                      {{ csrf_field() }}
                                      <input type="hidden" value="{{ $inform_po->id_inform_poz }}" name="get_id">

                                      <div class="form-inline">
                                          <label id="fontslabel"><b>วันที่ตามใบกำกับภาษี :</b></label>
                                          <div class="col">
                                          <input style="width: 100%;max-width: 500px;" type="date" autocomplete="off" class="form-control" name="date_picker_withtaxs" value="{{ $inform_po->datebill }}">
                                          </div>

                                          <label id="fontslabel"><b>เลขที่ใบกำกับภาษี :</b></label>
                                          <div class="col">
                                          <input style="width: 100%;max-width: 500px;" type="text" name="bill_no_withtaxs" class="form-control" value="{{ $inform_po->bill_no }}">
                                          </div>
                                      </div>
                                      <br>
                                      <div class="form-inline">
                                          <label id="fontslabel"><b>วันที่ตามใบเสร็จรับเงิน :</b></label>
                                          <div class="col">
                                          <input style="width: 100%;max-width: 500px;" type="date" autocomplete="off" class="form-control" name="date_picker_withpaybills" value="{{ $inform_po->datebillreceipt }}">
                                          </div>

                                          <label id="fontslabel"><b>เลขที่ใบเสร็จรับเงิน :</b></label>
                                          <div class="col">
                                          <input style="width: 100%;max-width: 500px;" type="text" name="bill_no_withpaybills" class="form-control" value="{{ $inform_po->receipt_no }}">
                                          </div>
                                      </div>

                                      <br>
                                      <div style="padding: 10px 50px 0px 50px;">
                                        <div class="table-responsive">
                                          <table class="table">
                                            <thead class="thead-light">
                                              <tr>
                                                <th>รายการ</th>
                                                <th>จำนวน</th>
                                                <th>ราคาต่อหน่วย</th>
                                                <th>ราคารวม</th>
                                                <th>หมายเหตุ</th>
                                              </tr>
                                            </thead>
                                            @foreach ($inform_po_mainheads as $key => $inform_po_mainhead)
                                              <tr>
                                                  <td>{{$inform_po_mainhead->list }}</td>
                                                  <td><input type="text" name="amonts[]" class="form-control" value="{{$inform_po_mainhead->amount }}" id="amontss[]"></td>
                                                  <td><input type="text" name="prices[]" class="form-control" value="{{$inform_po_mainhead->price }}" id="pricess[]"><input type="hidden" name="id_po_details[]" value="{{$inform_po_mainhead->id_po_detail }}"></td>
                                                  <td><input type="text" class="form-control" disabled></td>
                                                  <td>{{$inform_po_mainhead->note}}</td>
                                              </tr>
                                            @endforeach
                                            <tfoot class="thead-light">
                                              @if($inform_po->discount > 0.00)
                                              <tr>
                                                <th></th>
                                                <th></th>
                                                <th style="text-align: right;">ส่วนลด</th>
                                                <td><input type="text" name="sum_discount" class="form-control" value="{{ $inform_po->discount }}"></td>
                                              </tr>
                                              @endif

                                              @if($inform_po->vat_price > 0.00)
                                              <tr>
                                                <th></th>
                                                <th></th>
                                                <th style="text-align: right;">ภาษีมูลค่าเพิ่ม</th>
                                                <td><input type="text" name="vat_price" class="form-control" value="{{ $inform_po->vat_price }}"></td>
                                              </tr>
                                              @endif

                                              @if($inform_po->wht_percent > 0.00)
                                              <tr>
                                                <th></th>
                                                <th></th>
                                                <th style="text-align: right;">วันที่เสียภาษีหัก ณ ที่จ่าย</th>
                                                <td><input type="date" autocomplete="off" class="form-control" value="{{ $inform_po->date_pay_wht }}" name="date_pay_wht"></td>
                                              </tr>

                                              <tr>
                                                <th></th>
                                                <th></th>
                                                <th style="text-align: right;">ยอดหัก ณ ที่จ่าย</th>
                                                <td><input type="text" class="form-control" value="{{ $inform_po->wht }}" name="wth_price"></td>
                                              </tr>
                                              @endif

                                              <tr>
                                                <th></th>
                                                <th></th>
                                                <th style="text-align: right;">รวมเป็นเงินสุทธิ</th>
                                                <td><input type="text" class="form-control" value="{{ $inform_po->payout }}" name="payouts"></td>
                                              </tr>


                                            </tfoot>
                                          </table>
                                        </div>
                                      </div>

                                  @endforeach

                                  <br>
                                  <center>
                                    <a href="{{route('payser')}}">
                                  {!! Form::submit('บันทึก', ['class' => 'btn btn-success', 'style' => 'dispaly: inline']) !!}
                                    <button type="button" class="btn btn-warning">ยกเลิก</button>
                                    </a>
                                  {!! Form::close() !!}
                                  </div>
                                  </center>
                    </div>
      			<!-- END container-fluid -->
      		    </div>
      		<!-- END content -->
          </div>
      </div><!-- end card-->
  </div>


  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <script type="text/javascript" src = 'js/accountjs/edit_payser.js'></script>
  <!-- <script>

  </script> -->
  <script>
      $(document).ready(function() {
      $('#example').DataTable();
      } );
  </script>
@endsection
