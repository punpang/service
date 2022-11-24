<?php

namespace App\Order;

use App\ShabuNooNee\GoogleImage;
use Illuminate\Database\Eloquent\Model;

class OrderImageForMenu extends Model
{
    protected $table = "order_image_for_menus";
    protected $primaryKey = "id";
    protected $guarded = ["id"];
    protected $hidden = ['created_at', 'updated_at'];


    public function googleImage(){
        return $this->belongsTo(GoogleImage::class);
    }
}
