<?php
use  App\Api\Connectdb;
use  App\Api\Accountcenter;
use  App\Api\Maincenter;
use  App\Api\Vendorcenter;
use  App\Api\Rent;

  $level_emp = Session::get('level_emp');

?>
@include('headmenu')

<script type="text/javascript" src = 'js/jquery-ui-1.12.1/jquery-ui.js'></script>
{{--<script type="text/javascript" src = 'js/jquery-ui-1.12.1/jquery-ui.min.js'></script>--}}



<link rel="stylesheet" type="text/css" href="css/ui/jquery-ui.css">
{{--<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>--}}

<script type="text/javascript" src = 'js/bootbox.min.js'></script>
<script type="text/javascript" src = 'js/validator.min.js'></script>


<script type="text/javascript" src = 'js/jquery.dataTables.min.js'></script>
<script type="text/javascript" src = 'js/dataTables.bootstrap.min.js'></script>
<link rel="stylesheet" type="text/css" href="css/table/dataTables.bootstrap.min.css">


<link rel="stylesheet" type="text/css" href="bower_components/select2/dist/css/select2.min.css">
<script type="text/javascript" src = 'bower_components/select2/dist/js/select2.full.min.js'></script>

<link rel="stylesheet" href="bower_components/bootstrap-daterangepicker/daterangepicker.css">
<script type="text/javascript" src="bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>

<script type="text/javascript" src = 'js/jquery.mask.js'></script>

<script type="text/javascript" src = 'js/rent/rent.js'></script>


<style>
    .ui-autocomplete-input {
        border: none;
        font-size: 14px;
        width: 225px;
        height: 24px;
        margin-bottom: 5px;
        padding-top: 2px;
        border: 1px solid #DDD !important;
        padding-top: 0px !important;
        z-index: 1511;
        position: relative;
    }
    .ui-menu .ui-menu-item a {
        font-size: 12px;
    }
    .ui-autocomplete {
        position: absolute;
        top: 0;
        left: 0;
        z-index: 1510 !important;
        float: left;
        display: none;
        min-width: 160px;
        width: 160px;
        padding: 4px 0;
        margin: 2px 0 0 0;
        list-style: none;
        background-color: #ffffff;
        border-color: #ccc;
        border-color: rgba(0, 0, 0, 0.2);
        border-style: solid;
        border-width: 1px;
        -webkit-border-radius: 2px;
        -moz-border-radius: 2px;
        border-radius: 2px;
        -webkit-box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
        -moz-box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
        -webkit-background-clip: padding-box;
        -moz-background-clip: padding;
        background-clip: padding-box;
        *border-right-width: 2px;
        *border-bottom-width: 2px;
    }
    .ui-menu-item > a.ui-corner-all {
        display: block;
        padding: 3px 15px;
        clear: both;
        font-weight: normal;
        line-height: 18px;
        color: #555555;
        white-space: nowrap;
        text-decoration: none;
    }
    .ui-state-hover, .ui-state-active {
        color: #ffffff;
        text-decoration: none;
        background-color: #0088cc;
        border-radius: 0px;
        -webkit-border-radius: 0px;
        -moz-border-radius: 0px;
        background-image: none;
    }
</style>



<meta name="csrf-token" content="{{ csrf_token() }}" />
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>




