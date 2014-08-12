<?php

class AccountController extends BaseController {

	/**
	 * __construct
	 */
	function __construct ()
	{
		parent::__construct();
		$this->data['navigation']['account']['selected'] = TRUE;
	}

	/**
	 * index
	 *
	 * Displays the login form
	 *
	 * @return	View
	 */
	public function index()
	{
		return View::make('account.account')->withData($this->data);
	}

	/**
	 * save
	 *
	 * Executes UpdateAccountCommand
	 * 
	 * @return	Redirect
	 */
	public function save()
	{
		// Extract input [ $base, $cell_number, $cell_carrier ]
		extract(Input::all());

		// Execute command
		try {
			$command = new UpdateAccountCommand($base, $cell_number, $cell_carrier);
			$command->execute();
		}

		// Catch UpdateAccountException
		catch (UpdateAccountException $e) {
			return Redirect::back()->withInput();
		}

		// Redirect to account page
		return Redirect::route('account');
	}
}