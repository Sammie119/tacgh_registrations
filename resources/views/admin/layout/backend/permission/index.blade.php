@extends('admin.layout.template')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1></h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
{{--                <li><a href="{{ route('residence.index') }}"><i class="fa fa-building-o"></i> Residences</a></li>--}}
                <li class="active"></li>
            </ol>
        </section>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Permissions<div style="float: right"></div></div>

                    <div class="panel-body">
                        <h1><i class="fa fa-lock"></i>Available Permissions</h1>

                            {{--<a href="{{ route('users.index') }}" class="btn btn-default pull-right">Users</a>--}}
                            {{--<a href="{{ route('roles.index') }}" class="btn btn-default pull-right">Roles</a></h1>--}}
                        <hr>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>Permissions</th>
                                    <th>Operation</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($permissions as $permission)
                                    <tr>
                                        <td>{{ $permission->name }}</td>
                                        <td>
                                            <a href="{{ URL::to('permission/'.$permission->id.'/edit') }}" class="btn btn-info pull-left" style="margin-right: 3px;">Edit</a>

                                            {!! Form::open(['method' => 'DELETE', 'route' => ['permission.destroy', $permission->id] ]) !!}
                                            {!! Form::submit('Block', ['class' => 'btn btn-danger']) !!}
                                            {!! Form::close() !!}

                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                            <div style="float:right">
                                {{$permissions->links()}}
                            </div>
                        </div>

                        <a href="{{ URL::to('permission/create') }}" class="btn btn-success">Add Permission</a>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection