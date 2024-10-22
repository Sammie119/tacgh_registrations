@extends('layouts.app')
@section('beforecss')
    {{--    <link rel="stylesheet" href="{{ asset('css/AdminLTE.min.css') }}">--}}
    {{--<link rel="stylesheet" href="{{ asset('plugins/iCheck/all.css') }}">--}}
    {{--<link rel="stylesheet" href="{{ asset('css/custom.css') }}">--}}
    <link rel="stylesheet" href="{{asset('css/jquery-ui.min.css')}}">

    {{--<link rel="stylesheet" href="{{ asset('css/custom.css') }}">--}}
    {{--<link rel="stylesheet" href="{{asset('css/jquery-ui.min.css')}}">--}}
    <link rel="stylesheet" href="{{asset('css/jquery.dataTables.min.css')}}">
    <link href="{{asset('css/bootstrap-switch.min.css')}}" rel="stylesheet"/>
    {{--<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">--}}
    <script>
        $(document).ready(function(){
            $('.switchbutton').bootstrapSwitch({
                onColor:'primary',
                onText:'Paid',
                offText:'NA'
            });
        })
    </script>
    <link href="{{asset('css/progress-form.css')}}" rel="stylesheet"/>
@endsection

@section('content')
    <section style="margin-top: 50px;">
        <div class="container" style="overflow: auto;height: 100%;">
            {{--<div style="text-align: center; margin-bottom: 30px">--}}
            {{--<img src="{{asset('img/aposa-main_edit.png')}}" style="text-align: center;max-width:200px;"/>--}}
            {{--</div>--}}
            <div style="margin: 2.5rem 0;">
                <p style="text-align:right">
                    <a href="{{route('registrant.camper_logout')}}" class="btn btn-flat btn-default">
                        Log out
                    </a>
                </p>
                <div class="row">
                    <!-- Multi step form -->
                    <section class="multi_step_form">
                        <div id="msform">

                            <ul id="progressbar">
                                <li class="active">Verify Campers</li>
                                <li>Payment Details</li>
                                <li>Registration Status</li>
                            </ul>
                                    <form class="form-horizontal" id="paymentform" role="form" method="POST" action="{{ route('bacthregistration.chapter_save_progress') }}">
                                {{ csrf_field() }}
                            <fieldset>
                                <h3>Verify Campers</h3>
                                <h6>Check to see if this is your updated member list</h6>
                                <div class="panel-body">
                                    @if($nonpaidmembers)

                                        <div class="table-responsive">
                                            <table id="dtrows" class="table table-striped">
                                                <thead>
                                                <tr>
                                                    <th>Firstname</th>
                                                    <th>Lastname</th>
                                                    <th>DOB</th>
                                                    <th>Gender</th>
                                                    <th>Camper Category</th>
                                                    <th>Applicable fee</th>
                                                    <th>Special Accom.</th>
                                                    <th>Area</th>
                                                    <th>Paid?</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($nonpaidmembers as $registrant)
                                                    <tr>
                                                        <td>{{$registrant->firstname}}</td>
                                                        <td>{{strtoupper($registrant->surname)}}</td>
                                                        <td>{{$registrant->dob}}</td>
                                                        <td>{{$registrant->gender}}</td>
                                                        <td>{{$registrant->camper}}</td>
                                                        <td>{{$registrant->Applicable_Camp_Fee}}</td>
                                                        <td>{{$registrant->Type_of_Special_Accomodation}}</td>
                                                        <td>{{$registrant->carea}}</td>
                                                        <td class="floatright">{{ Form::checkbox('registrants[]',  $registrant->id ,null,['class'=>'switchbutton']) }}</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                {{--</form>--}}
                                    @endif

                                        @if($paidmembers)

                                            <div class="table-responsive">
                                                <div>Paid Chapter Members</div>
                                                <table id="dtrows" class="table table-striped">
                                                    <thead>
                                                    <tr>
                                                        <th>Firstname</th>
                                                        <th>Lastname</th>
                                                        <th>DOB</th>
                                                        <th>Gender</th>
                                                        <th>Camper Category</th>
                                                        <th>Applicable fee</th>
                                                        <th>Special Accom.</th>
                                                        <th>Area</th>
                                                        {{--<th>Paid?</th>--}}
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($paidmembers as $registrant)
                                                        <tr>
                                                            <td>{{$registrant->firstname}}</td>
                                                            <td>{{strtoupper($registrant->surname)}}</td>
                                                            <td>{{$registrant->dob}}</td>
                                                            <td>{{$registrant->gender}}</td>
                                                            <td>{{$registrant->camper}}</td>
                                                            <td>{{$registrant->Applicable_Camp_Fee}}</td>
                                                            <td>{{$registrant->Type_of_Special_Accomodation}}</td>
                                                            <td>{{$registrant->carea}}</td>
                                                            {{--<td class="floatright">{{ Form::checkbox('registrants[]',  $registrant->id ,null,['class'=>'switchbutton']) }}</td>--}}
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            {{--</form>--}}
                                        @endif
                                </div>
                                <button type="button" class="action-button previous_button">Back</button>
                                <button type="button" class="next action-button">Continue</button>
                            </fieldset>

                            <fieldset>
                                <h3>Payment Details</h3>
                                {{--<form action="{{route('registrant.steps_save',[2])}}" method="POST">--}}
                                    {{--{{csrf_field()}}--}}
                                    <div class="form-group">
                                        <div class="col-md-4">
                                            <label for="payment_mode" class="required">Payment Mode</label>
                                            <select class="form-control" name="payment_mode" required>
                                                <option value="{{str_slug('MTN Mobile Money')}}">MTN Mobile Money</option>
                                                <option value="{{str_slug('Vodafone Cash')}}">Vodafone Cash</option>
                                                <option value="{{str_slug('Airtel Money')}}">Airtel Money</option>
                                                <option value="{{str_slug('Tigo Cash')}}">Tigo Cash</option>
                                                <option value="{{str_slug('Bank Deposit')}}">Bank Deposit</option>
                                                <option value="{{str_slug('Paid Cash')}}">Paid Cash</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="transaction_no" class="required">Payment Reference No.</label>
                                            <input type="text" required class="form-control" name="transaction_no">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="date_paid" class="required">Date Paid</label>
                                            <input type="date" required class="form-control" name="date_paid">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-4" style="margin-top:15px">
                                            <label for="amount" class="required">Amount Paid</label>
                                            <input type="text" class="form-control" required name="amount" placeholder="Amount here..."/>
                                        </div>
                                        <div class="col-md-8" style="margin-top:15px">
                                            <label for="comment" class="required">Payment Comment/Details</label>
                                            <textarea class="form-control" required name="comment" placeholder="Any Comment/Details"></textarea>
                                        </div>
                                    </div>

                                    {{--<div class="form-group">--}}
                                        {{--<div class="col-md-12">--}}
                                            {{--<center>--}}
                                                {{--<button type="button" class="action-button previous previous_button">Back</button>--}}
                                                {{--<a href="#" class="action-button">Finish</a>--}}
                                                {{--<input type="submit" name="complete" value="Complete" class="btn btn-flat btn-success" style="margin-top:15px">--}}
                                            {{--</center>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}

                                    <button type="button" class="action-button previous previous_button">Back</button>
                                    <button type="submit" class="next action-button">Save</button>

                            </fieldset>
                                        <input type="hidden" name="batch_no" value="{{$chapter_details->batch_no}}"/>
                            </form>
                        </div>
                    </section>
                    <!-- End Multi step form -->
                </div>
            </div>

        </div>
    </section>
@endsection
@section('footerscripts')
    <script src="{{asset('js/bootstrap-switch.min.js')}}"></script>
    <script src="{{ asset('plugins/icheck/icheck.min.js') }}"></script>
    <script>
        (function($) {
            "use strict";

            //* Form js
            function verificationForm(){
                //jQuery time
                var current_fs, next_fs, previous_fs; //fieldsets
                var left, opacity, scale; //fieldset properties which we will animate
                var animating; //flag to prevent quick multi-click glitches

                $(".next").click(function () {
                    if (animating) return false;
                    animating = true;

                    current_fs = $(this).parent();
                    next_fs = $(this).parent().next();

                    //activate next step on progressbar using the index of next_fs
                    $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

                    //show the next fieldset
                    next_fs.show();
                    //hide the current fieldset with style
                    current_fs.animate({
                        opacity: 0
                    }, {
                        step: function (now, mx) {
                            //as the opacity of current_fs reduces to 0 - stored in "now"
                            //1. scale current_fs down to 80%
                            scale = 1 - (1 - now) * 0.2;
                            //2. bring next_fs from the right(50%)
                            left = (now * 50) + "%";
                            //3. increase opacity of next_fs to 1 as it moves in
                            opacity = 1 - now;
                            current_fs.css({
                                'transform': 'scale(' + scale + ')',
                                'position': 'absolute'
                            });
                            next_fs.css({
                                'left': left,
                                'opacity': opacity
                            });
                        },
                        duration: 800,
                        complete: function () {
                            current_fs.hide();
                            animating = false;
                        },
                        //this comes from the custom easing plugin
                        easing: 'easeInOutBack'
                    });
                });

                $(".previous").click(function () {
                    if (animating) return false;
                    animating = true;

                    current_fs = $(this).parent();
                    previous_fs = $(this).parent().prev();

                    //de-activate current step on progressbar
                    $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");

                    //show the previous fieldset
                    previous_fs.show();
                    //hide the current fieldset with style
                    current_fs.animate({
                        opacity: 0
                    }, {
                        step: function (now, mx) {
                            //as the opacity of current_fs reduces to 0 - stored in "now"
                            //1. scale previous_fs from 80% to 100%
                            scale = 0.8 + (1 - now) * 0.2;
                            //2. take current_fs to the right(50%) - from 0%
                            left = ((1 - now) * 50) + "%";
                            //3. increase opacity of previous_fs to 1 as it moves in
                            opacity = 1 - now;
                            current_fs.css({
                                'left': left
                            });
                            previous_fs.css({
                                'transform': 'scale(' + scale + ')',
                                'opacity': opacity
                            });
                        },
                        duration: 800,
                        complete: function () {
                            current_fs.hide();
                            animating = false;
                        },
                        //this comes from the custom easing plugin
                        easing: 'easeInOutBack'
                    });
                });

//                $(".submit").click(function () {
//                    return false;
//                })
            };

            //* Add Phone no select
//            function phoneNoselect(){
//                if ( $('#msform').length ){
//                    $("#phone").intlTelInput();
//                    $("#phone").intlTelInput("setNumber", "+880");
//                };
//            };
            //* Select js
//            function nice_Select(){
//                if ( $('.product_select').length ){
//                    $('select').niceSelect();
//                };
//            };
            /*Function Calls*/
            verificationForm ();
//            phoneNoselect ();
//            nice_Select ();
        })(jQuery);
    </script>
    <script src="{{asset('js/jquery.dataTables.min.js')}}"></script>
    <script>
        //        var editor;
        $(document).ready(function() {
            var table = $('#dtrows').DataTable( {
                "processing": true,
//                select: true
            } );
            $('#paymentform').on('submit', function(e){
//                alert('submit clicked');
                var form = this;

                // Encode a set of form elements from all pages as an array of names and values
                var params = dt.$('input,select,textarea').serializeArray();

                // Iterate over all form elements
                $.each(params, function(){
                    // If element doesn't exist in DOM
                    if(!$.contains(document, form[this.name])){
                        // Create a hidden element
                        $(form).append(
                            $('<input>')
                                .attr('type', 'hidden')
                                .attr('name', this.name)
                                .val(this.value)
                        );
                    }
                });
            });
        })
    </script>
@endsection