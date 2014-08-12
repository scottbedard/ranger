<?php

class CalcTravelCommand {

	public $start;
	public $end;

	/**
	 * __construct
	 * 
	 * @param	$zip1, $zip2
	 */
	function __construct( $zip1, $zip2 )
	{
		if ($zip1 == $zip2) return ['distance' => '0 miles', 'duration' => '0 min'];

		// Assign start and end
		$this->start = ($zip1 < $zip2) ? $zip1 : $zip2;
		$this->end = ($zip1 < $zip2) ? $zip2 : $zip1;

	}

	/**
	 * execute
	 * 
	 * @return	array
	 */
	public function execute()
	{
		// Check if this travel has been calculated before, if so return array
		$exists = Travel::where('start', $this->start)->where('end', $this->end)->first();
		if ($exists) return ['distance' => $exists->distance, 'duration' => $exists->duration];

		// Calculate travel distance
		$url = 'http://maps.googleapis.com/maps/api/distancematrix/json?origins='.$this->start.'&destinations='.$this->end.'&mode=driving&units=imperial';
		$source = file_get_contents($url);

		// Google is not responding
		if (!$source) return FALSE;

		// Decode google's response
		$data = json_decode($source, TRUE);

		// Parse response into distance and duration
		if (isset($data['rows'][0]['elements'][0]['distance']['text']))
			$distance = $data['rows'][0]['elements'][0]['distance']['text'];

		if (isset($data['rows'][0]['elements'][0]['duration']['text']))
			$duration = $data['rows'][0]['elements'][0]['duration']['text'];

		// Reponse data is missing, return FALSE
		if (!isset($distance) || !isset($duration)) return FALSE;

		// Log response
		$travel = new Travel([
			'start' => $this->start,
			'end' => $this->end,
			'distance' => $distance,
			'duration' => $duration
		]);
		$travel->save();

		// Return array
		return ['distance' => $distance, 'duration' => $duration];
	}

}