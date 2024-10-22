@extends('admin.layout.template')
@section('afterAllCss')
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <!-- bootstrap datepicker -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/all.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <link rel="stylesheet" href="{{asset('css/jquery-ui.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/jquery.dataTables.min.css')}}">
    {{--<link type="text/css" href="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.11/css/dataTables.checkboxes.css" rel="stylesheet" />--}}

    <script src="{{asset('js/jquery-3.2.1.min.js')}}"/>
    <script type="text/javascript" src="{{asset('js/dataTables.checkboxes.min.js')}}"></script>

    <style>
        .token-code input{
            border:none;
        }
    </style>
@endsection
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper bg-im">
        <section class="content">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Token List</h3>
                    {{--<p>Select the Batch to generate and send tokens to</p>--}}
                </div>
                <!-- /.box-header -->
                {{--<form class="form-horizontal" id="paymentform" role="form" method="POST" action="{{ route('message.batchtokensend') }}">--}}
                    {{--{{ csrf_field() }}--}}
                    <div class="box-body no-padding">
                        @if($tokens)
                            <table id="flow-table" class="table table-bordered table-striped table-hover">
                                <thead>
                                <tr>
                                    <th>Code</th>
                                    <th>Phone</th>
                                    <th>Token</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($tokens as $token)
                                    <tr>
                                        <td>{{$token['camper_code']}}</td>
                                        <td>{{$token['telephone']}}</td>
                                        {{--<td>{{$token['token']}}</td>--}}
                                        <td class="token-code"><input id="token-field{{$token->id}}" type="password" name="password" value="{{$token['token']}}">
                                            <span toggle="#token-field{{$token->id}}" class="fa fa-fw fa-eye field-icon toggle-password"></span></td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                    <div>
                    </div>
            </div>
        </section>
    </div>
@endsection
@section('afterOtherScripts')
    <script src="{{asset('js/jquery-ui.min.js')}}"></script>
    <script src="{{asset('js/jquery.dataTables.min.js')}}"></script>
    <script>
        $(document).ready(function() {
            var oTableStaticFlow = $('#flow-table').DataTable({
                "processing": true,
                "select": true,
            });


//            $(".toggle-password").click(function() {
////                alert('hey');
//                $(this).toggleClass("fa-eye fa-eye-slash");
//                var input = $($(this).attr("toggle"));
//                alert(JSON.stringify(input.attr("type")));
//                if (input.attr("type") == "password") {
//                    input.attr("type", "text");
//                } else {
//                    input.attr("type", "password");
//                }
//            });

            $("#flow-table").on('click','.toggle-password',function() {
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