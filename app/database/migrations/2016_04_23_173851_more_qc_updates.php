<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MoreQcUpdates extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('lots', function(Blueprint $table)
		{
			$table->dropForeign('lots_instrument_id_foreign');
			$table->dropColumn('instrument_id');
		});
		Schema::table('control_tests', function(Blueprint $table)
		{
			$table->dropForeign('control_tests_entered_by_foreign');
			$table->dropColumn('entered_by');

			$table->integer('lot_id')->unsigned()->default(1)->after('control_id');
			$table->foreign('lot_id')->references('id')->on('lots');

			$table->string('performed_by', 100)->nullable()->after('lot_id');
			
			$table->integer('user_id')->unsigned()->default(1)->after('lot_id');
			$table->foreign('user_id')->references('id')->on('users');
		});
		Schema::table('control_results', function(Blueprint $table)
		{
			$table->integer('user_id')->unsigned()->default(1)->after('control_test_id');
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
		//
	}
}
