<?php
use  App\Api\Connectdb;
use  App\Api\Accountcenter;
use  App\Api\Maincenter;
use  App\Api\Vendorcenter;
use Illuminate\Support\Facades\Input;
?>
<html>
<head>
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
        }
        h4 {
            font-family: "THSarabunNew";
        }
        h4 {
            font-family: "THSarabunNew";
        }


        .container table {
        border-collapse: collapse;
        border: solid 1px #000;
        }
        .container table td {
        border: solid 1px #000;
        }
        .no-border-left-and-bottom {
        border-left: solid 1px #FFF!important;
        border-bottom: solid 1px #FFF!important;
        }
        .no-border-left-and-bottom-and-top {
        border-left: solid 1px #FFF!important;
        border-bottom: solid 1px #FFF!important;
        border-top: solid 1px #FFF!important;
        }
        .no-border-bottom-and-top {
        border-bottom: solid 1px #FFF!important;
        border-top: solid 1px #FFF!important;
        }
        .no-top{
        border-top: solid 1px #FFF!important;
        }
    </style>
</head>
<body>
    <?php
        $db = Connectdb::Databaseall();
        $data = Input::all();
        $id = $data['id'];
        $connect1 = Connectdb::Databaseall();
        $baseAc1 = $connect1['fsctaccount'];
        $sql2 = "SELECT $baseAc1.bill_of_lading_head.*,
                        $baseAc1.bill_of_lading_detail.*,
                        $baseAc1.po_to_asset.po_number,
                        $baseAc1.po_head.id as idpo
                FROM $baseAc1.bill_of_lading_head
                INNER JOIN $baseAc1.bill_of_lading_detail
                ON $baseAc1.bill_of_lading_head.id = $baseAc1.bill_of_lading_detail.bill_of_lading_head
                INNER JOIN $baseAc1.po_to_asset
                ON $baseAc1.po_to_asset.id = $baseAc1.bill_of_lading_head.po_to_asset_id
                INNER JOIN $baseAc1.po_head
                ON $baseAc1.po_head.po_number = $baseAc1.po_to_asset.po_number
                WHERE $baseAc1.bill_of_lading_head.status != '99'
                AND $baseAc1.bill_of_lading_head.id = '$id'";
        $datamain = DB::connection('mysql')->select($sql2);





        $idpo = $datamain[0]->idpo;
        $sql = "SELECT * FROM $db[fsctaccount].po_head  WHERE id ='$idpo' ";
        $datahead = DB::connection('mysql')->select($sql);
        $branch = $datahead[0]->branch_id;

        $dateset = '2020-06-30';
        $datenow = $datahead[0]->date;
        // exit;
        if($datenow>$dateset){
          // echo $branch_id;
          $sqlbranchgroup = "SELECT * FROM $db[fsctaccount].branch_group_withholdtaxpo
                             WHERE branch ='$branch'
                             AND status = '1' ";
          $databranchset = DB::connection('mysql')->select($sqlbranchgroup);
          // echo "<pre>";
          // print_r($databranchset);

          $branch = $databranchset[0]->branch_group;
          $sqlbranch = "SELECT * FROM $db[hr_base].branch  WHERE branch.code_branch ='$branch' ";
          $branchdata = DB::connection('mysql')->select($sqlbranch);

        }else{
          $sqlbranch = "SELECT * FROM $db[hr_base].branch  WHERE branch.code_branch ='$branch' ";
          $branchdata = DB::connection('mysql')->select($sqlbranch);
        }

        $baseHr = $connect1['hr_base'];
        $sql = "SELECT $baseAc1.emp_data_producttion.*,
                       $baseHr.WAGE_HISTORY.*,
                       $baseHr.emp_data.prefixth,
                       $baseHr.emp_data.nameth,
                       $baseHr.emp_data.surnameth
                FROM $baseAc1.bill_of_lading_head
                INNER JOIN $baseAc1.emp_data_producttion
                ON $baseAc1.emp_data_producttion.bill_of_lading_head_id = $baseAc1.bill_of_lading_head.id
                INNER JOIN $baseHr.WAGE_HISTORY
                ON $baseHr.WAGE_HISTORY.WAGE_ID = $baseAc1.emp_data_producttion.wage_his_pk
                INNER JOIN $baseHr.emp_data
                ON $baseHr.emp_data.idcard_no = $baseHr.WAGE_HISTORY.WAGE_EMP_ID
                WHERE $baseAc1.bill_of_lading_head.id = '$id'
                AND $baseAc1.emp_data_producttion.status = '1'";
        $getdatadetail = DB::select($sql);

        // $branchsql = "SELECT branch.* FROM $db[hr_base].branch  WHERE code_branch ='$branch' ";
        // $branchdata = DB::connection('mysql')->select($branchsql);
        // print_r($branchdata[0]->addresstax);
        // exit;

    ?>

    <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td width="10%">
                @if($datahead[0]->id_company==1)
                    <img src="images/company/1.png" width="275px" >
                @elseif($datahead[0]->id_company==2)
                    <img src="images/company/2.png" width="275px" >
                @endif
            </td>
            <td width="90%" valign="top" style="padding-top: -30px">
                <table width="100%">
                    <tr>
                        <td>
                            <?php $datacompany = Maincenter::datacompany($datahead[0]->id_company);?>
                            <h3><?php print_r($datacompany[0]->name_eng);

                                ?></h3>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-top: -55px">
                            <?php $datacompany = Maincenter::datacompany($datahead[0]->id_company);?>
                          <h4><?php print_r($datacompany[0]->name)?></h4>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-top: -35px">
                            <?php $datacompany = Maincenter::datacompany($datahead[0]->id_company);?>



                            <?php print_r($branchdata[0]->addresstax)?>



                        </td>
                    </tr>
                    <tr>
                        <td style="padding-top: -15px">
                           โทรศัพท์  <?php print_r($branchdata[0]->tel)?>
                           เลขประจำตัวผู้เสียภาษี <?php print_r($datacompany[0]->business_number)?>
                        </td>
                    </tr>
                </table>


            </td>
        </tr>
    </table>

    <center><h3>ตารางการจ่ายเงินเดือนและค่าแรง</h3></center>
    <?php
    // print_r($datahead[0]->pr_id);
    // exit;



