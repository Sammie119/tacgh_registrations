<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Report</title>

	<link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
	<script src="{{ asset('js/highcharts.js') }}"></script>
	<script src="{{ asset('js/exporting.js') }}"></script>
	{{-- @php
		include_once "";
	@endphp --}}
	<style type="text/css">
		@import url(https://fonts.googleapis.com/css?family=Open+Sans:300,400,400italic,600);
		body{
			font-family: 'Open Sans', sans-serif;
		}
		.reportTable td,.reportTable th{
			padding: 5px 10px;
		}
	</style>
</head>
<body>

	@php
		$child = 0;
		$teen = 0;
		$regular = 0;
		$senior = 0;
		$cmp = $lookups->where('lookup_code_id', 6);
	@endphp
			
	<div class="container">
		<button class="btn btn-alert" style="border-radius: 0px;margin-top: 20px" onclick="printDiv('printableArea')"><i class="fa fa-print"></i> Print</button>
		<div id="printableArea">
			@if (!is_null($camper_type))
					{{-- <table class="reportTable table-bordered table-striped"> --}}
					<table class="table table-bordered table-striped">
						<caption style="text-align: center;text-transform: uppercase; text-decoration: underline;"><h4>Report on Account for Type of Campers</h4></caption>
						<thead>

							@php
								$camper = [];
								$camperTitle = [];
							@endphp
							<tr>
								@foreach ($cmp as $lookup)
									<th>{{ $camperTitle[] =$lookup->FullName }}</th>
								@endforeach
							</tr>
						</thead>
						<tr>
							@foreach ($cmp as $lookup)
								@php
									$value = 0;
								@endphp

								@foreach ($camper_type as $registrant)
									@if ($lookup->id == $registrant->id)
										@php
											$value = $registrant->amount;
										@endphp
									@endif
								@endforeach
								<td>{{ $camper[] = $value }}</td>
							@endforeach
						</tr>
					</table>

					<div id="container" style="width:auto; height:400px;"></div>
					
					<script>
			            Highcharts.chart('container', {
			                chart: {
			                    type: 'column'
			                },
			                tooltip: {
			                    backgroundColor: {
			                        linearGradient: [0, 0, 0, 60],
			                        stops: [
			                            [0, '#FFFFFF'],
			                            [1, '#E0E0E0']
			                        ]
			                    },
			                    style:{
			                      color:"#000"
			                    },
			                    borderWidth: 1,
			                    borderColor: '#AAA'
			                },
			                title: {
			                    text: 'Summary Report'
			                },
			                xAxis: {
			                    categories: ["Senior", "Regular", "Teen", "Child"]
			                },
			                yAxis: {
			                    title: {
			                        text: 'Values'
			                    }
			                },
			                series: [{
			                    name: 'Total amount for each camper type',
			                    data: [{{ join(',', $camper) }}]
			                }]
			            });
			        </script>
			@endif

			@if (!is_null($per_day))
			<div style="page-break-after:always">
				<table class="table table-bordered table-striped">
					<caption style="text-align: center;text-transform: uppercase; text-decoration: underline;">
						<h4>Report on Accounts Per Day</h4>
					</caption>
					<thead>

							@php
								$amount = [];
								$date = [];
								$getdate = "";
							@endphp
							<tr>
								@foreach ($per_day as $day)
								@php
									$time = strtotime($day->per_day);
									$time = $date[] = date("D, d M Y", $time);
								@endphp
									<th>{{ $time }}</th>
								@endforeach
								@php
									$getdate = json_encode($date);
								@endphp
							</tr>
						</thead>
						<tr>
							@foreach ($per_day as $amounts)
								<td>{{ $amount[] = $amounts->amount }}</td>
							@endforeach
						</tr>
				</table>
				<div id="camp_gender" style="width:auto; height:300px;"></div>
					
					<script>
			            Highcharts.chart('camp_gender', {
			                chart: {
			                    type: 'column'
			                },
			                tooltip: {
			                    backgroundColor: {
			                        linearGradient: [0, 0, 0, 60],
			                        stops: [
			                            [0, '#FFFFFF'],
			                            [1, '#E0E0E0']
			                        ]
			                    },
			                    style:{
			                      color:"#000"
			                    },
			                    borderWidth: 1,
			                    borderColor: '#AAA'
			                },
			                title: {
			                    text: 'Total Amount Per Day Report'
			                },
			                xAxis: {
			                    categories: 
			                    	{!! $getdate !!}
			                    
			                },
			                yAxis: {
			                    title: {
			                        text: 'Amount'
			                    }
			                },
			                series: [{
			                    name: 'Amount',
			                    data: [ {{ join(',', $amount) }}]
			                }]
			            });
			        </script>
			    </div>
			@endif

			@if (is_null($camper_type) and is_null($per_day))
				<h4 style="text-align: center;text-transform: uppercase;margin-top: 50px">No Report was selected</h4>
			@endif
		</div>
	</div>



<!-- jQuery 2.2.3 -->
<script src="{{ asset('plugins/jQuery/jquery-2.2.3.min.js') }}"></script>
<script>
	function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
}
</script>
</body>
</html>