<?php

class LoadScheduleCommand {
	
	public $ranger;

	function __construct( Ranger $ranger )
	{
		$this->ranger = $ranger;
	}

	public function execute()
	{
		// No games on the schedule
		if ($this->ranger->game_count == 0) {
			return View::make('schedule.empty');
		} else {
			return View::make('schedule.empty');
		}
		
	}

}