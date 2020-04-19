<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tb_bill_sale extends Model
{
  protected $table = 'tb_bill_sale';

  protected $primaryKey = 'bill_sale_id';

  protected $connection = 'store';

  public $timestamps = false;

  public function member()
  {
    return $this->belongsTo(Member::class,'member_id','member_id')->select('member_id','member_name','member_tel');
  }

  public function score_total()
  {
    return $this->belongsTo(Summary_score_of_member::class,'member_id','member_id')->select('id','member_id','score_total');
  }

  public function scopeLastSellOfDay()
  {
    return $query = $this->whereDate('bill_sale_created_date',\Carbon\Carbon::now()->format('Y-m-d'));
  }
}
