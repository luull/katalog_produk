<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = "transaction";
    protected $guarded = ['id'];
    public $timestamps = false;
    public function user()
    {
        return $this->belongsTo(Users::class, 'id_user', 'id')->select(['id', 'username', 'name', 'email', 'phone', 'refferal', 'refferal_id']);
    }
    public function address()
    {
        return $this->belongsTo(Contact::class, 'id_address', 'id');
    }
    public function detil()
    {
        return $this->hasMany(ListTransaction::class, 'id_transaction', 'id_transaction');
    }
    public function branch()
    {
        return $this->hasMany(ListTransaction::class, 'processed_by', 'id');
    }
}
