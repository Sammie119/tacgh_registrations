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
        <li class="active">Residences</li>
      </ol>
    </section>
  <section class="content">
    <div class="row">
        <div class="col-md-12">
          <div class="box box-warning">
            <div class="box-header with-border">
              <h3 class="box-title">Set Gender for Rooms</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <form action="{{route('residence.set_gender')}}" method="post">
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
                    <label for="room">Room</label>
                    <select name="room" disabled id="room" class="form-control">
                      <option value="">Select Room</option>
                    </select>
                  </div>
                  <div class="col-md-7" style="margin-top: 10px;">
                    <label for="gender" class="control-label">Gender</label>
                    <div clas="col-md-2">
                      <label style="margin-top: 5px; margin-right: 5px;">
                        <input type="radio" required name="gender" class="flat-red" value="M">
                        Male
                      </label>
                      <label style="margin-top: 5px; margin-right: 5px;">
                        <input type="radio" required name="gender" class="flat-red" value="F">
                        Female
                      </label>
                      <label style="margin-top: 5px; margin-right: 5px;">
                        <input type="radio" required name="gender" value="A" class="flat-red">
                        Mixed
                      </label>
                    </div>
                  </div>
                    <div class="col-md-5" style="margin-top: 10px;">
                        <label for="assign" class="control-label">Assign?</label>
                        <div clas="col-md-2">
                            <label style="margin-top: 5px; margin-right: 5px;">
                                <input type="radio" name="assign" class="flat-red" value="0">
                                No
                            </label>
                            <label style="margin-top: 5px; margin-right: 5px;">
                                <input type="radio" name="assign" checked class="flat-red" value="1">
                                Yes
                            </label>
                        </div>
                    </div>
                </div>
                <div style="margin-top: 15px">
                  <button class="btn btn-success flat">Submit</button>
                </div>
              </form>
            </div>
            <!-- /.box-body -->
          </div>
          <div class="box box-solid">
            <div class="box-header">
              <div class="row" style="margin-bottom: 10px">
                <div class="col-md-4">
                  <h3 style="margin-top:20px;font-size: 20px;">All Residences</h3>
                </div>
                <div class="col-md-4 text-center">

                </div>
                <div class="col-md-4 text-right">
                  <a href="{{ url('/residence/create') }}" class="btn bg-orange btn-flat margin">Add Residence</a>
                </div>
              </div>
            </div>  
            
            <div class="box-body">

              <div class="table-responsive">
                <table id="residences" class="table table-bordered table-striped table-hover">
                  <thead>
                    <tr>
                      <td>No.</td>
                      <td>Name</td>
                      <td>Total Blocks</td>
                      <td>Total Rooms</td>
                      <td>Gender</td>
                      <td>Operation</td>
                    </tr>
                  </thead>
                  <tbody>
                    @php
                      $count = 1;
                    @endphp
                    @foreach($residence as $res)
                        @php
                          if ($res->gender == "M") {
                            $gender = "Male";
                          }elseif($res->gender == "F"){
                            $gender = "Female";
                          }elseif ($res->gender == "A") {
                            $gender = "Mixed";
                          }else{
                            $gender = "";
                          }
                        @endphp
                      <tr>
                        <td>{{ $count++ }}</td>
                        <td>{{ $res->name }}</td>
                        <td>{{ $res->blocks->count() }}</td>
                        <td>{{ $res->rooms->count() }}</td>
                        <td>{{ $gender}}</td>
                        <td>
                          {{-- <form action="{{ url('residence/'.$res->id) }}" method="POST" class="pull-left" style="margin-right:3px">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <button type="submit" class="btn btn-danger btn-flat"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                            
                              </form> --}} 
                          <a href="{{ url('/residence/'.$res->id.'/edit') }}" class="btn btn-success btn-flat"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>
                          <a href="{{ url('/residence/'.$res->id.'/blocks') }}" class="btn btn-primary btn-flat"><i class="fa fa-th-large" aria-hidden="true"></i> Blocks</a>
                        </td>
                      </tr>

                    @endforeach
                  </tbody>
                </table>
              </div>
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

  {{-- @include('sweet::alert') --}}
{{-- @if (Session::has('sweet_alert.alert'))
    <script>
        swal({!! Session::get('sweet_alert.alert') !!});
    </script>
@endif --}}

@endsection

@section('afterOtherScripts')
{{--<script src="{{ asset('plugins/datatables/datatables.bootstrap.min.js') }}"></script>--}}
{{--<script src="{{ asset('plugins/datatables/jquery.datatables.min.js') }}"></script>--}}
{{--<script src="{{ asset('plugins/icheck/icheck.min.js') }}"></script>--}}
<script>
    //Flat red color scheme for iCheck
    // $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
    //     checkboxClass: 'icheckbox_flat-green',
    //     radioClass   : 'iradio_flat-green'
    // });

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
        // var residence = $('#residence').val();
        // var block = $('#block').val();
        console.log(block+" "+residence);
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

    $('#floor').on('change', function (e) {
        var floor = e.target.value;
        var residence = $('#residence').val();
        var block = $('#block').val();

        $.get('all-rooms?residence='+residence+'&block='+block+'&floor='+floor, function (data) {
            $('#room').empty();
            $('#room').prop('disabled',false);
            $('#room').append('<option value="" disabled="disabled" selected>Select Room</option>');
            $.each(data, function (index, brandObj) {
                $('#room').append('<option value="'+brandObj.id+'">'+brandObj.room_no+'</option>');
            });
        });
    });
</script>
@endsection