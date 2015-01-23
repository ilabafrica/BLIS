<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Externaldumptable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('external_dump', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('labNo')->unique();
			$table->integer('parentLabNo');
			$table->integer('test_id')->nullable();
			$table->string('requestingClinician')->nullable();
			$table->string('investigation');
			$table->string('provisional_diagnosis')->nullable();
			$table->timestamp('requestDate')->nullable();
			$table->string('orderStage')->nullable();
			$table->text('result')->nullable();
			$table->integer('result_returned')->nullable();
			$table->integer('patientVisitNumber')->nullable();
			$table->integer('patient_id');
			$table->string('fullName');
			$table->datetime('dateOfBirth')->nullable();
			$table->string('gender')->nullable();
			$table->string('address')->nullable();
			$table->string('postalCode')->nullable();
			$table->string('phoneNumber')->nullable();
			$table->string('city')->nullable();
			$table->string('cost')->nullable();
			$table->string('receiptNumber')->nullable();
			$table->string('receiptType')->nullable();
			$table->string('waiver_no')->nullable();
			$table->string('system_id')->nullable();

			$table->timestamps();
		});

		//Holds the external user ID's of the users in our system who are also in the external system
		Schema::create('external_users', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('internal_user_id')->unique()->unsigned();
			$table->integer('external_user_id')->nullable();
			$table->timestamps();

			$table->foreign('internal_user_id')->references('id')->on('users');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('external_dump');
		Schema::drop('external_users');
	}

}
