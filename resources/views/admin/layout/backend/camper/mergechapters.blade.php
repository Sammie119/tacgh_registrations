@extends('admin.layout.template')
@section('afterAllCss')
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
@endsection
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper bg-im">
        <section class="content">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <form method="GET" action="{{ route('batchregistration.mergechapters') }}">
                        {{ csrf_field() }}
                    <div class="col-lg-6 col-md-6">
                        <div class="form-box-m box">
                            <h4 style="text-align: center">(Primary Chapter)</h4>
                            <p style="color:green;font-weight: bold">This chapter ID and ambassador details is what is retained in the system</p>
                            <hr>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group{{ $errors->has('batch_no') ? ' has-error' : '' }}">
                                            <label for="batch_no" class="control-label">Batch Number <span class="required">*</span></label>
                                            <input id="batch_no" value="{{old('batch_no')}}" type="text" class="form-control" name="batch_no" required autocomplete="off">
                                            @if ($errors->has('batch_no'))
                                                <span class="help-block">
                                                <strong>{{ $errors->first('batch_no') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group{{ $errors->has('btoken') ? ' has-error' : '' }}">
                                            <label for="btoken" class="control-label">Token <span class="required">*</span></label>
                                            <input id="btoken" value="{{old('btoken')}}" type="text" class="form-control token-field" name="btoken" autocomplete="off">
                                            @if ($errors->has('btoken'))
                                                <span class="help-block">
                                            <strong>{{ $errors->first('btoken') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="form-box-m box">
                            <h4 style="text-align: center">(Secondary Chapter)</h4>
                            <p style="color:red;font-weight: bold">This Chapter ID cannot be used anymore after merge</p>
                            <hr>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group{{ $errors->has('secondary_batch_no') ? ' has-error' : '' }}">
                                            <label for="secondary_batch_no" class="control-label">Batch Number <span class="required">*</span></label>
                                            <input id="secondary_batch_no" value="{{old('secondary_batch_no')}}" type="text" class="form-control" name="secondary_batch_no" required autocomplete="off">
                                            @if ($errors->has('secondary_batch_no'))
                                                <span class="help-block">
                                                <strong>{{ $errors->first('secondary_batch_no') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group{{ $errors->has('secondary_token') ? ' has-error' : '' }}">
                                            <label for="secondary_token" class="control-label">Token <span class="required">*</span></label>
                                            <input id="secondary_token" value="{{old('secondary_token')}}" type="text" class="form-control token-field" name="secondary_token" autocomplete="off">
                                            @if ($errors->has('secondary_token'))
                                                <span class="help-block">
                                            <strong>{{ $errors->first('secondary_token') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                        </div>
                </div>
                        <div class="col-lg-12">
                        <div class="row">
                                <div class="container-fluid">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-success btn-labl">
                                            Merge Chapters
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
            </div>
            </div>
        </section>
    </div>
    <!-- /.content-wrapper -->
@endsection