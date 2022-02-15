<?php

namespace App;

use App\ShabuNooNee\DiningTable;
use App\Order\UserType;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;


class User extends Authenticatable implements JWTSubject
{
    use Notifiable;
    const DEFAULT_TYPE = 0;
    const ADMIN_TYPE = 1;
    const CUSTOMER_TYPE = 2;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
        "type_name", "type"
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function isAdmin()
    {
        return $this->type === self::ADMIN_TYPE;
    }

    public function isCustomer()
    {
        return $this->type === self::CUSTOMER_TYPE;
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function userType()
    {
        return $this->belongsTo(UserType::class, "type", "id");
    }

    public function table()
    {
        return $this->hasOne(DiningTable::class, "user_id", "id")->whereIn("status_id", [1, 2, 3]);
    }
}
