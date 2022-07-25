<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Po_head extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'po_head';
    protected $fillable = ['branch_id','type_pay','po_number'];
}
