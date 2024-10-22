@extends('admin.layout.backend.blocks.generate_rooms_template')

@section('acitvity', 'Edit - ')

@php
	// dd($block);
@endphp
@section('action', route('update_rooms',$block->id))
{{-- {{ $block->rooms->min()->room_no }} --}}
@section('method')
	{{ method_field('PUT') }}
@endsection
@section('form')

	@for ($count = 0; $count < $block->total_floors; $count++)

        @php
        	$floor_no = $count + 1;
        	if ($block->rooms->where('floor_no', $floor_no)->pluck('floor_color')->first() !== '') {
        		$color = $block->rooms->where('floor_no', $floor_no)->pluck('floor_color')->first();
        	}else {$color = '#eeeeee';}
        @endphp
		
      {{-- <input id="room_id" type="hidden" class="form-control" name="room_id[]" value="" > --}}
      
      <tr>
        <td>
        	<input id="floor_no" type="number" readonly class="form-control" name="floor_no[]" value="{{ $floor_no }}" required ></td>

        <td><input id="start" type="number" min="1" max="2000" class="form-control" name="start[]" value="{{ $block->rooms->where('floor_no', $floor_no)->pluck('room_no')->min() }}" placeholder="From" required autofocus></td>

        <td><input id="end" type="number" min="1" max="2000" class="form-control" name="end[]" value="{{ $block->rooms->where('floor_no', $floor_no)->pluck('room_no')->max() }}" placeholder="To" required autofocus></td>

        <td><input id="prefix" type="text" min="1" max="5" class="form-control" name="prefix[]" value="{{ $block->rooms->where('floor_no', $floor_no)->pluck('prefix')->first()}}" placeholder="Eg. (A)100" autofocus></td>

        <td><input id="suffix" type="text" min="1" max="5" class="form-control" name="suffix[]" value="{{ $block->rooms->where('floor_no', $floor_no)->pluck('suffix')->first()}}" placeholder="Eg. 100(A)" autofocus></td>

        <td><input id="occupants" type="number" min="1" max="100" class="form-control" name="occupants[]" value="{{ $block->rooms->where('floor_no', $floor_no)->pluck('total_occupants')->first()}}" placeholder="Beds" required autofocus></td>

        {{-- <td><input id="color" type="color" min="1" max="100" class="form-control" name="color[]"  value="{{ $color }}" required placeholder="color" required autofocus></td> --}}

      </tr>

    @endfor
	
@endsection
@section('after_table')
	<p><strong>Note.</strong> <em> The <strong>{{ $block->name }}</strong> can only contain not more than the <strong>{{ $block->total_rooms }}</strong> rooms allocated.</em> </p>
@endsection
@section('button', 'Update')