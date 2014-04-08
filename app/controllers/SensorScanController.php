<?php

use Sunra\PhpSimple\HtmlDomParser;

class SensorScanController extends BaseController { 
	
	public function getSensorScanHtml() {
		return View::make('get_sensor_scan_html');
	}


	public function parseSensorScanHtml() {



		return Response::make("Successfully parsed Sensor Scan");
	}

}