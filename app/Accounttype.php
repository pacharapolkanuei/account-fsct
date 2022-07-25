<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Accounttype extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'accounttype';
    protected $primarykey = 'id';
    protected $fillable = ['id','accounttypeno','accounttypefull','config_group_supp_id'];
    public $timestamps = false;
}
