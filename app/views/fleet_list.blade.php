@extends('layout')

@section('head')



	<script type="text/javascript" src={{ asset('/assets/js/jquery-2.1.0.min.js') }} ></script> 
	<script type="text/javascript" src={{ asset('/assets/js/tablesorter/jquery.tablesorter.min.js') }}></script> 
	<?php
		function timePassed($fleet_position_updated_at)
		{
			$seconds = time() - strtotime($fleet_position_updated_at) ;
		//	$temp = $seconds;
			$days = (int) floor($seconds / 86400); // 86400 = 60 * 60 *24 = seconds in a day ;
			$seconds = $seconds - $days * 86400 ;
			$hours = (int) floor($seconds / 3600); // 3600 = 60 * 60 = seconds in an hour ;
			$seconds = $seconds - $hours * 3600 ;
			$minutes = (int) floor($seconds / 60);
			$seconds = $seconds - $minutes * 60;
			$answer = $days . " Days, " . $hours . " Hours, " . $minutes ." minutes and " . $seconds . " seconds ago";	
		//	$answer = "Total seconds: " .$temp. " Which means: " . $answer ;
			return $answer;
		}
	?>

	<script>


    // add parser through the tablesorter addParser method 
    $("#fleet_table").tablesorter.addParser({ 
        // set a unique id 
        id: 'commaNumber', 
        is: function(s) { 
            // return false so this parser is not auto detected 
            return false; 
        }, 
        format: function(s) { 
            // format your data for normalization 
            return s.replace(/,/g, ""); 
        }, 
        // set type, either numeric or text 
        type: 'numeric' 
    }); 
     
    $(function() { 
        $("#fleet_table").tablesorter({ 
            headers: { 
                10: { 
                    sorter:'commaNumber' 
                } 
            } 
        }); 
    });                  


		//TODO Fix the need of calculateDistance calling 2 times tablesorter, else after first click only sort is only one way (after 2 clicks it works normally)
		//TODO Fix table sorter to work with comma seperated numbers

		function previousElementSibling( elem ) {

		    do {

		        elem = elem.previousSibling;

		    } while ( elem && elem.nodeType !== 1 );

		    return elem;
		}

		function calculateDistance()
		{


			function numberWithCommas(x) {
			    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
			}
			var point = document.getElementById("point_for_distance").value ;
			if (point != "" ){
				point = point.replace(/[()]/g,''); // remove parenthesis
				point_arr = point.split(',');
				original_x = point_arr[0];
				original_y = point_arr[1];
				original_z = point_arr[2];

				var cells = document.getElementsByClassName("calc_dist");
				//alert (cells.length);
				for (var i=0; i < cells.length ; i++){
					var cell = cells[i];
					//alert(cell.innerHTML);
					var temp = previousElementSibling(cell).textContent;
					temp = temp.replace(/[()]/g,''); // remove parenthesis
					var position = temp.split(',');
					var pos_x = position[0];
					var pos_y = position[1];
					var pos_z = position[2];
			
		 			var distance = Math.round (4000 *  Math.sqrt( Math.pow(original_x - pos_x , 2) + Math.pow(original_y - pos_y , 2) + Math.pow(original_z - pos_z , 2) ) );

					cell.innerHTML = distance ;
					//cell.innerHTML = numberWithCommas(distance) ;

				}

			}
			$("#fleet_table").tablesorter(); 
		}



	$(document).ready(function() 
	    { 
	        $("#fleet_table").tablesorter(); 
	    } 
	); 

	</script> 

@stop






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
		<label for="point">Calculate Distance from point:</label>
		<input id="point_for_distance" type="text" name="point" value= {{ Input::old('point', null) }} >	
		<input id="calculate_distance" type="button" value="Calculate Distance" onclick="calculateDistance();" />	
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
		<label for="time_limit">Last Scan not older than </label>
		<input type="number"  name="time_limit" size='12' value= {{ Input::old('time_limit', null) }} >
		<select name="time_limit_type">
			<option value="days"  @if (Input::old('time_limit_type') == "days" ) selected @endif > Days</option> 
			<option value="hours"  @if (Input::old('time_limit_type') == "hours" ) selected @endif > Hours</option> 
			<option value="minutes"  @if (Input::old('time_limit_type') == "minutes" ) selected @endif > Minutes</option> 
		</select>		

		<input type="submit" value="Refresh" class="btn btn-primary" />
		<a href="{{ action('FleetsController@show') }}" class="btn-danger">Cancel</a>
	</div>
	</form>



@if (empty($fleets))
	<p>No fleets matching those criteria(</p>
@else
	<table id="fleet_table" class="table table-striped tablesorter">
		<thead>
			<tr>
				<th>Name</th>
				<th>Owner</th>
				<th>Relationship</th>
				<th>Empire</th>
				<th>Faction</th>
				<th>Ships</th>
				<th>Tonnage</th>
				<th>Last Scanned</th>
				<th>Warfacts Id</th>
				<th>Position</th>
				<th  class=\"{sorter: 'commaNumber'}\"> Distance from Point (km)</th>
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
					<td> {{ timePassed($fleet->position_updated_at) }}</td>
					<td>{{ $fleet->warfacts_id }}</td>
					<td><a href={{ "http://www.war-facts.com/extras/view_universe.php?x=".$fleet->x."&y=".$fleet->y ."&z=".$fleet->z ;}} target="_blank" >
						({{ $fleet->x }},{{ $fleet->y }},{{ $fleet->z }})</td>
					<td class = "calc_dist" ></td>
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
