@extends('index')
@section('content')

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript" src={{ asset('js/accountjs/pettycash.js') }}></script>
<!-- swal -->
<script type="text/javascript" src="https://unpkg.com/sweetalert2@7.0.6/dist/sweetalert2.all.js"></script>


<!-- -----แสดง SWAL เมื่อบันทึกการตั้งหนี้สำเร็จ--------- -->
@if (Session::has('sweetalert.json'))
<script>
    swal({!!Session::pull('sweetalert.json') !!});
</script>
@endif
<!-- -----แสดง SWAL เมื่อบันทึกการตั้งหนี้สำเร็จ--------- -->

<div class="content-page">
    <!-- Start content -->
    <div class="content">
        <div class="container-fluid" >
            <div class="row">
                <div class="col-xl-12">
                    <div class="breadcrumb-holder" id="fontscontent">
                        <h1 class="float-left">Account - FSCT</h1>
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item">จัดการข้อมูล</li>
                            <li class="breadcrumb-item active">บัญชีแยกประเภท</li>
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
                                <fonts id="fontsheader">เลือกบัญชี</fonts>
                            </h3>
                        </div>
                    </div>
                    <div class="bs-example container" data-example-id="striped-table">
                        <table id="example" class="table table-striped table-bordered table-hover fontslabel">
                            <caption>Bootstrap Table CSS Demo</caption>
                            <thead>
                                <tr>
                                    <th>ลำดับ</th>
                                    <th>เลขที่บัญชี</th>
                                    <th>ชื่อบัญชี</th>
                                    <th style="text-align:center;"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($account_types as $key => $account_type)
                                
                                    <tr>
                                        <th scope="row">{{++$key}}</th>
                                        <td>{{$account_type->accounttypeno}}</td>
                                        <td>{{$account_type->accounttypefull}}</td>
                                        <td style="text-align:center;">
                                            <a href="{{ route('ledger.detail',$account_type->accounttypeno) }}">
                                                <button class="btn btn-primary btn-sm">ดูบัญชี</button>
                                            </a>
                                        </td>
                                    </tr>
                                
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="note">

                                </tr>
                            </tfoot>
                        </table>
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