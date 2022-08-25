<?php
use App\Api\Connectdb;
?>
@extends('index')
@section('content')
<script type="text/javascript" src="https://unpkg.com/sweetalert2@7.0.6/dist/sweetalert2.all.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
@if (Session::has('sweetalert.json'))
<script>
swal({!!Session::pull('sweetalert.json')!!});


</script>
@endif

<style>
.nav-tabs .nav-link.active, .nav-tabs .nav-item.show .nav-link {
    color: #495057;
    /* background-color: #9cc8f3 !important; */
    border-color: #dee2e6 #dee2e6 #fff;
    border-top: 10px solid #4fc28b !important;
    /* border-left: 10px solid #4fc28b !important; */
    /* border-right: 10px solid #4fc28b !important; */

}

.select2-container .select2-selection--single{
  height:40px !important;
}
.select2-container--default .select2-selection--single{
  border: 1px solid #ccc !important;
  border-radius: 0px !important;
}

.text-on-pannel {
  background: #fff none repeat scroll 0 0;
  height: auto;
  margin-left: 20px;
  padding: 3px 5px;
  position: absolute;
  margin-top: -47px;
  border: 1px solid #337ab7;
  border-radius: 8px;
}

.panel {
  /* for text on pannel */
  margin-top: 27px !important;
}

