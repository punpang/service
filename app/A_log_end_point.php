<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class A_log_end_point extends Model
{
    protected $connection = 'store';

    protected $table = 'a_log_end_point';

    public $timestamps = false;

    public function member()
    {
      return $this->belongsTo(Member::class,'member_id','member_id')->select('member_id','member_name','member_tel');
    }

}
