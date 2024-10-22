@extends('admin.layout.template')
@section('afterAllCss')
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <!-- bootstrap datepicker -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/all.css') }}">
@endsection
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper bg-im">
        <section class="content">
            <div style="background: #fff; margin: 10px 0;">
                <button type="button" onclick="activate_meal()" style="margin: 0 20px 0 0;" class="btn bg-olive btn-flat margin">Activate Next Meal</button>
                <span id="message_status"></span><span id="text_desp">Click here to activate next meal time.</span>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs pull-right">
                            <li class="">
                                <a href="#tab_1-1" data-toggle="tab" aria-expanded="false">Officials</a>
                            </li>
                            <li class="active">
                                <a href="#tab_2-2" data-toggle="tab" aria-expanded="true">Meal Centres</a>
                            </li>
                            <li class="">
                                <a href="#tab_3-2" data-toggle="tab" aria-expanded="false">Foods</a>
                            </li>
                            <li class="pull-left header">
                                <i class="fa fa-th"></i> Food Settings
                            </li>
                        </ul>

                        <div class="tab-content">
                            <div class="tab-pane" id="tab_1-1">
                                {{--<h4 class="box-title">Meal Officials</h4>--}}
                                <form action="#" id="user-submit" method="post">
                                    {{csrf_field()}}
                                    <input type="hidden" name="id" value="">
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label>Name:</label>
                                            <input type="text" value="{{old('name')}}" id="official_name" required name="name" class="form-control pull-right">
                                            <!-- /.input group -->
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Centre</label>
                                            <select name="centre" class="form-control" required id="official_centre">
                                                <option value="">Choose centre</option>
                                                @foreach($centres as $centre)
                                                    <option value="{{$centre->id}}">{{$centre->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <button type="submit" class="btn btn-primary btn-flat" styl="margin-top: 10px;">
                                                <i class="fa fa-check"></i> Save User
                                            </button>
                                        </div>
                                    </div>
                                    <!-- /.form group -->

                                </form>
                                <div id="message-official" style="margin-top: 10px; text-align: center"></div>
                                <hr>

                                <table class="table table-striped">
                                    <tbody id="servers-list">
                                    <tr>
                                        <th>Name</th>
                                        <th>Current Centre</th>
                                        <th style="width: 20px;text-align: center;"><i class="fa fa-trash-o"></i></th>
                                    </tr>
                                    @if(isset($meal_officials))
{{--                                    @if($meal_officials->count() > 0)--}}
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
                                            <td colspan="3" style="text-align: center; color: #bbb;">No List</td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                                <div style="display: none" id="servers-load" class="overlay">
                                    <i class="fa fa-spinner fa-spin"></i>
                                </div>
                            </div>
                            <!-- /.tab-pane -->
                            <div class="tab-pane active" id="tab_2-2">
                                <form action="#" id="centre-form" method="post">
                                    {{csrf_field()}}
                                    <input type="hidden" name="id" value="">
                                    <div class="row">
                                        <div class="form-group col-md-8">
                                            <label>Centre</label>
                                            <input type="text" placeholder="Centre name"
                                                   value="{{old('centre')}}" id="centre_name" name="centre" class="form-control pull-right">
                                            <!-- /.input group -->
                                        </div>
                                        <div class="form-group col-md-4">
                                            <button type="submit" class="btn btn-primary btn-flat" style="margin-top: 25px;">
                                                <i class="fa fa-check"></i> Save
                                            </button>
                                        </div>
                                    </div>
                                    <!-- /.form group -->
                                </form>
                                <div id="message-centre" style="margin-top: 10px;"></div>
                                <hr>
                                <table class="table table-striped">
                                    <tbody id="centre-list">
                                    <tr>
                                        <th>Centre</th>
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
                                            <td colspan="2" style="text-align: center; color: #bbb;">No List</td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                                <div style="display: none" id="servers-load" class="overlay">
                                    <i class="fa fa-spinner fa-spin"></i>
                                </div>
                            </div>
                            <!-- /.tab-pane -->
                            <div class="tab-pane" id="tab_3-2">
                                <h4 class="box-title">Food</h4>
                                <form action="#" id="food-submit" method="post">
                                    {{csrf_field()}}
                                    <input type="hidden" name="id" value="">
                                    <div class="row">
                                        <div class="form-group col-md-8">
                                            {{--<label>Name:</label>--}}
                                            <input type="text" value="{{old('name')}}" id="food-name" required name="name" class="form-control pull-right">
                                            <!-- /.input group -->
                                        </div>
                                        <div class="form-group col-md-4">
                                            <button type="submit" class="btn btn-primary btn-flat" styl="margin-top: 10px;">
                                                <i class="fa fa-check"></i> Save Food
                                            </button>
                                        </div>
                                    </div>
                                    <!-- /.form group -->

                                </form>
                                <div id="message-foods" style="margin-top: 10px; text-align: center"></div>
                                <hr>
                                <table class="table table-striped">
                                    <tbody id="foods-list">
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
                                                       onclick="del_food({{$food->id}})"><i class="fa fa-trash-o"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="2" style="text-align: center; color: #bbb;">No Food</td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                                <div style="display: none" id="foods-load" class="overlay">
                                    <i class="fa fa-spinner fa-spin"></i>
                                </div>
                            </div>
                            <!-- /.tab-pane -->
                        </div>

                    </div>
                </div>
                <div class="col-md-6">
                    <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title">Daily Meals Schedules</h3>
                        </div>
                        <div class="box-body">
                            <!-- Date -->
                            <form action="{{route('meal.save_schedule')}}" id="schedule-submit" method="post">
                                {{csrf_field()}}
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label>Date:</label>
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input type="text" value="{{old('meal_day')}}" id="meal_day" required name="meal_day" class="form-control pull-right" autocomplete="off">
                                        </div>
                                    </div>
                                    {{--<div class="form-group col-md-6">--}}
                                        {{--<label>Food</label>--}}
                                        {{--<select name="food" required id="food" multiple style="width: 100%;" class="form-control select2">--}}
                                            {{--<option value="">Choose...</option>--}}
                                            {{--@foreach($foods as $food)--}}
                                                {{--<option value="{{$food->id}}">{{$food->name}}</option>--}}
                                            {{--@endforeach--}}
                                        {{--</select>--}}
                                    {{--</div>--}}
                                </div>

                                <label style="margin-right: 15px">
                                    <input type="checkbox" value="Breakfast" name="meals" class="flat-red">
                                    Breakfast
                                </label>
                                <label style="margin-right: 15px">
                                    <input type="checkbox" value="Lunch" name="meals" class="flat-red">
                                    Lunch
                                </label>
                                <label style="margin-right: 15px">
                                    <input type="checkbox" value="Snack" name="meals" class="flat-red">
                                    Snack
                                </label>
                                <label style="margin-right: 15px">
                                    <input type="checkbox" checked value="Supper" name="meals" class="flat-red">
                                    Supper
                                </label>
                                <!-- /.form group -->
                                <button type="submit" class="btn btn-primary btn-flat" style="margin-top: 10px;">
                                    <i class="fa fa-check"></i> Save Schedule
                                </button>
                            </form>
                            <div id="message" style="margin-top: 10px;"></div>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Meal Schedules</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body no-padding">
                            <table class="table table-striped">
                                <tbody id="schedule-list">
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
                                                    <a class="btn btn-danger btn-xs" onclick="del_meal({{$meal_schedule->id}})">
                                                        <i class="fa fa-trash-o"></i></a>
                                                @endif
                                            </td>
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
                </div>
            </div>
        </section>
    </div>
    <!-- /.content-wrapper -->
@endsection
@section('afterOtherScripts')
    <!-- bootstrap datepicker -->
    <script src="{{asset('js/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{asset('plugins/select2/select2.min.js')}}"></script>
    <script src="{{ asset('js/icheck.min.js') }}"></script>
    <script>
        $('.select2').select2({
            'placeholder':'Select foods'
        });
        //Date picker
        $('#meal_day').datepicker({
            autoclose: true,
            format: "yyyy-mm-dd"
        });
        //Flat red color scheme for iCheck
        $('input[type="checkbox"].flat-red').iCheck({
            checkboxClass: 'icheckbox_flat-green'
        });

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

        function del_centre(id) {
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

                var path = "{{route('meal.remove_centre')}}";
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
                        $('#centres-load').show();
                    },
                    success: function(data){
                        swal("Deleted!", "Official has been deleted.", "success");
                        $('#centre-list').empty();
                        $('#centre-list').html(data.theList);
                        // console.log(data);
                    }, complete:function(){
                        $('#centres-load').hide();
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

        function del_food(id) {
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

                var path = "{{route('meal.remove_food')}}";
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
                        $('#foods-load').show();
                    },
                    success: function(data){
                        swal("Deleted!", "Meal Schedule has been deleted.", "success");
                        $('#foods-list').empty();
                        $('#foods-list').html(data.theList);
                        // console.log(data);
                    }, complete:function(){
                        $('#foods-load').hide();
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
            var name  = $('#official_name').val();
            var centre = $('#official_centre').val();

            var path = "{{route('meal.save_meal_official')}}";
            $.ajaxSetup(    {
                headers: {
                    'X-CSRF-Token': $('meta[name=_token]').attr('content')
                }
            });
            $.ajax({
                url: path,
                type: 'POST',
                data: {name:name, centre:centre},
                beforeSend: function(){
                    $('#servers-load').show();
                },
                success: function(data){
                    $('#servers-list').empty();
                    $('#message-official').html("<p class=\"text-green\">Meal Official Saved</p>");
                    $('#servers-list').html(data.theList);

                    $('#official_name').value = '';
                    $('#official_centre').value = '';
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

        //Submit the Meal Official.
        $('#food-submit').on('submit', function (e) {
            e.preventDefault();
            $('#message-foods').empty();
            var name  = $('#food-name').val();

            var path = "{{route('meal.save_food')}}";
            $.ajaxSetup(    {
                headers: {
                    'X-CSRF-Token': $('meta[name=_token]').attr('content')
                }
            });
            $.ajax({
                url: path,
                type: 'POST',
                data: {name:name},
                beforeSend: function(){
                    $('#foods-load').show();
                },
                success: function(data){
                    $('#foods-list').empty();
                    $('#message-foods').html("<p class=\"text-green\">Meal Official Saved</p>");
                    $('#foods-list').html(data.theList);

                    $('#food-name').value = '';
                },
                complete:function(){
                    $('#foods-load').hide();
                }
                ,
                error: function (data) {
                    $('#message-foods').html("<p class=\"text-yellow\">Please check the inputs.</p>");
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

        //Submit the Meal Centre form.
        $('#centre-form').on('submit', function (e) {
            e.preventDefault();
            $('#message-centre').empty();
            var centre  = $('#centre_name').val();
            // var meals = new Array();
            // $('input[name="meals"]:checked').each(function() {
            //     meals.push(this.value);
            // });

            var path = "{{route('meal.save_centre')}}";
            $.ajaxSetup(    {
                headers: {
                    'X-CSRF-Token': $('meta[name=_token]').attr('content')
                }
            });
            $.ajax({
                url: path,
                type: 'POST',
                data: {name:centre},
                beforeSend: function(){
                    $('#centre-load').show();
                },
                success: function(data){
                    $('#centre-list').empty();
                    $('#message-centre').html("<p class=\"text-green\">Centre Saved</p>");
                    $('#centre-list').html(data.theList);

                    $('#centre_name').value = '';
                },
                complete:function(){
                    $('#centre-load').hide();
                }
                ,
                error: function (data) {
                    console.log(data);
                    $('#message-centre').html("<p class=\"text-yellow\">Please check the inputs.</p>");
                }
            });
        });

        function activate_meal() {
            swal({
                    title: "Meal Activation",
                    text: "Do you want to activate the next meal time?",
                    type: "info",
                    showCancelButton: true,
                    confirmButtonClass: "btn-info",
                    confirmButtonText: "Yes, activate!",
                    closeOnConfirm: false
                },
                function(){
                    var path = "{{route('meal.activeNextMeal')}}";
                    $.ajaxSetup(    {
                        headers: {
                            'X-CSRF-Token': $('meta[name=_token]').attr('content')
                        }
                    });
                    $.get({
                        url: path,
                        beforeSend: function(){
                            $('#text_desp').empty();
                            $('#message_status').html('<i class="fa fa-circle-o-notch fa-spin"></i>');
                        },
                        success: function(data){
                            swal("Activated!", "Meal Time has been activated.", "success");
                            $('#message_status').html('<span class="text-'+data.color+'">'+data.message+'</span>');
                            // $('#schedule-list').html(data.theList);
                            // console.log(data);
                        }, complete:function(){
                            // $('#schedule-load').hide();
                        },
                        error: function (data) {
                            $('#message_status').html('<span class="text-'+data.color+'">Something went wrong</span>');
                        }
                    });
                }
            )
        }

    </script>

@endsection