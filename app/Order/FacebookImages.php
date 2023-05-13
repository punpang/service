<?php

namespace App\Order;

use Illuminate\Database\Eloquent\Model;

class FacebookImages extends Model
{
    protected $table = "facebook_images";
    protected $connection = "order";

    public static function createImage($attachment, $profile)
    {
        $is_have = FacebookImages::where("image_url", $attachment["payload"]["url"])->first();
        if ($is_have) {
            return;
        }

        $new = new FacebookImages;
        $new->facebook_id = $profile->id;
        $new->image_url = $attachment["payload"]["url"];
        $new->save();

        return;
    }

    public static function createImages($attachments, $profile)
    {
        foreach ($attachments as $attachment) {
            if ($attachment["type"] == "image") {
                $is_have = FacebookImages::where("image_url", $attachment["payload"]["url"])->first();
                if ($is_have) {
                    return;
                }

                $new = new FacebookImages;
                $new->facebook_id = $profile->id;
                $new->image_url = $attachment["payload"]["url"];
                $new->save();
            }
        }
        return;
    }

    public function facebook()
    {
        return $this->belongsTo(Facebook::class);
    }
}
