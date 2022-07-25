@extends('index')
@section('content')
<!-- <link rel="stylesheet" href="{{asset('css/debt/debt.css')}}"> //! include css -->
<!-- js data table -->
<script type="text/javascript" src="https://unpkg.com/sweetalert2@7.0.6/dist/sweetalert2.all.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<!-- <script type="text/javascript" src={{ asset('js/accountjs/journal_general1.js') }}></script> -->
<script type="text/javascript" src={{ asset('js/accountjs/journal_general1.js') }}></script>
<link href="{{ asset('css/journal_debt/journal_general1.css') }}" rel="stylesheet" type="text/css" media="all">

<style media="screen">
  .project-tab {
    padding: 10% 2% 10% 2%;
    margin-top: -8%;
  }
  .project-tab #tabs{
    background: #007b5e;
    color: #eee;
  }
  .project-tab #tabs h6.section-title{
    color: #eee;
  }
  .project-tab #tabs .nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active {
    color: #0062cc;
    background-color: transparent;
    border-color: transparent transparent #f3f3f3;
    border-bottom: 3px solid !important;
    font-size: 16px;
    font-weight: bold;
  }
  .project-tab .nav-link {
    border: 1px solid transparent;
    border-top-left-radius: .25rem;
    border-top-right-radius: .25rem;
    color: #0062cc;
    font-size: 16px;
    font-weight: 600;
  }
  .project-tab .nav-link:hover {
    border: none;
  }
  .project-tab thead{
    background: #f3f3f3;
    color: #333;
  }
  .project-tab a{
    text-decoration: none;
    color: #333;
    font-weight: 600;
  }
</style>

<script language="JavaScript">
  function toggle1(source) {
    checkboxes = document.getElementsByName('id_journal_5[]');
    for(var i=0, n=checkboxes.length;i<1000;i++) {
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
                            <li class="breadcrumb-item active">สมุดรายวันทั่วไป (กรณีคืนของ)</li>
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
                                <fonts id="fontsheader">สมุดรายวันทั่วไป (กรณีคืนของ)</fonts>
                            </h3><br><br>

                            <!-- date range -->
                            {!! Form::open(['route' => 'journal_generalfilter4', 'method' => 'post']) !!}
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
                                &nbsp;&nbsp;&nbsp;<center><button type="submit" class="btn btn-primary btn-sm fontslabel">ค้นหา</button></center>&nbsp;
                                <center><a class="btn btn-info btn-sm fontslabel" href="{{url('journal_general2_returnengine')}}">ดูทั้งหมด</a></center>&nbsp;
                            </div>
                            {!! Form::close() !!}
                            <!-- date range -->
                        </div>

                                            <br>
                                            {!! Form::open(['route' => 'confirm_journal_general4', 'method' => 'post']) !!}
                                            <table class="table table-bordered" cellspacing="0" id="fontsjournal">
                                              <thead>
                                                  <tr style="background-color:#aab6c2;color:white;">
                                                      <th scope="col"><label class="con" style="margin: -25px -35px 0px 0px;">
                                                          <input type="checkbox" onClick="toggle1(this)">
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
                                                @foreach ($databillengines  as $key => $databillengine)
                                                  @if ($databillengine->numberrun == $en)
                                                  <!-- ถ้า ap เหมือนกันเขียนแค่ list -->
                                                    <tr>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td>เครื่องมือให้เช่า {{$databillengine->names}}</td>
                                                        <td>ลูกค้า {{$databillengine->name}} {{$databillengine->lastname}} คืนเครื่องมือให้เช่า</td>
                                                        <td>151900</td>
                                                        <td style="text-align:left;">เครื่องมือให้เช่า {{$databillengine->names}}</td>
                                                        <td></td>
                                                        <td>{{$databillengine->last_total}} <?php $sumdbthis = $sumdbthis + $databillengine->last_total;?></td>
                                                        <td></td>
                                                    </tr>

                                                    <tr>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td>151901</td>
                                                        <td style="text-align:center;">เครื่องมือให้เช่าลูกค้า {{$databillengine->name}} {{$databillengine->lastname}}</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td>{{$databillengine->last_total}} <?php  $sumcrthis = $sumcrthis + $databillengine->last_total; ?></td>
                                                    </tr>

                                                    @if ($key == count($databillengines)-1)
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
                                                            <td><b><?php echo number_format($sumdbthis,2);?></b></td>
                                                            <td><b><?php echo number_format($sumcrthis,2);?></b></td>
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
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td><b><?php echo number_format($sumdbthis,2);?></b></td>
                                                            <td><b><?php echo number_format($sumcrthis,2);?></b></td>
                                                        </tr>
                                                        <?php $sumdbthis = 0;
                                                              $sumcrthis = 0;
                                                        ?>
                                                    @endif
                                                    <?php $sumdbthis = 0;
                                                          $sumcrthis = 0;
                                                    ?>
                                                  <tr style="border-top-style:solid;">
                                                      <!-- เขียน row แรก แต่ละรายการ -->
                                                      <td>
                                                          @if($databillengine->accept == 0)
                                                          <label class="con">
                                                          <input type="checkbox" name="id_journal_5[]" value="{{$databillengine->id_billenginereturn}}">
                                                              <span class="checkmark"></span>
                                                          </label>
                                                          @else
                                                          <i class="fa fa-check" style="color:green;font-size:20px;"></i>
                                                          @endif
                                                      </td>
                                                      <td>{{$databillengine->time}}</td>
                                                      <td>{{$databillengine->numberrun}}</td>
                                                      <td>เครื่องมือให้เช่า {{$databillengine->names}}</td>
                                                      <td>ลูกค้า {{$databillengine->name}} {{$databillengine->lastname}} คืนเครื่องมือให้เช่า</td>
                                                      <td>151900</td>
                                                      <td style="text-align:left;">เครื่องมือให้เช่า {{$databillengine->names}}</td>
                                                      <td>{{$databillengine->branch_id}}</td>
                                                      <td>{{$databillengine->last_total}} <?php  $sumdbthis = $sumdbthis + $databillengine->last_total;?></td>
                                                      <td></td>
                                                  </tr>

                                                  <tr>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td>151901</td>
                                                      <td style="text-align:center;">เครื่องมือให้เช่าลูกค้า {{$databillengine->name}} {{$databillengine->lastname}}</td>
                                                      <td></td>
                                                      <td></td>
                                                      <td>{{$databillengine->last_total}} <?php  $sumcrthis = $sumcrthis + $databillengine->last_total; ?></td>
                                                  </tr>

                                                    @if ($key == count($databillengines)-1)
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
                                                            <td><b><?php echo number_format($sumdbthis,2);?></b></td>
                                                            <td><b><?php echo number_format($sumcrthis,2);?></b></td>
                                                        </tr>
                                                        <?php $sumdbthis = 0;
                                                              $sumcrthis = 0;
                                                        ?>
                                                    @endif

                                                  <?php $en = $databillengine->numberrun ?>
                                                  @endif
                                                @endforeach
                                              </tbody>
                                            </table>

                                            <div style="padding-bottom:50px;">
                                                <center><button type="submit" class="btn btn-success">Okay ยืนยันการตรวจ</button></center>
                                            </div>
                                            {!! Form::close() !!}



                        </div>

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
