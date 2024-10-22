@extends('layouts.app')
@section('beforecss')
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <link rel="stylesheet" href="{{asset('css/jquery-ui.min.css')}}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{asset('css/jquery.dataTables.min.css')}}">
    <style>
        .modal-backdrop
        {
            opacity:0.2 !important;
        }
        .hideCol{
            display:none;
        }
    </style>
@endsection

@section('content')
    <section style="margin-top: 50px;">
        <div class="container">
            <div style="text-align: center; margin-bottom: 30px">
                <img src="{{asset('img/aposa-main_edit.png')}}" style="text-align: center;max-width:200px;"/>
                <p style="text-align:right">
                    <a href="{{route('registrant.camper_logout')}}" class="btn btn-flat btn-default">
                        Log out
                    </a>
                </p>
            </div>
            <div style="margin: 2.5rem 0;">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-box box">
                            <h3 style="text-align: center">Welcome back <span style="color:green">{{$chapter_details->chapter}} Chapter</span></h3>
                            <h4 style="text-align: center">Available Chapter Members</h4>
                            {{--<p>In here, you'll download two files,--}}
                                {{--<span>Write up to be added soon </span>--}}
                                {{--<form class="form-horizontal white" method="POST" action="{{ route('bacthregistration.downloadExcel') }}">--}}
                                    {{--{{ csrf_field() }}--}}
                                {{--<input type="hidden" value="{{$chapter_details->chapter}}" name="hidChapter">--}}
                                {{--<input type="hidden" value="{{$chapter_details->batch_no}}" name="hidBatch">--}}
                                {{--<a href="{{ url('/downloadfiles/camp_list_upload_file.xlsm') }}" class="btn btn-label-blue btn-flat"><i class="fa fa-file-excel-o" style="margin-right:10px" aria-hidden="true"></i> Download Upload File</a>--}}
                                {{--<button class="btn btn-label-blue btn-flat"><i class="fa fa-file-excel-o" style="margin-right:10px" aria-hidden="true;float:right;right:5px;"></i> Download Members</button>--}}
                                {{--</form>--}}
                                {{--</p>--}}
                            <hr>

                            <div class="panel-body">
                                @if($registrants)
                                    <div class="table-responsive">
                                        <div style="float:right;right:20px;margin-bottom: 20px;"><a href="#" class="btn btn-primary" id="addcamper">Add Camper</a></div>
                                        <table id="dtrows" class="table table-striped">
                                            <thead>
                                            <tr>
                                                <th>Firstname</th>
                                                <th>Lastname</th>
                                                <th>DOB</th>
                                                <th>Gender</th>
                                                <th>Camper Category</th>
                                                <th>Applicable fee</th>
                                                <th>Special Accom.</th>
                                                <th>AGD</th>
                                                <th>Action</th>
                                                <th class="hideCol">Data</th>

                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($registrants as $registrant)
                                                <tr>
                                                    <td>{{$registrant->firstname}}</td>
                                                    <td>{{strtoupper($registrant->surname)}}</td>
                                                    <td>{{$registrant->olddob}}</td>
                                                    <td>{{$registrant->gender}}</td>
                                                    <td>{{$registrant->camper}}</td>
                                                    <td>{{$registrant->Applicable_Camp_Fee}}</td>
                                                    <td>{{$registrant->Type_of_Special_Accomodation}}</td>
                                                    <td>{{$registrant->AGD_Language}}</td>
                                                    <td>
                                                        <a href="#" class="btn-warning btn-sm form-edit"  style="padding:5px;width:auto;">Edit</a>
                                                        {{--<a href="{{ route('batchregistration.chaptermemberedit', ['uid'=>$registrant->id]) }}" class="btn-danger row-delete" style="padding:3px;width:auto;margin:0" onclick="return confirm('Are you sure you want to Delete from list?')">Delete</a>--}}
                                                        <a href="#" class="btn-danger row-delete" style="padding:3px;width:auto;margin:0" >Delete</a>
                                                    </td>
                                                    <td class="hideCol">{{$registrant->marital_status.'|'.$registrant->nationality
                                                        .'|'.$registrant->local_assembly.'|'.$registrant->area.'|'.$registrant->permanent_address.'|'.$registrant->telephone
                                                        .'|'.$registrant->email.'|'.$registrant->officechurch.'|'.$registrant->profession.'|'.$registrant->business_address
                                                        .'|'.$registrant->business_address.'|'.$registrant->agd_leader.'|'.$registrant->id.'|'.$registrant->batch_no}}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>

                                    </div>
                                @endif
                            </div>
                            <div>
                                {{--<form  action="{{ URL::to('importExcel') }}" class="form-horizontal" method="post" style="margin-top: 20px">--}}
                                {{--<input type="hidden" name="_token" value="{{ csrf_token() }}">--}}
                                {{--<input type="hidden" name="type" value="2">--}}
                                {{--<input type="hidden" value="{{$chapter_details->chapter}}" name="hidChapter">--}}
                                {{--<input type="hidden" value="{{$chapter_details->batch_no}}" name="hidBatch">--}}
                                {{--<div class="form-group">--}}
                                {{--<div class="col-md-8" style="margin-top:10px">--}}
                                {{--<input type="file" required name="import_file" class="form-control text-color file-input">--}}
                                {{--</div>--}}
                                {{--<div class="col-md-2" style="margin-top:10px">--}}
                                {{--<button class="btn btn-default btn-flat"><i class="fa fa-cloud-upload" style="margin-right:10px" aria-hidden="true"></i> Upload Batch</button>--}}
                                {{--</div>--}}
                                {{--</div>--}}
                                {{--</form>--}}
                                <form  action="{{ URL::to('batchregisternew') }}" class="form-horizontal" method="post">
                                {{ csrf_field() }}
                                <div class="row" style="color:red;margin:10px;">
                                All fields are required!
                                </div>
                                <div class="form-group">
                                        <input type="hidden" value="{{$chapter_details->chapter}}" name="hidChapter">
                                        <input type="hidden" value="{{$chapter_details->batch_no}}" name="hidBatch">
                                <div class="col-md-6 {{ $errors->has('chapter') ? ' has-error' : '' }}" style="margin-top:10px">
                                {!! Form::label('chapter','Chapter:',['class'=>'form-label']) !!}
                                {!! Form::text('chapter',$chapter_details->chapter,['class'=>'form-control','required']) !!}
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
                                </div>
                                <div class="form-group">

                                    <div class="col-md-6 {{ $errors->has('region') ? ' has-error' : '' }}" style="margin-top:10px">
                                        {!! Form::label('region','Region:',['class'=>'form-label']) !!}
                                        {!! Form::select('region',$region->prepend('Choose...',''),$chapter_details->region,['class'=>'form-control','required']) !!}
                                    </div>

                                <div class="col-md-6 {{ $errors->has('area') ? ' has-error' : '' }}" style="margin-top:10px">
                                {!! Form::label('area','Area:',['class'=>'form-label']) !!}
                                {!! Form::select('area',$area->prepend('Choose...',''),null,['class'=>'form-control','required']) !!}
                                </div>

                                </div>
                                <div class="form-group">
                                <div class="col-md-6 {{ $errors->has('ambassadorname') ? ' has-error' : '' }}" style="margin-top:10px">
                                {!! Form::label('ambassadorname','Name of Ambassador/Leader:',['class'=>'form-label']) !!}
                                {!! Form::text('ambassadorname',$chapter_details->ambassadorname,['class'=>'form-control','required']) !!}
                                </div>
                                <div class="col-md-6 {{ $errors->has('ambassadorphone') ? ' has-error' : '' }}" style="margin-top:10px">
                                {!! Form::label('ambassadorphone','Contact of Ambassador/Leader:',['class'=>'form-label']) !!}
                                {!! Form::text('ambassadorphone',$chapter_details->ambassadorphone,['class'=>'form-control','id'=>'ambassadorphone','required']) !!}
                                </div>
                                <input type="hidden" name="hidBatchNo" value="{{$chapter_details->batch_no}}"/>
                                </div>
                                <center>
                                <button class="btn btn-flat btn-label-blue" style="margin-top:15px"> Register Batch</button>
                                <a href="{{url()->previous()}}" class="btn btn-flat btn-default">
                                <i class="fa fa-angle-left" aria-hidden="true" style="margin-right:5px"></i> Back
                                </a>
                                </center>
                                </form>
                                {{--<form  action="{{ URL::to('importExcel') }}" class="form-horizontal" method="post" enctype="multipart/form-data" style="margin-top: 20px">--}}
                                    {{--<input type="hidden" name="_token" value="{{ csrf_token() }}">--}}
                                    {{--<input type="hidden" name="type" value="2">--}}
                                    {{--<input type="hidden" value="{{$chapter_details->chapter}}" name="hidChapter">--}}
                                    {{--<input type="hidden" value="{{$chapter_details->batch_no}}" name="hidBatch">--}}
                                    {{--<div class="form-group">--}}
                                        {{--<div class="col-md-8" style="margin-top:10px">--}}
                                            {{--<input type="file" required name="import_file" class="form-control text-color file-input">--}}
                                        {{--</div>--}}
                                        {{--<div class="col-md-2" style="margin-top:10px">--}}
                                            {{--<button class="btn btn-default btn-flat"><i class="fa fa-cloud-upload" style="margin-right:10px" aria-hidden="true"></i> Upload Batch</button>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</form>--}}
                            </div>
                        </div>
                    </div>
                </div>
                {{--//Uploaded campers details--}}
                {{--@if(isset($batches))--}}
                {{--<div class="row">--}}
                    {{--<div class="col-md-12">--}}
                        {{--<div class="form-box box">--}}
                            {{--<div style="margin:20px;">Preview Upload:<br/>--}}
                                {{--<span style="font-weight: bold;color:green;font-size: small">Validity of file upload will be shown in a message box below your preview</span>--}}
                            {{--</div>--}}
                            {{--<hr>--}}

                            {{--<div class="panel-body">--}}
                                {{--<table id="example" cellspacing="0" cellpadding="0" class="table table-responsive" border="1">--}}
                                    {{--<thead>--}}
                                    {{--<tr>--}}
                                        {{--<th>Excel Row</th>--}}
                                        {{--<th>Surname</th>--}}
                                        {{--<th>Othername(s)</th>--}}
                                        {{--<th>DOB</th>--}}
                                        {{--<th>Telephone</th>--}}
                                        {{--<th>Camper Type</th>--}}
                                        {{--<th>Applicable Camp Fee</th>--}}
                                        {{--<th>AGD Language</th>--}}
                                        {{--<th>Error/Success</th>--}}
                                    {{--</tr>--}}
                                    {{--</thead>--}}
                                    {{--<tbody>--}}
                                    {{--<div style="display:none">{{$error_count =0}}</div>--}}
                                    {{--@foreach($batches as $key =>$registrant)--}}
                                        {{--@if($registrant['surname'] == "" || $registrant['firstname']=="" || $registrant['gender_id']=="" || $registrant['dob']=="" || $registrant['maritalstatus_id']=="" || $registrant['nationality']=="" || $registrant['campercat_id']=="" || $registrant['campfee_id']=="" )--}}
                                            {{--<tr style="color:red;margin:2px;padding:2px">--}}
                                                {{--<td>{{$key+2}}</td>--}}
                                                {{--<td>{{$registrant['surname']}}</td><td>{{$registrant['firstname']}}</td>--}}
                                                {{--<td>{{$registrant['dob']->toDateString()}}</td>--}}
                                                {{--<td>@if(isset($registrant['dob']) && !empty($registrant['dob'])){{$registrant['dob']->format('d-M-Y')}}@else{{\Carbon\Carbon::now()->subYears(18)->format('d-M-Y')}}@endif</td>--}}
                                                {{--                                                <td>{{$registrant['dob']->format('d-M-Y')}}</td>--}}
                                                {{--<td>{{$registrant['telephone']}}</td>--}}
                                                {{--<td>{{$registrant['campercat_id']}}</td><td>{{$registrant['campfee_id']}}</td>--}}
                                                {{--<td>{{$registrant['agdlang_id']}}</td><td><i class="fa fa-times"></i></td>--}}
                                                {{--<div style="display:none">{{$error_count ++}}</div>--}}
                                        {{--@else--}}
                                            {{--<tr style="color:green;font-size: x-small;">--}}
                                                {{--<td>{{$key+2}}</td>--}}
                                                {{--<td>{{$registrant['surname']}}</td><td>{{$registrant['firstname']}}</td>--}}
                                                {{--<td>@if(isset($registrant['dob']) && !empty($registrant['dob'])){{$registrant['dob']->format('d-M-Y')}}@else{{\Carbon\Carbon::now()->subYears(18)->format('d-M-Y')}}@endif</td>--}}
                                                {{--<td>{{$registrant['telephone']}}</td>--}}
                                                {{--<td>{{$registrant['campercat_id']}}</td><td>{{$registrant['campfee_id']}}</td>--}}
                                                {{--<td>{{$registrant['agdlang_id']}}</td><td><i class="fa fa-check"></i></td>--}}
                                            {{--</tr>--}}
                                        {{--@endif--}}
                                    {{--@endforeach--}}
                                    {{--</tbody>--}}
                                {{--</table>--}}

                                {{--@if($error_count>0)--}}
                                    {{--<p class="error text-danger" style="margin-top:15px">You have {{$error_count}} error(s) in your upload. Such rows are in red</p>--}}
                                    {{--<p class="error text-danger">Names, gender, Date of Birth,marital staus,nationality, camper type, applicable fee, AGD Language are all required! <br/>--}}
                                        {{--Check them out in your excel and upload.</p>--}}
                                    {{--<center><a class="btn btn-label-blue btn-flat" disabled><i class="fa fa-pencil" style="margin-right:10px" aria-hidden="true"></i> Register Batch</a></center>--}}
                                {{--@else--}}
                                    {{--<form  action="{{ URL::to('batchregister') }}" class="form-horizontal" method="post">--}}
                                        {{--{{ csrf_field() }}--}}
                                        {{--<div class="row" style="color:red;margin:10px;">--}}
                                            {{--All fields are required!--}}
                                        {{--</div>--}}
                                        {{--<div class="row row-fit"><div class="form-group">--}}
                                                {{--<div class="col-md-6 {{ $errors->has('chapter') ? ' has-error' : '' }}" style="margin-top:10px">--}}
                                                    {{--{!! Form::label('chapter','Chapter:',['class'=>'form-label']) !!}--}}
                                                    {{--{!! Form::text('chapter',$chapter_details->chapter,['class'=>'form-control','required']) !!}--}}
                                                {{--</div>--}}
                                                {{--<div class="col-md-6 {{ $errors->has('denomination') ? ' has-error' : '' }}" style="margin-top:9px">--}}
                                                    {{--{!! Form::label('denomination','Denomination:',['class'=>'form-label']) !!}--}}
                                                    {{--<label style="margin-left: 10px; margin-right: 5px;">--}}
                                                        {{--<input type="radio"  value="The Apostolic Church-Ghana"class="flat-red" name="denomination" required> The Apostolic Church-Ghana--}}
                                                    {{--</label>--}}
                                                    {{--<label style="margin-top: 0px; margin-right: 5px;">--}}
                                                        {{--<input type="radio" class="flat-red" value="2" name="denomination" required> Other--}}
                                                    {{--</label><input type="text" name="otherdenomination" class="form-control" style="float:right"/>--}}
                                                {{--</div>--}}
                                            {{--</div></div>--}}
                                        {{--<div class="form-group">--}}
                                            {{--<div class="col-md-6 {{ $errors->has('area') ? ' has-error' : '' }}" style="margin-top:10px">--}}
                                                {{--{!! Form::label('area','Area:',['class'=>'form-label']) !!}--}}
                                                {{--{!! Form::text('area',null,['class'=>'form-control']) !!}--}}
                                                {{--{!! Form::select('area',$area->prepend('Choose...',''),null,['class'=>'form-control','required']) !!}--}}
                                            {{--</div>--}}
                                            {{--<div class="col-md-6 {{ $errors->has('region') ? ' has-error' : '' }}" style="margin-top:10px">--}}
                                                {{--{!! Form::label('region','Region:',['class'=>'form-label']) !!}--}}
                                                {{--{!! Form::select('region',$region->prepend('Choose...',''),$chapter_details->region,['class'=>'form-control','required']) !!}--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                        {{--<div class="form-group">--}}
                                            {{--<div class="col-md-6 {{ $errors->has('ambassadorname') ? ' has-error' : '' }}" style="margin-top:10px">--}}
                                                {{--{!! Form::label('ambassadorname','Name of Ambassador/Leader:',['class'=>'form-label']) !!}--}}
                                                {{--{!! Form::text('ambassadorname',$chapter_details->ambassadorname,['class'=>'form-control','required']) !!}--}}
                                            {{--</div>--}}
                                            {{--<div class="col-md-6 {{ $errors->has('ambassadorphone') ? ' has-error' : '' }}" style="margin-top:10px">--}}
                                                {{--{!! Form::label('ambassadorphone','Contact of Ambassador/Leader:',['class'=>'form-label']) !!}--}}
                                                {{--{!! Form::text('ambassadorphone',$chapter_details->ambassadorphone,['class'=>'form-control','id'=>'ambassadorphone','required']) !!}--}}
                                            {{--</div>--}}
                                            {{--<input type="hidden" name="hidBatchNo" value="{{$chapter_details->batch_no}}"/>--}}
                                        {{--</div>--}}
                                        {{--<center>--}}
                                            {{--<button class="btn btn-flat btn-label-blue" style="margin-top:15px"> Register Batch</button>--}}
                                            {{--<a href="{{url()->previous()}}" class="btn btn-flat btn-default">--}}
                                                {{--<i class="fa fa-angle-left" aria-hidden="true" style="margin-right:5px"></i> Back--}}
                                            {{--</a>--}}
                                        {{--</center>--}}
                                    {{--</form>--}}
                                {{--@endif--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
{{--@endif--}}
            <!-- Modal -->
                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    {!! Form::open(['class'=>'form-horizontal popup','id'=>'camper-form']) !!}{{ csrf_field() }}
{{--                    {!! Form::open(['method'=>'post','route'=>['batchregistration.chaptermemberedit',-113],'class'=>'form-horizontal popup','id'=>'camper-form']) !!}{{ csrf_field() }}--}}
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header" style="background-color:#007bb6;color:white">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Title</h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <input type="hidden" id="entrytype" name="entrytype"/>
                                            <input type="hidden" id="camperid" name="camperid"/>
                                            <input type="hidden" id="batch_no" name="batch_no" value="{{$chapter_details->batch_no}}"/>
                                            <div class="col-md-6 {{ $errors->has('surname') ? ' has-error' : '' }}" style="margin-top:10px">
                                                {!! Form::label('surname','Surname:',['class'=>'form-label required']) !!}
                                                {!! Form::text('surname',null,['class'=>'form-control','id'=>'surname']) !!}
                                            </div>
                                            <div class="col-md-6 {{ $errors->has('firstname') ? ' has-error' : '' }}" style="margin-top:10px">
                                                {!! Form::label('firstname','Other names:',['class'=>'form-label required']) !!}
                                                {!! Form::text('firstname',null,['class'=>'form-control','id'=>'firstname']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-6 {{ $errors->has('gender') ? ' has-error' : '' }}" style="margin-top:10px">
                                                {!! Form::label('gender','Gender:',['class'=>'form-label required']) !!}
                                                {!! Form::select('gender',$gender->prepend('Choose...',''),"",['class'=>'form-control','id'=>'gender']) !!}
                                            </div>
                                            <div class="col-md-6 {{ $errors->has('dob') ? ' has-error' : '' }}" style="margin-top:10px">
                                                {!! Form::label('dob','Date of Birth:',['class'=>'form-label required']) !!}
                                                {!! Form::text('dob',null,['class'=>'form-control','id'=>'datepicker','autocomplete'=>'off']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                                <div class="col-md-6 {{ $errors->has('nationality') ? ' has-error' : '' }}" style="margin-top:9px">
                                                    {!! Form::label('nationality','Nationality:',['class'=>'form-label required']) !!}
                                                    <label style="margin-left: 10px; margin-right: 5px;">
                                                        <input type="radio" value="Ghanaian" id="ghana" class="flat-red" name="nationality" {{ (old('nationality') == 'Ghanaian') ? 'checked' : '' }}> Ghanaian
                                                    </label>
                                                    <label style="margin-top: 0px; margin-right: 5px;">
                                                        <input type="radio" class="flat-red" id="others" value="2" name="nationality" {{ (old('nationality') == '2') ? 'checked' : '' }}> Other
                                                    </label><input type="text" id="othernationality" name="othernationality" class="form-control" style="float:right" {{ (old('othernationality')) }}/>

                                                </div>
                                            <div class="col-md-6 {{ $errors->has('maritalstatus') ? ' has-error' : '' }}" style="margin-top:10px">
                                                {!! Form::label('maritalstatus','Marital Status:',['class'=>'form-label required']) !!}
                                                {!! Form::select('maritalstatus',$maritalstatus->prepend('Choose...',''),null,['class'=>'form-control','id'=>'maritalstatus']) !!}
                                            </div>
                                            </div>
                                        <div class="form-group">
                                                <div class="col-md-6 {{ $errors->has('localassembly') ? ' has-error' : '' }}" style="margin-top:10px">
                                                    {!! Form::label('localassembly','Local Assembly:',['class'=>'form-label required']) !!}
                                                    {!! Form::text('localassembly',null,['class'=>'form-control','id'=>'localassembly']) !!}
                                                </div>
                                                <div class="col-md-6 {{ $errors->has('denomination') ? ' has-error' : '' }}" style="margin-top:9px">
                                                    {!! Form::label('denomination','Denomination:',['class'=>'form-label required']) !!}
                                                    <label style="margin-left: 10px; margin-right: 5px;">
                                                        <input type="radio" value="The Apostolic Church-Ghana" class="flat-red" name="denomination" {{ (old('denomination') == 'The Apostolic Church-Ghana') ? 'checked' : '' }}> The Apostolic Church-Ghana
                                                    </label>
                                                    <label style="margin-top: 0px; margin-right: 5px;">
                                                        <input type="radio" class="flat-red" value="2" name="denomination" {{ (old('denomination') == '2') ? 'checked' : '' }}> Other
                                                    </label><input type="text" name="otherdenomination" class="form-control" style="float:right" value="{{ (old('otherdenomination'))}}"/>
                                                </div>
                                        </div>
                                        <div class="form-group">
                                                <div class="col-md-6 {{ $errors->has('permaddress') ? ' has-error' : '' }}" style="margin-top:10px">
                                                    {!! Form::label('permaddress','Permanent Address:',['class'=>'form-label']) !!}
                                                    {!! Form::textarea('permaddress',null,['class'=>'form-control','rows'=>3,'cols'=>10,'id'=>'permaddress']) !!}
                                                </div>
                                                <div class="col-md-6 {{ $errors->has('telephone') ? ' has-error' : '' }}" style="margin-top:10px">
                                                    {!! Form::label('telephone','Mobile Number:',['class'=>'form-label required']) !!}
                                                    {!! Form::text('telephone',null,['class'=>'form-control','id'=>'telephone']) !!}
                                                </div>
                                            </div>
                                        <div class="form-group">
                                            <div class="col-md-6 {{ $errors->has('email') ? ' has-error' : '' }}" style="margin-top:10px">
                                                {!! Form::label('email','Email Address:',['class'=>'form-label']) !!}
                                                {!! Form::text('email',null,['class'=>'form-control']) !!}
                                            </div>
                                            <div class="col-md-6 {{ $errors->has('officeaposa') ? ' has-error' : '' }}" style="margin-top:10px">
                                                {!! Form::label('officeaposa','Office Held at APOSA (if any):',['class'=>'form-label']) !!}
                                                {!! Form::text('officeaposa',null,['class'=>'form-control']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-6 {{ $errors->has('officechurch') ? ' has-error' : '' }}" style="margin-top:10px">
                                                {!! Form::label('officechurch','Office Held in Church:',['class'=>'form-label required']) !!}
                                                {!! Form::select('officechurch',$OfficeHeldInChurch->prepend('Choose...',''),null,['class'=>'form-control select2 padded','id'=>'officechurch']) !!}
                                            </div>
                                            <div class="col-md-6 {{ $errors->has('profession') ? ' has-error' : '' }}" style="margin-top:10px">
                                                {!! Form::label('profession','Profession:',['class'=>'form-label']) !!}
                                                {!! Form::text('profession',null,['class'=>'form-control','id'=>'profession','id'=>'profession']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                                <div class="col-md-6 {{ $errors->has('businessadress') ? ' has-error' : '' }}" style="margin-top:10px">
                                                    {!! Form::label('businessaddress','Business Address:',['class'=>'form-label']) !!}
                                                    {!! Form::textarea('businessaddress',null,['class'=>'form-control','rows'=>3,'cols'=>10,'id'=>'businessaddress']) !!}
                                                </div>
                                            </div>
                                        <div class="form-group">
                                            <div class="col-md-6 {{ $errors->has('campercat') ? ' has-error' : '' }}" style="margin-top:10px">
                                                {!! Form::label('campercat','Camper:',['class'=>'form-label required']) !!}
                                                {!! Form::select('campercat',$Camper->prepend('Choose...',''),null,['class'=>'form-control','id'=>'campercat']) !!}
                                            </div>
                                            <div class="col-md-6 {{ $errors->has('agdlang') ? ' has-error' : '' }}" style="margin-top:10px">
                                                {!! Form::label('agdlang','Action Group Discussion (Preferred Language):',['class'=>'form-label required']) !!}
                                                {!! Form::select('agdlang',$AGDLanguage->prepend('Choose...',''),null,['class'=>'form-control','id'=>'agdlang']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-6 {{ $errors->has('agdleader') ? ' has-error' : '' }}" style="margin-top:10px">
                                                {!! Form::label('agdleader','Are you an AGD Leader?:',['class'=>'form-label']) !!}
                                                {!! Form::select('agdleader',$yesno->prepend('Choose...',''),null,['class'=>'form-control','id'=>'agdleader']) !!}
                                            </div>
                                            <div class="col-md-6 {{ $errors->has('campfee') ? ' has-error' : '' }}" style="margin-top:10px">
                                                {!! Form::label('campfee','Select Applicable Camp Fee:',['class'=>'form-label required']) !!}
                                                {!! Form::select('campfee',$CampApplicableFee->prepend('Choose...',''),null,['class'=>'form-control','id'=>'campfee']) !!}
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-md-6 {{ $errors->has('specialaccom') ? ' has-error' : '' }}" style="margin-top:10px">
                                                {!! Form::label('specialaccom','Select the type of Special Accommodation:',['class'=>'form-label']) !!}
                                                {!! Form::select('specialaccom',$SpecialAccomodation->prepend('Choose...',''),null,['class'=>'form-control','id'=>'speAcc','disabled'=>'disabled']) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                            <button type="submit" id="btn-save" class="btn btn-primary">Save Changes</button>
                            </div>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </section>
@endsection
@section('footerscripts')
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{asset('js/jquery-ui.min.js')}}"></script>
    <script src="{{asset('js/jquery.dataTables.min.js')}}"></script>
    <script>
        $(document).ready(function() {
            var selectedrow;
            var selectedrowactual;
            var table = $('#dtrows').DataTable({
                "columnDefs": [
                    { className: "hideCol", "targets": [ 9 ] }
                ]
            });

            //Remove camper from table list
            $('#dtrows tbody').on('click','.row-delete',function(e){
                e.preventDefault();

                var confirmdelete = confirm('Are you sure you want to Delete from list?');
                if(confirmdelete){
                    var data = table.row( $(this).parents('tr') ).data();
                    var other_details =  data[9];
                    //Convert | delimeter separated string to array
                    var details_array = other_details.split('|');

                    $('#camperid').val(details_array[12]);
                    $('#batch_no').val(details_array[13]);

                    token = $("input[name='_token']").val(); // get csrf field.

                    var formData = {
                        _token: token,
                        camperid: $('#camperid').val(),
                        batch_no: $('#batch_no').val()}
//                alert(JSON.stringify(formData));
//                return;
                    $.ajax({
                        type: 'post',
                        url: "<?php echo url('chaptermemberdelete');?>",
                        data: formData,
                        dataType: 'json',
                        success: function (data) {
                            console.log(JSON.stringify(data));
                        },
                        error: function (data) {
                            console.log('Error:', JSON.stringify(data));
                        }
                    });

                    table.row( $(this).parents('tr') ).remove().draw();
                }
                else return;
            });

            //Update camper data in table list
            $('#dtrows tbody').on('click','.form-edit',function(e){
                //get selected row data
                selectedrow = table.row( $(this).parents('tr') ).data();
                selectedrowactual="";
                selectedrowactual = $(this).parents('tr');
                alert(selectedrowactual);

                   var other_details =  selectedrow[9];
                   //Convert | delimeter separated string to array
                var details_array = other_details.split('|');
                //Set other details in to inputs
                /*0=>marital_status  1=>nationality  2=>local_assembly   3=>area     4=>permanent_address 5=>telephone
                 6=>email 7=>officechurch  8=>profession  9=>business_address  11=>agdleader   12=>camper_id 13=>batch_no*/
//                alert(JSON.stringify(details_array));

                $('#surname').val(selectedrow[0]);
                $('#firstname').val(selectedrow[1]);
                $('#datepicker').val(selectedrow[2]);
                $('#localassembly').val(details_array[2]);
                $('#permaddress').val(details_array[4]);
                $('#telephone').val(details_array[5]);
                $('#email').val(details_array[6]);
                $('#businessaddress').val(details_array[9]);
                $('#profession').val(details_array[8]);
                $('#camperid').val(details_array[12]);
                $('#batch_no').val(details_array[13]);

                $('#gender option').filter(function() {return ($(this).text() == selectedrow[3]);}).prop('selected', true);
                $('#campercat option').filter(function() {return ($(this).text() == selectedrow[4]);}).prop('selected', true);
                $('#campfee option').filter(function() {return ($(this).text() == selectedrow[5]);}).prop('selected', true);
                $('#agdlang option').filter(function() {return ($(this).text() == selectedrow[6]);}).prop('selected', true);
                $('#maritalstatus option').filter(function() {return ($(this).text() == details_array[0]);}).prop('selected', true);
                $('#officechurch option').filter(function() {return ($(this).text() == details_array[7]);}).prop('selected', true);
                $('#agdleader option').filter(function() {return ($(this).text() == details_array[11]);}).prop('selected', true);
                $('#agdlang option').filter(function() {return ($(this).text() == selectedrow[7]);}).prop('selected', true);
                $('#myModalLabel').html('Edit: '+selectedrow[1]+' '+selectedrow[0]);

                $("input[name='entrytype']").val(2);
                $('#myModal').modal('show');
            });

            $('#addcamper').click(function () {
                $('#myModalLabel').html('Add New Camper');
                $("input[name='entrytype']").val(1);
                $('#myModal').modal('show');
            })

            //create new camper / update existing camper
            $("#btn-save").click(function (e) {
                formtype = $("input[name='entrytype']").val();
                token = $("input[name='_token']").val(); // get csrf field.
//                alert(token);
                e.preventDefault();
                var formData = {
                    _token: token,
                    entry_form: formtype,
                    camperid: $('#camperid').val(),
                    batch_no: $('#batch_no').val(),
                    surname: $('#surname').val(),
                    firstname: $('#firstname').val(),
                    gender_id: $('#gender').val(),
                    dob: $('#datepicker').val(),
                    maritalstatus_id: $('#maritalstatus').val(),
                    localassembly: $('#localassembly').val(),
                    telephone: $('#telephone').val(),
                    email: $('#email').val(),
                    officeaposa: $('#officeaposa').val(),
                    officechurch_id: $('#officechurch').val(),
                    profession: $('#profession').val(),
                    businessaddress: $('#businessaddress').val(),
                    campercat_id: $('#campercat').val(),
                    camperfee_id: $('#campfee').val(),
                    agdlang_id: $('#agdlang').val(),
                    agdleader_id: $('#agdleader').val(),

                }
//                console.log(JSON.stringify(formData));
                //used to determine the http verb to use [add=POST], [update=PUT]
//                var state = $('#btn-save').val();
                $.ajax({
                    type: 'post',
                    url: "<?php echo url('chaptermemberedit');?>",
                    data: formData,
                    dataType: 'json',
                    success: function (data) {
                        console.log("Returned data from server "+JSON.stringify(data));
//                      //Delete if the form is an update form
                        if(formtype == 2)
                        table.row(selectedrowactual).remove().draw();
                        var registrant = data['data'];
                        var rowNode = table
                            .row.add( [ registrant['firstname'], registrant['surname'], registrant['olddob'],registrant['gender'],registrant['camper'],registrant['Applicable_Camp_Fee'],
                                registrant['Type_of_Special_Accomodation'],registrant['AGD_Language'],
                                '<a href="#" class="btn-warning btn-sm form-edit" style="padding:5px;width:auto;">Edit</a><a href="#" class="btn-danger row-delete" style="padding:3px;width:auto;margin:0" >Delete</a>',
                                ''+registrant['marital_status']+'|'+registrant['nationality']+''
//                                    +'|'.$registrant->local_assembly.'|'.$registrant->area.'|'.$registrant->permanent_address.'|'.$registrant->telephone
//                                    +'|'.$registrant->email.'|'.$registrant->officechurch.'|'.$registrant->profession.'|'.$registrant->business_address
//                                    +'|'.$registrant->business_address.'|'.$registrant->agd_leader.'|'.$registrant->id.'|'.$registrant->batch_no' ' +
                                 ])
                            .draw()
                            .node();

                        $( rowNode )
                            .css( 'color', 'blue' );

                        $('#camper-form')[0].reset();
                        $('#myModal').modal('hide')
                    },
                    error: function (data) {
                        console.log('Error:', JSON.stringify(data));
                    }
                });
            });

            $(function() {
                $( "#datepicker" ).datepicker({changeMonth: true,changeYear: true,showButtonPanel: true,yearRange: "-70:-2 ",dateFormat: "yy-mm-dd"});
            });
            $("#telephone").keypress(function (event) { return isNumberKey(event) });

            //function to check if value entered is numeric
            function isNumberKey(evt) { var charCode = (evt.which) ? evt.which : event.keyCode; if (charCode > 31 && (charCode < 48 || charCode > 57)) { return false; } return true; }
            function isNumber(evt) { var charCode = (evt.which) ? evt.which : event.keyCode; if (charCode != 45 && (charCode != 46 || $(this).val().indexOf('.') != -1) && (charCode < 48 || charCode > 57)) return false; return true; }
            //        })
            $( function() {
                var profs = ({!! json_encode($profession) !!});
                $("#profession").autocomplete({
                    source: profs
                });
            });

            function showFee() {
                // var campfeeid = $('select#campfee').val();
                var campfeeid = document.getElementById('campfee').value;
                if(campfeeid != 43){
                    document.getElementById('speAcc').disabled = true;
                    document.getElementById('speAcc').value = null;
                }else{
                    document.getElementById('speAcc').disabled = false;
                }
            }
        });

    </script>

@endsection