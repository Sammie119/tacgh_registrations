@extends('layouts.app')
@section('beforecss')
        <link rel="stylesheet" href="{{ asset('css/AdminLTE.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/select2/select2.min.css') }}">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        tr>th,label {
            font-weight: 500;
        }
    </style>
    <script>
        var camperfee;
        function showFee(id) {
            var campfeeid = $('#campfee_'+id).val();
            if(campfeeid != 43){
//                document.getElementById('speAcc_'+id).disabled = true;
//                document.getElementById('speAcc_'+id).value = null;
            }else{
                document.getElementById('speAcc_'+id).disabled = false;
            }
        }

        $(document).ready(function(){
            camperfee = function camper_fee(id){
                var val = $('#campercat_'+id).val();

            alert(JSON.stringify($('#campfee_'+id)));
            $('#campfee_'+id +'option').hide();
            $('#campfee_'+id).prop('selectedIndex',0);

            $('#campfee_'+id +'option').each(function(index){
                alert("within each loop");
                var feeoption = $('#campfee_'+id +'option');
                if(val == 25){
                    alert("option 25");
                    if(jQuery.inArray($(feeoption).val(),["42","43"]) !== -1){
                        $(feeoption).show();
                        return;
                    }
                }
                else if(val == 26){
                    alert("option 26");
                    if(jQuery.inArray($(feeoption).val(),["37","38","41","43"]) !== -1){
                        $(feeoption).show();
                        return;
                    }
                }
                else if(val == 28){
                    alert("option 28");
                    if(jQuery.inArray($(feeoption).val(),["40","43"]) !== -1){
                        $(feeoption).show();
                        return;
                    }
                }
                else if(jQuery.inArray(val,["130","131"]) !== -1){
                    if(jQuery.inArray($(feeoption).val(),["39","43"]) !== -1){
                        $(feeoption).show();
                        return;
                    }
                }
            });
            }
        })

    </script>
@endsection

