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
                        <form class="form-horizontal" method="GET" action="{{ route('rawdata') }}">
                            {{ csrf_field() }}
                            <div class="input-group input-group-sm{{ $errors->has('search') ? ' has-error' : '' }}">
                                <input type="text" name="searchdata" required value="{{ old('search') }}" placeholder="Enter Red ID or Batch #" class="form-control">
                                <span class="input-group-btn">
                  <button type="submit" class="btn btn-info btn-flat"><i class="fa fa-search" aria-hidden="true"></i> </button>
                </span>
                            </div>
                            @if ($errors->has('search'))
                                <span class="help-block">
                        <strong>{{ $errors->first('search') }}</strong>
                    </span>
                            @endif
                        </form>
                    </div>
                    <div class="text-center">
                        <i class="fa fa-search" style="color: #ddd;font-size: 20vmax;" aria-hidden="true"></i>
                    </div>
                </div>

            </div>
    </div>
    </section>
    </div>
    <!-- /.content-wrapper -->
@endsection