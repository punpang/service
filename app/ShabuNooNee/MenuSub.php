<?php

namespace App\ShabuNoonee;

use Illuminate\Database\Eloquent\Model;

class MenuSub extends Model
{
    protected $table = "menu_subs";
    protected $fillable = ["title", "to", "menu_main_id", "admin", "cashier", "waitress", "kitchen", "customer"];

    public function menuMain()
    {
        return $this->belongsTo(MenuMain::class, 'menu_main_id', 'id');
    }
}
