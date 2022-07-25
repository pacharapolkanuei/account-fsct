<?php
use  App\Api\Connectdb;
use  App\Api\Accountcenter;
use  App\Api\Maincenter;
use  App\Api\Vendorcenter;

use App\Api\Datetime;
use App\working_company;
use Illuminate\Support\Facades\Input;

?>

<link>
{{--<script type="text/javascript" src = 'js/jquery-ui-1.12.1/jquery-ui.js'></script>--}}
{{--<script type="text/javascript" src = 'js/jquery-ui-1.12.1/jquery-ui.min.js'></script>--}}
<script type="text/javascript" src = 'js/bootbox.min.js'></script>
<script type="text/javascript" src = 'js/validator.min.js'></script>

<script type="text/javascript" src = 'js/jquery.dataTables.min.js'></script>
<script type="text/javascript" src = 'js/dataTables.bootstrap.min.js'></script>
<link rel="stylesheet" type="text/css" href="css/table/dataTables.bootstrap.min.css">

<script type="text/javascript" src = 'js/accountjs/reservemoney.js'></script>

<meta name="csrf-token" content="{{ csrf_token() }}" />
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        @font-face {
            font-family: 'THSarabunNew';
            font-style: normal;
            font-weight: normal;
            src: url("{{ public_path('fonts/THSarabunNew.ttf') }}") format('truetype');
        }
        @font-face {
            font-family: 'THSarabunNew';
            font-style: normal;
            font-weight: bold;
            src: url("{{ public_path('fonts/THSarabunNew Bold.ttf') }}") format('truetype');
        }
        @font-face {
            font-family: 'THSarabunNew';
            font-style: italic;
            font-weight: normal;
            src: url("{{ public_path('fonts/THSarabunNew Italic.ttf') }}") format('truetype');
        }
        @font-face {
            font-family: 'THSarabunNew';
            font-style: italic;
            font-weight: bold;
            src: url("{{ public_path('fonts/THSarabunNew BoldItalic.ttf') }}") format('truetype');
        }

        body {
            font-family: "THSarabunNew";
            font-size: 12px;
        }
        h4 {
            font-family: "THSarabunNew";
        }
        table {
            font-family: "THSarabunNew";
        }
        td,th {
            font-family: "THSarabunNew";
        }

    </style>

<style>
    .modal-ku {
        width: 90%;
        margin: auto;
    }
