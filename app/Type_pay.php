<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Type_pay extends Model
{
  protected $connection = 'mysql2';
  protected $table = 'type_pay';
  protected $fillable = ['id','name_pay','status'];
}
