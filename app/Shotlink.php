<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shotlink extends Model
{
  // protected $connection = 'mysql2';

  const UPDATED_AT = null;

  public static function shorten($url)
  {
    // request()->validate([
    //
    // ])
    $s = Shotlink::where('url',$url)->first();
    if (empty($s)) {
      $s = new Shotlink;
      $s->key_link = \Carbon\Carbon::now()->getTimestamp();
      $s->url = $url;
      $s->save();
    }

    return action('ShotlinkController@redirect',['id' => $s->id , 'key_link' => $s->key_link]);
  }

}
