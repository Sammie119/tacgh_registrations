@extends('layouts.app')
@section('beforecss')
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('css/AdminLTE.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/iCheck/all.css') }}">
    <style>
        .box-body ul {
            list-style-type: none;
        }
        .box-body ul li{margin:2px}
    </style>
@endsection

@section('content')

    <div id="transparent-dark">
        <div class="container">
            <div class="row">
                <div class="col-md-2 col-md-offset-5 col-sm-3 col-sm-offset-5 col-xs-4 col-xs-offset-4">
                    <a href="{{ url('/') }}" title="Go to Homepage"><img src="{{ asset('img/aposa-main_edit.png') }}" alt="APOSA logo" class="img-responsive sm-mg-b"></a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="box box-solid" style="border-radius: 0px">
                        <div class="box-body">
                            <form class="form-horizontal white" method="POST" action="{{ route('login') }}">
                                {{ csrf_field() }}
                                <h4 class="sub-header" style="margin-bottom: 30px;color:#777">Register as a Batch</h4>
                                <a href="{{route('table_batch')}}" class="btn btn-flat btn-success">
                                    <i class="fa fa-list-ul" style="margin-right: 15px;"></i> REGISTER CAMPERS ON-SCREEN
                                </a>
                                <p class="text-color">Please follow the instructions below:</p>
                                <p class="instructions">
                                <ul style="color:black;text-align:left;padding:5px">
                                    <li><i class="fa fa-check"></i>Please download the excel by clicking the 'Download Excel' button below.</li>
                                    <li><i class="fa fa-check"></i>Fill the appropriate fields in the downloaded excel . eg. Surname, firstname/othernames, Date of Birth(dob), marital status( a dropdown to select from), etc.</li>
                                    <li><i class="fa fa-check"></i>Save the filled excel. Click on the "Choose file" below and browse to the excel you filled. Click upload batch.</li>
                                    <li><i class="fa fa-check"></i>The system will check if all required(mandatory fields) are filled and are correct and show you a preview</li>
                                    <li><i class="fa fa-check"></i>Correct records have green colors and incorrect have red colors. Preview row numbers correspond to the excel uploaded rows to make it easier for you to fix errors in your entries</li>
                                    <li><i class="fa fa-check"></i>When all rows are correct, you have a little screen below to input your chapter name, area, etc.</li>
                                    <li><i class="fa fa-check"></i>Click on Register Batch and 'Holla!', you're done</li>
                                </ul></p>

                                <p class="text text-danger">Note: please do not change header names in the excel sheet!</p>

                                <a href="{{ url('/downloadfiles/upload_format.xlsx') }}" class="btn btn-label-blue btn-flat"><i class="fa fa-file-excel-o" style="margin-right:10px" aria-hidden="true"></i> Download Excel</a>
                            </form>

                            <form  action="{{ URL::to('doimporttokens') }}" class="form-horizontal" method="post" enctype="multipart/form-data" style="margin-top: 20px">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="type" value="1">
                                <div class="form-group">
                                    <div class="col-md-8" style="margin-top:10px">
                                        <input type="file" required name="import_file" class="form-control text-color file-input">
                                    </div>
                                    <div class="col-md-2" style="margin-top:10px">
                                        <button class="btn btn-default btn-flat"><i class="fa fa-cloud-upload" style="margin-right:10px" aria-hidden="true"></i> Upload Batch</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


            @if(isset($batches))
                <div class="row text-color" style="margin-top: 0px">
                    <div class="col-md-10 col-md-offset-1">
                        <div class="box box-solid" style="border-radius: 0px">
                            <div class="box-body">
                                <div style="margin:20px;">Preview Upload:<br/>
                                    <span style="font-weight: bold;color:green;font-size: small">Validity of file upload will be shown in a message box below your preview</span>
                                </div>
                                <table id="example" cellspacing="0" cellpadding="0" class="table table-responsive" border="1">
                                    <thead>
                                    <tr>
                                        <th>Excel Row</th>
                                        <th>Surname</th>
                                        <th>Othername(s)</th>
                                        <th>DOB</th>
                                        <th>Telephone</th>
                                        <th>Camper Type</th>
                                        {{--<th>Profession</th>--}}
                                        <th>Applicable Camp Fee</th>
                                        <th>AGD Language</th>
                                        <th>Error/Success</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <div style="display:none">{{$error_count =0}}</div>
                                    @foreach($batches as $key =>$registrant)
                                        @if($registrant['surname'] == "" || $registrant['firstname']=="" || $registrant['gender_id']=="" || $registrant['dob']=="" || $registrant['maritalstatus_id']=="" || $registrant['nationality']=="" || $registrant['campercat_id']=="" || $registrant['campfee_id']=="" )
                                            <tr style="color:red;margin:2px;padding:2px">
                                                <td>{{$key+2}}</td>
                                                <td>{{$registrant['surname']}}</td><td>{{$registrant['firstname']}}</td>
                                                {{--<td>{{$registrant['dob']->toDateString()}}</td>--}}
                                                <td>@if(isset($registrant['dob']) && !empty($registrant['dob'])){{$registrant['dob']->format('d-M-Y')}}@else{{\Carbon\Carbon::now()->subYears(18)->format('d-M-Y')}}@endif</td>
                                                {{--                                                <td>{{$registrant['dob']->format('d-M-Y')}}</td>--}}
                                                <td>{{$registrant['telephone']}}</td>
                                                <td>{{$registrant['campercat_id']}}</td><td>{{$registrant['campfee_id']}}</td>
                                                <td>{{$registrant['agdlang_id']}}</td><td><i class="fa fa-times"></i></td>
                                                <div style="display:none">{{$error_count ++}}</div>
                                        @else
                                            <tr style="color:green;font-size: x-small;">
                                                <td>{{$key+2}}</td>
                                                <td>{{$registrant['surname']}}</td><td>{{$registrant['firstname']}}</td>
                                                {{--<td>{{$registrant['dob']}}</td>--}}
                                                {{--                                                <td>@if(isset($registrant['dob']) && !nullOrEmptyString($registrant['dob'])){{$registrant['dob']->toDateString()}}@else{{\Carbon\Carbon::now()->subYears(18)->format('d-m-Y')}}@endif</td>--}}
                                                {{--<td>{{$registrant['dob']->format('d-M-Y')}}</td>--}}
                                                <td>@if(isset($registrant['dob']) && !empty($registrant['dob'])){{$registrant['dob']->format('d-M-Y')}}@else{{\Carbon\Carbon::now()->subYears(18)->format('d-M-Y')}}@endif</td>
                                                <td>{{$registrant['telephone']}}</td>
                                                <td>{{$registrant['campercat_id']}}</td><td>{{$registrant['campfee_id']}}</td>
                                                <td>{{$registrant['agdlang_id']}}</td><td><i class="fa fa-check"></i></td>
                                            </tr>
                                        @endif
                                    @endforeach
                                    </tbody>
                                </table>

                                @if($error_count>0)
                                    <p class="error text-danger" style="margin-top:15px">You have {{$error_count}} error(s) in your upload. Such rows are in red</p>
                                    <p class="error text-danger">Names, gender, Date of Birth,marital staus,nationality, camper type, applicable fee, AGD Language are all required! <br/>
                                        Check them out in your excel and upload.</p>
                                    <center><a class="btn btn-label-blue btn-flat" disabled><i class="fa fa-pencil" style="margin-right:10px" aria-hidden="true"></i> Register Batch</a></center>
                                @else
                                    <form  action="{{ URL::to('batchregister') }}" class="form-horizontal" method="post">
                                        {{ csrf_field() }}
                                        <div class="row" style="color:red;margin:10px;">
                                            All fields are required!
                                        </div>
                                        <div class="row row-fit"><div class="form-group">
                                                <div class="col-md-6 {{ $errors->has('chapter') ? ' has-error' : '' }}" style="margin-top:10px">
                                                    {!! Form::label('chapter','Chapter:',['class'=>'form-label']) !!}
                                                    {!! Form::text('chapter',null,['class'=>'form-control','required']) !!}
                                                </div>
                                                <div class="col-md-6 {{ $errors->has('denomination') ? ' has-error' : '' }}" style="margin-top:9px">
                                                    {!! Form::label('denomination','Denomination:',['class'=>'form-label']) !!}
                                                    <label style="margin-left: 10px; margin-right: 5px;">
                                                        <input type="radio"  value="The Apostolic Church-Ghana"class="flat-red" name="denomination" required> The Apostolic Church-Ghana
                                                    </label>
                                                    <label style="margin-top: 0px; margin-right: 5px;">
                                                        <input type="radio" class="flat-red" value="2" name="denomination" required> Other
                                                    </label><input type="text" name="otherdenomination" class="form-control" style="float:right"/>
                                                </div>
                                            </div></div>
                                        <div class="form-group">
                                            <div class="col-md-6 {{ $errors->has('area') ? ' has-error' : '' }}" style="margin-top:10px">
                                                {!! Form::label('area','Area:',['class'=>'form-label']) !!}
                                                {{--{!! Form::text('area',null,['class'=>'form-control']) !!}--}}
                                                {!! Form::select('area',$area->prepend('Choose...',''),null,['class'=>'form-control','required']) !!}
                                            </div>
                                            <div class="col-md-6 {{ $errors->has('region') ? ' has-error' : '' }}" style="margin-top:10px">
                                                {!! Form::label('region','Region:',['class'=>'form-label']) !!}
                                                {!! Form::select('region',$region->prepend('Choose...',''),null,['class'=>'form-control','required']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-6 {{ $errors->has('ambassadorname') ? ' has-error' : '' }}" style="margin-top:10px">
                                                {!! Form::label('ambassadorname','Name of Ambassador/Leader:',['class'=>'form-label']) !!}
                                                {!! Form::text('ambassadorname',null,['class'=>'form-control','required']) !!}
                                            </div>
                                            <div class="col-md-6 {{ $errors->has('ambassadorphone') ? ' has-error' : '' }}" style="margin-top:10px">
                                                {!! Form::label('ambassadorphone','Contact of Ambassador/Leader:',['class'=>'form-label']) !!}
                                                {!! Form::text('ambassadorphone',null,['class'=>'form-control','id'=>'ambassadorphone','required']) !!}
                                            </div>
                                        </div>
                                        {{--<div class="form-group">--}}
                                        {{--<div class="col-md-6" style="margin-top:10px">--}}
                                        {{--<label><input type="checkbox" name="foreigndelegate"/>Any Foreign delegate?</label>--}}
                                        {{--</div>--}}
                                        {{--<div class="col-md-6" style="margin-top:10px">--}}
                                        {{--<label><input type="checkbox" name="specialneeds"/>Anybody with special needs?</label>--}}
                                        {{--</div>--}}
                                        {{--</div>--}}
                                        <center>
                                            <button class="btn btn-flat btn-label-blue" style="margin-top:15px"> Register Batch</button>
                                            <a href="{{url()->previous()}}" class="btn btn-flat btn-default">
                                                <i class="fa fa-angle-left" aria-hidden="true" style="margin-right:5px"></i> Back
                                            </a>
                                        </center>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

@endsection
@section('footerscripts')
    <script src="{{ asset('plugins/icheck/icheck.min.js') }}"></script>
    <script>
        $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
            checkboxClass: 'icheckbox_minimal-blue',
            radioClass   : 'iradio_minimal-blue'
        })
        //Red color scheme for iCheck
        $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
            checkboxClass: 'icheckbox_minimal-red',
            radioClass   : 'iradio_minimal-red'
        })
        //Flat red color scheme for iCheck
        $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
            checkboxClass: 'icheckbox_flat-green',
            radioClass   : 'iradio_flat-green'
        });

        $("#ambassadorphone").keypress(function (event) { return isNumberKey(event) });
        //     $("#ambassadorphone").keypress(function (event) { return isNumberKey(event) });
        //function to check if value entered is numeric
        function isNumberKey(evt) { var charCode = (evt.which) ? evt.which : event.keyCode; if (charCode > 31 && (charCode < 48 || charCode > 57)) { return false; } return true; }
        //     function isNumber(evt) { var charCode = (evt.which) ? evt.which : event.keyCode; if (charCode != 45 && (charCode != 46 || $(this).val().indexOf('.') != -1) && (charCode < 48 || charCode > 57)) return false; return true; }
    </script>
@endsection