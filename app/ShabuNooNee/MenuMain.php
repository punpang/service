<?php

namespace App\ShabuNoonee;

use Illuminate\Database\Eloquent\Model;
use Auth;

class MenuMain extends Model
{
    protected $table = "menu_mains";

    protected $fillable = ["title", "action", "admin", "cashier", "waitress", "kitchen", "customer"];
    public function menuSubs()
    {
        return $this->hasMany(MenuSub::class, "menu_main_id", "id")->select("id", "title", "to", "menu_main_id")->where(Auth::user()->userType->name, 1);
        //return $this->hasMany(MenuSub::class, "menu_main_id", "id")->select("id", Auth::user()->userType->name, "title", "to", "menu_main_id");
    }

    public function menuSubsAll()
    {
        return $this->hasMany(MenuSub::class, "menu_main_id", "id");
        //return $this->hasMany(MenuSub::class, "menu_main_id", "id")->select("id", Auth::user()->userType->name, "title", "to", "menu_main_id");
    }
}
