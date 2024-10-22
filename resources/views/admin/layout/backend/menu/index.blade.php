@extends('admin.layout.template')
@section('afterAllCss')
    <link rel="stylesheet" href="{{asset('css/jquery-ui.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/jquery.dataTables.min.css')}}">
@endsection
@section('content')
    <section class="content-wrapper">
        <section class="content-header">
            <h1>Menus</h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Menus</li>
            </ol>
        </section>
        <div class="content">
            <div class="row">
                <div class="box box-solid">
                    <div class="box-header">
                        <div class="row" style="margin-bottom: 10px">
                            <div class="col-md-4">
                                <h3 style="margin-top:20px;font-size: 20px;">System Menus</h3>
                            </div>
                            <div class="col-md-4 text-center">
                            </div>
                            <div class="col-md-4 text-right">
                                <a href="{{ url('/menu/create') }}" class="btn bg-orange btn-flat margin">Add Menu</a>
                            </div>
                        </div>
                    </div>
                    <div class="box-body">
                        @if($menus)
                            <div class="table-responsive">
                                <table id="dtrows" class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>Menu Name</th>
                                        <th>Route</th>
                                        <th>Level</th>
                                        <th>Rank</th>
                                        <th>Managed?</th>
                                        <th>Icon</th>
                                        <th>Parent Menu</th>
                                        <th>Active?</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($menus as $menu)
                                        <tr><td><a href="{{ route('menu.edit', $menu->id)}}">{{$menu->menuname}}</a></td>
                                            {{--<tr><td class="details-control">{{$audit->reg_id}}</td>--}}
                                            <td>{{$menu->nodeurl}}</td>
                                            <td>{{$menu->level}}</td>
                                            <td>{{$menu->rank}}</td>
                                            <td>{{($menu->managedmenu==1)?'Yes':'No'}}</td>
                                            <td><a href="#">{{$menu->glyphicon}}</a></td>
                                            <td>{{isset($menu->parent)?$menu->parent->menuname:""}}</td>
                                            <td>{{$menu->activeflag==1?"Active":"Inactive"}}</td>
                                    @endforeach
                                    </tbody>
                                </table>

                            </div>
                        @endif
                        {{--<div><i class="fa fa-history"></i></div>--}}
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
            $('#dtrows').DataTable({
//                "aoColumnDefs":[{
//                    "bSortable":false,"aTarget":1
//                }]
                "aaSorting":[]
            });
        });
    </script>
@endsection