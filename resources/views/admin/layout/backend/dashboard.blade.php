@extends('admin.layout.template')
@section("afterAllCss")
  {{-- <link rel="stylesheet" href="{{ asset('css/highcharts.css') }}"> --}}
  <script src="{{ asset('js/highcharts.js') }}"></script>
  <script src="{{ asset('js/exporting.js') }}"></script>
  {{-- <script src="{{ asset('js/dark-unica.js') }}"></script> --}}
  <script src="{{ asset('js/Chart.min.js') }}"></script>
  {{--<meta http-equiv="refresh" content="60"/>--}}
@endsection
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header"><h1>Dashboard</h1></section>

    <!-- Main content -->
    @hasanyrole(['SysDeveloper','SuperAdmin','Finance Officer'])
    <section class="content">

      {{-- Summary Panels --}}
      <div class="row">
        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>{{ $total_registrants }}</h3>

              <p>Total Applicants</p>
            </div>
            <div class="icon">
              <i class="ion ion-ios-people"></i>
            </div>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>{{ $males }} - {{ $females }}</h3>

              <p>Males - Females</p>
            </div>
            <div class="icon">
              <i class="ion ion-ios-people"></i>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3>{{ $males_paid }} - {{ $females_paid }}</h3>

              <p>Males - Females (Paid Applicants)</p>
            </div>
            <div class="icon">
              <i class="ion ion-cash"></i>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              @if(\Auth()->user()->hasAnyRole(['SysDeveloper','SuperAdmin','Finance Officer']))
                <h3>GH&cent {{ $onlinepayments }}</h3>
              @else
                <h3>GH&cent 0 </h3>
              @endif
              <p>Total amount received</p>
            </div>
            <div class="icon">
              <i class="ion ion-cash"></i>
            </div>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3>{{ $non_residencial }}</h3>

              <p>Paid Non-Residencial</p>
            </div>
            <div class="icon">
              <i class="ion ion-android-walk"></i>
            </div>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          {{-- <div class="small-box bg-red">
            <div class="inner">
              <h3>{{ $rooms_left }} - {{ $beds_left }}</h3>

              <p>Rooms left - Beds left</p>
            </div>
            <div class="icon">
              <i class="ion ion-android-apps"></i>
            </div>
          </div> --}}
          <div class="small-box bg-red">
            <div class="inner">
              <h3>{{ $females_rooms_left }} - {{ $males_rooms_left }}</h3>

              <p>Females rooms left - Males rooms left</p>
            </div>
            <div class="icon">
              <i class="ion ion-android-apps"></i>
            </div>
          </div>
        </div>
        <!-- ./col -->
        <!-- ./col -->

      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Residences</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
              <table class="table table-striped">
                <tr>
                  <th>Residence</th>
                  <th>Beds Allocated</th>
                  <th>Beds Left</th>
                </tr>
                @foreach($residences as $residence)

                  <tr>
                    <td>{{ $residence->residence }}</td>
                    <td>
                      {{ $residence->assigned_to }}
                    </td>
                    <td>
                      {{ $residence->total_beds - $residence->assigned_to }}
                    </td>
                  </tr>

                @endforeach
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <div class="col-md-6">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Campers</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
              <table class="table table-striped">
                <tr>
                  <th style="width: 10px">#</th>
                  <th>Type</th>
                  <th>Total</th>
                  <th style="width: 40px">Percentage</th>
                </tr>
                <tr>
                  <td>1.</td>
                  <td>Senior</td>
                  <td>
                    {{ $senior_paid }}
                  </td>
                  <td><span class="badge bg-red">
                    @if($senior_paid != 0)
                        {{ round(($senior_paid/$paid_applicants)*100, 1) }}%
                      @else
                        0%
                      @endif
                  </span></td>
                </tr>
                <tr>
                  <td>2.</td>
                  <td>Regular</td>
                  <td>
                    {{ $regular_paid }}
                  </td>
                  <td><span class="badge bg-red">
                    @if($regular_paid != 0)
                        {{ round(($regular_paid/$paid_applicants)*100, 1) }}%
                      @else
                        0%
                      @endif
                  </span></td>
                </tr>
                {{--<tr>--}}
                {{--<td>3.</td>--}}
                {{--<td>Junior Teens</td>--}}
                {{--<td>--}}
                {{--{{ $junior_teen_paid }}--}}
                {{--</td>--}}
                {{--<td><span class="badge bg-red">--}}
                {{--@if($junior_teen_paid != 0)--}}
                {{--{{ round(($junior_teen_paid/$paid_applicants)*100, 1) }}%--}}
                {{--@else--}}
                {{--0%--}}
                {{--@endif--}}
                {{--</span></td>--}}
                {{--</tr>--}}
                {{--<tr>--}}
                {{--<td>4.</td>--}}
                {{--<td>Senior Teens</td>--}}
                {{--<td>--}}
                {{--{{ $senior_teen_paid }}--}}
                {{--</td>--}}
                {{--<td><span class="badge bg-red">--}}
                {{--@if($senior_teen_paid != 0)--}}
                {{--{{ round(($senior_teen_paid/$paid_applicants)*100, 1) }}%--}}
                {{--@else--}}
                {{--0%--}}
                {{--@endif--}}
                {{--</span></td>--}}
                {{--</tr>--}}
                {{--<tr>--}}
                {{--<td>5.</td>--}}
                {{--<td>Child</td>--}}
                {{--<td>--}}
                {{--{{ $child_paid }}--}}
                {{--</td>--}}
                {{--<td><span class="badge bg-red">--}}
                {{--@if($child_paid != 0)--}}
                {{--{{ round(($child_paid/$paid_applicants)*100, 1) }}%--}}
                {{--@else--}}
                {{--0%--}}
                {{--@endif--}}
                {{--</span></td>--}}
                {{--</tr>--}}
                {{-- <tr>
                  <td>5.</td>
                  <td>Special Accomodation</td>
                  <td>
                    {{ $special_accm }}
                  </td>
                  <td></td>
                </tr> --}}
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>
      {{-- <div class="row">
        <div class="col-md-6">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Chart</h3>
            </div>
            <div class="box-body no-padding">


            </div><div id="temps_div"></div>
          </div>
        </div>
      </div> --}}


      {{-- Commented the graphs --}}
      {{-- <div class="row" style="margin-top: 30px">

        <div class="col-md-6">
          <div class="box box-solid">
            <canvas id="registrants" width="400" height="230"></canvas>
            <script>
              var ctx = document.getElementById("registrants");
              var myChart = new Chart(ctx, {
                  type: 'bar',
                  data: {
                      labels: ["All", "Male", "Female", "Senior", "Regular", "Teen", "Child"],
                      datasets: [{
                          label: 'Applicants',
                          data: [{{ $total_registrants }}, {{ $males }}, {{ $females }}, {{ $senior }},{{ $regular }}, {{ $teen }},{{ $child }}],
                          backgroundColor: [
                              'rgb(54, 162, 235)','rgb(255, 99, 132)','rgb(255, 99, 132)','#EAA334','#EAA334','#EAA334','#EAA334'
                          ],
                          borderWidth: 0
                      }]
                  },
                  options: {
                    title: {
                        display: true,
                        text: 'Bar Chart for Total Registrants'
                    },
                    layout: {
                        padding: {
                            left: 10,
                            right: 10,
                            top: 10,
                            bottom: 10
                        }
                      },
                      legend: {
                          display:false
                      },
                      scales: {
                          yAxes: [{
                              ticks: {
                                  beginAtZero:true
                              }
                          }]
                      }
                  }
              });
            </script>
          </div>
        </div>

        <div class="col-md-6">
          <div class="box box-solid">
            <canvas id="myChart" width="400" height="230"></canvas>
            <script>
              var ctx = document.getElementById("myChart");
              var myChart = new Chart(ctx, {
                  type: 'bar',
                  data: {
                      labels: ["All", "Male", "Female", "Senior", "Regular", "Teen", "Child"],
                      datasets: [{
                          label: 'Registration',
                          data: [{{ $paid_applicants }}, {{ $males_paid }}, {{ $females_paid }}, {{ $senior_paid }},{{ $regular_paid }}, {{ $teen_paid }},{{ $child_paid }}],
                          backgroundColor: [
                              'rgb(54, 162, 235)','rgb(255, 99, 132)', 'rgb(255, 99, 132)','#EAA334','#EAA334','#EAA334','#EAA334'
                          ],
                          borderWidth: 0
                      }]
                  },
                  options: {
                    title: {
                        display: true,
                        text: 'Bar Chart for Authorized Registrants'
                    },
                    layout: {
                        padding: {
                            left: 10,
                            right: 10,
                            top: 10,
                            bottom: 10
                        }
                      },
                      legend: {
                          display:false
                      },
                      scales: {
                          yAxes: [{
                              ticks: {
                                  beginAtZero:true
                              }
                          }]
                      }
                  }
              });
            </script>
          </div>
        </div>

      </div> --}}

{{--      <div class="row" style="margin-top: 30px">--}}
{{--        <div class="col-md-6">--}}
{{--          <div class="box">--}}
{{--            <div class="box-header">--}}
{{--              <h3 class="box-title">Meal Distributions</h3>--}}
{{--            </div>--}}
{{--            <!-- /.box-header -->--}}
{{--            <div class="box-body no-padding">--}}
{{--              <table class="table table-striped">--}}
{{--                <tr>--}}
{{--                  <th>Center</th>--}}
{{--                  <th>Food Distributed</th>--}}
{{--                </tr>--}}
{{--                @if(sizeof($centres_infos) > 0)--}}
{{--                  @foreach($centres_infos as $centres_info)--}}
{{--                    <tr>--}}
{{--                      <td>{{$centres_info->centre}}</td>--}}
{{--                      <td>{{$centres_info->distributed}}</td>--}}
{{--                    </tr>--}}
{{--                  @endforeach--}}
{{--                @else--}}
{{--                  <tr><td colspan="2" style="text-align: center;">Empty</td></tr>--}}
{{--                @endif--}}
{{--              </table>--}}
{{--            </div>--}}
{{--          </div>--}}
{{--        </div>--}}
{{--      </div>--}}
{{--      <div class="row" style="margin-top: 30px">--}}
{{--        <div class="col-md-6">--}}
{{--          <div class="box">--}}
{{--            <div class="box-header">--}}
{{--              <h3 class="box-title">Camper Fee Types</h3>--}}
{{--            </div>--}}
{{--            <!-- /.box-header -->--}}
{{--            <div class="box-body no-padding">--}}
{{--              <table class="table table-striped">--}}
{{--                <tr>--}}
{{--                  <th style="width: 10px">#</th>--}}
{{--                  <th>Type</th>--}}
{{--                  <th>Total</th>--}}
{{--                  <th>Percentage</th>--}}
{{--                </tr>--}}
{{--                <tr>--}}
{{--                  <td>1.</td>--}}
{{--                  <td>Non-Resident with supper</td>--}}
{{--                  <td>--}}
{{--                    {{ $students_fee }}--}}
{{--                  </td>--}}
{{--                  <td><span class="badge bg-green">--}}
{{--                    @if($students_fee != 0)--}}
{{--                        {{ round(($students_fee/$paid_applicants)*100, 1) }}%--}}
{{--                      @else--}}
{{--                        0%--}}
{{--                      @endif--}}
{{--                  </span></td>--}}
{{--                </tr>--}}
{{--                <tr>--}}
{{--                  <td>2.</td>--}}
{{--                  <td>Regular</td>--}}
{{--                  <td>--}}
{{--                    {{ $regular_fee }}--}}
{{--                  </td>--}}
{{--                  <td><span class="badge bg-green">--}}
{{--                    @if($regular_fee != 0)--}}
{{--                        {{ round(($regular_fee/$paid_applicants)*100, 1) }}%--}}
{{--                      @else--}}
{{--                        0%--}}
{{--                      @endif--}}
{{--                  </span></td>--}}
{{--                </tr>--}}
{{--                --}}{{--<tr>--}}
{{--                --}}{{--<td>3.</td>--}}
{{--                --}}{{--<td>Teens</td>--}}
{{--                --}}{{--<td>--}}
{{--                --}}{{--{{ $teens_fee }}--}}
{{--                --}}{{--</td>--}}
{{--                --}}{{--<td><span class="badge bg-green">--}}
{{--                --}}{{--@if($teens_fee != 0)--}}
{{--                --}}{{--{{ round(($teens_fee/$paid_applicants)*100, 1) }}%--}}
{{--                --}}{{--@else--}}
{{--                --}}{{--0%--}}
{{--                --}}{{--@endif--}}
{{--                --}}{{--</span></td>--}}
{{--                --}}{{--</tr>--}}
{{--                --}}{{--<tr>--}}
{{--                --}}{{--<td>4.</td>--}}
{{--                --}}{{--<td>Child</td>--}}
{{--                --}}{{--<td>--}}
{{--                --}}{{--{{ $children_fee }}--}}
{{--                --}}{{--</td>--}}
{{--                --}}{{--<td><span class="badge bg-green">--}}
{{--                --}}{{--@if($children_fee != 0)--}}
{{--                --}}{{--{{ round(($children_fee/$paid_applicants)*100, 1) }}%--}}
{{--                --}}{{--@else--}}
{{--                --}}{{--0%--}}
{{--                --}}{{--@endif--}}
{{--                --}}{{--</span></td>--}}
{{--                --}}{{--</tr>--}}
{{--                <tr>--}}
{{--                  <td>5.</td>--}}
{{--                  <td>Non-Residential</td>--}}
{{--                  <td>--}}
{{--                    {{ $non_residencial }}--}}
{{--                  </td>--}}
{{--                  <td><span class="badge bg-green">--}}
{{--                    @if($non_residencial != 0)--}}
{{--                        {{ round(($non_residencial/$paid_applicants)*100, 1) }}%--}}
{{--                      @else--}}
{{--                        0%--}}
{{--                      @endif--}}
{{--                  </span></td>--}}
{{--                </tr>--}}
{{--                <tr>--}}
{{--                  <td>6.</td>--}}
{{--                  <td>Non Fee Paying</td>--}}
{{--                  <td>--}}
{{--                    {{ $non_fee_paying }}--}}
{{--                  </td>--}}
{{--                  <td><span class="badge bg-green">--}}
{{--                    @if($non_fee_paying != 0)--}}
{{--                        {{ round(($non_fee_paying/$paid_applicants)*100, 1) }}%--}}
{{--                      @else--}}
{{--                        0%--}}
{{--                      @endif--}}
{{--                  </span></td>--}}
{{--                </tr>--}}
{{--                --}}{{--<tr>--}}
{{--                --}}{{--<td>7.</td>--}}
{{--                --}}{{--<td>Special Accomodation</td>--}}
{{--                --}}{{--<td>--}}
{{--                --}}{{--{{ $special_accm }}--}}
{{--                --}}{{--</td>--}}
{{--                --}}{{--<td><span class="badge bg-green">--}}
{{--                --}}{{--@if($special_accm != 0)--}}
{{--                --}}{{--{{ round(($special_accm/$paid_applicants)*100, 1) }}%--}}
{{--                --}}{{--@else--}}
{{--                --}}{{--0%--}}
{{--                --}}{{--@endif--}}
{{--                --}}{{--</span></td>--}}
{{--                --}}{{--</tr>--}}
{{--              </table>--}}
{{--            </div>--}}
{{--            <!-- /.box-body -->--}}
{{--          </div>--}}
{{--          <!-- /.box -->--}}
{{--        </div>--}}
{{--        <div class="col-md-6">--}}
{{--          <div class="box box-solid">--}}
{{--            <div id="container" style="width:100%; height:400px;">--}}

{{--            </div>--}}
{{--          </div>--}}
{{--          --}}{{--<script>--}}
{{--          --}}{{--// $(function () { --}}
{{--          --}}{{--Highcharts.chart('container', {--}}
{{--          --}}{{--chart: {--}}
{{--          --}}{{--type: 'column'--}}
{{--          --}}{{--},--}}
{{--          --}}{{--tooltip: {--}}
{{--          --}}{{--backgroundColor: {--}}
{{--          --}}{{--linearGradient: [0, 0, 0, 60],--}}
{{--          --}}{{--stops: [--}}
{{--          --}}{{--[0, '#FFFFFF'],--}}
{{--          --}}{{--[1, '#E0E0E0']--}}
{{--          --}}{{--]--}}
{{--          --}}{{--},--}}
{{--          --}}{{--style:{--}}
{{--          --}}{{--color:"#000"--}}
{{--          --}}{{--},--}}
{{--          --}}{{--borderWidth: 1,--}}
{{--          --}}{{--borderColor: '#AAA'--}}
{{--          --}}{{--},--}}
{{--          --}}{{--title: {--}}
{{--          --}}{{--text: 'Comparison Summary Report'--}}
{{--          --}}{{--},--}}
{{--          --}}{{--xAxis: {--}}
{{--          --}}{{--categories: ["Applicants", "Male", "Female", "Senior", "Regular", "Child"]--}}
{{--          --}}{{--},--}}
{{--          --}}{{--yAxis: {--}}
{{--          --}}{{--title: {--}}
{{--          --}}{{--text: 'Values'--}}
{{--          --}}{{--}--}}
{{--          --}}{{--},--}}
{{--          --}}{{--series: [{--}}
{{--          --}}{{--name: 'Total Registered Applicants',--}}
{{--          --}}{{--data: [{{ $total_registrants }}, {{ $males }}, {{ $females }}, {{ $senior }},{{ $regular }},{{ $child }}]--}}
{{--          --}}{{--}, {--}}
{{--          --}}{{--name: 'Total Authorized Applicants',--}}
{{--          --}}{{--data: [ {{ $paid_applicants }}, {{ $males_paid }}, {{ $females_paid }}, {{ $senior_paid }},{{ $regular_paid }}, {{ $teen_paid }},{{ $child_paid }}]--}}
{{--          --}}{{--}]--}}
{{--          --}}{{--});--}}
{{--          --}}{{--// });--}}
{{--          --}}{{--</script>--}}
{{--        </div>--}}
{{--      </div>--}}

    </section>
    @else
      <section class="content">
        Welcome!
      </section>
      @endhasanyrole
      <!-- /.content -->
      {{--@barchart('Temps', 'temps_div')--}}
  </div>
  <!-- /.content-wrapper -->
@endsection