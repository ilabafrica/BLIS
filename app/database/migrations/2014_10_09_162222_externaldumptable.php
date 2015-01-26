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
			$table->integer('lab_no')->unique();
			$table->integer('parent_lab_no');
			$table->integer('test_id')->nullable();
			$table->string('requesting_clinician')->nullable();
			$table->string('investigation');
			$table->string('provisional_diagnosis')->nullable();
			$table->timestamp('request_date')->nullable();
			$table->string('order_stage')->nullable();
			$table->text('result')->nullable();
			$table->integer('result_returned')->nullable();
			$table->integer('patient_visit_number')->nullable();
			$table->integer('patient_id');
			$table->string('full_name');
			$table->datetime('dob')->nullable();
			$table->string('gender')->nullable();
			$table->string('address')->nullable();
			$table->string('postal_code')->nullable();
			$table->string('phone_number')->nullable();
			$table->string('city')->nullable();
			$table->string('cost')->nullable();
			$table->string('receipt_number')->nullable();
			$table->string('receipt_type')->nullable();
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
