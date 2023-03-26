<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Level_admin extends Model
{
    protected $table = "level_admin";
    protected $guarded = ['id'];
    public function admin()
    {
        return $this->hasMany(Admin::class, 'akses', 'kode');
    }
}
