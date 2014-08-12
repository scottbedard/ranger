<?php

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
			'officials'	=> ['name' => 'Officials'],
			'logout'	=> ['name' => 'Log Out']
		];
	} else {
		// Return navigation for guests
		return[
			'login' => ['name' => 'Login']
		];
	}
}