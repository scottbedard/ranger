<?php

class BaseController extends Controller {

	public $data;

	/**
	 * __construct
	 */
	function __construct()
	{
		$this->data['date_format'] = 'n/d/Y';
		$this->data['time_format'] = 'g:ia';

		if (Session::get('user_id')) {
			// User Navigaiton
			$this->data['navigation'] = navigation('user');

			// Data for authenticated user
			$this->data['user'] = User::find(Session::get('user_id'));
			$this->data['ranger'] = new Ranger($this->data['user']->username);
			
		} else {
			// Guest Navigation
			$this->data['navigation'] = navigation('guest');

		}
	}

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

}
