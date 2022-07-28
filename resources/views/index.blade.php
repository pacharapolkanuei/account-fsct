<?php
use App\Api\Connectdb;
     $emp_code = Session::get('emp_code');
     $fullname = Session::get('fullname');
     $position = Session::get('position');
     $brcode   = Session::get('brcode');
     $level_emp  = Session::get('level_emp');
     $section_id  = Session::get('section_id');
?>
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
										<fonts id="fontsheader"></fonts>
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
									<fonts id="fontsmenu">ระบบซื้อ</fonts>
								</span> <span class="menu-arrow"></span></a>
							<ul class="list-unstyled">
								<!-- <li><a href="/reserve_money" id="fontsmenu2"><i class="fa fa-shopping-cart"></i>จ่ายเงินสำรอง</a></li>
								<li><a href="/debt" id="fontsmenu2"><i class="fa fa-shopping-cart"></i>รายการตั้งหนี้</a></li>
								<li><a href="/payser" id="fontsmenu2"><i class="fa fa-shopping-cart"></i>แจ้งการจ่ายเงิน (สด / โอน)</a></li>
								<li><a href="/reportaccrued" id="fontsmenu2"><i class="fa fa-shopping-cart"></i>รายการค่าใช้จ่ายค้างจ่าย</a></li>
								<li class=""><a href="/pettycash" id="fontsmenu2"><i class="fa fa-shopping-cart"></i>ตั้งค่าวงเงินสดย่อย</a></li> -->
								<li><a href="/account-fsct/public/reserve_money" id="fontsmenu2">ตั้งเบิกเงินสำรองจ่าย</a></li>
								<li><a href="/account-fsct/public/reserve_moneyto" id="fontsmenu2">จ่ายเงินสำรอง</a></li>
								<li><a href="/account-fsct/public/debt" id="fontsmenu2">รายการตั้งหนี้</a></li>
								<!-- <li><a href="/reportaccrued" id="fontsmenu2">รายการค่าใช้จ่ายค้างจ่าย</a></li> -->
								<li><a href="/account-fsct/public/payser" id="fontsmenu2">แจ้งการจ่ายเงิน (สด / โอน)</a></li>
								<li><a href="/account-fsct/public/paycredit" id="fontsmenu2">แจ้งการจ่ายเงิน (เชื่อ)</a></li>
								<li><a href="/account-fsct/public/pettycash" id="fontsmenu2">ตั้งค่าวงเงินสดย่อย</a></li>
							</ul>
						</li>

						<!-- <li class="submenu">
							<a href="#"><i class="fa fa-shopping-cart"></i><span>
									<fonts id="fontsmenu">ระบบขาย</fonts>
								</span> <span class="menu-arrow"></span></a>
							<ul class="list-unstyled">
								<li><a href="/" id="fontsmenu2"></a></li>
							</ul>
						</li> -->

						<li class="submenu">
							<a href="#"><i class="fa fa-fw fa-book"></i><span>
									<fonts id="fontsmenu">ทรัพย์สินและค่าเสื่อม</fonts>
								</span> <span class="menu-arrow"></span></a>
							<ul class="list-unstyled">
								<li><a href="/account-fsct/public/define_property" id="fontsmenu2">กลุ่มบัญชีทรัพย์สิน</a></li>
								<li><a href="/account-fsct/public/asset_list" id="fontsmenu2">เพิ่มรายการทรัพย์สิน</a></li>
                <li class="submenu">
                    <a href="#" id="fontsmenu2"><span>รายการต้นทุนแบบเหล็ก(ซื้อสำเร็จรูป)</span> <span class="menu-arrow"></span> </a>
                        <ul style="">
                            <li><a href="/account-fsct/public/buysteel" id="fontsmenu2">เพิ่มรายการต้นทุนแบบเหล็ก(ซื้อสำเร็จรูป)</a></li>
                            <li><a href="/account-fsct/public/asset_approve_innsert_tool" id="fontsmenu2">อนุมัติรายการต้นทุนแบบเหล็ก(ซื้อสำเร็จรูป)</a></li>
                        </ul>
                </li>
                <li class="submenu">
                    <a href="#" id="fontsmenu2"><span>เพิ่มรายการต้นทุนแบบเหล็ก(ซื้อมาผลิต)</span> <span class="menu-arrow"></span> </a>
                        <ul style="">
                            <li><a href="/account-fsct/public/asset_product_tool" id="fontsmenu2">เพิ่มรายการต้นทุนแบบเหล็ก(ซื้อมาผลิต)</a></li>
                            <li><a href="/account-fsct/public/settingpotool" id="fontsmenu2">ใบ POวัตถุดิบ (ซื้อมาผลิต)</a></li>
                            <li><a href="/account-fsct/public/settingdmtool" id="fontsmenu2">ใบเบิกวัตถุดิบ (ซื้อมาผลิต)</a></li>
                            <li><a href="/account-fsct/public/settingsalaryemptool" id="fontsmenu2">ค่าแรงพนักงานผลิต (ซื้อมาผลิต)</a></li>
                            <li><a href="/account-fsct/public/settingtool" id="fontsmenu2">การจัดการชิ้นส่วนสินค่าให้เช่า(ซื้อมาผลิต)</a></li>
                        </ul>
                </li>

							</ul>
						</li>

						<li class="submenu">
							<a href="#"><i class="fa fa-fw fa-book"></i> <span>
									<fonts id="fontsmenu">สมุดรายวัน</fonts>
								</span> <span class="menu-arrow"></span></a>
							<ul class="list-unstyled">
								<li><a href="/account-fsct/public/journal_debt" id="fontsmenu2">สมุดรายวันซื้อ</a></li>
								<li class="submenu">
										<a href="#" id="fontsmenu2"><span>สมุดรายวันจ่าย</span> <span class="menu-arrow"></span> </a>
												<ul style="">
														<li><a href="/account-fsct/public/journal_pay" id="fontsmenu2"><span>สมุดรายวันจ่าย</span></a></li>
														<li><a href="/account-fsct/public/journal_pay_social" id="fontsmenu2"><span>สมุดรายวันจ่าย(ประกันสังคม)</span></a></li>
											 	</ul>
								</li>
								<li><a href="/account-fsct/public/journal_sale" id="fontsmenu2">สมุดรายวันขาย</a></li>
								<li><a href="/account-fsct/public/journal_income" id="fontsmenu2">สมุดรายวันรับ</a></li>
								<li class="submenu">
										<a href="#" id="fontsmenu2"><span>สมุดรายวันทั่วไป</span> <span class="menu-arrow"></span> </a>
												<ul style="">
														<li><a href="/account-fsct/public/journal_general1" id="fontsmenu2"><span>สมุดรายวันทั่วไป (กรณีขึ้นของเช่าทั่วไป)</span></a></li>
														<li><a href="/account-fsct/public/journal_general1_rentengine" id="fontsmenu2"><span>สมุดรายวันทั่วไป (กรณีขึ้นของเช่าเครื่องยนต์)</span></a></li>
														<li><a href="/account-fsct/public/journal_general2" id="fontsmenu2"><span>สมุดรายวันทั่วไป (กรณีคืนของเช่าทั่วไป)</span></a></li>
														<li><a href="/account-fsct/public/journal_general2_returnengine" id="fontsmenu2"><span>สมุดรายวันทั่วไป (กรณีคืนของเช่าเครื่องยนต์)</span></a></li>
														<!-- <li><a href="/account-fsct/public/journal_general3" id="fontsmenu2"><span>สมุดรายวันทั่วไป (กรณีของหาย)</span></a></li> -->
														<li><a href="/account-fsct/public/journal_general" id="fontsmenu2"><span>สมุดรายวันทั่วไป (ปรับปรุงรายการ)</span></a></li>
											 	</ul>
								</li>
							</ul>
						</li>

						<li class="submenu">
							<a href="#"><i class="fa fa-fw fa-book"></i><span>
									<fonts id="fontsmenu">ธนาคาร</fonts>
								</span> <span class="menu-arrow"></span></a>
							<ul class="list-unstyled">
								<li><a href="/account-fsct/public/bank.detail" id="fontsmenu2">ข้อมูลธนาคาร</a></li>
								<li><a href="/account-fsct/public/cheque" id="fontsmenu2">รับเช็คธนาคาร</a></li>
							</ul>
						</li>

						<!-- <li class="submenu">
							<a href="/account-fsct/public/ledger" class=""><i class="fa fa-money-check-alt"></i><span>
									<fonts id="fontsmenu"> ประเภทบัญชี </fonts>
								</span> </span> </a></a>
						</li> -->

						<li class="submenu">
							<a href="#"><i class="fa fa-fw fa-book"></i><span>
									<fonts id="fontsmenu">แยกประเภทบัญชี</fonts>
								</span> <span class="menu-arrow"></span></a>
							<ul class="list-unstyled">
								<li><a href="/account-fsct/public/ledger_branch" id="fontsmenu2">แยกประเภทบัญชี (รายสาขา)</a></li>
								<li><a href="/account-fsct/public/ledger_allbranch" id="fontsmenu2">แยกประเภทบัญชี (ทั้งหมด)</a></li>
							</ul>
						</li>

						<li class="submenu">
							<a href="#"><i class="fa fa-fw fa-book"></i><span>
									<fonts id="fontsmenu">งบทดลอง</fonts>
								</span> <span class="menu-arrow"></span></a>
							<ul class="list-unstyled">
								<li><a href="/account-fsct/public/trial_balance" id="fontsmenu2">งบทดลอง (รายสาขา)</a></li>
								<li><a href="/account-fsct/public/trial_allbalance" id="fontsmenu2">งบทดลอง (ทั้งหมด)</a></li>
							</ul>
						</li>

						<li class="submenu">
							<a href="#"><i class="fa fa-fw fa-book"></i><span>
									<fonts id="fontsmenu">งบทดลองหลังปิดบัญชี</fonts>
								</span> <span class="menu-arrow"></span></a>
							<ul class="list-unstyled">
								<li><a href="/account-fsct/public/trial_balance_after" id="fontsmenu2">งบทดลองหลังปิดบัญชี (รายสาขา)</a></li>
								<li><a href="/account-fsct/public/trial_allbalance_after" id="fontsmenu2">งบทดลองหลังปิดบัญชี (ทั้งหมด)</a></li>
							</ul>
						</li>

						<?php  if($emp_code == '1474'){ ?>
						<li class="submenu">
							<a href="#"><i class="fa fa-fw fa-book"></i><span>
									<fonts id="fontsmenu">กระดาษทำการ 10 ช่อง</fonts>
								</span> <span class="menu-arrow"></span></a>
							<ul class="list-unstyled">
								<li><a href="/account-fsct/public/working_papers" id="fontsmenu2">กระดาษทำการ 10 ช่อง (รายสาขา)</a></li>
								<li><a href="/account-fsct/public/working_allpapers" id="fontsmenu2">กระดาษทำการ 10 ช่อง (ทั้งหมด)</a></li>
							</ul>
						</li>
						<?php } ?>

						<li class="submenu">
							<a href="#"><i class="fa fa-fw fa-book"></i><span>
									<fonts id="fontsmenu">งบกำไรขาดทุน</fonts>
								</span> <span class="menu-arrow"></span></a>
							<ul class="list-unstyled">
								<li class="submenu">
										<a href="#" id="fontsmenu2"><span>งบกำไรขาดทุน (รายสาขา)</span> <span class="menu-arrow"></span> </a>
												<ul style="">
													<li><a href="/account-fsct/public/profitloss_statement_day" id="fontsmenu2">งบกำไรขาดทุน (รายวัน/รายเดือน)</a></li>
													<li><a href="/account-fsct/public/profitloss_statement_year" id="fontsmenu2">งบกำไรขาดทุน (รายปี)</a></li>
											 	</ul>
								</li>
								<li class="submenu">
										<a href="#" id="fontsmenu2"><span>งบกำไรขาดทุน (ทั้งหมด)</span> <span class="menu-arrow"></span> </a>
												<ul style="">
													<li><a href="/account-fsct/public/profitloss_statement_allday" id="fontsmenu2">งบกำไรขาดทุน (รายวัน/รายเดือน)</a></li>
													<li><a href="/account-fsct/public/profitloss_statement_allyear" id="fontsmenu2">งบกำไรขาดทุน (รายปี)</a></li>
											 	</ul>
								</li>
							</ul>
						</li>

						<li class="submenu">
							<a href="#"><i class="fa fa-fw fa-book"></i><span>
									<fonts id="fontsmenu">งบแสดงฐานะการเงิน</fonts>
								</span> <span class="menu-arrow"></span></a>
							<ul class="list-unstyled">
								<li class="submenu">
										<a href="#" id="fontsmenu2"><span>งบแสดงฐานะการเงิน (รายสาขา)</span> <span class="menu-arrow"></span> </a>
												<ul style="">
													<li><a href="/account-fsct/public/financial_statement_day" id="fontsmenu2">งบแสดงฐานะการเงิน (รายวัน/รายเดือน)</a></li>
													<li><a href="/account-fsct/public/financial_statement_year" id="fontsmenu2">งบแสดงฐานะการเงิน (รายปี)</a></li>
												</ul>
								</li>
								<li class="submenu">
										<a href="#" id="fontsmenu2"><span>งบแสดงฐานะการเงิน (ทั้งหมด)</span> <span class="menu-arrow"></span> </a>
												<ul style="">
													<li><a href="/account-fsct/public/financial_statement_allday" id="fontsmenu2">งบแสดงฐานะการเงิน (รายวัน/รายเดือน)</a></li>
													<li><a href="/account-fsct/public/financial_statement_allyear" id="fontsmenu2">งบแสดงฐานะการเงิน (รายปี)</a></li>
												</ul>
								</li>
							</ul>
						</li>

						<li class="submenu">
							<a href="#"><i class="fa fa-fw fa-book"></i><span>
									<fonts id="fontsmenu">รายงานต่างๆ</fonts>
								</span> <span class="menu-arrow"></span></a>
							<ul class="list-unstyled">
								<li><a href="/account-fsct/public/reporttaxbuy" id="fontsmenu2">รายงานภาษีซื้อ</a></li>
								<li><a href="/account-fsct/public/reportaccruedall" id="fontsmenu2">รายงานเจ้าหนี้การค้า (ทั้งหมด)</a></li>
								<li><a href="/account-fsct/public/reportaccrued" id="fontsmenu2">รายงานเจ้าหนี้การค้า (ค้างจ่าย)</a></li>
								<li><a href="/account-fsct/public/reportaccruedtransfer" id="fontsmenu2">รายงานเจ้าหนี้การค้า (โอนแล้ว)</a></li>
								<li><a href="/account-fsct/public/reportpaycash" id="fontsmenu2">รายงานชำระค่าสินค้าและบริการ (เงินสด / เงินโอน)</a></li>
								<li><a href="/account-fsct/public/reportpaycredit" id="fontsmenu2">รายงานชำระค่าสินค้าและบริการ (เงินเชื่อ)</a></li>
							</ul>
						</li>

            @if($level_emp == 1 || $level_emp == 7 || $level_emp == 15)
            <li class="submenu">
							<a href="#"><i class="fa fa-fw fa-book"></i><span>
									<fonts id="fontsmenu">แก้ไข</fonts>
								</span> <span class="menu-arrow"></span></a>
							<ul class="list-unstyled">
								<li><a href="/account-fsct/public/percent_main_cost" id="fontsmenu2">แก้ไขเปอร์เซ็นค่าบริหารกลาง</a></li>
							</ul>
						</li>

            @endif

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


</body>

</html>
