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
                                  <li class="breadcrumb-item active">ต้นทุนแบบเหล็ก(ซื้อสำเร็จรูป)</li>
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
                            <fonts id="fontsheader">ต้นทุนแบบเหล็ก(ซื้อสำเร็จรูป)</fonts>
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
                                        <h4 class="modal-title" id="fontscontent2"><b>ต้นทุนแบบเหล็ก(ซื้อสำเร็จรูป)</b></h4>
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

                                                {!! Form::open(['route' => 'buysteel.store', 'method' => 'post' ]) !!}
                                                  {{ csrf_field() }}
                                                <?php
                                                  $level_id = Session::get('emp_code');
                                                  // echo $level_id;
                                                ?>
                                                <input type="hidden" name="get_emp" value="{{ $level_id }}">
                                                
                                                <div class="was-validated form-inline" style="margin: 10px 50px 0px 50px;">
                                                  <!-- <div class="col-sm-6"> -->
                                                  <div class="row">
                                                    <label class="mb-2 mr-sm-2" id="fontslabel" for=""><b>Lot :</b></label>
                                                    <input type="text" class="form-control mb-2 mr-sm-2" name="lotnumber"required>

                                                    &nbsp;&nbsp;<label class="mb-2 mr-sm-2" id="fontslabel" for=""><b>วันที่ผลิตเสร็จ :</b></label>
                                                    <input type="date" autocomplete="off" class="form-control mb-2 mr-sm-2" name="datenow" required>

                                                    &nbsp;&nbsp;<label class="mb-2 mr-sm-2" for="modal-input-priceservice" id="fontslabel"><b>PO :</b></label>
                                                    <input type="text" class="form-controller" id="search" name="search"></input>
                                                    <br>

                                                  </div>
                                                  <!-- </div> -->

                                                  <div id="show_po">
                                                  </div>
                                                </div>

                                                <div style="padding: 10px 0px 0px 0px;">
                                                  <div class="table-responsive">
                                                    <table class="table">
                                                      <thead class="thead-light" id="fontstable">
                                                          <th width="20%" style="text-align: center;">รายการ</th>
                                                          <th width="11.6%" style="text-align: center;">ผลิตได้(ชิ้น)</th>
                                                          <th width="11.6%" style="text-align: center;">ราคาทุนวัตถุดิบ(ต่อชิ้น)</th>
                                                          <th width="11.6%" style="text-align: center;">ต้นทุนวัตถุดิบที่ใช้(รวม)</th>
                                                          <th width="11.6%" style="text-align: center;">เงินเดือน/ค่าแรงในการผลิต</th>
                                                          <th width="11.6%" style="text-align: center;">รวมต้นทุนการผลิต</th>
                                                          <th width="11.6%" style="text-align: center;">ต้นทุนการผลิตต่อหน่วย</th>
                                                          <th width="10%" style="text-align: center;"><button class="btn-primary add_form_field" type="button">เพิ่มข้อมูล</button></th>
                                                      </thead>

                                                      <tbody class="container11">

                                                      </tbody>

                                                      <tfoot>
                                                        <tr>
                                                          <th style="text-align: right;" id="fontstable">รวม</th>
                                                          <th style="text-align: right;"><input type="text" name="totaldebit" id="totaldebit" class="form-control" readonly></th>
                                                          <th style="text-align: right;"><input type="text" name="totalcredit" id="totalcredit" class="form-control" readonly></th>
                                                          <th></th>
                                                          <th></th>
                                                          <th></th>
                                                          <th></th>
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


                                    </div>
                                  </div>
                                </div>
                                {!! Form::close() !!}

                                <div >
                                  <div class="table-responsive">
                                    <table id="example" class="table table-striped table-bordered fontslabel" style="width:100%">
                                      <thead>
                                        <tr>
                                          <th>ลำดับ</th>
                                          <th>รายการ</th>
                                          <th>ผลิตได้(ชิ้น)</th>
                                          <th>ราคาทุนวัตถุดิบ(ต่อชิ้น)</th>
                                          <th>ต้นทุนวัตถุดิบที่ใช้(รวม)</th>
                                          <th>เงินเดือน/ค่าแรงในการผลิต</th>
                                          <th>รวมต้นทุนการผลิต</th>
                                          <th>ต้นทุนการผลิตต่อหน่วย</th>
                                          <th>สถานะ</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                        @foreach ($propertys as $key => $property)
                                        <tr>
                                          <td>{{ $key+1 }}</td>
                                          <td>{{ $property->number_property }}</td>
                                          <td>{{ $property->descritption_thai }}</td>
                                          <td>{{ $property->descritption_eng }}</td>
                                          <td>{{ $property->accounttypeno }}</td>
                                          <td>{{ $property->accounttypefull }}</td>
                                          <td>{{ $property->accounttypeno }} - {{ $property->accounttypefull }}</td>
                                          <td>{{ $property->accounttypeno }} - {{ $property->accounttypefull }}</td>
                                          <td>
                                            <button type="button" class="btn btn-warning" onclick="getdataedit({{ $property->id_group }})" data-toggle="modal" data-target="#modaledit">แก้ไข</button>
                                            <a href="{{ route ('define_property.delete', ['id' => $property->id_group]) }}" class="btn btn-danger btn-md delete-confirm">ลบ</a>
                                            <!-- <button type="button" class="btn btn-danger btn-md" data-toggle="modal" onclick="confirmdelete({{ $property->id_group }})">ลบ</button> -->
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

  <div class="modal fade" id="modaledit">
      <div class="modal-dialog modal-lg">
          <div class="modal-content">

              <!-- Modal Header -->
              <div class="modal-header">
                <h4 class="modal-title" id="fontscontent2"><b>รายการทรัพย์สิน</b></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>

                <!-- Modal body -->
                <div class="modal-body">

                    {{ csrf_field() }}


              </div>
              <!-- Modal footer -->
              <div class="modal-footer">
                  <a href="{{route('asset_list')}}">
                      <input type="submit" class="btn btn-success" style="display: inline" id="button-submit-edit" value="บันทึก">
                      <button type="button" class="btn btn-warning" data-dismiss="modal">ยกเลิก</button>
                  </a>
              </div>


          </div>
      </div>
  </div>

  <!-- end iditmodal -->


  <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script> -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  <script type="text/javascript" src = 'js/accountjs/buysteel.js'></script>
  <script>
      $(document).ready(function() {
      $('#example').DataTable();
      } );
  </script>

  <script type="text/javascript">
  $('#search').on('keyup',function(){
  $value = $(this).val();
  var e = window.event || e;
  var key = e.keyCode;
  if ($value && key != 32) {
    $.ajax({
    type : 'get',
    url : '{{URL::to('search')}}',
    data:{'search':$value},
    success:function(data){
    $('#show_po').html(data);
    }
    });
  }
  else {
    alert('กรุณากรอก PO!');
  }

  })
  </script>

  <script type="text/javascript">
  $.ajaxSetup({ headers: { 'csrftoken' : '{{ csrf_token() }}' } });
  </script>



@endsection
