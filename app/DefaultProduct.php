<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DefaultProduct extends Model
{
    protected $table = "default_produk";
    protected $guarded = ['id'];
    public $timestamps = false;
}
