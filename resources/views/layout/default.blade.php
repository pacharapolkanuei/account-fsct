<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Account - FSCT</title>
	<!-- Favicon -->
	<link rel="shortcut icon" href="assets/images/favicon.ico">
	<!-- Bootstrap CSS -->
	<link href="{{ URL::asset('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
	<!-- Font Awesome CSS -->
	<link href="{{ URL::asset('font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ URL::asset('font-awesome/fonts/fontSARABUN.css') }}" rel="stylesheet" type="text/css" />
	<!-- Custom CSS -->
	<link href="{{ URL::asset('css/style.css') }}" rel="stylesheet" type="text/css" />
	<!-- BEGIN CSS for this page -->
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap4.min.css" />
	<!-- END CSS for this page -->
	<link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.7.0/css/all.css' integrity='sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ' crossorigin='anonymous'>
	<link rel="stylesheet" href="{{ URL::asset('css/jquery.datetimepicker.css') }}" />
	<link href="{{ URL::asset('plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />

	<!-- date range & selectpicker -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
	<link href="{{ URL::asset('plugins/datetimepicker/css/daterangepicker.css') }}" rel="stylesheet" type="text/css"/>
</head>

<body class="adminbody">
	<div id="main">
		<!-- top bar navigation -->
		<div class="headerbar">
			<!-- LOGO -->
			<div class="headerbar-left">
				<a href="index.html" class="logo"><img src="" /> <span>FSCT</span></a>
			</div>
			<nav class="navbar-custom">
				<ul class="list-inline float-right mb-0">
					<li class="list-inline-item dropdown notif">
						<a class="nav-link dropdown-toggle nav-user" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
							<img src="" class="avatar-rounded">
						</a>
						<div class="dropdown-menu dropdown-menu-right profile-dropdown ">
							<!-- item-->
							<div class="dropdown-item noti-title">
								<h5 class="text-overflow"><small>
										<fonts id="fontsheader">สวัสดีคุณ ....</fonts>
									</small> </h5>
							</div>
							<!-- item-->
							<a href="pro-profile.html" class="dropdown-item notify-item">
								<i class="fa fa-user"></i> <span>
									<fonts id="fontsheader">โปรไฟล์</fonts>
								</span>
							</a>
							<!-- item-->
							<a href="#" class="dropdown-item notify-item">
								<i class="fa fa-power-off"></i> <span>
									<fonts id="fontsheader">ออกจากระบบ</fonts>
								</span>
							</a>
						</div>
					</li>
				</ul>
				<ul class="list-inline menu-left mb-0">
					<li class="float-left">
						<button class="button-menu-mobile open-left">
							<i class="fa fa-fw fa-bars"></i>
						</button>
					</li>
				</ul>
			</nav>
		</div>
		<!-- End Navigation -->
		<!-- Left Sidebar -->
		<!-- Left Sidebar -->
		<div class="left main-sidebar">
			<div class="sidebar-inner leftscroll">
				<div id="sidebar-menu">
					<ul>
						<li class="submenu">
							<a href="/" class="active"><i class="fa fa-fw fa-home"></i><span>
									<fonts id="fontsmenu"> หน้าหลัก </fonts>
								</span> </a>
						</li>

						<li class="submenu">
							<a href="#"><i class="fa fa-shopping-cart"></i><span>
									<fonts id="fontsmenu">จัดการข้อมูลซื้อ - ขาย</fonts>
								</span> <span class="menu-arrow"></span></a>
							<ul class="list-unstyled">
								<li><a href="/reserve_money" id="fontsmenu2"><i class="fa fa-shopping-cart"></i>จ่ายเงินสำรอง</a></li>
								<li><a href="/debt" id="fontsmenu2"><i class="fa fa-shopping-cart"></i>รายการตั้งหนี้</a></li>
								<li><a href="/payser" id="fontsmenu2"><i class="fa fa-shopping-cart"></i>แจ้งการจ่ายเงิน (สด / โอน)</a></li>
								<li><a href="/paycredit" id="fontsmenu2"><i class="fa fa-shopping-cart"></i>แจ้งการจ่ายเงินเชื่อ</a></li>
								<li><a href="/reportaccrued" id="fontsmenu2"><i class="fa fa-shopping-cart"></i>รายการค่าใช้จ่ายค้างจ่าย</a></li>
								<li class=""><a href="/pettycash" id="fontsmenu2"><i class="fa fa-shopping-cart"></i>ตั้งค่าวงเงินสดย่อย</a></li>
							</ul>
						</li>

						<li class="submenu">
							<a href="#"><i class="fa fa-fw fa-book"></i> <span>
									<fonts id="fontsmenu"> สมุดรายวันทั่วไป </fonts>
								</span> <span class="menu-arrow"></span></a>
							<ul class="list-unstyled">
								<li><a href="/journalbook" id="fontsmenu2"><i class="fa fa-book"></i>สมุดรายวันทั่วไป</a></li>
							</ul>
						</li>

						<li class="submenu">
							<a href="{{ route('bank.detail') }}" class=""><i class="fa fa-fw fa-table"></i><span>
									<fonts id="fontsmenu"> ข้อมูลธนาคาร </fonts>
								</span> </a>
						</li>
					</ul>
					<div class="clearfix"></div>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
		<!-- End Sidebar -->
		@yield('content')
		<!-- END main -->
		<script src="{{ URL::asset('js/modernizr.min.js') }}"></script>
		<script src="{{ URL::asset('js/jquery.min.js') }}"></script>
		<script src="{{ URL::asset('js/moment.min.js') }}"></script>

		<script src="{{ URL::asset('js/popper.min.js') }}"></script>
		<script src="{{ URL::asset('js/bootstrap.min.js') }}"></script>

		<script src="{{ URL::asset('js/detect.js') }}"></script>
		<script src="{{ URL::asset('js/fastclick.js') }}"></script>
		<script src="{{ URL::asset('js/jquery.blockUI.js') }}"></script>
		<script src="{{ URL::asset('js/jquery.nicescroll.js') }}"></script>
		<script src="{{ URL::asset('js/jquery.datetimepicker.full.js') }}"></script>
		<!-- App js -->
		<script src="{{ URL::asset('js/pikeadmin.js') }}"></script>
		<!-- BEGIN Java Script for this page -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
		<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
		<script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>
		<!-- Counter-Up-->
		<script src="{{ URL::asset('plugins/waypoints/lib/jquery.waypoints.min.js') }}"></script>
		<script src="{{ URL::asset('plugins/counterup/jquery.counterup.min.js') }}"></script>
		<script src="{{ URL::asset('plugins/select2/js/select2.min.js') }}"></script>

		<!-- -date range  & selectpicker -->
		<script src="{{ URL::asset('plugins/datetimepicker/js/moment.min.js') }}"></script>
		<script src="{{ URL::asset('plugins/datetimepicker/js/daterangepicker.js') }}"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>

		<script type="text/javascript">
			$(function() {
				$.datetimepicker.setLocale('th'); // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
				// กรณีใช้แบบ inline
				$("#testdate4").datetimepicker({
					timepicker: false,
					format: 'd-m-Y', // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00-00-0000
					lang: 'th', // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
					inline: true
				});
				// กรณีใช้แบบ input
				$("#testdate5").datetimepicker({
					timepicker: false,
					format: 'd-m-Y', // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00-00-0000
					lang: 'th', // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
					onSelectDate: function(dp, $input) {
						var yearT = new Date(dp).getFullYear() - 0;
						var yearTH = yearT + 543;
						var fulldate = $input.val();
						var fulldateTH = fulldate.replace(yearT, yearTH);
						$input.val(fulldateTH);
					},
				});
				// กรณีใช้กับ input ต้องกำหนดส่วนนี้ด้วยเสมอ เพื่อปรับปีให้เป็น ค.ศ. ก่อนแสดงปฏิทิน
				$("#testdate5").on("mouseenter mouseleave", function(e) {
					var dateValue = $(this).val();
					if (dateValue != "") {
						var arr_date = dateValue.split("-"); // ถ้าใช้ตัวแบ่งรูปแบบอื่น ให้เปลี่ยนเป็นตามรูปแบบนั้น
						// ในที่นี้อยู่ในรูปแบบ 00-00-0000 เป็น d-m-Y  แบ่งด่วย - ดังนั้น ตัวแปรที่เป็นปี จะอยู่ใน array
						//  ตัวที่สอง arr_date[2] โดยเริ่มนับจาก 0
						if (e.type == "mouseenter") {
							var yearT = arr_date[2] - 543;
						}
						if (e.type == "mouseleave") {
							var yearT = parseInt(arr_date[2]) + 543;
						}
						dateValue = dateValue.replace(arr_date[2], yearT);
						$(this).val(dateValue);
					}
				});
			});
		</script>

		<script type="text/javascript" src='js/accountjs/debt.js'></script>
</body>

</html>
