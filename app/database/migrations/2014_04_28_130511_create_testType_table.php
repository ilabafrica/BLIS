<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTestTypeTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('test_type', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
			$table->string('name', 100);
			$table->string('description', 100)->nullable();
			$table->integer('section_id')->unsigned();
			$table->string('targetTAT', 50)->nullable();
			$table->string('prevalence_threshold', 50)->nullable();
			
			$table->foreign('section_id')->references('id')->on('test_category');

			$table->softDeletes();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('test_type');
	}

}
