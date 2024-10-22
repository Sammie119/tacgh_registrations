@extends('admin.layout.template')
@section('afterAllCss')
<link rel="stylesheet" href="{{ asset('plugins/iCheck/all.css') }}">
@endsection
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <section class="content-header">
    <h1>{{ $residence->name }}</h1>
      {{--<ol class="breadcrumb">--}}
        {{--<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>--}}
        {{--<li><a href="{{ route('residence.index') }}"><i class="fa fa-building-o"></i> Residences</a></li>--}}
        {{--<li class="active">{{ $residence->name }}</li>--}}
      {{--</ol>--}}
    </section>
  <section class="content">
    <div class="row">
        <div class="col-md-12">
          @if (count($blocks) < $residence->total_blocks)
          {{-- @if (count($blocks) == 0 ) --}}
            <div class="box box-solid">
              <div class="box-header">
                  
                  <div class="row">
                    <div class="col-md-12">
                      <h3 style="margin-top:20px;font-size: 20px;">{{ $residence->name }} - Adding Blocks</h3>
                    </div>
                  </div>
              </div>
              <div class="box-body">
                <form class="form-horizontal" method="POST" action="{{ route('residence.add_blocks',[$venue_slug,$residence->id]) }}">
                {{ csrf_field() }}
                <input type="hidden" value="{{ $residence->id }}" name="residence_id">
                <input type="hidden" value="{{ $residence->gender }}" name="gender">
                <input type="hidden" value="{{ $residence->total_blocks }}" name="residence_blocks">
                <input type="hidden" value="{{ $residence->total_blocks - count($blocks) }}" name="residence_blocks_now">
                <input type="hidden" value="{{ $residence->total_rooms }}" name="residence_rooms">
                <input type="hidden" value="{{ $residence->total_rooms - count($residence->rooms)}}" name="residence_rooms_left">
                @section('method')

                @show
                <div class="table-responsive">
                  <table id="residences" class="table table-bordered table-striped table-hover">
                    <thead>
                      <tr>
                        <th>Name</th>
                        <th>Number of Rooms</th>
                        <th>Number of Floors</th>
                        <th>Gender</th>
                      </tr>
                    </thead>
                    <tbody>
                      @for ($count = 1; $count <= $residence->total_blocks - count($blocks); $count++)

                        <tr>

                          <td class="{{ $errors->has('name') ? ' has-error' : '' }}"><input id="name_{{ $count }}" type="text" class="form-control" name="name[]" value="{{ old('name[]') }}" placeholder="Block Name" required autofocus>

                            @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                          </td>

                          <td class="{{ $errors->has('rooms') ? ' has-error' : '' }}"><input id="rooms_{{ $count }}" type="number"
                                 max="20000" class="form-control" name="rooms[]" placeholder="No. of Rooms" value="{{ old('rooms[]') }}" autofocus>

                            @if ($errors->has('rooms'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('rooms') }}</strong>
                                </span>
                            @endif
                          </td>

                          <td class="{{ $errors->has('floors') ? ' has-error' : '' }}"><input id="floors_{{ $count }}" type="number" required
                              min="1" max="100" class="form-control" name="floors[]" placeholder="No. of Floors" value="{{ old('floors[]') }}" autofocus>

                            @if ($errors->has('floors'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('floors') }}</strong>
                                </span>
                            @endif
                          </td>

                          <td class="{{ $errors->has('gender') ? ' has-error' : '' }}">
                            @if ($residence->gender == "A")

                              <label style="margin-top: 5px; margin-right: 5px;">
                                <input type="radio" name="gender[{{ $count }}]" class="flat-red" value="M" @if(old('gender') == "M") checked @endif >
                                <strong>Male</strong> 
                              </label>

                              <label style="margin-top: 5px; margin-right: 5px;">
                                <input type="radio" name="gender[{{ $count }}]" class="flat-red" value="F"  @if(old('gender') == "F") checked @endif >
                                <strong>Female </strong>
                              </label>

                              <label style="margin-top: 5px; margin-right: 5px;">
                                <input type="radio" name="gender[{{ $count }}]" value="A" class="flat-red"  @if(old('gender') == "A") checked @endif >
                                <strong>All</strong>
                              </label>

                            @elseif ($residence->gender == "F")
                              <strong>FEMALE</strong><input id="gender" type="hidden" class="form-control" name="gender_{{ $count }}" value="F">
                            @else
                              <strong>MALE</strong><input id="gender" type="hidden" class="form-control" name="gender_{{ $count }}" value="M">
                            @endif
                          </td>
                        </tr>

                      @endfor
                    </tbody>
                  </table>
                </div>
                <p class="text text-danger"><em>The <strong> Total rooms</strong> assigned to Blocks cannot be more than the specified total for the <strong>Residence ({{ $residence->total_rooms }} rooms) -- ({{ $residence->total_rooms - count($residence->rooms)}} more left)</strong></em></p>
                {{-- <div id="checker-box">
                  <p>Rooms : <span id="input-rooms">0</span> / <span id="tot-rooms">{{ $residence->total_rooms }}</span></p>
                </div> --}}
                <a href="{{ url('/residence') }}" class="btn btn-default"><i class="fa fa-angle-left"></i> Back</a>
                <button type="submit" id="save_date" class="btn btn-success pull-right">
                  <i class="fa fa-floppy-o" aria-hidden="true"></i> Save
                </button>
              </form>
              </div>
            </div>
          @else
            <div class="box box-solid">
              <div class="box-header">
                  
                <h3 style="font-size: 20px;">{{ $residence->name }} - Blocks</h3>
                    
              </div>
              <div class="box-body">
                <div class="table-responsive">
                  <table id="residences" class="table table-bordered table-striped table-hover">
                    <thead>
                      <tr>
                        <th>No.</th>
                        <th>Name</th>
                        <th>No. of Floors</th>
                        <th>Total Rooms</th>
                        <th>Operations</th>
                      </tr>
                    </thead>
                    <tbody>
                      @php
                        $count = 1;
                        $tfloors = 0;
                        $trooms = 0;
                      @endphp
                      @foreach($blocks as $block)
                        @php
                          $tfloors += $block->total_floors;
                          $trooms += $block->total_rooms;
                        @endphp
                        <tr>
                          <td>{{ $count++ }}</td>
                          <td>{{ $block->name }}</td>
                          <td>{{ $block->total_floors }}</td>
                          <td>{{ $block->rooms->count() }}</td>
                          <td>
                            <a href="{{ url('/block/'.$block->id.'/edit') }}" class="btn btn-primary btn-flat"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>
                            @if(count($block->rooms) == null or count($block->rooms->groupBy('floor_no')) == null)

                              <a href="{{ url('/block/'.$block->id.'/generate_room') }}" class="btn btn-danger btn-flat"><i class="fa fa-cogs" aria-hidden="true"></i> Generate Rooms</a> 

                            @elseif (count($block->rooms) != $block->total_rooms or count($block->rooms->groupBy('floor_no')) != $block->total_floors)

                              <a href="{{ url('/block/'.$block->id.'/rooms') }}" class="btn btn-success btn-flat"><i class="fa fa-bed" aria-hidden="true"></i> Rooms</a>
                              
                              <a href="{{ route('edit_rooms',$block->id) }}" class="btn btn-warning btn-flat"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Update Rooms</a> 

                            @else 

                              <a href="{{ url('/block/'.$block->id.'/rooms') }}" class="btn btn-success btn-flat"><i class="fa fa-bed" aria-hidden="true"></i> Rooms</a>
                              
                            @endif
                            
                          </td>
                        </tr>

                      @endforeach
                    </tbody>
                    <tfoot>
                      <tr>
                        <th colspan="2">Total</th>
                        <th>{{ $tfloors }}</th>
                        {{--<td><strong>{{ $trooms }}</strong> out of <strong>{{ $block->residence->rooms->count() }}</strong></td>--}}
                        <td><strong>{{ $block->residence->rooms->count() }}</strong></td>
                        <th></th>
                      </tr>
                    </tfoot>
                  </table>
                </div>
              <br>
              <a href="{{ route('venue.residences',[$venue_slug]) }}" class="btn btn-default"><i class="fa fa-angle-left"></i> Back</a>
              </div>
              <!-- /.box-body -->
            </div>
            <!-- /.box -->
          @endif
        </div>
      </div>
  </section>
</div>
<!-- /.content-wrapper -->
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
</script>
<script>
  $('#flash-overlay-modal').modal();
</script>

@endsection