<?php

namespace App\ShabuNoonee;

use App\ShabuNooNee\Product;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class CookingBroth extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $auditInclude = [
        'cooking_detail_id',
        'product_id'
    ];

    protected $table = "cooking_broths";

    protected $hidden = ["created_at", "updated_at"];

    public function product()
    {
        return $this->belongsTo(Product::class, "product_id", "id");
    }

    public static function store($broths, $cooking_detail_id)
    {
        foreach ($broths as $broth) {
            $cookingBroth = new CookingBroth;
            $cookingBroth->cooking_detail_id = $cooking_detail_id;
            $cookingBroth->product_id = $broth["id"];
            $cookingBroth->save();
        }
    }
}
