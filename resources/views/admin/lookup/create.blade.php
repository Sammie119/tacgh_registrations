@extends('admin.layout.template')

@section('content')
    <section class="content-wrapper">
        <section class="content-header">
            <h1>
                Lookup
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li class="active">Lookup</li>
            </ol>
        </section>
        <div class="content">
            <div class="row">
                <div class="box box-solid">
                    <div class="box-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{ route('lookupcode.store') }}">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('LookUpName') ? ' has-error' : '' }}">
                                <label for="LookUpName" class="col-md-4 control-label">Lookup Name:</label>

                                <div class="col-md-6">
                                    <input id="LookUpName" type="text" class="form-control" name="LookUpName" value="{{ old('LookUpName') }}" required autofocus>

                                    @if ($errors->has('LookUpName'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('LookUpName') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('LookupShortCode') ? ' has-error' : '' }}">
                                <label for="website" class="col-md-4 control-label">Short Name:</label>

                                <div class="col-md-6">
                                    <input id="LookupShortCode" type="text" class="form-control" name="LookupShortCode" value="{{ old('LookupShortCode') }}" required>

                                    @if ($errors->has('LookupShortCode'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('LookupShortCode') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('ActiveFlag') ? ' has-error' : '' }}">
                                {{--<label for="phone" class="col-md-4 control-label">Active?</label>--}}
                                {{--<input id="ActiveFlag" type="checkbox" class="form-control" name="ActiveFlag" required>--}}
                                <div class="col-md-4 control-label"></div>
                                <label class="col-md-6">
                                    <input type="checkbox" value="" name="ActiveFlag" class="flat-red camp control-label">
                                    Active?
                                </label>
                                <div class="col-md-1">


                                    @if ($errors->has('ActiveFlag'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('ActiveFlag') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                </div>


                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Add Lookup Code
                                    </button>

                                    <a href="{{url()->previous()}}" class="btn btn-default">Back</a>

                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection