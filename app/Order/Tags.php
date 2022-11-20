<?php

namespace App\Order;

use App\Order\OrderTags;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Tags extends Model
{
    use SoftDeletes;

    protected $table = "tags";
    protected $connection = "order";
    protected $hidden = ['created_at', 'updated_at'];

    protected $appends = [];
    protected $guarded = [];

    public function orderTags()
    {
        return $this->hasMany(OrderTags::class);
    }
}
