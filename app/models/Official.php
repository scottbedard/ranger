<?php

class Official extends Eloquent {

	/**
	 * Eloquent Settings
	 */
	protected $table = 'officials';								// Table:		Officials
	protected function getDateFormat() { return 'U'; }			// Timestamps:	UNIX
	protected $fillable = ['name', 'home', 'cell'];

}
