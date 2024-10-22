@extends('admin.layout.template')
{{--@extends('layouts.app')--}}
@section('afterAllCss')
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/iCheck/all.css') }}">
    <style>
        .table tr:hover{cursor:pointer}
        .hideCell{display:none}
        /* The switch - the box around the slider */
        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }

        /* Hide default HTML checkbox */
        .switch input {display:none;}

        /* The slider */
        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        input:checked + .slider {
            background-color: #2196F3;
        }

        input:focus + .slider {
            box-shadow: 0 0 1px #2196F3;
        }

        input:checked + .slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
        }

        /* Rounded sliders */
        .slider.round {
            border-radius: 25px;
        }

        .slider.round:before {
            border-radius: 50%;
        }
    </style>
@endsection
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Lookups
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li class="active">Lookups</li>
            </ol>
        </section>
    <section>
        <div class="row">
            <div class="col-md-6">
                <div class="box box-solid">
                    <div class="panel-heading">Lookups<div style="float: right"><a href="{{route('lookup.create')}}">Create Lookup</a></div></div>

                    <div class="panel-body">
                        {!! Form::open(['method'=>'POST','action'=>'LookupController@store','class'=>'form-horizontal']) !!}
                        {{ csrf_field() }}

                        <div class="list-view col-md-8">
                            @if($lookupcodes)
                                <div class="form-group">
                                    <div class="col-md-6">{!! Form::select('lookup',$lookupcodes,1,['class'=>'form-control','size'=>'10','id'=>'lookup']) !!}</div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="box box-solid">
                            <div class="" style="border-bottom:1px dotted;display:inline-block;width:100%;position: relative">

                                <div class="form-group{{ $errors->has('fullname') ? ' has-error' : '' }}">
                                    <div class="col-md-6">
                                        <div>{!! Form::label('fullname','Lookup Name',['class'=>'control-label']) !!}</div>
                                        <div>{!! Form::text('fullname',null,['class'=>'form-control','id'=>'fullname']) !!}</div>
                                    </div>
                                    <input type="hidden" id="clickedlookup" name="clickedlookup"/>
                                    <div class="col-md-2">
                                        {{--<div>{!! Form::label('ActiveFlag','Active?',['class'=>'control-label']) !!}</div>--}}
                                        {{--<div>{!! Form::checkbox('ActiveFlag',null,['class'=>'form-control']) !!}</div>--}}
                                        <label class="control-inline">
                                            {{--<input type="checkbox" value="" name="ActiveFlag" class="flat-red camp control-label" id="activeflag">--}}
                                            Active?
                                        </label>
                                        <!-- Rounded switch -->
                                        <label class="control-inline switch">
                                            <input type="checkbox" name="ActiveFlag" class="flat-red camp control-label" id="activeflag">
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                    <div class="col-md-4" style="position:relative;top:20px !important;right:10px">
                                        {!! Form::submit('Add Lookup',['class'=>'btn btn-primary']) !!}
                                        <input type="button" id="clearForm" class="btn btn-default" value="Clear">
                                    </div>
                                </div>
                                {!! Form::close() !!}
                            </div>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Filter lookups..." id="filter"/>
                    </div>
                            <table class="table table-hover lookups">
                                <thead>
                                <tr><th class="hideCell">CodeID</th><th>Lookup Name</th><th>Active?</th></tr>
                                </thead>
                                @if($lpcodes)
                                    @foreach($lpcodes as $lpcode)
                                        <tr><td class="hideCell">{{$lpcode->id}}</td><td>{{$lpcode->FullName}}</td><td>{{$lpcode->ActiveFlag}}</td></tr>
                                        {{--<tr><td><a href="{{route('lookup.edit',$lpcode->id)}}">{{$lpcode->FullName}}</a></td><td>{{$lpcode->ShortName}}</td><td>{{$lpcode->	UseShortName}}</td><td>{{$lpcode->LookUpName}}</td>--}}
                                        {{--<td>{{$lpcode->ActiveFlag}}</td><td>{{$lpcode->Toggled}}</td></tr>--}}
                                    @endforeach

                                @endif
                                <div style="float:right;right:10px;width: 200px;">
                                    {{$lpcodes->links()}}
                                </div>
                            </table>

                        </div>

                    </div>
                </div>
        <a href="{{url()->previous()}}" class="btn btn-default">Back</a>
    </section>
    </div>
@endsection
@section('afterMainScripts')
{{--@section('footerscripts')--}}
    <script>
        $(document).ready(function () {
            retriveLookups();
            $("#lookup").change(function(e) {
               retriveLookups();
            });
            function retriveLookups(){
                var val = $('#lookup option:selected').val();
//                alert(val);
                $.ajax({
                    url:'lookupindex/{id}',
                    contentType: "application/json; charset=utf-8",
                    data: {'lookupid': val},
                    type:'GET',
                    success: function (response){
//                        swal("Some title "+val,"some message","success");
//                        var tHTML = "<thead><tr><th>Lookup Name</th><th>Active?</th><th>Toggled</th></tr></thead>";
                        var tHTML = '<thead><tr><th class="hideCell">CodeID</th><th>Lookup Name</th><th>Active?</th></tr></thead>';
                        $.each(response,function(i,item){
//                            tHTML += '<tr><td>'+item.FullName+'</td><td>'+item.ActiveFlag+'</td><td>'+item.Toggled+'</td></tr>';
                            tHTML += '<tr><td class="hideCell">'+item.id+'</td><td>'+item.FullName+'</td><td>'+item.ActiveFlag+'</td></tr>';
                        });
                        $('.lookups').html(tHTML);
//                       swal("Some title "+val,"some message","success");
                    },
                    error:function(e){
                        alert('error');
                    }
                });
            }

            $('.lookups').on('dblclick','td',function () {
                var $this = $(this);
                var row = $this.closest("tr");
                var cell2text = row.find('td:eq(2)').text();
                var cell1text = row.find('td:eq(1)').text();
                var hidID = row.find('td:eq(0)').text();

                $('#fullname').val(cell1text);
                if(cell2text == 1){
                    $('#activeflag').prop("checked",true);
                }
                else{
                    $('#activeflag').prop("checked",false);
                }
                $('#clickedlookup').val(hidID);
            });
            $('#clearForm').on('click',function(){
//                alert('Clear');
                $('#fullname').val('');
                $('#activeflag').prop('checked',false);
                $('#clickedlookup').val('');
            });

            $("#filter").on("keyup", function() {
                //Filter lookups on key up
//                $('#filter').on('keyup',function() {
                    var $rows = $('.table tr');
                    var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();

//                            alert(val);
                    $rows.show().filter(function() {
                        var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
                        return !~text.indexOf(val);
                    }).hide();
                });
//            });
        });


    </script>
@endsection