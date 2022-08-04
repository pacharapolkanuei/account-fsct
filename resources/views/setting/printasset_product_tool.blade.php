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
        $sql = "SELECT * FROM $db[fsctaccount].receiptasset  WHERE id ='$id' ";
        $datahead = DB::connection('mysql')->select($sql);


        // $branchsql = "SELECT branch.* FROM $db[hr_base].branch  WHERE code_branch ='$branch' ";
        // $branchdata = DB::connection('mysql')->select($branchsql);
        // print_r($branchdata[0]->addresstax);
        // exit;

    ?>

    <center><h3>รายงานต้นทุนการผลิต </h3></center>
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
            <td width="50%" colspan="2"><font style="font-weight: bold">Date/วันที่  :{{$datahead[0]->datein}}</font></td>
            <td width="50%" colspan="2" align="right"><font style="font-weight: bold">เลขที่เอกสาร :</font>{{$datahead[0]->receiptnum}}</td>
        </tr>
    </table>
    <br>
    <?php

    $i = 0;

     $arrwhd = [];
     $arrTotal = [];
     $connect1 = Connectdb::Databaseall();
     $baseAc1 = $connect1['fsctaccount'];
     $baseMan = $connect1['fsctmain'];
     $sql2 = "SELECT $baseAc1.receiptasset.*,
                     $baseAc1.receiptasset_detail.*,
                     $baseMan.material.name
            FROM $baseAc1.receiptasset
            INNER JOIN $baseAc1.receiptasset_detail
            ON $baseAc1.receiptasset.id = $baseAc1.receiptasset_detail.receiptasset_id
            INNER JOIN $baseMan.material
            ON $baseMan.material.id = $baseAc1.receiptasset_detail.material_id
            WHERE $baseAc1.receiptasset.status  = '1'
            AND $baseAc1.receiptasset.id =  '$id' ";

     $getdatadetail = DB::select($sql2);

     $totalpd = 0;
     $totalcost = 0;
     $totallastcost = 0;
     $totalsaraly = 0;
     $totalcostpd = 0;
     $totalcpu = 0;

     ?>
    <table width="100%" border="1"  cellspacing="0" cellpadding="0">
        <tr valign="top">
            <td width="5%" align="center" bgcolor="#dcdcdc">#</td>
            <td  align="center"  bgcolor="#dcdcdc">รายการ</td>
            <td  align="center"  bgcolor="#dcdcdc">ผลิตได้</td>
            <td  align="center"  bgcolor="#dcdcdc">ราคาทุนวัตถุดิบ</td>
            <td  align="center"  bgcolor="#dcdcdc">ต้นทุนวัตถุดิบที่ใช้ </td>
            <td  align="center"  bgcolor="#dcdcdc">เงินเดือน/ค่าแรงในการผลิต </td>
            <td  align="center"  bgcolor="#dcdcdc">รวมต้นทุนการผลิต </td>
            <td  align="center"  bgcolor="#dcdcdc">ต้นทุนการผลิตต่อหน่วย </td>
        </tr>

        <?php foreach ($getdatadetail as $key => $value) {?>
        <tr >
          <td width="5%" align="center"> <?php echo $i; ?> </td>
          <td  align="center" > <?php echo $value->name; ?> </td>
          <td  align="center" > <?php echo $value->produce; $totalpd= $totalpd+$value->produce; ?> </td>
          <td  align="center" > <?php echo $value->cost; $totalcost = $totalcost + $value->cost;?> </td>
          <td  align="center" > <?php echo $value->total_cost; $totallastcost = $totallastcost + $value->total_cost;?> </td>
          <td  align="center" > <?php echo $value->saraly; $totalsaraly = $totalsaraly + $value->saraly; ?> </td>
          <td  align="center" > <?php echo $value->total_cost_produce; $totalcostpd = $totalcostpd + $value->total_cost_produce;?> </td>
          <td  align="center" > <?php echo $value->cost_produce_unit; $totalcpu = $totalcpu +  $value->cost_produce_unit;?> </td>
        </tr>
        <?php $i++; } ?>
        <tr valign="top">
            <td colspan="2">รวม</td>
            <td  align="center" ><?php echo $totalpd; ?></td>
            <td  align="center" ><?php echo $totalcost; ?></td>
            <td  align="center" ><?php echo $totallastcost; ?> </td>
            <td  align="center" ><?php echo $totalsaraly; ?></td>
            <td  align="center" ><?php echo $totalcostpd; ?> </td>
            <td  align="center" ><?php echo $totalcpu; ?> </td>
        </tr>
    </table>
    <br>
    <br>



</body>
</html>
