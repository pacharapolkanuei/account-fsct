<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cheque_after extends Model
{
    protected $table = 'cheque_after';
    protected $primaryKey = 'id';
    protected $connection = 'mysql2';
    protected $fillable = ['id_cheque','status','bank_recived','date_check_pass','income_cheque','fee','net','deposit_no','receipt_no','file','date_deposit'];
    public $timestamps = false;
}
