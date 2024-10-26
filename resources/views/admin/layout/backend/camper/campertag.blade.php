@extends('admin.layout.template')
@section('afterAllCss')
    {{--<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">--}}
    <link rel="stylesheet" href="{{asset('css/jquery-ui.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/jquery.dataTables.min.css')}}">

    <style>
        {{--Custom--}}
        #qrcode{
            position: absolute;
            bottom: 0;
            right: 0;
        }
        .bar{
            width: 40%;
            margin: auto;
            height: 2px;
            background: #ff0000;
            margin-top: 5px;
        }
        .camperInfo,.descp{
            font-size: 11px;
            padding: 5px;
        }
        .camperInfo p{
            margin-bottom: 6px;
            font-weight: 600;
            font-size: 12px;
        }
        .camperInfo p>i{
            margin-right: 7px;
        }
        .camperInfo{
            position: absolute;
            left: 0;
        }
        /*End of Custom*/
        .card {
            box-shadow: 0 14px 28px rgba(0, 0, 0, 0.25), 0 10px 10px rgba(0, 0, 0, 0.22);
            display: grid;
            font-family: 'Trebuchet MS', sans-serif;
            height: 200px;
            margin: 20px auto;
            width: 350px;
            position: relative;
        }
        .front {
            grid-template-columns: repeat(12, 1fr);
            grid-template-rows: repeat(4, 1fr);
        }
        .front .blue {
            background-color: #4cc9c8;
            grid-column: 8 / span 5;
            grid-row: 1 / span 4;
        }
        .front .yellow {
            background-color: #f1ef1c;
            grid-column: 1 / span 7;
            grid-row: 1 / span 4;
        }
        .front .pink {
            background-color: #fa001a;
            -webkit-clip-path: polygon(0% 0%, 100% 0%, 0% 100%);
            clip-path: polygon(0% 0%, 100% 0%, 0% 100%);
            grid-row: 1 / span 3;
            grid-column: 1 / span 11;
            position: relative;
            z-index: 2;
        }
        .front .dots {
            background: radial-gradient(#fa001a 20%, transparent 19%), radial-gradient(#fa001a 20%, transparent 19%), transparent;
            background-size: 6px 6px;
            background-position: 0 0, 3px 3px;
            grid-column: 1 / span 12;
            grid-row: 3 / span 2;
            margin: 0 0 15px 20px;
            z-index: 1;
        }
        .front .personal-intro {
            background: black;
            color: white;
            display: flex;
            flex-direction: column;
            grid-column: 4 / span 6;
            grid-row: 2 / span 2;
            justify-content: center;
            text-align: center;
            z-index: 3;
        }
        .front .personal-intro p {
            letter-spacing: 1px;
            text-transform: uppercase;
        }
        .front .personal-intro p:first-of-type {
            font-size: 18px;
        }
        .front .personal-intro p:last-of-type {
            font-size: 8px;
            margin-top: 5px;
        }
        .back {
            grid-template-columns: repeat(12, 1fr);
            grid-template-rows: repeat(12, 1fr);
        }
        .back .yellow {
            background-color: #f1ef1c;
            grid-column: 1 / span 9;
            grid-row: 1 / span 3;
        }
        .back .top.dots {
            background: radial-gradient(#4cc9c8 20%, transparent 19%), radial-gradient(#4cc9c8 20%, transparent 19%), transparent;
            background-size: 6px 6px;
            background-position: 0 0, 3px 3px;
            grid-column: 8 / span 6;
            grid-row: 2 / span 3;
        }
        .back .personal-info {
            grid-column: 2 / span 6;
            grid-row: 5 / span 6;
        }
        .back .personal-info p {
            font-size: 10px;
        }
        .back .personal-info p:first-of-type {
            font-size: 18px;
            font-weight: bold;
            letter-spacing: 1px;
            text-transform: uppercase;
        }
        .back .personal-info p:nth-of-type(2) {
            font-size: 12px;
            margin-bottom: 15px;
        }
        .back .bottom.dots {
            background: radial-gradient(#4cc9c8 20%, transparent 19%), radial-gradient(#4cc9c8 20%, transparent 19%), transparent;
            background-size: 6px 6px;
            background-position: 0 0, 3px 3px;
            grid-column: 1 / span 8;
            grid-row: 11 / span 2;
            z-index: 2;
        }
        .back .pink {
            background-color: #fa001a;
            grid-column: 8 / span 5;
            grid-row: 10 / span 3;
        }
        .back .ministry{
            background-color: #f1ef1c;
            grid-column: 1 / span 9;
            grid-row: 1 / span 3;
            width:40px;height:100%;border:1px solid teal;
        }

        .card-holder {
            display: grid;
            height: 200px;
            margin: 20px auto;
            width: 350px;

            box-shadow: 0 14px 28px rgba(0, 0, 0, 0.25), 0 5px 5px rgba(0, 0, 0, 0.22);
            /*position:relative;*/
            border:1px solid black;
            grid-template-columns: 40px 310px;
            grid-template-rows: 45px 65px 90px;
        }
        .item-a {
            background-color:red;
            /*width:40px;*/
            height:100%;
            grid-column-start: 1;
            grid-column-end: 2;
            grid-row-start: 1;
            grid-row-end: end;

            position: relative;
            display: inline-block;
            /*margin: 0 15px;*/
        }
        .item-b {
            /*border:1px solid red;*/
            grid-column-start: 2;
            grid-column-end: span 2;
            grid-row-start: 1;
            grid-row-end: 1;
            display:inline-block;
            border-bottom: 2px solid black;
        }
        .item-c {
            /*border:1px solid goldenrod;*/
            grid-column-start: 2;
            grid-column-end: span 2;
            grid-row-start: 2;
            grid-row-end: 2;
            display:inline-block;
            border-bottom: 1px solid black;
        }
        .item-d {
            /*border:1px solid blue;*/
            grid-column-start: 2;
            grid-column-end: span 2;
            grid-row-start: 3;
            grid-row-end: 3;

            display:flex;
            align-items: flex-start;
            justify-content: space-around;
        }
        .vertical-text {
            position: absolute;
            top:50%;
            left: 50%;
            white-space: nowrap !important;

            color:white;
            text-transform: uppercase;
            font-size:14pt;
            font-weight: bolder;
            line-height: 40px;
            text-align: center;
        }
        .rotate {
            -moz-transform: translateX(-50%) translateY(-50%) rotate(-90deg);
            -webkit-transform: translateX(-50%) translateY(-50%) rotate(-90deg);
            transform:  translateX(-50%) translateY(-50%) rotate(-90deg);
        }
        .year-text{
            background-color: red;
            color:white;
            padding:2px 2px;
        }
        .camper-details{
            font-weight: 900;
        }
        .card-details{
            border-bottom: 1px black dotted;
        }

    </style>
@endsection
@section('content')
    <section class="content-wrapper">
        <section class="content-header">
            <h1>Applicants</h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Applicants</li>
            </ol>
        </section>
        <div class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-solid">
                        <div class="panel-body">
                            <div class="card-holder" style="width: 322px;">
                                <div class="item-a">
                                    <div class="vertical-text rotate">
                                        <h6>The Apostolic Church-Ghana,<br/>Students and Associates (APOSA)</h6>
                                    </div>
                                </div>
                                <div class="item-b">
                                    <div class="row" style="padding:2px;display: flex;justify-content:center;align-items: center;flex-flow: row wrap;">
                                        <div class="col-lg-2 clientlogo" style="display:inline-block; width:40px;height:35px; align: center;vertical-align: middle;" >
                                            <img src="{{App::isLocal() ? asset('img/aposa-main_edit.png') : asset('public/img/aposa-main_edit.png') }}" style="width:40px;height:35px;"/></div>
                                        <div class="col-lg-8" style=" display: flex;justify-content: center;;vertical-align: middle;text-transform: uppercase;font-size: 12px;font-weight: bolder">
                                            <div class="item-c">
                                                <div style="text-align: center;font-size: 12pt;font-weight: bolder">
                                                    CAMPMEETING <span class="year-text">2018</span>
                                                </div>
                                                <div style="text-align: center;font-size: 10pt;font-weight: bolder">
                                                    THEME: LET GOD ARISE <span class="scripture-text">(NUMBERS 10:35)</span>
                                                </div>
                                                <div style="text-align: center;font-size: 8pt;font-weight: bolder">
                                                    From Wed. 26th-Sun. 30th December, 2018 @LEGON, Accra
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="item-d">
                                    <div style=" flex-grow: 2;padding:5px;" class="camper-details">
                                        <div>
                                            NAME: <span class="card-details">Bernard Sowah Adjetey</span>
                                        </div>
                                        <div>
                                            Chapter: <span class="card-details">La</span>
                                        </div>
                                        <div>
                                            Residence:<span class="card-details">Katanga Room 45A</span><br/>AGD No:<span class="card-details">ENG 201</span>
                                        </div>
                                    </div>
                                    <div style="display:inline-block;height:auto;margin-right:5px">
                                        {!! QrCode::size(80)->generate("ACM0021") !!}
                                    </div>
                                </div>
                            </div>
                            {{--<div class="card front">--}}
                            {{--<div class="blue"></div>--}}
                            {{--<div class="yellow"></div>--}}
                            {{--<div class="pink"></div>--}}
                            {{--<div class="dots"></div>--}}
                            {{--<div class="personal-intro">--}}
                            {{--<p>Krista Stone</p>--}}
                            {{--<p>Photographer Maker Doer</p>--}}
                            {{--</div>--}}
                            {{--</div>--}}

                            {{--<div class="card front">--}}
                            {{--<div class="blue"></div>--}}
                            {{--<div class="yellow"></div>--}}
                            {{--<div class="pink"></div>--}}
                            {{--<div class="dots"></div>--}}
                            {{--<div class="personal-intro">--}}
                            {{--<p>Krista Stone</p>--}}
                            {{--<p>Photographer Maker Doer</p>--}}
                            {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="card back">--}}

                            {{--<div class="yellow"></div>--}}
                            {{--<div class="top dots"></div>--}}
                            {{--<div class="personal-info">--}}
                            {{--<div class="vertical-text ministry">Teens Ministry</div>--}}
                            {{--<p>Krista Stone</p>--}}
                            {{--<p>Photographer. Maker. Doer.</p>--}}
                            {{--<p>123 Address St</p>--}}
                            {{--<p>Sacramento, CA 14234</p>--}}
                            {{--<p>567.890.1234</p>--}}
                            {{--<p>www.kristastone.com</p>--}}
                            {{--<p>@kristastone</p>--}}
                            {{--</div>--}}
                            {{--<div class="bottom dots"></div>--}}
                            {{--<div class="pink"></div>--}}
                            {{--</div>--}}

                            {{--<div class="card back">--}}
                            {{--<div class="yellow"></div>--}}
                            {{--<div class="top dots"></div>--}}
                            {{--<div class="personal-info">--}}
                            {{--<p>Krista Stone</p>--}}
                            {{--<p>Photographer. Maker. Doer.</p>--}}
                            {{--<p>123 Address St</p>--}}
                            {{--<p>Sacramento, CA 14234</p>--}}
                            {{--<p>567.890.1234</p>--}}
                            {{--<p>www.kristastone.com</p>--}}
                            {{--<p>@kristastone</p>--}}
                            {{--</div>--}}
                            {{--<div class="bottom dots"></div>--}}
                            {{--<div class="pink"></div>--}}
                            {{--</div>--}}
                        </div>
                    </div>
                </div>
            </div>

            {{--Sample Card--}}
            <div class="id-box">
                <div class="id-box" style="margi: auto; width: 310px; height: 204px; padding: 5px;background: #ff0000;">
                    <div class="id-content"style="background-color: #fff; width: 100%; height: 100%; position: relative;">
                        <div class="id-header" style="padding:4px;position: relative;height: 40px;background: #009bf4;">
                            <img src="{{App::isLocal() ? asset('img/aposa-main_edit.png') : asset('public/img/aposa-main_edit.png') }}" style="width:60px;height:auto;position: absolute;"/>
                            <h6 style="position: absolute;right: 7px; margin: 0;font-size: 12px; text-transform: uppercase;
                            font-family: 'Times New Roman';margin-top: 5px; color: #fff;">
                                The Apostolic Church-Ghana,<br/>Students and Associates (APOSA)
                            </h6>
                        </div>
                        <div class="descp">
                            <span style="display: block;font-size: 14px;text-align: center;font-weight: 700;">CAMPMEETING
                                <span style="color: #ff0000;">{{date('Y')}}</span>
                            </span>
                            <span style="display: block;text-align: center;font-weight: 500;">THEME: LET GOD ARISE (NUMBERS 10:35)</span>
                            <div class="bar" style=""></div>
                            {{--<span style="display: block;">FROM WED. 26TH-SUN. 30TH DECEMBER, 2018 @LEGON, ACCRA</span>--}}
                        </div>
                        <div class="camperInfo">
                            <p><i class="fa fa-user"></i> Bernard Sowah Adjetey</p>
                            <p><i class="fa fa-at"></i> La Chapter</p>
                            <p><i class="fa fa-bed"></i> Akuafo Hall, Rm 201-A</p>
                            <p><i class="fa fa-hashtag"></i> AGD No. ENG 201</p>
                        </div>
                        <div id="qrcode">
                            {!! QrCode::size(100)->generate("lakjklajsiubkavkaerilkabfklavlkjsdflld98u3905tnegf9qQ#Tqbiu") !!}
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal -->

        </div>
    </section><center>
        <div id="testdiv" style="display:none">

        </div></center>
@endsection

@section('afterMainScripts')
    {{--<script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>--}}
    {{--<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>--}}
    <script src="{{asset('js/jquery-ui.min.js')}}">


    </script>
@endsection