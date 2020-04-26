<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FormatData extends Model
{
    public static function CurrencyToString($value)
    {
        $exlodes = explode(',',$value);
        $data = '';
        foreach($exlodes as $exlode){
            $data .= $exlode;
        }
        return $data;
    }
}
