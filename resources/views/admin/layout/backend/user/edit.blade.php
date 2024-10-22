@extends('admin.layout.template')
@section('content')
    <section class="content-wrapper">
        <section class="content-header">
            <h1>Edit User</h1>
            <ol class="breadcrumb">
                <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li class="active">Users</li>
            </ol>
        </section>
        <div class="content">
            <div class="row">
                <div class="box box-solid">
                    <div class="box-header">
                        <div class="panel-heading">{{$user->fullname}}</div>
                    </div>
                    <div class="panel-body">
                        {!! Form::model($user,['method'=>'PATCH','route'=>['user.update',$user],'class'=>'form-horizontal']) !!}
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
                            <div>{!! Form::label('password','New Password:',['class'=>'col-md-4 control-label']) !!}</div>
                            <div class="col-md-4">{!! Form::password('password',['class'=>'form-control  disabled','disabled'=>'disabled']) !!}</div>
                        </div>

                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <div>{!! Form::label('password_confirmation','Confirm Password:',['class'=>'col-md-4 control-label']) !!}</div>
                            <div class="col-md-4">{!! Form::password('password_confirmation',['class'=>'form-control disabled','disabled'=>'disabled']) !!}</div>
                        </div>
                        <div class="form-group{{ $errors->has('role_id') ? ' has-error' : '' }}">
                            <div>{!! Form::label('role_id','Role:',['class'=>'col-md-4 control-label']) !!}</div>
                            <div class="col-md-2">{!! Form::select('role_id',$roles->prepend('Assign role',''),null,['class'=>'form-control']) !!}</div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-4"></div>
                            <label class="control-label" style="margin:10px">
                                    <input type="checkbox"  name="changepassword" class="flat-red" id="changepassword" value="1" {{ (old('changepassword') == '1') ? 'checked' : '' }}/>
                                    Change Password?
                                </label>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                {!! Form::submit('Update User',['class'=>'btn btn-primary']) !!}
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
                        {{--<script>--}}
                            {{--swal('hello','hellow',"success");--}}
                        {{--</script>--}}
                    @endif
                </div>
                {{--<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#favoritesModal">Add to Favorites</button>--}}
            </div>
        </div>
        </div>
    </section>
@endsection
@section('afterMainScripts')
<script>
    $(document).ready(function(){
//        $('.disabled').disabled();
        $('#changepassword').on('click',function (e) {
//            $('.disabled').toggleClass("collapsed pressed"); //you can list several class names
//            e.preventDefault();
//            alert('heyya');
            var val = $('.disabled');
            if (val.attr('disabled')) {
                val.removeAttr('disabled');
            } else {
                val.attr('disabled', 'disabled');
            }
        })
    })
</script>
@endsection
