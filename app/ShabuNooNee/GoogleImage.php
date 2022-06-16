<?php

namespace App\ShabuNooNee;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GoogleImage extends Model
{
    use softDeletes;

    // protected $auditInclude = [
    //     'scr'
    // ];

    protected $table = "google_images";
    protected $guarded = ["id"];
    // protected $fillable = ['src_name'];
    protected $hidden = ['created_at','updated_at'];

    public function scopeUseOnly()
    {
        return $query = $this->where('status', 1);
    }
}
