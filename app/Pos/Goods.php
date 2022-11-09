<?php

namespace App\Pos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Goods extends Model
{
    use softDeletes;

    protected $table = "pos_goods";
    protected $connection = "order";
    // protected $hidden = ['created_at', 'updated_at'];
    // public $timestamps = false;
    protected $appends = [];
    protected $guarded = [];

    public function categoryGoodses()
    {
        return $this->belongsTo(CategoryGoods::class, "pos_category_goods_id", "id");
    }
}
