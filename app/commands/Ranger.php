<?php

class Ranger {

	public $username;
	public $game_count = 0;
	public $games;
	public $pending;

	/**
	 * __construct
	 *
	 * Pulls cached game data
	 */
	function __construct( $username )
	{
		$this->username = $username;
		$data = json_decode(file_get_contents(app_path()."/schedules/$username.json"));


		// Count the scheduled or pending games
		if (isset($data->games)) {
			$this->game_count = count($data->games);
			$this->games = $data->games;
		} elseif (isset($data->pending)) {
			$this->game_count = count($data->pending);
			$this->pending = $data->pending;
		} else {
			$this->game_count = 0;
		}
		
	}

}