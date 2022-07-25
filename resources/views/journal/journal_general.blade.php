@extends('index')
@section('content')
<!-- <link rel="stylesheet" href="{{asset('css/debt/debt.css')}}"> //! include css -->
<!-- js data table -->
<meta name="csrf-token" content="{{ csrf_token() }}">
<script type="text/javascript" src="https://unpkg.com/sweetalert2@7.0.6/dist/sweetalert2.all.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript" src={{ asset('js/accountjs/journal_general.js') }}></script>
<link href="{{ asset('css/journal_debt/journal_debt.css') }}" rel="stylesheet" type="text/css" media="all">
<script type="text/javascript">
  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
</script>

<script language="JavaScript">
  function toggle(source) {
    checkboxes = document.getElementsByName('id_gen[]');
    for(var i=0, n=checkboxes.length;i<10;i++) {
      checkboxes[i].checked = source.checked;
    }
  }
</script>

@if (Session::has('sweetalert.json'))
<script>
swal({!!Session::pull('sweetalert.json')!!});
</script>
@endif

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
                            <li class="breadcrumb-item active">สมุดรายวันทั่วไป (ปรับปรุงรายการ)</li>
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
                                <fonts id="fontsheader">สมุดรายวันทั่วไป (ปรับปรุงรายการ)</fonts>
                            </h3><br><br>

                            <!-- date range -->
                            {!! Form::open(['route' => 'journalgeneral_filter', 'method' => 'post']) !!}
                            <div class="row" class="fontslabel">
                                <div class="col-sm-3">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <label id="fontslabel"><b>วันที่ : &nbsp;</b></label>
                                        </div>
                                        <input type='text' class="form-control" name="daterange" value="" autocomplete="off" />
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="input-group">
                                        <label id="fontslabel"><b>สาขา :</b></label>&nbsp;&nbsp;
                                        <select class="form-control" name="branch_search">
                                            <option value="0">เลือกสาขา</option>
                                            @foreach ($branchs as $key => $branch)
                                            <option value="{{$branch->code_branch}}">{{$branch->name_branch}}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>
                                <div class="col-sm-5">
                                <button type="submit" class="btn btn-primary btn-sm fontslabel">ค้นหา</button>
                                <a class="btn btn-info btn-sm fontslabel" href="{{url('journal_general')}}">ดูทั้งหมด</a>
                                <button type="button" class="btn btn-primary btn-sm fontslabel" data-toggle="modal" data-target="#myModal"><i class="fas fa-plus"></i> เพิ่มข้อมูล</button>
                                </div>
                            </div>
                            {!! Form::close() !!}
                            <!-- date range -->
                        </div>

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

                        <!-- The Modal -->
                        <div class="modal fade" id="myModal">
                          <div class="modal-dialog modal-xl">
                            <div class="modal-content">

                              <!-- Modal Header -->
                              <div class="modal-header">
                                <h4 class="modal-title" id="fontscontent2"><b>สมุดรายวันทั่วไป</b></h4>
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

                                      {!! Form::open(['route' => 'journal.store', 'method' => 'post' ]) !!}
                                        {{ csrf_field() }}

                                          <div class="was-validated form-inline" style="margin: 10px 50px 0px 50px;">
                                            <!-- <div class="col-sm-6"> -->
                                            <div class="row">
                                              <label class="mb-2 mr-sm-2" id="fontslabel" for=""><b>สาขา :</b></label>
                                              <select class="form-control mb-2 mr-sm-2" name="branch" required>
                                                <option disabled selected></option>
                                                @foreach ($branchs as $key => $branch)
                                                <option value="{{$branch->code_branch}}">{{$branch->name_branch}}</option>
                                                @endforeach
                                              </select>

                                              &nbsp;&nbsp;<label class="mb-2 mr-sm-2" id="fontslabel" for=""><b>สมุดรายวัน :</b></label>
                                              <select class="form-control mb-2 mr-sm-2" name="type_module" required>
                                                <option disabled selected></option>
                                                @foreach ($type_journals as $key => $type_journal)
                                                <option value="{{$type_journal->id_typejournal}}">{{$type_journal->name_typejournal}}</option>
                                                @endforeach
                                              </select>
                                              <!-- <label class="mb-2 mr-sm-2" id="fontslabel"><b>เลขที่เอกสาร :</b></label>
                                              <input type="text" name="bill_no_withtax" class="form-control mb-2 mr-sm-2" id="getautokey" required> -->
                                              &nbsp;&nbsp;<label class="mb-2 mr-sm-2" for="modal-input-priceservice" id="fontslabel"><b>วันที่เอกสาร :</b></label>
                                              <input type="date" autocomplete="off" class="form-control mb-2 mr-sm-2" name="datenow" value="<?php echo date('Y-m-d'); ?>" required>
                                                <!-- <div class="valid-feedback" style="margin: 0px 0px 0px 110px;">เลือกวันที่แล้ว</div>
                                                <div class="invalid-feedback" style="margin: 0px 0px 0px 110px;">โปรดเลือกวันที่</div> -->
                                              <br>


                                            </div>
                                            <!-- </div> -->
                                          </div>
                                          <div class="form-inline" style="margin: 10px 50px 0px 50px;">
                                            <div class="row">
                                              <br>
                                                <label class="mb-2 mr-sm-2" id="fontslabel" for=""><b>อัพโหลด Excel :</b></label>
                                                <input type="file" name="fileexcel" class="form-control">
                                            </div>

                                            <div class="row">
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="mb-2 mr-sm-2" id="fontslabel" for=""><b>กรณีปิดบัญชี :</b></label>
                                                <input class="form-control mb-2 mr-sm-2" type="checkbox" name="check_bankclose" value="1">
                                            </div>


                                          </div>
                                          <!-- <div class="form-inline" style="margin: 10px 50px 0px 50px;">
                                            <div class="col-sm-6">
                                            <div class="row">
                                              <label id="fontslabel"><b>เลือกจำนวน Column :&nbsp;</b></label>
                                                <select class="form-control" onchange="increase_col(this)" id="inc_col"/>
                                                    <option disabled selected>เลือกจำนวน Column</option>
                                                    <option value="1">1 Column</option>
                                                    <option value="2">2 Column</option>
                                                    <option value="3">3 Column</option>
                                                    <option value="4">4 Column</option>
                                                    <option value="5">5 Column</option>
                                                    <option value="6">6 Column</option>
                                                </select>
                                            </div>
                                            </div>
                                          </div>
                                        </div> -->

                                        <div style="padding: 10px 0px 0px 0px;">
                                          <div class="table-responsive">
                                            <table class="table">
                                              <thead class="thead-light" id="fontstable">
                                                  <th width="25%" style="text-align: center;">รหัสบัญชี</th>
                                                  <th width="15%" style="text-align: center;">เดบิต</th>
                                                  <th width="15%" style="text-align: center;">เครดิต</th>
                                                  <th width="20%" style="text-align: center;">คำอธิบายรายการย่อย</th>
                                                  <th width="15%" style="text-align: center;">ชื่อ</th>
                                                  <!-- <th width="20%" style="text-align: center;">สาขา</th> -->
                                                  <th width="10%" style="text-align: center;"><button class="btn-primary add_form_field" type="button">เพิ่มข้อมูล</button></th>
                                              </thead>

                                              <tbody class="container11">

                                              </tbody>

                                              <tfoot>
                                                <tr>
                                                  <th style="text-align: right;" id="fontstable">รวม</th>
                                                  <th style="text-align: right;"><input type="text" name="totaldebit" id="totaldebit" class="form-control" readonly></th>
                                                  <th style="text-align: right;"><input type="text" name="totalcredit" id="totalcredit" class="form-control" readonly></th>
                                                  <th></th>
                                                  <th></th>
                                                  <th></th>
                                                  <th></th>
                                                </tr>
                                              </tfoot>
                                            </table>
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

                        {!! Form::open(['route' => 'confirm_journal_general', 'method' => 'post']) !!}
                        <!-- table cotent -->
                        <div class="col" id="fontsjournal">
                            <table class="table table-bordered" >
                                <thead>
                                    <tr style="background-color:#aab6c2;color:white;">
                                        <th scope="col"><label class="con" style="margin: -25px -35px 0px 0px;">
                                            <input type="checkbox" onClick="toggle(this)">
                                            <span class="checkmark"></span>
                                          </label>
                                        </th>
                                        <th scope="col">วัน/เดือน/ปี</th>
                                        <th scope="col">เลขที่เอกสาร</th>
                                        <th scope="col">รายการ</th>
                                        <th scope="col">คำอธิบายรายการย่อย</th>
                                        <th scope="col">เลขที่บัญชี</th>
                                        <th scope="col">ชื่อเลขที่บัญชี</th>
                                        <th scope="col">สาขา</th>
                                        <th scope="col">เดบิต</th>
                                        <th scope="col">เครดิต</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  @foreach ($inform_get_edits as $key => $inform_get_edit)
                                  @if ($inform_get_edit->number_bill_journal == $ap)
                                    <!-- ถ้า ap เหมือนกันเขียนแค่ list -->
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        @if($inform_get_edit->debit >= 0.01)
                                          <td style="text-align:left;">{{$inform_get_edit->name_suplier}}</td>
                                        @elseif($inform_get_edit->credit >= 0.01)
                                          <td style="text-align:center;">{{$inform_get_edit->name_suplier}}</td>
                                        @endif
                                        <td></td>
                                        <td>{{$inform_get_edit->accounttypeno}}</td>
                                        <td>{{$inform_get_edit->accounttypefull}}</td>
                                        <td></td>
                                        <td><?php echo number_format($inform_get_edit->debit,2);?></td>
                                        <td><?php echo number_format($inform_get_edit->credit,2);?></td>
                                    </tr>
                                    @if ($key == count($inform_get_edits)-1)
                                    <!-- เขียนสำหรับรายการสุดท้าย -->
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td><b><?php echo number_format($inform_get_edit->totalsum,2);?></b></td>
                                            <td><b><?php echo number_format($inform_get_edit->totalsum,2);?></b></td>
                                        </tr>
                                    @endif
                                    <?php $ap = $inform_get_edit->number_bill_journal ?>
                                  @else
                                  <!-- เปลี่ยนรายการ -->
                                    @if ($key != 0)
                                    <!-- ก่อนเปลี่ยนรายการเขียนปิดรายการก่อนหน้า -->
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td><b><?php echo number_format($inform_get_edits[$key-1]->totalsum,2);?></b></td>
                                            <td><b><?php echo number_format($inform_get_edits[$key-1]->totalsum,2);?></b></td>
                                        </tr>
                                    @endif
                                    <tr style="border-top-style:solid;">
                                        <!-- เขียน row แรก แต่ละรายการ -->
                                        <td>
                                          @if($inform_get_edit->accept == 0)
                                          <label class="con">
                                          <input type="checkbox" name="id_gen[]" value="{{ $inform_get_edit->id_journal_5 }}">
                                              <span class="checkmark"></span>
                                          </label>
                                          @else
                                          <i class="fa fa-check" style="color:green;font-size:20px;"></i>
                                          @endif
                                        </td>
                                        <td>{{$inform_get_edit->datebill}}</td>
                                        <td>{{$inform_get_edit->number_bill_journal}}</td>
                                        @if($inform_get_edit->debit >= 0.01)
                                          <td style="text-align:left;">{{$inform_get_edit->name_suplier}}</td>
                                        @elseif($inform_get_edit->credit >= 0.01)
                                          <td style="text-align:center;">{{$inform_get_edit->name_suplier}}</td>
                                        @endif
                                        <td>{{$inform_get_edit->list}}</td>
                                        <td>{{$inform_get_edit->accounttypeno}}</td>
                                        <td>{{$inform_get_edit->accounttypefull}}</td>
                                        <td>{{$inform_get_edit->code_branch}}</td>
                                        <td><?php echo number_format($inform_get_edit->debit,2);?></td>
                                        <td><?php echo number_format($inform_get_edit->credit,2);?></td>
                                    </tr>

                                    @if ($key == count($inform_get_edits)-1)
                                    <!-- เขียนสำหรับรายการสุดท้าย -->
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td><b><?php echo number_format($inform_get_edit->totalsum,2);?></b></td>
                                            <td><b><?php echo number_format($inform_get_edit->totalsum,2);?></b></td>
                                        </tr>
                                    @endif
                                  <?php $ap = $inform_get_edit->number_bill_journal ?>
                                  @endif
                                  @endforeach



                                </tbody>
                            </table>
                        </div>
                        <div style="padding-bottom:50px;">
                            <center><button type="submit" class="btn btn-success">Okay ยืนยันการตรวจ</button></center>
                        </div>
                        {!! Form::close() !!}

                        <!--END table cotent -->
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



