@extends('layouts.app')
@section('beforecss')
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('css/AdminLTE.min.css') }}">
@endsection

@section('content')

    <div id="transparent-dark">
        <div class="container">
            <div class="row" style="margin-top: 10%;">
                <div class="col-md-6 col-md-offset-3">
                    <a href="{{route('meal.logout')}}" class="btn btn-info btn-block btn-flat" style="margin-bottom: 40px;">Logout</a>
                    <form class="form-horizontal loginbox" method="GET" action="{{ route('meal.check_serve') }}">
                        {{ csrf_field() }}
                        <h4 class="sub-header" style="margin-bottom: 30px">Serve Meal</h4>
                        {{--<div class="form-group{{ $errors->has('search') ? ' has-error' : '' }}">--}}
                            <input type="text" name="code" required value="{{ old('code') }}"
                                   placeholder="Enter 4-Digit Code (ERE2)" class="form-control" maxlength="4">
                            {{--<span class="input-group-btn">--}}
                              {{--<button type="submit" class="btn btn-info btn-flat"><i class="fa fa-" aria-hidden="true"></i> SERVE</button>--}}
                            {{--</span>--}}
                        {{--</div>--}}
                        @if ($errors->has('code'))
                            <span class="help-block">
                                <strong>{{ $errors->first('code') }}</strong>
                            </span>
                        @endif
                        <br>
                        <div class="form-group">
                            {{--<div class="col-md-3 col-md-offset-4">--}}
                            <button type="submit" styl="color: #888;" class="btn btn-flat btn-success">
                                SERVE
                            </button>
                            {{--</div>--}}
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /.content-wrapper -->
@endsection