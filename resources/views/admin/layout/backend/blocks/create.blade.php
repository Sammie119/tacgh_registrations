@extends('admin.layout.backend.blocks.form')

@section('heading','Residence Blocks')

@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Residence</li>
    </ol>
    {{ $residence->name }}
@endsection

@section("action",url("/residence"))

@section("button","Save")
