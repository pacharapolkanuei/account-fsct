@extends('index')
@section('content')

<style>
    th,
    td {
        text-align: center;
    }
</style>

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript" src={{ asset('js/accountjs/pettycash.js') }}></script>
<link rel="styelsheet" href="">

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
                        <div class="card-header" style="margin-bottom:20px;">
                            <h3><i class="fas fa-edit"></i>
                                <fonts id="fontsheader">บัญชีประเภท : <b>{{ $account_type->accounttypefull }}</b> ( {{ $account_type->accounttypeno }} )</fonts>
                            </h3>
                        </div>
                        <div class="" data-example-id="striped-table">
                            <table id="example" class="table  table-bordered table-hover fontslabel">
                                <thead class="thead-light">
                                    <tr>
                                        <th>ลำดับ</th>
                                        <th>ข้อมูลของโมดูล</th>
                                        <th>สาขา</th>
                                        <th>วัน/เดือน/ปี</th>
                                        <th>รายการ</th>
                                        <th>Ref On Journal</th>
                                        <th>เดบิต</th>
                                        <th>เครดิต</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sum_debit = 0;
                                    $sum_credit = 0;
                                    ?>
                                    @foreach ($journals as $key => $journal)
                                    <tr>
                                        <th scope="row">{{++$key}}</th>
                                        <td>{{$journal->module}}</td>
                                        <td>{{$journal->name_branch}}</td>
                                        <td>{{$journal->datebill}}</td>
                                        <td>{{$journal->list}}</td>
                                        <td>{{$journal->po_head}}</td>
                                        @if($journal->DorC == 0)
                                        <td style="background-color:"></td>
                                        <td style="background-color:">{{$journal->total}}</td>
                                        <?php $sum_credit = $sum_credit + $journal->total; ?>
                                        @else
                                        <td style="background-color:#a3d1f8">{{$journal->total}}</td>
                                        <td style="background-color:"></td>
                                        <?php $sum_debit = $sum_debit + $journal->total; ?>
                                        @endif
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr class="note">
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td><b>รวม</td>
                                        <td><b>{{$sum_debit}}</td>
                                        <td><b>{{$sum_credit}}</td>
                                    </tr>
                                </tfoot>
                            </table>
                            <center>
                                <a href="{{ route('ledger') }}" class="btn btn-danger">ย้อนกลับ</a>
                            </center>
                            <br><br>
                        </div>
                    </div>

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



@endsection