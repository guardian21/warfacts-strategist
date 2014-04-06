@extends('layout')

@section('content')
	<div class="page-header">
		<h1>Delete {{ $fleet->name; }} <small>Are you sure?</small></h1>
	</div>
<form action="{{ action('FleetsController@handleDelete') }}" method="post" role="form">
<input type="hidden" name="fleet" value="{{ $fleet->id }}" />
<input type="submit" class="btn btn-danger" value="Yes" />
<a href="{{ action('FleetsController@show') }}" class="btn btn-default">No</a>
</form>
@stop
