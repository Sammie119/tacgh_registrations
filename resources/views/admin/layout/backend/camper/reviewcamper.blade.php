@extends('admin.layout.template')
@section('afterAllCss')
    {{--<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">--}}
    <script src="{{asset('css/jquery.dataTables.min.css')}}"></script>
@endsection
@section('content')
    <section class="content-wrapper">
        <section class="content-header">
            <h1>Applicants</h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Applicants</li>
            </ol>
        </section>
        <div class="content">
            <div class="row">
                <div class="box box-solid">
                    <div class="box-header">

                        <div class="row" style="margin-bottom: 10px">
                            <div class="col-md-4">
                                <h3 style="margin-top:20px;font-size: 20px;">All Applicants</h3>
                            </div>
                            <div class="col-md-4 text-center">

                            </div>
                            <div class="col-md-4 text-right">
                                <a href="{{ url('/registrant/create') }}" class="btn bg-orange btn-flat margin">Add Applicant</a>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        @if($registrants)
                            <div class="table-responsive">
                                <table id="dtrows" class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>Reg #</th>
                                        <th>Name</th>
                                        <th>Chapter</th>
                                        {{--<th>Age</th>--}}
                                        <th>Gender</th>
                                        <th>Camper Category</th>
                                        <th>Applicable fee</th>
                                        <th>Special Accom.</th>
                                        <th>Area</th>
                                        <th>Batch No</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($registrants as $registrant)
                                        <tr>
                                            {{--@if(isset($registrant->batch_no))--}}
                                                {{--<td class="details-control1"><a class="btn btn-primary" disabled="disabled">{{$registrant->reg_id}}</a></td>--}}
                                            {{--@else--}}
                                                <td class="details-control"><a href="{{ route('registrant.edit', $registrant->id) }}" >{{$registrant->reg_id}}</a></td>
                                            {{--@endif--}}
                                            <td>{{strtoupper($registrant->surname) ." ".$registrant->firstname}}</td>
                                            <td>{{$registrant->chapter}}</td>
                                            {{--<td>{{$registrant->dob}}<span>yrs</span></td>--}}
                                            <td>{{$registrant->gender->FullName}}</td>
                                            <td>{{$registrant->campercat->FullName}}</td>
                                            <td>{{$registrant->campfee->FullName}}</td>
                                            <td>{{$registrant->specialaccom->FullName}}</td>
                                            <td>{{$registrant->area->FullName}}</td>
                                            <td>{{$registrant->batch_no}}</td>
                                            {{--<td><a href="#{{$payment->registrant->reg_id}}" data-toggle="modal" data-target="#myModal" class="camper" payid="{{$payment->id}}">{{$payment->registrant->reg_id}}</a></td>--}}
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
    {{--<script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>--}}
    {{--<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>--}}
    <script src="{{asset('js/jquery-ui.min.js')}}"></script>
    <script src="{{asset('js/jquery.dataTables.min.js')}}"></script>
    <script>
              $(document).ready(function() {
                  var dt = $('#dtrows').DataTable();

              });
    </script>
@endsection