<?php

namespace App\Order;

use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Model;

class Product extends Model implements Auditable
{
    //auditing
    use \OwenIt\Auditing\Auditable;
    protected $auditInclude = [
        'name', 'detail_status', 'detail', 'price_normal', 'price_special_status', 'price_special', 'status', 'image_status', 'product_image_id'
    ];

    protected $table = "products";
    protected $connection = 'order';
    protected $fillable = ['name', 'detail_status', 'detail', 'price_normal', 'price_special_status', 'price_special', 'status', 'image_status', 'product_image_id'];

    public function scopeUseOnly()
    {
        return $query = $this->where('status', 1);
    }

    public function ProductImage()
    {
        return $this->belongsTo(ProductImage::class, "product_image_id", "id");
    }

    public function ProductTag()
    {
        return $this->hasMany(ProductTag::class,"product_id",'id');
    }
}
