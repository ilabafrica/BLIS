<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMeasureRangeTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('measure_range', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
			$table->integer('measure_id')->unsigned();
			$table->string('age_min');
			$table->string('age_max');
			$table->string('sex');
			$table->string('range_lower');
			$table->string('range_upper');
			
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
		Schema::drop('measure_range');
	}

}