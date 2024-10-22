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
                    <div class="box-header">
                        <div class="panel-heading">Users</div>
                    </div>
                    <div class="panel-body">

                        <h1><i class="fa fa-users"></i> User Administration <a href="{{ route('roles.index') }}" class="btn btn-default pull-right">Roles</a>
                            <a href="{{ route('permission.index') }}" class="btn btn-default pull-right">Permissions</a></h1>
                        <hr>
                        <div class="table-responsive">
                            @if($users)
                                <table id="dtrows" class="table table-striped">
                                    <thead>
                                    <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Date/Time Added</th>
                                    <th>User Roles</th>
                                    <th>Operations</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $user->fullname }}</td>
                                        <td>{{ $user->email }}</td>
                                        {{--<td>{{ $user->created_at->format('F d, Y h:ia') }}</td>--}}
                                        <td>{{ $user->created_at->toDateString() }}</td>
                                        <td>{{  $user->roles()->pluck('name')->implode(' ') }}</td>{{-- Retrieve array of roles associated to a user and convert to string --}}
                                        <td>
                                            <a href="{{ route('user.edit', $user->id) }}" class="btn btn-info pull-left" style="margin-right: 3px;">Edit</a>
                                            {{--<a href="#" class="btn btn-info pull-left" style="margin-right: 3px;">Edit</a>--}}

                                            @if($user->active_flag == 0)
                                                {{--{!! Form::open(['method' => 'PATCH', 'route' => ['user.unblock', $user->id] ]) !!}--}}
                                                                                            {{--{!! Form::open(['method' => 'DELETE', $user->id] ) !!}--}}
                                                {{--{!! Form::submit('Unblock', ['class' => 'btn btn-danger']) !!}--}}
                                                <a href="{{ route('user.unblock', ['uid'=>$user->id]) }}" class="btn btn-warning pull-left" style="margin-right: 3px;">Unblock</a>
                                                @else
                                                {!! Form::open(['method' => 'DELETE', 'route' => ['user.destroy', $user->id] ]) !!}
                                                {{--                                            {!! Form::open(['method' => 'DELETE', $user->id] ) !!}--}}
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
<center>
                        <a href="{{ route('user.create') }}" class="btn btn-success">Add User</a>
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