<?php

class AccountController extends BaseController {

	function __construct ()
	{
		parent::__construct();

		// Highlight navigation menu
		$this->data['navigation']['account']['selected'] = TRUE;
	}

	/**
	 * index
	 *
	 * Displays the login form
	 */
	public function index()
	{
		return View::make('account.account')->withData($this->data);
	}

	/**
	 * save
	 * 
	 * @return [type]
	 */
	public function save()
	{
		// Extract form information
		extract(Input::all());

		// Execute new UpdateAccountCommand
		$command = new UpdateAccountCommand($base, $cell_number, $cell_carrier);
		$command->execute();

		// Redirect back to account page
		return Redirect::route('account');

	}

}