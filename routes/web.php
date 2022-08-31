<?php

Route::get('test', function () {
    return view('test');
});

use Illuminate\Support\Facades\Input;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//        return view('index');
// });


Route::get('/index', function () {
    // $data = Input::all();
    //
    // Session::put('fullname', $data['fullname']);
    // Session::put('position', $data['position']);
    // Session::put('brcode', $data['brcode']);
    // Session::put('emp_code', $data['emp_code']);
    // Session::put('id_position',$data['id_position']);
    // Session::put('level_emp', $data['level_emp']);
    // Session::put('level_id', $data['level_id']);


          $data = input::all();


          if(isset($data['idcompany']) && isset($data['brcode']) && isset($data['emp_code'])   && isset($data['id_position'])  &&   isset($data['level_emp'])  && isset($data['fullname'])){
            Session::put('idcompany', $data['idcompany']);
            Session::put('brcode', $data['brcode']);
            Session::put('emp_code', $data['emp_code']);
            Session::put('id_position', $data['id_position']);
            Session::put('level_emp', $data['level_emp']);
            Session::put('fullname', $data['fullname']);

          }else{
            $idcompany = Session::get('idcompany');
            $brcode = Session::get('brcode');
            $emp_code = Session::get('emp_code');
            $id_position = Session::get('id_position');
            $level_emp = Session::get('level_emp');
            $fullname= Session::get('fullname');


            Session::put('idcompany',$idcompany);
            Session::put('brcode',$brcode);
            Session::put('id_position',$id_position);
            Session::put('level_emp', $level_emp);
            Session::put('fullname', $fullname);
          }


    //
    // Session::put('idcompany', '1');
    // Session::put('brcode', '1001');
    // Session::put('emp_code', '1001');
    // Session::put('id_position', '1');//1
    // Session::put('level_emp', '1');//1
    // Session::put('level_id', '7');//1
    // Session::put('fullname', 'Boss');
    // Session::put('position', 'Boss');

    return view('index');
});


//! -------------------------Start จัดการข้อมูลซื้อ - ขาย----------------------------
// ---------------deb controller---------------------
Route::get('/debt', 'debtController@index')->name('debt'); //รายการตั้งหนี้
Route::post('/debt/store','debtController@store')->name('debt.store'); //บันทึกรายการตั้งหนี้
Route::get('/debtpdf/{id_debt}', 'debtController@pdf')->name('debtpdf');
Route::get('/debtpdfsupplier/{id_indebtsupplier}', 'debtController@pdfsupplier')->name('debtpdfsupplier');
Route::post('/debtconfirm', 'debtController@debtconfirm')->name('debtconfirm');
// ---------------deb controller---------------------

// ------------------bank controller--------------------
Route::get('/bank_detail', 'BankController@index')->name('bank.detail'); //แสดงรายธนาคารทั้งหมด
Route::patch('bank/update/{id}','BankController@update')->name('bank.update');//แก้ไขข้อมูลธนาคาร
Route::post('/Bank/store','BankController@store')->name('bank.store');
Route::get('/Bank/delete/{id}','BankController@delete')->name('Bank.delete');
// ------------------bank controller--------------------

// -------debt jquery-----------
Route::get('getbranchtouse/{branchcode}', 'debtController@getbranch');
Route::get('getterm/{po}', 'debtController@getterm');
Route::get('getpodetail/{po}', 'debtController@getpodetail');
// -------end debt jquery-----------

// ------------------pettycash controller--------------------
Route::get('/pettycash', 'PettycashController@index')->name('pettycash');
Route::get('/pettycash/{date}', 'PettycashController@show_somelist');
Route::post('/cash/store','PettycashController@store')->name('cash.store');
Route::patch('cash/update/{id}','PettycashController@update')->name('cash.update');
// ------------------pettycash controller--------------------

// ------------------payment controller--------------------
Route::get('payment', function () {
    return view('payment.payment');
});
// ------------------payment controller--------------------

// ------------------cheque controller--------------------
Route::get('/cheque', 'ChequeController@index')->name('cheque');
Route::get('/cheque/{id}', 'ChequeController@show')->name('cheque.detail');
Route::post('/cheque/store','chequeController@store')->name('cheque.store');
Route::get('/chequepdf', 'ChequeController@pdf')->name('chequepdf');
Route::post('/cheque/update_status','ChequeController@update_status')->name('cheque.update_status');
Route::patch('cheque/edit/{id}','ChequeController@edit')->name('cheque.edit');
// ------------------cheque controller--------------------

// ------------------ledger controller--------------------
Route::post('/ledger', 'LedgerController@store')->name('ledger.store');
// ------------------cheque controller--------------------

//---------------------------journal----------------------------------
Route::get('/journal','JournalController@index');
Route::post('/journal/store','JournalController@store')->name('journal.store');
//---------------------------journal----------------------------------

//---------------------------ledger----------------------------------
Route::get('/ledger','LedgerController@index')->name('ledger');
Route::get('/ledger/{id}','LedgerController@detail')->name('ledger.detail');
//---------------------------ledger----------------------------------

