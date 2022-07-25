@extends('index')
@section('content')
<!-- js data table -->
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript" src={{ asset('js/accountjs/pettycash.js') }}></script>
<!-- css data table -->
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css" />
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" />
<!-- css cash -->
<link rel="stylesheet" href="{{asset('css/cash/cash.css')}}">
<!-- swal -->
<script type="text/javascript" src="https://unpkg.com/sweetalert2@7.0.6/dist/sweetalert2.all.js"></script>

<!-- -----แสดง SWAL เมื่อบันทึกการตั้งหนี้สำเร็จ--------- -->
@if (Session::has('sweetalert.json'))
<script>
    swal({
        !!Session::pull('sweetalert.json') !!
    });
</script>
@endif
<!-- -----แสดง SWAL เมื่อบันทึกการตั้งหนี้สำเร็จ--------- -->

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
                            <li class="breadcrumb-item active">ตั้งค่าวงเงินสดย่อย</li>
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
                                <fonts id="fontsheader">ตั้งค่าวงเงินสดย่อย</fonts>
                            </h3>
                        </div>
                    </div>

                    <div style="padding: 25px 15px 0px 10px;">
                        <div class="row">
                            <div class="col-sm">
                                <?php
                                if ($date == "ทั้งหมด") {
                                    $date = "ทั้งหมด";
                                } else {
                                    $date = date("d m Y", strtotime($date));
                                }

                                ?>
                                <label class="col-form-label" for="modal-input-po" id="fontslabel"><b>
                                        <i class="fas fa-calendar-alt"></i>
                                        เงินสดย่อยประจำวันที่วันที่ :<font color="red"> {{$date}} </font></b>
                                </label>
                                <input style="display: inline-block;" type="date" name="time" class="form-control form-control-input" id="time" onchange="change_time()" value="" placeholder="เลือกวันที่">
                                <a href="{{ route('pettycash') }}"> <button class="btn btn-sm btn-success">ดูทั้งหมด</button> </a>
                            </div>
                            <div class="col-sm">
                                <!-- เว้นว่าง -->
                            </div>
                            <div class="col-sm">
                                <button type="button" class="btn btn-primary" style="float: right;" data-toggle="modal" data-target="#modalcreate">
                                    <i class="fas fa-plus">
                                        <fonts id="fontscontent">เพิ่มข้อมูล
                                    </i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <br>

                    <!-- ตารางรายชื่อ ธนาคาร -->

                    <table id="example" class="table table-striped table-bordered fontslabel" style="width:100%">
                        <thead>
                            <tr>
                                <th>ลำดับ</th>
                                <th>รหัสสาขา</th>
                                <th>ชื่อสาขา</th>
                                <th style="text-align:center">ยอดเงินสดย่อยคงเหลือ (คงเหลือ)</th>
                                <th style="text-align:center;">action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($cashs as $key => $cash)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td>{{ $cash->branch_id }}</td>
                                <td>{{ $cash->branch_name }}</td>
                                <td style="text-align:center">{{ $cash->grandtotal }}</td>
                                <td style="text-align:center;">
                                    <button type="button" class="btn btn-warning btn-md fontslabel" data-toggle="modal" data-target="#modaledit{{ $cash->id }}"><b>แก้ไข</b></button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>

                        </tfoot>
                    </table><br>
                    <!-- สิ้นสุด ตารางรายชื่อ ธนาคาร -->

                </div><!-- end card-->
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
@foreach ($cashs as $key => $cash)
<div class="modal fade" id="modaledit{{ $cash->id }}">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title" id="fontscontent2"><b>รายละเอียดบัญชีธนาคาร</b></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <div class="container">
                    <div class="row">
                        <div class="col">
                            {!! Form::open(['route' => ['cash.update',$cash->id], 'method' => 'patch', 'files' => true]) !!}
                            <label class="col-form-label" for="modal-input-po" id="fontslabel"><b>สาขา :</b></label>
                            <select class="form-control" id="modal-input-province" name="branch_id" onchange="" readonly>
                                <option value="{{$cash->branch_id}}">{{$cash->branch_id}}</option>
                            </select>
                        </div>
                        <div class="col order-1">
                            <label class="col-form-label" for="modal-input-priceservice" id="fontslabel"><b>วงเงิน :</b></label>
                            <input type="text" name="grandtotal" value="{{ $cash->grandtotal }}" class="form-control">
                        </div>
                        <div class="col order-12">
                            <label class="col-form-label" for="modal-input-po" id="fontslabel"><b>วันที่ :</b></label>
                            <?php $time = date("Y-m-d", strtotime($cash->time)); ?>
                            <input type="date" autocomplete="off" name="time" value="{{$time}}" class="form-control" id="account_name" onchange="" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label class="col-form-label" for="modal-input-po" id="fontslabel"><b>วันที่นำเงินฝาก :</b></label>
                            <?php $timeold = date("Y-m-d", strtotime($cash->timeold)); ?>
                            <input type="date" autocomplete="off" name="timeold" value="{{$timeold}}" class="form-control" id="account_no_insert" value="" onchange="" readonly>
                        </div>
                        <div class="col order-12">
                            <label class="col-form-label" for="modal-input-po" id="fontslabel"><b>รหัสบัญชี :</b></label>
                            <select class="form-control" id="modal-input-province" name="account" onchange="" readonly>
                                <option value="{{$cash->account_code}},{{$cash->account_name}}">{{$cash->account_code}}/{{$cash->account_name}}</option>
                            </select>

                        </div>
                        <div class="col order-1">
                            <label class="col-form-label" for="modal-input-priceservice" id="fontslabel"><b>หมายเหตุ :</b></label>
                            <input type="text" name="note" class="form-control" placeholder="ยอดที่นำฝาก" value="{{$cash->note}}" readonly>
                        </div>
                    </div>
                </div>

            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <a href="{{route('debt')}}">
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



