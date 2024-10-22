@extends('admin.layout.template')
@section('afterAllCss')

@endsection
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <section class="content-header">
            <h1>General Settings</h1>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-md-5">
                    <div class="box box-info">
                        <!-- form start -->
                        <form role="form" action="{{route('settings.saveThisYearVenue')}}" method="POST">
                            {{csrf_field()}}
                            <div class="box-body">
                                <div class="form-group">
                                    <label>Venue for {{date("Y")}} Camp Meeting</label>
                                    <select class="form-control" required name="venue">
                                        <option>Select Camp Venue</option>
                                        @foreach($venues as $venue)
                                        <option value="{{$venue->id}}"
                                                @isset($current_venue)
                                                @if($current_venue->camp_venue_id == $venue->id) selected @endif
                                        @endisset>
                                            {{$venue->name}}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-default">Save</button>
                                @if (session()->has('message'))
                                    <span class="text-success">{{session('message')}}</span>
                                @elseif(session()->has('error'))
                                    <span class="text-danger">{{session('error')}}</span>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </section>
    </div>
@endsection

@section('afterMainScripts')

@endsection

@section('afterOtherScripts')

@endsection