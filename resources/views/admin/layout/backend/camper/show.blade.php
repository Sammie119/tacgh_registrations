@extends('admin.layout.template')
@section('afterAllCss')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.jqueryui.min.css" />
    <link href="{{asset('css/main.css')}}" rel="stylesheet">
@endsection
@section('content')
    <section class="content-wrapper">
        <section class="content-header">
            <h1>Applicant Details</h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Applicants</li>
            </ol>
        </section>
        <div class="content">
            <div class="row">

                <div class="box box-solid">
                    <div class="box-header">

                        <div class="row" style="margin-bottom: 10px">
                            <div class="col-md-4">
                                <h3 style="margin-top:20px;font-size: 20px;"><span style="font-size:small">Hello,</span> {{$registrant->firstname." ".$registrant->surname}}</h3>
                                {{--<span>Age: {{($registrant->dob)}}</span>--}}
                            </div>
                            <div class="col-md-4 text-center">

                            </div>
                            <div class="col-md-4 text-right">
                                Registration Number:{{$registrant->reg_id}}
                            </div>
                        </div>
                    </div>
                    <div class="box-body">
                       <style>
                           .alignright{
                               float:right;font-weight:bold}
                       </style>
                        @if($registrant)
                            <table id="dtrows" class="table table-responsive">
                                <tr>
                                    <td class="alignright">Surname:</td><td>{{$registrant->surname}}</td>
                                    <td class="alignright">Firstname:</td><td>{{$registrant->firstname}}</td></tr>
                                <tr>
                                    <td class="alignright">Gender</td><td>{{$registrant->gender->FullName}}</td>
                                    <td class="alignright">DOB</td><td>{{$registrant->dob}}</td></tr>
                                <tr>
                                    <td  class="alignright">Nationality:</td><td>{{$registrant->nationality}}</td>
                                    <td class="alignright">Foreign delegate?:</td><td>{{$registrant->foreigndel_id}}</td></tr>
                                <tr>
                                    <td class="alignright">Marital Status:</td><td>{{$registrant->maritalstatus->FullName}}</td>
                                    <td class="alignright">Telephone:</td><td>{{$registrant->telephone}}</td>
                                </tr>
                                <tr>
                                    <td class="alignright">Chapter</td><td>{{$registrant->chapter}}</td>
                                    <td class="alignright">Profession</td><td>{{$registrant->profession}}</td></tr>
                                <tr>
                                    <td class="alignright">Batch No</td><td>{{$registrant->batch_no}}</td>
                                </tr>
                                </tbody>
                            </table>
                        @endif
                        <div class="panel-body">
                            {{--<form class="form-horizontal" role="form" method="PATCH" action="{{ route('registrant.update',$registrant->id) }}">--}}
                                {!! Form::open(['method'=>'PATCH','route' => ['registrant.update',$registrant],'class'=>'form-horizontal']) !!}
{{--                                {!! Form::open(['method'=>'PUT','action'=>'RegistrantController@update','class'=>'form-horizontal']) !!}--}}
                                {{ csrf_field() }}
                                    <div style="max-width:800px;margin:0 auto">
                                        <div class="controlBlock{{ $errors->has('amountpaid') ? ' has-error' : '' }}">
                                            <div class="inputControl control-inline">{!! Form::label('amountpaid','Amount Paid:',['class'=>'form-label']) !!}</div>
                                            <div class="inputControl control-inline">{!! Form::text('amountpaid',null,['class'=>'form-control']) !!}</div>
                                        </div>

                                        <div class="controlBlock{{ $errors->has('paymentdetails') ? ' has-error' : '' }}">
                                            <div class="inputControl control-inline">{!! Form::label('paymentdetails','Payment Details:',['class'=>'form-label']) !!}</div>
                                            <div class="inputControl control-inline">{!! Form::textarea('paymentdetails',null,['class'=>'form-control','cols'=>60,'rows'=>3]) !!}</div>
                                        </div>

                                        <div class="controlBlock{{ $errors->has('shortnotes') ? ' has-error' : '' }}">
                                            <div class="inputControl control-inline">{!! Form::label('shortnotes','Short Comments:',['class'=>'form-label']) !!}</div>
                                            <div class="inputControl control-inline">{!! Form::textarea('shortnotes',null,['class'=>'form-control','cols'=>60,'rows'=>3]) !!}</div>
                                        </div>
                                    </div>
                                <center>
                                    <button type="submit" class="btn btn-primary" title="Authorize for distribution of material and room">
                                        Authorize
                                    </button>
                                </center>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
@section('afterOtherScripts')

@endsection