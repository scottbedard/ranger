<?php

class OfficialsController extends BaseController {

	/**
	 * OfficialsController
	 */
	function __construct()
	{
		parent::__construct();

		// Highlight navigation menu
		$this->data['navigation']['officials']['selected'] = TRUE;
	}

	/**
	 * Officials directory
	 * 
	 * @param  integer $page
	 * @return view
	 */
	function index( $page = 1 )
	{
		DB::getPaginator()->setCurrentPage($page);
		$this->data['officials'] = Official::orderBy('name', 'asc')->paginate(20);
		
		$this->data['pagination']['next'] = $page + 1;
		$this->data['pagination']['prev'] = $page - 1;

		return View::make('officials.officials')->withData($this->data);
	}

	/**
	 * Searches officials by name
	 * 
	 * @return view
	 */
	function search()
	{
		if (empty(Input::get('search'))) return Redirect::route('officials');

		$this->data['officials'] = Official::where('name', 'LIKE', '%'.Input::get('search').'%')->get();
		$this->data['pagination'] = FALSE;

		return View::make('officials.officials')->withData($this->data);
	}

}