@extends('layout')

@section('content')

	<div class="page-header">
		<h1>Get Perimeter Scan from HTML</h1>
	</div>



	<form action="{{ action('PerimeterScanController@getPerimeterScanHtml') }}" method="post" role="form">
		<div class="form-group">
			<label for="scannerPosition"> Scanner Fleet position</label>
			<input type="text" class="form-control" name="scannerPosition" />
			<label for="system"> Scanner Fleet inside System</label>
			<input type="text" class="form-control" name="system" />
			<label for="perimeterScanHtmlPage">Html page of Perimeter Scan</label>
			<textarea class="form-control" name="perimeterScanHtmlPage" cols="60" rows="10"></textarea>
		</div>


		<input type="submit" value="Parse" class="btn btn-primary" />
		<a href="{{ action('FleetsController@show') }}" class="btn btn-link">Cancel</a>
	</form>

@stop