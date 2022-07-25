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
                                  <li class="breadcrumb-item">ทรัพย์สินและค่าเสื่อม</li>
                                  <li class="breadcrumb-item active">ใบ POวัตถุดิบ (ซื้อมาผลิต)</li>
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
                            <fonts id="fontsheader">ใบ POวัตถุดิบ (ซื้อมาผลิต)</fonts>
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
                                  <div class="modal-dialog modal-xl" style="max-width: 80%;" role="document">
                                    <div class="modal-content">

                                      <!-- Modal Header -->
                                      <div class="modal-header">
                                        <h4 class="modal-title" id="fontscontent2"><b>ใบ POวัตถุดิบ (ซื้อมาผลิต)</b></h4>
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
                                        {!! Form::open(['route' => 'asset_list.store', 'method' => 'post' , 'id' => 'myForm' ,  'files' => true ]) !!}
                                          {{ csrf_field() }}
                                                <div class="was-validated form-inline" style="margin: 10px 50px 0px 50px;">
                                                  <!-- <div class="col-sm-6"> -->
                                                  <div class="row">
                                                    &nbsp;&nbsp;<label class="mb-2 mr-sm-2" for="modal-input-priceservice" id="fontslabel"><b>PO :</b></label>
                                                    <input type="text" class="form-control mb-2 mr-sm-2"  id="search" name="search" required></input>
                                                    <button type="button" class="btn btn-primary" data-toggle="modal" onclick="serchpo()">
                                                      <i class="fas fa-search">
                                                        <fonts id="fontscontent">ค้นหา
                                                      </i>
                                                    </button>
                                                    <br>
                                                    &nbsp;&nbsp;<label class="mb-2 mr-sm-2" id="fontslabel" for=""><b>Lot :</b></label>
                                                    <input type="text" class="form-control mb-2 mr-sm-2" name="lotnumber"required>
                                                    <br>

                                                  </div>


                                                  <!-- </div> -->
                                                </div>
                                                <br>
                                                <div class="row">
                                                  &nbsp;&nbsp;
                                                  <label class="mb-2 mr-sm-2" for="modal-input-priceservice" id="fontslabel"><b>ชื่อ Supplier:</b></label>
                                                  <br>
                                                </div>
                                                <br>
                                                <div class="row">
                                                  <label class="mb-2 mr-sm-2" id="fontslabel" for=""><b>ที่อยู่ :</b></label>
                                                  <br>
                                                </div>
                                                <br>
                                                <div class="row">
                                                  &nbsp;&nbsp;
                                                  <label class="mb-2 mr-sm-2" for="modal-input-priceservice" id="fontslabel"><b>เบอร์:</b></label>
                                                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                                  <br>
                                                </div>

                                                <br>

                                                <table class="table table-bordered table-hover">
                                                  <thead>
                                                  <tr>
                                                    <th>ลำดับ</th>
                                                    <th>รหัสบัญชี</th>
                                                    <th>รายการ</th>
                                                    <th>ปริมาณ</th>
                                                    <th>ราคาต่อหน่วย</th>
                                                    <th>รวม</th>
                                                    <th>ส่วนลด</th>
                                                    <th>ราคาหลังหักส่วนลด</th>
                                                    <th>ราคาสุทธิต่อหน่วย</th>
                                                  </tr>
                                                  </thead>
                                                  <tbody>
                                                  </tbody>
                                                </table>

                                      </div>

                                      <!-- Modal footer -->

                                      <div class="modal-footer">

                                      {!! Form::submit('บันทึก', ['class' => 'btn btn-success', 'style' => 'dispaly: inline']) !!}
                                        <button type="button" class="btn btn-warning" data-dismiss="modal">ยกเลิก</button>

                                      </div>


                                    </div>
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



  <!-- end iditmodal -->


  <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script> -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  <script type="text/javascript" src = 'js/accountjs/settingpotool.js'></script>
  <script>
      $(document).ready(function() {
      $('#example').DataTable();
      } );
  </script>



  <script type="text/javascript">
  $.ajaxSetup({ headers: { 'csrftoken' : '{{ csrf_token() }}' } });
  </script>



@endsection
