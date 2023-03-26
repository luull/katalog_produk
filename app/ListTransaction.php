<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ListTransaction extends Model
{
    protected $table = "list_transaction";
    protected $guarded = ['id'];
    public $timestamps = false;
    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'id_transaction', 'id_transaction');
    }
    public function product()
    {
        return $this->belongsTo(Product::class, 'id_barang', 'id')->select(['id', 'kode_brg', 'slug', 'nama', 'berat', 'harga', 'satuan', 'image']);
    }
}
