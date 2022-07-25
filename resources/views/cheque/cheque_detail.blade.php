@extends('index')
@section('content')
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
                                <fonts id="fontsheader">รายละเอียดรับเช็ค</fonts>
                            </h3>
                        </div>
                        <div class="container">
                        {!! Form::model($cheque, ['route' => ['cheque.edit', $cheque->id], 'method' => 'patch', 'file'=>'true']) !!}
                            <div class="row">
                                <div class="col">
                                    <label class="col-form-label" for="modal-input-po" id="fontslabel"><b>วันที่รับเช็ค :</b></label>
                                    <input type="date" autocomplete="off" name="got_cheque" class="form-control" value="{{$cheque->got_cheque}}">

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
                                    <input type="date" autocomplete="off" class="form-control" name="cheque_date" value="{{$cheque->cheque_date}}">
                                </div>
                                <div class="col ">
                                    <label class="col-form-label" for="modal-input-priceservice" id="fontslabel"><b>เลขที่เช็ค :</b></label>
                                    <input type="text" class="form-control" name="cheque_no" placeholder="กรอกเลขที่เช็ค" value="{{$cheque->cheque_no}}">
                                </div>
                                <div class="col ">
                                    <label class="col-form-label" for="modal-input-priceservice" id="fontslabel"><b>เช็คธนาคาร :</b></label>
                                    <select class="form-control" name="bank_cheque">
                                        <option value="{{$cheque->bank_cheque}}">{{$cheque->bank_cheque}}</option>
                                        <option value="กรุงไทย">กรุงไทย</option>
                                        <option value="กสิกร">กสิกร</option>
                                        <option value="ไทยพานิช">ไทยพานิช</option>
                                    </select>
                                </div>
                                <div class="col ">
                                    <label class="col-form-label" for="modal-input-priceservice" id="fontslabel"><b>สาขา :</b></label>
                                    <input type="text" class="form-control" placeholder="กรอกสาขาธนาคาร" name="branch" value="{{$cheque->branch}}">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <label class="col-form-label" for="modal-input-po" id="fontslabel"><b>ชื่อลูกค้า :</b></label>
                                    <input type="text" class="form-control" placeholder="กรอกชื่อลูกค้า" name="name" value="{{$cheque->name}}">
                                </div>
                                <div class="col ">
                                    <label class="col-form-label" for="modal-input-priceservice" id="fontslabel"><b>ผู้สั่งจ่าย :</b></label>
                                    <input type="text" class="form-control" placeholder="กรอกผู้สั่งจ่าย" name="payer" value="{{$cheque->payer}}" >
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <label class="col-form-label" for="modal-input-po" id="fontslabel"><b>จำนวนเงิน :</b></label>
                                    <input type="text" class="form-control" placeholder="จำนวนเงิน" name="price" value="{{$cheque->price}}">
                                </div>
                                <div class="col ">
                                    <label class="col-form-label" for="modal-input-priceservice" id="fontslabel"><b>หมายเหตุ :</b></label>
                                    <input type="text" class="form-control" placeholder="หมายเหต" name="notation" value="{{$cheque->notation}}">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <label class="col-form-label" for="modal-input-bookinc" id="fontslabel"><b>แนบหลักฐาน :</b></label> <br>  
                                    @if( $cheque->pic != NULL)                                 
                                    <img src="{{ asset($cheque->pic) }}" width="25%" height="50%" style="border:solid;">  
                                    @endif                                                          
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success" id="submit-btn" onclick="validate_click()">ยืนยัน</button>
                                <a href="{{route('cheque')}}">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">ย้อนกลับ</button>
                                </a>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




@endcontent