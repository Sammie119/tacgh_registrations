@extends('admin.layout.template')
@section('afterAllCss')
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
@endsection
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper bg-im">
        <section class="content">
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div id="run-search">
                        <div class="text-center">
                            <i class="fa fa-user" style="color: #ddd;font-size: 6vmax;" aria-hidden="true"></i>
                        </div>
                        <form class="form-horizontal" method="GET" action="{{ route('search') }}">
                            {{ csrf_field() }}
                            <div class="input-group input-group-sm{{ $errors->has('search') ? ' has-error' : '' }}">
                                <input type="text" name="search" required value="{{ old('search') }}"
                                       placeholder="Enter Registration ID" class="form-control">
                                <span class="input-group-btn">
                  <button type="submit" class="btn btn-info btn-flat"><i class="fa fa-search" aria-hidden="true"></i> SEARCH APPLICANT</button>
                </span>
                            </div>
                            @if ($errors->has('search'))
                                <span class="help-block">
                        <strong>{{ $errors->first('search') }}</strong>
                    </span>
                            @endif
                        </form>
                        <div class="text-center">
                            <i class="fa fa-users" style="color: #ddd;font-size: 6vmax;margin-top: 20px;" aria-hidden="true"></i>
                        </div>
                        <form class="form-horizontal" style="margin-top: 10px;" method="GET"
                              action="{{ route('assignBulk') }}">
                            {{ csrf_field() }}
                            <div class="input-group input-group-sm{{ $errors->has('bulk') ? ' has-error' : '' }}">
                                <input type="text" name="bulk" required value="{{ old('bulk') }}"
                                       placeholder="Enter Batch Number" class="form-control">
                                <span class="input-group-btn">
                  <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-search" aria-hidden="true"></i> SEARCH AS BATCH</button>
                </span>
                            </div>
                            @if ($errors->has('search'))
                                <span class="help-block">
                        <strong>{{ $errors->first('search') }}</strong>
                    </span>
                            @endif
                        </form>
                    </div>
                </div>

            </div>
            {{--</div>--}}
        </section>
    </div>
    <!-- /.content-wrapper -->
@endsection