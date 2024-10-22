@extends('admin.layout.backend.residence.form')

@section('heading','Residence')

@section('breadcrumb')
    {{--<ol class="breadcrumb">--}}
        {{--<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>--}}
        {{--<li><a href="{{ url('/residence') }}"><i class="fa fa-building-o"></i> Residences</a></li>--}}
        {{--<li class="active">Add Residence</li>--}}
    {{--</ol>--}}
@endsection

@section("action",route("save_residence",[$venue_slug]))

@section("name",old('name'))

 @section("blocks",old('blocks'))

{{--@section("rooms",old('rooms'))--}}

@section('mgender')
	@if (old('gender') == 'M') checked @endif
@endsection

@section('fgender')
	@if (old('gender') == 'F') checked @endif
@endsection

@section('agender')
	@if (old('gender') == 'A') checked @endif
@endsection

@section('1status')
	@if (old('status') == '1') checked @endif
@endsection

@section('0status')
	@if (old('status') == '0') checked @endif
@endsection{{-- --}}
@section("button","Save")
