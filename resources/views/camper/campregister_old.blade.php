@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Register for ACM 2017</div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{ route('registrant.store') }}">
                            {{ csrf_field() }}
                            <div class="controlBlock{{ $errors->has('surname') ? ' has-error' : '' }}">
                                <div class="inputControl control-inline">{!! Form::label('surname','Surname:',['class'=>'form-label']) !!}</div>
                                <div class="inputControl control-inline">{!! Form::text('surname',null,['class'=>'form-control']) !!}</div>
                            </div>
                            <div class="controlBlock{{ $errors->has('firstname') ? ' has-error' : '' }}">
                                <div class="inputControl control-inline">{!! Form::label('firstname','Firstname:',['class'=>'form-label']) !!}</div>
                                <div class="inputControl control-inline">{!! Form::text('firstname',null,['class'=>'form-control']) !!}</div>
                            </div>

                            <div class="controlBlock{{ $errors->has('gender') ? ' has-error' : '' }}">
                                <div class="inputControl control-inline">{!! Form::label('gender','Gender:',['class'=>'form-label']) !!}</div>
                                <div class="inputControl control-inline">{!! Form::select('gender',$gender->prepend('Choose...',''),null,['class'=>'form-control']) !!}</div>
                            </div>
                            <div class="controlBlock{{ $errors->has('dob') ? ' has-error' : '' }}">
                                <div class="inputControl control-inline">{!! Form::label('dob','Date of Birth:',['class'=>'form-label']) !!}</div>
                                <div class="inputControl control-inline">{!! Form::text('dob',null,['class'=>'form-control','id'=>'datepicker']) !!}</div>
                            </div>
                            <div class="controlBlock{{ $errors->has('nationality') ? ' has-error' : '' }}">
                                <div class="inputControl control-inline">{!! Form::label('nationality','Nationality:',['class'=>'form-label']) !!}</div>
                                <div class="inputControl control-inline"><label class="inputControl"><input type="radio" value="1" name="nationality">
                                        Ghanaian</label></div>
                                <div class="inputControl control-inline">
                                    <label class="inputControl"><input type="radio" value="2" name="nationality">
                                        Other<input type="text" name="othernationality" class="form-control" style="float:right"/></label>
                                     </div>
                            </div>
                            <div class="controlBlock{{ $errors->has('foreigndel') ? ' has-error' : '' }}">
                                <div class="inputControl control-inline">{!! Form::label('foreigndel','Are you a foreign delegate?:',['class'=>'form-label']) !!}</div>
                                <div class="inputControl control-inline">{!! Form::select('foreigndel',$yesno->prepend('Choose...',''),null,['class'=>'form-control']) !!}</div>
                            </div>
                            <div class="controlBlock{{ $errors->has('maritalstatus') ? ' has-error' : '' }}">
                                <div class="inputControl control-inline">{!! Form::label('maritalstatus','Marital Status:',['class'=>'form-label']) !!}</div>
                                <div class="inputControl control-inline">{!! Form::select('maritalstatus',$maritalstatus->prepend('Choose...',''),null,['class'=>'form-control']) !!}</div>
                            </div>
                            <div class="controlBlock{{ $errors->has('chapter') ? ' has-error' : '' }}">
                                <div class="inputControl control-inline">{!! Form::label('chapter','Chapter:',['class'=>'form-label']) !!}</div>
                                <div class="inputControl control-inline">{!! Form::text('chapter',null,['class'=>'form-control']) !!}</div>
                            </div>
                            <div class="controlBlock{{ $errors->has('localassembly') ? ' has-error' : '' }}">
                                <div class="inputControl control-inline">{!! Form::label('localassembly','Local Assembly:',['class'=>'form-label']) !!}</div>
                                <div class="inputControl control-inline">{!! Form::text('localassembly',null,['class'=>'form-control']) !!}</div>
                            </div>
                            <div class="controlBlock{{ $errors->has('denomination') ? ' has-error' : '' }}">
                                <div class="inputControl control-inline">{!! Form::label('denomination','Denomination:',['class'=>'form-label']) !!}</div>
                                <div class="inputControl control-inline"><label class="inputControl"><input type="radio" value="1" name="denomination">
                                        The Apostolic Church-Ghana</label></div>
                                <div class="inputControl control-inline"><label class="inputControl"><input type="radio" value="2" name="denomination">
                                        Other<input type="text" name="othernationality" class="form-control" style="float:right"/></label></div>
                            </div>
                            <div class="controlBlock{{ $errors->has('area') ? ' has-error' : '' }}">
                                <div class="inputControl control-inline">{!! Form::label('area','Area:',['class'=>'form-label']) !!}</div>
                                <div class="inputControl control-inline">{!! Form::text('area',null,['class'=>'form-control']) !!}</div>
                            </div>
                            <div class="controlBlock{{ $errors->has('region') ? ' has-error' : '' }}">
                                <div class="inputControl control-inline">{!! Form::label('region','Region:',['class'=>'form-label']) !!}</div>
                                <div class="inputControl control-inline">{!! Form::select('region',$region->prepend('Choose...',''),null,['class'=>'form-control']) !!}</div>
                            </div>

                            <div class="controlBlock{{ $errors->has('permaddress') ? ' has-error' : '' }}">
                                <div class="inputControl control-inline">{!! Form::label('permaddress','Permanent Address:',['class'=>'form-label']) !!}</div>
                                <div class="inputControl control-inline">{!! Form::textarea('permaddress',null,['class'=>'form-control','rows'=>3,'cols'=>10]) !!}</div>
                            </div>
                            <div class="controlBlock{{ $errors->has('telephone') ? ' has-error' : '' }}">
                                <div class="inputControl control-inline">{!! Form::label('telephone','Telephone:',['class'=>'form-label']) !!}</div>
                                {{--<div class="inputControl control-inline">{!! Form::text('telephone',null,['class'=>'form-control']) !!}</div>--}}
                                <div class="inputControl control-inline">{!! Form::text('telephone',null,['class'=>'form-control','id'=>'telephone']) !!}</div>
                            </div>

                            <div class="controlBlock{{ $errors->has('email') ? ' has-error' : '' }}">
                                <div class="inputControl control-inline">{!! Form::label('email','Email Address:',['class'=>'form-label']) !!}</div>
                                <div class="inputControl control-inline">{!! Form::text('email',null,['class'=>'form-control']) !!}</div>
                            </div>
                            <div class="controlBlock{{ $errors->has('officeaposa') ? ' has-error' : '' }}">
                                <div class="inputControl control-inline">{!! Form::label('officeaposa','Office Held at APOSA (if any):',['class'=>'form-label']) !!}</div>
                                <div class="inputControl control-inline">{!! Form::text('officeaposa',null,['class'=>'form-control']) !!}</div>
                            </div>
                            <div class="controlBlock{{ $errors->has('officechurch') ? ' has-error' : '' }}">
                                <div class="inputControl control-inline">{!! Form::label('officechurch','Office Held in Church:',['class'=>'form-label']) !!}</div>
                                <div class="inputControl control-inline">{!! Form::select('officechurch',$OfficeHeldInChurch->prepend('Choose...',''),null,['class'=>'form-control']) !!}</div>
                            </div>
                            <div class="controlBlock{{ $errors->has('profession') ? ' has-error' : '' }}">
                                <div class="inputControl control-inline">{!! Form::label('profession','Profession:',['class'=>'form-label']) !!}</div>
                                <div class="inputControl control-inline">{!! Form::text('profession',null,['class'=>'form-control','id'=>'profession']) !!}</div>
                            </div>
                            <div class="controlBlock{{ $errors->has('businessadress') ? ' has-error' : '' }}">
                                <div class="inputControl control-inline">{!! Form::label('businessaddress','Business Address:',['class'=>'form-label']) !!}</div>
                                <div class="inputControl control-inline">{!! Form::textarea('businessaddress',null,['class'=>'form-control','rows'=>3,'cols'=>10]) !!}</div>
                            </div>
                            <div class="controlBlock{{ $errors->has('studentaddress') ? ' has-error' : '' }}">
                                <div class="inputControl control-inline">{!! Form::label('studentaddress','If Student, state school and address:',['class'=>'form-label']) !!}</div>
                                    <div class="inputControl control-inline"><span style="font-size:x-small;">(NB: Student refers to undergrads and below. Address Example: Mfantsipim, P. O. Box 101, Cape Coast)</span></div>
                                <div class="inputControl control-inline">{!! Form::textarea('studentaddress',null,['class'=>'form-control','rows'=>1,'cols'=>10]) !!}</div>
                            </div>
                            <div class="controlBlock{{ $errors->has('campercat') ? ' has-error' : '' }}">
                                <div class="inputControl control-inline">{!! Form::label('campercat','Camper:',['class'=>'form-label']) !!}</div>
                                <div class="inputControl control-inline">{!! Form::select('campercat',$Camper->prepend('Choose...',''),null,['class'=>'form-control']) !!}</div>
                            </div>
                            <div class="controlBlock{{ $errors->has('agdlang') ? ' has-error' : '' }}">
                                <div class="inputControl control-inline">{!! Form::label('agdlang','Action Group Discussion (Preferred Language):',['class'=>'form-label']) !!}</div>
                                <div class="inputControl control-inline">{!! Form::select('agdlang',$AGDLanguage->prepend('Choose...',''),null,['class'=>'form-control']) !!}</div>
                            </div>
                            <div class="controlBlock{{ $errors->has('agdleader') ? ' has-error' : '' }}">
                                <div class="inputControl control-inline">{!! Form::label('agdleader','Are you an AGD Leader?:',['class'=>'form-label']) !!}</div>
                                <div class="inputControl control-inline">{!! Form::select('agdleader',$yesno->prepend('Choose...',''),null,['class'=>'form-control']) !!}</div>
                            </div>
                            <div class="controlBlock{{ $errors->has('ambassadorname') ? ' has-error' : '' }}">
                                <div class="inputControl control-inline">{!! Form::label('ambassadorname','Name of Ambassador/Leader:',['class'=>'form-label']) !!}</div>
                                <div class="inputControl control-inline">{!! Form::text('ambassadorname',null,['class'=>'form-control']) !!}</div>
                            </div>
                            <div class="controlBlock{{ $errors->has('ambassadorphone') ? ' has-error' : '' }}">
                                <div class="inputControl control-inline">{!! Form::label('ambassadorphone','Contact of Ambassador/Leader:',['class'=>'form-label']) !!}</div>
                                {{--<div class="inputControl control-inline">{!! Form::text('ambassadorphone',null,['class'=>'form-control']) !!}</div>--}}
                                <div class="inputControl control-inline">{!! Form::text('ambassadorphone',null,['class'=>'form-control','id'=>'ambassadorphone']) !!}</div>
                            </div>

                            <div class="controlBlock{{ $errors->has('campfee') ? ' has-error' : '' }}">
                                <div class="inputControl control-inline">{!! Form::label('campfee','Select Applicable Camp Fee:',['class'=>'form-label']) !!}</div>
                                <div class="inputControl control-inline">{!! Form::select('campfee',$CampApplicableFee->prepend('Choose...',''),null,['class'=>'form-control']) !!}</div>
                            </div>

                            <div class="controlBlock{{ $errors->has('specialaccom') ? ' has-error' : '' }}">
                                <div class="inputControl control-inline">{!! Form::label('specialaccom','Select the type of Special Accommodation:',['class'=>'form-label']) !!}</div>
                                <div class="inputControl control-inline">{!! Form::select('specialaccom',$SpecialAccomodation->prepend('Choose...',''),null,['class'=>'form-control']) !!}</div>
                            </div>

                            <div class="controlBlock{{ $errors->has('paymentphone') ? ' has-error' : '' }}">
                                <div class="inputControl control-inline">{!! Form::label('paymentphone','Please call any of the numbers below to make payment:',['class'=>'form-label']) !!}</div>
                                <div class="inputControl control-inline">{!! Form::select('paymentphone',[''=>'Choose..','1'=>'0246968574','2'=>'0263968574'],null,['class'=>'form-control']) !!}</div>
                            </div>

                            <div class="controlBlock{{ $errors->has('disclaimer') ? ' has-error' : '' }}">
                                <div class="inputControl control-inline">{!! Form::label('disclaimer','I understand that my registration is not complete until I make payment:',['class'=>'form-label']) !!}</div>
                                <div class="inputControl control-inline">{!! Form::select('disclaimer',$yesno->prepend('Choose...',''),null,['class'=>'form-control']) !!}</div>
                            </div>
                            <div class="controlBlock">

                            </div>

                                <center>
                                    <button type="submit" class="btn btn-primary">
                                        Register
                                    </button>
                                    <a href="{{url()->previous()}}" class="btn btn-default">Back</a>
                                </center>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footerscripts')
    <script>
        $(document).ready(function(){

            $(function() {
                $( "#datepicker" ).datepicker({changeMonth: true,changeYear: true,showButtonPanel: true,yearRange: "-90:-2 ",dateFormat: "yy-mm-dd"});
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