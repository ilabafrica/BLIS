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
			$table->integer('testtype_id');
			$table->integer('measure_id');
			$table->tinyInteger('ordering');
			$table->tinyInteger('nesting');
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