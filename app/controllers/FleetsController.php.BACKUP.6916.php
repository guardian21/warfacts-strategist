<?php

class FleetsController extends BaseController { 
	public function show()	{
		$fleets = Fleet::all();
		return View::make('fleet_show', compact('fleets'));
	}

	public function add(){
		return View::make('fleet_add');
	}

	public function handleAdd() {
		// Handle add form submission
		$fleet = new Fleet;
		$fleet->name = Input::get('name', 'Unknown');
		$fleet->owner = Input::get('owner', 'Unknown');
		$fleet->relationship = Input::get('relationship', 'enemy');
		$fleet->ships = Input::get('ships');
		$fleet->tonnage = Input::get('tonnage');
		$fleet->x = Input::get('x');
		$fleet->y = Input::get('y');
		$fleet->z = Input::get('z');
		$fleet->position_updated_at = date('Y/m/d h:i:s', time());
		$fleet->previous_x = null;
		$fleet->previous_y = null;
		$fleet->previous_z = null;
		$fleet->previous_position_updated_at = null;
		$fleet->speed = Input::get('speed', null);
		$fleet->speed_knowledge = Input::get('speed_knowledge', 'estimation');
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
		$fleet->ships = Input::get('ships');
		$fleet->tonnage = Input::get('tonnage');
		$fleet->previous_x = $fleet->x;
		$fleet->previous_y = $fleet->y;
		$fleet->previous_z = $fleet->z;
		$fleet->previous_position_updated_at = $fleet->position_updated_at;
		$fleet->x = Input::get('x');
		$fleet->y = Input::get('y');
		$fleet->z = Input::get('z');
		$fleet->position_updated_at = date('Y/m/d h:i:s', time());
		$fleet->speed = Input::get('speed');
		$fleet->speed_knowledge = Input::get('speed_knowledge');
		$fleet->vector_x = Input::get('vector_x', null);
		$fleet->vector_y = Input::get('vector_y', null);
		$fleet->vector_z = Input::get('vector_z', null);
		if ($fleet->vector_x == null || $fleet->vector_y == null || $fleet->vector_z == null){
			$fleet->vector_x = (($fleet->x - $fleet->previous_x)*4000) / ($fleet->speed * 3.6);	//Each coord 4000km, speed from m/s - > km/h
			$fleet->vector_y = (($fleet->y - $fleet->previous_y)*4000) / ($fleet->speed * 3.6);
			$fleet->vector_z = (($fleet->z - $fleet->previous_z)*4000) / ($fleet->speed * 3.6);
		}
		$fleet->destination = Input::get('destination');
		$fleet->old_positions = "(". $fleet->previous_x . "," . $fleet->previous_y . "," . $fleet->previous_z . ") " . $fleet->old_positions ; // Add previous position to old
		$fleet->battlelogs = Input::get('battlelogs');
		$fleet->notes = Input::get('notes');

		$fleet->save();
		return Redirect::action('FleetsController@show');
	}

	public function delete($fleet) {
		// Show delete confirmation page
		return View::make('fleet_delete', compact('fleet'));
	}

	public function handleDelete(Fleet $fleet) {
		// Handle the delete confirmation
		$id = Input::get('fleet');
		$fleet = Fleet::findOrFail($id);
		$fleet->delete();
<<<<<<< HEAD
=======
		return Redirect::action('FleetsController@show');
 
>>>>>>> 7239fc9e4c1eda1d4019e66f068881383fa7a0bd
	}
}