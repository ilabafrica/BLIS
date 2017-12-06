<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatekBLIStables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
        {
            $table->increments("id")->unsigned();
            $table->string("username", 50)->unique();
            $table->string("password", 100);
            $table->string("email", 100);
            $table->string("name", 100)->nullable();
            $table->tinyInteger("gender")->default(0);
            $table->string("designation", 100)->nullable();
            $table->string("image", 100)->nullable();
            $table->string("remember_token", 100)->nullable();

            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('tokens', function(Blueprint $table)
        {
            $table->string('email')->index();
            $table->string('token')->index();
            $table->timestamps();
        });

        Schema::create('patients', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->string('patient_number')->unique();
            $table->string('name', 100);
            $table->date('dob');
            $table->tinyInteger('gender')->default(0);
            $table->string('email', 100)->nullable();
            $table->string('address', 150)->nullable();
            $table->string('phone_number')->nullable();
            $table->string('external_patient_number', 20)->nullable();
            $table->integer('created_by')->unsigned()->default(0);

            $table->index('external_patient_number');
            $table->index('created_by');

            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('specimen_types', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->string('name', 45);
            $table->string('description', 100)->nullable();

            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('test_categories', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->string('name',100)->unique();
            $table->string('description',100)->nullable();

            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('measure_types', function(Blueprint $table)
        {
            $table->integer('id')->unsigned();
            $table->string('name',100)->unique();

            $table->primary('id');

            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('measures', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->integer('measure_type_id')->unsigned();
            $table->string('name', 100);
            $table->string('unit', 30);
            $table->string('description', 150)->nullable();

            $table->foreign('measure_type_id')->references('id')->on('measure_types');

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('measure_ranges', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->integer('measure_id')->unsigned();
            $table->integer('age_min')->unsigned()->nullable();
            $table->integer('age_max')->unsigned()->nullable();
            $table->tinyInteger('gender')->unsigned()->nullable();
            $table->decimal('range_lower', 7, 3)->nullable();
            $table->decimal('range_upper', 7, 3)->nullable();
            $table->string('alphanumeric', 200)->nullable();
            $table->string('interpretation', 100)->nullable();

            $table->index('alphanumeric');

            $table->softDeletes();
            $table->foreign('measure_id')->references('id')->on('measures');
        });

        Schema::create('test_types', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->string('name', 100);
            $table->string('description', 100)->nullable();
            $table->integer('test_category_id')->unsigned();
            $table->string('targetTAT', 50)->nullable();
            $table->string('prevalence_threshold', 50)->nullable();
            
            $table->foreign('test_category_id')->references('id')->on('test_categories');

            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('testtype_measures', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->integer('test_type_id')->unsigned();
            $table->integer('measure_id')->unsigned();
            $table->tinyInteger('ordering')->nullable();
            $table->tinyInteger('nesting')->nullable();

            $table->foreign('test_type_id')->references('id')->on('test_types');
            $table->foreign('measure_id')->references('id')->on('measures');
            $table->unique(array('test_type_id','measure_id'));
        });

        Schema::create('testtype_specimentypes', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->integer('test_type_id')->unsigned();
            $table->integer('specimen_type_id')->unsigned();

            $table->foreign('test_type_id')->references('id')->on('test_types');
            $table->foreign('specimen_type_id')->references('id')->on('specimen_types');
            $table->unique(array('test_type_id','specimen_type_id'));
        });

        Schema::create('test_phases', function(Blueprint $table)
        {
            $table->integer('id')->unsigned();
            $table->string('name',45);

            $table->primary('id');
        });

        Schema::create('test_statuses', function(Blueprint $table)
        {
            $table->integer('id')->unsigned();
            $table->string('name',45);
            $table->integer('test_phase_id')->unsigned();
            
            $table->primary('id');
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
            $table->string('visit_type', 12)->default('Out-patient'); //'OUT-PATIENT' | 'IN-PATIENT'
            $table->integer('visit_number')->unsigned()->nullable(); //External

            $table->index('visit_number');
			$table->foreign('patient_id')->references('id')->on('patients');

            $table->timestamps();
        });
		
		Schema::create('rejection_reasons', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
			$table->string("reason", 100);
		});

        Schema::create('facilities', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->string('name', 500);

            $table->timestamps();
        });

        Schema::create('referrals', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->integer('status')->unsigned();
            $table->integer('facility_id')->unsigned();
            $table->string('person', 500);
            $table->text('contacts');
            $table->integer('user_id')->unsigned();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('facility_id')->references('id')->on('facilities');

            $table->timestamps();
        });

		Schema::create('specimens', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
			$table->integer('specimen_type_id')->unsigned();
			$table->integer('specimen_status_id')->unsigned()->default(Specimen::NOT_COLLECTED);
            $table->integer('accepted_by')->unsigned()->default(0);
            $table->integer('rejected_by')->unsigned()->default(0);
			$table->integer('rejection_reason_id')->unsigned()->nullable();
            $table->string('reject_explained_to',100)->nullable();
			$table->integer('referral_id')->unsigned()->nullable();
			$table->timestamp('time_accepted')->nullable();
			$table->timestamp('time_rejected')->nullable();
			
            $table->index('accepted_by');
            $table->index('rejected_by');
			$table->foreign('specimen_type_id')->references('id')->on('specimen_types');
			$table->foreign('specimen_status_id')->references('id')->on('specimen_statuses');
			$table->foreign('rejection_reason_id')->references('id')->on('rejection_reasons');
            $table->foreign('referral_id')->references('id')->on('referrals');
		});

		Schema::create('tests', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
			$table->bigInteger('visit_id')->unsigned();
			$table->integer('test_type_id')->unsigned();
			$table->integer('specimen_id')->unsigned()->default(0);
			$table->string('interpretation',200)->default('');
			$table->integer('test_status_id')->unsigned()->default(0);
			$table->integer('created_by')->unsigned();
			$table->integer('tested_by')->unsigned()->default(0);
			$table->integer('verified_by')->unsigned()->default(0);
			$table->string('requested_by',60);
			$table->timestamp('time_created')->default(DB::raw('CURRENT_TIMESTAMP'));
			$table->timestamp('time_started')->nullable();
			$table->timestamp('time_completed')->nullable();
			$table->timestamp('time_verified')->nullable();
			$table->timestamp('time_sent')->nullable();
            $table->integer('external_id')->nullable();//Unique ID for external records
			
            $table->index('created_by');
            $table->index('tested_by');
            $table->index('verified_by');
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
			$table->string('result',1000)->nullable();
			$table->timestamp('time_entered')->default(DB::raw('CURRENT_TIMESTAMP'));
			
            $table->foreign('test_id')->references('id')->on('tests');
            $table->foreign('measure_id')->references('id')->on('measures');
			$table->unique(array('test_id','measure_id'));
		});

        Schema::create('instruments', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->string('name', 100);
            $table->string('ip', 15)->nullable();
            $table->string('hostname', 100)->nullable();
            $table->string('description', 100)->nullable();
            $table->string('driver_name', 100)->nullable();

            $table->nullableTimestamps();
        });

        Schema::create('instrument_testtypes', function(Blueprint $table)
        {
            $table->integer('instrument_id')->unsigned();
            $table->integer('test_type_id')->unsigned();

            $table->foreign('instrument_id')->references('id')->on('instruments');
            $table->foreign('test_type_id')->references('id')->on('test_types');
            $table->unique(array('instrument_id','test_type_id'));
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::dropIfExists('instrument_testtypes');
        Schema::dropIfExists('instruments');
		Schema::dropIfExists('test_results');
		Schema::dropIfExists('tests');
		Schema::dropIfExists('specimens');
        Schema::dropIfExists('referrals');
        Schema::dropIfExists('facilities');
		Schema::dropIfExists('rejection_reasons');
		Schema::dropIfExists('visits');
		Schema::dropIfExists('test_statuses');
		Schema::dropIfExists('specimen_statuses');
		Schema::dropIfExists('test_phases');
		Schema::dropIfExists('testtype_specimentypes');
        Schema::dropIfExists('testtype_measures');
        Schema::dropIfExists('test_types');
        Schema::dropIfExists('measure_ranges');
        Schema::dropIfExists('measures');
        Schema::dropIfExists('measure_types');
        Schema::dropIfExists('test_categories');
        Schema::dropIfExists('specimen_types');
        Schema::dropIfExists('patients');
        Schema::dropIfExists('tokens');
        Schema::dropIfExists('users');
	}
}
