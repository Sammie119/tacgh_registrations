@extends('admin.layout.template')
@section('afterAllCss')
<link rel="stylesheet" href="{{ asset('plugins/iCheck/all.css') }}">
@endsection
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <section class="content-header">

            <h1>@yield('heading')</h1>
            @section('breadcrumb')

            @show

        </section>
        <section class="content">
        <div class="row">
            <div class="col-md-12">
              <div class="box box-solid">
                <div class="box-header">
                    <h4>{{ ucfirst(substr(Route::currentRoutename(), 10)) }} Residence</h4>
                </div>
                <div class="box-body">
                  <form class="form-horizontal" method="POST" action="@yield('action')">
                    {{ csrf_field() }}
                    @section('method')

                    @show
                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <label for="name" class="col-md-4 control-label">Residence Name</label>

                        <div class="col-md-6">
                            <input id="name" type="text" class="form-control" name="name" value="@yield('name')" required autofocus>

                            @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('blocks') ? ' has-error' : '' }}">
                        <label for="blocks" class="col-md-4 control-label">Number of Blocks/Sections</label>

                        <div class="col-md-6">
                            <input id="blocks" type="number" min="1" max="10" class="form-control" name="blocks" value="@yield('blocks')" required autofocus>

                            @if ($errors->has('blocks'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('blocks') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    {{--<div class="form-group{{ $errors->has('rooms') ? ' has-error' : '' }}">--}}
                        {{--<label for="rooms" class="col-md-4 control-label">Number of Rooms</label>--}}
                        {{--<div class="col-md-6">--}}
                            {{--<input id="rooms" type="number" min="1" max="4000" class="form-control" name="rooms" value="@yield('rooms')" autofocus>--}}

                            {{--@if ($errors->has('rooms'))--}}
                                {{--<span class="help-block">--}}
                                    {{--<strong>{{ $errors->first('rooms') }}</strong>--}}
                                {{--</span>--}}
                            {{--@endif--}}
                        {{--</div>--}}
                    {{--</div>--}}

                    <div class="form-group{{ $errors->has('gender') ? ' has-error' : '' }}">
                        <label for="gender" class="col-md-4 control-label">Gender</label>
                        <div class="col-md-3">
                            <label style="margin-top: 5px; margin-right: 5px;">
                              <input type="radio" name="gender" class="flat-red" value="M" @section('mgender') @show >
                              Male
                            </label>
                            <label style="margin-top: 5px; margin-right: 5px;">
                            <input type="radio" name="gender" class="flat-red" value="F"  @section('fgender') @show >
                              Female
                            </label>
                            <label style="margin-top: 5px; margin-right: 5px;">
                              <input type="radio" name="gender" value="A" class="flat-red"  @section('agender')  @show >
                              Mixed
                            </label>
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
                        <label for="assign" class="col-md-4 control-label">Available for allocation?</label>
                        <div class="col-md-4">
                            <label style="margin-top: 5px; margin-right: 5px;">
                              <input type="radio" name="status" class="flat-red" value="1" @section('1status')  @show>
                              Yes
                            </label>
                            <label style="margin-top: 5px; margin-right: 5px;">
                              <input type="radio" name="status" value="0" class="flat-red"  @section('0status')  @show>
                              No
                            </label>

                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <a href="{{ url('residence') }}" class="btn btn-default"><i class="fa fa-times"></i> Cancel</a>
                            <button type="submit" class="btn btn-primary pull-right">
                                <i class="fa fa-save"></i> @yield('button')
                            </button>
                        </div>
                    </div>
                  </form>
                </div>
                <!-- /.box-body -->
              </div>
              <!-- /.box -->
            </div>
          </div>
        </section>
    </div>
    <!-- /.content-wrapper -->
@endsection
@section('afterOtherScripts')
<script src="{{ asset('plugins/icheck/icheck.min.js') }}"></script>
<script>
     $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
      checkboxClass: 'icheckbox_minimal-blue',
      radioClass   : 'iradio_minimal-blue'
    })
    //Red color scheme for iCheck
    $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
      checkboxClass: 'icheckbox_minimal-red',
      radioClass   : 'iradio_minimal-red'
    })
    //Flat red color scheme for iCheck
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
      checkboxClass: 'icheckbox_flat-green',
      radioClass   : 'iradio_flat-green'
    })
</script>
@endsection