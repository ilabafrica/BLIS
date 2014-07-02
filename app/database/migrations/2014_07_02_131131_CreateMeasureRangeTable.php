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
			$table->integer('age_min')->unsigned();
			$table->integer('age_max')->unsigned();
			$table->char('gender', 1);
			$table->decimal('range_lower', 7, 3);
			$table->decimal('range_upper', 7, 3);
			
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