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

<style media="screen">
  tr.group,
  tr.group:hover {
    background-color: #ddd !important;
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
                                  <li class="breadcrumb-item active">ต้นทุนแบบเหล็ก(ซื้อสำเร็จรูป)</li>
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
                            <fonts id="fontsheader">ต้นทุนแบบเหล็ก(ซื้อสำเร็จรูป)</fonts>
                          </h3>
                        </div>
                        </div><!-- end card-->

                                <!-- Button to Open the Modal -->
                                <div>
                                  <button type="button" class="btn btn-primary" data-toggle="modal" style="float: right;margin: 0px 12px 10px 10px;" data-target="#myModal">
                                    <i class="fas fa-plus">
                                      <fonts id="fontscontent">เพิ่มข้อมูล
                                    </i>
                                  </button>
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
                                  <div class="modal-dialog modal-xl" style="max-width: 80%;">
                                    <div class="modal-content">

                                      <!-- Modal Header -->
                                      <div class="modal-header">
                                        <h4 class="modal-title" id="fontscontent2"><b>ต้นทุนแบบเหล็ก(ซื้อสำเร็จรูป)</b></h4>
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

                                                {!! Form::open(['route' => 'buysteel.store', 'method' => 'post' ]) !!}
                                                  {{ csrf_field() }}
                                                <?php
                                                  $level_id = Session::get('emp_code');
                                                  // echo $level_id;
                                                ?>
                                                <input type="hidden" name="get_emp" value="{{ $level_id }}">

                                                <div class="was-validated form-inline" style="margin: 10px 50px 0px 50px;">
                                                  <!-- <div class="col-sm-6"> -->
                                                  <div class="row">
                                                    <label class="mb-2 mr-sm-2" id="fontslabel" for=""><b>Lot :</b></label>
                                                    <input type="text" class="form-control mb-2 mr-sm-2" name="lotnumber"required>

                                                    &nbsp;&nbsp;<label class="mb-2 mr-sm-2" id="fontslabel" for=""><b>วันที่เริ่มใช้งาน :</b></label>
                                                    <input type="date" autocomplete="off" class="form-control mb-2 mr-sm-2" name="datenow" required>

                                                    &nbsp;&nbsp;<label class="mb-2 mr-sm-2" id="fontslabel" for=""><b>เลือก PO :</b></label>
                                                    <select class="form-control mb-2 mr-sm-2" id="modal-input-branch" name="po_id" onchange="select_po(this)">
                                                      <option disabled selected>เลือก PO</option>
                                                      @foreach ($po_heads as $key => $po_head)
                                                      <option value="{{$po_head->id}}">{{$po_head->po_number}}</option>
                                                      @endforeach
                                                    </select>

                                                    <!-- &nbsp;&nbsp;<label class="mb-2 mr-sm-2" for="modal-input-priceservice" id="fontslabel"><b>PO :</b></label>
                                                    <input type="date" autocomplete="off" class="form-control mb-2 mr-sm-2" name="search1" required>
                                                    <input type="text" class="form-controller" id="search" name="search"></input>
                                                    <br> -->

                                                  </div>
                                                  <!-- </div> -->

                                                  <!-- <div id="show_po">
                                                  </div> -->
                                                </div>
                                                <br>

                                                <div class="container1">
                                                </div>


                                                <!-- <div style="padding: 10px 0px 0px 0px;">
                                                  <div class="table-responsive">
                                                    <table class="table">
                                                      <thead class="thead-light" id="fontstable">
                                                          <th width="20%" style="text-align: center;">รายการ</th>
                                                          <th width="11.6%" style="text-align: center;">ผลิตได้(ชิ้น)</th>
                                                          <th width="11.6%" style="text-align: center;">ราคาทุนวัตถุดิบ(ต่อชิ้น)</th>
                                                          <th width="11.6%" style="text-align: center;">ต้นทุนวัตถุดิบที่ใช้(รวม)</th>
                                                          <th width="11.6%" style="text-align: center;">เงินเดือน/ค่าแรงในการผลิต</th>
                                                          <th width="11.6%" style="text-align: center;">รวมต้นทุนการผลิต</th>
                                                          <th width="11.6%" style="text-align: center;">ต้นทุนการผลิตต่อหน่วย</th>
                                                          <th width="10%" style="text-align: center;"><button class="btn-primary add_form_field" type="button">เพิ่มข้อมูล</button></th>
                                                      </thead>

                                                      <tbody class="container11">

                                                      </tbody>

                                                      <tfoot>
                                                        <tr>
                                                          <th style="text-align: right;" id="fontstable">รวม</th>
                                                          <th style="text-align: right;"><input type="text" name="produce_sum" id="produces" class="form-control" readonly></th>
                                                          <th style="text-align: right;"><input type="text" name="material_cost_sum" id="material_costs" class="form-control" readonly></th>
                                                          <th style="text-align: right;"><input type="text" name="total_cost_sum" id="total_costs" class="form-control" readonly></th>
                                                          <th style="text-align: right;"><input type="text" name="salary_sum" id="salarys" class="form-control" readonly></th>
                                                          <th style="text-align: right;"><input type="text" name="total_produce_sum" id="total_produces" class="form-control" readonly></th>
                                                          <th style="text-align: right;"><input type="text" name="produce_unit_sum" id="produce_units" class="form-control" readonly></th>
                                                          <th></th>
                                                        </tr>
                                                      </tfoot>
                                                    </table>
                                                  </div>
                                                </div> -->



                                                <br>
                                                <div style="padding: 10px 50px 0px 50px;" id="table-po">
                                                  <div class="table-responsive">
                                                    <table class="table">
                                                      <thead class="thead-light">
                                                        <tr>
                                                          <th id="fontstable" width="5%" style="text-align: center;">ลำดับ</th>
                                                          <th id="fontstable" width="30%" style="text-align: center;">รายการ</th>
                                                          <th id="fontstable" width="16.25%" style="text-align: center;">ผลิตได้(ชิ้น)</th>
                                                          <th id="fontstable" width="16.25%" style="text-align: center;">ราคาทุนวัตถุดิบ(ต่อชิ้น)</th>
                                                          <th id="fontstable" width="16.25%" style="text-align: center;">ต้นทุนวัตถุดิบที่ใช้(รวม)</th>
                                                          <th id="fontstable" width="16.25%" style="text-align: center;">ต้นทุนการผลิตต่อหน่วย</th>
                                                        </tr>
                                                      </thead>
                                                      <tbody id="po_content">

                                                      </tbody>
                                                      <tfoot>
                                                        <tr>
                                                          <th></th>
                                                          <th></th>
                                                          <th></th>
                                                          <th id="fontstable" style="text-align: right;">รวม</th>
                                                          <th><input type="text" name="sum_col" id="sum_col" class="form-control" readonly></th>
                                                          <td></td>
                                                        </tr>
                                                      </tfoot>
                                                    </table>
                                                  </div>
                                                </div>






                                      </div>

                                      <!-- Modal footer -->

                                      <div class="modal-footer">
                                        <a href="{{route('paycredit')}}">
                                      {!! Form::submit('บันทึก', ['class' => 'btn btn-success', 'style' => 'dispaly: inline']) !!}
                                        <button type="button" class="btn btn-warning" data-dismiss="modal">ยกเลิก</button>
                                        </a>
                                      </div>


                                    </div>
                                  </div>
                                </div>
                                {!! Form::close() !!}

                                <div >
                                  <div class="table-responsive" id="fontstable">
                                    <table id="example" class="display" cellspacing="0" width="100%">
                                      <thead>
                                        <tr>
                                          <th>ลำดับ</th>
                                          <th>LOT</th>
                                          <th>รายการ</th>
                                          <th>ผลิตได้(ชิ้น)</th>
                                          <th>ราคาทุนวัตถุดิบ(ต่อชิ้น)</th>
                                          <th>ต้นทุนวัตถุดิบที่ใช้(รวม)</th>
                                          <th>เงินเดือน/ค่าแรงในการผลิต</th>
                                          <th>รวมต้นทุนการผลิต</th>
                                          <th>ต้นทุนการผลิตต่อหน่วย</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                        @foreach ($receiptasset_details as $key => $receiptasset_detail)
                                        <tr>
                                          <td>{{ $key+1 }}</td>
                                          <td>{{ $receiptasset_detail->lot}}</td>
                                          <td>{{ $receiptasset_detail->material_name}}</td>
                                          <td>{{ $receiptasset_detail->produce}}</td>
                                          <td>{{ $receiptasset_detail->cost}}</td>
                                          <td>{{ $receiptasset_detail->total_cost}}</td>
                                          <td>{{ $receiptasset_detail->saraly}}</td>
                                          <td>{{ $receiptasset_detail->total_cost_produce}}</td>
                                          <td>{{ $receiptasset_detail->cost_produce_unit}}</td>
                                        </tr>
                                        @endforeach
                                      </tbody>
                                    </table>
                                    <br>
                                  </div>
                                </div>



                    </div>
      			<!-- END container-fluid -->
      		    </div>
      		<!-- END content -->
        </div>
      </div><!-- end card-->
  </div>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script> -->
  <script type="text/javascript" src = 'js/accountjs/buysteel.js'></script>
  <script>
  $(document).ready(function() {
    var table = $('#example').DataTable({
        "columnDefs": [
            { "visible": false, "targets": 1 }
        ],
        "order": [[ 1, 'asc' ]],
        "displayLength": 25,
        "drawCallback": function ( settings ) {
            var api = this.api();
            var rows = api.rows( {page:'current'} ).nodes();
            var last=null;

            api.column(1, {page:'current'} ).data().each( function ( group, i ) {
                if ( last !== group ) {
                    $(rows).eq( i ).before(
                        '<tr class="group"><td colspan="8">'+group+'</td></tr>'
                    );

                    last = group;
                }
            } );
        }
    } );

    // Order by the grouping
    $('#example tbody').on( 'click', 'tr.group', function () {
        var currentOrder = table.order()[0];
        if ( currentOrder[0] === 1 && currentOrder[1] === 'asc' ) {
            table.order( [ 1, 'desc' ] ).draw();
        }
        else {
            table.order( [ 1, 'asc' ] ).draw();
        }
    } );
  } );
  </script>

  <!-- <script type="text/javascript">
  $('#search').on('keyup',function(){
  $value = $(this).val();
  var e = window.event || e;
  var key = e.keyCode;
  if ($value && key != 32) {
    $.ajax({
    type : 'get',
    url : '{{URL::to('search')}}',
    data:{'search':$value},
    success:function(data){
    $('#show_po').html(data);
    }
    });
  }
  else {
    alert('กรุณากรอก PO!');
  }

  })
  </script>

  <script type="text/javascript">
  $.ajaxSetup({ headers: { 'csrftoken' : '{{ csrf_token() }}' } });
  </script> -->



@endsection
