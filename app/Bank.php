<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'bank_detail';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'account_no', 'account_name', 'notation', 'updated_at', 'initials', 'accounttype_no', 'branch_id','status','status_use'];
}
