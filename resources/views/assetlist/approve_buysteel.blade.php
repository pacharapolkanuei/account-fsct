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
                                  <li class="breadcrumb-item active">อนุมัติรายการต้นทุนแบบเหล็ก(ซื้อสำเร็จรูป)</li>
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
                            <fonts id="fontsheader">อนุมัติรายการต้นทุนแบบเหล็ก(ซื้อสำเร็จรูป)</fonts>
                          </h3>
                        </div>
                        </div><!-- end card-->

                                <div >
                                  <div class="table-responsive">
                                    <table id="example" class="table table-striped table-bordered fontslabel" style="width:100%">
                                      <thead>
                                        <tr>
                                          <th>ลำดับ</th>
                                          <th>วันที่ผลิตเสร็จ</th>
                                          <th>เลขที่บิล</th>
                                          <th>เลขที่ PO</th>
                                          <th>LOT</th>
                                          <th>รวมต้นทุนการผลิต</th>
                                          <th>สถานะ</th>
                                          <th>พิมพ์</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                        @foreach ($receiptassets as $key => $receiptasset)
                                        <tr>
                                          <td>{{ $key+1 }}</td>
                                          <td>{{ $receiptasset->datein }}</td>
                                          <td>{{ $receiptasset->receiptnum}}</td>
                                          <td>{{ $receiptasset->po_number}}</td>
                                          <td>{{ $receiptasset->lot}}</td>
                                          <td>{{ $receiptasset->totalall}}</td>
                                          <td>
                                            @if($receiptasset->status == 0)
                                            {!! Form::open(['route' => 'approve_buysteel_confirm', 'method' => 'post']) !!}
                                              <input type="hidden" name="receiptasset_id[]" value="{{$receiptasset->id}}">
                                              <button type="submit" class="btn btn-warning">อนุมัติ</button>
                                            {!! Form::close() !!}
                                            @else
                                              <button class="btn btn-success">อนุมัติแล้ว</button>
                                            @endif
                                          </td>
                                          <td><a href="{{ route ('approve_buysteelpdf', ['id' => $receiptasset->id]) }}"><img src="images/global/printall.png"></a></td>
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


  <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script> -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  <script>
      $(document).ready(function() {
      $('#example').DataTable();
      } );
  </script>
@endsection
