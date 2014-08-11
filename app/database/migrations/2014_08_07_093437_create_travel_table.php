<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTravelTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('travel', function(Blueprint $table)
		{
			$table->increments('id');
			$table->char('start', 5);
			$table->char('end', 5);
			$table->string('distance', 30);
			$table->string('duration', 30);
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
		Schema::drop('travel');
	}

}
