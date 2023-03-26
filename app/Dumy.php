<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dumy extends Model
{
    protected $table = "dummy";
    protected $guarded = ['id'];
    public $timestamps = false;
}
