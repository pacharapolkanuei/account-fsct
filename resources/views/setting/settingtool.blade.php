@extends('index')
@section('content')
<script type="text/javascript" src="https://unpkg.com/sweetalert2@7.0.6/dist/sweetalert2.all.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
@if (Session::has('sweetalert.json'))
<script>
swal({!!Session::pull('sweetalert.json')!!});
</script>
@endif

<style>
.nav-tabs .nav-link.active, .nav-tabs .nav-item.show .nav-link {
    color: #495057;
    /* background-color: #9cc8f3 !important; */
    border-color: #dee2e6 #dee2e6 #fff;
    border-top: 10px solid #4fc28b !important;
    /* border-left: 10px solid #4fc28b !important; */
    /* border-right: 10px solid #4fc28b !important; */

}

.select2-container .select2-selection--single{
  height:40px !important;
}
.select2-container--default .select2-selection--single{
  border: 1px solid #ccc !important;
  border-radius: 0px !important;
}

.text-on-pannel {
  background: #fff none repeat scroll 0 0;
  height: auto;
  margin-left: 20px;
  padding: 3px 5px;
  position: absolute;
  margin-top: -47px;
  border: 1px solid #337ab7;
  border-radius: 8px;
}

.panel {
  /* for text on pannel */
  margin-top: 27px !important;
}

.panel-body {
  padding-top: 30px !important;
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
                                  <li class="breadcrumb-item">ตั้งค่าสินคา</li>
                                  <li class="breadcrumb-item active">การจัดการชิ้นส่วนสินค่าให้เช่า</li>
                                </ol>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                  </div>

               

  <!-- end iditmodal -->
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script type="text/javascript" src={{ asset('js/accountjs/asset_list1.js') }}></script>
  <script>
      $(document).ready(function() {
      $('#example').DataTable();
      $('#example1').DataTable();
      } );
  </script>
@endsection
