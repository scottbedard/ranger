<?php

class LoginCommand {

	protected $username, $password;
	public $weeks = 16;
	public $source;

	/**
	 * LoginCommand
	 * 
	 * @param $username
	 * @param $password
	 */
	function __construct( $username, $password )
	{
		$this->username = strtolower($username);
		$this->password = strtolower($password);
	}

	/**
	 * execute()
	 * 
	 * Submit login details to oswebs
	 */
	public function execute()
	{
		// Make sure we have required login data
		if (!$this->username || !$this->password) {
			Flash::warning('You must provide a username and password to log in.');
			throw new LoginException;
		}

		// Load the mobile schedule
		// Load HTML
		$url = "http://www.oswebs.com/usahjr/officials/mobile.asp";
		$postdata = http_build_query([
			'end'	=> $this->weeks,
			'nm'	=> $this->username,
			'pw'	=> $this->password,
			'ed'	=> '2'
		]);
		$opts = [
			'http' => [
				'method'  => 'POST',
				'header'  => 'Content-type: application/x-www-form-urlencoded',
				'content' => $postdata
			]
		];

		$context = stream_context_create($opts);
		try {
			$source = file_get_contents($url, false, $context);
		}
		catch (ErrorException $e) {
			throw new RangerOfflineException;
		}

		if (strpos($source, 'Access Denied')) {
			// Invalid credentials
			Flash::warning('Invalid username / password combination.');
			throw new LoginException;
		} elseif (!$source) {
			// Ranger is not responding...
			throw new RangerOfflineException;
		}

		// Remove passwords from the source
		$search = ['"'.$this->password.'"', 'pw='.$this->password];
		$replace = ['"[removed]"', '[removed]'];
		$source = str_replace($search, $replace, $source);

		// Log the user in
		$this->login();

		// Send to parser
		$this->source = $source;
		$this->parse();
	}

	/**
	 * login
	 *
	 * Logs a user in
	 */
	public function login()
	{
		$user = User::whereUsername($this->username)->first();

		if (!$user) {
			$user = User::create([
				'username' => $this->username,
				'lastseen' => time()
			]);
			Flash::message(	'Thanks for signing up!<br /><br />'.
							'Make sure to update your account settings so we can accuaretly calculate driving distances.');
		} else {
			$user->lastseen = time();
			$user->save();
		}

		// Store the user_id in a session
		Session::put('user_id', $user->id);
	}

	/**
	 * parse
	 *
	 * Parse 16 week mobile schedule into json,
	 * representation, and cache the results.
	 */
	public function parse()
	{
		// Timestamp the output
		$output['timestamp'] = time();

		// Determine the number of games scheduled
		if (strpos($this->source, 'No games scheduled')) {
			$output['game_count'] = 2;
		}

		$output['games'] = [
			[
				'date'	=> 1409680800,
				'code'	=> 'ghijklm',
				'level'	=> 'JRT3',
				'teams' => 'Bar @ Foo',
				'crew' => [
					'referees' => ['Mark', 'Joe'],
					'linesmen' => ['Jim', 'Drew']
				]
			],

			[
				'date'	=> 1409680800 + (86400),
				'code'	=> 'ljsdff',
				'level'	=> 'JRT3',
				'teams' => 'Bar @ Foo',
				'crew' => [
					'referees' => ['Mark', 'Joe'],
					'linesmen' => ['Jim', 'Drew']
				]
			],

			[
				'date'	=> 1409680800 + (86400 * 2),
				'code'	=> 'abcdef',
				'level'	=> 'JRT3',
				'teams' => 'Bar @ Foo',
				'crew' => [
					'referees' => ['Mark', 'Joe'],
					'linesmen' => ['Jim', 'Drew']
				]
			],

			[
				'date'	=> 1409680800 + (86400 * 3),
				'code'	=> 'ghijklm',
				'level'	=> 'JRT3',
				'teams' => 'Bar @ Foo',
				'crew' => [
					'referees' => ['Mark', 'Joe'],
					'linesmen' => ['Jim', 'Drew']
				]
			]
		];

		File::put('cache/'.$this->username.'.json', json_encode($output));
	}

}