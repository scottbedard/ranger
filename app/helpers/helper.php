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