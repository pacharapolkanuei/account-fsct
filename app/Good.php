<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Good extends Model
{
  protected $connection = 'mysql2';
  protected $table = 'good';
  protected $fillable = ['id','name','group_supplier','status'];
}
