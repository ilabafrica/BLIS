<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTestResultTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('test_results', function(Blueprint $table)
		{
			$table->increments('id')->bigInterger()->unsigned();
			$table->integer('test_id')->unsigned();
			$table->integer('measure_id')->unsigned();
			$table->string('result',45)->nullable();
			$table->timestamp('time_entered')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('test_results');
	}

}