<div class="content-wrapper">
    <!-- Content Header (Page header) -->

    <!-- Main content -->
    <input type="hidden" id="dateset" value="<?php echo date('Y-m-d H:i:s')?>">
    <input type="hidden"  class="form-control"  id="yearset" value="<?php echo date('Y')?>"  />
    <input type="hidden"  class="form-control" id="year_thset" value="<?php echo date('Y',strtotime("+543 year"))?>"  />
    <input type="hidden"  class="form-control" id="dateshowset" value="<?php echo date('d-m-Y',strtotime("+543 year"))?>"  disabled/>
    <input type="hidden" id="statuscontinue" value="0">
    <section class="content">
        <div class="box box-success">
            <div class="breadcrumbs" id="breadcrumbs">
                <ul class="breadcrumb">
                    <li>
                        <i class="ace-icon fa fa-home home-icon"></i>
                        <a href="#">งานเช่าสินค้า</a>
                    </li>
                    <li class="active">เช่าสินค้า</li>
                </ul><!-- /.breadcrumb -->
                <!-- /section:basics/content.searchbox -->
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-1">

                    </div>
                    <div class="col-md-2">
                      <center>
                        <img src="images/global/qt1.png">
                        <br>
                        <br>
                        <font color="#000000">
                        ใบ quotation
                        <br>
                        อนุมัติเรียบร้อยแล้ว
                      </font>
                      </center>
                    </div>
                    <div class="col-md-2">
                      <center>
                        <img src="images/global/qt2.png">
                        <br>
                        <br>
                        <font color="#0000e6">
                        ลงเช่าเรียบร้อยแล้ว
                        <br>
                        รอขึ้นของ
                        </font>
                      </center>
                    </div>
                    <div class="col-md-2">
                      <center>
                        <img src="images/global/rent.png">
                        <br>
                        <br>
                        <font color="#cccc00">
                        ลงเช่าเรียบร้อยแล้ว
                        <br>

                        </font>
                      </center>
                    </div>
                    <div class="col-md-2">
                      <center>
                        <img src="images/global/checked.png">
                        <br>
                        <br>
                        <font color="#009900">
                         ปิดบิลเรียบร้อยแล้ว
                        <br>

                        </font>
                      </center>
                    </div>
                    <div class="col-md-2">
                      <center>
                        <img src="images/global/userdelete.png">
                        <br>
                        <br>
                        <font color="#ff3300">
                        หนี้สูญ
                        </font>
                      </center>
                    </div>
                    <div class="col-md-1">

                    </div>
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-primary">
                            <div class="breadcrumbs" id="breadcrumbs">
                                <ul class="breadcrumb">
                                    <li>
                                        ข้อมูลเช่าสินค้า/สาขา  <?php
                                        $brcode = Session::get('brcode');
                                        $namebrcode = Maincenter::databranchbycode($brcode);
                                        print_r($namebrcode[0]->name_branch);
                                        echo  " (".$brcode.")";
                                        ?>
                                    </li>
                                </ul><!-- /.breadcrumb -->
                                <!-- /section:basics/content.searchbox -->
                            </div>
                            <div class="box-body">
                              <div class="row" style="overflow-x:auto;">


                              <form action="searchrent" method="post">
                                <!-- <div class="row">
                                  <div class="col-md-1">
                                  </div>
                                  <div class="col-md-10" align="center">
                                        ค้นหาจาก
                                        วันที่
                                        <input type="radio" name="selectsc" value="1">
                                        ชื่อลูกค้า
                                        <input type="radio" name="selectsc" value="2">
                                  </div>
                                  <div class="col-md-1">
                                  </div>
                                </div>
                                <div class="row">
                                  <div class="col-md-12">
                                        <br>
                                  </div>
                                </div> -->
                                <div class="row">
                                  <div class="col-md-1">
                                  </div>
                                  <!-- <div class="col-md-10" align="center">
                                    ชื่อ ลูกค้า
                                        <input type="text"  id="cusname" onkeyup="autocompletecusdatasc()">
                                        <input type="text"  name="idcustomer" id="idcustomer">
                                  </div> -->
                                  <div class="col-md-1">
                                  </div>
                                </div>
                                <div class="row">
                                  <div class="col-md-12">
                                        <br>
                                  </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-1">

                                    </div>
                                    <div class="col-md-1">
                                        <center>ตั้งแต่วันที่</center>
                                    </div>
                                    <div class="col-md-2">
                                        <input type="text" name="daterentstart" id="daterentstart" class="form-control" required   value="<?php if(isset($query)){ echo $datestart;}?>" >
                                    </div>
                                    <div class="col-md-1">
                                        <center>ถึงวันที่</center>
                                    </div>
                                    <div class="col-md-2">
                                        <input type="text" name="daterentend" id="daterentend"  class="form-control" required  value="<?php if(isset($query)){ echo $dateend;}?>">
                                    </div>
                                    <div class="col-md-2">
                                        <center>สถานะ</center>
                                    </div>
                                    <div class="col-md-2">
                                      <?php $arrStatus = [1=>'ใบ quotation อนุมัติเรียบร้อยแล้ว',
                                                          2=>'ลงเช่า',
                                                          3=>'กำลังเช่า',
                                                          4=>'ลงคืนเรียบร้อย',
                                                          5=>'หนี้สูญ',
                                                          6=>'ลงคืนเรียบร้อย(หนี้สูญ)'
                                                         ];


                                      ?>
                                        <select name="statusrent"  id="statusrent" class="form-control">
                                            <option value="">สถานะใบ การเช่า</option>
                                            <?php foreach ($arrStatus as $k => $vs ) {?>
                                                <option value="<?php echo $k;?>" <?php if(isset($query) && $statusrent==$k){ echo "selected" ;}?> > <?php echo $vs;?></option>
                                            <?php }?>
                                        </select>
                                    </div>
                                    <div class="col-md-1">
                                        <input type="submit" value="ค้นหา" class="btn btn-primary">
                                    </div>

                                </div>
                              </form>



                                <?php
                                 $datemonth = date('Y-m-d');
                                 $timeremove = strtotime('-45 day',strtotime($datemonth));
                                 $timeremove = date('Y-m-d 23:59:59',$timeremove);



                                 $db = Connectdb::Databaseall();

                              if(isset($query)){
                                $sqlrentshow = 'SELECT '.$db['fsctmain'].'.bill_rent.*
                                               FROM '.$db['fsctmain'].'.bill_rent' ;

                                         if($level_emp == '1' || $level_emp== '2'){

                                            if($statusrent==4 || $statusrent==6){
                                              $sqlrentshow .=' WHERE '.$db['fsctmain'].'.bill_rent.status = "'.$statusrent.'"
                                               AND '.$db['fsctmain'].'.bill_rent.enddate BETWEEN "'.$datestartset.'" AND "'.$dateendset.'"  ';
                                            }else{
                                              $sqlrentshow .=' WHERE '.$db['fsctmain'].'.bill_rent.status = "'.$statusrent.'"
                                               AND '.$db['fsctmain'].'.bill_rent.startdate BETWEEN "'.$datestartset.'" AND "'.$dateendset.'"  ';
                                            }


                                         }else{
                                             if($statusrent==4 || $statusrent==6){
                                               $sqlrentshow .=' WHERE '.$db['fsctmain'].'.bill_rent.status  = "'.$statusrent.'"
                                               AND '.$db['fsctmain'].'.bill_rent.branch_id = "'.$brcode.'"
                                               AND '.$db['fsctmain'].'.bill_rent.enddate BETWEEN "'.$datestartset.'" AND "'.$dateendset.'" ';

                                             }else{
                                               $sqlrentshow .=' WHERE '.$db['fsctmain'].'.bill_rent.status  = "'.$statusrent.'"
                                               AND '.$db['fsctmain'].'.bill_rent.branch_id = "'.$brcode.'"
                                               AND '.$db['fsctmain'].'.bill_rent.startdate BETWEEN "'.$datestartset.'" AND "'.$dateendset.'" ';
                                             }

                                         }

                                         $sqlrentshow .= '  ORDER BY `bill_rent`.`status` ASC , id DESC';

                                         // echo $sqlrentshow;

                                  $data = DB::connection('mysql')->select($sqlrentshow);

                              }else{
                                $sqlrentshow = 'SELECT '.$db['fsctmain'].'.bill_rent.*
                                               FROM '.$db['fsctmain'].'.bill_rent' ;


                                         if($level_emp == '1' || $level_emp== '2'){
                                             $datemonth = date('Y-m-d');
                                             $timeremove = strtotime('-15 day',strtotime($datemonth));
                                             $timeremove = date('Y-m-d 23:59:59',$timeremove);
                                             $sqlrentshow .=' WHERE '.$db['fsctmain'].'.bill_rent.status IN (1,2,3,5,6)
                                              AND '.$db['fsctmain'].'.bill_rent.startdate >= "'.$timeremove.'" ';

                                         }else{
                                             $datemonth = date('Y-m-d');
                                             $timeremove = strtotime('-15 day',strtotime($datemonth));
                                             $timeremove = date('Y-m-d 23:59:59',$timeremove);
                                               $sqlrentshow .=' WHERE '.$db['fsctmain'].'.bill_rent.status IN (2,3)
                                               AND '.$db['fsctmain'].'.bill_rent.branch_id = "'.$brcode.'"
                                               OR '.$db['fsctmain'].'.bill_rent.id IN (SELECT '.$db['fsctmain'].'.bill_rent.id
                                                      FROM '.$db['fsctmain'].'.bill_rent
                                                      WHERE '.$db['fsctmain'].'.bill_rent.branch_id = "'.$brcode.'"
                                                      AND '.$db['fsctmain'].'.bill_rent.status = "1"
                                                      AND '.$db['fsctmain'].'.bill_rent.startdate >= "'.$timeremove.'")
                                               OR  '.$db['fsctmain'].'.bill_rent.id IN (SELECT '.$db['fsctmain'].'.bill_rent.id
                                                      FROM '.$db['fsctmain'].'.bill_rent
                                                      WHERE '.$db['fsctmain'].'.bill_rent.branch_id = "'.$brcode.'"
                                                      AND '.$db['fsctmain'].'.bill_rent.status IN (3,5,6)
                                                      AND '.$db['fsctmain'].'.bill_rent.enddate >= "'.$timeremove.'")';


                                         }

                                         $sqlrentshow .= '  ORDER BY `bill_rent`.`status` ASC , id DESC';



                                  $data = DB::connection('mysql')->select($sqlrentshow);

                              }

                               // echo $sqlrentshow;



                                $i = 1;
                                ?>
                                <?php
                                $imageset3 = '<img src="images/global/blank-check-box.png">';
                                $imageset4 = '<img src="images/global/blank-check-box.png">';
                                $imageset5 = '<img src="images/global/blank-check-box.png">';
                                ?>

                                <table id="example" class="table table-striped table-bordered">
                                    <thead class="thead-inverse">
                                      <tr>
                                          <td>#</td>
                                          <td>วันที่ขอใบ QT</td>
                                          <td>QT No.</td>
                                          <td>วันที่ออก Bill</td>
                                          <td>วันที่ครบกำหนด</td>
                                          <td>Bill No.</td>
                                          <td>สาขา</td>
                                          <td>รายชื่อลูกค้า</td>
                                          <td>บัตรประชาชนลูกค้า</td>
                                          <td align="center">สถานะ</td>
                                          <td>ยกเลิก</td>
                                          <td>เอกสารเกี่ยวข้อง</td>
                                          <td>ต่อบิล</td>
                                          <td>พิมพ์ใบแจ้งหนี้(เพิ่มเติม)</td>
                                          <td>พิมพ์ใบแจ้งหนี้(ของหาย)</td>
                                          <td>พิมพ์ใบเช็คบิล</td>
                                          <td>พิมพ์ใบคืนของ</td>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <?php $i = 1;
                                      foreach($data as $value){
                                        // $databillrent = Rent::datebillbyqt($value->id);
                                         ?>
                                      <tr>
                                        <td><?php echo $i ;?></td>
                                        <td><?php echo $value->date_req //ขอใบ qt;?></td>
                                        <td><?php echo $value->number_qt ;?></td>
                                        <td><?php
                                            echo $value->startdate;
                                        ?></td>
                                        <td>
                                          <?php echo $value->duedate?>
                                        </td>
                                        <td><?php
                                            echo $value->bill_rent;
                                        ?></td>
                                        <td><?php echo $value->branch_id ;?></td>
                                        <td>
                                          <?php

                                          if($value->customer_id){
                                            $empdata = Maincenter::getdatacustomer($value->customer_id);
                                               if($empdata){
                                                   print_r($empdata[0]->name."     ".$empdata[0]->lastname);
                                               }

                                          }else{
                                            print_r($value->name_customer) ;
                                          }


                                        ?>
                                        </td>
                                        <td>
                                        <?php
                                        if($value->customer_id){
                                          echo $value->customer_id;
                                        }
                                        ?>
                                        </td>
                                        <td>
                                            <table width="100%" border="0">
                                                <tr>

                                                    <td>
                                                      <?php
                                                       if($value->status==1){
                                                          echo $imageset1 = '<a href="#" title="ใบ quotation อนุมัติเรียบร้อยแล้ว" data-toggle="modal" data-target="#myModal" onclick="getdata(1,'.$value->id.')"><img src="images/global/qt1.png"></a>';
                                                        }else{
                                                          echo $imageset1 = '<img src="images/global/blank-check-box.png">'; ;
                                                       } ?>
                                                    </td>
                                                    <td>
                                                      <?php
                                                       if($value->status==2){
                                                          echo  $imageset2 = '<a href="#" title="ลงเช่า" data-toggle="modal" data-target="#myModal" onclick="getdata(2,'.$value->id.')"><img src="images/global/qt2.png"></a>';
                                                        }else{
                                                          echo  $imageset2 = '<img src="images/global/blank-check-box.png">'; ;
                                                       } ?>
                                                    </td>
                                                    <td>
                                                      <?php
                                                       if($value->status==3){
                                                          echo  $imageset3 = '<a href="#" title="กำลังเช่า" data-toggle="modal" data-target="#myModal" onclick="getdata(3,'.$value->id.')"><img src="images/global/rent.png"></a>';
                                                        }else{
                                                          echo  $imageset3 = '<img src="images/global/blank-check-box.png">'; ;
                                                       } ?>
                                                    </td>
                                                    <td>
                                                      <?php
                                                      if($value->status==4 || $value->status==6){
                                                         echo  $imageset4 = '<a href="#" title="ลงคืนเรียบร้อย" data-toggle="modal" data-target="#myModal" onclick="getdata(5,'.$value->id.')"><img src="images/global/checked.png"></a>';
                                                       }else{
                                                         echo  $imageset4 = '<img src="images/global/blank-check-box.png">'; ;
                                                      } ?>
                                                    </td>
                                                    <td>
                                                      <?php
                                                      if($value->status==5 || $value->status==6){
                                                         echo  $imageset5 = '<a href="#" title="หนี้สูญ" data-toggle="modal" data-target="#myModal" onclick="getdata(6,'.$value->id.')"><img src="images/global/userdelete.png"></a>';
                                                       }else{
                                                         echo  $imageset5 = '<img src="images/global/blank-check-box.png">'; ;
                                                      } ?>
                                                    </td>
                                                </tr>
                                            </table>

                                        </td>
                                        <td align="center">
                                          <?php if($value->status <= 2){?>
                                          <a href="#" data-toggle="modal" data-target="#modalcalcel" onclick="getcancelrent(<?php echo $value->id;?>)"><img src="images/global/close.png"></a>
                                          <?php } ?>
                                        </td>
                                        <td align="center">

                                          <a href="#" data-toggle="modal" data-target="#docref" onclick="showdocref(<?php echo $value->id;?>,<?php echo $value->qt_id;?>)"><img src="images/global/record.png"></a>

                                        </td>
                                        <td>
                                          <?php if($value->status==3){?>
                                                <a href="#" data-toggle="modal" data-target="#myModal" onclick="continuebill(<?php echo $value->id;?>)">
                                                  <img src="images/global/continuebill.png">
                                                </a>
                                           <?php } ?>
                                        </td>
                                        <td align="center">
                                          <?php
                                         $db = Connectdb::Databaseall();
                                         //print_r($value->bill_rentid);
                                         if($value->id!=''){
                                           $sqltm = 'SELECT '.$db['fsctaccount'].'.invoice_more.*
                                                           FROM '.$db['fsctaccount'].'.invoice_more
                                                           WHERE '.$db['fsctaccount'].'.invoice_more.bill_rent	= '.$value->id.'
                                                           AND '.$db['fsctaccount'].'.invoice_more.status = "1"';
                                             $datatm = DB::connection('mysql')->select($sqltm);

                                             if($datatm){
                                              $idshow = $datatm[0]->id;
                                               ?>
                                               <a href="<?php echo url("/printinvoicemore/$idshow");?>" target="_blank">
                                                 <img src="images/global/continuebill.png">
                                               </a>
                                             <?php }
                                         }
                                        ?>
                                        </td>
                                        <td align="center">
                                          <?php
                                         $db = Connectdb::Databaseall();
                                         //print_r($value->bill_rentid);
                                         if($value->id!=''){
                                           $sqlil = 'SELECT '.$db['fsctaccount'].'.invoice_loss.*
                                                          FROM '.$db['fsctaccount'].'.invoice_loss
                                                          WHERE '.$db['fsctaccount'].'.invoice_loss.bill_rent	= '.$value->id.'
                                                          AND '.$db['fsctaccount'].'.invoice_loss.status = "1"';
                                            $datail = DB::connection('mysql')->select($sqlil);
                                             if($datail){
                                                 $idshowil = $datail[0]->id;
                                               ?>
                                               <a href="<?php echo url("/printinvoiceloss/$idshowil");?>" target="_blank">
                                                 <img src="images/global/continuebill.png">
                                               </a>
                                             <?php }
                                         }
                                        ?>
                                        </td>
                                        <td align="center">
                                          <?php
                                            if($value->status==4){
                                              if($value->id != ''){ ?>
                                              <a href="<?php echo url("/printcheckbill/$value->id");?>" target="_blank"><img src="images/global/continuebill.png" ></a>
                                          <?php }
                                        } ?>
                                        </td>
                                        <td align="center">
                                            <?php
                                          if($value->status==3 || $value->status==4 || $value->status==5){
                                            if($value->id != ''){?>
                                                <a href="<?php echo url("/printreturnbill/$value->id");?>" target="_blank"><img src="images/global/printer.png" ></a>
                                              <?php } } ?>
                                        </td>
                                      </tr>
                                      <?php $i++ ;} ?>
                                    </tbody>
                                </table>
                              </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
