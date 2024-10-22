@extends('admin.layout.template')
@section('afterAllCss')
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
{{--    <link rel="stylesheet" href="{{ asset('plugins/iCheck/all.css') }}">--}}
    <!-- Select2 -->
{{--    <link rel="stylesheet" href="{{ asset('plugins/select2/select2.min.css') }}">--}}
@endsection
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <section class="content-header">
            <h1>Batch Room Allocation <br><small>Batch No. {{$batch}}</small></h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="{{route('assign')}}">Search</a></li>
                <li class="active">Search Result</li>
            </ol>
        </section>
        <section class="content">
            <div class="row">

                {{--MALE--}}
                <div class="col-md-6">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Males</h3>
                            <button onclick="printDiv('printableAreaMale')" class="btn btn-sm btn-default pull-right"><i class="fa fa-save"></i> Print List</button>
                        </div>
                        <div class="box-body">
                            <p id="message"></p>

                            <form class="form-horizontal" id="male-form" method="GET" action="{{route('batchAllocation')}}">
                                {{ csrf_field() }}
                                <input type="hidden" name="batch_no" id="batch_no" value="{{$batch}}">
                                <input type="hidden" name="gender_id" id="gender_id" value="3">
                                <div class="row" style="margin-bottom: 15px">

                                    <div class="col-md-6">
                                        <select class="form-control select2" data-placeholder="Select Residence" id="list_residences" name="residence_id" style="width: 100%;">
                                            <option value="">-- Select Residence --</option>
                                            @foreach ($Mresidences as $residence)
                                                @if ($residence->rooms->count() > 0)
                                                    <option value="{{ $residence->id }}">{{ $residence->name }}</option>
                                                @endif

                                            @endforeach
                                        </select>
                                        <!-- /.form-group -->
                                    </div>
                                    <div class="col-md-6">
                                        <select class="form-control select2" required="required" id="list_blocks" name="block_id" style="width: 100%;">
                                            <option value="">-- Select Block --</option>
                                        </select>
                                        <!-- /.form-group -->
                                    </div>
                                </div>
                                <div class="row" style="margin-bottom: 15px">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-success btn-flat"><i class="fa fa-hotel margin-r-5" aria-hidden="true"></i> Assign</button>
                                    </div>
                                </div>
                            </form>
                            <div id="printableAreaMale">
                                <h4 style="font-size: 1.7rem;">Room Allocation for Males in batch({{$batch}})</h4>
                                <table class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Camper ID</th>
                                        <th>Type</th>
                                        <th>Room No.</th>
                                    </tr>
                                    </thead>
                                    <tbody id="Mlist">
                                    @foreach($bulkList as $registrant)
                                        @if($registrant->gender_id == 3)
                                            <tr>
                                                <td>{{$registrant->firstname." ".$registrant->surname}}</td>
                                                <td>{{$registrant->reg_id}}</td>
                                                @if($registrant->campercat_id == NULL)
                                                    <td><span class="text-danger" style="font-weight: bolder">Category Not Set</span></td>
                                                @else
                                                    <td>{{$types[$registrant->campercat_id]}}</td>
                                                @endif
                                                <td>@if($registrant->room_id)
                                                        {{$registrant->room->residence->name.", ".$registrant->room->block->name." (Rm. ".$registrant->room->prefix." ".$registrant->room->room_no." ".$registrant->room->suffix.")"}}
                                                    @elseif($registrant->confirmedpayment == 0)
                                                        <span class="text-danger">Not Authorized</span>
{{--                                                    @elseif(!$registrant->room_id and $registrant->specialaccom_id == 44)--}}
{{--                                                        <a hre="{{route('search',[$registrant->reg_id])}}">Special Accomodation (Not Assigned)</a>--}}
                                                    @else
                                                        <span class="text-danger">Not Assigned</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div style="display: none" id="male-load" class="overlay">
                            <i class="fa fa-spinner fa-spin"></i>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>

                {{--FEMALE--}}
                <div class="col-md-6">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Females</h3>
                            <a href="#" onclick="printDiv('printableAreaFemale')" target="_blank" class="btn btn-sm btn-default pull-right"><i class="fa fa-print"></i> Print List</a>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <p id="Fmessage"></p>
                            <form class="form-horizontal" id="female-form" method="GET" action="{{route('batchAllocation')}}">
                                {{ csrf_field() }}
                                <input type="hidden" name="batch_no" id="batch_no" value="{{$batch}}">
                                <input type="hidden" name="gender_id" id="fgender_id" value="4">
                                <div class="row" style="margin-bottom: 15px">

                                    <div class="col-md-6">
                                        {{-- {{ var_dump($residences->toJson()) }} --}}
                                        <select class="form-control select2" data-placeholder="Select Residence" id="list_Fresidences" name="residence_id" style="width: 100%;">
                                            <option></option>
                                            @foreach ($Fresidences as $residence)
                                                @if ($residence->rooms->count() > 0)
                                                    <option value="{{ $residence->id }}">{{ $residence->name }}</option>
                                                @endif

                                            @endforeach
                                        </select>
                                        <!-- /.form-group -->
                                    </div>
                                    <div class="col-md-6">
                                        <select class="form-control select2" required="required" id="list_blocks_female" name="block_id" style="width: 100%;">
                                            <option></option>
                                        </select>
                                        <!-- /.form-group -->
                                    </div>
                                </div>
                                <div class="row" style="margin-bottom: 15px">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-success btn-flat"><i class="fa fa-hotel margin-r-5" aria-hidden="true"></i> Assign</button>
                                    </div>
                                </div>
                            </form>
                            <div id="printableAreaFemale">
                                <h4 style="font-size: 1.7rem;">Room Allocation for Females in batch({{$batch}})</h4>
                                <table class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Camper ID</th>
                                        <th>Type</th>
                                        <th>Room No.</th>
                                    </tr>
                                    </thead>
                                    <tbody id="Flist">
                                    @foreach($bulkList as $registrant)
                                        @if($registrant->gender_id == 4)
                                            <tr>
                                                <td>{{$registrant->firstname." ".$registrant->surname}}</td>
                                                <td>{{$registrant->reg_id}}</td>
                                                <td>{{$types[$registrant->campercat_id]}}</td>
                                                <td>@if($registrant->room_id)
                                                        {{$registrant->room->residence->name.", ".$registrant->room->block->name." (Rm. ".$registrant->room->prefix." ".$registrant->room->room_no." ".$registrant->room->suffix.")"}}
                                                    @elseif($registrant->confirmedpayment == 0)
                                                        <span class="text-danger">Not Authorized</span>
{{--                                                    @elseif(!$registrant->room_id and $registrant->specialaccom_id == 44)--}}
{{--                                                        <a hre="{{route('search',[$registrant->reg_id])}}">Special Accomodation (Not Assigned)</a>--}}
                                                    @else
                                                        <span class="text-danger">Not Assigned</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div style="display: none" id="female-load" class="overlay">
                            <i class="fa fa-spinner fa-spin"></i>
                        </div>
                        <!-- /.box-body -->
                    </div>
                </div>

            </div>
        </section>
    </div>
