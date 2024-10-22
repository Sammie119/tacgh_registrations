@extends('admin.layout.template')
@section('afterAllCss')
    <link rel="stylesheet" href="{{asset('css/jquery-ui.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/jquery.dataTables.min.css')}}">
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
                            </div>
                        </div>
                        <div class="panel-body">
                            @if($registrants)
                                <div class="table-responsive">
                                    <table id="dtrows" class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th>Code</th>
                                            <th>Name</th>
                                            <th>Payment Mode</th>
                                            <th>Transaction No</th>
                                            <th>Amount</th>
                                            <th>Date Paid</th>
                                            <th>Token</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($registrants as $registrant)
                                            <tr>
                                                <td class="details-control"><a class="btn btn-primary" data-toggle="collapse" href="{{$registrant->reg_id}}" aria-expanded="false" aria-controls="collapseExample">{{$registrant->reg_id}}</a></td>
                                                <td>{{$registrant->camper->firstname.' '.$registrant->camper->surname}}</td>
                                                <td>{{$registrant->payment_mode}}</td>
                                                <td>{{$registrant->transaction_no}}</td>
                                                <td>{{$registrant->amount_paid}}</td>
                                                <td>{{$registrant->date_paid}}</td>
                                                <td>{{$registrant->token}}</td>
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
                "processing": true,
            } );

            // Array to track the ids of the details displayed rows
            var detailRows = [];

            $('#dtrows tbody').on('click', 'tr td.details-control', function () {
                var tr = $(this).closest('tr');
                var row = dt.row(tr);
                var idx = $.inArray(tr.attr('id'), detailRows);

                var id= $(this).find('a').attr('href');
                var selectedrow = dt.row( $(this).parents('tr') ).data();
//                alert(selectedrow);
//                $('#hidVal').val('value ='+id);
                if (row.child.isShown()) {
                    tr.removeClass('details');
                    row.child.hide();

                    // Remove from the 'open' array
                    detailRows.splice(idx, 1);
                }
                else {
                    tr.addClass('details');
//                    row.child(format(row.data())).show();
                    row.child(format(id,selectedrow)).show();

//                    set payment details in form
                    $("textarea#paymentdetails").val("online payment for "+id+" (" +selectedrow[1]+") by "+selectedrow[2]+" -"+selectedrow[3]);

                    // Add to the 'open' array
                    if (idx === -1) {
                        detailRows.push(tr.attr('id'));
                    }
                }
            });

            // On each draw, loop over the `detailRows` array and show any child rows
            dt.on('draw', function () {
                $.each(detailRows, function (i, id) {
                    $('#' + id + ' td.details-control').trigger('click');
                });
            });

            /* Formatting function for row details - modify as you need */
            function format ( d,rowdata ) {
//                alert(rowdata);
                $('#paymentcontainer').empty();
                $('#paymentcontainer').append(d);
                var id = $( "#paymentcontainer" ).find( "a" ).attr('href');
                return '<tr><td colspan="5" style="min-width:300px !important;margin-left:10px">' +
                    '<form role="form" method="POST" action="{{ route('registrant.camperonlineauthorize')}}">{{ csrf_field() }}' +
                    '<div class="form-group">'+
                    '<input type="hidden" id="hidVal" value="'+d+'" name="id" /><input type="hidden" id="hidTransNo" value="'+rowdata[3]+'" name="hidTransNo" /></div>'+
                    '<div class="form-group">'+
                    '<input type="text" name="amountpaid" value="'+rowdata[4]+'" class="form-control col-md-4" placeholder="Enter amount" autocomplete="off"  required/></div>'+
                    '<div class="form-group">'+
                    '<textarea name="paymentdetails" class="form-control col-md-2" placeholder="Payment description" id="paymentdetails" required/></div>'+
                    '<div class="form-group">'+
                    '<textarea name="comment" class="form-control col-md-4" placeholder="Comment here" required/>'+
                    '</div><div class="form-group"><input type="submit" value="Approve Payment"class="btn btn-success"/></div>' +
                    '</form></td></tr>';
            }
        })
    </script>
@endsection