<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cash extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'cash';
    protected $primarykey = 'id';
    protected $fillable = ['grandtotal','branch_id','time','timeold','account_code','account_name','note','codeemp','status'];
    public $timestamps = false;
}
