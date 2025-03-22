@extends('admin.layout.template')
@section('afterAllCss')
    <link rel="stylesheet" href="{{asset('css/jquery-ui.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/jquery.dataTables.min.css')}}">
@endsection
@section('content')
    <section class="content-wrapper">
        <section class="content-header">
            <h1>Events</h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Events</li>
            </ol>
        </section>
        <div class="content">
            <div class="row">
                <div class="box box-solid">
                    <div class="box-header">
                        <div class="row" style="margin-bottom: 10px">
                            <div class="col-md-4">
                                <h3 style="margin-top:20px;font-size: 20px;">Events</h3>
                            </div>
                            <div class="col-md-4 text-center">
                            </div>
                            <div class="col-md-4 text-right">
                                <a href="{{ url('/events/create') }}" class="btn bg-orange btn-flat margin">Add Event</a>
                            </div>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <table id="dtrows" class="table table-striped">
                                <thead>
                                <tr>
                                    <th>Event Name</th>
                                    <th>Code Prefix</th>
                                    <th>Description</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Require Payment</th>
                                    <th>Status</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @forelse($events as $event)
                                        <tr>
                                            <td><a href="{{ route('events.edit', $event->id) }}">{{$event->name}}</a></td>
                                            <td>{{ $event->code_prefix }}</td>
                                            <td>{{$event->description}}</td>
                                            <td>{{$event->start_date}}</td>
                                            <td>{{$event->end_date}}</td>
                                            <td>{{($event->isPaymentRequired==1) ? "Yes" : "No"}}</td>
                                            <td>{{($event->activeflag==1) ? "Active" :($event->activeflag==0?"Inactive":"Complete")}}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="10">No Data Found</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>

                        </div>
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