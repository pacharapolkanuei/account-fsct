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
                                  <li class="breadcrumb-item">ค่าเสื่อม</li>
                                  <li class="breadcrumb-item active">กลุ่มบัญชีทรัพย์สิน</li>
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
                            <fonts id="fontsheader">กลุ่มบัญชีทรัพย์สิน</fonts>
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
                                  <div class="modal-dialog modal-lg">
                                    <div class="modal-content">

                                      <!-- Modal Header -->
                                      <div class="modal-header">
                                        <h4 class="modal-title" id="fontscontent2"><b>กลุ่มบัญชีทรัพย์สิน</b></h4>
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

                                              {!! Form::open(['route' => 'define_property.store', 'method' => 'post']) !!}
                                                {{ csrf_field() }}

                                                <div class="form-inline">
                                                <label id="fontslabel"><b>รหัสกลุ่มบัญชีทรัพย์สิน : </b></label>
                                                  <div class="col-sm">
                                                  <input style="width: 100%;max-width: 1200px;" type="text" name="no_group" class="form-control">
                                                  </div>
                                                </div>

                                                <br>

                                                <div class="form-inline">
                                                <label id="fontslabel"><b>คำอธิบาย (ภาษาไทย) : </b></label>
                                                  <div class="col-sm">
                                                  <textarea name="des_thai" style="width: 100%;max-width: 1200px;" class="form-control"></textarea>
                                                  </div>
                                                </div>

                                                <br>

                                                <div class="form-inline">
                                                <label id="fontslabel"><b>คำอธิบาย (ภาษาอังกฤษ) : </b></label>
                                                  <div class="col-sm">
                                                  <textarea name="des_eng" style="width: 100%;max-width: 1200px;" class="form-control"></textarea>
                                                  </div>
                                                </div>

                                                <br>

                                                <div class="form-inline">
                                                <label id="fontslabel"><b>เลขที่บัญชี - ชื่อบัญชี : </b></label>
                                                  <div class="col-sm">
                                                    <select style="width: 100%;max-width: 1200px;" class="form-control select2" name="acc_code">
                                                        <option disabled selected>เลือกเลขที่บัญชี - ชื่อบัญชี</option>
                                                        @foreach ($accounttypes as $key => $accounttype)
                                                        <option value="{{$accounttype->id}}">{{$accounttype->accounttypeno}} - {{$accounttype->accounttypefull}}</option>
                                                        @endforeach
                                                    </select>
                                                  </div>
                                                </div>

                                                <br>

                                                <div class="form-inline">
                                                  <label id="fontslabel"><b>เดบิต :</b></label>
                                                  <div class="col-sm">
                                                  <select style="width: 307px;" class="form-control select2" name="debit">
                                                    <option disabled selected>เลือกเดบิต</option>
                                                    @foreach ($accounttypes as $key => $accounttype)
                                                    <option value="{{$accounttype->id}}">{{$accounttype->accounttypeno}} - {{$accounttype->accounttypefull}}</option>
                                                    @endforeach
                                                  </select>
                                                </div>

                                                  <label id="fontslabel"><b>เครดิต :</b></label>
                                                  <div class="col-sm">
                                                  <select style="width: 307px;" class="form-control select2" name="credit">
                                                    <option disabled selected>เลือกเครดิต</option>
                                                    @foreach ($accounttypes as $key => $accounttype)
                                                    <option value="{{$accounttype->id}}">{{$accounttype->accounttypeno}} - {{$accounttype->accounttypefull}}</option>
                                                    @endforeach
                                                  </select>
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
                                          <th>เลขที่กลุ่มบัญชีทรัพย์สิน</th>
                                          <th>คำอธิบาย(ภาษาไทย)</th>
                                          <th>คำอธิบาย(ภาษาอังกฤษ)</th>
                                          <th>เลขที่บัญชี</th>
                                          <th>ชื่อบัญชี</th>
                                          <th>เดบิต</th>
                                          <th>เครดิต</th>
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
  @foreach ($propertys as $key => $property)
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
                  {!! Form::open(['route' => 'define_property.update']) !!}
                    {{ csrf_field() }}
                        <input type="hidden" class="form-control" name="get_id" id="get_id_edit">

                        <div class="form-inline">
                        <label id="fontslabel"><b>รหัสกลุ่มบัญชีทรัพย์สิน : </b></label>
                          <div class="col-sm">
                          <input style="width: 100%;max-width: 1200px;" type="text" name="no_group" class="form-control" id="get_no_group">
                          </div>
                        </div>

                        <br>

                        <div class="form-inline">
                        <label id="fontslabel"><b>คำอธิบาย (ภาษาไทย) : </b></label>
                          <div class="col-sm">
                          <textarea name="des_thai" style="width: 100%;max-width: 1200px;" class="form-control" id="get_des_thai"></textarea>
                          </div>
                        </div>

                        <br>

                        <div class="form-inline">
                        <label id="fontslabel"><b>คำอธิบาย (ภาษาอังกฤษ) : </b></label>
                          <div class="col-sm">
                          <textarea name="des_eng" style="width: 100%;max-width: 1200px;" class="form-control" id="get_des_eng"></textarea>
                          </div>
                        </div>

                        <br>

                        <div class="form-inline">
                        <label id="fontslabel"><b>เลขที่บัญชี - ชื่อบัญชี : </b></label>
                          <div class="col-sm">
                            <select style="width: 100%;max-width: 1200px;" class="form-control select2" name="acc_code" id="get_acc_code">
                                  @foreach ($accounttypes as $key => $accounttype)
                                  <option selected value="{{$accounttype->id}}">{{$accounttype->accounttypeno}} - {{$accounttype->accounttypefull}}</option>
                                  @endforeach
                            </select>
                          </div>
                        </div>

                        <br>

                        <div class="form-inline">
                          <label id="fontslabel"><b>เดบิต :</b></label>
                          <div class="col-sm">
                          <select style="width: 307px;" class="form-control select2" name="debit" id="get_debit">
                              @foreach ($accounttypes as $key => $accounttype)
                              <option selected value="{{$accounttype->id}}">{{$accounttype->accounttypeno}} - {{$accounttype->accounttypefull}}</option>
                              @endforeach

                          </select>
                          </div>

                          <label id="fontslabel"><b>เครดิต :</b></label>
                          <div class="col-sm">
                          <select style="width: 307px;" class="form-control select2" name="credit" id="get_credit">
                            @foreach ($accounttypes as $key => $accounttype)
                            <option selected value="{{$accounttype->id}}">{{$accounttype->accounttypeno}} - {{$accounttype->accounttypefull}}</option>
                            @endforeach
                          </select>
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
  <script type="text/javascript" src = 'js/accountjs/property.js'></script>
  <script>
      $(document).ready(function() {
      $('#example').DataTable();
      } );
  </script>
@endsection
