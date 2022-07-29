<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Receiptasset_detail extends Model
{
  protected $connection = 'mysql2';
  protected $table = 'receiptasset_detail';
  protected $fillable = ['id','receiptasset_id','material_id','lot','produce','cost','total_cost','saraly','total_cost_produce','cost_produce_unit'];
  public $timestamps = false;
}
