<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOfficialsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('officials', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name', 50);
			$table->char('home', 10);
			$table->char('cell', 10);
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
		Schema::drop('officials');
	}

}
