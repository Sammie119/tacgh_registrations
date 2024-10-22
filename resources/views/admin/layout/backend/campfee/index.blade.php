@extends('admin.layout.template')
@section('afterAllCss')
    {{--<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">--}}
    <link rel="stylesheet" href="{{asset('css/jquery-ui.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/jquery.dataTables.min.css')}}">
@endsection
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
                        <div class="panel-heading">Users</div>
                    </div>
                    <div class="panel-body">
                        <hr>
                        <div class="table-responsive">
                            @if($fees)
                                <table id="dtrows" class="table table-striped">
                                    <thead>
                                    <tr>
                                    <th>Camper Type</th>
                                    <th>Fee Description</th>
                                    <th>Fee Amount</th>
                                    <th>Date/Time Added</th>
                                    <th>Status</th>
                                    <th>Operations</th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach ($fees as $fee)
                                    <tr>
                                        <td>{{ $fee->camperType->FullName }}</td>
                                        <td>{{ $fee->fee_tag }}</td>
                                        <td>{{ $fee->fee_amount}}</td>
                                        <td>{{ $fee->created_at->toDateString() }}</td>
                                        <td>{{ $fee->status}}</td>
                                        <td>
                                            <a href="{{ route('campfee.edit', $fee->id) }}" class="btn btn-info pull-left" style="margin-right: 3px;">Edit</a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>

                            </table>
                                @endif
                        </div>
                        {{--<div style="float:right">--}}
                            {{--{{$users->links()}}--}}
                        {{--</div>--}}
<center>
                        <a href="{{ route('campfee.create') }}" class="btn btn-success">Add Camp Fee</a>
                        <a href="{{url()->previous()}}" class="btn btn-default">Back</a>
                        </center>

                {{--</div>--}}
                </div>
            </div>
        </div>
        </div>
    </section>
@endsection
@section('afterMainScripts')
    {{--<script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>--}}
    {{--<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>--}}
    <script src="{{asset('js/jquery-ui.min.js')}}"></script>
    <script src="{{asset('js/jquery.dataTables.min.js')}}"></script>
    <script>
        $(document).ready(function() {
            var dt = $('#dtrows').DataTable( {
                "processing": true,
            } );
        });
    </script>
    @endsection