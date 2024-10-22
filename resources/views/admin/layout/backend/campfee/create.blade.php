@extends('admin.layout.template')
@section('content')
    <section class="content-wrapper">
        <section class="content-header">
            <h1>Users</h1>
            <ol class="breadcrumb">
                <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li class="active">Camp Fees</li>
            </ol>
        </section>
        <div class="content">
        <div class="row">
            <div class="box box-solid">
                <div class="box-header">
                    <div class="panel-heading">Add Camp Fee</div>
                </div>
                    <div class="panel-body">
                        {!! Form::open(['method'=>'POST','url'=>'campfee','class'=>'form-horizontal']) !!}
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('camper_type_id') ? ' has-error' : '' }}">
                            <div>{!! Form::label('camper_type_id','Camper Type:',['class'=>'col-md-4 control-label']) !!}</div>
                            <div class="col-md-2">{!! Form::select('camper_type_id',$camperTypes->prepend('Select type',''),null,['class'=>'form-control']) !!}</div>
                        </div>

                        <div class="form-group{{ $errors->has('fee_tag') ? ' has-error' : '' }}">
                            <div>{!! Form::label('fee_tag','Fee Tag:',['class'=>'col-md-4 control-label ']) !!}</div>
                            <div class="col-md-4">{!! Form::text('fee_tag',null,['class'=>'form-control','placeholder'=>'fee description']) !!}</div>
                        </div>

                        <div class="form-group{{ $errors->has('fee_amount') ? ' has-error' : '' }}">
                            <div>{!! Form::label('fee_amount','Fee Amount:',['class'=>'col-md-4 control-label']) !!}</div>
                            <div class="col-md-2">{!! Form::text('fee_amount',null,['class'=>'form-control']) !!}</div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-4"></div>
                            <label class="control-label" style="margin:10px">
                                <input type="checkbox"  name="active_flag" class="flat-red" id="active_flag" value="1" {{ (old('active_flag') == '1') ? 'checked' : '' }}/>
                                Active Record?
                            </label>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                {!! Form::submit('Create Camp Fee',['class'=>'btn btn-primary']) !!}
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
    </section>
@endsection
