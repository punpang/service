<?php

namespace App\Order;


use App\ShabuNooNee\GoogleImage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ImageGoodsReviewToCustomer extends Model
{
    use SoftDeletes;
    protected $table = 'image_goods_review_to_customers';
    protected $guarded = ["id"];
    protected $hidden = ['created_at', 'updated_at'];

    public function googleImage()
    {
        return $this->belongsTo(GoogleImage::class);
    }
}
