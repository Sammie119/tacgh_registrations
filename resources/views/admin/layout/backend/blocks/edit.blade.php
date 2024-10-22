@extends('admin.layout.backend.blocks.form')

@section('heading',$block->residence->name)

@section('breadcrumb')
    {{--<ol class="breadcrumb">--}}
        {{--<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>--}}
        {{--<li><a href="{{ route('residence.blocks',$block->residence_id) }}"><i class="fa fa-building-o"></i> {{ $block->residence->name }}</a></li>--}}
        {{--<li class="active">{{ $block->name }}</li>--}}
    {{--</ol>--}}
@endsection

@section("activity","Edit - $block->name")
@section("action",url("/block/$block->id"))
@section('method')
	{{ method_field('PUT') }}
@endsection
@section("name",$block->name)
@section("floors",$block->total_floors)
@section("rooms",$block->total_rooms)
@section("button","Update")