</style>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->

    <!-- Main content -->


    <section class="content">
        <div class="box box-success">
            <div class="box-body">

            <?php

              $data = Input::all();
              $db = Connectdb::Databaseall();
              // echo "<pre>";
              // print_r($data);
              // exit;

              $datepicker = explode("-",trim(($data['reservation'])));

              $datepickerstart = explode("/",trim(($datepicker[0])));
              if(count($datepickerstart) > 0) {
                  $datetime = $datepickerstart[1] . '-' . $datepickerstart[0]; //วัน - เดือน
              }

              $datepickerend = explode("/",trim(($datepicker[1])));
              if(count($datepickerend) > 0) {
                  $datetime2 = $datepickerend[1] . '-' . $datepickerend[0]; //วัน - เดือน
              }

              if($datepickerstart[0] == "01"){$monthTH = "มกราคม";
                }else if($datepickerstart[0] == "02"){$monthTH = "กุมภาพันธ์";
                }else if($datepickerstart[0] == "03"){$monthTH = "มีนาคม";
                }else if($datepickerstart[0] == "04"){$monthTH = "เมษายน";
                }else if($datepickerstart[0] == "05"){$monthTH = "พฤษภาคม";
                }else if($datepickerstart[0] == "06"){$monthTH = "มิถุนายน";
                }else if($datepickerstart[0] == "07"){$monthTH = "กรกฎาคม";
                }else if($datepickerstart[0] == "08"){$monthTH = "สิงหาคม";
                }else if($datepickerstart[0] == "09"){$monthTH = "กันยายน";
                }else if($datepickerstart[0] == "10"){$monthTH = "ตุลาคม";
                }else if($datepickerstart[0] == "11"){$monthTH = "พฤศจิกายน";
                }else if($datepickerstart[0] == "12"){$monthTH = "ธันวาคม";
                }

              if($datepickerend[0] == "01"){$monthTH2 = "มกราคม";
                }else if($datepickerend[0] == "02"){$monthTH2 = "กุมภาพันธ์";
                }else if($datepickerend[0] == "03"){$monthTH2 = "มีนาคม";
                }else if($datepickerend[0] == "04"){$monthTH2 = "เมษายน";
                }else if($datepickerend[0] == "05"){$monthTH2 = "พฤษภาคม";
                }else if($datepickerend[0] == "06"){$monthTH2 = "มิถุนายน";
                }else if($datepickerend[0] == "07"){$monthTH2 = "กรกฎาคม";
                }else if($datepickerend[0] == "08"){$monthTH2 = "สิงหาคม";
                }else if($datepickerend[0] == "09"){$monthTH2 = "กันยายน";
                }else if($datepickerend[0] == "10"){$monthTH2 = "ตุลาคม";
                }else if($datepickerend[0] == "11"){$monthTH2 = "พฤศจิกายน";
                }else if($datepickerend[0] == "12"){$monthTH2 = "ธันวาคม";
                }

                // $modelname = Maincenter::databranchbycode($data['branch_id']);

                // $compid = $modelname[0]->company_id;
                // $sqlcompany = "SELECT * FROM $db[hr_base].working_company  WHERE id ='$compid' ";
                // $datacomp = DB::connection('mysql')->select($sqlcompany);

                // $branch_id = $data['branch_id'];
                // $sql = "SELECT * FROM $db[hr_base].branch  WHERE code_branch ='$branch_id' ";
                // $databranch = DB::connection('mysql')->select($sql);

                $acc_code = $data['acc_code'];
                $sqlacc_code = "SELECT * FROM $db[admin_accdemo].accounttype  WHERE accounttypeno ='$acc_code' ";
                $datacc_code = DB::connection('mysql')->select($sqlacc_code);

            ?>

          <div class="row">
              <div class="col-md-12">
                  <div class="box box-primary">
                      <div class="breadcrumbs" id="breadcrumbs">
                          <ul class="breadcrumb">
                              <div align="center">
                              <table width="100%">
                                <tr>
                                  <td align="center" ><b>บริษัท ฟ้าใสคอนสตรัคชั่นทูลส์ จำกัด </b></td>
                                </tr>

                                <tr>
                                  <td align="center" ><b>บัญชีแยกประเภท {{$datacc_code[0]->accounttypefull}} ({{$datacc_code[0]->accounttypeno}})</b></td>
                                </tr>

                                <tr>
                                  <td align="center" ><b>ตั้งแต่วันที่ {{$datepickerstart[1]}} {{$monthTH}} {{$datepickerstart[2]}} จนถึงวันที่ {{$datepickerend[1]}} {{$monthTH2}} {{$datepickerend[2]}}</b></td>
                                </tr>
                              </table>
              </div>
              </div>
              </ul><!-- /.breadcrumb -->
              <!-- /section:basics/content.searchbox -->
              </div>

							<div align="center">
							<?php

              $data = Input::all();
              $db = Connectdb::Databaseall();

              $datepicker = explode("-",trim(($data['reservation'])));

              // $start_date = $datepicker[0];
              $e1 = explode("/",trim(($datepicker[0])));
                      if(count($e1) > 0) {
                          $start_date = $e1[2] . '-' . $e1[0] . '-' . $e1[1]; //ปี - เดือน - วัน
                          $start_date2 = $start_date." 00:00:00";

                          $olds =$e1[2]; //ปี
                          $old = "01/01/" .$olds;
                      }

              // $end_date = $datepicker[1];
              $e2 = explode("/",trim(($datepicker[1])));
                      if(count($e2) > 0) {
                          $end_date = $e2[2] . '-' . $e2[0] . '-' . $e2[1]; //ปี - เดือน - วัน
                          $end_date2 = $end_date." 23:59:59";
                      }

              // $branch_id = $data['branch_id'];

              //กรณี เพิ่มข้อมูลเล่มทั่วไป โดยไม่กดปิดบัญชี balance_forward_status = 0
              $sql = 'SELECT '.$db['fsctaccount'].'.ledger.*
                      FROM '.$db['fsctaccount'].'.ledger

                      WHERE '.$db['fsctaccount'].'.ledger.acc_code = '.$acc_code.'
                        AND '.$db['fsctaccount'].'.ledger.timestamp BETWEEN "'.$start_date2.'" AND  "'.$end_date2.'"
                        AND '.$db['fsctaccount'].'.ledger.balance_forward_status = 0
                        AND '.$db['fsctaccount'].'.ledger.status != 99
                        ';
              $datatresult = DB::connection('mysql')->select($sql);
              // echo "<pre>";
              // print_r($datatresult);
              // exit;

              ?>

              <div align="center" >
              <table class="table table-bordered" width="100%" border="1" cellspacing="0">
                  <thead class="thead-inverse" >
                  <tr>
                    <!-- <th>No.</th> -->
                    <th align="center">Type</th>
                    <th align="center">Date</th>
                    <th align="center">Num</th>
                    <th align="center">Adj.</th>
                    <th align="center">Memo</th>
                    <th align="center">Split</th>
                    <th align="center">Debit</th>
                    <th align="center">Credit</th>
                    <th align="center">Balance</th>
                  </tr>
                  </thead>
                  <tbody>

                  <?php
                  $sumgrandtotal_debit = 0;
                  $sumgrandtotal_credit = 0;
                  $sumdebit_brought = 0;
                  $sumcredit_brought = 0;

                  $i = 1;
                  $sumgrandtotal = 0;
                  $sumdebit = 0;
                  $sumcredit = 0;
                  ?>

                  <tr>
                    <td></td>
                    <td><?php echo $old;?></td>
                    <td></td>
                    <td></td>
                    <td><b>ยอดยกมา</b></td>
                    <td></td>
                    <td align="right"><b> <!--Debit-->
                      <?php
                        $modelbroughtforward = Maincenter::getdatabroughtforward($acc_code,$data['reservation']);
                              if($modelbroughtforward){
                                echo number_format($modelbroughtforward[0]->sumdebit,2);
                                $sumdebit_brought = $modelbroughtforward[0]->sumdebit;
                              }else {
                                echo "0.00";
                              }
                      ?>
                    </b></td>
                    <td align="right"><b> <!--Credit-->
                      <?php
                            if($modelbroughtforward){
                              echo number_format($modelbroughtforward[0]->sumcredit,2);
                              $sumcredit_brought = $modelbroughtforward[0]->sumcredit;
                            }else {
                              echo "0.00";
                            }
                      ?>
                    </b></td>
                    <td align="right"> <!--Balance-->
                      <?php
                      // if($modelbroughtforward){
                      //   if($modelbroughtforward[0]->sumdebit != 0){
                      //     echo number_format ($modelbroughtforward[0]->sumdebit,2);
                      //     $sumgrandtotal_debit = $sumgrandtotal_debit + $modelbroughtforward[0]->sumdebit;
                      //
                      //   }elseif ($modelbroughtforward[0]->sumdebit == 0) {
                      //     echo number_format ($modelbroughtforward[0]->sumcredit,2);
                      //     $sumgrandtotal_credit = $sumgrandtotal_credit + $modelbroughtforward[0]->sumcredit;
                      //   }
                      // }else {
                      //   // echo "0.00";
                      // }
                      ?>
                    </td>
                  </tr>

                  <?php
                  foreach ($datatresult as $key => $value) { ?>
                  <tr>

                     <td><center><!--Type-->
                       <?php
                       if($value->type_journal == 1) {
                           echo "ซื้อ";
                       }elseif ($value->type_journal == 2) {
                           echo "ขาย";
                       }elseif ($value->type_journal == 3) {
                           echo "จ่าย";
                       }elseif ($value->type_journal == 4) {
                           echo "รับ";
                       }elseif ($value->type_journal == 5) {
                           echo "ทั่วไป";
                       }else {
                           echo "-";
                       }
                       ?>
                     </td></center>
                     <td><!--วันที่-->
                       <?php
                         $timestamp = explode(" ",trim($value->timestamp));
                         $time = explode("-",trim($timestamp[0])); //วัน-เดือน-ปี
                         $timeall = $time[2] . '-' . $time[1] . '-' . $time[0]; //วัน - เดือน - ปี
                         echo $timeall;
                       ?>
                     </td>
                     <td><?php echo ($value->number_bill);?></td><!--เลขที่เอกสาร-->
                     <td><center><!--Adj.-->
                       <?php
                             if($value->type_journal == 5){
                       ?>    <i class="fa fa-check" style="color:green;font-size:20px;"></i>
                       <?php }else {
                               echo "-";
                             };
                       ?>
                     </td></center>
                     <td><?php echo ($value->list);?></td><!--คำอธิบาย-->
                     <td><?php echo ($value->acc_code);?></td><!--Split-->

                     <td align="right"><!--Debit-->
                       <?php
                       echo ($value->dr);
                       $sumdebit = $sumdebit + $value->dr;
                       ?>
                     </td>

                     <td align="right"><!--Credit-->
                       <?php
                       echo ($value->cr);
                       $sumcredit = $sumcredit + $value->cr;
                       ?>
                     </td>

                     <td align="right"><!--Balance-->
                       <?php
                         if($value->dr != 0){
                           echo number_format (($value->dr + $value->cr) + $sumgrandtotal,2);
                           $sumgrandtotal = ($value->dr + $value->cr) + $sumgrandtotal;

                         }elseif ($value->dr == 0) {
                           echo number_format ($sumgrandtotal - ($value->dr + $value->cr),2);
                           $sumgrandtotal = $sumgrandtotal - ($value->dr + $value->cr);
                         }

                         // echo number_format (($value->dr + $value->cr) - $sumgrandtotal,2);
                         // $sumgrandtotal = $sumgrandtotal - ($value->dr + $value->cr);
                       ?>
                     </td>
                  </tr>

                  <?php $i++; } ?>

                        <tr>
                          <td colspan="5" align="right"></td>
                          <td><b>รวม</b></td>
                          <td align="right"><b><?php echo number_format($sumdebit + $sumdebit_brought,2); ?></b></td>
                          <td align="right"><b><?php echo number_format($sumcredit + $sumcredit_brought,2); ?></b></td>
                          <td align="right"><b>
                            <?php
                            if(($sumdebit + $sumdebit_brought) > ($sumcredit + $sumcredit_brought)){
                              echo number_format(($sumdebit + $sumdebit_brought) - ($sumcredit + $sumcredit_brought),2);
                            }elseif(($sumdebit + $sumdebit_brought) < ($sumcredit + $sumcredit_brought)) {
                              echo number_format(($sumcredit + $sumcredit_brought) - ($sumdebit + $sumdebit_brought),2);
                            }
                            // echo number_format($sumgrandtotal,2);
                            ?>
                          </b></td>
                        </tr>

                        </tbody>
                     </table>
                     <!-- </font> -->

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
