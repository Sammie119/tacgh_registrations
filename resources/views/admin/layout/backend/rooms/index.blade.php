@extends('admin.layout.template')
@section('afterAllCss')
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
@endsection
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <section class="content-header">

            <h1>{{ $block->residence->name }}</h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="#"><i class="fa fa-building-o"></i> Residences</a></li>
                <li><a href="{{url('/residence/'.$block->residence->id.'/blocks') }}"><i class="fa fa-building-o"></i> {{ $block->residence->name }}</a></li>
                <li class="active">{{ $block->name }}</li>
            </ol>

        </section>
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-solid">
                        <div class="box-header with-border">
                            <h4>{{ $block->name }} - (Rooms)</h4>
                        </div>
                        <div class="box-body ">
                            <div class="row">
                                <div class="col-md-5">
                                    <p>Total rooms : <strong>{{ count($block->rooms) }}</strong> || Number of floors : <strong>{{ $block->total_floors }}</strong>
                                    </p>
                                </div>
                                <div class="col-md-7">
                                    <p>
                            <span class="pull-right">Legend :
                                @foreach ($legends as $legend)
                                    <span class="ccode" style="background-color: {{ $legend->color_code }}"> </span>
                                    <span class="legend">{{ $legend->legend }}</span>
                                @endforeach
                            </span>
                                    </p>
                                </div>
                            </div>

                            <div class="table-responsive for-rooms" style="padding: 10px 15px">
                                <table class="table table-bordered" id="room-form" style="border:none">
                                    {{-- <thead> --}}
                                    <tr>
                                        <th style="text-align: center;width: 40px;" width='50px' >
                                            Floor
                                        </th>
                                        <th style="text-align: center" colspan="{{ count($block->rooms) }}">Rooms ( Showing Room No. and Total Occupants )</th>
                                    </tr>
                                    {{-- </thead> --}}
                                    @php

                                        $floor = 1;

                                        while ( $floor <= $block->total_floors) {

                                            echo "<tr>";
                                                echo "<td style='text-align: center'><strong> $floor </strong></td>";

            foreach ($block->rooms->where('floor_no',$floor)->sortBy('room_no') as $room) {
                $url = url('/room/'.$room->id.'/edit');
                $rmates = $room_mates->where('room_id',$room->id)->count('room_id');

                $color ='#85C3D4';
                // get Full room color
                if ($rmates >= $room->total_occupants) {
                    $color = $legends->where('legend','Full')->pluck('color_code')->first();
                }
                // get Regular room color and cannot be assigned
                elseif ($room->assign == 0 and $room->type == 'Regular') {
                    $color = $legends->where('legend','Blocked')->pluck('color_code')->first();
                }
                // get Regular room color and can be assigned
                elseif ($room->assign == 1 and $room->type == 'Regular') {
                    $color = $legends->where('legend','Regular')->pluck('color_code')->first();
                }
                // get Reserved room color and cannot be assigned or assigned
                elseif ($room->type == 'Reserved') {
                    $color = $legends->where('legend','Reserved')->pluck('color_code')->first();
                }
                // dd($color);
                echo "<td min-width='100px' style='background:$color' class='rooms-col'>";
                echo "<a href='$url'><div style='width:65px'>Rm ".$room->prefix." ".$room->room_no." ".$room->suffix;
                echo "<br>";
                echo "<i class='fa fa-bed' aria-hidden='true'></i>  (".$rmates." of ".$room->total_occupants;
                echo ")</div></a></td>";
            }
                                            echo "</tr>";

                                            $floor++;
                                        }

                                    @endphp

                                </table>
                            </div>
                            <a href="{{ URL::previous() }}" class="btn btn-flat btn-info"><i class="fa fa-angle-left"></i> Back</a>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
            </div>
        </section>
    </div>
    <!-- /.content-wrapper -->


    <!-- Modal -->
    {{-- <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title" id="myModalLabel">Room</h4>
                </div>

                <div class="modal-body">

                </div>

                <div class="modal-footer">
                    <a href="#" class="btn btn-default" data-dismiss="modal">Close</a>
                    <input type="submit" id="submit" value="Save changes" name="submit" class="btn btn-primary">
                </div>

            </div>
        </div>
    </div> --}}
@endsection

@section('afterotherscripts')

    <script>
        // $(document).ready(function(){
        //     var base_url = window.location.origin;
        //     $("form#room-form tr>td").click(function(){
        //          $("#myModal").on("show.bs.modal", function(e) {
        //             var id = $(e.relatedTarget).data('target-id');
        //             $.ajax({
        //                 url: base_url+"room/"+id+"/openmodal",
        //                 method:"POST",
        //                 data:{id:id},
        //                 datatype:"text",
        //                 success:function( data ) {

        //                     $(".modal-body").html(data);
        //                 }

        //             });

        //         });
        //     })

        // });
    </script>

@endsection