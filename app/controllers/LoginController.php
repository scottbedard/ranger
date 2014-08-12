<?php

class LoginController extends BaseController {

	/**
	 * index
	 *
	 * Displays the login form
	 *
	 * @return	Redirect
	 */
	public function index()
	{
		return View::make('login.login')->withData($this->data);
	}

	/**
	 * send
	 *
	 * Sends the login details to oswebs. Login creditials
	 * may be sent through the index form, or through the URL.
	 * 
	 * @param	string	$username
	 * @param	string	$password
	 * @return  View / Redirect
	 */
	public function send ( $username = FALSE, $password = FALSE )
	{
		// Extract login data from form if none is present in the url
		if (!$username && !$password) extract (Input::only('username', 'password'));

		// Send login data
		try {
			$command = new LoginCommand($username, $password);
			$command->execute();
		}

		// Login failed, redirect back to the login page
		catch (LoginException $e) {
			return Redirect::route('login')->withInput();
		}

		// Load authenticated navigation
		$this->data['navigation'] = navigation('user');

		// Redirect to schedule route if Ranger is already defined.
		// This will keep the login credentials out of the URL when it's not needed.
		if (isset($this->data['ranger'])) return Redirect::route('schedule');
		else $this->data['ranger'] = new Ranger($username);

		// No games on the schedule
		if ($this->data['ranger']->game_count == 0) {
			return View::make('schedule.empty');
		}

		// Display upcoming games
		return View::make('schedule.upcoming')->withData($this->data);
	}
}