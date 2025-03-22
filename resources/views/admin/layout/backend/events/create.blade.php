@extends('admin.layout.template')
@section('content')
    <section class="content-wrapper">
        <section class="content-header">
            <h1>Events</h1>
            <ol class="breadcrumb">
                <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li class="active">Events</li>
            </ol>
        </section>
        <div class="content">
            <div class="row">
                <div class="box box-solid">
                    <div class="box-header">
                        <div class="panel-heading">Create Event</div>
                    </div>
                    <div class="panel-body">
                        {!! Form::open(['method'=>'POST','url'=>'events','class'=>'form-horizontal']) !!}
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <div>{!! Form::label('name','Event Name:',['class'=>'col-md-4 control-label ']) !!}</div>
                            <div class="col-md-4">{!! Form::text('name',null,['class'=>'form-control']) !!}</div>
                        </div>

                        <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                            <div>{!! Form::label('description','Description:',['class'=>'col-md-4 control-label']) !!}</div>
                            <div class="col-md-4">{!! Form::text('description',null,['class'=>'form-control']) !!}</div>
                        </div>

                        <div class="form-group{{ $errors->has('code_prefix') ? ' has-error' : '' }}">
                            <div>{!! Form::label('code_prefix','Code Prefix:',['class'=>'col-md-4 control-label']) !!}</div>
                            <div class="col-md-4">{!! Form::text('code_prefix',null,['class'=>'form-control']) !!}</div>
                        </div>

                        <div class="form-group{{ $errors->has('start_date') ? ' has-error' : '' }}">
                            <div>{!! Form::label('start_date','Start Date:',['class'=>'col-md-4 control-label']) !!}</div>
                            <div class="col-md-4">{!! Form::date('start_date',null,['class'=>'form-control']) !!}</div>
                        </div>

                        <div class="form-group{{ $errors->has('end_date') ? ' has-error' : '' }}">
                            <div>{!! Form::label('end_date','End Date:',['class'=>'col-md-4 control-label']) !!}</div>
                            <div class="col-md-4">{!! Form::date('end_date',null,['class'=>'form-control']) !!}</div>
                        </div>

                        <div class="form-group {{ $errors->has('isPaymentRequired') ? ' has-error' : '' }}">
                            <div>{!! Form::label('isPaymentRequired','Is Payment Required?:',['class'=>'col-md-4 control-label']) !!}</div>
                            <div class="col-md-4">
                                <select class="form-control" name="isPaymentRequired">
                                    <option value="0" selected>No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('activeflag') ? ' has-error' : '' }}">
                            <div>{!! Form::label('activeflag','Active?:',['class'=>'col-md-4 control-label']) !!}</div>
                            <div class="col-md-4">
                                <select class="form-control" name="activeflag">
                                    <option value="0">No</option>
                                    <option value="1" selected>Yes</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                {!! Form::submit('Save Event',['class'=>'btn btn-primary']) !!}
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

            </div>
        </div>
        </div>
    </section>
@endsection
