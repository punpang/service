<?php

namespace App\ShabuNoonee;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class MenuMain extends Model
{
    protected $table = "menu_mains";
    protected $connection = "order";

    protected $fillable = ["title", "action", "admin", "customer"];

    public function menuSubs()
    {
        return $this->hasMany(MenuSub::class, "menu_main_id", "id")->select("id", "title", "to", "menu_main_id")->where(Auth::user()->type_name, 1);
        //return $this->hasMany(MenuSub::class, "menu_main_id", "id")->select("id", Auth::user()->userType->name, "title", "to", "menu_main_id");
    }

    public function menuSubsAll()
    {
        return $this->hasMany(MenuSub::class, "menu_main_id", "id");
        //return $this->hasMany(MenuSub::class, "menu_main_id", "id")->select("id", Auth::user()->userType->name, "title", "to", "menu_main_id");
    }
}
