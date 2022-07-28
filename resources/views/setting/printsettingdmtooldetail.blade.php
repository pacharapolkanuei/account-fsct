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
        $sql = "SELECT * FROM $db[fsctaccount].po_head  WHERE id ='$id' ";
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

    <center><h3>ใบสั่งซื้อ/Purchase Order </h3></center>
    <?php
    // print_r($datahead[0]->pr_id);
    // exit;
    //$datadetail = Vendorcenter::getdatadetailpr($datahead[0]->pr_id);

//    print_r($datadetail);
//    exit;

    $i= 0;

   // print_r($datadetail);
    ?>
    <table width="100%" border="0">
        <tr>
            <td width="50%" colspan="2"><font style="font-weight: bold">Date/วันที่  :{{$datahead[0]->date}}</font></td>
            <td width="50%" colspan="2" align="right"><font style="font-weight: bold">PO NO./เลขที่ใบขออนุมัติซื้อ  :</font>{{$datahead[0]->po_number}}</td>
        </tr>
        <tr>
            <td width="50%" colspan="2"><font style="font-weight: bold">Seller/ผู้ขาย  :
                   <?php
                    $data = Vendorcenter::getdatavendorcenter($datahead[0]->supplier_id);
                    print_r($data[0]->pre.'  '.$data[0]->name_supplier);

                   ?>
                </font></td>
            <td width="50%" colspan="2" align="right"><font style="font-weight: bold"></td>
        </tr>
        <tr>
            <td width="100%" colspan="4"><font style="font-weight: bold">Address/ที่อยู่ :
                <?php
                    print_r($data[0]->address .'  ตำบล  '.$data[0]->district.'  อำเภอ  '.$data[0]->amphur.'  จังหวัด  '.$data[0]->province);

                    print_r('รหัสไปรษณีย์  '.$data[0]->zipcode .' โทรศัพท์ '.$data[0]->phone);

                ?>
                </font>
            </td>
        </tr>
    </table>
    <br>
    <?php
    $datadetail = Vendorcenter::getdatapodetail($datahead[0]->id);
    $i = 0;

     $arrwhd = [];
     $arrTotal = [];
     ?>
    <table width="100%" border="1"  cellspacing="0" cellpadding="0">
        <tr valign="top">
            <td width="3%" align="center" bgcolor="#dcdcdc">#</td>
            <td width="25%" align="center"  bgcolor="#dcdcdc">รายการ</td>
            <td width="12%" align="center"  bgcolor="#dcdcdc">ราคาต่อหน่วย</td>
            <td width="10%" align="center"  bgcolor="#dcdcdc">จำนวน</td>
            <td width="10%" align="center"  bgcolor="#dcdcdc">รวม</td>

        </tr>
        <?php foreach ($datadetail as $key => $value){?>
        <tr>
          <td align="center">  <?php echo $i+1; ?></td>
          <td>&nbsp;&nbsp;<?php echo $value->list.'&nbsp;&nbsp;&nbsp;'.$value->type_amount;?></td>
          <td align="center"><?php echo number_format($value->price,2);?></td>
          <td align="center"><?php echo $value->amount;?></td>
          <td align="center"><?php
          $arrTotal[] = $value->total;
          echo number_format($value->total,2);?>
          </td>

        </tr>
      <?php $i++; } ?>
        <tr>
          <td colspan="2" class="no-border-bottom-and-top"></td>
          <td align="center" colspan="2" bgcolor="#dcdcdc">รวม ภาษีหัก ณ ที่จ่าย</td>
          <td align="center"><?php $totalwdh = (array_sum($arrTotal)*($datahead[0]->whd/100));
                    echo number_format($totalwdh,2);
            ?>
          </td>
        </tr>
        <tr>
          <td colspan="2" class="no-border-bottom-and-top"></td>
          <td align="center" colspan="2" bgcolor="#dcdcdc"> ภาษี <?php print_r($datahead[0]->vat) ?> % (บาท)</td>
          <td align="center"><?php
                $totalvat = (array_sum($arrTotal)*($datahead[0]->vat/100));
            echo number_format($totalvat,2);?>
          </td>
        </tr>
        <tr>
          <td colspan="2" class="no-top" align="center">
            <?php
                $totalbeforecal = (float)array_sum($arrTotal) + (float)$totalvat - (float)$totalwdh;

              echo "<b>( ".(Accountcenter::converttobath(number_format($totalbeforecal,2)))." )</b>";
             ?>
          </td>
          <td align="center" colspan="2" bgcolor="#dcdcdc"> รวม สุทธิ (บาท)</td>
          <td align="center"><?php
              echo number_format($totalbeforecal,2);
          ?></td>
        </tr>
    </table>
    <br>
    <br>

    <table width="100%" border="0">
        <tr>
            <td width="10%" valign="top"><b>หมายเหตุ</b></td>
            <td width="90%">Price are included VAT / ราคาที่สั่งซื้อ เป็นราคาที่ได้รวมภาษีมูลค่าเพิ่มไว้แล้ว <br>
                Please refer the Purchase Order No. at each Delivery Note/Invoice. กรุณาระบุหมายเลขใบสั่งซื้อทุกครั้งในใบส่งสินค้า/ใบแจ้งหนี้<br>
                Please issue the receipt in the name of <b><?php print_r($datacompany[0]->name_eng)?></b><br>
                กรุณาออกใบเสร็จรับเงินในนาม <b><?php print_r($datacompany[0]->name)?></b>


            </td>
        </tr>
    </table>

    <br>
    <br>
    <table width="100%" border="0">
        <tr>
            <td width="50%" align="center">
                ....................................................................................
            </td>
            <td width="50%" align="center">
                ....................................................................................
            </td>
        </tr>
        <tr>
            <td width="50%" align="center">

                (<?php

                $dataemp = Maincenter::getdatacompemp($datahead[0]->emp_code_po);
                // print_r($dataemp);
                // exit;
                print_r($dataemp[0]->nameth.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$dataemp[0]->surnameth);
                ?>)
            </td>
            <td width="50%" align="center">
              <?php  if(!empty($datahead[0]->code_emp_approve)){?>
                (
                <?php
                $dataempapproved = Maincenter::getdatacompemp($datahead[0]->code_emp_approve);
                //print_r($datahead[0]->code_emp_approve);
                print_r($dataempapproved[0]->nameth.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$dataempapproved[0]->surnameth);
                ?>
                )
                <?php } ?>
            </td>
        </tr>
        <tr>
            <td width="50%" align="center">
                ผู้สั่งซื้อ
            </td>
            <td width="50%" align="center">
                ผู้อนุมัติการสั่งซื้อ
            </td>
        </tr>
    </table>
</body>
</html>
