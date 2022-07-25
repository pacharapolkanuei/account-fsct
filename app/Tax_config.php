<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tax_config extends Model
{
  protected $connection = 'mysql2';
  protected $table = 'tax_config';
  protected $fillable = ['id','tax','status'];
}
