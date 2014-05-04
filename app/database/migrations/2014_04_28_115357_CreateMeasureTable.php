<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMeasureTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('measure', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
			$table->string('name', 100);
			$table->string('measure_range', 60)->nullable();
			$table->string('unit', 30);
			$table->string('description', 150)->nullable();
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
		Schema::dropIfExists('measure');
	}

}