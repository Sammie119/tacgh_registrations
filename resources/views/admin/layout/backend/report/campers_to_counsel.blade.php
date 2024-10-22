@extends('admin.layout.template')
@section('afterAllCss')
    <link rel="stylesheet" href="{{ asset('plugins/icheck/all.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables/dataTables.bootstrap.css') }}">
    {{-- <link rel="stylesheet" href="{{ asset('plugins/datatables/jquery.dataTables.min.css') }}"> --}}
    <link rel="stylesheet" href="{{asset('css/buttons.dataTables.min.css')}}">
@endsection
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <section class="content-header">

            <h1>Campers with Counseling Needs</h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Campers</li>
            </ol>

        </section>
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-solid">
                        <div class="box-header with-border">
                            <a href="{{url()->previous()}}" class="btn btn-default">Back</a>
                        </div>
                        <div class="box-body">
                            <div class="table-responsive">
                                <table id="paid" class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Phone Number</th>
                                        <th>Camper Type</th>
                                        <th>Counseling Area</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($campers as $applicant)
                                        <tr>
                                            <td>{{ $applicant->firstname." ".$applicant->surname }}</td>
                                            <td>{{ $applicant->telephone}}</td>
                                            <td>{{ $applicant->campercat->FullName }}</td>
                                            <td>{{ $applicant->counselingArea->FullName }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@section('afterMainScripts')
    <script src="{{asset('js/jquery-ui.min.js')}}"></script>
    <script src="{{asset('js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('js/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('js/jszip.min.js')}}"></script>
    <script src="{{asset('js/pdfmake.min.js')}}"></script>
    <script src="{{asset('js/vfs_fonts.js')}}"></script>
    <script src="{{asset('js/buttons.html5.min.js')}}"></script>
    {{--<script src="{{asset('js/buttons.print.min.js')}}"></script>--}}
    <script src="{{asset('js/buttons.colVis.min.js')}}"></script>
    <script >
        $(document).ready(function() {
            var paiddt = $('#paid').DataTable({
                select: {
                    selector: 'td:not(:first-child)',
                    style: 'os'
                },
                stateSave: true,
                dom: 'lBfrtip',
                buttons: [

//                    {
//                        extend:    'copyHtml5',
//                        text:      '<i class="fa fa-files-o"></i>',
//                        titleAttr: 'Copy'
//                    },
                    {
                        extend:    'excelHtml5',
                        text:      '<img src="../img/exportexcel.png"/>',
                        titleAttr: 'Excel'
                    },

                    {
                        extend:    'pdfHtml5',
//                        text:      '<i class="fa fa-file-pdf-o"></i>',
                        text:'<img src="../img/exportpdf.png"/>',
                        titleAttr: 'PDF'
                    },
                    {
                        extend:     'colvis',
                        text:       'Toggle Columns'
                    }

                ],
            });

            $('a.toggle-vis').on( 'click', function (e) {
                e.preventDefault();

                // Get the column API object
                var column = table.column( $(this).attr('data-column') );

                // Toggle the visibility
                column.visible( ! column.visible() );
            } );
        });
    </script>
@endsection