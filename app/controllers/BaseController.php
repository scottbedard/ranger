<?php

class BaseController extends Controller {

	public $data;

	/**
	 * __construct
	 */
	function __construct()
	{
		if (Session::get('user_id')) {
			// User Navigaiton
			$this->data['navigation'] = [
				'account'	=> ['name' => 'My Account'],
				'schedule'	=> ['name' => 'Schedule'],
				'rinks'		=> ['name' => 'Rinks'],
				'officials'	=> ['name' => 'Officials'],
				'logout'	=> ['name' => 'Log Out']
			];

			// Data for authenticated user
			$this->data['user'] = User::find(Session::get('user_id'));
			$this->data['ranger'] = new Ranger('ssbedard');
			
		} else {
			// Guest Navigation
			$this->data['navigation'] = [
				'login' => ['name' => 'Login']
			];

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
