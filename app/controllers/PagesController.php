<?php

class PagesController extends BaseController {

	/**
	 * Login page
	 *
	 * @return	View
	 */
	public function login()
	{
		return View::make('pages.login');
	}

}
