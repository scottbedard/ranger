<?php

class Ranger {

	public $username;
	public $game_count = 0;
	public $games;

	/**
	 * LoadCache
	 */
	function __construct( $username )
	{
		$this->username = $username;
		$data = json_decode(file_get_contents(public_path()."/cache/$username.json"));

		$this->game_count = $data->game_count;
		$this->games = $data->games;
	}

}