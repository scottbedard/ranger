<?php

class Rink extends Eloquent {

	/**
	 * Eloquent Settings
	 */
	protected $table = 'rinks';									// Table:		Rinks
	protected function getDateFormat() { return 'U'; }			// Timestamps:	UNIX
	protected $fillable = ['code', 'name', 'address', 'city', 'state', 'zip', 'phone', 'added_by', 'confirmed_by'];

}
