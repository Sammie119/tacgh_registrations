@extends('layouts.app')
@section('beforecss')
    {{--    <link rel="stylesheet" href="{{ asset('css/AdminLTE.min.css') }}">--}}
    <style>
        td>strong{
            margin-right: 25px;
        }
        #qrcode{
            margin: auto;
            margin-bottom: 40px;
            margin-top: 40px;
            text-align: center;
        }
    </style>
@endsection

@section('content')
    <section style="margin-top: 50px;">
        <div class="container">
            {{--<div style="text-align: center; margin-bottom: 30px">--}}
            {{--<img src="{{asset('img/aposa-main_edit.png')}}" style="text-align: center;max-width:200px;"/>--}}
            {{--</div>--}}
            <div style="margin: 1rem 0;">
                <p style="text-align:right">
                    <a href="{{URL::previous()}}" class="btn btn-flat btn-danger">
                        Go Back
                    </a>
                    <a href="{{route('registrant.camper_logout')}}" class="btn btn-flat btn-default">
                        Log out
                    </a>
                </p>
                
            </div>
            <div style="background: #f6f9fb;margin: 1.5rem 0; padding: 0.5rem 1rem 3rem;">
                <h2 style="text-align: center;">{{ get_current_event()->name }} - My Profile</h2>
                <hr>
                <div id="qrcode">
                    @if(isset($camper->qrcode))
                        {!! QrCode::size(200)->generate($camper->qrcode->qrcode) !!}
                    @else
                        <h3>No Qr-Code assigned</h3>
                    @endif
                </div>
                <div class="table-reaponsive">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <td colspan="2">
                                <strong>Name : </strong>
                                @isset($camper->surname)
                                    {{$camper->surname ." ". $camper->firstname}}
                                @endisset
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Camper ID : </strong>
                                @isset($camper->reg_id)
                                    {{$camper->reg_id}}
                                @endisset
                            </td>
                            <td>
                                <strong>Batch No : </strong>
                                @isset($camper->batch_no)
                                    {{$camper->batch_no}}
                                @endisset
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>AGD No : </strong>
                                @isset($camper->agd_no)
                                    ENG 200
                                @endisset
                            </td>
                            <td>
                                <strong>Camper Type : </strong>
                                @isset($camper->campercat_id)
                                    {{$camper->campercat->FullName}}
                                @endisset
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <strong>Residence : </strong>
                                @isset($camper->room_id)
                                    <span class="text-primary">{{ "$resName, $blockName, Room No.: $roomName" }}</span>
                                @endisset
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('footerscripts')
@endsection