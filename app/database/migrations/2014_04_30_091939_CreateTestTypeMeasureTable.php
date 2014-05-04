<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTestTypeMeasureTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('testtype_measure', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
			$table->integer('testtype_id')->unsigned();
			$table->integer('measure_id')->unsigned();
			$table->tinyInteger('ordering');
			$table->tinyInteger('nesting');

			$table->foreign('testtype_id')->references('id')->on('test_type');
			$table->foreign('measure_id')->references('id')->on('measure');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('testtype_measure');
	}

}