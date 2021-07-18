<?php

namespace App\ShabuNooNee;

use App\User;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Auth;

class DiningTable extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $auditInclude = [
        "user_id",
        "status_id",
        "count_Infant",
        "count_Children",
        "count_Adolescence",
        "count_Adult",
        "count_Elder",
        "price_Infant",
        "price_Children",
        "price_Adolescence",
        "price_Adult",
        "price_Elder",
        "sumPrice",
        "priceRange_id",
        //
        "time_end",
        "checkAuth",
        //
    ];

    protected $table = "dining_tables";
    protected $hidden = ['created_at', 'updated_at'];

    protected $fillable = [
        "user_id",
        "status_id",
        "count_Infant",
        "count_Children",
        "count_Adolescence",
        "count_Adult",
        "count_Elder",
        "price_Infant",
        "price_Children",
        "price_Adolescence",
        "price_Adult",
        "price_Elder",
        "sumPrice",
        "priceRange_id",
        //
        "time_end",
        "checkAuth",
        //
    ];

    public function diningTableStatus()
    {
        return $this->belongsTo(DiningTableStatus::class, "status_id", "id");
    }

    public static function checkTable($tableNumber)
    {
        return self::whereUserId($tableNumber)->whereIn("status_id", [1, 2, 3])->first();
    }

    public function priceRange()
    {
        return $this->belongsTo(PriceRange::class, "priceRange_id", "id");
    }

    public function detailTable()
    {
        return $this->belongsTo(User::class, "user_id", "id")->select("id", "name");
    }

    public function userProfile()
    {
        return $this->belongsTo(User::class, "user_id", "id")->select("id", "email", "pw");
    }

    public static function table($id)
    {
        return self::whereId($id)
            ->with("detailTable", "diningTableStatus", "priceRange")
            ->first();
    }


    public static function sumPrice($count, $price)
    {
    }

    public static function checkUUID($uuid = null)
    {
        $check = DiningTable::where("checkAuth", $uuid)
            ->whereIn("status_id", [1, 2])
            ->whereDate("created_at", \Carbon\Carbon::now())
            ->first();

        if ($check === null && $uuid != null) {
            Auth::logout();
            return false;
        }

        return true;
    }

    public static function findByUserID()
    {
        $data = DiningTable::whereUserId(Auth::user()->id)
            ->whereIn("status_id", [1, 2, 3])
            ->with("detailTable", "priceRange")
            ->first();

        return $data;
    }


    public static function findByUserIDStatusUse()
    {
        $data = DiningTable::whereUserId(Auth::user()->id)
            ->whereIn("status_id", [1])
            ->first();

        if ($data === null) {
            return false;
        }

        return true;
    }
}
