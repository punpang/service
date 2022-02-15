<?php

namespace App\Order;

use App\ShabuNooNee\GoogleImage;
use Illuminate\Database\Eloquent\Model;

class ImageFromCustomer extends Model
{
    protected $table = "image_from_customers";
    // protected $connection = "order";

    public function googleImage()
    {
        return $this->belongsTo(GoogleImage::class, "google_image_id", "id");
    }
}
