<?php use App\Api\Connectdb;?>
@extends('index')
@section('content')
<script type="text/javascript" src="https://unpkg.com/sweetalert2@7.0.6/dist/sweetalert2.all.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
@if (Session::has('sweetalert.json'))
<script>
swal({!!Session::pull('sweetalert.json')!!});
</script>
@endif

<style media="screen">
.select2-container .select2-selection--single{
  height:40px !important;
}
.select2-container--default .select2-selection--single{
  border: 1px solid #ccc !important;
  border-radius: 0px !important;
}
</style>

  <div class="content-page">
    <!-- Start content -->
        <div class="content">
             <div class="container-fluid">

                  <div class="row">
                        <div class="col-xl-12">
                            <div class="breadcrumb-holder" id="fontscontent">
                                <h1 class="float-left">Account - FSCT</h1>
                                <ol class="breadcrumb float-right">
                                  <li class="breadcrumb-item">ทรัพย์สินและค่าเสื่อม</li>
                                  <li class="breadcrumb-item active">ใบเบิกวัตถุดิบ (ซื้อมาผลิต)</li>
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
                            <fonts id="fontsheader">ใบเบิกวัตถุดิบ (ซื้อมาผลิต)</fonts>
                          </h3>
                        </div>
                        </div><!-- end card-->

                        <!-- Button to Open the Modal -->
                        <!-- แสดงตาราง -->
                        <?php
                        $connect1 = Connectdb::Databaseall();

                        $baseAc1 = $connect1['fsctaccount'];
                        $baseMan = $connect1['fsctmain'];

                        $sql1 = "SELECT $baseAc1.po_head.*,
                                        $baseAc1.po_to_asset.*,
                                        $baseAc1.po_to_asset.id as idasset,
                                        $baseAc1.po_head.id as po_id
                                FROM $baseAc1.po_to_asset
                                INNER JOIN $baseAc1.po_head
                                ON $baseAc1.po_head.po_number = $baseAc1.po_to_asset.po_number
                                WHERE $baseAc1.po_to_asset.status = '1'";
                        $getdatas = DB::select($sql1);
                        //print_r($getdatas);
                        ?>
                        <div class="table-responsive">
                          <table id="example" class="table table-striped table-bordered fontslabel" style="width:100%">
                            <thead>
                              <tr>
                                <th>ลำดับ</th>
                                <th>รหัส PO</th>
                                <th>วันที่ บันทึก</th>
                                <th>lot</th>
                                <th>มูลค่าสุทธิ</th>
                                <th>สถานะใบPOวัตถุดิบ</th>
                                <th>สถานะใบเบิก</th>
                                <th>เบิกวัตถุดิบ</th>
                                <th>พิมพ์ใบเบิก</th>
                              </tr>
                            </thead>

                            <tbody>
                              <?php
                              if(!empty($getdatas)){
                                 $i=1;foreach ($getdatas as $key => $value) {    ?>
                                  <tr>
                                    <th><?php echo $i;?></th>
                                    <th><?php echo $value->po_number;?><input type="hidden" id="poshowappoved<?php echo $value->idasset?>" value="<?php echo $value->po_number;?>"></th>
                                    <th><?php echo $value->datetimestamp;?></th>
                                    <th><?php echo $value->lotnumber;?></th>
                                    <th><?php echo $value->totolsumreal;?></th>
                                    <th>
                                        <?php  if($value->status==0){
                                                    echo '<p style="color:blue"><a href="#"  data-toggle="modal" data-target="#exampleModal" onclick="confirmappove('.$value->idasset.')">รอการอนุมัติ</a></p>';
                                                }else if($value->status==1){
                                                    echo '<p style="color:green">อนุมัติแล้ว</p>';
                                                }else{
                                                    echo '<p style="color:red">ยกเลิก</p>';
                                                };
                                        ?>
                                    </th>
                                    <th>
                                        <?php
                                                  $sql2 = "SELECT $baseAc1.bill_of_lading_head.*,
                                                                  $baseAc1.bill_of_lading_detail.*
                                                          FROM $baseAc1.bill_of_lading_head
                                                          INNER JOIN $baseAc1.bill_of_lading_detail
                                                          ON $baseAc1.bill_of_lading_head.id = $baseAc1.bill_of_lading_detail.bill_of_lading_head
                                                          WHERE $baseAc1.bill_of_lading_head.status != '99'
                                                          AND $baseAc1.bill_of_lading_head.po_to_asset_id = '$value->idasset'";
                                                  $bill_of_lading_head = DB::select($sql2);
                                                  if(!empty($bill_of_lading_head)){
                                                      //print_r($bill_of_lading_head);
                                                      if($bill_of_lading_head[0]->status==2){
                                                          echo '<p style="color:blue">เบิกของครบแล้วรออนุมัติ</p>';
                                                      }elseif($bill_of_lading_head[0]->status==3){
                                                          echo '<p style="color:orange">ยังมีของค้างในคลัง</p>';
                                                      }
                                                  }else{
                                                    echo '<p style="color:blue">ยังไม่ได้เบิก</p>';
                                                  }

                                        ?>
                                    </th>

                                    <th>
                                      <?php
                                                $sql2 = "SELECT $baseAc1.bill_of_lading_head.*,
                                                                $baseAc1.bill_of_lading_detail.*
                                                        FROM $baseAc1.bill_of_lading_head
                                                        INNER JOIN $baseAc1.bill_of_lading_detail
                                                        ON $baseAc1.bill_of_lading_head.id = $baseAc1.bill_of_lading_detail.bill_of_lading_head
                                                        WHERE $baseAc1.bill_of_lading_head.status != '99'
                                                        AND $baseAc1.bill_of_lading_head.po_to_asset_id = '$value->idasset'";
                                                $bill_of_lading_head = DB::select($sql2);
                                                if(!empty($bill_of_lading_head)){
                                                    //print_r($bill_of_lading_head);
                                                    if($bill_of_lading_head[0]->status==2){
                                                        echo '<p style="color:blue"><a href="#"  data-toggle="modal" data-target="#exampleModal" onclick="confirmappove('.$bill_of_lading_head[0]->id.')">รอการอนุมัติขอ '.$bill_of_lading_head[0]->number_bill.' </a></p>';
                                                    }elseif($bill_of_lading_head[0]->status==3){?>
                                                        <button type="button" class="btn btn-primary" data-toggle="modal" onclick="getdatadmtool(<?php echo $value->idasset; ?>)" data-target="#myModal">
                                                          <i class="fas fa-plus">
                                                            <fonts id="fontscontent">เบิกวัตถุดิบ
                                                          </i>
                                                        </button>
                                                      <?php }
                                                }else{ ?>
                                                  <button type="button" class="btn btn-primary" data-toggle="modal" onclick="getdatadmtool(<?php echo $value->idasset; ?>)" data-target="#myModal">
                                                    <i class="fas fa-plus">
                                                      <fonts id="fontscontent">เบิกวัตถุดิบ
                                                    </i>
                                                  </button>
                                          <?php } ?>

                                    </th>
                                    <th>
                                        <?php
                                              if(!empty($bill_of_lading_head)){
                                                  //print_r($bill_of_lading_head);
                                                  if($bill_of_lading_head[0]->status==2){?>
                                                        <a href="printsettingpotooldetail?id=<?php echo $value->po_id ?>" target="_blank"><?php echo $bill_of_lading_head[0]->number_bill;?> </a>
                                                  <?php }elseif($bill_of_lading_head[0]->status==3){?>
                                                        <a href="printsettingpotooldetail?id=<?php echo $value->po_id ?>" target="_blank"><?php echo $bill_of_lading_head[0]->number_bill;?> </a>
                                                  <?php } ?>
                                         <?php } ?>
                                    </th>
                                  </tr>
                                <?php $i++;}
                              }?>
                            </tbody>
                          </table><br>
                        </div>




                        <br>

                                <!-- แสดง error กรอกข้อมูลไม่ครบ -->
                                @if ($errors->any())
                                <script>
                                  swal({
                                    title: 'กรุณาระบุข้อมูลให้ครบถ้วน',
                                    html: '{!! implode(' <br> ',$errors->all()) !!}',
                                    type: 'error'
                                  })
                                </script>
                                @endif
                                <!-- แสดง error -->

                                <br>


                                <!-- The Modal -->
                                <div class="modal fade" id="myModal">
                                  <div class="modal-dialog modal-xl" style="max-width: 80%;" role="document">
                                    <div class="modal-content">

                                      <!-- Modal Header -->
                                      <div class="modal-header">
                                        <h4 class="modal-title" id="fontscontent2"><b>ใบเบิกวัตถุดิบ (ซื้อมาผลิต)</b></h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                      </div>

                                      <!-- Modal body -->
                                      <!-- ทำการ validate ช่องข้อมูล แสดง error -->
                                      <div class="modal-body">
                                        @if ($errors->any())
                                        <div class="alert alert-danger">
                                          <ul>
                                            @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                            @endforeach
                                          </ul>
                                        </div>
                                        @endif
                                        <!-- //สิ้นสุด ทำการ validate ช่องข้อมูล แสดง error -->
                                      <form action="savesettingdmtool" method="post" id="myForm" files='true' >
                                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                      <input type="hidden" name="id_poasset" id="id_poasset" value="0">
                                                <div class="was-validated form-inline" style="margin: 10px 50px 0px 50px;">
                                                  <!-- <div class="col-sm-6"> -->
                                                  <div class="row">
                                                    &nbsp;&nbsp;<label class="mb-2 mr-sm-2" id="fontslabel" for=""><b>Lot :   <b id="lotthis"></b></b></label>
                                                    <br>
                                                  </div>
                                                  <!-- </div> -->
                                                </div>
                                                <br>
                                                <div class="row">
                                                  &nbsp;&nbsp;
                                                  <label class="mb-2 mr-sm-2" for="modal-input-priceservice" id="fontslabel"><b>วันที่ <?php echo date('Y-m-d H:m:s');?></b>

                                                  </label>
                                                  <br>
                                                </div>
                                                <br>
                                                <div class="row">
                                                  <label class="mb-2 mr-sm-2" id="fontslabel" for=""><b>รหัสพนักงาน : <?php   echo $fullname= Session::get('fullname');?></b>
                                                  </label>
                                                  <br>
                                                </div>
                                                <br>


                                                <table class="table table-bordered table-hover">
                                                  <thead>
                                                  <tr>
                                                    <th>ลำดับ</th>
                                                    <th>รายการ</th>
                                                    <th>ปริมาณ</th>
                                                    <th>ราคาต่อหน่วย</th>
                                                    <th>รับเข้า</th>
                                                    <th>เบิกใช้</th>
                                                    <th>คงเหลือ</th>
                                                  </tr>
                                                  </thead>
                                                  <tbody id="datatable">
                                                  </tbody>
                                                </table>

                                      </div>

                                      <!-- Modal footer -->

                                      <div class="modal-footer">

                                      {!! Form::submit('บันทึก', ['class' => 'btn btn-success', 'style' => 'dispaly: inline']) !!}
                                        <button type="button" class="btn btn-warning" data-dismiss="modal">ยกเลิก</button>

                                      </div>
                                    </form>

                                    </div>
                                  </div>
                                </div>



                    </div>
      			<!-- END container-fluid -->
      		    </div>
      		<!-- END content -->
        </div>
      </div><!-- end card-->
  </div>

  <!-- Modal confrime-->
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          ยืนยันการอนุมัติ <b id="poappove"></b>
          <input type="hidden" id="idpoappoved" value="">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" onclick="saveapprovedpostatus();">Save</button>
        </div>
      </div>
    </div>
  </div>

  <!-- MODAL edit -->



  <!-- end iditmodal -->


  <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script> -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  <script type="text/javascript" src = 'js/accountjs/settingdmtool.js'></script>
  <script>
      $(document).ready(function() {
      $('#example').DataTable();
      } );
  </script>



  <script type="text/javascript">
  $.ajaxSetup({ headers: { 'csrftoken' : '{{ csrf_token() }}' } });
  </script>



@endsection
