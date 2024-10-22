@extends('admin.layout.template')
@section('afterAllCss')
    {{--<link rel="stylesheet" href="css/main.css"/>--}}
    <link rel="stylesheet" href="{{asset('css/dataTables.jqueryui.min.css')}}" />
    <link rel="stylesheet" href="{{asset('css/jquery-ui.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/jquery.dataTables.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('css/buttons.dataTables.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/rowGroup.dataTables.min.css')}}">
    <style>
        a.dt-button{border:none;width:auto;height:auto;}
    </style>

@endsection
@section('content')
    <section class="content-wrapper">
        <section class="content-header">
            <h1>Payments Report</h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Financials</li>
            </ol>
        </section>
        <div class="content">
            <div class="row">
                <div class="box box-solid">
                    <div class="box-body">
                        @if($payments)
                            <table id="dtrows" class="table table-responsive table-bordered table-striped table-hover">
                                <thead>
                                <tr>
                                    <th>Camper ID</th>
                                    <th>Camper Name</th>
                                    <th>Amount Paid</th>
                                    {{--<th>Payment Details</th>--}}
                                    {{--<th>Comment</th>--}}
                                    <th>Date Authorized</th>
                                    <th>Authorized By</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($payments as $payment)
                                    <tr>
                                        @if($payment->registrant->id == 0)
                                            <td><a href="#{{$payment->registrant_id}}" data-toggle="modal" data-target="#myModal" class="camper" payid="{{$payment->id}}">{{$payment->registrant_id}}</a></td>
                                            <td>Batch registration</td>
                                        @else
                                            <td><a href="#{{$payment->registrant->reg_id}}" data-toggle="modal" data-target="#myModal" class="camper" payid="{{$payment->id}}">{{$payment->registrant->reg_id}}</a></td>
                                            <td>{{strtoupper($payment->registrant->surname) ." ".$payment->registrant->firstname}}</td>
                                        @endif
                                        <td>{{$payment->amount_paid}}</td>
                                        {{--<td>{{$payment->payment_details}}</td>--}}
                                        {{--<td>{{$payment->comment}}</td>--}}
                                        <td>{{$payment->created_at->toDateString()}}</td>
                                        <td>{{$payment->user->fullname}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <form class="form-horizontal">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header" style="background-color:#007bb6;color:white">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">Title</h4>
                            </div>

                            <div class="modal-body">
                                {!! Form::open(['method'=>'PATCH','route' => ['payment.update',-12],'class'=>'form-horizontal']) !!}{{ csrf_field() }}
                                <input type="hidden" name="paymentid" id="paymentid" value="">
                                <input type="text" name="amountinit" id="amountinit" value="" class="form-control" required readonly>
                                <input type="text" name="amountnew" placeholder="Revised amount" class="form-control" required>
                                <textarea  name="comment" placeholder="Comment here" class="form-control" required></textarea>

                                {!! Form::close() !!}

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>

                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
@section('afterMainScripts')
    <script src="{{asset('js/jquery-ui.min.js')}}"></script>
    <script src="{{asset('js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('js/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('js/jszip.min.js')}}"></script>
    <script src="{{asset('js/pdfmake.min.js')}}"></script>
    <script src="{{asset('js/vfs_fonts.js')}}"></script>
    <script src="{{asset('js/buttons.html5.min.js')}}"></script>
    <script src="{{asset('js/dataTables.rowGroup.min.js')}}"></script>
    <script >
        $(document).ready(function() {
            $('.camper').on('click', function (e) {
                var href = $(this).attr('href');//
//                var data = "Hellow there";
                var id = $(this).attr('payid');
//                swal(id,'succcess');
                var name = $(this).closest('td').next('td').text();
                var amount = $(this).closest('td').next('td').next('td').text();
                $('#paymentid').val(id);
                $('#amountinit').val(amount);
                $('#myModalLabel').html('Registration ID: ' + href + ', ' + name + ' (' + amount + ')');
            });

            $(".modal").draggable();

            $('.modal').on('show.bs.modal', function (e) {
                var modal = $('.modal');
                modal.find('.form-horizontal').attr({'action': '{{route('payment.update',1)}}', 'method': 'POST'});
            });

            $('#dtrows').DataTable({
                select: {
                    selector: 'td:not(:first-child)',
                    style: 'os'
                },
                dom: 'lBfrtip',
                buttons: [
//                    {
//                        extend:    'copyHtml5',
//                        text:      '<i class="fa fa-files-o"></i>',
//                        titleAttr: 'Copy'
//                    },
                    {
                        extend:    'excelHtml5',
                        text:      '<img src="img/exportexcel.png"/>',
                        titleAttr: 'Excel'
                    },
//                    {
//                        extend:    'csvHtml5',
////                        text:      '<i class="fa fa-file-text-o"></i>',
//                        text:      '<img src="img/exportexcel.png" />',
//                        titleAttr: 'CSV'
//                    },
                    {
                        extend:    'pdfHtml5',
//                        text:      '<i class="fa fa-file-pdf-o"></i>',
                        text:'<img src="img/exportpdf.png"/>',
                        titleAttr: 'PDF'
                    }
                ],
//                columnDefs: [
//                    { "visible": false, "targets": 2 }
//                ],
//                order: [[ 2, 'asc' ]],
//                displayLength: 25,
//                drawCallback: function ( settings ) {
//                    var api = this.api();
//                    var rows = api.rows( {page:'current'} ).nodes();
//                    var last=null;
//
//                    api.column(6, {page:'current'} ).data().each( function ( group, i ) {
//                        if ( last !== group ) {
//                            $(rows).eq( i ).before(
//                                '<tr class="group"><td colspan="7">'+group+'</td></tr>'
//                            );
//
//                            last = group;
//                        }
//                    } );
//                },
                rowGroup: {
                    startRender: function ( rows, group ) {
                        return group +' has authorized <b>('+rows.count()+') </b>campers';
                    },
                    endRender: function ( rows, group ) {
                        var salaryAvg = rows
                            .data()
                            .pluck(2)
                            .reduce( function (a, b) {
                                return a + b.replace(/[^\d]/g, '')*1;
                            }, 0);
                        salaryAvg = $.fn.dataTable.render.number(',', '.', 0, 'GHC ').display( salaryAvg );

                        var ageAvg = rows
                                .data()
                                .pluck(2)
                                .reduce( function (a, b) {
                                    return a + b*1;
                                }, 0) / rows.count();

                        return $('<tr/>')
                            .append( '<td colspan="2">Total Amounts Received by:  '+group+'</td>' )
                            //                            .append( '<td>'+ageAvg.toFixed(0)+'</td>' )
                            //                            .append( '<td/>' )
                            .append( '<td>'+salaryAvg+'</td>' );
                    },
                    dataSrc: 4
                }

            })
        })
    </script>
@endsection