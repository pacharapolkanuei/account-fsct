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
                              <form action="searchassetlistsale" method="post" id="myForm" files='true' >
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
                                    <div class="col-sm-1">
                                        <div class="input-group mb-6">
                                            <label id="fontslabel"><b>สินค้า : &nbsp;</b></label>

                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="input-group mb-6">
                                            <?php
                                                  $connect1 = Connectdb::Databaseall();
                                                  $baseMain = $connect1['fsctmain'];
                                                  $sql = "SELECT $baseMain.material.*
                                                                  FROM $baseMain.material
                                                                  WHERE $baseMain.material.status = '1' ";
                                                  $getdatamaterial = DB::select($sql);

                                            ?>
                                            <select class="form-control select2" name="material_id" id="material_id">
                                              <?php  foreach ($getdatamaterial as $k => $v) { ?>
                                                <option value="<?php echo $v->id; ?>"><?php  echo $v->name; ?></option>
                                              <?php } ?>
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
                    </div>
      			<!-- END container-fluid -->
      		    </div>
      		<!-- END content -->


          <!-- Tabs -->
          <?php

          if(!empty($start)){
            // print_r($branchselct);
            $yearselect = substr($start,0,4);
            $datefirst = $yearselect.'-01-01';
            echo "<font color='red'>งวดบัญชีก่อน :".($start)."</font>";
            echo "<font color='blue'>    งวดบัญชีปัจจบัน :".($end)."</font>";

            $sqlmselect = "SELECT $baseMain.material.*
                            FROM $baseMain.material
                            WHERE $baseMain.material.status = '1'
                            AND $baseMain.material.id = '$material_id' ";
            $getdatamselect = DB::select($sqlmselect);

            $yearnow = date('Y');

            $connect1 = Connectdb::Databaseall();
            $baseAc1 = $connect1['fsctaccount'];
            $baseMain = $connect1['fsctmain'];

            $arrdataset = [];

            ///////////////////  RL  ///////////////////
            $sqlrl = "SELECT $baseAc1.taxinvoice_loss_abb.*,
                                  $baseMain.bill_detail.material_id,
                                  $baseMain.material.name,
                                  $baseMain.bill_detail.status,
                                  $baseMain.bill_rent.id as idrent,
                                  $baseMain.bill_detail.id as iddetail,
                                  $baseMain.bill_detail.amount as amountdetail,
                                  $baseMain.bill_detail.loss as priceunitrl
                            FROM $baseAc1.taxinvoice_loss_abb
                            INNER JOIN $baseMain.bill_rent
                            ON $baseAc1.taxinvoice_loss_abb.bill_rent = $baseMain.bill_rent.id
                            INNER JOIN $baseMain.bill_detail
                            ON $baseMain.bill_rent.id =  $baseMain.bill_detail.bill_rent
                            INNER JOIN $baseMain.material
                            ON $baseMain.material.id = $baseMain.bill_detail.material_id
                            WHERE $baseAc1.taxinvoice_loss_abb.status IN (1,98)
                            AND $baseAc1.taxinvoice_loss_abb.time BETWEEN '$start 00:00:00' AND '$end 23:59:59'
                            AND $baseAc1.taxinvoice_loss_abb.branch_id = '$branchselct'
                            AND $baseMain.bill_detail.status = '4'
                            AND $baseMain.bill_detail.material_id = '$material_id'";
              $getdatarl = DB::select($sqlrl);

              // print_r($getdatarl);
              ///////////////////  RB  ///////////////////
              $i = 0;
              foreach ($getdatarl as $c => $d) {
                         $idrent = $d->idrent;
                         $bill_detail = $d->iddetail;

                      $sqlrb =  "SELECT sum($baseMain.bill_return_detail.amount) as sumreturnamount
                                    FROM $baseMain.bill_return_head
                                    INNER JOIN $baseMain.bill_return_detail
                                    ON $baseMain.bill_return_head.id = $baseMain.bill_return_detail.return_head
                                    WHERE  $baseMain.bill_return_head.bill_rent = '$idrent'
                                    AND $baseMain.bill_return_detail.bill_detail = '$bill_detail'";
                      $getdatarb = DB::select($sqlrb);
                      // print_r($getdatarb);
                      $amountthis = 0;

                      if(!empty($getdatarb)){
                          $amountthis = $d->amountdetail - $getdatarb[0]->sumreturnamount;
                      }else{
                          $amountthis = $d->amountdetail - 0;
                      }
                      // echo $amountthis;
                      // echo "<br>";
                      $arrdataset[$i]['date']=$d->time;//วันที่ขาย
                      $arrdataset[$i]['taxshow']=$d->number_taxinvoice;//รหัสบิล
                      $arrdataset[$i]['amount']=$amountthis;//จำนวนขาย
                      $arrdataset[$i]['priceunit']=$d->priceunitrl;//ราคาขายต่อหน่วย
                  $i++;
              }

              // print_r($arrdataset);
              ///////////////////  SS  ///////////////////
             $sqlss = "SELECT  $baseMain.stock_sell_head.*,
                                $baseMain.stock_sell_detail.material_id,
                                $baseMain.stock_sell_detail.amount,
                                $baseMain.stock_sell_detail.loss as priceunitss
                              FROM  $baseMain.stock_sell_head
                              INNER JOIN $baseMain.stock_sell_detail
                              ON $baseMain.stock_sell_head.id = $baseMain.stock_sell_detail.bill_head
                              WHERE $baseMain.stock_sell_head.status = '1'
                              AND $baseMain.stock_sell_head.date_approved BETWEEN '$start 00:00:00' AND '$end 23:59:59'
                              AND $baseMain.stock_sell_head.type = '3'
                              AND $baseMain.stock_sell_head.branch_id = '$branchselct'
                              AND $baseMain.stock_sell_detail.material_id = '$material_id' ";
                $getdatass = DB::select($sqlss);


                foreach ($getdatass as $a => $b) {

                          $arrdataset[$i]['date']=$b->date_approved;//วันที่ขาย
                          $arrdataset[$i]['taxshow']=$b->bill_no;//รหัสบิล
                          $arrdataset[$i]['amount']=$b->amount;//จำนวนขาย
                          $arrdataset[$i]['priceunit']=$b->priceunitss;//ราคาขายต่อหน่วย
                          $i++;
                }


              // print_r($getdatarl);
              echo "<br>";
              echo "<br>";
              echo "ชื่อสินค้า  <font color='green'>       ".$getdatamselect[0]->name."</font>";
              echo "<br>";
              echo "<br>";

              $sqlassetdata = "SELECT $baseAc1.asset_list.*,
                                      $baseAc1.his_asset_depreciationexpense.*
                              FROM $baseAc1.asset_list
                              INNER JOIN $baseAc1.his_asset_depreciationexpense
                              ON $baseAc1.his_asset_depreciationexpense.asset_list_id = $baseAc1.asset_list.id
                              WHERE $baseAc1.asset_list.statususe = '1'
                              AND $baseAc1.asset_list.material_id = '$material_id'
                              AND  $baseAc1.asset_list.date_startuse  < '$start 00:00:00'
                              AND $baseAc1.his_asset_depreciationexpense.amount > '0.00'
                              AND $baseAc1.his_asset_depreciationexpense.date_ed   BETWEEN '$start 00:00:00' AND '$end 23:59:59'
                              AND $baseAc1.his_asset_depreciationexpense.status = '1' ";

              $getdataassetdata = DB::select($sqlassetdata);
              // echo "<pre>";
              // print_r($getdataassetdata);

              array_multisort($arrdataset);
              $arrnewasset = [];
              $amsell = 0;
              foreach ($arrdataset as $j => $k) {
                      $arrnewasset[$j]['date'] = $k['date'];
                      $arrnewasset[$j]['taxshow'] = $k['taxshow'];
                      $arrnewasset[$j]['amount'] = $k['amount'];
                      $arrnewasset[$j]['priceunit'] = $k['priceunit'];
                        $amsell =   $amsell + $k['amount'];
              }



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
                        <table  class="table table-striped table-bordered fontslabel" style="width:100%;">
                          <thead>
                            <tr>
                              <th rowspan="2">ใบกำกับภาษี</th>
                              <th rowspan="2">วันที่ขาย</th>
                              <th colspan="3">ราคาทุน</th>
                              <th colspan="3">ขาย</th>
                              <th colspan="3">คงเหลือ</th>
                              <th colspan="4">ค่าเสื่อมราคาสะสม</th>
                            </tr>
                            <tr>
                              <td >จำนวนชิ้น</td>
                              <td >ราคาทุน/ชิ้น</td>
                              <td >ราคาทุนรวม</td>
                              <td >จำนวนชิ้น</td>
                              <td >ราคาทุน/ชิ้น</td>
                              <td >ราคาทุนรวม</td>
                              <td >จำนวนชิ้น</td>
                              <td >ราคาทุน/ชิ้น</td>
                              <td >ราคาทุนรวม</td>
                              <td >ยอดยกมา</td>
                              <td >เพิ่มขึ้น</td>
                              <td >ลดลง</td>
                              <td >ยอดยกไป</td>
                            </tr>
                          </thead>
                          <?php if(!empty($start)){?>
                          <tbody>
                            <?php
                            $amaddless  = 0;
                            $arrKeyloop = [];
                            $totalsale = 0;
                             $newstock=0;
                          foreach ($getdataassetdata as $g => $h):

                              $totalsale = $h->bring_forward_amount;
                              if($amaddless >= 0){
                                $amaddless = $h->amount;
                            ?>
                          <tr>
                            <td >LOT: <?php echo $h->name_thai;?> </td>
                            <td ></td>

                            <td ><?php echo $h->amount;?></td>
                            <td ><?php echo $h->price_buy;?></td>
                            <td ><?php echo $h->price_buy * $h->amount;?></td>
                            <td ><?php echo $h->amount;?></td>
                            <td ><?php echo $h->price_buy;?></td>
                            <td ><?php echo $h->price_buy * $h->amount;?></td>
                            <td ></td>
                            <td ></td>
                            <td ></td>
                            <td ><?php echo $h->bring_forward;?></td>
                            <td ></td>
                            <td ></td>
                            <td ></td>
                          </tr>
                          <?php
                          foreach ($arrnewasset as $e => $f):
                            if(!in_array($e,$arrKeyloop)){
                            $deducep = 0;
                                if($amaddless > 0){
                                $amaddless  = $amaddless - $f['amount'];
                              ?>
                              <tr>
                                <td ><?php echo $f['taxshow'];?> </td>
                                <td ><?php echo $f['date'];?> </td>
                                <td ></td>
                                <td ></td>
                                <td ></td>
                                <td ><?php
                                      if($amaddless>0){
                                        echo $f['amount'];

                                        $arrKeyloop[] = $e;
                                      }else{
                                        echo  ($amaddless + $f['amount']) ;

                                      }
                                ?>
                                </td>
                                <td ><?php echo $f['priceunit'];?> </td>
                                <td >
                                  <?php
                                        if($amaddless>0){
                                          echo $f['amount']*$f['priceunit'];;


                                        }else{
                                          echo  ($amaddless + $f['amount'])*$f['priceunit'];

                                        }
                                  ?>
                                </td>
                                <td >
                                    <?php
                                    if($amaddless>0){
                                        echo $amaddless;
                                      }
                                      ?>
                                </td>
                                <td ><?php echo $h->price_buy;?></td>
                                <td >
                                    <?php
                                    if($amaddless>0){
                                        echo $amaddless*$h->price_buy;
                                    }
                                    ?>
                                </td>
                                <td >
                                  <?php
                                        if($amaddless>0){
                                          echo ($h->bring_forward*$f['amount'])/$h->amount;
                                          $deducep = $deducep + ($h->bring_forward*$f['amount'])/$h->amount;
                                        }else{
                                          echo ($h->bring_forward*($amaddless + $f['amount']))/$h->amount;
                                          $deducep = $deducep + ($h->bring_forward*($amaddless + $f['amount']))/$h->amount;
                                        }
                                  ?>
                                </td>
                                <td >
                                    <?php
                                           $datethis = $h->date_startuse;
                                           $life_for_use = $h->life_for_use;
                                           $endDate = date('Y-m-d', strtotime($datethis. ' + '.$life_for_use.' years'));
                                      $datenow = date('Y-m-d');
                                      if($endDate>$datenow){
                                            //echo  (($amaddless + $f['amount'])*$f['priceunit'])*($h->end_price_sellpercent/100);
                                            if($amaddless>0){
                                              $date1 = date_create($datefirst);
                                              $date2 = date_create($f['date']);
                                              $interval = date_diff($date1, $date2);
                                              $datethis = ($interval->format('%a'));
                                              echo number_format(($f['amount']*$f['priceunit'])*($h->end_price_sellpercent/100)*($datethis/365),2);
                                                $deducep = $deducep + ($f['amount']*$f['priceunit'])*($h->end_price_sellpercent/100)*($datethis/365);


                                            }else{

                                              $date1 = date_create($datefirst);
                                              $date2 = date_create($f['date']);
                                              $interval = date_diff($date1, $date2);
                                              $datethis = ($interval->format('%a'));
                                              echo  number_format((($amaddless + $f['amount'])*$f['priceunit'])*($h->end_price_sellpercent/100)*($datethis/365),2) ;
                                                $deducep = $deducep + (($amaddless + $f['amount'])*$f['priceunit'])*($h->end_price_sellpercent/100)*($datethis/365);

                                            }
                                      }
                                    ?>
                                </td>
                                <td ><?php echo number_format($deducep,2);?></td>
                                <td ></td>
                              </tr>
                              <?php }  ?>
                            <?php }  ?>

                            <?php endforeach; ?>
                          <?php }else{ ?>
                            <tr>
                              <td >LOT: <?php echo $h->name_thai;?> </td>
                              <td ></td>
                              <td ><?php echo $h->amount;?></td>
                              <td ><?php echo $h->price_buy;?></td>
                              <td ><?php echo $h->price_buy * $h->amount;?></td>
                              <td ><?php echo $h->amount;?></td>
                              <td ><?php echo $h->price_buy;?></td>
                              <td ><?php echo $h->price_buy * $h->amount;?></td>
                              <td ></td>
                              <td ></td>
                              <td ></td>
                              <td ><?php echo $h->bring_forward;?></td>
                              <td ></td>
                              <td ></td>
                              <td ></td>
                            </tr>

                            <?php
                              foreach ($arrnewasset as $key => $value) {

                                if(!in_array($key,$arrKeyloop)){

                                ?>
                                <?php if($amaddless<0){
                                    $amaddless = $amaddless*(-1);
                                    $newstock = $h->amount;

                                ?>
                                <tr>
                                  <td ><?php echo $value['taxshow'];?> </td>
                                  <td ><?php echo $value['date'];?> </td>
                                  <td ></td>
                                  <td ></td>
                                  <td ></td>
                                  <td >
                                    <?php echo $amaddless ;?>
                                  </td>
                                  <td ><?php echo $value['priceunit'];?></td>
                                  <td >  <?php echo $amaddless * $value['priceunit'];?></td>
                                  <td >  <?php  echo $newstock = $newstock - $amaddless;?></td>
                                  <td ><?php echo $h->price_buy;?></td>
                                  <td ><?php echo $h->price_buy*$newstock;?></td>
                                  <td ><?php echo ($h->bring_forward*$amaddless)/$h->amount;  ?></td>
                                  <td >
                                    <?php
                                           $datethis = $h->date_startuse;
                                           $life_for_use = $h->life_for_use;
                                           $endDate = date('Y-m-d', strtotime($datethis. ' + '.$life_for_use.' years'));
                                      $datenow = date('Y-m-d');
                                      if($endDate>$datenow){
                                            //echo  (($amaddless + $f['amount'])*$f['priceunit'])*($h->end_price_sellpercent/100);
                                              $date1 = date_create($datefirst);
                                              $date2 = date_create($value['date']);
                                              $interval = date_diff($date1, $date2);
                                              $datethis = ($interval->format('%a'));
                                              echo number_format(($amaddless * $value['priceunit'])*($h->end_price_sellpercent/100)*($datethis/365),2);

                                      }
                                    ?>
                                  </td>
                                  <td >
                                    <?php
                                           $datethis = $h->date_startuse;
                                           $life_for_use = $h->life_for_use;
                                           $endDate = date('Y-m-d', strtotime($datethis. ' + '.$life_for_use.' years'));
                                      $datenow = date('Y-m-d');
                                      if($endDate>$datenow){
                                            //echo  (($amaddless + $f['amount'])*$f['priceunit'])*($h->end_price_sellpercent/100);
                                              $date1 = date_create($datefirst);
                                              $date2 = date_create($value['date']);
                                              $interval = date_diff($date1, $date2);
                                              $datethis = ($interval->format('%a'));
                                              $a = ($h->bring_forward*$amaddless)/$h->amount;
                                              echo number_format(($amaddless * $value['priceunit'])*($h->end_price_sellpercent/100)*($datethis/365)+$a,2);

                                      }
                                    ?>
                                  </td>
                                  <td ></td>
                                </tr>
                              <?php $amaddless = $h->amount; ;} else{ ?>
                                <tr>
                                  <td ><?php echo $value['taxshow'];?> </td>
                                  <td ><?php echo $value['date'];?> </td>
                                  <td ></td>
                                  <td ></td>
                                  <td ></td>
                                  <td >
                                    <?php echo $value['amount'];?>
                                  </td>
                                  <td ><?php echo $value['priceunit'];?></td>
                                  <td ><?php echo $value['amount']*$value['priceunit'];?></td>
                                  <td > <?php  echo $newstock = $newstock -  $value['amount'];?></td>
                                  <td ><?php echo $h->price_buy;?></td>
                                  <td ><?php echo $h->price_buy*$newstock;?></td>
                                  <td ><?php echo ($h->bring_forward * $value['amount'])/$h->amount; ?></td>
                                  <td >
                                    <?php
                                           $datethis = $h->date_startuse;
                                           $life_for_use = $h->life_for_use;
                                           $endDate = date('Y-m-d', strtotime($datethis. ' + '.$life_for_use.' years'));
                                      $datenow = date('Y-m-d');
                                      if($endDate>$datenow){
                                            //echo  (($amaddless + $f['amount'])*$f['priceunit'])*($h->end_price_sellpercent/100);
                                              $date1 = date_create($datefirst);
                                              $date2 = date_create($value['date']);
                                              $interval = date_diff($date1, $date2);
                                              $datethis = ($interval->format('%a'));
                                              echo number_format(($value['amount']*$value['priceunit'])*($h->end_price_sellpercent/100)*($datethis/365),2);
                                      }
                                    ?>
                                  </td>
                                  <td >
                                    <?php
                                           $datethis = $h->date_startuse;
                                           $life_for_use = $h->life_for_use;
                                           $endDate = date('Y-m-d', strtotime($datethis. ' + '.$life_for_use.' years'));
                                      $datenow = date('Y-m-d');
                                      if($endDate>$datenow){
                                            //echo  (($amaddless + $f['amount'])*$f['priceunit'])*($h->end_price_sellpercent/100);
                                              $date1 = date_create($datefirst);
                                              $date2 = date_create($value['date']);
                                              $interval = date_diff($date1, $date2);
                                              $datethis = ($interval->format('%a'));
                                              $a = ($h->bring_forward * $value['amount'])/$h->amount;
                                              echo number_format(($value['amount']*$value['priceunit'])*($h->end_price_sellpercent/100)*($datethis/365)+$a,2);

                                      }
                                    ?>
                                  </td>
                                  <td ></td>
                                </tr>
                              <?php } ?>
                              <?php } ?>
                            <?php } ?>
                          <?php } ?>
                          <tr>
                            <td > </td>

                            <td ><b>ค่าเสือมปกติ</b></td>
                            <td>

                            </td>
                            <td ></td>
                            <td ></td>
                            <td ></td>
                            <td ></td>
                            <td ></td>
                            <td ></td>
                            <td ></td>
                            <td ></td>
                            <td ><?php echo ($newstock*$h->bring_forward)/$h->amount;?></td>
                            <td >
                              <?php
                                     $datethis = $h->date_startuse;
                                     $life_for_use = $h->life_for_use;
                                     $years1 = substr($h->date_startuse,0,4);
                                     $years2 = substr($start,0,4);
                                     $endDate = date('Y-m-d', strtotime($datethis. ' + '.$life_for_use.' years'));
                                $datenow = date('Y-m-d');
                                if($endDate>$datenow){
                                      if($years1 < $years2){
                                          echo ($h->price_buy*$newstock)*($h->end_price_sellpercent/100);
                                      }else{
                                          $date1 = date_create($h->date_startuse);
                                          $date2 = date_create($start);
                                          $interval = date_diff($date1, $date2);
                                          $datethis = ($interval->format('%a'));
                                          echo number_format(($h->price_buy*$newstock)*($h->end_price_sellpercent/100)*($datethis/365),2);
                                      }
                                }
                              ?>
                            </td>
                            <td >
                              0
                            </td>
                            <td >
                              <?php
                                     $datethis = $h->date_startuse;
                                     $life_for_use = $h->life_for_use;
                                     $years1 = substr($h->date_startuse,0,4);
                                     $years2 = substr($start,0,4);
                                     $endDate = date('Y-m-d', strtotime($datethis. ' + '.$life_for_use.' years'));
                                $datenow = date('Y-m-d');
                                if($endDate>$datenow){
                                      if($years1 < $years2){
                                          echo number_format(($h->price_buy*$newstock)*($h->end_price_sellpercent/100)+(($newstock*$h->bring_forward)/$h->amount),2);
                                      }else{
                                          $date1 = date_create($h->date_startuse);
                                          $date2 = date_create($start);
                                          $interval = date_diff($date1, $date2);
                                          $datethis = ($interval->format('%a'));
                                          echo number_format(($h->price_buy*$newstock)*($h->end_price_sellpercent/100)*($datethis/365)+(($newstock*$h->bring_forward)/$h->amount),2);
                                      }
                                }
                              ?>
                            </td>
                          </tr>
                          <tr>
                            <td > </td>

                            <td ><b><u>รวม</u></b></td>
                            <td>

                            </td>
                            <td ></td>
                            <td ><?php echo $totalsale;?></td>
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
                          <?php endforeach; ?>


                          </tbody>
                        <?php } ?>
                        </table>
                        <?php
                          // print_r($arrKeyloop);
                        ?>

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

      $('.select2').select2({
            dropdownAutoWidth: true
       });

      } );
  </script>
@endsection