<!-- MODAL CREATE -->
<div class="modal fade" id="modalcreate">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title" id="fontscontent2"><b>ตั้งค่าวงเงินสดย่อย</b></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            {!! Form::open(['route' => 'cash.store', 'method' => 'post', 'files' => true]) !!}
            <!-- Modal body -->
            <div class="modal-body">
                <div class="container">
                    <div class="row">
                        <div class="col">

                            <label class="col-form-label" for="modal-input-po" id="fontslabel"><b>สาขา :</b></label>
                            <select class="form-control" name="branch_id" id="branch_id" onchange="validate()">
                                <option value="">เลือกสาขา</option>
                                @foreach ($branchs as $key => $branch)
                                <option value="{{$branch->code_branch}}">{{$branch->code_branch}}/{{$branch->name_branch}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col order-1">
                            <label class="col-form-label" for="modal-input-priceservice" id="fontslabel"><b>วงเงิน :</b></label>
                            <input type="text" name="grandtotal" id="grandtotal" class="form-control" placeholder="กรุณากรอกจำนวนเงิน" onchange="validate()">
                        </div>
                        <div class="col order-12">
                            <label class="col-form-label" for="modal-input-po" id="fontslabel"><b>วันที่ :</b></label>
                            <?php $current_date = date("Y-m-d"); ?>
                            <input type="date" autocomplete="off" name="time" id="time" min="{{$current_date}}" class="form-control" value="{{$current_date}}" onchange="validate()">
                            <input type="text" id="testdate5" name="date_picker" class="form-control" autocomplete="off" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label class="col-form-label" for="modal-input-po" id="fontslabel"><b>วันที่นำเงินฝาก :</b></label>
                            <font id="text_validate_acc_no" style="color:red"><b></b></font>
                            <input type="date" autocomplete="off" name="timeold" id="timeold" class="form-control" value="" onchange="validate()">
                        </div>
                        <div class="col order-12">
                            <label class="col-form-label" for="modal-input-po" id="fontslabel"><b>รหัสบัญชี :</b></label>
                            <select class="form-control" id="account" name="account" onchange="validate()">
                                <option value="">รหัสบัญชี</option>
                                @foreach ($accounttypes as $key => $accounttype)
                                <option value="{{$accounttype->accounttypeno}},{{$accounttype->accounttypefull}}">
                                    {{$accounttype->accounttypeno}}/{{$accounttype->accounttypefull}}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col order-1">
                            <label class="col-form-label" for="modal-input-priceservice" id="fontslabel"><b>หมายเหตุ :</b></label>
                            <input type="text" name="note" id="note" class="form-control" placeholder="ยอดที่นำฝาก" onchange="validate()">
                        </div>
                    </div>
                </div>

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


    