@extends('layouts.camper')
@section('before-css')
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/login/iconmoon.css') }}">
    <link rel="stylesheet" href="{{ asset('css/login/style.css') }}">
@endsection

@section('content')
    <div class="content">
        <div class="container">
            <div class="row align-items-center text-center">
                <div class="col-md-12 mb-3">
                    <div class="form-header text-center mb-3">
                        <a href="{{route('landing')}}"><img src="{{App::isLocal() ? asset('img/aposa-main_edit.png') : asset('public/img/aposa-main_edit.png')}}" alt="" class="sign-up-icon" style="width: 250px;"></a>
                    </div>
                    {{--                    <h4>Camper Portal</h4>--}}
                </div>
                <div class="col-md-5 contents">
                    <div class="form-block">
                        <div class="mb-4">
                            <h3>Individual Log In</h3>
                            <p class="mb-5">Access your registration and camping information</p>
                        </div>
                        <form method="POST" action="{{ route('registrant.verify_token') }}">
                            {{ csrf_field() }}
                            <div class="form-group{{ $errors->has('tphone') ? ' has-error' : '' }} first mb-4">
                                <label for="tphone" class="control-label">Phone Number/Reg. ID <span class="required">*</span></label>
                                <input id="tphone" value="{{old('tphone')}}" type="text" class="form-control" name="tphone" required>
                            </div>

                            <div class="form-group{{ $errors->has('token') ? ' has-error' : '' }} last" >
                                {!! Form::label('token','Token',['class'=>'form-label']) !!}
                                {!! Form::text('token',null,['class'=>'form-control token-field','required']) !!}
                            </div>

                            <button type="submit" value="Log In" class="btn btn-block btn-primary mt-4">Log In</button>
                        </form>
                    </div>
                </div>
                <div class="col-md-2 text-center">
                    &mdash; or &mdash;
                </div>
                <div class="col-md-5 contents">
                    <div class="form-block">
                        <div class="mb-4">
                            <h3>Batch Log In</h3>
                            <p class="mb-5">Access your group registration and information</p>
                        </div>
                        <form method="POST" action="{{ route('registrant.verify_chapter') }}">
                            {{ csrf_field() }}
                            <div class="form-group{{ $errors->has('batch_no') ? ' has-error' : '' }} first mb-4">
                                <label for="batch_no" class="control-label">Batch # <span class="required">*</span></label>
                                <input id="batch_no" value="{{old('batch_no')}}" type="text" class="form-control" name="batch_no" required>
                            </div>
                            @if ($errors->has('batch_no'))
                                <span class="help-block">{{ $errors->first('batch_no') }}</span>
                            @endif

                            <div class="form-group{{ $errors->has('btoken') ? ' has-error' : '' }} last" >
                                {!! Form::label('btoken','Token',['class'=>'form-label']) !!}
                                {!! Form::text('btoken',null,['class'=>'form-control token-field','required']) !!}
                            </div>
                            @if ($errors->has('btoken'))
                                <span class="help-block">{{ $errors->first('btoken') }}</span>
                            @endif

                            <button type="submit" value="Log In" class="btn btn-block btn-primary mt-4">Log In</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer-scripts')
{{--    <script src="{{ asset('js/login/main.js') }}"></script>--}}
    <script>
        $(function() {
            'use strict';


            $('.form-control').on('input', function() {
                var $field = $(this).closest('.form-group');
                if (this.value) {
                    $field.addClass('field--not-empty');
                } else {
                    $field.removeClass('field--not-empty');
                }
            });

        });
        $( function() {
            var info = ({!! json_encode(($errors->any() !==null)?$errors->all():0) !!});

            if(info.length == 3)
            {
                $('#hidsurname').val(info[0]);
                $('#hidphone').val(info[1]);
                $('#hidgender').val(info[2]);
                $('#myModal').modal('show');
            }

        } );

        $(document).ready(function(){
            $('.token-field').on('keyup',function () {
                if(($(this).val().length) == 3){
                    $(this).val($(this).val() + '-');
                }
            })
        })

    </script>

@endsection