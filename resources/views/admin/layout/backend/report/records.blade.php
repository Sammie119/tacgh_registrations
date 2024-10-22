@extends('admin.layout.template')
@section('afterAllCss')
    <link rel="stylesheet" href="{{asset('css/jquery-ui.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/jquery.dataTables.min.css')}}">

    <script src="{{asset('js/jquery-3.2.1.min.js')}}"/>
    <script type="text/javascript" src="{{asset('js/dataTables.checkboxes.min.js')}}"></script>

    <style>
        .token-code input{
            border:1px;
            width:80px;
        }
    </style>
@endsection
@section('content')
    <section class="content-wrapper">
        <section class="content-header">
            <h1>Records</h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">All Records</li>
            </ol>
        </section>
        <div class="content">
            <div class="row">
                <div class="box box-solid">
                    <div class="box-header">
                        <div class="row" style="margin-bottom: 10px">
                            <div class="col-md-4">
                                <h3 style="margin-top:20px;font-size: 20px;">All Records</h3>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        @if($registrants)
                            <div class="table-responsive">
                                <table id="dtrows" class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>Camper ID</th>
                                        <th>Firstname</th>
                                        <th>Surname</th>
                                        <th>Phone</th>
                                        <th>Gender</th>
                                        <th>Date of Birth</th>
                                        <th>Local Assembly</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($registrants as $registrant)
                                        <tr>
                                            <td>{{$registrant->reg_id}}</td>
                                            <td>{{$registrant->firstname}}</td>
                                            <td>{{$registrant->surname}}</td>
                                            {{--<td>{{$registrant->telephone}}</td>--}}
                                            <td class="token-code"><input id="token-field{{$registrant->reg_id}}" type="password" name="password" value="{{$registrant->telephone}}">
                                                <span toggle="#token-field{{$registrant->reg_id}}" class="fa fa-fw fa-eye field-icon toggle-password"></span></td>
                                            <td>{{$registrant->gender}}</td>
                                            {{--<td>{{$registrant->olddob}}</td>--}}
                                            <td class="token-code"><input id="dob-field{{$registrant->reg_id}}" type="password" name="password" value="{{$registrant->olddob}}">
                                                <span toggle="#dob-field{{$registrant->reg_id}}" class="fa fa-fw fa-eye field-icon toggle-password"></span></td>
                                            <td>{{$registrant->local_assembly}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection

@section('afterMainScripts')
    <script src="{{asset('js/jquery-ui.min.js')}}"></script>
    <script src="{{asset('js/jquery.dataTables.min.js')}}"></script>
    <script>
        $(document).ready(function() {
            var dt = $('#dtrows').DataTable( {
                "processing": true,
            } );

            $("#dtrows").on('click','.toggle-password',function() {
                $(this).toggleClass("fa-eye fa-eye-slash");
                var input = $($(this).attr("toggle"));
                if (input.attr("type") == "password") {
                    input.attr("type", "text");
                } else {
                    input.attr("type", "password");
                }
            });
        })
    </script>
@endsection