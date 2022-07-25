@extends('index')
@section('content')


<!-- js data table -->
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript" src={{ asset('js/accountjs/payment.js') }}></script>
<!-- swal -->
<script type="text/javascript" src="https://unpkg.com/sweetalert2@7.0.6/dist/sweetalert2.all.js"></script>


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
                                <fonts id="fontsheader">รายการการจ่ายเงิน</fonts>
                            </h3>
                        </div><br>
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12 col-md-offset-1">
                                    <div class="panel panel-default panel-table">
                                        <div class="panel-heading">
                                            <div class="row">

                                                <div class="col col-xs-6 text-right">
                                                    <div class="pull-right">
                                                        <div class="btn-group" data-toggle="buttons">
                                                            <label class="btn btn-success btn-filter active" data-target="completed">
                                                                <input type="radio" name="options" id="option1" autocomplete="off" checked>
                                                                จ่ายสด
                                                            </label>
                                                            <label class="btn btn-warning btn-filter" data-target="pending">
                                                                <input type="radio" name="options" id="option2" autocomplete="off"> แบบโอน
                                                            </label>
                                                            <label class="btn btn-info btn-filter" data-target="all">
                                                                <input type="radio" name="options" id="option3" autocomplete="off"> All
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel-body">
                                            <table id="mytable" class="table table-striped table-bordered table-list">
                                                <thead>
                                                    <tr>
                                                        <th class="col-check" style="text-align:center;"><input type="checkbox" id="checkall" onclick="test()" /> ทั้งหมด</th>
                                                        <th class="col-tools" style="text-align:center;"></span> สถานะ</th>
                                                        <th class="hidden-xs">ID</th>
                                                        <th class="col-text">Name</th>
                                                        <th class="col-text">Email</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr data-status="completed">
                                                        <td align="center"><input type="checkbox" class="checkthis" /></td>
                                                        <td align="center">
                                                            <span style="color:green;"><b>Active</b></span>
                                                        </td>
                                                        <td class="hidden-xs">1</td>
                                                        <td>John Doe</td>
                                                        <td>johndoe@example.com</td>
                                                    </tr>
                                                    <tr data-status="pending">
                                                        <td align="center"><input type="checkbox" class="checkthis" /></td>
                                                        <td align="center">
                                                        <span style="color:red;"><b>Inactive</b></span>
                                                        </td>
                                                        <td class="hidden-xs">2</td>
                                                        <td>Jen Curtis</td>
                                                        <td>jencurtis@example.com</td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                        </div>
                                        <div class="panel-footer">
                                            <div class="container">
                                                <div class="row">
                                                    <div class="col col-xs-3">
                                                        <div class="pull-right">
                                                            <button type="button" class="btn btn-primary">
                                                                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                                                                Add row
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><br>
                                    </div>
                                </div>
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



@endsection