@extends('layouts.app')
@section('beforecss')
<!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('css/AdminLTE.min.css') }}">
    <style>
        html,body{
            height:100%;
        }
        #transparent-dark {
            height: 100%;
            width: 100%;
            display: table;
        }
        .container{
            height:100%;
            display:table-cell;
            vertical-align: middle;
        }
        .loginbox{
            max-width:400px;
            width:400px;
            margin:0 auto;
        }
    </style>
@endsection

@section('content')

<div id="transparent-dark">
	<div class="container">
		<div class="row">
            <div class="login-form">
			<div class="col-lg-4 col-md-4 col-md-offset-4">

                            <form class="loginbox" method="POST" action="{{ route('login') }}">
                                {{ csrf_field() }}
                                <h4 class="sub-header" style="margin-bottom: 30px">CAMP Manager</h4>
                                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                    <input id="email" placeholder="Enter Email Address" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
                                </div>

                                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                    <input id="password" placeholder="Enter Password" type="password" class="form-control" name="password" required>
                                </div>

                                <div class="form-group">
                                    {{--<div class="col-md-8 col-md-offset-2">--}}
                                    <div class="checkbox">
                                        {{--<label class="text-color">--}}
                                            {{--<input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me--}}
                                        {{--</label>--}}

                                        {{--<a class="btn btn-link" href="{{ route('password.request') }}">--}}
                                        {{--Forgot Your Password?--}}
                                        {{--</a>--}}
                                    </div>
                                    {{--</div>--}}
                                </div>

                                <div class="form-group">
                                    {{--<div class="col-md-3 col-md-offset-4">--}}
                                    <button type="submit" style="color: #888;" class="btn btn-flat btn-labl">
                                        Login
                                    </button>
                                    {{--</div>--}}
                                </div>
                            </form>
                        </div>
			</div>
		</div>
	</div>
</div>

@endsection