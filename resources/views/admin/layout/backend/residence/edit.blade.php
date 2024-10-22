@extends('admin.layout.backend.residence.form')

@section('heading','Residence')

@section('breadcrumb')
    {{--<ol class="breadcrumb">--}}
        {{--<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>--}}
        {{--<li><a href="{{ url('/residence') }}"><i class="fa fa-building-o"></i> Residence</a></li>--}}
        {{--<li class="active">{{ $residence->name }}</li>--}}
    {{--</ol>--}}
@endsection

@section('method')
    {{ method_field('PUT') }}
@endsection

@section("action",route("edit_residence",[$venue_slug,$residence->id]))

@section("name",$name = str_replace(' ', '_', $residence->name))

@section("blocks",$residence->total_blocks)

{{--@section("rooms",$residence->total_rooms)--}}

@section('mgender')
	@if ($residence->gender == 'M') checked @endif
@endsection

@section('fgender')
	@if ($residence->gender == 'F') checked @endif
@endsection

@section('agender')
	@if ($residence->gender == 'A') checked @endif
@endsection

@section('1status')
	@if ($residence->status == '1') checked @endif
@endsection

@section('0status')
	@if ($residence->status == '0') checked @endif
@endsection

@section("button","Update")

