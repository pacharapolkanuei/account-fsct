@extends('index')
@section('content')
<!-- <link rel="stylesheet" href="{{asset('css/debt/debt.css')}}"> //! include css -->
<!-- js data table -->
<script type="text/javascript" src="https://unpkg.com/sweetalert2@7.0.6/dist/sweetalert2.all.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<!-- <script type="text/javascript" src={{ asset('js/accountjs/journal_general1.js') }}></script> -->
<link href="{{ asset('css/journal_debt/journal_debt.css') }}" rel="stylesheet" type="text/css" media="all">

<script language="JavaScript">
  function toggle(source) {
    checkboxes = document.getElementsByName('check_list[]');
    for(var i=0, n=checkboxes.length;i<50;i++) {
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
                            <li class="breadcrumb-item active">สมุดรายวันทั่วไป (กรณีสินค้าสูญหาย)</li>
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
                                <fonts id="fontsheader">สมุดรายวันทั่วไป (กรณีสินค้าสูญหาย)</fonts>
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
                                            <option disabled selected>เลือกสาขา</option>
                                            @foreach ($branchs as $key => $branch)
                                            <option value="{{$branch->code_branch}}">{{$branch->name_branch}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                <button type="submit" class="btn btn-primary btn-sm fontslabel">ค้นหา</button>
                                <a class="btn btn-info btn-sm fontslabel" href="{{url('journal_general')}}">ดูทั้งหมด</a>
                                </div>
                            </div>
                            {!! Form::close() !!}
                            <!-- date range -->
                        </div>


                        {!! Form::open(['route' => 'confirm_journal_general5', 'method' => 'post']) !!}
                        <table class="table table-bordered" cellspacing="0" id="fontsjournal">
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
                            @foreach ($databills  as $key => $databill)
                              @if ($databill->bill_no == $ap)
                              <!-- ถ้า ap เหมือนกันเขียนแค่ list -->
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>512900</td>
                                    <td style="text-align:left;">สินค้าสูญหาย</td>
                                    <td></td>
                                    <td>{{$databill->grandtotal}}</td>
                                    <td></td>
                                </tr>
                                <?php  ?>

                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>151900</td>
                                    <td style="text-align:center;">เครื่องมือให้เช่า {{$databill->names}}</td>
                                    <td></td>
                                    <td></td>
                                    <td>{{$databill->totaloss}}</td>
                                </tr>
                                <?php ?>
                                <?php $ap = $databill->bill_no ?>

                                @if ($key == count($databills)-1)
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
                                        <td><b>5555
                                        </b></td>
                                        <td><b>1111
                                        </b></td>
                                    </tr>
                                @endif

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
                                        <td>151900</td>
                                        <td style="text-align:center;">เครื่องมือให้เช่า {{$databills[$key-1]->names}}</td>
                                        <td></td>
                                        <td></td>
                                        <td>{{$databill->totaloss}}</td>
                                    </tr>

                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td><b>5555
                                        </b></td>
                                        <td><b>1111
                                        </b></td>
                                    </tr>
                                @endif

                              <?php //$sum_tot_Price1 = 0; ?>
                              <?php //$sum_tot_Price_credit1 = 0; ?>
                              <tr style="border-top-style:solid;">
                                  <!-- เขียน row แรก แต่ละรายการ -->
                                  <td>
                                      @if($databill->accept == 0)
                                      <label class="con">
                                      <input type="checkbox" name="number_bill_rents[]" value="{{$databill->bill_no}}">
                                          <span class="checkmark"></span>
                                      </label>

                                      @else
                                      <i class="fa fa-check" style="color:green;font-size:20px;"></i>
                                      @endif
                                  </td>
                                  <td>{{$databill->date_req}}</td>
                                  <td>{{$databill->bill_no}}</td>
                                  <td></td>
                                  <td></td>
                                  <td>512900</td>
                                  <td style="text-align:left;">สินค้าสูญหาย</td>
                                  <td>{{$databill->branch_id}}</td>
                                  <td>{{$databill->grandtotal}}</td>
                                  <td></td>
                              </tr>
                              <?php  ?>
                              <?php  ?>

                                @if ($key == count($databills)-1)
                                <!-- เขียนสำหรับรายการสุดท้าย -->
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>151900</td>
                                        <td style="text-align:center;">เครื่องมือให้เช่า {{$databill->names}}</td>
                                        <td></td>
                                        <td></td>
                                        <td>{{$databill->totaloss}}</td>
                                    </tr>
                                    <?php  ?>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td><b>1111d
                                        </b></td>
                                        <td><b>2222e
                                        </b></td>
                                    </tr>
                                @endif

                              <?php $ap = $databill->bill_no ?>
                              @endif
                            @endforeach
                          </tbody>
                        </table>
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
@endsection
