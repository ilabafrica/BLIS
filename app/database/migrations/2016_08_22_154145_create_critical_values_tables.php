<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCriticalValuesTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('critical', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
			$table->integer('parameter')->unsigned();
			$table->tinyInteger('gender')->unsigned();
			$table->integer('age_min')->nullable();
			$table->integer('age_max')->nullable();
			$table->decimal('normal_lower', 5, 2)->nullable();
			$table->decimal('normal_upper', 5, 2)->nullable();
			$table->decimal('critical_low', 5, 2)->nullable();
			$table->decimal('critical_high', 5, 2)->nullable();
			$table->string('unit', 10)->nullable();

			$table->timestamps();
			$table->softDeletes();

			$table->foreign('parameter')->references('id')->on('measures');
		});
		Schema::create('micro_critical', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
			$table->integer('description');

			$table->timestamps();
			$table->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('micro_critical');
		Schema::dropIfExists('critical');
	}
}
