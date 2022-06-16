<?php

namespace App\Order;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class FacebookReply extends Model
{
    protected $table = "facebook_replies";
    protected $guarded = [];
    protected $hidden = ['created_at', 'updated_at'];
    protected $appends = ["text_th"];

    public function webhooks()
    {
        return $this->hasMany(FacebookWebhook::class, "reply_id", "id");
    }

    // public function setTextAttribute($text)
    // {
    //     $this->attributes['text'] = str_replace('"', '', $text);
    // }

    public function getTextThAttribute()
    {
        return json_decode($this->text);
    }

    public static function replace_value($id, $value = [])
    {
        $message = self::find($id);
        $explode = explode('/*-', $message->text_th);
        return Str::replaceArray("!?!", $value, $explode[0]);
    }
}