@section('content')
    <section style="margin-top: 50px;">
        <div class="container">
            <div class="row" style="margin: 40px 0">
                <div class="col-md-5 col-md-offset-1 text-center">
                    <div class="box box-solid" style="border-radius: 0px">
                        <div class="box-body text-color">
                            <h3>Total Male Rooms Left</h3>
                            <h1 class="text-danger">{{ $total_male_rooms_left }}</h1>
                        </div>
                    </div>
                </div>
                <div class="col-md-5 text-center">
                    <div class="box box-solid" style="border-radius: 0px">
                        <div class="box-body text-color">
                            <h3>Total Female Rooms Left</h3>
                            <h1 class="text-danger">{{ $total_female_rooms_left }}</h1>
                        </div>
                    </div>
                </div>
            </div>
            <div style="display:inline-block;width:100%;" class="text-center">
                <div style="margin:0 auto;display:inline-block;">
                    <img src="{{asset('img/aposa-main_edit.png')}}" style="margin:0 auto;;max-width:200px"/>
                </div>

                <div style="margin: 1rem 0;display: inline-block;float:right">
                    <a href="{{route('registrant.camper_logout')}}" class="btn btn-flat btn-danger">
                        Log out
                    </a>
                </div>
            </div>

            <div style="background: #f6f9fb;margin: 1.5rem 0; padding: 1.5rem 1rem 3rem;">
                <h2 style="text-align: center;">APOSA Campmeeting
                    <span style="color: red;">{{date('Y')}}</span> - Batch Registration</h2>
                {{--<p style="text-align:center">--}}
                <div class="container" >
                    <ul style="margin:5px;padding:10px;word-wrap: break-word">
                        <li>Enter the number of campers you're registering from your batch and click 'Generate', the form will be generated for you to enter their indidual details (minimum of 2 campers).</li>
                        <li>Complete chapter details and click Register. A batch number and token will be sent to the ambassador's phone.</li>
                        <li>Use batch number and token to continue registraion at 'Registered Last Year' on the landing page!</li>
                    </ul>
                        {{--Note: <span style="color:red">For excel upload, kindly click 'Register Campers By Excel Upload'</span>--}}
                </div>

                <hr>
                <form action="{{route('table_batch')}}" method="get">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-6 {{ $errors->has('rows') ? ' has-error' : '' }}">
                            {{--                            {!! Form::label('surname','Surname:',['class'=>'form-label required']) !!}--}}
                            {!! Form::number('rows',null,['class'=>'form-control','placeholder'=>'No. of Campers','min'=>2]) !!}
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-flat btn-outline-primary">
                                Generate
                            </button>
                        </div>
                        <div class="col-md-4" style="text-align: right;">
                            <a href="{{url('bacthregistration')}}" class="btn btn-flat btn-primary">
                                <i class="fa fa-file-excel-o" style="margin-right: 5px;"></i> Use excel upload
                            </a>
                        </div>
                    </div>
                </form>
                <hr>
                <form action="{{route('table_batch.save')}}" method="post">
                    {{csrf_field()}}
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th><div style="width: 30px;">No.</div></th>
                                    <th><div style="width: 200px;">Surname</div></th>
                                    <th><div style="width: 250px;">Other Names</div></th>
                                    <th><div style="width: 100px;">Gender</div></th>
                                    <th><div style="width: 150px;">Date of Birth</div></th>
                                    <th><div style="width: 100px;">Marital Status</div></th>
                                    <th><div style="width: 130px;">Foreign Delegate?</div></th>
                                    <th><div style="width: 130px;">Nationality</div></th>
                                    <th><div style="width: 130px;">Mobile Number</div></th>
                                    <th><div style="width: 250px;">Email</div></th>
                                    <th><div style="width: 200px;">Office held in Church</div></th>
                                    <th><div style="width: 250px;">Camper Type</div></th>
                                    <th><div style="width: 250px;">Camp Fee</div></th>
                                    <th class="hidden"><div style="width: 250px;">Special Accommodation</div></th>
                                    <th><div style="width: 130px;">AGD Language</div></th>
                                    <th><div style="width: 115px;">An AGD Leader?</div></th>
                                    <th><div style="width: 115px;">Need Counselling?</div></th>
                                    <th><div style="width: 115px;">Counseling Area</div></th>
                                </tr>
                            </thead>
                            <tbody>
                                @for($a = 1; $a <= $rows; $a++)
                                    <tr>
                                        <td>{{$a}}</td>
                                        <td style="width: 250px;">
                                            {!! Form::text('surname[]',null,['class'=>'form-control', 'required']) !!}
                                        </td>
                                        <td style="width: 250px;">
                                            {!! Form::text('firstname[]',null,['class'=>'form-control', 'required']) !!}
                                        </td>
                                        <td style="width: 250px;">
                                            {!! Form::select('gender_'.$a,$gender->prepend('Choose...',''),null,['class'=>'form-control']) !!}
                                        </td>
                                        <td style="width: 250px;">
                                            {!! Form::text('dob[]',null,['class'=>'form-control datepicker','id'=>'datepicker_'.$a,'autocomplete'=>'off']) !!}
                                        </td>
                                        <td>
                                            {!! Form::select('maritalstatus_'.$a,$maritalstatus->prepend('Choose...',''),null,['class'=>'form-control']) !!}
                                        </td>
                                        <td>
                                            {!! Form::select('foreigndel_'.$a,$yesno->prepend('Choose...',''),null,['class'=>'form-control']) !!}
                                        </td>
                                        <td>
                                            {!! Form::text('nationality[]','Ghanaian',['class'=>'form-control','required']) !!}
                                        </td>
                                        <td>
                                            {!! Form::text('telephone[]',null,['class'=>'form-control telephone','id'=>'telephone']) !!}
                                        </td>
                                        <td>
                                            {!! Form::text('email[]',null,['class'=>'form-control']) !!}
                                        </td>
                                        <td>
                                            {!! Form::select('officechurch_'.$a,$OfficeHeldInChurch->prepend('Choose...',''),null,['class'=>'form-control select2 padded']) !!}
                                        </td>
                                        <td>
                                            {!! Form::select('campercat_'.$a,$Camper->prepend('Choose...',''),null,['class'=>'form-control campercat','rowNum'=>$a]) !!}
                                        </td>
                                        <td>
                                            {!! Form::select('campfee_'.$a,$CampApplicableFee->prepend('Choose...',''),null,['class'=>'form-control camperfee','id'=>'campfee_'.$a,'onchange'=>'showFee('.$a.')']) !!}
                                        </td>
                                        <td class="hidden">
                                            {!! Form::select('specialaccom_'.$a,$SpecialAccomodation->prepend('Choose...',''),null,['class'=>'form-control','id'=>'speAcc_'.$a,'disabled'=>'disabled']) !!}
                                        </td>
                                        <td>
                                            {!! Form::select('agdlang_'.$a,$AGDLanguage->prepend('Choose...',''),null,['class'=>'form-control']) !!}
                                        </td>
                                        <td>
                                            {!! Form::select('agdleader_'.$a,$yesno->prepend('Choose...',''),null,['class'=>'form-control']) !!}
                                        </td>
                                        <td>
                                            {!! Form::select('needcounseling_'.$a,$yesno->prepend('Choose...',''),null,['class'=>'form-control']) !!}
                                        </td>
                                        <td>
                                            {!! Form::select('counselingarea_'.$a,$areaOfCounseling->prepend('Choose...',''),null,['class'=>'form-control']) !!}
                                        </td>
                                    </tr>
                                @endfor
                            </tbody>
                        </table>
                    </div>
                    <div>
                        <h5 class="text-danger">This section of the form applies to all the added campers in this batch.</h5>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-4 {{ $errors->has('ambassadorname') ? ' has-error' : '' }}" style="margin-top:10px">
                                {!! Form::label('ambassadorname','Name of Ambassador/Leader:',['class'=>'form-label']) !!}
                                {!! Form::text('ambassadorname',null,['class'=>'form-control','required']) !!}
                            </div>
                            <div class="col-md-4 {{ $errors->has('ambassadorphone') ? ' has-error' : '' }}" style="margin-top:10px">
                                {!! Form::label('ambassadorphone','Contact of Ambassador/Leader:',['class'=>'form-label']) !!}
                                {!! Form::text('ambassadorphone',null,['class'=>'form-control ambassadorphone','id'=>'ambassadorphone','required']) !!}
                            </div>
                            <div class="col-md-4 {{ $errors->has('denomination') ? ' has-error' : '' }}" style="margin-top:9px;display: none">
                                {!! Form::label('denomination','Denomination:',['class'=>'form-label required']) !!}
                                <label style="margin-left: 10px; margin-right: 5px;">
                                    <input type="radio" checked value="The Apostolic Church-Ghana" class="flat-red" name="denomination" {{ (old('denomination') == 'The Apostolic Church-Ghana') ? 'checked' : '' }}> The Apostolic Church-Ghana
                                </label>
                                <label style="margin-top: 0px; margin-right: 5px;">
                                    <input type="radio" class="flat-red" value="2" name="denomination" {{ (old('denomination') == '2') ? 'checked' : '' }}> Other
                                </label>
                                <input type="text" name="otherdenomination" class="form-control" style="float:right" value="{{ (old('otherdenomination'))}}"/>

                            </div>
                            <div class="col-md-4 {{ $errors->has('chapter') ? ' has-error' : '' }}" style="margin-top:10px">
                                {!! Form::label('chapter','Chapter:',['class'=>'form-label']) !!}
                                {!! Form::text('chapter',null,['class'=>'form-control']) !!}
                            </div>
                            <div class="col-md-4 {{ $errors->has('localassembly') ? ' has-error' : '' }}" style="margin-top:10px">
                                {!! Form::label('localassembly','Local Assembly:',['class'=>'form-label required']) !!}
                                {!! Form::text('localassembly',null,['class'=>'form-control']) !!}
                            </div>
                            <div class="col-md-4 {{ $errors->has('region') ? ' has-error' : '' }}" style="margin-top:10px">
                                {!! Form::label('region','Region:',['class'=>'form-label']) !!}
                                {!! Form::select('region',$region->prepend('Choose...',''),null,['class'=>'form-control select2','required']) !!}
                            </div>
                            <div class="col-md-4 {{ $errors->has('area') ? ' has-error' : '' }}" style="margin-top:10px">
                                {!! Form::label('area','Area:',['class'=>'form-label']) !!}
                                {!! Form::select('area',$area->prepend('Choose...',''),null,['class'=>'form-control  select2','required']) !!}
                            </div>
                            <div class="col-md-12">
                                <p><label style="margin-top: 10px; margin-right: 5px;" class="required">
                                        <input type="checkbox" required  name="disclaimer" class="flat-red" id="disclaimer" value="1" {{ (old('disclaimer') == '1') ? 'checked' : '' }}/>
                                        I understand that my registration is not complete until I make payment.&nbsp;(Disclaimer)
                                    </label></p>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-flat btn-success" style="margin-top: 15px">
                            Register members
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
@section('footerscripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="{{ asset('plugins/select2/select2.full.min.js') }}"></script>
    <script>
        $(document).ready(function(){
            showFee();
            $(".select2").select2();
            $(function() {
                $( ".datepicker" ).datepicker({changeMonth: true,changeYear: true,showButtonPanel: true,yearRange: "-70:-2 ",dateFormat: "yy-mm-dd"});
            });

            $('.campercat').on('change',function () {
                const val = $(this).val();

                const id = $(this).attr('rowNum');
                const controlId = '#campfee_'+id;
                $(controlId+' option').hide();

                $(controlId).find('option').not(':first').remove();
                $.ajax({
                    url:'/campercatfees/'+val,
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

                                $(controlId).append(option);
                            }
                        }
                    }
                })
            });

