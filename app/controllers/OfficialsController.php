<?php

class OfficialsController extends BaseController {

	public $pagination = 20;	// Officials per page

	/**
	 * __construct
	 */
	function __construct()
	{
		parent::__construct();
		$this->data['navigation']['officials']['selected'] = TRUE;
	}

	/**
	 * index
	 * 
	 * Officials directory
	 * 
	 * @param	$page
	 * @return	View
	 */
	function index( $page = 1 )
	{
		// Query the page of officials, order by name
		DB::getPaginator()->setCurrentPage($page);
		$this->data['officials'] = Official::orderBy('name', 'asc')->paginate($this->pagination);
		
		// Pagination data
		$this->data['pagination']['next'] = $page + 1;
		$this->data['pagination']['prev'] = $page - 1;

		// Display officials
		return View::make('officials.officials')->withData($this->data);
	}

	/**
	 * search
	 * 
	 * Searches for officials by name
	 * 
	 * @return	View
	 */
	function search()
	{
		// Redirect back if input is missing
		if (empty(Input::get('search'))) return Redirect::route('officials');

		// Query officials
		$this->data['officials'] = Official::where('name', 'LIKE', '%'.Input::get('search').'%')->get();
		$this->data['pagination'] = FALSE;

		// Display search results
		return View::make('officials.officials')->withData($this->data);
	}
}