<?php

namespace App\Order;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class ProductImage extends Model implements Auditable
{
    //auditing
    use \OwenIt\Auditing\Auditable;
    protected $auditInclude = [
        'scr'
    ];

    protected $table = "product_images";
    protected $connection = 'order';
    protected $fillable = ['src_name'];

    public function scopeUseOnly()
    {
        return $query = $this->where('status', 1);
    }
}
