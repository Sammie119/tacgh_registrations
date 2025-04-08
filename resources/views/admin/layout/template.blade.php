<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ get_current_event()->name }}</title>
  @yield('beforeAllCss')
  <link rel="icon" href="{{ App::isLocal() ? asset('img/aposa-favicon.png') : asset('public/img/aposa-favicon.png') }}" type="image/x-icon">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
  <!-- sweetalert style -->
  <link rel="stylesheet" href="{{ asset('css/sweetalert.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('css/AdminLTE.min.css') }}">
  <!-- AdminLTE Skins. Choose a skin from the css/skins -->
  <link rel="stylesheet" href="{{ asset('css/skins/_all-skins.min.css') }}">
  {{-- Custom css --}}
  <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

  @yield('afterAllCss')
  <style>
    .sidebar-menu{display:none}
    .membercard{width: 300px;border:1px solid #1b1b1b;height:100px;max-height:100px;display:table;margin:2px;}
    .membercard-header{display:table-cell;padding:2px;width:80px;vertical-align: middle;margin:2px;}
    .membercard-header-img{display:table-cell;padding:2px;width:80px;vertical-align: middle;margin:2px;}
    .membercard-header-text{width:215px;display:table-cell;vertical-align: middle;padding:0px;margin:0 !important;text-align: right;
      width:200px;margin:0 auto;padding:2px;}
    .membercard-header-text span{display:block;}
    .membercard-content{display: block;margin:2px;padding:2px;font-size: smaller}
    .content-text{width:100px;display: inline-block;}
  </style>
</head>
<body class="hold-transition fixed skin-blue-light sidebar-mini">
<div class="wrapper">

  <header class="main-header">

    <!-- Logo -->
    <a href="#" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>{{get_current_event()->code_prefix}}</b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>{{ get_current_event()->name }}</b></span>
    </a>

    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span >&nbsp;Role: ({{ Auth::user()->role->name }})</span>
      </a>
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">

        <ul class="nav navbar-nav">
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <span class="hidden-xs"> {{ Auth::user()->fullname }}&nbsp;<span class="caret"></span></span>
            </a>

            <ul class="dropdown-menu">
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="#" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a class="btn btn-default btn-flat" href="{{ route('logout') }}"
                     onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    Logout
                  </a>

                  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                  </form>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>

    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <section class="sidebar">
      <div class="user-panel">
        <div class="pull-left image" style="height:126px;width:inherit;background:url({{App::isLocal() ? asset('img/aposa-main_edit.png') : asset('public/img/aposa-main_edit.png') }}) no-repeat;background-size: 100%;">
          {{--<img src="{{ asset('img/aposa-main_edit.png') }}"  alt="The Apostolic Church" style="">--}}
        </div>
      </div>
      @if(Auth::check())
        <ul class="sidebar-menu">
          <li class="header" style="text-align:center">MAIN NAVIGATION</li>
          {!! $MyNavBar->asUl(array('class'=>'sidebar-menu')) !!}
          <li>
            <a  href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fa fa-sign-out"></i> <span>Log out</span></a>
            <form id="logout-form-main" action="{{ route('logout') }}" method="POST" style="display: none;">
              {{ csrf_field() }}
            </form>
          </li>
        </ul>
      @endif
    </section>
  </aside>

  @yield('content')


  <footer class="main-footer">
    <div class="pull-right hidden-xs">

{{--      <b style="margin-right:30px;"><a href="" >TAC-GH</a></b>--}}
      <b>Version</b> 4.0.0
    </div>
    <strong>Copyright &copy; <?php echo date('Y');?>
      <a href="https://www.theapostolicchurch.org.gh" target="_blank">The Apostolic Church-Ghana</a>.
    </strong> All rights reserved.
  </footer>

</div>
<!-- ./wrapper -->

<!-- jQuery 2.2.3 -->
<script src="{{ asset('plugins/jQuery/jquery-2.2.3.min.js') }}"></script>
<script src="{{asset('js/jquery.userTimeout.js')}}"></script>
{{--<script src="https://github.com/marcuswestin/store.js"></script>--}}
<script>
  $(document).ready(function() {
    $('.sidebar-menu').fadeIn();
    $('.treeview ul').addClass("treeview-menu");

    $(document).userTimeout({
      // URL to redirect to, to log user out
      logouturl:'{{route('logout')}}',
      // URL Referer - false, auto or a passed URL
      referer:false,
      // Name of the passed referal in the URL
      refererName:'refer',
      // Toggle for notification of session ending
      notify:true,
      // Toggle for enabling the countdown timer
      timer:true,
      // 10 Minutes in Milliseconds, then notification of logout
      session: 600000,
//      session: 500,
      ui:'auto',
      // Shows alerts
      debug:false,
      // <a href="https://www.jqueryscript.net/tags.php?/Modal/">Modal</a> Title
      modalTitle:'Session Timeout',
      // Modal Body
      modalBody:'You\'re being timed out due to inactivity. Please choose to stay signed in or to logoff. Otherwise, you will logged off automatically.',
      // Modal log off button text
      modalLogOffBtn:'Log Off',
      // Modal stay logged in button text
      modalStayLoggedBtn:'Stay Logged In'
    });
  });
</script>
<!-- jQuery 2.2.3 -->
<script src="{{ asset('js/vue.min.js') }}"></script>
<!-- Bootstrap 3.3.6 -->
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/jquery.slimscroll.min.js') }}"></script>
<!-- sweet alert -->
<script src="{{ asset('js/sweetalert.min.js') }}"></script>

{{-- @include('sweet::alert') --}}
@include('sweetalert::alert')

@section('afterMainScripts')

@show
<!-- FastClick -->
<script src="{{ asset('plugins/fastclick/fastclick.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('js/app.min.js') }}"></script>
<script src="{{ asset('js/cs-performance.js') }}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
{{--<script src="{{ asset('js/pages/dashboard2.js') }}"></script>--}}
<!-- AdminLTE for demo purposes -->
{{--<script src="{{ asset('js/demo.js') }}"></script>--}}
{{--<script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.min.js"></script>--}}
@yield('afterOtherScripts')
@if (Session::has('sweet_alert.alert'))
  <script>
    swal({!! Session::get('sweet_alert.alert') !!});
  </script>
  {{ Session::forget('sweet_alert') }}
@endif
<script type="text/javascript">
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
</script>


</body>
</html>