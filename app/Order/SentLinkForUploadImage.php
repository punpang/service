<?php

namespace App\Order;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class SentLinkForUploadImage extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $auditInclude = [
        'order_detail_id',
        'example',
        'image',
        'token'
    ];

    protected $table = "sent_link_for_upload_images";
    protected $connection = 'order';
    protected $fillable = [
        'order_detail_id',
        'example',
        'image',
        'token'
    ];
    protected $hidden = ['created_at', 'updated_at'];
    protected $primaryKey = 'order_detail_id';

    public function orderDetail()
    {
        return $this->belongsTo(OrderDetail::class,"order_detail_id","id");
    }
}
