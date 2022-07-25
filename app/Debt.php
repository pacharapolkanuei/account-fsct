<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Debt extends Model
{
    protected $table = 'in_debt';
    protected $connection = 'mysql2';
    protected $fillable = ['id','bill_no','vat_price','id_po','inform_po_picture','datebill','branch_id','discount','vat','number_debt','supplier_id','status_pay','accept'];
}
