<?php

namespace App\Order;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class ProductTag extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $auditInclude = [
        'product_id',
        'product_category_sub_id'
    ];

    protected $table = "product_tags";
    protected $connection = 'order';
    protected $fillable = ['product_id', 'product_category_sub_id'];

    protected $hidden = ['created_at','updated_at'];

    public function ProductCategorySub()
    {
        return $this->belongsTo(ProductCategorySub::class, "product_category_sub_id", "id");
    }

    public function ProductCategorySubUseOnly()
    {
        return $this->belongsTo(ProductCategorySub::class, "product_category_sub_id", "id")->whereStatus('1');
    }

    public function Product()
    {
        return $this->hasOne(Product::class, "id", "product_id");
    }

    public function scopeUseOnly()
    {
        return $query = $this->where('status', 1);
    }
}
