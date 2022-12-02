<?php

namespace App\Order;

use App\URL;
use Exception;
use App\Order\AOrder;
use App\Order\Setting;
use Illuminate\Database\Eloquent\Model;

class KsherPay extends Model
{
    protected $primaryKey = 'mch_order_no';
    protected $table = "ksher_pays";
    protected $guarded = [];
    protected $appends = [];
    protected $hidden = ['created_at', 'updated_at'];

    public $time;
    public $appid; //ksher appid
    public $privatekey; // 私钥
    public $pubkey; //ksher公钥
    public $version; //SDK版本
    public $pay_domain;
    public $gateway_domain;

    public function __construct($appid = '', $privatekey = '', $version = '3.0.0')
    {
        $this->time = date("YmdHis", time());
        $this->appid = $appid;
        $this->privatekey = str_replace("\\n", "\n", env('PEM_KSHER_PAY')); //$privatekey;
        $this->version = $version;
        $this->pay_domain = 'https://api.mch.ksher.net/KsherPay';
        $this->gateway_domain = 'https://gateway.ksher.com/api';

        $this->pubkey = <<<EOD
-----BEGIN PUBLIC KEY-----
MFwwDQYJKoZIhvcNAQEBBQADSwAwSAJBAL7955OCuN4I8eYNL/mixZWIXIgCvIVE
ivlxqdpiHPcOLdQ2RPSx/pORpsUu/E9wz0mYS2PY7hNc2mBgBOQT+wUCAwEAAQ==
-----END PUBLIC KEY-----
EOD;
    }

    public static function create_qrcode_promptpay_by_facebook($order)
    {
        $datas = [
            "mch_order_no" => $order->id . "-" . KsherPay::generate_nonce_str(10),
            "total_fee" => round($order->sumBalance(), 2) * 100,
            "fee_type" => "THB",
            "expire_time" => 600
        ];

        $url_notify = URL::base() . '/api/callback/ksherPay';

        $datas["channel"] = "promptpay";
        $datas["notify_url"] = $url_notify;
        $ksher = self::native_pay($datas);

        $ksherDecode = json_decode($ksher, true);

        $new_KsherPay = new KsherPay;
        $new_KsherPay->mch_order_no = $datas["mch_order_no"];
        $new_KsherPay->result;
        $new_KsherPay->amount = $order->sumBalance();
        $new_KsherPay->total_fee = 0;
        $new_KsherPay->save();

        return $ksherDecode["data"]["imgdat"];
    }

    public function getSumTotalFeeAttribute()
    {
        return $this->sum("total_fee");
    }

