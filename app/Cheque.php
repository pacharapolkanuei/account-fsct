<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cheque extends Model
{
    protected $table = 'cheque';
    protected $primaryKey = 'id';
    protected $connection = 'mysql2';
    protected $fillable = ['id','got_cheque','cheque_date','status','cheque_no','bank_cheque','branch_bank','branch','name','payer','price','notation','pic'];
    public $timestamps = false;

}
