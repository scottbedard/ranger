<?php

class ForgotPasswordCommand {

	protected $email;

	/**
	 * ForgotPasswordCommand
	 * 
	 * @param $email
	 */
	function __construct( $email )
	{
		$this->email = $email;
	}

	/**
	 * execute()
	 * 
	 * Contacts oswebs and submit the forgot password form
	 */
	public function execute()
	{
		// Validate the email address
		$validation = Validator::make(
			['email' => $this->email], 
			['email' => 'required|email']
		);

		// Throw an exception if it fails
		if ($validation->fails()) {
			Flash::warning('Please enter a valid email address.');
			throw new ValidationFailedException;
		}

		// Validation passed, send the request to oswebs
		$url = "http://www.oswebs.com/usahjr/officials/dir.asp";
		$postdata = http_build_query(
		    array('dir' => 'val',
				  'snd'	=> '1',
				  'email'	=> $this->email)
		);
		$opts = array('http' =>
			array(
				'method'  => 'POST',
				'header'  => 'Content-type: application/x-www-form-urlencoded',
				'content' => $postdata
			)
		);
		
		$context  = stream_context_create($opts);
		$source = file_get_contents($url, FALSE, $context);
		
		if (strpos($source, '<p>Your request has been emailed</p>')) {
			// Success
			Flash::success('Ranger has emailed your password to you.');

		} elseif (strpos($source, '<p>email address cannot be found</p>')) {
			// Email not found
			Flash::warning('Ranger could not find an account by that email address.');
			throw new ForgotPasswordException;

		} else {
			// Ranger is not responding...
			throw new RangerOfflineException;
		}

	}

}