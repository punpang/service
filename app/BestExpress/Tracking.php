<?php

namespace App\BestExpress;

use Illuminate\Database\Eloquent\Model;

class Tracking extends Model
{
  protected $table = 'trackings';

  protected $connection = 'best';

  protected $fillable = [
    'dates',
    'waybill',
    'shipping_charge',
    'other_values',
    'parcel_fee',
    'besides',
    'sender_number',
    'recipient_name',
    'recipient_number',
    'total',
    'weight',
    'size'
  ];

  // protected $primaryKey = 'waybill';

  // public $timestamps = false;\
  public function ShippingChargeNBF()
  {
    return number_format($this->shipping_charge,2);
  }

  public function ParcelFeeNBF()
  {
    return number_format($this->parcel_fee,2);
  }

  public function OtherValuesNBF()
  {
    return number_format($this->other_values,2);
  }

  public function BesidesNBF()
  {
    return number_format($this->besides,2);
  }

  public function TotalNBF()
  {
    return number_format($this->total,2);
  }

  public function DatesFormat()
  {
    return \Carbon\Carbon::parse($this->dates)->addYears(543)->format('d/m/Y');
  }

  public function SumAll()
  {
    return $this->sum('shipping_charge');
  }
}
