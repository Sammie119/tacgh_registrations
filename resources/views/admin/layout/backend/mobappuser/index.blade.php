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
                <li class="active">Users</li>
            </ol>
        </section>
        <div class="content">
            <div class="row">
                <div class="box box-solid">
                    <div class="panel-body">

                        <h1><i class="fa fa-users"></i> Mobile App Users
                            </h1>
                        <hr>
                        <div class="table-responsive">
                            @if($mobusers)
                                <table id="dtrows" class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Username</th>
                                        <th>Date/Time Added</th>
                                        <th>Status</th>
                                        {{--<th>User Roles</th>--}}
                                        <th>Operations</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @foreach ($mobusers as $user)
                                        <tr>
                                            <td>{{ $user->fullname }}</td>
                                            <td>{{ $user->username }}</td>
                                            {{--<td>{{ $user->created_at->format('F d, Y h:ia') }}</td>--}}
                                            <td>{{ $user->created_at->toDateString() }}</td>
                                            <td>{{ ($user->active_flag == 1)?"Active":"Disabled" }}</td>
                                            <td>
                                                <a href="{{ route('user.edit', $user->id) }}" class="btn btn-info pull-left" style="margin-right: 3px;">Edit</a>
                                                @if($user->active_flag == 10)
                                                    <a href="{{ route('user.mobappuserunblock', ['uid'=>$user->id]) }}" class="btn btn-warning pull-left" style="margin-right: 3px;">Unblock</a>
                                                @else
                                                    {!! Form::open(['method' => 'DELETE', 'route' => ['user.mobappuserdestroy', $user->id] ]) !!}
                                                    {!! Form::submit('Block', ['class' => 'btn btn-danger']) !!}
                                                @endif
                                                {!! Form::close() !!}
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
                            <a href="{{ route('user.mobappuseradd') }}" class="btn btn-success">Add App User</a>
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