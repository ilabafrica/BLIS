<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCustomFields extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('custom_field_types', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
			$table->string('name');
			$table->string('description');

			$table->timestamps();
			$table->softDeletes();
		});

		Schema::create('custom_fields', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
			$table->string('name');
			$table->string('label');
			$table->integer('custom_field_type_id')->unsigned();
			$table->string('options');

			$table->foreign('custom_field_type_id')->references('id')->on('custom_field_types');

			$table->timestamps();
			$table->softDeletes();
		});

		Schema::create('custom_field_values', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
			$table->integer('custom_field_id')->unsigned();
			$table->string('data_value');
			
			$table->foreign('custom_field_id')->references('id')->on('custom_fields');

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
		Schema::dropIfExists('custom_field_values');
		Schema::dropIfExists('custom_field');
		Schema::dropIfExists('custom_field_types');
	}

}
