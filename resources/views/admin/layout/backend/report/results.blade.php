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
		.reportTable td,.reportTable th{
			padding: 5px 10px;
		}
	</style>
</head>
<body>


         
        
	{{-- @foreach ($lookups as $lookup) --}}
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
			@if (!is_null($registrants))
					{{-- <table class="reportTable table-bordered table-striped"> --}}
					<table class="table table-bordered table-striped">
						<caption style="text-align: center;text-transform: uppercase; text-decoration: underline;"><h4>Report on Type of Campers</h4></caption>
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

								@foreach ($registrants as $registrant)
									@if ($lookup->id == $registrant->id)
										@php
											$value = $registrant->campers;
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
			                    name: 'Total Paid Applicants',
			                    data: [{{ join($camper,',') }}]
			                }]
			            });
			        </script>
			@endif

			@if (!is_null($genders))
			<div style="page-break-after:always">
				<table class="table table-bordered table-striped">
					<caption style="text-align: center;text-transform: uppercase; text-decoration: underline;">
						<h4>Report on Gender distribution</h4>
					</caption>
					<thead>
						<tr>
							<th>Male</th>
							<th>Female</th>
						</tr>
					</thead>
					<tbody>
						@php
							$sex = [];
						@endphp
						<tr>
							@foreach ($genders as $gender)
								<td>{{ $sex[] = $gender->campers }}</td>
							@endforeach
						</tr>
					</tbody>
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
			                    text: 'Gender Distribution Report'
			                },
			                xAxis: {
			                    categories: ["Male", "Female"]
			                },
			                yAxis: {
			                    title: {
			                        text: 'Values'
			                    }
			                },
			                series: [{
			                    name: 'Gender',
			                    data: [ {{ join($sex,',') }}]
			                }]
			            });
			        </script>
			    </div>
			@endif

			@if (!is_null($chapters))
				<table class="table table-bordered table-striped">
					<caption style="text-align: center;text-transform: uppercase; text-decoration: underline;">
						<h4>Report on the various chapters</h4>
						{{ $chapters }}
					</caption>
				</table>
			@endif

			@if (is_null($registrants) and is_null($genders) and is_null($chapters))
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