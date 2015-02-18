<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class QcTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() 
        {
                Schema::create('lots', function(Blueprint $table)
                {
                	$table->increments('id')->unsigned();
                	$table->string('number', 100)->unique();
                	$table->string('information', 400)->nullable();

                	$table->timestamps();
                });

                Schema::create('control_types', function(Blueprint $table)
                {
                	$table->increments('id')->unsigned();
                	$table->string('name', 100)->unique();
                	$table->string('description', 400)->nullable();
                	$table->integer('instrument_id')->unsigned();

                	$table->timestamps();
                	$table->foreign('instrument_id')->references('id')->on('instruments');
                });

                Schema::create('control_measures', function(Blueprint $table)
                {
                	$table->increments('id');
                	$table->string('name');
                	$table->string('unit');
                        $table->string('expected_result');
                	$table->integer('control_type_id')->unsigned();

                	$table->foreign('control_type_id')->references('id')->on('control_types');
                	$table->timestamps();
                });

                Schema::create('control_measure_ranges', function(Blueprint $table){
                	$table->increments('id');
                	$table->integer('upper_range');
                	$table->integer('lower_range');
                	$table->string('alphanumeric', '100');
                	$table->integer('control_measure_id')->unsigned();
                	$table->integer('lot_id')->unsigned();

                	$table->foreign('control_measure_id')->references('id')->on('control_measures');
                	$table->foreign('lot_id')->references('id')->on('lots');
                	$table->timestamps();
                });

                Schema::create('control_results', function(Blueprint $table){
                	$table->increments('id');
                	$table->string('results', '300');
                	$table->integer('control_type_id')->unsigned();
                	$table->integer('control_measure_id')->unsigned();
                	
                	$table->foreign('control_type_id')->references('id')->on('control_types');
                	$table->foreign('control_measure_id')->references('id')->on('control_measures');
                });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('control_results');
		Schema::dropIfExists('ranges');
		Schema::dropIfExists('lot_ranges');
		Schema::dropIfExists('control_measures');
		Schema::dropIfExists('control_types');
		Schema::dropIfExists('lots');
	}
}