//---------------------------journal debt----------------------------------
Route::get('/journal_debt','Journal_debtController@index')->name('journal.debt');
Route::get('/debtcancel/{getidindebt}','Journal_debtController@debtcancel')->name('debtcancel');
Route::post('/journal_debt/filter','Journal_debtController@journaldebt_filter')->name('journaldebt_filter');
Route::post('/confirm_journal_debt','Journal_debtController@confirm_journal_debt')->name('confirm_journal_debt');
//---------------------------journal debt----------------------------------

//---------------------------journal pay----------------------------------
Route::get('/journal_pay','Journal_payController@index')->name('journal.pay');
Route::post('/confirm_journal_pay','Journal_payController@confirm_journal_pay')->name('confirm_journal_pay');
Route::post('/journalpay_filter','Journal_payController@journalpay_filter')->name('journalpay_filter');
//---------------------------journal pay----------------------------------

//---------------------------journal pay social----------------------------------
Route::get('/journal_pay_social','Journal_pay_socialController@index')->name('journal.pay.socail');
Route::post('/confirm_journal_pay_social','Journal_pay_socialController@confirm_journal_pay_social')->name('confirm_journal_pay_social');
Route::post('/journalpay_filter_social','Journal_pay_socialController@journalpay_filter_social')->name('journalpay_filter_social');
//---------------------------journal pay----------------------------------

//---------------------------journal sale----------------------------------
Route::get('/journal_sale','Journal_saleController@index')->name('journal.sale');
Route::post('/confirm_journal_sale','Journal_saleController@confirm_journal_sale')->name('confirm_journal_sale');
Route::post('/journalsale_filter','Journal_saleController@journalsale_filter')->name('journalsale_filter');
//---------------------------journal sale----------------------------------


//---------------------------journal general(ปรับปรุง)-------------------------------
Route::get('/journal_general','JournalGeneralController@index')->name('journal.general');
Route::post('/journal_general/store','JournalGeneralController@store')->name('journal.store');
Route::post('/journalgeneral_filter','JournalGeneralController@journalgeneral_filter')->name('journalgeneral_filter');
Route::get('getaccountname', 'JournalGeneralController@getaccountname');
Route::post('/confirm_journal_general','JournalGeneralController@confirm_journal_general')->name('confirm_journal_general');

Route::get('getbranch/{idbranch}', 'JournalGeneralController@getbranch');
Route::get('/journal_general/deleteUpdate/{id}', 'JournalGeneralController@deleteUpdate');

Route::get('getjournalgeneraledit/{id}', 'JournalGeneralController@getjournalgeneraledit');
Route::patch('/journal_general/update','JournalGeneralController@update')->name('journal_general.update');
//-------------------------------------------------------------------------

//---------------------------journal general(ขึ้นของ)-------------------------------
Route::get('/journal_general1','JournalGeneral1Controller@index')->name('journal.general1');
Route::post('/confirm_journal_general1','JournalGeneral1Controller@confirm_journal_general1')->name('confirm_journal_general1');
// Route::post('/confirm_journal_general2','JournalGeneral1Controller@confirm_journal_general2')->name('confirm_journal_general2');
Route::post('/journal_generalfilter1','JournalGeneral1Controller@journal_generalfilter1')->name('journal_generalfilter1');

//---------------------------journal general(กรณีขึ้นของเช่าเครื่องยนต์)-------------------------------
Route::get('/journal_general1_rentengine','Journal_general1_rentengineController@index')->name('journal.general1_rentengine');
Route::post('/confirm_journal_general2','Journal_general1_rentengineController@confirm_journal_general2')->name('confirm_journal_general2');
Route::post('/journal_generalfilter2','Journal_general1_rentengineController@journal_generalfilter2')->name('journal_generalfilter2');

// Route::post('/journal_general/store','JournalGeneralController@store')->name('journal.store');
// Route::post('/journalgeneral_filter','JournalGeneralController@journalgeneral_filter')->name('journalgeneral_filter');
// Route::get('getaccountname', 'JournalGeneralController@getaccountname');
//
// Route::get('getbranch/{idbranch}', 'JournalGeneralController@getbranch');
// Route::get('/journal_general/deleteUpdate/{id}', 'JournalGeneralController@deleteUpdate');
//
// Route::get('getjournalgeneraledit/{id}', 'JournalGeneralController@getjournalgeneraledit');
// Route::patch('/journal_general/update','JournalGeneralController@update')->name('journal_general.update');
//---------------------------journal general(คืนของ)-------------------------------
Route::get('/journal_general2','JournalGeneral2Controller@index')->name('journal.general2');
Route::post('/confirm_journal_general3','JournalGeneral2Controller@confirm_journal_general3')->name('confirm_journal_general3');
Route::post('/journal_generalfilter3','JournalGeneral2Controller@journal_generalfilter3')->name('journal_generalfilter3');
//-------------------------------------------------------------------------
//---------------------------journal general(คืนของเช่าเครื่องยนต์)-------------------------------
Route::get('/journal_general2_returnengine','Journal_general2_returnengineController@index')->name('journal.general2_returnengine');
Route::post('/confirm_journal_general4','Journal_general2_returnengineController@confirm_journal_general4')->name('confirm_journal_general4');
Route::post('/journal_generalfilter4','Journal_general2_returnengineController@journal_generalfilter4')->name('journal_generalfilter4');
//---------------------------journal general(ของหาย)--------------------------
Route::get('/journal_general3','JournalGeneral3Controller@index')->name('journal.general3');
Route::post('/confirm_journal_general5','JournalGeneral3Controller@confirm_journal_general5')->name('confirm_journal_general5');

