<?php

class UpdateAccountCommand {

	protected $base;
	protected $cell_number;
	protected $cell_carrier;

	/**
	 * UpdateAccountCommand
	 * 
	 * @param $username
	 * @param $password
	 */
	function __construct( $base = NULL, $cell_number = NULL, $cell_carrier = NULL )
	{
		$this->base = $base;
		$this->cell_number = $cell_number;
		$this->cell_carrier = $cell_carrier;
	}

	public function execute()
	{
		// Validation
		if (!empty($this->base) && !ctype_digit($this->base)) {
			Flash::warning('Home base zip code may only contain numbers.');
			throw new UpdateAccountException;
		} elseif(!ctype_digit($this->cell_number)) {
			Flash::warning('Cell phone number should contain only numbers and be 10 digets long.');
			throw new UpdateAccountException;
		}

		// Load the user
		$user = User::find(Session::get('user_id'));
		if (!$user) throw new Exception;

		// Save the user info
		$user->base = $this->base;
		$user->cell_number = $this->cell_number;
		$user->cell_carrier = $this->cell_carrier;
		$result = $user->save();

		// Make sure if worked
		if (!$result) {
			Flash::error('An unknown error has occured, please contact us for assistance.');
			throw new UpdateAccountException;
		}

		// Everything worked
		Flash::success('Your account settings have been saved!');
	}

}