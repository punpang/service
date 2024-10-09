<?php

namespace App;

use App\URL;
use Request;
use App\Order\Setting;
use App\Notifications\LineNotification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Linenotify extends Model
{
    use Notifiable;

    protected $table = 'lines';

    public $timestamps = false;

    protected function routeNotificationForLine()
    {
        $setting = Setting::first();
        return $setting->line_key_notify;
        return "aFrDdvbflGulc1vsErMtF6LyIGzjxk2zmnJ0xhfNrDn";

        if (
            URL::base() == "https://punpang.online" ||
            URL::base() == "https://www.punpang.online"
        ) {
            $target = "en4wdRyp7E3aKReZVmQXtLSIYHsdfbSWkKosx4COKeR"; // PP-Order
        } else {
            $target = "aFrDdvbflGulc1vsErMtF6LyIGzjxk2zmnJ0xhfNrDn"; // Line Test
        }
        // aFrDdvbflGulc1vsErMtF6LyIGzjxk2zmnJ0xhfNrDn บอททดลอง

        return $target;

        // NAWpRL0qfXJk3YgnvRhQWWNqDrC8j6xK2XvQlGNjrHO // momday
        // en4wdRyp7E3aKReZVmQXtLSIYHsdfbSWkKosx4COKeR

        // if (Request::is('admin/best-express/*') or Request::is('best-express/*')) {
        //   $target = 'best';
        //   // ScJ97aIdk3Lk9PvKWsjsFfzaJtSqU0A5EoEAggH19Ja //ทดสอบ BEST Express Test
        // }else if (Request::is('admin/order/*') or Request::is('order/*')) {
        //   $target = 'ORDER';
        //   // c742h8lSRqhcCWGs9raMKSKQKxXe2lddL0rMIr7OzII //NY62
        // }else {
        //   $target = 'ORDER';
        // }


        // $line = $this->where('target',$target)->first();
        // return $line->key;

        // return 'tQHzQpNoBJcvE8EQA89eom4ju0k6b3jlO5vkUjv2Qws';
        // return 'c742h8lSRqhcCWGs9raMKSKQKxXe2lddL0rMIr7OzII'; // NY62
        // return 'en4wdRyp7E3aKReZVmQXtLSIYHsdfbSWkKosx4COKeR'; // PP-Order
        // VuALSykAt2HiwYKsKuuWGLUEatDyBDmWZWrQFneqNlY // น้องแป้งรายงาน

    }

    public function line($message)
    {
        // $messaged = urlencode($message);
        // $curl = curl_init();

        // curl_setopt_array($curl, array(
        //     CURLOPT_URL => 'https://api.pushover.net/1/messages.json?token=aurobm79ezqcsrx6643g36oz6nurpb&message=' . urlencode($message) . '&user=u7b7kvtdh5vu872cx9zkytaaowfgs5&title=PUNPANG',
        //     CURLOPT_RETURNTRANSFER => true,
        //     CURLOPT_ENCODING => '',
        //     CURLOPT_MAXREDIRS => 10,
        //     CURLOPT_TIMEOUT => 0,
        //     CURLOPT_FOLLOWLOCATION => true,
        //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        //     CURLOPT_CUSTOMREQUEST => 'POST',
        // ));

        // $response = curl_exec($curl);

        // curl_close($curl);
        // echo $response;

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.telegram.org/bot7865201344:AAGXWxLbiX4WNTEWCjaE0yUng6iygYX3zTM/sendMessage?chat_id=-4528608055&text=' . urlencode($message),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
        ));

        // $response = curl_exec($curl);

        curl_close($curl);
        // echo $response;

        $this->notify(new LineNotification($message));
    }

    public static function send($message)
    {
        return (new Linenotify)->line($message);
    }
}
