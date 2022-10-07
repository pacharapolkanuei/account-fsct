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
                                        $baseMain.bill_rent.countrent,
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
                  <?php foreach ($datarent as $a => $b) {
                    $date_out = $b->date_out;
                    $billnumber = $b->bill_rent;
                    $branch_id = $b->branch_id;
                    $countrent = $b->countrent;
                    $bill_rentid = $b->bill_rentid;
                    $end_date =  date('Y-m-d', strtotime($date_out.' + '.$countrent.' days'));
                    $datenow = date('Y-m-d');
                    ?>
                    <tr>
                      <td><?php echo $b->date_out; ?>bbb</td>
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
                      ////////////// RA //////////////

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
                  <?php ////////////// END RA //////////////?>


                  <?php

                      //////////////  คืน คืนก่อนกำหนดแบบยังไม่ครบกำหนด
                      $sqlreturn = "SELECT  $baseMain.bill_return_head.time,
                                            $baseMain.bill_return_detail.bill_detail,
                                            $baseMain.bill_return_detail.amount,
                                            $baseMain.bill_detail.price,
                                            $baseMain.bill_return_head.numberrun
                                             FROM $baseMain.bill_return_head
                                             INNER JOIN $baseMain.bill_return_detail
                                             ON $baseMain.bill_return_head.id = $baseMain.bill_return_detail.return_head
                                             INNER JOIN $baseMain.bill_detail
                                             ON $baseMain.bill_return_detail.bill_detail = $baseMain.bill_detail.id
                                             WHERE $baseMain.bill_return_head.bill_rent = '$bill_rentid' ";
                    $billDatareturn = DB::select($sqlreturn);




                  ?>

                  <?php if(!empty($billDatareturn)&&($billDatareturn[0]->time < $end_date)){ ?>
                  <tr>
                    <td><?php echo $billDatareturn[0]->time; ?></td>
                    <td><?php echo $billDatareturn[0]->numberrun; ?></td>
                    <td><?php echo  $b->branch_id; ?></td>
                    <td>
                        <?php
                        $totalcn = 0;

                          // echo "//////";
                          $date1 = $billDatareturn[0]->time;
                          $date1 = date_create($date1);
                          $date2 = $end_date;
                          $date2 = date_create($date2);
                          $diff = date_diff($date1,$date2);
                          $datediff =  $diff->format("%a");
                          // echo "//////";
                            foreach ($billDatareturn as $c => $d) {
                               $totalcn = $totalcn + ($d->amount *  $d->price * $datediff);
                            }
                            echo number_format(($totalcn*1.07),2);
                             $totalthis = $totalthis + ($totalcn*1.07);
                        $totalcn = 0 ;
                        ?>
                    </td>
                    <td>-</td>
                    <td><?php echo number_format($totalthis,2);?></td>
                  </tr>
                <?php } ?>
                  <?php ////////////// END คืนก่อนกำหนดแบบยังไม่ครบกำหนด //////////////?>

                  <?php ////////////// เกินกำหนด //////////////?>
                <?php

                  if($datenow>$end_date){
                    $date3 = $end_date;
                    $date3 = date_create($date3);
                    $date4 = date('Y-m-d');
                    $date4 = date_create($date4);
                    $diffcon = date_diff($date3,$date4);
                    $datediffcon =  $diffcon->format("%a");
                ?>
                <tr>
                  <td><?php echo $end_date ; ?></td>
                  <td><?php echo $billnumber;  ?></td>
                  <td><?php echo $branch_id;  ?></td>
                  <td>
                      <?php

                      $sqlrentcon = "SELECT  $baseMain.bill_rent.date_out ,
                                         $baseMain.bill_rent.bill_rent ,
                                         $baseMain.bill_rent.branch_id,
                                         $baseMain.bill_rent.discount ,
                                         $baseMain.bill_rent.withhold ,
                                         $baseMain.bill_rent.type_pay ,
                                         $baseMain.bill_rent.vat,
                                         $baseMain.bill_rent.id as bill_rentid,
                                         $baseMain.bill_rent.countrent,
                                         $baseMain.bill_detail.price,
                                         $baseMain.bill_detail.amount,
                                         $baseMain.bill_detail.id as iddetail

                             FROM $baseMain.bill_rent
                             INNER JOIN $baseMain.bill_detail
                             ON $baseMain.bill_rent.id = $baseMain.bill_detail.bill_rent
                             WHERE $baseMain.bill_rent.id = '$bill_rentid'";

                     $datarentcon = DB::select($sqlrentcon);
                    $totalcon = 0;
                     // echo "<pre>";
                     if(!empty($billDatareturn)&&($billDatareturn[0]->time < $end_date)){

                           // echo "<br>";
                           // print_r($datarentcon);
                           // echo "<br>";
                           // print_r($billDatareturn);

                           foreach ($datarentcon as $g => $h) {
                                foreach ($billDatareturn as $i => $j) {
                                    if($h->iddetail == $j->bill_detail){


                                        $totalcon = $totalcon + ($h->amount - $j->amount) * $datediffcon * $h->price;
                                    }else{
                                        $totalcon = $totalcon + ($h->amount) * $datediffcon*$h->price;
                                    }

                                }
                           }
                                $sumtotal = $totalcon;
                                $discount = $datarentcon[0]->discount;
                                $withhold = $datarentcon[0]->withhold;
                                $vat = $datarentcon[0]->vat;
                                $discountmoney = $sumtotal * ($discount/100);
                                $sumtotalreal = $sumtotal - $discountmoney;
                                $showreal = $sumtotalreal + ($sumtotalreal*($vat/100)) - ($sumtotalreal*($withhold/100));
                                echo number_format($showreal,2);
                                $totalthis = $totalthis + $showreal;
                                $sumtotal = 0;
                                $showreal = 0;

                     }else{
                           foreach ($datarentcon as $k => $l) {
                              $totalcon = $totalcon + ($l->amount) * $datediffcon*$l->price;
                           }
                                 $sumtotal = $totalcon;
                                 $discount = $datarentcon[0]->discount;
                                 $withhold = $datarentcon[0]->withhold;
                                 $vat = $datarentcon[0]->vat;
                                 $discountmoney = $sumtotal * ($discount/100);
                                 $sumtotalreal = $sumtotal - $discountmoney;
                                 $showreal = $sumtotalreal + ($sumtotalreal*($vat/100)) - ($sumtotalreal*($withhold/100));
                                 echo number_format($showreal,2);
                                 $totalthis = $totalthis + $showreal;
                                 $sumtotal = 0;
                                 $showreal = 0;

                     }
                    $totalcon = 0;
                      ?>
                  </td>
                  <td>-</td>
                  <td><?php echo number_format($totalthis,2);?></td>
                </tr>
              <?php } ?>
                  <?php ////////////// END เกินกำหนด //////////////?>


                  <?php

                      //////////////  คืน หลังวันครบกำหนด
                      $sqlreturn = "SELECT  $baseMain.bill_return_head.time,
                                            $baseMain.bill_return_detail.bill_detail,
                                            $baseMain.bill_return_detail.amount,
                                            $baseMain.bill_detail.price,
                                            $baseMain.bill_return_head.numberrun
                                             FROM $baseMain.bill_return_head
                                             INNER JOIN $baseMain.bill_return_detail
                                             ON $baseMain.bill_return_head.id = $baseMain.bill_return_detail.return_head
                                             INNER JOIN $baseMain.bill_detail
                                             ON $baseMain.bill_return_detail.bill_detail = $baseMain.bill_detail.id
                                             WHERE $baseMain.bill_return_head.bill_rent = '$bill_rentid' ";
                    $billDatareturn = DB::select($sqlreturn);




                  ?>

                  <?php if(!empty($billDatareturn)&&($billDatareturn[0]->time > $end_date)){ ?>
                  <tr>
                    <td><?php echo $billDatareturn[0]->time; ?></td>
                    <td><?php echo $billDatareturn[0]->numberrun; ?></td>
                    <td><?php echo  $b->branch_id; ?></td>
                    <td>
                        <?php
                        $totalcncon = 0;
                        $date5 = $end_date;
                        $date5 = date_create($date5);
                        $date6 = date('Y-m-d');
                        $date6 = date_create($date6);
                        $diffcncon = date_diff($date5,$date6);
                        $datediffcncon =  $diffcncon->format("%a");

                            foreach ($billDatareturn as $m => $n) {
                               $totalcncon = $totalcncon + ($n->amount *  $n->price * $datediffcncon);
                            }
                            echo number_format(($totalcncon*1.07),2);
                             $totalthis = $totalthis + ($totalcncon*1.07);
                        $totalcn = 0 ;
                        ?>
                    </td>
                    <td>-</td>
                    <td><?php echo number_format($totalthis,2);?></td>
                  </tr>
                <?php } ?>
                  <?php ////////////// END หลังวันครบกำหนด //////////////?>



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
