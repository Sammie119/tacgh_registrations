@extends('admin.layout.template')
@section('afterAllCss')
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('css/AdminLTE.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/iCheck/all.css') }}">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
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
    <section class="content-wrapper">
        <section class="content-header">
            <h1>Edit {{$registrant->surname.' '.$registrant->firstname.' ('.$registrant->reg_id.')'}}</h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Edit Camper</li>
            </ol>
        </section>

        <div class="content">
            <div class="row">
                <div class="box box-solid">
                    <div id="transparent-dar">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-10 col-md-offset-1">
                                    <div class="box-body text-color" style="text-align: left;border:1px solid #888888;box-shadow: 10px 5px 10px 5px #888888;">
                                        {{--<form role="form" method="POST" action="{{ route('registrant.store') }}">--}}
                                            {!! Form::model($registrant,['method'=>'PATCH','route'=>['registrant.update',$registrant],'class'=>'form-horizontal']) !!}
                                            {{ csrf_field() }}
                                            {{--<h4 class="sub-header" style="margin-bottom: 20px;text-align: center;">Register</h4>--}}
                                            <div class="form-group">
                                                <div class="col-md-6 {{ $errors->has('surname') ? ' has-error' : '' }}" style="margin-top:10px">
                                                    {!! Form::label('surname','Surname',['class'=>'form-label required']) !!}
                                                    {!! Form::text('surname',null,['class'=>'form-control']) !!}
                                                </div>
                                                <div class="col-md-6 {{ $errors->has('firstname') ? ' has-error' : '' }}" style="margin-top:10px">
                                                    {!! Form::label('firstname','Other names:',['class'=>'form-label required']) !!}
                                                    {!! Form::text('firstname',null,['class'=>'form-control']) !!}
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-md-6 {{ $errors->has('gender_id') ? ' has-error' : '' }}" style="margin-top:10px">
                                                    {!! Form::label('gender_id','Gender:',['class'=>'form-label']) !!}
                                                    {!! Form::select('gender_id',$gender->prepend('Choose...',''),null,['class'=>'form-control']) !!}
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
                                                        {!! Form::select('foreigndel_id',$yesno->prepend('Choose...',''),null,['class'=>'form-control']) !!}
                                                    </div>
                                                </div></div>
                                            <div class="form-group">
                                                <div class="col-md-6 {{ $errors->has('maritalstatus') ? ' has-error' : '' }}" style="margin-top:10px">
                                                    {!! Form::label('maritalstatus','Marital Status:',['class'=>'form-label required']) !!}
                                                    {!! Form::select('maritalstatus_id',$maritalstatus->prepend('Choose...',''),null,['class'=>'form-control']) !!}
                                                </div>
                                                <div class="col-md-6 {{ $errors->has('chapter') ? ' has-error' : '' }}" style="margin-top:10px">
                                                    {!! Form::label('chapter','Chapter:',['class'=>'form-label']) !!}
                                                    {!! Form::text('chapter',null,['class'=>'form-control']) !!}
                                                </div>
                                            </div>
                                            <div class="row-fit"><div class="form-group">
                                                    <div class="col-md-6 {{ $errors->has('localassembly') ? ' has-error' : '' }}" style="margin-top:10px">
                                                        {!! Form::label('localassembly','Local Assembly:',['class'=>'form-label required']) !!}
                                                        {!! Form::text('localassembly',null,['class'=>'form-control']) !!}
                                                    </div>
                                                    {{--<div class="col-md-6 {{ $errors->has('denomination') ? ' has-error' : '' }}" style="margin-top:9px">--}}
                                                        {{--{!! Form::label('denomination','Denomination:',['class'=>'form-label required']) !!}--}}
                                                        {{--<label style="margin-left: 10px; margin-right: 5px;">--}}
                                                            {{--<input type="radio" value="1" class="flat-red" name="denomination"> The Apostolic Church-Ghana--}}
                                                        {{--</label>--}}
                                                        {{--<label style="margin-top: 0px; margin-right: 5px;">--}}
                                                            {{--<input type="radio" class="flat-red" value="2" name="denomination"> Other--}}
                                                        {{--</label><input type="text" name="othernationality" class="form-control" style="float:right"/>--}}

                                                    {{--</div>--}}

                                                    <div class="col-md-6 {{ $errors->has('denomination') ? ' has-error' : '' }}" style="margin-top:9px">
                                                        {!! Form::label('denomination','Denomination:',['class'=>'form-label required']) !!}
                                                        <label style="margin-left: 10px; margin-right: 5px;">
                                                            <input type="radio" value="The Apostolic Church-Ghana" class="flat-red" name="denomination" {{ (isset($registrant->denomination)) && ($registrant->denomination== 'The Apostolic Church-Ghana') ? 'checked' : '' }}> The Apostolic Church-Ghana
                                                        </label>
                                                        <label style="margin-top: 0px; margin-right: 5px;">
                                                            <input type="radio" class="flat-red" value="2" name="denomination" {{ (isset($registrant->denomination)) && ($registrant->denomination != 'The Apostolic Church-Ghana') ? 'checked' : '' }}> Other
                                                        </label><input type="text" name="otherdenomination" class="form-control" style="float:right" value="{{(isset($registrant->denomination)&& ($registrant->denomination != "The Apostolic Church-Ghana"))?$registrant->denomination:""}}"/>

                                                    </div>
                                                </div></div>
                                            <div class="form-group">
                                                <div class="col-md-6 {{ $errors->has('area') ? ' has-error' : '' }}" style="margin-top:10px">
                                                    {!! Form::label('area','Area:',['class'=>'form-label']) !!}
                                                    {!! Form::select('area_id',$area->prepend('Choose...',''),null,['class'=>'form-control  select2']) !!}
                                                </div>
                                                <div class="col-md-6 {{ $errors->has('region_id') ? ' has-error' : '' }}" style="margin-top:10px">
                                                    {!! Form::label('region_id','Region:',['class'=>'form-label']) !!}
                                                    {!! Form::select('region_id',$region->prepend('Choose...',''),null,['class'=>'form-control']) !!}
                                                </div>
                                            </div>
                                            <div class="row-fit"><div class="form-group">
                                                    <div class="col-md-6 {{ $errors->has('permaddress') ? ' has-error' : '' }}" style="margin-top:10px">
                                                        {!! Form::label('permaddress','Permanent Address:',['class'=>'form-label']) !!}
                                                        {!! Form::textarea('permaddress',null,['class'=>'form-control','rows'=>3,'cols'=>10]) !!}
                                                    </div>
                                                    <div class="col-md-6 {{ $errors->has('telephone') ? ' has-error' : '' }}" style="margin-top:10px">
                                                        {!! Form::label('telephone','Mobile Number:',['class'=>'form-label required']) !!}
                                                        {!! Form::text('telephone',null,['class'=>'form-control','id'=>'telephone']) !!}
                                                    </div>
                                                </div></div>
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
                                                <div class="col-md-6 {{ $errors->has('officechurch_id') ? ' has-error' : '' }}" style="margin-top:10px">
                                                    {!! Form::label('officechurch_id','Office Held in Church:',['class'=>'form-label required']) !!}
                                                    {!! Form::select('officechurch_id',$OfficeHeldInChurch->prepend('Choose...',''),null,['class'=>'form-control']) !!}
                                                </div>
                                                <div class="col-md-6 {{ $errors->has('profession') ? ' has-error' : '' }}" style="margin-top:10px">
                                                    {!! Form::label('profession','Profession:',['class'=>'form-label']) !!}
                                                    {!! Form::text('profession',null,['class'=>'form-control','id'=>'profession']) !!}
                                                </div>
                                            </div>
                                            <div class="row-fit"><div class="form-group">
                                                    <div class="col-md-6 {{ $errors->has('businessadress') ? ' has-error' : '' }}" style="margin-top:10px">
                                                        {!! Form::label('businessaddress','Business Address:',['class'=>'form-label']) !!}
                                                        {!! Form::textarea('businessaddress',null,['class'=>'form-control','rows'=>3,'cols'=>10]) !!}
                                                    </div>
                                                    <div class="col-md-6 {{ $errors->has('studentaddress') ? ' has-error' : '' }}" style="margin-top:10px">
                                                        {!! Form::label('studentaddress','If Student, state school and address:',['class'=>'form-label']) !!}
                                                        <span style="font-size:x-small;">(NB: Student refers to undergrads and below. Address Example: Mfantsipim, P. O. Box 101, Cape Coast)</span>
                                                        {!! Form::textarea('studentaddress',null,['class'=>'form-control','rows'=>2,'cols'=>10]) !!}
                                                    </div>
                                                </div></div>
                                            <div class="form-group">
                                                <div class="col-md-6 {{ $errors->has('campercat_id') ? ' has-error' : '' }}" style="margin-top:10px">
                                                    {!! Form::label('campercat_id','Camper:',['class'=>'form-label required']) !!}
                                                    @if(($registrant->confirmedpayment==0) || (\Auth()->user()->hasAnyRole(['SuperAdmin','Finance Officer'])))
                                                    {!! Form::select('campercat_id',$Camper->prepend('Choose...',''),null,['class'=>'form-control']) !!}
                                                    @else
                                                    {!! Form::select('campercat_id',$Camper->prepend('Choose...',''),null,['class'=>'form-control','readonly'=>'readonly']) !!}
                                                        @endif
                                                </div>
                                                <div class="col-md-6 {{ $errors->has('agdlang_id') ? ' has-error' : '' }}" style="margin-top:10px">
                                                    {!! Form::label('agdlang_id','Action Group Discussion (Preferred Language):',['class'=>'form-label required']) !!}
                                                    {!! Form::select('agdlang_id',$AGDLanguage->prepend('Choose...',''),null,['class'=>'form-control']) !!}
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-md-6 {{ $errors->has('agdleader_id') ? ' has-error' : '' }}" style="margin-top:10px">
                                                    {!! Form::label('agdleader_id','Are you an AGD Leader?:',['class'=>'form-label']) !!}
                                                    {!! Form::select('agdleader_id',$yesno->prepend('Choose...',''),null,['class'=>'form-control']) !!}
                                                </div>
                                                <div class="col-md-6 {{ $errors->has('ambassadorname') ? ' has-error' : '' }}" style="margin-top:10px">
                                                    {!! Form::label('ambassadorname','Name of Ambassador/Leader:',['class'=>'form-label']) !!}
                                                    {!! Form::text('ambassadorname',null,['class'=>'form-control']) !!}
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-md-6 {{ $errors->has('ambassadorphone') ? ' has-error' : '' }}" style="margin-top:10px">
                                                    {!! Form::label('ambassadorphone','Contact of Ambassador/Leader:',['class'=>'form-label']) !!}
                                                    {!! Form::text('ambassadorphone',null,['class'=>'form-control','id'=>'ambassadorphone']) !!}
                                                </div>
                                                <div class="col-md-6 {{ $errors->has('campfee_id') ? ' has-error' : '' }}" style="margin-top:10px">
                                                    {!! Form::label('campfee_id','Select Applicable Camp Fee:',['class'=>'form-label required']) !!}
                                                    @if(($registrant->confirmedpayment==0) || (\Auth()->user()->hasAnyRole(['SuperAdmin','Finance Officer'])))
                                                    {!! Form::select('campfee_id',$CampApplicableFee->prepend('Choose...',''),null,['class'=>'form-control','onchange'=>'showFee()']) !!}
                                                    @else
                                                    {!! Form::select('campfee_id',$CampApplicableFee->prepend('Choose...',''),null,['class'=>'form-control','onchange'=>'showFee()','readonly'=>'readonly']) !!}
                                                        @endif
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-md-6 {{ $errors->has('specialaccom_id') ? ' has-error' : '' }}" style="margin-top:10px">
                                                    {!! Form::label('specialaccom_id','Select the type of Special Accommodation:',['class'=>'form-label']) !!}
                                                    @if($registrant->confirmedpayment==0)
                                                    {!! Form::select('specialaccom_id',$SpecialAccomodation->prepend('Choose...',''),null,['class'=>'form-control','id'=>'speAcc','disabled'=>'disabled']) !!}
                                                    @else
                                                    {!! Form::select('specialaccom_id',$SpecialAccomodation->prepend('Choose...',''),null,['class'=>'form-control','id'=>'speAcc','disabled'=>'disabled']) !!}
                                                        @endif
                                                </div>

                                            </div>

                                        <div class="form-group">
                                            <center>
                                                <button type="submit" class="btn btn-primary btn-label-blue" style="margin-top:15px">
                                                    Update Details
                                                </button>
                                                <a href="{{url()->previous()}}" class="btn btn-flat btn-default"><i class="fa fa-angle-left" aria-hidden="true" style="margin-right:5px"></i> Back</a>
                                            </center>
                                        </div>
                                        </form>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div></div>
    </section>
@endsection

@section('afterMainScripts')
    <script src="{{asset('plugins/jQuery/jquery-2.2.3.min.js')}}"></script>
    {{--<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>--}}
    <script src="{{asset('plugins/jQueryUI/jquery-ui.min.js')}}"></script>
    <script>

        function showFee() {

            // var campfeeid = $('select#campfee').val();
            var campfeeid = document.getElementById('campfee_id').value;
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

//        $('input:radio[name="nationality"]').change(function () {
//            if ($(this).val() == 1) {
//                $('#othernationality').attr('disabled','disabled');
//            } else {
//                $('#othernationality').removeAttr('disabled','disabled');
//            }
//        });
    </script>
    <script>
        $(function () {

            $(".select2").select2();

        });
    </script>
    <script>
        $(document).ready(function(){
            showFee();
            $(function() {
                $("#datepicker").datepicker({changeMonth: true,changeYear: true,showButtonPanel: true,yearRange: "-70:-2 ",dateFormat: "yy-mm-dd"});
            });
//                $( "#datepicker" ).mask("99/99/9999").datepicker({changeMonth: true,changeYear: true,showButtonPanel: true,yearRange: "-70:-2 ",dateFormat: "yy-mm-dd"});
        });
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

    </script>
@endsection