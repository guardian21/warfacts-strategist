@extends('layout')

@section('content')

<div class="page-header">
	<h1>All fleets</h1>
</div>


<div class="panel panel-default">
	<div class="panel-body">
		<a href="{{ action('FleetsController@add') }}" class="btn btn-primary">Add a fleet</a>
	</div>
</div>

	<form action="{{ action('FleetsController@show') }}" method="post" role="form">

	<div>
		<label for="friend">Show Friend:</label>
		<input type="checkbox" name="friend" value="friend">
		<label for="neutral">Show Neutral:</label>
		<input type="checkbox" name="neutral" value="neutral" checked >
		<label for="enemy">Show Enemy:</label>
		<input type="checkbox" name="enemy" value="enemy"checked >
		<label for="unknown">Show Unknown:</label>
		<input type="checkbox" name="unknown" value="unknown"checked >
	</div>
	<div>
			<label for="shipMin">Minimum Ships</label>
			<input type="number"  name="shipMin" size='12'/>
			<label for="shipMax">Maximum Ships</label>
			<input type="number" name="shipMax" size='12'/>
	</div>
	<div>
			<label for="tonMin">Minimum Tonnage</label>
			<input type="number"  name="tonMin" size='12'/>
			<label for="tonMax">Maximum Tonnage</label>
			<input type="number"  name="tonMax" size='12'/>

	</div>
	<div>
		Order by:
		<select name="orderBy1">
			<option value="owner">Owner</option> 
			<option value="empire">Empire</option>
			<option value="faction">Faction</option>
			<option value="relationship" selected>Relationship</option>			
			<option value="ships" >Ships</option>			
			<option value="tonnage">Tonnage</option>			
		</select>
		<select name="orderWay1">
			<option value="asc">Ascending</option> 
			<option value="desc" selected>Descending</option>
		</select>
		and then By:
		<select name="orderBy2">
			<option value="owner">Owner</option> 
			<option value="empire">Empire</option>
			<option value="faction">Faction</option>
			<option value="relationship">Relationship</option>			
			<option value="ships" selected>Ships</option>			
			<option value="tonnage">Tonnage</option>			
		</select>
		<select name="orderWay2">
			<option value="asc">Ascending</option> 
			<option value="desc" selected>Descending</option>
		</select>

		<input type="submit" value="Refresh" class="btn btn-primary" />
		<a href="{{ action('FleetsController@show') }}" class="btn-primary">Cancel</a>
	</div>
	</form>



@if (empty($fleets))
	<p>No fleets matching those criteria(</p>
@else
	<table class="table table-striped">
		<thead>
			<tr>
				<th>Name</th>
				<th>Owner</th>
				<th>Relationship</th>
				<th>Empire</th>
				<th>Faction</th>
				<th>Ships</th>
				<th>Tonnage</th>
				<th>Warfacts Id</th>
				<th>Position</th>
				<th>Speed</th>
				<th>Speed Knowledge</th>
				<th>Vector X</th>
				<th>Vector Y</th>
				<th>Vector Z</th>
				<th>Destination</th>
				<th>Battlelogs</th>
				<th>Notes</th>
			</tr>
		</thead>
		<tbody>
			@foreach($fleets as $fleet)
				<tr class={{$fleet->relationship}}>
					<td>
					<a href={{ "http://www.war-facts.com/fleet_navigation.php?x=".$fleet->x."&y=".$fleet->y ."&z=".$fleet->z."&tpos=global&tfleet=".$fleet->warfacts_id ; }} target="_blank">
						{{ $fleet->name }} </a></td>
					<td>{{ $fleet->owner }}</td>
					<td>{{ $fleet->relationship }}</td>
					<td>{{ $fleet->empire }}</td>					
					<td>{{ $fleet->faction }}</td>
					<td>{{ $fleet->ships }}</td>
					<td>{{ $fleet->tonnage }}</td>
					<td>{{ $fleet->warfacts_id }}</td>
					<td><a href={{ "http://www.war-facts.com/extras/view_universe.php?x=".$fleet->x."&y=".$fleet->y ."&z=".$fleet->z ;}} target="_blank" >
						({{ $fleet->x }},{{ $fleet->y }},{{ $fleet->z }})</td>
					<td>{{ $fleet->speed }}</td>
					<td>{{ $fleet->speed_knowledge }}</td>
					<td>{{ $fleet->vector_x }}</td>
					<td>{{ $fleet->vector_y }}</td>
					<td>{{ $fleet->vector_z }}</td>
					<td>{{ $fleet->destination }}</td>
					<td>{{ $fleet->battlelogs }}</td>
					<td>{{ $fleet->notes }}</td>

					<td>
						<a href="{{ action('FleetsController@update', $fleet->id) }}"class="btn btn-default">Update</a>
						<a href="{{ action('FleetsController@delete', $fleet->id) }}"class="btn btn-danger">Delete</a>
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>
@endif
@stop