//-------------------------------------------------------------------------


//---------------------------journal income----------------------------------
// Route::get('/journal_income','Journal_incomeController@index')->name('journal.income');
// Route::post('/journal_income/filter','Journal_incomeController@journalincome_filter')->name('journalincome_filter');
// Route::post('/confirm_journalincome','Journal_incomeController@confirm_journalincome')->name('confirm_journalincome');

Route::get('/journal_income','Journal_incomeController@journal_income');
Route::post('serachjournal_income', 'Journal_incomeController@serachjournal_income');

Route::post('/journalincome_filter','Journal_incomeController@journalincome_filter')->name('journalincome_filter');

//---------------------------journal income----------------------------------


Route::get('/reserve_money','BuyController@reserve_money'); //ตั้งเบิกเงินสำรองจ่าย

Route::post('savecash', 'BuyController@savecash'); //ตั้งเบิกเงินสำรองจ่าย

Route::post('/checkdetail','BuyController@checkdetail'); //ตั้งเบิกเงินสำรองจ่าย

Route::get('/reserve_moneyto','BuyController@reserve_moneyto'); //จ่ายเงินสำรอง

Route::post('savereservemoney', 'BuyController@savereservemoney'); //จ่ายเงินสำรอง

Route::get('/testcash','BuyController@testcash'); //จ่ายเงินสำรอง

Route::get('/getmainmaterialbyquotation','BuyController@getmainmaterialbyquotation'); //จ่ายเงินสำรอง

Route::get('reserve_money/updatereserve_withdraw/{id}','BuyController@updatereserve_withdraw')->name('reserve_money.updatereserve_withdraw');

Route::get('reserve_moneyto/updatereservemoney/{id}','BuyController@updatereservemoney')->name('reserve_moneyto.updatereservemoney');

Route::get('reserve_moneyto/recordreservemoney/{id}','BuyController@recordreservemoney')->name('reserve_moneyto.recordreservemoney');

Route::post('insertporef', 'BuyController@insertporef'); //แนบ PO

//! ---------------------------End จัดการข้อมูลซื้อ - ขาย---------------------------


//! ---------------------------Start แยกประเภท----------------------------------

// Route::get('/reportledgercash','LedgerController@reportledgercash'); //เงินสด
//
// Route::post('/serachreportledgercash','LedgerController@serachreportledgercash');

// Route::get('/excelreporttaxbuy','ExcelController@excelreporttaxbuy'); //เงินสด

Route::get('/reportledger','ReportLedgerController@reportledger'); //เงินสด

Route::post('/serachreportledger','ReportLedgerController@serachreportledger');


//! ---------------------------End แยกประเภท------------------------------------


//! ----------------------------- Start รายงาน ---------------------------------

Route::get('/reportaccrued','ReportController@reportaccrued'); //รายงานเจ้าหนี้การค้า (ค้างจ่าย)

Route::post('/serachreportaccrued','ReportController@serachreportaccrued'); //รายงานเจ้าหนี้การค้า (ค้างจ่าย)

Route::post('/saveapprovedpo','ReportController@saveapprovedpo');

Route::get('/excelreportaccrued','ExcelController@excelreportaccrued'); //รายงานเจ้าหนี้การค้า (ค้างจ่าย)

Route::get('/reportaccruedall','ReportController@reportaccruedall'); //รายงานเจ้าหนี้การค้า (ทั้งหมด)

Route::post('/serachreportaccruedall','ReportController@serachreportaccruedall'); //

Route::get('/excelreportaccruedall','ExcelController@excelreportaccruedall');// รายงานเจ้าหนี้การค้า (ทั้งหมด)

Route::get('/reportaccruedtransfer','ReportController@reportaccruedtransfer'); //รายงานเจ้าหนี้การค้า (โอนแล้ว)

Route::post('/serachreportaccruedtransfer','ReportController@serachreportaccruedtransfer');

Route::get('/excelreportaccruedtransfer','ExcelController@excelreportaccruedtransfer'); //รายงานเจ้าหนี้การค้า (โอนแล้ว)

Route::get('/reporttaxbuy','ReportController@reporttaxbuy'); //รายงานภาษีซื้อ

Route::post('/serachreporttaxbuy','ReportController@serachreporttaxbuy');

Route::get('/excelreporttaxbuy','ExcelController@excelreporttaxbuy'); //รายงานภาษีซื้อ

Route::get('/reportpaycash','ReportController@reportpaycash'); //รายงานชำระค่าสินค้าและบริการ (เงินสด/เงินโอน)

Route::post('/serachreportpaycash','ReportController@serachreportpaycash');

Route::get('/excelreportpaycash','ExcelController@excelreportpaycash'); //รายงานชำระค่าสินค้าและบริการ (เงินสด/เงินโอน)

