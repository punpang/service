<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Summary_score_of_member extends Model
{
  protected $table = 'summary_score_of_member';

  protected $connection = 'store';

  public $timestamps = false;

  public function member()
  {
    return $this->belongsTo(Member::class,'member_id','member_id')->select('member_id','member_name','member_tel');
  }

  public static function addScore($member_id,$addScore)
  {
    $score = self::where('member_id',$member_id)->first();
    $score->score_total = $score->score_total+$addScore;
    $score->save();

    return 'success';
  }
}