@include('footer')


<!-- Modal -->


<div class="modal fade" id="myModal"  role="dialog" aria-labelledby="Login" aria-hidden="true">
    <div class="modal-dialog"  style="width:1000px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title">ข้อมูลบิลเช่า</h5>
            </div>

            <div class="modal-body">

                <form id="configFormvendors" onsubmit="return getdatesubmit();" data-toggle="validator" method="post" class="form-horizontal">
                    <input value="{{ null }}" type="hidden" id="id" name="id" />
                    {{--<input type="hidden" name="status" id="status" value="0">--}}
                    <input type="hidden" id="statusprocess" value="0">
                    <input type="hidden" id="billrentid" name="billrentid" value="">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="pull-right" id='savebaddept' style="display:none;">
                              <a href="#">
                                <img src="images/global/userdelete.png" onclick="savebaddept()">
                                <font color="red">หนี้สูญ</font>
                              </a>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <br>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="pull-right">รหัสสาขา <?php  $brcode = Session::get('brcode');?>
                                <input type="text"  class="form-control" name="branch_id" id="branch_id" value="<?php echo $brcode ;?>" readonly />

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <br>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="col-xs-6 control-label">วันที่ออกใบเสนอราคา<i><span style="color: red">*</span></i></label>
                                <div class="col-xs-5">
                                    <input type="text"  class="form-control" id="dateshow" value="<?php echo date('d-m-Y',strtotime("+543 year"))?>"  disabled/>
                                    <input type="hidden"  class="form-control" name="date" id="date" value="<?php echo date('Y-m-d H:i:s')?>"  />
                                    <input type="hidden"  class="form-control" name="year" id="year" value="<?php echo date('Y')?>"  />
                                    <input type="hidden"  class="form-control" name="year_th" id="year_th" value="<?php echo date('Y',strtotime("+543 year"))?>"  />
                                </div>
                                <div class="col-xs-4">

                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="col-xs-12">
                                  <center>
                                    <b><span id="id_companyshow"></span></b>
                                    <input type="hidden" id="company_id" name="company_id" >
                                  </center>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="pull-right">
                                <div class="form-group">
                                    <label class="col-xs-6 control-label">QT No.<i><span style="color: red">*</span></i></label>
                                    <div class="col-xs-6">
                                        <input type="text"  class="form-control" name="number_qt" id="number_qt" value=""  readonly/>

                                        <input type="hidden"  class="form-control" name="qt_id" id="qt_id" value=""  readonly/>

                                    </div>
                                    <div class="col-xs-4">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <br>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="col-xs-4 control-label">วันที่ใบเช่า<i><span style="color: red">*</span></i></label>
                                <div class="col-xs-7">
                                    <input type="text" class="form-control" id="datereqrentshow" name="datereqrentshow" value="<?php echo date('d-m-Y');?>" readonly>
                                    <input type="hidden" class="form-control" name="date_req_rent" id="date_req_rent" value="<?php echo date('Y-m-d H:i:s')?>">
                                </div>

                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="col-xs-12">
                                  <center>
                                    <b>ชื่อลูกค้า: <input type="text" name="name_customer" id="name_customer" class="form-control" onkeyup="autocompletecusdata()">
                                    <input type="hidden" name="cusid" id="cusid">
                                  </center>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="pull-right">
                                <div class="form-group">
                                    <label class="col-xs-6 control-label">Bill No.<span style="display:none" id="showcontinue">(เก่า)</span><i><span style="color: red">*</span></i></label>
                                    <div class="col-xs-6">
                                        <input type="text"  class="form-control" name="bill_rent" id="bill_rent"  readonly/>
                                    </div>
                                    <div class="col-xs-4">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <br>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="col-xs-1 control-label">ที่อยู่<i><span style="color: red">*</span></i></label>
                                <div class="col-xs-10">
                                    <span id="address"></span>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <br>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                          <label class="col-xs-2 control-label">เลือก site<i><span style="color: red">*</span></i></label>
                          <div class="col-xs-10">
                            <select class="form-control" id="site_id" name="site_id" required>
                                <option value="0">เลือก site</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="col-xs-4 control-label">ประเภท การเช่า<i><span style="color: red">*</span></i></label>
                                <div class="col-xs-6">
                                    <select class="form-control" id="type_price" name="type_price" onchange="selecttypeprice(this)" required disabled>
                                        <option value="">เลือก การเช่า</option>
                                        <?php
                                        $db = Connectdb::Databaseall();
                                        $data = DB::connection('mysql')->select('SELECT * FROM '.$db['fsctmain'].'.type_price WHERE status = "1" ');
                                        ?>
                                        @foreach ($data as $value)
                                            <option value="{{$value->id}}">{{$value->name}}</option>

                                        @endforeach
                                    </select>
                                </div>

                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="col-xs-4 control-label">ประเภท จ่ายเงิน<i><span style="color: red">*</span></i></label>
                                <div class="col-xs-6">
                                    <select class="form-control" id="type_pay" name="type_pay" onchange="selecttypeprice(this)" required disabled>
                                        <option value="">เลือก จ่ายเงิน</option>
                                        <option value="1">เงินสด</option>
                                        <option value="2">เงินเชื่อ</option>
                                    </select>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <br>
                    </div>
                    <div class="row">
                        <div class="col-md-6">

                        </div>
                        <div class="col-md-6">

                        </div>
                    </div>
                    <div class="row">
                        <br>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="col-xs-5 control-label">ช่วงเวลาเริ่มเช่า<i><span style="color: red">*</span></i></label>
                                <div class="col-xs-7">
                                    <input type="text" id="startdate" name="startdate" class="form-control datepicker" onchange="pickdate(this)" readonly >
                                    <input type="hidden" id="startdatehidden" name="startdatehidden">

                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="col-xs-6 control-label">จำนวนวันที่เช่า<i><span style="color: red">*</span></i></label>
                                <div class="col-xs-6">
                                    <input type="text" name="countrent" id="countrent"  class="form-control" onblur="calcountrent(this)" placeholder="วัน" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="col-xs-5 control-label">ช่วงเวลาสิ้นสุดการเช่า<i><span style="color: red">*</span></i></label>
                                <div class="col-xs-7">
                                    <input type="text" id="duedate" name="duedate" class="form-control" readonly >
                                    <input type="hidden" id="duedatehidden" name="duedatehidden">

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <br>
                    </div>
                    <div class="row" id="hideselecthead">
                       <div class="col-md-12" >
                           <center><h4><font color="red">กรุณาเลือกประเภทการเช่าก่อนทำรายการ</font></h4></center>
                       </div>
                    </div>
                    <div class="row">
                        <br>
                    </div>
                    <div class="row">
                       <div class="col-md-12" >
                         <div class="pull-right">
                           <span id="showreturn"></span>
                         </div>
                       </div>
                    </div>

                    <div class="row">
                        <br>
                    </div>

                    <div class="row showdetail" style="display: none">
                        <div class="col-md-12">
                            <table class="table" id="thdetail">
                                <thead>
                                <tr>
                                    <td align="center">รายการ</td>
                                    <td align="center" >ราคา</td>
                                    <td align="center">จำนวน</td>
                                    <td align="center">รวม</td>
                                    <td align="center">ค่าเช่าจริง</td>
                                    <td align="center">ค่าตัดหาย</td>
                                </tr>
                                </thead>
                                <tbody id="tdbody">
                                    <td align="center">
                                        <input type="hidden" name="material_id[]" id="materialid0" value="0">
                                        <input type="text" name="list[]" id="list0"  onfocus="autocompletedata(0)" class="form-control" disabled>
                                    </td>
                                    <td align="center">
                                        <input type="text" name="price[]" id="price0"   class="form-control" disabled >
                                        <input type="hidden" name="insurance[]" id="insurance0">
                                        <input type="hidden" name="loss[]" id="loss0">
                                    </td>
                                    <td align="center">
                                        <input type="text" name="amount[]" id="amount0" onblur="getamount(this,0)" class="form-control" disabled  placeholder="จำนวน">
                                    </td>
                                    <td align="center">
                                        <input type="hidden" name="totalinsurance[]" id="totalinsurance0">
                                        <input type="hidden" name="totaloss[]" id="totaloss0">
                                        <input type="text" name="total[]"  id="total0" class="form-control" disabled >
                                    </td>
                                    <td align="center">
                                        <input type="text" name="payreal[]"  id="payreal0" class="form-control" disabled >
                                    </td>
                                    <td align="center">
                                        <input type="text" name="payloss[]"  id="payloss0" class="form-control" disabled >
                                    </td>
                                </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <br>
                    </div>
                    <div class="row showdetail3" style="display: none;">
                        <div class="col-md-12">
                          <center>
                            <span id="showappendcall">

                            </span>
                          </center>
                        </div>
                    </div>
                    <div class="row">
                        <br>
                    </div>
                    <div class="row showdetail showdetail2" style="display: none">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="col-xs-5 control-label">ส่วนลด<i><span style="color: red">*</span></i></label>
                                <div class="col-xs-4">
                                    <input type="text" name="discount" id="discount" onblur="calcullatelast()" disabled  class="form-control" placeholder="%" value="0">
                                </div>
                                <label class="col-xs-1 control-label">%</label>

                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="col-xs-5 control-label">หัก ณ ที่จ่าย<i><span style="color: red">*</span></i></label>
                                <div class="col-xs-4">
                                    <input type="text" name="withhold" id="withhold" onblur="calcullatelast()" disabled   class="form-control" placeholder="%" value="0">
                                </div>
                                <label class="col-xs-1 control-label">%</label>

                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="col-xs-5 control-label">ภาษี<i><span style="color: red">*</span></i></label>
                                <div class="col-xs-4">
                                    <input type="text" name="vat" id="vat" onblur="calcullatelast()" disabled  class="form-control" placeholder="%" value="0">
                                </div>
                                <label class="col-xs-1 control-label">%</label>

                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <br>
                    </div>
                    <div class="row showdetail showdetail2" style="display: none">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="col-xs-5 control-label">จำนวน<i><span style="color: red">*</span></i></label>
                                <div class="col-xs-4">
                                    <span id="showdiscount"></span>
                                </div>
                                <label class="col-xs-1 control-label">บาท</label>

                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="col-xs-5 control-label">จำนวน<i><span style="color: red">*</span></i></label>
                                <div class="col-xs-4">
                                    <span id="showwithhold"></span>
                                </div>
                                <label class="col-xs-1 control-label">บาท</label>

                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="col-xs-5 control-label">จำนวน<i><span style="color: red">*</span></i></label>
                                <div class="col-xs-4">
                                    <span id="showvat"></span>
                                </div>
                                <label class="col-xs-1 control-label">บาท</label>

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <br>
                    </div>
                    <div class="row showdetail showdetail2" style="display: none">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="col-xs-5 control-label">หัก ณ ที่จ่าย<br>เพิ่มเติม<i><span style="color: red">*</span></i></label>
                                <div class="col-xs-4">
                                  <input type="radio" name="ckwht2" id="ckwht21" onclick="ckwht(1)" checked value="1">ไม่มี
                                  <input type="radio" name="ckwht2" id="ckwht22" onclick="ckwht(2)" value="2">มี

                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="col-xs-5 control-label">หัก ณ ที่จ่าย<br>เพิ่มเติม<i><span style="color: red">*</span></i></label>
                                <div class="col-xs-4">
                                  <select name="wht2" id="wht2" class="form-control" style="display:none" onchange="calculatenew()">
                                    <option value="0" >ไม่คิดภาษี</option>
                                    <?php
                                    $db = Connectdb::Databaseall();
                                    $datawht = DB::connection('mysql')->select('SELECT * FROM '.$db['fsctaccount'].'.withhold WHERE status ="1"');
                                    ?>
                                    @foreach ($datawht as $valuewth)
                                        <option value="{{$valuewth->withhold}}">{{$valuewth->withhold}}</option>
                                    @endforeach

                                  </select>
                                </div>
                                <label class="col-xs-1 control-label">%</label>

                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="col-xs-5 control-label">จำนวนเงิน หัก ณ <br>ที่จ่ายเพิ่มเติม<i><span style="color: red">*</span></i></label>
                                <div class="col-xs-4">
                                    <span id="resultwht2"></span>
                                </div>
                                <label class="col-xs-1 control-label">บาท</label>

                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <br>
                    </div>
                    <div class="row showdetail showdetail2" style="display: none">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="col-xs-5 control-label">ค่าขนส่ง<i><span style="color: red">*</span></i></label>
                                <div class="col-xs-4">
                                    <input type="text" name="transport" id="transport" disabled onblur="calcullatelast()"   class="form-control" placeholder="บาท" value="0">
                                </div>
                                <label class="col-xs-1 control-label">บาท</label>

                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="col-xs-5 control-label">หัก ณ ที่จ่าย<i><span style="color: red">*</span></i></label>
                                <div class="col-xs-4">
                                    <input type="text" name="withhold_transport" disabled id="withhold_transport" onblur="calcullatelast()"   class="form-control" placeholder="บาท" value="0">
                                </div>
                                  <label class="col-xs-1 control-label">%</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                              <label class="col-xs-5 control-label">จำนวนเงิน หัก ณ ที่จ่าย ขนส่ง<i><span style="color: red">*</span></i></label>
                              <div class="col-xs-4">
                                  <span id="showwithholdtransport"></span>
                              </div>
                              <label class="col-xs-1 control-label">บาท</label>

                          </div>
                        </div>
                    </div>
                    <div class="row">
                        <br>
                    </div>
                    <div class="row showdetail showdetail2" style="display: none">
                        <div class="col-md-4">
                          <div class="form-group">
                              <label class="col-xs-5 control-label">เงินประกัน<i><span style="color: red">*</span></i></label>
                              <div class="col-xs-7">
                                    <?php
                                    $db = Connectdb::Databaseall();
                                    $datainsurance= DB::connection('mysql')->select('SELECT * FROM '.$db['fsctmain'].'.type_insurance WHERE status = "1" ');
                                    ?>
                                    <select class="form-control" id="type_insurance_id" name="type_insurance_id" disabled>
                                      <?php foreach ($datainsurance as $key => $value): ?>

                                          <option value="{{ $value->id}}" <?php if($value->id == 2){ echo "selected=selected";} ?>>{{ $value->type_description }}</option>
                                      <?php endforeach; ?>
                                    </select>
                              </div>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                              <label class="col-xs-5 control-label">เงินประกัน<i><span style="color: red">*</span></i></label>
                              <div class="col-xs-4">
                                  <input type="text" name="insurance_money" id="insurance_money" disabled class="form-control" placeholder="%" value="0">
                              </div>
                              <label class="col-xs-1 control-label">บาท</label>

                          </div>
                        </div>
                        <div class="col-md-4">
                             <div class="form-group">
                              <label class="col-xs-5 control-label">ชำระเงินครั้งแรก<i><span style="color: red">*</span></i></label>
                              <div class="col-xs-4">
                                  <input type="text" name="firstpay" id="firstpay" disabled class="form-control" >
                              </div>
                              <label class="col-xs-1 control-label">บาท</label>

                          </div>
                        </div>
                    </div>
                    <div class="row">
                        <br>
                    </div>

                    <div class="row showdetail showdetail2" style="display: none">
                        <div class="col-md-4">
                          <div class="form-group">
                              <label class="col-xs-5 control-label">ภาษีค่าตัดหาย<i><span style="color: red">*</span></i></label>
                              <div class="col-xs-5">
                                  <input type="text" name="vatloss" id="vatloss"  class="form-control" placeholder="%" value="0" disabled>
                              </div>
                              <label class="col-xs-1 control-label">บาท</label>

                          </div>

                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                              <label class="col-xs-5 control-label"><U>รวมค่าตัดหาย</U><i><span style="color: red">*</span></i></label>
                              <div class="col-xs-5">
                                  <input type="text" name="totalloss" id="totalloss"  class="form-control" placeholder="%" value="0" disabled>
                              </div>
                              <label class="col-xs-1 control-label">บาท</label>

                          </div>

                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                              <label class="col-xs-5 control-label"><U>ยอดรวม</U><i><span style="color: red">*</span></i></label>
                              <div class="col-xs-5">
                                  <input type="text" name="total" id="total"  class="form-control" placeholder="%" value="0" disabled>
                              </div>
                              <label class="col-xs-1 control-label">บาท</label>

                          </div>
                        </div>
                    </div>
                    <div class="row">
                        <br>
                    </div>
                    <div class="row">
                      <div class="row showdetail showdetail2" style="display: none">
                          <!-- <div class="col-md-4">
                            <div class="form-group">
                                <label class="col-xs-5 control-label">การรับเงินจากลูกค้า<i><span style="color: red">*</span></i></label>
                                <div class="col-xs-5">
                                    <select name="gettypemoney" id="gettypemoney" class="form-control" >
                                        <option value="0">เลือกช่องทางการรับเงิน</option>
                                        <option value="1">เงินสด</option>
                                        <option value="2">เงินโอน</option>
                                    </select>

                                </div>
                            </div>
                          </div> -->
                          <div class="col-md-4">


                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                                <label class="col-xs-5 control-label"><U>ส่วนต่าง</U><i><span style="color: red">*</span></i></label>
                                <div class="col-xs-5">
                                    <input type="text" name="diffcus" id="diffcus"  class="form-control" placeholder="%" value="0" disabled>
                                </div>
                                <label class="col-xs-1 control-label">บาท</label>

                            </div>
                          </div>
                      </div>
                    </div>
                    <div class="row">
                        <br>
                    </div>
                    <div class="row">
                        <div class="col-md-4 savetranferup">
                            วันที่ขนของออก
                          <input type="text" name="date_out" class="form-control " id="date_out" value="<?php echo date('Y-m-d');?>" readonly>
                        </div>
                        <div class="col-md-4 savetranferup">
                             พนักงานดูแลการขนออก
                          <!-- <input type="text" name="emp_out" onblur="checkempout()" class="form-control emp_out" readonly id="emp_out"> -->
                          <select name="emp_out" readonly id="emp_out" class="emp_out select2" onchange="checkempout()">
                                      <option value="0">เลือกรหัสพนักงาน</option>
                                  <?php
                                      $db = Connectdb::Databaseall();
                                      $dataemp = DB::connection('mysql')->select('SELECT code_emp_old,nameth,surnameth,nickname FROM '.$db['hr_base'].'.emp_data WHERE workingstatus IN (0,1) ');
                                      foreach ($dataemp as $key2 => $value2) {?>
                                      <option value="<?php echo $value2->code_emp_old; ?>"><?php echo $value2->code_emp_old.'  ('.$value2->nameth.'   '.$value2->surnameth.')' ?></option>
                                  <?php } ?>
                          </select>
                        </div>
                        <div class="col-md-4 savetranferup" >
                            ชื่อพนักงานขนออก
                           <input type="text" name="emp_store" class="form-control emp_out" id="emp_store" readonly value="" >
                        </div>
                    </div>
                    <div class="row savecheckbill">
                        <br>
                    </div>
                    <div class="row">
                        <div class="col-md-12" >

                        </div>
                    </div>
                    <div class="row savecheckbill">
                        <br>
                    </div>
                    <div class="row savecheckbill">
                        <div class="col-md-12 savecheckbill" style="display:none;">
                           <table class="table table-bordered">
                               <tr>
                                 <td align="center">วันที่จ่าย</td>
                                 <td align="center">จำนวนเงิน</td>
                                 <td align="center">การรับเงิน</td>
                                 <td align="center">ยอดสุทธิ</td>
                                 <td align="center"></td>
                               </tr>
                               <tr>
                                 <td><input type="text" name="datepayreal" id="datepayreal0" class="form-control datepicker" onchange="pickdatereal(0)" readonly></td>
                                 <td><input type="text" name="grandtotalpayreal" id="grandtotalpayreal0" class="form-control" placeholder="จำนวนเงิน" onblur="calcullatewthreal()"></td>
                                 <td>
                                   <select name="typepaypartial" id="typepaypartial"  onchange="typepaypartialthis(this)" class="form-control" >
                                      <option value="">เลือกช่องทางการชำระเงิน</option>
                                      <option value="1">เงินสด</option>
                                      <option value="2">เงินโอน</option>

                                   </select>
                                 </td>
                                 <td>
                                      <input type="text" name="resultpayrealonce" id="resultpayrealonce" class="form-control">
                                 </td>
                                 <td>
                                      <button type="button" style="display:none;" onclick="Savepayreal()" id="savepaypeal"  class="btn btn-primary">บันทึก</button>
                                 </td>
                               </tr>
                           </table>
                        </div>
                    </div>
                    <div class="row ">
                        <br>
                    </div>
                    <div class="row ">
                        <div class="col-md-12 ">
                          <center><b>ประวัติการจ่ายเงิน</b></center>
                        </div>
                    </div>
                    <div class="row ">
                        <br>
                    </div>
                    <div class="row ">
                        <div class="col-md-12 ">
                           <table class="table table-bordered">
                               <tr>
                                 <td align="center">วันที่จ่าย</td>
                                 <td align="center">จำนวนเงิน</td>
                                 <td align="center">หัก ณ ที่จ่ายต่อครั้ง (%)</td>
                                 <td align="center">พิมพ์ใบกำกับภาษีอย่างย่อย่อย</td>
                               </tr>
                               <tbody id="showdetailpaylistabb">

                               </tbody>
                               <tbody id="showdetailpaylistfull">

                               </tbody>
                           </table>
                        </div>
                    </div>
                    <div class="row">
                        <br>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="pull-right">
                                รหัสพนักงาน:
                                <input type="text" class="form-control" name="code_emp" id="code_emp" value="<?php echo $brcode = Session::get('emp_code')?>" readonly>

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <br>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="pull-right">
                                <input type="text" class="form-control" name="code_sup" id="code_sup" placeholder="รหัสซุปประจำสาขา">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <br>
                    </div>
                    <div class="row" style="display: none;" id="updatestatus" >
                        <div class="col-md-4">

                        </div>
                        <div class="col-md-4">
                            สถานะปัจจุบัน
                            <?php
                             $id_position = Session::get('id_position');
                             $level_emp = Session::get('level_emp');

                             $db = Connectdb::Databaseall();
                             $datainsurance= DB::connection('mysql')->select('SELECT * FROM '.$db['fsctmain'].'.config_auth_qt WHERE position_id = "'.$id_position.'" OR level_emp = "'.$level_emp.'" AND status = "1" ');
                            // print_r($datainsurance);
                            ?>
                            <select name="status" id="status" class="form-control" disabled>
                                <option value="0" selected>รออนุมัติ</option>
                                <option value="1"  <?php  if(!$datainsurance){ echo "disabled"; } ?> >อนุมัติใบ quotation</option>
                                <option value="99" >ยกเลิก</option>
                            </select>


                        </div>
                        <div class="col-md-4">

                        </div>
                    </div>
                    <div class="row">
                        <br>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="col-xs-5 col-xs-offset-3">

                                    <button type="button" onclick="Saverent()" id="saverent"  class="btn btn-primary">ลงเช่า</button>
                                    <button type="button" onclick="Savetranferup()" id="savetranferup"  class="btn btn-info">ขึ้นของ</button>

                                    <!-- <button type="button" onclick="Savetcontinue()" id="savecontinue"  class="btn btn-warning">ต่อบิล</button> -->
                                    <button type="button" id="savecontinue"  onclick="modalcashcontinue()"   class="btn btn-warning">ต่อบิล</button>
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">

                    </div>



                </form>
            </div>
        </div>
    </div>
