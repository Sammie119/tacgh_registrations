@extends('layouts.app')
@section('beforecss')
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('css/AdminLTE.min.css') }}">
@endsection

@section('content')

    <div id="transparent-dark">
        <div class="container">
            <div class="row" style="margin-top: 10%;">
                <div class="col-md-4 col-md-offset-4">
                    {{--<div class="row" style="margin-top: 40px">--}}
                    {{-- <div styl="padding: 25px 15px 15px; background: rgba(8, 22, 15, 0.3);"> --}}
                    <form class="loginbox" method="POST" action="{{ route('meal.server') }}">
                        {{ csrf_field() }}
                        <h4 class="sub-header" style="margin-bottom: 30px">Meal Server</h4>
                        <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                            {{--<label for="email" class="col-md-5 control-label">E-Mail Address</label>--}}

                            {{--<div class="col-md-7">--}}
                            <input id="username" placeholder="Enter username" type="text" class="form-control" name="username" value="{{ old('username') }}" required autofocus>

                            @if ($errors->has('username'))
                                <span class="help-block">
                                <strong>{{ $errors->first('username') }}</strong>
                            </span>
                            @endif
                            {{--</div>--}}
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            {{--<label for="password" class="col-md-5 control-label">Password</label>--}}

                            {{--<div class="col-md-7">--}}
                            <input id="password" placeholder="Enter Password" type="password" class="form-control" name="password" required>

                            @if ($errors->has('password'))
                                <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                            @endif
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
                    {{-- </div> --}}
                    {{--</div>--}}
                </div>
            </div>
        </div>
    </div>

@endsection