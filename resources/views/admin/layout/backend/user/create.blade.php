@extends('admin.layout.template')
@section('content')
    <section class="content-wrapper">
        <section class="content-header">
            <h1>Users</h1>
            <ol class="breadcrumb">
                <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li class="active">Users</li>
            </ol>
        </section>
        <div class="content">
        <div class="row">
            <div class="box box-solid">
                <div class="box-header">
                    <div class="panel-heading">Create User</div>
                </div>
                    <div class="panel-body">
                        {!! Form::open(['method'=>'POST','url'=>'user','class'=>'form-horizontal']) !!}
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('fullname') ? ' has-error' : '' }}">
                            <div>{!! Form::label('fullname','Full Name:',['class'=>'col-md-4 control-label ']) !!}</div>
                            <div class="col-md-4">{!! Form::text('fullname',null,['class'=>'form-control']) !!}</div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <div>{!! Form::label('email','Email:',['class'=>'col-md-4 control-label']) !!}</div>
                            <div class="col-md-4">{!! Form::text('email',null,['class'=>'form-control']) !!}</div>
                        </div>


                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <div>{!! Form::label('password','Password:',['class'=>'col-md-4 control-label']) !!}</div>
                            <div class="col-md-4">{!! Form::password('password',['class'=>'form-control']) !!}</div>
                        </div>

                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <div>{!! Form::label('password_confirmation','Confirm Password:',['class'=>'col-md-4 control-label']) !!}</div>
                            <div class="col-md-4">{!! Form::password('password_confirmation',['class'=>'form-control']) !!}</div>
                        </div>

                        <div class="form-group{{ $errors->has('role_id') ? ' has-error' : '' }}">
                            <div>{!! Form::label('role_id','Role:',['class'=>'col-md-4 control-label']) !!}</div>
                            <div class="col-md-2">{!! Form::select('role_id',$roles->prepend('Assign role',''),null,['class'=>'form-control']) !!}</div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                {!! Form::submit('Create User',['class'=>'btn btn-primary']) !!}
                                <a href="{{url()->previous()}}" class="btn btn-default">Back</a>
                            </div>
                            <div class="col-md-6 col-md-offset-4">

                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
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
                {{--<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#favoritesModal">Add to Favorites</button>--}}
            </div>
        </div>
        </div>
    </section>
@endsection
