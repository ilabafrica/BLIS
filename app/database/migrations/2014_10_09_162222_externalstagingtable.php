<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Externalstagingtable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('staging', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('labNo');
			$table->integer('parentLabNo');
			$table->integer('test_id');
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
			$table->integer('age')->nullable();
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
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('staging');
	}

}
