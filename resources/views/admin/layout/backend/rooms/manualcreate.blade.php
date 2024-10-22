@extends('admin.layout.template')
@section('afterAllCss')

@endsection
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <section class="content-header">
            <h1>Residences</h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Rooms</li>
            </ol>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-warning">
                        <div class="box-header with-border">
                            <h3 class="box-title">Manual Rooms Setup</h3>

                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>
                            </div>
                            <!-- /.box-tools -->
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <form action="{{route('rooms.savemanualrooms')}}" method="post">
                                {{csrf_field()}}
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="residence">Residence</label>
                                        <select type="text" name="residence" id="residence" required class="form-control">
                                            <option value="">Select Residence</option>
                                            @foreach($residence as $res)
                                                <option value="{{$res->id}}">{{$res->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="block">Block</label>
                                        <select name="block" disabled id="block" class="form-control">
                                            <option value="">Select Block</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="floor">Floor</label>
                                        <select name="floor" disabled id="floor" class="form-control">
                                            <option value="">Select Floor</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="numofoccupants">Occupants Per Room</label>
                                       <input type="number" name="numofoccupants" class="form-control" required/>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <label>
                                            <input type="checkbox"  name="specAccom" class="flat-red" id="specAccom" value="1"/>
                                           Special Accomodation
                                        </label>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="rooms">Rooms</label>
                                        <textarea class="form-control" name="rooms" id="rooms" cols="5" rows="5" placeholder="enter room numbers with comma separator"></textarea>
                                    </div>
                                </div>
                                <div style="margin-top: 15px">
                                    <button class="btn btn-success flat">Submit</button>
                                </div>
                            </form>
                        </div>
                        <!-- /.box-body -->
                    </div>

                </div>
            </div>
        </section>
        <!-- /.content-wrapper -->
    </div>
@endsection
@section('afterMainScripts')
    <script>
        $('#residence').on('change', function (e) {
            var residence = e.target.value;

            $.get('all-blocks?residence_id='+residence, function (data) {

                $('#floor').empty();
                $('#room').empty();
                $('#block').empty();
                $('#block').prop('disabled',false);
                $('#block').append('<option value="" disabled="disabled" selected>Select Block</option>');
                $.each(data, function (index, brandObj) {
                    $('#block').append('<option value="'+brandObj.id+'">'+brandObj.name+'</option>');
                });
            });
        });

        $('#block').on('change', function (e) {
            var block = e.target.value;
            $.get('all-floors?block='+block, function (data) {
                $('#floor').empty();
                $('#room').empty();
                $('#floor').prop('disabled',false);
                $('#floor').append('<option value="" disabled="disabled" selected>Select Floor</option>');
                for (var i = 1; i <= data; i++) {
                    $('#floor').append('<option value="'+i+'">Floor '+i+'</option>');
                }
            });
        });
    </script>
@endsection