<?php

namespace App\Punpang;

use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    protected $table = 'price';
    public $timestamps = false;
    protected $connection = 'punpang';

    public function size()
    {
        return $this->belongsTo(Size::class, "size", "id");
    }
}
