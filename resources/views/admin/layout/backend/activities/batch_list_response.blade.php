@foreach($batchList as $registrant)
    @if($registrant->gender_id == $gender_id)
        <tr>
            <td>{{$registrant->firstname." ".$registrant->surname}}</td>
            <td>{{$registrant->reg_id}}</td>
{{--            <td>{{(isset($registrant->campercat_id))?"Category Not Set":"Category not set"}}</td>--}}
            @if($registrant->campercat_id == NULL)
                <td><span class="text-danger" style="font-weight: bolder">Category Not Set</span></td>
            @else
                <td>{{$types[$registrant->campercat_id]}}</td>
            @endif
            <td>@if($registrant->room_id)
                    {{$registrant->room->residence->name.", ".$registrant->room->block->name." (Rm. ".$registrant->room->prefix." ".$registrant->room->room_no." ".$registrant->room->suffix.")"}}
                @elseif($registrant->confirmedpayment == 0)
                    <span class="text-danger">Not Authorized</span>
                @elseif(!$registrant->room_id and $registrant->specialaccom_id == 44)
                    <a hre="{{route('search',[$registrant->reg_id])}}">Special Accomodation (Not Assigned)</a>
                @else
                    <span class="text-danger">Not Assigned</span>
                @endif
            </td>
        </tr>
    @endif
@endforeach