@extends('admin.layout.template')
@section('afterAllCss')
    <link rel="stylesheet" type="text/css" href="{{asset('css/camper-tag-style.css')}}">
    <style>
        @CHARSET "UTF-8";
        .page-break {
            page-break-after: always;
            page-break-inside: avoid;
            clear:both;
        }
        .page-break-before {
            page-break-before: always;
            page-break-inside: avoid;
            clear:both;
        }
        .hide-item{display:none;}
    </style>

@endsection
@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title">Qr Codes</h3>
                        </div>
                        <div class="box-body">
                                <form action="{{route('registrant.campertaggenerate')}}" id="schedule-submit" method="post">
                                    {{csrf_field()}}
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label>Camper Tag Category</label>
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-caret-down"></i>
                                                </div>
                                                {!! Form::select('campercat',$camper_cats->prepend('Choose...',''),null,['class'=>'form-control pull-right']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <button type="submit" class="btn btn-primary btn-flat" style="margin-top: 2.5rem;">
                                                <i class="fa fa-id-card"></i> Generate Tags
                                            </button>

                                        </div>
                                        <div class="form-group col-md-4">
                                            <button class="btn btn-primary btn-flat" id="printTags" style="margin-top: 2.5rem;" {{($codes == null)?'disabled':''}}>
                                                <i class="fa fa-print"></i> Save Tags
                                            </button>
                                        </div>
                                    </div>
                                    @if($codes)
                                    <div clas="row">{{$no_of_pages}}/{{$total_codes}} pages</div>
                                    @endif
                                </form>
                        </div>
                    </div>
                </div>
            </div>
            </ol>
        </section>
        <section>
            <div class="hide-item">{{$counter = 1}}</div>
            <div id="print-content">
            @if($codes)
                @foreach($codes as $key=>$code)
                    @if($counter % 10 == 1)
                        <page size="A4">
                            <div id="html-to-pdfwrapper{{$key}}">
                                <div class="camp-tags" id="camper-tags">
                                    @endif
                                    @if($key % 2 ==0)
                                        <div class="card-row">
                                            <div class="card-holder">
                                                <div class="card-side-bar">
                                                    <div class="vertical-text rotate">
                                                        <h4 class="side-text">
                                                            CAMP MEETING <span class="year-text">{{date('Y')}}</span>
                                                            {{-----}}
                                                            {{--@if(strlen($code->campercat->FullName)>8)--}}
                                                            {{--{{substr($code->campercat->FullName,0,8)."..."}}--}}
                                                                {{--@else--}}
                                                                {{--{{$code->campercat->FullName}}--}}
                                                                {{--@endif--}}
                                                        </h4>
                                                    </div>
                                                </div>
                                                <div class="card-content">
                                                    <div class="id-content"style="background-color: #fff; width: 100%; height: 100%; position: relative;">
                                                        <div class="id-header" style="padding:4px;position: relative;height: 40px;background: #009bf4;">
                                                            <img src="{{asset('img/aposa-main_edit.png')}}" style="width:60px;height:auto;position: absolute;"/>
                                                            <h6 style="position: absolute;right: 7px; margin: 0;font-size: 13px; text-transform: uppercase;
                            font-family: 'Times New Roman';margin-top: 3px; color: #fff;">
                                                                The Apostolic Church-Ghana,<br/>Students and Associates (APOSA)
                                                            </h6>
                                                        </div>
                                                        <div class="descp">
                                                            <span class="id-descp-theme">THEME: <span style="font-style: italic;font-weight: bolder;font-size:16px">Arise & Build</span><span style="font-size: smaller;"> Nehemiah 2:20</span></span>
                                                            <div class="bar" style=""></div>
                                                            <span style="font-size:xx-small;color:red;font-weight: 600;">26TH - 30TH DEC, {{ date('Y') }} @ Apostolic Resources Centre - Fafraha</span>
                                                        </div>
                                                        <div class="camperInfo">
                                                            <p><i class="fa fa-user"></i></p>
                                                            <p><i class="fa fa-at"></i></p>
                                                            <p><i class="fa fa-bed"></i></p>
                                                            <p><i class="fa fa-hashtag"></i>AGD</p>
                                                        </div>
                                                        {{--<div class="qrcode">--}}
                                                            {{--{!! QrCode::size(100)->generate($code->qrcode) !!}--}}
                                                        {{--</div>--}}
                                                    </div>
                                                </div>
                                            </div>
                                    @else
                                        <div class="card-holder">
                                            <div class="card-side-bar">
                                                <div class="vertical-text rotate">
                                                    <h4 class="side-text">
                                                        CAMP MEETING <span class="year-text">{{date('Y')}}</span>
                                                        {{--@if(strlen($code->campercat->FullName)>8)--}}
                                                            {{--{{substr($code->campercat->FullName,0,8)."..."}}--}}
                                                        {{--@else--}}
                                                            {{--{{$code->campercat->FullName}}--}}
                                                        {{--@endif--}}
                                                    </h4>
                                                </div>
                                            </div>
                                            <div class="card-content">
                                                <div class="id-content"style="background-color: #fff; width: 100%; height: 100%; position: relative;">
                                                    <div class="id-header" style="padding:4px;position: relative;height: 40px;background: #009bf4;">
                                                        <img src="{{asset('img/aposa-main_edit.png')}}" style="width:60px;height:auto;position: absolute;"/>
                                                        <h6 style="position: absolute;right: 7px; margin: 0;font-size: 13px; text-transform: uppercase;
                    font-family: 'Times New Roman';margin-top: 3px; color: #fff;">
                                                            The Apostolic Church-Ghana,<br/>Students and Associates (APOSA)
                                                        </h6>
                                                    </div>
                                                    <div class="descp">
                                                        <span class="id-descp-theme">THEME: <span style="font-style: italic;font-weight: bolder;font-size:16px">Arise & Build</span><span style="font-size: smaller;"> Nehemiah 2:20</span></span>
                                                        <div class="bar" style=""></div>
                                                        <span style="font-size:xx-small;color:red;font-weight: 600;">26TH - 30TH DEC, {{ date('Y') }} @ Apostolic Resources Centre - Fafraha</span>
                                                    </div>
                                                    <div class="camperInfo">
                                                        <p><i class="fa fa-user"></i></p>
                                                        <p><i class="fa fa-at"></i></p>
                                                        <p><i class="fa fa-bed"></i></p>
                                                        <p><i class="fa fa-hashtag"></i>AGD</p>
                                                    </div>
                                                    {{--<div class="qrcode">--}}
                                                        {{--{!! QrCode::size(100)->generate($code->qrcode) !!}--}}
                                                    {{--</div>--}}
                                                </div>
                                            </div>
                                        </div>
                                        </div>
                                    @endif
                                    @if($counter % 10 == 0)
                                </div></div></page>
                        @endif
                    <div class="hide-item"> {{$counter++}}</div>
                        @endforeach
                        </div>
                        </div>
                    @endif
                    </div>
        </section>
    </div>
@endsection

@section('afterMainScripts')
    <script src="{{asset('js/jquery-ui.min.js')}}"></script>
    <script src="{{asset('plugins/jquery-printme.js')}}"></script>
    <script>

    $(document).ready(function(){
        $('#printTags').click(function () {
            $('#print-content').printMe({ "path": ["{{asset('css/camper-tag-style.css')}}","https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css"]});
        });
        $('.hide-item').hide();
    })

    </script>
@endsection