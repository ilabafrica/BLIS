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
		// Truncate tables
		DB::statement('SET FOREIGN_KEY_CHECKS = 0');
		DB::table('control_results')->truncate();
		DB::table('control_tests')->truncate();
		DB::table('control_measure_ranges')->truncate();
		DB::table('control_measures')->truncate();
		DB::table('controls')->truncate();
		DB::table('lots')->truncate();
		DB::statement('SET FOREIGN_KEY_CHECKS = 1');
		Schema::table('controls', function(Blueprint $table)
		{
			$table->dropForeign('controls_lot_id_foreign');
			$table->dropColumn('lot_id');
		});
		Schema::table('lots', function(Blueprint $table)
		{
			$table->dropForeign('lots_instrument_id_foreign');
			$table->dropColumn('instrument_id');
		});
		Schema::table('control_tests', function(Blueprint $table)
		{
			$table->dropForeign('control_tests_entered_by_foreign');
			$table->dropColumn('entered_by');

			$table->integer('lot_id')->unsigned()->after('control_id');
			$table->foreign('lot_id')->references('id')->on('lots');

			$table->string('performed_by', 100)->after('lot_id');
			
			$table->integer('user_id')->unsigned()->after('lot_id');
			$table->foreign('user_id')->references('id')->on('users');
		});
		Schema::table('control_results', function(Blueprint $table)
		{
			$table->integer('user_id')->unsigned()->after('control_test_id');
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
