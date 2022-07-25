<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ledger extends Model
{
  protected $connection = 'mysql2';
  protected $table = 'ledger';
  protected $fillable = ['id','dr','cr','acc_code','branch','status','number_bill','customer_vendor','timestamp','code_emp','subtotal','discount','vat','vatmoney','wht','whtmoney','grandtotal','type_income','type_journal','id_type_ref_journal','timereal','list','balance_forward_status'];
  public $timestamps = false;
}
