@extends('layout')

@section('content')

<div class="page-header">
	<h1>All fleets</h1>
</div>


<div >
	<div >
		<a href="{{ action('FleetsController@add') }}" class="btn btn-primary">Add a fleet</a>
	</div>
</div>

	<form action="{{ action('FleetsController@show') }}" method="post" role="form">

	<div>
		<label for="friend">Show Friend:</label>
		<input type="checkbox" name="friend" value="friend" @if (Input::old('friend')) checked @endif >
		<label for="neutral">Show Neutral:</label>		
		<input type="checkbox" name="neutral" value="neutral" @if (Input::old('neutral')) checked @endif >
		<label for="enemy">Show Enemy:</label>
		<input type="checkbox" name="enemy" value="enemy" @if (Input::old('enemy')) checked @endif >
		<label for="unknown">Show Unknown:</label>
		<input type="checkbox" name="unknown" value="unknown" @if (Input::old('unknown')) checked @endif >
	</div>
	<div>
		<label for="name">Name:</label>
		<input type="text" name="name" value= {{ Input::old('name', null) }} >
		<label for="owner">Owner:</label>
		<input type="text" name="owner" value= {{ Input::old('owner', null) }} >
		<label for="empire">Empire:</label>
		<input type="text" name="empire" value= {{ Input::old('empire', null) }} >
		<label for="faction">Faction:</label>
		<input type="text" name="faction" value= {{ Input::old('faction', null) }} >
	<div>
			<label for="shipMin">Minimum Ships</label>
			<input type="number"  name="shipMin" size='12' value= {{ Input::old('shipMin', null) }} >
			<label for="shipMax">Maximum Ships</label>
			<input type="number" name="shipMax" size='12' value= {{ Input::old('shipMax', null) }} >
	</div>
	<div>
			<label for="tonMin">Minimum Tonnage</label>
			<input type="number"  name="tonMin" size='12' value= {{ Input::old('tonMin', null) }} >
			<label for="tonMax">Maximum Tonnage</label>
			<input type="number"  name="tonMax" size='12' value= {{ Input::old('tonMax', null) }} >

	</div>
	<div>
		Order by:
		<select name="orderBy1">
			<option value="owner"  @if (Input::old('orderBy1') == "owner" ) selected @endif > Owner</option> 
			<option value="empire"  @if (Input::old('orderBy1') == "empire" ) selected @endif >Empire</option>
			<option value="faction"  @if (Input::old('orderBy1') == "faction" ) selected @endif >Faction</option>
			<option value="relationship"   @if (Input::old('orderBy1') == "relationship" ) selected @endif >Relationship</option>			
			<option value="ships"   @if (Input::old('orderBy1') == "ships" ) selected @endif >Ships</option>			
			<option value="tonnage"  @if (Input::old('orderBy1') == "tonnage" ) selected @endif >Tonnage</option>			
		</select>
		<select name="orderWay1">
			<option value="asc" @if (Input::old('orderWay1') == "asc" ) selected @endif>Ascending</option> 
			<option value="desc" @if (Input::old('orderWay1') == "desc" ) selected @endif>Descending</option>
		</select>
		and then By:
		<select name="orderBy2">
			<option value="owner"  @if (Input::old('orderBy2') == "owner" ) selected @endif > Owner</option> 
			<option value="empire"  @if (Input::old('orderBy2') == "empire" ) selected @endif >Empire</option>
			<option value="faction"  @if (Input::old('orderBy2') == "faction" ) selected @endif >Faction</option>
			<option value="relationship"   @if (Input::old('orderBy2') == "relationship" ) selected @endif >Relationship</option>			
			<option value="ships"   @if (Input::old('orderBy2') == "ships" ) selected @endif >Ships</option>			
			<option value="tonnage"  @if (Input::old('orderBy2') == "tonnage" ) selected @endif >Tonnage</option>			
		</select>
		<select name="orderWay2">
			<option value="asc" @if (Input::old('orderWay2') == "asc" ) selected @endif>Ascending</option> 
			<option value="desc" @if (Input::old('orderWay2') == "desc" ) selected @endif>Descending</option>
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