Route::get('/reportpaycredit','ReportController@reportpaycredit'); //รายงานชำระค่าสินค้าและบริการ (เงินเชื่อ)

Route::post('/serachreportpaycredit','ReportController@serachreportpaycredit');

Route::get('/excelreportpaycredit','ExcelController@excelreportpaycredit'); //รายงานชำระค่าสินค้าและบริการ (เงินเชื่อ)

Route::get('/reportcustomercredit','ReportController@reportcustomercredit'); //รายงานลูกหนี้

Route::post('/serachreportcustomercredit','ReportController@serachreportcustomercredit');//ค้นหารายงานลูกหนี้


//! ----------------------------- End รายงาน -----------------------------------

//---------------------------ledger----------------------------------
Route::get('/ledger_branch','LedgerController@ledger_branch'); //แยกประเภทบัญชี (รายสาขา)

Route::post('/serachledger_branch','LedgerController@serachledger_branch'); //แยกประเภทบัญชี (รายสาขา)

Route::get('/printledger_branch', function () { //แยกประเภทบัญชี (รายสาขา)
    $data = Input::all();
	// print_r($data);

	  $pdf = PDF::loadView('printledger_branch', $data);
    return @$pdf->stream();
});

Route::get('/ledger_allbranch','LedgerController@ledger_allbranch'); //แยกประเภทบัญชี (ทั้งหมด)

Route::post('/serachledger_allbranch','LedgerController@serachledger_allbranch'); //แยกประเภทบัญชี (ทั้งหมด)
Route::post('/exportExcel', 'LedgerController@exportexcelledger');
Route::get('/printledger_allbranch', function () { //แยกประเภทบัญชี (ทั้งหมด)
    $data = Input::all();
	// print_r($data);

	  $pdf = PDF::loadView('printledger_allbranch', $data);
    return @$pdf->stream();
});

//---------------------------ledger----------------------------------


//---------------------------Trial_balance----------------------------------
Route::get('/trial_balance','Trial_balanceController@trial_balance'); //งบทดลอง (รายสาขา)

Route::post('/serachtrial_balance','Trial_balanceController@serachtrial_balance'); //งบทดลอง (รายสาขา)

Route::get('/printtrial_balance', function () { //งบทดลอง (รายสาขา)
    $data = Input::all();
	// print_r($data);

	$pdf = PDF::loadView('printtrial_balance', $data);
    return @$pdf->stream();
});

Route::get('/reportcustomercreditdetailpdf', function () { //งบทดลอง (รายสาขา)
    $data = Input::all();
	// print_r($data);

	$pdf = PDF::loadView('reportcustomercreditdetailpdf', $data);
    return @$pdf->stream();
});


Route::get('/trial_allbalance','Trial_balanceController@trial_allbalance'); //งบทดลอง (ทั้งหมด)

Route::get('/trial_balance_detail','Trial_balanceController@trial_balance_detail'); //งบทดลอง (ทั้งหมด)->(รายละเอียด)

Route::post('/serachtrial_allbalance','Trial_balanceController@serachtrial_allbalance'); //งบทดลอง (ทั้งหมด)

Route::get('/printtrial_allbalance', function () { //งบทดลอง (ทั้งหมด)
    $data = Input::all();
	// print_r($data);

	$pdf = PDF::loadView('printtrial_allbalance', $data);
    return @$pdf->stream();
});

Route::get('/printtrial_balance_detail', function () { //งบทดลอง (ทั้งหมด)
    $data = Input::all();
	// print_r($data);

	$pdf = PDF::loadView('printtrial_balance_detail', $data);
    return @$pdf->stream();
});

//---------------------------Trial_balance----------------------------------


//---------------------------Trial_balance_after--------------------------------
Route::get('/trial_balance_after','Trial_balanceController@trial_balance_after'); //งบทดลองหลังปิดบัญชี (รายสาขา)

Route::post('/serachtrial_balance_after','Trial_balanceController@serachtrial_balance_after'); //งบทดลองหลังปิดบัญชี (รายสาขา)

Route::get('/printtrial_balance_after', function () { //งบทดลองหลังปิดบัญชี (รายสาขา)
    $data = Input::all();
	// print_r($data);

	$pdf = PDF::loadView('printtrial_balance_after', $data);
    return @$pdf->stream();
});

Route::get('/trial_allbalance_after','Trial_balanceController@trial_allbalance_after'); //งบทดลองหลังปิดบัญชี (ทั้งหมด)

Route::get('/trial_balance_detail_after','Trial_balanceController@trial_balance_detail_after'); //งบทดลองหลังปิดบัญชี (ทั้งหมด)->(รายละเอียด)

Route::post('/serachtrial_allbalance_after','Trial_balanceController@serachtrial_allbalance_after'); //งบทดลองหลังปิดบัญชี (ทั้งหมด)

Route::get('/printtrial_allbalance_after', function () { //งบทดลองหลังปิดบัญชี (ทั้งหมด)
    $data = Input::all();
	// print_r($data);

	$pdf = PDF::loadView('printtrial_allbalance_after', $data);
    return @$pdf->stream();
});

