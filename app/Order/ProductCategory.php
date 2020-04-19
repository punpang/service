<?php

namespace App\Order;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class ProductCategory extends Model implements Auditable
{
    //auditing
    use \OwenIt\Auditing\Auditable;
    protected $auditInclude = [
        'name',
        'status',
    ];

    protected $table = "product_categories";
    protected $connection = 'order';
    protected $fillable = ['name', 'status'];

    public function scopeUseOnly()
    {
        return $query = $this->where('status', 1)->select('id', 'name', 'status');
    }

    public function productCategorySub()
    {
        return $this->hasMany(ProductCategorySub::class,"product_category_id","id");
    }
}
