@extends('admin.layout.template')
@section('afterAllCss')
    <link rel="stylesheet" href="{{ asset('plugins/datatables/datatables.bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables/jquery.datatables.min.css') }}">


@endsection
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <section class="content-header">
            <h1>Camp Venues</h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Venues</li>
            </ol>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-solid">
                        <div class="box-header">
                            <div class="row" style="margin-bottom: 10px">
                                <div class="col-md-4">
                                    <h3 style="margin-top:20px;font-size: 20px;">All Camp Venues</h3>
                                </div>
                                <div class="col-md-4 text-center">

                                </div>
                                <div class="col-md-4 text-right">
                                    <button class="btn bg-orange btn-flat margin"
                                            data-toggle="modal" data-target="#add-venue">Add Camp Venue</button>
                                </div>
                            </div>
                        </div>

                        <div class="box-body">
                            <div class="table-responsive">
                                <table id="residences" class="table table-bordered table-striped table-hover">
                                    <thead>
                                    <tr>
                                        <th class="border-top-0" style="width: 50px">No.</th>
                                        <th class="border-top-0">Venue Name</th>
                                        <th class="border-top-0">Location</th>
                                        <th class="border-top-0" style="width: 200px">Region</th>
                                        <th class="border-top-0" style="width: 200px">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php
                                        $count = 1;
                                    @endphp
                                    @foreach($venues as $venue)
                                        <tr>
                                            <td>{{ $count++ }}</td>
                                            <td>{{ $venue->name }}</td>
                                            <td>{{ $venue->location }}</td>
                                            <td>{{ $venue->region->FullName }}</td>
                                            <td>
                                                {{-- <form action="{{ url('residence/'.$res->id) }}" method="POST" class="pull-left" style="margin-right:3px">
                                                      {{ csrf_field() }}
                                                      {{ method_field('DELETE') }}
                                                      <button type="submit" class="btn btn-danger btn-flat"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>

                                                    </form> --}}
                                                <button data-toggle="modal" data-target="#edit-venue" onclick="edit('{{$venue->slug}}')" class="btn btn-default btn-flat">
                                                    <i class="fa fa-pencil" aria-hidden="true"></i>
                                                    {{--Edit--}}
                                                </button>
                                                <a href="{{ route('venue.residences', [$venue->slug]) }}" class="btn bg-navy btn-flat">
                                                    {{--<i class="fa fa-th-large" aria-hidden="true"></i> --}}
                                                    Residences
                                                </a>
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
    </div>
    <div class="modal fade" id="add-venue">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">New Camp Venue</h4>
                </div>
                <form action="#" id="newVenue" method="POST" onsubmit="save(event); return false">
                    {{csrf_field()}}
                    <div class="modal-body">
                        {{--<div class="alert  alert-arrow-left alert-icon-left alert-dismissible mb-2" v-bind:class="status_type" role="alert" v-if="status">--}}
                        {{--<span class="alert-icon"><i class="la" v-bind:class="status_icon"></i></span>--}}
                        {{--<button type="button" class="close" data-dismiss="alert" aria-label="Close">--}}
                        {{--<span aria-hidden="true">&times;</span>--}}
                        {{--</button>--}}
                        {{--<strong>{{status_message}}</strong>--}}
                        {{--</div>--}}
                        <fieldset class="form-group">
                            <label for="venue">Venue Name* </label>
                            <input type="text" placeholder="Venue Name*" required name="venue" class="form-control">
                            {{--<small v-if="errors.venue" class="danger">{{errors.venue[0]}}</small>--}}
                        </fieldset>
                        <div class="row">
                            <div class="col-md-6">
                                <fieldset class="form-group">
                                    <label for="location">Location* </label>
                                    <input type="text" placeholder="Location" required name="location" class="form-control">
                                    {{--<small v-if="errors.location" class="danger">{{errors.location[0]}}</small>--}}
                                </fieldset>
                            </div>
                            <div class="col-md-6">
                                <fieldset class="form-group">
                                    <label for="region">Region* </label>
                                    <select name="region" required id="region" class="form-control">
                                        <option value="">-- Select Region --</option>
                                        @foreach ($regions as $key=>$region)
                                            <option value="{{$key}}">{{$region}}</option>
                                        @endforeach
                                    </select>
                                    {{--<small v-if="errors.region" class="danger">{{errors.region[0]}}</small>--}}
                                </fieldset>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="reset" class="btn btn-outline-secondary btn-md" data-dismiss="modal"
                               value="Close">
                        <button class="btn btn-success btn-md" type="submit" id="save_field_button">
                            {{--<i class="la la-refresh spinner mr-1" id="new-loader"></i>--}}
                            Add Venue
                        </button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <div class="modal fade" id="edit-venue">
        <div class="modal-dialog">
            <div class="modal-content"></div>
        </div>
    </div>
    <!-- /.content-wrapper -->
    </div>
@endsection

@section('afterMainScripts')

@endsection

@section('afterOtherScripts')
    <script>
        function edit(slug) {
            console.log(slug);
            var path = "{{route('venue.edit')}}";
            $.ajaxSetup({ headers: {'X-CSRF-Token': $('meta[name=_token]').attr('content')}});
            $.ajax({
                url: path,
                data: {slug:slug},
                type: 'POST',
                beforeSend: function(){
                    $('#edit-venue .modal-content').html('<div class="modal-loader">\n' +
                        '<i class="fa-spin fa fa-spinner"></i></div>')
                },
                success: function(data){
                    $('#edit-venue .modal-content').html(data.theForm);
                },
                complete: function (data){

                },
                error: function (data) {
                    console.log(data);
                }
            });
        }
        function save(e) {
            e.preventDefault();
            let form_data = $('#newVenue').serialize();
            // console.log(form_data);
            var path = "{{route('venue.store')}}";
            $.ajaxSetup({ headers: {'X-CSRF-Token': $('meta[name=_token]').attr('content')}});
            $.ajax({
                url: path,
                // data: JSON.stringify(form_data),
                data: form_data,
                // {form_data:form_data},
                type: 'POST',
                beforeSend: function(){
                    $("#save_field_button").prop('disables', true).html('<i class="fa-spin fa fa-spinner mr-2"></i> Saving...');
                },
                success: function(data){
                    $('#save_field_button').html('Saved');
                    jQuery('#modal-block-extra-large').modal('hide');
                    // refreshFields(data.form_id);
                    window.location.reload();

                },
                complete: function (data){
                    // if (data.status != undefined){
                    //     $('#field_sucess_alert').show();
                    //     $('#status').html(data.status);
                    // }
                },
                error: function (data) {
                    console.log(data);
                }
            });
        }
        function update(e) {
            e.preventDefault();
            let form_data = $('#editVenue').serialize();
            console.log(form_data);
            var path = "{{route('venue.update')}}";
            $.ajaxSetup({ headers: {'X-CSRF-Token': $('meta[name=_token]').attr('content')}});
            $.ajax({
                url: path,
                data: form_data,
                type: 'POST',
                beforeSend: function(){
                    $("#update_field_button").prop('disables', true).html('<i class="fa-spin fa fa-spinner mr-2"></i> Updating...');
                },
                success: function(data){
                    // $('#update_field_button').html('Saved');
                    // jQuery('#modal-block-extra-large').modal('hide');
                    // refreshFields(data.form_id);
                    if (data.status === true){
                        $('#update_field_button').html('Saved');
                        window.location.reload();
                    } else {
                        $('#update_field_button').html('Update Venue');
                    }

                },
                complete: function (data){

                },
                error: function (data) {
                    console.log(data);
                }
            });
        }
    </script>
@endsection