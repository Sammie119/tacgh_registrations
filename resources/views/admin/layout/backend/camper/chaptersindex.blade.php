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
            <h1>@if($show_batch_list == 1){{ "Chapters with Not-Authorized Members"}}@else{{"Chapter Members Pending Authorization"}}@endif</h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Applicants</li>
            </ol>
        </section>

        <div class="content">
            <div class="container-fluid">
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
                                            <td>{{$registrant->batch_no}}</td>
                                            <td>{{$registrant->chapter}}</td>
                                            <td>{{$registrant->ambassadorname}}</td>
                                            <td>
                                                <a class="btn btn-success btn-flat" href="{{ route('chapter.nonpaidchapters') }}"
                                                   onclick="event.preventDefault(); document.getElementById('batch-form{{$registrant->id}}').submit();">
                                                    Process
                                                </a>
                                                <form id="batch-form{{$registrant->id}}" action="{{ route('chapter.nonpaidchapters') }}" method="GET" style="display: none;">
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
                                                <form class="form-horizontal" id="batchprocessing" role="form" method="POST" action="{{ route('chapter.authorizechapterlist') }}">
                                                    {{ csrf_field() }}
                                                                <div class="panel-body">
                                                                    @if($registrants)
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
                                                                        <th>Fee (GHS)</th>
                                                                        <th class="check">Paid?
                                                                            <input type="checkbox" id="memberCheckAll" class="memberCheckAll" name="selectall" value="1"  checked="true"/></th>
                                                                        </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                        @foreach($registrants as $registrant)
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
                                                                    @else
                                                                        <div>No non-paid members </div>
                                                                    @endif
                                                                </div>
                                                        <hr/>
                                                    <div class="container-fluid">
                                                        <div class="row">
                                                            <div class="col-lg-6 col-md-6">
                                                                <div >
                                                                    <div>
                                                                        <input type="button" id="calcBatchAmount" class="btn btn-primary" value="Calculate Payment" title="Calculates for checked members"/>
                                                                    </div>
                                                                    <h4>Authorization here!</h4>
                                                                    <input type="hidden" name="batch_no" id="batchno" value="{{$batch_no}}">
                                                                    <input type="text" name="amount_paid"  placeholder="Amount paid" value="" class="form-control" required>

                                                                    <textarea  name="description" placeholder="Payment description" class="form-control" required></textarea>
                                                                    <textarea  name="comment" placeholder="Comment here" class="form-control" required></textarea>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="submit" class="btn btn-primary">Authorize Selected</button>
                                                                </div>
                                                            </div>
                                                        </div>
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
        /* Formatting function for row details - modify as you need */
        $(document).ready(function() {
//            $(".modal").draggable();

            $('#dtrows').DataTable({});
            var non_paid_members = $('#dtrows-nonpaid').DataTable({});


            $('.content').on('click','#calcBatchAmount',function(e){
                var totalAmount=0;

                $(non_paid_members.$('input[type="checkbox"]').map(function () {
                    if($(this).closest('tr').find('input[type="checkbox"]').is(':checked')){
                        var rowc = non_paid_members.row($(this).closest('tr')).data();

                        totalAmount= totalAmount+parseInt(rowc[6]);
                    }
                } ) );

                swal({
                    title:" GH₵ "+totalAmount,
                    text:"Total Amount for checked chapter members",
                    type:"info"
                });
//                swal("Supposed amount to pay: GHC "+totalAmount);
            });


            $("#memberCheckAll").click(function () {
                var cols = non_paid_members.column(7).nodes();
                state = this.checked;
                for (var i = 0; i < cols.length; i += 1) {
                    cols[i].querySelector("input[type='checkbox']").checked = state;
                }
            });
        })
    </script>
@endsection