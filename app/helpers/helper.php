<?php

/**
 * Game Date Helper
 *
 * @param	date	[string]
 * @param	time	[string]
 * @return	[int]
 */
function gameDate($date, $time)
{
	// Since Ranger doesn't provide the year of the game, we'll assume that July to December is this 2014
	// and January to July is 2015
	$date = explode(' ', $date);

	return strtotime($date[1].' '.$date[0].' 2014 '.$time);
}

/**
 * Icon Helper
 * 
 * @param  $icon
 * @param  boolean $alt
 * @return string
 */
function icon ( $icon = FALSE, $alt = FALSE )
{
	if (!$icon) return FALSE;
	else return '<img src="/assets/images/icons/'.$icon.'.png" alt="'.$alt.'" />';
}

/**
 * Phone Helper
 * 
 * @param  $number
 * @return string
 */
function phone ( $number = FALSE )
{
	if (!$number) return FALSE;
	else return substr($number, 0, 3).'-'.substr($number, 3, 3).'-'.substr($number, 6, 4);
}

/**
 * Navigation Helper
 *
 * @param	String	$scope
 */
function navigation ( $scope ) {
	if ($scope == 'user') {
		// Return navigation for authenticated user
		return [
			'account'	=> ['name' => 'My Account'],
			'schedule'	=> ['name' => 'Schedule'],
			'rinks'		=> ['name' => 'Rinks'],
			//'officials'	=> ['name' => 'Officials'],
			'logout'	=> ['name' => 'Log Out']
		];
	} else {
		// Return navigation for guests
		return[
			'login' => ['name' => 'Login']
		];
	}
}