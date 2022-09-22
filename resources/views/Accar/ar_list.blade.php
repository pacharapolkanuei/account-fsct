@extends('index')
@section('content')

<?php
  use App\Api\Connectdb;
  use App\Api\Datetime;
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



<div class="content-page">
  <!-- Start content -->
  <div class="content">
    <div class="container-fluid">

      <div class="row">
        <div class="col-xl-12">
          <div class="breadcrumb-holder" id="fontscontent">
            <h1 class="float-left">Account - FSCT</h1>
            <ol class="breadcrumb float-right">
              <li class="breadcrumb-item">ลูกหนี้้การค้า</li>
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
          <?php
                    $connect1 = Connectdb::Databaseall();
                    $baseMain = $connect1['fsctmain'];
                    $baseAc1 = $connect1['fsctaccount'];
                    $sql = "SELECT  $baseAc1.initial.per,
                                    $baseMain.customers.name,
                                    $baseMain.customers.lastname,
                                    $baseMain.customers.customerid
                            FROM $baseMain.customers
                            INNER JOIN  $baseAc1.initial
                            ON $baseMain.customers.initial = $baseAc1.initial.id ";

                    $datas = DB::select($sql);

          ?>

          <form action="arlist_serch" method="post" id="myForm" files='true' >
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <center>
              <div class="col-sm-3">
                  <div class="input-group mb-6">
                      <div class="input-group-prepend">
                          <label id="fontslabel"><b>วันที่ : &nbsp;</b></label>
                      </div>
                      <input type='text' class="form-control" name="daterange" value="" autocomplete="off" />
                  </div>
              </div>
              <br>
              <div class="col-sm-3">
                  <div class="input-group mb-6">
                      <div class="input-group-prepend">
                          <label id="fontslabel"><b>ชื่อลูกหนี้ : &nbsp;</b></label>
                      </div>
                      <select name="customerid[]" class="form-control select2"  required>
                          <option value="">เลือกทั้งหมด</option>
                          <?php  foreach ($datas as $key => $value) { ?>
                              <option value="<?php echo $value->customerid; ?>"><?php echo $value->per; ?>&nbsp;&nbsp;<?php echo $value->name; ?>&nbsp;&nbsp; <?php echo $value->lastname; ?></option>
                          <?php } ?>
                      </select>
                  </div>
              </div>
              <br>
              <button type="submit" class="btn btn-primary btn-sm fontslabel">ค้นหา</button>
              <a href="{{url('ap_list')}}" class="btn btn-danger btn-md delete-confirm">RESET</a>
            </center>
          </form>


          <br>
          <br>
          <center>
            <?php  if(isset($query)){

                  // print_r($daterange);
                  $dateset = Datetime::convertStartToEnd($daterange);
                  $start = $dateset['start'];
                  $end = $dateset['end'];




             ?>

              <label id="fontslabel"><b>วันที่ <?php echo $start; ?>  ถึง <?php echo $end;?> </b></label>

          </center>
          <br>

            <table class="table table-bordered" cellspacing="0" id="fontslabel" style="width : 70%;margin-left: auto;margin-right: auto;">
              <thead>
                <tr style="background-color:#aab6c2;color:white;">
                  <th style="vertical-align : middle;text-align:center;">วันที่</th>
                  <th style="vertical-align : middle;text-align:center;">เลขที่เอกสาร</th>
                  <th style="vertical-align : middle;text-align:center;">สาขา</th>
                  <th style="vertical-align : middle;text-align:center;">เพิ่มขึ้น</th>
                  <th style="vertical-align : middle;text-align:center;">ลดลง</th>
                  <th style="vertical-align : middle;text-align:center;">ยอดคงเหลือ</th>
                </tr>
              </thead>
              <tbody>
              <?php
                $totalthis = 0;
                foreach ($customerid as $k => $v) {
                    $idcard = $v;

                    $sqlrent = "SELECT  $baseMain.bill_rent.date_out ,
                                        $baseMain.bill_rent.bill_rent ,
                                        $baseMain.bill_rent.branch_id,
                                        $baseMain.bill_rent.discount ,
                                        $baseMain.bill_rent.withhold ,
                                        $baseMain.bill_rent.type_pay ,
                                        $baseMain.bill_rent.vat,
                                        $baseMain.bill_rent.id as bill_rentid,
                                        sum($baseMain.bill_detail.total) as sumtotal

                            FROM $baseMain.bill_rent
                            INNER JOIN $baseMain.bill_detail
                            ON $baseMain.bill_rent.id = $baseMain.bill_detail.bill_rent
                            WHERE $baseMain.bill_rent.customer_id = '$idcard'
                            AND $baseMain.bill_rent.status = '3'
                            AND $baseMain.bill_rent.date_out BETWEEN '$start' AND '$end'
                            GROUP By  $baseMain.bill_rent.bill_rent ";

                    $datarent = DB::select($sqlrent);

                ?>
                  <?php foreach ($datarent as $a => $b) { ?>
                    <tr>
                      <td><?php echo $b->date_out; ?></td>
                      <td><?php echo $b->bill_rent; ?></td>
                      <td><?php echo $b->branch_id; ?></td>
                      <td>
                        <?php $sumtotal = $b->sumtotal;
                              $discount = $b->discount;
                              $withhold = $b->withhold;
                              $vat = $b->vat;
                              $discountmoney = $sumtotal * ($b->discount/100);
                              $sumtotalreal = $sumtotal - $discountmoney;
                              $showreal = $sumtotalreal + ($sumtotalreal*($vat/100)) - ($sumtotalreal*($withhold/100));
                              $totalthis = $totalthis + $showreal;
                              echo number_format($showreal,2);
                        ?>
                      </td>
                      <td>-</td>
                      <td><?php echo number_format($totalthis,2);?></td>
                    </tr>
                    <?php
                      ////////////// เงินสด
                        $bill_rentid = $b->bill_rentid;
                        $sqltax = "SELECT *   FROM $baseAc1.taxinvoice_abb WHERE $baseAc1.taxinvoice_abb.bill_rent = '$bill_rentid' AND  $baseAc1.taxinvoice_abb.status != '99' ";
                      $taxinvoiceabbdata = DB::select($sqltax);
                    if(!empty($taxinvoiceabbdata) && $b->type_pay == 1){?>
                    <tr>
                      <td><?php echo $taxinvoiceabbdata[0]->time; ?></td>
                      <td><?php echo $taxinvoiceabbdata[0]->number_taxinvoice; ?></td>
                      <td><?php echo $taxinvoiceabbdata[0]->branch_id; ?></td>
                      <td>-</td>
                      <td><?php echo number_format($taxinvoiceabbdata[0]->grandtotal,2); $totalthis = $totalthis - $taxinvoiceabbdata[0]->grandtotal; ?></td>
                      <td><?php echo number_format($totalthis,2);?></td>
                    </tr>
                  <?php }?>
                <?php } ?>
              <?php } $totalthis=0;?>





              
              </tbody>
            </table>

          <?php  } ?>




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
