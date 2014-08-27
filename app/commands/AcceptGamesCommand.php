<?php

class AcceptGamesCommand {

	protected $username, $password;		// Ranger username / password
	protected $ranger;					// Ranger JSON file
	public $source;						// Ranger response

	/**
	 * __construct
	 * 
	 * @param $username
	 * @param $password
	 */
	function __construct( $username, $password, $ranger )
	{
		$this->username = strtolower($username);
		$this->password = strtolower($password);
		$this->ranger = $ranger;
	}

	/**
	 * execute
	 * 
	 * Submit login details to oswebs
	 */
	public function execute()
	{

		// Loop through games and build the accept payload
		$games = [];
		foreach ($this->ranger->pending as $game) {
			array_push($games, "'".$game->game_id."'");
		}
		$payload['a'] = implode(',', $games);

		// Add other ranger credentials to payload
		$payload['nm'] = $this->username;
		$payload['pw'] = $this->password;
		$payload['conf'] = '2';
		$payload['d'] = '';
		$payload['B1'] = 'Continue';

		// Build the form to submit
		$url = "http://www.oswebs.com/usahjr/officials/mobile.asp";
		$postdata = http_build_query($payload);
		$opts = [
			'http' => [
				'method'  => 'POST',
				'header'  => 'Content-type: application/x-www-form-urlencoded',
				'content' => $postdata
			]
		];
		$context = stream_context_create($opts);

		// Send request to ranger
		try {
			$source = file_get_contents($url, false, $context);
		}
		
		// HTTP request threw an error
		catch (ErrorException $e) {
			throw new RangerOfflineException;
		}

	}

}