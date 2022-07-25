@extends('index')
@section('content')
<?php
use App\Api\Datetime;

use App\Api\Connectdb;

$db = Connectdb::Databaseall();
?>
<!-- js data table -->
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript" src={{ asset('js/accountjs/journal_debt.js') }}></script>
<link href="{{ asset('css/journal_debt/journal_debt.css') }}" rel="stylesheet" type="text/css" media="all">
<script language="JavaScript">
  function toggle(source) {
    checkboxes = document.getElementsByName('check_list[]');
    for(var i=0, n=checkboxes.length;i<n;i++) {
      checkboxes[i].checked = source.checked;
    }
  }
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
                            <li class="breadcrumb-item">สมุดรายวัน</li>
                            <li class="breadcrumb-item active">สมุดรายวันจ่าย(เงินเดือน)</li>
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
                                <fonts id="fontsheader">สมุดรายวันจ่าย(เงินเดือน)</fonts>
                            </h3><br><br>
                            <!-- date range -->
                            <form action="journalpay_filter_social" method="post">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="row" class="fontslabel">
                                <div class="col-sm-3">
                                    <div class="input-group mb-6">
                                        <div class="input-group-prepend">
                                            <label id="fontslabel"><b>วันที่ : &nbsp;</b></label>
                                        </div>
                                        <input type='text' class="form-control" name="daterange" value="" autocomplete="off" required/>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="input-group mb-6">
                                        <label id="fontslabel"><b>สาขา : &nbsp;</b></label>
                                        <select class="form-control" name="branch" required>
                                            <option selected value="all">เลือกทุกสาขา</option>
                                            @foreach ($branchs as $key => $branch)
                                            <option value="{{$branch->code_branch}}">{{$branch->name_branch}}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>

                                <center><button type="submit" class="btn btn-primary btn-sm fontslabel">ค้นหา</button></center>&nbsp;

                            </div>
                            </form>
                            <!-- date range -->
                        </div>
                        <?php if(!empty($datamsg)){?>
                              <div class="alert alert-success">
                              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                              <strong>Success!</strong>
                              </div>
                        <?php }?>
                        <?php if(!empty($datasaraly)){
                              // echo "<pre>";
                              // print_r($datasaraly);

                          ?>
                        <form action="confirm_journal_pay_social" method="post">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <!-- table cotent -->
                        <div class="col" id="fontsjournal">
                            <table class="table table-bordered">
                                <thead>
                                    <tr style="background-color:#aab6c2;color:white;">
                                        <th scope="col"><label class="con" style="margin: -25px -35px 0px 0px;">
                                            <input type="checkbox" onClick="toggle(this)">
                                            <span class="checkmark"></span>
                                          </label>
                                        </th>
                                        <th scope="col">วัน/เดือน/ปี</th>
                                        <th scope="col">เลขที่ใบสำคัญรับ</th>
                                        <th scope="col">รายการ</th>
                                        <th scope="col">รายละเอียด</th>
                                        <th scope="col">สาขา</th>
                                        <th scope="col">เลขที่บัญชี</th>
                                        <th scope="col">ชื่อเลขที่บัญชี</th>

                                        <th scope="col">เดบิต</th>
                                        <th scope="col">เครดิต</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  <?php
                                  echo "<pre>";
                                  print_r($datasaraly);
                                  exit;

                                  foreach ($datasaraly as $k => $v){
                                    $sumadd = 0;
                                    $sumdeduc = 0;
                                     ?>
                                    <tr >
                                        <td scope="col">
                                          <?php if($v->status_ap==0){ ?>
                                            <label class="con">
                                            <input type="checkbox" name="check_list[]" value="{{ $v->WAGE_ID }}">
                                                <span class="checkmark"></span>
                                            </label>
                                          <?php }else{ ?>
                                            <i class="fa fa-check" style="color:green;font-size:20px;"></i>
                                          <?php } ?>
                                        </td>
                                        <td scope="col">
                                          <?php $datelastmonth = substr($v->WAGE_THIS_MONTH_BANK_CONFIRM_DATE,0,7);
                                                echo date("Y-m-t", strtotime($datelastmonth));
                                          ?>
                                        </td>
                                        <td scope="col"><?php echo $datelastmonth.'/'.$v->WAGE_THIS_MONTH_ROW_NUM?></td>
                                        <td scope="col">เงินเดือนของ
                                                <?php echo $v->nameth.'  '.$v->surnameth;

                                                ?>

                                        </td>
                                        <td scope="col"> เงินเดือนพนักงานเดือน
                                            <?php
                                                    $exportmounth = explode("-",$datelastmonth);
                                                    $monthshow = Datetime::mappingMonth($exportmounth[1]);
                                                    echo $monthshow;
                                                    echo "  ";
                                                    echo $exportmounth[0]+543;

                                            ?>
                                        </td>
                                        <td scope="col">
                                          <?php echo $v->branch_id;?>
                                        </td>
                                        <td scope="col">
                                            <?php
                                                if($v->statussalaryboss==1){
                                                    echo "621106";
                                                }else{
                                                    echo "621101";
                                                }
                                            ?>
                                        </td>
                                        <td scope="col">
                                          <?php
                                              if($v->statussalaryboss==1){
                                                  echo "ค่าใช้จ่ายในการบริหาร-เงินเดือนผู้บริหาร";
                                              }else{
                                                  echo "ค่าใช้จ่ายในการบริหาร-เงินเดือนพนักงาน";
                                              }
                                          ?>
                                        </td>

                                        <td scope="col"><?php $sumadd = $sumadd + $v->WAGE_SALARY;  echo number_format($v->WAGE_SALARY,2);?></td>
                                        <td scope="col">0.00</td>
                                    </tr>
                                    <?php
                                        $idcard = $v->WAGE_EMP_ID;
                                        $dateset = $exportmounth[1].'-'.$exportmounth[0];
                                      echo  $sqlsso = "SELECT  $db[hr_base].ADD_DEDUCT_HISTORY.*
                                                    FROM $db[hr_base].ADD_DEDUCT_HISTORY
                                                    WHERE $db[hr_base].ADD_DEDUCT_HISTORY.ADD_DEDUCT_THIS_MONTH_EMP_ID = '$idcard'
                                                    AND $db[hr_base].ADD_DEDUCT_HISTORY.ADD_DEDUCT_THIS_MONTH_PAY_DATE = '$dateset'
                                                    AND $db[hr_base].ADD_DEDUCT_HISTORY.ADD_DEDUCT_THIS_MONTH_TMP_NAME = 'ประกันสังคม'  ";
                                        $datasso = DB::select($sqlsso);
                                        if(!empty($datasso[0]->ADD_DEDUCT_THIS_MONTH_AMOUNT!='0.00')){
                                    ?>
                                    <tr >
                                        <td scope="col">  </td>
                                        <td scope="col">  </td>
                                        <td scope="col">  </td>
                                        <td scope="col">  </td>
                                        <th scope="col">  </td>
                                        <td scope="col">  </th>
                                        <td scope="col">621151</td>
                                        <td scope="col">ค่าใช้จ่ายในการบริหาร-เงินสมทบกองทุนประกันสังคม</td>
                                        <td scope="col"><?php $sumadd = $sumadd + $datasso[0]->ADD_DEDUCT_THIS_MONTH_AMOUNT;  echo $datasso[0]->ADD_DEDUCT_THIS_MONTH_AMOUNT; ?></td>
                                        <td scope="col"> 0.00 </td>
                                    </tr>
                                    <?php } ?>
                                    <?php
                                          $sqladddeduc = "SELECT  sum(ADD_DEDUCT_THIS_MONTH_AMOUNT) as ADD_DEDUCT_THIS_MONTH_AMOUNT,
                                                                  $db[hr_base].ADD_DEDUCT_TEMPLATE.accounting_code_pk
                                                      FROM $db[hr_base].ADD_DEDUCT_HISTORY
                                                      INNER JOIN $db[hr_base].ADD_DEDUCT_TEMPLATE
                                                      ON  $db[hr_base].ADD_DEDUCT_HISTORY.ADD_DEDUCT_THIS_MONTH_TMP_ID = $db[hr_base].ADD_DEDUCT_TEMPLATE.ADD_DEDUCT_TEMPLATE_ID
                                                      WHERE $db[hr_base].ADD_DEDUCT_HISTORY.ADD_DEDUCT_THIS_MONTH_EMP_ID = '$idcard'
                                                      AND $db[hr_base].ADD_DEDUCT_HISTORY.ADD_DEDUCT_THIS_MONTH_PAY_DATE = '$dateset'
                                                      AND $db[hr_base].ADD_DEDUCT_HISTORY.ADD_DEDUCT_THIS_MONTH_TYPE = '1'
                                                      GROUP BY  $db[hr_base].ADD_DEDUCT_TEMPLATE.accounting_code_pk ";

                                          $datadddeduc = DB::select($sqladddeduc);
                                        foreach ($datadddeduc as $q => $r) { ?>
                                    <tr >
                                        <td scope="col">  </td>
                                        <td scope="col">  </td>
                                        <td scope="col">  </td>
                                        <td scope="col">  </td>
                                        <th scope="col">  </td>
                                        <td scope="col">  </th>
                                        <td scope="col"><?php echo $accthis = $r->accounting_code_pk; ?></td>
                                        <td scope="col">
                                          <?php
                                              $sqlacc = "SELECT $db[fsctaccount].accounttype.*
                                                           FROM $db[fsctaccount].accounttype
                                                           WHERE $db[fsctaccount].accounttype.accounttypeno = '$accthis'";
                                              $dataaccname = DB::connection('mysql')->select($sqlacc);
                                              if(!empty($dataaccname)){
                                                    echo $dataaccname[0]->accounttypefull;
                                              }
                                          ?>
                                        </td>
                                        <td scope="col"><?php $sumadd = $sumadd + $r->ADD_DEDUCT_THIS_MONTH_AMOUNT;  echo number_format($r->ADD_DEDUCT_THIS_MONTH_AMOUNT,2) ?></td>
                                        <td scope="col"> 0.00 </td>
                                    </tr>
                                   <?php }?>
                                   <?php
                                       $idcard = $v->WAGE_EMP_ID;
                                       $dateset = $exportmounth[1].'-'.$exportmounth[0];
                                       $sqlsso = "SELECT  $db[hr_base].ADD_DEDUCT_HISTORY.*
                                                   FROM $db[hr_base].ADD_DEDUCT_HISTORY
                                                   WHERE $db[hr_base].ADD_DEDUCT_HISTORY.ADD_DEDUCT_THIS_MONTH_EMP_ID = '$idcard'
                                                   AND $db[hr_base].ADD_DEDUCT_HISTORY.ADD_DEDUCT_THIS_MONTH_PAY_DATE = '$dateset'
                                                   AND $db[hr_base].ADD_DEDUCT_HISTORY.ADD_DEDUCT_THIS_MONTH_TMP_NAME = 'ประกันสังคม'  ";
                                       $datasso = DB::select($sqlsso);
                                       if(!empty($datasso[0]->ADD_DEDUCT_THIS_MONTH_AMOUNT!='0.00')){
                                   ?>
                                   <tr >
                                       <td scope="col">  </td>
                                       <td scope="col">  </td>
                                       <td scope="col">  </td>
                                       <td scope="col">  </td>
                                       <th scope="col">  </td>
                                       <td scope="col">  </th>
                                       <td scope="col">219102</td>
                                       <td scope="col">เงินสมทบประกันสังคมค้างจ่าย</td>
                                       <td scope="col">0.00</td>
                                       <td scope="col"> <?php $sumdeduc = $sumdeduc+$datasso[0]->ADD_DEDUCT_THIS_MONTH_AMOUNT*2; echo number_format($datasso[0]->ADD_DEDUCT_THIS_MONTH_AMOUNT*2,2); ?> </td>
                                   </tr>
                                   <?php } ?>
                                   <?php

                                       $sqllost = "SELECT  sum(ADD_DEDUCT_THIS_MONTH_AMOUNT) as ADD_DEDUCT_THIS_MONTH_AMOUNT
                                                   FROM $db[hr_base].ADD_DEDUCT_HISTORY
                                                   WHERE $db[hr_base].ADD_DEDUCT_HISTORY.ADD_DEDUCT_THIS_MONTH_EMP_ID = '$idcard'
                                                   AND $db[hr_base].ADD_DEDUCT_HISTORY.ADD_DEDUCT_THIS_MONTH_PAY_DATE = '$dateset'
                                                   AND  $db[hr_base].ADD_DEDUCT_HISTORY.ADD_DEDUCT_THIS_MONTH_TMP_ID  IN(21,20)  ";
                                       $datalost = DB::select($sqllost);
                                       if(!empty($datalost[0]->ADD_DEDUCT_THIS_MONTH_AMOUNT) AND $datalost[0]->ADD_DEDUCT_THIS_MONTH_AMOUNT !='0.00'){
                                   ?>
                                   <tr >
                                       <td scope="col">  </td>
                                       <td scope="col">  </td>
                                       <td scope="col">  </td>
                                       <td scope="col">  </td>
                                       <th scope="col">[ มาสาย หักขาด ลากิจ ]</td>
                                       <td scope="col">  </th>
                                       <td scope="col">621101</td>
                                       <td scope="col">ค่าใช้จ่ายในการบริหาร-เงินเดือนพนักงาน</td>
                                       <td scope="col">0.00</td>
                                       <td scope="col"> <?php $sumdeduc = $sumdeduc+$datalost[0]->ADD_DEDUCT_THIS_MONTH_AMOUNT; echo number_format($datalost[0]->ADD_DEDUCT_THIS_MONTH_AMOUNT,2); ?></td>
                                   </tr>
                                   <?php } ?>
                                   <?php
                                         $sqladddeduc = "SELECT  sum(ADD_DEDUCT_THIS_MONTH_AMOUNT) as ADD_DEDUCT_THIS_MONTH_AMOUNT,
                                                                 $db[hr_base].ADD_DEDUCT_TEMPLATE.accounting_code_pk
                                                     FROM $db[hr_base].ADD_DEDUCT_HISTORY
                                                     INNER JOIN $db[hr_base].ADD_DEDUCT_TEMPLATE
                                                     ON  $db[hr_base].ADD_DEDUCT_HISTORY.ADD_DEDUCT_THIS_MONTH_TMP_ID = $db[hr_base].ADD_DEDUCT_TEMPLATE.ADD_DEDUCT_TEMPLATE_ID
                                                     WHERE $db[hr_base].ADD_DEDUCT_HISTORY.ADD_DEDUCT_THIS_MONTH_EMP_ID = '$idcard'
                                                     AND $db[hr_base].ADD_DEDUCT_HISTORY.ADD_DEDUCT_THIS_MONTH_PAY_DATE = '$dateset'
                                                     AND $db[hr_base].ADD_DEDUCT_HISTORY.ADD_DEDUCT_THIS_MONTH_TYPE = '2'
                                                     AND  $db[hr_base].ADD_DEDUCT_HISTORY.ADD_DEDUCT_THIS_MONTH_TMP_NAME NOT LIKE '%ประกันสังคม%'
                                                     AND  $db[hr_base].ADD_DEDUCT_HISTORY.ADD_DEDUCT_THIS_MONTH_TMP_ID NOT IN(21,38,20)
                                                     GROUP BY  $db[hr_base].ADD_DEDUCT_TEMPLATE.accounting_code_pk  ";
                                         $datadddeduc = DB::select($sqladddeduc);
                                       foreach ($datadddeduc as $b => $a) {
                                          if($a->ADD_DEDUCT_THIS_MONTH_AMOUNT!='0.00'){
                                        ?>
                                   <tr>
                                       <td scope="col">  </td>
                                       <td scope="col">  </td>
                                       <td scope="col">  </td>
                                       <td scope="col">  </td>
                                       <th scope="col">  </td>
                                       <td scope="col">  </th>
                                       <td scope="col"><?php  echo $accthis = $a->accounting_code_pk; ?></td>
                                       <td scope="col">
                                         <?php
                                             $sqlacc = "SELECT $db[fsctaccount].accounttype.*
                                                          FROM $db[fsctaccount].accounttype
                                                          WHERE $db[fsctaccount].accounttype.accounttypeno = '$accthis'";
                                             $dataaccname = DB::connection('mysql')->select($sqlacc);
                                             if(!empty($dataaccname)){
                                                   echo $dataaccname[0]->accounttypefull;
                                             }
                                         ?>
                                       </td>
                                       <td scope="col">0.00</td>
                                       <td scope="col"><?php $sumdeduc = $sumdeduc+$a->ADD_DEDUCT_THIS_MONTH_AMOUNT; echo number_format($a->ADD_DEDUCT_THIS_MONTH_AMOUNT,2) ?> </td>
                                   </tr>
                                    <?php }?>
                                  <?php }?>
                                  <tr >
                                      <td scope="col">  </td>
                                      <td scope="col">  </td>
                                      <td scope="col">  </td>
                                      <td scope="col">  </td>
                                      <th scope="col">  </td>
                                      <td scope="col">  </th>
                                      <td scope="col">112027</td>
                                      <td scope="col">เงินฝากออมทรัพย์ KBANK 587-2-25765-0 (เชียงใหม่)</td>
                                      <td scope="col">0.00</td>
                                      <td scope="col"> <?php $sumdeduc = $sumdeduc+$v->WAGE_NET_SALARY; echo number_format($v->WAGE_NET_SALARY,2); ?> </td>
                                  </tr>
                                  <tr >
                                      <td scope="col">  </td>
                                      <td scope="col">  </td>
                                      <td scope="col">  </td>
                                      <td scope="col">  </td>
                                      <th scope="col">  </td>
                                      <td scope="col">  </th>
                                      <td scope="col"></td>
                                      <td scope="col"></td>
                                      <td scope="col"><b><?php echo number_format($sumadd,2); ?></b></td>
                                      <td scope="col"><b><?php echo number_format($sumdeduc,2); ?></b> </td>
                                  </tr>

                                  <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <div style="padding-bottom:50px;">
                            <center><button type="submit" class="btn btn-success">Okay ยืนยันการตรวจ</button></center>
                        </div>
                     <?php } ?>
                        <!--END table cotent -->
                      </form>
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
