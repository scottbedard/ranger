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
	 * @param	Bool	$username
	 * @param	Bool	$password
	 * @return  Redirect
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

		// Everything worked, redirect to the schedule
		return Redirect::route('schedule');
	}
}