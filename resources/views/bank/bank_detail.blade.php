@extends('index')
@section('content')

<!-- css data table -->
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css" />
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" />
<!-- js data table -->
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript" src={{ asset('js/accountjs/bank.js') }}></script>
<!-- swal -->
<script type="text/javascript" src="https://unpkg.com/sweetalert2@7.0.6/dist/sweetalert2.all.js"></script>
<!-- input mask -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>

<!-- -----แสดง SWAL เมื่อบันทึกการตั้งหนี้สำเร็จ--------- -->
@if (Session::has('sweetalert.json'))
<script>
    swal({
        !!Session::pull('sweetalert.json') !!
    });
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
                            <li class="breadcrumb-item active">ข้อมูลธนาคาร</li>
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
                                <fonts id="fontsheader">รายการธนาคาร</fonts>
                            </h3>
                            <!-- Button to Open the Modal -->
                            <div style="padding: 0px 0px 0px 50px;">
                                <button type="button" class="btn btn-primary" data-toggle="modal" style="float: right;" data-target="#modalcreate">
                                    <i class="fas fa-plus">
                                        <fonts id="fontscontent">เพิ่มข้อมูล
                                    </i>
                                </button>
                            </div>
                        </div>
                    </div><!-- end card-->

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

                    <!-- ตารางรายชื่อ ธนาคาร -->
                    <table id="example" class="table table-striped table-bordered fontslabel" style="width:100%">
                        <thead>
                            <tr>
                                <th>ลำดับ</th>
                                <th>ชื่อบัญชี</th>
                                <th>หมายเลขบัญชี</th>
                                <th>หมายเหตุ</th>
                                <th>อัพเดทเมื่อ</th>
                                <th style="text-align:center;">action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($banks as $key => $bank)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td>{{ $bank->account_name }}</td>
                                <td>{{ $bank->account_no }}</td>
                                <td>{{ $bank->notation }}</td>
                                <td>{{ \Carbon\Carbon::parse($bank->updated_at)->format('H:i:s d/m/Y ')}}</td>
                                <td style="text-align:center;">
                                    <button type="button" class="btn btn-warning btn-md" data-toggle="modal" data-target="#modaledit{{ $bank->id }}"><b>แก้ไข</b></button>
                                    <button type="button" class="btn btn-danger btn-md" data-toggle="modal" onclick="confirmdelete({{ $bank->id }})">ลบ</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>

                    </table><br>
                    <!-- สิ้นสุด ตารางรายชื่อ ธนาคาร -->


                </div>
            </div>
            <!-- end row -->
        </div>
        <!-- END container-fluid -->
    </div>
    <!-- END content -->
</div>
<!-- END content-page -->
</div>
<!-- END main -->


<!-- MODAL edit -->
@foreach ($banks as $key => $bank)
<div class="modal fade" id="modaledit{{ $bank->id }}">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title" id="fontscontent2"><b>รายละเอียดบัญชีธนาคาร</b></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            {!! Form::model($bank, ['route' => ['bank.update', $bank->id], 'method' => 'patch']) !!}
            <!-- Modal body -->
            <!-- ทำการ validate ช่องข้อมูล แสดง error -->
            <div class="modal-body">
                <label class="col-form-label" for="modal-input-po" id="fontslabel"><b>เจ้าของบัญชี :</b></label>
                <select class="form-control" name="status">
                    <option value="0">บริษัท ฟ้าใสคอนทรัคชั่นทูล จำกัด</option>
                    <option value="1">ลูกค้า</option>
                </select>

                <label class="col-form-label" for="modal-input-po" id="fontslabel"><b>สาขา :</b></label>
                <select class="form-control" name="branch_id" id="branch_id" onchange="validate()">
                    <option value="{{ $bank->branch_id }}">{{ $bank->branch_id }}</option>
                    @foreach ($branchs as $key => $branch)
                    <option value="{{$branch->code_branch}}">{{$branch->code_branch}}/{{$branch->name_branch}}</option>
                    @endforeach
                </select>

                <label class="col-form-label" for="modal-input-po" id="fontslabel"><b>หมายเลขบัญชี</b></label>
                <font id="text_validate_acc_no_edit" style="color:red"><b></b></font>
                <input type="text" name="no" class="form-control account_no_edit" id="" onchange="validate_account_edit()" value="{{ $bank->account_no }}">

                <label class="col-form-label" for="modal-input-po" id="fontslabel"><b>ชื่อบัญชี :</b></label>
                <input type="text" name="name" class="form-control" id="account_name_edit" onchange="validate_account_edit()" value="{{ $bank->account_name }}">

                <label class="col-form-label" for="modal-input-priceservice" id="fontslabel"><b>ชื่อย่อ :</b></label>
                <input type="text" name="initials" class="form-control" value="{{ $bank->initials }}">

                <label class="col-form-label" for="modal-input-po" id="fontslabel"><b>รหัสบัญชี :</b></label>
                <select class="form-control" id="accounttype_no" name="accounttype_no" onchange="validate()">
                    <option value="{{ $bank->accounttype_no }}">{{ $bank->accounttype_no }}</option>
                    @foreach ($accounttypes as $key => $accounttype)
                    <option value="{{$accounttype->accounttypeno}}">
                        {{$accounttype->accounttypeno}}/{{$accounttype->accounttypefull}}
                    </option>
                    @endforeach
                </select>

                <label class="col-form-label" for="modal-input-priceservice" id="fontslabel"><b>หมายเหตุ :</b></label>
                <input type="text" name="notation" class="form-control" value="{{ $bank->notation }}">

                <label class="col-form-label" for="modal-input-calculate" id="fontslabel"><b>แก้ไขล่าสุดเมื่อ :</b></label>
                <input type="text" name="update" class="form-control" value="{{ \Carbon\Carbon::parse($bank->updated_at)->format('H:i:s d/m/Y ')}}" readonly>

            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <input type="submit" class="btn btn-success" style="dispaly: inline" id="submit-btn-edit" value="บันทึก">
                <button type="button" class="btn btn-warning" data-dismiss="modal">ยกเลิก</button>

            </div>
            {!! Form::close() !!}

        </div>
    </div>
