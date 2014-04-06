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

@if ($fleets->isEmpty())
	<p>There are no fleets! :(</p>
@else
	<table class="table table-striped">
		<thead>
			<tr>
				<th>Name</th>
				<th>Owner</th>
				<th>Relationship</th>
				<th>Ships</th>
				<th>Tonnage</th>
				<th>Warfacts Id</th>
				<th>X</th>
				<th>Y</th>
				<th>Z</th>
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
				<tr>
					<td>{{ $fleet->name }}</td>
					<td>{{ $fleet->owner }}</td>
					<td>{{ $fleet->relationship }}</td>
					<td>{{ $fleet->ships }}</td>
					<td>{{ $fleet->tonnage }}</td>
					<td>{{ $fleet->warfacts_id }}</td>
					<td>{{ $fleet->x }}</td>
					<td>{{ $fleet->y }}</td>
					<td>{{ $fleet->z }}</td>
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
