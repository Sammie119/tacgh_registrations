@extends('layouts.app')
@section('beforecss')
    <link rel="stylesheet" href="{{ asset('css/AdminLTE.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/icheck/all.css') }}">
    <link rel="stylesheet" href="{{asset('css/jquery-ui.min.css')}}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{asset('css/jquery.dataTables.min.css')}}">
{{--    <link rel="stylesheet" href="{{ asset('css/progress-form-new.css') }}">--}}
    <script>
        //        $(document).ready(function(){

        function showFee() {
            // var campfeeid = $('select#campfee').val();
            var campfeeid = document.getElementById('campfee').value;
//                alert(campfeeid);
            if(campfeeid != 43){
                document.getElementById('speAcc').disabled = true;
                document.getElementById('speAcc').value = null;
            }else{
                document.getElementById('speAcc').disabled = false;
            }
        }
        // function applicabeFee(){
        //     var campfeeid = document.getElementById('campcat').value;
        // }
        //        })
    </script>
    <style>
        .modal-backdrop
        {
            opacity:0.2 !important;
        }
        .hideCol{
            display:none;
        }
        .ui-autocomplete
        {
            position:absolute;
            cursor:default;
            z-index:4000 !important
        }
        .panel-group .panel {
            border-radius: 0;
            box-shadow: none;
            border-color: #EEEEEE;
        }

        .panel-default > .panel-heading {
            padding: 0;
            border-radius: 0;
            color: #212121;
            background-color: #FAFAFA;
            border-color: #EEEEEE;
        }

        .panel-title {
            font-size: 14px;
        }

        .panel-title > a {
            display: block;
            padding: 15px;
            text-decoration: none;
        }

        .more-less{
            float: right;
            /*color: white;*/
        }
        span.collapse-header-span{
            font-size:16pt;margin-right:10px;
            font-weight:bolder;
        }
        /*span.collapse-header-span{float:right;right:140px !important;}*/

        .panel-default > .panel-heading + .panel-collapse > .panel-body {
            border-top-color: #EEEEEE;
        }
        .panel-heading#headingOne{
            background-color:#d9534f;color:white;
        }
        .panel-heading#headingTwo{
            background-color:#5cb85c;color:white;
        }
        .panel-heading#headingThree{
            background-color:#5bc0de;color:white;
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

        .fee-display{
            float:right;
            margin-right:10px;
            font-size:large;
        }
    </style>
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
            width: calc(100%/3);
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
@endsection

