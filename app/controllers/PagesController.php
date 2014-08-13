<?php

class PagesController extends BaseController {

	function __construct()
	{
		parent::__construct();
	}

	/**
	 * About page
	 */
	public function about()
	{
		return View::make('pages.about')->withData($this->data);
	}
}
