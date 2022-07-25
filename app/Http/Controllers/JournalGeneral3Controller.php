<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use DB;
use App\Branch;
use App\Type_journal;
use App\Journal_5;
use App\Accounttype;
use App\Api\Connectdb;
use Illuminate\Support\Facades\Input;
use Softon\SweetAlert\Facades\SWAL;
use App\Api\Datetime;

class JournalGeneral3Controller extends Controller
{
  use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index()
    {
        $accounttypes = new Accounttype;
        $accounttypes->setConnection('mysql2');
        $accounttypes = Accounttype::where('status','=',1)
                      ->get();

        $branchs = new Branch;
        $branchs = Branch::get();

        $data = Input::all();
        $db = Connectdb::Databaseall();

        $sqlbill = 'SELECT '.$db['fsctmain'].'.stock_loss_head.*
                                              ,material.name as names
                                              ,stock_loss_detail.totaloss
                                              ,customers.name
                                              ,customers.lastname


          FROM '.$db['fsctmain'].'.stock_loss_head

          INNER JOIN  '.$db['fsctmain'].'.stock_loss_detail
          ON '. $db['fsctmain'].'.stock_loss_head.id = '. $db['fsctmain'].'.stock_loss_detail.bill_head

          INNER JOIN  '.$db['fsctmain'].'.material
          ON '. $db['fsctmain'].'.stock_loss_detail.material_id = '. $db['fsctmain'].'.material.id

          INNER JOIN  '.$db['fsctmain'].'.customers
          ON '. $db['fsctmain'].'.stock_loss_head.customer_id = '. $db['fsctmain'].'.customers.customerid


          ORDER BY '. $db['fsctmain'].'.stock_loss_head.bill_no ASC ';

        $databills = DB::connection('mysql')->select($sqlbill);
        $ap = 'default';
        // WHERE '.$db['fsctmain'].'.stock_loss_head.status = 1 AND '.$db['fsctmain'].'.stock_loss_head.type = 2
        return view('journal.journal_general3', compact( 'branchs' , 'accounttypes', 'databills' ,'ap' ));
    }

    public function confirm_journal_general3(Request $request)
    {
        // dd($comma_separated);
        // exit;
        $connect1 = Connectdb::Databaseall();
        $baseAc1 = $connect1['fsctaccount'];

        // $id_debt = $request->get('id_journal_pay');
        // $comma_separated1 = implode(",", $id_debt);

        $number_jg = $request->get('jg_number');
        $comma_separated2 = implode(',' , $number_jg);

        $sql1 = "UPDATE $baseAc1.journal_5
                 SET $baseAc1.journal_5.accept = '1'
                 WHERE $baseAc1.journal_5.number_bill_journal IN($comma_separated2)";
        $sql_finish1 = DB::select($sql1);

        // $debts = Debt::whereIn('number_debt' , '=' , $comma_separated)->get();
        // foreach ($debts as $key => $debt) {
        //     $debt->accept = 1;
        //     $debt->update();
        // }

        $ins_ledger = new Ledger;
        $ins_ledger->setConnection('mysql2');
        $ins_ledger->branch = $request->get('code_branchs');
        $ins_ledger->number_bill = $request->get('number_debts');
        $ins_ledger->discount = $request->get('discounts');
        $ins_ledger->vat = $request->get('vat_percents');
        $ins_ledger->vatmoney = $request->get('vat_prices');
        $ins_ledger->type_journal = $request->get('id_typejournals');
        $ins_ledger->id_type_ref_journal = $request->get('id_journal_general');
        $ins_ledger->timereal = $request->get('datebills');
        $ins_ledger->debit = $request->get('debits');
        $ins_ledger->credit = $request->get('credits');
        // echo $request->get('id_journal_pay');
        // exit;
        $ins_ledger->save();

        return redirect()->route('journal.general');
    }
}
