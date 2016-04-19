<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequireVerificationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('require_verifications', function(Blueprint $table)
		{
			// The need for verification to send test results
			$table->increments('id')->unsigned();
			$table->tinyInteger('verification_required')->default(0);
			$table->time('verification_required_from')->default('00:00:00');
			$table->time('verification_required_to')->default('00:00:00');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('require_verifications');
	}

}
