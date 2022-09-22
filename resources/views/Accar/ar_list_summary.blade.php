@extends('index')
@section('content')

<?php
use App\Api\Connectdb;
use App\Api\Datetime;
  $level_id = Session::get('level_id');
  // echo $level_id;
?>

<script type="text/javascript" src="https://unpkg.com/sweetalert2@7.0.6/dist/sweetalert2.all.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> -->
<script src="https://code.jquery.com/jquery-1.8.3.js" integrity="sha256-dW19+sSjW7V1Q/Z3KD1saC6NcE5TUIhLJzJbrdKzxKc=" crossorigin="anonymous"></script>
<!-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> -->
<!-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> -->
<!-- <script type="text/javascript">

$(function() {
//หมวด1
    $("#e1").select2({closeOnSelect:false});
    $("#checkbox").click(function(){
        if($("#checkbox").is(':checked') ){
            $("#e1 > option").prop("selected","selected");
            $("#e1").trigger("change");
        }else{
            $("#e1 > option").removeAttr("selected");
             $("#e1").trigger("change");
         }
    });
  // หมวด2
    $("#e2").select2({closeOnSelect:false});
    $("#checkbox1").click(function(){
        if($("#checkbox1").is(':checked') ){
            $("#e2 > option").prop("selected","selected");
            $("#e2").trigger("change");
        }else{
            $("#e2 > option").removeAttr("selected");
             $("#e2").trigger("change");
         }
    });

  });
</script> -->

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

<style media="screen">
  tr.group,
  tr.group:hover {
    background-color: #ddd !important;
  }

  .child {
  margin: 0 auto;
}
</style>
<script type="text/javascript">
  $(function() {
      $('input[name="daterange"]').daterangepicker();
  });
</script>


<div class="content-page">
  <!-- Start content -->
  <div class="content">
    <div class="container-fluid">

      <div class="row">
        <div class="col-xl-12">
          <div class="breadcrumb-holder" id="fontscontent">
            <h1 class="float-left">Account - FSCT</h1>
            <ol class="breadcrumb float-right">
              <li class="breadcrumb-item">เจ้าหนี้การค้า</li>
              <li class="breadcrumb-item active">ลูกหนี้คงค้างแบบสรุป</li>
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
                <fonts id="fontsheader">ลูกหนี้คงค้างแบบสรุป</fonts>
              </h3>
            </div>
          </div><!-- end card-->
          <?php
                    $connect1 = Connectdb::Databaseall();
                    $baseMain = $connect1['fsctmain'];
                    $baseAc1 = $connect1['fsctaccount'];
                    $sql = "SELECT  $baseAc1.initial.per,
                                    $baseMain.customers.name,
                                    $baseMain.customers.lastname,
                                    $baseMain.customers.customerid
                            FROM $baseMain.customers
                            INNER JOIN  $baseAc1.initial
                            ON $baseMain.customers.initial = $baseAc1.initial.id ";

                    $datas = DB::select($sql);

          ?>

          <form action="arlistsummary_serch" method="post" id="myForm" files='true' >
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <center>
              <div class="col-sm-4">
                  <div class="input-group mb-6">
                      <div class="input-group-prepend">
                          <label id="fontslabel"><b>ณ วันที่ : &nbsp;</b></label>
                      </div>
                      <input type='date' class="form-control" name="dateend" value="" autocomplete="off" />
                  </div>
              </div>
              <br>
              <div class="col-sm-3">
                  <div class="input-group mb-6">
                      <div class="input-group-prepend">
                          <label id="fontslabel"><b>ชื่อลูกหนี้ : &nbsp;</b></label>
                      </div>
                      <select name="customerid[]" class="form-control select2"  required>
                          <option value="">เลือกทั้งหมด</option>
                          <?php  foreach ($datas as $key => $value) { ?>
                              <option value="<?php echo $value->customerid; ?>"><?php echo $value->per; ?>&nbsp;&nbsp;<?php echo $value->name; ?>&nbsp;&nbsp; <?php echo $value->lastname; ?></option>
                          <?php } ?>
                      </select>
                  </div>
              </div>
              <br>
              <button type="submit" class="btn btn-primary btn-sm fontslabel">ค้นหา</button>
              <button type="reset" class="btn btn-danger btn-sm fontslabel">reset</button>
            </center>
          </form>

          <br>
          <br>
          <center>
            <?php if (isset($dateend)): ?>
              <label id="fontslabel"><b>วันที่ดึงรายงาน</b> <?php echo $dateend ?></label>
            <?php endif; ?>
          </center>
          <br>

          <?php if (isset($supplier_aps)): ?>
            <table class="table table-bordered" cellspacing="0" id="fontslabel" style="width : 70%;margin-left: auto;margin-right: auto;">
              <thead>
                <tr style="background-color:#aab6c2;color:white;">
                  <th scope="col">รหัส</th>
                  <th scope="col">ชื่อลูกหนี้</th>
                  <th scope="col">ยอดคงค้าง</th>
                </tr>
              </thead>
              <tbody>
                <?php
                  $sum_totalthis = 0;
                 ?>
                @foreach ($supplier_aps  as $key => $supplier_ap)
                  <tr>
                    <td>{{ $supplier_ap->codecreditor }}</td>
                    <td>{{ $supplier_ap->pre }} {{ $supplier_ap->name_supplier }}</td>
                    <td>
                        <?php $keep_totalsum = number_format($supplier_ap->totalsumreal2,2,".",",");
                              echo $keep_totalsum;
                        ?>
                        <?php $sum_totalthis += $supplier_ap->totalsumreal2;?>
                    </td>
                  </tr>

                @endforeach
              </tbody>
              <tfoot>
                <tr>
                  <th colspan="2" style="vertical-align : middle;text-align:center;"><b>รวมทั้งสิ้น</b></th>
                  <td>
                        <?php $sum_total_show = number_format($sum_totalthis,2,".",",");
                              echo $sum_total_show;
                        ?>
                  </td>
                </tr>
              </tfoot>
            </table>

          <?php endif; ?>


        </div>
      </div>
      <!-- end row -->
    </div>
    <!-- END container-fluid -->
  </div>
  <!-- END content -->







</div>
<!-- END content-page -->
<!-- END main -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script>
$(document).ready(function() {
    $('.select2').select2();
});
</script>
<script type="text/javascript" src = 'js/accountjs/buysteel.js'></script>
@endsection
