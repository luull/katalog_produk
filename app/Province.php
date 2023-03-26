<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    protected $table = "province";
    protected $guarded = ['id'];
    public $timestamps = false;
    public function branch()
    {
        return $this->hasMany(Branch::class, 'province', 'province_id');
    }
}
