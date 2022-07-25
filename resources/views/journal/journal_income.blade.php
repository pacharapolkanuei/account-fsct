<?php
use  App\Api\Connectdb;
use  App\Api\Accountcenter;
use  App\Api\Vendorcenter;
use  App\Api\Maincenter;

$db = Connectdb::Databaseall();
?>

@extends('index')
@section('content')
<!-- js data table -->

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<script src="{{asset('js/jquery-3.2.1.js')}}"></script>
<script type="text/javascript">
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
</script>

<script type="text/javascript" src={{ asset('js/accountjs/journal_debt.js') }}></script>
<link href="{{ asset('css/journal_debt/journal_debt.css') }}" rel="stylesheet" type="text/css" media="all">

<!--
<style>

/* define height and width of scrollable area. Add 16px to width for scrollbar          */
div.tableContainer {
	clear: both;
	border: 1px solid #963;
	height: 44vh;
	overflow: auto;
	width: 100%;
}

/* Reset overflow value to hidden for all non-IE browsers. */
html>body div.tableContainer {
	overflow: hidden;
	width: 100%;

}

/* define width of table. IE browsers only                 */
div.tableContainer table {
	float: left;
	/* width: 740px */
}

/* define width of table. Add 16px to width for scrollbar.           */
/* All other non-IE browsers.                                        */
html>body div.tableContainer table {
	/* width: 756px */
}

/* set table header to a fixed position. WinIE 6.x only                                       */
/* In WinIE 6.x, any element with a position property set to relative and is a child of       */
/* an element that has an overflow property set, the relative value translates into fixed.    */
/* Ex: parent element DIV with a class of tableContainer has an overflow property set to auto */

thead.fixedHeader tr {
	position: relative;
}

/* set THEAD element to have block level attributes. All other non-IE browsers            */
/* this enables overflow to work on TBODY element. All other non-IE, non-Mozilla browsers */

/* make the TH elements pretty */
thead.fixedHeader th {
	background: #C96;
	border-left: 1px solid #EB8;
	border-right: 1px solid #B74;
	border-top: 1px solid #EB8;
	font-weight: normal;
	padding: 4px 3px;
	text-align: left
}

html>body tbody.scrollContent {
	display: block;
	height: 40vh;
	overflow: auto;
	width: 100%
}

html>body thead.fixedHeader {
	display: table;
	overflow: auto;
	/* width: 100% */
}

/* make TD elements pretty. Provide alternating classes for striping the table */
/* http://www.alistapart.com/articles/zebratables/                             */
tbody.scrollContent td, tbody.scrollContent tr.normalRow td {
	background: #FFF;
	border-bottom: none;
	border-left: none;
	border-right: 1px solid #CCC;
	border-top: 1px solid #DDD;
	padding: 2px 3px 3px 4px
}



tbody.scrollContent tr.alternateRow td {
	background: #EEE;
	border-bottom: none;
	border-left: none;
	border-right: 1px solid #CCC;
	border-top: 1px solid #DDD;
	padding: 2px 3px 3px 4px
}
tr th{ width:10%} tr td{width:10%}
</style>
-->
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
                            <li class="breadcrumb-item active">สมุดรายวันรับ</li>
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
                                <fonts id="fontsheader">สมุดรายวันรับ</fonts>
                            </h3><br><br>
                            <!-- date range -->

                            <!-- <div class="box-body" style="overflow-x:auto;"> -->
                            <form action="serachjournal_income" method="post">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="row" class="fontslabel">
                              <div class="col-sm-3">
                                  <div class="input-group mb-6">
                                      <div class="input-group-prepend">
                                          <label id="fontslabel"><b>วันที่ : &nbsp;</b></label>
                                      </div>
                                      <input type='text' class="form-control" name="daterange" value="<?php if(!empty($data)){echo $datepicker; }?>" autocomplete="off"  />
                                  </div>
                              </div>

                              <div class="col-sm-4">
                                  <div class="input-group mb-6">
                                      <?php
                                          $db = Connectdb::Databaseall();
                                          $sql = 'SELECT '.$db['hr_base'].'.branch.*
                                             FROM '.$db['hr_base'].'.branch
											 WHERE status_main = "1" ';

                                          $brcode = DB::connection('mysql')->select($sql);

                                      ?>
                                      <label id="fontslabel"><b>สาขา :</b></label>
                                      <select name="branch[]" id="branch" class="form-control select2"  multiple="multiple"   data-placeholder="เลือกสาขา" required>
                                          <option value="all">SELECT ALL</option>
                                          <?php
                                            foreach ($brcode as $key => $value) {
                                          ?>
                                            <option value="<?php echo $value->code_branch;?>" <?php if(!empty($data)&&($value->code_branch==$branch)){ echo "selected";}?> > <?php echo $value->name_branch;?></option>

                                          <?php }?>
                                      </select>
                                      <center><button type="submit" class="btn btn-primary btn-sm fontslabel">ค้นหา</button></center>&nbsp;
                                      <center></center>
                                  </div>
                              </div>
                            </div>
                            </form>

          <div class="row">
              <br>
          </div>
		<div class="tableFixHead">

