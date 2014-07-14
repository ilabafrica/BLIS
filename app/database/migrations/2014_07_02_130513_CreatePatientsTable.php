<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePatientsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('patients', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();;
			$table->string('patient_number')->unique();
			$table->string('name', 100);
			$table->date('dob');
			$table->tinyInteger('gender')->default(0);
			$table->string('email', 100)->nullable();
			$table->string('address', 150)->nullable();
			$table->string('phone_number')->nullable();
			$table->string('external_patient_number')->nullable();

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
		Schema::drop('patients');
	}

}