<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $table = "admin";
    protected $guarded = ['id'];
    public $timestamps = false;
    public function level_admin()
    {
        return $this->belongsTo(Level_admin::class, 'akses', 'kode');
    }
}
