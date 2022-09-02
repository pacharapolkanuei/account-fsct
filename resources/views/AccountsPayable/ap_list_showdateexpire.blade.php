<?php

use  App\Api\Connectdb;
use  App\Api\Accountcenter;
use  App\Api\Maincenter;
use  App\Api\Vendorcenter;
use  App\Api\DateTime;

?>

@extends('index')
@section('content')

<?php
  $level_id = Session::get('level_id');
  // echo $level_id;
?>

<script type="text/javascript" src="https://unpkg.com/sweetalert2@7.0.6/dist/sweetalert2.all.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
@if (Session::has('sweetalert.json'))
<script>
swal({!!Session::pull('sweetalert.json')!!});
</script>
@endif

<style media="screen">
.select2-container .select2-selection--single{
  height:40px !important;
}
.select2-container--default .select2-selection--single{
  border: 1px solid #ccc !important;
  border-radius: 0px !important;
}
</style>

<style media="screen">
  tr.group,
  tr.group:hover {
    background-color: #ddd !important;
  }
</style>
<script type="text/javascript">
  $(function() {
      $('input[name="daterange"]').daterangepicker();
  });
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
              <li class="breadcrumb-item">เจ้าหนี้การค้า</li>
              <li class="breadcrumb-item active">รายงานวิเคราะห์อายุหนี้ แยกตามลูกหนี้</li>
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
                <fonts id="fontsheader">รายงานวิเคราะห์อายุหนี้ แยกตามลูกหนี้</fonts>
              </h3>
            </div>
          </div><!-- end card-->

          {!! Form::open(['route' => 'ap_list_showdateexpire_filter', 'method' => 'post']) !!}
            <center>
              <div class="col-sm-3">
                  <div class="input-group mb-6">
                      <div class="input-group-prepend">
                          <label id="fontslabel"><b>วันที่ : &nbsp;</b></label>
                      </div>
                      <input type='text' class="form-control" name="daterange" value="" autocomplete="off" />
                  </div>
              </div>
              <button type="submit" class="btn btn-primary btn-sm fontslabel">ค้นหา</button>
              <a href="{{url('ap_list_showdateexpire')}}" class="btn btn-danger btn-md delete-confirm">RESET</a>
            </center>
          {!! Form::close() !!}

          <br>
          <br>
          <center>
            <?php if (isset($start) && isset($end)): ?>
              <label id="fontslabel"><b>วันที่ <?php echo $start ?> ถึง <?php echo $end ?></b></label>
            <?php endif; ?>
          </center>
          <br>

          <?php if (isset($supplier_aps)): ?>
            <table class="table table-bordered" cellspacing="0" id="fontslabel" style="margin-left: auto;margin-right: auto;">
              <thead>
                <tr style="background-color:#aab6c2;color:white;">
                  <th rowspan="2" style="vertical-align : middle;text-align:center;">รหัส</th>
                  <th rowspan="2" style="vertical-align : middle;text-align:center;">ชื่อลูกหนี้</th>
                  <th rowspan="2" style="vertical-align : middle;text-align:center;">เครดิต (วัน)</th>
                  <th rowspan="2" style="vertical-align : middle;text-align:center;">ยอดคงค้าง</th>
                  <th colspan="4" style="vertical-align : middle;text-align:center;">จะครบกำหนด</th>
                  <th colspan="4" style="vertical-align : middle;text-align:center;">เกินกำหนด</th>
                  <th rowspan="2" style="vertical-align : middle;text-align:center;">รวมยอดหนี้</th>
                </tr>
                <tr>
                  <th scope="col" style="vertical-align : middle;text-align:center;">ภายใน 15 วัน</th>
                  <th scope="col" style="vertical-align : middle;text-align:center;">ภายใน 30 วัน</th>
                  <th scope="col" style="vertical-align : middle;text-align:center;">ภายใน 60 วัน</th>
                  <th scope="col" style="vertical-align : middle;text-align:center;">เกิน 60 วัน</th>
                  <th scope="col" style="vertical-align : middle;text-align:center;">1-7 วัน</th>
                  <th scope="col" style="vertical-align : middle;text-align:center;">8-15 วัน</th>
                  <th scope="col" style="vertical-align : middle;text-align:center;">16-30 วัน</th>
                  <th scope="col" style="vertical-align : middle;text-align:center;">เกิน 30 วัน</th>
                </tr>
              </thead>
              <tbody style="vertical-align : middle;text-align:center;">
                @foreach ($supplier_aps  as $key => $supplier_ap)
                  @if ($supplier_ap->name_supplier == $ap)
                    <tr>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td>
                        <?php $keep_totalsum = number_format($supplier_ap->totalsum,2,".",",");
                              echo $keep_totalsum;
                        ?>
                        <?php $sumtotalthis = $sumtotalthis + $supplier_ap->totalsum;?>
                      </td>
                      <td>
                        <?php if ( $number_days = (strtotime($end) - strtotime($supplier_ap->date_to_cal))/(60 * 60 * 24) > 16 && $number_days = (strtotime($end) - strtotime($supplier_ap->date_to_cal))/(60 * 60 * 24) <= 30 && $supplier_ap->day_tocal == 30): ?>
                          <?php $show_total_for_day = number_format($supplier_ap->totalsum,2,".",",");
                                echo $show_total_for_day;
                          ?>
                        <?php endif; ?>
                        <?php if ( $number_days = (strtotime($end) - strtotime($supplier_ap->date_to_cal))/(60 * 60 * 24) > 7 && $number_days = (strtotime($end) - strtotime($supplier_ap->date_to_cal))/(60 * 60 * 24) <= 15 && $supplier_ap->day_tocal == 15): ?>
                          <?php $show_total_for_day = number_format($supplier_ap->totalsum,2,".",",");
                                echo $show_total_for_day;
                          ?>
                        <?php endif; ?>
                        <?php if ( $number_days = (strtotime($end) - strtotime($supplier_ap->date_to_cal))/(60 * 60 * 24) >= 1 && $number_days = (strtotime($end) - strtotime($supplier_ap->date_to_cal))/(60 * 60 * 24) <= 7 && $supplier_ap->day_tocal == 7): ?>
                          <?php $show_total_for_day = number_format($supplier_ap->totalsum,2,".",",");
                                echo $show_total_for_day;
                          ?>
                        <?php endif; ?>
                      </td>
                      <td>
                        <?php if ( $number_days = (strtotime($end) - strtotime($supplier_ap->date_to_cal))/(60 * 60 * 24) <= 15 && $supplier_ap->day_tocal == 30): ?>
                          <?php $show_total_for_day = number_format($supplier_ap->totalsum,2,".",",");
                                echo $show_total_for_day;
                          ?>
                        <?php endif; ?>
                      </td>
                      <td></td>
                      <td>
                        <?php if ($supplier_ap->day_tocal == 0): ?>
                          <?php $show_total_for_day = number_format($supplier_ap->totalsum,2,".",",");
                                echo $show_total_for_day;
                          ?>
                        <?php endif; ?>
                      </td>
                      <td>
                        <?php if ( $number_days = (strtotime($end) - strtotime($supplier_ap->date_to_cal))/(60 * 60 * 24) > 30 && $number_days = (strtotime($end) - strtotime($supplier_ap->date_to_cal))/(60 * 60 * 24) <= 37 && $supplier_ap->day_tocal != 0): ?>
                          <?php $show_total_for_day = number_format($supplier_ap->totalsum,2,".",",");
                                echo $show_total_for_day;
                          ?>
                        <?php endif; ?>
                      </td>
                      <td>
                        <?php if ( $number_days = (strtotime($end) - strtotime($supplier_ap->date_to_cal))/(60 * 60 * 24) > 37 && $number_days = (strtotime($end) - strtotime($supplier_ap->date_to_cal))/(60 * 60 * 24) <= 45 && $supplier_ap->day_tocal != 0): ?>
                          <?php $show_total_for_day = number_format($supplier_ap->totalsum,2,".",",");
                                echo $show_total_for_day;
                          ?>
                        <?php endif; ?>
                      </td>
                      <td>
                        <?php if ( $number_days = (strtotime($end) - strtotime($supplier_ap->date_to_cal))/(60 * 60 * 24) > 45 && $number_days = (strtotime($end) - strtotime($supplier_ap->date_to_cal))/(60 * 60 * 24) <= 60 && $supplier_ap->day_tocal != 0): ?>
                          <?php $show_total_for_day = number_format($supplier_ap->totalsum,2,".",",");
                                echo $show_total_for_day;
                          ?>
                        <?php endif; ?>
                      </td>
                      <td>
                        <?php if ( $number_days = (strtotime($end) - strtotime($supplier_ap->date_to_cal))/(60 * 60 * 24) > 60 && $supplier_ap->day_tocal != 0): ?>
                          <?php $show_total_for_day = number_format($supplier_ap->totalsum,2,".",",");
                                echo $show_total_for_day;
                          ?>
                        <?php endif; ?>
                      </td>
                      <td>
                        <?php $keep_totalsum1 = number_format($supplier_ap->totalsum,2,".",",");
                              echo $keep_totalsum1;
                        ?>
                        <?php $sumtotalthis1 = $sumtotalthis1 + $supplier_ap->totalsum;?>
                      </td>
                    </tr>
                    @if ($key == count($supplier_aps)-1)
                        <tr>
                          <th colspan="3" ><b>รวมทั้งสิ้น</b></th>
                          <td><?php echo number_format($sumtotalthis,2);?></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td><?php echo number_format($sumtotalthis1,2);?></td>
                        </tr>
                    @endif
                  @else
                    @if ($key != 0)
                        <!-- ก่อนเปลี่ยนรายการเขียนปิดรายการก่อนหน้า -->
                        <tr>
                          <th colspan="3" ><b>รวมทั้งสิ้น</b></th>
                          <td><?php echo number_format($sumtotalthis,2);?></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td><?php echo number_format($sumtotalthis1,2);?></td>
                        </tr>
                        <?php $sumtotalthis = 0;
                              $sumtotalthis1 = 0;
                        ?>
                    @endif
                    <?php $sumtotalthis = 0;
                          $sumtotalthis1 = 0;
                    ?>
                    <tr style="border-top-style:solid;">
                      <!-- เขียน row แรก แต่ละรายการ -->
                      <td>{{ $supplier_ap->codecreditor }}</td>
                      <td>{{ $supplier_ap->pre }} {{ $supplier_ap->name_supplier }}</td>
                      <td>{{ $supplier_ap->day_tocal }}</td>
                      <td>
                        <?php $keep_totalsum = number_format($supplier_ap->totalsum,2,".",",");
                              echo $keep_totalsum;
                        ?>
                        <?php $sumtotalthis = $sumtotalthis + $supplier_ap->totalsum;?>
                      </td>
                      <td>
                        <?php if ( $number_days = (strtotime($end) - strtotime($supplier_ap->date_to_cal))/(60 * 60 * 24) > 16 && $number_days = (strtotime($end) - strtotime($supplier_ap->date_to_cal))/(60 * 60 * 24) <= 30 && $supplier_ap->day_tocal == 30): ?>
                          <?php $show_total_for_day = number_format($supplier_ap->totalsum,2,".",",");
                                echo $show_total_for_day;
                          ?>
                        <?php endif; ?>
                        <?php if ( $number_days = (strtotime($end) - strtotime($supplier_ap->date_to_cal))/(60 * 60 * 24) > 7 && $number_days = (strtotime($end) - strtotime($supplier_ap->date_to_cal))/(60 * 60 * 24) <= 15 && $supplier_ap->day_tocal == 15): ?>
                          <?php $show_total_for_day = number_format($supplier_ap->totalsum,2,".",",");
                                echo $show_total_for_day;
                          ?>
                        <?php endif; ?>
                        <?php if ( $number_days = (strtotime($end) - strtotime($supplier_ap->date_to_cal))/(60 * 60 * 24) >= 1 && $number_days = (strtotime($end) - strtotime($supplier_ap->date_to_cal))/(60 * 60 * 24) <= 7 && $supplier_ap->day_tocal == 7): ?>
                          <?php $show_total_for_day = number_format($supplier_ap->totalsum,2,".",",");
                                echo $show_total_for_day;
                          ?>
                        <?php endif; ?>
                      </td>
                      <td>
                        <?php if ( $number_days = (strtotime($end) - strtotime($supplier_ap->date_to_cal))/(60 * 60 * 24) <= 15 && $supplier_ap->day_tocal == 30): ?>
                          <?php $show_total_for_day = number_format($supplier_ap->totalsum,2,".",",");
                                echo $show_total_for_day;
                          ?>
                        <?php endif; ?>
                      </td>
                      <td></td>
                      <td>
                        <?php if ($supplier_ap->day_tocal == 0): ?>
                          <?php $show_total_for_day = number_format($supplier_ap->totalsum,2,".",",");
                                echo $show_total_for_day;
                          ?>
                        <?php endif; ?>
                      </td>
                      <td>
                        <?php if ( $number_days = (strtotime($end) - strtotime($supplier_ap->date_to_cal))/(60 * 60 * 24) > 30 && $number_days = (strtotime($end) - strtotime($supplier_ap->date_to_cal))/(60 * 60 * 24) <= 37 && $supplier_ap->day_tocal != 0): ?>
                          <?php $show_total_for_day = number_format($supplier_ap->totalsum,2,".",",");
                                echo $show_total_for_day;
                          ?>
                        <?php endif; ?>
                      </td>
                      <td>
                        <?php if ( $number_days = (strtotime($end) - strtotime($supplier_ap->date_to_cal))/(60 * 60 * 24) > 37 && $number_days = (strtotime($end) - strtotime($supplier_ap->date_to_cal))/(60 * 60 * 24) <= 45 && $supplier_ap->day_tocal != 0): ?>
                          <?php $show_total_for_day = number_format($supplier_ap->totalsum,2,".",",");
                                echo $show_total_for_day;
                          ?>
                        <?php endif; ?>
                      </td>
                      <td>
                        <?php if ( $number_days = (strtotime($end) - strtotime($supplier_ap->date_to_cal))/(60 * 60 * 24) > 45 && $number_days = (strtotime($end) - strtotime($supplier_ap->date_to_cal))/(60 * 60 * 24) <= 60 && $supplier_ap->day_tocal != 0): ?>
                          <?php $show_total_for_day = number_format($supplier_ap->totalsum,2,".",",");
                                echo $show_total_for_day;
                          ?>
                        <?php endif; ?>
                      </td>
                      <td>
                        <?php if ( $number_days = (strtotime($end) - strtotime($supplier_ap->date_to_cal))/(60 * 60 * 24) > 60 && $supplier_ap->day_tocal != 0): ?>
                          <?php $show_total_for_day = number_format($supplier_ap->totalsum,2,".",",");
                                echo $show_total_for_day;
                          ?>
                        <?php endif; ?>
                      </td>
                      <td>
                        <?php $keep_totalsum1 = number_format($supplier_ap->totalsum,2,".",",");
                              echo $keep_totalsum1;
                        ?>
                        <?php $sumtotalthis1 = $sumtotalthis1 + $supplier_ap->totalsum;?>
                      </td>
                    </tr>

                      @if ($key == count($supplier_aps)-1)
                      <!-- เขียนสำหรับรายการสุดท้าย -->
                          <tr>
                            <th colspan="3" ><b>รวมทั้งสิ้น</b></th>
                            <td><?php echo number_format($sumtotalthis,2);?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><?php echo number_format($sumtotalthis1,2);?></td>
                          </tr>
                          <?php $sumtotalthis = 0;
                                $sumtotalthis1 = 0;
                          ?>
                      @endif
                  <?php $ap = $supplier_ap->name_supplier ?>
                  @endif
                @endforeach
              </tbody>
            </table>

          <?php endif; ?>




        </div>
      </div>
      <!-- end row -->
    </div>
    <!-- END container-fluid -->
  </div>
  <!-- END content -->
</div>
<!-- END content-page -->
<!-- END main -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script type="text/javascript" src = 'js/accountjs/buysteel.js'></script>
@endsection
