@extends('admin.layout.template')

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Groups<div style="float: right"></div></div>

                    <div class="panel-body">
                        <h1><i class='fa fa-key'></i> Edit Group: {{$role->name}}</h1>
                        <hr>

                        {{ Form::model($role, array('route' => array('roles.update', $role->id), 'method' => 'PUT')) }}

                        <div class="form-group">
                            {{ Form::label('name', 'Group Name') }}
                            {{ Form::text('name', null, array('class' => 'form-control')) }}
                        </div>
                        <div class="form-group">
                        <div class="col-md-4">
                            <div class="list-view col-md-12">
                                <div class="form-group">
                                    Available Permissions
                                </div>
                                {{--//UnassignedPermissions--}}
                                @if($availablepermissions)
                                    <div class="form-group">
                                        <div class="col-md-10">{!! Form::select('availperms',$availablepermissions,3,['class'=>'form-control','size'=>'10','id'=>'availperms']) !!}</div>
                                    </div>
                                @endif
                            </div>
                            <!-- /.box-body
                            <div class="box-footer text-center">
                              <a href="javascript:void(0)" class="uppercase">View All Products</a>
                            </div>
                            <!-- /.box-footer -->
                        </div>

                            <div class="col-md-4">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        Assign/Revoke Permission
                                    </div>
                                    {{ Form::button('>>>>', array('class' => 'form-control  btn-success','id'=>'assignPerm','title'=>'Assign Permission'))}}
                                    {{ Form::button('<<<<', array('class' => 'form-control  btn-danger','id'=>'removePerm','title'=>'Revoke Permission'))}}
                                </div>
                            </div>
                       <div class="col-md-4"><div class="form-group">
                           <h5><b>Assigned Permissions</b></h5>
                           {{--@foreach ($permissions as $permission)--}}

                               {{--{{Form::checkbox('permissions[]',  $permission->id, $role->permissions ) }}--}}
                               {{--{{Form::label($permission->name, ucfirst($permission->name)) }}<br>--}}

                           {{--@endforeach--}}
                           {{--<br>--}}

                           @if($assignedpermissions)

                                   <div class="col-md-8">{!! Form::select('assignedperms[]',$assignedpermissions,3,['class'=>'form-control','size'=>'10','id'=>'assignedperms','multiple']) !!}</div>
                               </div>
                           @endif
                       </div>
                    </div>
                        <div class="form-group">
                            <center>
                            {{ Form::submit('Save', array('class' => 'btn btn-primary')) }}
                            <a href="{{url()->previous()}}" class="btn btn-default">Back</a>
                            </center>
                        </div>


                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('afterMainScripts')
    <script>
        $(document).ready(function () {
            if( $('#assignedperms').has('option').length > 0 )
            {

            }
            selectAll();
            $("#assignPerm").click(function(e) {
                var val = $('#availperms option:selected').val();
                var text = $('#availperms option:selected').text();

                $("#availperms option:selected").remove();

                if(text)
                $("#assignedperms").append('<option value='+val+'>'+text+'</option>');
               // alert (val);
                selectAll();
            });

            $("#removePerm").click(function(e) {
                var val = $('#assignedperms option:selected').val();
                var text = $('#assignedperms option:selected').text();
//alert(val);
                $("#assignedperms option:selected").remove();
                if(text)
                $("#availperms").append('<option value='+val+'>'+text+'</option>');
                selectAll();
            });

            function selectAll()//function to select all assigned permissions
            {
                selectBox = document.getElementById("assignedperms");
                for (var i = 0; i < selectBox.options.length; i++)
                {
                    selectBox.options[i].selected = true;
                }
            }
        });
    </script>
@endsection