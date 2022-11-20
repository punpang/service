<?php

namespace App\Order;

use App\Order\Tags;
use Illuminate\Database\Eloquent\Model;

class OrderTags extends Model
{
    protected $table = "order_tags";
    protected $connection = "order";
    protected $hidden = ['created_at', 'updated_at'];

    protected $appends = [];
    protected $guarded = [];

    public function tag()
    {
        return $this->belongsTo(Tags::class);
    }
}
