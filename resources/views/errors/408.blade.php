@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Error<div style="float: right"></div></div>

                    <div class='panel-body'>
                        <h1><center> <span style="color:red">Error1</span><br>
                                Sorry some error occured!</center></h1>
                        <div>
                            <center>
                                <a href="{{url()->previous()}}" class="btn btn-flat btn-primary"><i class="fa fa-angle-left" aria-hidden="true" style="margin-right:5px"></i> Back</a>
                            </center>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection