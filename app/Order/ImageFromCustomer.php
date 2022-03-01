<?php

namespace App\Order;

use App\ShabuNooNee\GoogleImage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ImageFromCustomer extends Model
{
    use SoftDeletes;
    protected $table = "image_from_customers";
    // protected $connection = "order";

    protected $guarded = ["id"];
    protected $hidden = ['created_at', 'updated_at'];


    public function googleImage()
    {
        return $this->belongsTo(GoogleImage::class, "google_image_id", "id");
    }
}
