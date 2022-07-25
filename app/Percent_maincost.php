<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Percent_maincost extends Model
{
  protected $connection = 'mysql3';
  protected $table = 'percent_main_cost';
  public $timestamps = false;
}