</div>
<?php if(!empty($datamsg)){?>
      <div class="alert alert-success">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <strong>Success!</strong>
      </div>
<?php }?>
          <!-- table cotent -->
          <div  id="tableContainer" class="tableContainer">
            @if (session('status'))
                <div class="alert alert-danger">
                    {{ session('status') }}
                </div>
            @endif
            <?php if(!empty($data)){
                        // echo "<pre>";
                        // print_r($datataxra);
                        // print_r($datataxtf);
                        // print_r($datataxcn);
                        // print_r($datataxcs);
                        // print_r($datataxtk);
                        // print_r($datataxrl);
                        // print_r($datataxtm);
                        // print_r($datataxrn);
                        // print_r($datataxtp);
                        // print_r($datataxro);
                        // print_r($datataxrs);
                        // print_r($datataxss);
                        

                        $db = Connectdb::Databaseall();

            ?>

            {!! Form::open(['route' => 'journalincome_filter', 'method' => 'post']) !!}

            <table  width="100%" >
              <thead >
                  <tr >
                      <th width="" scope="col" style="text-align:center;">เลือก/แก้ไข</th>
                      <th scope="col">วัน/เดือน/ปี</th>
                      <th scope="col">เลขที่ใบกำกับภาษี</th>
                      <th scope="col">เลขใบสำคัญรับ</th>

                      <th scope="col">รายละเอียด</th>
                      <th scope="col">เลขที่บัญชี</th>
                      <th scope="col">ชื่อเลขที่บัญชี</th>
                      <th scope="col">สาขา</th>
                      <th scope="col">เดบิต</th>
                      <th scope="col">เครดิต</th>

                  </tr>
              </thead>

              <tbody  >

              <?php

              //id accountcode
              $discount = 14;      //ส่วนลด
              $income = 15;        //รายได้ค่าเช่า - เครื่องมือให้เช่า
              $vat = 16;           //ภาษีขาย
              $wht = 17;           //ภาษีเงินได้ถูก หัก ณ ที่จ่าย
              $insurance = 18;     //เงินประกันการเช่า
              $other = 19;         //รายได้อื่นๆ
              $tools = 20;         //เครื่องมือให้เช่า
              $depreciation = 21;  //ค่าเสื่อมราคาสะสม-เครื่องมือให้เช่า
              $loss = 22;  //ขาดทุนจากการขาย
              $profit = 23;  //กำไรจากการขาย
	          $datenovatinsu = '2020-11-30';
              foreach ($datataxra as $key => $value) { ?> <!--RA-->
                  <tr>
                      <td style="text-align:center;">
                        <?php if($value->status_ap == 0 OR  $value->status_ap == 2){ ?>
                          <!-- <label class="con"> -->
                          <input type="checkbox" name="check_list[]" value="{{ $value->id }},{{ 1 }}">
                              <!-- <span class="checkmark"></span> -->
                          <!-- </label> -->
														<br>
                            <br>
													<button type="button"  class="btn btn-danger"  class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" onclick="reply({{$value->branch_id}},{{$value->id}},{{ 1 }})" >แก้ไข</button>
                        <?php }else{ ?>
                            <i class="fa fa-check" style="color:green;font-size:20px;"></i>
                        <?php } ?>


                      </td>

                      <td><!--ปี/เดือน/วัน-->
                       <?php
                         $time = explode(" ",trim(($value->time)));
                         echo $time[0];
                       ?>

                      </td>

                      <td><?php echo ($value->number_taxinvoice);?></td><!--เลขที่-->


                      <td><?php echo "PV".($value->number_taxinvoice);?></td>



                      <td><!--รายละเอียด-->
                       <?php
                          $modelcustomer = Maincenter::getdatacustomer($value->customerid);

                          if($modelcustomer){
                              echo "<b>รับเงินค่าเช่าจาก</b> ";
                              echo $modelcustomer[0]->name." ".$modelcustomer[0]->lastname;
                          }
                       ?>

                      </td>

                      <td><!--เลขที่บัญชี-->
                        <?php
                           $modelra_acc = Maincenter::getdataconfig_ra_acc($value->branch_id);

                           if ($value->gettypemoney == "1") {
                              echo "111200";
                        ?>
                           <?php
                           }
                           elseif ($value->gettypemoney == "2") {
                              if($modelra_acc){
                                echo $modelra_acc[0]->accounttypeno;
                              ?>
                              <?php
                              }
                           }
                           elseif($value->gettypemoney == "3"){
                              echo "111200";
                        ?>
                           <?php
                           }
                           elseif($value->gettypemoney == "4"){
                              echo "113000";
                        ?>
                           <?php
                           }
                           else{
                              echo " - ";
                        ?>
                           <?php
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
                              echo "เช็ครับล่วงหน้า";
                           }
                        ?>
                      </td>

                      <td><?php echo ($value->branch_id);?></td><!--สาขา-->


                      <td><!--ยอดสุทธิ-->
                        <?php
                           if ($value->gettypemoney == "1") {
                              echo number_format($value->grandtotal,2);
                        ?>
                           <?php
                           }elseif ($value->gettypemoney == "2") {
                              echo number_format($value->grandtotal,2);
                        ?>
                           <?php
                           }elseif ($value->gettypemoney == "3") {
                              echo number_format($value->cashmoney,2);
                              // echo "string";
                        ?>
                           <?php
                           }elseif ($value->gettypemoney == "4") {
                              echo number_format($value->grandtotal,2);
                        ?>
                           <?php
                           }
                           else{
                              echo " 0";
                        ?>
                           <?php
                           }
                         ?>
                      </td>


                      <td> </td>
											<td></td>
                  </tr>

                  <!--กรณีมีทั้งเงินสด และ เงินโอน-->
                  <?php if($value->gettypemoney == 3) {?>
                  <tr>
                      <td></td>
                      <td> </td>
                      <td> </td>
                      <td></td>



                      <td>


                      </td>

                      <td>
                        <?php
                           if($modelra_acc){
                                 echo $modelra_acc[0]->accounttypeno;
                        ?>
                           <?php
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
                      <td> </td>
                      <td><?php echo number_format($value->transfermoney,2);?></td><!--ยอดสุทธิ-->

                      <td> </td>
                  </tr>
                  <?php } ?>


                  <?php if($value->withhold == 1 || $value->withhold == 3 || $value->withhold == 5 || $value->withhold == 1.5){ ?>
                  <tr>
                      <td></td>
                      <td> </td>
                      <td> </td>
                      <td></td>



                      <td>


                      </td>

                      <td>
                        <?php
                              $modelwht = Maincenter::getdataconfig_acc($wht);
                              if($modelwht){
                                    echo $modelwht[0]->accounttypeno;
                        ?>
                           <?php
                              }
                        ?>
                      </td>
                      <td>
                        <?php
                           if($modelwht){
                                 echo $modelwht[0]->accounttypefull;
                           }
                        ?>
                      </td>
                      <td> </td>
                      <td><?php echo number_format($value->withholdmoney,2);?></td><!--WTH-->

                      <td> </td>
                  </tr>
                  <?php } ?>

                  <?php if($value->discountmoney > "0"){ ?>
                  <tr>
                      <td></td>
                      <td> </td>
                      <td> </td>
                      <td>


                      </td>



                      <td></td>
                      <td>
                        <?php
                              $modeldiscount = Maincenter::getdataconfig_acc($discount);
                              if($modeldiscount){
                                    echo $modeldiscount[0]->accounttypeno;
                        ?>
                           <?php
                              }
                        ?>
                      </td>
                      <td>
                        <?php
                           if($modeldiscount){
                                 echo $modeldiscount[0]->accounttypefull;
                           }
                        ?>
                      </td>
                      <td> </td>
                      <td><?php echo number_format($value->discountmoney,2);?></td><!--ส่วนลด-->

                      <td> </td>
                  </tr>
                  <?php } ?>

                  <tr>
                      <td></td>
                      <td> </td>
                      <td> </td>
                      <td>


                      </td>



                      <td></td>
                      <td>
                        <?php
                              $modelincome = Maincenter::getdataconfig_acc($income);
                              if($modelincome){
                                    echo $modelincome[0]->accounttypeno;
                        ?>
                           <?php
                              }
                        ?>
                      </td>
                      <td>
                        <?php
                           if($modelincome){
                                 echo $modelincome[0]->accounttypefull;
                           }
                        ?>
                      </td>
                      <td> </td>
                      <td> </td>


                      <td><?php echo number_format($value->subtotal,2);?></td><!--ยอดก่อน vat-->

                  </tr>

                  <?php if($value->vat > "0"){ ?>
                  <tr>
                      <td></td>
                      <td> </td>
                      <td> </td>
                      <td>


                      </td>



                      <td></td>
                      <td>
                        <?php
                              $modelvat = Maincenter::getdataconfig_acc($vat);
                              if($modelvat){
                                    echo $modelvat[0]->accounttypeno;
                        ?>
                           <?php
                              }
                        ?>
                      </td>
                      <td>
                        <?php
                           if($modelvat){
                                 echo $modelvat[0]->accounttypefull;
                           }
                        ?>
                      </td>
                      <td> </td>
                      <td> </td>

                      <td><?php echo number_format($value->vatmoney,2);?></td><!--Vat-->

                  </tr>
                  <?php } ?>

                  <tr>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>

                      <td></td>
                      <td></td>
                      <td><b><?php echo number_format($value->grandtotal + $value->withholdmoney + $value->discountmoney,2);?></b></td>
                      <td><b><?php echo number_format($value->subtotal + $value->vatmoney,2);?></b></td>
                  </tr>

              <?php }  ?>




              <?php foreach ($datataxtf as $key2 => $value2) { ?> <!--TF-->

                  <tr>
                      <td>
                        <?php if($value2->status_ap ==0 OR $value2->status_ap ==2){ ?>
                          <!-- <label class="con"> -->
                          <input type="checkbox" name="check_list[]" value="{{ $value2->id }},{{ 2 }}">
                              <!-- <span class="checkmark"></span>
                          </label> -->
                          <br>
                          <br>
                          <button type="button"  class="btn btn-danger"
                              class="btn btn-primary" data-toggle="modal"
                              data-target="#exampleModal"
                              onclick="reply({{$value2->branch_id}},{{$value2->id}},{{ 2 }})" >แก้ไข</button>
                        <?php }else{ ?>
                           <i class="fa fa-check" style="color:green;font-size:20px;"></i>
                        <?php } ?>
                      </td>

                      <td><!--ปี/เดือน/วัน-->
                      <?php
                         $time = explode(" ",trim(($value2->timereal)));
                         echo $time[0];
                      ?>

                      </td>

                      <td><?php echo ($value2->number_taxinvoice);?></td><!--เลขที่-->


                      <td><?php echo "PV".($value2->number_taxinvoice);?></td>


                      <td><!--รายละเอียด-->
                      <?php
                        $modelcustomertf = Maincenter::getdatacustomer($value2->customerid);

                        if($modelcustomertf){
                           echo "<b>รับเงินค่าเช่าจาก</b> ";
                           echo $modelcustomertf[0]->name." ".$modelcustomertf[0]->lastname;
                        }
                      ?>

                      </td>

                      <td><!--เลขที่บัญชี-->
                        <?php
                           $modeltf_acc = Maincenter::getdataconfig_tf_acc($value2->branch_id);

                           if ($value2->gettypemoney == "1") {
                              echo "111200";
                        ?>
                           <?php
                           }
                           elseif ($value2->gettypemoney == "2") {
                              if($modeltf_acc){
                                echo $modeltf_acc[0]->accounttypeno;
                           ?>
                              <?php
                              }
                           }
                           elseif($value2->gettypemoney == "3"){
                              echo "111200";
                        ?>
                           <?php
                           }
                           elseif($value2->gettypemoney == "4"){
                              echo "113000";
                        ?>
                           <?php
                           }
                           else{
                              echo " - ";
                        ?>
                           <?php
                           }
                        ?>
                      </td>
                      <td><!--ชื่อเลขที่บัญชี-->
                        <?php
                           if ($value2->gettypemoney == "1") {
                              echo "เงินสด";
                           }
                           elseif ($value2->gettypemoney == "2") {
                               if($modeltf_acc){
                                 echo $modeltf_acc[0]->accounttypefull;
                               }
                           }
                           elseif($value2->gettypemoney == "3"){
                              echo "เงินสด";
                           }
                           elseif($value2->gettypemoney == "4"){
                              echo "เช็ครับล่วงหน้า";
                           }
                        ?>
                      </td>
                      <td><?php echo ($value2->branch_id);?></td><!--สาขา-->


                      <td><!--ยอดสุทธิ-->
                        <?php
                           if ($value2->gettypemoney == "1") {
                              echo number_format($value2->grandtotal,2);
                        ?>
                           <?php
                           }elseif ($value2->gettypemoney == "2") {
                              echo number_format($value2->grandtotal,2);
                        ?>
                           <?php
                           }elseif ($value2->gettypemoney == "3") {
                              echo number_format($value2->cashmoney,2);
                        ?>
                           <?php
                           }elseif ($value2->gettypemoney == "4") {
                              echo number_format($value2->grandtotal,2);
                        ?>
                           <?php
                           }
                           else{
                              echo " 0 ";
                        ?>
                           <?php
                           }
                         ?>
                      </td>

                      <td> </td>
                  </tr>

                  <!--กรณีมีทั้งเงินสด และ เงินโอน-->
                  <?php if($value2->gettypemoney == 3) {?>
                  <tr>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>




                      <td>


                      </td>

                      <td>
                        <?php
                           if($modeltf_acc){
                                 echo $modeltf_acc[0]->accounttypeno;
                        ?>
                           <?php
                           }
                        ?>
                      </td>
                      <td>
                        <?php
                           if($modeltf_acc){
                                 echo $modeltf_acc[0]->accounttypefull;
                           }
                        ?>
                      </td>
                      <td></td>
                      <td><?php echo number_format($value2->transfermoney,2);?></td><!--ยอดสุทธิ-->




                      <td></td>
                  </tr>
                  <?php } ?>


                  <?php if($value2->withhold == 1 || $value2->withhold == 3 || $value2->withhold == 5 || $value2->withhold == 1.5){ ?>
                  <tr>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>




                      <td>


                      </td>

                      <td>
                        <?php
                              $modelwht = Maincenter::getdataconfig_acc($wht);
                              if($modelwht){
                                    echo $modelwht[0]->accounttypeno;
                        ?>
                           <?php
                              }
                        ?>
                      </td>
                      <td>
                        <?php
                           if($modelwht){
                                 echo $modelwht[0]->accounttypefull;
                           }
                        ?>
                      </td>
                      <td></td>
                      <td><?php echo number_format($value2->withholdmoney,2);?></td><!--WTH-->




                      <td></td>
                  </tr>
                  <?php } ?>

                  <?php if($value2->discountmoney > "0"){ ?>
                  <tr>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>




                      <td>


                      </td>
                      <td>
                        <?php
                              $modeldiscount = Maincenter::getdataconfig_acc($discount);
                              if($modeldiscount){
                                    echo $modeldiscount[0]->accounttypeno;
                        ?>
                           <?php
                              }
                        ?>
                      </td>
                      <td>
                        <?php
                           if($modeldiscount){
                                 echo $modeldiscount[0]->accounttypefull;
                           }
                        ?>
                      </td>
                      <td></td>
                      <td><?php echo number_format($value2->discountmoney,2);?></td><!--ส่วนลด-->




                      <td></td>
                  </tr>
                  <?php } ?>

                  <tr>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>




                      <td>


                      </td>
                      <td>
                        <?php
                              $modelincome = Maincenter::getdataconfig_acc($income);
                              if($modelincome){
                                    echo $modelincome[0]->accounttypeno;
                        ?>
                           <?php
                              }
                        ?>
                      </td>
                      <td>
                        <?php
                           if($modelincome){
                                 echo $modelincome[0]->accounttypefull;
                           }
                        ?>
                      </td>
                      <td></td>
                      <td></td>



                      <td><?php echo number_format($value2->subtotal,2);?></td>

                  </tr>

                  <?php if($value2->vat > "0"){ ?>
                  <tr>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>




                      <td>


                      </td>
                      <td>
                        <?php
                              $modelvat = Maincenter::getdataconfig_acc($vat);
                              if($modelvat){
                                    echo $modelvat[0]->accounttypeno;
                        ?>
                           <?php
                              }
                        ?>
                      </td>
                      <td>
                        <?php
                           if($modelvat){
                                 echo $modelvat[0]->accounttypefull;
                           }
                        ?>
                      </td>
                      <td></td>
                      <td></td>


                      <td><?php echo number_format($value2->vatmoney,2);?></td><!--Vat-->

                  </tr>
                  <?php } ?>

                  <tr>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>

                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td><b><?php echo number_format($value2->grandtotal + $value2->withholdmoney + $value2->discountmoney,2);?></b></td>
                      <td><b><?php echo number_format($value2->subtotal + $value2->vatmoney,2);?></b></td>
                  </tr>

              <?php } ?>



              <?php
              $discountmoney = 0;

              foreach ($datataxtk as $key3 => $value3) { ?> <!--TK-->

                  <tr>
                      <td>
                        <?php if($value3->status_ap == 0 OR  $value3->status_ap == 2){ ?>
                            <!-- <label class="con"> -->
                            <input type="checkbox" name="check_list[]" value="{{ $value3->id }},{{ 3 }}">
                                <!-- <span class="checkmark"></span> -->
                            <!-- </label> -->
  														<br>
                              <br>
  													<button type="button"  class="btn btn-danger"  class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" onclick="reply({{$value3->branch_id}},{{$value3->id}},{{ 3 }})" >แก้ไข</button>
                          <?php }else{ ?>
                              <i class="fa fa-check" style="color:green;font-size:20px;"></i>
                          <?php } ?>


                      </td>

                      <td><!--ปี/เดือน/วัน-->
                      <?php
                        $time = explode(" ",trim(($value3->timereal)));
                        echo $time[0];
                      ?>

                      </td>

                      <td><?php echo ($value3->number_taxinvoice);?></td><!--เลขที่-->


                      <td><?php echo "PV".($value3->number_taxinvoice);?></td>


                      <td><!--รายละเอียด-->
                      <?php
                        $modelcustomertk = Maincenter::getdatacustomer($value3->customerid);

                        if($modelcustomertk){
                         echo "<b>รับเงินค่าตัดหายเครื่องมือให้เช่าจาก</b> ";
                         echo $modelcustomertk[0]->name." ".$modelcustomertk[0]->lastname;
                        }
                      ?>


                      </td>

                      <td><!--เลขที่บัญชี-->
                        <?php
                           $modeltk_acc = Maincenter::getdataconfig_tk_acc($value3->branch_id);

                           if ($value3->gettypemoney == "1") {
                              echo "111200";
                        ?>
                        <?php
                           }
                           elseif ($value3->gettypemoney == "2") {
                              if($modeltk_acc){
                                echo $modeltk_acc[0]->accounttypeno;
                            ?>
                            <?php
                              }
                           }
                           elseif($value3->gettypemoney == "3"){
                              echo "111200";
                        ?>
                        <?php
                           }
                           elseif($value3->gettypemoney == "4"){
                              echo "113000";
                        ?>
                        <?php
                           }
                           else{
                              echo " - ";
                        ?>
                           <?php
                           }
                        ?>
                      </td>
                      <td><!--ชื่อเลขที่บัญชี-->
                        <?php
                           if ($value3->gettypemoney == "1") {
                              echo "เงินสด";
                           }
                           elseif ($value3->gettypemoney == "2") {
                               if($modeltk_acc){
                                 echo $modeltk_acc[0]->accounttypefull;
                               }
                           }
                           elseif($value3->gettypemoney == "3"){
                              echo "เงินสด";
                           }
                           elseif($value3->gettypemoney == "4"){
                              echo "เช็ครับล่วงหน้า";
                           }
                        ?>
                      </td>

                      <td><?php echo ($value3->branch_id);?></td><!--สาขา-->


                      <td><!--ยอดสุทธิ-->
                        <?php
                           if ($value3->gettypemoney == "1") {
                              echo number_format($value3->grandtotal,2);
                        ?>
                        <?php
                           }elseif ($value3->gettypemoney == "2") {
                              echo number_format($value3->grandtotal,2);
                        ?>
                        <?php
                           }elseif ($value3->gettypemoney == "3") {
                              echo number_format($value3->cashmoney,2);
                        ?>
                        <?php
                           }elseif ($value3->gettypemoney == "4") {
                              echo number_format($value3->grandtotal,2);
                        ?>
                        <?php
                           }
                           else{
                              echo " 0 ";
                        ?>
                           <?php
                           }
                         ?>
                      </td>


                      <td> </td>
                  </tr>

                  <!--กรณีมีทั้งเงินสด และ เงินโอน-->
                  <?php if($value3->gettypemoney == 3) {?>
                  <tr>
                      <td></td>
                      <td> </td>
                      <td> </td>
                      <td></td>




                      <td>


                      </td>

                      <td>
                        <?php
                           if($modeltk_acc){
                                 echo $modeltk_acc[0]->accounttypeno;
                        ?>
                        <?php
                           }
                        ?>
                      </td>
                      <td>
                        <?php
                           if($modeltk_acc){
                                 echo $modeltk_acc[0]->accounttypefull;
                           }
                        ?>
                      </td>
                      <td> </td>
                      <td><?php echo number_format($value3->transfermoney,2);?></td><!--ยอดสุทธิ-->


                      <td> </td>
                  </tr>
                  <?php } ?>


                  <?php if($value3->discount > "0"){ ?>
                  <tr>
                      <td></td>
                      <td> </td>
                      <td> </td>
                      <td></td>

                      <td><?php echo "ส่วนลด";?></td>


                      <td>


                      </td>

                      <td>
                        <?php
                              $modeldiscount = Maincenter::getdataconfig_acc($discount);
                              if($modeldiscount){
                                    echo $modeldiscount[0]->accounttypeno;
                        ?>
                        <?php
                              }
                        ?>
                      </td>
                      <td>
                        <?php
                           if($modeldiscount){
                                 echo $modeldiscount[0]->accounttypefull;
                           }
                        ?>
                      </td>
                      <td> </td>
                      <td><!--ส่วนลด-->
                      <?php
                        echo number_format(($value3->subtotal * $value3->discount)/100,2);
                        $discountmoney = ($value3->subtotal * $value3->discount)/100;
                      ?>

                      </td>


                      <td></td>
                  </tr>
                  <?php } ?>


                  <?php
                      $modelmaterial_tk = Maincenter::getdatamaterial_tk($value3->id,$value3->bill_rent,$value3->type);$modelmaterial_tk = Maincenter::getdatamaterial_tk($value3->id,$value3->bill_rent,$value3->type);
                      // echo "<pre>";
                      // print_r($modelmaterial_tk);
                      // exit;
                  ?>

                  <?php if($value3->vat > "0"){ ?>
                  <tr>
                      <td></td>
                      <td> </td>
                      <td> </td>
                      <td></td>




                      <td>
                      </td>

                      <td>
                        <?php
                              $modelvat = Maincenter::getdataconfig_acc($vat);
                              if($modelvat){
                                    echo $modelvat[0]->accounttypeno;
                        ?>
                        <?php
                              }
                        ?>
                      </td>
                      <td>
                        <?php
                           if($modelvat){
                                 echo $modelvat[0]->accounttypefull;
                           }
                        ?>
                      </td>
                      <td> </td>
                      <td></td>


                      <td><?php echo number_format($value3->vatmoney,2);?></td><!--Vat-->

                  </tr>
                  <?php } ?>


                  <?php if($modelmaterial_tk){?>
                  <?php if($value3->grandtotal < ($value3->grandtotal + $modelmaterial_tk[0]->totalpricedepreciation)){ ?> <!--กำไรจากการขาย-->
                  <tr>
                      <td></td>
                      <td> </td>
                      <td> </td>
                      <td></td>



                      <td>


                      </td>
                      <td>
                        <?php
                              $modelprofit = Maincenter::getdataconfig_acc($profit);
                              if($modelprofit){
                                    echo $modelprofit[0]->accounttypeno;
                        ?>
                        <?php
                              }
                        ?>
                      </td>
                      <td>
                        <?php
                           if($modelprofit){
                                 echo $modelprofit[0]->accounttypefull;
                           }
                        ?>
                      </td>
                      <td> </td>
                      <td></td>


                      <td><?php echo number_format($value3->subtotal,2);?></td><!--Vat-->

                  </tr>
                  <?php } ?>

                  <tr>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td><b><?php echo number_format($value3->grandtotal,2);?></b></td>
                      <td><b><?php echo number_format($value3->grandtotal,2);?></b></td>



                  </tr>
                  <?php } ?>

                  <?php }  ?>





                  <?php foreach ($datataxrl as $key4 => $value4) { ?> <!--RL-->

                      <tr>
                          <td>
                            <?php if($value4->status_ap == 0 OR  $value4->status_ap == 2){ ?>
                              <!-- <label class="con"> -->
                              <input type="checkbox" name="check_list[]" value="{{ $value4->id }},{{ 4 }}">
                                  <!-- <span class="checkmark"></span>
                              </label> -->
                              <br>
                              <br>
                              <button type="button"  class="btn btn-danger"  class="btn btn-primary"
                                      data-toggle="modal" data-target="#exampleModal"
                                      onclick="reply({{$value4->branch_id}},{{$value4->id}},{{ 4 }})" >แก้ไข
                              </button>
                            <?php }else{ ?>
                               <i class="fa fa-check" style="color:green;font-size:20px;"></i>
                            <?php } ?>
                          </td>

                          <td><!--ปี/เดือน/วัน-->
                          <?php
                            $time = explode(" ",trim(($value4->time)));
                            echo $time[0];
                          ?>

                          </td>

                          <td><?php echo ($value4->number_taxinvoice);?></td><!--เลขที่-->


                          <td><?php echo "PV".($value4->number_taxinvoice);?></td>


                          <td><!--รายละเอียด-->
                          <?php
                            $modelcustomerrl = Maincenter::getdatacustomer($value4->customerid);

                            if($modelcustomerrl){
                             echo "<b>รับเงินค่าตัดหายเครื่องมือให้เช่าจาก</b> ";
                             echo $modelcustomerrl[0]->name." ".$modelcustomerrl[0]->lastname;
                            }
                          ?>

                           </td>

                          <td><!--เลขที่บัญชี-->
                            <?php
                               $modelrl_acc = Maincenter::getdataconfig_rl_acc($value4->branch_id);

                               if ($value4->gettypemoney == "1") {
                                  echo "111200";
                               ?>
                               <?php
                               }
                               elseif ($value4->gettypemoney == "2") {
                                  if($modelrl_acc){
                                    echo $modelrl_acc[0]->accounttypeno;
                               ?>
                               <?php
                                  }
                               }
                               elseif($value4->gettypemoney == "3"){
                                  echo "111200";
                               ?> <
                               <?php
                               }
                               elseif($value4->gettypemoney == "4"){
                                  echo "113000";
                               ?>
                               <?php
                               }
                               else{
                                  echo " - ";
                               ?>
                               <?php
                               }
                            ?>
                          </td>
                          <td><!--ชื่อเลขที่บัญชี-->
                            <?php
                               if ($value4->gettypemoney == "1") {
                                  echo "เงินสด";
                               }
                               elseif ($value4->gettypemoney == "2") {
                                   if($modelrl_acc){
                                     echo $modelrl_acc[0]->accounttypefull;
                                   }
                               }
                               elseif($value4->gettypemoney == "3"){
                                  echo "เงินสด";
                               }
                               elseif($value4->gettypemoney == "4"){
                                  echo "เช็ครับล่วงหน้า";
                               }
                            ?>
                          </td>
                          <td><?php echo ($value4->branch_id);?></td><!--สาขา-->


                          <td><!--ยอดสุทธิ-->
                            <?php
                               if ($value4->gettypemoney == "1") {
                                  echo number_format($value4->grandtotal,2);
                            ?>
                            <?php
                               }elseif ($value4->gettypemoney == "2") {
                                  echo number_format($value4->grandtotal,2);
                            ?>
                            <?php
                               }elseif ($value4->gettypemoney == "3") {
                                  echo number_format($value4->cashmoney,2);
                            ?>
                            <?php
                               }elseif ($value4->gettypemoney == "4") {
                                  echo number_format($value4->grandtotal,2);
                            ?>
                            <?php
                               }
                               else{
                                  echo " 0 ";
                            ?>
                            <?php
                               }
                             ?>
                          </td>

                          <td>
                      </tr>

                      <!--กรณีมีทั้งเงินสด และ เงินโอน-->
                      <?php if($value4->gettypemoney == 3) {?>
                      <tr>
                          <td></td>
                          <td> </td>
                          <td> </td>
                          <td></td>



                          <td>


                          </td>

                          <td>
                            <?php
                               if($modelrl_acc){
                                     echo $modelrl_acc[0]->accounttypeno;
                            ?>
                            <?php
                               }
                            ?>
                          </td>
                          <td>
                            <?php
                               if($modelrl_acc){
                                     echo $modelrl_acc[0]->accounttypefull;
                               }
                            ?>
                          </td>
                          <td> </td>
                          <td><?php echo number_format($value4->transfermoney,2);?></td><!--ยอดสุทธิ-->


                          <td>
                      </tr>
                      <?php } ?>

                      <?php
                          $modelmaterial_rl = Maincenter::getdatamaterial_rl($value4->id,$value4->bill_rent,$value4->type);
                          // echo "<pre>";
                          // print_r($modelmaterial_rl);
                          // exit;
                      ?>

                      <?php if($value4->vat > "0"){ ?>
                      <tr>
                          <td></td>
                          <td> </td>
                          <td> </td>
                          <td></td>


                          <td>

						  </td>

                          <td>
                            <?php
                                  $modelvat = Maincenter::getdataconfig_acc($vat);
                                  if($modelvat){
                                        echo $modelvat[0]->accounttypeno;
                            ?>
                            <?php
                                  }
                            ?>
                          </td>
                          <td>
                            <?php
                               if($modelvat){
                                     echo $modelvat[0]->accounttypefull;
                               }
                            ?>
                          </td>
                          <td></td>
                          <td></td>



                          <td><?php echo number_format($value4->vatmoney,2);?></td><!--Vat-->

                      </tr>
                      <?php } ?>

                      <?php if($modelmaterial_rl){?>
                      <?php if($value4->grandtotal < ($value4->grandtotal + $modelmaterial_rl[0]->totalpricedepreciation)){ ?> <!--กำไรจากการขาย-->
                      <tr>
                          <td></td>
                          <td> </td>
                          <td></td>
                          <td></td>



                          <td>


                          </td>

                          <td>
                            <?php
                                  $modelprofit = Maincenter::getdataconfig_acc($profit);
                                  if($modelprofit){
                                        echo $modelprofit[0]->accounttypeno;
                            ?>
                            <?php
                                  }
                            ?>
                          </td>
                          <td>
                            <?php
                               if($modelprofit){
                                     echo $modelprofit[0]->accounttypefull;
                               }
                            ?>
                          </td>
                          <td></td>
                          <td></td>



                          <td><?php echo number_format($value4->subtotal,2);?></td>
                      </tr>
                      <?php } ?>

                      <tr>
                          <td></td>
                          <td></td>
                          <td></td>

                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td><b><?php echo number_format($value4->grandtotal,2);?></b></td>
                          <td><b><?php echo number_format($value4->grandtotal,2);?></b></td>
                      </tr>
                      <?php } ?>

              <?php } ?>




              <?php foreach ($datataxtm as $key5 => $value5) { ?> <!--TM-->

                  <tr>
                      <td>
                        <?php if($value5->status_ap == 0 OR  $value5->status_ap == 2){ ?>
                          <!-- <label class="con"> -->
                          <input type="checkbox" name="check_list[]" value="{{ $value5->id }},{{ 5 }}">
                              <!-- <span class="checkmark"></span> -->
                          <!-- </label> -->
                          <br>
                          <br>
						              <button type="button"  class="btn btn-danger"  class="btn btn-primary"
                          data-toggle="modal" data-target="#exampleModal"
                          onclick="reply({{$value5->branch_id}},{{$value5->id}},{{ 5 }})" >แก้ไข</button>
                        <?php }else{ ?>
                          <i class="fa fa-check" style="color:green;font-size:20px;"></i>
                        <?php } ?>
                      </td>

                      <td><!--ปี/เดือน/วัน-->
                      <?php
                        $time = explode(" ",trim(($value5->timereal)));
                        echo $time[0];
                      ?>

                      </td>

                      <td><?php echo ($value5->number_taxinvoice);?></td><!--เลขที่-->


                      <td><?php echo "PV".($value5->number_taxinvoice);?></td>

                      <td><!--รายละเอียด-->
                      <?php
                        $modelcustomertm = Maincenter::getdatacustomer($value5->customerid);

                        if($modelcustomertm){
                         echo "<b>รับเงินค่าเช่าเพิ่มจาก</b> ";
                         echo $modelcustomertm[0]->name." ".$modelcustomertm[0]->lastname;
                        }
                      ?>


                      </td>

                      <td><!--เลขที่บัญชี-->
                        <?php
                           $modeltm_acc = Maincenter::getdataconfig_tm_acc($value5->branch_id);

                           if ($value5->gettypemoney == "1") {
                              echo "111200";
                           ?>
                           <?php
                           }
                           elseif ($value5->gettypemoney == "2") {
                              if($modeltm_acc){
                                echo $modeltm_acc[0]->accounttypeno;
                                ?>
                                <?php
                              }
                           }
                           elseif($value5->gettypemoney == "3"){
                              echo "111200";
                           ?>
                           <?php
                           }
                           elseif($value5->gettypemoney == "4"){
                              echo "113000";
                           ?>
                           <?php
                           }
                           else{
                              echo " - ";
                           ?>
                           <?php
                           }
                        ?>
                      </td>
                      <td><!--ชื่อเลขที่บัญชี-->
                        <?php
                           if ($value5->gettypemoney == "1") {
                              echo "เงินสด";
                           }
                           elseif ($value5->gettypemoney == "2") {
                               if($modeltm_acc){
                                 echo $modeltm_acc[0]->accounttypefull;
                               }
                           }
                           elseif($value5->gettypemoney == "3"){
                              echo "เงินสด";
                           }
                           elseif($value5->gettypemoney == "4"){
                              echo "เช็ครับล่วงหน้า";
                           }
                        ?>
                      </td>
                      <td><?php echo ($value5->branch_id);?></td><!--สาขา-->


                      <td><!--ยอดสุทธิ-->
                        <?php
                           if ($value5->gettypemoney == "1") {
                              echo number_format($value5->grandtotal,2);
                              ?>
                           <?php
                           }elseif ($value5->gettypemoney == "2") {
                              echo number_format($value5->grandtotal,2);
                              ?>
                           <?php
                           }elseif ($value5->gettypemoney == "3") {
                              echo number_format($value5->cashmoney,2);
                              ?>
                           <?php
                           }elseif ($value5->gettypemoney == "4") {
                              echo number_format($value5->grandtotal,2);
                              ?>
                           <?php
                           }else{
                              echo " - ";
                              ?>
                           <?php
                           }
                         ?>
                      </td>



                      <td></td>
                  </tr>

                  <!--กรณีมีทั้งเงินสด และ เงินโอน-->
                  <?php if($value5->gettypemoney == 3) {?>
                  <tr>
                      <td></td>
                      <td> </td>
                      <td></td>
                      <td></td>



                      <td>


                      </td>

                      <td>
                        <?php
                           if($modeltm_acc){
                                 echo $modeltm_acc[0]->accounttypeno;
                        ?>
                        <?php
                           }
                        ?>
                      </td>
                      <td>
                        <?php
                           if($modeltm_acc){
                                 echo $modeltm_acc[0]->accounttypefull;
                           }
                        ?>
                      </td>
                      <td> </td>
                      <td><?php echo number_format($value5->transfermoney,2);?></td><!--ยอดสุทธิ-->
                      <td> </td>



                      <td></td>
                  </tr>
                  <?php } ?>


                  <?php if($value5->withhold == 1 || $value5->withhold == 3 || $value5->withhold == 5 || $value5->withhold == 1.5){ ?>
                  <tr>
                      <td></td>
                      <td> </td>
                      <td></td>
                      <td></td>



                      <td>


                      </td>

                      <td>
                        <?php
                              $modelwht = Maincenter::getdataconfig_acc($wht);
                              if($modelwht){
                                    echo $modelwht[0]->accounttypeno;
                        ?>
                        <?php
                              }
                        ?>
                      </td>
                      <td>
                        <?php
                           if($modelwht){
                                 echo $modelwht[0]->accounttypefull;
                           }
                        ?>
                      </td>
                      <td> </td>
                      <td><?php echo number_format($value5->withholdmoney,2);?></td><!--WTH-->
                      <td> </td>



                      <td></td>
                  </tr>
                  <?php } ?>

                  <?php if($value5->discountmoney > "0"){ ?>
                  <tr>
                      <td></td>
                      <td> </td>
                      <td></td>
                      <td></td>



                      <td>


                      </td>

                      <td>
                        <?php
                              $modeldiscount = Maincenter::getdataconfig_acc($discount);
                              if($modeldiscount){
                                    echo $modeldiscount[0]->accounttypeno;
                        ?>
                        <?php
                              }
                        ?>
                      </td>
                      <td>
                        <?php
                           if($modeldiscount){
                                 echo $modeldiscount[0]->accounttypefull;
                           }
                        ?>
                      </td>
                      <td> </td>
                      <td><?php echo number_format($value5->discountmoney,2);?></td><!--ส่วนลด-->
                      <td> </td>



                      <td></td>
                  </tr>
                  <?php } ?>

                  <tr>
                      <td></td>
                      <td> </td>
                      <td></td>
                      <td></td>



                      <td>


                      </td>

                      <td>
                        <?php
                              $modelincome = Maincenter::getdataconfig_acc($income);
                              if($modelincome){
                                    echo $modelincome[0]->accounttypeno;
                        ?>
                        <?php
                              }
                        ?>
                      </td>
                      <td>
                        <?php
                           if($modelincome){
                                 echo $modelincome[0]->accounttypefull;
                           }
                        ?>
                      </td>
                      <td> </td>
                      <td></td>



                      <td><?php echo number_format($value5->subtotal,2);?></td>

                  </tr>

                  <?php if($value5->vat > "0"){ ?>
                  <tr>
                      <td></td>
                      <td> </td>
                      <td></td>
                      <td></td>



                      <td>


                      </td>

                      <td>
                        <?php
                              $modelvat = Maincenter::getdataconfig_acc($vat);
                              if($modelvat){
                                    echo $modelvat[0]->accounttypeno;
                        ?>
                        <?php
                              }
                        ?>
                      </td>
                      <td>
                        <?php
                           if($modelvat){
                                 echo $modelvat[0]->accounttypefull;
                           }
                        ?>
                      </td>
                      <td> </td>
                      <td></td>



                      <td><?php echo number_format($value5->vatmoney,2);?></td><!--Vat-->

                  </tr>
                  <?php } ?>

                  <tr>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>

                      <td></td>
                      <td></td>
                      <td></td>
                      <td><b><?php echo number_format($value5->grandtotal + $value5->withholdmoney + $value5->discountmoney,2);?></b></td>
                      <td><b><?php echo number_format($value5->subtotal + $value5->vatmoney,2);?></b></td>
                  </tr>

              <?php } ?>




              <?php foreach ($datataxrn as $key6 => $value6) { ?> <!--RN-->

                  <tr>
                  <td>
                    <?php if($value6->status_ap == 0 OR  $value6->status_ap == 2){ ?>
                      <!-- <label class="con"> -->
                      <input type="checkbox" name="check_list[]" value="{{ $value6->id }},{{ 6 }}">
                          <!-- <span class="checkmark"></span>
                      </label> -->
                      <br>
                      <br>
						          <button type="button"  class="btn btn-danger"
                      class="btn btn-primary" data-toggle="modal"
                      data-target="#exampleModal"
                      onclick="reply({{$value6->branch_id}},{{$value6->id}},{{ 6 }})" >แก้ไข
                      </button>
                    <?php }else{ ?>
                      <i class="fa fa-check" style="color:green;font-size:20px;"></i>
                    <?php } ?>
                  </td>

                  <td><!--ปี/เดือน/วัน-->
                  <?php
                    $time = explode(" ",trim(($value6->time)));
                    echo $time[0];
                  ?>

                  </td>

                  <td><?php echo ($value6->number_taxinvoice);?></td><!--เลขที่-->


                  <td><?php echo "PV".($value6->number_taxinvoice);?></td>


                  <td><!--รายละเอียด-->
                  <?php
                    $modelcustomerrn = Maincenter::getdatacustomer($value6->customerid);

                    if($modelcustomerrn){
                      echo "<b>รับเงินค่าเช่าเพิ่มจาก</b> ";
                      echo $modelcustomerrn[0]->name." ".$modelcustomerrn[0]->lastname;
                    }
                  ?>


                  </td>

                  <td><!--เลขที่บัญชี-->
                    <?php
                       $modelrn_acc = Maincenter::getdataconfig_rn_acc($value6->branch_id);

                       if ($value6->gettypemoney == "1") {
                          echo "111200";
                       ?>
                       <?php
                       }
                       elseif ($value6->gettypemoney == "2") {
                          if($modelrn_acc){
                            echo $modelrn_acc[0]->accounttypeno;
                            ?>
                            <?php
                          }
                       }
                       elseif($value6->gettypemoney == "3"){
                          echo "111200";
                       ?>
                       <?php
                       }
                       elseif($value6->gettypemoney == "4"){
                          echo "113000";
                       ?>
                       <?php
                       }
                       else{
                          echo " - ";
                       ?>
                       <?php
                       }
                    ?>
                  </td>
                  <td><!--ชื่อเลขที่บัญชี-->
                    <?php
                       if ($value6->gettypemoney == "1") {
                          echo "เงินสด";
                       }
                       elseif ($value6->gettypemoney == "2") {
                           if($modelrn_acc){
                             echo $modelrn_acc[0]->accounttypefull;
                           }
                       }
                       elseif($value6->gettypemoney == "3"){
                          echo "เงินสด";
                       }
                       elseif($value6->gettypemoney == "4"){
                          echo "เช็ครับล่วงหน้า";
                       }
                    ?>
                  </td>
                  <td><?php echo ($value6->branch_id);?></td><!--สาขา-->


                  <td><!--ยอดสุทธิ-->
                    <?php
                       if ($value6->gettypemoney == "1") {
                          echo number_format($value6->grandtotal,2);
                    ?>
                     <?php
                       }elseif ($value6->gettypemoney == "2") {
                          echo number_format($value6->grandtotal,2);
                    ?>
                     <?php
                       }elseif ($value6->gettypemoney == "3") {
                          echo number_format($value6->cashmoney,2);
                    ?>
                     <?php
                       }elseif ($value6->gettypemoney == "4") {
                          echo number_format($value6->grandtotal,2);
                    ?>
                     <?php
                       }else {
                          echo " - ";
                    ?>
                     <?php
                       }
                     ?>
                  </td>



                  <td></td>
                </tr>

                <!--กรณีมีทั้งเงินสด และ เงินโอน-->
                <?php if($value6->gettypemoney == 3) {?>
                <tr>
                    <td></td>
                    <td> </td>
                    <td></td>
                    <td></td>

                    <td>


                    </td>

                    <td>
                      <?php
                         if($modelrn_acc){
                               echo $modelrn_acc[0]->accounttypeno;
                      ?>
                      <?php
                         }
                      ?>
                    </td>
                    <td>
                      <?php
                         if($modelrn_acc){
                               echo $modelrn_acc[0]->accounttypefull;
                         }
                      ?>
                    </td>
                    <td></td>
                    <td><?php echo number_format($value6->transfermoney,2);?></td><!--ยอดสุทธิ-->



                    <td></td>
                </tr>
                <?php } ?>


                <?php if($value6->withhold == 1 || $value6->withhold == 3 || $value6->withhold == 5 || $value6->withhold == 1.5){ ?>
                <tr>
                    <td></td>
                    <td> </td>
                    <td></td>
                    <td></td>


                    <td>


                    </td>

                    <td>
                      <?php
                            $modelwht = Maincenter::getdataconfig_acc($wht);
                            if($modelwht){
                                  echo $modelwht[0]->accounttypeno;
                      ?>
                      <?php
                            }
                      ?>
                    </td>
                    <td>
                      <?php
                         if($modelwht){
                               echo $modelwht[0]->accounttypefull;
                         }
                      ?>
                    </td>
                    <td></td>
                    <td><?php echo number_format($value6->withholdmoney,2);?></td><!--WTH-->


                    <td></td>
                </tr>
                <?php } ?>

                <?php if($value6->discountmoney > "0"){ ?>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>

                    <td>


                    </td>

                    <td>
                      <?php
                            $modeldiscount = Maincenter::getdataconfig_acc($discount);
                            if($modeldiscount){
                                  echo $modeldiscount[0]->accounttypeno;
                      ?>
                      <?php
                            }
                      ?>
                    </td>
                    <td>
                      <?php
                         if($modeldiscount){
                               echo $modeldiscount[0]->accounttypefull;
                         }
                      ?>
                    </td>
                    <td></td>
                    <td><?php echo number_format($value6->discountmoney,2);?></td><!--ส่วนลด-->



                    <td></td>
                </tr>
                <?php } ?>

                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>



                    <td>


                    </td>

                    <td>
                      <?php
                            $modelincome = Maincenter::getdataconfig_acc($income);
                            if($modelincome){
                                  echo $modelincome[0]->accounttypeno;
                      ?>
                      <?php
                            }
                      ?>
                    </td>
                    <td>
                      <?php
                         if($modelincome){
                               echo $modelincome[0]->accounttypefull;
                         }
                      ?>
                    </td>
                    <td></td>
                    <td></td>



                    <td><?php echo number_format($value6->subtotal,2);?></td><!--ยอดก่อน vat-->

                </tr>

                <?php if($value6->vat > "0"){ ?>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>


                    <td>


                    </td>

                    <td>
                      <?php
                            $modelvat = Maincenter::getdataconfig_acc($vat);
                            if($modelvat){
                                  echo $modelvat[0]->accounttypeno;
                      ?>
                      <?php
                            }
                      ?>
                    </td>
                    <td>
                      <?php
                         if($modelvat){
                               echo $modelvat[0]->accounttypefull;
                         }
                      ?>
                    </td>
                    <td></td>
                    <td></td>



                    <td><?php echo number_format($value6->vatmoney,2);?></td><!--Vat-->

                </tr>
                <?php } ?>

                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>

                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><b><?php echo number_format($value6->grandtotal + $value6->withholdmoney + $value6->discountmoney,2);?></b></td>
                    <td><b><?php echo number_format($value6->subtotal + $value6->vatmoney,2);?></b></td>
                </tr>

            <?php }    ?>




            <?php foreach ($datataxcn as $key9 => $value9) { ?> <!--CN-->

                <tr>
                    <td>
                      <?php if($value9->status_ap == 0 OR  $value9->status_ap == 2){ ?>
                        <!-- <label class="con"> -->
                        <input type="checkbox" name="check_list[]" value="{{ $value9->id }},{{ 9 }}">
                            <!-- <span class="checkmark"></span>
                        </label> -->
                        <br>
                        <br>
						            <button type="button"  class="btn btn-danger"
                        class="btn btn-primary" data-toggle="modal"
                        data-target="#exampleModal"
                        onclick="reply({{$value9->branch_id}},{{$value->id}},{{ 9 }})" >แก้ไข</button>
                      <?php }else{ ?>
                          <i class="fa fa-check" style="color:green;font-size:20px;"></i>
                      <?php } ?>
                    </td>

                    <td><!--ปี/เดือน/วัน-->
                     <?php
                       $time = explode(" ",trim(($value9->time)));
                       echo $time[0];
                     ?>

                    </td>

                    <td><?php echo ($value9->number_taxinvoice);?></td><!--เลขที่-->


                    <td><?php echo "PV".($value9->number_taxinvoice);?></td>



                    <td>
                     <?php
                        $modelcustomercn = Maincenter::getdatacustomer($value9->customerid);

                        if($modelcustomercn){
                            echo "<b>คืนเงินค่าเช่าจาก</b> ";
                            echo $modelcustomercn[0]->name." ".$modelcustomercn[0]->lastname;
                        }
                     ?>


                    </td>

                    <td>
                      <?php
                            $modelincome = Maincenter::getdataconfig_acc($income);
                            if($modelincome){
                                  echo $modelincome[0]->accounttypeno;
                      ?>
                      <?php
                            }
                      ?>
                    </td>
                    <td>
                      <?php
                         if($modelincome){
                               echo $modelincome[0]->accounttypefull;
                         }
                      ?>
                    </td>
                    <td><?php echo  ($value9->branch_id);?></td><!--สาขา-->


                    <td><?php echo number_format($value9->subtotal,2);?></td><!--ยอดสุทธิ-->




                    <td></td>
                </tr>

                <?php if($value9->vat > "0"){ ?>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>



                    <td>


                    </td>

                    <td>
                      <?php
                            $modelvat = Maincenter::getdataconfig_acc($vat);
                            if($modelvat){
                                  echo $modelvat[0]->accounttypeno;
                      ?>
                      <?php
                            }
                      ?>
                    </td>
                    <td>
                      <?php
                         if($modelvat){
                               echo $modelvat[0]->accounttypefull;
                         }
                      ?>
                    </td>
                    <td></td>
                    <td><?php echo number_format($value9->vatmoney,2);?></td><!--Vat-->




                    <td></td>
                </tr>
                <?php } ?>

                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>


                    <td>


                    </td>

                    <td><!--เลขที่บัญชี-->
                      <?php
                         $modelcn_acc = Maincenter::getdataconfig_cn_acc(1001);

                         if ($value9->gettypemoney == "1") {
                            echo "111200";
                      ?> 
                      <?php
                         }
                         elseif ($value9->gettypemoney == "2") {
                            if($modelcn_acc){
                              echo $modelcn_acc[0]->accounttypeno;
                            ?>
                            <?php
                            }
                         }?>
                    </td>
                    <td><!--ชื่อเลขที่บัญชี-->
                      <?php
                         if ($value9->gettypemoney == "1") {
                            echo "เงินสด";
                         }
                         elseif ($value9->gettypemoney == "2") {
                             if($modelcn_acc){
                               echo $modelcn_acc[0]->accounttypefull;
                             }
                         }
                      ?>
                    </td>
                    <td></td>
                    <td></td>



                    <td><?php echo number_format($value9->grandtotal + $value9->withholdmoney + $value9->discountmoney,2);?></td><!--ยอดก่อน vat-->
                </tr>

                <tr>
                    <td></td>
                    <td></td>
                    <td></td>

                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><b><?php echo number_format($value9->subtotal + $value9->vatmoney,2);?></b></td>
                    <td><b><?php echo number_format($value9->grandtotal + $value9->withholdmoney + $value9->discountmoney,2);?></b></td>
                </tr>

            <?php }   ?>




            <?php
                  // echo "<pre>";
                  // print_r($datataxrs);
                  // exit;
             foreach ($datataxrs as $key10 => $value10) {
            ?> <!--RS-->

                <tr>
                    <td>
                      <?php if($value10->status_ap == 0 OR  $value10->status_ap == 2){ ?>
                        <!-- <label class="con"> -->
                        <input type="checkbox" name="check_list[]" value="{{ $value10->id }},{{ 10 }}">
                            <!-- <span class="checkmark"></span>
                        </label> -->
                        <br>
                        <br>
						           <button type="button"  class="btn btn-danger"
                       class="btn btn-primary" data-toggle="modal"
                       data-target="#exampleModal"
                       onclick="reply({{$value10->branch_id}},{{$value10->id}},{{ 10 }})" >แก้ไข
                       </button>
                      <?php }else{ ?>
                        <i class="fa fa-check" style="color:green;font-size:20px;"></i>
                      <?php } ?>
                    </td>

                    <td><!--ปี/เดือน/วัน-->
                     <?php
                       $time = explode(" ",trim(($value10->date_approved)));
                       echo $time[0];

                     ?>

                    </td>

                    <td><?php echo ($value10->number_taxinvoice); ?></td><!--เลขที่-->


                    <td><?php echo "PV".($value10->number_taxinvoice); ?></td>

                    <td><!--รายละเอียด-->
                     <?php
                        $modelcustomerrs = Maincenter::getdatacustomer($value10->customer_id);

                        if(!empty($modelcustomerrs)){
                            echo "<b>รับเงินรายได้อื่นๆ	จาก</b> ";
                            echo $modelcustomerrs[0]->name." ".$modelcustomerrs[0]->lastname;
                        }


                     ?>

                    </td>
                    <td><!--เลขที่บัญชี-->
                      <?php
                         $modelrs_acc = Maincenter::getdataconfig_rs_acc($value10->branch_id);

                         if ($value10->gettypemoney == "1") {
                            echo "111200";
                         ?> <
                         <?php
                         }
                         elseif ($value10->gettypemoney == "2") {
                            if($modelrs_acc){
                              echo $modelrs_acc[0]->accounttypeno;
                            ?>
                            <?php
                            }
                         }
                         elseif($value10->gettypemoney == "3"){
                            echo "111200";
                         ?> <
                         <?php
                         }
                         elseif($value10->gettypemoney == "4"){
                            echo "113000";
                         ?>
                         <?php
                         }
                         else{
                            echo " - ";
                         ?>
                         <?php
                         }
                      ?>
                    </td>
                    <td><!--ชื่อเลขที่บัญชี-->
                      <?php
                         if ($value10->gettypemoney == "1") {
                            echo "เงินสด";
                         }
                         elseif ($value10->gettypemoney == "2") {
                             if($modelrs_acc){
                               echo $modelrs_acc[0]->accounttypefull;
                             }
                         }
                         elseif($value10->gettypemoney == "3"){
                            echo "เงินสด";
                         }
                         elseif($value10->gettypemoney == "4"){
                            echo "เช็ครับล่วงหน้า";
                         }
                      ?>
                    </td>
                    <td><?php echo ($value10->branch_id);?></td><!--สาขา-->


                    <td><!--ยอดสุทธิ-->
                      <?php
                         if ($value10->gettypemoney == "1") {
                            echo number_format($value10->grandtotal,2);
                         ?>
                         <?php
                         }elseif ($value10->gettypemoney == "2") {
                            echo number_format($value10->grandtotal,2);
                         ?>
                         <?php
                         }elseif ($value10->gettypemoney == "3") {
                            echo number_format($value10->cashmoney,2);
                         ?>
                         <?php
                         }elseif ($value10->gettypemoney == "4") {
                            echo number_format($value10->grandtotal,2);
                         ?>
                         <?php
                         }else {
                            echo " - ";
                         ?>
                         <?php
                         }

                       ?>
                    </td>



                    <td></td>
                </tr>

                <!--กรณีมีทั้งเงินสด และ เงินโอน-->
                <?php if($value10->gettypemoney == 3) {?>
                <tr>
                    <td></td>
                    <td></td>
                    <td> </td>
                    <td></td>



                    <td>

                    </td>

                    <td>
                      <?php
                         if($modelrs_acc){
                               echo $modelrs_acc[0]->accounttypeno;
                      ?>
                      <?php
                         }
                      ?>
                    </td>
                    <td>
                      <?php
                         if($modelrs_acc){
                               echo $modelrs_acc[0]->accounttypefull;
                         }
                      ?>
                    </td>
                    <td></td>
                    <td><?php echo number_format($value10->transfermoney,2);?></td><!--ยอดสุทธิ-->




                    <td></td>
                </tr>
                <?php } ?>


                <?php if($value10->withhold == 1 || $value10->withhold == 3 || $value10->withhold == 5 || $value10->withhold == 1.5){ ?>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>



                    <td>

                    </td>

                    <td>
                      <?php
                            $modelwht = Maincenter::getdataconfig_acc($wht);
                            if($modelwht){
                                  echo $modelwht[0]->accounttypeno;
                      ?>
                      <?php
                            }
                      ?>
                    </td>
                    <td>
                      <?php
                         if($modelwht){
                               echo $modelwht[0]->accounttypefull;
                         }
                      ?>
                    </td>
                    <td></td>
                    <td><?php echo number_format($value10->withholdmoney,2);?></td><!--WTH-->




                <td></td>
                </tr>
                <?php }  ?>

                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>



                    <td>   </td>

                    <td>
                      <?php
                            $modelother = Maincenter::getdataconfig_acc($other);
                            if($modelother){
                                  echo $modelother[0]->accounttypeno;
                      ?>
                      <?php
                            }
                      ?>
                    </td>
                    <td>
                      <?php
                         if($modelother){
                               echo $modelother[0]->accounttypefull;
                         }
                      ?>
                    </td>
                    <td></td>
                    <td></td>



                    <td><?php echo number_format($value10->subtotal,2);?></td><!--ยอดก่อน vat-->

                </tr>

                <?php if($value10->vat > "0"){ ?>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>



                    <td>

                    </td>

                    <td>
                      <?php
                            $modelvat = Maincenter::getdataconfig_acc($vat);
                            if($modelvat){
                                  echo $modelvat[0]->accounttypeno;
                      ?>
                      <?php
                            }
                      ?>
                    </td>
                    <td>
                      <?php
                         if($modelvat){
                               echo $modelvat[0]->accounttypefull;
                         }
                      ?>
                    </td>
                    <td></td>
                    <td></td>



                    <td><?php echo number_format($value10->vatmoney,2);?></td><!--Vat-->

                </tr>
                <?php } ?>

                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>

                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><b><?php echo number_format($value10->grandtotal + $value10->withholdmoney,2);?></b></td>
                    <td><b><?php echo number_format($value10->subtotal + $value10->vatmoney,2);?></b></td>
                </tr>

            <?php }   ?>




            <?php foreach ($datataxss as $key11 => $value11) { ?> <!--SS-->

                <tr>
                    <td>
                      <?php if($value11->status_ap == 0 OR  $value11->status_ap == 2){ ?>
                        <!-- <label class="con"> -->
                        <input type="checkbox" name="check_list[]" value="{{ $value11->id }},{{ 11 }}">
                            <!-- <span class="checkmark"></span> -->
                        </label>

                      <?php }else{ ?>
                        <i class="fa fa-check" style="color:green;font-size:20px;"></i>
                      <?php } ?>
                    </td>

                    <td><!--ปี/เดือน/วัน-->
                     <?php
                       $time = explode(" ",trim(($value11->date_approved)));
                       echo $time[0];
                     ?>

                    </td>
                    <td><?php echo ($value11->bill_no);?></td><!--เลขที่-->


                    <td><?php echo "PV".($value11->bill_no);?></td>


                    <td><!--รายละเอียด-->
                     <?php
                        $modelcustomerss = Maincenter::getdatacustomer($value11->customer_id);

                        if($modelcustomerss){
                            echo "<b>รับเงินค่าเช่าจาก</b> ";
                            echo $modelcustomerss[0]->name." ".$modelcustomerss[0]->lastname;
                        }
                     ?>
                     </td>
                    <td><!--เลขที่บัญชี-->
                      <?php
                         $modelss_acc = Maincenter::getdataconfig_ss_acc($value11->branch_id);

                         if ($value11->gettypemoney == "1") {
                            echo "111200";
                         ?>
                         <?php
                         }
                         elseif ($value11->gettypemoney == "2") {
                            if($modelss_acc){
                              echo $modelss_acc[0]->accounttypeno;
                            ?>
                            <?php
                            }
                         }
                      ?>
                    </td>
                    <td><!--ชื่อเลขที่บัญชี-->
                      <?php
                         if ($value11->gettypemoney == "1") {
                            echo "เงินสด";
                         }
                         elseif ($value11->gettypemoney == "2") {
                             if($modelss_acc){
                               echo $modelss_acc[0]->accounttypefull;
                             }
                         }
                      ?>
                    </td>
                    <td><?php echo ($value11->branch_id);?></td><!--สาขา-->


                    <td><?php echo number_format($value11->grandtotal,2);?></td><!--ยอดสุทธิ-->




                    <td></td>
                </tr>

                <?php if($value11->discountmoney > "0"){ ?>
                <tr>
                    <td></td>
                    <td></td>
                    <td><i</td>
                    <td></td>



                    <td> </td>

                    <td>
                      <?php
                            $modeldiscount = Maincenter::getdataconfig_acc($discount);
                            if($modeldiscount){
                                  echo $modeldiscount[0]->accounttypeno;
                      ?>
                      <?php
                            }
                      ?>
                    </td>
                    <td>
                      <?php
                         if($modeldiscount){
                               echo $modeldiscount[0]->accounttypefull;
                         }
                      ?>
                    </td>
                    <td></td>
                    <td><?php echo number_format($value11->discountmoney,2);?></td><!--ส่วนลด-->




                    <td></td>
                </tr>
                <?php } ?>

                <?php
                    $modelmaterial_ss = Maincenter::getdatamaterial_ss($value11->id);
                ?>


                <?php if($value11->vat > "0"){ ?>
                <tr>
                    <td></td>
                    <td> </td>
                    <td> </td>
                    <td></td>



                    <td> </td>

                    <td>
                      <?php
                            $modelvat = Maincenter::getdataconfig_acc($vat);
                            if($modelvat){
                                  echo $modelvat[0]->accounttypeno;
                      ?>
                      <?php
                            }
                      ?>
                    </td>
                    <td>
                      <?php
                         if($modelvat){
                               echo $modelvat[0]->accounttypefull;
                         }
                      ?>
                    </td>
                    <td></td>
                    <td></td>



                    <td><?php echo number_format($value11->vatmoney,2);?></td><!--Vat-->

                </tr>
                <?php } ?>

                <?php if($modelmaterial_ss){?>
                <?php if($value11->grandtotal < ($value11->grandtotal + $modelmaterial_ss[0]->totalpricedepreciation)){ ?> <!--กำไรจากการขาย-->
                <tr>
                    <td></td>
                    <td> </td>
                    <td></td>
                    <td></td>



                    <td>  </td>

                    <td>
                      <?php
                            $modelvat = Maincenter::getdataconfig_acc($profit);
                            if($modelvat){
                                  echo $modelvat[0]->accounttypeno;
                      ?>
                      <?php
                            }
                      ?>
                    </td>
                    <td>
                      <?php
                         if($modelvat){
                               echo $modelvat[0]->accounttypefull;
                         }
                      ?>
                    </td>
                    <td></td>
                    <td></td>


                    <td><?php echo number_format($value11->grandtotal  - $value11->vatmoney,2);?></td><!--Vat-->

                </tr>
                <?php } ?>


                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>

                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><b><?php echo number_format($value11->grandtotal,2);?></b></td>
                    <td><b><?php echo number_format($value11->grandtotal,2);?></b></td>

                </tr>
                <?php } ?>

            <?php } ?>




            <?php foreach ($datataxti as $key12 => $value12) { ?> <!--TI-->
			
				<?php if($value12->time <= $datenovatinsu){?>
				 <tr>
                    <td>
                      <?php if($value12->status_ap == 0 OR  $value12->status_ap == 2){?>
                        <!-- <label class="con"> -->
                        <input type="checkbox" name="check_list[]" value="{{ $value12->id }},{{ 12 }}">
                            <!-- <span class="checkmark"></span>
                        </label> -->
                        <br>
                        <br>
                        <button type="button"  class="btn btn-danger"
                        class="btn btn-primary" data-toggle="modal"
                        data-target="#exampleModal"
                        onclick="reply({{$value12->branch_id}},{{$value12->id}},{{ 12 }})" >แก้ไข</button>
                      <?php }else{ ?>
                        <i class="fa fa-check" style="color:green;font-size:20px;"></i>
                      <?php } ?>
                    </td>

                    <td><!--ปี/เดือน/วัน-->
                     <?php
                       $time = explode(" ",trim(($value12->time)));
                       echo $time[0];
                     ?>
                    </td>
                    <td><?php echo ($value12->number_taxinvoice);?></td><!--เลขที่-->
                    <td><?php echo "PV".($value12->number_taxinvoice);?></td>

                    <td><!--รายละเอียด-->
                     <?php
                        $modelcustomerti = Maincenter::getdatacustomer($value12->customerid);

                        if($modelcustomerti){
                            echo "<b>รับเงินประกันจาก</b> ";
                            echo $modelcustomerti[0]->name." ".$modelcustomerti[0]->lastname;
                        }
                     ?>
                    </td>
                    <td><!--เลขที่บัญชี-->
                      <?php
                         $modelti_acc = Maincenter::getdataconfig_ti_acc($value12->branch_id);

                         if ($value12->gettypemoney == "1") {
                            echo "111200";
                         }
                         elseif ($value12->gettypemoney == "2") {
                            if($modelti_acc){
                              echo $modelti_acc[0]->accounttypeno;
                            }
                         }
                         elseif($value12->gettypemoney == "3"){
                            echo "111200";
                         }
                         elseif($value12->gettypemoney == "4"){
                            echo "113000";
                         }
                      ?>
                    </td>
                    <td><!--ชื่อเลขที่บัญชี-->
                      <?php
                         if ($value12->gettypemoney == "1") {
                            echo "เงินสด";
                         }
                         elseif ($value12->gettypemoney == "2") {
                             if($modelti_acc){
                               echo $modelti_acc[0]->accounttypefull;
                             }
                         }
                         elseif($value12->gettypemoney == "3"){
                            echo "เงินสด";
                         }
                         elseif($value12->gettypemoney == "4"){
                            echo "เช็ครับล่วงหน้า";
                         }
                      ?>
                    </td>
                    <td><?php echo ($value12->branch_id);?></td><!--สาขา-->
                    <td><!--ยอดสุทธิ-->
                      <?php
                         if($value12->cashmoney > 0 && $value12->transfermoney > 0){
                            echo number_format($value12->cashmoney,2);
                         }elseif ($value12->gettypemoney == "1") {
                            echo number_format($value12->grandtotal,2);
                         }elseif ($value12->gettypemoney == "2") {
                            echo number_format($value12->grandtotal,2);
                         }elseif ($value12->gettypemoney == "4") {
                            echo number_format($value12->grandtotal,2);
                         }
                       ?>
                    </td>
                    <td></td>
                </tr>

                <!--กรณีมีทั้งเงินสด และ เงินโอน-->
                <?php if($value12->gettypemoney == 3) {?>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>

                    <td></td>
                    <td>
                      <?php
                         if($modelti_acc){
                               echo $modelti_acc[0]->accounttypeno;
                         }
                      ?>
                    </td>
                    <td>
                      <?php
                         if($modelti_acc){
                               echo $modelti_acc[0]->accounttypefull;
                         }
                      ?>
                    </td>
                    <td></td>
                    <td><?php echo number_format($value12->transfermoney,2);?></td><!--ยอดสุทธิ-->
                    <td></td>
                </tr>
                <?php } ?>


                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>

                    <td></td>
                    <td>
                      <?php
                            $modelinsurance = Maincenter::getdataconfig_acc($insurance);
                            if($modelinsurance){
                                  echo $modelinsurance[0]->accounttypeno;
                            }
                      ?>
                    </td>
                    <td>
                      <?php
                         if($modelinsurance){
                               echo $modelinsurance[0]->accounttypefull;
                         }
                      ?>
                    </td>
                    <td></td>
                    <td></td>
                    <td><?php echo number_format($value12->subtotal,2);?></td><!--ยอดก่อน vat-->
                </tr>

                <?php if($value12->vat > "0"){ ?>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>

                    <td></td>
                    <td>
                      <?php
                            $modelvat = Maincenter::getdataconfig_acc($vat);
                            if($modelvat){
                                  echo $modelvat[0]->accounttypeno;
                            }
                      ?>
                    </td>
                    <td>
                      <?php
                         if($modelvat){
                               echo $modelvat[0]->accounttypefull;
                         }
                      ?>
                    </td>
                    <td></td>
                    <td></td>
                    <td><?php echo number_format($value12->vatmoney,2);?></td><!--Vat-->
                </tr>
                <?php } ?>

                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>

                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><b><?php echo number_format($value12->grandtotal,2);?></b></td>
                    <td><b><?php echo number_format($value12->subtotal + $value12->vatmoney,2);?></b></td>
                </tr>
				 <?php }else{ //TI หลัง 12 ?>
					 <tr>
						<td>
						  <?php if($value12->status_ap == 0 OR  $value12->status_ap == 2){?>
							<!-- <label class="con"> -->
							<input type="checkbox" name="check_list[]" value="{{ $value12->id }},{{ 12 }}">
								<!-- <span class="checkmark"></span>
							</label> -->
							<br>
							<br>
							<button type="button"  class="btn btn-danger"
							class="btn btn-primary" data-toggle="modal"
							data-target="#exampleModal"
							onclick="reply({{$value12->branch_id}},{{$value12->id}},{{ 12 }})" >แก้ไข</button>
						  <?php }else{ ?>
							<i class="fa fa-check" style="color:green;font-size:20px;"></i>
						  <?php } ?>
						</td>

						<td><!--ปี/เดือน/วัน-->
						 <?php
						   $time = explode(" ",trim(($value12->time)));
						   echo $time[0];
						 ?>
						</td>
						<td><?php echo ($value12->number_taxinvoice);?></td><!--เลขที่-->
						<td><?php echo "PV".($value12->number_taxinvoice);?></td>

						<td><!--รายละเอียด-->
						 <?php
							$modelcustomerti = Maincenter::getdatacustomer($value12->customerid);

							if($modelcustomerti){
								echo "<b>รับเงินประกันจาก</b> ";
								echo $modelcustomerti[0]->name." ".$modelcustomerti[0]->lastname;
							}
						 ?>
						</td>
						<td><!--เลขที่บัญชี-->
						  <?php
							 $modelti_acc = Maincenter::getdataconfig_ti_acc($value12->branch_id);

							 if ($value12->gettypemoney == "1") {
								echo "111200";
							 }
							 elseif ($value12->gettypemoney == "2") {
								if($modelti_acc){
								  echo $modelti_acc[0]->accounttypeno;
								}
							 }
							 elseif($value12->gettypemoney == "3"){
								echo "111200";
							 }
							 elseif($value12->gettypemoney == "4"){
								echo "113000";
							 }
						  ?>
						</td>
						<td><!--ชื่อเลขที่บัญชี-->
						  <?php
							 if ($value12->gettypemoney == "1") {
								echo "เงินสด";
							 }
							 elseif ($value12->gettypemoney == "2") {
								 if($modelti_acc){
								   echo $modelti_acc[0]->accounttypefull;
								 }
							 }
							 elseif($value12->gettypemoney == "3"){
								echo "เงินสด";
							 }
							 elseif($value12->gettypemoney == "4"){
								echo "เช็ครับล่วงหน้า";
							 }
						  ?>
						</td>
						<td><?php echo ($value12->branch_id);?></td><!--สาขา-->
						<td><!--ยอดสุทธิ-->
						  <?php
							 if($value12->cashmoney > 0 && $value12->transfermoney > 0){
								echo number_format($value12->cashmoney,2);
							 }elseif ($value12->gettypemoney == "1") {
								echo number_format($value12->grandtotal,2);
							 }elseif ($value12->gettypemoney == "2") {
								echo number_format($value12->grandtotal,2);
							 }elseif ($value12->gettypemoney == "4") {
								echo number_format($value12->grandtotal,2);
							 }
						   ?>
						</td>
						<td></td>
					</tr>

					<!--กรณีมีทั้งเงินสด และ เงินโอน-->
					<?php if($value12->gettypemoney == 3) {?>
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td></td>

						<td></td>
						<td>
						  <?php
							 if($modelti_acc){
								   echo $modelti_acc[0]->accounttypeno;
							 }
						  ?>
						</td>
						<td>
						  <?php
							 if($modelti_acc){
								   echo $modelti_acc[0]->accounttypefull;
							 }
						  ?>
						</td>
						<td></td>
						<td><?php echo number_format($value12->transfermoney,2);?></td><!--ยอดสุทธิ-->
						<td></td>
					</tr>
					<?php } ?>


					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td></td>

						<td></td>
						<td>
						  <?php
								$modelinsurance = Maincenter::getdataconfig_acc($insurance);
								if($modelinsurance){
									  echo $modelinsurance[0]->accounttypeno;
								}
						  ?>
						</td>
						<td>
						  <?php
							 if($modelinsurance){
								   echo $modelinsurance[0]->accounttypefull;
							 }
						  ?>
						</td>
						<td></td>
						<td></td>
						<td><?php echo number_format($value12->grandtotal,2);?></td><!--ยอดก่อน vat-->
					</tr> 
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td></td>

						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td><b><?php echo number_format($value12->grandtotal,2);?></b></td>
						<td><b><?php echo number_format($value12->subtotal + $value12->vatmoney,2);?></b></td>
					</tr>
				
				<?php } ?>

               

            <?php } ?>




            <?php foreach ($datataxci as $key13 => $value13) { ?> <!--CI-->
			
			<?php if($value13->time <= $datenovatinsu){ ?>
				 <tr>
                    <td>
                      <?php if($value13->status_ap == 0 OR  $value13->status_ap == 2){ ?>
                        <!-- <label class="con"> -->
                        <input type="checkbox" name="check_list[]" value="{{ $value13->id }},{{ 13 }}">
                            <!-- <span class="checkmark"></span> -->
                        <!-- </label> -->
                        <br>
                        <br>
                        <button type="button"  class="btn btn-danger"
                        class="btn btn-primary" data-toggle="modal"
                        data-target="#exampleModal"
                        onclick="reply({{$value13->branch_id}},{{$value13->id}},{{ 13 }})" >แก้ไข
                        </button>
                      <?php }else{ ?>
                        <i class="fa fa-check" style="color:green;font-size:20px;"></i>
                      <?php } ?>
                    </td>

                    <td><!--ปี/เดือน/วัน-->
                     <?php
                       $time = explode(" ",trim(($value13->time)));
                       echo $time[0];
                     ?>
                    </td>
                    <td><?php echo ($value13->number_taxinvoice);?></td><!--เลขที่-->
                    <td><?php echo "PV".($value13->number_taxinvoice);?></td>

                    <td><!--รายละเอียด-->
                     <?php
                        $modelcustomerci = Maincenter::getdatacustomer($value13->customerid);

                        if($modelcustomerci){
                            echo "<b>คืนเงินประกันให้</b> ";
                            echo $modelcustomerci[0]->name." ".$modelcustomerci[0]->lastname;
                        }
                     ?>
                    </td>
                    <td>
                      <?php
                            $modelinsurance = Maincenter::getdataconfig_acc($insurance);
                            if($modelinsurance){
                                  echo $modelinsurance[0]->accounttypeno;
                            }
                      ?>
                    </td>
                    <td>
                      <?php
                         if($modelinsurance){
                               echo $modelinsurance[0]->accounttypefull;
                         }
                      ?>
                    </td>
                    <td><?php echo ($value13->branch_id);?></td><!--สาขา-->
                    <td><?php echo number_format($value13->subtotal,2);?></td><!--ยอดก่อน vat-->
                    <td></td>
                </tr>

                <?php if($value13->vat > "0"){ ?>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>

                    <td></td>
                    <td>
                      <?php
                            $modelvat = Maincenter::getdataconfig_acc($vat);
                            if($modelvat){
                                  echo $modelvat[0]->accounttypeno;
                            }
                      ?>
                    </td>
                    <td>
                      <?php
                         if($modelvat){
                               echo $modelvat[0]->accounttypefull;
                         }
                      ?>
                    </td>
                    <td></td>
                    <td><?php echo number_format($value13->vatmoney,2);?></td><!--Vat-->
                    <td></td>
                </tr>
                <?php } ?>

                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>

                    <td></td>
                    <td><!--เลขที่บัญชี-->
                      <?php
                         $modelci_acc = Maincenter::getdataconfig_ci_acc($value13->branch_id);

                         if ($value13->gettypemoney == "1") {
                            echo "111200";
                         }
                         elseif ($value13->gettypemoney == "2") {
                            if($modelci_acc){
                              echo $modelci_acc[0]->accounttypeno;
                            }
                         }
                      ?>
                    </td>
                    <td><!--ชื่อเลขที่บัญชี-->
                      <?php
                         if ($value13->gettypemoney == "1") {
                            echo "เงินสด";
                         }
                         elseif ($value13->gettypemoney == "2") {
                             if($modelci_acc){
                               echo $modelci_acc[0]->accounttypefull;
                             }
                         }
                      ?>
                    </td>
                    <td></td>
                    <td></td>
                    <td><?php echo number_format($value13->grandtotal,2);?></td><!--ยอดสุทธิ-->
                </tr>

                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>

                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><b><?php echo number_format($value13->subtotal + $value13->vatmoney,2);?></b></td>
                    <td><b><?php echo number_format($value13->grandtotal,2);?></b></td>
                </tr>
			<?php }else{ ?>
				 <tr>
                    <td>
                      <?php if($value13->status_ap == 0 OR  $value13->status_ap == 2){ ?>
                        <!-- <label class="con"> -->
                        <input type="checkbox" name="check_list[]" value="{{ $value13->id }},{{ 13 }}">
                            <!-- <span class="checkmark"></span> -->
                        <!-- </label> -->
                        <br>
                        <br>
                        <button type="button"  class="btn btn-danger"
                        class="btn btn-primary" data-toggle="modal"
                        data-target="#exampleModal"
                        onclick="reply({{$value13->branch_id}},{{$value13->id}},{{ 13 }})" >แก้ไข
                        </button>
                      <?php }else{ ?>
                        <i class="fa fa-check" style="color:green;font-size:20px;"></i>
                      <?php } ?>
                    </td>

                    <td><!--ปี/เดือน/วัน-->
                     <?php
                       $time = explode(" ",trim(($value13->time)));
                       echo $time[0];
                     ?>
                    </td>
                    <td><?php echo ($value13->number_taxinvoice);?></td><!--เลขที่-->
                    <td><?php echo "PV".($value13->number_taxinvoice);?></td>

                    <td><!--รายละเอียด-->
                     <?php
                        $modelcustomerci = Maincenter::getdatacustomer($value13->customerid);

                        if($modelcustomerci){
                            echo "<b>คืนเงินประกันให้</b> ";
                            echo $modelcustomerci[0]->name." ".$modelcustomerci[0]->lastname;
                        }
                     ?>
                    </td>
                    <td>
                      <?php
                            $modelinsurance = Maincenter::getdataconfig_acc($insurance);
                            if($modelinsurance){
                                  echo $modelinsurance[0]->accounttypeno;
                            }
                      ?>
                    </td>
                    <td>
                      <?php
                         if($modelinsurance){
                               echo $modelinsurance[0]->accounttypefull;
                         }
                      ?>
                    </td>
                    <td><?php echo ($value13->branch_id);?></td><!--สาขา-->
                    <td><?php echo number_format($value13->grandtotal,2);?></td><!--ยอดก่อน vat-->
                    <td></td>
                </tr>

                
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>

                    <td></td>
                    <td><!--เลขที่บัญชี-->
                      <?php
                         $modelci_acc = Maincenter::getdataconfig_ci_acc($value13->branch_id);

                         if ($value13->gettypemoney == "1") {
                            echo "111200";
                         }
                         elseif ($value13->gettypemoney == "2") {
                            if($modelci_acc){
                              echo $modelci_acc[0]->accounttypeno;
                            }
                         }
                      ?>
                    </td>
                    <td><!--ชื่อเลขที่บัญชี-->
                      <?php
                         if ($value13->gettypemoney == "1") {
                            echo "เงินสด";
                         }
                         elseif ($value13->gettypemoney == "2") {
                             if($modelci_acc){
                               echo $modelci_acc[0]->accounttypefull;
                             }
                         }
                      ?>
                    </td>
                    <td></td>
                    <td></td>
                    <td><?php echo number_format($value13->grandtotal,2);?></td><!--ยอดสุทธิ-->
                </tr>

                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>

                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><b><?php echo number_format($value13->subtotal + $value13->vatmoney,2);?></b></td>
                    <td><b><?php echo number_format($value13->grandtotal,2);?></b></td>
                </tr>
			<?php } ?>

               

            <?php } ?>


            <?php foreach ($datataxtp as $key7 => $value7) { ?> <!--TP-->

                <tr>
                    <td>
                      <?php if($value7->status_ap == 0 OR  $value7->status_ap == 2){ ?>
                        
                        <input type="checkbox" name="check_list[]" value="{{ $value7->id }},{{ 7 }}">
                            

                      <?php }else{ ?>
                          <i class="fa fa-check" style="color:green;font-size:20px;"></i>
                      <?php } ?>
                    </td>
					   

                    <td><!--ปี/เดือน/วัน-->
                    <?php
                      $time = explode(" ",trim(($value7->timereal)));
                      echo $time[0];
                    ?>
                    </td>
                    <td><?php echo ($value7->number_taxinvoice);?></td><!--เลขที่-->
                    <td><?php echo "PV".($value7->number_taxinvoice);?></td>

                    <td><!--รายละเอียด-->
                    <?php
                      $modelcustomertp = Maincenter::getdatacustomer($value7->customerid);

                      if($modelcustomertp){
                      echo "<b>รับเงินค่าเช่าจาก</b> ";
                      echo $modelcustomertp[0]->name." ".$modelcustomertp[0]->lastname;
                      }
                    ?>
                    </td>
                    <td><!--เลขที่บัญชี-->
                      <?php
                         $modeltp_acc = Maincenter::getdataconfig_tp_acc($value7->branch_id);

                         if ($value7->gettypemoney == "1") {
                            echo "111200";
                         }
                         elseif ($value7->gettypemoney == "2") {
                            if($modeltp_acc){
                              echo $modeltp_acc[0]->accounttypeno;
                            }
                         }
                         elseif($value7->gettypemoney == "3"){
                            echo "111200";
                         }
                         elseif($value7->gettypemoney == "4"){
                            echo "113000";
                         }
                      ?>
                    </td>
                    <td><!--ชื่อเลขที่บัญชี-->
                      <?php
                         if ($value7->gettypemoney == "1") {
                            echo "เงินสด";
                         }
                         elseif ($value7->gettypemoney == "2") {
                             if($modeltp_acc){
                               echo $modeltp_acc[0]->accounttypefull;
                             }
                         }
                         elseif($value7->gettypemoney == "3"){
                            echo "เงินสด";
                         }
                         elseif($value7->gettypemoney == "4"){
                            echo "เช็ครับล่วงหน้า";
                         }
                      ?>
                    </td>
                    <td><?php echo ($value7->branch_id);?></td><!--สาขา-->
                    <td><!--ยอดสุทธิ-->
                      <?php
                         if ($value7->gettypemoney == "1") {
                            echo number_format($value7->grandtotal,2);
                         }elseif ($value7->gettypemoney == "2") {
                            echo number_format($value7->grandtotal,2);
                         }elseif ($value7->gettypemoney == "3") {
                            echo number_format($value7->cashmoney,2);
                         }elseif ($value7->gettypemoney == "4") {
                            echo number_format($value7->grandtotal,2);
                         }
                       ?>
                    </td>
                    <td></td>
                </tr>

                <!--กรณีมีทั้งเงินสด และ เงินโอน-->
                <?php if($value7->gettypemoney == 3) {?>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>

                    <td></td>
                    <td>
                      <?php
                         if($modeltp_acc){
                               echo $modeltp_acc[0]->accounttypeno;
                         }
                      ?>
                    </td>
                    <td>
                      <?php
                         if($modeltp_acc){
                               echo $modeltp_acc[0]->accounttypefull;
                         }
                      ?>
                    </td>
                    <td></td>
                    <td><?php echo number_format($value7->transfermoney,2);?></td><!--ยอดสุทธิ-->
                    <td></td>
                </tr>
                <?php } ?>


                <?php if($value7->withhold == 1 || $value7->withhold == 3 || $value7->withhold == 5 || $value7->withhold == 1.5){ ?>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>

                    <td></td>
                    <td>
                      <?php
                            $modelwht = Maincenter::getdataconfig_acc($wht);
                            if($modelwht){
                                  echo $modelwht[0]->accounttypeno;
                            }
                      ?>
                    </td>
                    <td>
                      <?php
                         if($modelwht){
                               echo $modelwht[0]->accounttypefull;
                         }
                      ?>
                    </td>
                    <td></td>
                    <td><?php echo number_format($value7->withholdmoney,2);?></td><!--WTH-->
                    <td></td>
                </tr>
                <?php } ?>

                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>

                    <td></td>
                    <td>114000</td>
                    <td>ลูกหนี้การค้า</td>
                    <td><?php echo ($value7->branch_id);?></td>
                    <td></td>
                    <td><?php echo number_format($value7->subtotal + $value7->vatmoney,2);?></td>
                </tr>



                <tr>
                    <td></td>
                    <td></td>
                    <td></td>

                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><b><?php echo number_format($value7->grandtotal + $value7->withholdmoney,2);?></b></td>
                    <td><b><?php echo number_format($value7->subtotal + $value7->vatmoney,2);?></b></td>
                </tr>

            <?php } ?>




            <?php foreach ($datataxro as $key8 => $value8) { ?> <!--RO-->

                <tr>
                    <td>
                      <?php //if()} ?>
                        <label class="con">
                        <input type="checkbox" name="check_list[]" value="{{ $value8->id }},{{ 8 }}">
                            <span class="checkmark"></span>
                        </label>

                      <?php //}else{ ?>
                        <!-- <i class="fa fa-check" style="color:green;font-size:20px;"></i> -->
                      <?php //} ?>
                    </td>

                    <td><!--ปี/เดือน/วัน-->
                    <?php
                       $time = explode(" ",trim(($value8->time)));
                       echo $time[0];
                    ?>
                    </td>
                    <td><?php echo ($value8->number_taxinvoice);?></td><!--เลขที่-->
                    <td><?php echo "PV".($value8->number_taxinvoice);?></td>

                    <td><!--รายละเอียด-->
                    <?php
                        $modelcustomerro = Maincenter::getdatacustomer($value8->customerid);

                        if($modelcustomerro){
                            echo "<b>รับเงินค่าเช่าจาก</b> ";
                            echo $modelcustomerro[0]->name." ".$modelcustomerro[0]->lastname;
                        }
                    ?>
                    </td>
                    <td><!--เลขที่บัญชี-->
                      <?php
                         $modelro_acc = Maincenter::getdataconfig_ro_acc($value8->branch_id);

                         if ($value8->gettypemoney == "1") {
                            echo "111200";
                         }
                         elseif ($value8->gettypemoney == "2") {
                            if($modelro_acc){
                              echo $modelro_acc[0]->accounttypeno;
                            }
                         }
                         elseif($value8->gettypemoney == "3"){
                            echo "111200";
                         }
                         elseif($value8->gettypemoney == "4"){
                            echo "113000";
                         }
                      ?>
                    </td>
                    <td><!--ชื่อเลขที่บัญชี-->
                      <?php
                         if ($value8->gettypemoney == "1") {
                            echo "เงินสด";
                         }
                         elseif ($value8->gettypemoney == "2") {
                             if($modelro_acc){
                               echo $modelro_acc[0]->accounttypefull;
                             }
                         }
                         elseif($value8->gettypemoney == "3"){
                            echo "เงินสด";
                         }
                         elseif($value8->gettypemoney == "4"){
                            echo "เช็ครับล่วงหน้า";
                         }
                      ?>
                    </td>
                    <td><?php echo ($value8->branch_id);?></td><!--สาขา-->
                    <td><!--ยอดสุทธิ-->
                      <?php
                         if ($value8->gettypemoney == "1") {
                            echo number_format($value8->grandtotal,2);
                         }elseif ($value8->gettypemoney == "2") {
                            echo number_format($value8->grandtotal,2);
                         }elseif ($value8->gettypemoney == "3") {
                            echo number_format($value8->cashmoney,2);
                         }elseif ($value8->gettypemoney == "4") {
                            echo number_format($value8->grandtotal,2);
                         }
                       ?>
                    </td>
                    <td></td>
                </tr>

                <!--กรณีมีทั้งเงินสด และ เงินโอน-->
                <?php if($value8->gettypemoney == 3) {?>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>

                    <td></td>
                    <td>
                      <?php
                         if($modelro_acc){
                               echo $modelro_acc[0]->accounttypeno;
                         }
                      ?>
                    </td>
                    <td>
                      <?php
                         if($modelro_acc){
                               echo $modelro_acc[0]->accounttypefull;
                         }
                      ?>
                    </td>
                    <td></td>
                    <td><?php echo number_format($value8->transfermoney,2);?></td><!--ยอดสุทธิ-->
                    <td></td>
                </tr>
                <?php } ?>


                <?php if($value8->withhold == 1 || $value8->withhold == 3 || $value8->withhold == 5 || $value8->withhold == 1.5){ ?>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>

                    <td></td>
                    <td>
                      <?php
                            $modelwht = Maincenter::getdataconfig_acc($wht);
                            if($modelwht){
                                  echo $modelwht[0]->accounttypeno;
                            }
                      ?>
                    </td>
                    <td>
                      <?php
                         if($modelwht){
                               echo $modelwht[0]->accounttypefull;
                         }
                      ?>
                    </td>
                    <td></td>
                    <td><?php echo number_format($value8->withholdmoney,2);?></td><!--WTH-->
                    <td></td>
                </tr>
                <?php } ?>

                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>

                    <td></td>
                    <td>114000</td>
                    <td>ลูกหนี้การค้า</td>
                    <td><?php echo ($value8->branch_id);?></td>
                    <td></td>
                    <td><?php echo number_format($value8->grandtotal,2);?></td><!--ยอดก่อน vat-->
                </tr>



                <tr>
                    <td></td>
                    <td></td>
                    <td></td>

                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><b><?php echo number_format($value8->grandtotal + $value8->withholdmoney,2);?></b></td>
                    <td><b><?php echo number_format($value8->subtotal + $value8->vatmoney,2);?></b></td>
                </tr>

            <?php } ?>




          <?php if($datacash){
              // echo "<pre>";
              // print_r($datacash);
              // echo gettype($datacash[0]->grandtotal);

              // exit;
          ?>
          <?php if($datacash[0]->grandtotal > 0){

            ?> <!--เงินนำฝากธนาคารที่ 1-->

            <?php foreach ($datacash as $key14 => $value14) {

               ?>

                <tr>
                    <td>
                      <?php if($value14->status_ap1 == 0 OR  $value14->status_ap1 == 2){ ?>
                        <!-- <label class="con"> -->
                        <input type="checkbox" name="check_list[]" value="{{ $value14->id }},{{ 14 }}">
                            <!-- <span class="checkmark"></span>
                        </label> -->
                        <br>
                        <br>
						            <button type="button"  class="btn btn-danger"
                        class="btn btn-primary" data-toggle="modal"
                        data-target="#exampleModal"
                        onclick="reply({{$value14->branch_id}},{{$value14->id}},{{ 14 }})" >แก้ไข
                        </button>
                      <?php }else{ ?>
                        <i class="fa fa-check" style="color:green;font-size:20px;"></i>
                      <?php } ?>
                    </td>

                    <td><!--ปี/เดือน/วัน-->
                    <?php
                       $time = explode(" ",trim(($value14->time)));
                       echo $time[0];

                    ?>
                    </td>
                    <td>
                        <?php echo ($value14->bill_no);?>
                    </td>
                    <td>
                        <a href="http://103.13.231.24/fsctaccounting/public/checkcash/<?php echo $value14->image?>"   target="_blank">
                          <<-หลักฐานสลิป->>
                        </a>

                    </td>

                    <td>
                    <?php
                        $modelbranch = Maincenter::databranchbycode($value14->branch_id);

                        if($modelbranch){
                            echo "<b>รับเงินฝากจากสาขา </b> ";
                            echo $modelbranch[0]->name_branch;
                            echo "<b>( รายรับประจำวัน )<b>";
                        }
                    ?>
                    </td>
                    <td><!--เลขที่บัญชี-->
                    <?php
                        $modelbranch_bank1 = Maincenter::databranch_bank1($value14->branch_id);

                        if($modelbranch_bank1){
                            echo $modelbranch_bank1[0]->accounttypeno;
                        }
                    ?>
                    </td>
                    <td><!--ชื่อเลขที่บัญชี-->
                    <?php
                        if($modelbranch_bank1){
                            echo $modelbranch_bank1[0]->accounttypefull;
                        }
                    ?>
                    </td>
                    <td><?php echo ($value14->branch_id);?></td><!--สาขา-->
                    <td><?php echo number_format($value14->grandtotal,2);?></td><!--ยอดสุทธิ-->
                    <td></td>
                </tr>


                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>

                    <td></td>
                    <td><?php echo "111200";?></td>
                    <td><?php echo "เงินสด";?></td>
                    <td></td>
                    <td></td>
                    <td><?php echo number_format($value14->grandtotal,2);?></td><!--ยอดสุทธิ-->
                </tr>

                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>

                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><b><?php echo number_format($value14->grandtotal,2);?></b></td>
                    <td><b><?php echo number_format($value14->grandtotal,2);?></b></td>
                </tr>

            <?php } ?>
          <?php } ?>


          <?php if($datacash[0]->grandtotal1 > 0){ ?> <!--เงินนำฝากธนาคารที่ 2-->

            <?php foreach ($datacash as $key15 => $value15) { ?>

                <tr>
                    <td>
                      <?php if($value15->status_ap2 == 0 OR  $value15->status_ap2 == 2){ ?>
                        <!-- <label class="con"> -->
                        <input type="checkbox" name="check_list[]" value="{{ $value15->id }},{{ 15 }}">
                            <!-- <span class="checkmark"></span>
                        </label> -->
                        <br>
                        <br>
                        <button type="button"  class="btn btn-danger"
                        class="btn btn-primary" data-toggle="modal"
                        data-target="#exampleModal"
                        onclick="reply({{$value15->branch_id}},{{$value15->id}},{{ 15 }})" >แก้ไข
                        </button>
                      <?php }else{ ?>
                         <i class="fa fa-check" style="color:green;font-size:20px;"></i>
                      <?php } ?>
                    </td>

                    <td><!--ปี/เดือน/วัน-->
                    <?php
                       $time = explode(" ",trim(($value15->time)));
                       echo $time[0];
                    ?>
                    </td>
                    <td><?php echo ($value15->bill_no2);?></td><!--เลขที่-->
                    <td>
                      <a href="http://103.13.231.24/fsctaccounting/public/checkcash/<?php echo $value14->image1?>"   target="_blank">
                        <<-หลักฐานสลิป->>
                      </a>
                    </td>

                    <td>
                    <?php
                        $modelbranch = Maincenter::databranchbycode($value15->branch_id);

                        if($modelbranch){
                            echo "<b>รับเงินฝากจากสาขา </b> ";
                            echo $modelbranch[0]->name_branch;
                            echo "<b>( รายรับประกัน )<b>";
                        }
                    ?>
                    </td>
                    <td><!--เลขที่บัญชี-->
                    <?php
                        $modelbranch_bank2 = Maincenter::databranch_bank2($value15->branch_id);

                        if($modelbranch_bank2){
                            echo $modelbranch_bank2[0]->accounttypeno;
                        }
                    ?>
                    </td>
                    <td><!--ชื่อเลขที่บัญชี-->
                    <?php
                        if($modelbranch_bank2){
                            echo $modelbranch_bank2[0]->accounttypefull;
                        }
                    ?>
                    </td>
                    <td><?php echo ($value15->branch_id);?></td><!--สาขา-->
                    <td><?php echo number_format($value15->grandtotal1,2);?></td><!--ยอดสุทธิ-->
                    <td></td>
                </tr>


                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>

                    <td></td>
                    <td><?php echo "111200";?></td>
                    <td><?php echo "เงินสด";?></td>
                    <td></td>
                    <td></td>
                    <td><?php echo number_format($value15->grandtotal1,2);?></td><!--ยอดสุทธิ-->
                </tr>

                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>

                    <td><b><?php echo number_format($value15->grandtotal1,2);?></b></td>
                    <td><b><?php echo number_format($value15->grandtotal1,2);?></b></td>
                </tr>

            <?php } ?>
          <?php } ?>


          <?php if($datacash[0]->grandtotal2 > 0){ ?> <!--เงินนำฝากธนาคารที่ 3-->

            <?php foreach ($datacash as $key16 => $value16) { ?>

                <tr>
                    <td>
                      <?php if($value16->status_ap3 == 0 OR  $value16->status_ap3 == 2){ ?>
                        <!-- <label class="con"> -->
                        <input type="checkbox" name="check_list[]" value="{{ $value16->id }},{{ 16 }}">
                            <!-- <span class="checkmark"></span>
                        </label> -->
                        <br>
                        <br>
                        <button type="button"  class="btn btn-danger"
                        class="btn btn-primary" data-toggle="modal"
                        data-target="#exampleModal"
                        onclick="reply({{$value16->branch_id}},{{$value16->id}},{{ 16 }})" >แก้ไข
                        </button>
                      <?php }else{ ?>
                         <i class="fa fa-check" style="color:green;font-size:20px;"></i>
                      <?php } ?>
                    </td>

                    <td><!--ปี/เดือน/วัน-->
                    <?php
                       $time = explode(" ",trim(($value16->time)));
                       echo $time[0];
                    ?>
                    </td>
                    <td><?php echo ($value16->bill_no3);?></td><!--เลขที่-->
                    <td>
                      <a href="http://103.13.231.24/fsctaccounting/public/checkcash/<?php echo $value16->image2?>"   target="_blank">
                        <<-หลักฐานสลิป->>
                      </a>
                    </td>

                    <td>
                    <?php
                        $modelbranch = Maincenter::databranchbycode($value16->branch_id);

                        if($modelbranch){
                            echo "<b>รับเงินฝากจากสาขา </b> ";
                            echo $modelbranch[0]->name_branch;
                            echo "<b>( ค่าใช้จ่าย )<b>";
                        }
                    ?>
                    </td>
                    <td><!--เลขที่บัญชี-->
                    <?php
                        $modelbranch_bank3 = Maincenter::databranch_bank3($value16->branch_id);

                        if($modelbranch_bank3){
                            echo $modelbranch_bank3[0]->accounttypeno;
                        }
                    ?>
                    </td>
                    <td><!--ชื่อเลขที่บัญชี-->
                    <?php
                        if($modelbranch_bank3){
                            echo $modelbranch_bank3[0]->accounttypefull;
                        }
                    ?>
                    </td>
                    <td><?php echo ($value16->branch_id);?></td><!--สาขา-->
                    <td><?php echo number_format($value16->grandtotal2,2);?></td><!--ยอดสุทธิ-->
                    <td></td>
                </tr>


                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>

                    <td></td>
                    <td><?php echo "111200";?></td>
                    <td><?php echo "เงินสด";?></td>
                    <td></td>
                    <td></td>
                    <td><?php echo number_format($value16->grandtotal2,2);?></td><!--ยอดสุทธิ-->
                </tr>

                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>

                    <td></td>
                    <td><b><?php echo number_format($value16->grandtotal2,2);?></b></td>
                    <td><b><?php echo number_format($value16->grandtotal2,2);?></b></td>
                </tr>

            <?php } ?>
          <?php } ?>


          <?php if($datacash[0]->grandtotal3 > 0){ ?> <!--เงินนำฝากธนาคารที่ 4-->

            <?php foreach ($datacash as $key17 => $value17) { ?>

                <tr>
                    <td>
                      <?php if($value16->status_ap4 == 0 OR  $value16->status_ap4 == 2){ ?>
                        <!-- <label class="con"> -->
                        <input type="checkbox" name="check_list[]" value="{{ $value17->id }},{{ 17 }}">
                            <!-- <span class="checkmark"></span>
                        </label> -->
                        <br>
                        <br>
                        <button type="button"  class="btn btn-danger"
                        class="btn btn-primary" data-toggle="modal"
                        data-target="#exampleModal"
                        onclick="reply({{$value17->branch_id}},{{$value17->id}},{{ 17 }})" >แก้ไข
                        </button>
                      <?php }else{ ?>
                          <i class="fa fa-check" style="color:green;font-size:20px;"></i>
                      <?php } ?>
                    </td>

                    <td><!--ปี/เดือน/วัน-->
                    <?php
                       $time = explode(" ",trim(($value17->time)));
                       echo $time[0];
                    ?>
                    </td>
                    <td><?php echo ($value17->bill_no4);?></td><!--เลขที่-->
                    <td>
                      <a href="http://103.13.231.24/fsctaccounting/public/checkcash/<?php echo $value14->image3?>"   target="_blank">
                        <<-หลักฐานสลิป->>
                      </a>w
                    </td>

                    <td>
                    <?php
                        $modelbranch = Maincenter::databranchbycode($value17->branch_id);

                        if($modelbranch){
                            echo "<b>รับเงินฝากจากสาขา </b> ";
                            echo $modelbranch[0]->name_branch;
                            echo "<b>( คืนประกัน )<b>";
                        }
                    ?>
                    </td>
                    <td><!--เลขที่บัญชี-->
                    <?php
                        $modelbranch_bank4 = Maincenter::databranch_bank4($value17->branch_id);

                        if($modelbranch_bank4){
                            echo $modelbranch_bank4[0]->accounttypeno;
                        }
                    ?>
                    </td>
                    <td><!--ชื่อเลขที่บัญชี-->
                    <?php
                        if($modelbranch_bank4){
                            echo $modelbranch_bank4[0]->accounttypefull;
                        }
                    ?>
                    </td>
                    <td><?php echo ($value17->branch_id);?></td><!--สาขา-->
                    <td><?php echo number_format($value17->grandtotal3,2);?></td><!--ยอดสุทธิ-->
                    <td></td>
                </tr>


                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>

                    <td></td>
                    <td><?php echo "111200";?></td>
                    <td><?php echo "เงินสด";?></td>
                    <td></td>
                    <td></td>
                    <td><?php echo number_format($value17->grandtotal3,2);?></td><!--ยอดสุทธิ-->
                </tr>

                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>

                    <td><b><?php echo number_format($value17->grandtotal3,2);?></b></td>
                    <td><b><?php echo number_format($value17->grandtotal3,2);?></b></td>
                </tr>

            <?php } ?>
          <?php } ?>
          <?php } ?>


          <?php foreach ($datapo as $key18 => $value18) { ?> <!--การโอนระหว่างสาขา PO-->

              <tr>
                  <td>
                    <?php if($value18->status_ap == 0 OR  $value18->status_ap == 2){ ?>
                      <!-- <label class="con"> -->
                      <input type="checkbox" name="check_list[]" value="{{ $value18->id }},{{ 18 }}">
                          <!-- <span class="checkmark"></span>
                      </label> -->
                      <br>
                      <br>
                      <button type="button"  class="btn btn-danger"
                      class="btn btn-primary" data-toggle="modal"
                      data-target="#exampleModal"
                      onclick="reply({{$value18->branch_id}},{{$value18->id}},{{ 18 }})" >แก้ไข
                      </button>

                    <?php }else{ ?>
                       <i class="fa fa-check" style="color:green;font-size:20px;"></i>
                    <?php } ?>
                  </td>

                  <td><!--ปี/เดือน/วัน-->
                   <?php
                     $time = explode(" ",trim(($value18->po_date_ap)));
                     echo $time[0];
                   ?>
                  </td>
                  <td><?php echo ($value18->po_number);?></td><!--เลขที่-->
                  <td><?php //echo "PV".($value18->number_taxinvoice);?>
                    โอนเงินค่าใช้จ่ายของ <?php echo ($value18->po_number);?>
                  </td>

                  <td><!--รายละเอียด-->
                    <?php
                        $modelbranch_po = Maincenter::databranchbycode($value18->branch_id);

                        if ($value18->statusbank == "0") {
                           echo "เงินฝากออมทรัพย์";
                        }elseif ($value18->statusbank == "1") {
                           echo "เงินฝากธนาคารออมทรัพย์ (";
                             if($modelbranch_po){
                               echo $modelbranch_po[0]->name_branch;
                             }
                           echo ")";
                        }
                    ?>
                  </td>
                  <td><!--เลขที่บัญชี-->
                    <?php
                       $modelbank_po = Maincenter::databranch_bank3($value18->branch_id);

                       if ($value18->statusbank == "0") {
                           if($modelbank_po){
                             echo $modelbank_po[0]->accounttypeno;
                           }
                       }elseif ($value18->statusbank == "1") {
                           if($modelbank_po){
                             echo $modelbank_po[0]->accounttypeno;
                           }

                       }
                    ?>
                  </td>
                  <td><!--ชื่อเลขที่บัญชี-->
                    <?php
                       if ($value18->statusbank == "0") {
                           if($modelbank_po){
                             echo $modelbank_po[0]->accounttypefull;
                           }
                       }elseif ($value18->statusbank == "1") {
                           if($modelbank_po){
                             echo $modelbank_po[0]->accounttypefull;
                           }

                       }
                    ?>
                  </td>
                  <td><?php echo ($value18->branch_id);?></td><!--สาขา-->
                  <td><!--ยอดสุทธิ-->
                    <?php echo number_format($value18->totolsumreal,2);?></td>
                  <td></td>
              </tr>

              <tr>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>

                  <td><!--เลขที่บัญชี-->
                    <?php
                       if ($value18->statusbank == "0") {
                             echo "221100";
                       }elseif ($value18->statusbank == "1") {
                             echo "112000";
                       }else {
                             echo $value18->banktranfer;
                       }
                    ?>
                  </td>
                  <td><!--ชื่อเลขที่บัญชี-->
                    <?php
                       if ($value18->statusbank == 0) {
                            echo "เงินกู้ยืมกรรมการ";
                       }elseif ($value18->statusbank == 1) {
                           if($modelbank_po){
                             echo "เงินฝากออมทรัพย์ KBANK 587-2-21903-1 (เชียงใหม่)";
                           }
                       }else {
                              $accCodeBank = $value18->banktranfer;
                              $db = Connectdb::Databaseall();
                              $sqaccshow = 'SELECT '.$db['fsctaccount'].'.accounttype.*
                                     FROM '.$db['fsctaccount'].'.accounttype
                                     WHERE  '.$db['fsctaccount'].'.accounttype.accounttypeno = "'.$accCodeBank.'" ';

                            $dataacccode = DB::connection('mysql')->select($sqaccshow);
                            echo $dataacccode[0]->accounttypefull;

                       }
                    ?>
                  </td>
                  <td></td>
                  <td></td>
                  <td><?php echo number_format($value18->totolsumreal,2);?></td><!--ยอดก่อน vat-->
              </tr>

              <tr>
                  <td></td>
                  <td></td>
                  <td></td>

                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td><b><?php echo number_format($value18->totolsumreal,2);?></b></td>
                  <td><b><?php echo number_format($value18->totolsumreal,2);?></b></td>
              </tr>

          <?php } ?>


          <?php foreach ($datataxti as $key19 => $value19) { ?> <!--การโอนระหว่างสาขา TI-->
              <?php if($value19->status_return==2 OR
                 $value19->status_return==3 OR
                 $value19->status_return==4){?>
              <tr>
                  <td>
                    <?php if($value19->status_ap == 0 OR  $value19->status_ap == 2){ ?>
                      <!-- <label class="con"> -->
                      <input type="checkbox" name="check_list[]" value="{{ $value19->id }},{{ 19 }}">
                          <!-- <span class="checkmark"></span>
                      </label> -->
                      <br>
                      <br>
						          <button type="button"  class="btn btn-danger"  class="btn btn-primary"
                      data-toggle="modal" data-target="#exampleModal"
                      onclick="reply({{$value19->branch_id}},{{$value19->id}},{{ 19 }})" >แก้ไข</button>
                    <?php }else{ ?>
                       <i class="fa fa-check" style="color:green;font-size:20px;"></i>
                    <?php } ?>
                  </td>

                  <td><!--ปี/เดือน/วัน-->
                   <?php
                     $time = explode(" ",trim(($value19->time)));
                     echo $time[0];
                   ?>
                  </td>
                  <td>
                    <?php  $bill_rent = $value19->bill_rent;
                            $db = Connectdb::Databaseall();
                            $sqlrent = 'SELECT '.$db['fsctmain'].'.bill_rent.bill_rent
                                   FROM '.$db['fsctmain'].'.bill_rent
                                   WHERE  '.$db['fsctmain'].'.bill_rent.id = "'.$bill_rent.'" ';

                          $databillrent= DB::connection('mysql')->select($sqlrent);
                          echo str_replace('RR','CB',$databillrent[0]->bill_rent);
                    ?>

                  </td><!--เลขที่-->

                  <td><?php //echo "PV".($value19->number_taxinvoice);?>
                      โอนเงินคืนประกันของ <?php echo $value19->number_taxinvoice;?>
                  </td>

                  <td><!--รายละเอียด-->
                    <?php
                        $modelbranch_po = Maincenter::databranchbycode($value19->branch_id);

                        if ($value19->statusbank == "0") {
                           echo "เงินฝากออมทรัพย์";
                        }elseif ($value19->statusbank == "1") {
                           echo "เงินฝากธนาคารออมทรัพย์ (";
                             if($modelbranch_po){
                               echo $modelbranch_po[0]->name_branch;
                             }
                           echo ")";
                        }
                    ?>
                  </td>
                  <td><!--เลขที่บัญชี-->
                    <?php
                       $modelbank_po = Maincenter::databranch_bank4($value19->branch_id); //ธนาคารเล่ม คืนประกัน

                       if ($value19->statusbank == "0") {
                           if($modelbank_po){
                             echo $modelbank_po[0]->accounttypeno;
                           }
                       }elseif ($value19->statusbank == "1") {
                           if($modelbank_po){
                             echo $modelbank_po[0]->accounttypeno;
                           }

                       }
                    ?>
                  </td>
                  <td><!--ชื่อเลขที่บัญชี-->
                    <?php
                       if ($value19->statusbank == "0") {
                           if($modelbank_po){
                             echo $modelbank_po[0]->accounttypefull;
                           }
                       }elseif ($value19->statusbank == "1") {
                           if($modelbank_po){
                             echo $modelbank_po[0]->accounttypefull;
                           }

                       }
                    ?>
                  </td>
                  <td><?php echo ($value19->branch_id);?></td><!--สาขา-->
                  <td><!--ยอดสุทธิ-->
                    <?php echo number_format($value19->grandtotal,2);?></td>
                  <td></td>
              </tr>

              <tr>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>

                  <td><!--เลขที่บัญชี-->
                    <?php
                       // if ($value19->statusbank == "0") {
                       //       echo "221100";
                       // }elseif ($value19->statusbank == "1") {
                       //       echo "112000";
                       // }
                        $accSet = $value19->banktranfer;
                        $db = Connectdb::Databaseall();
                        $sqaccshow = 'SELECT '.$db['fsctaccount'].'.accounttype.*
                               FROM '.$db['fsctaccount'].'.accounttype
                               WHERE  '.$db['fsctaccount'].'.accounttype.accounttypeno = "'.$accSet.'" ';

                      $dataacccode = DB::connection('mysql')->select($sqaccshow);
                      if(!empty($dataacccode)){
                            echo  $value19->banktranfer;
                      }else{
                            echo "221100";
                      }



                    ?>
                  </td>
                  <td><!--ชื่อเลขที่บัญชี-->
                    <?php
                       // if ($value19->statusbank == "0") {
                       //      echo "เงินกู้ยืมกรรมการ";
                       // }elseif ($value19->statusbank == "1") {
                       //     if($modelbank_po){
                       //       echo "เงินฝากธนาคารออมทรัพย์ KBANK 587-2-21903-1 (เชียงใหม่)";
                       //     }
                       // }
                       if(!empty($dataacccode)){
                             echo   $dataacccode[0]->accounttypefull;
                       }else{
                             echo "เงินกู้ยืมกรรมการ";
                       }



                    ?>
                  </td>
                  <td></td>
                  <td></td>
                  <td><?php echo number_format($value19->grandtotal,2);?></td>
              </tr>

              <tr>
                  <td></td>
                  <td></td>
                  <td></td>

                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td><b><?php echo number_format($value19->grandtotal,2);?></b></td>
                  <td><b><?php echo number_format($value19->grandtotal,2);?></b></td>
              </tr>
            <?php } ?>
          <?php } ?>


          <?php $totaldebit = 0; $totalcredit = 0;
          foreach ($datajournal_general as $key20 => $value20) { ?> <!--การโอนระหว่างสาขา CI (สาขาโอนคืน บจก)-->

              <tr>
                  <td>
                    <input type="checkbox" name="check_list[]" value="{{ $value20->id }},{{ 20 }}">
                        <!-- <span class="checkmark"></span>
                    </label> -->
                    <br>
                    <br>
                  </td>
                  <td>
                      <?php echo $value20->datebill;?>
                  </td>
                  <td>
                      <?php echo $value20->number_bill_journal;?>
                  </td>
                  <td>

                  </td>
                  <td>
                      <?php
                             $journal5_id = $value20->id;
                             $sqljournalgeneral_detail = 'SELECT '.$db['fsctaccount'].'.journalgeneral_detail.*
                                                  FROM '.$db['fsctaccount'].'.journalgeneral_detail
                                                   WHERE '.$db['fsctaccount'].'.journalgeneral_detail.id_journalgeneral_head = "'.$journal5_id.'"
                                                   AND  ('.$db['fsctaccount'].'.journalgeneral_detail.debit != "0.00"
                                                   OR '.$db['fsctaccount'].'.journalgeneral_detail.debit IS NULL) ';

                              $datajournalgeneral_detail = DB::connection('mysql')->select($sqljournalgeneral_detail);

                              foreach ($datajournalgeneral_detail as $k => $v) {
                                  echo $v->list;
                                  echo "<br>";
                              }
                      ?>
                  </td>
                  <td>
                      <?php
                              foreach ($datajournalgeneral_detail as $k => $v) {
                                  $ac_id = $v->accounttype;
                                  $sqlaccounttype = 'SELECT '.$db['fsctaccount'].'.accounttype.*
                                                       FROM '.$db['fsctaccount'].'.accounttype
                                                        WHERE '.$db['fsctaccount'].'.accounttype.id = "'.$ac_id.'" ';

                                   $dataaccounttype = DB::connection('mysql')->select($sqlaccounttype);
                                   echo $dataaccounttype[0]->accounttypeno;
                                   echo "<br>";

                              }
                      ?>
                  </td>
                  <td>
                      <?php
                              foreach ($datajournalgeneral_detail as $k => $v) {
                                  $ac_id = $v->accounttype;
                                  $sqlaccounttype = 'SELECT '.$db['fsctaccount'].'.accounttype.*
                                                       FROM '.$db['fsctaccount'].'.accounttype
                                                        WHERE '.$db['fsctaccount'].'.accounttype.id = "'.$ac_id.'" ';

                                   $dataaccounttype = DB::connection('mysql')->select($sqlaccounttype);
                                   echo $dataaccounttype[0]->accounttypefull;
                                   echo "<br>";

                              }
                      ?>
                  </td>
                  <td>
                      <?php echo $value20->code_branch;?>
                  </td>
                  <td>
                      <?php
                             $journal5_id = $value20->id;
                             $sqljournalgeneral_detail = 'SELECT '.$db['fsctaccount'].'.journalgeneral_detail.*
                                                  FROM '.$db['fsctaccount'].'.journalgeneral_detail
                                                   WHERE '.$db['fsctaccount'].'.journalgeneral_detail.id_journalgeneral_head = "'.$journal5_id.'"
                                                   AND  ('.$db['fsctaccount'].'.journalgeneral_detail.debit != "0.00"
                                                   OR '.$db['fsctaccount'].'.journalgeneral_detail.debit IS NULL) ';

                              $datajournalgeneral_detail = DB::connection('mysql')->select($sqljournalgeneral_detail);

                              foreach ($datajournalgeneral_detail as $k => $v) {
                                  echo $v->debit;
                                  $totaldebit = $totaldebit +  $v->debit;
                                  echo "<br>";
                              }
                      ?>
                  </td>
                  <td>
                          0.00
                  </td>
              </tr>
              <tr>
                  <td>

                  </td>
                  <td>

                  </td>
                  <td>

                  </td>
                  <td>

                  </td>
                  <td>
                      <?php
                             $journal5_id = $value20->id;
                             $sqljournalgeneral_detail = 'SELECT '.$db['fsctaccount'].'.journalgeneral_detail.*
                                                  FROM '.$db['fsctaccount'].'.journalgeneral_detail
                                                   WHERE '.$db['fsctaccount'].'.journalgeneral_detail.id_journalgeneral_head = "'.$journal5_id.'"
                                                   AND  ('.$db['fsctaccount'].'.journalgeneral_detail.credit != "0.00"
                                                   OR '.$db['fsctaccount'].'.journalgeneral_detail.credit IS NOT NULL) ';

                              $datajournalgeneral_detail = DB::connection('mysql')->select($sqljournalgeneral_detail);

                              foreach ($datajournalgeneral_detail as $k => $v) {
                                  echo $v->list;
                                  echo "<br>";
                              }
                      ?>
                  </td>
                  <td>
                      <?php
                              foreach ($datajournalgeneral_detail as $k => $v) {
                                  $ac_id = $v->accounttype;
                                  $sqlaccounttype = 'SELECT '.$db['fsctaccount'].'.accounttype.*
                                                       FROM '.$db['fsctaccount'].'.accounttype
                                                        WHERE '.$db['fsctaccount'].'.accounttype.id = "'.$ac_id.'" ';

                                   $dataaccounttype = DB::connection('mysql')->select($sqlaccounttype);
                                   echo $dataaccounttype[0]->accounttypeno;
                                   echo "<br>";

                              }
                      ?>
                  </td>
                  <td>
                      <?php
                              foreach ($datajournalgeneral_detail as $k => $v) {
                                  $ac_id = $v->accounttype;
                                  $sqlaccounttype = 'SELECT '.$db['fsctaccount'].'.accounttype.*
                                                       FROM '.$db['fsctaccount'].'.accounttype
                                                        WHERE '.$db['fsctaccount'].'.accounttype.id = "'.$ac_id.'" ';

                                   $dataaccounttype = DB::connection('mysql')->select($sqlaccounttype);
                                   echo $dataaccounttype[0]->accounttypefull;
                                   echo "<br>";

                              }
                      ?>
                  </td>
                  <td>

                  </td>
                  <td>
                          0.00
                  </td>
                  <td>
                    <?php
                           $journal5_id = $value20->id;
                           $sqljournalgeneral_detail = 'SELECT '.$db['fsctaccount'].'.journalgeneral_detail.*
                                                FROM '.$db['fsctaccount'].'.journalgeneral_detail
                                                 WHERE '.$db['fsctaccount'].'.journalgeneral_detail.id_journalgeneral_head = "'.$journal5_id.'"
                                                 AND  ('.$db['fsctaccount'].'.journalgeneral_detail.credit != "0.00"
                                                 OR '.$db['fsctaccount'].'.journalgeneral_detail.credit IS NOT NULL) ';

                            $datajournalgeneral_detail = DB::connection('mysql')->select($sqljournalgeneral_detail);

                            foreach ($datajournalgeneral_detail as $k => $v) {
                                echo $v->credit;
                                $totalcredit = $totalcredit +  $v->credit;
                                echo "<br>";
                            }
                    ?>
                  </td>
              </tr>

              <tr>
                  <td>

                  </td>
                  <td>

                  </td>
                  <td>

                  </td>
                  <td>

                  </td>
                  <td>

                  </td>
                  <td>

                  </td>
                  <td>

                  </td>
                  <td>

                  </td>
                  <td>
                      <b><?php echo number_format($totaldebit,2) ; ?></b>
                  </td>
                  <td>
                      <b><?php echo number_format($totalcredit,2);?></b>
                  </td>
              </tr>

          <?php } ?>





                          </tbody>
                      </table>

                      </div>
                      <br>
                      <br>
                      <div style="padding-bottom:50px;">
                          <center><button type="submit" class="btn btn-success" value="submt" id="btnSubmit">Okay ยืนยันการตรวจ</button></center>
                      </div>
                      <?php } ?>

                      {!! Form::close() !!}


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
<script type="text/javascript">
$(document).ready(function() {
  $("#btnSubmit").click(function(){
      $('input[name=""]')
  });
});
</script>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">ข้อความแก้ไข</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">สาขา:</label>
            <input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}">
            <input type="text" class="form-control" id="recipient-name">
            <input type="hidden" class="form-control" id="typedoc">
            <input type="hidden" class="form-control" id="iddoc">
          </div>
          <div class="form-group">
            <label for="message-text" class="col-form-label">รายละเอียด:</label>
            <textarea class="form-control" id="message-text"></textarea>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="savemsg()">Send message</button>
      </div>
    </div>
  </div>
</div>

@endsection
