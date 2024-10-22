<tr>
    <th>Food</th>
    <th style="width: 20px;text-align: center;"><i class="fa fa-trash-o"></i></th>
</tr>
@if($foods->count() > 0)
    @foreach($foods as $food)
        <tr>
            <td>{{$food->name}}</td>
            <td>
                <a class="btn btn-danger btn-xs" data-value="{{$food->id}}"
                   onclick="del({{$food->id}})"><i class="fa fa-trash-o"></i></a>
            </td>
        </tr>
    @endforeach
@else
    <tr>
        <td colspan="2">No Food</td>
    </tr>
@endif