@extends('admin.layout.template')
@section('content')
    <section class="content-wrapper">
        <section class="content-header">
            <h1>Applicants</h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Menus</li>
            </ol>
        </section>
        <div class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-solid">
                        <div class="box-header">

                            <div class="row" style="margin-bottom: 10px">
                                <div class="col-md-4">
                                    <h3 style="margin-top:20px;font-size: 20px;">Map Menus To Roles</h3>
                                </div>
                                <div class="col-md-4 text-center">

                                </div>
                            </div>
                        </div>
                        <div class="box-body">

                            {{ Form::open(['method'=>'GET','route' => ['assignmenu.mapmenu'],'class'=>'form-horizonta']) }}

                            <div class="form-group inputControl_reg" style="max-width:300px;">
                                {{ Form::label('role', 'Select Role: ') }}
                                {{ Form::select('role', $roles->prepend('Select role',''),null,array('class' => 'form-control','id'=>'role')) }}
                            </div>
                            <div class="form-group">
                                <div class="col-md-4">
                                    {{-- <div class="list-view col-md-12"> --}}
                                        <div class="form-group">
                                            Available Menus
                                        </div>
                                        {{--//UnassignedPermissions--}}
                                        @if($menus)
                                            <div class="form-group">
                                                {{--<div class="col-md-10">{!! Form::select('availmenus',null,['class'=>'form-control','size'=>'10','id'=>'availmenus']) !!}</div>--}}
                                                <div clas="col-md-10">{!! Form::select('availmenus',$menus,3,['class'=>'form-control','size'=>'10','id'=>'availmenus']) !!}</div>
                                            </div>
                                        @endif
                                    {{-- </div> --}}
                                </div>

                                <div class="col-md-4">
                                    <div class="col-md-6 col-md-offset-3">
                                        <div class="form-group center">
                                            Assign/Revoke Menu
                                        </div>
                                        {{ Form::button('>>>>', array('class' => 'form-control btn-success','id'=>'assignmenu','title'=>'Assign Menu','style'=>'margin-bottom:20px'))}}
                                        {{ Form::button('<<<<', array('class' => 'form-control btn-danger','id'=>'removemenu','title'=>'Revoke Menu'))}}
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <h5><b>Assigned Menus</b></h5>
                                        @if($assigendmenus)
                                            <div clas="col-md-8">{!! Form::select('assignedmenus[]',$assigendmenus,5,['class'=>'form-control','size'=>'10','id'=>'assignedmenus','multiple']) !!}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <center>
                                {{ Form::submit('Update', array('class' => 'btn btn-primary')) }}
                                    <a href="{{url()->previous()}}" class="btn btn-default">Back</a>
                                </center>
                            </div>
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('afterMainScripts')
    <script>
        $(document).ready(function () {
            if( $('#assignedmenus').has('option').length > 0 )
            {
//                selectAll();
            }

            $("#assignmenu").click(function(e) {
                var val = $('#availmenus option:selected').val();
                var text = $('#availmenus option:selected').text();
//                $("#availperms option["+val+"]").remove();
                $("#availmenus option:selected").remove();
//                $('#assignedperms option:selected');
//                $("#assignedperms").append('<option value='+val+'>'+$('#availperms option:selected').text()+'</option>');
                $("#assignedmenus").append('<option value='+val+'>'+text+'</option>');
                // alert (val);
                selectAll();
            });

            $("#removemenu").click(function(e) {
                var val = $('#assignedmenus option:selected').val();
                var text = $('#assignedmenus option:selected').text();

                $("#assignedmenus option:selected").remove();
                $("#availmenus").append('<option value='+val+'>'+text+'</option>');
//                alert (val);
                selectAll();
            });

            $("#role").change(function(e) {
                var val = $('#role option:selected').val();
//                swal("Some title "+val,"some message","success");

                var menusassigned, menusavailable;
                $.ajax({
                    url:'rolemenuajax/{id}',
                    contentType: "application/json; charset=utf-8",
                    data: {'roleid': val},
                    type:'GET',
                    success: function (response){
//                        alert(response);
                        menusassigned   =   response.menusassigned;
                        menusavailable  =   response.menusavail;
                        var avail = "",assigned="";
                        $.each(menusavailable,function(i,item){
//                            alert(item);
                            avail += '<option value='+i+'>'+item+'</option>';
//                            tHTML += '<tr><td>'+item.FullName+'</td><td>'+item.ActiveFlag+'</td><td>'+item.Toggled+'</td></tr>';
                        });
                        $('#availmenus').html(avail);

                        $.each(menusassigned,function(i,item){
//
                            assigned += '<option value='+i+'>'+item+'</option>';//
                        });
                        $('#assignedmenus').html(assigned);
//                        $('#availmenus').html("<option value="+16+">Allow Assign Menus</option>");
//\
                        selectAll();
                    },
                    error:function(e){
                        alert('error');
                    }
                });
            });

            function selectAll()//function to select all assigned permissions
            {
                selectBox = document.getElementById("assignedmenus");
                for (var i = 0; i < selectBox.options.length; i++)
                {
                    selectBox.options[i].selected = true;
                }
            }
        });
    </script>
@endsection