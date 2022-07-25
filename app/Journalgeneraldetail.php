<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Journalgeneraldetail extends Model
{
  protected $connection = 'mysql2';
  protected $table = 'journalgeneral_detail';
  protected $fillable = ['id','id_journalgeneral_head','accounttype','list','name_suplier','status','credit','debit'];
  public $timestamps = false;
}
