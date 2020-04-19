<?php

namespace App\Order;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class ProductCategorySub extends Model implements Auditable
{
    //auditing
    use \OwenIt\Auditing\Auditable;
    protected $auditInclude = [
        'name',
        'status',
        'product_category_id'
    ];

    protected $table = "product_category_subs";
    protected $connection = 'order';
    protected $fillable = ['name', 'status', 'product_category_id'];

    public function ProductCategory()
    {
        return $this->belongsTo(ProductCategory::class, "product_category_id", "id")->select('id','name','status');
    }

    public function scopeUseOnly()
    {
        return $query = $this->where('status',1);
    }

    public function scopeProductCategoryUseOnly()
    {
        return $query = $this->whereNotNull('product_category');
    }
}
