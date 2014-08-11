<?php

class User extends Eloquent {

	/**
	 * Eloquent Settings
	 */
	protected $table = 'users';									// Table:		Users
	protected function getDateFormat() { return 'U'; }			// Timestamps:	UNIX
	protected $fillable = ['username', 'email', 'base', 'cell_number', 'cell_carrier', 'lastseen'];

}
