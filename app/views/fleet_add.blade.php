@extends('layout')

@section('content')
	<div class="page-header">
		<h1>Add Fleet</h1>
	</div>
	<form action="{{ action('FleetsController@handleAdd') }}" method="post" role="form">
		<div class="form-group">
			<label for="name">Name</label>
			<input type="text" class="form-control" name="name" />
		</div>
		<div class="form-group">
			<label for="owner">Owner</label>
			<input type="text" class="form-control" name="owner" />
		</div>

		<select name="relationship">
			<option value="friend">Friend</option> 
			<option value="neutral" >Neutral</option>
			<option value="enemy" selected="">Enemy</option>
		</select>
		<div class="form-group">
			<label for="empire">Empire</label>
			<input type="text" class="form-control" name="empire" />
		</div>

		<div class="form-group">
			<label for="faction">Faction</label>
			<input type="text" class="form-control" name="faction" />
		</div>
		<div class="form-group">
			<label for="ships">Ships</label>
			<input type="number" class="form-control" name="ships" />
		</div>
		<div class="form-group">
			<label for="tonnage">Tonnage</label>
			<input type="number" class="form-control" name="tonnage" />
		</div>
		<div class="form-group">
			<label for="warfacts_id">Warfacts Id</label>
			<input type="number" class="form-control" name="warfacts_id" />
		</div>
		<div class="form-group">
			<label for="x">X</label>
			<input type="number" class="form-control" name="x" />
		</div>
		<div class="form-group">
			<label for="y">Y</label>
			<input type="number" class="form-control" name="y" />
		</div>
		<div class="form-group">
			<label for="z">Z</label>
			<input type="number" class="form-control" name="z" />
		</div>
		<div class="form-group">
			<label for="speed">Speed (m/s)</label>
			<input type="number" class="form-control" name="speed" />
		</div>

		<select name="speed_knowledge">
			<option value="exact">Exact</option> 
			<option value="estimation">Estimation</option>
			<option value="maximum">Maximum</option>
			<option value="unknown" selected>Unkown</option>			
		</select>

		<div class="form-group">
			<label for="destination">Destination</label>
			<input type="text" class="form-control" name="destination" />
		</div>
		<div class="form-group">
			<label for="battlelogs">Battlelogs</label>
			<textarea class="form-control" name="battlelogs" cols="60" rows="5"></textarea>
		</div>
		<div class="form-group">
			<label for="notes">Notes</label>
			<textarea class="form-control" name="notes" cols="60" rows="10"></textarea>
		</div>


		<input type="submit" value="Add" class="btn btn-primary" />
		<a href="{{ action('FleetsController@show') }}" class="btn btn-link">Cancel</a>
	</form>
@stop
