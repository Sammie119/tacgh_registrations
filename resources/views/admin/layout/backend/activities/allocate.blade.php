@extends('admin.layout.template')
@section('afterAllCss')
  <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
@endsection
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <section class="content-header">

      <h1>List of Residence for room allocation</h1>
      <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">List of Residence for room allocation</li>
    </ol>

  </section>
  <section class="content">
    <div class="row">
      @php
        $count = 0;
      @endphp
      @foreach($residences as $residence)
        @php
          $count += 1;
        @endphp
        <div class="col-md-3">
          <div class="box box-solid">
            <div class="box-header with-border">
              <i class="fa fa-building"></i>

              <h3 class="box-title">{{ $residence->residence }}</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              @php
                $get_blocks = $blocks->where('residence_id',$residence->residence_id);
              @endphp
              @foreach($get_blocks as $block)
              @php
                if($block->assigned_to >= $block->total_beds){
                  $btn_type = "btn-danger";
                }else{
                  $btn_type = "btn-success";
                }
              @endphp
              
                <a class="btn {{ $btn_type }} btn-flat btn-block" href="{{ route('rooms',$block->block_id) }}">{{ $block->block." ( ".$block->assigned_to." out of ".$block->total_beds." ) " }}</a>
              @endforeach
            </div>
            <!-- /.box-body -->
          </div>
        </div>
        @if($count%4==0)
          </div>
          <div class="row">
        @endif
      @endforeach
    </div>
  </section>
</div>
<!-- /.content-wrapper -->
@endsection