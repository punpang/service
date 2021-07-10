<?php

namespace App\ShabuNooNee;

use Illuminate\Database\Eloquent\Model;

class GoogleImage extends Model
{
    protected $auditInclude = [
        'scr'
    ];

    protected $table = "google_images";
    protected $fillable = ['src_name'];
    protected $hidden = ['created_at','updated_at'];

    public function scopeUseOnly()
    {
        return $query = $this->where('status', 1);
    }
}
