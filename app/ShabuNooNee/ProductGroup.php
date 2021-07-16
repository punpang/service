<?php

namespace App\ShabuNooNee;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class ProductGroup extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $auditInclude = [
        'name',
        'status'
    ];
    protected $table = "product_groups";
    protected $hidden = ['created_at', 'updated_at'];


    protected $fillable = [
        'name', 'status'
    ];

    public function productUseOnly()
    {
        return $this->hasMany(Product::class,"product_group_id","id")->whereStatus(1);
    }

    public function product()
    {
        return $this->hasMany(Product::class,"product_group_id","id");
    }
}
