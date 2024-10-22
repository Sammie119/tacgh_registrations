@extends('admin.layout.template')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1></h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="{{ route('permission.index') }}"><i class="fa fa-building-o"></i> Permissions</a></li>
                <li class="active"></li>
            </ol>
        </section>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Permissions<div style="float: right"></div></div>

                    <div class="panel-body">
                        <h1><i class='fa fa-key'></i> Edit Permission</h1>
                        <br>

                        {{--{{ Form::model($permission,array('route' => 'permission.store')) }}--}}
                        {!! Form::model($permission,['method'=>'PATCH','route'=>['permission.update',$permission],'class'=>'form-horizontal']) !!}

                        <div class="form-group">
                            {{ Form::label('name', 'Name') }}
                            {{ Form::text('name',null, array('class' => 'form-control')) }}
                        </div><br>
                        @if(!$roles->isEmpty())
                            <h4>Assign Permission to Roles</h4>

                            @foreach ($roles as $role)
                                {{ Form::checkbox('roles[]',  $role->id ) }}
                                {{ Form::label($role->name, ucfirst($role->name)) }}<br>

                            @endforeach
                        @endif
                        <br>
                        {{ Form::submit('Update Permission', array('class' => 'btn btn-primary')) }}

                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection