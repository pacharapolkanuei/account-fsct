<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'supplier';
    protected $fillable = ['id'];
}
