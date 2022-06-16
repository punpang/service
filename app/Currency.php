<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    public static function change($value)
    {
        $exlodes = explode(',',$value);
        $data = '';
        foreach($exlodes as $exlode){
            $data .= $exlode;
        }
        return $data;
    }
}
