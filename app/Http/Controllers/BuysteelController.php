<?php

namespace App\Http\Controllers;

use App\Bank;
use Illuminate\Http\Request;
use Softon\SweetAlert\Facades\SWAL;
use App\Branch;
use App\Accounttype;
use App\Http\Requests\BankRequest;


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
}
