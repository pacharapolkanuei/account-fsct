@extends('index')
@section('content')
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

  <div class="content-page">
    <!-- Start content -->
        <div class="content">
             <div class="container-fluid">

                  <div class="row">
                        <div class="col-xl-12">
                            <div class="breadcrumb-holder" id="fontscontent">
                                <h1 class="float-left">Account - FSCT</h1>
                                <ol class="breadcrumb float-right">
                                  <li class="breadcrumb-item">แก้ไข</li>
                                  <li class="breadcrumb-item active">แก้ไขประเภทการจ่ายเงินของเจ้าหนี้</li>
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
                            <fonts id="fontsheader">แก้ไขประเภทการจ่ายเงินของเจ้าหนี้</fonts>
                          </h3>
                        </div>
                        </div><!-- end card-->

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

                                <div >
                                  <div class="table-responsive">
                                    <table id="example" class="table table-striped table-bordered" style="width:100%">
                                      <thead>
                                        <tr>
                                          <th>ลำดับ</th>
                                          <th>ชื่อลูกค้า</th>
                                          <th>ที่อยู่</th>
                                          <th>ประเภทการจ่ายเงิน</th>
                                          <th>status</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                        @foreach ($datas as $key => $data)
                                        <tr>
                                          <td>{{ $key+1 }}</td>
                                          <td>{{ $data->pre }} {{ $data->name_supplier }}</td>
                                          <td>{{ $data->address }} {{ $data->district }} {{ $data->amphur }} {{ $data->province }} {{ $data->zipcode }}</td>
                                          <td>
                                            @if ($data->type_pay  === 1)
                                                เงินสด
                                            @elseif ($data->type_pay  === 2)
                                                เงินโอน
                                            @else
                                                ยังไม่มีข้อมูลประเภทการจ่ายเงินของเจ้าหนี้
                                            @endif
                                          </td>
                                          <td>
                                            <button type="button" class="btn btn-warning" onclick="getdata_supplier_pay_type_edit({{ $data->id_supplier_ref }})" data-toggle="modal" data-target="#modaledit">แก้ไข</button>
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
  @foreach ($datas as $key => $data)
  <div class="modal fade" id="modaledit">
      <div class="modal-dialog modal-lg">
          <div class="modal-content">

              <!-- Modal Header -->
              <div class="modal-header">
                <h4 class="modal-title" id="fontscontent2"><b>แก้ไขประเภทการจ่ายเงินของเจ้าหนี้</b></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>

                <!-- Modal body -->
                <div class="modal-body">
                  {!! Form::open(['route' => 'supplier_pay_type.update']) !!}
                    {{ csrf_field() }}
                        <input type="hidden" class="form-control" name="get_id" id="get_id_edit">

                        <label id="fontslabel"><b>เลือกประเภทการจ่ายเงินของเจ้าหนี้ :</b></label>
                        <div class="col-sm">
                          <select style="width: 100%;max-width: 1200px;" class="form-control" name="type_pay">
                            <option disabled selected>เลือกประเภทการจ่ายเงิน</option>
                            <option value="1">เงินสด</option>
                            <option value="2">เงินโอน</option>
                          </select>
                        </div>

              </div>
              <!-- Modal footer -->
              <div class="modal-footer">
                  <a href="{{route('supplier_pay_type')}}">
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
  <!-- <script type="text/javascript" src = 'js/accountjs/paycredit.js'></script> -->
  <script type="text/javascript" src = 'js/accountjs/buysteel.js'></script>
  <script>
      $(document).ready(function() {
      $('#example').DataTable();
      } );
  </script>
@endsection
