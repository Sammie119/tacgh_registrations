@extends('admin.layout.template')
@section('afterAllCss')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
@endsection
@section('content')
    <section class="content-wrapper">
        <section class="content-header">
            <h1>Password Reset</h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Password Reset</li>
            </ol>
        </section>
        <div class="content">
            <div class="row">
                <div class="box box-solid">
                    <div class="box-header">

                        <div class="row" style="margin-bottom: 10px">
                            <div class="col-md-4">
                                <h1><i class='fa fa-key'></i> Change Password</h1>
                                <hr>
                            </div>
                            <div class="col-md-4 text-center">
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        {!! Form::open(['method'=>'POST','route' => ['changepassword'],'class'=>'form-horizontal']) !!}
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('oldpassword') ? ' has-error' : '' }}">
                            <div>{!! Form::label('oldpassword','Old Password:',['class'=>'col-md-4 control-label ']) !!}</div>
                            <div class="col-md-4">{!! Form::password('oldpassword',['class'=>'form-control']) !!}</div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <div>{!! Form::label('password','Password:',['class'=>'col-md-4 control-label']) !!}</div>
                            <div class="col-md-4">{!! Form::password('password',['class'=>'form-control']) !!}</div>
                        </div>

                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <div>{!! Form::label('password_confirmation','Confirm New Password:',['class'=>'col-md-4 control-label']) !!}</div>
                            <div class="col-md-4">{!! Form::password('password_confirmation',['class'=>'form-control']) !!}</div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                {!! Form::submit('Change Password',['class'=>'btn btn-primary']) !!}
                                <a href="{{url()->previous()}}" class="btn btn-default">Back</a>
                            </div>
                        </div>
                        {!! Form::close() !!}
                        @if(count($errors)>0)
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach($errors->all() as $error)
                                        <li>{{$error}}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection
