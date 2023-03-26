<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payget extends Model
{
    protected $table = "payget";
    protected $guarded = ['id'];
    public $timestamps = false;
}
