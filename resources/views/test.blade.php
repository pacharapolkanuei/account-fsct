@extends('index')
@section('content')

@if




@endsection

<td><!--รายการ-->
 <?php
    if ($value->gettypemoney == "1") {
       echo "เงินสด";
    }elseif ($value->gettypemoney == "2") {
       echo "เงินฝากออมทรัพย์";
    }elseif ($value->gettypemoney == "3") {
       echo "เงินสด";
    }elseif ($value->gettypemoney == "4") {
       echo "เช็ค";
    }
 ?>
</td>


<td><!--เลขที่บัญชี-->
  <?php
     $modelra_acc = Maincenter::getdataconfig_ra_acc($value->branch_id);

     if ($value->gettypemoney == "1") {
        echo "111200";
     }
     elseif ($value->gettypemoney == "2") {
        if($modelra_acc){
          echo $modelra_acc[0]->accounttypeno;
        }
     }
     elseif($value->gettypemoney == "3"){
        echo "111200";
     }
     elseif($value->gettypemoney == "4"){
        // echo "111200";
     }
  ?>
</td>
<td><!--ชื่อเลขที่บัญชี-->
  <?php
     if ($value->gettypemoney == "1") {
        echo "เงินสด";
     }
     elseif ($value->gettypemoney == "2") {
         if($modelra_acc){
           echo $modelra_acc[0]->accounttypefull;
         }
     }
     elseif($value->gettypemoney == "3"){
        echo "เงินสด";
     }
     elseif($value->gettypemoney == "4"){
        // echo "เงินสด";
     }
  ?>
</td>

<td><!--ยอดสุทธิ-->
  <?php
     if ($value->gettypemoney == "1") {
        echo $value->grandtotal;
     }elseif ($value->gettypemoney == "2") {
        echo $value->grandtotal;
     }elseif ($value->gettypemoney == "3") {
        echo $value->cashmoney;
     }elseif ($value->gettypemoney == "4") {
        // echo $value->cashmoney;
     }
   ?>
</td>

<!--กรณีมีทั้งเงินสด และ เงินโอน-->
<?php if($value->gettypemoney == 3) {?>
<tr>
    <td></td>
    <td></td>
    <td></td>
    <td><?php echo "เงินฝากออมทรัพย์";?></td>
    <td></td>
    <td>
      <?php
         if($modelra_acc){
               echo $modelra_acc[0]->accounttypeno;
         }
      ?>
    </td>
    <td>
      <?php
         if($modelra_acc){
               echo $modelra_acc[0]->accounttypefull;
         }
      ?>
    </td>
    <td></td>
    <td><?php echo ($value->transfermoney);?></td><!--ยอดสุทธิ-->
    <td></td>
</tr>
<?php } ?>
