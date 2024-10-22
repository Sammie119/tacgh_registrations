<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title">Update Camp Venue</h4>
</div>
<form action="#" id="editVenue" method="POST" onsubmit="update(event); return false">
    {{csrf_field()}}
    <div class="modal-body">
        <input type="hidden" name="id" value="{{$venue->id}}">
        {{--<div class="alert  alert-arrow-left alert-icon-left alert-dismissible mb-2" v-bind:class="status_type" role="alert" v-if="status">--}}
        {{--<span class="alert-icon"><i class="la" v-bind:class="status_icon"></i></span>--}}
        {{--<button type="button" class="close" data-dismiss="alert" aria-label="Close">--}}
        {{--<span aria-hidden="true">&times;</span>--}}
        {{--</button>--}}
        {{--<strong>{{status_message}}</strong>--}}
        {{--</div>--}}
        <fieldset class="form-group">
            <label for="venue">Venue Name* </label>
            <input type="text" placeholder="Venue Name*" required name="venue" value="{{$venue->name}}" class="form-control">
            {{--<small v-if="errors.venue" class="danger">{{errors.venue[0]}}</small>--}}
        </fieldset>
        <div class="row">
            <div class="col-md-6">
                <fieldset class="form-group">
                    <label for="location">Location* </label>
                    <input type="text" placeholder="Location" required name="location" value="{{$venue->location}}" class="form-control">
                    {{--<small v-if="errors.location" class="danger">{{errors.location[0]}}</small>--}}
                </fieldset>
            </div>
            <div class="col-md-6">
                <fieldset class="form-group">
                    <label for="region">Region* </label>
                    <select name="region" required id="region" class="form-control">
                        <option value="">-- Select Region --</option>
                        @foreach ($regions as $key=>$region)
                            <option {{( $venue->region_id == $key)? 'selected': ''}} value="{{$key}}">{{$region}}</option>
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
        <button class="btn btn-success btn-md" type="submit" id="update_field_button">
            {{--<i class="la la-refresh spinner mr-1" id="new-loader"></i>--}}
            Update Venue
        </button>
    </div>
</form>