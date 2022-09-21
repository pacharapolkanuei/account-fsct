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
              <li class="breadcrumb-item active">รายงานเคลื่อนไหวลูกหนี้รายตัว</li>
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
                <fonts id="fontsheader">รายงานเคลื่อนไหวลูกหนี้รายตัว</fonts>
              </h3>
            </div>
          </div><!-- end card-->

          {!! Form::open(['route' => 'ap_list_filter', 'method' => 'post']) !!}
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
              <a href="{{url('ap_list')}}" class="btn btn-danger btn-md delete-confirm">RESET</a>
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
            <table class="table table-bordered" cellspacing="0" id="fontslabel" style="width : 70%;margin-left: auto;margin-right: auto;">
              <thead>
                <tr style="background-color:#aab6c2;color:white;">
                  <th style="vertical-align : middle;text-align:center;">วันที่</th>
                  <th style="vertical-align : middle;text-align:center;">เลขที่เอกสาร</th>
                  <th style="vertical-align : middle;text-align:center;">เพิ่มขึ้น</th>
                  <th style="vertical-align : middle;text-align:center;">ลดลง</th>
                  <th style="vertical-align : middle;text-align:center;">ยอดคงเหลือ</th
                </tr>
              </thead>
              <tbody>
                @foreach ($supplier_aps  as $key => $supplier_ap)
                  @if ($supplier_ap->name_supplier == $ap)
                    <tr>
                      <td>{{ $supplier_ap->date_po }}</td>
                      <td>{{ $supplier_ap->po_number_use }}</td>
                      <td>
                          <?php $keep_totalsum_inc = number_format($supplier_ap->totalsum,2,".",",");
                                echo $keep_totalsum_inc;
                          ?>
                          <?php $sumtotal_inc = $sumtotal_inc + $supplier_ap->totalsum;?>
                      </td>
                      <td></td>
                      <td>
                          <?php $keep_totalsum_inc_1 = number_format($supplier_ap->totalsum,2,".",",");
                                echo $keep_totalsum_inc_1;
                          ?>
                          <?php $sumtotal_inc1 = $sumtotal_inc1 + $supplier_ap->totalsum;?>
                      </td>
                    </tr>

                    <tr>
                      <td>{{ $supplier_ap->date_inform_po }}</td>
                      <td>{{ $supplier_ap->payser_number_use }}</td>
                      <td></td>
                      <td>
                          <?php $keep_totalsum_dec = number_format($supplier_ap->payout,2,".",",");
                                echo $keep_totalsum_dec;
                          ?>
                          <?php $sumtotal_dec = $sumtotal_dec + $supplier_ap->payout;?>
                      </td>
                      <td>
                          <?php $keep_totalsum_dec = number_format($supplier_ap->payout,2,".",",");
                                echo $keep_totalsum_dec;
                          ?>
                          <?php $sumtotal_dec1 = $sumtotal_dec1 + $supplier_ap->payout;?>
                      </td>
                    </tr>
                    @if ($key == count($supplier_aps)-1)
                        <tr>
                          <td></td>
                          <td></td>
                          <td><?php echo number_format($sumtotal_inc,2);?></td>
                          <td><?php echo number_format($sumtotal_dec,2);?></td>
                          <td>
                            <?php $calculate = $sumtotal_inc1 - $sumtotal_dec1;
                                  echo number_format($calculate,2);
                            ?>
                          </td>
                        </tr>
                    @endif
                    <?php $ap = $supplier_ap->name_supplier ?>
                  @else
                    @if ($key != 0)
                        <!-- ก่อนเปลี่ยนรายการเขียนปิดรายการก่อนหน้า -->
                        <tr>
                          <td></td>
                          <td></td>
                          <td><?php echo number_format($sumtotal_inc,2);?></td>
                          <td><?php echo number_format($sumtotal_dec,2);?></td>
                          <td>
                            <?php $calculate = $sumtotal_inc1 - $sumtotal_dec1;
                                  echo number_format($calculate,2);
                            ?>
                          </td>
                        </tr>
                        <?php $sumtotal_inc = 0;
                              $sumtotal_inc1 = 0;
                              $sumtotal_dec = 0;
                              $sumtotal_dec1 = 0;
                              $calculate = 0;
                        ?>
                    @endif
                    <?php $sumtotal_inc = 0;
                          $sumtotal_inc1 = 0;
                          $sumtotal_dec = 0;
                          $sumtotal_dec1 = 0;
                          $calculate = 0;
                    ?>
                    <tr style="border-top-style:solid;">
                      <!-- เขียน row แรก แต่ละรายการ -->
                      <td><b>{{ $supplier_ap->pre }} {{ $supplier_ap->name_supplier }}</b></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                    <tr>
                      <td><b>ยอดยกมา</b></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td> - </td>
                    </tr>

                      @if ($key == count($supplier_aps)-1)
                      <!-- เขียนสำหรับรายการสุดท้าย -->
                          <tr>
                            <td></td>
                            <td></td>
                            <td><?php echo number_format($sumtotal_inc,2);?></td>
                            <td><?php echo number_format($sumtotal_dec,2);?></td>
                            <td>
                              <?php $calculate = $sumtotal_inc1 - $sumtotal_dec1;
                                    echo number_format($calculate,2);
                              ?>
                            </td>
                          </tr>
                          <?php $sumtotal_inc = 0;
                                $sumtotal_inc1 = 0;
                                $sumtotal_dec = 0;
                                $sumtotal_dec1 = 0;
                                $calculate = 0;
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
