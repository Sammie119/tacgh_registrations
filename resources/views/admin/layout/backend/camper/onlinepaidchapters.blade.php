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
                                        {{--<th>Payment Token</th>--}}
                                        <th>Batch No</th>
                                        <th>Name</th>
                                        <th>Payment Mode</th>
                                        {{--<th>Transaction No</th>--}}
                                        <th>Camper Fee</th>
                                        <th>Amount</th>
                                        <th>Date Paid</th>
                                        <th>Token</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($registrants as $registrant)
                                        <tr>
                                            {{--<td>{{$registrant->payment_token}}</td>--}}

                                            <td class="details-control">{{$registrant->batch_no}}</td>
                                            <td class="details-control">{{$registrant->reg_id}}</td>
                                            {{--<td>{{$registrant->payment_mode}}</td>--}}
                                            <td>{{$registrant->transaction_no}}</td>
                                            <td>{{$registrant->camper_fee}}</td>
                                            <td>{{$registrant->amount_paid}}</td>
                                            <td>{{$registrant->date_paid}}</td>
                                            {{--<td class="details-control"><a class="btn btn-primary" data-toggle="collapse" chapter="{{$registrant->reg_id}}" href="{{$registrant->payment_token}}" aria-expanded="false" aria-controls="collapseExample">{{$registrant->payment_token}}</a></td>--}}
                                            {{--<td>{{$registrant->payment_token}}</td>--}}
                                            <td><a href="#{{$registrant->batch_no}}" btoken="{{$registrant->payment_token}}" data-toggle="modal" data-target="#myModal" class="batch">{{$registrant->payment_token}}</a></td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                {!! Form::open(['method'=>'POST','route' => ['batchregistration.chapteronlineauthorize'],'class'=>'form-horizontal popup']) !!}
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header" style="background-color:#007bb6;color:white">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Title</h4>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="batchno" id="batchno" value="">
                            <input type="hidden" name="ptoken" id="ptoken" value="">
                            <input type="text" name="amountpaid" id="amountpaid" placeholder="Amount paid" value="" class="form-control" required>
                            <input type="text" name="paymentdetails" id="paymentdetails" value="" class="form-control" required>
                            <textarea  name="comment" placeholder="Comment here" class="form-control" required></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">Authorize Batch</button>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
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

            $('#dtrows tbody').on('click','.batch',function(e){
                var selectedrow = dt.row( $(this).parents('tr') ).data();
//                alert(selectedrow);
//                var href = $(this).attr('href');
                var ctoken = $(this).attr('btoken');
//                var id = $(this).attr('payid');
//                var name = $(this).closest('td').next('td').text();
//                var amount = $(this).closest('td').next('td').next('td').text();
                $('#batchno').val(selectedrow[0]);
                $('#ptoken').val(ctoken);
                $('#amountpaid').val(selectedrow[4]);
                $('#paymentdetails').val(selectedrow[2]);

                $('#myModalLabel').html('Batch No: '+selectedrow[0]+', '+ctoken);
            });
        })
    </script>
@endsection