Route::get('/printtrial_balance_detail_after', function () { //งบทดลองหลังปิดบัญชี (ทั้งหมด)
    $data = Input::all();
	// print_r($data);

	$pdf = PDF::loadView('printtrial_balance_detail_after', $data);
    return @$pdf->stream();
});

//---------------------------Trial_balance_after--------------------------------


//---------------------------Working_papers----------------------------------
Route::get('/working_papers','Working_papersController@working_papers'); //กระดาษทำการ 10 ช่อง (รายสาขา)

Route::post('/serachworking_papers','Working_papersController@serachworking_papers'); //กระดาษทำการ 10 ช่อง (รายสาขา)

Route::get('/printworking_papers', function () { //กระดาษทำการ 10 ช่อง (รายสาขา)
    $data = Input::all();
	// print_r($data);

	$pdf = PDF::loadView('printworking_papers', $data);
    return @$pdf->stream();
});

Route::get('/working_allpapers','Working_papersController@working_allpapers'); //กระดาษทำการ 10 ช่อง (ทั้งหมด)

Route::post('/serachworking_allpapers','Working_papersController@serachworking_allpapers'); //กระดาษทำการ 10 ช่อง (ทั้งหมด)

Route::get('/printworking_allpapers', function () { //กระดาษทำการ 10 ช่อง (ทั้งหมด)
    $data = Input::all();
	// print_r($data);

	$pdf = PDF::loadView('printworking_allpapers', $data);
    return @$pdf->stream();
});

//---------------------------Working_papers----------------------------------


//---------------------------Profitloss_statement-------------------------------
//งบกำไรขาดทุน (รายสาขา)
Route::get('/profitloss_statement_day','Profitloss_statementController@profitloss_statement_day'); //งบกำไรขาดทุน (รายวัน/รายเดือน)
Route::post('/serachprofitloss_statement_day','Profitloss_statementController@serachprofitloss_statement_day'); //งบกำไรขาดทุน (รายวัน/รายเดือน)
Route::get('/printprofitloss_statement_day', function () { //งบกำไรขาดทุน (รายวัน/รายเดือน)
    $data = Input::all();
	// print_r($data);

	$pdf = PDF::loadView('printprofitloss_statement_day', $data);
    return @$pdf->stream();
});

Route::get('/profitloss_statement_year','Profitloss_statementController@profitloss_statement_year'); //งบกำไรขาดทุน (รายปี)
Route::post('/serachprofitloss_statement_year','Profitloss_statementController@serachprofitloss_statement_year'); //งบกำไรขาดทุน (รายปี)
Route::get('/printprofitloss_statement_year', function () { //งบกำไรขาดทุน (รายปี)
    $data = Input::all();
	// print_r($data);

	$pdf = PDF::loadView('printprofitloss_statement_year', $data);
    return @$pdf->stream();
});

//------------detail--------------
Route::get('/income_sell_detail','Profitloss_statementController@income_sell_detail'); //รายได้จากการขายหรือการให้บริการ
Route::get('/income_other_detail','Profitloss_statementController@income_other_detail'); //รายได้อื่น
Route::get('/cost_of_sales_detail','Profitloss_statementController@cost_of_sales_detail'); //ต้นทุนขายหรือต้นทุนการให้บริการ
Route::get('/expenses_sales_detail','Profitloss_statementController@expenses_sales_detail'); //ค่าใช้จ่ายในการขาย
Route::get('/expenses_manage_detail','Profitloss_statementController@expenses_manage_detail'); //ค่าใช้จ่ายในการบริหาร
Route::get('/totalincome_detail','Profitloss_statementController@totalincome_detail'); //กำไร(ขาดทุน) ก่อนต้นทุนทางการเงินและค่าใช้จ่ายภาษีเงินได้
Route::get('/costs_finance_detail','Profitloss_statementController@costs_finance_detail'); //ต้นทุนทางการเงิน
Route::get('/totalsumincome_detail','Profitloss_statementController@totalsumincome_detail'); //กำไร(ขาดทุน) ก่อนค่าใช้จ่ายภาษีเงินได้
Route::get('/total_detail','Profitloss_statementController@total_detail'); //รวม detail
//------------detail--------------


//งบกำไรขาดทุน (ทั้งหมด)
Route::get('/profitloss_statement_allday','Profitloss_statementController@profitloss_statement_allday'); //งบกำไรขาดทุน (รายวัน/รายเดือน)
Route::post('/serachprofitloss_statement_allday','Profitloss_statementController@serachprofitloss_statement_allday'); //งบกำไรขาดทุน (รายวัน/รายเดือน)
Route::get('/printprofitloss_statement_allday', function () { //งบกำไรขาดทุน (รายวัน/รายเดือน)
    $data = Input::all();
	// print_r($data);

	$pdf = PDF::loadView('printprofitloss_statement_allday', $data);
    return @$pdf->stream();
});

