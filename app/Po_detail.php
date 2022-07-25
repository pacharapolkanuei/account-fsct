<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Po_detail extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'po_detail';
    protected $fillable = ['list','amount','price','total'];
    public $timestamps = false;
}
