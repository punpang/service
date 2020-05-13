<?php

namespace App\Order;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use App\Helper;

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
        return $this->belongsTo(OrderDetail::class, "order_detail_id", "id");
    }

    public function ExampleImage()
    {
        return $this->hasOne(Image::class, 'order_detail_id', 'order_detail_id')->whereType('example');
    }

    public function Images()
    {
        return $this->hasMany(Image::class, 'order_detail_id', 'order_detail_id')->whereType('images')->orderBy('main', 'DESC')->orderBy('created_at', 'DESC');
    }

    public static function SeachByTokenRules($token)
    {
        $now = \Carbon\Carbon::now()->format("Y-m-d");
        $sent = SentLinkForUploadImage::whereToken($token)->first();
        if ($sent && $sent->orderDetail->order->dateTime_get >= $now && $sent->orderDetail->status && $sent->orderDetail->upload_image_status) {
            return $sent;
        }
    }

    public static function CreateLink($detail)
    {
        if ($detail->upload_image_status) {
            // เช็ค มีการสร้างไปหรือยัง หากมีให้ไปที่อัปเดทแทน
            $sent = SentLinkForUploadImage::find($detail->id);
            if ($sent) {
                return $sent;
            } else {
                $input['order_detail_id'] = $detail->id;
                $input['token'] = Helper::generateToken();
                $sent = SentLinkForUploadImage::create($input);
                return $sent;
            }
        }
    }
}
