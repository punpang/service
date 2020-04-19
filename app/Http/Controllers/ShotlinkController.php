<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use URL ,Redirect;
use App\Shotlink;

class ShotlinkController extends Controller
{
    public function test()
    {
      $addMiutes = \Carbon\Carbon::now()->addMinutes(15);
      $url_sms = URL::temporarySignedRoute('test.member.signin.check',$addMiutes,['phone'=> '0864735562']);

      // return $url_sms;

      // $url_sms = 'https://www.punpang.ml';
      $shotlink = Shotlink::shorten($url_sms);

      return $shotlink;
    }

    public function signintest()
    {
      dd(Session::has('signin'));
      return view('members.signin');
    }

    public function redirect($id,$key_link)
    {
      // http://isname.thddns.net:6331/test/r/4/1556336983
      $s = Shotlink::where([
        ['id',$id],
        ['key_link',$key_link]
        ])->firstOrFail();
      return Redirect::to($s->url);
    }
}
