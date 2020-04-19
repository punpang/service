<nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-best">
  <a class="navbar-brand" href="#">Best Express</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>

  </button>
  <div class="collapse navbar-collapse" id="navbarNavDropdown">
    @if (Auth::Check())
      <ul class="navbar-nav">
        {{-- <li class="nav-item">
          <a class="nav-link" href="{{ action('MemberController@PointCoupon') }}">คะแนนสะสม/คูปอง</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">บัญชีของฉัน</a>
        </li> --}}
        <li class="nav-item dropdown active">
          <a class="nav-link dropdown-toggle" href="{{ action('BestExpress\TrackingController@index') }}">
            DASHBOARD
          </a>
        </li>

        <li class="nav-item dropdown active">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            พัสดุ
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <a class="dropdown-item" href="{{ action('BestExpress\TrackingController@SenderFind') }}">ลงทะเบียนพัสดุ</a>
            <a class="dropdown-item" href="#">ค้นหาพัสดุ</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="{{ action('BestExpress\TrackingController@importExportView') }}">นำเข้าพัสดุ</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="{{ action('BestExpress\TrackingController@index') }}">DASHBOARD</a>
          </div>
        </li>

        <li class="nav-item dropdown active">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            ผู้ส่ง
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <a class="dropdown-item" href="{{ action('BestExpress\SenderController@index') }}">รายชื่อทั้งหมด</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="{{ action('BestExpress\SenderController@create') }}">สร้างรายชื่อใหม่</a>
            <a class="dropdown-item" href="#">ค้นหารายชื่อ</a>

            <a class="dropdown-item" href="{{ action('BestExpress\TrackingController@index') }}">รายชื่อ</a>
            <div class="dropdown-divider"></div>
          </div>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="{{ action('Order\AOrderController@DashboardToday') }}">Order<span class="sr-only">(current)</span></a>
        </li>
      </ul>


    @endif

    <ul class="navbar-nav ml-auto">
        <!-- Authentication Links -->
        @guest
            <li class="nav-item">
                <a class="nav-link" href="{{ action('MemberController@signin') }}">{{ __('เข้าสู่ระบบ') }}</a>
            </li>
        @else
            <li class="nav-item dropdown">
                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                    {{ Auth::user()->name }} <span class="caret"></span>
                </a>

                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                                     document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </li>
        @endguest
    </ul>
  </div>

</nav>
