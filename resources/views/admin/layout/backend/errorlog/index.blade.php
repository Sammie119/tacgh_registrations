@extends('admin.layout.template')
@section('afterAllCss')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">

@endsection
@section('content')
    <section class="content-wrapper">
        <section class="content-header">
            <h1>Error Log</h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Error Log</li>
            </ol>
        </section>
        <div class="content">
            <div class="row">
                <div class="box box-solid">
                    <div class="box-body">
                        @if($errors)
                            <div class="table-responsive">
                                <table id="dtrows" class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>Error Source</th>
                                        <th>Message</th>
                                        <th>Occured</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($errors as $error)
                                        <tr>
                                            <td>{{$error->error_source}}</td>
                                            <td>{{$error->error_message}}</td>
                                            <td>{{$error->created_at->diffForHumans()}}</td>
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
    {{--<link rel="stylesheet" href="/resources/demos/style.css">--}}
    {{--<script src="https://code.jquery.com/jquery-1.12.4.js"></script>--}}
    {{--<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>--}}
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script>

        $(document).ready(function() {
            $('#dtrows').DataTable({
                select: {
                    selector:'td:not(:first-child)',
                    style:    'os'
                },
                "ordering":false
            });
        });

    </script>
@endsection