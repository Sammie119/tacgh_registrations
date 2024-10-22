@extends('admin.layout.template')
@section('afterAllCss')
    {{--<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">--}}
    <link rel="stylesheet" href="{{asset('css/jquery-ui.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/jquery.dataTables.min.css')}}">
@endsection
@section('content')
    <section class="content-wrapper">
        <section class="content-header">
            <h1>Authorized Individuals</h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Applicants</li>
            </ol>
        </section>
        <div class="content">
            <div class="row">
                <div class="box box-solid">
                    <div class="panel-body">
                        @if($registrants)
                            <div class="table-responsive">
                                <table id="dtrows" class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>Batch #</th>
                                        <th>Chapter</th>
                                        <th>Ambassador</th>
                                        <th>Ambassador Phone #</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($registrants as $registrant)
                                        <tr>
                                            <td>{{$registrant->batch_no}}</td>
                                            <td>{{strtoupper($registrant->chapter)}}</td>
                                            <td>{{strtoupper($registrant->ambassadorname)}}</td>
                                            <td>{{$registrant->ambassadorphone}}</td>
                                            <td>
                                                <a class="btn btn-success btn-flat" href="{{ route('assignBulk') }}"
                                                   onclick="event.preventDefault(); document.getElementById('assign-room-form{{$registrant->batch_no}}').submit();">
                                                    Assign Room
                                                </a>

                                                <form id="assign-room-form{{$registrant->batch_no}}" action="{{ route('assignBulk') }}" method="GET" style="display: none;">
                                                    {{ csrf_field() }}
                                                    <input type="hidden" name="bulk" value="{{$registrant->batch_no}}">
                                                </form>
                                            </td>
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
        })
    </script>
@endsection