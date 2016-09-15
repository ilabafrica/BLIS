<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCriticalReport extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('critical_report', function(Blueprint $table){
			$table->increments('id')->unsigned();
			$table->integer('test_id')->unsigned();
			$table->integer('measure_id')->unsigned();
			$table->integer('test_type_id')->unsigned();
			$table->integer('test_category_id')->unsigned();
			$table->tinyInteger('gender');
			$table->decimal('age', 5, 2);

			$table->timestamps();

			$table->foreign('test_id')->references('id')->on('tests');
			$table->foreign('measure_id')->references('id')->on('measures');
			$table->foreign('test_type_id')->references('id')->on('test_types');
			$table->foreign('test_category_id')->references('id')->on('test_categories');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('critical_report');
	}
}