<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    protected $table = "users";
    protected $guarded = ['id'];
    public function cart()
    {
        return $this->hasMany(Cart::class, 'id_user', 'id');
    }
    public function transaction()
    {
        return $this->hasMany(Transaction::class,  'id_user', 'id');
    }
}
