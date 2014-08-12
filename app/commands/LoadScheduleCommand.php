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
			echo 'nothing';
			return View::make('schedule.empty');
		} else {
			return View::make('schedule.empty');
		}

		// Load rinks
		// foreach ($this->data['ranger']->games as $id => $game) {
		// 	$this->data['ranger']->games[$id]->rink = Rink::where('code', $game->code)->first();
		// }

		// // Display upcoming games
		// return View::make('schedule.upcoming')->withData($this->data);
		
	}

}