</div>



<div id="docref" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">พิมพ์เอกสารที่เกี่ยวข้อง</h4>
      </div>
      <div class="modal-body">
          <table width="100%" border="1" cellspacing="5" cellpadding="5">
              <tr>
                  <td width="50%" align="right">พิมพ์ใบสนอราคา</td>
                  <td width="50%">&nbsp;&nbsp;&nbsp;<span id="printqtthis"></span></td>
              </tr>
              <tr>
                  <td width="50%" align="right">ใบกำกับภาษีอย่างย่อ/เต็ม</td>
                  <td width="50%">&nbsp;&nbsp;&nbsp;<span id="printtaxinvoiceabb"></span></td>
              </tr>
              <tr>
                  <td width="50%" align="right">ใบแจ้งหนี้</td>
                  <td width="50%">&nbsp;&nbsp;&nbsp;<span id="printinvoice"></span></td>
              </tr>
              <tr>
                  <td width="50%" align="right">ใบกำกับภาษีเงินประกัน</td>
                  <td width="50%">&nbsp;&nbsp;&nbsp;<span id="printinvoiceinsurancerefrent"></span></td>
              </tr>
              <tr>
                  <td width="50%" align="right">ใบขึ้นของ</td>
                  <td width="50%">&nbsp;&nbsp;&nbsp;<span id="printdeliveryorder"></span></td>
              </tr>
              <tr>
                  <td width="50%" align="right">ใบเก็บของ</td>
                  <td width="50%">&nbsp;&nbsp;&nbsp;<span id="printreturnorder"></span></td>
              </tr>
              <tr>
                  <td width="50%" align="right">ใบลดหนี้</td>
                  <td width="50%">&nbsp;&nbsp;&nbsp;<span id="printcreditnote"></span></td>
              </tr>
              <tr>
                  <td width="50%" align="right">ใบลดหนี้ ประกัน</td>
                  <td width="50%">&nbsp;&nbsp;&nbsp;<span id="printtaxinvoiceinsurancecreditnote"></span></td>
              </tr>
              <tr>
                  <td width="50%" align="right">ใบกำกับภาษี (เพิ่มเติม) อย่างย่อ/ เต็ม</td>
                  <td width="50%">&nbsp;&nbsp;&nbsp;<span id="printtaxinvoicemoreabb"></span></td>
              </tr>
              <tr>
                  <td width="50%" align="right">ใบกำกับภาษีของหาย อย่างย่อ/เต็ม</td>
                  <td width="50%">&nbsp;&nbsp;&nbsp;<span id="printtaxinvoicelossabb"></span></td>
              </tr>
          </table>
          <!-- <div class="row" id="showprinttaxinvoiceabb">
              <div class="col-md-6 " align="right">
                    <b>ใบกำกับภาษีอย่างย่อ</b>
              </div>
              <div class="col-md-6">

              </div>
          </div>
          <div class="row" id="showprintinvoice">
              <div class="col-md-6 " align="right">
                    <b>ใบแจ้งหนี้</b>
              </div>
              <div class="col-md-6">
                  <span id="printinvoice"></span>
              </div>
          </div>
          <div class="row" id="showprintinvoiceinsurancerefrent">
              <div class="col-md-6 " align="right">
                    <b>ใบกำกับภาษีเงินประกัน</b>
              </div>
              <div class="col-md-6">
                  <span id="printinvoiceinsurancerefrent"></span>
              </div>
          </div> -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<!-- modalReturn -->


