@extends('layout')

@section('content')

<div class="page-header">
	<h1>Welcome to Warfacts Strategist</h1>

	@if (!Auth::check())
		<div>
			<p> Welcome Guest. Please login or register. </p>

			<p> <a href="/login"> Login </a> </p>
			<p> <a href="/user"> Register </a> </p>
		</div>
	@else
		<div>
			<p> Welcome {{ Auth::user()->username}} </p>
			<p> <a href="/logout"> Logout </a> </p>
		</div>
	@endif

	<div>
		<h2> Available pages: </h2>


		<p> <a href="/fleets"> View Fleet list </a>
		<p> <a href="/fleets/add"> Add a new fleet in the list </a>

	</p>
	

	<div>
		<p> <a href="http://userscripts.org/scripts/show/452596"> Get Warfacts Strategist Scanner Fleet to run scans and update Warfacts strategist with one click.</a>
	</div>

</div>


@stop
