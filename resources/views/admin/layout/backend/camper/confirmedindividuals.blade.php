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
                                        <th>Reg #</th>
                                        <th>Name</th>
                                        <th>Phone #</th>
                                        <th>Age</th>
                                        <th>Gender</th>
                                        <th>Camper Category</th>
                                        <th>Applicable Fee</th>
                                        <th>Room</th>
                                        {{--<th>Special Accom.</th>--}}
                                        {{--<th>Area</th>--}}
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($registrants as $registrant)
                                        <tr>
                                            <td>{{$registrant->reg_id}}</td>
                                            <td>{{strtoupper($registrant->surname) ." ".$registrant->firstname}}</td>
                                            <td>{{$registrant->telephone}}</td>
                                            <td>{{$registrant->dob}}<span>yrs</span></td>
                                            <td>{{$registrant->gender->FullName}}</td>
                                            <td>{{$registrant->campercat->FullName}}</td>
                                            <td>{{$registrant->campfee->fee_tag}}</td>
{{--                                            <td>{{$registrant->specialaccom->FullName}}</td>--}}
                                            <td>
                                                @if($registrant->room_id > 0)
                                                    {{$registrant->room->block->name}},<br> Room #: {{$registrant->room->room_no}}
                                                @else
                                                    -
                                                @endif</td>
{{--                                            <td>{{$registrant->area->FullName}}</td>--}}
                                            <td>
                                                <a class="btn btn-success btn-flat" href="{{ route('search') }}"
                                                   onclick="event.preventDefault(); document.getElementById('assign-room-form{{$registrant->id}}').submit();">
                                                    Assign Room
                                                </a>

                                                <form id="assign-room-form{{$registrant->id}}" action="{{ route('search') }}" method="GET" style="display: none;">
                                                    {{ csrf_field() }}
                                                    <input type="hidden" name="search" value="{{$registrant->reg_id}}">
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
                "pageLength": 100,
                "dom": 'T<"clear">lfrtip',
                tableTools: {
                    "sSwfPath": "media/swf/copy_csv_xls_pdf.swf"
                },
                "processing": true,
                dom: 'Bfrtip',
                buttons: [
                    'excelHtml5'
                ],
            } );
        })
    </script>
@endsection