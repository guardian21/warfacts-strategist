@extends('layout')

@section('content')
	<div class="page-header">
		<h1>Update {{ $fleet->name }} Fleet</h1>
	</div>
	<form action="{{ action('FleetsController@handleUpdate') }}" method="post" role="form">

		<input type="hidden" name="id" value="{{ $fleet->id }}">
		<div class="form-group">
			<label for="name">Name</label>
			<input type="text" class="form-control" name="name" value="{{$fleet->name }}" />
		</div>
		<div class="form-group">
			<label for="owner">Owner</label>
			<input type="text" class="form-control" name="owner" value="{{$fleet->owner }}"/>
		</div>
		<select name="relationship">
			@if ($fleet->relationship == "ally")
				<option value="ally" selected>Ally</option>
			@else {
				<option value="ally">Ally</option>
			} 
			@endif
			@if ($fleet->relationship == "neutral")
				<option value="neutral" selected>Neutral</option>
			@else {
				<option value="neutral">Neutral</option>
			} 
			@endif
			@if ($fleet->relationship == "enemy")
				<option value="enemy" selected>Enemy</option>
			@else {
				<option value="enemy">Enemy</option>
			} 
			@endif
		</select>
		<div class="form-group">
			<label for="ships">Ships</label>
			<input type="number" class="form-control" name="ships" value="{{$fleet->ships }}"/>
		</div>
		<div class="form-group">
			<label for="tonnage">Tonnage</label>
			<input type="number" class="form-control" name="tonnage" value="{{$fleet->tonnage }}"/>
		</div>
		<div class="form-group">
			<label for="warfacts_id">Warfacts Id</label>
			<input type="number" class="form-control" name="warfacts_id" value="{{$fleet->warfacts_id }}"/>
		</div>
		<div class="form-group">
			<label for="x">X</label>
			<input type="number" class="form-control" name="x" value="{{$fleet->x }}"/>
		</div>
		<div class="form-group">
			<label for="y">Y</label>
			<input type="number" class="form-control" name="y" value="{{$fleet->y }}"/>
		</div>
		<div class="form-group">
			<label for="z">Z</label>
			<input type="number" class="form-control" name="z" value="{{$fleet->z }}"/>
		</div>
		<div class="form-group">
			<label for="speed">Speed (m/s)</label>
			<input type="number" class="form-control" name="speed" value="{{$fleet->speed }}"/>
		</div>
		<select name="speed_knowledge">
			@if ($fleet->speed_knowledge == "exact")
				<option value="exact" selected>exact</option>
			@else {
				<option value="exact">exact</option>
			} 
			@endif
			@if ($fleet->speed_knowledge == "estimation")
				<option value="estimation" selected>Estimation</option>
			@else {
				<option value="estimation">Estimation</option>
			} 
			@endif
			@if ($fleet->speed_knowledge == "maximum")
				<option value="maximum" selected>Maximum</option>
			@else {
				<option value="maximum">Maximum</option>
			} 
			@endif
		</select>
		<div class="form-group">
			<label for="destination">Destination</label>
			<input type="text" class="form-control" name="destination" />
		</div>
		<div class="form-group">
			<label for="battlelogs">Battlelogs</label>
			<textarea class="form-control" name="battlelogs" cols="60" rows="5" >{{$fleet->battlelogs }}</textarea>
		</div>
		<div class="form-group">
			<label for="notes">Notes</label>
			<textarea class="form-control" name="notes" cols="60" rows="10" >{{$fleet->notes }}</textarea>
		</div>
		<input type="submit" value="Update" class="btn btn-primary" />
		<a href="{{ action('FleetsController@show') }}" class="btn btn-link">Cancel</a>
	</form>
@stop