@section('content')
    <section style="margin-top: 50px;" class="content">
        <div class="container" styl="border:1px solid teal;overflow: auto;height: 90%;">
            <div style="display:inline-block;width:100%;">
                <div style="margin:0 auto;display:inline-block;">
                    <img src="{{asset('img/aposa-main_edit.png')}}" style="margin:0 auto;;max-width:200px"/>
                </div>
                <div style="margin: 1rem 0;display: inline-block;float:right">
                    <a href="{{route('registrant.camper_logout')}}" class="btn btn-flat btn-danger">
                        Log out
                    </a>
                </div>
            </div>
            <div style="margin: 2.5rem 0;">
                <div class="row">
                    <!-- Multi step form -->
                    <section class="multi_step_form">
                        <form id="msform">
                            <div clas="tittle">
                                <h3 style="text-align: center">Welcome back <span style="color:green">{{$chapter_details->chapter}} Chapter</span></h3>
                            </div>
                            <div style="text-align: center">
                                <ul id="progressbar">
                                    <li class="@if($reg_status > 0) active @endif">Update Members</li>
                                    <li class="@if($reg_status > 1) active @endif">Payment Details</li>
                                    <li class="@if($reg_status > 2) active @endif">Complete</li>
                                </ul>
                            </div>
                        </form>
                        <!-- fieldsets -->
                        <div class="container">
                            @if($status == 0)
                                <fieldset>
                                    <div class="row">
                                        <div class="pull-right">
                                            <div class="col-md-4"><a href="#" class="btn btn-primary" id="addcamper">Add New Camper</a></div>
                                            <div class="col-md-4"><button type="button" class="btn btn-danger" data-toggle="modal" data-target="#transferOutModal">Transfer Out Camper</button></div>
                                            <div class="col-md-4"><button type="button" class="btn btn-warning" data-toggle="modal" data-target="#transferInModal">Transfer In Camper</button></div>
                                        </div>

                                    </div>

                                    <h3>Verify Chapter Member Details</h3>
                                    {{--<form role="form" method="POST" action="{{ route('registrant.steps_save',[0]) }}">--}}
                                    <form  action="{{ URL::to('batchregisternew') }}" class="form-horizontal" method="post">
                                        {{ csrf_field() }}
                                        <div class="panel-body">
                                            @if($registrants)
                                                <div class="table-responsive">

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
                                                                <td>{{$registrant->camper_fee_desc}}</td>
                                                                <td>{{$registrant->Type_of_Special_Accomodation}}</td>
                                                                <td>{{$registrant->AGD_Language}}</td>
                                                                <td>
                                                                    <a href="#" class="btn-warning btn-sm form-edit"  style="padding:5px;width:auto;">Edit</a>
                                                                    {{--<a href="{{ route('batchregistration.chaptermemberedit', ['uid'=>$registrant->id]) }}" class="btn-danger row-delete" style="padding:3px;width:auto;margin:0" onclick="return confirm('Are you sure you want to Delete from list?')">Delete</a>--}}
                                                                    <a href="#" class="btn-danger row-delete" style="padding:3px;width:auto;margin:0" >Delete</a>
                                                                </td>
                                                                <td class="hideCol">{{$registrant->reg_json}}</td>
{{--                                                                <td class="hideCol">{{$registrant->marital_status.'|'.$registrant->nationality--}}
{{--                                                        .'|'.$registrant->local_assembly.'|'.$registrant->area.'|'.$registrant->permanent_address.'|'.$registrant->telephone--}}
{{--                                                        .'|'.$registrant->email.'|'.$registrant->officechurch.'|'.$registrant->profession.'|'.$registrant->business_address--}}
{{--                                                        .'|'.$registrant->business_address.'|'.$registrant->agd_leader.'|'.$registrant->reg_id.'|'.$registrant->batch_no}}</td>--}}
                                                            </tr>
                                                        @endforeach
                                                        </tbody>
                                                    </table>

                                                </div>
                                            @endif
                                        </div>
                                        <hr/>
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
                                                    <input type="radio" id="denomination"  value="The Apostolic Church-Ghana"class="flat-red" name="denomination" required checked> The Apostolic Church-Ghana
                                                </label>
                                                <label style="margin-top: 0px; margin-right: 5px;">
                                                    <input type="radio" id="otherdenomination" class="flat-red" value="2" name="denomination" required> Other
                                                </label>
                                                <input type="text" name="otherdenomination" class="form-control" style="float:right"/>

                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-6 {{ $errors->has('region') ? ' has-error' : '' }}" style="margin-top:10px">
                                                {!! Form::label('region','Region:',['class'=>'form-label']) !!}
                                                {!! Form::select('region',$region->prepend('Choose...',''),$chapter_details->region,['class'=>'form-control','id'=>'chapter-region','required']) !!}
                                            </div>
                                            <div class="col-md-6 {{ $errors->has('area') ? ' has-error' : '' }}" style="margin-top:10px">
                                                <input type="hidden" id="chapterarea" class="form-control" value="{{$chapter_details->carea}}" style="float:right"/>
                                                {!! Form::label('area','Area:',['class'=>'form-label']) !!}
                                                {!! Form::select('area',$area->prepend('Choose...',''),$chapter_details->carea,['class'=>'form-control','id'=>'chapter-area','required']) !!}
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
                                        <center style="margin-bottom:10px">
                                            {{--<input type="submit" name="save" value="Save" class="btn btn-flat btn-label-blue" style="margin-top:15px">--}}
                                            <input type="submit" name="save_continue" value="Save & Continue" class="btn btn-flat btn-label-blue" style="margin-top:15px">
                                            @if($reg_status > $status)
                                                <a href="{{route('batchregistration.chapter_info_update',[$chapter_details->batch_no,1])}}" style="margin-top: 15px;margin-bottom: 10px;" class="btn btn-flat btn-label-blue">Next</a>
                                            @endif
                                        </center>
                                    </form>
                                </fieldset>
                            @elseif($status == 1)
                                <fieldset>

                                    <hr/>
                                    <div class="row">
                                        <div class="pull-left">
                                            <div style="margin-left: 10px;"><i class="fa fa-info-circle"></i>You may call these numbers in case you need assistance:&nbsp;0240189785 /0246768140 </div>
                                        </div>
                                        <div class="pull-right">
                                            <div class="col-md-4"><button type="button" class="btn btn-warning" data-toggle="modal" data-target="#onlinePaymentModal">Pay Online</button></div>
                                        </div>

                                    </div>
                                    <hr/>

                                    <h3 style="text-align:center">Payment Details</h3>

                                    <form class="form-horizontal" id="paymentform" role="form" method="POST" action="{{ route('bacthregistration.chapter_save_progress') }}">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="hidBatchNo" value="{{$chapter_details->batch_no}}"/>

                                        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                            <div class="panel panel-default">
                                                <div class="panel-heading" role="tab" id="headingOne" class="header-warning">
                                                    <h4 class="panel-title">
                                                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                            <span class="collapse-header-span">{{($nonpaidmembers != null)? count($nonpaidmembers):0}}</span> <i class="more-less glyphicon glyphicon-plus"></i>
                                                            Non-paid Chapter Members <span class="fee-display">Total Amount GHS: {{$total_fee - $total_payment_checked_campers }}</span>
                                                        </a>
                                                    </h4>
                                                </div>
                                                <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                                                    <div class="panel-body">
                                                        @if($nonpaidmembers)
                                                            <div class="row">
                                                                <div class="text-center">
                                                                    <input type="button" id="calcBatchAmount" class="btn btn-primary" value="Calculate Payment" title="Calculates for checked members"/>
                                                                </div>
                                                            </div>
                                                            <div class="table-responsive">
                                                                <table id="dtrows-nonpaid" class="table table-striped">
                                                                    <thead>
                                                                    <tr>
                                                                        <th>Firstname</th>
                                                                        <th>Lastname</th>
                                                                        <th>DOB</th>
                                                                        <th>Gender</th>
                                                                        <th>Camper Category</th>
                                                                        <th>Fee Type</th>
                                                                        <th>Fee (GHS)</th>
                                                                        <th>Area</th>
                                                                        <th class="check">Paid?
                                                                            <input type="checkbox" id="memberCheckAll" class="memberCheckAll" name="selectall" value="1"  checked="false"/></th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    @foreach($nonpaidmembers as $registrant)
                                                                        <tr>
                                                                            <td>{{$registrant->firstname}}</td>
                                                                            <td>{{strtoupper($registrant->surname)}}</td>
                                                                            <td>{{$registrant->dob}}</td>
                                                                            <td>{{$registrant->gender}}</td>
                                                                            <td>{{$registrant->camper}}</td>
                                                                            <td>{{$registrant->camper_fee_desc}}</td>
                                                                            <td>{{$registrant->camper_fee}}</td>
                                                                            <td>{{$registrant->carea}}</td>
                                                                            <td class="floatright">{{ Form::checkbox('registrants[]',  $registrant->id ,null,['class'=>'switchbutton','checked'=>'false']) }}</td>
                                                                            {{--<td class="floatright">{{ Form::checkbox('registrants[]',  $registrant->id ,null) }}</td>--}}
                                                                        </tr>
                                                                    @endforeach
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        @else
                                                            <div>No non-paid members </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="panel panel-default">
                                                <div class="panel-heading" role="tab" id="headingTwo" class="header-success">
                                                    <h4 class="panel-title">
                                                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                            <span class="collapse-header-span">{{($paidmembers !=null)?count($paidmembers):0}}</span><i class="more-less glyphicon glyphicon-plus"></i>
                                                            Paid Chapter Members (members who have paid to leader)<span class="fee-display">Total Amount GHS: {{$total_payment_checked_campers }}</span>
                                                        </a>
                                                    </h4>
                                                </div>
                                                <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                                                    <div class="panel-body">
                                                        @if($paidmembers)
                                                            <div class="table-responsive">
                                                                <div>Paid Chapter Members</div>
                                                                <table id="dtrows-paid" class="table table-striped">
                                                                    <thead>
                                                                    <tr>
                                                                        <th>Firstname</th>
                                                                        <th>Lastname</th>
                                                                        <th>DOB</th>
                                                                        <th>Gender</th>
                                                                        <th>Camper Category</th>
                                                                        <th>Fee Type</th>
                                                                        <th>Fee</th>
                                                                        <th>Area</th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    @foreach($paidmembers as $registrant)
                                                                        <tr>
                                                                            <td>{{$registrant->firstname}}</td>
                                                                            <td>{{strtoupper($registrant->surname)}}</td>
                                                                            <td>{{$registrant->dob}}</td>
                                                                            <td>{{$registrant->gender}}</td>
                                                                            <td>{{$registrant->camper}}</td>
                                                                            <td>{{$registrant->camper_fee_desc}}</td>
                                                                            <td>{{$registrant->camper_fee}}</td>
                                                                            <td>{{$registrant->carea}}</td>
                                                                        </tr>
                                                                    @endforeach
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        @else
                                                            <div>No paid members </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="panel panel-default">
                                                <div class="panel-heading" role="tab" id="headingThree" class="header-default">
                                                    <h4 class="panel-title">
                                                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                                            <span class="collapse-header-span">{{($payment_details!=null)?count($payment_details):0}}</span><i class="more-less glyphicon glyphicon-plus"></i>
                                                            Payments History <span class="fee-display">Outstanding GHS: {{$total_fee - $received_online_payments }}</span>
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

                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <center>
                                                        <a href="{{route('batchregistration.chapter_info_update',[$chapter_details->batch_no,0])}}" style="margin-top: 15px;margin-bottom: 0px;" class="btn btn-flat btn-label-blue">Previous</a>
                                                        {{--<input type="submit" name="save" value="Save" class="btn btn-flat btn-label-blue" style="margin-top:15px">--}}
                                                        <input type="submit" name="save_continue" value="Save & Continue" class="btn btn-flat btn-label-blue" style="margin-top:15px">
                                                        @if($reg_status > $status)
                                                            <a href="{{route('batchregistration.chapter_info_update',[$chapter_details->batch_no,2])}}" style="margin-top: 15px;margin-bottom: 0px;" class="btn btn-flat btn-label-blue">Next</a>
                                                        @endif
                                                    </center>
                                                </div>
                                            </div>

                                        </div>
                                    </form>

                                </fieldset>
                            @elseif($status == 2)
                                <fieldset>
                                    <h3>Registration Status</h3>
                                    <p>
                                        Your registration status is shown here!
                                    </p>
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <center>
                                                <a href="{{route('batchregistration.chapter_info_update',[$chapter_details->batch_no,1])}}" style="margin-top: 15px;margin-bottom: 0px;" class="btn btn-flat btn-label-blue">Previous</a>
                                                @if($reg_status > $status)
                                                    <a href="{{route('batchregistration.chapter_info_update',[$chapter_details->batch_no,2])}}" style="margin-top: 15px;margin-bottom: 0px;" class="btn btn-flat btn-label-blue">Next</a>
                                                @endif
                                            </center>
                                        </div>
                                    </div>
                                </fieldset>
                            @endif
                        </div>
                        {{--</form>--}}
                    </section>
                    <!-- End Multi step form -->
                </div>
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
                                                {!! Form::text('dob',null,['class'=>'form-control datepicker','id'=>'datepicker','autocomplete'=>'off']) !!}
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
                                            <div class="col-md-6 {{ $errors->has('campfee') ? ' has-error' : '' }}" style="margin-top:10px">
                                                {!! Form::label('campfee','Select Applicable Camp Fee:',['class'=>'form-label required']) !!}
                                                {!! Form::select('campfee',$CampApplicableFee->prepend('Choose...',''),null,['class'=>'form-control','id'=>'campfee','onchange'=>'showFee()','required']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-6 {{ $errors->has('agdleader') ? ' has-error' : '' }}" style="margin-top:10px">
                                                {!! Form::label('agdleader','Are you an AGD Leader?:',['class'=>'form-label']) !!}
                                                {!! Form::select('agdleader',$yesno->prepend('Choose...',''),null,['class'=>'form-control','id'=>'agdleader']) !!}
                                            </div>
                                            <div class="col-md-6 {{ $errors->has('agdlang') ? ' has-error' : '' }}" style="margin-top:10px">
                                                {!! Form::label('agdlang','Action Group Discussion (Preferred Language):',['class'=>'form-label required']) !!}
                                                {!! Form::select('agdlang',$AGDLanguage->prepend('Choose...',''),null,['class'=>'form-control','id'=>'agdlang']) !!}
                                            </div>
                                        </div>

                                        <div class="form-group" style="display: none">
                                            <div class="col-md-6 {{ $errors->has('specialaccom') ? ' has-error' : '' }}" style="margin-top:10px">
                                                {!! Form::label('specialaccom','Select the type of Special Accommodation:',['class'=>'form-label']) !!}
                                                {!! Form::select('specialaccom',$SpecialAccomodation->prepend('Choose...',''),null,['class'=>'form-control','id'=>'speAcc','disabled'=>'disabled']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-6 {{ $errors->has('needCounseling') ? ' has-error' : '' }}" style="margin-top:10px">
                                                {!! Form::label('needCounseling','Would you need counseling during camp meeting? :',['class'=>'form-label required']) !!}
                                                {!! Form::select('needCounseling',$yesno->prepend('Choose...',''),null,['class'=>'form-control','required',"id"=>"needCounseling"]) !!}
                                            </div>
                                            <div class="col-md-6 {{ $errors->has('areaOfCounseling') ? ' has-error' : '' }}" style="margin-top:10px">
                                                {!! Form::label('areaOfCounseling','Which area would you need counseling?:',['class'=>'form-label']) !!}
                                                {!! Form::select('areaOfCounseling',$areaOfCounseling->prepend('Choose...',''),null,['class'=>'form-control',"id"=>"counselingArea"]) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                <button type="submit" id="btn-save" class="btn btn-success">Save Changes</button>
                            </div>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>

                <!-- Tranfer In Modal -->
                <div class="modal fade" id="transferInModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" >Transfer In</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="box box-widget">
                                    <div class="box-header with-border">
                                        <p>Add an Individual to this Batch<span style="color:red">&nbsp;*Individual must be registered already</span></p>
                                    </div>
                                    <!-- /.box-header -->
                                    <div class="box-body">
                                        <form action="{{route('batchregistration.includeCamper',[$chapter_details->batch_no])}}" method="post">
                                            {{csrf_field()}} {{method_field('PUT')}}
                                            <input type="hidden" name="batch_no" value="{{$chapter_details->batch_no}}">
                                            <div class="form-group row">
                                                <div class="col-md-6" style="margin-top:15px">
                                                    <label for="camper_id" class="required">Camper ID</label>
                                                    <input type="text" class="form-control" required name="camper_id" id="camper_id" placeholder="ACM 0000" autocomplete="off"/>
                                                </div>
                                                <div class="col-md-6" style="margin-top:15px">
                                                    <label for="token" class="required">Camper Token</label>
                                                    <input type="text" class="form-control token-field" required name="token" placeholder="100-001" autocomplete="off">
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-info">Include Camper</button>
                                        </form>
                                    </div>
                                    <!-- /.box-body -->
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Transfer Out Modal -->
                <div class="modal fade" id="transferOutModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Transfer Out</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="box box-widget">
                                    <div class="box-header with-border">
                                        Remove a Member from this Batch
                                    </div>
                                    <!-- /.box-header -->
                                    <div class="box-body">
                                        <form action="{{route('batchregistration.excludeCamper',[$chapter_details->batch_no])}}" method="post">
                                            {{csrf_field()}} {{method_field('PUT')}}
                                            <input type="hidden" name="batch_no" value="{{$chapter_details->batch_no}}">
                                            <div class="form-group row">
                                                <div class="col-md-6" style="margin-top:15px">
                                                    <label for="camper_id" class="required">Camper ID</label>
                                                    <input type="text" class="form-control" required name="camper_id" id="camper_id" placeholder="ACM 0000" autocomplete="off"/>
                                                </div>
                                                <div class="col-md-6" style="margin-top:15px">
                                                    <label for="phone" class="required">Camper Mobile Number</label>
                                                    <input type="text" class="form-control" required name="phone" placeholder="024500000" autocomplete="off">
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-info">Exclude Camper</button>
                                        </form>
                                    </div>
                                    <!-- /.box-body -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="onlinePaymentModal" tabindex="-1" aria-labelledby="onlinePaymentModal" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form role="form" method="POST" action="{{ route('payment.makepayment') }}">
                                {{ csrf_field() }}
                                <div class="modal-body">
                                {{--Online Payment form--}}

                                    <div class="row">
                                        {{ csrf_field() }}
                                        <div class="col-md-6 mb-3">
                                            <label for="transaction_no" class="required">Payment Reference No.</label>
                                            <input type="text" required class="form-control" name="transaction_no" value="{{$payment_ref}}">
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="amount" class="required">Amount Paid</label>
                                            <input type="text" class="form-control" required name="amount" id="amount" placeholder="Amount here..."/>
                                            <input type="hidden" required name="amount_left" value="{{$total_fee - $received_online_payments }}"/>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label></label>

                                        </div>
                                    </div>


                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success">Pay</button>
                                <button type="button" class="btn btn-secondary" >Close</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('footerscripts')
    <script src="{{ asset('plugins/icheck/check-file.js') }}"></script>

    <script src="{{asset('js/jquery-ui.min.js')}}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>

    <script src="{{asset('js/jquery.dataTables.min.js')}}"></script>
    {{--<script src="{{asset('js/bootstrap-switch.min.js')}}"></script>--}}
    <script>

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function(){

            // showAlert("Information","This is a simple text","info");

            $('.memberCheckAll').prop('checked', false); // Unchecks it

            // showFee();
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

                var selectedrowactual = $(this).parents('tr');

                var data = table.row( $(this).parents('tr') ).data();
                var other_details =  data[9];
                var details_array = JSON.parse(other_details);
                var full_name = details_array["firstname"]+" "+details_array["surname"];
                var confirmdelete = confirm('Are you sure you want to DELETE '+full_name+' from list?');

                if(confirmdelete){

                    // console.table(details_array);

                    $('#camperid').val(details_array["reg_id"]);
                    $('#batch_no').val(details_array["batch_no"]);

                    token = $("input[name='_token']").val(); // get csrf field.

                    var formData = {
                        _token: token,
                        camperid: $('#camperid').val(),
                        batch_no: $('#batch_no').val()}
//                alert(JSON.stringify(formData));
//                return;
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        }
                    })

                    $.ajax({
                        type: 'post',
                        url: "<?php echo url('chaptermemberdelete');?>",
                        data: JSON.stringify(formData),
                        dataType: 'json',
                        contentType: 'application/json; charset=utf-8',
                        success: function (data) {
                            // console.log(JSON.stringify(data));
                            table.row(selectedrowactual).remove().draw();
                            showAlert("Success","Chapter member deleted successfully!","success");

                        },
                        error: function (data) {
                            showAlert("Info","Sorry we had challenges deleting member!","info");

                            // console.log('Error:', JSON.stringify(data));
                        }
                    });

//                    table.row( $(this).parents('tr') ).remove().draw();
                }
                else return;
            });

            //Update camper data in table list
            $('#dtrows tbody').on('click','.form-edit',function(e){
                //get selected row data

                $('#camper-form').trigger("reset");

                selectedrow = table.row( $(this).parents('tr') ).data();
                selectedrowactual="";
                selectedrowactual = $(this).parents('tr');
                var other_details =  selectedrow[9];

                // console.log(other_details);

                //Convert | delimeter separated string to array
                // var details_array = other_details.split('|');
                var details_array = JSON.parse(other_details);

                // console.table(details_array);

                $('#firstname').val(details_array["firstname"]);
                $('#surname').val(details_array["surname"]);

                $('#datepicker').val(details_array["olddob"]);
                $('#localassembly').val(details_array["local_assembly"]);
                $('#permaddress').val(details_array["permanent_address"]);
                $('#telephone').val(details_array["telephone"]);
                $('#email').val(details_array["email"]);
                $('#businessaddress').val(details_array["business_address"]);
                $('#profession').val(details_array["profession"]);
                $('#camperid').val(details_array["reg_id"]);
                $('#batch_no').val(details_array["batch_no"]);

                $('#gender option').filter(function() {return ($(this).text() == selectedrow[3]);}).prop('selected', true);
                $('#campercat option').filter(function() {return ($(this).text() == selectedrow[4]);}).prop('selected', true);
                $('#campfee option').filter(function() {return ($(this).val() == details_array["campfee_id"]);}).prop('selected', true);
                $('#agdlang option').filter(function() {return ($(this).text() == selectedrow[6]);}).prop('selected', true);
                $('#maritalstatus option').filter(function() {return ($(this).text() == details_array["marital_status"]);}).prop('selected', true);
                $('#officechurch option').filter(function() {return ($(this).text() == details_array["officechurch"]);}).prop('selected', true);
                $('#agdleader option').filter(function() {return ($(this).text() == details_array["agd_leader"]);}).prop('selected', true);

                $('#agdlang option').filter(function() {return ($(this).text() == selectedrow[7]);}).prop('selected', true);

                $('#needCounseling option').filter(function() {return ($(this).text() == details_array["need_counseling"]);}).prop('selected', true);
                $('#counselingArea option').filter(function() {return ($(this).text() == details_array["counseling_area"]);}).prop('selected', true);
//                alert(selectedrow[7]);
                $('#myModalLabel').html('Edit: '+details_array["reg_id"]+' : '+details_array["firstname"]+' '+details_array["surname"]);

                $("input[name='entrytype']").val(2);
                $('#myModal').modal('show');

                // $("#campercat").trigger("change");
                // console.table(selectedrow[5].trim());
                // triggerChangeEvent().then(res=>{
                    // alert("we done");


                // });
                })


            $('#addcamper').click(function () {
                $('#camper-form').trigger("reset");

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
                    specialaccom_id: $('#speAcc').val(),
                    agdlang_id: $('#agdlang').val(),
                    agdleader_id: $('#agdleader').val(),
                    needcounseling_id: $('#needCounseling').val(),
                    counselingarea_id: $('#counselingArea').val(),
                }
//                console.log("posted data : "+JSON.stringify(formData));
                //used to determine the http verb to use [add=POST], [update=PUT]
//                var state = $('#btn-save').val();
                $.ajax({
                    type: 'post',
                    url: "<?php echo url('chaptermemberedit');?>",
                    data: formData,
                    dataType: 'json',
                    success: function (data) {
                        // console.log("Returned data from server "+JSON.stringify(data));
//                      //Delete if the form is an update form
                        if((formtype == 2) && (data['mcode'] == 1))
                        {
                            table.row(selectedrowactual).remove().draw();
                        }


                        if(data['mcode'] == 1 ){

                            //Create or Update was successful
                            var registrant = data['data'];

//                        console.log("Returned data from server "+JSON.stringify(data));

                            var rowNode = table
                                .row.add( [ registrant['firstname'], registrant['surname'], registrant['olddob'],registrant['gender'],registrant['camper'],registrant['Applicable_Camp_Fee'],
                                    registrant['Type_of_Special_Accomodation'],registrant['AGD_Language'],
                                    '<a href="#" class="btn-warning btn-sm form-edit" style="padding:5px;width:auto;">Edit</a><a href="#" class="btn-danger row-delete" style="padding:3px;width:auto;margin:0" >Delete</a>',
                                    ''+registrant['marital_status']+'|'+registrant['nationality']+''
                                ]).draw().node();

                            $( rowNode ).css( 'color', 'blue' );

                            $('#camper-form')[0].reset();

                            var message="";
                            if(formtype == 2){
                                message= "Member update was succesful!";
                            }
                            else{
                                message= "Member added succesfully!";
                            }
                            showAlert("Success",message,"success");
                            // swal({
                            //     title:"Success",
                            //     text:message,
                            //     type:"success"
                            // });

                            $('#myModal').modal('hide');
//                            location.reload(true);
                        }
                        else if(data['mcode'] == 2){
//                            console.log(" in info "+JSON.stringify(data));
                            showAlert("Info",data['message'],"info");
                        }
                        else if(data['mcode'] == -1){

//                            console.log(" in info "+JSON.stringify(data));
//                            showAlert("Info","Validation issues. Be sure all required fields are filled!","info");
                            showAlert("Warning",data['message'],"warning");
                        }
                        else if(data['mcode'] == -10){

//                            console.log(" in info "+JSON.stringify(data));
//                            showAlert("Info","Validation issues. Be sure all required fields are filled!","info");
                            showAlert("Validation Errors",data['message'],"error");
                        }
                    },
                    error: function (data) {
//                        console.log("error data: "+JSON.stringify(data));
                        swal({
                            title:"Error",
                            text:"Sorry some error occured. Be sure all required fields are filled! "+data['message'],
                            type:"error"
                        });
//                        console.log('Error:', JSON.stringify(data));
                    }
                });
            });

            //Online payment
            $("#btn-online-payment").click(function(e){
                token = $("input[name='_token']").val(); // get csrf field.

                e.preventDefault();
                var formData = {
                    _token: token,
                    batch_no: $('#batch_no').val(),
                    amount: $('#amount').val(),
                }

//                console.log(JSON.stringify(formData));

                $.ajax({
                    type: "POST",
                    url: "{{route('payment.makepayment')}}",
                    data: formData,
//                    contentType: "application/json; charset=utf-8",
//                    dataType: 'json',
                    success: function (data) {
                        console.log(JSON.stringify(data));
                    },
                    error: function (data) {
                        console.log(JSON.stringify(data));
                    }
                });
            })

            $(function() {
                $( ".datepicker" ).datepicker({changeMonth: true,changeYear: true,showButtonPanel: true,yearRange: "-60:+2",dateFormat: "yy-mm-dd"});
            });

            $("#telephone").keypress(function (event) { return isNumberKey(event) });
            $("#ambassadorphone").keypress(function (event) { return isNumberKey(event) });
            $("#amount").keypress(function (event) { return isNumber(event) });
            //function to check if value entered is numeric
            function isNumberKey(evt) { var charCode = (evt.which) ? evt.which : event.keyCode; if (charCode > 31 && (charCode < 48 || charCode > 57)) { return false; } return true; }
            function isNumber(evt) { var charCode = (evt.which) ? evt.which : event.keyCode; if (charCode != 45 && (charCode != 46 || $(this).val().indexOf('.') != -1) && (charCode < 48 || charCode > 57)) return false; return true; }
            //        })
            $( function() {
                var profs = ({!! json_encode($profession) !!});

                $("#profession").autocomplete({
                    source: profs
                });

                //get chapter details into js variable
                var chapter_details = ({!! json_encode($chapter_details) !!});
//                alert(JSON.stringify(chapter_details));
                //passed the area into a hidden field to get rid of \r coming with area name
                $('#chapter-area option').filter(function() {return ($(this).text() == $('#chapterarea').val());}).prop('selected', true);
                $('#chapter-region option').filter(function() {return ($(this).text() == chapter_details['region']);}).prop('selected', true);

            } );

            //Flat red color scheme for iCheck
            $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
                checkboxClass: 'icheckbox_flat-green',
                radioClass   : 'iradio_flat-green'
            })
            $('#dtrows-paid').DataTable({});

            var non_paid_members = $('#dtrows-nonpaid').DataTable({});

            $("#memberCheckAll").click(function () {
                var cols = non_paid_members.column(8).nodes();
                state = this.checked;
                for (var i = 0; i < cols.length; i += 1) {
                    cols[i].querySelector("input[type='checkbox']").checked = state;
                }
            });
            $('#paymentform').on('submit', function(e){
                var form = this;

                // Encode a set of form elements from all pages as an array of names and values
                var params = non_paid_members.$('input,select,textarea').serializeArray();

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

            $('.content').on('click','#calcBatchAmount',function(e){
                var totalAmount=0;
                // var specialAccom = 0;

//                var selectedRows = non_paid_members.$('input:checked');
//                var selectedRows = non_paid_members.columns().selected();
//                var selectedRows = $( non_paid_members.$('input[type="checkbox"]').prop("checked", true).map(function () {
//                    return $(this).closest('tr');
//                } ) );

                $(non_paid_members.$('input[type="checkbox"]').map(function () {
                    if($(this).closest('tr').find('input[type="checkbox"]').is(':checked')){
                        var rowc = non_paid_members.row($(this).closest('tr')).data();

                        // console.table(rowc);

                        // totalAmount= totalAmount+parseInt(((rowc[6].substring(4,10))));
                        totalAmount= totalAmount+parseInt(rowc[6]);

                    }

//                    return rowc;
                } ) );

                showAlert("Total Amount","You'll make a total payment of: GHC "+totalAmount,"info");
                // swal({
                //     title:"Total Amount",
                //     text:"You'll make a total payment of : GH₵ "+totalAmount,
                //     type:"info"
                // });
//                alert();
            });

            $('.token-field').on('keyup',function () {
                if(($(this).val().length) == 3){
                    $(this).val($(this).val() + '-');
                }
            })

            $('#campercat').on('change',function () {
                // alert("I was triggered");
                var id = $(this).val();
                if($('#campercat')[0].selectedIndex > 0){
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
                }
            });

            // $("#campercat").trigger("change");

            // triggerChangeEvent().then(res=>{
            //     alert("we done");
            // })
            //
            // function triggerChangeEvent() {
            //     return new Promise(function (resolve) {
            //         $("#campercat").on("change", function () {
            //             resolve(); // Resolve the Promise when the "change" event completes
            //         }).trigger("change");
            //     });
            // }
        });

    </script>
@endsection