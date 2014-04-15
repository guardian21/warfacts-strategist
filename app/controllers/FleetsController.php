<?php

class FleetsController extends BaseController { 
	public function show() {
		//$fleets = Fleet::all();

		if (Request::isMethod('GET'))
		{
			$fleets = Fleet::all();
			return View::make('fleet_list', compact('fleets'));
		}



		$orderBy1 = Input::get('orderBy1', 'relationship');
		$orderWay1 = Input::get('orderWay1', 'desc');
		$orderBy2 = Input::get('orderBy2', 'ships');
		$orderWay2 = Input::get('orderWay2', 'desc');


		 $fleets = DB::table('fleets')->where(function($query) {


			$showFriend = Input::get('friend');
			$showNeutral = Input::get('neutral');
			$showEnemy = Input::get('enemy');
			$showUnknown = Input::get('unknown');
			$name = Input::get('name', null);
			$owner = Input::get('owner',null);
			$empire = Input::get('empire',null);
			$faction = Input::get('faction',null);
			$shipMin = Input::get('shipMin',null);
			$shipMax = Input::get('shipMax',null);
			$tonMin = Input::get('tonMin',null);
			$tonMax = Input::get('tonMax',null);
			$time_limit = Input::get('time_limit', null);
			$time_limit_type = Input::get('time_limit_type', null);

			if($name != null){
				$query->where('name', 'LIKE', "%$name%");
			}

			if($owner != null){
				$query->where('owner', 'LIKE', "%$owner%");
			}

			if($empire != null){
				$query->where('empire', 'LIKE', "%$empire%");
			}

		 	if(Input::has('faction')){
		 		$query->where('faction', '=' , $faction);
		 	}


			if ($shipMin != null && $shipMax == null){
				$query->where('ships', '>', $shipMin);
			}
		
			else if ($shipMin == null && $shipMax != null) {
				$query->where('ships', '<', $shipMax);
			}
			else if ($shipMin != null && $shipMax != null) {
				$query->whereBetween('ships', array($shipMin,$shipMax));
			}


			if ($tonMin != null && $tonMax == null){
				$query->where('tonnage', '>', $tonMin);
			}
			else if ($tonMin == null && $tonMax != null) {
				$query->where('tonnage', '<', $tonMax);
			}
			else if ($tonMin != null && $tonMax != null) {
				$query->whereBetween('tonnage', array($tonMin,$tonMax));
			}
			if ($time_limit != null) {
				switch ($time_limit_type) {
					case 'days':
						$time_limit = $time_limit * 86400;
						break;
					case 'hours':
						$time_limit = $time_limit * 3600;
						break;
					case 'minutes':
						$time_limit = $time_limit * 60;
						break;
					
					default:
						# code...
						break;
				}

				$oldest_scan = date('Y/m/d h:i:s', time() - $time_limit );
				$query->where('position_updated_at', '>' , $oldest_scan);
			}



			if (!$showFriend){
				$query->where('relationship', '<>', 'friend');
			}
			if (!$showNeutral){
				$query->where('relationship', '<>', 'neutral');
			}
			if (!$showEnemy){
				$query->where('relationship', '<>', 'enemy');
			}
			if (!$showUnknown){
				$query->where('relationship', '<>', 'unknown');
			}

		})
		->orderBy($orderBy1,$orderWay1)
		->orderBy($orderBy2,$orderWay2)
		->get();

		Input::flash();
		return View::make('fleet_list', compact('fleets'));
	}

	public function add(){
		return View::make('fleet_add');
	}

	public function handleAdd() {
		// Handle add form submission
		$fleet = new Fleet;
		$fleet->name = Input::get('name', 'Unknown');
		$fleet->owner = Input::get('owner', 'Unknown');
		$fleet->relationship = Input::get('relationship', 'unknown');
		$fleet->empire = Input::get('empire', 'Unknown');		
		$fleet->faction = Input::get('faction', 'Unknown');
		$fleet->ships = Input::get('ships');
		$fleet->tonnage = Input::get('tonnage');
		$fleet->warfacts_id = Input::get('warfacts_id');
		$fleet->x = Input::get('x');
		$fleet->y = Input::get('y');
		$fleet->z = Input::get('z');
		$fleet->system= Input::get('system', null);
		$fleet->position_updated_at = date('Y/m/d h:i:s', time());
		$fleet->previous_x = null;
		$fleet->previous_y = null;
		$fleet->previous_z = null;
		$fleet->previous_position_updated_at = null;
		$fleet->speed = Input::get('speed');
		$fleet->speed_knowledge = Input::get('speed_knowledge', 'unknown');
		$fleet->vector_x = Input::get('vector_x', null);
		$fleet->vector_y = Input::get('vector_y', null);
		$fleet->vector_z = Input::get('vector_z', null);
		$fleet->destination = Input::get('destination', 'Unknown');
		$fleet->old_positions = null;
		$fleet->battlelogs = Input::get('battlelogs', null);
		$fleet->notes = Input::get('notes', null);

		$fleet->save();
		
		return Redirect::action('FleetsController@show');

	}

	public function update(Fleet $fleet) {
		// Show the fleet update form
		return View::make('fleet_update', compact('fleet'));
	}

	public function handleUpdate(){
		// Handle update form submission
		$fleet = Fleet::findOrFail(Input::get('id'));
		$fleet->name = Input::get('name');
		$fleet->owner = Input::get('owner');
		$fleet->relationship = Input::get('relationship');
		$fleet->empire = Input::get('empire');	
		$fleet->faction = Input::get('faction');
		$fleet->ships = Input::get('ships');
		$fleet->tonnage = Input::get('tonnage');
		$fleet->old_positions = "(". $fleet->previous_x . "," . $fleet->previous_y . "," . $fleet->previous_z . ") " . $fleet->old_positions ; // Add previous position to old
		$fleet->previous_x = $fleet->x;
		$fleet->previous_y = $fleet->y;
		$fleet->previous_z = $fleet->z;
		$fleet->previous_position_updated_at = $fleet->position_updated_at;
		$fleet->x = Input::get('x');
		$fleet->y = Input::get('y');
		$fleet->z = Input::get('z');
		$fleet->system = Input::get('system' );
		$fleet->position_updated_at = date('Y/m/d h:i:s', time());
		$fleet->speed = Input::get('speed');
		$fleet->speed_knowledge = Input::get('speed_knowledge');
		$fleet->vector_x = Input::get('vector_x', null);
		$fleet->vector_y = Input::get('vector_y', null);
		$fleet->vector_z = Input::get('vector_z', null);
		if ($fleet->speed != null && $fleet->speed !=0){
			$fleet->vector_x = (($fleet->x - $fleet->previous_x)*4000) / ($fleet->speed * 3.6);	//Each coord 4000km, speed from m/s - > km/h
			$fleet->vector_y = (($fleet->y - $fleet->previous_y)*4000) / ($fleet->speed * 3.6);
			$fleet->vector_z = (($fleet->z - $fleet->previous_z)*4000) / ($fleet->speed * 3.6);
		}
		$fleet->destination = Input::get('destination');
		$fleet->battlelogs = Input::get('battlelogs');
		$fleet->notes = Input::get('notes');

		$fleet->save();
		return Redirect::action('FleetsController@show');
	}

	public function delete($fleet) {
		// Show delete confirmation page
		return View::make('fleet_delete', compact('fleet'));
	}

	public function handleDelete() {
		// Handle the delete confirmation
		$id = Input::get('fleet');
		$fleet = Fleet::findOrFail($id);
		$fleet->delete();
		return Redirect::action('FleetsController@show');

	}
}