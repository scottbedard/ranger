<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRinksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('rinks', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('code', 20)->unique();
			$table->string('name', 50);
			$table->string('address', 100);
			$table->string('city', 50);
			$table->string('state', 2);
			$table->char('zip', 5);
			$table->char('phone', 10);
			$table->integer('added_by');
			$table->integer('confirmed_by');
			$table->integer('reported_by');
			$table->integer('locked_by');
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
		Schema::drop('rinks');
	}

}
