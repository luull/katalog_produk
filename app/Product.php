<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = "product";
    protected $guarded = ['id'];
    public $timestamps = false;

    public function cart()
    {
        return $this->hasMany(Cart::class, 'id_barang', 'id');
    }
    public function category()
    {
        return $this->belongsTo(Category::class, 'kategori', 'id');
    }
    public function sub_category()
    {
        return $this->belongsTo(SubCategory::class, 'sub_kategori', 'id');
    }
    public function sub_sub_category()
    {
        return $this->belongsTo(SubSubCategory::class, 'sub_sub_kategory', 'id');
    }

    public function display()
    {
        return $this->hasOne(Display::class, "produk_id", "id");
    }
    public function detil_transaction()
    {
        return $this->hasMany(ListTransaction::class, 'id_barang', 'id');
    }
}
