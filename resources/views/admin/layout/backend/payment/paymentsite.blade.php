@extends('admin.layout.template')
@section('afterAllCss')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.4.2/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/rowgroup/1.0.2/css/rowGroup.dataTables.min.css">
    <style>
        a.dt-button{border:none;width:auto;height:auto;}
    </style>

@endsection
@section('content')
    <section class="content-wrapper">
                        @if($api_details)
                            <form name='form' action='{{$api_details['base_url']}}' method='post' id="myForm">
                            {{--<form name='form' action='testpayment' method='post' id="myForm">--}}
                                {{--{{ csrf_field() }}--}}
                                {{--{{ method_field('post') }}--}}
                                <input type='hidden' name='clientid' value='{{$api_details['client_id']}}'>
                                <input type='hidden' name='itemname' value='{{$api_details['item_name']}}'>
                                <input type='hidden' name='clientref' value='{{$api_details['client_ref']}}'>
                                <input type='hidden' name='clientsecret' value='{{$api_details['client_secret']}}'>
                                <input type='hidden' name='returnurl' value='{{$api_details['return_url']}}'>
                                <input type='hidden' name='amount' value='{{$api_details['payment_amount']}}'>
                                <input type='hidden' name='securehash' value='{{$api_details['hash_string']}}'>
                            </form>
                        @endif
            </div>
        </div>
    </section>
@endsection
@section('afterMainScripts')
    <script >

        document.getElementById('myForm').submit();

//        $(document).ready(function() {
//            alert("I'm ready ");
//        })
    </script>
@endsection