@extends('admin.layout.template')
@section('beforecss')
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('css/AdminLTE.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/iCheck/all.css') }}">
    <link rel="stylesheet" href="{{asset('css/jquery-ui.min.css')}}">
@endsection

@section('content')
    <section class="content-wrapper">
        <section class="content-header">
            <h1>Register</h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Register Camper</li>
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
                            <form role="form" method="POST" action="{{ route('registrant.store') }}">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <div class="col-md-6 {{ $errors->has('surname') ? ' has-error' : '' }}" style="margin-top:10px">
                                        {!! Form::label('surname','Surname*:',['class'=>'form-label']) !!}
                                        {!! Form::text('surname',null,['class'=>'form-control']) !!}
                                    </div>
                                    <div class="col-md-6 {{ $errors->has('firstname') ? ' has-error' : '' }}" style="margin-top:10px">
                                        {!! Form::label('firstname','Other names*:',['class'=>'form-label']) !!}
                                        {!! Form::text('firstname',null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-6 {{ $errors->has('gender') ? ' has-error' : '' }}" style="margin-top:10px">
                                        {!! Form::label('gender','Gender*:',['class'=>'form-label']) !!}
                                        {!! Form::select('gender',$gender->prepend('Choose...',''),null,['class'=>'form-control']) !!}
                                    </div>
                                    <div class="col-md-6 {{ $errors->has('dob') ? ' has-error' : '' }}" style="margin-top:10px">
                                        {!! Form::label('dob','Date of Birth*:',['class'=>'form-label']) !!}
                                        {!! Form::text('dob',null,['class'=>'form-control','id'=>'datepicker']) !!}
                                    </div>
                                </div>
                                <div class="row row-fit"><div class="form-group">
                                        <div class="col-md-6 {{ $errors->has('nationality') ? ' has-error' : '' }}" style="margin-top:9px">
                                            {!! Form::label('nationality','Nationality*:',['class'=>'form-label']) !!}
                                            <label style="margin-left: 10px; margin-right: 5px;">
                                                <input type="radio" value="1" checked id="ghana" class="flat-red" name="nationality"> Ghanaian
                                            </label>
                                            <label style="margin-top: 0px; margin-right: 5px;">
                                                <input type="radio" class="flat-red" id="others" value="2" name="nationality"> Other
                                            </label><input type="text" disabled id="othernationality" name="othernationality" class="form-control" style="float:right"/>

                                        </div>
                                        <div class="col-md-6 {{ $errors->has('foreigndel') ? ' has-error' : '' }}" style="margin-top:10px">
                                            {!! Form::label('foreigndel','Are you a foreign delegate?*:',['class'=>'form-label']) !!}
                                            {!! Form::select('foreigndel',$yesno->prepend('Choose...',''),null,['class'=>'form-control']) !!}
                                        </div>
                                    </div></div>
                                <div class="form-group">
                                    <div class="col-md-6 {{ $errors->has('maritalstatus') ? ' has-error' : '' }}" style="margin-top:10px">
                                        {!! Form::label('maritalstatus','Marital Status*:',['class'=>'form-label']) !!}
                                        {!! Form::select('maritalstatus',$maritalstatus->prepend('Choose...',''),null,['class'=>'form-control']) !!}
                                    </div>
                                    <div class="col-md-6 {{ $errors->has('chapter') ? ' has-error' : '' }}" style="margin-top:10px">
                                        {!! Form::label('chapter','Chapter*:',['class'=>'form-label']) !!}
                                        {!! Form::text('chapter',null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="row row-fit"><div class="form-group">
                                        <div class="col-md-6 {{ $errors->has('localassembly') ? ' has-error' : '' }}" style="margin-top:10px">
                                            {!! Form::label('localassembly','Local Assembly*:',['class'=>'form-label']) !!}
                                            {!! Form::text('localassembly',null,['class'=>'form-control']) !!}
                                        </div>
                                        <div class="col-md-6 {{ $errors->has('denomination') ? ' has-error' : '' }}" style="margin-top:9px">
                                            {!! Form::label('denomination','Denomination*:',['class'=>'form-label']) !!}
                                            <label style="margin-left: 10px; margin-right: 5px;">
                                                <input type="radio" value="1" class="flat-red" name="denomination"> The Apostolic Church-Ghana
                                            </label>
                                            <label style="margin-top: 0px; margin-right: 5px;">
                                                <input type="radio" class="flat-red" value="2" name="denomination"> Other
                                            </label><input type="text" name="othernationality" class="form-control" style="float:right"/>

                                        </div>
                                    </div></div>
                                <div class="form-group">
                                    <div class="col-md-6 {{ $errors->has('area') ? ' has-error' : '' }}" style="margin-top:10px">
                                        {!! Form::label('area','Area*:',['class'=>'form-label']) !!}
                                        {!! Form::text('area',null,['class'=>'form-control']) !!}
                                    </div>
                                    <div class="col-md-6 {{ $errors->has('region') ? ' has-error' : '' }}" style="margin-top:10px">
                                        {!! Form::label('region','Region*:',['class'=>'form-label']) !!}
                                        {!! Form::select('region',$region->prepend('Choose...',''),null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="row row-fit"><div class="form-group">
                                        <div class="col-md-6 {{ $errors->has('permaddress') ? ' has-error' : '' }}" style="margin-top:10px">
                                            {!! Form::label('permaddress','Permanent Address:',['class'=>'form-label']) !!}
                                            {!! Form::textarea('permaddress',null,['class'=>'form-control','rows'=>3,'cols'=>10]) !!}
                                        </div>
                                        <div class="col-md-6 {{ $errors->has('telephone') ? ' has-error' : '' }}" style="margin-top:10px">
                                            {!! Form::label('telephone','Mobile Number*:',['class'=>'form-label']) !!}
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
                                    <div class="col-md-6 {{ $errors->has('officechurch') ? ' has-error' : '' }}" style="margin-top:10px">
                                        {!! Form::label('officechurch','Office Held in Church*:',['class'=>'form-label']) !!}
                                        {!! Form::select('officechurch',$OfficeHeldInChurch->prepend('Choose...',''),null,['class'=>'form-control']) !!}
                                    </div>
                                    <div class="col-md-6 {{ $errors->has('profession') ? ' has-error' : '' }}" style="margin-top:10px">
                                        {!! Form::label('profession','Profession:',['class'=>'form-label']) !!}
                                        {!! Form::text('profession',null,['class'=>'form-control','id'=>'profession']) !!}
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
                                    <div class="col-md-6 {{ $errors->has('campercat') ? ' has-error' : '' }}" style="margin-top:10px">
                                        {!! Form::label('campercat','Camper*:',['class'=>'form-label']) !!}
                                        {!! Form::select('campercat',$Camper->prepend('Choose...',''),null,['class'=>'form-control']) !!}
                                    </div>
                                    <div class="col-md-6 {{ $errors->has('agdlang') ? ' has-error' : '' }}" style="margin-top:10px">
                                        {!! Form::label('agdlang','Action Group Discussion (Preferred Language)*:',['class'=>'form-label']) !!}
                                        {!! Form::select('agdlang',$AGDLanguage->prepend('Choose...',''),null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-6 {{ $errors->has('agdleader') ? ' has-error' : '' }}" style="margin-top:10px">
                                        {!! Form::label('agdleader','Are you an AGD Leader?:',['class'=>'form-label']) !!}
                                        {!! Form::select('agdleader',$yesno->prepend('Choose...',''),null,['class'=>'form-control']) !!}
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
                                    <div class="col-md-6 {{ $errors->has('campfee') ? ' has-error' : '' }}" style="margin-top:10px">
                                        {!! Form::label('campfee','Select Applicable Camp Fee*:',['class'=>'form-label']) !!}
                                        {!! Form::select('campfee',$CampApplicableFee->prepend('Choose...',''),null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-6 {{ $errors->has('specialaccom') ? ' has-error' : '' }}" style="margin-top:10px">
                                        {!! Form::label('specialaccom','Select the type of Special Accommodation*:',['class'=>'form-label']) !!}
                                        {!! Form::select('specialaccom',$SpecialAccomodation->prepend('Choose...',''),null,['class'=>'form-control']) !!}
                                    </div>
                                    <div class="col-md-6 {{ $errors->has('paymentphone') ? ' has-error' : '' }}" style="margin-top:10px">
                                        {!! Form::label('paymentphone','Please call any of the numbers below to make payment:',['class'=>'form-label']) !!}
                                        {!! Form::select('paymentphone',[''=>'Choose..','1'=>'0246968574','2'=>'0263968574'],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12 {{ $errors->has('disclaimer') ? ' has-error' : '' }}" style="margin-top:10px">
                                        {!! Form::label('disclaimer','I understand that my registration is not complete until I make payment*:',['class'=>'form-label']) !!}
                                        {!! Form::select('disclaimer',$yesno->prepend('Choose...',''),null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <center>
                                    <button type="submit" class="btn btn-flat btn-label-blue" style="margin-top:15px">
                                        Register
                                    </button>
                                    <a href="{{url()->previous()}}" class="btn btn-flat btn-default"><i class="fa fa-angle-left" aria-hidden="true" style="margin-right:5px"></i> Back</a>
                                </center>
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
        $(document).ready(function(){
            $(function() {
                $( "#datepicker" ).datepicker({changeMonth: true,changeYear: true,showButtonPanel: true,yearRange: "-70:-2 ",dateFormat: "yy-mm-dd"});
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