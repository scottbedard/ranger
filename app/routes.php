<?php

// Home (ScheduleController)
Route::get('/', ['before' => 'auth', 'as' => 'home', 'uses' => 'ScheduleController@index']);

// Login
Route::get('login', ['as' => 'login', 'uses' => 'LoginController@index']);
Route::post('login', ['as' => 'login', 'uses' => 'LoginController@send']);
Route::get('login/{username}/{password}', ['uses' => 'LoginController@send']);
Route::get('login/{username}', function($username) {
	Flash::warning('You must provide a username and password to log in.');
	return View::make('login.login')->withUsername($username);
});

// Logout
Route::get('logout', ['as' => 'logout', 'uses' => function() {
	Session::flush();
	return Redirect::route('login');
}]);

// Forgot Password
Route::get('forgotpw', ['as' => 'forgotpw', 'uses' => 'ForgotPasswordController@index']);
Route::post('forgotpw', ['as' => 'forgotpw', 'uses' => 'ForgotPasswordController@send']);

// Authenticated routes
Route::group(['before' => 'auth'], function() {

	// User Account
	Route::get('account', ['as' => 'account', 'uses' => 'AccountController@index']);
	Route::post('account', ['as' => 'account', 'uses' => 'AccountController@save']);

	// Schedule
	Route::get('schedule', ['as' => 'schedule', 'uses' => 'ScheduleController@index']);
	Route::get('game/{id}', ['as' => 'game', 'uses' => 'ScheduleController@game']);

	// Rinks
	Route::get('rinks/info/{code}', ['as' => 'rinks.info', 'uses' => 'RinksController@info']);
	Route::get('rinks/{page?}', ['as' => 'rinks', 'uses' => 'RinksController@index']);
	Route::post('rinks', ['as' => 'rinks', 'uses' => 'RinksController@store']);
	Route::post('rinks/search', ['as' => 'rinks.search', 'uses' => 'RinksController@search']);
	Route::get('rinks/{code}/confirm', ['as' => 'rinks.confirm', 'uses' => 'RinksController@confirm']);
	Route::get('rinks/{code}/report', ['as' => 'rinks.report', 'uses' => 'RinksController@report']);

	// Officials
	Route::get('officials/{page?}', ['as' => 'officials', 'uses' => 'OfficialsController@index']);
	Route::post('officials/search', ['as' => 'officials.search', 'uses' => 'OfficialsController@search']);

});