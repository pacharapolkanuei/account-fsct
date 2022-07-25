<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Withhold extends Model
{
  protected $connection = 'mysql2';
  protected $table = 'withhold';
  protected $fillable = ['id','withhold','status'];
}
