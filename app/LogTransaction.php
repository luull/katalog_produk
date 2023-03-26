<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LogTransaction extends Model
{
    protected $table = "log_transaction";
    protected $guarded = ['id'];
}
