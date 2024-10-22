@extends('admin.layout.template')

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Groups<div style="float: right"></div></div>

                    <div class="panel-body">
                        <h1><i class="fa fa-key"></i> Groups

                            {{--<a href="{{ route('users.index') }}" class="btn btn-default pull-right">Users</a>--}}
                            <a href="{{ route('permission.index') }}" class="btn btn-default pull-right">Permissions</a></h1>
                        <hr>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>Group</th>
                                    <th>Permissions</th>
                                    <th>Operation</th>
                                </tr>
                                </thead>

                                <tbody>
                                @if($roles)
                                @foreach ($roles as $role)
                                    <tr>

                                        <td>{{ $role->name }}</td>

                                        <td>{{ str_replace(array('[',']','"'),'', $role->permissions()->pluck('name')) }}</td>{{-- Retrieve array of permissions associated to a role and convert to string --}}
                                        <td>
                                            <a href="{{ URL::to('roles/'.$role->id.'/edit') }}" class="btn btn-info pull-left" style="margin-right: 3px;">Edit</a>

                                            {!! Form::open(['method' => 'DELETE', 'route' => ['roles.destroy', $role->id] ]) !!}
                                            {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                                            {!! Form::close() !!}

                                        </td>
                                    </tr>
                                @endforeach
                                    @endif
                                </tbody>

                            </table>
                        </div>
                        <center>
                        <a href="{{ URL::to('roles/create') }}" class="btn btn-success">Add Role</a>
                        <a href="{{url()->previous()}}" class="btn btn-default">Back</a>
                        </center>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection