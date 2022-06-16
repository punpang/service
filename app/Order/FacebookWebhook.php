<?php

namespace App\Order;

use App\Order\FacebookReply;
use Illuminate\Database\Eloquent\Model;

class FacebookWebhook extends Model
{
    protected $table = "facebook_webhooks";
    protected $hidden = ["created_at", "updated_at"];
    protected $guarded = [];

    public function reply()
    {
        return $this->belongsTo(FacebookReply::class, "reply_id", "id");
    }
}
