<?php

namespace App\Order;

use Illuminate\Database\Eloquent\Model;

class RewardGroup extends Model
{
    protected $table = "reward_groups";
    protected $hidden = ["created_at", "updated_at"];
}
