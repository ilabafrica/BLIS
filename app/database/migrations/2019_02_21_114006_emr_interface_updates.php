<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EmrInterfaceUpdates extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// for alphanumerics
		Schema::create('emr_result_aliases', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('emr_test_type_alias_id')->unsigned();
			$table->integer('measure_range_id')->unsigned()->nullable();
			$table->string('emr_alias');
			$table->unique(['measure_range_id', 'emr_alias']);
		});

		Schema::table('third_party_access', function (Blueprint $table) {
			$table->string('grant_type')->nullable();
			$table->string('client_name')->nullable();
			$table->string('client_id')->nullable();
			$table->string('client_secret')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
	}

}