Route::get('/profitloss_statement_allyear','Profitloss_statementController@profitloss_statement_allyear'); //งบกำไรขาดทุน (รายปี)
Route::post('/serachprofitloss_statement_allyear','Profitloss_statementController@serachprofitloss_statement_allyear'); //งบกำไรขาดทุน (รายปี)
Route::get('/printprofitloss_statement_allyear', function () { //งบกำไรขาดทุน (รายปี)
    $data = Input::all();
	// print_r($data);

	$pdf = PDF::loadView('printprofitloss_statement_allyear', $data);
    return @$pdf->stream();
});
//---------------------------Profitloss_statement-------------------------------


//---------------------------Financial_statement--------------------------------
//งบแสดงฐานะการเงิน (รายสาขา)
Route::get('/financial_statement_day','Financial_statementController@financial_statement_day'); //งบแสดงฐานะการเงิน (รายวัน/รายเดือน)
Route::post('/serachfinancial_statement_day','Financial_statementController@serachfinancial_statement_day'); //งบแสดงฐานะการเงิน (รายวัน/รายเดือน)
Route::get('/printfinancial_statement_day', function () { //งบแสดงฐานะการเงิน (รายวัน/รายเดือน)
    $data = Input::all();
	// print_r($data);

	$pdf = PDF::loadView('printfinancial_statement_day', $data);
    return @$pdf->stream();
});

Route::get('/financial_statement_year','Financial_statementController@financial_statement_year'); //งบแสดงฐานะการเงิน (รายปี)
Route::post('/serachfinancial_statement_year','Financial_statementController@serachfinancial_statement_year'); //งบแสดงฐานะการเงิน (รายปี)
Route::get('/printfinancial_statement_year', function () { //งบแสดงฐานะการเงิน (รายปี)
    $data = Input::all();
	// print_r($data);

	$pdf = PDF::loadView('printfinancial_statement_year', $data);
    return @$pdf->stream();
});


//งบแสดงฐานะการเงิน (ทั้งหมด)
Route::get('/financial_statement_allday','Financial_statementController@financial_statement_allday'); //งบแสดงฐานะการเงิน (รายวัน/รายเดือน)
Route::post('/serachfinancial_statement_allday','Financial_statementController@serachfinancial_statement_allday'); //งบแสดงฐานะการเงิน (รายวัน/รายเดือน)
Route::get('/printfinancial_statement_allday', function () { //งบแสดงฐานะการเงิน (รายวัน/รายเดือน)
    $data = Input::all();
	// print_r($data);

	$pdf = PDF::loadView('printfinancial_statement_allday', $data);
    return @$pdf->stream();
});

Route::get('/financial_statement_allyear','Financial_statementController@financial_statement_allyear'); //งบแสดงฐานะการเงิน (รายปี)
Route::post('/serachfinancial_statement_allyear','Financial_statementController@serachfinancial_statement_allyear'); //งบแสดงฐานะการเงิน (รายปี)
Route::get('/printfinancial_statement_allyear', function () { //งบแสดงฐานะการเงิน (รายปี)
    $data = Input::all();
	// print_r($data);

	$pdf = PDF::loadView('printfinancial_statement_allyear', $data);
    return @$pdf->stream();
});
Route::get('/Excel_financial_statement_allyear','ExcelAccountController@Excel_financial_statement_allyear'); //งบแสดงฐานะการเงิน (รายปี)
//---------------------------Financial_statement--------------------------------


// -----payser-----------------------------------------
Route::get('/payser', 'payserController@index')->name('payser');
Route::post('/payser/store','payserController@store')->name('payser.store');
Route::get('/payserpdf/{id}', 'payserController@pdf')->name('payserpdf');
// Route::get('/payser', 'payserController@index')->name('payser');
// Route::post('/payser/check','payserController@check')->name('payser.check');
// Route::post('/payser/store','payserController@store')->name('debt.store');
// -------payser jquery-----------
Route::get('getbranchtopayser/{branchcode}', 'payserController@getbranchtoconpay');
Route::get('getbankdetail/{getidbank}', 'payserController@getbankdetail');
Route::get('getbankfromacc/{getbank}', 'payserController@getbankfromacctype');
Route::get('getbankdetail1', 'payserController@getbankdetail1');
//----filter------
Route::post('/payser_filter/filter','payserController@payser_filters')->name('payser_filter');
//-----endfilter----
//-----edit_payser---
Route::get('/edit_payser/{id}','payserController@edit_data_payser')->name('edit_payser');
Route::post('/edit_payser/update','payserController@update_data_payser')->name('update_payser');
//-----end_edit_payser---
// Route::get('gettypepo/{potype}', 'payserController@gettypepo');
// Route::get('getpodetail/{po}', 'payserController@getpodetail');
Route::get('getpohead/{po}', 'payserController@getpohead');

Route::get('getgetpay/{infrompoid}', 'payserController@getpayseredit');
Route::get('getdataviewpicture/{id}', 'payserController@getdataviewpicture');
Route::get('getbankdetail1/{id}', 'payserController@getbankdetail1');

Route::post('getinfofromidpo1', 'payserController@getinfofromidpo1');

Route::post('postcalculatepo','payserController@postcalculatepo');
Route::post('getpodetailbyhead','payserController@getpodetailbyhead');
Route::get('/payser/deleteUpdate/{id}', 'payserController@deleteUpdate')->name('payser.delete');
Route::post('/payser/update','payserController@update')->name('payser.update');
Route::post('/paycredit/update','PaycreditController@update')->name('paycredit.update');
//-----------------------------------------------------


