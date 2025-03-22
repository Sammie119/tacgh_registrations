@extends('layouts.app')
@section('beforecss')
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('css/AdminLTE.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/icheck/all.css') }}">
    <style>
        .required::after{
            content: "*";
            color:red;
        }
        .padded{padding:25px;}
        label {
            font-weight: 200;
        }
    </style>
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('plugins/select2/select2.min.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

@endsection

@section('content')

    <div id="transparent-dar">
        <div class="container">
            @if(false)
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <div class="box box-solid" style="border-radius: 0px">
                            <div class="box-body text-color" style="text-align: left;">
                                <form role="form" method="POST" action="{{ route('registrant.store') }}">
                                    {{ csrf_field() }}
                                    {{--<div class="sub-header" stye="text-align:center"><h3>APOSA Campmeeting {{\Carbon\Carbon::now()->year}}</h3></div>--}}
                                    <h4 class="sub-header" style="margin-bottom: 20px;text-align: center;">Register</h4>
                                    <div class="row row-fit"><div class="form-group">
                                            <div class="col-md-6 {{ $errors->has('permaddress') ? ' has-error' : '' }}" style="margin-top:10px">
                                                {!! Form::label('permaddress','Permanent Address:',['class'=>'form-label']) !!}
                                                {!! Form::textarea('permaddress',null,['class'=>'form-control','rows'=>3,'cols'=>10]) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row row-fit"><div class="form-group">
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
                                        <div class="col-md-12">
                                            <center>
                                                <button type="submit" class="btn btn-flat btn-primary" style="margin-bottom:10px">
                                                    <i class="fa fa-check-circle-o" aria-hidden="true" style="margin-right:5px"></i> Submit Registration
                                                </button>
                                                <a href="{{route('landing')}}" class="btn btn-flat btn-default" style="margin-bottom:10px">
                                                    <i class="fa fa-angle-left" aria-hidden="true" style="margin-right:5px"></i> Back to Home</a>
                                            </center>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="form-header text-center mb-2 mt-2">
                    <a href="{{route('landing')}}"><img src="{{App::isLocal() ? asset('img/aposa-main_edit.png') : asset('public/img/aposa-main_edit.png')}}" alt="" class="sign-up-icon" style="width: 100px;"></a>
                </div>
                <div class="form-sub-header text-center">
                    <h8>{{ strtoupper(get_current_event()->name) }} REGISTRATION</h8>
                </div>
                <form role="form" method="POST" action="{{ route('registrant.store') }}">
                    {{ csrf_field() }}
                    <div class="col-md-12 mb-2">
                        <h5 class="text-uppercase">Personal Information</h5>
                    </div>
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3 {{ $errors->has('surname') ? ' has-error' : '' }}" style="margin-top:10px">
                                    {!! Form::label('surname','Surname',['class'=>'form-label required']) !!}
                                    {!! Form::text('surname',old('surname'),['class'=>'form-control','required']) !!}
                                </div>
                                <div class="col-md-3 {{ $errors->has('firstname') ? ' has-error' : '' }}" style="margin-top:10px">
                                    {!! Form::label('firstname','Other names',['class'=>'form-label required']) !!}
                                    {!! Form::text('firstname',old('firstname'),['class'=>'form-control','required']) !!}
                                </div>
                                <div class="col-md-3 {{ $errors->has('gender') ? ' has-error' : '' }}" style="margin-top:10px">
                                    {!! Form::label('gender','Gender',['class'=>'form-label required']) !!}
                                    {!! Form::select('gender',$gender->prepend('Choose...',''),null,['class'=>'form-select','required']) !!}
                                </div>
                                <div class="col-md-3 {{ $errors->has('dob') ? ' has-error' : '' }}" style="margin-top:10px">
                                    {!! Form::label('dob','Date of Birth',['class'=>'form-label required']) !!}
                                    {!! Form::text('dob',null,['class'=>'form-control','required','id'=>'datepicker','autocomplete'=>'off']) !!}
                                </div>
                                <div class="col-md-3 {{ $errors->has('maritalstatus') ? ' has-error' : '' }}" style="margin-top:10px">
                                    {!! Form::label('maritalstatus','Marital Status',['class'=>'form-label required']) !!}
                                    {!! Form::select('maritalstatus',$maritalstatus->prepend('Choose...',''),null,['class'=>'form-select','required']) !!}
                                </div>
                                <div class="col-md-3 {{ $errors->has('telephone') ? ' has-error' : '' }}" style="margin-top:10px">
                                    {!! Form::label('telephone','Mobile Number',['class'=>'form-label required']) !!}
                                    {!! Form::text('telephone',null,['class'=>'form-control','id'=>'telephone','required']) !!}
                                </div>
                                <div class="col-md-3 {{ $errors->has('email') ? ' has-error' : '' }}" style="margin-top:10px">
                                    {!! Form::label('email','Email Address',['class'=>'form-label']) !!}
                                    {!! Form::text('email',null,['class'=>'form-control']) !!}
                                </div>
                                <div class="col-md-3 {{ $errors->has('nationality') ? ' has-error' : '' }}" style="margin-top:10px">
                                    {!! Form::label('nationality','Are you a Ghanaian?',['class'=>'form-label required']) !!}
                                    <br>
                                    <label style="margin-left: 10px; margin-right: 5px;">
                                        <input type="radio" value="Ghanaian" id="ghana" class="form-check-input" name="nationality" {{ (old('nationality') == 'Ghanaian') ? 'checked' : '' }}> Ghanaian
                                    </label>
                                    <label style="margin-top: 0px; margin-right: 5px;">
                                        <input type="radio" class="form-check-input" value="2" name="nationality" {{ (old('nationality') == '2') ? 'checked' : '' }}> Other
                                    </label>
                                </div>
                                <div class="col-md-3 {{ $errors->has('otherdenomination') ? ' has-error' : '' }}" style="margin-top:10px">
                                    {!! Form::label('email','Other Nationality',['class'=>'form-label']) !!}
                                    <input type="text" name="otherdenomination" class="form-control" value="{{ (old('otherdenomination'))}}"/>
                                </div>
                                <div class="col-md-3 {{ $errors->has('profession') ? ' has-error' : '' }}" style="margin-top:10px">
                                    {!! Form::label('profession','Profession:',['class'=>'form-label']) !!}
                                    {!! Form::text('profession',null,['class'=>'form-control','id'=>'profession']) !!}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 mt-2 mb-2">
                        <h5 class="text-uppercase">Denomination Information</h5>
                    </div>
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3 {{ $errors->has('foreigndel') ? ' has-error' : '' }}" style="margin-top:10px">
                                    {!! Form::label('foreigndel','Are you a foreign delegate?',['class'=>'form-label required']) !!}
                                    {!! Form::select('foreigndel',$yesno->prepend('Choose...',''),null,['class'=>'form-select','required']) !!}
                                </div>
                                <div class="col-md-3 {{ $errors->has('denomination') ? ' has-error' : '' }}" style="margin-top:9px">
                                    {!! Form::label('denomination','Apostolic Member?',['class'=>'form-label required']) !!}
                                    <br>
                                    <label style="margin-left: 10px; margin-right: 5px;">
                                        <input type="radio" value="The Apostolic Church-Ghana" class="form-check-input" name="denomination" {{ (old('denomination') == 'The Apostolic Church-Ghana') ? 'checked' : '' }}> Yes
                                    </label>
                                    <label style="margin-top: 0px; margin-right: 5px;">
                                        <input type="radio" class="form-check-input" value="2" name="denomination" {{ (old('denomination') == '2') ? 'checked' : '' }}> No
                                    </label>
                                </div>
                                <div class="col-md-3 {{ $errors->has('chapter') ? ' has-error' : '' }}" style="margin-top:10px">
                                    {!! Form::label('chapter','Chapter',['class'=>'form-label']) !!}
                                    {!! Form::text('chapter',null,['class'=>'form-control']) !!}
                                </div>
                                <div class="col-md-3 {{ $errors->has('localassembly') ? ' has-error' : '' }}" style="margin-top:10px">
                                    {!! Form::label('localassembly','Local Assembly:',['class'=>'form-label required']) !!}
                                    {!! Form::text('localassembly',null,['class'=>'form-control','required']) !!}
                                </div>
                                <div class="col-md-3 {{ $errors->has('otherdenomination') ? ' has-error' : '' }}" style="margin-top:9px">
                                    {!! Form::label('otherdenomination','Other Denomination',['class'=>'form-label']) !!}
                                    <input type="text" name="otherdenomination" class="form-control" style="float:right" value="{{ (old('otherdenomination'))}}"/>

                                </div>
                                <div class="col-md-3 {{ $errors->has('area') ? ' has-error' : '' }}" style="margin-top:10px">
                                    {!! Form::label('area','Area:',['class'=>'form-label']) !!}
                                    {!! Form::select('area',$area->prepend('Choose...',''),null,['class'=>'form-select  select2']) !!}
                                </div>
                                <div class="col-md-3 {{ $errors->has('region') ? ' has-error' : '' }}" style="margin-top:10px">
                                    {!! Form::label('region','Region:',['class'=>'form-label']) !!}
                                    {!! Form::select('region',$region->prepend('Choose...',''),null,['class'=>'form-select select2']) !!}
                                </div>
                                <div class="col-md-3 {{ $errors->has('officechurch') ? ' has-error' : '' }}" style="margin-top:10px">
                                    {!! Form::label('officechurch','Office Held in Church:',['class'=>'form-label']) !!}
                                    {!! Form::select('officechurch',$OfficeHeldInChurch->prepend('Choose...',''),null,['class'=>'form-select padded']) !!}
                                </div>
                                <div class="col-md-3 {{ $errors->has('officeaposa') ? ' has-error' : '' }}" style="margin-top:10px">
                                    {!! Form::label('officeaposa','Office Held at APOSA (if any):',['class'=>'form-label']) !!}
                                    {!! Form::text('officeaposa',null,['class'=>'form-control']) !!}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 mt-2 mb-2">
                        <h5 class="text-uppercase">Camp Information</h5>
                    </div>
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3 {{ $errors->has('campercat') ? ' has-error' : '' }}" style="margin-top:10px">
                                    {!! Form::label('campercat','Camper:',['class'=>'form-label required']) !!}
                                    {!! Form::select('campercat',$Camper->prepend('Choose...',''),null,['class'=>'form-select','required']) !!}
                                </div>
                                <div class="col-md-3 {{ $errors->has('campfee') ? ' has-error' : '' }}" style="margin-top:10px">
                                    {!! Form::label('campfee','Select Applicable Camp Fee:',['class'=>'form-label required']) !!}
                                    {!! Form::select('campfee',$CampApplicableFee->prepend('Choose...',''),null,['class'=>'form-control','required']) !!}
                                </div>
                                <div class="col-md-3 {{ $errors->has('agdlang') ? ' has-error' : '' }}" style="margin-top:10px">
                                    {!! Form::label('agdlang','AGD (Preferred Language):',['class'=>'form-label required']) !!}
                                    {!! Form::select('agdlang',$AGDLanguage->prepend('Choose...',''),null,['class'=>'form-select','required']) !!}
                                </div>
                                <div class="col-md-3 {{ $errors->has('agdleader') ? ' has-error' : '' }}" style="margin-top:10px">
                                    {!! Form::label('agdleader','Are you an AGD Leader?:',['class'=>'form-label']) !!}
                                    {!! Form::select('agdleader',$yesno->prepend('Choose...',''),null,['class'=>'form-select']) !!}
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-3 {{ $errors->has('needCounseling') ? ' has-error' : '' }}" style="margin-top:10px">
                                    {!! Form::label('needCounseling','Would you need counseling during camp meeting? :',['class'=>'form-label required']) !!}
                                    {!! Form::select('needCounseling',$yesno->prepend('Choose...',''),null,['class'=>'form-select','required']) !!}
                                </div>
                                <div class="col-md-3 {{ $errors->has('areaOfCounseling') ? ' has-error' : '' }}" style="margin-top:10px">
                                    {!! Form::label('areaOfCounseling','Which area would you need counseling?:',['class'=>'form-label']) !!}
                                    {!! Form::select('areaOfCounseling',$areaOfCounseling->prepend('Choose...',''),null,['class'=>'form-select']) !!}
                                </div>
                                <div class="col-md-3 {{ $errors->has('apngrouping') ? ' has-error' : '' }}" style="margin-top:10px">
                                    {!! Form::label('apngrouping','APN Breakout Session Grouping?',['class'=>'form-label required']) !!}
                                    {!! Form::select('apngrouping',$apngrouping->prepend('Choose...',''),null,['class'=>'form-select','required']) !!}
                                </div>
                            </div>
                            <div class="col-md-12 mt-3">
                                <p>
                                    <label style="margin-top: 10px; margin-right: 5px;" class="required">
                                        <input type="checkbox"  name="disclaimer" class="flat-red" id="disclaimer" required value="1" {{ (old('disclaimer') == '1') ? 'checked' : '' }}/>
                                        I understand that my registration is not complete until I make payment.&nbsp;(Disclaimer)
                                    </label>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 text-center">
                        <button type="submit" class="btn btn-flat btn-primary" style="margin-bottom:10px">
                            <i class="fa fa-check-circle-o" aria-hidden="true" style="margin-right:5px"></i> Submit Registration
                        </button>
                        <a href="{{route('landing')}}" class="btn btn-flat btn-default" style="margin-bottom:10px">
                            <i class="fa fa-angle-left" aria-hidden="true" style="margin-right:5px"></i> Back to Home</a>
                    </div>

                </form>
            @endif

        </div>
    </div>

@endsection

@section('footerscripts')
    <script>

        function showFee() {
            // var campfeeid = $('select#campfee').val();
            // var campfeeid = document.getElementById('campfee').value;
            // if(campfeeid != 43){
            //     document.getElementById('speAcc').disabled = true;
            //     document.getElementById('speAcc').value = null;
            // }else{
            //     document.getElementById('speAcc').disabled = false;
            // }
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
                $( "#datepicker" ).datepicker({changeMonth: true,changeYear: true,showButtonPanel: true,yearRange: "-70:-2 ",dateFormat: "yy-mm-dd"});
            });

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

            $("#campercat").trigger("change");
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