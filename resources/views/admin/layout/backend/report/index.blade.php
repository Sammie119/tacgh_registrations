@extends('admin.layout.template')
@section('afterAllCss')
  <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/iCheck/all.css') }}">
@endsection
@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Generate Reports
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Report</li>
      </ol>
    </section>

    <section class="content">
	    <div class="row">
	        <div class="col-md-6">
	        	<div class="box box-solid">
		            <div class="box-header with-border">
		                <h4>Report on Applicants</h4>
		            </div>
		            <div class="box-body ireport">
		            	<p class="text text-info" style="margin-bottom: 15px"><i class="fa fa-filter"></i> Filter report by selecting any of the list below</p>
			            <form class="form-horizontal" target="_blank" method="GET" action="{{ route('report.campers') }}">
			                {{ csrf_field() }}
			                <label style="margin-right: 15px">
		                        <input type="checkbox" value="camper_type" name="camper_type" class="flat-red camp">
		                         Type of Camper
		                    </label><br>
		                    <label style="margin-right: 15px">
		                        <input type="checkbox" value="gender" name="gender" class="flat-red camp">
		                         Gender
		                    </label><br>
		                    {{-- <label style="margin-right: 15px">
		                        <input type="checkbox" value="chapter" name="chapter" class="flat-red camp">
		                         Chapter
		                    </label> --}}

			                <div class="form-group">
			                    <div class="col-md-6 col-md-offset-4">
			                        {{-- <a href="{{ route('residence.blocks',$block->residence_id) }}" class="btn btn-default"><i class="fa fa-times"></i> Cancel</a> --}}
			                        <button type="submit" class="btn btn-success btn-flat">
			                            <i class="fa fa-bar-chart"></i> Generate
			                        </button>
			                    </div>
			                </div>
			            </form>
			        </div>
			    </div>
			</div>
	        <div class="col-md-6">
	        	<div class="box box-solid">
		            <div class="box-header with-border">
		                <h4>Report on Accounts</h4>
		            </div>
		            <div class="box-body ireport">
		            	<p>Filter report by selecting any of the list below</p>
			            <form class="form-horizontal" target="_blank" method="GET" action="{{ route('report.accounts') }}">
			                {{ csrf_field() }}
			                <label style="margin-right: 15px">
		                        <input type="checkbox" value="camper_type" name="camper_type" class="flat-red">
		                         Type of Camper
		                    </label><br>
		                    <label style="margin-right: 15px">
		                        <input type="checkbox" value="per_day" name="per_day" class="flat-red">
		                         Per Day
		                    </label><br>

			                <div class="form-group">
			                    <div class="col-md-6 col-md-offset-4">
			                        {{-- <a href="{{ route('residence.blocks',$block->residence_id) }}" class="btn btn-default"><i class="fa fa-times"></i> Cancel</a> --}}
			                        <button type="submit" class="btn btn-success btn-flat">
			                            <i class="fa fa-bar-chart"></i> Generate
			                        </button>
			                    </div>
			                </div>
			            </form>
			        </div>
			    </div>
			</div>
		</div>
	</section>
</div>
@endsection
@section('afterMainScripts')
  <script src="{{ asset('plugins/icheck/icheck.min.js') }}"></script>
  
  <script>
    //Flat red color scheme for iCheck
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
      checkboxClass: 'icheckbox_flat-green',
      radioClass   : 'iradio_flat-green'
    })
    // $('.camp').cheeck
</script>
@endsection