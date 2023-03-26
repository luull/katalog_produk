<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table = "city";
    protected $fillable = ['city_id', 'province_id', 'type', 'city_name', 'postal_code'];
    public $timestamps = false;

    public function contact()
    {
        return $this->hasMany(Contact::class, 'city', 'city_id');
    }
}
