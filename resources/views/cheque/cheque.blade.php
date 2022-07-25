@extends('index')
@section('content')
<!-- jquery -->
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<!-- js.cheque -->
<script type="text/javascript" src={{ asset('js/accountjs/cheque.js') }}></script>
<!-- css data table -->
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css" />
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" />
<!-- swal -->
<script type="text/javascript" src="https://unpkg.com/sweetalert2@7.0.6/dist/sweetalert2.all.js"></script>

<!-- แสดง error -->
@if($errors->any())
<script>
    swal({
        title: 'กรุณาระบุข้อมูลให้ครบถ้วน',
        html: '{!! implode('<br>',$errors->all()) !!}',
        type: 'error',

    })
</script>
@endif
<!-- แสดง error -->

<!-- -----แสดง SWAL เมื่อบันทึกการตั้งหนี้สำเร็จ--------- -->
@if (Session::has('sweetalert.json'))
<script>
    swal({!!Session::pull('sweetalert.json')!!});
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
                            <li class="breadcrumb-item active">รับเช็คเงินสด</li>
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
                                <fonts id="fontsheader">รับเช็คเงินสด</fonts>
                            </h3>

                            <button type="button" class="btn btn-primary" data-toggle="modal" style="float: right;" data-target="#modalcreate">
                                <i class="fas fa-plus">
                                    <fonts id="fontscontent">รับเช็ค
                                </i>
                            </button>

                        </div>
                    </div>
                    <table id="example" class="table table-striped table-bordered fontslabel" style="width:100%">
                        <thead>
                            <tr>
                                <th>วันที่รับเช็ค</th>
                                <th>เลขที่เช็ค</th>
                                <th>วันที่เช็ค</th>
                                <th>ชื่อลูกค้า</th>
                                <th>จำนวนเงินใบเช็ค</th>
                                <th>จำนวนเงินสุทธิ</th>
                                <th>เงินเข้าบัญชี</th>
                                <th style="text-align:center;">สถานะเช็ค</th>
                                <th>หมายเหตุ</th>
                                <th style="text-align:center;">action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cheques as $key => $cheque)
                            <tr>
                                <td>{{$cheque->got_cheque}}</td>
                                <td>{{$cheque->cheque_no}}</td>
                                <td>{{$cheque->cheque_date}}</td>
                                <td>{{$cheque->name}}</td>
                                <td>{{$cheque->price}}</td>
                                <td>{{$cheque->net}}</td>
                                <td>{{$cheque->bank_recived}}</td>
                                <td style="text-align:center;">
                                     @if($cheque->status == "เช็คในมือ")
                                    <button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#modalupdate{{$cheque->id}}">
                                        {{$cheque->status}}
                                    </button>
                                    @else
                                    <button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#modalupdate{{$cheque->id}}">
                                        {{$cheque->status}}
                                    </button>
                                    @endif
                                </td>
                                <td>{{$cheque->notation}}</td>
                                <td style="text-align:center;">
                                    <a href="{{ route('cheque.detail',$cheque->id) }}">
                                        <button class="btn btn-primary">ดู</button>
                                    </a>
                                    <a href="{{ route('chequepdf') }}">
                                        <button class="btn btn-info">พิมพ์</button>
                                    </a>
                                </td>

                            </tr>
                            @endforeach
                        </tbody>

                    </table><br>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- MODAL CREATE -->
<div class="modal fade" id="modalcreate">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title" id="fontscontent2"><b>รับเช็ค</b></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            {!! Form::open(['route' => 'cheque.store', 'method' => 'post', 'files' => true]) !!}
            <!-- Modal body -->
            <div class="modal-body">
                <div class="container">

                    <div class="row">
                        <div class="col">
                            <label class="col-form-label" for="modal-input-po" id="fontslabel"><b>วันที่รับเช็ค :</b></label>
                            <input type="date" autocomplete="off" name="got_cheque" class="form-control">

                        </div>
                        <div class="col ">
                            <label class="col-form-label" for="modal-input-priceservice" id="fontslabel"><b>สถานะเช็ค :</b></label>
                            <select class="form-control" name="status">
                                <option value="เช็คในมือ">เช็คในมือ</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <label class="col-form-label" for="modal-input-po" id="fontslabel"><b>วันที่เช็ค :</b></label>
                            <input type="date" autocomplete="off" class="form-control" name="cheque_date">
                        </div>
                        <div class="col ">
                            <label class="col-form-label" for="modal-input-priceservice" id="fontslabel"><b>เลขที่เช็ค :</b></label>
                            <input type="text" class="form-control" name="cheque_no" placeholder="กรอกเลขที่เช็ค">
                        </div>
                        <div class="col ">
                            <label class="col-form-label" for="modal-input-priceservice" id="fontslabel"><b>เช็คธนาคาร :</b></label>
                            <select class="form-control" name="bank_cheque">
                                <option value="กรุงไทย">กรุงไทย</option>
                                <option value="กสิกร">กสิกร</option>
                                <option value="ไทยพานิช">ไทยพานิช</option>
                            </select>
                        </div>
                        <div class="col ">
                            <label class="col-form-label" for="modal-input-priceservice" id="fontslabel"><b>สาขา :</b></label>
                            <input type="text" class="form-control" placeholder="กรอกสาขาธนาคาร" name="branch">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <label class="col-form-label" for="modal-input-po" id="fontslabel"><b>ชื่อลูกค้า :</b></label>
                            <input type="text" class="form-control" placeholder="กรอกชื่อลูกค้า" name="name">
                        </div>
                        <div class="col ">
                            <label class="col-form-label" for="modal-input-priceservice" id="fontslabel"><b>ผู้สั่งจ่าย :</b></label>
                            <input type="text" class="form-control" placeholder="กรอกผู้สั่งจ่าย" name="payer">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <label class="col-form-label" for="modal-input-po" id="fontslabel"><b>จำนวนเงิน :</b></label>
                            <input type="text" class="form-control" placeholder="จำนวนเงิน" name="price">
                        </div>
                        <div class="col ">
                            <label class="col-form-label" for="modal-input-priceservice" id="fontslabel"><b>หมายเหตุ :</b></label>
                            <input type="text" class="form-control" placeholder="หมายเหต" name="notation">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <label class="col-form-label" for="modal-input-bookinc" id="fontslabel"><b>แนบหลักฐาน :</b></label>
                            <input type="file" name="pic" class="form-control">
                        </div>
                    </div>

                </div>

            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="submit" class="btn btn-success" id="submit-btn" onclick="validate_click()">ยืนยัน</button>
                <button type="button" class="btn btn-warning" data-dismiss="modal">ยกเลิก</button>
            </div>
            {!! Form::close() !!}

        </div>
    </div>
