<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $table = "branches";
    protected $guarded = ['id'];
    public $timestamps = false;
    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'processed_by', 'branch_id');
    }
    public function log_processed_by()
    {
        return $this->belongsTo(Log_Processed_By::class, 'branch_id', 'branch_id');
    }
    public function propinsi()
    {
        return $this->belongsTo(Province::class,  'province', 'province_id');
    }
    public function kota()
    {
        return $this->belongsTo(City::class,  'city', 'city_id');
    }
    public function kecamatan()
    {
        return $this->belongsTo(Subdistrict::class,  'subdistrict', 'subdistrict_id');
    }
}