//--------paycredit-------------
Route::get('/paycredit', 'PaycreditController@index')->name('paycredit');
Route::post('/paycredit/store','PaycreditController@store')->name('paycredit.store');
Route::get('/paycreditpdf/{id}', 'PaycreditController@pdf')->name('paycreditpdf');
//-------payquery---------------
Route::get('getpoindebt/{getpo}', 'PaycreditController@getpoindebt');
Route::get('getbankfromaccounttype/{getbank}', 'PaycreditController@getbankfromaccounttype');
Route::get('getdataeditz/{getidedit}', 'PaycreditController@getdatadebtedit');
// Route::post('getpofrombranch', 'PaycreditController@getpofrombranch');
Route::get('getdataprint/{getprint}', 'PaycreditController@getdataprint');

Route::post('getinfofromidpo', 'PaycreditController@getinfofromidpo');
Route::post('printdetail', 'PaycreditController@printdetail');
Route::post('getindebtpo', 'PaycreditController@getindebtpo');
Route::get('getbankdetailpaycredit/{id}', 'PaycreditController@getbankdetailpaycredit');

Route::get('printpaycredit/{id}', 'PaycreditController@printpaycredit'); //ฟังค์ชั่นปริ้น

Route::post('postcalculatepo1','PaycreditController@postcalculatevatdebt');
Route::post('postcalculatepo2','PaycreditController@postcalculatepo2');
Route::post('getpodetailbydebt1','PaycreditController@getpodetailbydebt1');
// Route::post('postcalindebt','PaycreditController@postcalindebt');
Route::post('postinfofromindebt','PaycreditController@postinfofromindebt');
Route::get('/paycredit/delete/{id}','PaycreditController@delete')->name('paycredit.delete');
Route::post('/paycredit/update','PaycreditController@update')->name('paycredit.update');
//------------------------------

//--------define_property(ทะเบียนสินทรัพย์)--------------
Route::get('/define_property', 'DefinePropertyController@index')->name('define_property');
Route::get('/getdefineproperty/{id}', 'DefinePropertyController@getdefineproperty');
Route::post('/define_property/store','DefinePropertyController@store')->name('define_property.store');
Route::post('/define_property/update','DefinePropertyController@update')->name('define_property.update');
Route::get('/define_property/delete/{id}','DefinePropertyController@delete')->name('define_property.delete');
//-----------------------------------------------

//--------asset_list(ทะเบียนสินทรัพย์)--------------
Route::get('/asset_list', 'Asset_listController@index')->name('asset_list');
Route::post('/asset_list/filter','Asset_listController@asset_list_filter')->name('asset_list_filter');
Route::get('/asset_listpdf/{daterangez}/{branchz}', 'Asset_listController@pdf')->name('asset_listpdf');
// Route::get('/asset_listpdf/{id}', 'Asset_listController@pdf')->name('asset_listpdf');
Route::get('/getassetlistforedit/{id}', 'Asset_listController@getassetlist');
Route::post('/asset_list/store','Asset_listController@store')->name('asset_list.store');
Route::post('/asset_list/update','Asset_listController@update')->name('asset_list.update');
Route::get('/asset_list/delete/{id}','Asset_listController@delete')->name('asset_list.delete');
Route::get('/asset_list/getlisttypeasset', 'Asset_listController@getlisttypeasset');
Route::get('/asset_list/getlisttypeassetrefaccnumber', 'Asset_listController@getlisttypeassetrefaccnumber');
Route::get('/asset_list/serchassetrefmaterial', 'Asset_listController@serchassetrefmaterial');
Route::get('getlisttypeasset', 'Asset_listController@getlisttypeasset');
Route::get('getlisttypeassetrefaccnumber', 'Asset_listController@getlisttypeassetrefaccnumber');
Route::get('serchassetrefmaterial', 'Asset_listController@serchassetrefmaterial');


//-------------------------------------- ap_list --------------------------
Route::get('/ap_list', 'ap_listController@index')->name('ap_list');
Route::post('/ap_list/filter','ap_listController@ap_list_filters')->name('ap_list_filter');

Route::get('/ap_list_summary', 'ap_listController@index_ap_list_summary')->name('ap_list_summary');
Route::post('/ap_list_summary/filter','ap_listController@ap_list_summary_filters')->name('ap_list_summary_filter');

Route::get('/ap_list_showdateexpire', 'ap_listController@index_ap_list_showdateexpire')->name('ap_list_showdateexpire');
Route::post('/ap_list_showdateexpire/filter','ap_listController@ap_list_filters')->name('ap_list_showdateexpire_filter');

//-----------------------------------------------



//-------------------------------------- buysteel --------------------------
Route::get('/config_po_good', 'BuysteelController@config_buysteel_index')->name('config_po_good');
Route::get('config_getmaterial', 'BuysteelController@config_getmaterial');
Route::get('config_getgood', 'BuysteelController@config_getgood');
Route::post('/config_po_good/config_ins','BuysteelController@config_ins')->name('config_po_good.config_ins');

