<?php

use Sunra\PhpSimple\HtmlDomParser;

class PerimeterScanController extends BaseController { 
	
	public function getPerimeterScanHtml() {
		return View::make('get_perimeter_scan_html');
	}


	public function parsePerimeterScanHtml() {

		$htmlPage = Input::get('perimeterScanHtmlPage');

		//Parse the input

		$html = HtmlDomParser::str_get_html("$htmlPage");


		$table = $html->find('*[id=perimTable]',0);
		$tbody = $table->find('tbody',0);

		$rows = $tbody->find('tr');

		foreach ($rows as $tr) {

			$td = $tr->find('td',0);
			$href = $td->find('a',0)->href;
			
			$fleet = new Fleet;


				
			$fleet->name = $td->find('a',0)->innertext;
			$temp = $td->find('*[class]',0);
			if ($temp == null){
				$fleet->relationship = "neutral";
			}
			else {
				$fleet->relationship = $temp->class;				
			}
			$fleet->warfacts_id = substr($href,strpos($href,"tfleet")+7);

			$td = $tr->find('td',1);
			$temp = explode("\n",$td->plaintext);

			$fleet->owner = $temp[0];
			$fleet->empire = $temp[1];
			$fleet->faction = $temp[2];

			$td = $tr->find('td',2);
			$fleet->ships = $td->innertext;

			$td = $tr->find('td',3);
			$fleet->tonnage = $td->innertext;

			$td = $tr->find('td',5);

			// Depends on whether on global coords or inside system

			if (strpos($td->innertext, 'Open Space:') !== False ) {	// $td->innertext contains: Open Space:
				$position = explode(",",$td->find('a',0)->innertext);
				$temp = explode(" ",$position[2]);	//String is split as:  x, y, z global, so we have to split last one by space (and temp[1] = " ") 

				$fleet->x = (int) $position[0];
				$fleet->y = (int) $position[1];
				$fleet->z = (int) $temp[1];
			}
			else {
				//TODO Handle fleets in systems correctly

				$fleet->notes = "Inside System. Position= " + $td->innertext + " .";
			}


				$this->addOrUpdateFleet($fleet);
		}	


		Log::info("User " +  Auth::user()->username + " successfully updated html perimter scan at " +  date('Y/m/d h:i:s', time()));
		return Redirect::to('/fleets');
	}


	private function addOrUpdateFleet(Fleet $newFleet){

		$oldFleet = Fleet::whereWarfacts_id($newFleet->warfacts_id)->first();

		if ($oldFleet == null){

		//	$oldFleet->speed = $newFleet->speed;
		//	$oldFleet->speed_knowledge = $newFleet->speed_knowledge;

			$newFleet->speed = -1;
			$newFleet->speed_knowledge = 'uknown';
			$newFleet->save();
		}
		else {
			$oldFleet->name = $newFleet->name;
			$oldFleet->owner = $newFleet->name;
			$oldFleet->relationship = $newFleet->name;
			$oldFleet->empire = $newFleet->empire;
			$oldFleet->faction = $newFleet->name;
			$oldFleet->ships = $newFleet->ships;
			$oldFleet->tonnage = $newFleet->tonnage;
			$oldFleet->old_positions = "(". $oldFleet->previous_x . "," . $oldFleet->previous_y . "," . $oldFleet->previous_z . ") " . $oldFleet->old_positions ; // Add previous position to old
			$oldFleet->previous_x = $oldFleet->x;
			$oldFleet->previous_y = $oldFleet->y;
			$oldFleet->previous_z = $oldFleet->z;
			$oldFleet->previous_position_updated_at = $oldFleet->position_updated_at;
			$oldFleet->x = $newFleet->x;
			$oldFleet->y = $newFleet->y;
			$oldFleet->z = $newFleet->z;
			$oldFleet->position_updated_at = date('Y/m/d h:i:s', time());
			$oldFleet->vector_x = (($oldFleet->x - $oldFleet->previous_x)*4000) / ($oldFleet->speed * 3.6);	//Each coord 4000km, speed from m/s - > km/h
			$oldFleet->vector_y = (($oldFleet->y - $oldFleet->previous_y)*4000) / ($oldFleet->speed * 3.6);
			$oldFleet->vector_z = (($oldFleet->z - $oldFleet->previous_z)*4000) / ($oldFleet->speed * 3.6);
		//	$oldFleet->speed = $newFleet->speed;
		//	$oldFleet->speed_knowledge = $newFleet->speed_knowledge;
		//	$oldFleet->destination = $newFleet->destination;
		//	$oldFleet->battlelogs = $newFleet->battlelogs;
			$oldFleet->notes += $newFleet->notes;

			$oldFleet->save();

		}

	}




}
