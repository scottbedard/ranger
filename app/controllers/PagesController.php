<?php

class PagesController extends BaseController {

	/**
	 * Login Controller
	 */
	public function login()
	{
		return View::make('pages.login');
	}

}
