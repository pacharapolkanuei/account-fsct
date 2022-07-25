<!DOCTYPE html>

<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account</title>

    <link href="{{ URL::asset('plugins/bootstrap/css/bootstrap.css') }}" rel="stylesheet" />

    <link href="{{ URL::asset('css/style.css') }}" rel="stylesheet" />

    <link href="{{ URL::asset('plugins/node-waves/waves.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('plugins/animate-css/animate.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('plugins/morrisjs/morris.css') }}" rel="stylesheet" />

    <link href="{{ URL::asset('css/themes/all-themes.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.js"></script>

  </head>
  <body class="theme-blue">

              <nav class="navbar">
                  <div class="container-fluid">
                      <div class="navbar-header">
                          <!--<a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>-->
                          <a href="javascript:void(0);" class="bars"></a>
                          <a class="navbar-brand" href="#">Accont - FSCT</a>
                      </div>
                  </div>
              </nav>


              <section>
                  <!-- Left Sidebar -->
                  <aside id="leftsidebar" class="sidebar">
                      <!-- User Info -->
                      <div class="user-info">
                          <div class="image">
                              <img src="images/user.png" width="48" height="48" alt="User" />
                          </div>
                          <div class="info-container">
                              <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">นายสม เต็มใจ</div>
                              <div class="email">ตำแหน่ง</div>

                              <!-- <div class="btn-group user-helper-dropdown">
                                  <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
                                  <ul class="dropdown-menu pull-right">
                                      <li><a href="javascript:void(0);"><i class="material-icons">person</i>Profile</a></li>
                                      <li role="separator" class="divider"></li>
                                      <li><a href="javascript:void(0);"><i class="material-icons">group</i>Followers</a></li>
                                      <li><a href="javascript:void(0);"><i class="material-icons">shopping_cart</i>Sales</a></li>
                                      <li><a href="javascript:void(0);"><i class="material-icons">favorite</i>Likes</a></li>
                                      <li role="separator" class="divider"></li>
                                      <li><a href="javascript:void(0);"><i class="material-icons">input</i>Sign Out</a></li>
                                  </ul>
                              </div> -->
                          </div>
                      </div>
                      <!-- #User Info -->
                      <!-- Menu -->
                      <div class="menu">
                          <ul class="list">
                              <li class="header"><h4>เมนูหลัก</h4></li>
                              <li>
                                  <a href="/">
                                      <i class="fa fa-file-text-o" style="font-size:36px"></i>
                                      <span>หน้าหลัก</span>
                                  </a>
                              </li>
                              <li class="active">
                                  <a href="/income_pay_book">
                                      <i class="fa fa-file-text-o" style="font-size:36px"></i>
                                      <span>สมุดรายวันทั่วไป</span>
                                  </a>
                              </li>
                              <li>
                                  <a href="/debt">
                                      <i class="fa fa-file-text-o" style="font-size:36px"></i>
                                      <span>รายการตั้งหนี้</span>
                                  </a>
                              </li>
                  </aside>
                  <!-- #END# Left Sidebar -->
              </section>

              <section class="content">
                  <div class="container-fluid">
                      <div class="block-header">
                          <h1>สมุดรายวันทั่วไป</h1>
                      </div>

                      <div class="row clearfix">
                          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                              <div class="card">
                                  <div class="header">
                                    
                                      <div class="col-md-5">
                                        <div class="input-group input-daterange">
                                            <input type="text" name="from_date" id="from_date" readonly class="form-control" />
                                            <div class="input-group-addon">to</div>
                                            <input type="text"  name="to_date" id="to_date" readonly class="form-control" />
                                        </div>
                                      </div>
                                       <div class="col-md-2">
                                        <button type="button" name="filter" id="filter" class="btn btn-info btn-sm">วันที่เลือก</button>
                                        <button type="button" name="refresh" id="refresh" class="btn btn-warning btn-sm">ล้างวันที่</button>
                                       </div>

                                    <br>
                                    <br>

                                     <p>จำนวน - <b><span id="total_records"></span></b> record</p>
                                    <div class="table-responsive">
                                     <table class="table table-striped table-bordered">
                                      <thead>
                                       <tr>
                                        <th>Date</th>
                                        <th>Lise</th>
                                        <th>Acc code</th>
                                        <th >Debit</th>
                                        <th>Credit</th>
                                       </tr>
                                      </thead>
                                      <tbody>

                                      </tbody>
                                     </table>
                                     {{ csrf_field() }}
                                    </div>



                                    <!-- <div class="container box">
                                     <div class="panel panel-default">
                                      <div class="panel-heading">
                                       <div class="row">
                                        <div class="col-md-5">Sample Data - Total Records - <b><span id="total_records"></span></b></div>
                                        <div class="col-md-5">
                                         <div class="input-group input-daterange">
                                             <input type="text" name="from_date" id="from_date" readonly class="form-control" />
                                             <div class="input-group-addon">to</div>
                                             <input type="text"  name="to_date" id="to_date" readonly class="form-control" />
                                         </div>
                                        </div>
                                        <div class="col-md-2">
                                         <button type="button" name="filter" id="filter" class="btn btn-info btn-sm">Filter</button>
                                         <button type="button" name="refresh" id="refresh" class="btn btn-warning btn-sm">Refresh</button>
                                        </div>
                                       </div>
                                      </div>
                                      <div class="panel-body">
                                       <div class="table-responsive">
                                        <table class="table table-striped table-bordered">
                                         <thead>
                                          <tr>
                                           <th width="35%">Date</th>
                                           <th width="50%">Lise</th>
                                           <th width="15%">Acc code</th>
                                           <th width="15%">Debit</th>
                                           <th width="15%">Credit</th>
                                          </tr>
                                         </thead>
                                         <tbody>

                                         </tbody>
                                        </table>
                                        {{ csrf_field() }}
                                       </div>
                                      </div>
                                     </div>
                                    </div> -->



                                  </div>
                              </div>
                          </div>
                      </div>
                    </div>
              </section>

              <!-- Jquery Core Js -->
              <!-- <script src="{{ URL::asset('plugins/jquery/jquery.min.js') }}"></script> -->
              <!-- Bootstrap Core Js -->
              <!-- <script src="{{ URL::asset('plugins/bootstrap/js/bootstrap.js') }}"></script> -->
              <!-- Waves Effect Plugin Js -->
              <script src="{{ URL::asset('plugins/node-waves/waves.js') }}"></script>
              <!-- Custom Js -->
              <script src="{{ URL::asset('js/admin.js') }}"></script>
              <script src="{{ URL::asset('plugins/jquery-slimscroll/jquery.slimscroll.js') }}"></script>

              <script>
              $(document).ready(function(){

               var date = new Date();

               $('.input-daterange').datepicker({
                todayBtn: 'linked',
                format: 'yyyy-mm-dd',
                autoclose: true
               });

               var _token = $('input[name="_token"]').val();

               fetch_data();

               function fetch_data(from_date = '', to_date = '')
               {
                $.ajax({
                 url:"{{ route('income_pay_book.fetch_data') }}",
                 method:"POST",
                 data:{from_date:from_date, to_date:to_date, _token:_token},
                 dataType:"json",
                 success:function(data)
                 {
                  var output = '';
                  $('#total_records').text(data.length);
                  for(var count = 0; count < data.length; count++)
                  {
                   output += '<tr>';
                   output += '<td>' + data[count].date + '</td>';
                   output += '<td>' + data[count].list + '</td>';
                   output += '<td>' + data[count].acc_code + '</td>';
                   output += '<td>' + data[count].debit + '</td>';
                   output += '<td>' + data[count].credit + '</td>';
                   output += '</tr>';
                  }
                  $('tbody').html(output);
                 }
                })
               }

               $('#filter').click(function(){
                var from_date = $('#from_date').val();
                var to_date = $('#to_date').val();
                if(from_date != '' &&  to_date != '')
                {
                 fetch_data(from_date, to_date);
                }
                else
                {
                 alert('โปรดเลือกวันที่');
                }
               });

               $('#refresh').click(function(){
                $('#from_date').val('');
                $('#to_date').val('');
                fetch_data();
               });


              });
              </script>

  </body>
</html>
