<?php

namespace App\Pos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class RawMaterial extends Model
{
    use softDeletes;

    protected $table = "pos_raw_materials";
    protected $connection = "order";
    protected $hidden = ['created_at', 'updated_at'];

    protected $appends = [];
    protected $guarded = [];

    public function linkRawMaterials()
    {
        return $this->hasMany(LinkRawMaterial::class, "pos_raw_material_id", "id");
    }
}
