@extends('layouts.app')
@section('beforecss')
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

	<link rel="stylesheet" href="{{asset('css/2023/fonts/material-design-iconic-font/css/material-design-iconic-font.min.css')}}">
	<link rel="stylesheet" href="{{asset('css/2023/style.css')}}">
	<style>
		html, body {
			height: 100%;
		}
		#transparent-dark {
			height: 100%;
			width: 100%;
			display: table;
		}
		.container {
			display: table-cell;
			height: 100%;
			vertical-align: middle;
		}
		.blink_me {
			animation: blinker 3s linear infinite;
		}

		@keyframes blinker {
			50% {
				opacity: 0.2;
			}
		}
	</style>
@endsection

@section('content')

	<div class="wrapper">
		<div class="image-holder text-center" style="margin: auto;padding: 70px;">
			<h1 class="top-header mb-4 fw-bold">
				APOSA Camp meeting <br/>
				& <br/>
				<span class="red-text"> Apostolic Professionals Summit </span>
				<br/>{{ date('Y') }}
			</h1>

			<h4 class="sub-header blink_me">Theme: {{env("CAMP_THEME")}}</h4>
		</div>
		<div class="form-inner">
			<div class="form-header text-center mb-5">
				<img src="{{App::isLocal() ? asset('img/aposa-main_edit.png') : asset('public/img/aposa-main_edit.png')}}" alt="" class="sign-up-icon" style="width: 150px;">
			</div>

			<div class="border border-primary p-3 border-opacity-25 mb-3">
				<h6 class="text-muted mb-2"><i class="fa fa-user-circle mr-2"></i> Individual</h6>
				<p class="mb-0">
					Are you an individual now about to register? <a href="{{url('registrant/create')}}" style="font-weight: 600;">Click here to proceed</a>. Enjoy!
				</p>

			</div>

			<div class="border border-primary p-3 border-opacity-25 mb-3">
{{--				<p><span class="text-info">Batch registration will be available from 18th December, 2023.--}}
{{--					This is due to a technical issue currently being addressed.</span></p>--}}
				<h6 class="text-muted mb-2"><i class="fa fa-users mr-2"></i> Batch</h6>
				<p class="mb-0">
					Are you a leader of a group now about to register? <a href="{{url('bacthregistration')}}" style="font-weight: 600;">Click here to proceed</a>. Enjoy!
				</p>

			</div>

			<div class="mb-3 mt-5 text-center">
				<p class="mb-2 fw-bold">
					Already registered?
				</p>
				<a href="{{route('registrant.registeredcamper')}}" class="btn btn-lg btn btn-primary btn-block fw-light p-3 mb-3" style="border-radius: 0">Login</a>
			</div>
		</div>

	</div>
@endsection
