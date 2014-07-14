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
		Schema::create('measure_ranges', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
			$table->integer('measure_id')->unsigned();
			$table->integer('age_min')->unsigned();
			$table->integer('age_max')->unsigned();
			$table->tinyInteger('gender')->unsigned();
			$table->decimal('range_lower', 7, 3);
			$table->decimal('range_upper', 7, 3);
			
			$table->foreign('measure_id')->references('id')->on('measures');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('measure_ranges');
	}

}