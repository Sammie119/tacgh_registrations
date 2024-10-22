@extends('layouts.app')
@section('beforecss')
        <style>
            .introtext{
                display: inline-block;
                float: left;
                width: 50%;
                padding: 0 10px;
                margin: 9px 0 0 0;
                color: #8C979E;
                text-align: center;
                line-height: 24px;
            }
            .introtext a{text-decoration: none;}
            /*.maincontainer{animation: scale 20s linear infinite;}*/
            /*@keyframes scale {
                50% {
                    -webkit-transform:scale(1.2);
                    -moz-transform:scale(1.2);
                    -ms-transform:scale(1.2);
                    -o-transform:scale(1.2);
                    transform:scale(1.2);
                }*/

        </style>
@endsection
@section('content')
<div id="transparent-dark">
    <h1>APOSA Campmeeting {{date('Y')}}</h1>
    <div class="logmod" style="heigth:0;max-height:200px;">
        <div class="logmod__wrapper">

            <div class="logmod__container">
                <ul class="logmod__tabs">
                    <li data-tabtar="lgm-1"><a href="#">Get Started</a></li>
                </ul>
                <div class="logmod__tab-wrapper">
                    <div class="logmod__tab lgm-1">
                        <div class="logmod__form">
                            <div class="simform__actions introtext" style="width:100%;text-align:left;">

                                    We are glad to find you here interested in registering for APOSA Campmeeting 2017.
                            </div>
                            <div class="simform__actions">
                                <a href="{{url('registrant/create')}}" class="sumbit" name="commit" type="sumbit" />Register</a>

                                <span class="simform__actions-sidetext">Are you an individual?</span>
                            </div>
                            <div class="simform__actions">
                                <a href="{{url('bacthregistration')}}" class="sumbit" name="commit" type="sumbit" />Batch registration</a>

                                <span class="simform__actions-sidetext">Are you a chapter or group?</span>
                            </div>
                            <div class="simform__actions introtext" style="width:100%;text-align:left;margin-bottom:20px;">

                                By registering, you agree to our <a class="special" href="#" role="link">Terms & Conditions</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
        
@endsection