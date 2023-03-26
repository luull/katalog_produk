<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Log_Processed_By extends Model
{
    protected $table = "log_processed_by";
    protected $guarded = ['id'];
    public $timestamps = false;
    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'branch_id');
    }
}
