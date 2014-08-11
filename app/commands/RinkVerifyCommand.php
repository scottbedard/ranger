<?php

class RinkVerifyCommand {

	public $code;
	public $action;

	/**
	 * __construct
	 * 
	 * @param $code, $action
	 */
	function __construct( $code, $action )
	{
		$this->code = $code;
		$this->action = $action;
	}

	/**
	 * execute
	 */
	public function execute()
	{
		// Load the rink, and throw an exception if it fails
		$rink = Rink::where('code', $this->code)->first();
		if (!$rink) {
			Flash::warning('Invalid rink code.');
			throw new RinkVerifyException;
		}

		// Update the confirmed_by or reported_by field
		if ($this->action == 'confirm') $rink->confirmed_by = Session::get('user_id');
		elseif ($this->action == 'report') $rink->reported_by = Session::get('user_id');
		else {
			Flash::warning('Invalid rink verify action.');
			throw new RinkVerifyException;
		}

		// Save the rink
		$result = $rink->save();

		// Throw an exception if it failed
		if (!$result) {
			Flash::error('An unknown error has occured.');
			throw new RinkConfirmException;
		}

		// Everything worked
		if ($this->action == 'confirm') Flash::success('Thanks for the confirmation!');
		elseif ($this->action == 'report') Flash::success('Thanks for alerting us, we\'ll check it out.');
	}

}