<div  class="modal fade" id="modalReturnthis" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">คืนสินค้ารหัสบิล <span></span></h4>
      </div>
      <div class="modal-body">
          <div class="row">
            <b><center>รายละเอียดการยืม</center></b>
          </div>
          <div class="row">
            <br>
          </div>
          <div class="row">
            <table width="100%" class="table table-bordered table-sm">
              <thead>
                 <tr>
                   <th align="center">รหัสสินค้า</th>
                   <th align="center">ชื่อสินค้า</th>
                   <th align="center">จำนวนที่ยืม</th>
                   <th align="center">จำนวนที่คืนแล้ว</th>
                  <th align="center">เหลือที่มือลูกค้า</th>
                 </tr>
              </thead>
             <tbody id="showdetailrentpd">

             </tbody>
            </table>
          </div>
          <div class="row">
            <br>
          </div>
          <div class="row">
            <b><center>การคืนสินค้า</center></b>
          </div>
          <div class="row">
            <br>
          </div>
          <div class="row">
            <table width="100%" class="table table-bordered table-sm">
              <thead>
                 <tr>
                   <th align="center">รหัสสินค้า</th>
                   <th align="center">ชื่อสินค้า</th>
                   <th align="center">วันที่คืน</th>
                   <th align="center">เลือกจ่ายคืน</th>
                   <th align="center">จำนวนที่คืน</th>
                 </tr>
              </thead>
             <tbody id="showdetailreturn">

             </tbody>
            </table>
          </div>
          <div class="row">
            <br>
          </div>
          <div class="row">
            <b><center>ประวัติการคืน</center></b>
          </div>
          <div class="row">
            <br>
          </div>
          <div class="row">
            <table width="100%" class="table table-bordered table-sm">
              <thead>
                 <tr>
                   <th align="center">รหัสสินค้า</th>
                   <th align="center">ชื่อสินค้า</th>
                   <th align="center">วันที่คืน</th>
                   <th align="center">จำนวนที่คืน</th>
                 </tr>
              </thead>
             <tbody id="showdetailreturnhistory">

             </tbody>
            </table>
          </div>
          <div class="row">
            <br>
          </div>
          <div class="row">
              <div class="col-md-12">
                  <center>
                       <font color="red" style="font-size: 20px;">กรุณาเลือกสถานะการชำระเงิน</font>
                  </center>
                  <input type="hidden" id="statusshowmore" value="0">
              </div>
          </div>

          <!-- ค่าเช่าเพิ่มเติม !-->

          <div class="row showrn" style="display:none;">
              <div class="col-md-12">
                  <br>
              </div>
          </div>
          <div class="row showrn" style="display:none;">
              <div class="col-md-12">
                  <center>
                      <font color="green">ยอดเงินค่าเช่าส่วนเกิน</font>
                  </center>
              </div>
          </div>
          <div class="row showrn" style="display:none;">
              <div class="col-md-12">
                  <br>
              </div>
          </div>
          <div class="row showrn" style="display:none;">
              <div class="col-md-12">
                  <input type="radio" name="getvaluestatusrn" onclick="getvaluestatusrn(0)"  value="0"> <font color="green"> เงินสดค่าเช่าเกินกำหนดทั้งหมด </font>
              </div>
          </div>
          <div class="row showrn" style="display:none;">
              <div class="col-md-12">
                  <br>
              </div>
          </div>
          <div class="row showrn" style="display:none;">
              <div class="col-md-12">
                  <input type="radio"  name="getvaluestatusrn" onclick="getvaluestatusrn(2)" value="2"> <font color="green"> เงินโอนค่าเช่าเกินกำหนดทั้งหมด </font>
              </div>
          </div>
          <div class="row showrn" style="display:none;">
              <div class="col-md-12">
                  <br>
              </div>
          </div>
          <div class="row showrn" style="display:none;">
              <div class="col-md-3">
                  <input type="radio"  name="getvaluestatusrn"  onclick="getvaluestatusrn(4)"  value="4"> <font color="green"> เช็คเงินสด </font>
              </div>
              <div class="col-md-3">
                  <?php
                    $branch = Session::get('brcode');
                    $sqlcheque = 'SELECT '.$db['fsctaccount'].'.cheque.*
                                   FROM '.$db['fsctaccount'].'.cheque
                                   WHERE  branch = '.$branch.' ';
                    $datacheque = DB::connection('mysql')->select($sqlcheque);
                    // print_r($datacheque);
                  ?>

                  <select name="chequern" id="chequern" class="form-control" required disabled>
                      <option value="0">เลือกหมายเลขเช็ค</option>
                      <?php
                      foreach ($datacheque as $key => $value) {?>
                      <option value="<?php echo $value->id;?>"><?php echo $value->name;?> (<?php echo $value->cheque_no;?>) </option>
                      <?php } ?>
                  </select>
              </div>
          </div>
          <div class="row showrn" style="display:none;">
                <div class="col-md-12">
                    <br>
                </div>
          </div>
          <div class="row showrn" style="display:none;">
              <div class="col-md-12">
                <font color="red"> กรณีเป็นเงินโอนให้เลือกธนาคาร  </font>
                <select name="bankrn" id="bankrn" class="form-control" required disabled>
                    <option value="0">เลือกแบงก์</option>
                    <?php
                    $sqlbank = 'SELECT '.$db['fsctaccount'].'.bank.*
                                   FROM '.$db['fsctaccount'].'.bank
                                   WHERE  branch_id = '.$branch.'
                                   AND status ="1" ';
                    $databank = DB::connection('mysql')->select($sqlbank);
                    foreach ($databank as $key4 => $value4) {?>
                    <option value="<?php echo $value4->id;?>"><?php echo $value4->name_bank;?> <?php echo $value4->name;?> (<?php echo $value4->number_bank;?>) </option>
                    <?php } ?>
                </select>
              </div>
          </div>
          <div class="row showrn" style="display:none;">
                <div class="col-md-12">
                    <br>
                </div>
          </div>
          <div class="row showrn" style="display:none;">
              <div class="col-md-12">
                  <hr>
              </div>
          </div>
          <div class="row">
              <div class="col-md-12">
                  <br>
              </div>
          </div>
          <div class="row">
              <div class="col-md-12">
                  <center>
                      <font color="orange"> ยอดเงินค่าของหาย </font>
                  </center>
              </div>
          </div>
          <div class="row">
              <div class="col-md-12">
                  <br>
              </div>
          </div>
          <div class="row">
              <div class="col-md-12 stupidsun">
                  <input type="radio" name="getvaluestatusrl" onclick="getvaluerl(this)" value="1"> <font color="orange"> เงินสดของหายทั้งหมด </font>
              </div>
          </div>
          <div class="row">
              <div class="col-md-12">
                  <br>
              </div>
          </div>
          <div class="row">
              <div class="col-md-12 stupidsun">
                  <input type="radio"  name="getvaluestatusrl" onclick="getvaluerl(this)" value="2"> <font color="orange"> เงินโอนของหายทั้งหมด </font>
              </div>
          </div>
          <div class="row">
              <div class="col-md-12">
                  <br>
              </div>
          </div>
          <div class="row stupidsun">
              <div class="col-md-3">
                  <input type="radio"  name="getvaluestatusrl" onclick="getvaluerl(this)" value="4"> <font color="orange"> เช็คเงินสด </font>
              </div>
              <div class="col-md-3">
                  <?php
                    $branch = Session::get('brcode');
                    $sqlcheque = 'SELECT '.$db['fsctaccount'].'.cheque.*
                                   FROM '.$db['fsctaccount'].'.cheque
                                   WHERE  branch = '.$branch.' ';
                    $datacheque = DB::connection('mysql')->select($sqlcheque);
                    // print_r($datacheque);
                  ?>

                  <select name="chequerl" id="chequerl" class="form-control" required disabled>
                      <option value="0">เลือกหมายเลขเช็ค</option>
                      <?php
                      foreach ($datacheque as $key => $value) {?>
                      <option value="<?php echo $value->id;?>"><?php echo $value->name;?> (<?php echo $value->cheque_no;?>) </option>
                      <?php } ?>
                  </select>
              </div>
          </div>
          <div class="row ">
                <div class="col-md-12">
                    <br>
                </div>
          </div>
          <div class="row">
              <div class="col-md-12 stupidsun">
                <font color="red"> กรณีเป็นเงินโอนให้เลือกธนาคาร  </font>
                <select name="bankrl" id="bankrl" class="form-control" required disabled>
                    <option value="0">เลือกแบงก์</option>
                    <?php
                    $sqlbank = 'SELECT '.$db['fsctaccount'].'.bank.*
                                   FROM '.$db['fsctaccount'].'.bank
                                   WHERE  branch_id = '.$branch.'
                                   AND status ="1" ';
                    $databank = DB::connection('mysql')->select($sqlbank);
                    foreach ($databank as $key4 => $value4) {?>
                    <option value="<?php echo $value4->id;?>"><?php echo $value4->name_bank;?> <?php echo $value4->name;?> (<?php echo $value4->number_bank;?>) </option>
                    <?php } ?>
                </select>
              </div>
          </div>
          <div class="row showrn" style="display:none;">
                <div class="col-md-12">
                    <br>
                </div>
          </div>
          <div class="row">
              <div class="col-md-12 noobsun">
                  <center>
                      <input type="radio" id="noobsun" name="getvaluestatusrl" onclick="getvaluerl(this)" value="3"> <font color="orange"> ไม่มีของหาย </font>
                  </center>
              </div>
          </div>
          <div class="row">
              <div class="col-md-12">
                  <br>
              </div>
          </div>
      </div>
      <div class="modal-footer">
        <div class="col-12 text-center">
          <button type="button" onclick="savereturnthis()" class="btn btn-success" >ลงคืน</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <br>
          <br>
            <button type="button" onclick="Savetcheckbill()" style="display:none;" id="savecheckbill"  class="btn btn-danger">ปิดบิล</button>
        </div>
      </div>
    </div>

  </div>
