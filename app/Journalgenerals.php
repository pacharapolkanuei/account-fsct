<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Journalgenerals extends Model
{
  protected $connection = 'mysql2';
  protected $table = 'journal_5';
  protected $fillable = ['accounttypeno','code_branch','datebill','debit','credit','list','name_supplier'];
  public $timestamps = false;
}
