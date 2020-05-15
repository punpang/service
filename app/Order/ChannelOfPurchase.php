<?php

namespace App\Order;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class ChannelOfPurchase extends Model  implements Auditable
//ช่องทางการสั่งซื้อ
{
    //auditing
    use \OwenIt\Auditing\Auditable;
    protected $auditInclude = [
        'name', 'status'
    ];

    protected $table = "channel_of_purchases";
    protected $connection = 'order';
    protected $fillable = ['name', 'status'];
    protected $hidden = ['created_at', 'updated_at'];

    public function scopeUseOnly()
    {
        return $query = $this->where('status', 1)->select('id', 'name', 'status');
    }

    public function productCategorySub()
    {
        return $this->hasMany(ProductCategorySub::class, "product_category_id", "id");
    }
}
