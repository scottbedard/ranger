<?php

class ForgotPasswordController extends BaseController {

	function __construct()
	{
		parent::__construct();
	}

	/**
	 * index
	 *
	 * Displays the forgot password form
	 */
	public function index()
	{
		return View::make('forgotpw.forgotpw')->withData($this->data);
	}

	/**
	 * send
	 *
	 * Validates the email address, and
	 * executes ForgotPasswordCommand
	 */
	public function send()
	{
		// Run ForgotPasswordCommand
		$command = new ForgotPasswordCommand(Input::get('email'));
		try {
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