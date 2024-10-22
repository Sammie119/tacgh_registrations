@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Register in Batches</div>
                <div class="panel-body">
            <h4>Please download the excel format and fill in the columns appropriately and click upload batch<br/>
                <span style="color:red;font-size: small;font-weight: bold">Note: please do not change header names in the excel sheet!</span></h4>
                    <div><a href="{{ url('/downloadfiles/upload_format.xlsx') }}"><button class="btn btn-success">Download Excel Format</button></a></div>
        </div>
    <form  action="{{ URL::to('importExcel') }}" class="form-horizontal" method="post" enctype="multipart/form-data">
        <input type="file" name="import_file" />
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <button class="btn btn-primary">Upload Batch</button>
    </form>
    @if(isset($batches))
        {{--{{dd($batches)}}--}}
                    <div style="margin:20px;">Preview Upload:<br/>
                        <span style="font-weight: bold;color:green;font-size: small">Validity of file upload will be shown in a message box below your preview</span></div>
        <table id="example" cellspacing="0" cellpadding="0" class="table table-responsive" border="1">
            <thead>
            <tr>
                <th>Excel Row</th>
                <th>Surname</th>
                <th>Firstname</th>
                <th>DOB</th>
                <th>Telephone</th>
                <th>Email</th>
                <th>Profession</th>
                <th>AGD Language</th>
                <th>Error/Success</th>
            </tr>
            </thead>
            <tbody>
            <div style="display:none">{{$error_count =0}}</div>
            {{--{{$values[] = array_combine(range(2,count($batches)),$batches)}}--}}
            @foreach($batches as $key =>$registrant)
                @if($registrant['surname'] == "" || $registrant['firstname']=="" || $registrant['gender_id']=="" || $registrant['maritalstatus_id']=="" || $registrant['nationality']=="")
                    <tr style="color:red;margin:2px;padding:2px">
                        <td>{{$key+2}}</td>
                        <td>{{$registrant['surname']}}</td><td>{{$registrant['firstname']}}</td>
                        <td>{{$registrant['dob']}}</td><td>{{$registrant['telephone']}}</td>
                        <td>{{$registrant['email']}}</td><td>{{$registrant['profession']}}</td>
                        <td>{{$registrant['agdlang_id']}}</td><td>error maybe</td>
                    <div style="display:none">{{$error_count ++}}</div>
                    @else
                    <tr style="color:green;font-size: x-small;">
                        <td>{{$key+2}}</td>
                        <td>{{$registrant['surname']}}</td><td>{{$registrant['firstname']}}</td>
                        <td>@if(isset($registrant['dob'])){{$registrant['dob']->toFormattedDateString()}}@endif</td><td>{{$registrant['telephone']}}</td>
                        <td>{{$registrant['email']}}</td><td>{{$registrant['profession']}}</td>
                        <td>{{$registrant['agdlang_id']}}</td><td><span class="glyphicons glyphicons-check"></span></td>
                    </tr>
                    @endif
            @endforeach
            </tbody>
        </table>
                    {{--<div>{{dump($batches['error'])}}</div>--}}
                @if($error_count>0)
                        <div class="error">You have {{$error_count}} errors in your upload. Such rows are in red</div>
       <center><button class="btn btn-primary" disabled>Register Batch</button></center>
                    @else
                        <form  action="{{ URL::to('batchregister') }}" class="form-horizontal" method="post">
                            {{ csrf_field() }}
                        <div class="controlBlock">
                            <div class="inputControl control-inline">{!! Form::label('chapter','Chapter:',['class'=>'form-label']) !!}</div>
                            <div class="inputControl control-inline">{!! Form::text('chapter',null,['class'=>'form-control']) !!}</div>
                        </div>
                        <div class="controlBlock">
                            <div class="inputControl control-inline">{!! Form::label('denomination','Denomination:',['class'=>'form-label']) !!}</div>
                            <div class="inputControl control-inline"><label class="inputControl">
                                    <input type="radio" value="1" name="denomination">The Apostolic Church-Ghana</label></div>
                            <div class="inputControl control-inline"><label class="inputControl"><input type="radio" value="2" name="denomination">
                                    Other<input type="text" name="otherdenomination" class="form-control" style="float:right"/></label></div>
                        </div>
                        <div class="controlBlock{{ $errors->has('area') ? ' has-error' : '' }}">
                            <div class="inputControl control-inline">{!! Form::label('area','Area:',['class'=>'form-label']) !!}</div>
                            <div class="inputControl control-inline">{!! Form::text('area',null,['class'=>'form-control']) !!}</div>
                        </div>
                        <div class="controlBlock{{ $errors->has('region') ? ' has-error' : '' }}">
                            <div class="inputControl control-inline">{!! Form::label('region','Region:',['class'=>'form-label']) !!}</div>
                            <div class="inputControl control-inline">{!! Form::select('region',$region->prepend('Choose...',''),null,['class'=>'form-control']) !!}</div>
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
                        <div class="controlBlock">
                            <label><input type="checkbox" name="foreigndelegate"/>Any Foreign delegate?</label>
                            <label><input type="checkbox" name="specialneeds"/>Anybody with special needs?</label>
                        </div>
                        <center>
                            <button class="btn btn-primary">Register Batch</button>
                            <a href="{{url()->previous()}}" class="btn btn-default">Back</a>
                        </center>
                        </form>
                    @endif
    @endif
</div>
        </div>
    </div>
    </div>
    </div>
@endsection