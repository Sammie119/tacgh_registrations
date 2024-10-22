<tr>
    <th>Name</th>
    <th>Current Centre</th>
    <th style="width: 20px;text-align: center;"><i class="fa fa-trash-o"></i></th>
</tr>
@if($meal_officials->count() > 0)
    @foreach($meal_officials as $meal_official)
        <tr>
            <td>{{$meal_official->name}}</td>
            <td>{{$meal_official->centre->name}}</td>
            <td>
                <a class="btn btn-danger btn-xs" data-value="{{$meal_official->id}}" onclick="del({{$meal_official->id}})"><i class="fa fa-trash-o"></i></a>
            </td>
        </tr>
    @endforeach
@else
    <tr>
        <td colspan="3">No List</td>
    </tr>
@endif