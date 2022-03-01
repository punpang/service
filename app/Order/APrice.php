<?php

namespace App\Order;

use Illuminate\Database\Eloquent\Model;

class APrice extends Model
{
    protected $table = "a_price";
    protected $connection = "order";
    protected $primaryKey = "id";
    protected $appends = ["name_goods"];
    protected $hidden = ['created_at', 'updated_at'];

    //protected $filable = ["code", "price", "m1", "m2", "m3", "m4"];
    protected $guards = [];

    public function getPriceAttribute($price)
    {
        return number_format($price, 2);
    }

    public function am1()
    {
        return $this->belongsTo(AM1::class, "m1", "id");
    }

    public function am2()
    {
        return $this->belongsTo(AM2::class, "m2", "id");
    }

    public function am3()
    {
        return $this->belongsTo(AM3::class, "m3", "id");
    }

    public function am4()
    {
        return $this->belongsTo(AM4::class, "m4", "id");
    }

    public function getNameGoodsAttribute()
    {
        return $this->am1->m1 . ":" . $this->am2->m2 . ":" . $this->am3->m3 . ":" . $this->am4->m4;
    }
}
