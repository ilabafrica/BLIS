<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ControlsFkey extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('controls', function(Blueprint $table)
		{
			$table->integer('lot_id')->unsigned();
			$table->foreign('lot_id')->references('id')->on('lots');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('controls', function(Blueprint $table)
		{
			//
		});
	}

}