Route::get('/buysteel', 'BuysteelController@index')->name('buysteel');
Route::get('/search','BuysteelController@search');
Route::get('getmaterial', 'BuysteelController@getmaterial');
Route::post('/buysteel/store','BuysteelController@store')->name('buysteel.store');
Route::post('getdetails','BuysteelController@getdetails');
Route::post('getpodetailforshow', 'BuysteelController@getpodetailforapend');

Route::get('/approve_buysteel', 'BuysteelController@approve_buysteel_index')->name('approve_buysteel');
Route::post('/approve_buysteel_confirm', 'BuysteelController@approve_confirm')->name('approve_buysteel_confirm');
Route::get('/approve_buysteelpdf/{id}', 'BuysteelController@pdf')->name('approve_buysteelpdf');
//-----------------------------------------------

//--------Percent_maincost--------------
Route::get('/percent_main_cost', 'Percent_maincostController@index')->name('percent_main_cost');
Route::get('/getdata_percent/{id}', 'Percent_maincostController@getdata_percent');
// Route::post('/define_property/store','DefinePropertyController@store')->name('define_property.store');
Route::post('/percent_main_cost/update','Percent_maincostController@update')->name('percent_main_cost.update');
// Route::get('/define_property/delete/{id}','DefinePropertyController@delete')->name('define_property.delete');
//-----------------------------------------------

Route::get('/excelreportcustomercredit','ExcelController@excelreportcustomercredit'); //รายงานเจ้าหนี้การค้า (ค้างจ่าย)

//--------- settingtool -----------------
Route::get('/settingtool', 'SettingassettoolController@settingtool');
Route::get('/settingpotool', 'SettingassettoolController@settingpotool');
Route::get('/serchsettingpotool', 'SettingassettoolController@serchsettingpotool');
Route::post('/savesettingpotool','SettingassettoolController@savesettingpotool');
Route::get('/settingdmtool', 'SettingassettoolController@settingdmtool');
Route::get('/settingsalaryemptool', 'SettingassettoolController@settingsalaryemptool');
Route::get('/printsettingpotooldetail', function () { //กระดาษทำการ 10 ช่อง (ทั้งหมด)
    $data = Input::all();
	// print_r($data);

	$pdf = PDF::loadView('setting.printsettingpotooldetail', $data);
    return @$pdf->stream();
});
Route::get('/approvedpotoolassetstatus', 'SettingassettoolController@approvedpotoolassetstatus');
Route::get('/getdatedmtool', 'SettingassettoolController@getdatedmtool');
Route::post('/savesettingdmtool','SettingassettoolController@savesettingdmtool');
Route::get('/printsettingdmtooldetail', function () { //กระดาษทำการ 10 ช่อง (ทั้งหมด)
    $data = Input::all();
	// print_r($data);

	$pdf = PDF::loadView('setting.printsettingdmtooldetail', $data);
    return @$pdf->stream();
});
Route::get('/approveddmtoolassetstatus', 'SettingassettoolController@approveddmtoolassetstatus');
Route::get('/getempwageselectmonthproduct', 'SettingassettoolController@getempwageselectmonthproduct');
Route::get('/getempwageloadproductthislot', 'SettingassettoolController@getempwageloadproductthislot');
Route::post('/saveempdateproductthislot', 'SettingassettoolController@saveempdateproductthislot');
Route::get('/printsettingswdetail', function () {
    $data = Input::all();
	// print_r($data);

	$pdf = PDF::loadView('setting.printsettingswdetail', $data)->setPaper('a4', 'landscape');
    return @$pdf->stream();
});
Route::get('/getgoodformaterial', 'SettingassettoolController@getgoodformaterial');
Route::post('/saveconfiggoodtomaterial', 'SettingassettoolController@saveconfiggoodtomaterial');

Route::get('/asset_product_tool', 'SettingassettoolController@asset_product_tool');
Route::get('/seachbillofladinghead', 'SettingassettoolController@seachbillofladinghead');
Route::get('/getmaterialall', 'SettingassettoolController@getmaterialall');
Route::get('/selectmmapping', 'SettingassettoolController@selectmmapping');
Route::get('/approveasset_product_tool', 'SettingassettoolController@approveasset_product_tool');
Route::get('/printasset_product_tool', function () {
    $data = Input::all();
	// print_r($data);

	$pdf = PDF::loadView('setting.printasset_product_tool', $data)->setPaper('a4', 'landscape');
    return @$pdf->stream();
});
Route::post('/saveproductgoodtoproduct', 'SettingassettoolController@saveproductgoodtoproduct');
Route::get('/calstopdepreciation', 'SettingassettoolController@calstopdepreciation');
Route::post('/searchtypecalstoppreciation', 'SettingassettoolController@searchtypecalstoppreciation');
Route::post('/savedatestopdepreciation', 'SettingassettoolController@savedatestopdepreciation');


Route::get('asset_list_tool', 'Asset_listController@asset_list_tool');
Route::get('asset_list_sale', 'Asset_listController@asset_list_sale');
Route::post('searchassetlistsale', 'Asset_listController@searchassetlistsale');
Route::post('searchassetlisttool', 'Asset_listController@searchassetlisttool');

?>
