<tr>
    <th>Name</th>
    <th style="width: 20px;text-align: center;"><i class="fa fa-trash-o"></i></th>
</tr>
@if($centres->count() > 0)
    @foreach($centres as $centre)
        <tr>
            <td>{{$centre->name}}</td>
            <td>
                <a class="btn btn-danger btn-xs" data-value="{{$centre->id}}" onclick="del_centre({{$centre->id}})"><i class="fa fa-trash-o"></i></a>
            </td>
        </tr>
    @endforeach
@else
    <tr>
        <td colspan="2">No List</td>
    </tr>
@endif