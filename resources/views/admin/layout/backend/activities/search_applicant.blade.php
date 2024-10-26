@extends('admin.layout.template')
@section('afterAllCss')
  <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/iCheck/all.css') }}">
  <!-- Select2 -->
  <link rel="stylesheet" href="{{ asset('plugins/select2/select2.min.css') }}">
@endsection
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <section class="content-header">
      <h1>Applicant Information</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Search Result</li>
      </ol>
    </section>
    <section class="content">
      <div class="row">
        <div class="col-md-8 col-md-offset-2">
          {{-- {{ print_r($residence) }} --}}
          <form class="form-horizontal" method="POST" action="{{ route('assignment') }}">
            {{ csrf_field() }}

          </form>
        </div>
      </div>
      <div style="margin-bottom: 15px">
        <a href="{{ url('/assign-room') }}" class="btn btn-default"><i class="fa fa-angle-left" aria-hidden="true"></i> Back</a>
      </div>


      <div class="row">
        <div class="col-md-3">

          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
              <img class="profile-user-img img-responsive img-circle" src="{{ App::isLocal() ? asset('img/avatar.jpg') : asset('public/img/avatar.jpg') }}" alt="User profile picture">

              <h3 class="profile-username text-center">{{ $applicant->surname." ".$applicant->firstname }}</h3>

              <p class="text-muted text-center">{{ $applicant->profession }}</p>

              @if ($applicant->confirmedpayment == 1)
                <p class="text-center" style="color:#00ad03"><i class="fa fa-check-circle" aria-hidden="true"></i> Authorized</p>
              @else
                <p class="text-center" style="color:#dc1e00"><i class="fa fa-times-circle" aria-hidden="true"></i> Not Authorized</p>
              @endif

              @if ($applicant->room_id && !is_null($applicant->room_id))
              <hr>
              <strong><i class="fa fa-bed margin-r-5"></i> Room No. </strong>
              @php
                $room = $rooms->where('id',$applicant->room_id)->first();
                // dd($room);
              @endphp
               @if(!is_null($room))
              {{$room->prefix." ".$room->room_no." ".$room->suffix }}
              {{-- @else --}}
              {{-- Room Not Available --}}
               @endif

              <p class="text-muted"><strong><i class="fa fa-building margin-r-5"></i></strong>
                {{ $room->block->name }}, {{ $room->residence->name }}
              </p>
              @endif

            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>

        <div class="col-md-9">
          <!-- About Me Box -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">About {{ $applicant->surname." ".$applicant->firstname }}</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="row">
                <div class="col-md-6">
                  <p><strong>Registration ID :</strong> {{ $applicant->reg_id }}</p>
                  <p><strong>Age :</strong> {{ $applicant->dob }} yrs</p>
                  {{-- <p>Date of Birth : {{ $applicant->dob }}</p> --}}
                  <p><strong>Nationality :</strong> {{ $applicant->nationality }}</p>
                  <p><strong>Contact :</strong> {{ $applicant->telephone }}</p>
                  <p><strong>Chapter :</strong> {{ isset($applicant->chapter)?$applicant->chapter:""}}</p>
                </div>
                <div class="col-md-6">
                  <p><strong>AGD Language :</strong> {{ $agd_language }}</p>
                  <p><strong>Category :</strong> {{ $camper_type }}</p>
                  <p><strong>Type :</strong> {{ $camper_fee_type }}</p>
{{--                  <p><strong>Accomodation Type :</strong> {{ $camper_acc_type }}</p>--}}

                  {{-- <p>Contact : {{ $applicant->telephone }}</p> --}}
                </div>
              </div>

            </div>
            <!-- /.box-body -->
          </div>

          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Fill Form</h3>
            </div>
            <div class="box-body">
              <form class="form-horizontal" method="POST" action="{{ route('assignment') }}">
                {{ csrf_field() }}
                {{-- <input type="hidden" value="$applicant->" name="residence_id"> --}}
                @php
                  if ($applicant->gender_id == 3) {
                    $app_gender = "M";
                  }
                    else {
                    $app_gender = "F";
                  }
                @endphp
                <input type="hidden" value="{{ $app_gender }}" name="gender" id="gnd">
                <input type="hidden" value="{{ $applicant->reg_id }}" name="registration_id">
                <p class="text text-warning">Please select the appropriate materials given to this Applicant</p>
                <div class="row">
                  <div class="col-md-8">
                    @foreach ($materials as $material)
                      <label style="margin-right: 15px">
                        <input type="checkbox" value="{{ $material->id }}"
                               @if (in_array($material->id, $regMaterialsArray))
                               checked disabled
                               @endif
                               name="materials[]" class="flat-red">
                        {{ $material->material }}
                      </label>
                    @endforeach
                  </div>
                  <div class="col-md-2">
                    <input id="agd" type="text" class="form-control" name="agd" value="{{ $applicant->agd_no }}" placeholder="AGD No." autofocus>
                  </div>
                  <div class="col-md-2">
                    <input id="qr_code" type="text" class="form-control" name="qr_code" value="@isset($qr_code){{$qr_code->code}}@endisset"
                           maxlength="4" placeholder="Qr Code" autofocus>
                  </div>
                  <hr>
                </div>
                <div class="row" style="margin-bottom: 15px">
                  <div class="col-md-12">
                  @if ($applicant->campfee_id != 43)

                    <div class="col-md-4">
                      {{-- {{ var_dump($residences->toJson()) }} --}}
                      <select class="form-control select2" data-placeholder="Select Residence" id="list_residences" name="residence_id" style="width: 100%;">
                        <option value="">-- Select Residence --</option>
                        @foreach ($residences as $residence)
                          @if ($residence->rooms->count() > 0)
                            <option value="{{ $residence->id }}">{{ $residence->name }}</option>
                          @endif

                        @endforeach
                      </select>
                      <!-- /.form-group -->
                    </div>
                    <div class="col-md-4">
                      <select class="form-control select2" required="required" id="list_blocks" name="block_id" style="width: 100%;">
                        <option value="">-- Select Block --</option>
                      </select>
                      <!-- /.form-group -->
                    </div>
                    <div class="col-md-2">

                      @isset ($room->room_no)
                      <button type="submit" class="btn btn-warning btn-flat"><i class="fa fa-hotel" aria-hidden="true"></i> Re-assign</button>
                      @endisset

                      @empty ($room->room_no)

                        <button type="submit" class="btn btn-success btn-flat"><i class="fa fa-hotel margin-r-5" aria-hidden="true"></i> Assign</button>

                        @endempty
                    </div>

                  @else
                    <div class="row table-responsive">
                      <div class="col-md-12">
                        <table class="table table-striped table-hover">
                          <thead>
                          <tr>
                            <th>No.</th>
                            <th>Room No.</th>
                            <th>Floor No.</th>
                            <th>Block</th>
                            <th>Residence</th>
                            <th>Beds Left</th>
                            <th>Action</th>
                          </tr>
                          </thead>
                          @php
                            $count = 1;
                            $app_gender = "";
                            if ($applicant->gender_id == 3) {
                              $app_gender = "F";
                            }else{
                              $app_gender = "M";
                            }

                            $not_full = $unfull->where('gender','!=',$app_gender)->where('special_acc',$applicant->specialaccom_id);

                          @endphp
                          @if (count($not_full) > 0)
                            @foreach ($not_full as $room)

                              @php
                                $room_info = $rooms->where('id',$room->room_id)->first();
                                $block_info = $blocks->where('id',$room->block_id)->first();
                                $res_info = $resid->where('id',$room->residence_id)->pluck('name')->first();

                              @endphp
                              <tr>
                                <td>
                                  <input type="radio" name="sp_accom" @if($applicant->room_id == $room->room_id) checked @endif required="required" value="{{ $room->room_id }}" class="flat-red">
                                </td>
                                <td><input type="hidden" name="room_name" value="{{ $room_info->prefix."".$room_info->room_no."".$room_info->suffix }}">{{ $room_info->prefix."".$room_info->room_no."".$room_info->suffix }}</td>
                                <td>{{ $room_info->floor_no }}</td>
                                <td><input type="hidden" name="block_name" value="{{ $block_info->name }}">{{ $block_info->name }}</td>
                                <td><input type="hidden" name="resid_name" value="{{ $res_info }}">{{ $res_info }}</td>
                                <td>{{ $room->assigned_to."/".$room->total_occupants }}</td>
                                <td><button class="btn btn-success btn-flat" type="submit">Assign</button></td>
                              </tr>

                              @php
                                $count +=1;
                              @endphp
                            @endforeach

                          @else
                            <tr><td colspan="7" style="text-align: center;">No Rooms available per request. Contact the Administrator.</td></tr>
                          @endif


                        </table>
                      </div>
                    </div>
                    @if (count($not_full) <= 0)
                      <input type="hidden" name="sp_accom" value="0">
                      <button type="submit" class="btn btn-success btn-flat"><i class="fa fa-save margin-r-5" aria-hidden="true"></i> Save</button>
                    @endif
                  @endif
                </div>
                </div>
              </form>
            </div>
          </div>
          <!-- /.box -->
        </div>
        <!-- /.nav-tabs-custom -->
      </div>
  </div>
  </section>
  </div>
@endsection
@section('afterMainScripts')
  <script src="{{ asset('plugins/select2/select2.full.min.js') }}"></script>
  <script src="{{ asset('plugins/icheck/icheck.min.js') }}"></script>
  <script>
      $(function () {

          $(".select2").select2({
              placeholder: "Choose..."
          });

      });
      $('#list_residences').on('change', function (e) {
          var residences = e.target.value;
         // alert(residences);
          var gender = $('#gnd').val();
          console.log(gender);
          $.get('/get_blocks?residence_id='+residences+'&gender='+gender, function (data) {
              console.log(residences);
              $('#list_blocks').empty();
              $('#list_blocks').append('<option value="" disabled="disabled" selected>Select Block</option>');

              $.each(data, function (index, brandObj) {
                  $('#list_blocks').append('<option value="'+brandObj.id+'">'+brandObj.name+'</option>');
              });
          });
      });
  </script>
  <script>
      //Flat red color scheme for iCheck
      $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
          checkboxClass: 'icheckbox_flat-green',
          radioClass   : 'iradio_flat-green'
      })
  </script>
@endsection
@section('afterOtherScripts')

@endsection