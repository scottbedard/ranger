<?php

class RinksController extends BaseController {

	public $pagination = 10;	// Rinks per page

	/**
	 * __construct
	 */
	function __construct()
	{
		parent::__construct();
		$this->data['navigation']['rinks']['selected'] = TRUE;
	}

	/**
	 * index
	 *
	 * @param	$page
	 * @return	View
	 */
	public function index( $page = 1 )
	{
		// Query the page of rinks, ordered by rink name
		DB::getPaginator()->setCurrentPage($page);
		$this->data['rinks'] = Rink::orderBy('name', 'asc')->paginate($this->pagination);

		// Pagination links
		$this->data['pagination']['next'] = $page + 1;
		$this->data['pagination']['prev'] = $page - 1;

		// Display rinks index
		return View::make('rinks.rinks')->withData($this->data);
	}

	/**
	 * search
	 * 
	 * @return	View
	 */
	public function search()
	{
		// Search for the rink
		$this->data['rinks'] = Rink::where(Input::get('field'), 'LIKE', '%'.Input::get('search').'%')->get();
		$this->data['pagination'] = FALSE;

		// Display search results
		return View::make('rinks.rinks')->withData($this->data);
	}

	/**
	 * info
	 * 
	 * @param	$code
	 * @return	View
	 */
	public function info ( $code )
	{
		// Query rink details
		$this->data['rink'] = Rink::where('code', $code)->first();

		// Rink not found, redirect to rinks
		if (!$this->data['rink']) {
			Flash::warning('Invalid rink code.');
			return Redirect::route('rinks');
		}

		// Display rink details
		return View::make('rinks.info')->withData($this->data);
	}

	/**
	 * store
	 *
	 * Executes RinkInsertCommand
	 *
	 * @return	Redirect
	 */
	public function store()
	{
		// Extract input [ $code, $name, $address, $city, $state, $zip, $phone ]
		extract(Input::all());

		// Execute command
		$command = new RinkInsertCommand($code, $name, $address, $city, $state, $zip, $phone);
		$command->execute();

		// Rink stored, redirect back to 
		return Redirect::back();
	}

	/**
	 * confirm
	 * 
	 * Executes RinkVerifyCommand
	 * 
	 * @param	$code
	 * @return	Redirect
	 */
	public function confirm ( $code )
	{
		// Execute command
		try {
			$command = new RinkVerifyCommand($code, 'confirm');
			$command->execute();
		}

		catch (RinkVerifyException $e) {
			Flash::error('An unknown error occured while attempting to confirm rink address.');
		}

		// Redirect back
		return Redirect::back();
	}

	/**
	 * report
	 * 
	 * Logs a rink address as incorrect
	 * 
	 * @param	$code
	 * @return	Redirect
	 */
	public function report ( $code )
	{
		// Execute command
		try {
			$command = new RinkVerifyCommand($code, 'report');
			$command->execute();
		}

		catch (RinkVerifyException $e) {
			Flash::error('An unknown error ocured while attempting to report rink address.');
		}

		// Redirect back
		return Redirect::back();
	}
}