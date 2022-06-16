<?php

namespace App\Order;

use App\ShabuNooNee\GoogleImage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderProductPrototype extends Model
{
    use SoftDeletes;

    protected $table = "order_product_prototypes";
    protected $primaryKey = "id";
    protected $guarded = ["id"];
    protected $hidden = ['created_at', 'updated_at'];


    public function googleImage(){
        return $this->belongsTo(GoogleImage::class);
    }
}
