@extends('admin.layout.template')
@section('afterAllCss')
<link rel="stylesheet" href="{{ asset('plugins/icheck/all.css') }}">
@endsection
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content-header">

        <h1>{{ $room->residence->name }}</h1>
        <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{url('/residence/'.$room->residence_id.'/blocks') }}"><i class="fa fa-building-o"></i> Residences</a></li>
        <li><a href="{{url('block/'.$room->block_id.'/rooms') }}"><i class="fa fa-building-o"></i> block</a></li>
        <li class="active">Room {{ $room->prefix." ".$room->room_no." ".$room->suffix }}</li>
      </ol>

    </section>
    <section class="content">
    	<div class="form-group">
    		<a href="{{URL::previous() }}" class="btn btn-default btn-flat"><i class="fa fa-angle-left"></i> Go back</a>
    		{{-- <a href="{{url('block/'.$room->block_id.'/rooms') }}" class="btn btn-default btn-flat"><i class="fa fa-angle-left"></i> Go back</a> --}}
    	</div>
    	@hasanyrole(['SysDeveloper',"SuperAdmin"])
	    <div class="row">
	        <div class="col-md-12">
	          	<div class="box box-solid">
		            <div class="box-header with-border">
		                <h4>Room {{ $room->prefix." ".$room->room_no." ".$room->suffix }}</h4>
		            </div>
		            <div class="box-body ">
						<form class="form-horizontal" method="POST" action="{{ url('/room/'.$room->id) }}">
			                {{ csrf_field() }}
			                {{ method_field('PUT') }}

			                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
								
								<label for="name" class="col-md-2 control-label">Name</label>
			                	<div class="col-md-3">
			                        <input id="name" type="text" maxlength="20" class="form-control" name="name" value="{{ $room->name }}" autofocus>

			                        @if ($errors->has('name'))
			                            <span class="help-block">
			                                <strong>{{ $errors->first('name') }}</strong>
			                            </span>
			                        @endif
			                    </div>
			                    <label for="roomNo" class="col-md-1 control-label">Room</label>

			                    <div class="col-md-1">
			                        <input id="roomNo" type="number" class="form-control" name="room_no" readonly value="{{ $room->room_no }}" required>
			                    </div>
			                    <label for="roomNo" class="col-md-1 control-label">Floor</label>

			                    <div class="col-md-1">
			                        <input id="roomNo" type="number" class="form-control" name="floor_no" readonly value="{{ $room->floor_no }}" required>
			                    </div>
			                    <label for="roomNo" class="col-md-1 control-label">Block</label>

			                    <div class="col-md-2">
			                        <input id="roomNo" type="text" class="form-control" name="block_name" readonly value="{{ $room->block->name }}" required>
			                    </div>
			                </div>

			                <div class="form-group">
			                    <label for="residence" class="col-md-2 control-label">Residence</label>

			                    <div class="col-md-3">
			                        <input id="residence" type="text" class="form-control" name="residence" value="{{ $room->residence->name }}" readonly disabled required>
			                    </div>

			                    <label for="prefix" class="col-md-1 control-label">Prefix</label>
			                    <div class="col-md-1">
			                        <input id="prefix" type="text" maxlength="5" class="form-control" name="prefix" value="{{ $room->prefix }}" autofocus>

			                        @if ($errors->has('prefix'))
			                            <span class="help-block">
			                                <strong>{{ $errors->first('prefix') }}</strong>
			                            </span>
			                        @endif
			                    </div>

			                    <label for="suffix" class="col-md-1 control-label">Suffix</label>
			                    <div class="col-md-1">
			                        <input id="suffix" type="text" maxlength="5" class="form-control" name="suffix" value="{{ $room->suffix }}" autofocus>

			                        @if ($errors->has('suffix'))
			                            <span class="help-block">
			                                <strong>{{ $errors->first('suffix') }}</strong>
			                            </span>
			                        @endif
			                    </div>

			                    <label for="assign" class="col-md-1 control-label">Assign</label>
			                    <div class="col-md-2">
			                      	<label style="margin-top: 5px; margin-right: 5px;">
					                  <input type="radio" name="assign" class="flat-red" value="1" @if ($room->assign == '1') checked @endif>
					                  Yes 
					                </label>
					                <label style="margin-top: 5px; margin-right: 5px;">
					                  <input type="radio" name="assign" value="0" class="flat-red"  @if ($room->assign == '0') checked @endif>
					                  No
					                </label>
				                      	
				                </div>
			                    
			                </div>

			                <div class="form-group">
			                    <label for="type" class="col-md-2 control-label">Room Type</label>
			                    <div class="col-md-3">
			                        <select class="form-control" name="type" id="type">
			                        	<option @if ($room->type == 'Regular') selected @endif value="Regular">Regular</option>
			                        	<option @if ($room->type == 'Reserved') selected @endif value="Reserved">Reserved</option>
			                        </select>
			                    </div>

			                    <label for="beds" class="col-md-1 control-label">Beds</label>
			                    <div class="col-md-1">
			                        <input id="beds" type="number" required min="1" max="100" class="form-control" name="beds" value="{{ $room->total_occupants }}" autofocus>

			                        @if ($errors->has('beds'))
			                            <span class="help-block">
			                                <strong>{{ $errors->first('beds') }}</strong>
			                            </span>
			                        @endif
			                    </div>

			                    {{-- <label for="suffix" class="col-md-1 control-label">Color</label>
			                    <div class="col-md-1">
			                        <input id="color" type="color" class="form-control" name="color" value="{{ $room->floor_color }}" required autofocus>
			                    </div> --}}
			                    <label for="accom" class="col-md-2 control-label">Accomodation Type</label>
			                    <div class="col-md-3">
			                        <select class="form-control" disabled required name="accom" id="accom">
			                        	<option value="">Please Choose Accomodation</option>
			                        	@foreach ($special as $accom)
			                        		<option @if ($room->special_acc == $accom->id) selected @endif value="{{ $accom->id }}">{{ $accom->FullName }}</option>
			                        	@endforeach
			                        </select>
			                    </div>
			                </div>

			                <div class="form-group">
			                    
			                    <label for="gender" class="col-md-2 control-label">Gender</label>
			                    <div class="col-md-4">
			                      	<label style="margin-top: 5px; margin-right: 5px;">
					                  <input type="radio" name="gender" class="flat-red" value="M" @if ($room->gender == 'M') checked @endif>
					                  Male 
					                </label>
			                      	<label style="margin-top: 5px; margin-right: 5px;">
					                <input type="radio" name="gender" class="flat-red" value="F" @if ($room->gender == 'F') checked @endif>
					                  Female 
					                </label>
					                <label style="margin-top: 5px; margin-right: 5px;">
					                  <input type="radio" name="gender" value="A" class="flat-red"  @if ($room->gender == 'A') checked @endif>
					                  Mixed
					                </label>
				                </div>
			                </div>
		            		<div class="box-footer ">
				                <div class="form-group">
				                    {{-- <div class="col-md-2 col-md-offset-2">
				                        <a href="{{url('block/'.$room->block_id.'/rooms') }}" class="btn btn-default btn-flat"><i class="fa fa-times"></i> Cancel</a>
				                    </div> --}}

				                    <div class="col-md-4">
				                        <button type="submit" class="btn btn-success btn-flat pull-right">
				                            <i class="fa fa-save"></i> Save & Continue
				                        </button>
				                    </div>

				                    {{-- <div class="col-md-4">
				                        <form action="{{ url('room/'.$room->id) }}" method="POST" class="pull-left" style="margin-right:3px">
			                              {{ csrf_field() }}
			                              {{ method_field('DELETE') }}
			                              <button type="submit" class="btn btn-danger btn-flat  pull-right"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete Room</button>
			                          
			                            </form> 
				                    </div> --}}
				                </div>
			            	</div>
			            </form>
		            </div>
		        </div>
		    </div>
		</div>
		@endrole


	    <div class="row">
	        <div class="col-md-3">
	          	<div class="box box-solid">
		            <div class="box-header with-border">
		                <h4>Add applicant here</h4>
		            </div>
		            <div class="box-body ">
		            	@if($room->total_occupants == $room_mates->count())
							<p class="label bg-green">The room is up to capacity.</p>
						@elseif($room->total_occupants < $room_mates->count())
							<p class="label bg-yellow">The room is overpopulated!</p>
						@else
							<form action="{{ route('manual.assignment') }}" method="POST">
								{{ csrf_field() }} {{ method_field('put') }}
								<input type="hidden" name="r_id" value="{{ $room->id }}">
								<input type="hidden" name="r_app" value="{{ $room_mates->count() }}">
								<div class="input-group input-group-sm">
					                <input type="text" placeholder="Reg ID" name="applicant_no" required id="applicant_no" class="form-control">
					                    <span class="input-group-btn">
					                      <button type="submit" class="btn btn-info btn-flat">Add Applicant</button>
					                    </span>
					              </div>
							</form>
						@endif
		            </div>
		        </div>
	          	<div class="box box-solid">
		            <div class="box-header with-border">
		                <h4>Transfer applicant here</h4>
		            </div>
		            <div class="box-body ">
		            	@if($room->total_occupants == $room_mates->count())
							<p class="label bg-green">The room is up to capacity.</p>
						@elseif($room->total_occupants < $room_mates->count())
							<p class="label bg-yellow">The room is overpopulated!</p>
						@else
							<form action="{{ route('manual.transfer') }}" method="POST">
								{{ csrf_field() }} {{ method_field('put') }}
								<input type="hidden" name="r_id" value="{{ $room->id }}">
								<input type="hidden" name="r_app" value="{{ $room_mates->count() }}">
								<div class="input-group input-group-sm">
					                <input type="text" placeholder="Reg ID" name="applicant_no" required id="applicant_no" class="form-control">
					                    <span class="input-group-btn">
					                      <button type="submit" class="btn btn-warning btn-flat">Transfer</button>
					                    </span>
					              </div>
							</form>
						@endif
		            </div>
		        </div>
		    </div>
	        <div class="col-md-9">
	            <div class="box box-primary">
	                <div class="box-body table-responsive">
	                    <h4>Room Information <small>(Capacity : {{ $room->total_occupants }}) 
	                    	Left : {{ $room->total_occupants - $room_mates->count() }}</small></h4><hr>
	                    <table class="table table-hover table-striped">
	                    	<thead>
	                    		<tr>
	                    			<th>Reg#</th>
	                    			<th>Name</th>
	                    			<th>Area</th>
	                    			<th>Local Assembly</th>
	                    			<th>Contact</th>
									<th>Action</th>
	                    		</tr>
	                    	</thead>
	                    	<tbody>
	                    			@if ($room_mates->count('room_id') < 1)
	                    				<td colspan="5" style="text-align: center;">No occupants available</td>
	                    			@else
	                    				@php
	                    					$count = 1;
	                    				@endphp
	                    				@foreach ($room_mates as $room_mate)
	                    					<tr>
												<td>{{ $room_mate->reg_id }}</td>
												<td>{{ $room_mate->firstname." ".$room_mate->surname }}</td>
												<td>{{ $room_mate->area->FullName }}</td>
												<td>{{ $room_mate->localassembly }}</td>
												<td>{{ $room_mate->telephone }}</td>
												<td><a href="{{ route('rooms.remove_room_mate', [$room_mate->id]) }}" class="btn btn-danger btn-flat  pull-right">
														<i class="fa fa-trash-o" aria-hidden="true"></i>
													</a>
												</td>
	                    					</tr>
	                    				@endforeach
		                    			
	                    			@endif
	                    	</tbody>
	                    </table>
						@if($room_mates->count('room_id') > 0)
						<div style="margin-top: 10px;">
							<form action="{{ route('room.clear_members') }}" method="POST" class="pull-left" style="margin-right:3px">
							  {{ csrf_field() }}
								<input type="hidden" name="room_id" value="{{$room->id}}">
							  <button type="submit" class="btn btn-danger btn-flat  pull-right">
								  <i class="fa fa-trash-o" aria-hidden="true"></i> Clear Room
							  </button>
							</form>
						</div>
						@endif
	                </div>
	            </div>
	        </div>
	    </div>
	</section>
</div>

@endsection
@section('afterOtherScripts')
<script src="{{ asset('plugins/icheck/icheck.min.js') }}"></script>
<script>
	 $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
      checkboxClass: 'icheckbox_minimal-blue',
      radioClass   : 'iradio_minimal-blue'
    })
    //Red color scheme for iCheck
    $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
      checkboxClass: 'icheckbox_minimal-red',
      radioClass   : 'iradio_minimal-red'
    })
    //Flat red color scheme for iCheck
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
      checkboxClass: 'icheckbox_flat-green',
      radioClass   : 'iradio_flat-green'
    })

    $('#type').change(function(){
    	if (this.value == 'Regular') {
    		$('select#accom').attr("disabled","disabled")
    		$('#beds').removeAttr("readonly","readonly")
    	}

    	if (this.value == 'Reserved') {
    		$('select#accom').removeAttr("disabled","disabled")
    		$('#beds').attr("readonly","readonly")
    	}
    	
    });

    $('#accom').change(function(){
    	if (this.value == 44 || this.value == 46) {
    		$('#beds').val(2)
    	}
    	if (this.value == 45 || this.value == 47) {
    		$('#beds').val(1)
    	}
    });
</script>
@endsection