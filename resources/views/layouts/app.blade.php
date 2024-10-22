<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>APOSA Campmeeting {{date('Y')}}</title>
    <link rel="icon" href="{{ asset('img/aposa-favicon.png') }}" type="image/x-icon">
    <!-- Styles -->
    {{--<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">--}}
    <link rel="stylesheet" href="{{asset('css/jquery-ui.min.css')}}">
    {{--<script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>--}}
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{asset('css/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/main.css')}}" rel="stylesheet">
    <link href="{{asset('css/sweetalert.css')}}" rel="stylesheet">
    <link href="{{asset('css/jquery.toast.min.css')}}" rel="stylesheet">

    <!-- Fonts -->
    {{--<link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">--}}

    <!-- Styles -->
    <link href="{{ asset('css/normalize.css') }}" rel="stylesheet">
    <link href="{{ asset('css/indexstyle.css') }}" rel="stylesheet">
    <link href="{{ asset('css/landingpage.css') }}" rel="stylesheet">
    {{--<script src="https://code.jquery.com/jquery-1.12.4.js"></script>--}}
    <script src="{{asset('plugins/jQuery/jquery-2.2.3.min.js')}}"></script>
    {{--<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>--}}
    <script src="{{asset('plugins/jQueryUI/jquery-ui.min.js')}}"></script>

    @yield('beforecss')
    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode(['csrfToken' => csrf_token()]) !!};
    </script>

</head>
<body>
@yield('content')
{{--</div>--}}

{{--<script src="{{ asset('js/app.js') }}"></script>--}}
{{--<script src="{{ asset('js/sweetalert.min.js') }}"></script>--}}
{{--<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>--}}
{{--<script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>--}}
{{--<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>--}}

<script src="{{ asset('js/jquery.toast.min.js') }}"></script>
@include('sweetalert::alert')


{{--<script src="{{ asset('js/jquery.maskedinput.js') }}"></script>--}}
<script>
    $(window).on('load',function() {
        $(".loader").fadeOut("slow");
    });
    //Check if there is a flash message
        @if(notify()->ready()){
        swal({
            title:"{!! notify()->message() !!}",
            {{--                text:"{!! notify()->option('text') !!}",--}}
            text:"{!!  notify()->option('text')!!}",
            type:"{!! notify()->type() !!}"
        });
    }
    @endif
    $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    })
    function showAlert(title,text,type) {

        $.toast(
            {
                heading: title,
                text: text,
                icon: type,
                loader: true,        // Change it to false to disable loader
                loaderBg: '#9EC600', // To change the background
                position:'mid-center',
                hideAfter:false
            }
        );
    }
</script>
@yield('footerscripts')
</body>
</html>
