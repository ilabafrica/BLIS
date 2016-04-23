<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ControlsFkey extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
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
			$table->integer('lot_id')->unsigned();
			$table->foreign('lot_id')->references('id')->on('lots');
		});
		Schema::table('lots', function(Blueprint $table)
		{
			$table->date('expiry')->after('instrument_id')->default('00:00:00');;
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		/*Schema::table('controls', function(Blueprint $table)
		{
			$table->dropForeign('controls_instrument_id_foreign');
			$table->dropColumn('instrument_id');
		});*/
	}
}
