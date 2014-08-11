<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('username', 30)->unique();
			$table->string('email', 50);
			$table->char('base', 5);
			$table->char('cell_number', 10);
			$table->string('cell_carrier', 30);
			$table->integer('lastseen');
			$table->integer('created_at');
			$table->integer('updated_at');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users');
	}

}
