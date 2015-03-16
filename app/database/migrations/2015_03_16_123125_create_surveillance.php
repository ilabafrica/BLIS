<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSurveillance extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('diseases', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->string('name', 60);
        });

        Schema::create('report_diseases', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->integer('test_type_id')->unsigned();
            $table->integer('disease_id')->unsigned();

            $table->unique( array('test_type_id','disease_id') );
            $table->foreign('test_type_id')->references('id')->on('test_types');
            $table->foreign('disease_id')->references('id')->on('diseases');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::dropIfExists('report_diseases');
        Schema::dropIfExists('diseases');		
	}

}
