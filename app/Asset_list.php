<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Asset_list extends Model
{
  protected $connection = 'mysql2';
  protected $table = 'asset_list';
  public $timestamps = false;
}
