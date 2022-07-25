@extends('index')
@section('content')
<!-- js data table -->
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript" src={{ asset('js/accountjs/journal_debt.js') }}></script>
<link href="{{ asset('css/journal_debt/journal_debt.css') }}" rel="stylesheet" type="text/css" media="all">
<script language="JavaScript">
  function toggle(source) {
    checkboxes = document.getElementsByName('check_list[]');
    for(var i=0, n=checkboxes.length;i<n;i++) {
      checkboxes[i].checked = source.checked;
    }
  }
</script>
<div class="content-page">
    <!-- Start content -->
    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-xl-12">
                    <div class="breadcrumb-holder" id="fontscontent">
                        <h1 class="float-left">Account - FSCT</h1>
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item">สมุดรายวัน</li>
                            <li class="breadcrumb-item active">สมุดรายวันจ่าย(เงินเดือน)</li>
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
                                <fonts id="fontsheader">สมุดรายวันจ่าย(เงินเดือน)</fonts>
                            </h3><br><br>
                            <!-- date range -->
                            <form action="journalpay_filter_social" method="post">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="row" class="fontslabel">
                                <div class="col-sm-3">
                                    <div class="input-group mb-6">
                                        <div class="input-group-prepend">
                                            <label id="fontslabel"><b>วันที่ : &nbsp;</b></label>
                                        </div>
                                        <input type='text' class="form-control" name="daterange" value="" autocomplete="off" required/>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="input-group mb-6">
                                        <label id="fontslabel"><b>สาขา : &nbsp;</b></label>
                                        <select class="form-control" name="branch" required>
                                            <option selected value="all">เลือกทุกสาขา</option>
                                            @foreach ($branchs as $key => $branch)
                                            <option value="{{$branch->code_branch}}">{{$branch->name_branch}}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>

                                <center><button type="submit" class="btn btn-primary btn-sm fontslabel">ค้นหา</button></center>&nbsp;

                            </div>
                            </form>
                            <!-- date range -->
                        </div>



                        <!-- table cotent -->
                        <div class="col" id="fontsjournal">
                            <table class="table table-bordered">
                                <thead>
                                    <tr style="background-color:#aab6c2;color:white;">
                                        <th scope="col"><label class="con" style="margin: -25px -35px 0px 0px;">
                                            <input type="checkbox" onClick="toggle(this)">
                                            <span class="checkmark"></span>
                                          </label>
                                        </th>
                                        <th scope="col">วัน/เดือน/ปี</th>
                                        <th scope="col">เลขที่ใบสำคัญรับ</th>
                                        <th scope="col">รายการ</th>
                                        <th scope="col">รายละเอียด</th>
                                        <th scope="col">เลขที่บัญชี</th>
                                        <th scope="col">ชื่อเลขที่บัญชี</th>
                                        <th scope="col">สาขา</th>
                                        <th scope="col">เดบิต</th>
                                        <th scope="col">เครดิต</th>
                                    </tr>
                                </thead>
                                <tbody>


                                </tbody>
                            </table>
                        </div>
                        <div style="padding-bottom:50px;">
                            <center><button type="submit" class="btn btn-success">Okay ยืนยันการตรวจ</button></center>
                        </div>
                        <!--END table cotent -->
                        {!! Form::close() !!}
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

@endsection
