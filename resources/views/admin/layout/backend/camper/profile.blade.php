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
        <li class="active">Profile</li>
      </ol>
    </section>
  <section class="content">
    <div style="margin-bottom: 15px">
      <a href="{{URL::previous() }}" class="btn btn-default"><i class="fa fa-angle-left" aria-hidden="true"></i> Back</a>
    </div>
    

    <div class="row">
      <div class="col-md-3">

        <!-- Profile Image -->
        <div class="box box-primary">
          <div class="box-body box-profile">
            @if($applicant->region->FullName == "Male")
            <img class="profile-user-img img-responsive img-circle" src="{{ App::isLocal() ? asset('img/male-avatar.jpg') : asset('public/img/male-avatar.jpg') }}" alt="User profile picture">
            @else
            <img class="profile-user-img img-responsive img-circle" src="{{ App::isLocal() ? asset('img/female-avatar.jpg') : asset('public/img/female-avatar.jpg') }}" alt="User profile picture">
            @endif

            <h3 class="profile-username text-center">{{ $applicant->surname." ".$applicant->firstname }}</h3>

            <p class="text-muted text-center">{{ $applicant->profession }}</p>

                @if ($applicant->confirmedpayment == 1)
                  <p class="text-center" style="color:#00ad03"><i class="fa fa-check-circle" aria-hidden="true"></i> Authorized</p>
                @else
                  <p class="text-center" style="color:#dc1e00"><i class="fa fa-times-circle" aria-hidden="true"></i> Not Authorized</p>
                @endif
            
            @isset ($applicant->room_id)
            <hr>
                <strong><i class="fa fa-bed margin-r-5"></i> Room No. </strong> 
              @php
                $room = $rooms->where('id',$applicant->room_id)->first();
              @endphp
              {{$room->prefix." ".$room->room_no." ".$room->suffix }}

              <p class="text-muted"><strong><i class="fa fa-building margin-r-5"></i></strong> {{ $room->block->name }}, {{ $room->residence->name }}</p>
            @endisset
            
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>

      <div class="col-md-9">
        <!-- About Me Box -->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">About Me</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <table class="table table-bordered table-striped">
              <tr>
                <th>Registration ID</th><td>{{ $applicant->reg_id }}</td>
                <th>Age</th><td>{{ $applicant->dob }}</td>
              </tr>
              <tr>
                <th>Gender</th><td>{{ $applicant->gender->FullName }}</td>
                <th>Contact</th><td>{{ $applicant->telephone }}</td>
              </tr>
              <tr>
                <th>Region</th><td>{{ $applicant->region->FullName }}</td>
                <th>Marital Status</th><td>{{ $applicant->maritalstatus->FullName }}</td>
              </tr>
              <tr>
                <th>Nationality</th><td>{{ $applicant->nationality }}</td>
                <th>Local Assembly</th><td>{{ $applicant->localassembly }}</td>
              </tr>
              <tr>
                <th>Chapter</th><td>{{ $applicant->chapter }}</td>
                <th>Area</th><td>{{ $applicant->area->FullName }}</td>
              </tr>
              <tr>
                <th>AGD Language</th><td>{{ $applicant->agdlang->FullName }}</td>
                <th>Camper Type</th><td>{{ $applicant->campercat->FullName }}</td>
              </tr>
              <tr>
                <th>Camper Fee Type</th><td>{{ $applicant->campfee->FullName }}</td>
                <th>Accomodation Type</th><td></td>
              </tr>
            </table>
            </div>
            
          </div>
          <!-- /.box-body -->
        </div>
      </div>
          <!-- /.nav-tabs-custom -->
      </div>
    </div>
  </section>
</div>
@endsection
@section('afterMainScripts')
  
@endsection