<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpecimenTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('specimens', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('specimen_type_id');
			$table->timestamp('time_accepted');
			$table->tinyInteger('specimen_status_id');
			$table->tinyInteger('created_by');
			$table->smallInteger('referred_from');
			$table->smallInteger('referred_to');
			$table->smallInteger('rejection_reason_id');
			$table->timestamp('time_rejected')->nullable();
			$table->tinyInteger('test_phase_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('specimens');
	}

}
