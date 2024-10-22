@extends('admin.layout.template')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <section class="content-header">
    <h1>{{ $block->residence->name }}</h1>
      {{--<ol class="breadcrumb">--}}
        {{--<li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Home</a></li>--}}
        {{--<li><a href="{{ url('/residence') }}"><i class="fa fa-building-o"></i> Residences</a></li>--}}
        {{--<li><a href="{{url('/residence/'.$block->residence->id.'/blocks') }}"><i class="fa fa-building-o"></i> {{ $block->residence->name }}</a></li>--}}
        {{--<li class="active">{{ $block->name }}</li>--}}
      {{--</ol>--}}
    </section>
  <section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-solid">
              <div class="box-header">
                  
                  <div class="row">
                    <div class="col-md-12">
                      <h3 style="margin-top:20px;font-size: 20px;">@yield('acitvity') {{ $block->residence->name }} ({{ $block->name }})</h3>
                    </div>
                  </div>
              </div>
              <div class="box-body">
                <form class="form-horizontal" method="POST" action="@yield('action')">
                {{ csrf_field() }}
                @section('method')

                @show
                <input id="venue_slug" type="hidden" readonly class="form-control" name="venue_slug" value="{{ $venue_slug }}" >
                <input id="floors" type="hidden" readonly class="form-control" name="floors" value="{{ $block->total_floors }}" >
                <input id="rooms" type="hidden" readonly class="form-control" name="rooms" value="{{ $block->total_rooms }}" >
                <input id="block_id" type="hidden" readonly class="form-control" name="block_id" value="{{ $block->id }}" >
                <input id="residence_id" type="hidden" readonly class="form-control" name="residence_id" value="{{ $block->residence->id }}" >
                <table id="residences" class="table table-bordered table-striped table-hover">
                  <thead>
                    <tr>
                      <th style="width: 80px;">Floor</th>
                      <th colspan="2">Rooms Range</th>
                      <th>Prefix</th>
                      <th>Suffix</th>
                      <th>Average beds per room</th>
                      {{-- <th>Floor Color</th> --}}
                    </tr>
                  </thead>
                  <tbody>
                    @section('form')

                    @show
                  </tbody>
                </table>
                @section('after_table')

                @show
                <a href="{{ route('residence.blocks',[$venue_slug,$block->residence_id]) }}" class="btn btn-default"><i class="fa fa-times"></i> Cancel</a>
                <button type="submit" class="btn btn-success pull-right">
                  <i class="fa fa-floppy-o" aria-hidden="true"></i> @yield('button')
                </button>
              </form>
              </div>
            </div>
        </div>
      </div>
  </section>
</div>
<!-- /.content-wrapper -->
@endsection