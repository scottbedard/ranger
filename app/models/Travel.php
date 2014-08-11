<?php

class Travel extends Eloquent {

	/**
	 * Eloquent Settings
	 */
	protected $table = 'travel';								// Table:		Travel
	protected function getDateFormat() { return 'U'; }			// Timestamps:	UNIX
	protected $fillable = ['start', 'end', 'distance', 'duration'];

}
