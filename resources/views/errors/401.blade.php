@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Permissions<div style="float: right"></div></div>

                    <div class='panel-body'>
                        <h1><center>Error <span style="color:red">#401</span><br>
                                ACCESS DENIED</center></h1>
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