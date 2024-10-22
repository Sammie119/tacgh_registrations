@extends('admin.layout.template')
@section('afterAllCss')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.4.2/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/rowgroup/1.0.2/css/rowGroup.dataTables.min.css">
    <style>
        a.dt-button{border:none;width:auto;height:auto;}
    </style>

@endsection
@section('content')
    <section class="content-wrapper">
        <section class="content-header">
            <h1>Payments</h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Payments</li>
            </ol>
        </section>
        <div class="content">
            <div class="row">
                <div class="box box-solid">
                    <div class="box-header">

                        <div class="row" style="margin-bottom: 10px">
                            <div class="col-md-4">
                                <h3 style="margin-top:20px;font-size: 20px;">View Payments</h3>
                            </div>
                        </div>
                    </div>
                    <div class="box-body table-responsive">
                        @if($payments)
                            <table id="dtrows" class="table table-bordered table-striped table-hover">
                                <thead>
                                <tr>
                                    <th>Camper ID</th>
                                    <th>Camper Name</th>
                                    <th>Expected Amount</th>
                                    <th>Amount Paid</th>
                                    <th>Payment Details</th>
                                    {{--<th>Comment</th>--}}
                                    <th>Date Authorized</th>
                                    {{--<th>Duplicate Check</th>--}}
                                </tr>
                                </thead>
                                <tbody>

                                {{--@foreach($payments as $payment)--}}
                                    {{--<tr>--}}
                                        {{--<td>{{$payment->registrat_id}}</td>--}}
                                            {{--@if(strlen($payment->registrant_id) == 10)--}}
                                            {{--<td><a href="#{{$payment->registrant_id}}" data-toggle="modal" data-target="#myModal" class="camper" payid="{{$payment->id}}">{{$payment->registrant_id}}</a></td>--}}
                                        {{--@if(isset($payment->batch))--}}
                                            {{--<td>{{$payment->batch->chapter}}</td>--}}
                                            {{--<td>{{$payment->batch->chapter}}</td>--}}
                                                {{--@else--}}
                                                {{--<td>{{$payment->registrant_id}}</td>--}}
                                            {{--@endif--}}
                                        {{--@else--}}
                                                {{--<td><a href="#{{$payment->individualcamper->reg_id}}" data-toggle="modal" data-target="#myModal" class="camper" payid="{{$payment->id}}">{{$payment->individualcamper->reg_id}}</a></td>--}}
                                            {{--<td><a href="#{{$payment->registrant_id}}" data-toggle="modal" data-target="#myModal" class="camper" payid="{{$payment->id}}">{{$payment->individualcamper->reg_id}}</a></td>--}}
                                            {{--<td>{{strtoupper($payment->individualcamper->firstname) ." ".$payment->individualcamper->surname}}</td>--}}
                                            {{--<td>Individual</td>--}}
                                        {{--@endif--}}

                                        {{--<td>{{$payment->amount_paid}}</td>--}}
                                        {{--<td>{{$payment->payment_details}}</td>--}}
                                        {{--<td>{{$payment->comment}}</td>--}}
                                        {{--<td>{{$payment->created_at->toDateString()}}</td>--}}
                                        {{--<td>{{$payment->user->fullname}}</td>--}}
                                                {{--@if(strlen($payment->registrant_id)>10)--}}
                                                    {{--<td>{{$payment->registrant_id}}</td>--}}
                                                {{--@else--}}
                                                    {{--<td>{{$payment->individualcamper->reg_id}}</td>--}}
                                                {{--@endif--}}
                                    {{--</tr>--}}
                                {{--@endforeach--}}

                                @foreach($payments as $payment)
                                    <tr>
                                        <td>{{ $payment->reg_id }}</td>
                                        <td>{{strtoupper($payment->camper->firstname) ." ".$payment->camper->surname}}</td>
                                        <td>{{$payment->camper->campfee->FullName}}</td>
                                        <td>{{$payment->amount_paid}}</td>
                                        <td><strong>Transaction No.:</strong> {{$payment->transaction_no}}<br/><strong>Payment Mode: </strong>{{$payment->payment_mode}}</td>
                                        <td>{{$payment->created_at->toDateString()}}</td>
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
                {{--<form class="form-horizontal">--}}
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header" style="background-color:#007bb6;color:white">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">Title</h4>
                            </div>
                            <form method="POST" action="payment/1">
{{--                            {!! Form::open(['method'=>'PATCH','route' => ['payment.update',-12],'class'=>'form-horizontal']) !!}--}}
                            {{ csrf_field() }}
                            {{ method_field('PATCH') }}
                            <div class="modal-body">

                                <input type="hidden" name="paymentid" id="paymentid" value="">
                                <input type="text" name="amountinit" id="amountinit" value="" class="form-control" required readonly>
                                <input type="text" name="amountnew" placeholder="Revised amount" class="form-control" required>
                                <textarea  name="comment" placeholder="Comment here" class="form-control" required></textarea>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                            {{--{!! Form::close() !!}--}}
                            </form>
                        </div>
                    </div>

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
    {{--<script src="{{asset('js/buttons.print.min.js')}}"></script>--}}
    <script src="{{asset('js/buttons.colVis.min.js')}}"></script>
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

           var dtpayments = $('#dtrows').DataTable({
                select: {
                    selector: 'td:not(:first-child)',
                    style: 'os'
                },
                stateSave: true,
                dom: 'lBfrtip',
                buttons: [
                    {
                        extend:    'excelHtml5',
                        text:      '<img src="../img/exportexcel.png"/>',
                        title: 'APOSA Camp 21 Payments',
                        titleAttr: 'Excel'
                    },
                    {
                        extend:    'pdfHtml5',
                        text:'<img src="../img/exportpdf.png"/>',
                        title: 'APOSA Camp 21 Payments',
                        orientation: 'landscape',
                        pageSize: 'LEGAL',
                        titleAttr: 'PDF'
                    },
                    {
                        extend:     'colvis',
                        text:       'Toggle Columns'
                    }
                ],
                "rowCallback": function( row, data, index ) {
                    var allData = this.api().column(7).data().toArray();
                    if (allData.indexOf(data[7])!= allData.lastIndexOf(data[7])) {
                        $('td:eq(7)', row).css({'background-color':'Red','color':'white'}).html('CHECK');
                    }
                }
            })
//            var dtpayments = $.fn.dataTable.tables({ api: true });
//            var camp_codes = dtpayments.columns(0).data()[0];
////            console.log(camp_codes);
//            var num = 0;
//            dtpayments.rows().every( function ( rowIdx, tableLoop, rowLoop ) {
//                var code = $(this.data()[0]).attr('href');
//                    console.log("href val is: "+code);
//                camp_codes.forEach( function (colval) {
//                    console.log('col value is: '+$(colval).attr('href'));
//                    if ( $(colval).attr('href') == code )
//                        num++;
//                    console.log($(colval).attr('href')+" and "+code);
//                } )
//
//                if ( num > 1 )
//                    $(this.node()).addClass('duplicate');
//                num = 0;
//            } )
        })
    </script>
@endsection