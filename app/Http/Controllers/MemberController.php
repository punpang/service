<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session ,URL;
use App\Member;
use App\MSms;
use App\Shotlink;
use App\Summary_score_of_member;
use App\Tb_bill_sale;
use App\A_log_end_point;
use App\User;
use Auth;
use App\Tb_coupon;
use App\Linenotify;
use App\Tb_coupon_detail;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   public function index()
   {
     if (Auth::user()) {
       return redirect()->action('MemberController@dashboard');
     }else {
       return view('members.index');
     }
   }

   public function signin()
   {
     if (Auth::user()) {
       return redirect()->action('MemberController@dashboard');
     }
     return view('members.signin');
   }

   public function SignInCheck()
   {
    if (request('phone')[0] != 0) {
      Session::flash('danger', 'โปรดกรอกขึ้นต้นด้วยเลข 0');
      return back()->withInput();
    }

    request()->validate([
      'phone' => 'digits:10|numeric'//|unique:customers,tel
    ],[
      'phone.digits' => 'โปรดกรอกหมายเลขโทรศัพท์ 10 หลัก',
      'phone.numeric' => 'โปรดกรอกเป็นตัวเลขเท่านั้น',
    ]);

    $member = Member::where('member_tel',request('phone'))->first();

    if ($member == null) {
      Session::flash('warning','คุณยังไม่ได้เป็นสมาชิก โปรดสมัครสมาชิกก่อนค่ะ');
      return redirect()->action('MemberController@check');
    }else {
      $addMiutes = \Carbon\Carbon::now()->addMinutes(5);
      $url_sms = URL::temporarySignedRoute('signin.member.check',$addMiutes,['phone'=> request('phone')]);
      $shotlink = Shotlink::shorten($url_sms);
      // (new Linenotify)->line($shotlink);

      $SMS = MSms::Sms(request('phone'),'ปั้นแป้ง สวัสดีค่ะ คลิกลิงก์ => '.$shotlink.' <= เพื่อเข้าสู่ระบบค่ะ ลิงก์หมดอายุ '.\Carbon\Carbon::parse($addMiutes)->format("d-m-Y H:i:s") );
      Session::flash('success','ระบบได้ส่ง SMS ไปที่หมายเลข '.request('phone').' คลิกลิงก์เพื่อเข้าสู่ระบบค่ะ');
      return redirect()->action('MemberController@processed');
    }

    dd(request()->all());
   }


    public function check()
    {
      $phone = '';
      return view('members.check',compact('phone'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function checked()
    {
      // return Member::get();

      // dd(MSms::Sms('0864735562',$url_sms));
      // dd(Member::all());
      if (request('phone')[0] != 0) {
        Session::flash('danger', 'โปรดกรอกขึ้นต้นด้วยเลข 0');
        return back()->withInput();
      }

      request()->validate([
        'phone' => 'digits:10|numeric|unique:store.tb_member,member_tel'//|unique:customers,tel
      ],[
        'phone.digits' => 'โปรดกรอกหมายเลขโทรศัพท์ 10 หลัก',
        'phone.numeric' => 'โปรดกรอกเป็นตัวเลขเท่านั้น',
        'phone.unique' => 'หมายเลข '.request('phone').' มีผู้ใช้งานแล้ว'
      ]);

      $addMiutes = \Carbon\Carbon::now()->addMinutes(15);
      $url_sms = URL::temporarySignedRoute('signed.member.signup',$addMiutes,['phone'=> request('phone')]);
      $shotlink = Shotlink::shorten($url_sms);

      $SMS = MSms::Sms(request('phone'),'ปั้นแป้ง สวัสดีค่ะ คลิกลิงก์ => '.$shotlink.' <= เพื่อเปิดเว็บเพื่อสมัครสมาชิกค่ะ ลิงก์หมดอายุ '.\Carbon\Carbon::parse($addMiutes)->format("d-m-Y H:i:s") );
      if($SMS == 400)
      {
        Session::flash('danger', 'ขออภัยค่ะ ! ขณะระบบ SMS ขัดข้อง โปรดลองใหม่อีกครั้งภายหลังค่ะ');
        return back();
      }
      Session::flash('success', 'รอรับลิงก์สำหรับสมัครได้ที่ SMS หมายเลข '.request('phone'));
      return redirect()->action('MemberController@processed');

      // $member = new Member;
      // $member->member_code = request('phone');
      // $member->member_tel = request('phone');
      // $member->
    }

    public function signup($phone)
    {
      return view('members.signup',compact('phone'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        request()->validate([
          'name' => 'required',
          'phone' => 'digits:10|numeric|unique:store.tb_member,member_tel',//|unique:customers,tel
          'condition' => 'required|boolean'
        ],[
          'name.required' => 'โปรดกรอกชื่อลูกค้า',
          'phone.digits' => 'โปรดกรอกหมายเลขโทรศัพท์ 10 หลัก',
          'phone.numeric' => 'โปรดกรอกเป็นตัวเลขเท่านั้น',
          'phone.unique' => 'คุณเคยสมัครสมาชิกด้วยหมายเลข '.request('phone').' แล้ว',
          'condition.required' => 'โปรดอ่านและยอมรับเงื่อนไข'
        ]);

        $member = new Member;
        $member->member_code = request('phone');
        $member->member_tel = request('phone');
        $member->member_name = request('name');
        $member->member_created_date = \Carbon\Carbon::now();
        $member->branch_id = 1;
        $member->member_group_id = '7';
        $member->pay_type = 'cash';
        $member->credit_term = 0;
        $member->type_sale = 'no';
        $member->status = 'use';
        $member->save();

        MSms::Sms($member->member_tel,'สมัครสมาชิกเรียบร้อย ในนามคุณ '.$member->member_name.' หมายเลขโทรศัพท์ '.$member->member_tel.' รายละเอียดเพิ่มเติมคลิกลิงก์ => http://bit.ly/pp-condition <=');

        Session::flash('success', 'สมัครสมาชิกสำเร็จ สามารถใช้งานได้แล้วค่ะ');
        return redirect()->route('member.processed');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function condition()
    {
        return view('members.condition');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function analyze_age_of_member()
    {
      $members = Summary_score_of_member::where('score_total','>',0)
        ->select('member_id')
        ->get();

        // $day_of_last_bill = DB::connection('mysql')
        //   ->table('tb_bill_sale')
        //   ->where([
        //     ['member_id',2],
        //     ['bill_sale_status','pay']
        //   ])
        //   ->orderBy('bill_sale_created_date','DESC')
        //   ->select('bill_sale_created_date')
        //   ->first();
        //   dd($day_of_last_bill);

      foreach ($members as $member) {
          // echo $member->member_id.'<br />';
        $day_of_last_bill = Tb_bill_sale::where([
            ['member_id',$member->member_id],
            ['bill_sale_status','pay']
          ])
          ->orderBy('bill_sale_created_date','DESC')
          ->select('bill_sale_created_date','member_id')
          ->first();

          if(!empty($day_of_last_bill->bill_sale_created_date))
          {
            $ParseDay = \Carbon\Carbon::parse($day_of_last_bill->bill_sale_created_date);
            $diffDays = $ParseDay->diffInDays(\Carbon\Carbon::now()->format('Y-m-d'));
            // echo $diffDays;
            if ($diffDays == 84) {
              // echo $day_of_last_bill->score_total;
              // echo $day_of_last_bill->member;
              // MSms::Sms($day_of_last_bill->member->member_tel,'ปั้นแป้ง สวัสดีค่ะ คุณ '.$day_of_last_bill->member->member_name.' ไม่ได้ทำรายการเป็นเวลา 84 วัน คะแนนสะสมจำนวน '.$day_of_last_bill->score_total->score_total.' คะแนน หมดอายุแล้ว เพื่อรักษาคะแนนสะสม โปรดเลือกซื้อสินค้าภายในวันที่ 22-04-2562 (อีก 4 วัน) ไม่มียอดซื้อขั้นต่ำค่ะ รายละเอียดคลิกลิงก์ => http://bit.ly/pp-condition <=' );
            }

          }

        }
      }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function return_points()
    {
        $refunds = A_log_end_point::where('point','<',0)->orderBy('date_time','ASC')->take(1)->get();
        // $member = Member::select('member_id')->get();
        foreach ($refunds as $refund) {

          $re = A_log_end_point::where([
            ['member_id',$refund->member_id],
            ['point','<',0]
            ])->sum('point');


          $red = A_log_end_point::where([
            ['member_id',$refund->member_id],
            ['point','<',0]
            ])->update(['point' => $re*(-1)]);

          $score = Summary_score_of_member::where('member_id',$refund->member_id)->first();

          $score_new = $score->score_total+($re*(-1));
          // dd($re*(-1),$score->score_total,$score->score_total+($re*(-1)));
          $SMS = MSms::Sms($refund->member->member_tel,'ปั้นแป้ง สวัสดีค่ะ คุณได้รับคะแนนสะสมคืนจำนวน '.$re*(-1).' คะแนน คะแนนคงเหลือเดิม '.$score->score_total.' คะแนน รวม '.$score_new.' คะแนน รายละเอียดเพิ่มเติมคลิกลิงก์ => http://bit.ly/pp-condition <=');

          $score->score_total = $score->score_total+($re*(-1));
          $score->save();

          return $refund->member->member_tel.' || '.$refund->member_id.' || '.$SMS;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function check_signin($phone)
    {
      $check = Shotlink::where('url',url()->full())
        ->select('id','use_for_signin')
        ->first();

      if ($check->use_for_signin == 0) {
        return view('members.check_signin',compact('phone','check'));
      }else {
        Session::flash('danger','ไม่สามารถเข้าสู่ระบบ อย่างปลอดภัยได้ค่ะ กรุณาลองใหม่อีกครั้งค่ะ');
        return redirect()->action('MemberController@index');
      }

    }

    public function SignInDone()
    {
      // dd(request('phone'));
      $check = Shotlink::find(request('check'));

      if ($check->use_for_signin == 0) {
        $user = User::where('phone',request('phone'))->first();
        if($user == null)
        {
          $member = Member::where('member_tel',request('phone'))->select('member_id','member_name','member_tel')->first();
          $user = new User;
          $user->name = $member->member_name;
          $user->phone = $member->member_tel;
          $user->type = User::DEFAULT_TYPE;
          $user->save();
        }

        Auth::loginUsingId($user->id);
        if(Auth::user())
        {
          // (new Linenotify)->line('เข้าสู่ระบบ PUNPANG MEMBER โปรดแจ้ง! หากคุณไม่ได้เข้าสู่ระบบ 091-885-3402');
          MSms::Sms(request('phone'),'เข้าสู่ระบบ PUNPANG MEMBER โปรดแจ้ง! หากคุณไม่ได้เข้าสู่ระบบ 091-885-3402');

          // dd($check);
          $check->use_for_signin = '1';
          $check->save();

          return redirect()->action('MemberController@dashboard');
        }
      }else {
        Session::flash('danger','ไม่สามารถเข้าสู่ระบบ อย่างปลอดภัยได้ค่ะ กรุณาลองใหม่อีกครั้งค่ะ');
        return redirect()->action('MemberController@index');
      }

    }

    public function dashboard()
    {
      return redirect()->action('MemberController@HistoryPurchase');

      // return view('members.dashboard');
    }

    public function HistoryPurchase()
    {
      $member = Member::findMember();
      $bills = $member->HistoryPurchase;
      return view('members.HistoryPurchase',compact('bills'));
    }

    public function PointCoupon()
    {
      $member = Member::findMember();
      // $point = $member->PointCoupon;
      return view('members.PointCoupon',compact('member'));
    }

    public static function CreateCoupon()
    {
      $member = Member::findMember();
      // $point = $member->PointCoupon;
      $coupons = Tb_coupon::Coupon()->get();
      return view('members.CreateCoupon',compact('coupons','member'));
    }

    public static function ConfirmCoupon($CouponId)
    {
      $member = Member::findMember();
      $coupon = Tb_coupon::find($CouponId);

      return view('members.ConfirmCoupon',compact('coupon','member'));
    }

    public function NewCoupon()
    {
      $member = Member::findMember();
      $point = $member->PointCoupon;
      $coupon = Tb_coupon::find(request('CouponId'));

      if ($point->score_total >= $coupon->value and $coupon->status == 'use') {
        try {
          $new = new Tb_coupon_detail;
          $new->coupon_id = $coupon->id;
          $new->serial = $member->member_id.'-'.\Carbon\Carbon::now()->getTimestamp();
          $new->created = \Carbon\Carbon::now();
          $new->expire = \Carbon\Carbon::now()->addYears(1);
          $new->status = 'unuse';
          $new->member_id = $member->member_id;
          $new->save();

          $DisPoint = Summary_score_of_member::where('member_id',$member->member_id)->select('id','score_total')->first();
          $DisPoint->score_total = $DisPoint->score_total - $coupon->value;
          $DisPoint->save();

          // (new Linenotify)->line('หมายเลขคูปอง '.$new->serial.' มูลค่า '.$coupon->value.'฿ หมดอายุ '.\Carbon\Carbon::parse($new->expire)->addYears(543)->format('d/m/Y H:i:s'));
          MSms::Sms($member->member_tel,'ปั้นแป้ง สวัสดีค่ะ หมายเลขคูปอง '.$new->serial.' มูลค่า '.$coupon->value.'฿ หมดอายุ '.\Carbon\Carbon::parse($new->expire)->addYears(543)->format('d/m/Y H:i:s'));

          // Session::flash('success','แลกคูปองสำเร็จ คุณจะได้รับ ')
          Session::flash('success','แลกคูปองสำเร็จ');
          return redirect()->action('MemberController@ECoupon', $new->id);

        } catch (\Exception $e) {
          Session::flash('danger','ไม่สามารถทำรายการได้ กรุณาลองใหม่อีกครั้ง');
          return redirect()->action('MemberController@PointCoupon');
        }

      }else {
        Session::flash('danger','คุณไม่สามารถแลกคูปองได้ เนื่องจากคะแนนสะสมไม่เพียงพอ');
        return redirect()->action('MemberController@PointCoupon');
      }

    }

    public function ECoupon($CouponId)
    {
      $member = Member::findMember();
      $coupon = Tb_coupon_detail::find($CouponId);
      $bill = Tb_bill_sale::where([
        // ['status','normal'],
        ['coupon_detail_id',$coupon->serial]
      ])->first();
      if ($member->member_id == $coupon->member_id) {
        return view('members.ECoupon',compact('coupon','member','bill'));
      }else {
        Session::flash('danger','คุณไม่มีสิทธิ์เข้าถึงคูปองดังกล่าว');
        return redirect()->action('MemberController@PointCoupon');
      }
    }

    public function MyCoupon()
    {
      $member = Member::findMember();
      $coupons = Tb_coupon_detail::where([
        ['member_id',$member->member_id]
        ])->orderBy('created','DESC')->get();

      return view('members.MyCoupon',compact('coupons','member'));
    }

    public function processed()
    {
      return view('members.processed');
    }
}
