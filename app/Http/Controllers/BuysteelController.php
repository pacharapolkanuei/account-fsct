<?php

namespace App\Http\Controllers;

use App\Bank;
use Illuminate\Http\Request;
use Softon\SweetAlert\Facades\SWAL;
use App\Branch;
use App\Po_head;
use App\Accounttype;
use App\Receiptasset;
use App\Http\Requests\BankRequest;
use Carbon\Carbon;
use DB;

class BuysteelController extends Controller
{

    public function index()
    {
      // $accounttypes = new Accounttype;
      // $accounttypes->setConnection('mysql2');
      // $accounttypes = Accounttype::where('status','=',1)
      //               ->get();
      //
      // $propertys = DB::connection('mysql2')
      //     ->table('group_property')
      //     // ->select('in_debt.id as id_indebt','in_debt.number_debt','in_debt.accept','in_debt.branch_id','in_debt.discount'
      //     // ,'in_debt.vat','in_debt.vat_price','in_debt.id_typejournal','in_debt.datebill','po_detail.list','po_detail.note'
      //     // ,'accounttype.accounttypeno','accounttype.accounttypefull','po_detail.total','accounttype.config_group_supp_id','good.name'
      //     // ,'accounttype.id as id_accounttype','po_head.supplier_id')
      //     ->select('group_property.id as id_group','group_property.number_property','group_property.descritption_thai','group_property.descritption_eng','accounttype.accounttypeno','accounttype.accounttypefull')
      //     ->join('accounttype', 'accounttype.id', '=', 'group_property.accounttype_no')
      //     ->orderBy('group_property.id', 'asc')
      //     ->where('group_property.statususe',1)
      //     ->get();
      return view('assetlist.buysteel');
    }



    public function search(Request $request)
    {
      if($request->ajax())
      {
      $output="";

      $products = DB::connection('mysql2')
  			->table('po_head')
  			->where('po_number','LIKE',$request->search)
  			->get();

          if(!empty($products))
          {
            foreach ($products as $key => $product) {
            $output.= '&nbsp'.'&nbsp'.'&nbsp'.'&nbsp'.'ยอดเงิน'.'&nbsp'.$product->totolsumall;
            // foreach ($products as $key => $product) {
            // $output.='<tr>'.
            // '<td>'.$product->po_number.'</td>'.
            // '<td>'.$product->totolsumall.'</td>'.
            // '</tr>';
            }
          return Response($output);
          }
          else {
            $output.= '&nbsp'.'&nbsp'.'&nbsp'.'&nbsp'.'ไม่มีข้อมูล';
          }
      }
    }

    public function store(Request $request)
    {
        if ($request->get('get_emp') != null) {
          // $code_branch = $request->get('branch');
          $count = DB::connection('mysql2')
                       ->table('receiptasset')
                       ->get();
          $count_num = count($count);

          // $lot = $request->get('lotnumber');
          $datenowuse = $request->get('datenow');
          $emp_code = $request->get('get_emp');
          $po_number = $request->get('search');

          $search_po = DB::connection('mysql2')
      			->table('po_head')
            ->seLect('id as id_po')
      			->where('po_number','LIKE',$po_number)
      			->get();
          foreach ($search_po as $key => $search_pos) {
            $get_id_po = $search_pos->id_po;
          }

          $now = Carbon::now();
          $yearforuse = $now->year + 543;
          $monthforuse = $now->month;
          $dayforuse =$now->day;

          $ins_receiptasset = new Receiptasset;
          $ins_receiptasset->setConnection('mysql2');
          $ins_receiptasset->datein = $code_branch;
          $ins_receiptasset->dateuse = $gettype_module;
          $ins_receiptasset->status = 0;
          $ins_receiptasset->emp_code = $emp_code;
          $ins_receiptasset->po_ref = $get_id_po;

          $ins_receiptasset->receiptnum = "RCT" . $yearforuse . $monthforuse . $dayforuse . sprintf('%04d', $count_num);
          $ins_receiptasset->save();

          exit;

          $count_id = Receiptasset::max('id');
          for ($i=0; $i < count($accounttypeno); $i++) {
            $journal_generals_detail = new Journalgeneraldetail;
            $journal_generals_detail->setConnection('mysql2');
            $journal_generals_detail->id_journalgeneral_head = $count_id;
            $journal_generals_detail->accounttype = $accounttypeno[$i];
            $journal_generals_detail->debit = $debit[$i];
            $journal_generals_detail->credit = $credit[$i];
            $journal_generals_detail->list = $list[$i];
            $journal_generals_detail->name_suplier = $name_supplier[$i];
            $journal_generals_detail->save();
          }

      SWAL::message('สำเร็จ', 'บันทึกสมุดรายวันทั่วไปแล้ว!', 'success', ['timer' => 6000]);
      return redirect()->route('journal.general');
    }else {
      SWAL::message('บันทึกล้มเหลว', 'session หมดอายุให้กลับไป Log In !', 'warning', ['timer' => 6000]);
      return redirect()->route('fsctonline.com/fscthr/auth/default/index');
    }
    }




    public function getmaterial()
    {
      $materials = DB::connection('mysql3')
          ->table('material')
          // ->select('in_debt.id as id_indebt','in_debt.number_debt','in_debt.accept','in_debt.branch_id','in_debt.discount'
          // ,'in_debt.vat','in_debt.vat_price','in_debt.id_typejournal','in_debt.datebill','po_detail.list','po_detail.note'
          // ,'accounttype.accounttypeno','accounttype.accounttypefull','po_detail.total','accounttype.config_group_supp_id','good.name'
          // ,'accounttype.id as id_accounttype','po_head.supplier_id')
          // ->select('group_property.id as id_group','group_property.number_property','group_property.descritption_thai','group_property.descritption_eng','accounttype.accounttypeno','accounttype.accounttypefull')
          ->seLect('id','name')
          // ->join('accounttype', 'accounttype.id', '=', 'group_property.accounttype_no')
          ->orderBy('name', 'asc')
          ->where('status',1)
          ->get();

      return $materials;
    }


}