.panel-body {
  padding-top: 30px !important;
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
                                  <li class="breadcrumb-item active">รายการทรัพย์สิน</li>
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
                            <fonts id="fontsheader">รายการทรัพย์สิน</fonts>
                          </h3>
                        </div>
                        </div><!-- end card-->

                                <!-- Button to Open the Modal -->
                                <!-- <div>
                                  <button type="button" class="btn btn-primary" data-toggle="modal" style="float: left;margin: 0px 12px 10px 10px;" data-target="#myModal">
                                    <i class="fas fa-plus">
                                      <fonts id="fontscontent">
                                    </i>
                                  </button>
                                </div> -->
                                <input type="hidden" id="timethis" name="timethis" value="<?php echo date('Ymd')?>">
                                <form action="searchassetlisttool" method="post" id="myForm" files='true' >
                                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="row" class="fontslabel">
                                    <div class="col-sm-3">
                                        <div class="input-group mb-6">
                                            <div class="input-group-prepend">
                                                <label id="fontslabel"><b>วันที่ : &nbsp;</b></label>
                                            </div>
                                            <input type='text' class="form-control" name="daterange" value="" autocomplete="off" />
                                        </div>
                                    </div>


                                    <div class="col-sm-3">
                                        <div class="input-group mb-6">
                                            <label id="fontslabel"><b>สาขา : &nbsp;</b></label>
                                            <select class="form-control" name="branch">
                                                <option value="0">เลือกสาขา</option>
                                                @foreach ($branchs as $key => $branch)
                                                <option value="{{$branch->code_branch}}">{{$branch->name_branch}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <center><button type="submit" class="btn btn-primary btn-sm fontslabel">ค้นหา</button></center>&nbsp;
                                    <!-- <center><a class="btn btn-info btn-sm fontslabel" href="{{url('asset_list')}}">ดูทั้งหมด</a></center> -->

                                </form>
                                </div>

                                <br>

                              <!-- ปริ้น  -->
                                <div class="row" class="fontslabel">
                                  &nbsp;&nbsp;&nbsp;<button type="button" class="btn btn-primary" data-toggle="modal"  data-target="#myModal">
                                    <i class="fas fa-plus">
                                      <fonts id="fontscontent">เพิ่มข้อมูล
                                    </i>
                                  </button>

                                  <?php
                                    // $nameValue = {{request()->input('daterange')}};
                                    // $nameValue1 = {{request()->input('branch')}};
                                    $nameValue=Request::input('daterange');
                                    $nameValue1=Request::input('branch');
                                   ?>
                                  <a href="{{ URL::route('asset_listpdf', ['daterangez'=>$nameValue,'branchz'=>$nameValue1]) }}">
                                    &nbsp;&nbsp;<button type="button" class="btn btn-primary">
                                    <i class="fa fa-print">
                                      <fonts id="fontscontent">Print
                                    </i>
                                    </button>
                                  </a>
                                </div>
                              <!------------------>


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
                                        <h4 class="modal-title" id="fontscontent2"><b>รายการทรัพย์สิน</b></h4>
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
                                              {!! Form::open(['route' => 'asset_list.store', 'method' => 'post' , 'id' => 'myForm' ,  'files' => true ]) !!}
                                                {{ csrf_field() }}


                                              <div class="form-inline">
                                                <label id="fontslabel"><b>เลือกประเภทสินทรัพย์ : </b></label>
                                                <div class="col-sm">
                                                  <select style="width: 365px;" class="form-control" name="assetlist_different" id="assetlist_different" onchange="selectassetlist()" required>
                                                    <option value="" selected>โปรดเลือกประเภทสินทรัพย์</option>
                                                    <option value="1">สำนักงาน</option>
                                                    <option value="2">สินค้าให้เช่า</option>
                                                    </option>
                                                  </select>
                                                </div>
                                              </div>

                                              <br>

                                              <!-- <div class="panel panel-primary">
                                                <div class="panel-body">
                                                  <h3 class="text-on-pannel text-primary"><strong class="text-uppercase"> Title </strong></h3>
                                                  <p> Your Code </p>
                                                </div>
                                              </div> -->

                                              <fieldset class="border p-2">
                                                <legend id="fontscontent2" class="w-auto">&nbsp; รายละเอียด &nbsp;</legend>

                                                 <div class="form-inline">
                                                   <label id="fontslabel"><b>หมวด :</b></label>
                                                   <div class="col-sm">
                                                     <select style="width: 450px;" class="form-control select2" name="groups" id="groups_new" onchange="selectgroup()" required>
                                                       <option value="" selected>เลือกหมวด</option>
                                                       <!--
                                                       @foreach ($accounttypes as $key => $accounttype)
                                                       <option value="{{$accounttype->id}}">{{$accounttype->accounttypeno}} - {{$accounttype->accounttypefull}}</option>
                                                       @endforeach
                                                       -->
                                                     </select>
                                                   </div>

                                                   <label id="fontslabel"><b>กลุ่มบัญชี :</b></label>
                                                   <div class="col-sm">
                                                     <select style="width: 450px;" class="form-control select2" name="groups_acc" id="groups_acc_new" required>
                                                       <option value="" selected>เลือกกลุ่มบัญชี</option>
                                                       <!--
                                                       @foreach ($group_propertys as $key => $group_property)
                                                       <option value="{{ $group_property->id }}">{{$group_property->number_property}} - {{$group_property->descritption_thai}}</option>
                                                       @endforeach
                                                       -->
                                                     </select>
                                                   </div>
                                                 </div>

                                                 <br>

                                                 <div class="form-inline">
                                                   <label id="fontslabel"><b>เลขทะเบียน :</b></label>
                                                   <div class="col-sm">
                                                     <input style="width: 100%;max-width: 400px;" type="text" name="no_register" class="form-control" required>
                                                   </div>



                                                   <label id="fontslabel"><b>สาขา :</b></label>
                                                   <div class="col-sm">
                                                     <select style="width: 100%;max-width: 400px;" class="form-control select2" name="ins_branch" required>
                                                       <option value="" selected>เลือกสาขา</option>
                                                       @foreach ($branchs as $key => $branch)
                                                       <option value="{{$branch->code_branch}}">{{$branch->name_branch}}</option>
                                                       @endforeach
                                                     </select>
                                                   </div>
                                                 </div>

                                                 <br>


                                                 <div class="form-inline material_serch" style="display:none;" >
                                                   <label id="fontslabel"><b>ค้นหาใบรับสินค้า :</b></label>
                                                   <div class="col-sm">
                                                     <input style="width: 100%;max-width: 400px;" type="text" name="serachpayinid" id="serachpayinid" class="form-control" required value="">
                                                   </div>
                                                   <div class="col-sm">
                                                     <button type="button" class="btn btn-primary" onclick="serachpayin()">ค้นหา</button>
                                                   </div>
                                                 </div>



                                                 <br>
                                                 <div class="form-inline material_serch" style="display:none;">
                                                   <label id="fontslabel"><b>สินค้า :</b></label>
                                                   <div class="col-sm">
                                                     <?php
                                                           $connect1 = Connectdb::Databaseall();

                                                           $baseMan = $connect1['fsctmain'];
                                                     ?>
                                                     <select style="width: 450px;" class="form-control select2" name="material_id" id="material_id" onchange="selectserchlot()" >
                                                       <option value="0" selected>เลือกสินค้า</option>

                                                       <!--
                                                       @foreach ($accounttypes as $key => $accounttype)
                                                       <option value="{{$accounttype->id}}">{{$accounttype->accounttypeno}} - {{$accounttype->accounttypefull}}</option>
                                                       @endforeach
                                                       -->
                                                     </select>
                                                   </div>

                                                   <label id="fontslabel"><b>lot :</b></label>
                                                   <div class="col-sm">
                                                       <input style="width: 100%;max-width: 400px;" type="text" name="lot" id="lot" readonly class="form-control">
                                                   </div>
                                                 </div>
                                                 <br>


                                                 <!-- <div class="form-inline">
                                                   <label class="col-form-label"  id="fontslabel"><b>วันที่ซื้อ :</b></label>
                                                     <div class="col-sm">
                                                     <input style="width: 100%;max-width: 500px;" type="date" autocomplete="off" class="form-control" name="datebill">
                                                     </div>

                                                   <label id="fontslabel"><b>เลขที่บิล :</b></label>
                                                     <div class="col-sm">
                                                     <input style="width: 100%;max-width: 500px;" type="text" name="bill_no" class="form-control" id="modal-input-calculate">
                                                     </div>
                                                 </div> -->
                                                 <center>
                                                  <!--
                                                   <table border="0">
                                                     <thead>
                                                       <tr>
                                                         <th><label class="col-form-label" id="fontslabel"><b>วันที่เริ่มใช้งาน&nbsp;</b></label></th>
                                                         <th><input type="date" autocomplete="off" class="form-control" name="date_startuse"></th>
                                                       </tr>
                                                     </thead>
                                                   </table> -->

                                                   <table border="0">
                                                     <thead>

                                                       <tr>

                                                         <th>&nbsp;&nbsp;<label class="col-form-label" id="fontslabel"><b>วันที่ซื้อ&nbsp;</b></label></th>
                                                         <th><input type="date" autocomplete="off" class="form-control" readonly name="date_startuse" id="date_startuses"></th>
                                                         <th><label class="col-form-label" id="fontslabel"><b>วันที่เริ่มใช้งาน&nbsp;</b></label></th>
                                                         <th><input type="date" autocomplete="off" class="form-control" readonly name="date_buy" id="date_buy" onchange="get_date()"></th>
                                                       </tr>
                                                       <tr>
                                                         <th><label class="col-form-label" id="fontslabel"><b>ราคาทุน&nbsp;</b></label></th>
                                                         <th><input type="text" name="price_buy" class="form-control" id="price_buyz" onchange="calculate_depreciation()" required readonly></th>
                                                         <th>&nbsp;&nbsp;<label class="col-form-label" id="fontslabel"><b>อายุการใช้งาน&nbsp;</b></label></th>
                                                         <th><input type="text" name="life_for_use" class="form-control" maxlength="1" id="life_for_usez" onchange="calculate_depreciation()" readonly></th>
                                                         <th><input type='hidden' size="2" name="date_cal_starts" class="form-control" onchange="calculate_depreciation()" id="date_cal_start" readonly autocomplete="off" /></th>
                                                         <th><input type='hidden' size="2" name="date_cal_ends" class="form-control" onchange="calculate_depreciation()" id="date_cal_end" readonly autocomplete="off" /></th>
                                                       </tr>
                                                       <tr>

                                                       </tr>
                                                       <tr>
                                                         <th><label class="col-form-label" id="fontslabel"><b>ราคาซาก&nbsp;</b></label></th>
                                                         <th><input type="text" name="end_price_sell" class="form-control" id="end_price_sellz"  readonly value="1"></th>
                                                         <th>&nbsp;&nbsp;<label class="col-form-label" id="fontslabel"><b>อัตรา(%)&nbsp;</b></label></th>
                                                         <th><input type="text" name="end_price_sellpercent" class="form-control" id="end_price_sellpercentz" onchange="calculate_depreciation()" readonly></th>
                                                       </tr>

                                                       <!-- <tr>
                                                         <th><label class="col-form-label" id="fontslabel"><b>คำนวณเองถึง&nbsp;</b></label></th>
                                                         <th><input type="date" autocomplete="off" class="form-control" name="cal_date" id="get_date_calselfz" onchange="get_date()"></th>
                                                       </tr> -->
                                                     </thead>
                                                   </table>
                                                   <table>
                                                     <thead>
                                                       <tr>
                                                         <th><label class="col-form-label" id="fontslabel"><b>ค่าเสื่อมรายปี&nbsp;</b></label></th>
                                                         <th><input type="text" name="year_depreciation" class="form-control" id="year_depreciation" readonly></th>
                                                         <th>&nbsp;&nbsp;<label class="col-form-label" id="fontslabel"><b>ค่าเสื่อมรายเดือน&nbsp;</b></label></th>
                                                         <th><input type="text" name="month_depreciation" class="form-control" id="month_depreciation" readonly></th>
                                                         <th>&nbsp;&nbsp;<label class="col-form-label" id="fontslabel"><b>ค่าเสื่อมรายวัน&nbsp;</b></label></th>
                                                         <th><input type="text" name="day_depreciation" class="form-control" id="day_depreciation" readonly></th>
                                                       </tr>
                                                     </thead>
                                                   </table>

                                                 </center>
                                              </fieldset>
                                              <br>

                                              <fieldset class="border p-2">
                                              <legend id="fontscontent2" class="w-auto">&nbsp; รายละเอียดรหัสรายการทรัพย์สิน &nbsp;</legend>
                                              <div class="form-inline">
                                                <label id="fontslabel"><b>รหัสรายการทรัพย์สิน :</b></label>
                                                <div class="col-sm">
                                                  <input style="width: 100%;max-width: 1200px;" type="text" name="no_asset" id="no_asset" class="form-control"  readonly>
                                                </div>
                                              </div>

                                              <br>

                                              <div class="form-inline">
                                                <label id="fontslabel"><b>ชื่อรายการทรัพย์สิน (ภาษาไทย) :</b></label>
                                                <div class="col-sm">
                                                  <input style="width: 100%;max-width: 1200px;" type="text" name="name_thai" id="name_thai" class="form-control" readonly>
                                                </div>

                                                <label id="fontslabel"><b>ชื่อรายการทรัพย์สิน (ภาษาอังกฤษ) :</b></label>
                                                <div class="col-sm">
                                                  <input style="width: 100%;max-width: 1200px;" type="text" name="name_eng" id="name_eng" class="form-control" readonly>
                                                </div>
                                              </div>
                                              </fieldset>
                                              <br>

                                              <fieldset class="border p-2">
                                                <legend id="fontscontent2" class="w-auto">&nbsp; ค่าเสื่อมสะสมยกมา &nbsp;</legend>

                                                 <center>
                                                   <table border="0">
                                                     <thead>
                                                       <tr>
                                                         <th><label class="col-form-label" id="fontslabel"><b>ค่าเสื่อมสะสมยกมา&nbsp;</b></label></th>
                                                         <th><input type="text" class="form-control" id="depreciation_buyz" name="depreciation_buyz" readonly onchange="depreciation()"></th>
                                                         <th>&nbsp;&nbsp;<label class="col-form-label" id="fontslabel" ><b>ค่าเสื่อมเบื้องต้น&nbsp;</b></label></th>
                                                         <th><input type="text" name="primary_depreciation"  id="primary_depreciation" readonly class="form-control"></th>
                                                       </tr>
                                                       <tr class="container10">
                                                         <!-- <th style="text-align: right;"><label class="col-form-label" id="fontslabel"><font color="red"><b>ค่าเสื่อมสะสมยกมาสุทธิ&nbsp;</b></font></label></th>
                                                         <th><input type="text" name="depreciation_buy" class="form-control" readonly></th>
                                                         <th></th>
                                                         <th></th> -->
                                                       </tr>
                                                       <!-- <tr>
                                                         <th><label class="col-form-label" id="fontslabel"><b>ค่าเสื่อมที่คำนวณเอง&nbsp;</b></label></th>
                                                         <th><input type="text" name="cal_depreciation_buy" class="form-control" id="cal_selfz" readonly></th>
                                                         <th>&nbsp;&nbsp;<label class="col-form-label" id="fontslabel"><b>ราคาขาย&nbsp;</b></label></th>
                                                         <th><input type="text" name="depreciation_sell" class="form-control"></th>
                                                       </tr> -->
                                                       <!-- <tr>
                                                         <th><label class="col-form-label" id="fontslabel"><b>คำนวณเองถึงวันที่&nbsp;</b></label></th>
                                                         <th><input type="date" autocomplete="off" class="form-control" name="cal_date" id="get_date_calselfz" onchange="get_date()"></th>
                                                         <th>&nbsp;&nbsp;<label class="col-form-label" id="fontslabel"><b>กำไร/ขาดทุน&nbsp;</b></label></th>
                                                         <th><input type="text" name="profit_loss" class="form-control"></th>
                                                       </tr> -->
                                                     </thead>
                                                   </table>
                                                 </center>
                                              </fieldset>

                                              <br>
                                              <!--
                                              <fieldset class="border p-2">
                                                <legend id="fontscontent2" class="w-auto">&nbsp; กำไร / ขาดทุน &nbsp;</legend>
                                                 <center>

                                                   <table border="0">
                                                     <thead>
                                                       <tr>
                                                          <th><label class="col-form-label" id="fontslabel"><b>คำนวณเองถึงวันที่&nbsp;</b></label></th>
                                                         <th><input type="date" autocomplete="off" class="form-control" name="cal_date" id="get_date_calselfz" onchange="get_date()"></th>
                                                         <th><label class="col-form-label" id="fontslabel"><b>ราคาขาย&nbsp;</b></label></th>
                                                         <th><input type="text" name="depreciation_sell" class="form-control"></th>
                                                         <th>&nbsp;&nbsp;<label class="col-form-label" id="fontslabel"><b>กำไร/ขาดทุน&nbsp;</b></label></th>
                                                         <th><input type="text" name="profit_loss" class="form-control"></th>
                                                         <th>&nbsp;&nbsp;<label class="col-form-label" id="fontslabel"><b>วันที่อนุมัติตัดจำหน่าย&nbsp;</b></label></th>
                                                         <th><input type="date" autocomplete="off" class="form-control" name="date_sell"></th>
                                                       </tr>
                                                     </thead>
                                                   </table>

                                                 </center>
                                              </fieldset>
                                              -->

                                            </div>

                                      <!-- Modal footer -->

                                      <div class="modal-footer">

                                        <button type="button" class="btn btn-primary" onclick="cleardata()">รีเซ็ตข้อมูล</button>
                                        <a href="{{route('asset_list')}}">
                                          {!! Form::submit('บันทึก', ['class' => 'btn btn-success', 'style' => 'dispaly: inline']) !!}
                                        <button type="button" class="btn btn-warning" data-dismiss="modal">ยกเลิก</button>
                                        </a>
                                      </div>
                                      {!! Form::close() !!}

                                    </div>
                                  </div>
                                </div>
                    </div>
      			<!-- END container-fluid -->
      		    </div>
      		<!-- END content -->


          <!-- Tabs -->
          <?php

          if(!empty($start)){
            // print_r($branchselct);
            echo "<font color='red'>งวดบัญชีก่อน :".($start)."</font>";
            echo "<font color='blue'>    งวดบัญชีปัจจบัน :".($end)."</font>";

            $yearnow = date('Y');
            $connect1 = Connectdb::Databaseall();
            $baseAc1 = $connect1['fsctaccount'];
            $sql1asset = "SELECT $baseAc1.asset_list.*
                            FROM $baseAc1.asset_list
                            INNER JOIN $baseAc1.typeasset
                            ON $baseAc1.typeasset.id = $baseAc1.asset_list.group_property_id
                            WHERE $baseAc1.asset_list.statususe ='1'
                            AND $baseAc1.asset_list.asset_different = '2'
                            AND $baseAc1.asset_list.branch_id = '$branchselct' ";

              $getdatadetailasset = DB::select($sql1asset);

              $sqltypeasset = "SELECT $baseAc1.typeasset.*
                              FROM $baseAc1.typeasset
                              WHERE $baseAc1.typeasset.status = '1'
                              AND $baseAc1.typeasset.typeasset = '2'
                              AND $baseAc1.typeasset.usecalasset = '1' ";

              $getdatatypeasset = DB::select($sqltypeasset);
              // echo "<pre>";
              // print_r($getdatatypeasset);
              // exit;
          }


          ?>
          <section id="tabs">
            <div >
              <h6 class="section-title h1"></h6>
              <div class="row">
                <div class="col-12" style="width:100%;">
                  <!-- <nav>
                    <div class="nav nav-tabs nav-fill fontslabel" id="nav-tab" role="tablist">
                      <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">สำนักงาน</a>
                      <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">สินค้าให้เช่า</a>
                    </div>
                  </nav> -->
                  <div class="tab-content py-3 px-3 px-sm-0" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                      <!-- table ยังไม่ได้จ่าย-->
                      <div class="table-responsive">
                        <table id="example" class="table table-striped table-bordered fontslabel" style="width:100%;">
                          <thead>
                            <tr>
                              <th  rowspan="2">กลุ่มสินทรัพย์</th>
                              <th  rowspan="2">สาขา</th>
                              <th  rowspan="2">กลุ่มบัญชี</th>
                              <th  rowspan="2">รหัสสินทรัพย์</th>
                              <th  rowspan="2">ชื่อสินทรัพย์</th>
                              <th  rowspan="2">วันที่ได้ซื้อ/ได้มา</th>
                              <th  rowspan="2">เลขที่เอกสาร</th>
                              <th  rowspan="2">วันที่เริ่มคิดค่าเสื่อมราคา</th>
                              <th  rowspan="2" >จำนวนสินทรัพย์</th>
                              <th  rowspan="2">มูลค่าราคาทุน</th>
                              <th  rowspan="2">มูลค่าคงเหลือ</th>
                              <th  rowspan="2">มูลค่าที่คิดค่าเสื่อมราคา</th>
                              <th  rowspan="2">อัตรา</th>
                              <th  rowspan="2">วันที่ขาย/ตัดบัญชี</th>
                              <th  rowspan="2">เลขที่เอกสาร</th>
                              <th  rowspan="2">จำนวนชิ้นที่ขาย</th>
                              <th  rowspan="2">จำนวนวันที่ขาย</th>
                              <th  rowspan="2">จำนวนเอกสาร</th>
                              <th colspan="4" >ราคาทุน</th>
                              <th rowspan="2" >จำนวนวันคิดค่าเสื่อมราคา</th>
                              <th colspan="4" >ค่าเสื่อมราคาสะสม</th>
                              <th  rowspan="2">ยอดสุทธิ</th>
                            </tr>
                            <tr>
                              <th >ยอดยกมา</th>
                              <th >เพิ่มขึ้น</th>
                              <th >ลดลง</th>
                              <th >ยอดยกไป</th>
                              <th >ยอดยกมา</th>
                              <th >เพิ่มขึ้น</th>
                              <th >ลดลง</th>
                              <th >ยอดยกไป</th>
                            </tr>
                          </thead>
                          <?php if(!empty($start)){?>
                          <tbody>
                            <?php foreach ($getdatatypeasset as $key => $value) { ?>
                              <tr>
                                <td  colspan="28"><?php echo $value->name_typeasset;?></td>

                              </tr>
                              <?php foreach ($getdatadetailasset as $k => $v): ?>
                                <?php if($v->group_property_id == $value->id ){ ?>
                                <tr>
                                  <td></td>
                                  <td ><?php echo $branchselct;?></td>
                                  <td ><?php echo $v->groups_acc;?></td>
                                  <td ><?php echo $v->no_asset;?></td>
                                  <td ><?php echo $v->name_thai;?></td>
                                  <td ><?php echo $v->date_buy;?></td>
                                  <td ><?php echo $v->no_register;?></td>
                                  <td ><?php echo $v->date_buy;?></td>
                                  <td  >1</td>
                                  <td ><?php echo $v->price_buy;?></td>
                                  <td ><?php echo $v->end_price_sell;?></td>
                                  <td ><?php echo $v->price_buy-$v->end_price_sell;?></td>
                                  <td ><?php echo $v->end_price_sellpercent;?></td>
                                  <td ></td>
                                  <td ></td>
                                  <td ></td>
                                  <td ></td>
                                  <td ></td>
                                  <td >
                                    <?php
                                       $yearbuy = substr($v->date_buy,0,4);
                                      if($yearnow > $yearbuy){
                                          echo $v->price_buy;
                                      }
                                      ?>
                                  </td>
                                  <td >
                                    <?php
                                       $yearbuy = substr($v->date_buy,0,4);
                                      if($yearnow == $yearbuy){
                                          echo $v->price_buy;
                                      }
                                      ?>
                                  </td>
                                  <td >0</td>
                                  <td ><?php echo $v->price_buy;?></td>
                                  <td >
                                    <?php
                                            $date1=date_create($end);
                                            $date2=date_create($v->date_buy);
                                            $diff=date_diff($date1,$date2);
                                            $datediff = $diff->format("%a");
                                            $datecallde = 0;
                                            if($datediff > 365){
                                              $datecallde = 365;
                                            }else{
                                              $datecallde = $datediff+1;
                                            }
                                            echo $datecallde;
                                    ?>
                                  </td>
                                  <td >
                                    <?php
                                      $bring_forward = 0;
                                      $monthselect = substr($start,0,7);
                                      $monthselect = $monthselect.'-01';
                                      $sqlhisasset = "SELECT $baseAc1.his_asset_depreciationexpense.*
                                                      FROM $baseAc1.his_asset_depreciationexpense
                                                      WHERE $baseAc1.his_asset_depreciationexpense.status ='1'
                                                      AND $baseAc1.his_asset_depreciationexpense.date_ed = '$monthselect'
                                                      AND $baseAc1.his_asset_depreciationexpense.asset_list_id = '$v->id' ";

                                        $getdatahisasset = DB::select($sqlhisasset);

                                    if(!empty($getdatahisasset)){
                                        echo $bring_forward = $getdatahisasset[0]->bring_forward;
                                    }
                                    ?>
                                  </td>
                                  <td >
                                    <?php
                                      $a = $v->price_buy-$v->end_price_sell;
                                      $b= $v->end_price_sellpercent/100 ;
                                      $c = $datecallde;
                                      $caled = (($a*$b*$c)/365);
                                      echo number_format((($a*$b*$c)/365),2);
                                    ?>
                                  </td>
                                  <td ></td>
                                  <td ><?php echo number_format(($bring_forward+$caled),2);?></td>
                                  <td >
                                    <?php   $totalde = $v->price_buy-($bring_forward+$caled);
                                            if($totalde<1){
                                              $totalde = $v->end_price_sell;
                                            }else{
                                               $totalde = $totalde;
                                            }

                                                echo number_format(($totalde),2)
                                    ?>
                                  </td>
                                </tr>
                              <?php } ?>
                              <?php endforeach; ?>
                              <tr>
                                <td  colspan="12">รวม<?php echo $value->name_typeasset;?></td>

                                <td ></td>
                                <td ></td>
                                <td ></td>
                                <td ></td>
                                <td ></td>
                                <td ></td>
                                <td ></td>
                                <td ></td>
                                <td ></td>
                                <td ></td>
                                <td ></td>
                                <td ></td>
                                <td ></td>
                                <td ></td>
                                <td ></td>
                                <td ></td>
                              </tr>
                            <?php } ?>
                          </tbody>
                        <?php } ?>
                        </table>
                        <br>
                        <br>
                        <br>
                        <br>
                        <font><u>สรุป</u></font>
                        <table id="example1" class="table table-striped table-bordered fontslabel" style="width:100%">
                          <thead>
                            <tr>
                              <th  rowspan="2">กลุ่มสินทรัพย์</th>
                              <th  rowspan="2" >จำนวนสินทรัพย์</th>
                              <th  rowspan="2">มูลค่าราคาทุน</th>
                              <th  rowspan="2">มูลค่าคงเหลือ</th>
                              <th  rowspan="2">มูลค่าที่คิดค่าเสื่อมราคา</th>
                              <th  rowspan="2">อัตรา</th>
                              <th  rowspan="2">วันที่ขาย/ตัดบัญชี</th>
                              <th  rowspan="2">เลขที่เอกสาร</th>
                              <th colspan="4" >ราคาทุน</th>
                              <th rowspan="2" >จำนวนวันคิดค่าเสื่อมราคา</th>
                              <th colspan="4" >ค่าเสื่อมราคาสะสม</th>

                            </tr>
                            <tr>
                              <th >ยอดยกมา</th>
                              <th >เพิ่มขึ้น</th>
                              <th >ลดลง</th>
                              <th >ยอดยกไป</th>
                              <th >ยอดยกมา</th>
                              <th >เพิ่มขึ้น</th>
                              <th >ลดลง</th>
                              <th >ยอดยกไป</th>
                            </tr>
                          </thead>
                          <?php if(!empty($start)){?>

                        <?php } ?>
                        </table>
                      </div>
                      <!-- table -->
                    </div>


                  </div>

                </div>
              </div>
            </div>
          </section>
          <!-- ./Tabs -->

        </div>
      </div><!-- end card-->
  </div>

  <!-- end iditmodal -->
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script type="text/javascript" src={{ asset('js/accountjs/asset_list1.js') }}></script>
  <script>
      $(document).ready(function() {
      $('#example').DataTable();
      $('#example1').DataTable();
      } );
  </script>
@endsection
