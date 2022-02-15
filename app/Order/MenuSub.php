<?php

namespace App\Order;

use Illuminate\Database\Eloquent\Model;

class MenuSub extends Model
{
    protected $table = "menu_subs";
    protected $connection = "order";
    
    protected $fillable = ["title", "to", "menu_main_id", "admin", "customer"];

    public function menuMain()
    {
        return $this->belongsTo(MenuMain::class, 'menu_main_id', 'id');
    }
}
