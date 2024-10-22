@extends('admin.layout.template')
@section('afterAllCss')
    {{--<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">--}}
    <link rel="stylesheet" href="{{asset('css/jquery-ui.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/jquery.dataTables.min.css')}}">
@endsection
@section('content')
    <section class="content-wrapper">
        <section class="content-header">
            <h1>@if(isset($camper)){{$camper->surname. ' '.$camper->firstname}}@endif</h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Applicants</li>
            </ol>
        </section>
        <div class="content">
            <div class="row">
                    <div class="box box-solid">
                        <div class="panel-body">
                            @if($show_camper_details == 0)
                            @if($registrants)
                                <div class="table-responsive">
                                    <table id="dtrows" class="table table-striped">
                                    <thead>
                                <tr>
                                    <th>Reg #</th>
                                    <th>Name</th>
{{--                                    <th>Chapter</th>--}}
                                    <th>Age</th>
                                    <th>Gender</th>
                                    <th>Camper Category</th>
                                    <th>Applicable fee</th>
{{--                                    <th>Total Payment</th>--}}
                                    <th>Room</th>
                                    {{--<th>Special Accom.</th>--}}
                                    <th>Area</th>
                                    <th>Action</th>
                                </tr>
                                        </thead>
                                <tbody>
                                @foreach($registrants as $registrant)
                                    <tr>
                                        {{--<td class="details-control"><a class="btn btn-primary" data-toggle="collapse" href="{{$registrant->id}}" aria-expanded="false" aria-controls="collapseExample">{{$registrant->reg_id}}</a></td>--}}
                                        <td>{{$registrant->reg_id}}</td>
                                        <td>{{strtoupper($registrant->surname) ." ".$registrant->firstname}}</td>
{{--                                        <td>{{$registrant->chapter}}</td>--}}
                                        <td>{{$registrant->dob}}<span>yrs</span></td>
                                        <td>{{$registrant->gender->FullName}}</td>
                                        <td>{{$registrant->campercat->FullName}}</td>
                                        <td>{{$registrant->campfee->fee_tag." - GHS ".$registrant->campfee->fee_amount}}</td>
{{--                                        <td>{{$registrant->online_payments + $registrant->onsite_payments}}</td>--}}
                                        <td>{{$registrant->room_id}}
                                            @if($registrant->room_id > 0)
                                            {{$registrant->room->block->name}}, Room #: {{$registrant->room->room_no}}
                                        @else
                                        -
                                        @endif</td>
{{--                                        <td>{{$registrant->specialaccom->FullName}}</td>--}}
                                        <td>{{$registrant->area->FullName}}</td>
                                        <td>
                                            <a class="btn btn-success btn-flat" href="{{ route('camper.nonpaidindividual') }}"
                                               onclick="event.preventDefault(); document.getElementById('indiv-form{{$registrant->id}}').submit();">
                                                Process
                                            </a>

                                            <form id="indiv-form{{$registrant->id}}" action="{{ route('camper.nonpaidindividual') }}" method="GET" style="display: none;">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="reg_id" value="{{$registrant->reg_id}}">
                                            </form>
                                        </td>
                                        {{--<td class="payment-control" reg="{{$registrant->reg_id}}"><a class="btn btn-success" >Process</a></td>--}}
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>

                                </div>
                                @endif
                            @elseif($show_camper_details == 1)
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="container-fluid">
                                                    <div class="box-body">
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <p><strong>Registration ID :</strong> {{ $camper->reg_id }}</p>
                                                                <p><strong>Age :</strong> {{ $camper->dob }} yrs</p>

                                                                <p><strong>Nationality :</strong> {{ $camper->nationality }}</p>
                                                                <p><strong>Contact :</strong> {{ $camper->telephone }}</p>

                                                            </div>
                                                            <div class="col-lg-6">
                                                                <p><strong>Chapter :</strong> {{ isset($camper->chapter)?$camper->chapter:""}}</p>

                                                                <p><strong>Camper Category :</strong>{{$camper->campercat->FullName}}</p>
                                                                <p><strong>Camper Fee :</strong>{{$camper->campfee->fee_tag." - GHS ".$camper->campfee->fee_amount}}</p>
{{--                                                                <p><strong>{{($camper->campfee->id == 43) ?"Special Accomodation Fee: ".$camper->specialaccom->FullName:" "}} :</strong></p>--}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr/>
                                    </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="col-lg-6 col-md-6">
                                                    <table border="1" cellpadding="3" cellspacing="3" width="80%">
                                                        <thead>
                                                        <tr class="table-row">
                                                            <th>Item</th>
                                                            <th>Amount</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <tr><td> Online Payment</td><td>{{$total_online_payments}}</td></tr>
                                                        <tr><td> Onsite Payment</td><td>{{$total_onsite_payments}}</td></tr>
                                                        <tr><td>Total Payment</td><td>{{$total_online_payments + $total_onsite_payments}}</td></tr>
                                                        </tbody>
                                                    </table>
                                                </div>

                                                <div class="col-lg-6 col-md-6" >
                                                    <h4>Authorization here!</h4>
                                                    <form class="form-horizontal" role="form" method="POST" action="{{ route('registrant.camperauthorize') }}">
                                                            {{ csrf_field() }}
                                                        <input type="hidden" name="id" value="{{$camper->id}}"/>
                                                        <input type="hidden" name="total_payments" value="{{$total_online_payments + $total_onsite_payments}}"/>
                                                        {{--<input type="hidden" name="batch_no" value="{{$batch_no}}">--}}
                                                        <input type="text" name="amount_paid"  placeholder="Amount paid" value="" class="form-control" required>

                                                        <div><textarea  name="description" placeholder="Payment description" class="form-control" required></textarea><div></div>
                                                            <textarea  name="comment" placeholder="Comment here" class="form-control" required></textarea>
                                                        </div>
                                                        <input type="submit" class="btn btn-success" value="Authorize Camper" style="margin-top:10px" />
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                        </div>
                                @endif
                        </div>
                    </div>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                {!! Form::open(['method'=>'PATCH','route' => ['bacthregistration.update',-12],'class'=>'form-horizontal popup']) !!}{{ csrf_field() }}
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header" style="background-color:#007bb6;color:white">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">Title</h4>
                            </div>

                            <div class="modal-body">
                                <input type="hidden" name="batchno" id="batchno" value="">
                                <input name="_method" type="hidden" value="PATCH">
                                <input type="text" name="amountpaid" id="amountpaid" placeholder="Amount paid" value="" class="form-control" required>
                                {{--<input type="text" name="amountinit" id="amountinit" value="" class="form-control" required>--}}
                                {{--<input type="text" name="amountnew" placeholder="Revised amount" class="form-control" required>--}}
                                <textarea  name="description" placeholder="Payment description" class="form-control" required></textarea>
                                <textarea  name="comment" placeholder="Comment here" class="form-control" required></textarea>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Authorize Batch</button>
                            </div>
                        </div>
                    </div>
                 {!! Form::close() !!}
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
        /* Formatting function for row details - modify as you need */
        function format ( d ) {
//            alert('heyya');

            $('#testdiv').empty();
            $('#testdiv').append(d);
            var id = $( "#testdiv" ).find( "a" ).attr('href');
            return '<tr><td colspan="5" style="min-width:300px !important;margin-left:10px">' +
{{--                '{!! Form::open(['method'=>'POST','url' => ['camperauthorize',12],'class'=>'form-horizontal']) !!}{{ csrf_field() }}' +--}}
                '<form role="form" method="POST" action="{{ route('registrant.camperauthorize')}}">{{ csrf_field() }}' +
                '<div class="form-group">'+
//                '<input name="_method" type="hidden" value="PATCH"></div>'+
                '<input type="hidden" id="hidVal" value="'+id+'" name="id" /></div>'+
                '<div class="form-group">'+
                '<input type="text" name="amountpaid" class="form-control col-md-4" placeholder="Enter amount" required/></div>'+
                '<div class="form-group">'+
                '<textarea name="paymentdetails" class="form-control col-md-2" placeholder="Payment description" required/></div>'+
                '<div class="form-group">'+
                '<textarea name="comment" class="form-control col-md-4" placeholder="Comment here" required/>'+
                '</div><div class="form-group"><input type="submit" value="Authorize"class="btn btn-primary"/></div>' +
                '</form></td></tr>';
        }

        $(document).ready(function() {

            var dt = $('#dtrows').DataTable( {
                dom: 'Bfrtip',
                buttons: [
                    'excelHtml5',
                    'pdfHtml5'
                ],
                "processing": true,
            } );

            // Array to track the ids of the details displayed rows
            var detailRows = [];

            $('#dtrows tbody').on('click', 'tr td.details-control', function () {
                var tr = $(this).closest('tr');
                var row = dt.row(tr);
                var idx = $.inArray(tr.attr('id'), detailRows);

                var id= $(this).find('a').attr('href');
//                alert(id);
//                $('#hidVal').val('value ='+id);
                if (row.child.isShown()) {
                    tr.removeClass('details');
                    row.child.hide();

                    // Remove from the 'open' array
                    detailRows.splice(idx, 1);
                }
                else {
                    tr.addClass('details');
                    row.child(format(row.data())).show();

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

            $('#dtrows tbody').on('click','.payment-control',function(e){

                var camper = $(this).attr('reg');//
//                var data = "Hellow there";
//                alert(camper);
//                var id = $(this).attr('payid');
//
//                var name = $(this).closest('td').next('td').text();
//                var amount = $(this).closest('td').next('td').next('td').text();
//                $('#batchno').val(href);
//                $('#amountinit').val(amount);
//                $('#myModalLabel').html('Batch No: '+href+', '+name+' '+amount);
                $('#myModalLabel').html('Camper: '+camper);
                $('.modal').show();
            });
//            $(".modal").draggable();
            $('.content').on('click','#calcBatchAmount',function(e){
                    var totalAmount=0;
                    var specialAccom = 0;
                    dt.column(6,  { search:'applied' } ).data().each(function(value, index) {

                        if(value== "Special Accomodation"){
                            specialAccom = specialAccom+1;
                        }
                        totalAmount= totalAmount+(value.replace(/\D/g,'')/100);
                    });
                    if(specialAccom>0){
                        dt.column(7,  { search:'applied' } ).data().each(function(value, index) {

                            value= value.substring(0, value.indexOf('each'));
                            totalAmount= totalAmount+(value.replace(/\D/g,'')/100);
                        });
                    }
                    alert("Supposed amount to pay: GHC "+totalAmount);
            });

            $('.modal').on('show.bs.modal', function(e) {

                var modal = $('.modal');
                modal.find('.popup').attr({'action':'{{route('bacthregistration.update',1)}}'});

            });
        })
    </script>
@endsection