@extends('admin.layout.template')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Setup Lookup</div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{ route('lookupcode.store') }}">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('LookUpName') ? ' has-error' : '' }}">
                                <label for="LookUpName" class="col-md-4 control-label">Lookup Name</label>

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
                                <label for="website" class="col-md-4 control-label">Short Name</label>

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
                                <label for="phone" class="col-md-4 control-label">Active?</label>

                                <div class="col-md-1">
                                    <input id="ActiveFlag" type="checkbox" class="form-control" name="ActiveFlag" required>

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
                                    <button type="button" class="btn btn-primary">
                                        <a href="{{route('lookupcode.index')}}">Go Back</a>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection