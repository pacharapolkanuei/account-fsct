<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group_Property extends Model
{
  protected $connection = 'mysql2';
  protected $table = 'group_property';
  public $timestamps = false;
}
