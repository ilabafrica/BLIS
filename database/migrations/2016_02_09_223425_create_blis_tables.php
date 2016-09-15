<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use App\Models\Specimen;

class CreateBlisTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patients', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->string('patient_number');
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
            $table->integer('orderable_test')->nullable();
            $table->string('prevalence_threshold', 50)->nullable();
            $table->tinyInteger('accredited')->nullable();

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
            $table->index('parent_lab_no');

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
        /* Drugs table */
        Schema::create('drugs', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->string('name',100)->unique();
            $table->string('description',100)->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
        /* Organisms table */
        Schema::create('organisms', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->string('name',100)->unique();
            $table->string('description',100)->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
        /* Organism_Drugs table */
        Schema::create('organism_drugs', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->integer('organism_id')->unsigned();
            $table->integer('drug_id')->unsigned();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('organism_id')->references('id')->on('organisms');
            $table->foreign('drug_id')->references('id')->on('drugs');
            $table->unique(array('organism_id','drug_id'));
        });
        /* testType_organisms table */
        Schema::create('testtype_organisms', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->integer('test_type_id')->unsigned();
            $table->integer('organism_id')->unsigned();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('test_type_id')->references('id')->on('test_types');
            $table->foreign('organism_id')->references('id')->on('organisms');
            $table->unique(array('test_type_id','organism_id'));
        });
        /* culture worksheet table */
        Schema::create('culture_worksheet', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('test_id')->unsigned();
            $table->string('observation',300);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('test_id')->references('id')->on('tests');
        });
        /* drug susceptibility table */
        Schema::create('drug_susceptibility', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('test_id')->unsigned();
            $table->integer('organism_id')->unsigned();
            $table->integer('drug_id')->unsigned();
            $table->string('zone',5);
            $table->string('interpretation',2);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('test_id')->references('id')->on('tests');
            $table->foreign('organism_id')->references('id')->on('organisms');
            $table->foreign('drug_id')->references('id')->on('drugs');
        });

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

        /* inventory table */
        Schema::create('inv_items', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->string('name', 100)->unique();
            $table->string('unit', 100)->nullable();
            $table->decimal('min_level', 8, 2);
            $table->decimal('max_level', 8, 2)->nullable();
            $table->string('storage_req', 100);
            $table->string('remarks', 250)->nullable();
            $table->integer('user_id')->unsigned();
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
        });
        /* supplier table */
        Schema::create('suppliers', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->string('name', 100);
            $table->string('phone', 100);
            $table->string('email', 100)->nullable();
            $table->string('address');
           
            $table->integer('user_id')->unsigned();
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
        });
        /* inventory-supply table */
        Schema::create('inv_supply', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->integer('item_id')->unsigned();
            $table->string('lot', 100)->nullable();
            $table->string('batch_no', 12)->nullable();
            $table->dateTime('expiry_date');
            $table->string('manufacturer', 100)->nullable();
            $table->integer('supplier_id')->unsigned();
            $table->integer('quantity_ordered')->default(0);
            $table->integer('quantity_supplied')->default(0);
            $table->decimal('cost_per_unit', 5, 2)->nullable();
            $table->date('date_of_order')->nullable();
            $table->date('date_of_supply')->nullable();
            $table->date('date_of_reception');
            $table->string('remarks', 250)->nullable();
            $table->integer('user_id')->unsigned();
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('item_id')->references('id')->on('inv_items');
            $table->foreign('supplier_id')->references('id')->on('suppliers');
        });
        /* inventory top up requests */
        Schema::create('requests', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->integer('item_id')->unsigned();
            $table->string('quantity_remaining');
            $table->integer('test_category_id')->unsigned();
            $table->integer('quantity_ordered');
            $table->integer('tests_done')->default(0);
            $table->integer('user_id')->unsigned();
            $table->string('remarks', 100);

            $table->softDeletes();
            $table->timestamps();
            $table->foreign('test_category_id')->references('id')->on('test_categories');
            $table->foreign('item_id')->references('id')->on('inv_items');
            $table->foreign('user_id')->references('id')->on('users');
        });
        /* inventory-usage table */
        Schema::create('inv_usage', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->integer('stock_id')->unsigned();
            $table->integer('request_id')->unsigned();
            $table->integer('quantity_used')->default(0);
            $table->date('date_of_usage');
            $table->string('issued_by')->nullable();
            $table->string('received_by')->nullable();
            $table->string('remarks', 250)->nullable();
            $table->integer('user_id')->unsigned();
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('stock_id')->references('id')->on('inv_supply');
            $table->foreign('request_id')->references('id')->on('requests');
        });

        Schema::create('lots', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->string('lot_no', 100)->unique();
            $table->string('description', 400)->nullable();
            $table->date('expiry')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('controls', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->string('name', 100)->unique();
            $table->string('description', 400)->nullable();
            $table->integer('instrument_id')->unsigned();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('instrument_id')->references('id')->on('instruments');
        });

        Schema::create('control_measures', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('name');
            $table->string('unit');
            $table->integer('control_id')->unsigned();
            $table->integer('control_measure_type_id')->unsigned();

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('control_measure_type_id')->references('id')->on('measure_types');
            $table->foreign('control_id')->references('id')->on('controls');
        });

        Schema::create('control_measure_ranges', function(Blueprint $table){
            $table->increments('id');
            $table->decimal('upper_range', 6, 2)->nullable();
            $table->decimal('lower_range', 6, 2)->nullable();
            $table->string('alphanumeric', '100')->nullable();
            $table->integer('control_measure_id')->unsigned();
            
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('control_measure_id')->references('id')->on('control_measures');
        });

        Schema::create('control_tests', function(Blueprint $table){
            $table->increments('id');
            $table->integer('control_id')->unsigned();
            $table->integer('lot_id')->unsigned();
            $table->string('performed_by', 100)->nullable();
            $table->integer('user_id')->unsigned();

            $table->timestamps();

            $table->foreign('control_id')->references('id')->on('controls');
            $table->foreign('lot_id')->references('id')->on('lots');
            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::create('control_results', function(Blueprint $table){
            $table->increments('id');
            $table->string('results');
            $table->integer('control_measure_id')->unsigned();
            $table->integer('control_test_id')->unsigned();
            $table->integer('user_id')->unsigned();

            $table->timestamps();

            $table->foreign('control_test_id')->references('id')->on('control_tests');
            $table->foreign('control_measure_id')->references('id')->on('control_measures');
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('control_tests');
        Schema::dropIfExists('control_measure_ranges');
        Schema::dropIfExists('control_measures');
        Schema::dropIfExists('controls');
        Schema::dropIfExists('lots');
        Schema::dropIfExists('issues');
        Schema::dropIfExists('topup_requests');
        Schema::dropIfExists('receipts');
        Schema::dropIfExists('suppliers');
        Schema::dropIfExists('commodities');
        Schema::dropIfExists('metrics');
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
        Schema::dropIfExists('external_dump');
        Schema::dropIfExists('external_users');
        Schema::dropIfExists('report_diseases');
        Schema::dropIfExists('diseases');
        /* drug susceptibility table */
        Schema::dropIfExists('drug_susceptibility');
        /* culture worksheet table */
        Schema::dropIfExists('culture_worksheet');
        /* testType_organisms table */
        Schema::dropIfExists('testtype_organisms');
        /* Organism_Drugs table */
        Schema::dropIfExists('organism_drugs');
        /* Organisms table */
        Schema::dropIfExists('organisms');
        /* Drugs table */
        Schema::dropIfExists('drugs');
    }
}
