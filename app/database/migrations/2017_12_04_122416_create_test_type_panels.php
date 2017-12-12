<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTestTypePanels extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('test_type_panels',function($table)
		{
			$table->integer('panel_id')->unsigned();
			$table->integer('test_type_id')->unsigned();

			$table->foreign('panel_id')->references('id')->on('panel');
			$table->foreign('test_type_id')->references('id')->on('test_types');
			$table->unique(array('test_type_id','panel_id'));
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExist('test_type_panels');
	}

}
