@extends('admin.layout.template')
@section('afterAllCss')
    {{--<link rel="stylesheet" href="css/main.css"/>--}}
    {{--<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.jqueryui.min.css" />--}}
    {{--<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">--}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">

@endsection
@section('content')
    <section class="content-wrapper">
        <section class="content-header">
            <h1>Audits</h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Audits</li>
            </ol>
        </section>
        <div class="content">
            <div class="row">
                <div class="box box-solid">
                    <div class="box-header">
                        <div class="row" style="margin-bottom: 10px">
                            <div class="col-md-4">
                                <h3 style="margin-top:20px;font-size: 20px;">Audit Trail</h3>
                            </div>
                            <div class="col-md-4 text-center">
                            </div>
                        </div>
                    </div>
                    <div class="box-body">
                        @if($audits)
                            <div class="table-responsive">
                                <table id="dtrows" class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>Item No</th>
                                        <th>Action by</th>
                                        <th>Action</th>
                                        <th>Activity</th>
                                        <th>Previous Values</th>
                                        <th>New Values</th>
                                        <th>Action Date</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($audits as $audit)
                                        <tr><td><a class="btn btn-primary" href="#{{$audit->id}}">{{$audit->reg_id}}</a></td>
                                            {{--<tr><td class="details-control">{{$audit->reg_id}}</td>--}}
                                            <td>{{strtoupper($audit->user->fullname)}}</td>
                                            <td>{{$audit->event}}</td>
                                            <td>{{$audit->auditable_type}}</td>
                                            <td>
                                                {{--{{$audit->old_values['fullname']}}--}}
                                                @if(strlen($audit->old_values) > 50)
                                                    {{substr($audit->old_values,0,50)."..."}}
                                                @else
                                                    {{$audit->old_values}}
                                                @endif
                                            </td>
                                            <td>
                                                @if(strlen($audit->new_values) > 50)
                                                    {{substr($audit->new_values,0,50)."..."}}
                                                @else
                                                    {{$audit->new_values}}
                                                @endif</td>
                                            <td>{{$audit->created_at->diffForHumans()}}</td>
                                            {{--<td>{{$audit->area}}</td><td>{{$audit->batch_no}}</td></tr>--}}
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
    {{--<link rel="stylesheet" href="/resources/demos/style.css">--}}
    {{--<script src="https://code.jquery.com/jquery-1.12.4.js"></script>--}}
    {{--<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>--}}
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script>
        /* Formatting function for row details - modify as you need */
        function format ( d ) {
//            alert('heyya');
            // `d` is the original data object for the row
            return '<form class="form-horizontal">'+
                '<div class="form-group">'+
                '<input type="hidden" name="id" value="'+d.id+'"/>'+
                '<input type="text" name="amountpaid"/>'+
                '<textarea name="paymentdetails"/>'+
                '<textarea name="comment"/>'+
                '</div><div class="form-group"><input type="button" text="Authorize"/></div>'
                +'</form>';
        }

        $(document).ready(function() {

            {{--// Add event listener for opening and closing details--}}
            $('#dtrows tbody').on('click', 'td.details-control', function (i) {
//
                var id= $(this).find('a').attr('href');
//                alert(id);

                var html="";
                html = '<tr><td colspan="5">{!! Form::open(['method'=>'PATCH','route' => ['registrant.update',-12],'class'=>'form-horizontal']) !!}{{ csrf_field() }}' +
//                html = '<tr><td colspan="5"><form class="form-horizontal" action="'+id+'">' +
                        {{--html = '<tr><td colspan="5"><form action="{{ route('registrant.update'), ['id' =>"'+id+'" ] }}" method="POST" >' +--}}
                            '<div class="form-group">'+
                    '<input type="hidden" name="id" value='+id+'/></div>'+
                    '<div class="form-group">'+
                    '<input type="text" name="amountpaid" class="form-control col-md-4" placeholder="Enter amount"/></div>'+
                    '<div class="form-group">'+
                    '<textarea name="paymentdetails" class="form-control col-md-2" placeholder="Payment description"/></div>'+
                    '<div class="form-group">'+
                    '<textarea name="comment" class="form-control col-md-4" placeholder="Comment here"/>'+
                    '</div><div class="form-group"><input type="submit" value="Authorize"class="btn btn-primary"/></div>' +
                    '{!! Form::close()!!}</td></tr>';

                var row = $(this).closest('tr'); // get the parent row of the clicked button
                $(html).remove();
                $(html).insertAfter(row); // insert content
//                alert('heyya');
//                if ( row.child.isShown() ) {
//                    // This row is already open - close it
//                    row.child.hide();
//                    tr.removeClass('shown');
//                }
//                else {
//                    // Open this row
//                    row.child( format(row.data()) ).show();
//                    tr.addClass('shown');
//                }
            } );
//            $('#dtrows').DataTable({
//                select: {
//                    selector:'td:not(:first-child)',
//                    style:    'os'
//                }
//            })
            $('#dtrows').DataTable({
                select: {
                    selector:'td:not(:first-child)',
                    style:    'os'
                }
            });
        });

    </script>
@endsection