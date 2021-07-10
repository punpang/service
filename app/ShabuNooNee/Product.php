<?php

namespace App\ShabuNooNee;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = "products";

    protected $fillable = [
        "title", "product_group_id", "image_id", "status"
    ];

    public function productGroup()
    {
        return $this->belongsTo(ProductGroup::class, "product_group_id", "id");
    }

    public function googlgImage()
    {
        return $this->belongsTo(GoogleImage::class, "image_id", "id");
        //->select("id","scr");
    }

    public static function afterStore($id)
    {
        return self::whereId($id)->with("productGroup", "googlgImage")->first();
    }
}
