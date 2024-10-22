@extends('admin.layout.template')
@section('content')
    <section class="content-wrapper">
        <section class="content-header">
            <h1>Menus</h1>
            <ol class="breadcrumb">
                <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li class="active">Menus</li>
            </ol>
        </section>
        <div class="content">
            <div class="row">
                <div class="box box-solid">
                    <div class="box-header">
                        <div class="panel-heading">Edit "{{$menuitem->menuname}}"</div>
                    </div>
                    <div class="panel-body">
{{--                        {!! Form::model($menuitem,array('route'=>['menu.update',$menuitem->id],'class'=>'form-horizontal')) !!}--}}
                        {!! Form::model($menuitem,['method'=>'PATCH','route'=>['menu.update',$menuitem],'class'=>'form-horizontal']) !!}
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('menuname') ? ' has-error' : '' }}">
                            <div>{!! Form::label('fullname','Menu Name:',['class'=>'col-md-4 control-label ']) !!}</div>
                            <div class="col-md-4">{!! Form::text('menuname',null,['class'=>'form-control']) !!}</div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-4"></div>
                            {{--                            <div>{!! Form::label('bo_qty_curr_month','Start Date:',['class'=>'col-md-4 control-label ']) !!}</div>--}}
                            <div class="col-md-5">
                                {{--{!! Form::text('bo_qty_curr_month1',null,['class'=>'form-control col-md-4']) !!}--}}
                                {{--{!! Form::text('bo_qty_curr_month col-md-4',null,['class'=>'form-control']) !!}--}}
                                <div class="form-group col-xs-4 col-md-4{{ $errors->has('menutype') ? ' has-error' : '' }}">
                                    <div>{!! Form::label('menutype','Type:',['class'=>'control-label']) !!}</div>
                                    <div>{!! Form::select('menutype',['Select type',1=>'Parent Menu',2=>'Child Menu'],2,['class'=>'form-control col-md-4']) !!}</div>
                                </div>
                                <div class="form-group col-xs-4 col-md-3{{ $errors->has('rank') ? ' has-error' : '' }}">
                                    <div>{!! Form::label('rank','Rank:',['class'=>'control-label']) !!}</div>
                                    <div>{!! Form::text('rank',null,['class'=>'form-control col-md-4']) !!}</div>
                                </div>
                                <div class="form-group col-xs-4 col-md-4{{ $errors->has('managedmenu') ? ' has-error' : '' }}">
                                    <div>{!! Form::label('managedmenu','Managed?:',['class'=>'control-label']) !!}</div>
                                    <div>{!! Form::select('managedmenu',['No',1=>'Yes'],1,['class'=>'form-control col-md-3']) !!}</div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('nodeurl') ? ' has-error' : '' }}">
                            <div>{!! Form::label('nodeurl','Route/Url:',['class'=>'col-md-4 control-label']) !!}</div>
                            <div class="col-md-4">{!! Form::text('nodeurl',null,['class'=>'form-control']) !!}</div>
                        </div>

                        <div class="form-group{{ $errors->has('glyphicon') ? ' has-error' : '' }}">
                            <div>{!! Form::label('glyphicon','Icon:',['class'=>'col-md-4 control-label']) !!}</div>
                            <div class="col-md-4">{!! Form::text('glyphicon',null,['class'=>'form-control']) !!}</div>
                        </div>

                        <div class="form-group{{ $errors->has('parentmenuid') ? ' has-error' : '' }}">
                            <div>{!! Form::label('parentmenuid','Parent Menu:',['class'=>'col-md-4 control-label']) !!}</div>
                            <div class="col-md-2">{!! Form::select('parentmenuid',$menus->prepend('Select Parent',''),null,['class'=>'form-control']) !!}</div>

                        </div>
                        <div class="form-group {{ $errors->has('managedmenu') ? ' has-error' : '' }}">
                            <div>{!! Form::label('activeflag','Active?:',['class'=>'col-md-4 control-label']) !!}</div>
                            <div class="col-md-2">{!! Form::select('activeflag',[0=>'No',1=>'Yes'],$menuitem->activeflag,['class'=>'form-control']) !!}</div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                {!! Form::submit('Save Menu',['class'=>'btn btn-primary']) !!}
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