//    print_r($datadetail);
//    exit;

    $i= 0;

   // print_r($datadetail);
    ?>
    <table width="100%" border="0">
        <tr>
            <td width="50%" colspan="2"><font style="font-weight: bold">Date/วันที่  :{{$datamain[0]->datetime}}</font></td>
            <td width="50%" colspan="2" align="right"><font style="font-weight: bold">NO./เลขที่ใบขอผลิต  :</font>{{$datamain[0]->number_bill}}</td>
        </tr>
        <tr>
            <td width="50%" colspan="2"><font style="font-weight: bold">LOT  : {{$datamain[0]->lot}}</font></td>
            <td width="50%" colspan="2" align="right"><font style="font-weight: bold"></td>
        </tr>
    </table>
    <br>
    <?php





    $datadetail = Vendorcenter::getdatapodetail($datahead[0]->id);
    $i = 0;

      $totalincome = 0;
      $totaldiff = 0;
      $totalpayout = 0;
     ?>
    <table width="100%" border="1"  cellspacing="0" cellpadding="0">
        <tr valign="top">
            <td  rowspan="2" align="center" bgcolor="#dcdcdc">#</td>
            <td  rowspan="2" align="center"  bgcolor="#dcdcdc">พนักงาน</td>
            <td  rowspan="2" align="center"  bgcolor="#dcdcdc">ชื่อตำแหน่ง</td>
            <td  colspan="4" align="center"  bgcolor="#dcdcdc">รายการจ่าย</td>
            <td  colspan="4" align="center"  bgcolor="#dcdcdc">รายการหัก</td>
            <td  rowspan="2" align="center"  bgcolor="#dcdcdc">เงินเดือนสุทธิ</td>
            <td  rowspan="2" align="center"  bgcolor="#dcdcdc">เงินเดือน/ค่าแรงพนักงานผลิต</td>
        </tr>

        <tr valign="top">

            <td  align="center" bgcolor="#dcdcdc">เงินเดือน</td>
            <td  align="center" bgcolor="#dcdcdc">ค่าล่วงเวลา</td>
            <td  align="center" bgcolor="#dcdcdc">รายรับอื่นๆ	</td>
            <td  align="center" bgcolor="#dcdcdc">รวมรายรับ	</td>
            <td  align="center" bgcolor="#dcdcdc">ประกันสังคม	</td>
            <td  align="center" bgcolor="#dcdcdc">ขาด/ลา	</td>
            <td  align="center" bgcolor="#dcdcdc">หักอื่นๆ</td>
            <td  align="center" bgcolor="#dcdcdc">รวมรายหัก</td>
        </tr>
        <?php
            $totalsalary = 0;
            $totalot = 0;
            $totalincomeetc = 0;
            $totalincomeall = 0;
            $totalsocialpay = 0;
            $totalleavepay = 0;
            $totalpayetc = 0;
            $totalpayall = 0;
            $totalpayreal = 0;
            $totalpaythisproduct = 0;


        $i=1; foreach ($getdatadetail as $key => $value) {?>
        <tr valign="top">
            <td  align="center" ><?php echo $i;?></td>
            <td  align="center" ><?php echo $value->prefixth.' '.$value->nameth.' '.$value->surnameth;?></td>
            <td  align="center" ><?php echo $value->WAGE_POSITION_NAME;?></td>
            <td  align="center" ><?php echo $totalsalary = $totalsalary+$value->salary;?></td>
            <td  align="center" >
                                <?php
                                  if(!empty($value->ot)){
                                    echo  $ot = $value->ot;
                                    $totalot = $totalot + $ot;
                                  }else{
                                    echo  $ot = 0;
                                    $totalot = $totalot + $ot;
                                  }
                                ?>
            </td>
            <td  align="center" >
                                <?php
                                  if(!empty($value->incomeetc)){
                                    echo  $incomeetc = $value->incomeetc;
                                    $totalincomeetc = $totalincomeetc + $incomeetc;
                                  }else{
                                    echo  $incomeetc = 0;
                                    $totalincomeetc = $totalincomeetc + $incomeetc;
                                  }
                                ?>
            </td>
            <td  align="center" ><?php echo $totalincomeall= $totalincomeall + $value->salary+ $ot + $incomeetc;?></td>
            <td  align="center" >
                                <?php
                                  if(!empty($value->socialpay)){
                                    echo  $socialpay = $value->socialpay;
                                    $totalsocialpay = $totalsocialpay + $socialpay;
                                  }else{
                                    echo  $socialpay = 0;
                                    $totalsocialpay = $totalsocialpay + $socialpay;
                                  }
                                ?>
            </td>
            <td  align="center" >
                                <?php
                                  if(!empty($value->leavepay)){
                                    echo  $leavepay = $value->leavepay;
                                    $totalleavepay = $totalleavepay + $leavepay;
                                  }else{
                                    echo  $leavepay = 0;
                                    $totalleavepay = $totalleavepay + $leavepay;
                                  }
                                ?>
            </td>
            <td  align="center" >
                                <?php
                                  if(!empty($value->payetc)){
                                    echo  $payetc = $value->payetc;
                                    $totalpayetc = $totalpayetc + $payetc;
                                  }else{
                                    echo  $payetc = 0;
                                    $totalpayetc = $totalpayetc + $payetc;
                                  }
                                ?>
            </td>
            <td  align="center" ><?php echo $totalpayall= $totalpayall + $socialpay + $leavepay + $payetc;?></td>
            <td  align="center" ><?php echo $totalpayreal= $totalpayreal + $value->payreal;?></td>
            <td  align="center" ><?php echo $totalpaythisproduct = $totalpaythisproduct + $value->paythisproduct;?></td>
        </tr>
        <?php $i++;} ?>
        <tr valign="top">
            <td  align="center" colspan="3" >รวม</td>
            <td  align="center" ><?php echo number_format($totalsalary,2);?></td>
            <td  align="center" ><?php echo number_format($totalot,2);?></td>
            <td  align="center" ><?php echo number_format($totalincomeetc,2);?></td>
            <td  align="center" ><?php echo number_format($totalincomeall,2);?></td>
            <td  align="center" ><?php echo number_format($totalsocialpay,2);?></td>
            <td  align="center" ><?php echo number_format($totalleavepay,2);?></td>
            <td  align="center" ><?php echo number_format($totalpayetc,2);?></td>
            <td  align="center" ><?php echo number_format($totalpayall,2);?></td>
            <td  align="center" ><?php echo number_format($totalpayreal,2);?></td>
            <td  align="center" ><?php echo number_format($totalpaythisproduct,2);?></td>
        </tr>
    </table>
    <br>
    <br>


    <br>
    <br>

</body>
</html>
