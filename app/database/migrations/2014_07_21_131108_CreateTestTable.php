<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTestTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tests', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
			$table->bigInteger('visit_id')->unsigned();
			$table->integer('test_type_id')->unsigned();
			$table->integer('specimen_id')->default(0);
			$table->string('interpretation',200)->default('');
			$table->tinyInteger('test_status_id')->default(0);
			$table->integer('created_by')->unsigned();
			$table->integer('tested_by')->unsigned()->default(0);
			$table->integer('verified_by')->unsigned()->default(0);
			$table->integer('requested_by')->unsigned()->default(0);
			$table->timestamp('time_created');
			$table->timestamp('time_started')->nullable();
			$table->timestamp('time_completed')->nullable();
			$table->timestamp('time_verified')->nullable();
			$table->timestamp('time_sent')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tests');
	}

}
