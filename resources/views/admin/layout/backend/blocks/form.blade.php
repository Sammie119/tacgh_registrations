@extends('admin.layout.template')

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
            {{-- @include('flash::message') --}}
          <div class="box box-solid">
            <div class="box-header with-border">
                <h4>@yield('activity')</h4>
            </div>
            <div class="box-body">
              <form class="form-horizontal" method="POST" action="@yield('action')">
                {{ csrf_field() }}
                @section('method')

                @show
                 <input type="hidden" id='venue_slug' value="{{$venue_slug}}">
{{--                <input type="hidden" id='rooms' value="@yield('total_rooms')"> --}}
                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                    <label for="name" class="col-md-4 control-label">Block Name</label>

                    <div class="col-md-6">
                        <input id="name" type="text" class="form-control" name="name" value="@yield('name')" required autofocus>

                        @if ($errors->has('name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                    <label for="floors" class="col-md-4 control-label">Number of Floors</label>
                    <div class="col-md-6">
                        <input id="floors" type="number" min="1" max="20" class="form-control" name="floors" value="@yield('floors')" required autofocus>

                        @if ($errors->has('floors'))
                            <span class="help-block">
                                <strong>{{ $errors->first('floors') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                    <label for="rooms" class="col-md-4 control-label">Number of Rooms</label>
                    <div class="col-md-6">
                        <input id="rooms" type="number" disabled="" min="0" max="200" class="form-control" name="rooms" value="@yield('rooms')">

                        @if ($errors->has('rooms'))
                            <span class="help-block">
                                <strong>{{ $errors->first('rooms') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                        <a href="{{ URL::previous() }}" class="btn btn-default"><i class="fa fa-times"></i> Cancel</a>
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