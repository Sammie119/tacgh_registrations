@extends('admin.layout.template')
@section('afterAllCss')
    <link rel="stylesheet" href="{{asset('css/jquery-ui.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/jquery.dataTables.min.css')}}">
    <style>
        td,thead{
            padding:10px ;
            margin:5px;
        }
    </style>
@endsection
@section('content')
    <section class="content-wrapper">
        <section class="content-header">
            <h1>Chapters (Made Online Payment)</h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Applicants</li>
            </ol>
        </section>

        <div class="content">
            <div class="row">
                <div class="box box-solid">

                    <div class="panel-body">
                        @if($show_batch_list == 1)
                            <div class="table-responsive">
                                <table id="dtrows" class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>Batch #</th>
                                        <th>Chapter</th>
                                        <th>Ambassador</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if($registrants)
                                    @foreach($registrants as $registrant)
                                        <tr>
                                            <td class="btn btn-primary">{{$registrant->batch_no}}</td>

                                            <td>{{$registrant->chapter}}</td>
                                            <td>{{$registrant->ambassadorname}}</td>
                                            <td>
                                                <a class="btn btn-success btn-flat" href="{{ route('chapter.onlinepaidchapters') }}"
                                                   onclick="event.preventDefault(); document.getElementById('batch-form{{$registrant->id}}').submit();">
                                                    Process
                                                </a>

                                                <form id="batch-form{{$registrant->id}}" action="{{ route('chapter.onlinepaidchapters') }}" method="GET" style="display: none;">
                                                    {{ csrf_field() }}
                                                    <input type="hidden" name="batch_no" value="{{$registrant->batch_no}}">
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                        @endif
                                    </tbody>
                                </table>

                            </div>
                        @endif
                                    <div class="container">
                                        @if($show_batch_list == 0)
                                        @if($registrants)
                                                <form class="form-horizontal" id="batchprocessing" role="form" method="POST" action="{{ route('chapter.authorizedpaidchaptermembers') }}">
                                                    {{ csrf_field() }}

                                                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                                        <div class="panel panel-default">
                                                            <div class="panel-heading" role="tab" id="headingOne" class="header-warning">
                                                                <h4 class="panel-title">
                                                                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                                        <span class="collapse-header-span"></span> <i class="more-less glyphicon glyphicon-plus"></i>
                                                                        Non-paid Chapter Members <span class="fee-display"></span>
                                                                    </a>
                                                                </h4>
                                                            </div>
                                                            <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                                                                <div class="panel-body">
                                                                    @if($nonpaidmembers)
                                                                        <div class="table-responsive">
                                                                        <table id="dtrows-nonpaid" class="table table-striped">
                                                                        <thead>
                                                                        <tr>
                                                                        <th>Reg #</th>
                                                                        <th>Camper</th>
                                                                        <th>Age</th>
                                                                        <th>Gender</th>
                                                                        <th>Camper Type</th>
                                                                        <th>Description</th>
                                                                        <th>Camp Fee</th>
                                                                        <th class="check">Paid?
                                                                            <input type="checkbox" id="memberCheckAll" class="memberCheckAll" name="selectall" value="1"  checked="true"/></th>
                                                                        </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                        @foreach($nonpaidmembers as $registrant)
                                                                     <tr>
                                                                        <td class="details-control1">{{$registrant->reg_id}}</td>
                                                                        <td>{{strtoupper($registrant->surname) ." ".$registrant->firstname}}</td>
                                                                        {{--<td>{{$registrant->dob}}<span>yrs</span></td>--}}
                                                                        <td>{{$registrant->dob}}</td>
                                                                        <td>{{$registrant->gender}}</td>
                                                                        <td>{{$registrant->camper}}</td>
                                                                        <td>{{$registrant->camper_fee_desc}}</td>
                                                                        <td>{{$registrant->camper_fee}}</td>
                                                                        <td class="floatright">{{ Form::checkbox('registrants[]',  $registrant->reg_id ,null,['checked']) }}</td>
                                                                      </tr>
                                                                        @endforeach
                                                                        </tbody>
                                                                        </table>
                                                                        </div>

                                                                        <div class="container-fluid">
                                                                            <div class="row">
                                                                                <div class="col-lg-8 col-md-12">
                                                                                    <input type="hidden" name="move_to_paid" id="hid_move_to_paid" value=""/>
                                                                                    <input type="submit" name="member_move_to_paid" class="btn btn-success" id="move_to_paid" value="Move Selected To Paid Chapter Members" style="margin-top:10px" />
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @else
                                                                        <div>No non-paid members </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                        <div class="panel panel-default">
                                                            <div class="panel-heading" role="tab" id="headingTwo" class="header-success">
                                                                <h4 class="panel-title">
                                                                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                                        <span class="collapse-header-span"></span><i class="more-less glyphicon glyphicon-plus"></i>
                                                                        Paid Chapter Members (members who have paid to leader)<span class="fee-display"></span>
                                                                    </a>
                                                                </h4>
                                                            </div>
                                                            <div id="collapseTwo" class="panel-collapse collapsed" role="tabpanel" aria-labelledby="headingTwo">
                                                                <div class="panel-body">
                                                                    @if($paidmembers)
                                                                        <div class="table-responsive">
                                                                            <div>Paid Chapter Members</div>
                                                                            <table  id="dtrows-paid" class="table table-striped">
                                                                                <thead>
                                                                                <tr>
                                                                                    <th>Reg #</th>
                                                                                    <th>Camper</th>
                                                                                    <th>DOB</th>
                                                                                    <th>Gender</th>
                                                                                    <th>Camper Type</th>
                                                                                    <th>Description</th>
                                                                                    <th>Fee</th>
                                                                                    <th class="check">Authorize
                                                                                        <input type="checkbox" id="paidmemberCheckAll" class="memberCheckAll" name="selectall" value="1"  checked="true"/></th>
                                                                                </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                @foreach($paidmembers as $registrant)
                                                                                    <tr>
                                                                                        <td>{{$registrant->reg_id}}</td>
                                                                                        <td>{{strtoupper($registrant->surname) ." ".$registrant->firstname}}</td>
                                                                                        {{--<td>{{$registrant->dob}}<span>yrs</span></td>--}}
                                                                                        <td>{{$registrant->dob}}</td>
                                                                                        <td>{{$registrant->gender}}</td>
                                                                                        <td>{{$registrant->camper}}</td>
                                                                                        <td>{{$registrant->camper_fee_desc}}</td>
                                                                                        <td>{{$registrant->camper_fee}}</td>
                                                                                        <td class="floatright">{{ Form::checkbox('paidregistrants[]',  $registrant->reg_id ,null,['class'=>'checked-member','checked']) }}</td>
                                                                                    </tr>
                                                                                @endforeach
                                                                                </tbody>
                                                                            </table>

                                                                        </div>
                                                                    @else
                                                                        <div>No paid members </div>
                                                                    @endif
                                                                </div>
                                                                <hr/>
                                                                <div class="container-fluid">
                                                                    <div class="row">
                                                                        <div class="col-lg-6 col-md-6">
                                                                            <table border="1" cellpadding="3" cellspacing="3" width="80%">
                                                                                <thead>
                                                                                <tr class="table-row">
                                                                                    <th>Item</th>
                                                                                    <th>Amount</th>
                                                                                </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                <tr class="table-row"><td>Total Fees </td><td>{{number_format($total_fee, 2, '.', ',')}}</td></tr>
                                                                                <tr><td>Total Payments (Online + Cash on grounds)</td><td>{{number_format($received_online_payments, 2, '.', ',')}}</td></tr>
                                                                                <tr><td>Total Authorized Campers Fees</td><td>{{number_format($total_authorized_payments, 2, '.', ',')}}</td></tr>
                                                                                <tr><td>Outstanding Amount for Authorization</td><td>{{number_format($received_online_payments - $total_authorized_payments, 2, '.', ',')}}</td></tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </div>

                                                                        <div class="col-lg-6 col-md-6 payment-form" >
                                                                            <div ><div>
                                                                                    <input type="button" id="calcBatchAmount" class="btn btn-primary" value="Calculate Payment" title="Calculates for checked members"/>
                                                                                </div>

                                                                                <h4>Authorization here!</h4>

                                                                                <input type="hidden" name="amount_balance" value="{{$received_online_payments - $total_authorized_payments}}"/>
                                                                                <input type="hidden" name="batch_no" value="{{$batch_no}}">
                                                                                <input type="text" name="amount_paid"  placeholder="Amount paid" value="0" class="form-control" required>

                                                                                <div><textarea  name="description" placeholder="Payment description" class="form-control" required></textarea><div></div>
                                                                                <textarea  name="comment" placeholder="Comment here" class="form-control" required></textarea>
                                                                            </div>
                                                                            {{--<div class="modal-footer">--}}
                                                                                <input type="submit" class="btn btn-success" value="Authorize Selected" style="margin-top:10px" />
                                                                            {{--</div>--}}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="panel panel-default">
                                                            <div class="panel-heading" role="tab" id="headingThree" class="header-default">
                                                                <h4 class="panel-title">
                                                                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                                                        <span class="collapse-header-span"></span><i class="more-less glyphicon glyphicon-plus"></i>
                                                                        Payments History <span class="fee-display"></span>
                                                                    </a>
                                                                </h4>
                                                            </div>
                                                            <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                                                                <div class="panel-body">
                                                                    @if($payment_details)
                                                                        <h4>Payments</h4>
                                                                        <div class="table-responsive">
                                                                            <table class="table table-striped table-bordered">
                                                                                <tr>
                                                                                    <th>Paid On</th>
                                                                                    <th>Payment Mode</th>
                                                                                    <th>Transaction No.</th>
                                                                                    <th>Amount Paid (GHS)</th>
                                                                                    <th>Approved?</th>
                                                                                </tr>
                                                                                @if($payment_details->count() > 0)
                                                                                    @foreach($payment_details as $initial_payment)
                                                                                        <tr>
                                                                                            <td>{{date('F j, Y', strtotime($initial_payment->created_at))}}</td>
                                                                                            <td>{{ucwords(str_replace('-',' ',$initial_payment->payment_mode))}}</td>
                                                                                            <td>{{$initial_payment->transaction_no}}</td>
                                                                                            <td>{{$initial_payment->amount_paid}}</td>
                                                                                            <td style="color: #5cb85c">{{$initial_payment->approved == 0?'No':'Yes'}}</td>
                                                                                        </tr>
                                                                                    @endforeach
                                                                                @else
                                                                                    <tr>
                                                                                        <td colspan="5" style="text-align: center">No payments history</td>
                                                                                    </tr>
                                                                                @endif
                                                                            </table>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <hr/>
                                                    </div>
                                                </form>
                                        @endif
                                    @endif
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

           var paid_members = $('#dtrows-paid').DataTable({
               columnDefs: [{
                   targets: 7,
//                   data: 2,
                   'checkboxes': {
                       'selectRow': true
                   }
               }]
           });

            var non_paid_members = $('#dtrows-nonpaid').DataTable({});
            $("#memberCheckAll").click(function () {
                var cols = non_paid_members.column(7).nodes();
                state = this.checked;
                for (var i = 0; i < cols.length; i += 1) {
                    cols[i].querySelector("input[type='checkbox']").checked = state;
                }
            });

            $('#dtrows tbody').on('click','.batch',function(e){
//                alert('hey');
                var href = $(this).attr('href');//
//                var data = "Hellow there";

                var id = $(this).attr('payid');
//                alert(id);
//                swal(id,'succcess');
                var name = $(this).closest('td').next('td').text();
                var amount = $(this).closest('td').next('td').next('td').text();
                $('#batchno').val(href);
                $('#amountinit').val(amount);
//                $('#myModalLabel').html('Batch No: '+href+', '+name+' '+amount);
                $('#myModalLabel').html('Batch No: '+href+', '+amount);
            });
//            $(".modal").draggable();
            $('.content').on('click','#calcBatchAmount',function(e){
                var totalAmount=0;

                $(paid_members.$('input[type="checkbox"]').map(function () {
                    if($(this).closest('tr').find('input[type="checkbox"]').is(':checked')){
                        var rowc = paid_members.row($(this).closest('tr')).data();

                        totalAmount= totalAmount+parseInt(rowc[6]);
                    }
                } ) );

                // showAlert("Total Amount","You'll make a total payment of: GHC "+totalAmount,"info");
                swal({
                    title:"Total Amount",
                    text:"You'll make a total payment of : GH₵ "+totalAmount,
                    type:"info"
                });
//                alert();
            });

            $('#move_to_paid').on('click',function(e){
                e.preventDefault();
                $('.payment-form').find('input').prop('required', false);
                $('#hid_move_to_paid').val(1);
                $('#batchprocessing').submit();
            })
        })
    </script>
@endsection