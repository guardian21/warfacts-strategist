@extends('layout')

@section('content')

	<div class="page-header">
		<h1>Get Sensor Scan from HTML</h1>
	</div>



	<form action="{{ action('SensorScanController@getSensorScanHtml') }}" method="post" role="form">
		<div class="form-group">
			<label for="sensorScanHtmlPage">Html source page of Sensor Scan</label>
			<textarea class="form-control" name="sensorScanHtmlPage" cols="60" rows="10"></textarea>
		</div>


		<input type="submit" value="Parse" class="btn btn-primary" />
		<a href="{{ action('FleetsController@show') }}" class="btn btn-primary">Cancel</a>
	</form>

@stop