<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Config_group_supp extends Model
{
  protected $connection = 'mysql2';
  protected $table = 'config_group_supp';
  protected $fillable = ['id','name','status'];
}
