<?php

class LoginController extends BaseController {

	/**
	 * index
	 *
	 * Displays the login form
	 */
	public function index()
	{
		return View::make('login.login')->withData($this->data);
	}

	/**
	 * send
	 *
	 * Sends the login details to oswebs
	 * 
	 * @param	$username
	 * @param	$password
	 */
	public function send ( $username = FALSE, $password = FALSE )
	{
		// Extract login data from form if none is present in the url
		if (!$username && !$password) extract (Input::only('username', 'password'));

		// Send data
		$command = new LoginCommand($username, $password);
		try {
			$command->execute();
		}

		// Login failed, redirect back to the login page
		catch (LoginException $e) {
			return Redirect::route('login')->withInput();
		}

		// Everything worked, redirect to the schedule
		return Redirect::route('schedule');
	}

}