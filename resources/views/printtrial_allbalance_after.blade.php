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
                //
                // $branch_id = $data['branch_id'];
                // $sql = "SELECT * FROM $db[hr_base].branch  WHERE code_branch ='$branch_id' ";
                // $databranch = DB::connection('mysql')->select($sql);

                // $acc_code = $data['acc_code'];
                // $sqlacc_code = "SELECT * FROM $db[admin_accdemo].accounttype  WHERE accounttypeno ='$acc_code' ";
                // $datacc_code = DB::connection('mysql')->select($sqlacc_code);

            ?>

          <div class="row">
              <div class="col-md-12">
                  <div class="box box-primary">
                      <div class="breadcrumbs" id="breadcrumbs">
                          <ul class="breadcrumb">
                              <div align="center">
                              <table width="100%">
                                <tr>
                                  <td align="center" ><b>บริษัท ฟ้าใสคอนสตรัคชั่นทูลส์ จำกัด</b></td>
                                </tr>

                                <tr>
                                  <td align="center" ><b>งบทดลองหลังปิดบัญชี</b></td>
                                </tr>

                                <tr>
                                  <td align="center" ><b>ตั้งแต่วันที่ <?php echo $datepickerstart[1]." ".$monthTH." ".$datepickerstart[2];?> จนถึงวันที่ <?php echo $datepickerend[1]." ".$monthTH2." ".$datepickerend[2];?></b></td>
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
                      }

              // $end_date = $datepicker[1];
              $e2 = explode("/",trim(($datepicker[1])));
                      if(count($e2) > 0) {
                          $end_date = $e2[2] . '-' . $e2[0] . '-' . $e2[1]; //ปี - เดือน - วัน
                          $end_date2 = $end_date." 23:59:59";
                      }

              // $branch_id = $data['branch_id'];
              //
              // $sql = 'SELECT '.$db['fsctaccount'].'.accounttype.*
              //         FROM '.$db['fsctaccount'].'.accounttype
              //
              //         WHERE '.$db['fsctaccount'].'.accounttype.status != 99
              //           ';
              // $datatresult = DB::connection('mysql')->select($sql);

              $sql = 'SELECT '.$db['fsctaccount'].'.ledger.acc_code
                            FROM '.$db['fsctaccount'].'.ledger

                            WHERE '.$db['fsctaccount'].'.ledger.timestamp  BETWEEN "'.$start_date2.'" AND  "'.$end_date2.'"
                              AND '.$db['fsctaccount'].'.ledger.status != 99
                            GROUP BY '.$db['fsctaccount'].'.ledger.acc_code
                            ';

              $datatresult = DB::select($sql);
              // echo "<pre>";
              // print_r($datatresult);
              // exit;

              ?>

              <div align="center" >
              <table class="table table-bordered" width="100%" border="1" cellspacing="0">
                  <thead class="thead-inverse" >
                  <tr>
                    <th align="center">Name</th>
                    <th align="center">Account code</th>
                    <th align="center">Debit</th>
                    <th align="center">Credit</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php

                  $i = 1;
                  $sumgrandtotal = 0;
                  $sumdebit = 0;
                  $sumcredit = 0;

                  foreach ($datatresult as $key => $value) { ?>

                  <tr>
                    <?php $modelaccounttype = Maincenter::dataaccounttype($value->acc_code);?>
                    <td><?php if($modelaccounttype){ echo $modelaccounttype[0]->accounttypefull; }?></td><!--Name-->
                    <td><?php echo ($value->acc_code);?></td><!--Account code-->

                     <?php
                     // $modelaccount_name = Maincenter::getdataaccount_name_all_after($value->accounttypeno,$data['reservation']);
                     // $modelbroughtforward = Maincenter::getdatabroughtforward($value->accounttypeno,$data['reservation']);

                     $modelaccount_name = Maincenter::getdataaccount_name_all_after($value->acc_code,$data['reservation']); //กรณี ไม่เอาหมวด 1 2 3
                     $modelaccount_name_select = Maincenter::getdataaccount_name_all_after_select($value->acc_code,$data['reservation']); //กรณี ข้อมูลของหมวดที่ 1 2 3
                     $modelbroughtforward = Maincenter::getdatabroughtforward($value->acc_code,$data['reservation']); //กรณี มียอดยกมา
                     // if($modelaccount_name){
                     //       echo "debit";
                     //       // echo $modelaccount_name[0]->accounttypeno;
                     // }
                     ?>

                     <td align="right"><!--Debit-->
                       <?php
                       if($modelbroughtforward){
                         if($modelaccount_name){
                           if(($modelaccount_name[0]->sumdebit + $modelbroughtforward[0]->sumdebit) > ($modelaccount_name[0]->sumcredit + $modelbroughtforward[0]->sumcredit)){
                                 echo number_format (($modelaccount_name[0]->sumdebit + $modelbroughtforward[0]->sumdebit) - ($modelaccount_name[0]->sumcredit + $modelbroughtforward[0]->sumcredit),2);
                                 $sumdebit = $sumdebit + (($modelaccount_name[0]->sumdebit + $modelbroughtforward[0]->sumdebit) - ($modelaccount_name[0]->sumcredit + $modelbroughtforward[0]->sumcredit));
                           }
                         }else if($modelaccount_name_select){
                             if($modelaccount_name_select[0]->sumdebit > $modelaccount_name_select[0]->sumcredit){
                                   echo number_format ($modelaccount_name_select[0]->sumdebit - $modelaccount_name_select[0]->sumcredit,2);
                                   $sumdebit = $sumdebit + ($modelaccount_name_select[0]->sumdebit - $modelaccount_name_select[0]->sumcredit);
                             }
                         }
                       }
                       else if($modelaccount_name){
                           if($modelaccount_name[0]->sumdebit > $modelaccount_name[0]->sumcredit){
                                 echo number_format ($modelaccount_name[0]->sumdebit - $modelaccount_name[0]->sumcredit,2);
                                 $sumdebit = $sumdebit + ($modelaccount_name[0]->sumdebit - $modelaccount_name[0]->sumcredit);
                           }
                       }
                       else if($modelaccount_name_select){
                           if($modelaccount_name_select[0]->sumdebit > $modelaccount_name_select[0]->sumcredit){
                                 echo number_format ($modelaccount_name_select[0]->sumdebit - $modelaccount_name_select[0]->sumcredit,2);
                                 $sumdebit = $sumdebit + ($modelaccount_name_select[0]->sumdebit - $modelaccount_name_select[0]->sumcredit);
                           }
                       }
                       ?>
                     </td>

                     <td align="right"><!--Credit-->
                       <?php
                       if($modelbroughtforward){
                         if($modelaccount_name){
                           if(($modelaccount_name[0]->sumdebit + $modelbroughtforward[0]->sumdebit) < ($modelaccount_name[0]->sumcredit + $modelbroughtforward[0]->sumcredit)){
                                 echo number_format (($modelaccount_name[0]->sumcredit + $modelbroughtforward[0]->sumcredit) - ($modelaccount_name[0]->sumdebit + $modelbroughtforward[0]->sumdebit),2);
                                 $sumcredit = $sumcredit + (($modelaccount_name[0]->sumcredit + $modelbroughtforward[0]->sumcredit) - ($modelaccount_name[0]->sumdebit + $modelbroughtforward[0]->sumdebit));
                           }
                         }
                         else if($modelaccount_name_select){
                           if($modelaccount_name_select[0]->sumdebit < $modelaccount_name_select[0]->sumcredit){
                                 echo number_format ($modelaccount_name_select[0]->sumcredit - $modelaccount_name_select[0]->sumdebit,2);
                                 $sumcredit = $sumcredit + ($modelaccount_name_select[0]->sumcredit - $modelaccount_name_select[0]->sumdebit);
                           }
                         }
                       }
                       else if($modelaccount_name){
                         if($modelaccount_name[0]->sumdebit < $modelaccount_name[0]->sumcredit){
                               echo number_format ($modelaccount_name[0]->sumcredit - $modelaccount_name[0]->sumdebit,2);
                               $sumcredit = $sumcredit + ($modelaccount_name[0]->sumcredit - $modelaccount_name[0]->sumdebit);
                         }
                       }else if($modelaccount_name_select){
                         if($modelaccount_name_select[0]->sumdebit < $modelaccount_name_select[0]->sumcredit){
                               echo number_format ($modelaccount_name_select[0]->sumcredit - $modelaccount_name_select[0]->sumdebit,2);
                               $sumcredit = $sumcredit + ($modelaccount_name_select[0]->sumcredit - $modelaccount_name_select[0]->sumdebit);
                         }
                       }
                       ?>
                     </td>

                  </tr>
                  </form>

                <?php $i++; } ?>

                   <tr>
                     <td></td>
                     <td><b>รวม</b></td>
                     <td align="right"><b><?php echo number_format($sumdebit,2); ?></b></td>
                     <td align="right"><b><?php echo number_format($sumcredit,2); ?></b></td>
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
