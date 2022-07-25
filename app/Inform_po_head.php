<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inform_po_head extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'inform_po_head';
    protected $fillable = ['bill_no','payout','change_pay','vat_percent','vat_price','wht_percent','wht','type_po','inform_po_picture','status','datebill'];
    public $timestamps = false;
}
