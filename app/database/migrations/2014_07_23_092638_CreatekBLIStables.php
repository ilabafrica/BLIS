<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatekBLISTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('test_phases', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name',45);
		});

		Schema::create('test_statuses', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name',45);
			$table->integer('test_phase_id')->unsigned();
			
			$table->foreign('test_phase_id')->references('id')->on('test_phases');
		});

		Schema::create('specimen_statuses', function(Blueprint $table)
		{
			$table->integer('id')->unsigned();
			$table->string('name',45);

			$table->primary('id');
		});

		Schema::create('visits', function(Blueprint $table)
		{
			$table->bigIncrements('id');
			$table->integer('patient_id')->unsigned();
			$table->timestamp('time_created');
			
			$table->foreign('patient_id')->references('id')->on('patients');		
		});
		
		Schema::create('rejection_reasons', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string("reason", 100);
		});

		Schema::create('specimens', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('specimen_type_id')->unsigned();
			$table->integer('specimen_status_id')->unsigned();
			$table->integer('rejection_reason_id')->unsigned();
			$table->integer('test_phase_id')->unsigned();
			$table->integer('created_by');
			$table->integer('referred_from');
			$table->integer('referred_to');
			$table->timestamp('time_accepted');
			$table->timestamp('time_rejected')->nullable();
			
			$table->foreign('specimen_type_id')->references('id')->on('specimen_types');
			$table->foreign('specimen_status_id')->references('id')->on('specimen_statuses');
			$table->foreign('rejection_reason_id')->references('id')->on('rejection_reasons');
			$table->foreign('test_phase_id')->references('id')->on('test_phases');
		});

		Schema::create('tests', function(Blueprint $table)
		{
			$table->increments('id');
			$table->bigInteger('visit_id')->unsigned();
			$table->integer('test_type_id')->unsigned();
			$table->integer('specimen_id')->unsigned()->default(0);
			$table->string('interpretation',200)->default('');
			$table->integer('test_status_id')->unsigned()->default(0);
			$table->integer('created_by')->unsigned();
			$table->integer('tested_by')->unsigned()->default(0);
			$table->integer('verified_by')->unsigned()->default(0);
			$table->integer('requested_by')->unsigned()->default(0);
			$table->timestamp('time_created');
			$table->timestamp('time_started')->nullable();
			$table->timestamp('time_completed')->nullable();
			$table->timestamp('time_verified')->nullable();
			$table->timestamp('time_sent')->nullable();
			
			$table->foreign('visit_id')->references('id')->on('visits');
			$table->foreign('test_type_id')->references('id')->on('test_types');
			$table->foreign('specimen_id')->references('id')->on('specimens');
			$table->foreign('test_status_id')->references('id')->on('test_statuses');
		});

		Schema::create('test_results', function(Blueprint $table)
		{
			$table->bigIncrements('id');
			$table->integer('test_id')->unsigned();
			$table->integer('measure_id')->unsigned();
			$table->string('result',45)->nullable();
			$table->timestamp('time_entered')->nullable();
			
			$table->foreign('test_id')->references('id')->on('tests');
			$table->foreign('measure_id')->references('id')->on('measures');
			$table->unique(array('test_id','measure_id'));
		});

		Schema::create('referrals', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('referring_institution', 100);
		});


		
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('referrals');
		Schema::drop('test_results');
		Schema::drop('tests');
		Schema::drop('specimens');
		Schema::drop('rejection_reasons');
		Schema::drop('visits');
		Schema::drop('test_statuses');
		Schema::drop('specimen_statuses');
		Schema::drop('test_phases');
	}

}