</div>
<!-- end CREATE -->


<!-- update status -->
@foreach($cheques as $key => $cheque)
<div class="modal fade" id="modalupdate{{$cheque->id}}">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title" id="fontscontent2"><b>เปลี่ยนสถานะเช็ค</b></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            {!! Form::open(['route' => 'cheque.update_status', 'method' => 'post', 'files' => true]) !!}
            <!-- Modal body -->
            <div class="modal-body">
                <div class="container">

                    <div class="row">
                        <div class="col ">
                            <label class="col-form-label" for="modal-input-priceservice" id="fontslabel"><b>สถานะเช็ค :</b></label>
                            <select class="form-control" name="status">
                                <option value="{{$cheque->status}}">{{$cheque->status}}</option>
                                <!-- <option value="เช็คในมือ">เช็คในมือ</option> -->
                                <option value="รอเรียกเก็บ">รอเรียกเก็บ</option>
                                <option value="เช็คคืนยืมใหม่">เช็คคืนยืมใหม่</option>
                                <option value="เช็คผ่าน">เช็คผ่าน</option>
                                <option value="เช็คคืน">เช็คคืน</option>
                                <option value="ตัดหนี้สุญ   ">ตัดหนี้สุญ</option>
                            </select>
                        </div>
                        <div class="col ">
                            <label class="col-form-label" for="modal-input-priceservice" id="fontslabel"><b>ยอดรายได้ตามใบเช็ค :</b></label>
                            <input type="text" class="form-control" id="income_cheque{{$cheque->id}}" name="income_cheque" placeholder="ยอดรายได้ตามใบเช็ค" value="{{$cheque->price}}">
                            <input type="hidden" autocomplete="off" name="cheque_id" class="form-control" value="{{$cheque->id}}">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <label class="col-form-label" for="modal-input-po" id="fontslabel"><b>วันที่นำฝาก :</b></label>
                            <input type="date" autocomplete="off" class="form-control" name="date_deposit" value="{{$cheque->date_deposit}}">
                        </div>
                        <div class="col ">
                            <label class="col-form-label" for="modal-input-priceservice" id="fontslabel"><b>ค่าธรรมเนียม :</b></label>
                            <input type="text" class="form-control" name="fee" id="fee{{$cheque->id}}" value="{{$cheque->fee}}" placeholder="ค่าธรรมเนียม" onchange="change_fee({{$cheque->id}})">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col ">
                            <label class="col-form-label" for="modal-input-priceservice" id="fontslabel"><b>เข้าบัญชี :</b></label>
                            <select class="form-control" name="bank_recived">
                                <!-- <option value="{{$cheque->bank_recived}}">{{$cheque->bank_recived}}</option> -->
                                <option selected disabled>เลือกบัญชีธนาคาร</option>
                                @foreach($moneybanks as $key => $moneybank)
                                <option value="{{ $moneybank->id }}">{{ $moneybank->accounttypeno }} - {{ $moneybank->accounttypefull }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col ">
                            <label class="col-form-label" for="modal-input-priceservice" id="fontslabel"><b>รายได้สุทธิ :</b></label>
                            <input type="text" class="form-control" placeholder="รายได้สุทธิ" value="{{$cheque->net}}" name="net" id="net{{$cheque->id}}">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <label class="col-form-label" for="modal-input-po" id="fontslabel"><b>วันที่ผ่านเช็ค :</b></label>
                            <input type="date" class="form-control" placeholder="วันที่ผ่านเช็ค" name="date_check_pass" value="{{$cheque->date_check_pass}}">
                        </div>
                        <div class="col ">
                            <label class="col-form-label" for="modal-input-priceservice" id="fontslabel"><b>เลขที่ใบนำฝาก :</b></label>
                            <input type="text" class="form-control" placeholder="เลขที่ใบนำฝาก" name="deposit_no" value="{{$cheque->deposit_no}}">
                        </div>
                        <div class="col ">
                            <label class="col-form-label" for="modal-input-priceservice" id="fontslabel"><b>เลขที่ใบสำคัญรับ :</b></label>
                            <input type="text" class="form-control" placeholder="เลขที่ใบสำคัญรับ" name="receipt_no" value="{{$cheque->receipt_no}}">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <label class="col-form-label" for="modal-input-bookinc" id="fontslabel"><b>แนบไฟล์ใบนำฝาก :</b></label>
                            <input type="file" name="pic" class="form-control">
                        </div>
                    </div>

                </div>

            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="submit" class="btn btn-success" id="submit-btn" onclick="validate_click()">ยืนยัน</button>
                <button type="button" class="btn btn-warning" data-dismiss="modal">ยกเลิก</button>
            </div>
            {!! Form::close() !!}

        </div>
    </div>
</div>
@endforeach
<!-- end update status -->



@endsection
