@extends('layouts.app')
@section('beforecss')
    {{--    <link rel="stylesheet" href="{{ asset('css/AdminLTE.min.css') }}">--}}
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <link rel="stylesheet" href="{{asset('css/jquery-ui.min.css')}}">
    <link rel="stylesheet" href="{{ asset('css/AdminLTE.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/iCheck/all.css') }}">
    <style>
        .required::after{
            content: "*";
            color:red;
        }
        .padded{padding:25px;}
    </style>
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('plugins/select2/select2.min.css') }}">
@endsection

@section('content')
    {{--<section class="content-wrapper">--}}
        <div class="container">
            <div style="text-align: center; margin-bottom: 30px">
            <img src="{{asset('img/aposa-main_edit.png')}}" style="text-align: center;max-width:200px;"/>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="main-box">
                    <div class="text-center">
                        <h4 class="sub-header" style="color:#777">Welcome back {{$registrant->surname.' '.$registrant->firstname.' ('.$registrant->reg_id.')'}}</h4>
                    </div>
                </div>
            </div>
        </div>

        {{--<div class="content">--}}
            {{--<div class="row">--}}
                {{--<div class="box box-solid">--}}
                    <div id="transparent-dar">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-10 col-md-offset-1">
                                    {{--<div class="box-body text-color" style="text-align: left;border:1px solid #888888;box-shadow: 10px 5px 10px 5px #888888;">--}}
                                        {{--<form role="form" method="POST" action="{{ route('registrant.store') }}">--}}
                                        {{--{!! Form::model($registrant,['method'=>'PATCH','route'=>['registrant.update',$registrant],'class'=>'form-horizontal']) !!}--}}
                                    <div class="box box-solid" style="border-radius: 0px">
                                        <div class="box-body text-color" style="text-align: left;">
                                            {{--<form role="form" method="POST" action="{{ route('registrant.store') }}">--}}
                                            <form role="form" method="POST" action="{{ route('registrant.store') }}">
                                        {{ csrf_field() }}
                                        {{--<h4 class="sub-header" style="margin-bottom: 20px;text-align: center;">Register</h4>--}}
                                        <div class="form-group">
                                            <div class="col-md-6 {{ $errors->has('surname') ? ' has-error' : '' }}" style="margin-top:10px">
                                                {!! Form::label('surname','Surname',['class'=>'form-label required']) !!}
                                                {!! Form::text('surname',$registrant->surname,['class'=>'form-control']) !!}
                                            </div>
                                            <div class="col-md-6 {{ $errors->has('firstname') ? ' has-error' : '' }}" style="margin-top:10px">
                                                {!! Form::label('firstname','Other names:',['class'=>'form-label required']) !!}
                                                {!! Form::text('firstname',$registrant->firstname,['class'=>'form-control']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-6 {{ $errors->has('gender') ? ' has-error' : '' }}" style="margin-top:10px">
                                                {!! Form::label('gender','Gender:',['class'=>'form-label']) !!}
                                                {!! Form::select('gender',$gender->prepend('Choose...',''),$registrant->gender_id,['class'=>'form-control']) !!}
                                            </div>
                                            <div class="col-md-6 {{ $errors->has('dob') ? ' has-error' : '' }}" style="margin-top:10px">
                                                {!! Form::label('dob','Date of Birth:',['class'=>'form-label required']) !!}
                                                {!! Form::text('dob',$registrant->getOriginal('dob'),['class'=>'form-control required','id'=>'datepicker']) !!}
                                            </div>
                                        </div>
                                        <div class="row-fit"><div class="form-group">
                                                <div class="col-md-6 {{ $errors->has('nationality') ? ' has-error' : '' }}" style="margin-top:9px">
                                                    {!! Form::label('nationality','Nationality:',['class'=>'form-label required']) !!}
                                                    <label style="margin-left: 10px; margin-right: 5px;">
                                                        <input type="radio" value="Ghanaian" id="ghana" class="flat-red" name="nationality" {{(isset($registrant->nationality)&& ($registrant->nationality == "Ghanaian"))?"checked":""}}/> Ghanaian
                                                    </label>
                                                    <label style="margin-top: 0px; margin-right: 5px;">
                                                        <input type="radio" class="flat-red" id="others" value="2" name="nationality" {{(isset($registrant->nationality)&& ($registrant->nationality != "Ghanaian"))?"checked":""}}> Other
                                                    </label><input type="text" id="othernationality" name="othernationality" class="form-control" style="float:right" value="{{(isset($registrant->nationality)&& ($registrant->nationality != "Ghanaian"))?$registrant->nationality:""}}"/>

                                                </div>
                                                <div class="col-md-6 {{ $errors->has('foreigndel') ? ' has-error' : '' }}" style="margin-top:10px">
                                                    {!! Form::label('foreigndel','Are you a foreign delegate?:',['class'=>'form-label required']) !!}
                                                    {!! Form::select('foreigndel',$yesno->prepend('Choose...',''),$registrant->foreigndel_id,['class'=>'form-control']) !!}
                                                </div>
                                            </div></div>
                                        <div class="form-group">
                                            <div class="col-md-6 {{ $errors->has('maritalstatus') ? ' has-error' : '' }}" style="margin-top:10px">
                                                {!! Form::label('maritalstatus','Marital Status:',['class'=>'form-label required']) !!}
                                                {!! Form::select('maritalstatus',$maritalstatus->prepend('Choose...',''),$registrant->maritalstatus_id,['class'=>'form-control']) !!}
                                            </div>
                                            <div class="col-md-6 {{ $errors->has('chapter') ? ' has-error' : '' }}" style="margin-top:10px">
                                                {!! Form::label('chapter','Chapter:',['class'=>'form-label']) !!}
                                                {!! Form::text('chapter',$registrant->chapter,['class'=>'form-control']) !!}
                                            </div>
                                        </div>

                                            <div class="row row-fit"><div class="form-group">
                                                    <div class="col-md-6 {{ $errors->has('localassembly') ? ' has-error' : '' }}" style="margin-top:10px">
                                                        {!! Form::label('localassembly','Local Assembly:',['class'=>'form-label required']) !!}
                                                        {!! Form::text('localassembly',$registrant->localassembly,['class'=>'form-control']) !!}
                                                    </div>
                                                    <div class="col-md-6 {{ $errors->has('denomination') ? ' has-error' : '' }}" style="margin-top:9px">
                                                        {!! Form::label('denomination','Denomination:',['class'=>'form-label required']) !!}
                                                        <label style="margin-left: 10px; margin-right: 5px;">
                                                            <input type="radio" value="The Apostolic Church-Ghana" class="flat-red" name="denomination" {{ ($registrant->denomination == 'The Apostolic Church-Ghana') ? 'checked' : '' }}> The Apostolic Church-Ghana
                                                        </label>
                                                        <label style="margin-top: 0px; margin-right: 5px;">
                                                            <input type="radio" class="flat-red" value="2" name="denomination" {{ ($registrant->denomination == '2') ? 'checked' : '' }}> Other
                                                        </label><input type="text" name="otherdenomination" class="form-control" style="float:right" value="{{ $registrant->denomination}}"/>

                                                    </div>
                                                </div></div>
                                        <div class="form-group">
                                            <div class="col-md-6 {{ $errors->has('area') ? ' has-error' : '' }}" style="margin-top:10px">
                                                {!! Form::label('area','Area:',['class'=>'form-label']) !!}
                                                {!! Form::select('area',$area->prepend('Choose...',''),$registrant->area_id,['class'=>'form-control  select2']) !!}
                                            </div>
                                            <div class="col-md-6 {{ $errors->has('region') ? ' has-error' : '' }}" style="margin-top:10px">
                                                {!! Form::label('region','Region:',['class'=>'form-label']) !!}
                                                {!! Form::select('region',$region->prepend('Choose...',''),$registrant->region_id,['class'=>'form-control']) !!}
                                            </div>
                                        </div>
                                        <div class="row-fit"><div class="form-group">
                                                <div class="col-md-6 {{ $errors->has('permaddress') ? ' has-error' : '' }}" style="margin-top:10px">
                                                    {!! Form::label('permaddress','Permanent Address:',['class'=>'form-label']) !!}
                                                    {!! Form::textarea('permaddress',$registrant->permaddress,['class'=>'form-control','rows'=>3,'cols'=>10]) !!}
                                                </div>
                                                <div class="col-md-6 {{ $errors->has('telephone') ? ' has-error' : '' }}" style="margin-top:10px">
                                                    {!! Form::label('telephone','Mobile Number:',['class'=>'form-label required']) !!}
                                                    {!! Form::text('telephone',$registrant->telephone,['class'=>'form-control','id'=>'telephone']) !!}
                                                </div>
                                            </div></div>
                                        <div class="form-group">
                                            <div class="col-md-6 {{ $errors->has('email') ? ' has-error' : '' }}" style="margin-top:10px">
                                                {!! Form::label('email','Email Address:',['class'=>'form-label']) !!}
                                                {!! Form::text('email',$registrant->email,['class'=>'form-control']) !!}
                                            </div>
                                            <div class="col-md-6 {{ $errors->has('officeaposa') ? ' has-error' : '' }}" style="margin-top:10px">
                                                {!! Form::label('officeaposa','Office Held at APOSA (if any):',['class'=>'form-label']) !!}
                                                {!! Form::text('officeaposa',$registrant->officeaposa,['class'=>'form-control']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-6 {{ $errors->has('officechurch') ? ' has-error' : '' }}" style="margin-top:10px">
                                                {!! Form::label('officechurch','Office Held in Church:',['class'=>'form-label required']) !!}
                                                {!! Form::select('officechurch',$OfficeHeldInChurch->prepend('Choose...',''),$registrant->officechurch_id,['class'=>'form-control']) !!}
                                            </div>
                                            <div class="col-md-6 {{ $errors->has('profession') ? ' has-error' : '' }}" style="margin-top:10px">
                                                {!! Form::label('profession','Profession:',['class'=>'form-label']) !!}
                                                {!! Form::text('profession',$registrant->profession,['class'=>'form-control','id'=>'profession']) !!}
                                            </div>
                                        </div>
                                        <div class="row-fit"><div class="form-group">
                                                <div class="col-md-6 {{ $errors->has('businessadress') ? ' has-error' : '' }}" style="margin-top:10px">
                                                    {!! Form::label('businessaddress','Business Address:',['class'=>'form-label']) !!}
                                                    {!! Form::textarea('businessaddress',$registrant->businessaddress,['class'=>'form-control','rows'=>3,'cols'=>10]) !!}
                                                </div>
                                                <div class="col-md-6 {{ $errors->has('studentaddress') ? ' has-error' : '' }}" style="margin-top:10px">
                                                    {!! Form::label('studentaddress','If Student, state school and address:',['class'=>'form-label']) !!}
                                                    <span style="font-size:x-small;">(NB: Student refers to undergrads and below. Address Example: Mfantsipim, P. O. Box 101, Cape Coast)</span>
                                                    {!! Form::textarea('studentaddress',$registrant->studentaddress,['class'=>'form-control','rows'=>2,'cols'=>10]) !!}
                                                </div>
                                            </div></div>
                                        <div class="form-group">
                                            <div class="col-md-6 {{ $errors->has('campercat') ? ' has-error' : '' }}" style="margin-top:10px">
                                                {!! Form::label('campercat','Camper:',['class'=>'form-label required']) !!}
                                                {!! Form::select('campercat',$Camper->prepend('Choose...',''),$registrant->campercat_id,['class'=>'form-control']) !!}

                                            </div>
                                            <div class="col-md-6 {{ $errors->has('agdlang') ? ' has-error' : '' }}" style="margin-top:10px">
                                                {!! Form::label('agdlang','Action Group Discussion (Preferred Language):',['class'=>'form-label required']) !!}
                                                {!! Form::select('agdlang',$AGDLanguage->prepend('Choose...',''),$registrant->agdlang_id,['class'=>'form-control']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-6 {{ $errors->has('agdleader') ? ' has-error' : '' }}" style="margin-top:10px">
                                                {!! Form::label('agdleader','Are you an AGD Leader?:',['class'=>'form-label']) !!}
                                                {!! Form::select('agdleader',$yesno->prepend('Choose...',''),$registrant->agdleader_id,['class'=>'form-control']) !!}
                                            </div>
                                            <div class="col-md-6 {{ $errors->has('ambassadorname') ? ' has-error' : '' }}" style="margin-top:10px">
                                                {!! Form::label('ambassadorname','Name of Ambassador/Leader:',['class'=>'form-label']) !!}
                                                {!! Form::text('ambassadorname',$registrant->ambassadorname,['class'=>'form-control']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-6 {{ $errors->has('ambassadorphone') ? ' has-error' : '' }}" style="margin-top:10px">
                                                {!! Form::label('ambassadorphone','Contact of Ambassador/Leader:',['class'=>'form-label']) !!}
                                                {!! Form::text('ambassadorphone',$registrant->ambassadorphone,['class'=>'form-control','id'=>'ambassadorphone']) !!}
                                            </div>
                                            <div class="col-md-6 {{ $errors->has('campfee') ? ' has-error' : '' }}" style="margin-top:10px">
                                                {!! Form::label('campfee','Select Applicable Camp Fee:',['class'=>'form-label required']) !!}
                                                {!! Form::select('campfee',$CampApplicableFee->prepend('Choose...',''),$registrant->campfee_id,['class'=>'form-control','id'=>'campfee','onchange'=>'showFee()']) !!}

                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-6 {{ $errors->has('specialaccom') ? ' has-error' : '' }}" style="margin-top:10px">
                                                {!! Form::label('specialaccom','Select the type of Special Accommodation:',['class'=>'form-label']) !!}

                                                    {!! Form::select('specialaccom',$SpecialAccomodation->prepend('Choose...',''),$registrant->specialaccom_id,['class'=>'form-control','id'=>'speAcc','disabled'=>'disabled']) !!}
                                            </div>

                                        </div>
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <p><label style="margin-top: 10px; margin-right: 5px;" class="required">
                                                                <input type="checkbox"  name="disclaimer" class="flat-red" id="disclaimer" value="1" {{ ($registrant->disclaimer == '1') ? 'checked' : '' }}/>
                                                                <input type="hidden"  name="existing" value="1" />
                                                                I understand that my registration is not complete until I make payment.&nbsp;(Disclaimer)
                                                            </label></p>
                                                    </div>
                                                    <hr />
                                                </div>

                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <center>
                                                <button type="submit" class="btn btn-primary btn-label-blue" style="margin-top:15px">
                                                    Update Details
                                                </button>
                                                <a href="{{url()->previous()}}" class="btn btn-flat btn-default"><i class="fa fa-angle-left" aria-hidden="true" style="margin-right:5px"></i> Back</a>
                                                </center>
                                            </div>
                                        </div>
                                        </form>
                                    {{--</div>--}}
                                        </div>
                                    </div>

                                </div>
                            </div>
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            </div></div>
    </section>
        </div>
    {{--</section>--}}
@endsection

@section('footerscripts')

    <script>
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
    </script>
    <script src="{{ asset('plugins/icheck/icheck.min.js') }}"></script>
    <script src="{{ asset('plugins/select2/select2.full.min.js') }}"></script>
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
        })

        $('input:radio[name="nationality"]').change(function () {
            if ($(this).val() == 1) {
                $('#othernationality').attr('disabled','disabled');
            } else {
                $('#othernationality').removeAttr('disabled','disabled');
            }
        });
    </script>
    <script>
        $(function () {

            $(".select2").select2();

        });
    </script>
    <script>
        $(document).ready(function(){
            $(function() {
                $( "#dob" ).datepicker({changeMonth: true,changeYear: true,showButtonPanel: true,yearRange: "-70:-2 ",dateFormat: "yy-mm-dd"});
            });

            showFee();
            $(function() {
                $( "#datepicker" ).datepicker({changeMonth: true,changeYear: true,showButtonPanel: true,yearRange: "-70:-2 ",dateFormat: "yy-mm-dd"});
            });
//                $( "#datepicker" ).mask("99/99/9999").datepicker({changeMonth: true,changeYear: true,showButtonPanel: true,yearRange: "-70:-2 ",dateFormat: "yy-mm-dd"});

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
        });
    </script>
@endsection