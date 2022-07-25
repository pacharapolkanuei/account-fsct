<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Po extends Model
{
	protected $connection = 'mysql2';
	protected $table = 'po_head';
	protected $fillable = ['date','branch_id','type_pay','po_number','status_head','type_po'];
}
