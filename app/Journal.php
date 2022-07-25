<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'journal';
    protected $fillable = ['module','name_branch','datebill','list','po_head','accounttypeno','total','DorC'];
    public $timestamps = false;
}