    public function getUpdatedAtThAttribute()
    {
        return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $this->updated_at)->addYears(543)->format('d-m-Y H:i');
    }

    public function getCodeAttribute()
    {
        return $this->mch_order_no;
    }

    public function aOrder()
    {
        return $this->belongsTo(AOrder::class, "order_id", "id");
    }

    public static function updateStatusWhenCallbackSuccess($mch_order_no, $result)
    {
        if ($result == "SUCCESS") {
            $ksher = KsherPay::where("mch_order_no", $mch_order_no)->first();
            $ksher->result = "success";
            $ksher->update();
            return ["ksher" => $ksher, "result" => "success"];
        }
        return ["result" => "fail"];
    }

    public static function pubkey()
    {
        return <<<EOD
-----BEGIN PUBLIC KEY-----
MFwwDQYJKoZIhvcNAQEBBQADSwAwSAJBAL7955OCuN4I8eYNL/mixZWIXIgCvIVE
ivlxqdpiHPcOLdQ2RPSx/pORpsUu/E9wz0mYS2PY7hNc2mBgBOQT+wUCAwEAAQ==
-----END PUBLIC KEY-----
EOD;
    }


    public static function time()
    {
        return date("YmdHis", time());
    }

    public static function appid()
    {
        return env("KSHER_APP_ID");
    }

    public static function pay_domain()
    {
        return 'https://api.mch.ksher.net/KsherPay';
    }

    public static function gateway_domain()
    {
        return 'https://gateway.ksher.com/api';
    }

    public static function version($version = '3.0.0')
    {
        return $version;
    }

    public static function privatekey()
    {
        $setting = Setting::attribute_name("ksher_access_token");
        return <<<EOD
$setting
EOD;
    }

    public static function explodeOrderId($mch_order_no)
    {
        $orderID = (explode("-", $mch_order_no));

        return $orderID[0];
    }

    /**
     * 生成随机数
     */
    public static function generate_nonce_str($len = 16)
    {
        $nonce_str = "";
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";

        for ($i = 0; $i < $len; $i++) {
            $nonce_str .= $chars[mt_rand(0, strlen($chars) - 1)];
        }
        return $nonce_str;
    }
    /**
     * 生成sign
     * @param $data
     * @param $private_key_content
     */
    public static function ksher_sign($data)
    {
        $message = self::paramData($data);
        $private_key = self::privatekey();
        openssl_sign($message, $encoded_sign, $private_key, OPENSSL_ALGO_MD5);
        // openssl_free_key($private_key);
        $encoded_sign = bin2hex($encoded_sign);
        return $encoded_sign;
    }
    /**
     * 验证签名
     */
    public static function verify_ksher_sign($data, $sign)
    {
        $sign = pack("H*", $sign);
        $message = self::paramData($data);
        $res = openssl_get_publickey(self::pubkey());
        $result = openssl_verify($message, $sign, $res, OPENSSL_ALGO_MD5);
        // openssl_free_key($res);
        return $result;
    }
    /**
     * 处理待加密的数据
     */
    private static function paramData($data)
    {
        ksort($data);
        $message = '';
        foreach ($data as $key => $value) {
            $message .= $key . "=" . $value;
        }
        $message = mb_convert_encoding($message, "UTF-8");
        return $message;
    }
    /**
     * @access get方式请求数据
     * @params url //请求地址
     * @params data //请求的数据，数组格式
     * */
    public static function _request($url, $data = array())
    {
        try {
            $data['sign'] = self::ksher_sign($data);
            $queryData = http_build_query($data);

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $queryData);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/x-www-form-urlencoded'
            ));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            $output = curl_exec($ch);

            if ($output !== false) {
                $response_array = json_decode($output, true);
                if ($response_array['code'] == 0) {
                    if (!self::verify_ksher_sign($response_array['data'], $response_array['sign'])) {
                        $temp = array(
                            "code" => 0,
                            "data" => array(
                                "err_code" => "VERIFY_KSHER_SIGN_FAIL",
                                "err_msg" => "verify signature failed",
                                "result" => "FAIL"
                            ),
                            "msg" => "ok",
                            "sign" => "",
                            "status_code" => "",
                            "status_msg" => "",
                            "time_stamp" => self::time(),
                            "version" => self::version()
                        );
                        return json_encode($temp);
                    }
                }
            }
            curl_close($ch);
            return $output;
        } catch (Exception $e) {
            echo 'curl error';
            return false;
        }
    }
    /**
     * B扫C支付
     * 必传参数
     *    mch_order_no
     *    total_fee
     *    fee_type
     *    auth_code
     *    channel
     * 选传参数
     *    operator_id
     */
    public static function quick_pay($data)
    {
        $data['appid'] = self::appid();
        $data['nonce_str'] = self::generate_nonce_str();
        $data['time_stamp'] = self::time();
        $response = self::_request(self::pay_domain() . '/quick_pay', $data);
        return $response;
    }

    /**
     * C扫B支付
     * 必传参数
     *     mch_order_no
     *     total_fee
     *     fee_type
     *     channel
     *     notify_url
     * 选传参数
     *     redirect_url
     *     paypage_title
     *     operator_id
     */
    public static function jsapi_pay($data)
    {
        $data['appid'] = self::appid();
        $data['nonce_str'] = self::generate_nonce_str();
        $data['time_stamp'] = self::time();
        $response = self::_request(self::pay_domain() . '/jsapi_pay', $data);
        return $response;
    }

    /**
     * 动态码支付
     * 必传参数
     *     mch_order_no
     *     total_fee
     *     fee_type
     *     channel
     *     notify_url
     * 选传参数
     *     redirect_url
     *     paypage_title
     *     product
     *     attach
     *     operator_id
     *     device_id
     *     img_type
     */
    public static function native_pay($data)
    {
        $data['appid'] = self::appid();
        $data['nonce_str'] = self::generate_nonce_str();
        $data['time_stamp'] = self::time();
        $response = self::_request(self::pay_domain() . '/native_pay', $data);
        return $response;
    }

    /**
     * 小程序支付
     * 必传参数
     *      mch_order_no
     *      local_total_fee
     *      fee_type
     *      channel
     *      sub_openid
     *      channel_sub_appid
     * 选传参数
     *     redirect_url
     *     notify_url
     *     paypage_title
     *     product
     *     operator_id
     */

    public static function minipro_pay($data)
    {
        $data['appid'] = self::appid();
        $data['nonce_str'] = self::generate_nonce_str();
        $data['time_stamp'] = self::time();
        $response = self::_request(self::pay_domain() . '/mini_program_pay', $data);
        return $response;
    }
    /**
     * app支付
     * 必传参数
     *     mch_order_no
     *     total_fee
     *     fee_type
     *     channel
     *     sub_openid
     *     channel_sub_appid
     * 选传参数
     *     redirect_url
     *     notify_url
     *     paypage_title
     *     product
     *     attach
     *     operator_id
     *     refer_url 仅当channel为alipay时需要
     */
    public static function app_pay($data)
    {
        $data['appid'] = self::appid();
        $data['nonce_str'] = self::generate_nonce_str();
        $data['time_stamp'] = self::time();
        $response = self::_request(self::pay_domain() . '/app_pay', $data);
        return $response;
    }
    /**
     * H5支付，仅支持channel=alipay
     *
     * 必传参数
     *     mch_order_no
     *     local_total_fee
     *     fee_type
     *     channel
     *     refer_url
     * 选传参数
     *     redirect_url
     *     notify_url
     *     paypage_title
     *     product
     *     attach
     *     operator_id
     *     device_id
     */
    public static function wap_pay($data)
    {
        $data['appid'] = self::appid();
        $data['nonce_str'] = self::generate_nonce_str();
        $data['time_stamp'] = self::time();
        $response = self::_request(self::pay_domain() . '/wap_pay', $data);
        return $response;
    }
    /**
     * PC网站支付，仅支持channel=alipay
     * 必传参数
     *     mch_order_no
     *     local_total_fee
     *     fee_type
     *     channel
     *     refer_url
     * 选传参数
     *     redirect_url
     *     notify_url
     *     paypage_title
     *     product
     *     attach
     *     operator_id
     *     device_id
     */
    public static function web_pay($data)
    {
        $data['appid'] = self::appid();
        $data['nonce_str'] = self::generate_nonce_str();
        $data['time_stamp'] = self::time();
        $response = self::_request(self::pay_domain() . '/web_pay', $data);
        return $response;
    }
    /**
     * 订单查询
     * 必传参数
     *     mch_order_no、ksher_order_no、channel_order_no三选一
     */
    public static function order_query($data)
    {
        $data['appid'] = self::appid();
        $data['nonce_str'] = self::generate_nonce_str();
        $data['time_stamp'] = self::time();
        $response = self::_request(self::pay_domain() . '/order_query', $data);
        return $response;
    }
    /**
     * 订单关闭
     * 必传参数
     *     mch_order_no、ksher_order_no、channel_order_no三选一
     * 选传参数
     *     operator_id
     */
    public static function order_close($data)
    {
        $data['appid'] = self::appid();
        $data['nonce_str'] = self::generate_nonce_str();
        $data['time_stamp'] = self::time();
        $response = self::_request(self::pay_domain() . '/order_close', $data);
        return $response;
    }
    /**
     * 订单撤销
     * 必传参数
     *     mch_order_no、ksher_order_no、channel_order_no三选一
     * 选传参数
     *     operator_id
     */
    public static function order_reverse($data)
    {
        $data['appid'] = self::appid();
        $data['nonce_str'] = self::generate_nonce_str();
        $data['time_stamp'] = self::time();
        $response = self::_request(self::pay_domain() . '/order_reverse', $data);
        return $response;
    }
    /**
     * 订单退款
     * 必传参数
     *     total_fee
     *     fee_type
     *     refund_fee
     *     mch_refund_no
     *     mch_order_no、ksher_order_no、channel_order_no三选一
     * 选传参数
     *     operator_id
     */
    public static function order_refund($data)
    {
        $data['appid'] = self::appid();
        $data['nonce_str'] = self::generate_nonce_str();
        $data['time_stamp'] = self::time();
        $data['version'] = self::version();
        $response = self::_request(self::pay_domain() . '/order_refund', $data);
        return $response;
    }
    /**
     * 退款查询
     * 必传参数
     *     mch_refund_no、ksher_refund_no、channel_refund_no三选一
     *     mch_order_no、ksher_order_no、channel_order_no三选一
     */
    public static function refund_query($data)
    {
        $data['appid'] = self::appid();
        $data['nonce_str'] = self::generate_nonce_str();
        $data['time_stamp'] = self::time();
        $response = self::_request(self::pay_domain() . '/refund_query', $data);
        return $response;
    }
    /**
     * 汇率查询
     * 必传参数
     *     channel
     *     fee_type
     *     date
     */
    public static function rate_query($data)
    {
        $data['appid'] = self::appid();
        $data['nonce_str'] = self::generate_nonce_str();
        $data['time_stamp'] = self::time();
        $response = self::_request(self::pay_domain() . '/rate_query', $data);
        return $response;
    }
    /**
     *聚合支付商户查询订单支付状态
     * 必传参数
     * mch_order_no
     */
    public static function gateway_order_query($data)
    {
        $data['appid'] = self::appid();
        $data['nonce_str'] = self::generate_nonce_str();
        $data['time_stamp'] = self::time();
        $response = self::_request(self::gateway_domain() . '/gateway_order_query', $data);
        return $response;
    }
    /**
     *
     * 聚合支付商户通过API提交数据
     * :param kwargs:
     * 必传参数
     *   mch_order_no: 商户订单号 str
     *   total_fee: 金额(分) int
     *   fee_type: 货币种类 st
     *   channel_list: 支付通道 str
     *   mch_code: 商户订单code str
     *   mch_redirect_url: 商户通知url str
     *   mch_redirect_url_fail: 失败回调网址 str
     *   product_name: 商品描述 str
     *   refer_url: 商家refer str
     *   device: 设备名称(PC or H5) str
     * 选传参数
     *   color: 横幅颜色 str
     *   background: 横幅背景图片 str
     *   payment_color: 支付按钮颜色 str
     *   ksher_explain: 最下方文案 str
     *   hide_explain: 是否显示最下方文案(1显示 0不显示) int
     *   expire_time: 订单过期时间(min) int
     *   hide_exp_time: 是否显示过期时间(1显示 0不显示) int
     *   logo: 横幅logo str
     *   lang: 语言(en,cn,th) str
     *   shop_name: logo旁文案 str
     *   attach: 商户附加信息 str
     * :return:
     *   {'pay_content': 'https://gateway.ksher.com/mindex?order_uuid=订单uuid'}
     */
    public static function gateway_pay($data)
    {
        $data['appid'] = self::appid();
        $data['nonce_str'] = self::generate_nonce_str();
        $data['time_stamp'] = self::time();
        $response = self::_request(self::gateway_domain() . '/gateway_pay', $data);
        return $response;
    }
}