</div>
@endforeach
<!-- end iditmodal -->


<!-- MODAL CREATE -->
<div class="modal fade" id="modalcreate">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title" id="fontscontent2"><b>รายละเอียดบัญชีธนาคาร</b></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            {!! Form::open(['route' => 'bank.store', 'method' => 'post', 'files' => true]) !!}
            <!-- Modal body -->
            <!-- ทำการ validate ช่องข้อมูล แสดง error -->
            <div class="modal-body">

                <label class="col-form-label" for="modal-input-po" id="fontslabel"><b>เจ้าของบัญชี :</b></label>
                <select class="form-control" name="status">
                    <option value="0">บริษัท ฟ้าใสคอนทรัคชั่นทูล จำกัด</option>
                    <option value="1">ลูกค้า</option>
                </select>

                <label class="col-form-label" for="modal-input-po" id="fontslabel"><b>สาขา :</b></label>
                <select class="form-control" name="branch_id" id="branch_id" onchange="validate_account()">
                    <option value="">เลือกสาขา</option>
                    @foreach ($branchs as $key => $branch)
                    <option value="{{$branch->code_branch}}">{{$branch->code_branch}}/{{$branch->name_branch}}</option>
                    @endforeach
                </select>

                <label class="col-form-label" for="modal-input-po" id="fontslabel"><b>หมายเลขบัญชี</b></label>
                <font id="text_validate_acc_no" style="color:red"><b></b></font>
                <input type="text" autocomplete="off" name="no" class="form-control" id="account_no_insert" value="" onchange="validate_account()">
                
                <label class="col-form-label" for="modal-input-po" id="fontslabel"><b>ชื่อบัญชี :</b></label>
                <input type="text" autocomplete="off" name="name" class="form-control" id="account_name" value="" onchange="validate_account()">

                <label class="col-form-label" for="modal-input-priceservice" id="fontslabel"><b>ชื่อย่อ :</b></label>
                <input type="text" name="initials" id="initials" class="form-control" onchange="validate_account()">

                <label class="col-form-label" for="modal-input-po" id="fontslabel"><b>รหัสบัญชี :</b></label>
                <select class="form-control" id="accounttype_no" name="accounttype_no" onchange="validate_account()">
                    <option value="">รหัสบัญชี</option>
                    @foreach ($accounttypes as $key => $accounttype)
                    <option value="{{$accounttype->accounttypeno}}">
                        {{$accounttype->accounttypeno}}/{{$accounttype->accounttypefull}}
                    </option>
                    @endforeach
                </select>


                <label class="col-form-label" for="modal-input-priceservice" id="fontslabel"><b>หมายเหตุ :</b></label>
                <input type="text" name="notation" class="form-control">

            </div>

            <!-- Modal footer -->
            <div class="modal-footer">

                <button type="button" class="btn" id="submit-btn" onclick="validate_click()">ยืนยัน</button>
                <button type="button" class="btn btn-warning" data-dismiss="modal">ยกเลิก</button>

            </div>
            {!! Form::close() !!}

        </div>
    </div>
</div>
<!-- end CREATE -->
@endsection