@extends('admin.layout.template')
@section('afterAllCss')
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <!-- bootstrap datepicker -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/all.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <link rel="stylesheet" href="{{asset('css/jquery-ui.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/jquery.dataTables.min.css')}}">
    <link type="text/css" href="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.11/css/dataTables.checkboxes.css" rel="stylesheet" />

    <script src="{{asset('js/jquery-3.2.1.min.js')}}"/>
    <script type="text/javascript" src="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.11/js/dataTables.checkboxes.min.js"></script>
    {{--<link href="{{asset('css/bootstrap-switch.min.css')}}" rel="stylesheet"/>--}}
    {{--<script type="text/javascript" src="http://code.jquery.com/jquery-1.7.1.min.js"></script>--}}
    {{--<script>--}}
        {{--$(document).ready(function(){--}}
            {{--$('.switchbutton').bootstrapSwitch({--}}
                {{--onColor:'primary',--}}
                {{--onText:'Send',--}}
                {{--offText:'NA'--}}
            {{--});--}}
        {{--})--}}
    {{--</script>--}}
@endsection
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper bg-im">
        <section class="content">
                        <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Batch List</h3>
                    <p>Select the Batch to generate and send tokens to</p>
                </div>
                <!-- /.box-header -->
                <form class="form-horizontal" id="paymentform" role="form" method="POST" action="{{ route('message.batchtokensend') }}">
                    {{ csrf_field() }}
                <div class="box-body no-padding">
                    @if($batches)
                        <table id="flow-table" class="table table-bordered table-striped table-hover">
                            <thead>
                            <tr>
                                <th>Chapter</th>
                                <th>Batch No</th>
                                <th>Ambassador Name</th>
                                <th>Ambassador Phone</th>
                                <th class="check">
                                    &nbsp;Select All <input type="checkbox" id="flowcheckall" name="selectall" value="1" />
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($batches as $batch)
                                <tr>
                                    <td>{{$batch['chapter']}}</td>
                                    <td>{{$batch['batch_no']}}</td>
                                    <td>{{$batch['ambassadorname']}}</td>
                                    <td>{{$batch['ambassadorphone']}}</td>
                                    <td class="floatright">{{ Form::checkbox('batches[]',  $batch->batch_no ,null) }}</td>
                                    {{--<td class="floatright">{{ Form::checkbox('batches[]',  $batch->batch_no ,null) }}</td>--}}
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
                    <div>
                        <button type="submit">Generate & Send Token</button>
                    </div>
                </form>

            </div>
        </section>
    </div>
    <!-- /.content-wrapper -->
@endsection
@section('afterOtherScripts')
    <script src="{{asset('js/jquery-ui.min.js')}}"></script>
    <script src="{{asset('js/jquery.dataTables.min.js')}}"></script>
    {{--<script src="{{asset('js/bootstrap-switch.min.js')}}"></script>--}}
    <script>
        $(document).ready(function() {
            var oTableStaticFlow = $('#flow-table').DataTable({
                "processing": true,
                "select": true,
                "aoColumnDefs": [{
                    'bSortable': false,
                    'aTargets': [4]
                }],
            });

            $("#flowcheckall").click(function () {
                //$('#flow-table tbody input[type="checkbox"]').prop('checked', this.checked);
                var cols = oTableStaticFlow.column(4).nodes(),
                    state = this.checked;

                for (var i = 0; i < cols.length; i += 1) {
                    cols[i].querySelector("input[type='checkbox']").checked = state;
                }
            });

            $('#paymentform').on('submit', function(e){
                var form = this;

                // Encode a set of form elements from all pages as an array of names and values
                var params = oTableStaticFlow.$('input,select,textarea').serializeArray();

                // Iterate over all form elements
                $.each(params, function(){
                    // If element doesn't exist in DOM
                    if(!$.contains(document, form[this.name])){
                        // Create a hidden element
                        $(form).append(
                            $('<input>')
                                .attr('type', 'hidden')
                                .attr('name', this.name)
                                .val(this.value)
                        );
                    }
                });
            });

        })
    </script>
    {{--<script src="{{asset('js/bootstrap-switch.min.js')}}"></script>--}}
@endsection