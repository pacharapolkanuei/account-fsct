<?php

use  App\Api\Connectdb;
use  App\Api\Accountcenter;
use  App\Api\Maincenter;
use  App\Api\Vendorcenter;
use  App\Api\DateTime;
$db = Connectdb::Databaseall();
?>
@extends('index')
@section('content')
<!-- End Sidebar -->

<!-- css data table -->
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css" />
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" />
<!-- SWAL -->
<script type="text/javascript" src="https://unpkg.com/sweetalert2@7.0.6/dist/sweetalert2.all.js"></script>
<!-- jquery account debt -->
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<script src="bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>

<link rel="stylesheet" href="bower_components/bootstrap-daterangepicker/daterangepicker.css">

<script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>

<script type="text/javascript" src = 'js/accountjs/reservemoney.js'></script>

<div class="content-page">
	<!-- Start content -->
  <div class="content">
       <div class="container-fluid">

					   <div class="row">
									<div class="col-xl-12">
											<div class="breadcrumb-holder" id="fontscontent">
													<h1 class="float-left">Account - FSCT</h1>
													<ol class="breadcrumb float-right">
													<li class="breadcrumb-item">งบกำไรขาดทุน</li>
													<li class="breadcrumb-item active">รายได้จากการขายหรือการให้บริการ</li>
													</ol>
													<div class="clearfix"></div>
											</div>
									</div>
						</div>
			<!-- end row -->

      <div class="row">
          <br>
      </div>


        <div class="col-md-6">
          <?php   if(isset($query)){ //echo $branch_id; ?>

            <?php  //if(isset($group_branch_acc_select) && $group_branch_acc_select != ''){?>
                    <!-- <a href="printcovertaxabb?group_branch_acc_select=<?php //echo $group_branch_acc_select ;?>&&datepickerstart=<?php //echo $datepicker2['start_date'];?>&&datepickerend=<?php  //echo $datepicker2['end_date'];?>"><img src="images/global/printall.png"></a> -->
            <?php //}else { ?>
            <?php //$path = '&branch_id='.$branch_id?>
                    <!-- <a href="<?php //echo url("/excelreportaccruedall?$path");?>" target="_blank"><img src="images/global/printall.png"></a> -->
                    <!-- <a href="printprofitloss_statement_day?branch_id=<?php //echo $branch_id;?>&&reservation=<?php //echo $datepicker;?>" target="_blank" ><img src="images/global/printall.png"></a> -->
            <?php //} ?>

          <?php } ?>
        </div>

        <div class="row">
            <br>
        </div>

        <div class="row"  style="overflow-x:auto;">
        <div class="col-md-12" >
          <?php
          if(isset($query)){
              // echo "<pre>";
              // print_r($data);
              // print_r($datatold);
              $arraydata = [];
              $arraydataold = [];
              // print_r($datepicker);
              // // print_r($branch_id);

              foreach ($data as $key => $value) {
                  $arraydata[$key]=$value->branch;
              }

              foreach ($datatold as $key => $value) {
                  $arraydataold[$key]=$value->branch;
              }
              // print_r($arraydata);
              // print_r($arraydataold);
              $array_merge_branch = array_unique(array_merge($arraydata,$arraydataold));
              // print_r($array_merge);
              // exit;
              $datepickerthis = explode("-",trim(($datepicker)));

                // $start_date = $datepicker[0];
                $e1 = explode("/",trim(($datepickerthis[0])));
                        if(count($e1) > 0) {
                            $start_date = $e1[2] . '-' . $e1[0] . '-' . $e1[1]." 00:00:00"; //ปี - เดือน - วัน
                            $start_dateold = $e1[2]-1; //ปี - เดือน - วัน (ปีเก่า)
                        }

                // $end_date = $datepicker[1];
                $e2 = explode("/",trim(($datepickerthis[1])));
                        if(count($e2) > 0) {
                            $end_date = $e2[2] . '-' . $e2[0] . '-' . $e2[1]." 23:59:59"; //ปี - เดือน - วัน
                        }

              // $branch_id = $data['branch_id'];
              // $acc_code = $data['acc_code'];


              $datepicker_sub = explode("-",trim($datepicker));

              $datepickerstart = explode("/",trim(($datepicker_sub[0])));
              if(count($datepickerstart) > 0) {
                  $datetime = $datepickerstart[1] . '-' . $datepickerstart[0]; //วัน - เดือน
              }

              $datepickerend = explode("/",trim(($datepicker_sub[1])));
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

            ?>

            <!-- <form action="configreportcashdailynow" onSubmit="if(!confirm('ยืนยันการทำรายการ?')){return false;}" method="post" class="form-horizontal"> -->
            <!-- <input type="hidden" name="_token" value="{{ csrf_token() }}"> -->
            <form action="saveapprovedpo" method="post" enctype="multipart/form-data" onSubmit="JavaScript:return fncSubmit();">
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <!-- <table class="table table-striped"> -->
            <table class="table table-striped " style="width:100%">

                 <tr>
                   <td rowspan="2" width="40%"></td>
                   <td colspan="1" align="right"><b>หน่วย: แสดงตามจริง (Actuals),บาท</b></td>
                 </tr>

                 <tr>
                     <td><b><center><?php echo $datepickerstart[1]." ".$monthTH." ".$datepickerstart[2];?> - <?php echo $datepickerend[1]." ".$monthTH2." ".$datepickerend[2];?></center></b></td>
                 </tr>

               <?php
               $i = 1;

               //รายได้
               $sumincome_other_dr = 0; //รายได้ค่าเช่า - อาคาร
               $sumincome_other_cr = 0; //รายได้ค่าเช่า - อาคาร

//-----------------------------------ยอดยกมา-----------------------------------
               //รายได้
               $sumincome_other_old_dr = 0; //รายได้
               $sumincome_other_old_cr = 0; //รายได้

//-----------------------------------รวม----------------------------------------
               $totalincome_other =0;

               // foreach ($data as $key => $value) { ?>

               <!-- รายได้อื่น -->
               <?php //รายได้อื่น
                 // if($value->acc_code == 421101){ //รายได้อื่น
                 //         $sumincome_other_dr = $sumincome_other_dr + $value->sumdebit;
                 //         $sumincome_other_cr = $sumincome_other_cr + $value->sumcredit;
                 // }
               ?>
               <!-- รายได้ -->
               <?php //$i++; } ?>

               <?php
               //ยอดยกมา
               //foreach ($datatold as $key2 => $value2) { ?>

               <!-- รายได้อื่น -->
               <?php //รายได้อื่น
                 // if($value2->acc_code == 421101){ //รายได้อื่น
                 //         $sumincome_other_old_dr = $sumincome_other_old_dr + $value2->sumdebit;
                 //         $sumincome_other_old_cr = $sumincome_other_old_cr + $value2->sumcredit;
                 // }
               ?>

               <?php //$i++; } ?>

               <?php
               // //รายได้อื่น
               // if(($sumincome_other_dr + $sumincome_other_old_dr) > ($sumincome_other_cr + $sumincome_other_old_cr)){
               //     $totalincome_other = ($sumincome_other_dr + $sumincome_other_old_dr) - ($sumincome_other_cr + $sumincome_other_old_cr);
               // }elseif (($sumincome_other_dr + $sumincome_other_old_dr) < ($sumincome_other_cr + $sumincome_other_old_cr)) {
               //     $totalincome_other = ($sumincome_other_cr + $sumincome_other_old_cr) - ($sumincome_other_dr + $sumincome_other_old_dr);
               // }
               ?>

               </form>

               <tr>
                 <td ><b><?php echo "รายได้อื่น"?></b></td>
                 <td>
                     <table width="100%" >
                        <tr>
                            <?php

                            foreach ($array_merge_branch as $k => $v) {
                            ?>
                              <td>
                                <?php //echo $v;
                                $modelbranch = Maincenter::databranchbycode($v);
                                if($modelbranch){
                                    echo "<b>".$modelbranch[0]->name_branch."</b>";
                                }
                                ?>
                              </td>
                          <?php } ?>
                        </tr>
                     </table>

                 </td>
               </tr>

               <tr>
                 <td ><?php echo "&nbsp;&nbsp;รายได้อื่น"?></td>
                 <td>
                   <table width="100%" >
                      <tr>
                          <?php

                          foreach ($array_merge_branch as $k => $v) {
                          ?>
                            <td>
                              <?php  // $v; //421101
                               $sqlthis = 'SELECT '.$db['fsctaccount'].'.ledger.*,
                                               SUM('.$db['fsctaccount'].'.ledger.dr) as sumdebit,
                                               SUM('.$db['fsctaccount'].'.ledger.cr) as sumcredit

                                            FROM '.$db['fsctaccount'].'.ledger

                                            WHERE '.$db['fsctaccount'].'.ledger.timestamp  BETWEEN "'.$start_date.'" AND  "'.$end_date.'"
                                              AND '.$db['fsctaccount'].'.ledger.balance_forward_status = 0
                                              AND '.$db['fsctaccount'].'.ledger.status != 99
                                              AND '.$db['fsctaccount'].'.ledger.branch = "'.$v.'"
                                              AND '.$db['fsctaccount'].'.ledger.acc_code = "421101"
                                            ';
                                $datathisresult = DB::select($sqlthis);


                                $sqloldthis = 'SELECT '.$db['fsctaccount'].'.ledger.*,
                                                 SUM('.$db['fsctaccount'].'.ledger.dr) as sumdebit,
                                                 SUM('.$db['fsctaccount'].'.ledger.cr) as sumcredit

                                              FROM '.$db['fsctaccount'].'.ledger

                                              WHERE '.$db['fsctaccount'].'.ledger.timestamp LIKE "'.$start_dateold.'%"
                                                AND '.$db['fsctaccount'].'.ledger.balance_forward_status = 1
                                                AND '.$db['fsctaccount'].'.ledger.type_journal = 5
                                                AND '.$db['fsctaccount'].'.ledger.status != 99
                                                AND '.$db['fsctaccount'].'.ledger.branch = "'.$v.'"
                                                AND '.$db['fsctaccount'].'.ledger.acc_code = "421101"
                                              ';

                                $datatoldthis = DB::select($sqloldthis);

                                $sumincome_other_dr = $datathisresult[0]->sumdebit;
                                $sumincome_other_cr = $datathisresult[0]->sumcredit;

                                $sumincome_other_old_dr = $datatoldthis[0]->sumdebit;
                                $sumincome_other_old_cr = $datatoldthis[0]->sumcredit;

                                // //รายได้อื่น
                                if(($sumincome_other_dr + $sumincome_other_old_dr) > ($sumincome_other_cr + $sumincome_other_old_cr)){
                                    $totalincome_other = ($sumincome_other_dr + $sumincome_other_old_dr) - ($sumincome_other_cr + $sumincome_other_old_cr);
                                }elseif (($sumincome_other_dr + $sumincome_other_old_dr) < ($sumincome_other_cr + $sumincome_other_old_cr)) {
                                    $totalincome_other = ($sumincome_other_cr + $sumincome_other_old_cr) - ($sumincome_other_dr + $sumincome_other_old_dr);
                                }

                                echo number_format($totalincome_other,2);
                              ?>
                            </td>
                        <?php } ?>
                      </tr>
                   </table>

                 </td>
               </tr>




               <!-- <tr><td colspan="3"><b><?php //echo "รายได้"?></b></td></tr>
               <tr>
                 <td><b><?php //echo "รายได้อื่น"?></b>
                  <?php
                        // echo "<br>";
                        // echo "&nbsp;&nbsp;รายได้อื่น";
                  ?>
                 </td>
                 <td></td>
                 <td align="right">
                 <?php
                       // echo "<br>";
                       //       echo number_format ($totalincome_other,2);
                       // echo "<br>";
                       //       echo ("");
                 ?>
                </td>
               </tr> -->
              <!-- </tbody>
             </table> -->


             <?php  }  ?>

            </div>
         </div>

		  </div>
		<!-- END content -->
  </div>
	<!-- END content-page -->
</div>
<!-- END main -->
@endsection
