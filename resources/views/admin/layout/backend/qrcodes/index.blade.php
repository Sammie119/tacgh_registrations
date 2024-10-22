@extends('admin.layout.template')
@section('afterAllCss')
{{--    <link rel="stylesheet" href="{{asset('css/jquery-ui.min.css')}}">--}}
    {{--<link rel="stylesheet" href="{{asset('css/dataTables.bootstrap.css')}}">--}}
    <link rel="stylesheet" href="{{asset('css/jquery.dataTables.min.css')}}">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    {{--<link rel="stylesheet" href="{{ asset('css/all.css') }}">--}}
@endsection
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper bg-im">
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title">Qr Codes</h3>
                        </div>
                        <div class="box-body">
                            <!-- Date -->
                            <form action="{{route('qrcodes.generate')}}" id="schedule-submit" method="post">
                                {{csrf_field()}}
                                <div class="row">
                                    <div class="form-group col-md-3">
                                        <label>Length of Qr-Code</label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-arrows-h"></i>
                                            </div>
                                            <input type="number" min="1" value="20" id="length" required name="length" class="form-control pull-right">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Number to Generate</label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-balance-scale"></i>
                                            </div>
                                            <input type="number" min="1" value="10" id="quantity" required name="quantity" class="form-control pull-right">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Camper Tag Category</label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-caret-down"></i>
                                            </div>
                                        {!! Form::select('campercat',$camper_cats->prepend('Choose...',''),null,['class'=>'form-control pull-right']) !!}
                                    </div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <button type="submit" class="btn btn-primary btn-flat" style="margin-top: 2.5rem;">
                                            <i class="fa fa-refresh"></i> Generate
                                        </button>
                                    </div>
                                </div>
                            </form>
                            <h4>List of Qr-Codes</h4>
                            <hr/>
                            <div class="table-responsive">
                                <table id="dtrows" class="table table-striped table-bordered qrcodes">
                                    <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Camper ID</th>
                                        <th>Camper Category</th>
                                        <th>Code</th>
                                        <th>Qr Code</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    @php($count=1)
                                    @foreach($qr_codes as $qr_code)
                                        <tr>
                                        <td>{{$count++}}</td>
                                            <td>{{$qr_code->camper_id}}</td>
                                            <td>{{$qr_code->campercat->FullName}}</td>
                                        <td>{{$qr_code->code}}</td>
                                        <td>{{$qr_code->qrcode}}</td>
                                        <td>{{ ($qr_code->active_flag == 1)?"Active":"Inactive" }}</td>
                                            <td>
                                                    {!! Form::open(['method' => 'DELETE', 'route' => ['qrcodes.blockqrcode', $qr_code->id] ]) !!}
                                                    {!! Form::submit('Block Code', ['class' => 'btn btn-danger']) !!}
                                                    {!! Form::close() !!}
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!-- /.content-wrapper -->
@endsection
{{--@push('just-scripts')--}}
{{--@endpush--}}
@section('afterMainScripts')
    <script src="{{asset('js/jquery-ui.min.js')}}"></script>
    <script src="{{asset('js/jquery.dataTables.min.js')}}"></script>
    <script>
        $(document).ready(function() {
            $('#dtrows').DataTable();
        });
    </script>
@endsection