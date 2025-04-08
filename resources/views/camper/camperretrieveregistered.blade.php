@extends('layouts.app')
@section('beforecss')
{{--    <link rel="stylesheet" href="{{ asset('css/AdminLTE.min.css') }}">--}}
<link rel="stylesheet" href="{{ asset('plugins/icheck/all.css') }}">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
{{--<link rel="stylesheet" href="{{asset('css/jquery-ui.min.css')}}">--}}
{{--<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">--}}
{{--<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" type="text/css"/>--}}
    <style>
        /*font Variables*/
        /*Color Variables*/
        @import url("https://fonts.googleapis.com/css?family=Roboto:300i,400,400i,500,700,900");
        .multi_step_form {
            background: #f6f9fb;
            display: block;
            overflow: hidden;
        }
        #msform .form-label{
            text-align: left;
        }
        label {
            font-weight: 500;
            margin-top: 15px;
        }
        fieldset{
            border: none;
        }
        fieldset h3{
            text-align: center;
        }
        .multi_step_form #msform {
            text-align: center;
            position: relative;
            /*padding-top: 50px;*/
            /*min-height: 820px;*/
            /*max-width: 810px;*/
            margin: 0 auto;
            /*background: #ffffff;*/
            z-index: 1;
            /*border:1px solid gold;*/
        }
        .multi_step_form #msform .tittle {
            /*text-align: center;*/
            padding-bottom: 10px;
            border:1px solid red;
        }
        .multi_step_form #msform .tittle h2 {
            font: 500 24px/35px "Roboto", sans-serif;
            color: #3f4553;
            padding-bottom: 5px;
        }
        .multi_step_form #msform .tittle p {
            font: 400 16px/28px "Roboto", sans-serif;
            color: #5f6771;
        }

        .multi_step_form #msform fieldset h3 {
            font: 500 18px/35px "Roboto", sans-serif;
            color: #3f4553;
        }
        .multi_step_form #msform fieldset h6 {
            font: 400 15px/28px "Roboto", sans-serif;
            color: #5f6771;
            padding-bottom: 30px;
        }

        .multi_step_form #msform fieldset .form-control.placeholder, .multi_step_form #msform fieldset .product_select.placeholder {
            color: #5f6771;
        }
        .multi_step_form #msform fieldset .form-control:-moz-placeholder, .multi_step_form #msform fieldset .product_select:-moz-placeholder {
            color: #5f6771;
        }
        .multi_step_form #msform fieldset .form-control::-moz-placeholder, .multi_step_form #msform fieldset .product_select::-moz-placeholder {
            color: #5f6771;
        }
        .multi_step_form #msform fieldset .form-control::-webkit-input-placeholder, .multi_step_form #msform fieldset .product_select::-webkit-input-placeholder {
            color: #5f6771;
        }
        .multi_step_form #msform fieldset .form-control:hover, .multi_step_form #msform fieldset .form-control:focus, .multi_step_form #msform fieldset .product_select:hover, .multi_step_form #msform fieldset .product_select:focus {
            border-color: #5cb85c;
        }
        .multi_step_form #msform fieldset .form-control:focus.placeholder, .multi_step_form #msform fieldset .product_select:focus.placeholder {
            color: transparent;
        }
        .multi_step_form #msform fieldset .form-control:focus:-moz-placeholder, .multi_step_form #msform fieldset .product_select:focus:-moz-placeholder {
            color: transparent;
        }
        .multi_step_form #msform fieldset .form-control:focus::-moz-placeholder, .multi_step_form #msform fieldset .product_select:focus::-moz-placeholder {
            color: transparent;
        }
        .multi_step_form #msform fieldset .form-control:focus::-webkit-input-placeholder, .multi_step_form #msform fieldset .product_select:focus::-webkit-input-placeholder {
            color: transparent;
        }
        .multi_step_form #msform fieldset .product_select:after {
            display: none;
        }
        .multi_step_form #msform fieldset .product_select:before {
            content: "\f35f";
            position: absolute;
            top: 0;
            right: 20px;
            font: normal normal normal 24px/48px Ionicons;
            color: #5f6771;
        }

        .multi_step_form #msform #progressbar {
            margin-bottom: 30px;
            overflow: hidden;
        }
        .multi_step_form #msform #progressbar li {
            list-style-type: none;
            color: #99a2a8;
            font-size: 9px;
            width: calc(100%/4);
            float: left;
            position: relative;
            font: 500 13px/1 "Roboto", sans-serif;
        }
        .multi_step_form #msform #progressbar li:nth-child(2):before {
            content: "2";
        }
        .multi_step_form #msform #progressbar li:nth-child(3):before {
            content: "3";
        }
        .multi_step_form #msform #progressbar li:nth-child(4):before {
            content: "4";
        }
        .multi_step_form #msform #progressbar li:before {
            content: "1";
            font-size: 30px;
            /*font: normal normal normal 30px/50px Ionicons;*/
            width: 50px;
            height: 50px;
            line-height: 50px;
            display: block;
            background: #eaf0f4;
            border-radius: 50%;
            margin: 0 auto 10px auto;
        }
        .multi_step_form #msform #progressbar li:after {
            content: '';
            width: 100%;
            height: 10px;
            background: #eaf0f4;
            position: absolute;
            left: -50%;
            top: 21px;
            z-index: -1;
        }
        .multi_step_form #msform #progressbar li:last-child:after {
            width: 150%;
        }
        .multi_step_form #msform #progressbar li.active {
            color: #5cb85c;
        }
        .multi_step_form #msform #progressbar li.active:before, .multi_step_form #msform #progressbar li.active:after {
            background: #5cb85c;
            color: white;
        }
        .multi_step_form #msform #progressbar li.activated {
            color: #5cb85c;
        }
        .multi_step_form #msform #progressbar li.activated:before, .multi_step_form #msform #progressbar li.activated:after {
            /*background: transparent;*/
            color: #5cb85c;
        }
        .multi_step_form #msform .action-button {
            background: #5cb85c;
            color: white;
            border: 0 none;
            border-radius: 5px;
            cursor: pointer;
            min-width: 130px;
            font: 700 14px/40px "Roboto", sans-serif;
            border: 1px solid #5cb85c;
            margin: 0 5px;
            text-transform: uppercase;
            display: inline-block;
        }
        .multi_step_form #msform .action-button:hover, .multi_step_form #msform .action-button:focus {
            background: #405867;
            border-color: #405867;
        }
        .multi_step_form #msform .previous_button {
            background: transparent;
            color: #99a2a8;
            border-color: #99a2a8;
        }
        .multi_step_form #msform .previous_button:hover, .multi_step_form #msform .previous_button:focus {
            background: #405867;
            border-color: #405867;
            color: #fff;
        }
        .payment-method-row {
            display: flex;
            width:100%;
        }

        .payment-method{
            flex: 1; /* additionally, equal width */

            margin:5px;
            border-bottom:2px solid teal;
            padding:10px;
        }
        .payment-method:hover{
            background-color:#00a7d0;
            color:white;
            border-bottom:2px solid red;
            transition: 0.8s;
            -webkit-transition:0.8s;
        }

    </style>
    <script>
        function showFee() {
            // var campfeeid = $('select#campfee').val();
            var campfeeid = document.getElementById('campfee').value;
//            console.log(campfeeid);
            if(campfeeid != 43){
                document.getElementById('speAcc').disabled = true;
                document.getElementById('speAcc').value = null;
            }else{
                document.getElementById('speAcc').disabled = false;
            }
        }
    </script>
