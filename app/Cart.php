<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $table = "cart";
    protected $guarded = ['id'];
    public $timestamps = false;
    public function product()
    {
        return $this->belongsTo(Product::class, 'id_barang', 'id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
}
