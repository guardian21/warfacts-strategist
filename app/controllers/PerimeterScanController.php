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

		if ($html == null){
			return View::make("Failed to parse scan");
		}

		$table = $html->find('*[id=perimTable]',0);
	
		if ($table == null){
			return View::make("Failed to parse scan");
		}

		$tbody = $table->find('tbody',0);

		if ($tbody == null){
			return View::make("Failed to parse scan");
		}

		$rows = $tbody->find('tr');
	
		if ($rows == null){
			return View::make("Failed to parse scan");
		}

		foreach ($rows as $tr) {

			if ($tr == null){
				return View::make("Failed to parse scan");
			}

			$td = $tr->find('td',0);

			if ($td == null){
			return View::make("Failed to parse scan");
			}	

			$href = $td->find('a',0)->href;
			
			if ($href == null){
				return View::make("Failed to parse scan");
			}
			
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

			if ($td == null){
				return View::make("Failed to parse scan");
			}

			$temp = explode("\n",$td->plaintext);

			if ($temp == null){
				return View::make("Failed to parse scan");
			}

			$fleet->owner = $temp[0];
			$fleet->empire = $temp[1];
			$fleet->faction = $temp[2];

			$td = $tr->find('td',2);
			if ($td == null){
				return View::make("Failed to parse scan");
			}
			$fleet->ships = $td->innertext;

			$td = $tr->find('td',3);
			if ($td == null){
				return View::make("Failed to parse scan");
			}
			$fleet->tonnage = $td->innertext;

			if ($td == null){
				return View::make("Failed to parse scan");
			}
			$td = $tr->find('td',5);

			// Depends on whether on global coords or inside system
			if ($td == null){
				return View::make("Failed to parse scan");
			}

			if (strpos($td->innertext, 'Open Space:') !== False ) {	// $td->innertext contains: Open Space:
				$position = explode(",",$td->find('a',0)->innertext);
				$temp = explode(" ",$position[2]);	//String is split as:  x, y, z global, so we have to split last one by space (and temp[1] = " ") 

				$fleet->x = (int) $position[0];
				$fleet->y = (int) $position[1];
				$fleet->z = (int) $temp[1];
			}
			else {
				//TODO Handle fleets in systems correctly
				if ($td == null){
					return View::make("Failed to parse scan");
				}

				$fleet->notes = "Inside System. Position= " + $td->innertext + " .";
			}


				$this->addOrUpdateFleet($fleet);
		}	


		Log::info("User " +  Auth::user()->username + " successfully updated html perimter scan at " +  date('Y/m/d h:i:s', time()));
		return View::make("Succesfully Parsed Perimeter Scan");
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