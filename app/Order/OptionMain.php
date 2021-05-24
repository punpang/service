<?php

namespace App\Order;

use Illuminate\Database\Eloquent\Model;

class OptionMain extends Model
{
    protected $table = "option_mains";
    protected $connection = "order";
    protected $fillable = [
        'op1',
        'op2',
        'product_id',
        "product_category_id",
        "status"
    ];

    public function sub()
    {
        return $this->hasMany(OptionMain::class, "op1", "id");
        //return $this->hasMany(OrderDetail::class, 'order_id', 'id')->whereStatus(1);
    }

    public function ProductCategorySub()
    {
        return $this->belongsTo(ProductCategorySub::class, "op2", "id");

        //return $this->hasMany(OrderDetail::class, 'order_id', 'id')->whereStatus(1);
    }
    public function Product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id'); //->exclude()
    }
}
