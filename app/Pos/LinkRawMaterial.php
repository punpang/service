<?php

namespace App\Pos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LinkRawMaterial extends Model
{
    use softDeletes;

    protected $table = "pos_link_raw_materials";
    protected $connection = "order";
    protected $hidden = ['created_at', 'updated_at'];

    protected $appends = [];
    protected $guarded = [];

    public function setCostAttribute($cost)
    {
        return $this->attributes['cost'] = $cost * $this->rawMaterial->price / $this->rawMaterial->weight;
    }

    public function getCostsAttribute()
    {
        return $this->weight * $this->rawMaterial->price / $this->rawMaterial->weight;
    }

    // public function setExpirationDateAttribute($value)
    // {
    //     $this->attributes['expiration_date'] = \Carbon\Carbon::parse($value)->addDays(365);
    // }

    public function rawMaterial()
    {
        return $this->belongsTo(RawMaterial::class, "pos_raw_material_id", "id");
    }
}
