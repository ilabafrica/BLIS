<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTestTypeSpecimenTypeTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
 		Schema::create('testtype_specimentype', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
			$table->integer('testtype_id')->unsigned();
			$table->integer('specimentype_id')->unsigned();

			$table->foreign('testtype_id')->references('id')->on('test_type');
			$table->foreign('specimentype_id')->references('id')->on('specimen_type');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('testtype_specimentype');
	}

}