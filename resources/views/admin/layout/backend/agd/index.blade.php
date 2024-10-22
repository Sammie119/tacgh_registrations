@extends('admin.layout.template')
@section('afterAllCss')
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <!-- bootstrap datepicker -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/all.css') }}">
@endsection
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper bg-im">
        <section class="content">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">AGD Membership</h3>
                </div>
                <div class="box-body">
                    <div class="row">
                    <!-- Date -->
                        <form action="{{route('agd.save')}}" id="agd-submit" method="post">
                        {{csrf_field()}}
                            <input type="hidden" id="fullname" name="fullname">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label>Language</label>
                                    <select name="shortname" onchange="getIt()" id="shortname" class="form-control" required>
                                        <option value="">Choose Language</option>
                                        @foreach($languages as $language)
                                            <option value="{{$language->ShortName}}">{{$language->FullName}}</option>
                                        @endforeach
                                    </select>
                                    <!-- /.input group -->
                                </div>
                                <!-- /.box-body -->
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Group Size</label>
                                    <input type="number" class="form-control" name="group_size" id="group_size" min="1" required>
                                    <!-- /.input group -->
                                </div>
                            </div>
                        <!-- /.form group -->
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary btn-flat" style="margin-top: 25px;">
                                    <i class="fa fa-save"></i> Save
                                </button>
                            </div>
                        </form>
                    </div>
                    <div id="message" style="margin-top: 10px;"></div>
                </div>
            </div>
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">AGD List</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body no-padding">
                    <table class="table table-striped">
                        <tbody id="schedule-list">
                        <tr>
                            <th>Language</th>
                            <th>Code</th>
                            <th>Size</th>
                            {{--<th style="width: 40px">Action</th>--}}
                        </tr>
                        @if($groups->count() > 0)
                            @foreach($groups as $group)
                                <tr>
                                    <td>{{$group->name}}</td>
                                    <td>
                                        {{$group->code}}
                                    </td>
                                    <td>
                                        {{$group->size}}
                                    </td>
                                    {{--<td>--}}
                                        {{--<a class="btn btn-danger btn-xs" onclick="del_meal({{$group->id}})">--}}
                                            {{--<i class="fa fa-trash-o"></i></a>--}}
                                    {{--</td>--}}
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="3">No List</td>
                            </tr>
                        @endif

                        </tbody>
                    </table>
                    <div style="display: none" id="schedule-load" class="overlay">
                        <i class="fa fa-spinner fa-spin"></i>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
        </section>
    </div>
    <!-- /.content-wrapper -->
@endsection
@section('afterOtherScripts')
    <script>
        function getIt() {
            var text = $("select[name='shortname']").find('option:selected').text();
            $('input#fullname').val(text);
            console.log(text);
        }
        function del(id) {
            swal({
                    title: "Are you sure?",
                    text: "Data will not be lost permanently!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes, delete it!",
                    closeOnConfirm: false
                },
                function(){

                    var path = "{{route('meal.remove_official')}}";
                    $.ajaxSetup(    {
                        headers: {
                            'X-CSRF-Token': $('meta[name=_token]').attr('content')
                        }
                    });
                    $.ajax({
                        url: path,
                        type: 'POST',
                        data: {id:id},
                        beforeSend: function(){
                            $('#servers-load').show();
                        },
                        success: function(data){
                            swal("Deleted!", "Official has been deleted.", "success");
                            $('#servers-list').empty();
                            $('#servers-list').html(data.theList);
                            // console.log(data);
                        }, complete:function(){
                            $('#servers-load').hide();
                        },
                        error: function (data) {
                            console.log(data);
                        }
                    });
                })
        }

        function del_meal(id) {
            swal({
                    title: "Are you sure?",
                    text: "Data will not be lost permanently!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes, delete it!",
                    closeOnConfirm: false
                },
                function(){

                    var path = "{{route('meal.remove_meal')}}";
                    $.ajaxSetup(    {
                        headers: {
                            'X-CSRF-Token': $('meta[name=_token]').attr('content')
                        }
                    });
                    $.ajax({
                        url: path,
                        type: 'POST',
                        data: {id:id},
                        beforeSend: function(){
                            $('#schedule-load').show();
                        },
                        success: function(data){
                            swal("Deleted!", "Meal Schedule has been deleted.", "success");
                            $('#schedule-list').empty();
                            $('#schedule-list').html(data.theList);
                            // console.log(data);
                        }, complete:function(){
                            $('#schedule-load').hide();
                        },
                        error: function (data) {
                            console.log(data);
                        }
                    });
                })
        }

        //Submit the Meal Official.
        $('#user-submit').on('submit', function (e) {
            e.preventDefault();
            $('#message').empty();
            var name  = $('#name').val();
            var location = $('#location').val();

            var path = "{{route('meal.save_meal_official')}}";
            $.ajaxSetup(    {
                headers: {
                    'X-CSRF-Token': $('meta[name=_token]').attr('content')
                }
            });
            $.ajax({
                url: path,
                type: 'POST',
                data: {name:name, location:location},
                beforeSend: function(){
                    $('#servers-load').show();
                },
                success: function(data){
                    $('#servers-list').empty();
                    $('#message-official').html("<p class=\"text-green\">Meal Official Saved</p>");
                    $('#servers-list').html(data.theList);

                    $('#name').value = '';
                    $('#location').value = '';
                },
                complete:function(){
                    $('#servers-load').hide();
                }
                ,
                error: function (data) {
                    $('#message-official').html("<p class=\"text-yellow\">Please check the inputs.</p>");
                    console.log(data);
                }
            });
        });

        //Submit the Meal Schedule form.
        $('#schedule-submit').on('submit', function (e) {
            e.preventDefault();
            $('#message').empty();
            var meal_day  = $('#meal_day').val();
            var meals = new Array();
            $('input[name="meals"]:checked').each(function() {
                meals.push(this.value);
            });

            var path = "{{route('meal.save_schedule')}}";
            $.ajaxSetup(    {
                headers: {
                    'X-CSRF-Token': $('meta[name=_token]').attr('content')
                }
            });
            $.ajax({
                url: path,
                type: 'POST',
                data: {meal_day:meal_day, meals:meals},
                beforeSend: function(){
                    $('#schedule-load').show();
                },
                success: function(data){
                    $('#schedule-list').empty();
                    $('#message').html("<p class=\"text-green\">Meal Schedule Saved</p>");
                    $('#schedule-list').html(data.theList);

                    $('#meal_day').value = '';
                },
                complete:function(){
                    $('#schedule-load').hide();
                }
                ,
                error: function (data) {
                    $('#message').html("<p class=\"text-yellow\">Please check the inputs.</p>");
                }
            });
        });

    </script>

@endsection