@endsection

@section('content')
    <section style="margin-top: 50px;">
        @if ($errors->any())
            <ul class="get-alert">
                @foreach ($errors->all() as $error)
                    <span class="text-danger"><li>{{ $error }}</li></span>
                @endforeach
            </ul>
        @endif
        <div class="container">
            {{--<div style="text-align: center; margin-bottom: 30px">--}}
                {{--<img src="{{asset('img/aposa-main_edit.png')}}" style="text-align: center;max-width:200px;"/>--}}
            {{--</div>--}}
            <div style="margin: 2.5rem 0;">
                <p style="text-align:right">
                    <a href="{{route('registrant.MyProfile')}}" class="btn btn-flat btn-danger">
                        View My Profile
                    </a>
                    <a href="{{route('registrant.camper_logout')}}" class="btn btn-flat btn-default">
                        Log out
                    </a>
                </p>
                {{--<p style="text-align:left">--}}
                {{--</p>--}}
                <div class="row">
                    <!-- Multi step form -->
                    <section class="multi_step_form">
                        <form id="msform">
                            <!-- Tittle -->
                            <div class="mt-4">
                                <h2>{{ get_current_event()->name }} Registration Process</h2>
                                <p>You can view your registration status here</p>
                            </div>
                            {{--@php--}}
                                {{--$status = 0;--}}
                            {{--@endphp--}}
                            <!-- progressbar -->
                            <ul id="progressbar">
                                <li class="@if($status >= 0) active @endif">Update Details</li>
                                <li class="@if($status >= 1) active @elseif($reg_status >= 1) activated  @endif">Verify Camp Details</li>
                                <li class="@if($status >= 2) active @elseif($reg_status >= 2) activated  @endif">Confirm Payment</li>
                                <li class="@if($status >= 3 && $amount_left <= 0) active @endif">Complete</li>
                            </ul>

                        </form>
                            <!-- fieldsets -->
                        <div class="container p-5 px-3">
                            @if($status == 0)
                                <fieldset class="">
                                    <h3>Update your information</h3>
                                    <form role="form" method="POST" action="{{ route('registrant.steps_save',[0]) }}">
                                        {{ csrf_field() }}

                                        <div class="form-group">
                                            <div class="col-md-3 {{ $errors->has('surname') ? ' has-error' : '' }}" style="margin-top:10px">
                                                {!! Form::label('surname','Surname:',['class'=>'form-label required']) !!}
                                                {!! Form::text('surname',$registrant->surname,['class'=>'form-control']) !!}
                                            </div>
                                            <div class="col-md-3 {{ $errors->has('firstname') ? ' has-error' : '' }}" style="margin-top:10px">
                                                {!! Form::label('firstname','Other names:',['class'=>'form-label required']) !!}
                                                {!! Form::text('firstname',$registrant->firstname,['class'=>'form-control']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-3 {{ $errors->has('gender') ? ' has-error' : '' }}" style="margin-top:10px">
                                                {!! Form::label('gender','Gender:',['class'=>'form-label required']) !!}
                                                {!! Form::select('gender',$gender->prepend('Choose...',''),$registrant->gender_id,['class'=>'form-control']) !!}
                                            </div>
                                            <div class="col-md-3 {{ $errors->has('dob') ? ' has-error' : '' }}" style="margin-top:10px">
                                                {!! Form::label('dob','Date of Birth:',['class'=>'form-label required']) !!}
                                                {!! Form::text('dob',$registrant->dob,['class'=>'form-control datepicker','id'=>'datepicker','autocomplete'=>'off']) !!}
{{--                                                {!! Form::text('dob',$registrant->dob->toDateString(),['class'=>'form-control datepicker','id'=>'datepicker','autocomplete'=>'off']) !!}--}}
                                            </div>
                                        </div>
                                        <div class="row row-fit">
                                            <div class="form-group">
                                                <div class="col-md-3 {{ $errors->has('maritalstatus') ? ' has-error' : '' }}" style="margin-top:10px">
                                                    {!! Form::label('maritalstatus','Marital Status:',['class'=>'form-label required']) !!}
                                                    {!! Form::select('maritalstatus',$maritalstatus->prepend('Choose...',''),$registrant->maritalstatus_id,['class'=>'form-control']) !!}
                                                </div>
{{--                                                <div class="form-group">--}}
                                                <div class="col-md-3 {{ $errors->has('email') ? ' has-error' : '' }}" style="margin-top:10px">
                                                    {!! Form::label('email','Email Address:',['class'=>'form-label']) !!}
                                                    {!! Form::text('email',$registrant->email,['class'=>'form-control']) !!}
                                                </div>
                                                <div class="col-md-3 {{ $errors->has('telephone') ? ' has-error' : '' }}" style="margin-top:10px">
                                                    {!! Form::label('telephone','Mobile Number:',['class'=>'form-label required']) !!}
                                                    {!! Form::text('telephone',$registrant->telephone,['class'=>'form-control','id'=>'telephone']) !!}
                                                </div>
                                                <div class="col-md-3 {{ $errors->has('profession') ? ' has-error' : '' }}" style="margin-top:10px">
                                                    {!! Form::label('profession','Profession:',['class'=>'form-label']) !!}
                                                    {!! Form::text('profession',$registrant->profession,['class'=>'form-control','id'=>'profession']) !!}
                                                </div>
{{--                                                </div>--}}
                                                <div class="col-md-4 {{ $errors->has('nationality') ? ' has-error' : '' }}" style="margin-top:9px">
                                                    {!! Form::label('nationality','Nationality:',['class'=>'form-label required']) !!}
{{--                                                    <label style="margin-left: 10px; margin-right: 5px;">--}}
{{--                                                        <input type="radio" value="Ghanaian" id="ghana" class="flat-red" name="nationality" {{ ($registrant->nationality == 'Ghanaian') ? 'checked' : '' }}> Ghanaian--}}
{{--                                                    </label>--}}
{{--                                                    <label style="margin-top: 0px; margin-right: 5px;">--}}
{{--                                                        <input type="radio" class="flat-red" id="others" value="2" name="nationality" {{ ($registrant->nationality == '2') ? 'checked' : '' }}> Other--}}
{{--                                                    </label>--}}
                                                    <input type="text" id="othernationality" name="othernationality" class="form-control" style="float:right" value="{{ $registrant->nationality }}"/>
                                                </div>

                                                <div class="col-md-4 {{ $errors->has('permaddress') ? ' has-error' : '' }}" style="margin-top:10px">
                                                    {!! Form::label('permaddress','Permanent Address:',['class'=>'form-label']) !!}
                                                    {!! Form::text('permaddress',$registrant->permaddress,['class'=>'form-control']) !!}
                                                </div>

                                                <div class="col-md-4 {{ $errors->has('food_preference') ? ' has-error' : '' }}" style="margin-top:10px">
                                                    {!! Form::label('food_preference','Food Preference',['class'=>'form-label']) !!}
                                                    {!! Form::select('food_preference',['Choose...'=>'Choose...','Non Vegetarian'=>'Non Vegetarian', 'Vegetarian'=>'Vegetarian'],$registrant->food_preference,['class'=>'form-select','required']) !!}
                                                </div>
                                            </div>
                                        </div>

{{--                                        <div class="form-group">--}}
{{--                                            <div class="col-md-6 {{ $errors->has('businessadress') ? ' has-error' : '' }}" style="margin-top:10px">--}}
{{--                                                {!! Form::label('businessaddress','Business Address:',['class'=>'form-label']) !!}--}}
{{--                                                {!! Form::textarea('businessaddress',$registrant->businessaddress,['class'=>'form-control','rows'=>3,'cols'=>10]) !!}--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                        <div class="row row-fit">--}}
{{--                                            <div class="form-group">--}}
{{--                                                <div class="col-md-6 {{ $errors->has('permaddress') ? ' has-error' : '' }}" style="margin-top:10px">--}}
{{--                                                    {!! Form::label('permaddress','Permanent Address:',['class'=>'form-label']) !!}--}}
{{--                                                    {!! Form::textarea('permaddress',$registrant->permaddress,['class'=>'form-control','rows'=>3,'cols'=>10]) !!}--}}
{{--                                                </div>--}}
{{--                                                <div class="col-md-6 {{ $errors->has('studentaddress') ? ' has-error' : '' }}" style="margin-top:10px">--}}
{{--                                                    {!! Form::label('studentaddress','If Student, state school and address:',['class'=>'form-label']) !!}--}}
{{--                                                    <span style="font-size:x-small;">(NB: Student refers to undergrads and below. Address Example: Mfantsipim, P. O. Box 101, Cape Coast)</span>--}}
{{--                                                    {!! Form::textarea('studentaddress',$registrant->studentaddress,['class'=>'form-control','rows'=>2,'cols'=>10]) !!}--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
                                        {{----}}
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <center>
                                                    @if(!$registrant->confirmedpayment)
{{--                                                    <input type="submit" name="save" value="Save" class="btn btn-primary" style="margin-top:15px">--}}
                                                        <button class="btn btn-primary me-3 mb-2" name="save" value="Save" type="submit"> <i class="fa fa-save me-2"></i> Save</button>
                                                        <button class="btn btn-outline-primary me-3 mb-2" name="save_continue" value="Save & Continue" type="submit"> <i class="fa fa-arrow-circle-right me-2"></i> Save & Continue</button>
                                                    @endif
                                                    @if($reg_status > $status)
                                                            <a href="{{route('registrant.camper_info_update',[1])}}" class="btn btn-success mb-2 me-3">Next <i class="fa fa-angle-double-right ms-2"></i></a>
                                                        @endif
                                                </center>
                                            </div>
                                        </div>
                                    </form>
                                </fieldset>
                            @elseif($status == 1)
                                <fieldset>
                                    <h5 class="text-center mb-4">Verify registration details.</h5>
                                    <form role="form" method="POST" action="{{ route('registrant.steps_save',[1]) }}">
                                        {{ csrf_field() }}
                                        <div class="row row-fit"><div class="form-group">
{{--                                                <div class="col-md-3 {{ $errors->has('chapter') ? ' has-error' : '' }}" style="margin-top:10px">--}}
{{--                                                    {!! Form::label('chapter','Chapter:',['class'=>'form-label']) !!}--}}
{{--                                                    {!! Form::text('chapter',$registrant->chapter,['class'=>'form-control']) !!}--}}
{{--                                                </div>--}}
{{--                                                <div class="col-md-3 {{ $errors->has('foreigndel') ? ' has-error' : '' }}" style="margin-top:10px">--}}
{{--                                                    {!! Form::label('foreigndel','Foreign delegate?',['class'=>'form-label required']) !!}--}}
{{--                                                    {!! Form::select('foreigndel',$yesno->prepend('Choose...',''),$registrant->foreigndel_id,['class'=>'form-control']) !!}--}}
{{--                                                </div>--}}
{{--                                                <div class="col-md-3 {{ $errors->has('localassembly') ? ' has-error' : '' }}" style="margin-top:10px">--}}
{{--                                                    {!! Form::label('localassembly','Local Assembly:',['class'=>'form-label required']) !!}--}}
{{--                                                    {!! Form::text('localassembly',$registrant->localassembly,['class'=>'form-control']) !!}--}}
{{--                                                </div>--}}
{{--                                                <div class="col-md-3 {{ $errors->has('area') ? ' has-error' : '' }}" style="margin-top:10px">--}}
{{--                                                    {!! Form::label('area','Area:',['class'=>'form-label']) !!}--}}
{{--                                                    {!! Form::select('area',$area->prepend('Choose...',''),$registrant->area_id,['class'=>'form-control  select2']) !!}--}}
{{--                                                </div>--}}
{{--                                                <div class="col-md-3 {{ $errors->has('region') ? ' has-error' : '' }}" style="margin-top:10px">--}}
{{--                                                    {!! Form::label('region','Region:',['class'=>'form-label']) !!}--}}
{{--                                                    {!! Form::select('region',$region->prepend('Choose...',''),$registrant->region_id,['class'=>'form-control select2']) !!}--}}
{{--                                                </div>--}}
{{--                                                <div class="col-md-3 {{ $errors->has('officechurch') ? ' has-error' : '' }}" style="margin-top:10px">--}}
{{--                                                    {!! Form::label('officechurch','Office Held in Church:',['class'=>'form-label required']) !!}--}}
{{--                                                    {!! Form::select('officechurch',$OfficeHeldInChurch->prepend('Choose...',''),$registrant->officechurch_id,['class'=>'form-control select2 padded']) !!}--}}
{{--                                                </div>--}}
{{--                                                <div class="col-md-3 {{ $errors->has('officeaposa') ? ' has-error' : '' }}" style="margin-top:10px">--}}
{{--                                                    {!! Form::label('officeaposa','Office Held at APOSA (if any):',['class'=>'form-label']) !!}--}}
{{--                                                    {!! Form::text('officeaposa',$registrant->officeaposa,['class'=>'form-control']) !!}--}}
{{--                                                </div>--}}
                                                <div class="col-md-6 {{ $errors->has('denomination') ? ' has-error' : '' }}" style="margin-top:9px">
                                                    {!! Form::label('denomination','Denomination:',['class'=>'form-label required']) !!}
                                                    <label style="margin-left: 10px; margin-right: 5px;">
                                                        <input type="radio" value="The Apostolic Church-Ghana" class="flat-red" name="denomination" {{ ($registrant->denomination == 'The Apostolic Church-Ghana') ? 'checked' : '' }}> The Apostolic Church-Ghana
                                                    </label>
                                                    <label style="margin-top: 0px; margin-right: 5px;">
                                                        <input type="radio" class="flat-red" value="2" name="denomination" {{ ($registrant->denomination == '2') ? 'checked' : '' }}> Other
                                                    </label>
                                                    <input type="text" name="otherdenomination" class="form-control" style="float:right" value="{{ (old('otherdenomination'))}}"/>
                                                </div>
{{--                                                <div class="col-md-3 {{ $errors->has('agdleader') ? ' has-error' : '' }}" style="margin-top:10px">--}}
{{--                                                    {!! Form::label('agdleader','Are you an AGD Leader?',['class'=>'form-label']) !!}--}}
{{--                                                    {!! Form::select('agdleader',$yesno->prepend('Choose...',''),$registrant->agdleader_id,['class'=>'form-control']) !!}--}}
{{--                                                </div>--}}
                                                <div class="col-md-6 {{ $errors->has('agdlang') ? ' has-error' : '' }}" style="margin-top:10px">
                                                    {!! Form::label('agdlang','AGD Language:',['class'=>'form-label required']) !!}
                                                    {!! Form::select('agdlang',$AGDLanguage->prepend('Choose...',''),$registrant->agdlang_id,['class'=>'form-control']) !!}
                                                </div>
                                                <div class="col-md-6 {{ $errors->has('campercat') ? ' has-error' : '' }}" style="margin-top:10px">
                                                    {!! Form::label('campercat','Event:',['class'=>'form-label required']) !!}
                                                    {!! Form::select('campercat',$Camper->prepend('Choose...',''),$registrant->campercat_id,['class'=>'form-control']) !!}
                                                </div>
                                                <div class="col-md-6 {{ $errors->has('campfee') ? ' has-error' : '' }}" style="margin-top:10px">
                                                    {!! Form::label('campfee','Select Applicable Event Fee:',['class'=>'form-label required']) !!}
                                                    {!! Form::select('campfee',$CampApplicableFee->prepend('Choose...',''),$registrant->campfee_id,['class'=>'form-control','id'=>'campfee','onchange'=>'showFee()']) !!}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <p><label style="margin-top: 10px; margin-right: 5px;" class="required">
                                                        <input type="checkbox"  name="disclaimer" class="flat-red" id="disclaimer" value="1"
                                                               {{ (old('disclaimer_id') == '1') ? 'checked' : '' }} {{ (($registrant->disclaimer_id) == '1') ? 'checked' : '' }} required/>
                                                        I understand that my registration is not complete until I make payment.&nbsp;(Disclaimer)
                                                    </label>
                                                </p>
                                            </div>
                                            <hr />
                                        </div>

                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <center>
                                                    <a href="{{route('registrant.camper_info_update')}}" class="btn btn-outline-primary me-3 mb-2"> <i class="fa fa-angle-double-left me-2"></i>Previous</a>
                                                    @if(!$registrant->confirmedpayment)
                                                        <button class="btn btn-primary me-3 mb-2" name="save" value="Save" type="submit"> <i class="fa fa-save me-2"></i> Save</button>
                                                        <button class="btn btn-outline-primary me-3 mb-2" name="save_continue" value="Save & Continue" type="submit"> <i class="fa fa-arrow-circle-right me-2"></i> Save & Continue</button>
                                                    @endif
                                                    @if($reg_status > $status)
                                                        <a href="{{route('registrant.camper_info_update',[2])}}" class="btn btn-success mb-2 me-3">Next <i class="fa fa-angle-double-right ms-2"></i></a>
                                                    @endif
                                                </center>
                                            </div>
                                        </div>
                                    </form>
                                </fieldset>
                            @elseif($status == 2)
                                <fieldset>


                                    @php
                                        $payment = $payments->where('approved','=',0)->first();
                                        $initial_payments = $payments->where('approved','=',1);
                                    @endphp

                                    <div class="row">
                                        <div class="col-md-4 mb-4">
                                            <div class="card">
                                                <div class="card-header">
                                                    Payment Details
                                                </div>
                                                <ul class="list-group list-group-flush">
                                                    <li class="list-group-item"><strong>Registration Fee: </strong> GHS {{$amount_to_pay}}</li>
                                                    <li class="list-group-item"><strong>Paid: </strong> GHS {{$total_paid}}</li>
                                                    <li class="list-group-item">
                                                        @if($amount_left >= 0)
                                                            <span class="text-danger"><strong>Balance: </strong> GHS {{$amount_left}}</span>
                                                        @else
                                                            <span class="text-success"><strong>Refund: </strong> GHS {{$amount_left}}</span>
                                                        @endif
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col-md-8 mb-4">
                                            <form role="form" method="POST" action="{{ route('payment.makepayment') }}">
                                                {{ csrf_field() }}
                                            <div class="card">
                                                <div class="card-header">
                                                    Provide Payment Details
                                                </div>
                                                <div class="card-body">
                                                    <div class="form-group">
                                                        {{ csrf_field() }}
                                                        <div class="col-md-5">
                                                            <label for="transaction_no" class="required">Payment Reference No.</label>
                                                            <input type="text" required class="form-control" name="transaction_no" value="{{$payment_ref}}" readonly>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <label for="amount" class="required">Amount Paid</label>
                                                            <input type="number" step="0.01" min="0.1" class="form-control" required name="amount" id="amount" placeholder="Amount here..."/>
                                                            <input type="hidden" required name="amount_left" value="{{$amount_left}}"/>
                                                        </div>
                                                        <div class="col-md-3">
{{--                                                            <input type="submit" value="Make Online Payment" class="btn btn-success">--}}
                                                            <button type="submit" class="btn btn-success" style="margin-top: 40px"><i class="fa fa-money me-2"></i>Pay now</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            </form>
                                        </div>
                                    </div>

                                    <div class="card mb-4">
                                        <div class="card-header">
                                            Payments
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-bordered">
                                                    <tr>
                                                        <th>Paid On</th>
                                                        <th>Payment Mode</th>
                                                        <th>Transaction No.</th>
                                                        <th>Paid (GHS)</th>
                                                        <th>Successful Payment?</th>
                                                    </tr>
                                                    @if($payments->count() > 0)
                                                        @foreach($payments as $initial_payment)
                                                            <tr>
                                                                <td>{{date('F j, Y', strtotime($initial_payment->created_at))}}</td>
                                                                <td>{{ucwords(str_replace('-',' ',$initial_payment->payment_mode))}}</td>
                                                                <td>{{$initial_payment->transaction_no}}</td>
                                                                <td>{{$initial_payment->amount_paid}}</td>
                                                                <td>{{($initial_payment->approved == 1)?'Yes':'No, Did not go through.'}}</td>
                                                            </tr>
                                                        @endforeach
                                                    @else
                                                        <tr>
                                                            <td colspan="5" style="text-align: center">No payments yet</td>
                                                        </tr>
                                                    @endif
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-md-12 {{ $errors->has('paymentphone') ? ' has-error' : '' }}" style="margin-top:10px">
                                            {!! Form::label('paymentphone','You may call these numbers in case you need assistance:',['class'=>'form-label']) !!}
                                            <div><i class="fa fa-info-circle"></i>&nbsp;+233248376160 / +233558521306 </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                    <div class="col-md-12">
                                        <center>
                                            <a href="{{route('registrant.camper_info_update',[1])}}" style="margin-top: 15px;margin-bottom: 0px;" class="btn btn-outline-primary me-3"> <i class="fa fa-angle-double-left me-2"></i>Previous</a>
                                            {{--@if($amount_left > 0)--}}
                                            {{--<input type="submit" name="complete" value="Confirm Payment" class="btn btn-flat btn-success" style="margin-top:15px">--}}
                                            {{--@else--}}
                                                <a href="{{route('registrant.camper_info_update',[3])}}" style="margin-top: 15px;margin-bottom: 0px;" class="btn btn-outline-primary">Next <i class="fa fa-angle-double-right ms-2"></i></a>
                                            {{--@endif--}}
                                        </center>
                                    </div>
                                </div>
                            {{--</form>--}}
                                </fieldset>
                            @elseif($status == 3 && $amount_left <= 0)
                                <fieldset>
                                    <h3>Registration Completed</h3>
                                    @php
                                        /*$payment = $payments->where('approved','=',0)->first();*/
                                        $initial_payments = $payments->where('approved','=',1);
                                    @endphp
                                    <h4>Initial Payments</h4>
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered">
                                            <tr>
                                                <th>Paid On</th>
                                                <th>Payment Mode</th>
                                                <th>Transaction No.</th>
                                                <th>Amount Paid (GHS)</th>
                                                <th>Date Approved</th>
                                            </tr>
                                            @if($initial_payments->count() > 0)
                                                @foreach($initial_payments as $initial_payment)
                                                    <tr>
                                                        <td>{{date('F j, Y, g:i a', strtotime($initial_payment->created_at))}}</td>
                                                        <td>{{ucwords(str_replace('-',' ',$initial_payment->payment_mode))}}</td>
                                                        <td>{{$initial_payment->transaction_no}}</td>
                                                        <td>{{$initial_payment->amount_paid}}</td>
                                                        <td style="color: #5cb85c">{{date('F j, Y, g:i a', strtotime($initial_payment->approved_at))}}</td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="5" style="text-align: center">No payment approved</td>
                                                </tr>
                                            @endif
                                        </table>
                                    </div>
                                    <div class="text-center">
                                        <a href="{{route('registrant.camper_info_update',[2])}}" style="margin-top: 15px;margin-bottom: 0px;" class="btn btn-flat btn-label-blue">Previous</a>
                                    </div>
                                </fieldset>
                            @else
                                <h1 class="text-center">Invalid Step</h1>
                            @endif
                        </div>
                    </section>
                    <!-- End Multi step form -->
                </div>
            </div>

        </div>
    </section>
@endsection
@section('footerscripts')
    <script src="{{ asset('plugins/iCheck/check-file.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function(){
            //trigger campercat change
//            $("#campercat").trigger('change');
            $("#campercat").trigger("change");

            $(function() {
                $( ".datepicker" ).datepicker({changeMonth: true,changeYear: true,showButtonPanel: true,yearRange: "-40:+1 ",dateFormat: "yy-mm-dd"});
            });

//            showFee();//call show fee to automatically select Contact Admin for all special accomodation

        $("#telephone").keypress(function (event) { return isNumberKey(event) });
        $("#ambassadorphone").keypress(function (event) { return isNumberKey(event) });
        //function to check if value entered is numeric
        function isNumberKey(evt) { var charCode = (evt.which) ? evt.which : event.keyCode; if (charCode > 31 && (charCode < 48 || charCode > 57)) { return false; } return true; }
        function isNumber(evt) { var charCode = (evt.which) ? evt.which : event.keyCode; if (charCode != 45 && (charCode != 46 || $(this).val().indexOf('.') != -1) && (charCode < 48 || charCode > 57)) return false; return true; }
        //        })
        $( function() {
            var profs = ({!! json_encode($profession) !!});
            $("#profession").autocomplete({
                source: profs
            });
        } );
            //Flat red color scheme for iCheck
            $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
                checkboxClass: 'icheckbox_flat-green',
                radioClass   : 'iradio_flat-green'
            })

            $('#campercat').on('change',function () {
                var id = $(this).val();
                $('#campfee').find('option').not(':first').remove();
                $.ajax({
                    url:'/campercatfees/'+id,
                    type:'get',
                    dataType:'json',
                    success:function (response) {
                        var len = 0;
                        if (response.data != null) {
                            len = response.data.length;
                        }
                        if (len>0) {
                            for (var i = 0; i<len; i++) {
                                var id = response.data[i].id;
                                var name = response.data[i].name;

                                var option = "<option value='"+id+"'>"+name+"</option>";

                                $("#campfee").append(option);
                            }
                        }
                    }
                })
            });
        });

        </script>
@endsection