<!-- MODAL edit -->
@foreach ($inform_get_edits as $key => $inform_get_edit)
<div class="modal fade" id="modaledit">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
              <h4 class="modal-title" id="fontscontent2"><b>แก้ไขสมุดรายวันทั่วไป</b></h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

              <!-- Modal body -->
              <div class="modal-body">

                          {!! Form::open(['route' => ['journal_general.update'], 'method' => 'patch']) !!}

                          <input type="hidden" class="form-control" name="get_id" id="get_id_edit">

                          <div class="form-inline" style="margin: 10px 50px 0px 50px;">
                            <div class="row">
                              <label class="mb-2 mr-sm-2" id="fontslabel" for=""><b>สาขา :</b></label>
                              <select class="form-control mb-2 mr-sm-2" name="branchs" id="get_codebranch" required>
                                  @foreach($branchs as $branch)
                                      <option value="{{$branch->code_branch}}">{{$branch->name_branch}}</option>
                                  @endforeach
                              </select>

                              &nbsp;&nbsp;<label class="mb-2 mr-sm-2" for="modal-input-priceservice" id="fontslabel"><b>วันที่เอกสาร :</b></label>
                              <input type="date" autocomplete="off" class="form-control mb-2 mr-sm-2" name="datenow" id="datebill" required>
                            </div>
                          </div>
                          <br>

                          <div style="padding: 0px 30px 0px 30px;">
                            <div class="table-responsive">
                              <table class="table">
                                <thead class="thead-light" id="fontstable">
                                    <th width="20%" style="text-align: center;">รหัสบัญชี</th>
                                    <th width="15%" style="text-align: center;">เดบิต</th>
                                    <th width="15%" style="text-align: center;">เครดิต</th>
                                    <th width="30%" style="text-align: center;">คำอธิบายรายการย่อย</th>
                                    <th width="20%" style="text-align: center;">ชื่อ</th>
                                </thead>
                                <tbody>
                                    <tr>
                                      <td><select name="accounts" class="form-control mb-2 mr-sm-2" id="account" required>
                                            @foreach($accounttypes as $accounttype)
                                                <option value="{{$accounttype->id}}">{{$accounttype->accounttypeno}} - {{$accounttype->accounttypefull}}</option>
                                            @endforeach
                                          </select>
                                      </td>
                                      <td><input class="form-control mb-2 mr-sm-2" type="text" name="debits" id="debit" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');"/></td>
                                      <td><input class="form-control mb-2 mr-sm-2" type="text" name="credits" id="credit" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');"/></td>
                                      <td><textarea class="form-control mb-2 mr-sm-2" name="memos" id="list" required></textarea></td>
                                      <td><input class="form-control mb-2 mr-sm-2" type="text" name="names" id="name" required/></td>
                                    </tr>
                                </tbody>
                              </table>
                            </div>
                          </div>

              </div>
              <!-- Modal footer -->
              <div class="modal-footer">
                  <a href="{{route('payser')}}">
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
@endsection
