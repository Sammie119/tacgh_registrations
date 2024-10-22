<tr>
    <th>Date</th>
    <th>Meal Type</th>
    <th style="width: 40px">Action</th>
</tr>
@if($meal_schedules->count() > 0)
@foreach($meal_schedules as $meal_schedule)
    <tr>
        <td>{{date("M d, Y", strtotime($meal_schedule->day))}}</td>
        <td>
            {{$meal_schedule->meal_type}}
        </td>
        <td>
            @if($meal_schedule->status > 0)
                <i class="fa fa-check text-success"></i>
            @else
                <a class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i></a>
            @endif
        </td>
    </tr>
    @endforeach
@else
    <tr>
        <td colspan="3">No List</td>
    </tr>
@endif