@endsection
@section('afterMainScripts')
{{--    <script src="{{ asset('plugins/select2/select2.full.min.js') }}"></script>--}}
{{--    <script src="{{ asset('plugins/icheck/icheck.min.js') }}"></script>--}}
    <script>
        $('document').ready(function () {

            // $(".select2").select2({
            //     placeholder: "Choose..."
            // });
            $("#list_Fresidences").value == null;
        $('#list_residences').on('change', function (e) {
            var residences = e.target.value;
            var gender = "M";
            // console.log(gender);
            $.get('get_blocks?residence_id='+residences+'&gender='+gender, function (data) {
                console.log(data);
                $('#list_blocks').empty();
                $('#list_blocks').append('<option value="" disabled="disabled" selected>Select Block</option>');

                $.each(data, function (index, brandObj) {
                    $('#list_blocks').append('<option value="'+brandObj.id+'">'+brandObj.name+'</option>');
                });
            });
        });
        $('#list_Fresidences').on('change', function (e) {
            var residences = e.target.value;
            var gender = "F";
            // console.log(gender);
            $.get('get_blocks?residence_id='+residences+'&gender='+gender, function (data) {
                // console.log(data);
                $('#list_blocks_female').empty();
                $('#list_blocks_female').append('<option value="" disabled="disabled" selected>Select Block</option>');

                $.each(data, function (index, brandObj) {
                    $('#list_blocks_female').append('<option value="'+brandObj.id+'">'+brandObj.name+'</option>');
                });
            });
        });
        });

        $('#male-form').on('submit', function (e) {
            e.preventDefault();
            $('#message').empty();
            var batch_id  = $('#batch_no').val();
            var gender_id = $('#gender_id').val();
            var block_id  = $('#list_blocks option:selected').val()
            var residence_id = $('#list_residences option:selected').val()

            var path = "{{route('batchAllocation')}}";
            console.log("our allocation path "+path);
            $.ajaxSetup(    {
                headers: {
                    'X-CSRF-Token': $('meta[name=_token]').attr('content')
                }
            });
            $.ajax({
                url: path,
                type: 'GET',
                data: {batch_no:batch_id, gender_id:gender_id, residence_id:residence_id, block_id:block_id},
                beforeSend: function(){
                    $('#male-load').show();
                },
                success: function(data){
                    $('#Mlist').empty();
                    $('#message').html(data.message);
                    $('#Mlist').html(data.theList);

                    // $.each(data.theList, function (index, brandObj) {
                    //     $('#Mlist').append('<tr><td>'+brandObj.firstname+' '+brandObj.surname+'</td><td>'+brandObj.room_id+'</td></tr>');
                    // });

                    console.log(data);
                },
                complete:function(){
                    $('#male-load').hide();
                }
                ,
                error: function (data) {
                    console.log(data);
                }
            });
        });

        $('#female-form').on('submit', function (e) {
            e.preventDefault();
            $('#Fmessage').empty();
            var batch_id  = $('#batch_no').val();
            var gender_id = $('#fgender_id').val();
            var block_id  = $('#list_blocks_female option:selected').val();
            var residence_id = $('#list_Fresidences option:selected').val();

            var path = "{{route('batchAllocation')}}";
//            console.log("our allocation path "+path);
            $.ajaxSetup(    {
                headers: {
                    'X-CSRF-Token': $('meta[name=_token]').attr('content')
                }
            });
            $.ajax({
                url: path,
                type: 'GET',
                data: {batch_no:batch_id, gender_id:gender_id, residence_id:residence_id, block_id:block_id},
                beforeSend: function(){
                    $('#female-load').show();
                },
                success: function(data){
                    $('#Flist').empty();
                    $('#Fmessage').html(data.message);
                    $('#Flist').html(data.theList);

                    // $.each(data.theList, function (index, brandObj) {
                    //     $('#Mlist').append('<tr><td>'+brandObj.firstname+' '+brandObj.surname+'</td><td>'+brandObj.room_id+'</td></tr>');
                    // });

                    console.log(data);
                },
                complete:function(){
                    $('#female-load').hide();
                }
                ,
                error: function (data) {
                    console.log(data);
                }
            });
        });
    </script>
    <script>
        //Flat red color scheme for iCheck
        // $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
        //     checkboxClass: 'icheckbox_flat-green',
        //     radioClass   : 'iradio_flat-green'
        // })
    </script>
    <script>
        function printDiv(divName) {
            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;

            window.print();

            document.body.innerHTML = originalContents;
        }
    </script>
@endsection
@section('afterOtherScripts')

@endsection