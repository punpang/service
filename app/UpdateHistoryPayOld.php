<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UpdateHistoryPayOld extends Model
{
    protected $table = "a_history_payed";
    protected $connection = "update_table";
    protected $hidden = ['created_at', 'updated_at'];

    protected $appends = [];
    protected $guarded = [];
}
