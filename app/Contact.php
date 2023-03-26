<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $table = "contact";
    protected $guarded = ['id'];
    public $timestamps = false;

    public function kota()
    {
        return $this->belongsTo(City::class,  'city', 'city_id');
    }
    public function kecamatan()
    {
        return $this->belongsTo(Subdistrict::class,  'subdistrict', 'subdistrict_id');
    }
    public function transaction()
    {
        return $this->hasMany(Transaction::class, "id_user", "id");
    }
}
