<?php

class ForgotPasswordController extends BaseController {

	/**
	 * __construct
	 */
	function __construct()
	{
		parent::__construct();
	}

	/**
	 * index
	 *
	 * Displays the forgot password form
	 *
	 * @return	View
	 */
	public function index()
	{
		return View::make('forgotpw.forgotpw')->withData($this->data);
	}

	/**
	 * send
	 *
	 * Executes ForgotPasswordCommand
	 *
	 * @return	Redirect
	 */
	public function send()
	{
		// Execute ForgotPasswordCommand
		try {
			$command = new ForgotPasswordCommand(Input::get('email'));
			$command->execute();
		}

		// Catch errors and redirect back
		catch (ForgotPasswordException $e) {
			return Redirect::back()->withInput();
		}

		// Everything worked, redirect to login
		return Redirect::route('login');
	}
}