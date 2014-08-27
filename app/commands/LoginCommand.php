<?php

class LoginCommand {

	protected $username, $password;		// Ranger username / password
	public $weeks = 16;					// Default schedule scope
	public $source;						// Ranger response

	/**
	 * __construct
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
	 * execute
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

		// Send request to ranger
		try {
			$source = file_get_contents($url, false, $context);
		}

		// HTTP request threw an error
		catch (ErrorException $e) {
			throw new RangerOfflineException;
		}

		// Handle ranger's response
		if (strpos($source, 'Access Denied')) {
			// Invalid credentials
			Flash::warning('Invalid username / password combination.');
			throw new LoginException;

		} elseif (!$source) {
			// Ranger is not responding...
			throw new RangerOfflineException;
		}

		// Log the user in
		$this->login();

		// Send to parser
		$this->source = $source;

		$this->parse();
	}

	/**
	 * login
	 *
	 * Logs a user in and sets session variables
	 */
	public function login()
	{
		// Query the user
		$user = User::whereUsername($this->username)->first();

		if (!$user) {
			// New user
			$user = User::create([
				'username' => $this->username,
				'lastseen' => time()
			]);
			Flash::message(	'Thanks for signing up!<br /><br />'.
							'Make sure to update your account settings so we can accuaretly calculate driving distances.');

		} else {
			// Returning user
			$user->lastseen = time();
			$user->save();
		}

		// Store the user_id in a session
		Session::put('user_id', $user->id);
	}

	/**
	 * parse
	 *
	 * Parse mobile schedule into json representation, and caches the results.
	 */
	public function parse()
	{
		// Timestamp the output
		$output['timestamp'] = time();

		// Determine the number of games scheduled
		if (strpos($this->source, 'No games scheduled')) {
			// nothing
		}

		/**
		 * PARSE PENDING GAMES
		 */
		if (strpos($this->source, '<input type="submit" name="B1" value="Continue">') !== FALSE) {
			// Inclusively remove everything before the first <table> tag
			$this->source = substr($this->source, (strpos($this->source, '<table>') + 9));

			// Inclusively remove everything after the second to last </table> tag
			$last = strrpos($this->source, '</table>');
			$this->source = substr($this->source, 0, strrpos($this->source, '</table>', $last - strlen($this->source) - 1));

			// Split the data into games
			$pending = preg_split('/(\<tr style=")(background\-color\:[A-Za-z]+)(\">)/', $this->source);
			array_shift($pending);
			
			//Loop through pending games and continue parsing
			$i = 0;
			foreach ($pending as $game) {

				// Remove useless crap
				$game = str_replace([
					'<td>',
					'</td>',
					'<td align="center" nowrap><input type="radio" name="',
					'" Value="1" checked class="styled">',
					'<tr>',
					'<td align="right">',
					'<td class="tdData" colspan="2">',
					'</tr>',
					'<table>',
					'</table>',
					'<td colspan="2">&nbsp;<td colspan="3">',
					'<i>',
					'</i>',
				], '', $game);


				// Filter out the whitespace
				$game = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $game);
				$game = explode("\n", $game);
				array_shift($game); array_pop($game);
				
				// Add to output array
				$output['pending'][$i] = [
					'game_id'	=> preg_replace('/\s+/', '', $game[0]), // Clean whitespace
					'date'		=> $game[1].' '.$game[2],
					'code'		=> preg_replace('/\s+/', '', $game[3]), // Clean whitespace
					'time'		=> $game[4],
					'level'		=> $game[5],
					'teams'		=> $game[6]
				];

				$i++;
			}

			// Unfortunately, to submit the accept form correctly we need to persist the username and password
			Session::flash('ranger_username', $this->username);
			Session::flash('ranger_password', $this->password);
		}

		/**
		 * PARSE SCHEDULE
		 */
		elseif (strpos($this->source, 'Red Games have been canceled') !== FALSE) {
			// Inclusively remove everything before the schedule
			$this->source = substr($this->source, (strpos($this->source, '<table>', strpos($this->source, '<table>') + 9)) + 9);

			// Inclusively remove everything after the second to last </table> tag
			$last = strrpos($this->source, '</table>');
			$this->source = substr($this->source, 0, strrpos($this->source, '</table>', $last - strlen($this->source) - 1));
			
			// Split the data into games
			$games = preg_split('/(\<tr style=")(background\-color\:[A-Za-z]+)(\">)/', $this->source);
			array_shift($games);
			
			// Loop through schedule
			$i = 0;
			foreach ($games as $game) {
				// Remove HTML
				$game = preg_replace('/<[^>]*>/', '', $game);

				// Filter out the whitespace
				$game = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $game);
				$game = explode("\n", $game);
				array_shift($game); array_pop($game);

				// Parse the crew
				$crew['linesmen'] = $crew['referees'] = [];
				for($j = 6; $j <= 9; $j++) {
					$position = substr($game[$j], 0, 2);
					$official = ($position == 'R3' || $position == 'R4' || $position == 'L3' || $position == 'L4') ?
						substr($game[$j], 3) : FALSE;

					if ($official && substr($position, 0, 1) == 'R') {
						// Add Referee
						array_push($crew['referees'], $official);
					} elseif ($official && substr($position, 0, 1) == 'L') {
						// Add Linesmen
						array_push($crew['linesmen'], $official);
					}
				}

				// Add to output array
				$output['games'][$i] = [
					'date'		=> gameDate($game[1], $game[3]),
					'code'		=> preg_replace('/\s+/', '', $game[2]), // Clean whitespace
					'level'		=> $game[4],
					'teams'		=> $game[5],
					'crew'		=> $crew
				];
				
				$i++;
			}
		}

		/**
		 * EMPTY SCHEDULE
		 */
		else {
			echo 'no games scheduled';
		}
		
		// Load actual game schedule
		// Placeholder...
		// $output['games'] = [
		// 	[
		// 		'date'	=> 1409680800,
		// 		'code'	=> 'ghijklm',
		// 		'level'	=> 'JRT3',
		// 		'teams' => 'Bar @ Foo',
		// 		'crew' => [
		// 			'referees' => ['Mark', 'Joe'],
		// 			'linesmen' => ['Jim', 'Drew']
		// 		]
		// 	]
		// ];
		// End placeholder

		File::put(app_path().'/schedules/'.$this->username.'.json', json_encode($output));
	}

}