</div>

<div class="modal fade" id="modalcalcel" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">ยกเลิกการเช่า</h4>
        </div>
        <div class="modal-body">
          <div class="row">
              <div class="col-md-12">
                <center>
                  ยกเลิกรหัสบิลเช่า เลขที่
                  <input type="hidden" name="id_billrent_cancel" id="id_billrent_cancel">
                  <input type="hidden" name="id_qt_cancel" id="id_qt_cancel">
                  <span id="idrentshowcancel">
                  </span>
                </center>
              </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" onclick="cancelbillthis()">ยกเลิก</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>

    </div>
  </div>


  <div class="modal fade" id="modalcashmoney" role="dialog">
      <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">ลงเงินสดรายวัน</h4>
          </div>
          <div class="modal-body">

            <div class="row">
                <div class="col-md-12">
                    <center>
                        <font color="green">ยอดเงินค่าเช่าทั้งหมด</font>  <font color="red" id="showrentreal"><font color="green"> บาท </font>
                    </center>
                  <input type="hidden" id="showrentrealshow" value="0">
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <br>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                      <input type="radio" name="gettypemoney" onclick="checkgettypemoney(0)" value="0"> <font color="green"> ไม่รับเงินจากลูกค้า (เงินเชื่อ/ไม่มีธุรกรรม) </font>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <br>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                      <input type="radio" name="gettypemoney" onclick="checkgettypemoney(1)" value="1"> <font color="green"> เงินสดค่าเช่าทั้งหมด ( <font color="red" id="thismoney1">0</font>) </font>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <br>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                      <input type="radio" name="gettypemoney" onclick="checkgettypemoney(2)" value="2"> <font color="green"> เงินโอนค่าเช่าทั้งหมด (<font color="red" id="thismoney2">0</font>) </font>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <br>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                      <input type="radio" name="gettypemoney" onclick="checkgettypemoney(4)" value="4"> <font color="green"> เช็คเงินสด </font>
                </div>
                <div class="col-md-3">
                      <?php
                        $branch = Session::get('brcode');
                        $sqlcheque = 'SELECT '.$db['fsctaccount'].'.cheque.*
                                       FROM '.$db['fsctaccount'].'.cheque
                                       WHERE  branch = '.$branch.' ';
                        $datacheque = DB::connection('mysql')->select($sqlcheque);
                        // print_r($datacheque);
                      ?>

                      <select name="cheque1" id="cheque1" class="form-control" required disabled>
                          <option value="0">เลือกหมายเลขเช็ค</option>
                          <?php
                          foreach ($datacheque as $key => $value) {?>
                          <option value="<?php echo $value->id;?>"><?php echo $value->name;?> (<?php echo $value->cheque_no;?>) </option>
                          <?php } ?>
                      </select>
                </div>
                <div class="col-md-6">

                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <br>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                      <input type="radio" name="gettypemoney" onclick="checkgettypemoney(3)"  value="3"> <font color="green"> เงินโอน/เงินสด ค่าเช่า </font>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <br>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                      <font color="green"> เงินสดค่าเช่า </font>
                </div>
                <div class="col-md-3">
                      <input type="text" class="form-control" id="paymoneycash" onblur="paymoneycash()" readonly name="paymoneycash">
                </div>
                <div class="col-md-3">
                      <font color="green">  เงินโอนค่าเช่า </font>
                </div>
                <div class="col-md-3">
                       <input type="text" class="form-control" id="paymoneybank" readonly name="paymoneybank">
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <br>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                  <font color="red"> กรณีเป็นเงินโอนให้เลือกธนาคาร  </font>
                  <select name="bank1" id="bank1" class="form-control" required disabled>
                      <option value="0">เลือกแบงก์</option>
                      <?php
                      $sqlbank = 'SELECT '.$db['fsctaccount'].'.bank.*
                                     FROM '.$db['fsctaccount'].'.bank
                                     WHERE  branch_id = '.$branch.'
                                     AND status ="1" ';
                      $databank = DB::connection('mysql')->select($sqlbank);
                      foreach ($databank as $key4 => $value4) {?>
                      <option value="<?php echo $value4->id;?>"><?php echo $value4->name_bank;?> <?php echo $value4->name;?> (<?php echo $value4->number_bank;?>) </option>
                      <?php } ?>
                  </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <br>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <hr>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <br>
                </div>
            </div>
            <div class="row a"  style="display:none;">
                <div class="col-md-12 ">
                    <center>
                        <font color="orange"> ยอดเงินค่าขนส่งทั้งหมด </font> <font color="red" id="showtransport"></font>  <font color="orange"> บาท</font>
                    </center>
                    <input type="hidden" id="showtransportshow" value="0">
                </div>
            </div>
            <div class="row a"  style="display:none;">
                <div class="col-md-12">
                    <br>
                </div>
            </div>
            <div class="row a"  style="display:none;">
                <div class="col-md-12">
                    <input type="radio" name="gettypemoneytranfer" onclick="checkgettypemoneytranfer(0)" value="0"> <font color="orange"> ไม่รับเงินจากลูกค้า  (เงินเชื่อ/ไม่มีธุรกรรม) </font>
                </div>
            </div>
            <div class="row a"  style="display:none;">
                <div class="col-md-12">
                    <br>
                </div>
            </div>
            <div class="row a"  style="display:none;">
                <div class="col-md-12">
                    <input type="radio" name="gettypemoneytranfer" onclick="checkgettypemoneytranfer(1)" value="1"> <font color="orange"> เงินสดขนส่งทั้งหมด ( <font color="red" id="thistranfer1">0</font>)</font>
                </div>
            </div>
            <div class="row a"  style="display:none;">
                <div class="col-md-12">
                    <br>
                </div>
            </div>
            <div class="row a"  style="display:none;">
                <div class="col-md-12">
                    <input type="radio" name="gettypemoneytranfer" onclick="checkgettypemoneytranfer(2)" value="2"> <font color="orange"> เงินโอนขนส่งทั้งหมด ( <font color="red" id="thistranfer2">0</font>)</font>
                </div>
            </div>
            <div class="row a"  style="display:none;">
                <div class="col-md-12">
                    <br>
                </div>
            </div>
            <div class="row a"  style="display:none;">
                <div class="col-md-3">
                      <input type="radio" name="gettypemoneytranfer" onclick="checkgettypemoneytranfer(4)" value="4"> <font color="orange"> เช็คเงินสด </font>
                </div>
                <div class="col-md-3">
                      <?php
                        $branch = Session::get('brcode');
                        $sqlcheque = 'SELECT '.$db['fsctaccount'].'.cheque.*
                                       FROM '.$db['fsctaccount'].'.cheque
                                       WHERE  branch = '.$branch.' ';
                        $datacheque = DB::connection('mysql')->select($sqlcheque);
                        // print_r($datacheque);
                      ?>

                      <select name="cheque2" id="cheque2" class="form-control" required disabled>
                          <option value="0">เลือกหมายเลขเช็ค</option>
                          <?php
                          foreach ($datacheque as $key => $value) {?>
                          <option value="<?php echo $value->id;?>"><?php echo $value->name;?> (<?php echo $value->cheque_no;?>) </option>
                          <?php } ?>
                      </select>
                </div>
                <div class="col-md-6">

                </div>
            </div>
            <div class="row a"  style="display:none;">
                <div class="col-md-12">
                    <br>
                </div>
            </div>
            <div class="row a"  style="display:none;">
                <div class="col-md-12">
                  <input type="radio" name="gettypemoneytranfer" onclick="checkgettypemoneytranfer(3)"  value="3"> <font color="orange"> เงินโอน/เงินสด ขนส่ง </font>
                </div>
            </div>
            <div class="row a"  style="display:none;">
                <div class="col-md-12">
                    <br>
                </div>
            </div>
            <div class="row a"  style="display:none;">
                <div class="col-md-3">
                    <center>
                        <font color="orange"> เงินสด ขนส่ง </font>
                    </center>
                </div>
                <div class="col-md-3">
                    <center>
                       <input type="text" class="form-control" id="paymoneytranfercash" onblur="paymoneycashtrafer()" readonly name="paymoneytranfercash">
                    </center>
                </div>
                <div class="col-md-3">
                    <center>
                        <font color="orange"> เงินโอน ขนส่ง </font>
                    </center>
                </div>
                <div class="col-md-3">
                    <center>
                       <input type="text" class="form-control" id="paymoneytranferbank" readonly name="paymoneytranferbank">
                    </center>
                </div>
            </div>
            <div class="row a"  style="display:none;">
                <div class="col-md-12">
                    <br>
                </div>
            </div>
            <div class="row a" style="display:none;">
                <div class="col-md-12">
                  <font color="red"> กรณีเป็นเงินโอนให้เลือกธนาคาร  </font>
                  <select name="bank2" id="bank2" class="form-control" required disabled>
                      <option value="0">เลือกแบงก์</option>
                      <?php
                      $sqlbank = 'SELECT '.$db['fsctaccount'].'.bank.*
                                     FROM '.$db['fsctaccount'].'.bank
                                     WHERE  branch_id = '.$branch.'
                                     AND status ="1" ';
                      $databank = DB::connection('mysql')->select($sqlbank);
                      foreach ($databank as $key4 => $value4) {?>
                      <option value="<?php echo $value4->id;?>"><?php echo $value4->name_bank;?> <?php echo $value4->name;?> (<?php echo $value4->number_bank;?>) </option>
                      <?php } ?>
                  </select>
                </div>
            </div>
            <div class="row a"  style="display:none;">
                <div class="col-md-12">
                    <br>
                </div>
            </div>
            <div class="row"  style="display:none;">
                <div class="col-md-12">
                    <hr>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <br>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <br>
                </div>
            </div>
            <div class="row  b"  style="display:none;">
                <div class="col-md-12">
                    <center>
                        ยอดเงินประกันทั้งหมด  <font color="black" id="showinsurancemoneyreal"></font>  บาท
                    </center>
                    <input type="hidden" id="showinsurancemoneyrealshow">
                </div>
            </div>
            <div class="row b"  style="display:none;">
                <div class="col-md-12">
                    <br>
                </div>
            </div>
            <div class="row b"  style="display:none;">
                <div class="col-md-12">
                    <input type="radio" name="gettypemoneyinsurance" onclick="checkgettypemoneyinsurance(0)" value="0"> <font color="black"> ไม่รับเงินจากลูกค้า (เงินเชื่อ/ไม่มีธุรกรรม)</font>
                </div>
            </div>
            <div class="row  b"  style="display:none;">
                <div class="col-md-12">
                    <br>
                </div>
            </div>
            <div class="row  b"  style="display:none;">
                <div class="col-md-12">
                    <input type="radio"  name="gettypemoneyinsurance" onclick="checkgettypemoneyinsurance(1)" value="1">  <font color="black"> เงินสดประกันทั้งหมด ( <font color="red" id="thisinsurance1">0</font>)</font>
                </div>
            </div>
            <div class="row  b"  style="display:none;">
                <div class="col-md-12">
                    <br>
                </div>
            </div>
            <div class="row  b"  style="display:none;">
                <div class="col-md-12">
                    <input type="radio"  name="gettypemoneyinsurance" onclick="checkgettypemoneyinsurance(2)"  value="2"> <font color="black"> เงินโอนประกันทั้งหมด ( <font color="red" id="thisinsurance2">0</font>)</font>
                </div>
            </div>
            <div class="row  b"  style="display:none;">
                <div class="col-md-12">
                    <br>
                </div>
            </div>
            <div class="row  b"  style="display:none;">
                <div class="col-md-3">
                      <input type="radio" name="gettypemoneyinsurance" onclick="checkgettypemoneyinsurance(4)" value="4"> <font color="black"> เช็คเงินสด </font>
                </div>
                <div class="col-md-3">
                      <?php
                        $branch = Session::get('brcode');
                        $sqlcheque = 'SELECT '.$db['fsctaccount'].'.cheque.*
                                       FROM '.$db['fsctaccount'].'.cheque
                                       WHERE  branch = '.$branch.' ';
                        $datacheque = DB::connection('mysql')->select($sqlcheque);
                        // print_r($datacheque);
                      ?>

                      <select name="cheque3" id="cheque3" class="form-control" required disabled>
                          <option value="0">เลือกหมายเลขเช็ค</option>
                          <?php
                          foreach ($datacheque as $key => $value) {?>
                          <option value="<?php echo $value->id;?>"><?php echo $value->name;?> (<?php echo $value->cheque_no;?>) </option>
                          <?php } ?>
                      </select>
                </div>
                <div class="col-md-6">

                </div>
            </div>
            <div class="row  b"  style="display:none;">
                <div class="col-md-12">
                    <br>
                </div>
            </div>
            <div class="row  b"  style="display:none;">
                <div class="col-md-12">
                    <input type="radio"   name="gettypemoneyinsurance" onclick="checkgettypemoneyinsurance(3)" value="3"> <font color="black"> เงินโอน/เงินสด ประกัน</font>
                </div>
            </div>
            <div class="row  b"  style="display:none;">
                <div class="col-md-12">
                    <br>
                </div>
            </div>

            <div class="row  b"  style="display:none;">
                <div class="col-md-3">
                    <center>
                       <font color="black"> เงินสด ประกัน</font>
                    </center>
                </div>
                <div class="col-md-3">
                    <center>
                       <input type="text" class="form-control" id="paymoneyinsurancecash" onblur="paymoneycashinsurance()" readonly name="paymoneyinsurancecash">
                    </center>
                </div>
                <div class="col-md-3">
                    <center>
                      <font color="black"> เงินโอน ประกัน</font>
                    </center>
                </div>
                <div class="col-md-3">
                    <center>
                       <input type="text" class="form-control" id="paymoneyinsurancebank" readonly name="paymoneyinsurancebank">
                    </center>
                </div>
            </div>
            <div class="row  b"  style="display:none;">
                <div class="col-md-12">
                    <br>
                </div>
            </div>
            <div class="row b" style="display:none;">
                <div class="col-md-12">
                  <font color="red"> กรณีเป็นเงินโอนให้เลือกธนาคาร  </font>
                  <select name="bank3" id="bank3" class="form-control" required disabled>
                      <option value="0">เลือกแบงก์</option>
                      <?php
                      $sqlbank = 'SELECT '.$db['fsctaccount'].'.bank.*
                                     FROM '.$db['fsctaccount'].'.bank
                                     WHERE  branch_id = '.$branch.'
                                     AND status ="1" ';
                      $databank = DB::connection('mysql')->select($sqlbank);
                      foreach ($databank as $key4 => $value4) {?>
                      <option value="<?php echo $value4->id;?>"><?php echo $value4->name_bank;?> <?php echo $value4->name;?> (<?php echo $value4->number_bank;?>) </option>
                      <?php } ?>
                  </select>
                </div>
            </div>
            <div class="row a"  style="display:none;">
                <div class="col-md-12">
                    <br>
                </div>
            </div>



          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-success saverentthis" style="display:none;" onclick="saverentthis()">บันทึก</button>
          </div>
        </div>

      </div>
    </div>




      <div class="modal fade" id="modalcashmoneycontinuebill" role="dialog">
          <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">ลงเงินสดรายวัน</h4>
              </div>
              <div class="modal-body">

                <div class="row">
                    <div class="col-md-12">
                        <center>
                            <font color="green">ยอดเงินค่าเช่าทั้งหมด</font>  <font color="red" id="showrentreal"></font>  <font color="green"> บาท </font>
                        </center>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <br>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <center>
                            <input type="radio" name="gettypemoneycontinuebill" onclick="checkgettypemoneycontinuebill(1)" value="1"> <font color="green"> เงินสดค่าเช่าทั้งหมด </font>
                        </center>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <br>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <center>
                            <input type="radio" name="gettypemoneycontinuebill" onclick="checkgettypemoneycontinuebill(2)" value="2"> <font color="green"> เงินโอนค่าเช่าทั้งหมด </font>
                        </center>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <br>
                    </div>
                </div>

              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-success saverentthiscontinue" style="display:none;" onclick="Savetcontinue()">ต่อบิล</button>
              </div>
            </div>

          </div>
        </div>
