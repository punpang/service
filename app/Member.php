<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Member extends Model
{
    protected $connection = 'store';

    protected $table = 'tb_member';

    public $timestamps = false;

    public static function findMember()
    {
      return Member::where('member_tel',Auth::user()->phone)->first();
    }

    public static function beMember($tel)
    {
      // ตอบกลับเป็น id หรือ 0
      $member = Member::where('member_tel',$tel)->first();
      if ($member == null) {
        $return = '0';
      }elseif ($member != null) {
        $return = $member->member_id;
      }
      return $return;
    }

    public function HistoryPurchase()
    {
      return $this->hasMany(Tb_bill_sale::class,'member_id','member_id')->orderBy('bill_sale_id','DESC');
    }

    public function PointCoupon()
    {
      return $this->belongsTo(Summary_score_of_member::class,'member_id','member_id')->select('id','score_total');
    }
}
