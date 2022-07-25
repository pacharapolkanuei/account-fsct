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
                                  <li class="breadcrumb-item active">แก้ไขเปอร์เซ็นค่าบริหารกลาง</li>
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
                            <fonts id="fontsheader">แก้ไขเปอร์เซ็นค่าบริหารกลาง</fonts>
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
                                          <th>สาขา</th>
                                          <th>เปอร์เซ็น (%)</th>
                                          <th>Status</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                        @foreach ($datas as $key => $data)
                                        <tr>
                                          <td>{{ $key+1 }}</td>
                                          <td>{{ $data->name_branch }}</td>
                                          <td>{{ $data->percent }}</td>
                                          <td>
                                            <button type="button" class="btn btn-warning" onclick="getdata_percent_edit({{ $data->id_percent_ref }})" data-toggle="modal" data-target="#modaledit">แก้ไข</button>
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
                <h4 class="modal-title" id="fontscontent2"><b>แก้ไขเปอร์เซ็นค่าบริหารกลาง</b></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>

                <!-- Modal body -->
                <div class="modal-body">
                  {!! Form::open(['route' => 'percent_main_cost.update']) !!}
                    {{ csrf_field() }}
                        <input type="hidden" class="form-control" name="get_id" id="get_id_edit">

                        <div class="form-inline">
                        <label id="fontslabel"><b>แก้ไข (%) : </b></label>
                          <div class="col-sm">
                          <input style="width: 100%;max-width: 1200px;" type="text" name="percent_num" class="form-control" id="get_num_percent">
                          </div>
                        </div>

              </div>
              <!-- Modal footer -->
              <div class="modal-footer">
                  <a href="{{route('asset_list')}}">
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
  <script type="text/javascript" src = 'js/accountjs/percent_main_cost.js'></script>
  <script>
      $(document).ready(function() {
      $('#example').DataTable();
      } );
  </script>
@endsection
