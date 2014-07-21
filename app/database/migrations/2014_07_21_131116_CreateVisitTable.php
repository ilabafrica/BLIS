<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVisitTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('visits', function(Blueprint $table)
		{
			$table->bigInteger('id')->increments()->unsigned();
			$table->integer('patient_id')->unsigned();
			$table->timestamp('time_created');

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('visits');
	}

}