//             $(".campercat").on('change',function(){
//                 var val = $(this).val();
//
//                 var id = $(this).attr('rowNum');
//
//                 $('#campfee_'+id+' option').hide();
//                 $('#campfee_'+id).prop('selectedIndex',0);
//
//                 $('#campfee_'+id+' option').each(function(index){
//
//                     //Senior Campers
//                     if(val == 25){
//                         if(jQuery.inArray($(this).val(),["41","37","38","42","43"]) !== -1){
//                             $(this).show();
//                             return;
//                         }
//                     }
//                     //REgular Campers
//                     else if(val == 26){
//                         if(jQuery.inArray($(this).val(),["37","38","41","43"]) !== -1){
//                             $(this).show();
//                             return;
//                         }
//                     }
//                     //Children
//                     else if(val == 28){
//                         if(jQuery.inArray($(this).val(),["40","42","43"]) !== -1){
//                             $(this).show();
//                             return;
//                         }
//                     }
//                     //Junior & Senior Teens
//                     else if(jQuery.inArray(val,["123","124"]) !== -1){
// //                         alert(val+" is in 130,131 ");
//                         if(jQuery.inArray($(this).val(),["39","43"]) !== -1){
//                             $(this).show();
//                             return;
//                         }
//                     }
//                 });
//             });
        });
        $(".telephone").keypress(function (event) { return isNumberKey(event) });
        $(".ambassadorphone").keypress(function (event) { return isNumberKey(event) });
        //function to check if value entered is numeric
        function isNumberKey(evt) { var charCode = (evt.which) ? evt.which : event.keyCode; if (charCode > 31 && (charCode < 48 || charCode > 57)) { return false; } return true; }
        function isNumber(evt) { var charCode = (evt.which) ? evt.which : event.keyCode; if (charCode != 45 && (charCode != 46 || $(this).val().indexOf('.') != -1) && (charCode < 48 || charCode > 57)) return false; return true; }

    </script>
@endsection