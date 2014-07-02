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
			$table->integer('test_type_id')->unsigned();
			$table->integer('specimen_type_id')->unsigned();

			$table->foreign('test_type_id')->references('id')->on('test_type');
			$table->foreign('specimen_type_id')->references('id')->on('specimen_type');
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