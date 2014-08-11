<?php

class RinksController extends BaseController {

	function __construct()
	{
		parent::__construct();

		// Highlight navigation menu
		$this->data['navigation']['rinks']['selected'] = TRUE;

	}

	public function search()
	{
		$this->data['rinks'] = Rink::where(Input::get('field'), 'LIKE', '%'.Input::get('search').'%')->get();
		$this->data['pagination'] = FALSE;

		return View::make('rinks.rinks')->withData($this->data);
	}

	/**
	 * RinksController
	 */
	public function index( $page = 1 )
	{
		if (empty(Input::get('search'))) return Redirect::route('rinks');

		DB::getPaginator()->setCurrentPage($page);
		$this->data['rinks'] = Rink::orderBy('name', 'asc')->paginate(10);

		$this->data['pagination']['next'] = $page + 1;
		$this->data['pagination']['prev'] = $page - 1;

		return View::make('rinks.rinks')->withData($this->data);
	}

	public function info ( $code )
	{
		$this->data['rink'] = Rink::where('code', $code)->first();
		if (!$this->data['rink']) {
			Flash::warning('Invalid rink code.');
			return Redirect::route('rinks');
		}

		return View::make('rinks.info')->withData($this->data);
	}

	/**
	 * Executes RinkInsertCommand
	 */
	public function store()
	{
		extract(Input::all());
		$command = new RinkInsertCommand($code, $name, $address, $city, $state, $zip, $phone);
		$command->execute();

		return Redirect::back();
	}

	/**
	 * Confirms the accuracy of a rink address
	 * 
	 * @param	$code
	 */
	public function confirm ( $code )
	{
		try {
			$command = new RinkVerifyCommand($code, 'confirm');
			$command->execute();
		}

		catch (RinkVerifyException $exception) {
			return Redirect::back();
		}

		return Redirect::back();
	}

	/**
	 * Reports a rink address as incorrect
	 * 
	 * @param  $code
	 */
	public function report ( $code )
	{
		try {
			$command = new RinkVerifyCommand($code, 'report');
			$command->execute();
		}

		catch (RinkVerifyException $exception) {
			return Redirect::back();
		}

		return Redirect::back();
	}
}
