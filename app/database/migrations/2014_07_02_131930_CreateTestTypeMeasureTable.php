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
			$table->integer('test_type_id')->unsigned();
			$table->integer('measure_id')->unsigned();
			$table->tinyInteger('ordering');
			$table->tinyInteger('nesting');

			$table->foreign('test_type_id')->references('id')->on('test_type');
			$table->foreign('measure_id')->references('id')->on('measure');
			$table->unique(array('test_type_id','measure_id'));
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