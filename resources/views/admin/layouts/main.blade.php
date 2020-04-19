<html lang="en" dir="ltr" ng-app="myApp">
  <head>
    <title>ปั้นแป้ง เบเกอรี่ ปราณบุรี @yield('title')</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Sarabun" rel="stylesheet">
    {!! Html::style('css/me.css') !!}
    {!! Html::script('https://ajax.googleapis.com/ajax/libs/angularjs/1.7.8/angular.min.js') !!}

  </head>
  <body class="bg-dark">


    @include('admin.layouts.navbar')

    <div class="container-fluid bg-light" ng-controller="controller">
      <div class="container pt-4 pb-3 mt-5">
        {{-- @if (Auth::user()->password)
          <div class="alert alert-warning">
            บัญชีของคุณ ยังไม่ได้สร้างรหัสผ่าน โปรดสร้างรหัสผ่านได้ที่ "บัญชีของฉัน"
          </div>
        @endif --}}
        @yield('body')
        @yield('footer')
      </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  </body>
</html>
