@extends('admin.layout.template')
@section('afterAllCss')
<link rel="stylesheet" href="{{ asset('plugins/iCheck/all.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/datatables/dataTables.bootstrap.css') }}">
{{-- <link rel="stylesheet" href="{{ asset('plugins/datatables/jquery.dataTables.min.css') }}"> --}}
<link rel="stylesheet" href="{{asset('css/buttons.dataTables.min.css')}}">
@endsection
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content-header">

        <h1>All paid Applicants</h1>
        <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Paid applicants</li>
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
                        {{-- {{ var_dump($applicants) }} --}}
                        <div class="table-responsive">
                            <table id="paid" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>Reg.#</th>
                                    <th>Batch #</th>
                                    <th>Name</th>
                                    <th>Gender</th>
                                    {{--<th>Age</th>--}}
                                    <th>Status</th>
                                    <th>Phone #</th>
                                    <th>Email</th>
                                    <th>Camper Type</th>
                                    <th>AGD Lang.</th>
                                    <th>Office Held</th>
                                    <th>Nationality</th>
                                    <th>Region</th>
                                    <th>Area</th>
                                    <th>Chapter</th>
                                    <th>Assembly</th>
                                    <th>Profession</th>
                                    <th>AGD Leader?</th>
                                    <th>AGD #</th>
                                    <th>Foreign Delegate?</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($applicants as $applicant)
                                        <tr>
                                            <td>{{ $applicant->reg_id }}</td>
                                            <td>{{ $applicant->batch_no}}</td>
                                            <td>{{ $applicant->firstname." ".$applicant->surname }}</td>
                                            <td>{{ $applicant->gender->FullName }}</td>
                                            {{--<td>{{ $applicant->dob }}</td>--}}
                                            <td>{{ $applicant->maritalstatus->FullName }}</td>
                                            <td>{{ $applicant->telephone }}</td>
                                            <td>{{ $applicant->email }}</td>
                                            <td>{{ $applicant->campercat->FullName}}</td>
                                            <td>{{ $applicant->agdlang->FullName }}</td>
                                            <td>{{ $applicant->officechurch->FullName }}</td>
                                            <td>{{ $applicant->nationality }}</td>
                                            <td>{{ $applicant->region->FullName }}</td>
                                            <td>{{ $applicant->area->FullName}}</td>
                                            <td>{{ $applicant->chapter }}</td>
                                            <td>{{ $applicant->localassembly }}</td>
                                            <td>{{ $applicant->profession }}</td>
                                            <td>{{ $applicant->agdleader->FullName }}</td>
                                            <td>{{ $applicant->agd_no }}</td>
                                            <td>{{ $applicant->foreigndelegate->FullName }}</td>
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
//                    {
//                        extend:    'csvHtml5',
////                        text:      '<i class="fa fa-file-text-o"></i>',
//                        text:      '<img src="img/exportexcel.png" />',
//                        titleAttr: 'CSV'
//                    },
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