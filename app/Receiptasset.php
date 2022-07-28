<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Receiptasset extends Model
{
  protected $connection = 'mysql2';
  protected $table = 'receiptasset';
  protected $fillable = ['id','receiptnum','datein','dateuse','status','emp_code'];
  public $timestamps = false;
}
