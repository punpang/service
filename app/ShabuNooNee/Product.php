<?php

namespace App\ShabuNooNee;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Product extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $auditInclude = [
        'dining_table_id',
        'queue_id',
        "user_id",
        "format_id",
        "status_done",
    ];

    protected $table = "products";

    protected $fillable = [
        "title", "product_group_id", "image_id", "status", "price", "status_free", "next_to"
    ];
    protected $hidden = ['created_at', 'updated_at'];


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

    public static function cookingDetail($broths)
    {
        return self::whereIn("id", $broths)->get();
    }

    public static function checkProductUse($product_id)
    {
        $product = Product::whereId($product_id)->whereStatus(1)->first();

        if ($product === null) {
            return false;
        }

        return true;
    }

    public static function outOfStockByID($product_id)
    {
        self::where("id", $product_id)->update(['stauts' => 0]);
    }
}
