<?php

class RinkInsertCommand {

	public $code;
	public $name;
	public $address;
	public $city;
	public $state;
	public $zip;
	public $phone;

	/**
	 * __construct
	 * 
	 * @param	$code, $name, $address, $city, $state, $zip, $phone
	 */
	function __construct( $code, $name, $address, $city, $state, $zip, $phone )
	{
		$this->code = $code;
		$this->name = $name;
		$this->address = $address;
		$this->city = $city;
		$this->state = $state;
		$this->zip = $zip;
		$this->phone = $phone;
	}

	/**
	 * execute
	 */
	public function execute()
	{
		// Validate the input
		$validation = Validator::make(
			[
				'code' => $this->code,
				'name' => $this->name,
				'address' => $this->address,
				'city' => $this->city,
				'state' => $this->state,
				'zip' => $this->zip,
			], 
			[
				'code' => 'required',
				'name' => 'required',
				'address' => 'required',
				'city' => 'required',
				'state' => 'required|alpha|size:2',
				'zip' => 'required|regex:/[0-9]{5}/'
			]
		);

		// Throw an exception if it fails
		if ($validation->fails()) {
			Flash::warning('That address doesn\'t look right, please make sure it\'s correct and try again.');
			throw new ValidationFailedException;
		}

		// Store the rink information
		$rink = new Rink([
			'code' => strtoupper($this->code),
			'name' => ucwords(strtolower($this->name)),
			'address' => ucwords(strtolower($this->address)),
			'city' => ucwords(strtolower($this->city)),
			'state' => strtoupper($this->state),
			'zip' => $this->zip,
			'added_by' => Session::get('user_id')
		]);
		$result = $rink->save();

		// Handle exceptions
		if (!$result) {
			Flash::error('An unknown error has occured while trying to save rink information.');
			throw new ValidationFailedException;
		}

		// Everything worked
		Flash::success('Thanks for helping out!');
	}
}