<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    // create() や update() で代入を許可するカラム
    protected $fillable = ['name', 'position'];
}
