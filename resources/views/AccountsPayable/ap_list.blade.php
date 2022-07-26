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

          <?php if (isset($list)): ?>
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
                <?php
                $sumgrandtotal = 0;
                $sumdebit = 0;
                $sumcredit = 0;
                ?>
                @foreach ($list as $name_supplier => $item)
                  <tr>
                    <td colspan="5"><b>{{ $name_supplier }}</b></td>
                  </tr>
                  @foreach ($item as $supplier_ap)
                    @if ($supplier_ap->status_head_check === 2)
                      <tr>
                        <td>{{ $supplier_ap->date_po }}</td>
                        <td>{{ $supplier_ap->po_number_use }}</td>
                        <td>
                            <?php
                                  $keep_totalsum_inc = number_format($supplier_ap->totalsum,2,".",",");
                                  echo $keep_totalsum_inc;
                            ?>

                        </td>
                        <td></td>
                        <td>
                            <?php
                                  // $keep_totalsum_inc_1 = number_format($supplier_ap->totalsum,2,".",",");
                                  // echo $keep_totalsum_inc_1;
                                  if($supplier_ap->totalsum != 0){
                                    echo number_format ((($supplier_ap->totalsum) + $sumgrandtotal),2);
                                    $sumgrandtotal = (($supplier_ap->totalsum) + $sumgrandtotal);
                                  }
                            ?>

                        </td>
                      </tr>
                    @else
                      <tr>
                        <td>{{ $supplier_ap->date_po }}</td>
                        <td>{{ $supplier_ap->po_number_use }}</td>
                        <td>
                            <?php $keep_totalsum_inc = number_format($supplier_ap->totalsum,2,".",",");
                                  echo $keep_totalsum_inc;
                            ?>

                        </td>
                        <td></td>
                        <td>
                            <?php $keep_totalsum_inc_1 = number_format($supplier_ap->totalsum,2,".",",");
                                  echo $keep_totalsum_inc_1;
                            ?>

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

                        </td>
                        <td>
                            <?php $keep_totalsum_dec = number_format($supplier_ap->payout,2,".",",");
                                  echo $keep_totalsum_dec;
                            ?>

                        </td>
                      </tr>
                    @endif
                  @endforeach
                  <tr>
                    <td colspan="2" style="vertical-align : middle;text-align:right;"><b>รวมทั้งสิ้น</b></td>
                    <td></td>
                    <td></td>
                    <td></td>
                  </tr>
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
